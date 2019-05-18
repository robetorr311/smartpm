<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Update_roofing_project_table extends CI_Migration
{
    public function __construct()
    {
        parent::__construct();
        $this->load->dbforge();
    }

    public function up()
    {
        $fields = [
            'imagebox' => [
                'type' => 'longtext'
            ],
        ];
        $this->dbforge->modify_column('roofing_project', $fields);
        
    }

    public function down()
    {
        $fields = [
            'imagebox' => [
                'type' => 'varchar',
                'constraint' => 200
            ]
        ];
        $this->dbforge->modify_column('roofing_project', $fields);
    }
}
