<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Create_jobs_note_table extends CI_Migration
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
                'constraint' => 10,
                'auto_increment' => TRUE,
            ],
            'job_id' => [
                'type' => 'INT',
                'constraint' => 10,
            ],
            'note' => [
                'type' => 'longtext'
            ],
            'entry_date' => [
                'type' => 'DATETIME'
            ]
        ];
        $this->dbforge->add_field($field);
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('jobs_note', TRUE);
    }

    public function down()
    {
        $this->dbforge->drop_table('jobs_note', TRUE);
    }
}
