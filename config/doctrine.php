<?php

use Doctrine\DBAL\DriverManager;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMSetup;
use Symfony\Component\Dotenv\Dotenv;

require_once "vendor/autoload.php";

$dotenv = new Dotenv();
$dotenv->loadEnv(__DIR__ . '/../.env', null, true);

$requiredVars = ['DB_HOST', 'DB_NAME', 'DB_USER', 'DB_PASS'];
foreach ($requiredVars as $var) {
    if (!isset($_ENV[$var]) || empty($_ENV[$var])) {
        die("Environment variable $var is not set in .env file");
    }
}

$config = ORMSetup::createAttributeMetadataConfiguration(
    paths: [__DIR__ . '/../src'],
    isDevMode: true,
    proxyDir: __DIR__ . '/../var/cache/doctrine/proxies'
);

$connectionParams = [
    'dbname' => $_ENV['DB_NAME'],
    'user' => $_ENV['DB_USER'],
    'password' => $_ENV['DB_PASS'],
    'host' => $_ENV['DB_HOST'],
    'driver' => 'pdo_mysql',
    'charset' => 'utf8mb4',
    'defaultTableOptions' => [
        'charset' => 'utf8mb4',
        'collate' => 'utf8mb4_unicode_ci',
    ],
    // Specify your MySQL server version here for optimal performance
    'server_version' => $_ENV['DB_SERVER_VERSION'] ?? '8.0'
];

try {
    $connection = DriverManager::getConnection($connectionParams);
    $entityManager = new EntityManager($connection, $config);
    
    return $entityManager;
} catch (\Exception $e) {
    die("Error connecting to the database: " . $e->getMessage());
}
