<?php

use Mmi\App\AppTesting;

define('BASE_PATH', realpath(__DIR__ . '/../'));

//dołączenie autoloadera
require BASE_PATH . '/vendor/autoload.php';

putenv('APP_DEBUG_ENABLED=0');
putenv('SESSION_PATH=/tmp');

//run application
(new AppTesting())->run();
