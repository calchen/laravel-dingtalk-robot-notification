<?php

namespace Calchen\LaravelDingtalkRobot;

use Illuminate\Notifications\Notifiable;

/**
 * 该类是为了方便以机器人的身份发送群消息，无其他作用
 * 对于其他使用了 Notifiable Trait 的类都可以用来发送消息
 *
 * Class Robot
 *
 * @package Calchen\LaravelDingtalkRobot
 */
class Robot
{
    use Notifiable;

    // 机器人名称，用于指定发送机器人
    private $name;

    public function __construct($name = 'default')
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }
}