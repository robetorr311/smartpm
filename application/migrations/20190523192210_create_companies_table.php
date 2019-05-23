<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Create_companies_table extends CI_Migration
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
            'name' => [
                'type' => 'VARCHAR',
                'constraint' => 200,
                'null' => TRUE
            ],
            'email_id' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => TRUE
            ],
            'alt_email_id' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
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
            'is_deleted' => [
                'type' => 'BOOLEAN',
                'default' => FALSE
            ],
            'created_at TIMESTAMP default CURRENT_TIMESTAMP',
            'updated_at TIMESTAMP default CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'
        ];
        $this->dbforge->add_field($field);
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('companies', TRUE);
    }

    public function down()
    {
        $this->dbforge->drop_table('companies', TRUE);
    }
}
