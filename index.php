<?php
use MyApp\Weather;

require_once __DIR__."/vendor/autoload.php";

$data = new Weather('e114911e93b54a39a92134016210207');
$data->getWeatherByCity();
