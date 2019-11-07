<?php
defined('BASEPATH') or exit('No direct script access allowed');

class FinancialModel extends CI_Model
{
    private $table = 'financial';

    public function allFinancialWithLeads($start = 0, $limit = 10)
    {
        $this->db->select("
            financial.*,
            CONCAT(users_sales_rep.first_name, ' ', users_sales_rep.last_name, ' (@', users_sales_rep.username, ')') as sales_rep_fullname,
            type.name as type_name
        ");
        $this->db->from($this->table);
        $this->db->join('users as users_sales_rep', 'financial.sales_rep=users_sales_rep.id', 'left');
        $this->db->join('financial_types as type', 'financial.type=type.id', 'left');
        $this->db->where('financial.is_deleted', FALSE);
        $this->db->order_by('financial.created_at', 'ASC');
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
        $this->db->select("
            financial.*,
            CONCAT(users_sales_rep.first_name, ' ', users_sales_rep.last_name, ' (@', users_sales_rep.username, ')') as sales_rep_fullname,
            CONCAT(users_created_by.first_name, ' ', users_created_by.last_name, ' (@', users_created_by.username, ')') as created_user_fullname,
            CONCAT('RJOB',  jobs.id, ' - ', jobs.firstname, ' ', jobs.lastname) as job_fullname,
            type.name as type_name,
            method.name as method_name,
            subtype.name as subtype_name,
            accounting_code.name as accounting_code_name,
            bank_account.name as bank_account_name,
            state.name as state_name
        ");
        $this->db->from($this->table);
        $this->db->join('users as users_sales_rep', 'financial.sales_rep=users_sales_rep.id', 'left');
        $this->db->join('users as users_created_by', 'financial.created_by=users_created_by.id', 'left');
        $this->db->join('jobs as jobs', 'financial.job_id=jobs.id', 'left');
        $this->db->join('financial_types as type', 'financial.type=type.id', 'left');
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
}
