<?php
defined('BASEPATH') or exit('No direct script access allowed');

class FinancialModel extends CI_Model
{
    private $table = 'financial';

    private static $type = [
        1 => 'Expense',
        2 => 'Payment',
        3 => 'Purchase Order',
        4 => 'Work Order',
        5 => 'Contract Price',
        6 => 'Change Order',
        7 => 'Credit'
    ];

    public function allFinancials()
    {
        $this->db->select("
            financial.*,
            vendors.name as vendor_name,
            CONCAT(client.firstname, ' ', client.lastname) as client_name,
            CONCAT(users_created_by.first_name, ' ', users_created_by.last_name, ' (@', users_created_by.username, ')') as created_user_fullname
        ");
        $this->db->from($this->table);
        $this->db->join('vendors as vendors', 'financial.vendor_id=vendors.id', 'left');
        $this->db->join('jobs as client', 'financial.client_id=client.id', 'left');
        $this->db->join('users as users_created_by', 'financial.created_by=users_created_by.id', 'left');
        $this->db->where('financial.is_deleted', FALSE);
        $this->db->order_by('financial.created_at', 'ASC');
        $query = $this->db->get();
        return $query->result();
    }

    public function getCount()
    {
        $this->db->where('is_deleted', FALSE);
        return $this->db->count_all_results($this->table);
    }

    public function allFinancialsForReceipt($jobId)
    {
        $this->db->from($this->table);
        $this->db->where_in('type', [2, 5, 6, 7]);
        $this->db->where_in('job_id', $jobId);
        $this->db->where('is_deleted', FALSE);
        $this->db->order_by('created_at', 'ASC');
        $query = $this->db->get();
        return $query->result();
    }

    public function getFinancialById($id)
    {
        $this->db->select("
            financial.*,
            vendors.name as vendor_name,
            CONCAT(client.firstname, ' ', client.lastname) as client_name,
            CONCAT(users_created_by.first_name, ' ', users_created_by.last_name, ' (@', users_created_by.username, ')') as created_user_fullname,
            CONCAT((1600 + jobs.id), ' - ', jobs.firstname, ' ', jobs.lastname) as job_fullname,
            method.name as method_name,
            subtype.name as subtype_name,
            accounting_code.name as accounting_code_name,
            bank_account.name as bank_account_name,
            state.name as state_name
        ");
        $this->db->from($this->table);
        $this->db->join('vendors as vendors', 'financial.vendor_id=vendors.id', 'left');
        $this->db->join('jobs as client', 'financial.client_id=client.id', 'left');
        $this->db->join('users as users_created_by', 'financial.created_by=users_created_by.id', 'left');
        $this->db->join('jobs as jobs', 'financial.job_id=jobs.id', 'left');
        $this->db->join('financial_methods as method', 'financial.method=method.id', 'left');
        $this->db->join('financial_subtypes as subtype', 'financial.subtype=subtype.id', 'left');
        $this->db->join('financial_acc_codes as accounting_code', 'financial.accounting_code=accounting_code.id', 'left');
        $this->db->join('financial_bank_accs as bank_account', 'financial.bank_account=bank_account.id', 'left');
        $this->db->join('states as state', 'financial.state=state.id', 'left');
        $this->db->where([
            'financial.id' => $id,
            'financial.is_deleted' => FALSE
        ]);
        $query = $this->db->get();
        $result = $query->first_row();
        return $result ? $result : false;
    }

    public function getContractDetailsByJobId($job_id)
    {
        $this->db->select("
            MIN(transaction_date) AS contract_date,
            SUM(amount) AS contract_total
        ");
        $this->db->from($this->table);
        $this->db->where_in('type', [5, 6]);
        $this->db->where([
            'job_id' => $job_id,
            'is_deleted' => FALSE
        ]);
        $query = $this->db->get();
        $result = $query->first_row();
        return $result ? $result : false;
    }

    public function insert($data)
    {
        $data['week'] = date('W', strtotime($data['transaction_date']));
        $data['created_by'] = $this->session->id;
        $insert = $this->db->insert($this->table, $data);
        return $insert ? $this->db->insert_id() : $insert;
    }

    public function update($id, $data)
    {
        $data['week'] = date('W', strtotime($data['transaction_date']));
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

    /**
     * Static Methods
     */

    public static function typeToStr($id)
    {
        return isset(self::$type[$id]) ? self::$type[$id] : $id;
    }

    public static function getType()
    {
        return self::$type;
    }
}
