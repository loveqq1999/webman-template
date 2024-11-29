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
    'listen' => getenv('APP_LISTEN'),
    'transport' => 'tcp',
    'context' => [],
    'name' => getenv('APP_NAME'),
    'count' => cpu_count() * 4,
    'user' => '',
    'group' => '',
    'reusePort' => false,
    'event_loop' => '',
    'stop_timeout' => 2,
    'pid_file' => runtime_path() . '/' . strtolower(getenv('APP_NAME')) . '.pid',
    'status_file' => runtime_path() . '/' . strtolower(getenv('APP_NAME')) . '.status',
    'stdout_file' => runtime_path() . '/logs/' . strtolower(getenv('APP_NAME')) . '_stdout.log',
    'log_file' => runtime_path() . '/logs/' . strtolower(getenv('APP_NAME')) . '.log',
    'max_package_size' => 1024 * 1024 * 1024  // 1GB
];