<?php

namespace Calchen\LaravelDingtalkRobot;

use Illuminate\Notifications\Notifiable;

/**
 * 该类是为了方便以机器人的身份发送群消息，无其他作用
 * 对于其他使用了 Notifiable Trait 的类都可以用来发送消息
 *
 * Class Robot
 * @package Calchen\LaravelDingtalkRobot
 */
class Robot
{
    use Notifiable;
}