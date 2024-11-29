<?php

 return [
     'enable' => true,
     'app_key' => 'Yka7OfUCX1VoZxg2Hu9yWTRj8iNm0lpJMzb6dwDQqeKSAc5vGrLItBPFsnE34h',
     'guard' => [
         'user' => [
             'key' => 'id',
             'field' => ['id','account'], //设置允许写入扩展中的字段
             'num' => 1, //-1为不限制终端数量 0为只支持一个终端在线 大于0为同一账号同终端支持数量 建议设置为1 则同一账号同终端在线1个
             'model'=> app\model\User::class
         ]
     ],
     'jwt' => [
         'redis' => true,
         // 算法类型 ES256、HS256、HS384、HS512、RS256、RS384、RS512
         'algorithms' => 'HS256',
         // access令牌秘钥
         'access_secret_key' => 'LpYUx2S4hUv5Hnajzx6yztPjiQqKsg63QYowokb9FKddIXKXHbB2o3Z7YLhGRK4x',
         // access令牌过期时间，单位秒。默认 2 小时
         'access_exp' => 30 * 60,
         // refresh令牌秘钥
         'refresh_secret_key' => 'Tra5yaHMjEXVTofB6Ut7H37eVOidKw9vVo82elmwKgBWPApRC95Imkulmoh2176F',
         // refresh令牌过期时间，单位秒。默认 7 天
         'refresh_exp' => 24 * 60 * 60,
         // 令牌签发者
         'iss' => getenv('APP_NAME'),
         // 令牌签发时间
         'iat' => time(),

         /**
          * access令牌 RS256 私钥
          * 生成RSA私钥(Linux系统)：openssl genrsa -out access_private_key.key 1024 (2048)
          */
         'access_private_key' => file_get_contents(base_path('resource/app-auth/access-private.key')),
         /**
          * access令牌 RS256 公钥
          * 生成RSA公钥(Linux系统)：openssl rsa -in access_private_key.key -pubout -out access_public_key.key
          */
         'access_public_key' => file_get_contents(base_path('resource/app-auth/access-public.key')),

         /**
          * refresh令牌 RS256 私钥
          * 生成RSA私钥(Linux系统)：openssl genrsa -out refresh_private_key.key 1024 (2048)
          */
         'refresh_private_key' => file_get_contents(base_path('resource/app-auth/refresh-private.key')),
         /**
          * refresh令牌 RS256 公钥
          * 生成RSA公钥(Linux系统)：openssl rsa -in refresh_private_key.key -pubout -out refresh_public_key.key
          */
         'refresh_public_key' => file_get_contents(base_path('resource/app-auth/refresh-public.key')),
     ],
 ];
