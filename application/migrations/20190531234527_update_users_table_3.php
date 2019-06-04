<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Update_users_table_3 extends CI_Migration
{
    public function __construct()
    {
        parent::__construct();
        $this->load->dbforge();
    }

    public function up()
    {
        $modifyFields = [
            'verification_token' => [
                'type' => 'VARCHAR',
                'constraint' => 200,
                'null' => TRUE
            ]
        ];

        $fields = [
            'password_token' => [
                'type' => 'VARCHAR',
                'constraint' => 200,
                'after' => 'verification_token',
                'null' => TRUE
            ],
            'token_expiry' => [
                'type' => 'TIMESTAMP',
                'null' => TRUE
            ],
            'created_at TIMESTAMP default CURRENT_TIMESTAMP',
            'updated_at TIMESTAMP default CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'
        ];

        $this->dbforge->add_column('users', $fields);
        $this->dbforge->modify_column('users', $modifyFields);
    }

    public function down()
    {
        $modifyFields = [
            'verification_token' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => TRUE
            ]
        ];

        $this->dbforge->drop_column('users', 'password_token');
        $this->dbforge->drop_column('users', 'token_expiry');
        $this->dbforge->drop_column('users', 'created_at');
        $this->dbforge->drop_column('users', 'updated_at');
        $this->dbforge->modify_column('users', $modifyFields);
    }
}
