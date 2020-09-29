<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Update_estimate_descriptions_table_6 extends CI_Migration
{
    public function __construct()
    {
        parent::__construct();
        $this->load->dbforge();
    }

    public function up()
    {
        $this->dbforge->drop_column('estimate_descriptions', 'group_id');
    }

    public function down()
    {
        $fields = [
            'group_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'after' => 'id',
                'default' => NULL
            ],
        ];

        $this->dbforge->add_column('estimate_descriptions', $fields);
    }
}
