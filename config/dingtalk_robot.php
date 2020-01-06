<?php

return [
    // 这里注入到 Laravel 容器中的 HTTP 客户端的名称，如果不填写则默认创建
    // 提供这个功能是为了方便用户替换自己使用的 HTTP 客户端，
    'http_client_name' => null,
    // 默认发送的机器人
    'default' => [
        // 机器人的 access_token
        'access_token' => env('DINGTALK_ROBOT_ACCESS_TOKEN'),

        // 请求的超时时间
        'timeout' => env('DINGTALK_ROBOT_TIMEOUT', 2.0),

        // 安全设置（见：\Calchen\LaravelDingtalkRobot\DingtalkRobot::SECURITY_TYPES）
        'security_type' => env('DINGTALK_ROBOT_SECURITY_TYPE'),

        // 根据安全设置，这里的值有所不同
        // security_type 为 null，该值无效
        // security_type 为 keywords，该值为数组，数组的每个元素为关键字字符串，如：["关键字1", "关键字2"]
        // security_type 为 signature，该值为密钥字符串，如：SECa7386ac5314accda3a5036a5192ea826d676abab4920fc410bddcb57c4ff2bce
        // security_type 为 ip，该值无效
        'security_values' => env('DINGTALK_ROBOT_SECURITY_VALUES'),
    ],
];
