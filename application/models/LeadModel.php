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

    public function allClosedJobs($start = 0, $limit = 10)
    {
        $this->db->from($this->table);
        $this->db->where([
            'is_deleted' => FALSE,
            'signed_stage' => 3
        ]);
        $this->db->where_in('status', [7, 8, 9]);
        $this->db->order_by('created_at', 'ASC');
        $this->db->limit($limit, $start);
        $query = $this->db->get();
        return $query->result();
    }

    public function getClosedJobsCount()
    {
        $this->db->where([
            'is_deleted' => FALSE,
            'signed_stage' => 3
        ]);
        $this->db->where_in('status', [7, 8, 9]);
        return $this->db->count_all_results($this->table);
    }

    public function allArchivedJobs($start = 0, $limit = 10)
    {
        $this->db->from($this->table);
        $this->db->where([
            'is_deleted' => FALSE,
            'signed_stage' => 4
        ]);
        $this->db->where_in('status', [7, 8, 9]);
        $this->db->order_by('created_at', 'ASC');
        $this->db->limit($limit, $start);
        $query = $this->db->get();
        return $query->result();
    }

    public function getArchivedJobsCount()
    {
        $this->db->where([
            'is_deleted' => FALSE,
            'signed_stage' => 4
        ]);
        $this->db->where_in('status', [7, 8, 9]);
        return $this->db->count_all_results($this->table);
    }

    public function getLeadList($select = "id, CONCAT(firstname, ' ', lastname) AS name")
    {
		$this->db->select($select);
		$this->db->from($this->table);
        $this->db->where('is_deleted', FALSE);
		$query = $this->db->get();
		return $query->result();
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
