<?php

namespace Calchen\LaravelDingtalkRobot;

use Calchen\LaravelDingtalkRobot\Exception\Exception;
use Calchen\LaravelDingtalkRobot\Exception\HttpException;
use Calchen\LaravelDingtalkRobot\Exception\InvalidConfigurationException;
use Calchen\LaravelDingtalkRobot\Message\Message;
use GuzzleHttp\Client;

/**
 * 钉钉群消息机器 API.
 *
 * Class DingtalkRobot
 */
class DingtalkRobot
{
    protected $config;
    /**
     * @var string
     */
    protected $accessToken = '';
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

        if (! isset($configs[$name])) {
            throw new InvalidConfigurationException("Robot name: {$name} not exist. Please check your setting in dingtalk_robot.php");
        }

        $this->config = $configs[$name];
        $this->accessToken = $configs[$name]['access_token'];

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
     * 获取附带 access_token 的 webhook Url.
     *
     * @return string
     */
    protected function getRobotUrl(): string
    {
        return "{$this->robotUrl}?access_token={$this->accessToken}";
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

        try {
            $response = $client->post(
                $this->getRobotUrl(),
                [
                    'json' => $this->message->getMessage(),
                    'headers' => [
                        'Content-Type' => 'application/json',
                    ],
                ]
            );

            return $response->getBody()->getContents();
        } catch (Exception $e) {
            throw new HttpException($e->getMessage(), $e->getCode(), $e);
        }
    }
}
