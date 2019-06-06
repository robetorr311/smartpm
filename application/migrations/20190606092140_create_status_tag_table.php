<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Create_status_tag_table extends CI_Migration
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
            'name' => [
                'type' => 'varchar',
                'constraint' => 40
            ],
        ];
        $this->dbforge->add_field($field);
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('status_tag', TRUE);
    }

    public function down()
    {
        $this->dbforge->drop_table('status_tag', TRUE);
    }
}
