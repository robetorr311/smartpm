<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Create_jobs_table extends CI_Migration
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
            'job_name' => [
                'type' => 'VARCHAR',
                'constraint' => 50
            ],
            'report_id' => [
                'type' => 'INT',
                'constraint' => 10,
            ],
            'firstname' => [
                'type' => 'VARCHAR',
                'constraint' => 50
            ],
            'lastname' => [
                'type' => 'VARCHAR',
                'constraint' => 50
            ],
            'address' => [
                'type' => 'VARCHAR',
                'constraint' => 100
            ],
            'city' => [
                'type' => 'VARCHAR',
                'constraint' => 50
            ],
            'state' => [
                'type' => 'VARCHAR',
                'constraint' => 50
            ],
            'zip' => [
                'type' => 'INT',
                'constraint' => 5,
            ],
            'phone1' => [
                'type' => 'VARCHAR',
                'constraint' => 20
            ],
            'phone2' => [
                'type' => 'VARCHAR',
                'constraint' => 20
            ],
            'email' => [
                'type' => 'VARCHAR',
                'constraint' => 50
            ],
            'job_number' => [
                'type' => 'VARCHAR',
                'constraint' => 20
            ],
            'status' => [
                'type' => 'VARCHAR',
                'constraint' => 20
            ],
            'is_active' => [
                'type' => 'TINYINT',
                'constraint' => 4
            ],
            'entry_date' => [
                'type' => 'DATETIME'
            ]
        ];
        $this->dbforge->add_field($field);
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('jobs', TRUE);
    }

    public function down()
    {
        $this->dbforge->drop_table('jobs', TRUE);
    }
}
