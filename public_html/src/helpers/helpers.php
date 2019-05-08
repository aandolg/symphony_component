<?php

use App\System\App;
if (!function_exists('app')) {
    function app()
    {
        return App::getInstance(BASEPATH);
    }
}