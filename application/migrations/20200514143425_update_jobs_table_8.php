<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Update_jobs_table_8 extends CI_Migration
{
    public function __construct()
    {
        parent::__construct();
        $this->load->dbforge();
    }

    public function up()
    {
        $fields = [
            'classification' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => FALSE,
                'after' => 'type'
            ]
        ];

        $this->dbforge->add_column('jobs', $fields);
    }

    public function down()
    {
        $this->dbforge->drop_column('jobs', 'classification');
    }
}
