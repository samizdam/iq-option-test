<?php

namespace Samizdam\IQSubscriber\MessageHandler;

/**
 * @author samizdam <samizdam@inbox.ru>
 */
class DatabaseHandlerTest extends \PHPUnit_Framework_TestCase
{

    private $pdoConnection;

    public function __construct($name = null, array $data = [], $dataName = '')
    {
        $this->pdoConnection = new \PDO('sqlite::memory:');
        parent::__construct($name, $data, $dataName);
    }

    public function setUp()
    {
        $this->initTestDb();
        parent::setUp();
    }

    public function testHandleMessage()
    {
        $handler = new DatabaseHandler($this->pdoConnection);
        $redis = $this->getMock(\Redis::class);
        $columns = [
            'name' => 'EUR/USD',
            'value' => 1.3023421,
            'time' => 1465312662
        ];
        $message = <<<JSON
{
    "name": "EUR/USD",
    "value": 1.3023421,
    "time": 1465312662
}
JSON;

        $this->assertMessageNotExists($columns);
        $handler->handleMessage($redis, 'foo', $message);
        $this->assertMessageExists($columns);
    }

    private function assertMessageExists(array $columns)
    {
        if ($this->getNumberOfMessagesInDb($columns) === 0) {
            self::fail('Message with given columns not exists. ');
        }
    }

    private function assertMessageNotExists(array $columns)
    {
        if ($this->getNumberOfMessagesInDb($columns) > 0) {
            self::fail('Message with given columns not exists. ');
        }
    }

    private function getNumberOfMessagesInDb(array $columns): int
    {
        $statement = $this->pdoConnection->query("
        SELECT count(m.id) 
        FROM messages m
            WHERE 1
            AND m.name = :name 
            AND m.value = :value 
            AND m.time = :time
        ");

        $statement->execute($columns);
        return $statement->fetch(\PDO::FETCH_COLUMN);
    }

    private function initTestDb()
    {
        $this->pdoConnection->query(<<<SQL
            CREATE TABLE messages
            (
                id INTEGER PRIMARY KEY,
                name TEXT NOT NULL,
                value REAL NOT NULL,
                time INTEGER NOT NULL
            );
   );
SQL
        );
    }

}