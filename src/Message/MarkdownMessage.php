<?php

namespace Calchen\LaravelDingtalkRobot\Message;

use Calchen\LaravelDingtalkRobot\Exception\InvalidArgumentException;

/**
 * markdown 类型.
 *
 * Class MarkdownMessage
 */
class MarkdownMessage extends Message
{
    /**
     * MarkdownMessage constructor.
     *
     * @param string|null $title 首屏会话透出的展示内容
     * @param string|null $text  markdown 格式的消息
     */
    public function __construct(string $title = null, string $text = null)
    {
        if (! is_null($title) && ! is_null($text)) {
            $this->setMessage($title, $text);
        }
    }

    /**
     * @param string $title 首屏会话透出的展示内容
     * @param string $text  markdown 格式的消息
     *
     * @return MarkdownMessage
     */
    public function setMessage(string $title, string $text): self
    {
        $this->message = [
            'msgtype' => 'markdown',
            'markdown' => [
                'title' => $title,
                'text' => $text,
            ],
        ];

        return $this;
    }

    /**
     * 通过手机号码指定“被@人列表”.
     *
     * @param string|array $mobiles 被@人的手机号(在text内容里要有@手机号)
     *
     * @return MarkdownMessage
     * @throws InvalidArgumentException
     */
    public function at($mobiles): self
    {
        if (! is_array($mobiles) && ! is_string($mobiles)) {
            throw new InvalidArgumentException('mobiles should be string or array');
        }

        $mobiles = is_array($mobiles) ? $mobiles : func_get_args();

        $this->at['atMobiles'] = $mobiles;

        return $this;
    }

    /**
     * @所有人
     *
     * @return MarkdownMessage
     */
    public function atAll(): self
    {
        $this->at['isAtAll'] = true;

        return $this;
    }
}
