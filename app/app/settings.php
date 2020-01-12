<?php
declare(strict_types=1);

use DI\ContainerBuilder;
use Monolog\Logger;


return function (ContainerBuilder $containerBuilder) {

    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
    $dotenv->load();

    // Global Settings Object
    $containerBuilder->addDefinitions([
        'settings' => [
            'displayErrorDetails' => true, // Should be set to false in production
            'logger' => [
                'name' => getenv('APP_NAME'),
                'path' => isset($_ENV['docker']) ? 'php://stdout' : __DIR__ . '/../logs/app.log',
                'level' => Logger::DEBUG,
            ],
            'db' => require_once 'db.php'
        ],
    ]);
};
