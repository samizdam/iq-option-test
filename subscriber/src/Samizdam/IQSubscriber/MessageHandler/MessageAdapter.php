<?php

namespace Samizdam\IQSubscriber\MessageHandler;

use Samizdam\IQSubscriber\MessageHandler\Exception\BadMessageException;

/**
 * @author samizdam <samizdam@inbox.ru>
 */
class MessageAdapter
{

    private $name;
    private $value;
    private $time;

    public function __construct(string $sourceString)
    {
        $data = json_decode($sourceString, JSON_OBJECT_AS_ARRAY);
        if (is_array($data)) {
            $this->checkAndSetData($data);
        } else {
            throw new BadMessageException('Invalid message. ');
        }
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getValue(): float
    {
        return $this->value;
    }

    public function getTime(): int
    {
        return $this->time;
    }

    private function checkAndSetData(array $data)
    {
        if (isset($data['name']) && is_string($data['name'])) {
            $this->setName($data['name']);
        }
        if (isset($data['value']) && is_float($data['value']) && $data['value'] >= 1 && $data['value'] <= 2) {
            $this->setValue($data['value']);
        }
        if (isset($data['time'])) {
            $this->setTime($data['time']);
        }
    }

    private function setName(string $name)
    {
        $this->name = $name;
    }

    public function setValue(float $value)
    {
        $this->value = $value;
    }

    public function setTime(int $time)
    {
        $this->time = $time;
    }


}