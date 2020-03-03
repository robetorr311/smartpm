<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Update_jobs_table_data_3 extends CI_Migration
{
    public function __construct()
    {
        parent::__construct();
        $this->load->dbforge();
    }

    public function up()
    {
        $this->db->query('UPDATE jobs SET status=status+1 WHERE status>10');
        $this->db->query('UPDATE jobs SET status=7 WHERE status IN (7, 8, 9, 10)');
        $this->db->query('UPDATE jobs SET category=null');
    }

    public function down()
    {
        $this->db->query('UPDATE jobs SET status=status-1 WHERE status>11');
        $this->db->query('UPDATE jobs SET category=0');
    }
}
