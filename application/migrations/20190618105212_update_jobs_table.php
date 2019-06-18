<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Update_jobs_table extends CI_Migration
{
    public function __construct()
    {
        parent::__construct();
        $this->load->dbforge();
    }

    public function up()
    {
        $fields = [
            'zip' => [
                'type' => 'varchar',
                'constraint' => 20
            ],
        ];

        $this->dbforge->modify_column('jobs', $fields);
    }

    public function down()
    {
        $fields = [
            'zip' => [
                'type' => 'int',
                'constraint' => 5
            ],
        ];
        $this->dbforge->modify_column('jobs', $fields);
    }
}
