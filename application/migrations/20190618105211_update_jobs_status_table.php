<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Update_jobs_status_table extends CI_Migration
{
    public function __construct()
    {
        parent::__construct();
        $this->load->dbforge();
    }

    public function up()
    {
        $fields = [
            'start_at' => [
                'type' => 'DATETIME'
            ],
            'close_at' => [
                'type' => 'DATETIME'
            ],
        ];

        $this->dbforge->add_column('jobs_status', $fields);
    }

    public function down()
    {
        $fields = [
            'start_at' => [
                'type' => 'DATETIME'
            ],
            'close_at' => [
                'type' => 'DATETIME'
            ],
        ];
        $this->dbforge->drop_column('jobs_status', $fields);
    }
}
