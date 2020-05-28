<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Create_vendors_doc_table extends CI_Migration
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
                'auto_increment' => TRUE,
            ],
            'vendor_id' => [
                'type' => 'INT',
                'constraint' => 10,
            ],
            'name' => [
                'type' => 'VARCHAR',
                'constraint' => 100
            ],
            'doc_name' => [
                'type' => 'VARCHAR',
                'constraint' => 100
            ],
            'entry_date' => [
                'type' => 'DATETIME'
            ],
            'is_active' => [
                'type' => 'TINYINT',
                'constraint' => 5
            ]
        ];
        $this->dbforge->add_field($field);
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('vendors_doc', TRUE);
    }

    public function down()
    {
        $this->dbforge->drop_table('vendors_doc', TRUE);
    }
}
