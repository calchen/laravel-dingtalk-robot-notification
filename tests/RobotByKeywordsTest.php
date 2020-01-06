<?php

namespace Calchen\LaravelDingtalkRobot\Test;

use Calchen\LaravelDingtalkRobot\Robot;
use Calchen\LaravelDingtalkRobot\Test\Notifications\ActionCardIndependentJumpNotification;
use Calchen\LaravelDingtalkRobot\Test\Notifications\ActionCardOverallJumpNotification;
use Calchen\LaravelDingtalkRobot\Test\Notifications\FeedCardNotification;
use Calchen\LaravelDingtalkRobot\Test\Notifications\LinkNotification;
use Calchen\LaravelDingtalkRobot\Test\Notifications\MarkdownAtAllNotification;
use Calchen\LaravelDingtalkRobot\Test\Notifications\MarkdownAtPersonNotification;
use Calchen\LaravelDingtalkRobot\Test\Notifications\TextAtAllNotification;
use Calchen\LaravelDingtalkRobot\Test\Notifications\TextAtPersonNotification;
use Exception;

/**
 * Class RobotByKeywordsTest.
 *
 * 验证方式为关键字的测试
 */
class RobotByKeywordsTest extends TestCase
{
    /**
     * @var Robot
     */
    private static $robot = null;

    /**
     * @return Robot
     */
    private static function getRobot()
    {
        if (is_null(static::$robot)) {
            static::$robot = new Robot('keywords');
        }

        return static::$robot;
    }

    /**
     * 测试独立跳转 ActionCard 类型消息.
     */
    public function testActionCardIndependentJumpNotification()
    {
        try {
            $notification = new ActionCardIndependentJumpNotification();

            static::getRobot()->notify($notification);
        } catch (Exception $e) {
            $this->fail($e->getMessage());
        }

        $this->assertTrue(true);
    }

    /**
     * 测试整体跳转 ActionCard 类型消息.
     */
    public function testActionCardOverallJumpNotification()
    {
        try {
            $notification = new ActionCardOverallJumpNotification();

            static::getRobot()->notify($notification);
        } catch (Exception $e) {
            $this->fail($e->getMessage());
        }

        $this->assertTrue(true);
    }

    /**
     * 测试 FeedCard 类型消息.
     */
    public function testFeedCardNotification()
    {
        try {
            $notification = new FeedCardNotification();

            static::getRobot()->notify($notification);
        } catch (Exception $e) {
            $this->fail($e->getMessage());
        }

        $this->assertTrue(true);
    }

    /**
     * 测试 link 类型消息.
     */
    public function testLinkNotification()
    {
        try {
            $notification = new LinkNotification();

            static::getRobot()->notify($notification);
        } catch (Exception $e) {
            $this->fail($e->getMessage());
        }

        $this->assertTrue(true);
    }

    /**
     * 测试 markdown 类型消息.
     */
    public function testMarkdownAtAllNotification()
    {
        try {
            $notification = new MarkdownAtAllNotification();

            static::getRobot()->notify($notification);
        } catch (Exception $e) {
            $this->fail($e->getMessage());
        }

        $this->assertTrue(true);
    }

    /**
     * 测试 markdown 类型消息.
     */
    public function testMarkdownAtPersonNotification()
    {
        try {
            $notification = new MarkdownAtPersonNotification();

            static::getRobot()->notify($notification);
        } catch (Exception $e) {
            $this->fail($e->getMessage());
        }

        $this->assertTrue(true);
    }

    /**
     * 测试 text 类型消息.
     */
    public function testTextAtAllNotification()
    {
        try {
            $notification = new TextAtAllNotification();

            static::getRobot()->notify($notification);
        } catch (Exception $e) {
            $this->fail($e->getMessage());
        }

        $this->assertTrue(true);
    }

    /**
     * 测试 text 类型消息.
     */
    public function testTextAtPersonNotification()
    {
        try {
            $notification = new TextAtPersonNotification();

            static::getRobot()->notify($notification);
        } catch (Exception $e) {
            $this->fail($e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function sleepForLimit()
    {
        sleep(35);

        $this->assertTrue(true);
    }
}
