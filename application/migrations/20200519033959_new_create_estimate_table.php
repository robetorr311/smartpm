<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Create_estimate_table extends CI_Migration
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
            'estimate_no' => [
               'type' => 'INT',
               'constraint' => 11
           ],
            'client_id' => [
                'type' => 'INT',
                'constraint' => 11
            ],
            'item_id' => [
                'type' => 'JSON',
            ],
            'estimate_Date' => [
                'type' => 'DATE',
                
                
            ],
            'total' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => TRUE
            ],
            'balance_due' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => TRUE
           ],
            'estimate_total' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => TRUE
           ],
            'created_at TIMESTAMP default CURRENT_TIMESTAMP',
            'updated_at TIMESTAMP default CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'
        ];
        $this->dbforge->add_field($field);
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('estimate', TRUE);
    }

    public function down()
    {
        $this->dbforge->drop_table('estimate', TRUE);
    }
}
