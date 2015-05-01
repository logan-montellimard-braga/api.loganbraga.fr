<?php

namespace App\Models;
use App\Models\BaseModel;

class WorkModel extends BaseModel
{
    public function __construct(\Silex\Application $app)
    {
        parent::__construct($app, 'work');
    }

    public function findAll()
    {
        $works = parent::findAll();

        foreach($works as $key => $val) {
            $works[$key]['skills'] = self::getAllSkillsFromWork($val['id']);
            $works[$key]['status'] = self::getStatusInfos($val['id_status']);

            unset($works[$key]['id_status']);
        }

        return $works;
    }

    public function find($id)
    {
        $work = parent::find($id);
        if ($work) {
            $work['skills'] = self::getAllSkillsFromWork($work['id']);
            $work['status'] = self::getStatusInfos($work['id_status']);
            unset($work['id_status']);
        }

        return $work;
    }

    private function getAllSkillsFromWork($work_id)
    {
        $query =
            $this->db
            ->createQueryBuilder()
            ->select('skill.*')
            ->from('skill, works_skills', '')
            ->where('works_skills.id_skill = skill.id')
            ->andWhere("works_skills.id_work = $work_id")
            ->setMaxResults(10);
        $skills = $this->db->fetchAll($query);
        foreach ($skills as $key => $val) {
            unset($skills[$key]['created_at']);
        }

        return $skills;
    }

    private function getStatusInfos($id_status)
    {
        $query =
            $this->db
            ->createQueryBuilder()
            ->select('*')
            ->from('status', '')
            ->where("id = $id_status")
            ->setMaxResults(1);
        return $this->db->fetchAll($query)[0];
    }

    protected function getAllowedParams()
    {
        return array(
            'title'         => true,
            'summary'       => true,
            'description'   => true,
            'image_url'     => true,
            'thumbnail_url' => true,
            'website_url'   => false,
            'github_url'    => false,
            'id_status'     => false,
            'featured'      => false
        );
    }
}
