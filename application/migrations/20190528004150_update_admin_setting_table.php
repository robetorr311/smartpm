<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Update_admin_setting_table extends CI_Migration
{
    public function __construct()
    {
        parent::__construct();
        $this->load->dbforge();
    }

    public function up()
    {
        $modifyFields = [
            'user_id' => [
                'name' => 'company_id',
                'type' => 'INT',
                'constraint' => 10
            ]
        ];

        $this->dbforge->modify_column('admin_setting', $modifyFields);
    }

    public function down()
    {
        $modifyFields = [
            'company_id' => [
                'name' => 'user_id',
                'type' => 'INT',
                'constraint' => 10
            ]
        ];

        $this->dbforge->modify_column('admin_setting', $modifyFields);
    }
}
