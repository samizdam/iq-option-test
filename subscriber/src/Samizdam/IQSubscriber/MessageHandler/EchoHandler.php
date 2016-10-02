<?php

namespace Samizdam\IQSubscriber\MessageHandler;

/**
 * @author samizdam <samizdam@inbox.ru>
 */
class EchoHandler implements HandlerInterface
{

    const PRINT_PATTERN = '[channel:%s]: %s' . PHP_EOL;

    public function handleMessage(\Redis $redis, string $channelName, string $message)
    {
        printf(self::PRINT_PATTERN, $channelName, $message);
    }
}