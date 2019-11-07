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
        $this->dbforge->drop_column('financial', 'transaction_number');
    }

    public function down()
    {
        $fields = [
            'transaction_number' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'after' => 'transaction_date'
            ]
        ];

        $this->dbforge->add_column('financial', $fields);
    }
}
