<?php

namespace Calchen\LaravelDingtalkRobot\Test\Notifications;

use Calchen\LaravelDingtalkRobot\DingtalkRobotChannel;
use Calchen\LaravelDingtalkRobot\Message\Message;
use Calchen\LaravelDingtalkRobot\Message\TextMessage;
use Calchen\LaravelDingtalkRobot\Robot;
use Illuminate\Notifications\Notification;

/**
 * Class MarkdownNotification.
 *
 * text 类型消息
 */
class TextAtAllNotification extends Notification
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
     * @param  Robot  $notifiable
     * @return Message
     */
    public function toDingTalkRobot($notifiable): Message
    {
        $message = new TextMessage('我就是我, 是不一样的烟火');

        $message->atAll();

        $message->setRobot($notifiable->getName());

        return $message;
    }
}
