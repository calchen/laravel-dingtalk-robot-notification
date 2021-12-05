<?php

namespace Calchen\LaravelDingtalkRobot\Message;

/**
 * 机器人群消息的基类.
 *
 * Class Message
 */
abstract class Message
{
    // 消息体
    protected $message = [];

    // 被@人列表
    protected $at = [];

    // 设置机器人名称，默认为 default，会根据名称去找配置
    protected $robot = 'default';

    /**
     * 获取消息请求的请求体内容.
     *
     * @return array
     */
    public function getMessage(): array
    {
        return $this->message + ['at' => $this->at];
    }

    /**
     * 设置接受消息的机器人名称.
     *
     * @param  string  $robot
     * @return Message
     */
    public function setRobot(string $robot): self
    {
        $this->robot = $robot;

        return $this;
    }

    /**
     * 获取机器人名称.
     *
     * @return string
     */
    public function getRobot(): string
    {
        return $this->robot;
    }

    /**
     * 将 URL 转换成指定的 schema 形式，以便控制其 PC 端打开方式为钉钉侧边栏或系统默认浏览器.
     *
     * @link https://ding-doc.dingtalk.com/doc#/serverapi2/iat9q8/e300ae98
     *
     * @param  string  $url
     * @param  bool  $pcSlide
     * @return string
     */
    public function getFinalUrl(string $url, bool $pcSlide = true): string
    {
        return sprintf(
            'dingtalk://dingtalkclient/page/link?url=%s&pc_slide=%s', urlencode($url), $pcSlide ? 'true' : 'false'
        );
    }
}
