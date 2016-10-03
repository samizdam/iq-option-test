<?php

namespace Samizdam\IQPublisher;

/**
 * @author samizdam <samizdam@inbox.ru>
 */
class Worker
{

    /**
     * @var \Redis
     */
    private $redis;

    public function __construct(\Redis $redis)
    {
        $this->redis = $redis;
    }

    public function begin()
    {
        // TODO: think run and stop
        while (true) {
            $message = $this->createMessage();
            $messageString = json_encode($message);
            $this->redis->publish('foo', $messageString);
            $this->redis->publish('bar', $messageString);
            $this->redis->publish('baz', 'is\'s bazzz channel. Don\'t listen it!');
        }
    }

    private function createMessage(): array
    {
        $value = $this->getRandomValue();
        return [
            'name' => 'EUR/USD',
            'value' => $value,
            'time' => time(),
        ];
    }

    private function getRandomValue(): float
    {
        return (float) (200 / rand(100, 200));
    }
}