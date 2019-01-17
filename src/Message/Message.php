<?php

namespace Calchen\LaravelDingtalkRobot\Message;

abstract class Message
{
    protected $message = [];
    protected $at = [];

    // 设置机器人名称，默认为 default
    protected $connection = 'default';

    protected function setAt($mobiles = [], $atAll = false): self
    {
        $this->at = [
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

    public function setConnection($connection): self
    {
        $this->connection = $connection;
        return $this;
    }

    public function getConnection(): string
    {
        return $this->connection;
    }
}