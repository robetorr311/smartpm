<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Add_rows_box_names_table extends CI_Migration
{
    public function __construct()
    {
        parent::__construct();
        $this->load->dbforge();
    }
    public function up()
    {
        $this->db->query("INSERT INTO box_names (name, label) VALUES ('New', 'New'), ('Pending', 'Pending'), ('In-Process', 'In-Process'), ('Completed', 'Completed'), ('Closed', 'Closed')");
        $this->db->query("INSERT INTO box_names (name, label) VALUES ('New', 'New'), ('Planning & Budgeting', 'Planning & Budgeting'), ('In-Process', 'In-Process'), ('Completed', 'Completed'), ('Closed', 'Closed')");
    }

    public function down()
    {
        $this->db->query("DELETE FROM box_names WHERE id > 20");
    }
}
