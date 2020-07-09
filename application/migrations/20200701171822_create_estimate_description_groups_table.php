<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Create_estimate_description_groups_table extends CI_Migration
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
            'sub_title' => [
                'type' => 'VARCHAR',
                'constraint' => 100
            ],
            'estimate_id' => [
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
        $this->dbforge->create_table('estimate_description_groups', TRUE);
    }

    public function down()
    {
        $this->dbforge->drop_table('estimate_description_groups', TRUE);
    }
}