<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Create_task_job_tags_table extends CI_Migration
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
            'task_id' => [
                'type' => 'INT',
                'constraint' => 11
            ],
            'job_id' => [
                'type' => 'INT',
                'constraint' => 11
            ]
        ];
        $this->dbforge->add_field($field);
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('task_job_tags', TRUE);
    }

    public function down()
    {
        $this->dbforge->drop_table('task_job_tags', TRUE);
    }
}
