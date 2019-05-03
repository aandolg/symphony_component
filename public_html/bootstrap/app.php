<?php

use App\System\App;
use App\System\Config\Config;

define("BASEPATH", dirname(__DIR__));
$app = App::getInstance(BASEPATH);

$config = new Config('config');
$config->addConfig('database.yaml');
$app->add('config', $config);

return $app;