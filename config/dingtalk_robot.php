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

        // 安全设置
        // 多个配置项以数组形式设置（见：\Calchen\LaravelDingtalkRobot\DingtalkRobot::SECURITY_TYPES）
        'security_types' => [
            'keywords',
            'signature',
        ],

        // types 中包含 signature 时，该字段是必须的，为密钥字符串
        'security_signature' => env('DINGTALK_ROBOT_SECURITY_SIGNATURE'),
    ],
];
