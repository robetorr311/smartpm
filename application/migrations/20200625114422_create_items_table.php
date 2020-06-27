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
            'name' => [
                'type' => 'VARCHAR',
                'constraint' => 50
            ],
            'line_style_type' => [
                'type' => 'VARCHAR',
                'constraint' => 50
            ],
            'internal_part_no' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => TRUE
            ],
            'quantity_units' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => TRUE
            ],
            'unit_price' => [
                'type' => 'DECIMAL',
                'constraint' => '11,2',
                'null' => TRUE
            ],
            'description' => [
                'type' => 'VARCHAR',
                'constraint' => 500
            ],
            'is_deleted' => [
                'type' => 'BOOLEAN',
                'default' => FALSE
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