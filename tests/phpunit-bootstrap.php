<?php

use Mmi\App\AppTesting;

define('BASE_PATH', realpath(__DIR__ . '/../'));

//dołączenie autoloadera
require BASE_PATH . '/vendor/autoload.php';

//run application
(new AppTesting())->run();
