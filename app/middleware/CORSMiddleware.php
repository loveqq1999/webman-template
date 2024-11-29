<?php

namespace app\middleware;

use support\Request;
use support\Response;
use Webman\MiddlewareInterface;

class CORSMiddleware implements MiddlewareInterface
{

    public function process(Request|\Webman\Http\Request $request, callable $handler) : Response
    {
        // 如果是options请求则返回一个空响应，否则继续向洋葱芯穿越，并得到一个响应
        $response = $request->method() == 'OPTIONS' ? response('') : $handler($request);

        // 给响应添加跨域相关的http头
        $response->withHeaders([
            'Access-Control-Allow-Origin' => getenv('REQUEST_URL'),
            'Access-Control-Allow-Methods' => ['POST'],
            'Access-Control-Allow-Headers' => [
                'AppId',
                'AppKey',
                'Authorization',
                'Signature',
                'NonceStr',
                'Timestamp',
                'Locale',
                'Accept',
                'User-Agent',
                'Referer',
                'Dnt',
                'Content-Type',
            ],
        ]);

        return $response;
    }

}