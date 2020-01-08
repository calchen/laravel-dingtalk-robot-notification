<?php

namespace Calchen\LaravelDingtalkRobot\Test;

use Calchen\LaravelDingtalkRobot\DingtalkRobot;
use Calchen\LaravelDingtalkRobot\Exceptions\ErrorCodes;
use Calchen\LaravelDingtalkRobot\Exceptions\Exception;

class DingtalkRobotTest extends TestCase
{
    public function testInvalidHttpClientName()
    {
        try {
            app('config')->set('dingtalk_robot.http_client_name', 123);
            $robot = dingtalk_robot();
            $robot->robot('keyworkds');
        } catch (Exception $e) {
            $this->assertEquals(ErrorCodes::HTTP_CLIENT_NAME_INVALID, $e->getCode());

            return;
        } finally {
            app('config')->set('dingtalk_robot.http_client_name', null);
        }

        $this->fail('The exception parameter was not handled correctly');
    }

    public function testInvalidRobotName()
    {
        try {
            $robot = dingtalk_robot();
            $robot->robot('unknown');
        } catch (Exception $e) {
            $this->assertEquals(ErrorCodes::INVALID_ROBOT_NAME, $e->getCode());

            return;
        }

        $this->fail('The exception parameter was not handled correctly');
    }

    public function testUnsetAccessToken()
    {
        try {
            app('config')->set('dingtalk_robot.testUnsetAccessToken', []);

            $robot = dingtalk_robot();
            $robot->robot('testUnsetAccessToken');
        } catch (Exception $e) {
            $this->assertEquals(ErrorCodes::ACCESS_TOKEN_IS_NECESSARY, $e->getCode());

            return;
        }

        $this->fail('The exception parameter was not handled correctly');
    }

    public function testInvalidSecurityType()
    {
        try {
            app('config')->set('dingtalk_robot.testInvalidSecurityType', [
                'access_token' => 'secret',
                'security_types' => [
                    'unknown',
                ],
            ]);

            $robot = dingtalk_robot();
            $robot->robot('testInvalidSecurityType');
        } catch (Exception $e) {
            $this->assertEquals(ErrorCodes::INVALID_SECURITY_TYPES, $e->getCode());

            return;
        }

        $this->fail('The exception parameter was not handled correctly');
    }

    public function testInvalidSecurityValueSignature()
    {
        try {
            app('config')->set('dingtalk_robot.testInvalidSecurityValueSignature', [
                'access_token' => 'secret',
                'security_types' => [
                    DingtalkRobot::SECURITY_TYPES[2],
                ],
                'security_signature' => 'signature',
            ]);

            $robot = dingtalk_robot();
            $robot->robot('testInvalidSecurityValueSignature');
        } catch (Exception $e) {
            $this->assertEquals(ErrorCodes::INVALID_SECURITY_VALUES_SIGNATURE, $e->getCode());

            return;
        }

        $this->fail('The exception parameter was not handled correctly');
    }

    public function testMessageRequired()
    {
        try {
            $robot = dingtalk_robot();
            $robot->send();
        } catch (Exception $e) {
            $this->assertEquals(ErrorCodes::MESSAGE_REQUIRED, $e->getCode());

            return;
        }

        $this->fail('The exception parameter was not handled correctly');
    }
}
