<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Update_jobs_material_table_2 extends CI_Migration
{
    public function __construct()
    {
        parent::__construct();
        $this->load->dbforge();
    }

    public function up()
    {
        $fields = [
            'project_cost' => [
                'name' => 'projected_cost',
                'type' => 'DECIMAL',
                'constraint' => '11,2',
                'null' => TRUE
            ],
            'installer_project_cost' => [
                'name' => 'installer_projected_cost',
                'type' => 'DECIMAL',
                'constraint' => '11,2',
                'null' => TRUE
            ],
            'installer' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => TRUE
            ],
            'actual_cost' => [
                'type' => 'DECIMAL',
                'constraint' => '11,2',
                'null' => TRUE
            ],
            'installer_actual_cost' => [
                'type' => 'DECIMAL',
                'constraint' => '11,2',
                'null' => TRUE
            ]
        ];

        $this->dbforge->modify_column('jobs_material', $fields);
    }

    public function down()
    {
        $fields = [
            'projected_cost' => [
                'name' => 'project_cost',
                'type' => 'DECIMAL',
                'constraint' => '11,2',
                'null' => FALSE
            ],
            'installer_projected_cost' => [
                'name' => 'installer_project_cost',
                'type' => 'DECIMAL',
                'constraint' => '11,2',
                'null' => FALSE
            ],
            'installer' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => FALSE
            ],
            'actual_cost' => [
                'type' => 'DECIMAL',
                'constraint' => '11,2',
                'null' => FALSE
            ],
            'installer_actual_cost' => [
                'type' => 'DECIMAL',
                'constraint' => '11,2',
                'null' => FALSE
            ]
        ];

        $this->dbforge->modify_column('jobs_material', $fields);
    }
}
