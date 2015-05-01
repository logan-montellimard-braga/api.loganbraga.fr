<?php

namespace App\Models;
use App\Models\BaseModel;

class StatusModel extends BaseModel
{
    public function __construct(\Silex\Application $app)
    {
        parent::__construct($app, 'status');
    }

    protected function getAllowedParams()
    {
        return array(
            'name' => true
        );
    }
}
