<?php

$app['debug'] = false;
$app['log.level'] = Monolog\Logger::ERROR;

$app['db.options'] = array(
    'driver'   => 'pdo_mysql',
    'host'     => '',
    'dbname'   => '',
    'user'     => '',
    'password' => '',
    'charset'  => 'utf8'
);

$app['mail.options'] = array(
    'host'       => '',
    'port'       => 0,
    'username'   => '',
    'password'   => '',
    'encryption' => 'ssl',
    'auth_mode'  => 'login'
);
$app['mail.from'] = array(
    ''
);
$app['mail.to'] = array(
    '',
    ''
);

$app['db.prefix'] = '';

$app['auth.admin'] = array(
    'login' => '',
    'password' => ''
);
