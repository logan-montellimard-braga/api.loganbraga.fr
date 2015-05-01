<?php

namespace App\Models;
use App\Models\BaseModel;

class WorkSkillModel extends BaseModel
{
    public function __construct(\Silex\Application $app)
    {
        parent::__construct($app, 'works_skills');
    }

    protected function getAllowedParams()
    {
        return array(
            'id_work'  => true,
            'id_skill' => true,
        );
    }
}
