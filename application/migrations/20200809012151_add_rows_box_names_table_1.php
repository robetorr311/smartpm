<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Add_rows_box_names_table_1 extends CI_Migration
{
    public function __construct()
    {
        parent::__construct();
        $this->load->dbforge();
    }
    public function up()
    {
        $this->db->query("INSERT INTO box_names (name, label) VALUES ('Punch List', 'Punch List')");
    }

    public function down()
    {
        $this->db->query("DELETE FROM box_names WHERE id > 20");
    }
}
