<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Create_tasks_table extends CI_Migration
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
                'constraint' => 20
            ],
            'type' => [
                'type' => 'INT',
                'constraint' => 11
            ],
            'level' => [
                'type' => 'INT',
                'constraint' => 11
            ],
            'status' => [
                'type' => 'INT',
                'constraint' => 11
            ],
            'assigned_to' => [
                'type' => 'INT',
                'constraint' => 11
            ],
            'close_at' => [
                'type' => 'DATE',
                'null' => TRUE
            ],
            'created_by' => [
                'type' => 'INT',
                'constraint' => 11
            ],
            'created_at TIMESTAMP default CURRENT_TIMESTAMP',
            'updated_at TIMESTAMP default CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'
        ];
        $this->dbforge->add_field($field);
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('tasks', TRUE);
    }

    public function down()
    {
        $this->dbforge->drop_table('tasks', TRUE);
    }
}
