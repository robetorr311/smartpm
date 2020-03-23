<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Create_user_cell_notif_suffixs_table extends CI_Migration
{
    public function __construct()
    {
        parent::__construct();
        $this->load->dbforge();
    }
    public function up()
    {
        $field = [
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'auto_increment' => TRUE
            ],
            'cell_provider' => [
                'type' => 'VARCHAR',
                'constraint' => 100
            ],
            'suffix' => [
                'type' => 'VARCHAR',
                'constraint' => 100
            ],
            'is_deleted' => [
                'type' => 'BOOLEAN',
                'default' => FALSE
            ],
            'created_at TIMESTAMP default CURRENT_TIMESTAMP',
            'updated_at TIMESTAMP default CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'
        ];
        $this->dbforge->add_field($field);
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('user_cell_notif_suffixs', TRUE);
    }

    public function down()
    {
        $this->dbforge->drop_table('user_cell_notif_suffixs', TRUE);
    }
}
