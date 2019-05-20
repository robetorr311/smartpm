<?php
defined('BASEPATH') or exit('No direct script access allowed');

class TeamModel extends CI_Model
{
    private $table = 'teams';

    public function allTeams($start, $limit)
    {
        $this->db->select('teams.*, (SELECT count(id) FROM team_user_map WHERE team_user_map.team_id = teams.id AND is_deleted = FALSE) as total_members');
        $this->db->from($this->table);
        $this->db->where('is_deleted', FALSE);
        $this->db->order_by('created_at', 'ASC');
        $this->db->limit($limit, $start);
        $query = $this->db->get();
        return $query->result();
    }

    public function getCount()
    {
        $this->db->where('is_deleted', FALSE);
        return $this->db->count_all_results($this->table);
    }

    public function getTeamById($id)
    {
        $this->db->from($this->table);
        $this->db->where([
            'id' => $id,
            'is_deleted' => FALSE
        ]);
        $query = $this->db->get();
        $result = $query->first_row();
        return $result ? $result : false;
    }

    public function insert($data)
    {
        $insert = $this->db->insert($this->table, $data);
        return $insert ? $this->db->insert_id() : $insert;
    }

    public function update_record($updatedArray, $condition)
    {
        $this->db->where($condition);
        $this->db->update($this->table, $updatedArray);
        if ($this->db->affected_rows() > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function delete($condition)
    {
        $this->db->where($condition);
        return  $this->db->update($this->table, ['is_active' => 0]);
    }
}
