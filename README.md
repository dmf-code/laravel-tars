# Laravel Tars Driver

## 中文版

### 描述
Tars driver for laravel.

Laravel集成微服务治理框架Tars

### 环境依赖
1. Lumen5.x
2. Tars-PHP

### 安装

1. 创建项目

   创建Tars项目目录结构(scripts、src、tars)，Lumen项目放在src目录下

2. 安装Laravel Tars包

   更新Composer依赖

   ```shell
   composer require "luoxiaojun1992/laravel-tars:*"
   ```

   或添加 requirement 到 composer.json

   ```json
   {
     "require": {
       "luoxiaojun1992/laravel-tars": "*"
     }
   }
   ```

   添加ServiceProvider，编辑src/bootstrap/app.php
   
   ```php
   $app->register(\Lxj\Laravel\Tars\ServiceProvider::class);
   ```
   
   初始化Laravel Tars
   
   ```
   php artisan vendor:publish
   ```
3. 如果需要自动注册到网关(目前仅支持Kong)，修改配置文件src/config/tars.php

   ```php
   'registries' => [
        [
            'type' => 'kong',
            'url' => 'http://kong:8001/upstreams/tars_mysql8/targets', //根据实际情况填写
        ]
   ]
   ```
4. 如果需要使用配置中心(TarsConfig)，修改配置文件src/config/tars.php，服务启动时会自动拉取配置

   ```php
   'tarsregistry' => 'tars.tarsregistry.QueryObj@tcp -h 172.17.0.3 -p 17890' //根据实际情况填写，TarsConfig配置文件名称固定为'tars'
   ```
   
5. 编写业务逻辑代码，路由前缀必须为/Laravel/route

6. 搭建Tars-PHP开发环境，请参考[TARS-PHP-HTTP服务端与客户端开发](https://tangramor.gitlab.io/tars-docker-guide/3.TARS-PHP-HTTP%E6%9C%8D%E5%8A%A1%E7%AB%AF%E4%B8%8E%E5%AE%A2%E6%88%B7%E7%AB%AF%E5%BC%80%E5%8F%91/)

7. 在Tars-PHP开发环境下打包项目(在src目录下执行```php artisan tars:deploy```)

8. 在Tars管理后台发布项目(请参考[TARS-PHP-TCP服务端与客户端开发](https://tangramor.gitlab.io/tars-docker-guide/2.TARS-PHP-TCP%E6%9C%8D%E5%8A%A1%E7%AB%AF%E4%B8%8E%E5%AE%A2%E6%88%B7%E7%AB%AF%E5%BC%80%E5%8F%91/))，测试```curl 'http://{ip}:{port}/Laravel/route/{api_route}'```

### 使用示例
请参考 [https://github.com/luoxiaojun1992/laravel-tars-demo](https://github.com/luoxiaojun1992/laravel-tars-demo)
