<?php

namespace Calchen\LaravelDingtalkRobot\Test\Notifications;

use Calchen\LaravelDingtalkRobot\DingtalkRobotChannel;
use Calchen\LaravelDingtalkRobot\Exceptions\InvalidArgumentException;
use Calchen\LaravelDingtalkRobot\Message\Message;
use Calchen\LaravelDingtalkRobot\Message\TextMessage;
use Calchen\LaravelDingtalkRobot\Robot;
use Illuminate\Notifications\Notification;

/**
 * Class MarkdownNotification.
 *
 * text 类型消息
 */
class TextAtPersonNotification extends Notification
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
     * @param $notifiable
     *
     * @return Message
     * @throws InvalidArgumentException
     */
    public function toDingTalkRobot($notifiable): Message
    {
        $phone = env('AT_PERSON_PHONE');
        $message = new TextMessage("我就是我, 是不一样的烟火 @{$phone}");

        $message->at($phone);

        $message->setRobot($notifiable->getName());

        return $message;
    }
}
