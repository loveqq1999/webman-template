<?php

use Random\RandomException;
use support\Request;
use support\Response;
use WebmanTech\Polyfill\LaravelRequest;
use Wengg\WebmanApiSign\Encryption\RSA;


/**
 * 请求参数验证
 *
 * @param Request $request
 * @param array $rules
 * @param array $messages
 * @return void
 * @throws Exception
 */
function requestValidator(Request $request, array $rules, array $messages = []): void
{

    $validator = validator(LaravelRequest::wrapper($request)->all(), $rules, $messages);
    if ($validator->fails()) {
        throw new Exception($validator->errors()->first());
    }

}


/**
 * json返回格式规范
 *
 * @param array $data
 * @param int $errCode
 * @param string|null $message
 * @return Response
 * @throws RandomException
 * @throws Exception
 */
function jsonRe(array $data = [], int $errCode = 0, string|null $message = null): Response
{

    $openCrypt = getenv('RESPONSE_CRYPT');  // 是否开启响应加密

    $responseData = $data;

    // 响应加密
    if($openCrypt) {
        $key = generateRandomKey(16);
        $responseData = aesCrypt($key, json_encode($responseData));
    }

    $resJson = [
        'err_code' => $errCode,
        'message' => $message ?? trans('success_request', [], 'public'),
    ];
    if($errCode === 0) {  // 0表示成功
        if($openCrypt) {
            $resJson['key'] = rsaCrypt($key);  // 响应加密密钥
        }
        $resJson['data'] = $responseData;
    }
    $resJson['timestamp'] = time();

    return json($resJson);

}


/**
 * 生成随机Key
 *
 * @param int $length
 * @return string
 * @throws RandomException
 */
function generateRandomKey(int $length = 32): string
{

    return bin2hex(random_bytes($length));

}


/**
 * 生成随机字符串
 */
function generateRandomStr(int $length = 10): string
{

    $str = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    $len = strlen($str) - 1;
    $randomStr = '';

    for ($i = 0; $i < $length; $i++) {
        $num = mt_rand(0, $len);
        $randomStr .= $str[$num];
    }

    return $randomStr;

}


/**
 * RSA加解密
 *
 * @param string $data // 操作数据
 * @param string $type  // 操作类型 encode(加密) decode(解密)
 * @return string
 * @throws Exception
 */
function rsaCrypt(string $data, string $type = 'encode'): string
{

    $publicKey = file_get_contents(base_path('resource/rsa-crypt/public.key'));
    $privateKey = file_get_contents(base_path('resource/rsa-crypt/private.key'));

    try {
        $rsa = new RSA();

        if($type === 'decode') {
            return $rsa->rsa_decode($data, $privateKey);
        } else {
            return $rsa->rsa_encode($data, $publicKey);
        }
    } catch (Exception $e) {
        throw new Exception($e->getMessage());
    }

}


/**
 * AES加解密
 *
 * @param string $key  // 密钥
 * @param string $data  // 操作数据
 * @param string $type  // 操作类型 encode(加密) decode(解密)
 * @return string
 */
function aesCrypt(string $key, string $data, string $type = 'encode'): string
{

    $cipherAlgo = 'aes-128-cbc';

    // 获取加密算法要求的初始化向量的长度
    $ivLen = openssl_cipher_iv_length($cipherAlgo);

    if($type === 'decode') {  // 解密
        $ciphertext = base64_decode($data);
        $iv = substr($ciphertext, 0, $ivLen);
        $ciphertext = substr($ciphertext, $ivLen);

        return openssl_decrypt($ciphertext, $cipherAlgo, hex2bin($key), OPENSSL_RAW_DATA, $iv);
    } else {  // 加密
        // 生成对应长度的初始化向量. aes-128模式下iv长度是16个字节, 也可以自由指定.
        $iv = openssl_random_pseudo_bytes($ivLen);
        // 加密数据
        $ciphertext = openssl_encrypt($data, $cipherAlgo, hex2bin($key), OPENSSL_RAW_DATA, $iv);

        return base64_encode($iv . $ciphertext);
    }

}


/**
 * 根据生日获取年龄
 *
 * @param $date
 * @return int
 */
function getAgeByBirth($date): int
{

    if(empty($date)) return 0;

    if($date !== date('Y-m-d', strtotime($date))) return 0;

    $birthYear = explode('-', $date)[0];
    $birthMonth = explode('-', $date)[1];
    $birthDay = explode('-', $date)[2];

    $currentYear = date('Y', time());
    $currentMonth = date('m', time());
    $currentDay = date('d', time());
    if($birthYear >= $currentYear){
        return 0;
    }
    $age = (int)$currentYear - $birthYear - 1;
    if($currentMonth > $birthMonth){
        return $age + 1;
    } else if($currentMonth == $birthMonth && $currentDay >= $birthDay){
        return $age + 1;
    } else{
        return $age;
    }

}


/**
 * 获取两个日期间隔天数
 *
 * @param $date1
 * @param $date2
 * @return float
 */
function getDateDiffDay($date1, $date2): float
{

    $timestamp1 = strtotime($date1);
    $timestamp2 = strtotime($date2);

    $interval = abs($timestamp2 - $timestamp1);
    return floor($interval / (60 * 60 * 24));

}


/**
 * 时间语义化
 *
 * @param $time
 * @return string
 */
function timeFormat($time): string
{

    $ctime = time();
    $t = $ctime - $time; //时间差 （秒）
    if ($t < 0) {
        return date("Y-m-d", $time);
    }

    $y = intval(date("Y", $ctime) - date("Y", $time)); // 是否跨年
    if ($t == 0) {
        $text = trans('just_now', [], 'public');
    } elseif ($t < 60) {//一分钟内
        $text = trans('n_seconds_ago', ['%second%' => $t], 'public');
    } elseif ($t < 3600) {//一小时内
        $text = trans('n_minutes_ago', ['%minute%' => floor($t / 60)], 'public');
    } elseif ($t < 86400) {//一天内
        $text = trans('n_hours_ago', ['%hour%' => floor($t / 3600)], 'public');
    } elseif ($t < 2592000) {//30天内
        if ($time > strtotime(date('Ymd', strtotime('-1 day')))) {
            $text = trans('yesterday', [], 'public');
        } elseif ($time > strtotime(date('Ymd', strtotime('-2 days')))) {
            $text = trans('1_day_ago', [], 'public');
        } else {
            $text = trans('n_days_ago', ['%day%' => floor($t / 86400)], 'public');
        }
    } elseif ($t < 31536000 && $y == 0) {//一年内 不跨年
        $m = date("m", $ctime) - date("m", $time) - 1;
        if ($m == 0) {
            $text = trans('n_days_ago', ['%day%' => floor($t / 86400)], 'public');
        } else {
            $text = trans('n_months_ago', ['%month%' => $m], 'public');
        }
    } elseif ($t < 31536000 && $y > 0) {//一年内 跨年
        $text = trans('n_months_ago', ['%month%' => (12 - (int)date("m", $time) + (int)date("m", $ctime))], 'public');
    } else {
        $text = trans('n_years_ago', ['%year%' => (date("Y", $ctime) - date("Y", $time))], 'public');
    }

    return $text;

}


/**
 * 多维数组遍历取特定项
 *
 * @param $array
 * @param $field
 * @param $value
 * @return array
 */
function filterArrayByFieldValue($array, $field, $value): array
{

    $filteredItems = array_filter($array, function ($item) use ($field, $value) {
        return isset($item[$field]) && $item[$field] == $value;
    });

    return array_values($filteredItems); // 重置数组索引

}
