<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Update_jobs_table_11 extends CI_Migration
{
    public function __construct()
    {
        parent::__construct();
        $this->load->dbforge();
    }

    public function up()
    {
        $fields = [
            'address_2' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'after' => 'address',
                'null' => TRUE
            ],
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

    public function down()
    {
        $this->dbforge->drop_column('jobs', 'address_2');
        $this->dbforge->drop_column('jobs', 'contract_date');
        $this->dbforge->drop_column('jobs', 'contract_total');
    }
}
