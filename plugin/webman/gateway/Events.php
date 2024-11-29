<?php

namespace plugin\webman\gateway;


use Exception;
use GatewayWorker\Lib\Gateway;
use Illuminate\Contracts\Database\Eloquent\Builder;
use support\Redis;

class Events
{

    protected static string $keyPrefix = 'websocket:client:';


    /**
     * 进程启动
     *
     * @param $worker
     * @return void
     */
    public static function onWorkerStart($worker)
    {
//        每个生命周期触发一次
//        {
//            "Webman\\GatewayWorker\\BusinessWorker": {
//            "id": 0,
//            "name": "ChatBusinessWorker",
//            "count": 1,
//            "user": "",
//            "group": "",
//            "reloadable": true,
//            "reusePort": false,
//            "onWorkerStart": [
//                null,
//                "onWorkerStart"
//            ],
//            "onConnect": null,
//            "onMessage": null,
//            "onClose": null,
//            "onError": null,
//            "onBufferFull": null,
//            "onBufferDrain": null,
//            "onWorkerStop": [
//                 null,
//                 "onWorkerStop"
//            ],
//            "onWorkerReload": [
//                null,
//                "onWorkerReload"
//            ],
//            "onWorkerExit": null,
//            "transport": "tcp",
//            "connections": [],
//            "protocol": null,
//            "stopping": false,
//            "gatewayConnections": [],
//            "registerAddress": [
//                "127.0.0.1:5200"
//            ],
//            "eventHandler": "plugin\\webman\\gateway\\Events",
//            "secretKey": "",
//            "sendToGatewayBufferSize": 10240000
//          }
//        }
    }


    /**
     * 客户端连接上gateway进程
     *
     * @param $client_id
     * @return void
     */
    public static function onConnect($client_id)
    {
        //
    }


    /**
     * 客户端连接上gateway
     *
     * @param $client_id
     * @param $data
     * @return void
     * @throws Exception
     */
    public static function onWebSocketConnect($client_id, $data): void
    {

        Redis::del(config('redis.prefix') . self::$keyPrefix . $client_id);

        // 链接认证
        if(empty($data['server']['HTTP_ORIGIN']) || $data['server']['HTTP_ORIGIN'] !== getenv('REQUEST_URL')) {
            Gateway::closeCurrentClient();
        }
        $auth = $data['get']['sign'] ?? null;
        if(empty($auth)) {
            Gateway::closeCurrentClient();
        }
        try {
            $authInfo = json_decode(base64_decode($auth), true);
        } catch (Exception) {
            Gateway::closeCurrentClient();
        }
        if(empty($authInfo)) {
            Gateway::closeCurrentClient();
        }
        $userVerify = User::query()->where('uid', $authInfo['user'])->where('status', 1)->exists();
        if(!$userVerify) {
            Gateway::closeCurrentClient();
        }

        Redis::setNx(config('redis.prefix') . self::$keyPrefix . $client_id, $authInfo['user']);

        Gateway::bindUid($client_id, $authInfo['user']);

    }


    /**
     * 客户端发送数据
     *
     * @param $client_id
     * @param $message
     * @return void
     * @throws Exception
     */
    public static function onMessage($client_id, $message): void
    {

        $user = Redis::get(config('redis.prefix') . self::$keyPrefix . $client_id);
        if(empty($user)) {
            Gateway::closeCurrentClient();
        }

        $data = json_decode($message, true);

        if(!empty($data)) {
            // 收到消息
        }

    }


    /**
     * 客户端与Gateway进程的连接断开
     *
     * @param $client_id
     * @return void
     * @throws Exception
     */
    public static function onClose($client_id): void
    {

        $userId = Redis::get(config('redis.prefix') . self::$keyPrefix . $client_id);

        Redis::del(config('redis.prefix') . self::$keyPrefix . $client_id);

    }


    /**
     * 进程退出
     *
     * @param $worker
     * @return void
     */
    public function onWorkerStop($worker)
    {
        //
    }

}
