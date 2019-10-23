<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Update_jobs_table_data extends CI_Migration
{
    public function __construct()
    {
        parent::__construct();
        $this->load->dbforge();
    }

    public function up()
    {
        $this->db->query('UPDATE jobs SET status=status+1 WHERE status>9');
    }

    public function down()
    {
        $this->db->query('UPDATE jobs SET status=status-1 WHERE status>9');
    }
}
