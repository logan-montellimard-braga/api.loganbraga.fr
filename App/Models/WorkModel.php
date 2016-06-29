<?php

namespace App\Models;
use App\Models\BaseModel;

class WorkModel extends BaseModel
{
    protected $app;
    public function __construct(\Silex\Application $app)
    {
        parent::__construct($app, 'work');
        $this->app = $app;
    }

    public function findAll()
    {
        $works = parent::findAll();

        foreach($works as $key => $val) {
            $works[$key]['skills'] = self::getAllSkillsFromWork($val['id']);
            $works[$key]['status'] = self::getStatusInfos($val['id_status']);
            $works[$key]['prev_id'] = self::getPreviousID($val['created_at']);
            $works[$key]['next_id'] = self::getNextID($val['created_at']);

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
            $work['prev_id'] = self::getPreviousID($work['created_at']);
            $work['next_id'] = self::getNextID($work['created_at']);
            unset($work['id_status']);
        }

        return $work;
    }

    private function getPreviousID($date)
    {
        $query =
            $this->db
            ->createQueryBuilder()
            ->select($this->app['db.prefix'] . 'work.id')
            ->from($this->app['db.prefix'] . 'work', '')
            ->where('id_status = 1')
            ->andWhere($this->app['db.prefix'] . 'work.created_at < "' . $date . '"')
            ->orderBy('created_at', 'DESC')
            ->setMaxResults(1);
        $id = $this->db->fetchAll($query);
        if (count($id)) return $id[0]['id'];
        return null;
    }

    private function getNextID($date)
    {
        $query =
            $this->db
            ->createQueryBuilder()
            ->select($this->app['db.prefix'] . 'work.id')
            ->from($this->app['db.prefix'] . 'work', '')
            ->where('id_status = 1')
            ->andWhere($this->app['db.prefix'] . 'work.created_at > "' . $date . '"')
            ->orderBy('created_at')
            ->setMaxResults(1);
        $id = $this->db->fetchAll($query);
        if (count($id)) return $id[0]['id'];
        return null;
    }

    private function getAllSkillsFromWork($work_id)
    {
        $query =
            $this->db
            ->createQueryBuilder()
            ->select($this->app['db.prefix'] . 'skill.*')
            ->from($this->app['db.prefix'] . 'skill, ' . $this->app['db.prefix'] . 'works_skills', '')
            ->where($this->app['db.prefix'] . 'works_skills.id_skill = ' . $this->app['db.prefix'] . 'skill.id')
            ->andWhere($this->app['db.prefix'] . "works_skills.id_work = $work_id")
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
            ->from($this->app['db.prefix'] . 'status', '')
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
