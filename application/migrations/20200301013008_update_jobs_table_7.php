<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Update_jobs_table_7 extends CI_Migration
{
    public function __construct()
    {
        parent::__construct();
        $this->load->dbforge();
    }

    public function up()
    {
        $fields = [
            'signed_stage' => [
                'name' => 'category',
                'type' => 'INT',
                'constraint' => 11,
                'default' => null,
                'null' => TRUE,
                'after' => 'status'
            ]
        ];

        $this->dbforge->modify_column('jobs', $fields);
    }

    public function down()
    {
        $fields = [
            'category' => [
                'name' => 'signed_stage',
                'type' => 'INT',
                'constraint' => 11,
                'default' => 0,
                'after' => 'status'
            ]
        ];

        $this->dbforge->modify_column('jobs', $fields);
    }
}
