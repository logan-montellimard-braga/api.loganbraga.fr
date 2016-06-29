<?php

$app->get('/',               $app['util.getController']('home::index'));
$app->get('/works',          $app['util.getController']('works::index'));
$app->get('/works/{id}',     $app['util.getController']('works::read'));
$app->get('/experiences',    $app['util.getController']('experiences::index'));
$app->get('/qualifications', $app['util.getController']('qualifications::index'));
$app->get('/skills',         $app['util.getController']('skills::index'));
$app->get('/skills/{id}',    $app['util.getController']('skills::show'));
$app->get('/alerts',         $app['util.getController']('alerts::index'));
$app->post('/messages',      $app['util.getController']('messages::create'));
