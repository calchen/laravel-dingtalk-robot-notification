<h1 align="center"> Laravel-dingtalk-robot-notification </h1>

<p align="center"> 钉钉群机器人 Laravel/Lumen 扩展包 </p>
<p align="center">
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

## 功能说明
实现了 [钉钉群机器人](https://open-doc.dingtalk.com/docs/doc.htm?treeId=257&articleId=105733&docType=1) 的消息推送功能，并通过自定义通道使得机器人的消息推送也可以使用 Laravel 的消息通知（Notification）进行发送，同时对也 Lumen 也进行了支持。

## 依赖情况
```json
"php": ">=7.1",
"guzzlehttp/guzzle": "~6.0",
"phpunit/phpunit": "^7.0",
"illuminate/notifications": "^5.7",
"ramsey/uuid": "^3.8"
```
如遇到依赖过高无法安装的问题请提 Issues。

## 安装方法

```shell
$ composer require calchen/laravel-dingtalk-robot-notification -vvv
```

## 配置

### Laravel

安装成功后执行

```shell
$ php artisan vendor:publish --provider="Calchen\LaravelDingtalkRobot\DingtalkRobotNoticeServiceProvider"
```
会将 dingtalk_robot.php 添加到您项目的配置文件目录中。

### Lumen 

安装成功后首先需要在 bootstrap/app.php 中注册 Provider

```php
$app->register(Calchen\LaravelDingtalkRobot\DingtalkRobotNoticeServiceProvider::class);
```

如果使用 Laravel 的 Notifications 还需要额外增加 Notifications 相关 Provider

```php
$app->register(Illuminate\Notifications\NotificationServiceProvider::class);
```

如果使用 Facades 可以设置别名
```php
$app->withFacades(true, [
    Illuminate\Support\Facades\Notification::class => 'Notification'
]);
```

然后需要您手动的将 vendor/calchen/laravel-dingtalk-robot-notification/config/dingtalk_robot.php 文件拷贝至您项目的配置文件目录中。

### 获取 access_token

首先在钉钉中发起群聊并设置一个群机器人，如果您不知道如何设置请查看 [钉钉文档](https://open-doc.dingtalk.com/docs/doc.htm?spm=a219a.7386797.0.0.39a94a97L4qlKb&source=search&treeId=257&articleId=105733&docType=1#s1)，请注意这里需要设置的是"自定义"类型的机器人。

在设置完成后您将获得一个 webhook 地址，该地址中 access_token 的值即下文中使用到的 access_token 的值，请妥善保存该 access_token。

### 配置文件参数
可在 .env 文件中进行配置
- 配置文件默认包含名为 default 的机器人，可根据实际需要配置多个机器人
- access_token 为上文获取到的 webhook 地址中的 access_token。
- timeout 为请求超时时间，详见 [Guzzle](http://docs.guzzlephp.org/en/stable/request-options.html#timeout)

## 使用消息通知（Notification）

Tips：为了方便快速调试功能，内置了一个使用了  Notifiable Trait 的类：Calchen\LaravelDingtalkRobot\Robot ，以下均以此对象为例，实际开发中请务必根据您项目情况进行对应处理。

首先需要先创建一个 TestDingtalkNotification ，如果是 Laravel 可通过 artisan 命令创建

```php
$ php artisan make:notification TestDingtalkNotification
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

    public function toDingTalkRobot($notifiable)
    {
        /**
         *  $message 根据消息类型的不同由 Calchen\LaravelDingtalkRobot\Message\Message 的各个子类创建
         * 
         * @var Message $message 
         */
        $message = ...;
        return $message;
    }
}
```

根据 [Laravel](https://laravel-china.org/docs/laravel/5.7/notifications/2284#sending-notifications) 文档发送通知既可以使用 Notifiable Trait
```php
use Calchen\LaravelDingtalkRobot\Robot;

(new Robot)->notify(new TestDingtalkNotification());
```
也可以使用 Notification Facade

```php
\Notification::send(new Robot, new TestDingtalkNotification());
```

TestDingtalkNotification 中的 $message = ...; 部分可替换成下面的五种消息类型。

### 文本类型消息

```php
use Calchen\LaravelDingtalkRobot\Message\TextMessage;

public function toDingTalkRobot($notifiable)
{
    $message = new TextMessage('我就是我,  @1825718XXXX 是不一样的烟火');
    
    // 可@某人或某些人
    $message->at('1825718XXXX');
    
    // $message->at(['1825718XXXX', '1825718XXXY']);
    
    // 可@全部人
    
    // $message->atAll();
    
    // 可通过 setConnection 设置向指定的机器人发送消息，如果不指定则为默认机器人
    $message->setConnection('robot_dev');
    
    return  $message;
}
```

### link 类型消息

```php
use Calchen\LaravelDingtalkRobot\Message\LinkMessage;

public function toDingTalkRobot($notifiable)
{
    $message = new LinkMessage('自定义机器人协议', '群机器人是钉钉群的高级扩展功能。群机器人可以将第三方服务的信息聚合到群聊中，实现自动化的信息同步。例如：通过聚合GitHub，GitLab等源码管理服务，实现源码更新同步；通过聚合Trello，JIRA等项目协调服务，实现项目信息同步。不仅如此，群机器人支持Webhook协议的自定义接入，支持更多可能性，例如：你可将运维报警提醒通过自定义机器人聚合到钉钉群。', 'https://open-doc.dingtalk.com/docs/doc.htm?spm=a219a.7629140.0.0.Rqyvqo&treeId=257&articleId=105735&docType=1');
    
    return  $message;
}
```

### markdown 类型消息

```php
use Calchen\LaravelDingtalkRobot\Message\MarkdownMessage;

public function toDingTalkRobot($notifiable)
{
    $message = new MarkdownMessage('杭州天气', "#### 杭州天气  \n > 9度，@1825718XXXX 西北风1级，空气良89，相对温度73%\n\n > ![screenshot](http://i01.lw.aliimg.com/media/lALPBbCc1ZhJGIvNAkzNBLA_1200_588.png)\n  > ###### 10点20分发布 [天气](http://www.thinkpage.cn/) ");
    
    // 可@某人或某些人
    $message->at('1825718XXXX');
    
    // $message->at(['1825718XXXX', '1825718XXXY']);
    
    // 可@全部人
    
    // $message->atAll();
    
    return  $message;
}
```

### ActionCard 类型消息

#### 整体跳转类型

```php
use Calchen\LaravelDingtalkRobot\Message\ActionCardMessage;

public function toDingTalkRobot($notifiable)
{
    $message = new ActionCardMessage('乔布斯 20 年前想打造一间苹果咖啡厅，而它正是 Apple Store 的前身', "![screenshot](@lADOpwk3K80C0M0FoA) \n #### 乔布斯 20 年前想打造的苹果咖啡厅 \n\n Apple Store 的设计正从原来满满的科技感走向生活化，而其生活化的走向其实可以追溯到 20 年前苹果一个建立咖啡馆的计划");
    $message->setSingle('阅读全文', 'https://www.dingtalk.com/');
    
    return  $message;
}
```

#### 独立跳转类型

```php
use Calchen\LaravelDingtalkRobot\Message\ActionCardMessage;

public function toDingTalkRobot($notifiable)
{
    $message = new ActionCardMessage('乔布斯 20 年前想打造一间苹果咖啡厅，而它正是 Apple Store 的前身', "![screenshot](@lADOpwk3K80C0M0FoA) \n #### 乔布斯 20 年前想打造的苹果咖啡厅 \n\n Apple Store 的设计正从原来满满的科技感走向生活化，而其生活化的走向其实可以追溯到 20 年前苹果一个建立咖啡馆的计划");
    
    // 添加一个或多个按钮
    $message->addButton('内容不错', 'https://www.dingtalk.com/');
    $message->addButton('不感兴趣', 'https://www.dingtalk.com/');
    
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
    $message->addLink('时代的火车向前开', 'https://mp.weixin.qq.com/s?__biz=MzA4NjMwMTA2Ng==&mid=2650316842&idx=1&sn=60da3ea2b29f1dcc43a7c8e4a7c97a16&scene=2&srcid=09189AnRJEdIiWVaKltFzNTw&from=timeline&isappinstalled=0&key=&ascene=2&uin=&devicetype=android-23&version=26031933&nettype=WIFI', 'https://www.dingtalk.com/');
    $message->addLink('时代的火车向前开2', 'https://mp.weixin.qq.com/s?__biz=MzA4NjMwMTA2Ng==&mid=2650316842&idx=1&sn=60da3ea2b29f1dcc43a7c8e4a7c97a16&scene=2&srcid=09189AnRJEdIiWVaKltFzNTw&from=timeline&isappinstalled=0&key=&ascene=2&uin=&devicetype=android-23&version=26031933&nettype=WIFI', 'https://www.dingtalk.com/');
    
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
    $message = new TextMessage('我就是我,  @1825718XXXX 是不一样的烟火');
    
    // 可通过 setConnection 设置向指定的机器人发送消息，如果不指定则为默认机器人
    $message->setConnection($notifiable->getName());
    
    return  $message;
}
```

## 不使用消息通知（Notification）

本扩展也支持不使用 Notification 直接调用机器人接口发送信息，有多种方式可以实现：

### 辅助函数 dingtalk_robot
```php
use Calchen\LaravelDingtalkRobot\Message\TextMessage;

$message = new TextMessage('我就是我,  @1825718XXXX 是不一样的烟火');

dingtalk_robot()->setMessage($message)->send();
```

### 容器解析
```php
use Calchen\LaravelDingtalkRobot\DingtalkRobot;
use Calchen\LaravelDingtalkRobot\Message\TextMessage;

$message = new TextMessage('我就是我,  @1825718XXXX 是不一样的烟火');

app(DingtalkRobot::class)->setMessage($message)->send();
```

### 直接创建并调用接口
```php
use Calchen\LaravelDingtalkRobot\DingtalkRobot;
use Calchen\LaravelDingtalkRobot\Message\TextMessage;

$message = new TextMessage('我就是我,  @1825718XXXX 是不一样的烟火');

(new DingtalkRobot)->setMessage($message)->send();
```


## 鸣谢
感谢 [王举](https://github.com/wowiwj)，他的 [wangju/ding-notice](https://github.com/wowiwj/ding-notice) 项目给予了我很多启发。本项目中的很多代码原形均来自于该项目。 

## License

MIT
