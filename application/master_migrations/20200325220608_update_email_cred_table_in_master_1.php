<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Update_email_cred_table_in_master_1 extends CI_Migration
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
                'constraint' => 20
            ]
        ];
        $this->dbforge->modify_column('email_cred', $field);
    }

    public function down()
    {
        $field = [
            'smtp_crypto' => [
                'name' => 'smtp_crypto',
                'type' => 'VARCHAR',
                'constraint' => 5
            ]
        ];
        $this->dbforge->modify_column('email_cred', $field);
    }
}
