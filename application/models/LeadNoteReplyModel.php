<?php
defined('BASEPATH') or exit('No direct script access allowed');

class LeadNoteReplyModel extends CI_Model
{
    private $table = 'jobs_note_reply';

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

    public function delete($id, $note_id = false)
    {
        $this->db->where('id', $id);
        if ($note_id) {
            $this->db->where('note_id', $note_id);
        }
        return $this->db->update($this->table, [
            'is_deleted' => TRUE
        ]);
    }

    // public function deleteRelated($note_id)
    // {
    //     $this->db->where('note_id', $note_id);
    //     return $this->db->update($this->table, [
    //         'is_deleted' => TRUE
    //     ]);
    // }

    public function getRepliesByNoteId($id)
    {
        $this->db->select("jobs_note_reply.*, CONCAT(users_created_by.first_name, ' ', users_created_by.last_name, ' (@', users_created_by.username, ')') as created_user_fullname");
        $this->db->from($this->table);
        $this->db->join('users as users_created_by', 'jobs_note_reply.created_by=users_created_by.id', 'left');
        $this->db->where([
            'jobs_note_reply.note_id' => $id,
            'jobs_note_reply.is_deleted' => FALSE
        ]);
        $this->db->order_by('jobs_note_reply.created_at', 'DESC');
        $query = $this->db->get();
        $result = $query->result();
        return (count($result) > 0) ? $result : false;
    }
}
