<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Update_jobs_table_5 extends CI_Migration
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
                'type' => 'INT',
                'constraint' => 11,
                'default' => 0,
                'after' => 'status'
            ]
        ];

        $this->dbforge->add_column('jobs', $fields);
    }

    public function down()
    {
        $this->dbforge->drop_column('jobs', 'signed_stage');
    }
}
