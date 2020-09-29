<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Update_items_table_2 extends CI_Migration
{
    public function __construct()
    {
        parent::__construct();
        $this->load->dbforge();
    }

    public function up()
    {
        $fields = [
            'item_group_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'after' => 'name'
            ],
        ];

        $this->dbforge->add_column('items', $fields);
    }

    public function down()
    {
        $this->dbforge->drop_column('items', 'item_group_id');
    }
}
