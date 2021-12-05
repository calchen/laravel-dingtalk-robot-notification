<?php

namespace Calchen\LaravelDingtalkRobot\Message;

use Calchen\LaravelDingtalkRobot\Exceptions\ErrorCodes;
use Calchen\LaravelDingtalkRobot\Exceptions\InvalidArgumentException;

/**
 * Trait AtTrait.
 *
 * @mixin Message
 */
trait AtTrait
{
    /**
     * 通过手机号码指定“被@人列表”.
     *
     * @param  string|array  $mobiles  被@人的手机号(在text内容里要有@手机号)
     * @return Message
     *
     * @throws InvalidArgumentException
     */
    public function at($mobiles): self
    {
        if (! is_array($mobiles) && ! is_string($mobiles)) {
            throw new InvalidArgumentException(null, ErrorCodes::MOBILES_INVALID);
        }

        $mobiles = is_array($mobiles) ? $mobiles : func_get_args();

        $this->at['atMobiles'] = $mobiles;

        return $this;
    }

    /**
     * @所有人
     *
     * @return Message
     */
    public function atAll(): self
    {
        $this->at['isAtAll'] = true;

        return $this;
    }
}
