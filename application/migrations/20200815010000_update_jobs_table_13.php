<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Update_jobs_table_13 extends CI_Migration
{
    public function __construct()
    {
        parent::__construct();
        $this->load->dbforge();
    }

    public function up()
    {
        $fields = [
            'completed_date' => [
                'type' => 'DATE',
                'after' => 'permit_status',
                'null' => TRUE
            ]
        ];

        $this->dbforge->add_column('jobs', $fields);
    }

    public function down()
    {
        $this->dbforge->drop_column('jobs', 'completed_date');
    }
}
