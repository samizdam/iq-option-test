<?php

namespace Samizdam\IQSubscriber;

use Samizdam\IQSubscriber\MessageHandler\HandlerInterface;

/**
 * @author samizdam <samizdam@inbox.ru>
 */
class Worker
{

    const STATE_WAIT = 'wait';
    const STATE_RUN = 'run';
    const STATE_STOP = 'stop';

    private $state = self::STATE_WAIT;
    /**
     * @var \Redis
     */
    private $redis;
    /**
     * @var array|\string[]
     */
    private $channelsNames;
    /**
     * @var HandlerInterface
     */
    private $messageHandler;

    /**
     * Worker constructor.
     * @param \Redis $redis
     * @param array|string[] $channelsNames
     * @param HandlerInterface $messageHandler
     */
    public function __construct(\Redis $redis, array $channelsNames, HandlerInterface $messageHandler)
    {
        $this->redis = $redis;
        $this->channelsNames = $channelsNames;
        $this->messageHandler = $messageHandler;
    }

    public function run()
    {
        $this->redis->subscribe($this->channelsNames, [$this->messageHandler, HandlerInterface::HANDLER_CALLBACK_FUNC]);
        $this->state = self::STATE_RUN;
    }

    public function isRunned(): bool
    {
        return $this->state === self::STATE_RUN;
    }

    public function stop()
    {
        $this->redis->unsubscribe($this->channelsNames);
        $this->state = self::STATE_STOP;
    }

    public function isStopped(): bool
    {
        return $this->state === self::STATE_STOP;
    }
}