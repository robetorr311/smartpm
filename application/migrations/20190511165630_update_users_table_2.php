<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Update_users_table_2 extends CI_Migration
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
                'after' => 'id'
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
            'level' => [
                'type' => 'INT',
                'constraint' => 11,
                'default' => 1,
                'after' => 'password'
            ],
            'type' => [
                'type' => 'INT',
                'constraint' => 11,
                'default' => 1,
                'after' => 'level'
            ],
            'verification_token' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'after' => 'type',
                'null' => TRUE
            ],
            'office_phone' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'after' => 'verification_token',
                'null' => TRUE
            ],
            'home_phone' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'after' => 'office_phone',
                'null' => TRUE
            ],
            'cell_1' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'after' => 'home_phone',
                'null' => TRUE
            ],
            'cell_2' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'after' => 'cell_1',
                'null' => TRUE
            ],
            'notifications' => [
                'type' => 'INT',
                'constraint' => 11,
                'default' => 1,
                'after' => 'cell_2'
            ],
            'company_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'after' => 'notifications'
            ],
            'is_active' => [
                'type' => 'BOOLEAN',
                'default' => FALSE,
                'after' => 'company_id'
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
                'unique' => TRUE
            ]
        ];

        $fields = [
            'usertype' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
                'null' => TRUE
            ],
            'fullname' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => TRUE
            ]
        ];

        $this->dbforge->drop_column('users', 'first_name');
        $this->dbforge->drop_column('users', 'last_name');
        $this->dbforge->drop_column('users', 'username');
        $this->dbforge->drop_column('users', 'level');
        $this->dbforge->drop_column('users', 'type');
        $this->dbforge->drop_column('users', 'verification_token');
        $this->dbforge->drop_column('users', 'office_phone');
        $this->dbforge->drop_column('users', 'home_phone');
        $this->dbforge->drop_column('users', 'cell_1');
        $this->dbforge->drop_column('users', 'cell_2');
        $this->dbforge->drop_column('users', 'notifications');
        $this->dbforge->drop_column('users', 'company_id');
        $this->dbforge->drop_column('users', 'is_active');
        $this->dbforge->drop_column('users', 'is_deleted');
        $this->dbforge->modify_column('users', $modifyFields);
        $this->dbforge->add_column('users', $fields);
    }
}
