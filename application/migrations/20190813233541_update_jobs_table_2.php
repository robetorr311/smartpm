<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Update_jobs_table_2 extends CI_Migration
{
    public function __construct()
    {
        parent::__construct();
        $this->load->dbforge();
    }

    public function up()
    {
        $fields = [
            'status' => [
                'type' => 'INT',
                'constraint' => 11,
                'default' => 0
            ],
            'type' => [
                'type' => 'INT',
                'constraint' => 11,
                'default' => 0
            ],
            'created_by' => [
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

        $this->dbforge->drop_column('jobs', 'report_id');
        $this->dbforge->drop_column('jobs', 'status');
        $this->dbforge->drop_column('jobs', 'is_active');
        $this->dbforge->add_column('jobs', $fields);
    }

    public function down()
    {
        $fields = [
            'report_id' => [
                'type' => 'INT',
                'constraint' => 10,
                'after' => 'job_name'
            ],
            'status' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
                'after' => 'job_number'
            ],
            'is_active' => [
                'type' => 'TINYINT',
                'constraint' => 4,
                'after' => 'status'
            ]
        ];

        $this->dbforge->drop_column('jobs', 'status');
        $this->dbforge->drop_column('jobs', 'type');
        $this->dbforge->drop_column('jobs', 'created_by');
        $this->dbforge->drop_column('jobs', 'is_deleted');
        $this->dbforge->drop_column('jobs', 'created_at');
        $this->dbforge->drop_column('jobs', 'updated_at');
        $this->dbforge->add_column('jobs', $fields);
    }
}
