<?php

use Calchen\LaravelDingtalkRobot\DingtalkRobot;

if (!function_exists('dingtalk_robot')){

    /**
     * 获取钉钉群机器人
     *
     * @return DingtalkRobot
     */
    function dingtalk_robot(){

        $arguments = func_get_args();

        $dingTalk = app(DingtalkRobot::class);

        if (empty($arguments)) {
            return $dingTalk;
        }

        return $dingTalk->connection($arguments[0]);
    }
}