<?php

namespace App\Models;
use App\Models\BaseModel;

class MessageModel extends BaseModel
{
    public function __construct(\Silex\Application $app)
    {
        parent::__construct($app, 'message');
    }

    protected function getAllowedParams()
    {
        return array(
            'author'  => true,
            'title'   => true,
            'content' => true
        );
    }
}
