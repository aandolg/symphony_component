<?php


namespace App\System\Config;


interface IConfig
{
    public function addConfig($file);
    public function get($keyValue);
}