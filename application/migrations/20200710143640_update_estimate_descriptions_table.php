<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Update_estimate_descriptions_table extends CI_Migration
{
    public function __construct()
    {
        parent::__construct();
        $this->load->dbforge();
    }

    public function up()
    {
        $fields = [
            'item' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => FALSE,
                'after' => 'id'
            ]
        ];

        $this->dbforge->drop_column('estimate_descriptions', 'description');
        $this->dbforge->add_column('estimate_descriptions', $fields);
    }

    public function down()
    {
        $fields = [
            'description' => [
                'type' => 'VARCHAR',
                'constraint' => 500,
                'null' => FALSE,
                'after' => 'id'
            ]
        ];

        $this->dbforge->drop_column('estimate_descriptions', 'item');
        $this->dbforge->add_column('estimate_descriptions', $fields);
    }
}
