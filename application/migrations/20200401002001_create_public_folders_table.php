<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Create_public_folders_table extends CI_Migration
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
            'job_id' => [
                'type' => 'INT',
                'constraint' => 11,
            ],
            'file_name' => [
                'type' => 'VARCHAR',
                'constraint' => 100
            ],
            'saved_file_name' => [
                'type' => 'VARCHAR',
                'constraint' => 100
            ],
            'public_key' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
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
        $this->dbforge->create_table('public_folders', TRUE);
    }

    public function down()
    {
        $this->dbforge->drop_table('public_folders', TRUE);
    }
}
