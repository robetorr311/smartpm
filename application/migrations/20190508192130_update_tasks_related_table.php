<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Update_tasks_related_table extends CI_Migration
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
                'type' => 'INT',
                'constraint' => 1,
                'default' => 0
            ]
        ];

        $this->dbforge->add_column('tasks', $fields);
        $this->dbforge->add_column('task_user_tags', $fields);
        $this->dbforge->add_column('task_job_tags', $fields);
        $this->dbforge->add_column('task_predecessor', $fields);
        $this->dbforge->add_column('task_notes', $fields);
    }

    public function down()
    {
        $this->dbforge->drop_column('tasks', 'is_deleted');
        $this->dbforge->drop_column('task_user_tags', 'is_deleted');
        $this->dbforge->drop_column('task_job_tags', 'is_deleted');
        $this->dbforge->drop_column('task_predecessor', 'is_deleted');
        $this->dbforge->drop_column('task_notes', 'is_deleted');
    }
}
