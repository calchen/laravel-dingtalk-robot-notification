<h1 align="center"> laravel-dingtalk-robot-notification </h1>

<p align="center"> 阿里云消息服务（MNS） Laravel/Lumen 扩 扩展包 </p>

<p align="center">  
    <a href="https://github.styleci.io/repos/205573394">
        <img alt="Style CI" src="https://github.styleci.io/repos/166196221/shield?style=flat">
    </a>
    <a href="https://travis-ci.com/calchen/laravel-dingtalk-robot-notification">
        <img alt="Travis CI" src="https://img.shields.io/travis/com/calchen/laravel-dingtalk-robot-notification.svg">
    </a>
    <a href='https://coveralls.io/github/calchen/laravel-dingtalk-robot-notification?branch=master'>
        <img alt='Coverage Status' src='https://coveralls.io/repos/github/calchen/laravel-dingtalk-robot-notification/badge.svg?branch=master'/>
    </a>
    <a href="https://packagist.org/packages/calchen/laravel-dingtalk-robot-notification">
        <img alt="Latest Stable Version" src="https://img.shields.io/packagist/v/calchen/laravel-dingtalk-robot-notification.svg">
    </a>
    <a href="https://packagist.org/packages/calchen/laravel-dingtalk-robot-notification">
        <img alt="Total Downloads" src="https://img.shields.io/packagist/dt/calchen/laravel-dingtalk-robot-notification.svg">
    </a>
    <a href="https://github.com/calchen/laravel-dingtalk-robot-notification/blob/master/LICENSE">
        <img alt="License" src="https://img.shields.io/github/license/calchen/laravel-dingtalk-robot-notification.svg">
    </a>
</p>

> [English](https://github.com/calchen/laravel-dingtalk-robot-notification/blob/master/README_en.md)

这是一个[钉钉群机器人](https://ding-doc.dingtalk.com/doc#/serverapi2/qf2nxq)的 Laravel/Lumen 消息通知（Notification）扩展包 

## 安装

Laravel/Lumen 5.5 ~ 6.x

```shell
$ composer require calchen/laravel-dingtalk-robot-notification:^2.0
```

### Laravel

Laravel 5.5+ 已经实现了扩展包发现机制，您不需要进行额外的加载操作

### Lumen

Lumen 并未移植扩展包自动发现机制，所以需要手动加载扩展包并复制配置文件。

打开配置文件 `bootstrap/app.php` 并在大约 81 行左右添加如下内容：
```php
$app->register(Calchen\LaravelDingtalkRobot\DingtalkRobotNoticeServiceProvider::class);
```

将文件系统配置文件从 `vendor/calchen/laravel-dingtalk-robot-notification/config/dingtalk_robot.php` 复制到 `config/dingtalk_robot.php`

## 配置

打开配置文件 `config/dingtalk_robot.php` 并按照如下格式添加或修改配置：
```php
'robotName' => [
    'access_token' => 'xxxx',
    'timeout' => 2.0,
    'security_type' => 'signature',
    'security_values' => 'SECxxxx',
],
```
请注意，如果需要配置多个机器人，请重复以上操作，并为不同机器人给予不同的 robotName

### 配置说明
| 配置项                	| 必须 	| 说明                                 	| 备注                  	|
|-------------------	|------	|--------------------------------------	|-----------------------	|
| http_client_name      | 否   	| 驱动名称                             	| 默认值：null，不可修改   	|

### HTTP 客户端注入

为了方便在某些情况下需要统一管理扩展使用的 HTTP 客户端，提供了 `http_client_name` 配置项，以实现从 Laravel 容器中获取已经注入的 Guzzle 实例 

## 开源协议

[MIT](http://opensource.org/licenses/MIT)
