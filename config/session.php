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

use Webman\Session\FileSessionHandler;
use Webman\Session\RedisSessionHandler;
use Webman\Session\RedisClusterSessionHandler;

return [

    'type' => getenv('SESSION_TYPE'), // file or redis

    'handler' => FileSessionHandler::class,

    'config' => [
        'file' => [
            'save_path' => runtime_path() . '/sessions',
        ],
        'redis' => [
            'host' => getenv('REDIS_HOST'),
            'port' => getenv('REDIS_PORT'),
            'auth' => getenv('REDIS_PASSWORD'),
            'timeout' => 2,
            'database' => getenv('SESSION_REDIS_DATABASE'),
            'prefix' => config('redis.prefix') . 'session:',
        ],
    ],

    'session_name' => strtoupper(getenv('APP_NAME')) . '_SID',
    
    'auto_update_timestamp' => false,

    'lifetime' => 7 * 24 * 60 * 60,

    'cookie_lifetime' => 365 * 24 * 60 * 60,

    'cookie_path' => '/',

    'domain' => '',
    
    'http_only' => true,

    'secure' => false,
    
    'same_site' => '',

    'gc_probability' => [1, 1000],

];