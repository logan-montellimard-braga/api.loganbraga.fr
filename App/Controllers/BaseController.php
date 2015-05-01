<?php
namespace App\Controllers;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use App\Models;

class BaseController
{
    protected $model;

    protected function __construct($modelName)
    {
        $this->model = "App\\Models\\" . ucfirst($modelName) . "Model";
    }

    public function indexAction(Request $request, Application $app)
    {
        $model = new $this->model($app);
        return $app->json($model->findAll(), 200);
    }

    public function createAction(Request $request, Application $app)
    {
        $model = new $this->model($app);
        $params = $request->request->all();
        $params = $app['util.escapeAll']($params);
        $n = $model->insert($params);

        $code = $app['util.getStatusCode']($n);
        if ($n == 1)
            $n = array();
        return $app->json(array_merge($n, array('code' => $code)), $code);
    }

    public function readAction($id, Request $request, Application $app)
    {
        $model = new $this->model($app);
        $result = $model->find($id);
        $code = $result ? 200 : 404;
        return $app->json($result, $code);
    }

    public function updateAction($id, Request $request, Application $app)
    {
        $model = new $this->model($app);
        $params = $request->request->all();
        $params = $app['util.escapeAll']($params);
        $n = $model->update($id, $params);

        $code = $app['util.getStatusCode']($n);
        return $app->json(array('code' => $code), $code);
    }

    public function deleteAction($id, Request $request, Application $app)
    {
        $model = new $this->model($app);
        $n = $model->delete($id);

        $code = $app['util.getStatusCode']($n);
        return $app->json(array('code' => $code), $code);
    }
}
