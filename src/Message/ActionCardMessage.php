<?php

namespace Calchen\LaravelDingtalkRobot\Message;

use Calchen\LaravelDingtalkRobot\Exception\InvalidConfigurationException;

/**
 * ActionCard类型，包含整体跳转和独立跳转.
 *
 * Class ActionCardMessage
 */
class ActionCardMessage extends Message
{
    /**
     * 按钮的排列方式.
     */
    const HIDE_AVATAR_VALUES = [
        0,  // 按钮竖直排列
        1,  // 按钮横向排列
    ];

    /**
     * 是否隐藏发消息者头像.
     */
    const BTN_ORIENTATION_VALUES = [
        0,  // 正常发消息者头像
        1,  // 隐藏发消息者头像
    ];

    /**
     * ActionCardMessage constructor.
     *
     * @param string|null $title          首屏会话透出的展示内容
     * @param string|null $text           markdown 格式的消息
     * @param int|null    $hideAvatar     0-按钮竖直排列，1-按钮横向排列
     * @param int|null    $btnOrientation 0-正常发消息者头像,1-隐藏发消息者头像
     *
     * @throws InvalidConfigurationException
     */
    public function __construct(string $title = null, string $text = null, $hideAvatar = null, $btnOrientation = null)
    {
        if (! is_null($title) && ! is_null($text)) {
            $this->setMessage($title, $text, $hideAvatar, $btnOrientation);
        }
    }

    /**
     *  ActionCard 的整体跳转和独立跳转两种类型中 title text hideAvatar btnOrientation 都是共同拥有的.
     *
     * @param string   $title          首屏会话透出的展示内容
     * @param string   $text           markdown 格式的消息
     * @param int|null $hideAvatar     0-按钮竖直排列，1-按钮横向排列
     * @param int|null $btnOrientation 0-正常发消息者头像,1-隐藏发消息者头像
     *
     * @return ActionCardMessage
     * @throws InvalidConfigurationException
     */
    public function setMessage(string $title, string $text, $hideAvatar = null, $btnOrientation = null): self
    {
        $this->message = [
            'msgtype' => 'actionCard',
            'actionCard' => [
                'title' => $title,
                'text' => $text,
            ],
        ];

        if (! is_null($hideAvatar)) {
            if (! in_array($hideAvatar, self::HIDE_AVATAR_VALUES)) {
                throw new InvalidConfigurationException('hideAvatar value can only be 0 or 1');
            }
            $this->message['actionCard']['hideAvatar'] = $hideAvatar;
        }
        if (! is_null($btnOrientation)) {
            if (! in_array($btnOrientation, self::BTN_ORIENTATION_VALUES)) {
                throw new InvalidConfigurationException('hideAvatar value can only be 0 or 1');
            }
            $this->message['actionCard']['btnOrientation'] = $btnOrientation;
        }

        return $this;
    }

    /**
     * 设置整体跳转类型参数，与独立跳转互斥.
     *
     * @param string $singleTitle 单个按钮的方案。(设置此项和singleURL后btns无效。)
     * @param string $singleUrl   点击singleTitle按钮触发的URL
     *
     * @return $this
     */
    public function setSingle(string $singleTitle, string $singleUrl): self
    {
        $this->message['actionCard']['singleTitle'] = $singleTitle;
        $this->message['actionCard']['singleURL'] = $singleUrl;
        unset($this->message['actionCard']['btns']);

        return $this;
    }

    /**
     * 设置独立跳转类型按钮参数，可设置多个，与整体跳转互斥.
     *
     * @param string $title     按钮方案
     * @param string $actionUrl 点击按钮触发的URL
     *
     * @return ActionCardMessage
     */
    public function addButton(string $title, string $actionUrl): self
    {
        $this->message['actionCard']['btns'][] = [
            'title' => $title,
            'actionURL' => $actionUrl,
        ];
        unset($this->message['actionCard']['singleTitle']);
        unset($this->message['actionCard']['singleURL']);

        return $this;
    }
}
