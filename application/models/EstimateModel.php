<?php
defined('BASEPATH') or exit('No direct script access allowed');

class EstimateModel extends CI_Model
{
    private $table = 'estimates';

    public function allEstimates()
    {
        $this->db->select("
            estimates.*,
            CONCAT((1600 + client.id), '.', estimate_no) as estimate_number,
            CONCAT(client.firstname, ' ', client.lastname) as client_name,
            (SELECT SUM(amount * items.unit_price) FROM estimate_descriptions LEFT JOIN items as items ON estimate_descriptions.item=items.id WHERE description_group_id IN (SELECT id FROM estimate_description_groups WHERE estimate_id=estimates.id)) as total,
            CONCAT(users_created_by.first_name, ' ', users_created_by.last_name) as created_user
        ");
        $this->db->from($this->table);
        $this->db->join('users as users_created_by', 'estimates.created_by=users_created_by.id', 'left');
        $this->db->join('jobs as client', 'estimates.client_id=client.id', 'left');
        $this->db->where('estimates.is_deleted', FALSE);
        $this->db->order_by('estimates.created_at', 'ASC');
        $query = $this->db->get();
        return $query->result();
    }

    public function allEstimatesByClientId($clientId)
    {
        $this->db->select("
            estimates.*,
            CONCAT((1600 + client.id), '.', estimate_no) as estimate_number,
            CONCAT(client.firstname, ' ', client.lastname) as client_name,
            (SELECT SUM(amount * items.unit_price) FROM estimate_descriptions LEFT JOIN items as items ON estimate_descriptions.item=items.id WHERE description_group_id IN (SELECT id FROM estimate_description_groups WHERE estimate_id=estimates.id)) as total,
            CONCAT(users_created_by.first_name, ' ', users_created_by.last_name) as created_user
        ");
        $this->db->from($this->table);
        $this->db->join('users as users_created_by', 'estimates.created_by=users_created_by.id', 'left');
        $this->db->join('jobs as client', 'estimates.client_id=client.id', 'left');
        $this->db->where('estimates.client_id', $clientId);
        $this->db->where('estimates.is_deleted', FALSE);
        $this->db->order_by('estimates.created_at', 'ASC');
        $query = $this->db->get();
        return $query->result();
    }

    public function getEstimateById($id)
    {
        $this->db->select("
            estimates.*,
            CONCAT((1600 + client.id), '.', estimate_no) as estimate_number,
            CONCAT(client.firstname, ' ', client.lastname) as client_name,
            (SELECT SUM(amount * items.unit_price) FROM estimate_descriptions LEFT JOIN items as items ON estimate_descriptions.item=items.id WHERE description_group_id IN (SELECT id FROM estimate_description_groups WHERE estimate_id=estimates.id)) as total,
            CONCAT(users_created_by.first_name, ' ', users_created_by.last_name) as created_user
        ");
        $this->db->from($this->table);
        $this->db->join('users as users_created_by', 'estimates.created_by=users_created_by.id', 'left');
        $this->db->join('jobs as client', 'estimates.client_id=client.id', 'left');
        $this->db->where('estimates.id', $id);
        $this->db->where('estimates.is_deleted', FALSE);
        $this->db->order_by('estimates.created_at', 'ASC');
        $query = $this->db->get();
        $result = $query->first_row();
        return $result ? $result : false;
    }

    public function getEstimateByClientIdAndId($clientId, $id)
    {
        $this->db->select("
            estimates.*,
            CONCAT((1600 + client.id), '.', estimate_no) as estimate_number,
            CONCAT(client.firstname, ' ', client.lastname) as client_name,
            (SELECT SUM(amount * items.unit_price) FROM estimate_descriptions LEFT JOIN items as items ON estimate_descriptions.item=items.id WHERE description_group_id IN (SELECT id FROM estimate_description_groups WHERE estimate_id=estimates.id)) as total,
            CONCAT(users_created_by.first_name, ' ', users_created_by.last_name) as created_user
        ");
        $this->db->from($this->table);
        $this->db->join('users as users_created_by', 'estimates.created_by=users_created_by.id', 'left');
        $this->db->join('jobs as client', 'estimates.client_id=client.id', 'left');
        $this->db->where('estimates.id', $id);
        $this->db->where('estimates.client_id', $clientId);
        $this->db->where('estimates.is_deleted', FALSE);
        $this->db->order_by('estimates.created_at', 'ASC');
        $query = $this->db->get();
        $result = $query->first_row();
        return $result ? $result : false;
    }

    public function insert($data)
    {
        $this->db->select('MAX(estimate_no)+1 AS next_estimate_no');
        $this->db->from($this->table);
        $this->db->where('client_id', $data['client_id']);
        $query = $this->db->get();
        $result = $query->first_row();
        $estimate_no = ($result && $result->next_estimate_no) ? $result->next_estimate_no : 1;

        $data['estimate_no'] = $estimate_no;
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
