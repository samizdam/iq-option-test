<?php
/**
 * Entry script from worker.
 *
 * Accept next parameters:
 * channels: whitespace separated names of channel for subscribe.
 * --host (-h): address of Redis server.
 * --port (-p): port number for connection with Redis server.
 *
 */
use Samizdam\IQSubscriber\MessageHandler\CompositeHandler;
use Samizdam\IQSubscriber\MessageHandler\DatabaseHandler;
use Samizdam\IQSubscriber\MessageHandler\EchoHandler;
use Samizdam\IQSubscriber\Worker;
use Symfony\Component\Console\Input\ArgvInput;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputDefinition;
use Symfony\Component\Console\Input\InputOption;

require __DIR__ . '/vendor/autoload.php';

$definition = new InputDefinition();
$definition->addOptions([
        new InputOption('host', 'h', InputOption::VALUE_REQUIRED, 'Redis host address', '127.0.0.1'),
        new InputOption('port', 'p', InputOption::VALUE_REQUIRED, 'Redis port value', 6379),
    ]
);
$definition->addArgument(new InputArgument('channels', InputArgument::IS_ARRAY, 'Redis channels for subscribe'));
$input = new ArgvInput($_SERVER['argv'], $definition);
$host = $input->getOption('host');
$port = $input->getOption('port');

$redis = new Redis();
$redis->pconnect($host, $port);

$channels = $input->getArgument('channels');
$pdo = new PDO('sqlite:/var/data/subscriber/database.db');
$handler = new CompositeHandler([new EchoHandler(), new DatabaseHandler($pdo));

$worker = new Worker($redis, $channels, $handler);
$worker->run();