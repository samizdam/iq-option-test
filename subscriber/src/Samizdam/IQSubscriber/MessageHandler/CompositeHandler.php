<?php

namespace Samizdam\IQSubscriber\MessageHandler;

/**
 * @author samizdam <samizdam@inbox.ru>
 */
class CompositeHandler implements HandlerInterface
{

    /**
     * @var HandlerInterface[]
     */
    private $handlersList;

    /**
     * CompositeHandler constructor.
     * @param array|HandlerInterface[] $handlers
     */
    public function __construct(array $handlers = [])
    {
        foreach ($handlers as $handler) {
            $this->addHandler($handler);
        }
    }

    public function handleMessage(\Redis $redis, string $channelName, string $message)
    {
        foreach ($this->handlersList as $handler) {
            $handler->handleMessage($redis, $channelName, $message);
        }
    }

    private function addHandler(HandlerInterface $handler)
    {
        $this->handlersList[] = $handler;
    }
}