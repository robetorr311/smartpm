<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Create_client_notice_table extends CI_Migration
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
            'type' => [
                'type' => 'INT',
                'constraint' => 11
            ],
            'date' => [
                'type' => 'DATE'
            ],
            'expected_date' => [
                'type' => 'DATE',
                'null' => true
            ],
            'note' => [
                'type' => 'VARCHAR',
                'constraint' => 500
            ],
            'client_id' => [
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
        $this->dbforge->create_table('client_notice', TRUE);
    }

    public function down()
    {
        $this->dbforge->drop_table('client_notice', TRUE);
    }
}