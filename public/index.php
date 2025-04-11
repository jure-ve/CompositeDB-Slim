<?php
declare(strict_types=1);

use App\Controllers\RootController;
use App\Controllers\UserController;
use DI\ContainerBuilder;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;
use Dotenv\Dotenv;

require __DIR__ . '/../vendor/autoload.php';

// Cargar variables de entorno
$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

// Configurar PHP-DI
$containerBuilder = new ContainerBuilder();
$containerBuilder->addDefinitions([
    \App\Table\UsersTable::class => \DI\create(\App\Table\UsersTable::class)
]);

// Construir el contenedor
$container = $containerBuilder->build();

// Configurar Slim con el contenedor
AppFactory::setContainer($container);
$app = AppFactory::create();
$app->addRoutingMiddleware();

// Inicializar la base de datos (descomentar solo la primera vez)
// $container->get(App\Table\UsersTable::class)->init();

// Rutas
$app->get('/', [RootController::class, 'index']);
$app->get('/users', [UserController::class, 'list']);
$app->post('/users', [UserController::class, 'create']);

$app->run();