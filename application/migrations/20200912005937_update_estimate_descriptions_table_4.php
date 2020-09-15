<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Update_estimate_descriptions_table_4 extends CI_Migration
{
    public function __construct()
    {
        parent::__construct();
        $this->load->dbforge();
    }

    public function up()
    {
        $fields = [
            'quantity_units' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'after' => 'amount'
            ],
            'unit_price' => [
                'type' => 'DECIMAL',
                'constraint' => '11,2',
                'after' => 'quantity_units'
            ]
        ];

        $this->dbforge->add_column('estimate_descriptions', $fields);
        $this->db->query('UPDATE estimate_descriptions JOIN items ON estimate_descriptions.item=items.id SET estimate_descriptions.quantity_units=items.quantity_units, estimate_descriptions.unit_price=items.unit_price');
    }

    public function down()
    {
        $this->dbforge->drop_column('estimate_descriptions', 'quantity_units');
        $this->dbforge->drop_column('estimate_descriptions', 'unit_price');
    }
}
