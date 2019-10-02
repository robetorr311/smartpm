<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Update_insurance_job_details_table extends CI_Migration
{
    public function __construct()
    {
        parent::__construct();
        $this->load->dbforge();
    }

    public function up()
    {
        $this->dbforge->drop_column('insurance_job_details', 'adjuster');
        $this->dbforge->drop_column('insurance_job_details', 'adjuster_phone');
        $this->dbforge->drop_column('insurance_job_details', 'adjuster_email');
    }

    public function down()
    {
        $fields = [
            'adjuster' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => TRUE,
                'after' => 'date_of_loss'
            ],
            'adjuster_phone' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
                'null' => TRUE,
                'after' => 'adjuster'
            ],
            'adjuster_email' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => TRUE,
                'after' => 'adjuster_phone'
            ]
        ];

        $this->dbforge->add_column('insurance_job_details', $fields);
    }
}
