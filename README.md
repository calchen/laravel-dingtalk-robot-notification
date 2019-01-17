<h1 align="center"> laravel-dingtalk-robot-notification </h1>

<p align="center"> 钉钉群机器人 Laravel/Lumen 扩展包 </p>

## 功能说明

## 依赖情况

## 安装方法

```shell
$ composer require calchen/laravel-dingtalk-robot-notification -vvv
```

## 获取 access_token

首先在钉钉中发起群聊并设置一个群机器人，如果您不知道如何设置请查看 [钉钉文档](https://open-doc.dingtalk.com/docs/doc.htm?spm=a219a.7386797.0.0.39a94a97L4qlKb&source=search&treeId=257&articleId=105733&docType=1)，请注意这里需要设置的是"自定义"类型的机器人。

在设置完成后您将获得一个 webhook 地址，该地址中 access_token 的值即下文中使用到的 access_token 的值，请妥善保存该 access_token。


## 配置说明

### Laravel

安装成功后执行

```shell
php artisan vendor:publish --provider="Calchen\LaravelDingtalkRobot\DingtalkRobotNoticeServiceProvider"
```
会将 dingtalk_robot.php 添加到您项目的配置文件目录中

### Lumen 

首先需要在 bootstrap/app.php 中注册 Provider

```php
$app->register(Calchen\LaravelDingtalkRobot\DingtalkRobotNoticeServiceProvider::class);
```

由于使用了 Laravel 的 Notifications 所以还需要额外增加 Notifications 相关 Provider

```php
$app->register(Illuminate\Notifications\NotificationServiceProvider::class);
```

如果您的项目使用了 Facades 可以如下设置
```php
$app->withFacades(true, [
    Illuminate\Support\Facades\Notification::class => 'Notification'
]);
```

然后需要您手动的将 vendor/calchen/laravel-dingtalk-robot-notification/config/dingtalk_robot.php 文件拷贝至您项目的配置文件目录中

### 配置参数说明

- 配置文件默认包含名为 default 的机器人，可根据实际需要配置多个机器人
- access_token 为上文获取到的 webhook 地址中的 access_token。
- timeout 为请求超时时间，详见 [Guzzle](http://docs.guzzlephp.org/en/stable/request-options.html#timeout)

## 以 Laravel/Lumen 的 Notification 方式使用

Tips：为了方便快速调试功能，项目内置了一个使用了  Notifiable Trait 的类：Calchen\LaravelDingtalkRobot\Robot ，以下均以此对象为例，实际开发中请务必根据您项目情况进行对应处理。



根据 [Laravel](https://laravel-china.org/docs/laravel/5.7/notifications/2284#sending-notifications) 文档发送通知既可以使用 Notifiable Trait
```php
use Calchen\LaravelDingtalkRobot\Robot;

(new Robot)->notify(new TestDingtalkNotification());
```
也可以使用 Notification Facade

```php
\Notification::send(new Robot, new TestDingtalkNotification());
```

### 文本类型消息

### link 类型消息

### markdown 类型消息

### ActionCard 类型消息

#### 整体跳转类型


#### 独立跳转类型

### FeedCard 类型消息

## 直接发送机器人群消息

## 鸣谢
感谢 [王举](https://github.com/wowiwj)，他的 [wangju/ding-notice](https://github.com/wowiwj/ding-notice) 项目给予了我很多启发。本项目中的很多代码原形均来自于该项目。 

## License

MIT