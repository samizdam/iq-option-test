<?php

namespace Samizdam\IQSubscriber;

use Samizdam\IQSubscriber\MessageHandler\HandlerInterface;

/**
 * @author samizdam <samizdam@inbox.ru>
 */
class Worker
{

    const STATE_RUN = 'run';
    const STATE_STOP = 'stop';

    private $state = self::STATE_STOP;
    /**
     * @var \Redis
     */
    private $redis;

    /**
     * Worker constructor.
     * @param \Redis $redis
     * @param array|string[] $channelsNames
     */
    public function __construct(\Redis $redis, array $channelsNames, HandlerInterface $messageHandler)
    {
        $this->redis = $redis;
        $this->redis->subscribe($channelsNames, [$messageHandler, $messageHandler::HANDLER_CALLBACK_FUNC]);
    }

    public function handleMessage(\Redis $redis, string $channelName, string $msg)
    {

    }

    public function run()
    {
        $this->state = self::STATE_RUN;
    }

    public function isRunned(): bool
    {
        return $this->state === self::STATE_RUN;
    }

    public function stop()
    {
        $this->state = self::STATE_STOP;
    }

    public function isStopped(): bool
    {
        return $this->state === self::STATE_STOP;
    }
}