<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Doctrine\DBAL\Types\Type;
use Doctrine\DBAL\DriverManager;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMSetup;
use Dotenv\Dotenv;
use Ramsey\Uuid\Doctrine\UuidType;

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

$config = ORMSetup::createAttributeMetadataConfiguration(
    paths: [__DIR__ . '/../src'],
    isDevMode: true,
);

$connection = DriverManager::getConnection([
    'driver' => $_ENV['DB_DRIVER'],
    'host' => $_ENV['DB_HOST'],
    'dbname' => $_ENV['DB_NAME'],
    'user' => $_ENV['DB_USER'],
    'password' => $_ENV['DB_PASSWORD'],
], $config);

if (!Type::hasType('uuid')) {
    Type::addType('uuid', UuidType::class);
}

$platform = $connection->getDatabasePlatform();
$platform->markDoctrineTypeCommented(Type::getType('uuid'));

// Create and return the EntityManager
return EntityManager::create($connection, $config);