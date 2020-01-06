<?php

namespace Calchen\LaravelDingtalkRobot\Message;

/**
 * text类型.
 *
 * Class TextMessage
 */
class TextMessage extends Message
{
    use AtTrait;

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
            'text'    => [
                'content' => $content,
            ],
        ];

        return $this;
    }
}
