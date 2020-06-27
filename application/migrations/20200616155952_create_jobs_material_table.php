<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Create_jobs_material_table extends CI_Migration
{
    public function __construct()
    {
        parent::__construct();
        $this->load->dbforge();
    }
    public function up()
    {
        $field = [
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'auto_increment' => TRUE
            ],
            'job_id' => [
                'type' => 'INT',
                'constraint' => 11,
            ],
            'material' => [
                'type' => 'INT',
                'constraint' => 11
            ],
            'manufacturer' => [
                'type' => 'VARCHAR',
                'constraint' => 100
            ],
            'line_style_group' => [
                'type' => 'VARCHAR',
                'constraint' => 100
            ],
            'color' => [
                'type' => 'VARCHAR',
                'constraint' => 100
            ],
            'supplier' => [
                'type' => 'VARCHAR',
                'constraint' => 100
            ],
            'po_no' => [
                'type' => 'INT',
                'constraint' => 11
            ],
            'project_cost' => [
                'type' => 'INT',
                'constraint' => 11
            ],
            'actual_cost' => [
                'type' => 'INT',
                'constraint' => 11
            ],
            'installer' => [
                'type' => 'INT',
                'constraint' => 11
            ],
            'installer_project_cost' => [
                'type' => 'INT',
                'constraint' => 11
            ],
            'installer_actual_cost' => [
                'type' => 'INT',
                'constraint' => 11
            ],
            'is_deleted' => [
                'type' => 'BOOLEAN',
                'default' => FALSE
            ],
            'created_at TIMESTAMP default CURRENT_TIMESTAMP',
            'updated_at TIMESTAMP default CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'
        ];
        $this->dbforge->add_field($field);
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('jobs_material', TRUE);
    }

    public function down()
    {
        $this->dbforge->drop_table('jobs_material', TRUE);
    }
}
