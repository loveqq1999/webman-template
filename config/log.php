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
    'default' => [
        'handlers' => [
            [
                'class' => Monolog\Handler\RotatingFileHandler::class,
                'constructor' => [
                    runtime_path() . '/logs/run/' . strtolower(getenv('APP_NAME')) . '.log',
                    getenv('MAX_LOG_COUNT'), //$maxFiles
                    Monolog\Logger::DEBUG,
                ],
                'formatter' => [
                    'class' => Monolog\Formatter\LineFormatter::class,
                    'constructor' => [null, 'Y-m-d H:i:s', true],
                ],
            ]
        ],
    ],
    'error' => [
        // 处理默认通道的handler，可以设置多个
        'handlers' => [
            [
                // handler类的名字
                'class' => Monolog\Handler\RotatingFileHandler::class,
                // handler类的构造函数参数
                'constructor' => [
                    runtime_path() . '/logs/error/' . strtolower(getenv('APP_NAME')) . '.log',
                    getenv('MAX_LOG_COUNT'), //$maxFiles
                    Monolog\Logger::DEBUG,
                ],
                // 格式相关
                'formatter' => [
                    // 格式化处理类的名字
                    'class' => Monolog\Formatter\LineFormatter::class,
                    // 格式化处理类的构造函数参数
                    'constructor' => [ null, 'Y-m-d H:i:s', true],
                ],
            ]
        ],
    ],
    'pay' => [
        // 处理默认通道的handler，可以设置多个
        'handlers' => [
            [
                // handler类的名字
                'class' => Monolog\Handler\RotatingFileHandler::class,
                // handler类的构造函数参数
                'constructor' => [
                    runtime_path() . '/logs/pay/' . strtolower(getenv('APP_NAME')) . '.log',
                    getenv('MAX_LOG_COUNT'), //$maxFiles
                    Monolog\Logger::DEBUG,
                ],
                // 格式相关
                'formatter' => [
                    // 格式化处理类的名字
                    'class' => Monolog\Formatter\LineFormatter::class,
                    // 格式化处理类的构造函数参数
                    'constructor' => [ null, 'Y-m-d H:i:s', true],
                ],
            ]
        ],
    ],
];