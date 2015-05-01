<?php

namespace App\Models;
use App\Models\BaseModel;

class QualificationModel extends BaseModel
{
    public function __construct(\Silex\Application $app)
    {
        parent::__construct($app, 'qualification');
    }

    protected function getAllowedParams()
    {
        return array(
            'name'    => true,
            'options' => false,
            'date'    => true,
            'honors'  => false
        );
    }
}
