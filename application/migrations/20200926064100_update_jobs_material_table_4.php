<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Update_jobs_material_table_3 extends CI_Migration
{
    public function __construct()
    {
        parent::__construct();
        $this->load->dbforge();
    }

    public function up()
    {
        $fields = [
            'po_no' => [
                'type' => 'INT',
                'constraint' => 11,
                'default' => NULL
            ]
        ];

        $this->dbforge->modify_column('jobs_material', $fields);
    }

    public function down()
    {
        $this->dbforge->drop_column('jobs_material', 'po_no');
    }
}
