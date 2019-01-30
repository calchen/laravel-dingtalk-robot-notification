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
     * @param string $title 首屏会话透出的展示内容
     * @param string $text  markdown格式的消息
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
     * @param string|array $mobiles 被@人的手机号(在text内容里要有@手机号)
     * @param bool         $atAll   @所有人时:true,否则为:false
     *
     * @return Message
     * @throws InvalidArgumentException
     */
    public function at($mobiles, bool $atAll = false): self
    {
        if (!is_array($mobiles) && !is_string($mobiles)) {
            throw new InvalidArgumentException('mobiles should be string or array');
        }
        if (!is_array($mobiles)) {
            $mobiles = [$mobiles];
        }

        $this->at = [
            'at' => [
                'atMobiles' => $mobiles,
                'isAtAll' => $atAll
            ]
        ];

        return $this;
    }
}