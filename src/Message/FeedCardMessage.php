<?php

namespace Calchen\LaravelDingtalkRobot\Message;

class FeedCardMessage extends Message
{
    public function __construct()
    {
        $this->setMessage();

    }

    public function setMessage()
    {
        $this->message = [
            'feedCard' => [
                'links' => []
            ],
            'msgtype' => 'feedCard'
        ];
    }

    public function addLinks($title, $messageUrl, $picUrl)
    {
        $this->message['feedCard']['links'][] = [
            'title' => $title,
            'messageURL' => $messageUrl,
            'picURL' => $picUrl
        ];
        return $this;
    }
}