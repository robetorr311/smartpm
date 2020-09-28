<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Create_item_groups_items_map_table extends CI_Migration
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
            'group_id' => [
                'type' => 'INT',
                'constraint' => 11
            ],
            'item_id' => [
                'type' => 'INT',
                'constraint' => 11
            ],
        ];
        $this->dbforge->add_field($field);
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('item_groups_items_map', TRUE);
    }

    public function down()
    {
        $this->dbforge->drop_table('item_groups_items_map', TRUE);
    }
}