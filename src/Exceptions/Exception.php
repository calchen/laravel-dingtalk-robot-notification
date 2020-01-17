<?php

namespace Calchen\LaravelDingtalkRobot\Exceptions;

use Throwable;

/**
 * 异常基类.
 *
 * Class Exception
 */
class Exception extends \Exception
{
    /**
     * 重写构造方法，直接根据 code 取错误消息.
     *
     * @param string         $message
     * @param int            $code
     * @param Throwable|null $previous
     */
    public function __construct($message = '', $code = 0, Throwable $previous = null)
    {
        if (is_null($message) && in_array($code, array_keys(ErrorCodes::MESSAGES))) {
            $message = ErrorCodes::MESSAGES[$code];
        }

        parent::__construct($message, $code, $previous);
    }
}
