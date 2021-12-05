<?php

namespace Calchen\LaravelDingtalkRobot\Test\Notifications;

use Calchen\LaravelDingtalkRobot\DingtalkRobotChannel;
use Calchen\LaravelDingtalkRobot\Exceptions\InvalidConfigurationException;
use Calchen\LaravelDingtalkRobot\Message\ActionCardMessage;
use Calchen\LaravelDingtalkRobot\Message\Message;
use Calchen\LaravelDingtalkRobot\Robot;
use Illuminate\Notifications\Notification;

/**
 * Class ActionCardIndependentJumpNotification.
 *
 * 独立跳转 ActionCard 类型消息
 */
class ActionCardInvalidBtnOrientationNotification extends Notification
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
     *
     * @throws InvalidConfigurationException
     */
    public function toDingTalkRobot($notifiable): Message
    {
        $message = new ActionCardMessage(
            '乔布斯 20 年前想打造一间苹果咖啡厅，而它正是 Apple Store 的前身',
            "![screenshot](@lADOpwk3K80C0M0FoA) \n #### 乔布斯 20 年前想打造的苹果咖啡厅 \n\n Apple Store 的设计正从原来满满的科技感走向生活化，而其生活化的走向其实可以追溯到 20 年前苹果一个建立咖啡馆的计划",
            null,
            2
        );

        $message->setRobot($notifiable->getName());

        return $message;
    }
}
