<?php
defined('BASEPATH') or exit('No direct script access allowed');

class LeadNoteModel extends CI_Model
{
    private $table = 'jobs_note';

    public function insert($data)
    {
        $data['created_by'] = $this->session->id;
        $insert = $this->db->insert($this->table, $data);
        return $insert ? $this->db->insert_id() : $insert;
    }

    public function delete($id, $lead_id = false)
    {
        $this->db->where('id', $id);
        if ($lead_id) {
            $this->db->where('job_id', $lead_id);
        }
        return $this->db->update($this->table, [
            'is_deleted' => TRUE
        ]);
    }

    // public function deleteRelated($lead_id)
    // {
    //     $this->db->where('job_id', $lead_id);
    //     return $this->db->update($this->table, [
    //         'is_deleted' => TRUE
    //     ]);
    // }

    public function getNotesByLeadId($id)
    {
        $this->db->select("jobs_note.*, CONCAT(users_created_by.first_name, ' ', users_created_by.last_name, ' (@', users_created_by.username, ')') as created_user_fullname");
        $this->db->from($this->table);
        $this->db->join('users as users_created_by', 'jobs_note.created_by=users_created_by.id', 'left');
        $this->db->where([
            'jobs_note.job_id' => $id,
            'jobs_note.is_deleted' => FALSE
        ]);
        $query = $this->db->get();
        $result = $query->result();
        return (count($result) > 0) ? $result : false;
    }
}
