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
        $modifyFields = [
            'username' => [
                'name' => 'email_id',
                'type' => 'VARCHAR',
                'constraint' => 100,
                'unique' => TRUE
            ]
        ];

        $fields = [
            'first_name' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'first' => TRUE
            ],
            'last_name' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'after' => 'first_name'
            ],
            'username' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'after' => 'last_name',
                'unique' => TRUE
            ],
            'type' => [
                'type' => 'INT',
                'constraint' => 11,
                'default' => 1,
                'after' => 'password'
            ],
            'verification_token' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'after' => 'type',
                'null' => TRUE
            ],
            'address' => [
                'type' => 'TEXT',
                'after' => 'verification_token',
                'null' => TRUE
            ],
            'phone_number' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'after' => 'address',
                'null' => TRUE
            ],
            'is_active' => [
                'type' => 'BOOLEAN',
                'default' => FALSE,
                'after' => 'phone_number'
            ],
            'is_deleted' => [
                'type' => 'BOOLEAN',
                'default' => FALSE,
                'after' => 'is_active'
            ]
        ];

        $this->dbforge->drop_column('users', 'usertype');
        $this->dbforge->drop_column('users', 'fullname');
        $this->dbforge->modify_column('users', $modifyFields);
        $this->dbforge->add_column('users', $fields);
    }

    public function down()
    {
        $modifyFields = [
            'email_id' => [
                'name' => 'username',
                'type' => 'VARCHAR',
                'constraint' => 100,
                'unique' => FALSE
            ]
        ];

        $fields = [];

        $this->dbforge->drop_column('users', 'first_name');
        $this->dbforge->drop_column('users', 'last_name');
        $this->dbforge->drop_column('users', 'username');
        $this->dbforge->drop_column('users', 'type');
        $this->dbforge->drop_column('users', 'verification_token');
        $this->dbforge->drop_column('users', 'is_active');
        $this->dbforge->drop_column('users', 'is_deleted');
        $this->dbforge->modify_column('users', $modifyFields);
        $this->dbforge->add_column('users', $fields);
    }
}
