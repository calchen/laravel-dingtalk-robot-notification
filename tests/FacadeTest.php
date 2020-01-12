<?php

namespace Calchen\LaravelDingtalkRobot\Test;

use Calchen\LaravelDingtalkRobot\Message\TextMessage;

class FacadeTest extends TestCase
{
    public function testDefault()
    {
        $message = new TextMessage('我就是我, 是不一样的烟火');
        $message->setRobot('keywords');
        $robot = \DingtalkRobot::setMessage($message);
        $this->assertTrue(is_array($robot->getMessage()));
    }
}