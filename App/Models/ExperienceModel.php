<?php

namespace App\Models;
use App\Models\BaseModel;

class ExperienceModel extends BaseModel
{
    public function __construct(\Silex\Application $app)
    {
        parent::__construct($app, 'experience');
    }

    protected function getAllowedParams()
    {
        return array(
            'start_date'  => true,
            'end_date'    => false,
            'title'       => true,
            'description' => true
        );
    }
}
