<?php
use Silex\Application;
use Silex\Provider\HttpCacheServiceProvider;
use Silex\Provider\DoctrineServiceProvider;
use Silex\Provider\MonologServiceProvider;
use Silex\Provider\SwiftmailerServiceProvider;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\ParameterBag;

//handling CORS preflight request
$app->before(function (Request $request) {
   if ($request->getMethod() === "OPTIONS") {
       $response = new Response();
       $response->headers->set("Access-Control-Allow-Origin","*");
       $response->headers->set("Access-Control-Allow-Methods","GET,POST,PUT,DELETE,OPTIONS");
       $response->headers->set("Access-Control-Allow-Headers","Content-Type");
       $response->setStatusCode(200);
       return $response->send();
   }
}, Application::EARLY_EVENT);

//handling CORS respons with right headers
$app->after(function (Request $request, Response $response) {
   $response->headers->set("Access-Control-Allow-Origin","*");
   $response->headers->set("Access-Control-Allow-Methods","GET,POST,PUT,DELETE,OPTIONS");
   $response->headers->set("Cache-Control","s-maxage=5");
});

// Accept JSON requests
$app->before(function (Request $request) {
    if (0 === strpos($request->headers->get('Content-Type'), 'application/json')) {
        $data = json_decode($request->getContent(), true);
        $request->request->replace(is_array($data) ? $data : array());
    }
});

// Register to HttpCache service
$app->register(new HttpCacheServiceProvider(), array(
    "http_cache.cache_dir" => __DIR__ . "/../storage/cache"
));

// Register to Monoloh logging service
$app->register(new MonologServiceProvider(), array(
    "monolog.logfile" => __DIR__ . "/../storage/logs/" . ENV . "/" . date("Y-m-d") . ".log",
    "monolog.level" => $app["log.level"],
    "monolog.name" => "main_logger"
));

// Register to Doctrine DBAL service
$app->register(new DoctrineServiceProvider(), array(
    'db.options' => $app['db.options']
));

// Register to SwiftMailer mailer service
$app->register(new SwiftmailerServiceProvider());
$app['swiftmailer.options'] = $app['mail.options'];

// Basic user authentication
$app['auth.authenticate'] = $app->protect(function ($request, $app) {
    $login = $app->escape($request->request->get('login'));
    $pass = hash('sha512', $app->escape($request->request->get('pass')));

    if ($login != $app['auth.admin']['login']
        || $pass != $app['auth.admin']['password'])
        return $app->json(array('code' => 401), 401);
});

// Default settings for all controllers
$app['controllers']
    ->value('id', 0)
    ->assert('id', '\d+');

// Handle errors
$app->error(function (\Exception $e, $code) use ($app) {
    $app['monolog']->addError($e->getMessage());

    if ($app['debug']) {
        $app['monolog']->addError($e->getTraceAsString());
        return;
    }

    $err = array('error' => $code, 'message' => $e->getMessage());
    return $app->json($err, $code);
});

// Routes loader
require __DIR__.'/resources/routes.php';
