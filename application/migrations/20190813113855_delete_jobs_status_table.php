<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Delete_jobs_status_table extends CI_Migration
{
    public function __construct()
    {
        parent::__construct();
        $this->load->dbforge();
    }

    public function up()
    {
        $this->dbforge->drop_table('jobs_status', TRUE);
    }

    public function down()
    {
        $field = [
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'auto_increment' => TRUE,
            ],
            'jobid' => [
                'type' => 'INT',
                'constraint' => 20
            ],
            'lead' => [
                'type' => 'varchar',
                'constraint' => 40
            ],
            'job' => [
                'type' => 'varchar',
                'constraint' => 40
            ],
            'client' => [
                'type' => 'varchar',
                'constraint' => 40
            ],
            'contract' => [
                'type' => 'varchar',
                'constraint' => 40
            ],
            'scope' => [
                'type' => 'varchar',
                'constraint' => 40
            ],
            'price' => [
                'type' => 'varchar',
                'constraint' => 40
            ],
            'production' => [
                'type' => 'varchar',
                'constraint' => 40
            ],
            'closeout' => [
                'type' => 'varchar',
                'constraint' => 40
            ],
            'collection' => [
                'type' => 'varchar',
                'constraint' => 40
            ],
            'start_at' => [
                'type' => 'DATETIME'
            ],
            'close_at' => [
                'type' => 'DATETIME'
            ]
        ];
        $this->dbforge->add_field($field);
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('jobs_status', TRUE);
    }
}
