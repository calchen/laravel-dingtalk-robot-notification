<?php

use Calchen\LaravelDingtalkRobot\DingtalkRobot;

if (! function_exists('dingtalk_robot')) {
    /**
     * 获取钉钉群机器人接口.
     *
     * @return DingtalkRobot
     */
    function dingtalk_robot(): DingtalkRobot
    {
        return app(DingtalkRobot::class);
    }
}
