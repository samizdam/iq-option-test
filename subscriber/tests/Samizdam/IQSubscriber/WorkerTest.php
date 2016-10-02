<?php

namespace Samizdam\IQSubscriber;

use Samizdam\IQSubscriber\MessageHandler\HandlerInterface;

/**
 * @author samizdam <samizdam@inbox.ru>
 */
class WorkerTest extends \PHPUnit_Framework_TestCase
{

    public function testRunAndStop()
    {
        $resis = $this->getMock(\Redis::class);
        $handler = $this->getMock(HandlerInterface::class);
        $worker = new Worker($resis, [], $handler);
        $worker->run();
        self::assertTrue($worker->isRunned());
        $worker->stop();
        self::assertTrue($worker->isStopped());
    }
}