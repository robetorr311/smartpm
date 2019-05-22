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
            'alt_email' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'after' => 'password',
                'null' => TRUE
            ],
            'level' => [
                'type' => 'INT',
                'constraint' => 11,
                'default' => 1,
                'after' => 'alt_email'
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
            'company' => [
                'type' => 'VARCHAR',
                'constraint' => 200,
                'after' => 'verification_token',
                'null' => TRUE
            ],
            'address' => [
                'type' => 'TEXT',
                'after' => 'company',
                'null' => TRUE
            ],
            'city' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'after' => 'address',
                'null' => TRUE
            ],
            'state' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'after' => 'city',
                'null' => TRUE
            ],
            'zip' => [
                'type' => 'INT',
                'constraint' => 11,
                'after' => 'state',
                'null' => TRUE
            ],
            'office_phone' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'after' => 'zip',
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
            'is_active' => [
                'type' => 'BOOLEAN',
                'default' => FALSE,
                'after' => 'notifications'
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
        $this->dbforge->drop_column('users', 'alt_email');
        $this->dbforge->drop_column('users', 'level');
        $this->dbforge->drop_column('users', 'type');
        $this->dbforge->drop_column('users', 'verification_token');
        $this->dbforge->drop_column('users', 'company');
        $this->dbforge->drop_column('users', 'address');
        $this->dbforge->drop_column('users', 'city');
        $this->dbforge->drop_column('users', 'state');
        $this->dbforge->drop_column('users', 'zip');
        $this->dbforge->drop_column('users', 'office_phone');
        $this->dbforge->drop_column('users', 'home_phone');
        $this->dbforge->drop_column('users', 'cell_1');
        $this->dbforge->drop_column('users', 'cell_2');
        $this->dbforge->drop_column('users', 'notifications');
        $this->dbforge->drop_column('users', 'is_active');
        $this->dbforge->drop_column('users', 'is_deleted');
        $this->dbforge->modify_column('users', $modifyFields);
        $this->dbforge->add_column('users', $fields);
    }
}
