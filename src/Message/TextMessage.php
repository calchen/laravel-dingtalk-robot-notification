<?php

namespace Calchen\LaravelDingtalkRobot\Message;

use Calchen\LaravelDingtalkRobot\Exception\InvalidArgumentException;

/**
 * text类型
 *
 * Class TextMessage
 *
 * @package Calchen\LaravelDingtalkRobot
 */
class TextMessage extends Message
{
    /**
     * TextMessage constructor.
     *
     * @param string|null $content 消息内容
     */
    public function __construct(string $content = null)
    {
        if (!is_null($content)) {
            $this->setMessage($content);
        }
    }

    /**
     * @param string $content 消息内容
     *
     * @return TextMessage
     */
    public function setMessage(string $content): self
    {
        $this->message = [
            'msgtype' => 'text',
            'text' => [
                'content' => $content
            ]
        ];

        return $this;
    }

    /**
     * 通过手机号码指定“被@人列表”
     *
     * @param string|array $mobiles 被@人的手机号(在text内容里要有@手机号)
     *
     * @return TextMessage
     * @throws InvalidArgumentException
     */
    public function at($mobiles): self
    {
        if (!is_array($mobiles) && !is_string($mobiles)) {
            throw new InvalidArgumentException('mobiles should be string or array');
        }

        $mobiles = is_array($mobiles) ? $mobiles : func_get_args();

        $this->at['atMobiles'] = $mobiles;

        return $this;
    }

    /**
     * @所有人
     *
     * @return TextMessage
     */
    public function atAll(): self
    {
        $this->at['isAtAll'] = true;

        return $this;
    }
}