<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Update_users_table_4 extends CI_Migration
{
    public function __construct()
    {
        parent::__construct();
        $this->load->dbforge();
    }

    public function up()
    {
        $fields = [
            'cell_1_provider' => [
                'type' => 'INT',
                'constraint' => 11,
                'after' => 'cell_1'
            ]
        ];

        $this->dbforge->add_column('users', $fields);
    }

    public function down()
    {
        $this->dbforge->drop_column('users', 'cell_1_provider');
    }
}
