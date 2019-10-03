<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Delete_status_tag_types_table extends CI_Migration
{
    public function __construct()
    {
        parent::__construct();
        $this->load->dbforge();
    }

    public function up()
    {
        $this->dbforge->drop_table('status_tag_types', TRUE);
    }

    public function down()
    {
        $field = [
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'auto_increment' => TRUE,
            ],
            'status_tag_id' => [
                'type' => 'INT',
                'constraint' => 11,
            ],
             'value' => [
                'type' => 'VARCHAR',
                'constraint' => 40,
            ],
             'is_active' => [
                'type' => 'INT',
                'constraint' => 11,
            ],
        ];
        $this->dbforge->add_field($field);
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('status_tag_types', TRUE);
    }
}
