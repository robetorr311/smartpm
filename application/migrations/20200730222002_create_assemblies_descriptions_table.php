<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Create_assemblies_descriptions_table extends CI_Migration
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
            'item' => [
                'type' => 'INT',
                'constraint' => 11
            ],
            'assemblies_id' => [
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
        $this->dbforge->create_table('assemblies_descriptions', TRUE);
    }

    public function down()
    {
        $this->dbforge->drop_table('assemblies_descriptions', TRUE);
    }
}