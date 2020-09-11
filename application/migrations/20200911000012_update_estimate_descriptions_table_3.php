<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Update_estimate_descriptions_table_3 extends CI_Migration
{
    public function __construct()
    {
        parent::__construct();
        $this->load->dbforge();
    }

    public function up()
    {
        $fields = [
            'order' => [
                'type' => 'INT',
                'constraint' => 11,
                'after' => 'description_group_id'
            ]
        ];

        $this->dbforge->add_column('estimate_descriptions', $fields);
    }

    public function down()
    {
        $this->dbforge->drop_column('estimate_descriptions', 'order');
    }
}
