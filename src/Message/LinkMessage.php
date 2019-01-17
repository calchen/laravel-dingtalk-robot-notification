<?php

namespace Calchen\LaravelDingtalkRobot\Message;

/**
 * link类型
 *
 * Class DingtalkLinkMessage
 * @package Calchen\LaravelDingtalkRobot
 */
class LinkMessage extends Message
{
    /**
     * DingtalkLinkMessage constructor.
     *
     * @param string $title
     * @param string $text
     * @param string $messageUrl
     * @param string $picUrl
     */
    public function __construct(string $title, string $text, string $messageUrl, string $picUrl = '')
    {
        $this->setMessage($title, $text, $messageUrl, $picUrl);
    }

    /**
     * @param string $title
     * @param string $text
     * @param string $messageUrl
     * @param string $picUrl
     */
    public function setMessage(string $title, string $text, string $messageUrl, string $picUrl = ''): void
    {
        $this->message = [
            'msgtype' => 'link',
            'link' => [
                'title' => $title,
                'text' => $text,
                'picUrl' => $picUrl,
                'messageUrl' => $messageUrl
            ]
        ];
    }
}