<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Update_financial_table_1 extends CI_Migration
{
    public function __construct()
    {
        parent::__construct();
        $this->load->dbforge();
    }

    public function up()
    {
        $fields = [
            'vendor_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'after' => 'id'
            ]
        ];

        $this->dbforge->drop_column('financial', 'vendor');
        $this->dbforge->add_column('financial', $fields);
    }

    public function down()
    {
        $fields = [
            'vendor' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'after' => 'id'
            ]
        ];

        $this->dbforge->drop_column('financial', 'vendor_id');
        $this->dbforge->add_column('financial', $fields);
    }
}
