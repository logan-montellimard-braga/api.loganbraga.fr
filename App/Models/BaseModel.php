<?php

namespace App\Models;

class BaseModel
{
    protected $db;
    protected $tableName;

    protected function __construct(\Silex\Application $app, $name)
    {
        $this->db = $app['db'];
        $this->tableName = $app['db.prefix'] . $name;
    }

    public function findAll()
    {
        $query =
            $this->db
            ->createQueryBuilder()
            ->select('*')
            ->from($this->tableName, '')
            ->orderBy('created_at', 'DESC')
            ->setMaxResults(20);

        $results = $this->db->fetchAll($query);
        $this->db->close();
        return $results;
    }

    public function find($id)
    {
        $query =
            $this->db
            ->createQueryBuilder()
            ->select('*')
            ->from($this->tableName, '')
            ->where("id = $id");
        $result = $this->db->fetchAssoc($query);
        $this->db->close();

        return $result;
    }

    public function insert($params)
    {
        $allowed = $this->getAllowedParams();
        $prs = array_intersect_key($params, $allowed);
        $missing = array();
        foreach ($allowed as $key => $required){
            if ($required && !isset($prs[$key]))
                $missing[] = $key;
        }

        if (count($missing) > 0)
            return array('missing' => $missing);

        $number = $this->db->insert($this->tableName, $prs);
        $this->db->close();

        return $number;
    }

    public function update($id, $params)
    {
        $prs = array_intersect_key($params, $this->getAllowedParams());
        $prs['modified_at'] = date("Y-m-d H:i:s");
        $number = $this->db->update($this->tableName, $prs, array('id' => $id));
        $this->db->close();

        return $number;
    }

    public function delete($id)
    {
        $number = $this->db->delete($this->tableName, array('id' => $id));
        $this->db->close();

        return $number;
    }

    protected function getAllowedParams()
    {
        throw new \Exception(__METHOD__ . ' not implemented in child class.');
    }
}
