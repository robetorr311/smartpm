<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Update_financial_table extends CI_Migration
{
    public function __construct()
    {
        parent::__construct();
        $this->load->dbforge();
    }

    public function up()
    {
        $fields = [
            'vendor' => [
                'type' => 'VARCHAR',
                'constraint' => 200,
                'after' => 'transaction_date'
            ]
        ];

        $this->dbforge->add_column('financial', $fields);
        $this->dbforge->drop_column('financial', 'transaction_number');
        $this->dbforge->drop_column('financial', 'sales_rep');
    }

    public function down()
    {
        $fields = [
            'transaction_number' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'after' => 'transaction_date'
            ],
            'sales_rep' => [
                'type' => 'INT',
                'constraint' => 11,
                'after' => 'week'
            ]
        ];

        $this->dbforge->add_column('financial', $fields);
        $this->dbforge->drop_column('financial', 'vendor');
    }
}
