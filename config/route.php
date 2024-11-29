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

use app\controller\ChatMessageController;
use Webman\Route;


Route::group('/8a5da52ed126447d359e70c05721a8aa', function () {  // /api
    // 验证码
    Route::group('/captcha', function () {
        Route::any('/send', [\app\controller\CaptchaController::class, 'Send']);
    });

    // 认证
    Route::group('/auth', function () {
        Route::any('/register', [\app\controller\AuthController::class, 'Register']);
        Route::any('/login', [\app\controller\AuthController::class, 'Login']);
        Route::any('/reset-password', [\app\controller\AuthController::class, 'ResetPassword']);
        Route::any('/refresh', [\app\controller\AuthController::class, 'RefreshToken']);
    });

    // 登录后可请求
    Route::group('', function () {
        // 上传
        Route::group('/upload', function () {
            Route::any('/file', [\app\controller\UploadController::class, 'File'])->setParams(['notSign' => true]);
        });

        // 认证
        Route::group('/auth', function () {
            Route::any('/logout', [\app\controller\AuthController::class, 'Logout']);
        });

        // 用户
        Route::group('/user', function () {
            Route::any('/list', [\app\controller\UserController::class, 'List']);
            Route::any('/space', [\app\controller\UserController::class, 'Space']);
            Route::any('/detail', [\app\controller\UserController::class, 'Detail']);
            Route::any('/find-list', [\app\controller\UserController::class, 'FindList']);
        });

        // 动态
        Route::group('/dynamic', function () {
            Route::any('/publish', [\app\controller\DynamicController::class, 'Publish']);
            Route::any('/list', [\app\controller\DynamicController::class, 'List']);
            Route::any('/space-list', [\app\controller\DynamicController::class, 'SpaceList']);
            Route::any('/delete', [\app\controller\DynamicController::class, 'Delete']);
        });

        // 充值
        Route::group('/recharge', function () {
            Route::any('/config', [\app\controller\RechargeController::class, 'Config']);
            Route::any('/order', [\app\controller\RechargeController::class, 'Order']);
        });

        // 升级
        Route::group('/upgrade', function () {
            Route::any('/config', [\app\controller\UpgradeController::class, 'Config']);
            Route::any('/order', [\app\controller\UpgradeController::class, 'Order']);
        });

        // 礼物
        Route::group('/gift', function () {
            Route::any('/type', [\app\controller\GiftController::class, 'TypeList']);
            Route::any('/list', [\app\controller\GiftController::class, 'List']);
            Route::any('/detail', [\app\controller\GiftController::class, 'Detail']);
            Route::any('/give', [\app\controller\GiftController::class, 'Give']);
            Route::any('/box-list', [\app\controller\GiftController::class, 'BoxList']);
            Route::any('/give-list', [\app\controller\GiftController::class, 'GiveList']);
        });

        // 相册
        Route::group('/album', function () {
            Route::any('/add', [\app\controller\AlbumController::class, 'Add']);
            Route::any('/space-list', [\app\controller\AlbumController::class, 'SpaceList']);
            Route::any('/detail', [\app\controller\AlbumController::class, 'Detail']);
            Route::any('/like', [\app\controller\AlbumController::class, 'Like']);
            Route::any('/delete', [\app\controller\AlbumController::class, 'Delete']);
        });

        // 照片
        Route::group('/photo', function () {
            Route::any('/add', [\app\controller\PhotoController::class, 'Add']);
            Route::any('/delete', [\app\controller\PhotoController::class, 'Delete']);
        });

        // 账号
        Route::group('/account', function () {
            Route::any('/modify-avatar', [\app\controller\AccountController::class, 'ModifyAvatar']);
            Route::any('/modify-email', [\app\controller\AccountController::class, 'ModifyEmail']);
            Route::any('/modify-password', [\app\controller\AccountController::class, 'ModifyPassword']);
            Route::any('/modify-info', [\app\controller\AccountController::class, 'ModifyInfo']);
        });

        // 聊天室
        Route::group('/chat-room', function () {
            Route::any('/add-alone', [\app\controller\ChatRoomController::class, 'AddAlone']);
            Route::any('/contact-customer-service', [\app\controller\ChatRoomController::class, 'ContactCustomerService']);
            Route::any('/list', [\app\controller\ChatRoomController::class, 'List']);
            Route::any('/detail', [\app\controller\ChatRoomController::class, 'Detail']);
            Route::any('/hide', [\app\controller\ChatRoomController::class, 'Hide']);
        });

        // 聊天消息
        Route::group('/chat-message', function () {
            Route::any('/list', [ChatMessageController::class, 'List']);
        });
    })->middleware([
        \app\middleware\AuthMiddleware::class
    ]);
});


Route::disableDefaultRoute();