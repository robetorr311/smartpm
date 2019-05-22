<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Update_teams_table_2 extends CI_Migration
{
    public function __construct()
    {
        parent::__construct();
        $this->load->dbforge();
    }

    public function up()
    {
        $fields = [
            'manager' => [
                'type' => 'INT',
                'constraint' => 11,
                'after' => 'remark'
            ],
            'team_leader' => [
                'type' => 'INT',
                'constraint' => 11,
                'after' => 'manager'
            ],
            'created_by' => [
                'type' => 'INT',
                'constraint' => 11,
                'after' => 'team_leader'
            ]
        ];

        $this->dbforge->add_column('teams', $fields);
    }

    public function down()
    {
        $this->dbforge->drop_column('teams', 'manager');
        $this->dbforge->drop_column('teams', 'team_leader');
        $this->dbforge->drop_column('teams', 'created_by');
    }
}
