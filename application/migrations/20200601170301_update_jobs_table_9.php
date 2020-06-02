<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Update_jobs_table_9 extends CI_Migration
{
    public function __construct()
    {
        parent::__construct();
        $this->load->dbforge();
    }

    public function up()
    {
        $fields = [
            'dumpster_status' => [
                'type' => 'INT',
                'constraint' => 11,
                'after' => 'lead_source',
                'null' => TRUE
            ],
            'materials_status' => [
                'type' => 'INT',
                'constraint' => 11,
                'after' => 'dumpster_status',
                'null' => TRUE
            ],
            'labor_status' => [
                'type' => 'INT',
                'constraint' => 11,
                'after' => 'materials_status',
                'null' => TRUE
            ]
        ];

        $this->dbforge->add_column('jobs', $fields);
    }

    public function down()
    {
        $this->dbforge->drop_column('jobs', 'dumpster_status');
        $this->dbforge->drop_column('jobs', 'materials_status');
        $this->dbforge->drop_column('jobs', 'labor_status');
    }
}
