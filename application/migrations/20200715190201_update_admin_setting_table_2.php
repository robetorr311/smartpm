<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Update_admin_setting_table_2 extends CI_Migration
{
    public function __construct()
    {
        parent::__construct();
        $this->load->dbforge();
    }

    public function up()
    {
        $fields = [
            'company_name' => [
                'type' => 'VARCHAR',
                'constraint' => 100
            ],
            'company_address' => [
                'type' => 'VARCHAR',
                'constraint' => 500
            ],
            'company_phone' => [
                'type' => 'VARCHAR',
                'constraint' => 20
            ],
            'company_website' => [
                'type' => 'VARCHAR',
                'constraint' => 100
            ],
            'company_email' => [
                'type' => 'VARCHAR',
                'constraint' => 100
            ]
        ];

        $this->dbforge->add_column('admin_setting', $fields);
    }

    public function down()
    {
        $this->dbforge->drop_column('admin_setting', 'company_name');
        $this->dbforge->drop_column('admin_setting', 'company_address');
        $this->dbforge->drop_column('admin_setting', 'company_phone');
        $this->dbforge->drop_column('admin_setting', 'company_website');
        $this->dbforge->drop_column('admin_setting', 'company_email');
    }
}
