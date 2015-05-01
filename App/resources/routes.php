<?php

$app ->get('/',               $app['util.getController']('home::index'));
$app ->get('/works',          $app['util.getController']('works::index'));
$app ->get('/works/{id}',     $app['util.getController']('works::read'));
$app ->get('/experiences',    $app['util.getController']('experiences::index'));
$app ->get('/qualifications', $app['util.getController']('qualifications::index'));
$app ->get('/skills',         $app['util.getController']('skills::index'));
$app ->post('/messages',      $app['util.getController']('messages::create'));

/* $app->post('/works',                $app['util.getController']('works::create')) */
/*     ->before($app['auth.authenticate']); */
/* $app->post('/works/update/{id}',    $app['util.getController']('works::update')) */
/*     ->before($app['auth.authenticate']); */
/* $app->post('/works/delete/{id}',    $app['util.getController']('works::delete')) */
/*     ->before($app['auth.authenticate']); */

/* $app->post('/messages',             $app['util.getController']('messages::index')) */
/*     ->before($app['auth.authenticate']); */
/* $app->post('/messages/{id}',        $app['util.getController']('messages::read')) */
/*     ->before($app['auth.authenticate']); */
/* $app->post('/messages/delete/{id}', $app['util.getController']('messages::delete')) */
/*     ->before($app['auth.authenticate']); */

/* $app->get('/skills/{id}',           $app['util.getController']('skills::read')); */
/* $app->post('/skills',               $app['util.getController']('skills::create')) */
/*     ->before($app['auth.authenticate']); */
/* $app->post('/skills/update/{id}',   $app['util.getController']('skills::update')) */
/*     ->before($app['auth.authenticate']); */
/* $app->post('/skills/delete/{id}',   $app['util.getController']('skills::delete')) */
/*     ->before($app['auth.authenticate']); */

/* $app ->get('/status',         $app ['util.getController']('status::index')); */
/* $app->get('/status/{id}',           $app['util.getController']('status::read')); */
/* $app->post('/status',               $app['util.getController']('status::create')) */
/*     ->before($app['auth.authenticate']); */
/* $app->post('/status/update/{id}',   $app['util.getController']('status::update')) */
/*     ->before($app['auth.authenticate']); */
/* $app->post('/status/delete/{id}',   $app['util.getController']('status::delete')) */
/*     ->before($app['auth.authenticate']); */
