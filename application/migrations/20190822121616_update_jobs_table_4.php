<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Update_jobs_table_4 extends CI_Migration
{
    public function __construct()
    {
        parent::__construct();
        $this->load->dbforge();
    }

    public function up()
    {
        $this->dbforge->drop_column('jobs', 'job_name');
    }

    public function down()
    {
        $fields = [
            'job_name' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'after' => 'id'
            ]
        ];

        $this->dbforge->add_column('jobs', $fields);
    }
}
