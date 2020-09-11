<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Update_estimate_description_groups_table extends CI_Migration
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
                'after' => 'estimate_id'
            ]
        ];

        $this->dbforge->add_column('estimate_description_groups', $fields);
    }

    public function down()
    {
        $this->dbforge->drop_column('estimate_description_groups', 'order');
    }
}
