<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Update_jobs_table_12 extends CI_Migration
{
    public function __construct()
    {
        parent::__construct();
        $this->load->dbforge();
    }

    public function up()
    {
        $this->dbforge->drop_column('jobs', 'contract_date');
        $this->dbforge->drop_column('jobs', 'contract_total');
    }

    public function down()
    {
        $fields = [
            'contract_date' => [
                'type' => 'DATE',
                'after' => 'entry_date',
                'null' => TRUE
            ],
            'contract_total' => [
                'type' => 'INT',
                'constraint' => 11,
                'after' => 'contract_date',
                'null' => TRUE
            ]
        ];

        $this->dbforge->add_column('jobs', $fields);
    }
}
