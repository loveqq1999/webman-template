<?php
/**
 * This file is part of webman.
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the MIT-LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @author    walkor<walkor@workerman.net>
 * @copyright walkor<walkor@workerman.net>
 * @link      http://www.workerman.net/
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 */

return [
    // 默认数据库
    'default' => getenv('DATABASE_CONNECTION'),

    // 各种数据库配置
    'connections' => [
        'mysql' => [
            'driver'      => 'mysql',
            'host'        => getenv('DATABASE_HOST'),
            'port'        => getenv('DATABASE_PORT'),
            'database'    => getenv('DATABASE_NAME'),
            'username'    => getenv('DATABASE_USERNAME'),
            'password'    => getenv('DATABASE_PASSWORD'),
            'unix_socket' => '',
            'charset'     => 'utf8mb4',
            'collation'   => 'utf8mb4_unicode_ci',
            'prefix'      => '',
            'strict'      => false,
            'engine'      => 'InnoDB',
            'options' => [
                PDO::ATTR_TIMEOUT => 3
            ]
        ],
    ],
];
