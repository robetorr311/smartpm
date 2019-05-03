<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Create_task_notes_table extends CI_Migration
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
            'note' => [
                'type' => 'TEXT'
            ],
            'task_id' => [
                'type' => 'INT',
                'constraint' => 11
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
        $this->dbforge->create_table('task_notes', TRUE);
    }

    public function down()
    {
        $this->dbforge->drop_table('task_notes', TRUE);
    }
}
