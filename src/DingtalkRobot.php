<?php

namespace Calchen\LaravelDingtalkRobot;

use Calchen\LaravelDingtalkRobot\Exception\Exception;
use Calchen\LaravelDingtalkRobot\Exception\HttpException;
use Calchen\LaravelDingtalkRobot\Exception\InvalidConfigurationException;
use GuzzleHttp\Client;
use Calchen\LaravelDingtalkRobot\Message\Message;

class DingtalkRobot
{
    protected $config;
    /**
     * @var string
     */
    protected $accessToken = "";
    /**
     * @var string
     */
    protected $robotUrl = "https://oapi.dingtalk.com/robot/send";

    /**
     * @var Message
     */
    protected $message = null;

    /**
     * Dingtalk constructor.
     */
    public function __construct()
    {
        $this->connection();
    }

    /**
     * @param string $name
     *
     * @return $this
     * @throws \Exception
     */
    public function connection($name = 'default')
    {
        $configs = config('dingtalk_robot');

        if (!isset(config('dingtalk_robot')[$name])) {
            throw new \Exception("Connection name: {$name} not exist. Please check your config file dingtalk_robot.php");
        }
        
        $this->config = $configs[$name];
        $this->accessToken = $configs[$name]['access_token'];

        return $this;
    }

    /**
     * @param $message
     *
     * @return $this
     */
    public function setMessage(Message $message)
    {
        $this->message = $message;
        return $this;
    }

    /**
     * @return array
     */
    public function getMessage(): ?Message
    {
        return $this->message->getMessage();
    }

    /**
     * @return string
     */
    protected function getRobotUrl(): string
    {
        return "{$this->robotUrl}?access_token={$this->accessToken}";
    }

    /**
     * 发起请求
     *
     * @return bool|string
     * @throws Exception
     */
    public function send()
    {
        if (!$this->config['enabled']) {
            return false;
        }

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
                    ]
                ]
            );
            return $response->getBody()->getContents();
        } catch (Exception $e) {
            throw new HttpException($e->getMessage(), $e->getCode(), $e);
        }
    }
}