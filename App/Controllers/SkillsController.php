<?php
namespace App\Controllers;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;

class SkillsController extends BaseController
{
    public function __construct()
    {
        parent::__construct('skill');
    }

    public function showAction($id, Request $request, Application $app)
    {
        $model = new $this->model($app);
        $work = $model->find($id);
        return $app->json($work, 200);
    }
}
