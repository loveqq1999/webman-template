<?php

namespace app\middleware;

use app\helper\Locale;
use Exception;
use support\Request;
use support\Response;
use Webman\MiddlewareInterface;

class ApiMiddleware implements MiddlewareInterface
{

    /**
     * @param Request|\Webman\Http\Request $request
     * @param callable $handler
     * @return Response
     * @throws Exception
     */
    public function process(Request|\Webman\Http\Request $request, callable $handler) : Response
    {

        $localeRe = Locale::getInstance();
        $localeConfig = $localeRe->Config();

        // 设置语言
        $locale = $request->header('Locale') ?? $localeConfig['default_language'];
        if(!in_array($locale, $localeConfig['language_list'])) {
            $locale = $localeConfig['default_language'];
        }
        locale($locale);

        // 请求方式验证
        if(!in_array($request->method(), ['POST'])) {
            throw new Exception(trans('illegal_request', [], 'public'));
        }

        $request->locale = $locale;

        return $handler($request);

    }

}