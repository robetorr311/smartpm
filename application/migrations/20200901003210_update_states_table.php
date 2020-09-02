<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Update_states_table extends CI_Migration
{
    public function __construct()
    {
        parent::__construct();
        $this->load->dbforge();
    }
    public function up()
    {
        $fields = [
            'is_default' => [
                'type' => 'BOOLEAN',
                'default' => FALSE,
                'after' => 'name'
            ]
        ];
        
        $this->dbforge->add_column('states', $fields);
    }

    public function down()
    {
        $this->dbforge->drop_column('states', 'is_default');
    }
}
