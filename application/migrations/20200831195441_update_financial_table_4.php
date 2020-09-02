<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Update_financial_table_4 extends CI_Migration
{
    public function __construct()
    {
        parent::__construct();
        $this->load->dbforge();
    }

    public function up()
    {
        $fields = [
            'accounting_code' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => true
            ],
            'method' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => true
            ],
            'bank_account' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => true
            ]
        ];

        $this->dbforge->modify_column('financial', $fields);
    }

    public function down()
    {
        $fields = [
            'accounting_code' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => false
            ],
            'method' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => false
            ],
            'bank_account' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => false
            ]
        ];

        $this->dbforge->modify_column('financial', $fields);
    }
}
