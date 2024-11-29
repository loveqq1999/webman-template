<?php

namespace app\exception;

use Exception;
use support\Log;
use support\Request;
use support\Response;
use Throwable;
use Webman\Exception\ExceptionHandlerInterface;

class Handler implements ExceptionHandlerInterface
{


    /**
     * 记录日志
     * @param Throwable $exception
     * @return true
     */
    public function report(Throwable $exception): true
    {

        Log::channel('error')->error('错误信息: ', [
            'code' => $exception->getCode(),
            'message' => $exception->getMessage(),
            'file' => $exception->getFile(),
            'line' => $exception->getLine(),
        ]);

        return true;

    }


    /**
     * 渲染返回
     * @param Request $request
     * @param Throwable $exception
     * @return Response
     * @throws Exception
     */
    public function render(Request|\Webman\Http\Request $request, Throwable $exception): Response
    {

        // 0成功 1全局通用错误码 -1授权失效
        $code = $exception->getCode() ? (is_int($exception->getCode()) ? $exception->getCode() : 1) : 1;

        return jsonRe([], $code, $exception->getMessage());

    }

}