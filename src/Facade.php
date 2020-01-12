<?php

namespace Calchen\LaravelDingtalkRobot;

use Calchen\LaravelDingtalkRobot\Message\Message;
use Illuminate\Support\Facades\Facade as LaravelFacade;

/**
 * Class Facade
 *
 * @package Calchen\LaravelDingtalkRobot
 * @method static robot($name = 'default')
 * @method static setMessage(Message $message)
 * @method static getMessage()
 * @method static send()
 */
class Facade extends LaravelFacade
{
    protected static function getFacadeAccessor()
    {
        return DingtalkRobot::class;
    }
}