#!/usr/bin/env php
<?php

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Console\ConsoleRunner;
use Doctrine\ORM\Tools\Console\EntityManagerProvider\SingleManagerProvider;

// Adjust this path to your actual bootstrap file
require_once __DIR__ . '/../vendor/autoload.php';

// Replace this with your actual code to bootstrap your EntityManager
$entityManager = require_once __DIR__ . '/../config/doctrine.php';

// Ensure we have a valid EntityManager
if (!$entityManager instanceof EntityManager) {
    throw new RuntimeException('Invalid EntityManager provided');
}

// Create a SingleManagerProvider for use with ConsoleRunner
$entityManagerProvider = new SingleManagerProvider($entityManager);

// Run the console application
ConsoleRunner::run($entityManagerProvider);

