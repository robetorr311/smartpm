<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Update_tasks_table extends CI_Migration
{
    public function __construct()
    {
        parent::__construct();
        $this->load->dbforge();
    }

    public function up()
    {
        $fields = [
            'name' => [
                'name' => 'name',
                'type' => 'VARCHAR',
                'constraint' => 500,
                'null' => FALSE
            ]
        ];

        $this->dbforge->modify_column('tasks', $fields);
    }

    public function down()
    {
        $fields = [
            'name' => [
                'name' => 'name',
                'type' => 'VARCHAR',
                'constraint' => 20,
                'null' => FALSE
            ]
        ];

        $this->dbforge->modify_column('tasks', $fields);
    }
}
