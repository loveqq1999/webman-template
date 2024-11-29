<?php

namespace app\helper;

use App\ATrait\Single;
use support\Request;

class Pagination
{

    use Single;


    /**
     * 获取分页信息
     *
     * @param Request $request
     * @param int $defaultPageSize
     * @return array
     */
    public function Get(Request $request, int $defaultPageSize = 10): array
    {

        $noPage = $request->input('no_page') ?? 1;
        $pageSize = $request->input('page_size') ?? $defaultPageSize;

        return [
            'noPage' => $noPage,
            'pageSize' => $pageSize,
        ];

    }


    /**
     * 设置分页信息
     *
     * @param $count
     * @param $noPage
     * @param $pageSize
     * @return array
     */
    public function Set($count, $noPage, $pageSize): array
    {

        return [
            'no_page' => $noPage,
            'page_size' => $pageSize,
            'total_page' => ceil($count / $pageSize),
            'total_size' => $count,
        ];

    }

}