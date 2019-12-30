<?php

namespace Calchen\LaravelDingtalkRobot\Message;

class FeedCardMessage extends Message
{
    /**
     * FeedCardMessage constructor.
     */
    public function __construct()
    {
        $this->setMessage();
    }

    public function setMessage(): void
    {
        $this->message = [
            'feedCard' => [
                'links' => [],
            ],
            'msgtype' => 'feedCard',
        ];
    }

    /**
     * 增加链接.
     *
     * @param string $title      单条信息文本
     * @param string $messageUrl 点击单条信息到跳转链接
     * @param string $picUrl     单条信息后面图片的URL
     *
     * @return FeedCardMessage
     */
    public function addLink(string $title, string $messageUrl, string $picUrl): self
    {
        $this->message['feedCard']['links'][] = [
            'title'      => $title,
            'messageURL' => $messageUrl,
            'picURL'     => $picUrl,
        ];

        return $this;
    }
}
