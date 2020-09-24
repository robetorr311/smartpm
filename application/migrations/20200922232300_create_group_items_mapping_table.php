<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Create_group_items_mapping_table extends CI_Migration
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
                'constraint' => 11,
                'default' => NULL
            ],
            'item_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'default' => NULL
            ],
        ];
        $this->dbforge->add_field($field);
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('group_items_mapping', TRUE);
    }

    public function down()
    {
        $this->dbforge->drop_table('group_items_mapping', TRUE);
    }
}