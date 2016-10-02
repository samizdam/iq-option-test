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
        $value = 200 / rand(100, 200);
        return [
            'name' => 'EUR/USD',
            'value' => $value,
            'time' => time(),
        ];
    }
}