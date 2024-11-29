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

namespace support;

/**
 * Class Request
 * @package support
 */
class Request extends \Webman\Http\Request
{

    /**
     * 设置post参数
     * @param array $data
     * @return void
     */
    public function setPostData(array $data): void
    {
        if(empty($data)){ return; }
        $this->post();

        foreach ($data as $key => $value) {
            $this->_data['post'][$key] = $value;
        }
    }

}