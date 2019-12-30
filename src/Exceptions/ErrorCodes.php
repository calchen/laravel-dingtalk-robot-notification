<?php


namespace Calchen\LaravelDingtalkRobot\Exceptions;


use Calchen\LaravelDingtalkRobot\DingtalkRobot;

class ErrorCodes
{
    // 1-999 用于通用基本错误
    //

    // 1001-9999 用于基础业务错误
    const INVALID_ROBOT_NAME = 1001;
    const ACCESS_TOKEN_IS_NECESSARY = 1002;
    const INVALID_SECURITY_TYPE = 1003;
    const SECURITY_VALUES_IS_NECESSARY = 1004;
    const INVALID_SECURITY_VALUES_KEYWORDS = 1005;
    const INVALID_SECURITY_VALUES_SIGNATURE = 1006;

    const MESSAGES = [
        self::INVALID_ROBOT_NAME => 'Robot name: :name not exist. Please check your config in file dingtalk_robot.php',
        self::ACCESS_TOKEN_IS_NECESSARY => 'access_token is necessary in config',
        self::INVALID_SECURITY_TYPE => 'security_type in config is invalid, only value in '. DingtalkRobot::class .'::SECURITY_TYPES is acceptable',
        self::SECURITY_VALUES_IS_NECESSARY => 'security_values is necessary when security_type is keywords or signature',
        self::INVALID_SECURITY_VALUES_KEYWORDS => 'security_values is invalid',
        self::INVALID_SECURITY_VALUES_SIGNATURE => 'security_values is invalid',

    ];
}