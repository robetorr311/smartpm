<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Update_jobs_material_table_3 extends CI_Migration
{
    public function __construct()
    {
        parent::__construct();
        $this->load->dbforge();
    }

    public function up()
    {
        $fields = [
            'primary_material_info' => [
                'type' => 'INT',
                'constraint' => 11,
                'after' => 'installer_actual_cost',
                'default' => 0
            ]
        ];

        $this->dbforge->add_column('jobs_material', $fields);
    }

    public function down()
    {
        $this->dbforge->drop_column('jobs_material', 'primary_material_info');
    }
}
