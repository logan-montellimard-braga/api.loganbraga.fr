<?php
namespace App\Controllers;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;

class WorksController extends BaseController
{
    public function __construct()
    {
        parent::__construct('work');
    }

    public function indexAction(Request $request, Application $app)
    {
        $model = new $this->model($app);
        $works = $model->findAll();
        foreach ($works as $key => $work) {
            if ($work['status']['name'] !== 'published') {
                unset($works[$key]);
                continue;
            }
            unset($works[$key]['status']);
        }

        return $app->json(array_values($works), 200);
    }

    public function readAction($id, Request $request, Application $app)
    {
        $model = new $this->model($app);
        $work = $model->find($id);
        if ($work && $work['status']['name'] !== 'published') {
            return $app->json(false, 401);
        }
        return $app->json($work, 200);
    }
}
