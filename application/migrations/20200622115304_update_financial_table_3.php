<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Update_financial_table_3 extends CI_Migration
{
    public function __construct()
    {
        parent::__construct();
        $this->load->dbforge();
    }

    public function up()
    {
        $fields = [
            'amount' => [
                'type' => 'DECIMAL',
                'constraint' => '11,2',
                'null' => FALSE
            ]
        ];

        $this->dbforge->modify_column('financial', $fields);
    }

    public function down()
    {
        $fields = [
            'amount' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => FALSE
            ]
        ];

        $this->dbforge->modify_column('financial', $fields);
    }
}
