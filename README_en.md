<h1 align="center"> laravel-dingtalk-robot-notification </h1>
<p align="center"> Dingtalk Robot for Laravel/Lumen </p>
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

> [中文](https://github.com/calchen/laravel-dingtalk-robot-notification/blob/master/README.md)

This is Laravel/Lumen custom notification channel for [DingTalk group assistant](https://ding-doc.dingtalk.com/doc#/serverapi2/qf2nxq).

## Installing

Composer is recommended for installation:

```shell
$ composer require calchen/laravel-dingtalk-robot-notification:^2.0
```

### Laravel

For Laravel 5.5+ package auto discovery feature will help you loading everything you need. But you still need to publish the configuration file:

```shell
php artisan vendor:publish --provider="Calchen\LaravelDingtalkRobot\DingtalkRobotNoticeServiceProvider"
```

### Lumen

Open your `bootstrap/app.php` and add this line:

```php
$app->register(Calchen\LaravelDingtalkRobot\DingtalkRobotNoticeServiceProvider::class);
```

Copy configuration file from `vendor/calchen/laravel-dingtalk-robot-notification/config/dingtalk_robot.php`  to `config/dingtalk_robot.php`

### Other frameworks

Without considering the loading problem, please use the global function `\dingtalk_robot()` or directly create the \Calchen\LaravelDingtalkRobot\DingtalkRobot instance to send the message.

## Configuration

Open your `config/dingtalk_robot.php` and add these lines:

```php
'robotName' => [
    'access_token' => 'xxxx',
    'timeout' => 2.0,
    'security_types' => [
        'signature',
    ],
    'security_signature' => 'SECxxxx',
],
```

If you need to configure more than one robot, repeat the above and give different `robotName` to different robots

### Details

| key             	| required 	| type    	| remarks                                          	| 备注                                                                                                       	|
|--------------------	|------	|-------------	|-----------------------------------------------	|------------------------------------------------------------------------------------------------------------	|
| http_client_name   	| N   	| string/null 	| Guzzle 实例的名称                             	| 默认值：null，注入在 Laravel 中的 Guzzle 实例的名称，以便替换 HTTP 客户端                                  	|
| robotName          	| Y   	| string      	| 机器人名称                                    	| 这个名称为了区别不同的机器人                                                                               	|
| access_token       	| Y   	| string      	| 创建机器人后 Webhook URL 中 access_token 的值 	|                                                                                                            	|
| timeout            	| N   	| int/float   	| 超时时间                                      	| 默认值：2.0秒，具体见 [Guzzle 文档](http://docs.guzzlephp.org/en/stable/request-options.html#timeout)      	|
| security_types     	| Y   	| array       	| 安全设置                                      	| 旧机器人是不存在该项配置的传 null 或不设置该配置项；新机器人可以组合选择：自定义关键字、加签、IP地址（段） 	|
| security_types.*   	| Y   	| string/null 	| 设置项                                        	| 枚举值：null、keywords、signature、ip                                                                      	|
| security_signature 	| N   	| string      	| 安全模式包含加签时需要的密钥字符串            	| 应当以 SEC 开头                                                                                            	|                                                                                       	|

### 获取 access_token 并设置安全设置

首先在钉钉群选择添加一个群机器人（智能群助手），如果您不知道如何设置请查看 [钉钉文档](https://ding-doc.dingtalk.com/doc#/serverapi2/qf2nxq)，请注意这里需要设置的是"自定义"类型的机器人。

根据您的需要设置机器人名字，并选择安全设置。在完成后您将获得一个 webhook 地址，该地址中 access_token 的值即配置中使用到的 access_token 的值，
请妥善保存该 access_token。选择的安全设置就是配置中 security_types 的值，如果您选择了“加签”的安全设置，您还需要妥善保存密钥，该密钥即配置中 security_signature 的值

### HTTP 客户端注入

为了方便在某些情况下需要统一管理扩展包使用的 HTTP 客户端，提供了 `http_client_name` 配置项，以实现从 Laravel 容器中获取已经注入的 Guzzle 实例。如果您不需要手动管理 HTTP 客户端，您可以不设置该配置项或将该配置项值设置成 null。

## 使用方法

Tips：为了方便快速调试功能，内置了一个使用了  Notifiable Trait 的类：Calchen\LaravelDingtalkRobot\Robot ，以下均以此对象为例，实际开发中请务必根据您项目情况进行对应处理。

首先需要先创建一个 TestDingtalkNotification ，如果是 Laravel 可通过 artisan 命令创建

```shell
php artisan make:notification TestDingtalkNotification
```

如果是 Lumen 那么可能需要您手动创建 app/Notifications 文件夹并创建  TestDingtalkNotification.php 文件

```php
<?php

namespace App\Notifications;

use Calchen\LaravelDingtalkRobot\DingtalkRobotChannel;
use Calchen\LaravelDingtalkRobot\Message\Message;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class TestDingtalkNotification extends Notification
{
    // 注意这里如果不需要异步可不使用 Queueable Trait
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function via($notifiable)
    {
        // 这里的 channel 必须包含 DingtalkRobotChannel 才能正常的发送消息
        return [DingtalkRobotChannel::class];
    }

    /**
     * @param $notifiable
     *
     * @return Message
     */
    public function toDingTalkRobot($notifiable): Message
    {
        /**
         *  $message 根据消息类型的不同由 Calchen\LaravelDingtalkRobot\Message\Message 的各个子类创建
         * 
         * @var Message $message 
         */
        $message = ...;
    
        // 这里可以指定机器人，如果不需要指定则默认使用名称为 default 的机器人
        $message->setRobot($notifiable->getName());

        return $message;
    }
}
```

根据 [Laravel](https://laravel.com/docs/6.x/notifications) 文档发送通知可以使用 Notifiable Trait

```php
use Calchen\LaravelDingtalkRobot\Robot;

(new Robot)->notify(new TestDingtalkNotification());
```

也可以使用 Notification Facade

```php
\Notification::send(new Robot, new TestDingtalkNotification());
```

**重点：**

TestDingtalkNotification 中的 toDingTalkRobot 方法中可使用下面的五种消息类型。

### 文本类型消息

```php
use Calchen\LaravelDingtalkRobot\Message\TextMessage;

public function toDingTalkRobot($notifiable)
{
    $message = new TextMessage('我就是我,  @1825718XXXX 是不一样的烟火');
    
    // 可@某人或某些人，被@的人的手机号应出现在上面的消息体中
    $message->at('1825718XXXX');
    // $message->at(['1825718XXXX', '1825718XXXY']);
    
    // 可@全部人，被@的人的手机号不需要出现在消息体中
    // $message->atAll();
    
    // 这里可以指定机器人，如果不需要指定则默认使用名称为 default 的机器人
    $message->setRobot($notifiable->getName());
       
    return  $message;
}
```

### link 类型消息

```php
use Calchen\LaravelDingtalkRobot\Message\LinkMessage;

public function toDingTalkRobot($notifiable)
{
    $message = new LinkMessage(
        '自定义机器人协议',
        '群机器人是钉钉群的高级扩展功能。群机器人可以将第三方服务的信息聚合到群聊中，实现自动化的信息同步。例如：通过聚合GitHub，GitLab等源码管理服务，实现源码更新同步；通过聚合Trello，JIRA等项目协调服务，实现项目信息同步。不仅如此，群机器人支持Webhook协议的自定义接入，支持更多可能性，例如：你可将运维报警提醒通过自定义机器人聚合到钉钉群。',
        'https://open-doc.dingtalk.com/docs/doc.htm?spm=a219a.7629140.0.0.Rqyvqo&treeId=257&articleId=105735&docType=1'
    );
    
    // 这里可以指定机器人，如果不需要指定则默认使用名称为 default 的机器人
    $message->setRobot($notifiable->getName());
    
    return  $message;
}
```

### markdown 类型消息

```php
use Calchen\LaravelDingtalkRobot\Message\MarkdownMessage;

public function toDingTalkRobot($notifiable)
{
    $message = new MarkdownMessage(
        '杭州天气',
        "#### 杭州天气  \n > 9度，@1825718XXXX 西北风1级，空气良89，相对温度73%\n\n > ![screenshot](http://i01.lw.aliimg.com/media/lALPBbCc1ZhJGIvNAkzNBLA_1200_588.png)\n  > ###### 10点20分发布 [天气](http://www.thinkpage.cn/) "
    );
    
    // 可@某人或某些人，被@的人的手机号应出现在上面的消息体中
    $message->at('1825718XXXX');
    // $message->at(['1825718XXXX', '1825718XXXY']);
    
    // 可@全部人，被@的人的手机号不需要出现在消息体中
    // $message->atAll();
    
    // 这里可以指定机器人，如果不需要指定则默认使用名称为 default 的机器人
    $message->setRobot($notifiable->getName());
    
    return  $message;
}
```

### ActionCard 类型消息

#### 整体跳转类型

```php
use Calchen\LaravelDingtalkRobot\Message\ActionCardMessage;

public function toDingTalkRobot($notifiable)
{
    $message = new ActionCardMessage(
        '乔布斯 20 年前想打造一间苹果咖啡厅，而它正是 Apple Store 的前身',
        "![screenshot](@lADOpwk3K80C0M0FoA) \n #### 乔布斯 20 年前想打造的苹果咖啡厅 \n\n Apple Store 的设计正从原来满满的科技感走向生活化，而其生活化的走向其实可以追溯到 20 年前苹果一个建立咖啡馆的计划"
    );
    $message->setSingle('阅读全文', 'https://www.dingtalk.com/');
    
    // 这里可以指定机器人，如果不需要指定则默认使用名称为 default 的机器人
    $message->setRobot($notifiable->getName());
    
    return  $message;
}
```

#### 独立跳转类型

```php
use Calchen\LaravelDingtalkRobot\Message\ActionCardMessage;

public function toDingTalkRobot($notifiable)
{
    $message = new ActionCardMessage(
        '乔布斯 20 年前想打造一间苹果咖啡厅，而它正是 Apple Store 的前身',
        "![screenshot](@lADOpwk3K80C0M0FoA) \n #### 乔布斯 20 年前想打造的苹果咖啡厅 \n\n Apple Store 的设计正从原来满满的科技感走向生活化，而其生活化的走向其实可以追溯到 20 年前苹果一个建立咖啡馆的计划"
    );
    
    // 添加一个或多个按钮
    $message->addButton('内容不错', 'https://www.dingtalk.com/');
    $message->addButton('不感兴趣', 'https://www.dingtalk.com/');
    
    // 这里可以指定机器人，如果不需要指定则默认使用名称为 default 的机器人
    $message->setRobot($notifiable->getName());
    
    return  $message;
}
```

### FeedCard 类型消息

```php
use Calchen\LaravelDingtalkRobot\Message\FeedCardMessage;

public function toDingTalkRobot($notifiable)
{
    $message = new FeedCardMessage();
    
    // 添加一个或多个链接
    $message->addLink(
        '时代的火车向前开',
        'https://mp.weixin.qq.com/s?__biz=MzA4NjMwMTA2Ng==&mid=2650316842&idx=1&sn=60da3ea2b29f1dcc43a7c8e4a7c97a16&scene=2&srcid=09189AnRJEdIiWVaKltFzNTw&from=timeline&isappinstalled=0&key=&ascene=2&uin=&devicetype=android-23&version=26031933&nettype=WIFI',
        'https://www.dingtalk.com/'
    );
    $message->addLink(
        '时代的火车向前开2',
        'https://mp.weixin.qq.com/s?__biz=MzA4NjMwMTA2Ng==&mid=2650316842&idx=1&sn=60da3ea2b29f1dcc43a7c8e4a7c97a16&scene=2&srcid=09189AnRJEdIiWVaKltFzNTw&from=timeline&isappinstalled=0&key=&ascene=2&uin=&devicetype=android-23&version=26031933&nettype=WIFI',
        'https://www.dingtalk.com/'
    );
    
    // 这里可以指定机器人，如果不需要指定则默认使用名称为 default 的机器人
    $message->setRobot($notifiable->getName());
    
    return  $message;
}
```

## 使用消息通知（Notification）给多个机器人发同一条消息

```php
use Calchen\LaravelDingtalkRobot\Robot;

$notification = new TestDingtalkNotification();

(new Robot('robot_1'))->notify($notification);
(new Robot('robot_2'))->notify($notification);

// TestDingtalkNotification 文件
use Calchen\LaravelDingtalkRobot\Message\TextMessage;

public function toDingTalkRobot($notifiable)
{
    $message = new TextMessage('我就是我, 是不一样的烟火');
    
    // 这里可以指定机器人，如果不需要指定则默认使用名称为 default 的机器人
    // 这里需要 $notifiable 内保存机器人的名称，并提供获取的方法，方可实现给不同机器人发同一条消息
    $message->setRobot($notifiable->getName());
    
    return  $message;
}
```

## 不使用消息通知（Notification）

如果在非 Laravel/Lumen 框架中使用或者您不想使用 Notification ，而是直接调用机器人接口发送信息，那么有多种方式可以实现：

### 容器解析

```php
use Calchen\LaravelDingtalkRobot\DingtalkRobot;
use Calchen\LaravelDingtalkRobot\Message\TextMessage;

$message = new TextMessage('我就是我, 是不一样的烟火');
$message->setRobot('机器人名字');

app(DingtalkRobot::class)->setMessage($message)->send();
```

### 辅助函数 dingtalk_robot

```php
use Calchen\LaravelDingtalkRobot\Message\TextMessage;

$message = new TextMessage('我就是我, 是不一样的烟火');
$message->setRobot('机器人名字');

dingtalk_robot()->setMessage($message)->send();
```

### 直接创建并调用接口

```php
use Calchen\LaravelDingtalkRobot\DingtalkRobot;
use Calchen\LaravelDingtalkRobot\Message\TextMessage;

$message = new TextMessage('我就是我, 是不一样的烟火');
$message->setRobot('机器人名字');

(new DingtalkRobot)->setMessage($message)->send();
```

## 从1.x升级到2.x

首先感谢您使用 1.x 版本的扩展包，因为钉钉机器人更新了安全设置，在升级过程中为了使得代码更整洁因此出现了无法兼容的情况，故此将新版升级至2.x版本。这里将明确给出两个版本的差异，以便您以最少的成本进行升级。

### 配置项的差异

#### 新增

##### http_client_name

为了方便在某些情况下需要统一管理扩展包使用的 HTTP 客户端，提供了 `http_client_name` 配置项，以实现从 Laravel 容器中获取已经注入的 Guzzle 实例。如果您不需要手动管理 HTTP 客户端，您可以不设置该配置项或将该配置项值设置成 null。

##### 机器人名称.security_types

数据结构为数组。如果您使用的是旧机器人，配置项中无“安全设置”相关内容，那么您可以不设置该字段，或将其设置成：

```php
'security_types' => [
    null,
],
```

如果您使用的是新机器人，请按照机器人的实际情况配置该项，可以组合选择：自定义关键字、加签、IP地址（段），如：

```php
'security_types' => [
    'keywords',   // 自定义关键字
    'signature',  // 加签
    'ip',		  // IP地址（段）
],
```

##### 机器人名称.security_signature

密钥字符串。当安全模式包含加签时该字段是必须的。请注意，该字符串前三位应该是 SEC。

## 鸣谢

感谢 [王举](https://github.com/wowiwj)，他的 [wangju/ding-notice](https://github.com/wowiwj/ding-notice) 项目给予了我很多启发。本项目中的部分代码原形来自于该项目。 


## 开源协议

[MIT](http://opensource.org/licenses/MIT)
