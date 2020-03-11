<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Create_box_names_table extends CI_Migration
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
                'auto_increment' => TRUE
            ],
            'name' => [
                'type' => 'VARCHAR',
                'constraint' => 100
            ],
            'label' => [
                'type' => 'VARCHAR',
                'constraint' => 100
            ],
            'is_deleted' => [
                'type' => 'BOOLEAN',
                'default' => FALSE
            ],
            'created_at TIMESTAMP default CURRENT_TIMESTAMP',
            'updated_at TIMESTAMP default CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'
        ];
        $this->dbforge->add_field($field);
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('box_names', TRUE);

        $this->db->query("INSERT INTO box_names (name, label) VALUES ('New', 'New'), ('Appointment Scheduled', 'Appointment<br>Scheduled'), ('Needs Follow Up Call', 'Needs Follow Up<br>Call'), ('Needs Site Visit', 'Needs Site<br>Visit'), ('Needs Estimate / Bid', 'Needs<br>Estimate / Bid'), ('Estimate Sent', 'Estimate Sent'), ('Ready to Sign / Verbal Go', 'Ready to<br>Sign / Verbal Go'), ('Cold', 'Cold'), ('Postponed', 'Postponed'), ('Lost', 'Lost'), ('Signed', 'Signed'), ('Production', 'Production'), ('Completed', 'Completed'), ('Closed', 'Closed'), ('Archive', 'Archive'), ('Created', 'Created'), ('Working', 'Working'), ('Stuck', 'Stuck'), ('Hold', 'Hold'), ('Completed', 'Completed')");
    }

    public function down()
    {
        $this->dbforge->drop_table('box_names', TRUE);
    }
}
