<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Create_vendors_table extends CI_Migration
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
                'constraint' => 50
            ],
            'address' => [
                'type' => 'VARCHAR',
                'constraint' => 100
            ],
            'city' => [
                'type' => 'VARCHAR',
                'constraint' => 50
            ],
            'state' => [
                'type' => 'VARCHAR',
                'constraint' => 50
            ],
            'zip' => [
                'type' => 'VARCHAR',
                'constraint' => 50
            ],
            'phone' => [
                'type' => 'VARCHAR',
                'constraint' => 20
            ],
            'email_id' => [
                'type' => 'VARCHAR',
                'constraint' => 50
            ],
            'tax_id' => [
                'type' => 'VARCHAR',
                'constraint' => 20
            ],
            'credit_line' => [
                'type' => 'VARCHAR',
                'constraint' => 50
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
        $this->dbforge->create_table('vendors', TRUE);
    }

    public function down()
    {
        $this->dbforge->drop_table('vendors', TRUE);
    }
}
