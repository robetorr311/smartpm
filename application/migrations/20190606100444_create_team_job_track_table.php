<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Create_team_job_track_table extends CI_Migration
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
                'constraint' => 11,
            ],
            'job_id' => [
                'type' => 'INT',
                'constraint' => 11,
            ],
             'assign_date' => [
                'type' => 'datetime',
                'constraint' => 6,
            ],
             'end_date' => [
                'type' => 'datetime',
                'constraint' => 6,
            ],
             'is_deleted' => [
                'type' => 'INT',
                'constraint' => 11,
            ],
        ];
        $this->dbforge->add_field($field);
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('team_job_track', TRUE);
    }

    public function down()
    {
        $this->dbforge->drop_table('team_job_track', TRUE);
    }
}
