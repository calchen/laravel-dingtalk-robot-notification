<?php

namespace Calchen\LaravelDingtalkRobot\Message;

/**
 * markdown 类型.
 *
 * Class MarkdownMessage
 */
class MarkdownMessage extends Message
{
    use AtTrait;

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
            'msgtype'  => 'markdown',
            'markdown' => [
                'title' => $title,
                'text'  => $text,
            ],
        ];

        return $this;
    }
}
