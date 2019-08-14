<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Update_jobs_table_3 extends CI_Migration
{
    public function __construct()
    {
        parent::__construct();
        $this->load->dbforge();
    }

    public function up()
    {
        $this->dbforge->drop_column('jobs', 'job_number');
    }

    public function down()
    {
        $fields = [
            'job_number' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
                'after' => 'email'
            ]
        ];

        $this->dbforge->add_column('jobs', $fields);
    }
}
