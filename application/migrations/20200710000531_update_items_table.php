<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Update_items_table extends CI_Migration
{
    public function __construct()
    {
        parent::__construct();
        $this->load->dbforge();
    }

    public function up()
    {
        $fields = [
            'quantity_units' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => TRUE
            ]
        ];

        $this->dbforge->modify_column('items', $fields);
    }

    public function down()
    {
        $fields = [
            'quantity_units' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => TRUE
            ]
        ];

        $this->dbforge->modify_column('items', $fields);
    }
}
