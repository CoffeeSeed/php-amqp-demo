<?php
require __DIR__ . '/../protected/vendor/autoload.php';
define("APP_ENVIRONMENT", "demo1");

use Service\TestService;

$testService = new TestService();
$amqpCl = $testService->createConsumer();

while (true) {
    $amqpCl->wait();
    sleep(1);
}

