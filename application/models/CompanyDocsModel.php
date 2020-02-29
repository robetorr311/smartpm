<?php
defined('BASEPATH') or exit('No direct script access allowed');

class CompanyDocsModel extends CI_Model
{
    private $table = 'company_docs';

    public function allCompanyDocs()
    {
        $this->db->select("company_docs.*, CONCAT(users_created_by.first_name, ' ', users_created_by.last_name, ' (@', users_created_by.username, ')') as created_user_fullname");
        $this->db->from($this->table);
        $this->db->join('users as users_created_by', 'company_docs.created_by=users_created_by.id', 'left');
        $this->db->where('company_docs.is_deleted', FALSE);
        $this->db->order_by('created_at', 'ASC');
        $query = $this->db->get();
        return $query->result();
    }

    public function getCount()
    {
        $this->db->where('is_deleted', FALSE);
        return $this->db->count_all_results($this->table);
    }

    public function getCompanyDocById($id)
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

    public function insertArr($data)
    {
        if (is_array($data) && count($data) > 0) {
            $data = $this->buildCompanyDocsInsertArr($data);
            $insert = $this->db->insert_batch($this->table, $data);
            return $insert;
        } else {
            return false;
        }
    }

    public function delete($id)
    {
        $this->db->where('id', $id);
        return $this->db->update($this->table, [
            'is_deleted' => TRUE
        ]);
    }

    /**
     * Private Methods
     */
    private function buildCompanyDocsInsertArr($data)
    {
        $return = [];
        foreach ($data as $doc) {
            $doc['created_by'] = $this->session->id;
            $return[] = $doc;
        }
        return $return;
    }
}
