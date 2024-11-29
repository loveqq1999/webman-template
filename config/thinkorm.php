<?php

return [
    'default' => getenv('DATABASE_CONNECTION'),
    'connections' => [
        'mysql' => [
            // 数据库类型
            'type' => 'mysql',
            // 服务器地址
            'hostname' => getenv('DATABASE_HOST'),
            // 数据库名
            'database' => getenv('DATABASE_NAME'),
            // 数据库用户名
            'username' => getenv('DATABASE_USERNAME',),
            // 数据库密码
            'password' => getenv('DATABASE_PASSWORD'),
            // 数据库连接端口
            'hostport' => getenv('DATABASE_PORT'),
            // 数据库连接参数
            'params' => [
                // 连接超时3秒
                PDO::ATTR_TIMEOUT => 3,
            ],
            // 数据库编码默认采用utf8
            'charset' => 'utf8mb4',
            // 数据库表前缀
            'prefix' => '',
            // 断线重连
            'break_reconnect' => true,
            // 自定义分页类
            'bootstrap' =>  ''
        ],
    ],
];
