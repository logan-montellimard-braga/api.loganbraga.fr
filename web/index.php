<?php

define('ENV', ($_SERVER['SERVER_NAME'] === 'localhost') ? 'dev' : 'prod');

require_once __DIR__.'/../vendor/autoload.php';

$app = new Silex\Application();

require_once __DIR__.'/../App/resources/config/'.ENV.'.php';
require_once __DIR__.'/../App/resources/utils.php';
require __DIR__.'/../App/app.php';

$app['http_cache']->run();

?>
