<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Update_users_table extends CI_Migration
{
    public function __construct()
    {
        parent::__construct();
        $this->load->dbforge();
    }

    public function up()
    {
        $fields = [
            'usertype' => [
                'type' => 'varchar',
                'constraint' => 20
            ],
            'fullname' => [
                'type' => 'varchar',
                'constraint' => 100
            ],
        ];
        $this->dbforge->add_column('users', $fields);
        $this->dbforge->drop_column('users', 'email');
    }

    public function down()
    {
        $this->dbforge->drop_column('users', 'usertype');
        $this->dbforge->drop_column('users', 'fullname');
        $fields = [
            'email' => [
                'type' => 'varchar',
                'constraint' => 100
            ]
        ];
        $this->dbforge->add_column('users', $fields);
    }
}
