<?php

namespace Calchen\LaravelDingtalkRobot\Message;

abstract class Message
{
    protected $message = [];
    protected $at = [];

    protected function setAt($mobiles = [], $atAll = false): self
    {
        $this->at =  [
            'at' => [
                'atMobiles' => $mobiles,
                'isAtAll' => $atAll
            ]
        ];
        return $this;
    }

    public function getMessage(): array
    {
        return $this->message + $this->at;
    }
}