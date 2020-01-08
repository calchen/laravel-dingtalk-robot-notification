<?php

namespace Calchen\LaravelDingtalkRobot\Exceptions;

use Calchen\LaravelDingtalkRobot\DingtalkRobot;
use Calchen\LaravelDingtalkRobot\Message\Message;

class ErrorCodes
{
    // 1-999 用于通用基本错误
    const RESPONSE_FAILED = 1;
    const RESPONSE_BODY_ERROR = 2;

    // 1001-9999 用于基础业务错误
    const INVALID_ROBOT_NAME = 1001;
    const ACCESS_TOKEN_IS_NECESSARY = 1002;
    const INVALID_SECURITY_TYPES = 1003;
    const INVALID_SECURITY_VALUES_SIGNATURE = 1006;
    const HTTP_CLIENT_NAME_INVALID = 1007;
    const MOBILES_INVALID = 1008;
    const HIDE_AVATAR_INVALID = 1009;
    const BTN_ORIENTATION_INVALID = 1010;
    const SECURITY_VERIFICATION_FAILED = 1011;
    const RESPONSE_RESULT_UNKNOWN_ERROR = 1012;
    const SHOULD_BE_INSTANCEOF_MESSAGE = 1013;
    const MESSAGE_REQUIRED = 1014;
    const DINGTALK_ROBOT_CONFIG_IS_EMPTY = 1015;
    const OLD_ROBOT_SECURITY_TYPE_INVALID = 1016;
    const SECURITY_SIGNATURE_IS_NECESSARY = 1017;

    const MESSAGES = [
        self::RESPONSE_FAILED     => 'http request failed',
        self::RESPONSE_BODY_ERROR => 'response body decode failed',

        self::INVALID_ROBOT_NAME                => 'robot name: :name not exist. Please check your config in file dingtalk_robot.php',
        self::ACCESS_TOKEN_IS_NECESSARY         => 'access_token is necessary in config',
        self::INVALID_SECURITY_TYPES            => 'security type in config is invalid, only value in '.DingtalkRobot::class.'::SECURITY_TYPES is acceptable',
        self::INVALID_SECURITY_VALUES_SIGNATURE => 'security_values is invalid',
        self::HTTP_CLIENT_NAME_INVALID          => 'http_client_name is invalid',
        self::MOBILES_INVALID                   => 'mobiles should be string or array',
        self::HIDE_AVATAR_INVALID               => 'hideAvatar value can only be 0 or 1',
        self::BTN_ORIENTATION_INVALID           => 'btnOrientation value can only be 0 or 1',
        self::SECURITY_VERIFICATION_FAILED      => 'security verification failed, reason is: :message',
        self::RESPONSE_RESULT_UNKNOWN_ERROR     => 'response result is unknown error, code is: :code, message is: :message',
        self::SHOULD_BE_INSTANCEOF_MESSAGE      => 'function toDingTalkRobot in the $notification should return instanceof '.Message::class,
        self::MESSAGE_REQUIRED                  => 'Please set message object',
        self::DINGTALK_ROBOT_CONFIG_IS_EMPTY    => 'Please set dingtalk_robot config',
        self::OLD_ROBOT_SECURITY_TYPE_INVALID   => 'old robot security types could only has null',
        self::SECURITY_SIGNATURE_IS_NECESSARY   => 'security signature is necessary when security types has signature',
    ];
}
