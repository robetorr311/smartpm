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

    public function update($id, $data)
    {
        $this->db->where('id', $id);
        $update = $this->db->update($this->table, $data);
        return $update;
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
        $this->db->select("
            jobs_note.*,
            CONCAT(users_created_by.first_name, ' ', users_created_by.last_name, ' (@', users_created_by.username, ')') as created_user_fullname,
            IFNULL((SELECT MAX(created_at) FROM jobs_note_reply WHERE is_deleted=false AND note_id=jobs_note.id), jobs_note.created_at) AS last_thread_created_at
        ");
        $this->db->from($this->table);
        $this->db->join('users as users_created_by', 'jobs_note.created_by=users_created_by.id', 'left');
        $this->db->where([
            'jobs_note.job_id' => $id,
            'jobs_note.is_deleted' => FALSE
        ]);
        $this->db->order_by('last_thread_created_at', 'DESC');
        $query = $this->db->get();
        $result = $query->result();
        return (count($result) > 0) ? $result : false;
    }

    public function getNoteById($id, $leadId = false)
    {
        $this->db->select("jobs_note.*, CONCAT(users_created_by.first_name, ' ', users_created_by.last_name, ' (@', users_created_by.username, ')') as created_user_fullname");
        $this->db->from($this->table);
        $this->db->join('users as users_created_by', 'jobs_note.created_by=users_created_by.id', 'left');
        $this->db->where([
            'jobs_note.id' => $id,
            'jobs_note.is_deleted' => FALSE
        ]);
        if ($leadId) {
            $this->db->where('jobs_note.job_id', $leadId);
        }
        $query = $this->db->get();
        $result = $query->first_row();
        return $result ? $result : false;
    }
}
