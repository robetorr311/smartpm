<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Update_financial_table_2 extends CI_Migration
{
    public function __construct()
    {
        parent::__construct();
        $this->load->dbforge();
    }

    public function up()
    {
        $fields = [
            'party' => [
                'type' => 'INT',
                'constraint' => 11,
                'after' => 'id',
                'null' => FALSE
            ],
            'client_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'after' => 'vendor_id'
            ]
        ];

        $this->dbforge->add_column('financial', $fields);
    }

    public function down()
    {
        $this->dbforge->drop_column('financial', 'party');
        $this->dbforge->drop_column('financial', 'client_id');
    }
}
