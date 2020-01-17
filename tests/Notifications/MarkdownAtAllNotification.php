<?php

namespace Calchen\LaravelDingtalkRobot\Test\Notifications;

use Calchen\LaravelDingtalkRobot\DingtalkRobotChannel;
use Calchen\LaravelDingtalkRobot\Message\MarkdownMessage;
use Calchen\LaravelDingtalkRobot\Message\Message;
use Calchen\LaravelDingtalkRobot\Robot;
use Illuminate\Notifications\Notification;

/**
 * Class MarkdownNotification.
 *
 * markdown 类型消息
 */
class MarkdownAtAllNotification extends Notification
{
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
     * @param Robot $notifiable
     *
     * @return Message
     */
    public function toDingTalkRobot($notifiable): Message
    {
        $message = new MarkdownMessage(
            '杭州天气',
            "#### 杭州天气\n".
            "> 9度，西北风1级，空气良89，相对温度73%\n\n".
            "> ![screenshot](https://gw.alicdn.com/tfs/TB1ut3xxbsrBKNjSZFpXXcXhFXa-846-786.png)\n".
            "> ###### 10点20分发布 [天气](http://www.thinkpage.cn/) \n"
        );

        $message->atAll();

        $message->setRobot($notifiable->getName());

        return $message;
    }
}
