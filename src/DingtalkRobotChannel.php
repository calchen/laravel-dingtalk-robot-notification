<?php

namespace Calchen\LaravelDingtalkRobot;

use Calchen\LaravelDingtalkRobot\Message\Message;
use Exception;
use Illuminate\Notifications\Notification;

/**
 * 自定义的钉钉群机器人消息发送渠道.
 *
 * Class DingtalkRobotChannel
 */
class DingtalkRobotChannel
{
    /**
     * Send the given notification.
     *
     * @param              $notifiable
     * @param Notification $notification
     *
     * @throws Exception
     */
    public function send($notifiable, Notification $notification)
    {
        /** @var Message $message */
        $message = $notification->toDingTalkRobot($notifiable);
        if (is_null($message)) {
            return;
        }

        $ding = new DingtalkRobot();
        $ding->setMessage($message)->send();
    }
}
