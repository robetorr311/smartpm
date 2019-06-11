<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Create_companies_table_in_master extends CI_Migration
{
    public function __construct()
    {
        parent::__construct();
    }

    public function up()
    {
        $this->db->query('use smartpm_master');
        
        $field = [
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'auto_increment' => TRUE
            ],
            'company_code' => [
                'type' => 'INT',
                'constraint' => 11,
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
                'null' => TRUE
            ],
            'city' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => TRUE
            ],
            'state' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => TRUE
            ],
            'zip' => [
                'type' => 'INT',
                'constraint' => 11,
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

        $this->db->query('use ' . $this->db->database);
    }

    public function down()
    {
        $this->db->query('use smartpm_master');
        $this->dbforge->drop_table('companies', TRUE);
        $this->db->query('use ' . $this->db->database);
    }
}
