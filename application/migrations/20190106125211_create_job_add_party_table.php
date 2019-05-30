<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Create_job_add_party_table extends CI_Migration
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
                'type' => 'VARCHAR',
                'constraint' => 20
            ],
            'fname' => [
                'type' => 'VARCHAR',
                'constraint' => 50
            ],
            'lname' => [
                'type' => 'VARCHAR',
                'constraint' => 50
            ],
            'phone' => [
                'type' => 'VARCHAR',
                'constraint' => 20
            ],
            'email' => [
                'type' => 'VARCHAR',
                'constraint' => 50
            ]
        ];
        $this->dbforge->add_field($field);
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('job_add_party', TRUE);
    }

    public function down()
    {
        $this->dbforge->drop_table('job_add_party', TRUE);
    }
}
