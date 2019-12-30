<?php

namespace Calchen\LaravelDingtalkRobot\Message;

use Calchen\LaravelDingtalkRobot\Exception\InvalidConfigurationException;

/**
 * ActionCard类型，包含整体跳转和独立跳转.
 *
 * Class DingtalkActionCardMessage
 */
class ActionCardMessage extends Message
{
    /**
     * DingtalkActionCardMessage constructor.
     *
     * @param string $title          首屏会话透出的展示内容
     * @param string $text           markdown 格式的消息
     * @param int    $hideAvatar     0-按钮竖直排列，1-按钮横向排列
     * @param int    $btnOrientation 0-正常发消息者头像,1-隐藏发消息者头像
     *
     * @throws InvalidConfigurationException
     */
    public function __construct(string $title, string $text, int $hideAvatar = 0, int $btnOrientation = 0)
    {
        $this->setMessage($title, $text, $hideAvatar, $btnOrientation);
    }

    /**
     * hideAvatar 的值
     */
    const HIDE_AVATAR_VALUES = [
        0,  // 按钮竖直排列
        1,   // 按钮横向排列
    ];

    /**
     * btnOrientation 的值
     */
    const BTN_ORIENTATION_VALUES = [
        0,  // 正常发消息者头像
        1,   // 隐藏发消息者头像
    ];

    /**
     *  ActionCard 的整体跳转和独立跳转两种类型中 title text hideAvatar btnOrientation 都是共同拥有的.
     *
     * @param string $title          首屏会话透出的展示内容
     * @param string $text           markdown 格式的消息
     * @param int    $hideAvatar     0-按钮竖直排列，1-按钮横向排列
     * @param int    $btnOrientation 0-正常发消息者头像,1-隐藏发消息者头像
     *
     * @throws InvalidConfigurationException
     */
    public function setMessage(string $title, string $text, int $hideAvatar = 0, int $btnOrientation = 0): void
    {
        if (array_search($hideAvatar, self::HIDE_AVATAR_VALUES) === false) {
            throw new InvalidConfigurationException('hideAvatar value can only be 0 or 1');
        }
        if (array_search($btnOrientation, self::BTN_ORIENTATION_VALUES) === false) {
            throw new InvalidConfigurationException('btnOrientation value can only be 0 or 1');
        }

        $this->message = [
            'msgtype'    => 'actionCard',
            'actionCard' => [
                'title'          => $title,
                'text'           => $text,
                'hideAvatar'     => $hideAvatar,
                'btnOrientation' => $btnOrientation,
            ],
        ];
    }

    /**
     * 设置整体跳转类型参数.
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

        return $this;
    }

    /**
     * 设置独立跳转类型按钮参数.
     *
     * @param string $title     按钮方案
     * @param string $actionUrl 点击按钮触发的URL
     *
     * @return ActionCardMessage
     */
    public function addButton(string $title, string $actionUrl): self
    {
        $this->message['actionCard']['btns'][] = [
            'title'     => $title,
            'actionURL' => $actionUrl,
        ];

        return $this;
    }
}
