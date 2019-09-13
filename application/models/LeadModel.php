<?php
defined('BASEPATH') or exit('No direct script access allowed');

class LeadModel extends CI_Model
{
    private $table = 'jobs';

    private static $status = [
        0 => 'New',
        1 => 'Appointment Scheduled',
        2 => 'Needs Follow Up Call',
        3 => 'Needs Site Visit',
        4 => 'Needs Estimate/Bid',
        5 => 'Estimate Sent',
        6 => 'Ready to Sign / Verbal Go',
        7 => 'Signed Insurance Contract',
        8 => 'Signed Cash Contract',
        9 => 'Signed Labor Only',
        10 => 'Worry to Lose',
        11 => 'Postponed',
        12 => 'Dead / Lost'
    ];
    private static $type = [
        0 => 'Undefined / None',
        1 => 'Residential',
        2 => 'Commercial',
        3 => 'Government',
        4 => 'Industrial',
        5 => 'Repair'
    ];

    public function allLeads($start = 0, $limit = 10)
    {
        $this->db->from($this->table);
        $this->db->where([
            'is_deleted' => FALSE,
            'signed_stage' => 0
        ]);
        $this->db->where_in('status', [0, 1, 2, 3, 4, 5, 6, 10, 11]);
        $this->db->order_by('created_at', 'ASC');
        $this->db->limit($limit, $start);
        $query = $this->db->get();
        return $query->result();
    }

    public function getLeadsCount()
    {
        $this->db->where([
            'is_deleted' => FALSE,
            'signed_stage' => 0
        ]);
        $this->db->where_in('status', [0, 1, 2, 3, 4, 5, 6, 10, 11]);
        return $this->db->count_all_results($this->table);
    }

    public function allJobs($start = 0, $limit = 10)
    {
        $this->db->from($this->table);
        $this->db->where([
            'is_deleted' => FALSE
        ]);
        $this->db->order_by('created_at', 'ASC');
        $this->db->limit($limit, $start);
        $query = $this->db->get();
        return $query->result();
    }

    public function getJobsCount()
    {
        $this->db->where([
            'is_deleted' => FALSE
        ]);
        return $this->db->count_all_results($this->table);
    }

    public function allCashJobs($start = 0, $limit = 10)
    {
        $this->db->from($this->table);
        $this->db->where([
            'is_deleted' => FALSE,
            'signed_stage' => 0,
            'status' => 8
        ]);
        $this->db->order_by('created_at', 'ASC');
        $this->db->limit($limit, $start);
        $query = $this->db->get();
        return $query->result();
    }

    public function getCashJobsCount()
    {
        $this->db->where([
            'is_deleted' => FALSE,
            'signed_stage' => 0,
            'status' => 8
        ]);
        return $this->db->count_all_results($this->table);
    }

    public function allInsuranceJobs($start = 0, $limit = 10)
    {
        $this->db->from($this->table);
        $this->db->where([
            'is_deleted' => FALSE,
            'signed_stage' => 0,
            'status' => 7
        ]);
        $this->db->order_by('created_at', 'ASC');
        $this->db->limit($limit, $start);
        $query = $this->db->get();
        return $query->result();
    }

    public function getInsuranceJobsCount()
    {
        $this->db->where([
            'is_deleted' => FALSE,
            'signed_stage' => 0,
            'status' => 7
        ]);
        return $this->db->count_all_results($this->table);
    }

    public function allLaborOnlyJobs($start = 0, $limit = 10)
    {
        $this->db->from($this->table);
        $this->db->where([
            'is_deleted' => FALSE,
            'signed_stage' => 0,
            'status' => 9
        ]);
        $this->db->order_by('created_at', 'ASC');
        $this->db->limit($limit, $start);
        $query = $this->db->get();
        return $query->result();
    }

    public function getLaborOnlyJobsCount()
    {
        $this->db->where([
            'is_deleted' => FALSE,
            'signed_stage' => 0,
            'status' => 9
        ]);
        return $this->db->count_all_results($this->table);
    }

