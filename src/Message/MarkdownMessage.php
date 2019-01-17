<?php

namespace Calchen\LaravelDingtalkRobot\Message;

use Calchen\LaravelDingtalkRobot\Exception\InvalidArgumentException;

/**
 * markdown类型
 *
 * Class DingtalkMarkdownMessage
 * @package Calchen\LaravelDingtalkRobot
 */
class MarkdownMessage extends Message
{
    /**
     * DingtalkMarkdownMessage constructor.
     *
     * @param string $title
     * @param string $text
     */
    public function __construct(string $title, string $text)
    {
        $this->setMessage($title, $text);
    }

    /**
     * @param string $title
     * @param string $text
     */
    public function setMessage(string $title, string $text): void
    {
        $this->message = [
            'msgtype' => 'markdown',
            'markdown' => [
                'title' => $title,
                'text' => $text
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