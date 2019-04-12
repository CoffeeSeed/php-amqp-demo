<?php

require __DIR__ . '/../protected/vendor/autoload.php';

define("APP_ENVIRONMENT", "demo2");

use Service\TestService;

$testService = new TestService();
$count = random_int(1 , 10);
print "Count: " . (string) $count . "\n";
for ($i = 0; $i < $count; $i++) {
	$testService->tapRabbit();
	sleep(1);
}
