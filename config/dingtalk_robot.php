<?php

return [
    // 默认发送的机器人
    'default' => [
        // 机器人的 access_token
        'access_token' => env('DINGTALK_ROBOT_TOKEN', ''),

        // 请求的超时时间
        'timeout' => env('DINGTALK_ROBOT_TIME_OUT', 2.0)
    ]
];