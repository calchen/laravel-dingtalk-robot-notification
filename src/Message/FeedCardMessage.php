<?php

namespace Calchen\LaravelDingtalkRobot\Message;

/**
 * FeedCard 类型.
 *
 * Class FeedCardMessage
 */
class FeedCardMessage extends Message
{
    /**
     * FeedCardMessage constructor.
     */
    public function __construct()
    {
        $this->setMessage();
    }

    public function setMessage()
    {
        $this->message = [
            'msgtype'  => 'feedCard',
            'feedCard' => [
                'links' => [],
            ],
        ];
    }

    /**
     * 增加链接.
     *
     * @param string $title      单条信息文本
     * @param string $messageUrl 点击单条信息到跳转链接
     * @param string $picUrl     单条信息后面图片的URL
     * @param bool   $pcSlide    链接是否在 PC 端侧栏打开，true 在 PC 端侧栏打开；false 在系统默认浏览器
     *
     * @return FeedCardMessage
     */
    public function addLink(string $title, string $messageUrl, string $picUrl, bool $pcSlide = true): self
    {
        $this->message['feedCard']['links'][] = [
            'title'      => $title,
            'messageURL' => $this->getFinalUrl($messageUrl, $pcSlide),
            'picURL'     => $picUrl,
        ];

        return $this;
    }
}
