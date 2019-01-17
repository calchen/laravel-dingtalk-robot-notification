<?php

namespace Calchen\LaravelDingtalkRobot\Message;

use Calchen\LaravelDingtalkRobot\Exception\InvalidArgumentException;

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

    /**
     * 通过手机号码指定“被@人列表”
     *
     * @param      $mobiles
     * @param bool $atAll
     *
     * @return Message
     * @throws InvalidArgumentException
     */
    public function at($mobiles, bool $atAll = false): Message
    {
        if (!is_array($mobiles) && !is_string($mobiles)) {
            throw new InvalidArgumentException('$mobiles should be string or array');
        }
        if (!is_array($mobiles)) {
            $mobiles = [$mobiles];
        }

        return $this->setAt($mobiles, $atAll);
    }
}