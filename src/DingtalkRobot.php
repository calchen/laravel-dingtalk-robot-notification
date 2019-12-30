<?php

namespace Calchen\LaravelDingtalkRobot;

use Calchen\LaravelDingtalkRobot\Exception\Exception;
use Calchen\LaravelDingtalkRobot\Exception\HttpException;
use Calchen\LaravelDingtalkRobot\Exception\InvalidConfigurationException;
use Calchen\LaravelDingtalkRobot\Exceptions\ErrorCodes;
use Calchen\LaravelDingtalkRobot\Message\Message;
use GuzzleHttp\Client;

/**
 * 钉钉群消息机器 API.
 *
 * Class DingtalkRobot
 */
class DingtalkRobot
{
    /**
     * 允许的安全设置
     */
    const SECURITY_TYPES = [
        null,         // 旧机器人
        'keywords',   // 自定义关键字
        'signature',  // 加签
        'ip',         // IP地址（段）
    ];

    protected $config;
    /**
     * @var string
     */
    protected $robotUrl = 'https://oapi.dingtalk.com/robot/send';

    /**
     * 消息对象
     *
     * @var Message
     */
    protected $message = null;

    /**
     * Dingtalk constructor.
     */
    public function __construct()
    {
        $this->robot();
    }

    /**
     * 指定机器人名称，默认为 default.
     *
     * @param string $name
     *
     * @return $this
     * @throws \Exception
     */
    public function robot($name = 'default'): self
    {
        $configs = config('dingtalk_robot');

        // name 必须存在
        if (!isset($configs[$name])) {
            $message = __(ErrorCodes::MESSAGES[ErrorCodes::INVALID_ROBOT_NAME], [
                'name' => $name,
            ]);
            throw new InvalidConfigurationException($message, ErrorCodes::INVALID_ROBOT_NAME);
        }

        $this->config = $configs[$name];

        // access_token 必须有
        if (!isset($this->config['access_token'])) {
            throw new InvalidConfigurationException(null, ErrorCodes::ACCESS_TOKEN_IS_NECESSARY);
        }

        $securityType = $this->config['security_type'];

        if (!in_array($securityType, self::SECURITY_TYPES)) {
            throw new InvalidConfigurationException(null, ErrorCodes::INVALID_SECURITY_TYPE);
        }

        // 根据安全设置进行检查
        if (in_array($securityType, [self::SECURITY_TYPES[1], self::SECURITY_TYPES[2]]) &&
            !isset($this->config['security_values'])
        ) {
            throw new InvalidConfigurationException(null, ErrorCodes::SECURITY_VALUES_IS_NECESSARY);
        }
        $securityValues = $this->config['security_values'];
        if ($securityType == self::SECURITY_TYPES[1]) {
            // 关键字类型的，security_values 必须是数组，至少一个值，最多10个值，且必须是索引从0开始的连续数组
            if (!is_array($securityValues) || count($securityValues) == 0 || count($securityValues) > 10 ||
                array_keys($securityValues) != range(0, count($securityValues) - 1)
            ) {
                throw new InvalidConfigurationException(null, ErrorCodes::INVALID_SECURITY_VALUES_KEYWORDS);
            }
        } elseif ($securityType == self::SECURITY_TYPES[2]) {
            // 签名类型的，security_values 必须是签名，签名以 SEC 开头
            if (!is_string($securityValues) || strpos($securityValues, 'SEC') !== 0) {
                throw new InvalidConfigurationException(null, ErrorCodes::INVALID_SECURITY_VALUES_SIGNATURE);
            }
        }

        return $this;
    }

    /**
     * 将创建好的 message 对象保存到当前对象中以便后续发送
     *
     * @param Message $message
     *
     * @return $this
     * @throws \Exception
     */
    public function setMessage(Message $message): self
    {
        $this->message = $message;
        $this->robot($message->getRobot());

        return $this;
    }

    /**
     * 获取 message 对象的内容.
     *
     * @return array
     */
    public function getMessage(): array
    {
        return $this->message->getMessage();
    }

    /**
     * 发起请求，返回的内容与直接调用钉钉接口返回的内容一致.
     *
     * @return bool|string
     * @throws Exception
     */
    public function send(): string
    {
        if (is_null($this->message)) {
            throw new InvalidConfigurationException('Please set message object');
        }

        $client = new Client([
            'timeout' => $this->config['timeout'] ?? 2.0,
        ]);

        $query = [
            'access_token' => $this->config['access_token']
        ];

        // 在请求接口前根据安全设置进行处理
        $securityType = $this->config['security_type'];
        $securityValues = $this->config['security_values'];
        if ($securityType == self::SECURITY_TYPES[2]) {
            $query['timestamp'] = time();
            $strToSign = $query['timestamp']."\n".$securityValues;
            $query['sign'] = base64_encode(hash_hmac('sha256', $strToSign, $securityValues, true));
        }

        try {
            $response = $client->post(
                $this->robotUrl,
                [
                    'json' => $this->message->getMessage(),
                    'headers' => [
                        'Content-Type' => 'application/json',
                    ],
                    'query' => $query,
                ]
            );

            return $response->getBody()->getContents();
        } catch (Exception $e) {
            throw new HttpException($e->getMessage(), $e->getCode(), $e);
        }
    }
}
