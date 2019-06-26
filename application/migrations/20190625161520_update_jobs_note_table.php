<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Update_jobs_note_table extends CI_Migration
{
    public function __construct()
    {
        parent::__construct();
        $this->load->dbforge();
    }

    public function up()
    {
        $fields = [
            'created_by' => [
                'type' => 'INT',
                'constraint' => 11
            ],
            'created_at TIMESTAMP default CURRENT_TIMESTAMP',
            'updated_at TIMESTAMP default CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP',
            'is_deleted' => [
                'type' => 'BOOLEAN',
                'default' => FALSE
            ]
        ];

        $this->dbforge->add_column('jobs_note', $fields);
        $this->dbforge->drop_column('jobs_note', 'entry_date');
    }

    public function down()
    {
        $fields = [
            'entry_date' => [
                'type' => 'DATETIME'
            ]
        ];

        $this->dbforge->add_column('jobs_note', $fields);
        $this->dbforge->drop_column('jobs_note', 'created_by');
        $this->dbforge->drop_column('jobs_note', 'created_at');
        $this->dbforge->drop_column('jobs_note', 'updated_at');
        $this->dbforge->drop_column('jobs_note', 'is_deleted');
    }
}
