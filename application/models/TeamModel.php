<?php
defined('BASEPATH') or exit('No direct script access allowed');

class TeamModel extends CI_Model
{
    private $table = 'teams';

    public function allTeams()
    {
        $this->db->select("teams.*, (SELECT count(id) FROM team_user_map WHERE team_user_map.team_id = teams.id AND is_deleted = FALSE) as total_members, CONCAT(users_manager.first_name, ' ', users_manager.last_name, ' (@', users_manager.username, ')') as manager_fullname, CONCAT(users_team_leader.first_name, ' ', users_team_leader.last_name, ' (@', users_team_leader.username, ')') as team_leader_fullname");
        $this->db->from($this->table);
        $this->db->join('users as users_manager', 'teams.manager=users_manager.id', 'left');
        $this->db->join('users as users_team_leader', 'teams.team_leader=users_team_leader.id', 'left');
        $this->db->where('teams.is_deleted', FALSE);
        $this->db->order_by('created_at', 'ASC');
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
        $this->db->select("teams.*, CONCAT(users_manager.first_name, ' ', users_manager.last_name, ' (@', users_manager.username, ')') as manager_fullname, CONCAT(users_team_leader.first_name, ' ', users_team_leader.last_name, ' (@', users_team_leader.username, ')') as team_leader_fullname");
        $this->db->from($this->table);
        $this->db->join('users as users_manager', 'teams.manager=users_manager.id', 'left');
        $this->db->join('users as users_team_leader', 'teams.team_leader=users_team_leader.id', 'left');
        $this->db->where([
            'teams.id' => $id,
            'teams.is_deleted' => FALSE
        ]);
        $query = $this->db->get();
        $result = $query->first_row();
        return $result ? $result : false;
    }


    public function getTeamOnly( $condition ){

        $this->db->where($condition);
        $this->db->order_by("id", "desc");
        $result = $this->db->get($this->table);
        return $result->result();   
    }



    public function insert($data)
    {
        $data['created_by'] = $this->session->id;
        $insert = $this->db->insert($this->table, $data);
        return $insert ? $this->db->insert_id() : $insert;
    }

    public function update($id, $data)
    {
        $this->db->where('id', $id);
        $update = $this->db->update($this->table, $data);
        return $update;
    }

    public function delete($id)
    {
        $this->db->where('id', $id);
        return $this->db->update($this->table, [
            'is_deleted' => TRUE
        ]);
    }
}
