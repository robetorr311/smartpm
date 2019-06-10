<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Create_master_database extends CI_Migration
{
    public function __construct()
    {
        parent::__construct();
        $this->load->dbforge();
    }
    public function up()
    {
        $this->dbforge->create_database('smartpm_master');
    }

    public function down()
    {
        $this->dbforge->drop_database('smartpm_master');
    }
}
