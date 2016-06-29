<?php

namespace App\Models;
use App\Models\BaseModel;

class SkillModel extends BaseModel
{
    private $app;
    public function __construct(\Silex\Application $app)
    {
        parent::__construct($app, 'skill');
        $this->app = $app;
    }

    protected function getAllowedParams()
    {
        return array(
            'name' => true
        );
    }

    public function find($id)
    {
        $skill = parent::find($id);
        if ($skill) {
            unset($skill['created_at']);
            $works = self::getAllWorksFromSkill($skill['id']);
            $skill['works'] = $works;
        }

        return $skill;
    }

    protected function getAllWorksFromSkill($skill_id)
    {
        $query =
            $this->db
            ->createQueryBuilder()
            ->select($this->app['db.prefix'] . 'work.*')
            ->from($this->app['db.prefix'] . 'work, ' . $this->app['db.prefix'] . 'works_skills', '')
            ->where($this->app['db.prefix'] . 'works_skills.id_work = ' . $this->app['db.prefix'] . 'work.id')
            ->andWhere($this->app['db.prefix'] . "works_skills.id_skill = $skill_id")
            ->setMaxResults(50);
        $works = $this->db->fetchAll($query);
        foreach ($works as $key => $val) {
            if ($works[$key]['id_status'] != 1)
                unset($works[$key]);
        }

        return $works;
    }
}
