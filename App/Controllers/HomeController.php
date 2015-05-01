<?php
namespace App\Controllers;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;

class HomeController
{
    public function __construct()
    {
        null;
    }

    public function indexAction(Request $request, Application $app)
    {
        $message = array(
            'code'    => 200,
            'message' => 'loganbraga.fr public API'
        );
        return $app->json($message, 200);
    }
}
