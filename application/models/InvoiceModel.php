<?php
defined('BASEPATH') or exit('No direct script access allowed');

class InvoiceModel extends CI_Model
{
    private $table = 'invoices';

    public function allInvoices()
    {
        $this->db->select("
            invoices.*,
            CONCAT(client.firstname, ' ', client.lastname) as client_name,
            (SELECT SUM(amount) FROM invoice_items WHERE invoice_id=invoices.id) as total,
            CONCAT(users_created_by.first_name, ' ', users_created_by.last_name) as created_user
        ");
        $this->db->from($this->table);
        $this->db->join('users as users_created_by', 'invoices.created_by=users_created_by.id', 'left');
        $this->db->join('jobs as client', 'invoices.client_id=client.id', 'left');
        $this->db->where('invoices.is_deleted', FALSE);
        $this->db->order_by('invoices.created_at', 'DESC');
        $query = $this->db->get();
        return $query->result();
    }

    public function allInvoicesByClientId($clientId)
    {
        $this->db->where('invoices.client_id', $clientId);
        return $this->allInvoices();
    }

    public function getInvoiceById($id)
    {
        $this->db->select("
            invoices.*,
            CONCAT(client.firstname, ' ', client.lastname) as client_name,
            (SELECT SUM(amount) FROM invoice_items WHERE invoice_id=invoices.id) as total,
            CONCAT(users_created_by.first_name, ' ', users_created_by.last_name) as created_user
        ");
        $this->db->from($this->table);
        $this->db->join('users as users_created_by', 'invoices.created_by=users_created_by.id', 'left');
        $this->db->join('jobs as client', 'invoices.client_id=client.id', 'left');
        $this->db->where('invoices.id', $id);
        $this->db->where('invoices.is_deleted', FALSE);
        $this->db->order_by('invoices.created_at', 'DESC');
        $query = $this->db->get();
        $result = $query->first_row();
        return $result ? $result : false;
    }

    public function getInvoiceByClientIdAndId($clientId, $id)
    {
        $this->db->where('invoices.client_id', $clientId);
        return $this->getInvoiceById($id);
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
