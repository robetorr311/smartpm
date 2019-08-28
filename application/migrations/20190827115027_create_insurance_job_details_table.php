<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Create_insurance_job_details_table extends CI_Migration
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
            'insurance_carrier' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => TRUE
            ],
            'carrier_phone' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
                'null' => TRUE
            ],
            'carrier_email' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => TRUE
            ],
            'policy_number' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
                'null' => TRUE
            ],
            'date_of_loss' => [
                'type' => 'DATE',
                'null' => TRUE
            ],
            'adjuster' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => TRUE
            ],
            'adjuster_phone' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
                'null' => TRUE
            ],
            'adjuster_email' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => TRUE
            ],
            'job_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => TRUE
            ],
            'created_at TIMESTAMP default CURRENT_TIMESTAMP',
            'updated_at TIMESTAMP default CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'
        ];
        $this->dbforge->add_field($field);
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('insurance_job_details', TRUE);
    }

    public function down()
    {
        $this->dbforge->drop_table('insurance_job_details', TRUE);
    }
}
