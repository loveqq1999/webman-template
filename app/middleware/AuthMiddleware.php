<?php

namespace app\middleware;

use Exception;
use GatewayWorker\Lib\Gateway;
use Shopwwi\WebmanAuth\Facade\Auth;
use Shopwwi\WebmanAuth\Facade\JWT;
use support\Request;
use support\Response;
use Webman\MiddlewareInterface;

class AuthMiddleware implements MiddlewareInterface
{

    /**
     * @param Request|\Webman\Http\Request $request
     * @param callable $handler
     * @return Response
     * @throws Exception
     */
    public function process(Request|\Webman\Http\Request $request, callable $handler) : Response
    {

        try {
            $token = JWT::verify();

            if($token->exp <= time() || $token->iss !== config('plugin.shopwwi.auth.app.jwt.iss') || $token->iat >= time()) {
                throw new Exception();
            }

            if($token->guard !== 'user') {
                throw new Exception();
            }

            if($token->extend->ip !== $request->getRealIp()) {
                throw new Exception();
            }
        } catch (Exception) {
            throw new Exception(trans('login_invalid', [], 'auth'), -1);
        }

        $authUser = Auth::user();

        if($authUser->status === 0) {
            throw new Exception(trans('wait_for_review', [], 'auth'), -1);
        }
        if($authUser->status === 2) {
            throw new Exception(trans('account_disabled', [], 'auth'), -1);
        }

        // 修改websocket注册地址
        Gateway::$registerAddress = config('plugin.webman.gateway-worker.process.worker.constructor.config.registerAddress');

        return $handler($request);

    }

}