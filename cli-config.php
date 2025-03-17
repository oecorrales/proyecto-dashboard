<?php

use Doctrine\ORM\Tools\Console\ConsoleRunner;
use Doctrine\ORM\Tools\Console\EntityManagerProvider\SingleManagerProvider;

$entityManager = require_once __DIR__ . '/config/doctrine.php';
$commands = [];

ConsoleRunner::run(
    new SingleManagerProvider($entityManager),
    $commands
);