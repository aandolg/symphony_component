<?php

use App\System\App;

define("BASEPATH", dirname(__DIR__));
$app = App::getInstance(BASEPATH);
return $app;