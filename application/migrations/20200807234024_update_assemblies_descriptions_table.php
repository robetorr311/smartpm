<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Update_assemblies_descriptions_table extends CI_Migration
{
    public function __construct()
    {
        parent::__construct();
        $this->load->dbforge();
    }

    public function up()
    {
        $fields = [
            'description' => [
                'type' => 'VARCHAR',
                'constraint' => 500,
                'null' => FALSE,
                'after' => 'item'
            ]
        ];

        $this->dbforge->add_column('assemblies_descriptions', $fields);
    }

    public function down()
    {
        $this->dbforge->drop_column('assemblies_descriptions', 'description');
    }
}
