<?php

namespace Samizdam\IQSubscriber\MessageHandler;

/**
 * @author samizdam <samizdam@inbox.ru>
 */
interface HandlerInterface
{

    const HANDLER_CALLBACK_FUNC = 'handleMessage';

    public function handleMessage(\Redis $redis, string $channelName, string $message);
}