<?php

namespace Calchen\LaravelDingtalkRobot\Test;

use Calchen\LaravelDingtalkRobot\Exceptions\Exception;
use Calchen\LaravelDingtalkRobot\Message\TextMessage;

class HelperTest extends TestCase
{
    /**
     * @throws Exception
     */
    public function testDefault()
    {
        $robot = dingtalk_robot();
        $message = new TextMessage('我就是我, 是不一样的烟火');
        $message->setRobot('keywords');
        $robot->setMessage($message);
        $this->assertTrue(is_array($robot->getMessage()));
    }
}
