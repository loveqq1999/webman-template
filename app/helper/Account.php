<?php

namespace app\helper;

use App\ATrait\Single;
use app\model\User;
use Illuminate\Support\Arr;

class Account
{

    use Single;


    /**
     * 生成唯一账号
     *
     * @param int $length
     * @return string
     */
    public function GenerateAccount(int $length = 12): string
    {

        $account = generateRandomStr(12);

        $accountExist = User::query()->where('account', $account)->exists();
        if($accountExist) {
            $account = $this->GenerateAccount($length);
        }

        return $account;

    }


    /**
     * 生成唯一邀请码
     *
     * @param int $length
     * @return string
     */
    public function GenerateReferralCode(int $length = 10): string
    {

        $code = generateRandomStr($length);

        $codeExist = User::query()->where('referral_code', $code)->exists();
        if($codeExist) {
            $code = $this->GenerateReferralCode($length);
        }

        return $code;

    }

}