    public function allProductionJobs($start = 0, $limit = 10)
    {
        $this->db->from($this->table);
        $this->db->where([
            'is_deleted' => FALSE,
            'signed_stage' => 1
        ]);
        $this->db->where_in('status', [7, 8, 9]);
        $this->db->order_by('created_at', 'ASC');
        $this->db->limit($limit, $start);
        $query = $this->db->get();
        return $query->result();
    }

    public function getProductionJobsCount()
    {
        $this->db->where([
            'is_deleted' => FALSE,
            'signed_stage' => 1
        ]);
        $this->db->where_in('status', [7, 8, 9]);
        return $this->db->count_all_results($this->table);
    }

    public function allCompletedJobs($start = 0, $limit = 10)
    {
        $this->db->from($this->table);
        $this->db->where([
            'is_deleted' => FALSE,
            'signed_stage' => 2
        ]);
        $this->db->where_in('status', [7, 8, 9]);
        $this->db->order_by('created_at', 'ASC');
        $this->db->limit($limit, $start);
        $query = $this->db->get();
        return $query->result();
    }

    public function getCompletedJobsCount()
    {
        $this->db->where([
            'is_deleted' => FALSE,
            'signed_stage' => 2
        ]);
        $this->db->where_in('status', [7, 8, 9]);
        return $this->db->count_all_results($this->table);
    }

    public function getLeadById($id)
    {
        $this->db->where([
            'id' => $id
        ]);
        $query = $this->db->get($this->table);
        $result = $query->first_row();
        return $result ? $result : false;
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
        return $this->update($id, [
            'is_deleted' => TRUE
        ]);
    }

    /**
     * ***********************************
     * ***********************************
     * 
     * OLD CODES FROM THIS COMMENT ONWARDS
     * 
     * ***********************************
     * ***********************************
     */

    public function getAllSignedJob($start = 0, $limit = 10)
    {
        // $this->db->select('jobs.*, jobs_status.*');
        $this->db->from($this->table);
        // $this->db->join('jobs_status', 'jobs.id=jobs_status.jobid', 'left');
        // $this->db->where([
        //     'jobs_status.lead' => 'open', 'jobs_status.contract' => 'signed'
        // ]);
        $this->db->order_by('jobs.id', 'ASC');
        $this->db->limit($limit, $start);
        $query = $this->db->get();
        return $query->result();
    }

    public function getSignedJobCount()
    {
        // $this->db->where(['contract' => 'signed']);
        // return $this->db->count_all_results('jobs_status');
        return $this->db->count_all_results($this->table);
    }

    public function get_all_where($tablename, $condition)
    {
        $this->db->where($condition);
        $this->db->order_by("id", "desc");
        $result = $this->db->get($tablename);
        return $result->result();
    }

    public function getClosedJob($start = 0, $limit = 10)
    {
        $this->db->select('jobs.*, jobs.id as lead_status, jobs.id as job_type, jobs.id as contract_status, jobs.id as date');
        // $this->db->select('jobs.*, status.lead as lead_status, status.job as job_type, status.contract as contract_status, status.close_at as date');
        $this->db->from($this->table);
        // $this->db->join('jobs_status as status', 'jobs.id=status.jobid', 'left');
        // $this->db->where([
        //     'status.closeout' => 'yes'
        // ]);
        $this->db->order_by('id', 'ASC');
        $this->db->limit($limit, $start);
        $query = $this->db->get();
        return $query->result();
    }

    public function getCountClosedJob()
    {
        // $this->db->where(['closeout' => 'yes']);
        // return $this->db->count_all_results('jobs_status');
        return $this->db->count_all_results($this->table);
    }

    /**
     * Static Methods
     */
    public static function statusToStr($id)
    {
        return isset(self::$status[$id]) ? self::$status[$id] : $id;
    }

    public static function getStatus()
    {
        return self::$status;
    }

    public static function typeToStr($id)
    {
        return isset(self::$type[$id]) ? self::$type[$id] : $id;
    }

    public static function getType()
    {
        return self::$type;
    }
}
