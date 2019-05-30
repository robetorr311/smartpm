<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Create_teams_table extends CI_Migration
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
            'team_name' => [
                'type' => 'VARCHAR',
                'constraint' => 100
            ],
            'remark' => [
                'type' => 'VARCHAR',
                'constraint' => 1000
            ],
            'is_active' => [
                'type' => 'INT',
                'constraint' => 11
            ]
        ];
        $this->dbforge->add_field($field);
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('teams', TRUE);
    }

    public function down()
    {
        $this->dbforge->drop_table('teams', TRUE);
    }
}
