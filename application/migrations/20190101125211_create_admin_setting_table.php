<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Create_admin_setting_table extends CI_Migration
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
                'constraint' => 10,
                'auto_increment' => TRUE,
            ],
            'user_id' => [
                'type' => 'INT',
                'constraint' => 10,
            ],
            'name' => [
                'type' => 'VARCHAR',
                'constraint' => 100
            ],
            'url' => [
                'type' => 'VARCHAR',
                'constraint' => 100
            ],
            'favicon' => [
                'type' => 'VARCHAR',
                'constraint' => 100
            ],
            'color' => [
                'type' => 'VARCHAR',
                'constraint' => 20
            ]
        ];
        $this->dbforge->add_field($field);
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('admin_setting', TRUE);
    }

    public function down()
    {
        $this->dbforge->drop_table('admin_setting', TRUE);
    }
}
