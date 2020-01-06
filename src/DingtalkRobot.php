<?php

namespace Calchen\LaravelDingtalkRobot;

use Calchen\LaravelDingtalkRobot\Exceptions\ErrorCodes;
use Calchen\LaravelDingtalkRobot\Exceptions\Exception;
use Calchen\LaravelDingtalkRobot\Exceptions\HttpException;
use Calchen\LaravelDingtalkRobot\Exceptions\InvalidConfigurationException;
use Calchen\LaravelDingtalkRobot\Message\Message;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\ClientInterface;
use Illuminate\Support\Facades\App;
use Psr\Http\Message\ResponseInterface;

/**
 * 钉钉群消息机器 API.
 *
 * Class DingtalkRobot
 */
class DingtalkRobot
{
    /**
     * @var GuzzleClient
     */
    protected static $httpClient;

    /**
     * 允许的安全设置.
     */
    const SECURITY_TYPES = [
        null,         // 旧机器人
        'keywords',   // 自定义关键字
        'signature',  // 加签
        'ip',         // IP地址（段）
    ];

    /**
     * @var array
     */
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
     * DingtalkRobot constructor.
     */
    public function __construct()
    {
        //
    }

    /**
     * 指定机器人名称，默认为 default.
     *
     * @param string $name
     *
     * @return $this
     * @throws Exception
     */
    public function robot($name = 'default'): self
    {
        $configs = config('dingtalk_robot');

        // http_client_name 只能是 string
        if (isset($configs['http_client_name']) && ! is_string($configs['http_client_name'])) {
            throw new InvalidConfigurationException(null, ErrorCodes::HTTP_CLIENT_NAME_INVALID);
        }

        // name 必须存在
        if (! isset($configs[$name])) {
            $message = __(ErrorCodes::MESSAGES[ErrorCodes::INVALID_ROBOT_NAME], [
                'name' => $name,
            ]);
            throw new InvalidConfigurationException($message, ErrorCodes::INVALID_ROBOT_NAME);
        }

        $this->config = $configs[$name];

        // access_token 必须有
        if (! isset($this->config['access_token'])) {
            throw new InvalidConfigurationException(null, ErrorCodes::ACCESS_TOKEN_IS_NECESSARY);
        }

        $securityType = $this->config['security_type'];

        if (! in_array($securityType, self::SECURITY_TYPES)) {
            throw new InvalidConfigurationException(null, ErrorCodes::INVALID_SECURITY_TYPE);
        }

        // 根据安全设置进行检查
        if (in_array($securityType, [self::SECURITY_TYPES[1], self::SECURITY_TYPES[2]]) &&
            ! isset($this->config['security_values'])
        ) {
            throw new InvalidConfigurationException(null, ErrorCodes::SECURITY_VALUES_IS_NECESSARY);
        }
        $securityValues = $this->config['security_values'];
        if ($securityType == self::SECURITY_TYPES[1]) {
            // 关键字类型的，security_values 必须是数组，至少一个值，最多10个值，且必须是索引从0开始的连续数组
            if (! is_array($securityValues) || count($securityValues) == 0 || count($securityValues) > 10 ||
                array_keys($securityValues) != range(0, count($securityValues) - 1)
            ) {
                throw new InvalidConfigurationException(null, ErrorCodes::INVALID_SECURITY_VALUES_KEYWORDS);
            }
        } elseif ($securityType == self::SECURITY_TYPES[2]) {
            // 签名类型的，security_values 必须是签名，签名以 SEC 开头
            if (! is_string($securityValues) || strpos($securityValues, 'SEC') !== 0) {
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
     * @throws Exception
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
     * 获取 http 客户端
     * 如果容器已经注入了可记录日志的 guzzle 优先使用.
     *
     * @return ClientInterface
     */
    private function getHttpClient(): ClientInterface
    {
        if (! (self::$httpClient instanceof ClientInterface)) {
            $configs = config('dingtalk_robot');
            if (isset($configs['http_client_name']) && class_exists($configs['http_client_name'])) {
                self::$httpClient = App::make($configs['http_client_name']);
            }

            if (! (self::$httpClient instanceof ClientInterface)) {
                self::$httpClient = new GuzzleClient([
                    'timeout' => $this->config['timeout'] ?? 2.0,
                ]);
            }
        }

        return self::$httpClient;
    }

    /**
     * 发起请求，返回的内容与直接调用钉钉接口返回的内容一致.
     *
     * @return array
     * @throws Exception
     */
    public function send(): array
    {
        if (is_null($this->message)) {
            throw new InvalidConfigurationException('Please set message object');
        }

        $query = [
            'access_token' => $this->config['access_token'],
        ];

        // 在请求接口前根据安全设置进行处理
        $securityType = $this->config['security_type'];
        $securityValues = $this->config['security_values'];
        // 签名的安全设置
        if ($securityType == self::SECURITY_TYPES[2]) {
            // 这里出文档要求：当前时间戳，单位是毫秒，与请求调用时间误差不能超过1小时
            // 故此简单乘以1000，没有用 microtime
            $query['timestamp'] = time() * 1000;
            $strToSign = $query['timestamp']."\n".$securityValues;
            $query['sign'] = base64_encode(hash_hmac('sha256', $strToSign, $securityValues, true));
        }

        /** @var ResponseInterface $response */
        $response = $this->getHttpClient()->post(
            $this->robotUrl,
            [
                'json'    => $this->message->getMessage(),
                'headers' => [
                    'Content-Type' => 'application/json',
                ],
                'query'   => $query,
            ]
        );

        $result = $response->getBody()->getContents();
        if ($response->getStatusCode() !== 200) {
            throw new HttpException($result, ErrorCodes::RESPONSE_FAILED);
        }
        $result = json_decode($result, true);
        if (is_null($result)) {
            throw new Exception($result, ErrorCodes::RESPONSE_BODY_ERROR);
        }

        if (isset($result['errcode']) && $result['errcode'] != 0) {
            // 单独处理安全设置失败
            if ($result['errcode'] === 310000) {
                $message = __(ErrorCodes::MESSAGES[ErrorCodes::SECURITY_VERIFICATION_FAILED], [
                    'message' => $result['errmsg'],
                ]);
                throw new Exception($message, ErrorCodes::SECURITY_VERIFICATION_FAILED);
            } else {
                $message = __(ErrorCodes::MESSAGES[ErrorCodes::RESPONSE_RESULT_UNKNOWN_ERROR], [
                    'code'    => $result['errcode'],
                    'message' => $result['errmsg'],
                ]);
                throw new Exception($message, ErrorCodes::RESPONSE_RESULT_UNKNOWN_ERROR);
            }
        }

        return $result;
    }
}
