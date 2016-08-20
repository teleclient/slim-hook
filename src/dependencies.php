<?php

use App\BashRestController;
use App\HookController;
use App\Executor;
use App\Handler;
use Interop\Container\ContainerInterface;


$container = $app->getContainer();

$container[HookController::class] = function (ContainerInterface $c) {
	return new HookController($c, $c->get(Handler::class));
};

$container[BashRestController::class] = function (ContainerInterface $c) {
	return new BashRestController($c, $c->get(Executor::class));
};

$container[Handler::class] = function (ContainerInterface $c) {
	return new Handler($c, $c->get(Executor::class));
};

$container[Executor::class] = function () {
	return new Executor();
};

// monolog
$container['logger'] = function (ContainerInterface $c) {
    $settings = $c->get('settings')['logger'];
    $logger = new Monolog\Logger($settings['name']);
    $logger->pushProcessor(new Monolog\Processor\UidProcessor());
    $logger->pushHandler(new Monolog\Handler\StreamHandler(eval($settings['path']), $settings['level']));
    return $logger;
};
