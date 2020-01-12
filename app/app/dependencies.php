<?php
declare(strict_types=1);

use DI\ContainerBuilder;
use Envms\FluentPDO\Query;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Monolog\Processor\UidProcessor;
use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;

return function (ContainerBuilder $containerBuilder) {
    $containerBuilder->addDefinitions([
        LoggerInterface::class => function (ContainerInterface $c) {
            $settings = $c->get('settings');

            $loggerSettings = $settings['logger'];
            $logger = new Logger($loggerSettings['name']);

            $processor = new UidProcessor();
            $logger->pushProcessor($processor);

            $handler = new StreamHandler($loggerSettings['path'], $loggerSettings['level']);
            $logger->pushHandler($handler);

            return $logger;
        },
        PDO::class => function (ContainerInterface $c) {
            $config = $c->get('db');

            $adapter = $config['adapter'];
            $host = $config['host'];
            $dbname = $config['name'];
            $port = $config['port'];
            $charset = $config['charset'];


            $dsn = "$adapter:host=$host;dbname=$dbname;port=$port;charset=$charset";
//            var_dump($dsn);die;
            $dbh = new PDO($dsn, $config['user'], $config['pass']);
            $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            return $dbh;
        },
        Query::class => function (ContainerInterface $c) {
            /** @var PDO $pdo */
            $pdo = $c->get(PDO::class);
            return new Query($pdo);
        }
    ]);
};
