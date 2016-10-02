<?php

namespace Samizdam\IQSubscriber\MessageHandler;

/**
 * @author samizdam <samizdam@inbox.ru>
 */
class EchoHandlerTest extends \PHPUnit_Framework_TestCase
{

    public function testHandleMessage()
    {
        $redis = $this->getMock(\Redis::class);
        $handler = new EchoHandler();
        $handler->handleMessage($redis, 'foo', 'bar');
        self::expectOutputString('[channel:foo]: bar' . PHP_EOL);
    }
}