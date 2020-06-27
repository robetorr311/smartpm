<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Update_jobs_material_table extends CI_Migration
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
                'type' => 'DECIMAL',
                'constraint' => '11,2',
                'null' => FALSE
            ],
            'actual_cost' => [
                'type' => 'DECIMAL',
                'constraint' => '11,2',
                'null' => FALSE
            ],
            'installer_project_cost' => [
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

    public function down()
    {
        $fields = [
            'project_cost' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => FALSE
            ],
            'actual_cost' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => FALSE
            ],
            'installer_project_cost' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => FALSE
            ],
            'installer_actual_cost' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => FALSE
            ]
        ];

        $this->dbforge->modify_column('jobs_material', $fields);
    }
}
