<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\Infrastructure\Event\SimpleEventDispatcher;
use App\Infrastructure\Persistence\Doctrine\DoctrineUserRepository;
use App\Application\UseCase\RegisterUserUseCase;
use App\Presentation\Controller\RegisterUserController;

$request = [
    'method' => $_SERVER['REQUEST_METHOD'],
    'uri' => parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH),
    'body' => json_decode(file_get_contents('php://input'), true) ?? []
];

$entityManager = require __DIR__ . '/../config/doctrine.php';

try {
    if ($request['method'] !== 'POST' || $request['uri'] !== '/api/users') {
        throw new RuntimeException('Route not found', 404);
    }

    $userRepository = new DoctrineUserRepository($entityManager);
    $eventDispatcher = new SimpleEventDispatcher();
    $registerUserUseCase = new RegisterUserUseCase($userRepository, $eventDispatcher);
    $controller = new RegisterUserController($registerUserUseCase);

    $response = $controller->__invoke($request);
    
    http_response_code($response['statusCode']);
    header('Content-Type: application/json');
    echo json_encode($response['data']);

} catch (\Exception $e) {
    http_response_code($e->getCode() ?: 500);
    header('Content-Type: application/json');
    echo json_encode(['error' => $e->getMessage()]);
}