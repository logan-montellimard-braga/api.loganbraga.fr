<?php

namespace App\Models;
use App\Models\BaseModel;

class AlertModel extends BaseModel
{
    public function __construct(\Silex\Application $app)
    {
        parent::__construct($app, 'alert');
    }

    public function findAll()
    {
        $alerts = parent::findAll();

        foreach ($alerts as $key => $val) {
            $start = new \DateTime($alerts[$key]['start_display']);
            $end = new \DateTime($alerts[$key]['end_display']);
            $now = new \DateTime();
            if ($start > $now || $end < $now) {
                unset($alerts[$key]);
            }
            unset($alerts[$key]['modified_at']);
            unset($alerts[$key]['created_at']);
            unset($alerts[$key]['start_display']);
            unset($alerts[$key]['end_display']);
            unset($alerts[$key]['id']);
        }

        return $alerts;
    }

    protected function getAllowedParams()
    {
        return array(
            'title'         => true,
            'text'          => true,
            'action_text'   => true,
            'action_link'   => true,
            'start_display' => false,
            'end_display'   => false
        );
    }
}
