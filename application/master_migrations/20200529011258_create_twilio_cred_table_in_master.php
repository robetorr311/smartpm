<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Create_twilio_cred_table_in_master extends CI_Migration
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
            'account_sid' => [
                'type' => 'VARCHAR',
                'constraint' => 100
            ],
            'auth_token' => [
                'type' => 'VARCHAR',
                'constraint' => 100
            ],
            'twilio_number' => [
                'type' => 'VARCHAR',
                'constraint' => 100
            ],
            'company_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unique' => TRUE
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
        $this->dbforge->create_table('twilio_cred', TRUE);

        $this->db->query("INSERT INTO twilio_cred (account_sid, auth_token, twilio_number, company_id) SELECT '', '', '', id FROM companies");
    }

    public function down()
    {
        $this->dbforge->drop_table('twilio_cred', TRUE); 
    }
}
