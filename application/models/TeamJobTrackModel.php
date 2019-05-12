<?php
defined('BASEPATH') or exit('No direct script access allowed');

class TeamJobTrackModel extends CI_Model
{
    private $table = 'team_job_track';

   	public function get_all_where( $condition ){
        $this->db->where($condition);
		$result = $this->db->get($this->table);
		return $result->result();	
	}

     public function getTeamName($condition){
        $this->db->select('team_job_track.*, team.team_name as name');
        $this->db->from($this->table);
        $this->db->join('teams as team', 'team_job_track.team_id=team.id', 'left');
         $this->db->where(['team_job_track.job_id'=>$condition,
                          'is_deleted'=>FALSE
                        ]);
        $query = $this->db->get();
        return $query->result(); 
    }

    public function update_record($updatedArray, $condition){
        $this->db->where($condition);
        $this->db->update($this->table, $updatedArray);
        if ( $this->db->affected_rows() > 0 ) {
            return TRUE;
        } else {
            return FALSE;  
        }
    }


    public function add_record( $array ){
    
        $this->db->insert($this->table, $array);
        
        if ($this->db->affected_rows() > 0) {
            return $this->db->insert_id();
        } else {
            return false; 
        }
    }

    public function remove_team($condition){
        $this->db->where(['job_id'=>$condition,'is_deleted'=>FALSE]);
        $this->db->update($this->table, ['end_date'=>date('Y-m-d h:i:s'),'is_deleted'=>TRUE]);
        if ( $this->db->affected_rows() > 0 ) {
            return TRUE;
        } else {
            return FALSE;  
        }
    }

}
