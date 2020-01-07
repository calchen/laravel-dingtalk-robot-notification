<?php


namespace Calchen\LaravelDingtalkRobot\Test;


use Calchen\LaravelDingtalkRobot\Robot;

class RobotTest extends TestCase
{
    public function testSetName()
    {
        $robot = new Robot('signature');
        $robot->setName('keywords');
        $this->assertEquals('keywords', $robot->getName());
    }
}