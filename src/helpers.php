<?php

use Calchen\LaravelDingtalkRobot\DingtalkRobot;

if (!function_exists('dingtalk_robot')) {
    /**
     * 获取钉钉群机器人接口.
     *
     * @return DingtalkRobot
     * @throws Exception
     */
    function dingtalk_robot()
    {
        $arguments = func_get_args();

        /** @var DingtalkRobot $dingTalk */
        $dingTalk = app(DingtalkRobot::class);

        if (empty($arguments)) {
            return $dingTalk;
        }

        return $dingTalk->robot($arguments[0]);
    }
}
