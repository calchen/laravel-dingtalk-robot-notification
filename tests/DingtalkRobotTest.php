<?php

namespace Calchen\LaravelDingtalkRobot\Test;

use Calchen\LaravelDingtalkRobot\DingtalkRobot;
use Calchen\LaravelDingtalkRobot\Exceptions\ErrorCodes;
use Calchen\LaravelDingtalkRobot\Exceptions\Exception;
use Calchen\LaravelDingtalkRobot\Message\TextMessage;

class DingtalkRobotTest extends TestCase
{
    public function testNoneConfig()
    {
        $config = app('config')->get('dingtalk_robot');
        try {
            app('config')->set('dingtalk_robot', 123);
            $robot = dingtalk_robot();
            $robot->robot('keyworkds');
        } catch (Exception $e) {
            $this->assertEquals(ErrorCodes::DINGTALK_ROBOT_CONFIG_IS_EMPTY, $e->getCode());

            return;
        } finally {
            app('config')->set('dingtalk_robot', $config);
        }

        $this->fail('The exception parameter was not handled correctly');
    }

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
                'access_token'   => 'secret',
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

    public function testSecuritySignatureIsUnset()
    {
        try {
            app('config')->set('dingtalk_robot.testSecuritySignatureIsUnset', [
                'access_token'   => 'secret',
                'security_types' => [
                    DingtalkRobot::SECURITY_TYPES[2],
                ],
            ]);

            $robot = dingtalk_robot();
            $robot->robot('testSecuritySignatureIsUnset');
        } catch (Exception $e) {
            $this->assertEquals(ErrorCodes::SECURITY_SIGNATURE_IS_NECESSARY, $e->getCode());

            return;
        }

        $this->fail('The exception parameter was not handled correctly');
    }

    public function testInvalidSecuritySignature()
    {
        try {
            app('config')->set('dingtalk_robot.testInvalidSecuritySignature', [
                'access_token'       => 'secret',
                'security_types'     => [
                    DingtalkRobot::SECURITY_TYPES[2],
                ],
                'security_signature' => 'signature',
            ]);

            $robot = dingtalk_robot();
            $robot->robot('testInvalidSecuritySignature');
        } catch (Exception $e) {
            $this->assertEquals(ErrorCodes::INVALID_SECURITY_SIGNATURE, $e->getCode());

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

    public function testOldRobotSecurityType()
    {
        try {
            app('config')->set('dingtalk_robot.testOldRobotSecurityType', [
                'access_token'       => 'secret',
                'security_types'     => [
                    null,
                    DingtalkRobot::SECURITY_TYPES[2],
                ],
                'security_signature' => 'signature',
            ]);

            $robot = dingtalk_robot();
            $robot->robot('testOldRobotSecurityType');
        } catch (Exception $e) {
            $this->assertEquals(ErrorCodes::OLD_ROBOT_SECURITY_TYPE_INVALID, $e->getCode());

            return;
        }

        $this->fail('The exception parameter was not handled correctly');
    }

    public function testIncorrectSignature()
    {
        $config = app('config')->get('dingtalk_robot.signature');
        try {
            app('config')->set('dingtalk_robot.signature.security_signature', $config['security_signature'].'1');
            $robot = dingtalk_robot();
            $message = new TextMessage('我就是我, 是不一样的烟火');
            $message->setRobot('signature');
            $robot->setMessage($message);
            $robot->send();
        } catch (Exception $e) {
            $this->assertEquals(ErrorCodes::SECURITY_VERIFICATION_FAILED, $e->getCode());

            return;
        } finally {
            app('config')->set('dingtalk_robot.signature', $config);
        }

        $this->fail('The exception parameter was not handled correctly');
    }

    public function testHttpClient()
    {
        try {
            app('config')->set('dingtalk_robot.http_client_name', 'guzzle');
            $robot = dingtalk_robot();
            $message = new TextMessage('我就是我, 是不一样的烟火');
            $message->setRobot('signature');
            $robot->setMessage($message);
            $robot->send();
        } catch (Exception $e) {
            $this->fail($e->getMessage());

            return;
        } finally {
            app('config')->set('dingtalk_robot.http_client_name', null);
        }

        $this->assertTrue(true);
    }
}
