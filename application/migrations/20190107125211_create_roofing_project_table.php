<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Create_roofing_project_table extends CI_Migration
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
                'constraint' => 10
            ],
            'firstname' => [
                'type' => 'VARCHAR',
                'constraint' => 100
            ],
            'lastname' => [
                'type' => 'VARCHAR',
                'constraint' => 100
            ],
            'address' => [
                'type' => 'VARCHAR',
                'constraint' => 200
            ],
            'phone' => [
                'type' => 'VARCHAR',
                'constraint' => 20
            ],
            'imageboxdata' => [
                'type' => 'LONGTEXT'
            ],
            'imagebox' => [
                'type' => 'VARCHAR',
                'constraint' => 200
            ],
            'entry_date' => [
                'type' => 'DATETIME'
            ],
            'active' => [
                'type' => 'INT',
                'constraint' => 10
            ]
        ];
        $this->dbforge->add_field($field);
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('roofing_project', TRUE);
    }

    public function down()
    {
        $this->dbforge->drop_table('roofing_project', TRUE);
    }
}
