<?php

namespace App\Models;
use App\Models\BaseModel;

class SkillModel extends BaseModel
{
    public function __construct(\Silex\Application $app)
    {
        parent::__construct($app, 'skill');
    }

    protected function getAllowedParams()
    {
        return array(
            'name' => true
        );
    }
}
