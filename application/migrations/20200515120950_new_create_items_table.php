<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Create_items_table extends CI_Migration
{
    public function __construct()
    {
        parent::__construct();
        $this->load->dbforge();
    }
    public function up()
    {
        $field = [
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'auto_increment' => TRUE
            ],
            'item_name' => [
                'type' => 'VARCHAR',
                'constraint' => 50
            ],
            'item_type' => [
                'type' => 'VARCHAR',
                'constraint' => 50
            ],
            'internal_part' => [
                'type' => 'int',
                'constraint' => 11
            ],
            'quantity_units' => [
                'type' => 'VARCHAR',
                'constraint' => 500
            ],
            'unit_price' => [
                'type' => 'INT',
                'constraint' => 11
            ],
            'item_description' => [
                'type' => 'VARCHAR',
                'constraint' => 500
            ],
            'manufacturer' => [
                'type' => 'VARCHAR',
                'constraint' => 500
            ],
            'created_at TIMESTAMP default CURRENT_TIMESTAMP',
            'updated_at TIMESTAMP default CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'
        ];
        $this->dbforge->add_field($field);
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('items', TRUE);
    }

    public function down()
    {
        $this->dbforge->drop_table('items', TRUE);
    }
}
