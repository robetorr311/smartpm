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
        4 => 'Needs Estimate / Bid',
        5 => 'Estimate Sent',
        6 => 'Ready to Sign / Verbal Go',
        7 => 'Signed Insurance Contract',
        8 => 'Signed Cash Contract',
        9 => 'Signed Labor Only',
        10 => 'Signed Finance Job',
        11 => 'Worry to Lose',
        12 => 'Postponed',
        13 => 'Dead / Lost'
    ];
    // private static $signedStage = [
    //     0 => 'Ordering / Buy Out',
    //     1 => 'Scheduled',
    //     2 => 'In Process',
    //     3 => 'Complete',
    //     4 => 'Punch List',
    //     5 => 'Closed'
    // ];
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
        $this->db->where_in('status', [0, 1, 2, 3, 4, 5, 6, 12, 13]);
        $this->db->order_by('created_at', 'ASC');
        $this->db->limit($limit, $start);
        $query = $this->db->get();
        return $query->result();
    }

    public function allLeadsByStatus($status, $start = 0, $limit = 10)
    {
        if (!isset(self::$status[$status])) {
            show_404();
        }

        $this->db->from($this->table);
        $this->db->where([
            'is_deleted' => FALSE,
            'status' => $status,
            'signed_stage' => 0
        ]);
        $this->db->where_in('status', [0, 1, 2, 3, 4, 5, 6, 12, 13]);
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
        $this->db->where_in('status', [0, 1, 2, 3, 4, 5, 6, 11, 12]);
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

    public function allFinancialJobs($start = 0, $limit = 10)
    {
        $this->db->from($this->table);
        $this->db->where([
            'is_deleted' => FALSE,
            'signed_stage' => 0,
            'status' => 10
        ]);
        $this->db->order_by('created_at', 'ASC');
        $this->db->limit($limit, $start);
        $query = $this->db->get();
        return $query->result();
    }

    public function getFinancialJobsCount()
    {
        $this->db->where([
            'is_deleted' => FALSE,
            'signed_stage' => 0,
            'status' => 10
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
        $this->db->where_in('status', [7, 8, 9, 10]);
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
        $this->db->where_in('status', [7, 8, 9, 10]);
        return $this->db->count_all_results($this->table);
    }

    public function allCompletedJobs($start = 0, $limit = 10)
    {
        $this->db->from($this->table);
        $this->db->where([
            'is_deleted' => FALSE,
            'signed_stage' => 2
        ]);
        $this->db->where_in('status', [7, 8, 9, 10]);
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
        $this->db->where_in('status', [7, 8, 9, 10]);
        return $this->db->count_all_results($this->table);
    }

    public function allClosedJobs($start = 0, $limit = 10)
    {
        $this->db->from($this->table);
        $this->db->where([
            'is_deleted' => FALSE,
            'signed_stage' => 3
        ]);
        $this->db->where_in('status', [7, 8, 9, 10]);
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
        $this->db->where_in('status', [7, 8, 9, 10]);
        return $this->db->count_all_results($this->table);
    }

    public function allArchivedJobs($start = 0, $limit = 10)
    {
        $this->db->from($this->table);
        $this->db->where([
            'is_deleted' => FALSE,
            'signed_stage' => 4
        ]);
        $this->db->where_in('status', [7, 8, 9, 10]);
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
        $this->db->where_in('status', [7, 8, 9, 10]);
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
        $this->db->select("jobs.*, (SELECT name FROM client_lead_source WHERE id=jobs.lead_source) AS lead_source_name");
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

    public function getDashboardStatusCount()
    {
        $this->db->select("
            COUNT(IF(status=0, 1, NULL)) as new,
            COUNT(IF(status=1, 1, NULL)) as appointment_scheduled,
            COUNT(IF(status=2, 1, NULL)) as follow_up,
            COUNT(IF(status=3, 1, NULL)) as needs_site_visit,
            COUNT(IF(status=4, 1, NULL)) as needs_estimate,
            COUNT(IF(status=5, 1, NULL)) as estimate_sent,
            COUNT(IF(status=6, 1, NULL)) as ready_to_sign,
            COUNT(IF(status=11, 1, NULL)) as worry_to_lose,
            COUNT(IF(status=12, 1, NULL)) as postponed,
            COUNT(IF(signed_stage=1, (CASE WHEN status=7 THEN 1 WHEN status=8 THEN 1 WHEN status=9 THEN 1 ELSE NULL END), NULL)) as production,
            COUNT(IF(signed_stage=2, (CASE WHEN status=7 THEN 1 WHEN status=8 THEN 1 WHEN status=9 THEN 1 ELSE NULL END), NULL)) as completed,
            COUNT(IF(signed_stage=3, (CASE WHEN status=7 THEN 1 WHEN status=8 THEN 1 WHEN status=9 THEN 1 ELSE NULL END), NULL)) as closed,
            COUNT(IF(signed_stage=4, (CASE WHEN status=7 THEN 1 WHEN status=8 THEN 1 WHEN status=9 THEN 1 ELSE NULL END), NULL)) as archive
        ", FALSE);
		$this->db->from($this->table);
        $this->db->where('is_deleted', FALSE);
		$query = $this->db->get();
        $result = $query->first_row();
        return $result ? $result : false;
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
