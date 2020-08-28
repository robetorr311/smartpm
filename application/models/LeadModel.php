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
        7 => 'Signed',
        8 => 'In Production',
        9 => 'Completed',
        10 => 'Closed',
        11 => 'Archive',
        12 => 'Cold',
        13 => 'Postponed',
        14 => 'Dead / Lost',
        15 => 'Punch List'
    ];
    private static $status_lead = [0, 1, 2, 3, 4];
    private static $status_prospect = [5, 6, 12, 13, 14];
    private static $status_job = [7, 8, 9, 10, 11];
    private static $type = [
        0 => 'Undefined / None',
        1 => 'Residential',
        2 => 'Commercial',
        3 => 'Government',
        4 => 'Industrial',
        5 => 'Repair'
    ];
    private static $category = [
        0 => 'Insurance Jobs',
        1 => 'Cash Jobs',
        2 => 'Labor Only Jobs',
        3 => 'Financial Jobs'
    ];
    private static $dumpsterStatus = [
        1 => 'Ordered',
        2 => 'Delivered',
        3 => 'Removed'
    ];
    private static $materialStatus = [
        1 => 'Ordered',
        2 => 'Delivered',
        3 => 'Removed'
    ];
    private static $laborStatus = [
        1 => 'Scheduled',
        2 => 'Complete',
        3 => 'Approved'
    ];
    private static $permitStatus = [
        1 => 'Applied',
        2 => 'Received',
        3 => 'Posted'
    ];

    public function allLeads()
    {
        $this->db->from($this->table);
        $this->db->where([
            'is_deleted' => FALSE
        ]);
        $this->db->where_in('status', [0, 1, 2, 3, 4, 5, 6, 13, 14]);
        $this->db->order_by('created_at', 'DESC');
        $query = $this->db->get();
        return $query->result();
    }

    public function allLeadsByStatus($status)
    {
        if (!isset(self::$status[$status])) {
            show_404();
        }

        $this->db->from($this->table);
        $this->db->where([
            'is_deleted' => FALSE,
            'status' => $status
        ]);
        $this->db->order_by('created_at', 'DESC');
        $query = $this->db->get();
        return $query->result();
    }

    public function allJobs()
    {
        $this->db->from($this->table);
        $this->db->where([
            'is_deleted' => FALSE
        ]);
        $this->db->order_by('created_at', 'DESC');
        $query = $this->db->get();
        return $query->result();
    }

    public function allSignedJobs()
    {
        $this->db->from($this->table);
        $this->db->where([
            'status' => 7,
            'is_deleted' => FALSE
        ]);
        $this->db->order_by('created_at', 'DESC');
        $query = $this->db->get();
        return $query->result();
    }

    public function allCashJobs()
    {
        $this->db->from($this->table);
        $this->db->where([
            'is_deleted' => FALSE,
            'category' => 1
        ]);
        $this->db->order_by('created_at', 'DESC');
        $query = $this->db->get();
        return $query->result();
    }

    public function allInsuranceJobs()
    {
        $this->db->from($this->table);
        $this->db->where([
            'is_deleted' => FALSE,
            'category' => 0
        ]);
        $this->db->order_by('created_at', 'DESC');
        $query = $this->db->get();
        return $query->result();
    }

    public function allLaborOnlyJobs()
    {
        $this->db->from($this->table);
        $this->db->where([
            'is_deleted' => FALSE,
            'category' => 2
        ]);
        $this->db->order_by('created_at', 'DESC');
        $query = $this->db->get();
        return $query->result();
    }

    public function allFinancialJobs()
    {
        $this->db->from($this->table);
        $this->db->where([
            'is_deleted' => FALSE,
            'category' => 3
        ]);
        $this->db->order_by('created_at', 'DESC');
        $query = $this->db->get();
        return $query->result();
    }

    public function allProductionJobs()
    {
        $this->db->from($this->table);
        $this->db->where([
            'is_deleted' => FALSE,
            'status' => 8
        ]);
        $this->db->order_by('created_at', 'DESC');
        $query = $this->db->get();
        return $query->result();
    }

    public function allCompletedJobs()
    {
        $this->db->from($this->table);
        $this->db->where([
            'is_deleted' => FALSE,
            'status' => 9
        ]);
        $this->db->order_by('created_at', 'DESC');
        $query = $this->db->get();
        return $query->result();
    }

    public function allClosedJobs()
    {
        $this->db->from($this->table);
        $this->db->where([
            'is_deleted' => FALSE,
            'status' => 10
        ]);
        $this->db->order_by('created_at', 'DESC');
        $query = $this->db->get();
        return $query->result();
    }

    public function allArchivedJobs()
    {
        $this->db->from($this->table);
        $this->db->where([
            'is_deleted' => FALSE,
            'status' => 11
        ]);
        $this->db->order_by('created_at', 'DESC');
        $query = $this->db->get();
        return $query->result();
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
        $this->db->select("
            jobs.*,
            (SELECT name FROM client_lead_source WHERE id=jobs.lead_source) AS lead_source_name,
            (SELECT name FROM client_classification WHERE id=jobs.classification) AS classification_name,
            CONCAT(users_sales_rep.first_name, ' ', users_sales_rep.last_name, ' (@', users_sales_rep.username, ')') AS sales_rep_name
        ");
        $this->db->from($this->table);
        $this->db->join('users as users_sales_rep', 'jobs.sales_rep_id=users_sales_rep.id', 'left');
        $this->db->where([
            'jobs.id' => $id,
            'jobs.is_deleted' => FALSE
        ]);
        $query = $this->db->get();
        $result = $query->first_row();
        return $result ? $result : false;
    }

    public function getNextLeadAfterId($lead_status, $lead_id, $category_id = null)
    {
        $this->db->select("jobs.id");
        $this->db->where([
            'id > ' => $lead_id,
            'status' => $lead_status,
            'is_deleted' => FALSE
        ]);
        if ($category_id !== null) $this->db->where('category', $category_id);
        $this->db->order_by('id', 'ASC');
        $this->db->limit(1);
        $query = $this->db->get($this->table);
        $result = $query->first_row();
        return $result ? $result : false;
    }

    public function getPreviousLeadAfterId($lead_status, $lead_id, $category_id = null)
    {
        $this->db->select("jobs.id");
        $this->db->where([
            'id < ' => $lead_id,
            'status' => $lead_status,
            'is_deleted' => FALSE
        ]);
        if ($category_id !== null) $this->db->where('category', $category_id);
        $this->db->order_by('id', 'DESC');
        $this->db->limit(1);
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
            COUNT(IF(status=7, 1, NULL)) as signed,
            COUNT(IF(status=8, 1, NULL)) as production,
            COUNT(IF(status=9, 1, NULL)) as completed,
            COUNT(IF(status=10, 1, NULL)) as closed,
            COUNT(IF(status=11, 1, NULL)) as archive,
            COUNT(IF(status=12, 1, NULL)) as cold,
            COUNT(IF(status=13, 1, NULL)) as postponed,
            COUNT(IF(status=14, 1, NULL)) as lostLeads,
            COUNT(IF(status=15, 1, NULL)) as punchList
        ", FALSE);
        $this->db->from($this->table);
        $this->db->where('is_deleted', FALSE);
        $query = $this->db->get();
        $result = $query->first_row();
        return $result ? $result : false;
    }

    public function search($keywords)
    {
        if (count($keywords) <= 0) {
            return [];
        }
        $this->db->select("id, firstname, lastname, address, city, state, zip, phone1, phone2, email, status, category");
        $this->db->from($this->table);
        $this->db->where([
            'is_deleted' => FALSE
        ]);
        $this->db->group_start();
        foreach ($keywords as $k) {
            $this->db->or_like('id', $k);
            $this->db->or_like('firstname', $k);
            $this->db->or_like('lastname', $k);
            $this->db->or_like('address', $k);
            $this->db->or_like('city', $k);
            $this->db->or_like('state', $k);
            $this->db->or_like('zip', $k);
            $this->db->or_like('phone1', $k);
            $this->db->or_like('phone2', $k);
            $this->db->or_like('email', $k);
        }
        $this->db->group_end();
        $this->db->order_by('created_at', 'DESC');
        $query = $this->db->get();
        return $query->result();
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

    public static function getStatusLead()
    {
        return self::$status_lead;
    }

    public static function getStatusProspect()
    {
        return self::$status_prospect;
    }

    public static function getStatusJob()
    {
        return self::$status_job;
    }

    public static function typeToStr($id)
    {
        return isset(self::$type[$id]) ? self::$type[$id] : $id;
    }

    public static function getType()
    {
        return self::$type;
    }

    public static function categoryToStr($id)
    {
        return isset(self::$category[$id]) ? self::$category[$id] : $id;
    }

    public static function getCategory()
    {
        return self::$category;
    }

    public static function dumpsterStatusToStr($id)
    {
        return isset(self::$dumpsterStatus[$id]) ? self::$dumpsterStatus[$id] : $id;
    }

    public static function getDumpsterStatus()
    {
        return self::$dumpsterStatus;
    }

    public static function materialStatusToStr($id)
    {
        return isset(self::$materialStatus[$id]) ? self::$materialStatus[$id] : $id;
    }

    public static function getMaterialStatus()
    {
        return self::$materialStatus;
    }

    public static function laborStatusToStr($id)
    {
        return isset(self::$laborStatus[$id]) ? self::$laborStatus[$id] : $id;
    }

    public static function getLaborStatus()
    {
        return self::$laborStatus;
    }

    public static function permitStatusToStr($id)
    {
        return isset(self::$permitStatus[$id]) ? self::$permitStatus[$id] : $id;
    }

    public static function getPermitStatus()
    {
        return self::$permitStatus;
    }
}
