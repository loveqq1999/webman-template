<?php

use Webman\GatewayWorker\Gateway;
use Webman\GatewayWorker\BusinessWorker;
use Webman\GatewayWorker\Register;

$listenPort = 5001;
$startPort = 5100;
$registerPort = 5200;

return [
    'gateway' => [
        'handler'     => Gateway::class,
        'listen'      => 'websocket://0.0.0.0:' . $listenPort,
        'count'       => 2,
        'reloadable'  => false,
        'transport'   => strpos(getenv('WEBSOCKET_URL'), 'wss') ? 'ssl' : 'tcp',
        'context'     => [
            'ssl' => array(
                // 请使用绝对路径
                'local_cert'        => public_path('cert/server.pem'), // 也可以是crt文件
                'local_pk'          => public_path('cert/server.key'),
                'verify_peer'       => false,
                'allow_self_signed' => false, //如果是自签名证书需要开启此选项
            )
        ],
        'constructor' => ['config' => [
            'lanIp'                => '127.0.0.1',
            'startPort'            => $startPort,
            'pingInterval'         => 50,
            'pingNotResponseLimit' => 1,
            'pingData'             => '{"scene":"ping"}',
            'registerAddress'      => '127.0.0.1:' . $registerPort,
            'onConnect'            => function(){},
        ]]
    ],
    'worker' => [
        'handler'     => BusinessWorker::class,
        'count'       => cpu_count() * 2,
        'constructor' => ['config' => [
            'eventHandler'    => plugin\webman\gateway\Events::class,
            'name'            => 'ChatBusinessWorker',
            'registerAddress' => '127.0.0.1:' . $registerPort,
        ]]
    ],
    'register' => [
        'handler'     => Register::class,
        'listen'      => 'text://127.0.0.1:' . $registerPort,
        'count'       => 1, // Must be 1
        'reloadable'  => false,
        'constructor' => []
    ],
];