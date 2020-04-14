<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Create_company_photos_table extends CI_Migration
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
                'constraint' => 11,
            ],
            'path' => [
                'type' => 'VARCHAR',
                'constraint' => 500
            ],
            'name' => [
                'type' => 'VARCHAR',
                'constraint' => 100
            ],
            'public_key' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => TRUE
            ],
            'created_at TIMESTAMP default CURRENT_TIMESTAMP',
            'updated_at TIMESTAMP default CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'
        ];
        $this->dbforge->add_field($field);
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('company_photos', TRUE);
    }

    public function down()
    {
        $this->dbforge->drop_table('company_photos', TRUE);
    }
}
