<?php

namespace Calchen\LaravelDingtalkRobot\Message;

/**
 * 文本类型消息
 *
 * Class DingtalkTextMessage
 * @package Calchen\LaravelDingtalkRobot
 */
class TextMessage extends Message
{
    /**
     * DingtalkTextMessage constructor.
     *
     * @param string $content
     */
    public function __construct(string $content)
    {
        $this->setMessage($content);
    }

    /**
     * @param string $content
     */
    public function setMessage(string $content): void
    {
        $this->message = [
            'msgtype' => 'text',
            'text' => [
                'content' => $content
            ]
        ];
    }

    public function at($mobiles = [], $atAll = false): Message
    {
        return $this->setAt($mobiles, $atAll);
    }
}