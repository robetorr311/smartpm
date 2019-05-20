<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Create_team_user_map_table extends CI_Migration
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
            'team_id' => [
                'type' => 'INT',
                'constraint' => 11
            ],
            'user_id' => [
                'type' => 'INT',
                'constraint' => 11
            ],
            'created_at TIMESTAMP default CURRENT_TIMESTAMP',
            'updated_at TIMESTAMP default CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP',
            'is_deleted' => [
                'type' => 'BOOLEAN',
                'default' => FALSE,
                'after' => 'remark'
            ]
        ];
        $this->dbforge->add_field($field);
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('team_user_map', TRUE);
    }

    public function down()
    {
        $this->dbforge->drop_table('team_user_map', TRUE);
    }
}
