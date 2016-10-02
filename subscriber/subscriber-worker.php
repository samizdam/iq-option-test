<?php

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
$redis->connect($host, $port);

$channels = $input->getArgument('channels');
$handler = new EchoHandler();
$worker = new Worker($redis, $channels, $handler);