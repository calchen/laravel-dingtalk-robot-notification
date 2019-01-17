<?php

namespace Calchen\LaravelDingtalkRobot\Message;

class FeedCardMessage extends Message
{
    public function __construct()
    {
        $this->setMessage();

    }

    public function setMessage(): void
    {
        $this->message = [
            'feedCard' => [
                'links' => []
            ],
            'msgtype' => 'feedCard'
        ];
    }

    /**
     * @param string $title
     * @param string $messageUrl
     * @param string $picUrl
     *
     * @return FeedCardMessage
     */
    public function addLink(string $title, string $messageUrl, string $picUrl): self
    {
        $this->message['feedCard']['links'][] = [
            'title' => $title,
            'messageURL' => $messageUrl,
            'picURL' => $picUrl
        ];
        return $this;
    }
}