<?php
/**
 *
 * Entry worker script.
 *
 * Accept next parameters:
 * --host (-h): address of Redis server.
 * --port (-p): port number for connection with Redis server.
 *
 */
use Samizdam\IQPublisher\Worker;
use Symfony\Component\Console\Input\ArgvInput;
use Symfony\Component\Console\Input\InputDefinition;
use Symfony\Component\Console\Input\InputOption;

require __DIR__ . '/vendor/autoload.php';

$definition = new InputDefinition();
$definition->addOptions([
        new InputOption('host', 'h', InputOption::VALUE_REQUIRED, 'Redis host address', '127.0.0.1'),
        new InputOption('port', 'p', InputOption::VALUE_REQUIRED, 'Redis port value', 6379),
    ]
);

$input = new ArgvInput($_SERVER['argv'], $definition);
$host = $input->getOption('host');
$port = $input->getOption('port');

$redis = new Redis();
$redis->pconnect($host, $port);

$worker = new Worker($redis);
$worker->begin();