<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Update_teams_table extends CI_Migration
{
    public function __construct()
    {
        parent::__construct();
        $this->load->dbforge();
    }

    public function up()
    {
        $fields = [
            'is_deleted' => [
                'type' => 'BOOLEAN',
                'default' => FALSE,
                'after' => 'remark'
            ],
            'created_at TIMESTAMP default CURRENT_TIMESTAMP',
            'updated_at TIMESTAMP default CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'
        ];

        $this->dbforge->drop_column('teams', 'is_active');
        $this->dbforge->add_column('teams', $fields);
    }

    public function down()
    {
        $fields = [
            'is_active' => [
                'type' => 'INT',
                'constraint' => 11
            ]
        ];

        $this->dbforge->drop_column('teams', 'is_deleted');
        $this->dbforge->drop_column('teams', 'created_at');
        $this->dbforge->drop_column('teams', 'updated_at');
        $this->dbforge->add_column('teams', $fields);
    }
}
