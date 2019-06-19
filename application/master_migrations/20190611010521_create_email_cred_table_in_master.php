<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Create_email_cred_table_in_master extends CI_Migration
{
    public function __construct()
    {
        parent::__construct();
    }

    public function up()
    {
        $field = [
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'auto_increment' => TRUE
            ],
            'smtp_host' => [
                'type' => 'VARCHAR',
                'constraint' => 200
            ],
            'smtp_port' => [
                'type' => 'INT',
                'constraint' => 11
            ],
            'smtp_user' => [
                'type' => 'VARCHAR',
                'constraint' => 200
            ],
            'smtp_pass' => [
                'type' => 'VARCHAR',
                'constraint' => 200
            ],
            'smtp_crypto' => [
                'type' => 'BOOLEAN'
            ],
            'company_id' => [
                'type' => 'INT',
                'constraint' => 11
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
        $this->dbforge->create_table('email_cred', TRUE);
    }

    public function down()
    {
        $this->dbforge->drop_table('email_cred', TRUE); 
    }
}
