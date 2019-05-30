<?php
defined('BASEPATH') or exit('No direct script access allowed');

class TeamUserMapModel extends CI_Model
{
    private $table = 'team_user_map';

    public function insertByUserArr($users, $team_id)
    {
        if (is_array($users) && count($users) > 0) {
            $data = $this->buildByUserArr($users, $team_id);
            $insert = $this->db->insert_batch($this->table, $data);
            return $insert;
        } else {
            return false;
        }
    }

    public function deleteByUserArr($users, $team_id)
    {
        $this->db->where_in('user_id', $users);
        return $this->deleteRelated($team_id);
    }

    public function deleteRelated($team_id)
    {
        $this->db->where('team_id', $team_id);
        return $this->db->update($this->table, [
            'is_deleted' => TRUE
        ]);
    }

    public function getUsersByTeamId($id)
    {
        $this->db->select("users.id as id, users.username as username, CONCAT(users.first_name, ' ', users.last_name) AS name");
        $this->db->from($this->table);
        $this->db->join('users', 'team_user_map.user_id=users.id');
        $this->db->where([
            'team_user_map.team_id' => $id,
            'team_user_map.is_deleted' => FALSE,
            'users.is_deleted' => FALSE
        ]);
        $query = $this->db->get();
        $result = $query->result();
        return (count($result) > 0) ? $result : false;
    }

    /**
     * Private Methods
     */
    private function buildByUserArr($users, $team_id)
    {
        $return = [];
        foreach ($users as $user) {
            $return[] = [
                'team_id' => $team_id,
                'user_id' => $user
            ];
        }
        return $return;
    }
}
