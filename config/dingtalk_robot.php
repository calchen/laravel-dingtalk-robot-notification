<?php

return [
    // 默认发送的机器人
    'default' => [
        // 是否要开启机器人，关闭则不再发送消息
        'enabled' => env('DINGTALK_ROBOT_ENABLED') !== false,

        // 机器人的 access_token
        'access_token' => env('DINGTALK_ROBOT_TOKEN', ''),

        // 钉钉请求的超时时间
        'timeout' => env('DINGTALK_ROBOT_TIME_OUT', 2.0)
    ]
];