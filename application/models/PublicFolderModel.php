<?php
defined('BASEPATH') or exit('No direct script access allowed');

class PublicFolderModel extends CI_Model
{
    private $table = 'public_folders';

    public function allPublicFilesByJobId($job_id)
    {
        $this->db->from($this->table);
        $this->db->where([
            'job_id' => $job_id,
            'is_deleted' => FALSE
        ]);
        $query = $this->db->get();
        return $query->result();
    }

    public function getFileByPublicKey($company_code, $public_key)
    {
        $this->db->from('smartpm_' . $company_code . '.' . $this->table);
        $this->db->where([
            'public_key' => $public_key,
            'is_deleted' => FALSE
        ]);
        $query = $this->db->get();
        $result = $query->first_row();
        return $result ? $result : false;
    }

    public function insert($data)
    {
        $insert = $this->db->insert($this->table, $data);
        $id = $insert ? $this->db->insert_id() : $insert;
        if ($id) {
            $update = $this->update($id, [
                'public_key' => $this->generatePublicKey($id)
            ]);
        }
        return $id;
    }

    public function update($id, $data)
    {
        $this->db->where('id', $id);
        $update = $this->db->update($this->table, $data);
        return $update;
    }

    public function delete($id)
    {
        return $this->update($id, [
            'is_deleted' => TRUE
        ]);
    }

    /**
     * Private Methods
     */
    private function generatePublicKey($id)
    {
        $md5Key1 = md5(time());
        $md5Key2 = md5($id);
        return $md5Key1 . $id . $md5Key2;
    }
}
