<?php

namespace Samizdam\IQSubscriber\MessageHandler;

/**
 * @author samizdam <samizdam@inbox.ru>
 */
class DatabaseHandler implements HandlerInterface
{

    /**
     * @var \PDO
     */
    private $pdoConnection;

    public function __construct(\PDO $pdoConnection)
    {
        $this->pdoConnection = $pdoConnection;
    }

    public function handleMessage(\Redis $redis, string $channelName, string $message)
    {
        $messageAdapter = new MessageAdapter($message);
        $insertStatement = $this->pdoConnection->prepare("
        INSERT INTO `messages` (`name`, `value`, `time`)
          VALUES (:name, :value, :time)
        ");
        $insertStatement->bindValue('name', $messageAdapter->getName());
        $insertStatement->bindValue('value', $messageAdapter->getValue());
        $insertStatement->bindValue('time', $messageAdapter->getTime());
        $insertStatement->execute();
    }
}