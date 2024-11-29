<?php

return [
    'enable' => true,
    'mailer' => [
        'scheme'   => getenv('MAIL_MAILER'),// "smtps": using TLS, "smtp": without using TLS.
        'host'     => getenv('MAIL_HOST'), // 服务器地址
        'username' => getenv('MAIL_USERNAME'), //用户名
        'password' => getenv('MAIL_PASSWORD'), // 密码
        'port'     => (int)getenv('MAIL_PORT'), // SMTP服务器端口号,一般为25
        'options'  => [],
    ],
    'from'   => [
        'address' => getenv('MAIL_FROM_ADDRESS'),
        'name'    => getenv('MAIL_FROM_NAME'),
    ],
];
