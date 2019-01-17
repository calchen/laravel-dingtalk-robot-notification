<?php

namespace Calchen\LaravelDingtalkRobot\Message;

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

    public function at($mobiles = [], $atAll = false): Message
    {
        return $this->setAt($mobiles, $atAll);
    }
}