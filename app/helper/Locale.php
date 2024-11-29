<?php

namespace app\helper;

use App\ATrait\Single;

class Locale
{

    use Single;

    public function Config(): array
    {

        return [
            'language_list' => [  // 顺序与本地化语言解析顺序关联，请勿随意修改
                'zh-cn',
            ],
            'default_language' => 'zh-cn',
            'parse_separator' => ' | ',
        ];

    }

}