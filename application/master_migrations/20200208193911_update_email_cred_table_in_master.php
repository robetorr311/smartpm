<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Update_email_cred_table_in_master extends CI_Migration
{
    public function __construct()
    {
        parent::__construct();
    }

    public function up()
    {
        $field = [
            'smtp_crypto' => [
                'name' => 'smtp_crypto',
                'type' => 'VARCHAR',
                'constraint' => 5
            ],
            'company_id' => [
                'name' => 'company_id',
                'type' => 'INT',
                'constraint' => 11,
                'unique' => TRUE
            ]
        ];
        $this->dbforge->modify_column('email_cred', $field);
    }

    public function down()
    {
        $field = [
            'smtp_crypto' => [
                'name' => 'smtp_crypto',
                'type' => 'BOOLEAN'
            ],
            'company_id' => [
                'name' => 'company_id',
                'type' => 'INT',
                'constraint' => 11,
                'unique' => FALSE,
                'null' => FALSE
            ]
        ];
        $this->dbforge->modify_column('email_cred', $field);
    }
}
