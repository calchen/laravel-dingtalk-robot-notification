<?php

namespace Calchen\LaravelDingtalkRobot\Message;

/**
 * 机器人群消息的基类
 *
 * Class Message
 *
 * @package Calchen\LaravelDingtalkRobot\Message
 */
abstract class Message
{
    // 消息体
    protected $message = [];

    // 被@人列表
    protected $at = [];

    // 设置机器人名称，默认为 default
    protected $robot = 'default';


    /**
     * 获取消息请求的请求体内容
     *
     * @return array
     */
    public function getMessage(): array
    {
        return $this->message + $this->at;
    }

    /**
     * 设置接受消息的机器人名称
     *
     * @param $robot
     *
     * @return Message
     */
    public function setRobot($robot): self
    {
        $this->robot = $robot;

        return $this;
    }

    /**
     * 获取机器人名称
     *
     * @return string
     */
    public function getRobot(): string
    {
        return $this->robot;
    }
}