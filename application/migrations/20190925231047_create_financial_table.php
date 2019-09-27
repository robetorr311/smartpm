<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Create_financial_table extends CI_Migration
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
            'transaction_date' => [
                'type' => 'DATE'
            ],
            'transaction_number' => [
                'type' => 'VARCHAR',
                'constraint' => 50
            ],
            'job_id' => [
                'type' => 'INT',
                'constraint' => 11
            ],
            'amount' => [
                'type' => 'INT',
                'constraint' => 11
            ],
            'type' => [
                'type' => 'INT',
                'constraint' => 11
            ],
            'subtype' => [
                'type' => 'INT',
                'constraint' => 11
            ],
            'accounting_code' => [
                'type' => 'INT',
                'constraint' => 11
            ],
            'method' => [
                'type' => 'INT',
                'constraint' => 11
            ],
            'bank_account' => [
                'type' => 'INT',
                'constraint' => 11
            ],
            'state' => [
                'type' => 'INT',
                'constraint' => 11
            ],
            'week' => [
                'type' => 'INT',
                'constraint' => 11
            ],
            'sales_rep' => [
                'type' => 'INT',
                'constraint' => 11
            ],
            'notes' => [
                'type' => 'TEXT',
                'null' => TRUE
            ],
            'created_by' => [
                'type' => 'INT',
                'constraint' => 11
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
        $this->dbforge->create_table('financial', TRUE);
    }

    public function down()
    {
        $this->dbforge->drop_table('financial', TRUE);
    }
}
