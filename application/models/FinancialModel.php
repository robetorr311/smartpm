<?php
defined('BASEPATH') or exit('No direct script access allowed');

class FinancialModel extends CI_Model
{
    private $table = 'financial';

    /** Public Variables for Testing */
    public $types = [
        1 => 'Type 1',
        2 => 'Type 2',
        3 => 'Type 3'
    ];

    public $subTypes = [
        1 => 'Sub Type 1',
        2 => 'Sub Type 2',
        3 => 'Sub Type 3'
    ];

    public $accountingCodes = [
        1 => 'Acc Code 1',
        2 => 'Acc Code 2',
        3 => 'Acc Code 3'
    ];

    public $methods = [
        1 => 'Method 1',
        2 => 'Method 2',
        3 => 'Method 3'
    ];

    public $bankAccounts = [
        1 => '12345600025 - THE BANK ACCOUNT 1',
        2 => '12345600025 - THE BANK ACCOUNT 2',
        3 => '12345600025 - THE BANK ACCOUNT 3'
    ];

    public $states = [
        1 => 'State 1',
        2 => 'State 2',
        3 => 'State 3'
    ];
    /** Public Variables for Testing */

    public function allFinancialWithLeads($start = 0, $limit = 10)
    {
        $this->db->select("financial.*, CONCAT(users_sales_rep.first_name, ' ', users_sales_rep.last_name, ' (@', users_sales_rep.username, ')') as sales_rep_fullname");
        $this->db->from($this->table);
        $this->db->join('users as users_sales_rep', 'financial.sales_rep=users_sales_rep.id', 'left');
        $this->db->where('financial.is_deleted', FALSE);
        $this->db->order_by('created_at', 'ASC');
        $this->db->limit($limit, $start);
        $query = $this->db->get();
        return $query->result();
    }

    public function getCount()
    {
        $this->db->where('is_deleted', FALSE);
        return $this->db->count_all_results($this->table);
    }

    public function getFinancialById($id)
    {
        $this->db->select("financial.*, CONCAT(users_sales_rep.first_name, ' ', users_sales_rep.last_name, ' (@', users_sales_rep.username, ')') as sales_rep_fullname, CONCAT(users_created_by.first_name, ' ', users_created_by.last_name, ' (@', users_created_by.username, ')') as created_user_fullname, CONCAT('RJOB',  jobs.id, ' - ', jobs.firstname, ' ', jobs.lastname) as job_fullname");
        $this->db->from($this->table);
        $this->db->join('users as users_sales_rep', 'financial.sales_rep=users_sales_rep.id', 'left');
        $this->db->join('users as users_created_by', 'financial.created_by=users_created_by.id', 'left');
        $this->db->join('jobs as jobs', 'financial.job_id=jobs.id', 'left');
        $this->db->where([
            'financial.id' => $id,
            'financial.is_deleted' => FALSE
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
}
