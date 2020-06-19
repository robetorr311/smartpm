<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Alter_estimate_table extends CI_Migration
{
    public function __construct()
    {
        parent::__construct();
        $this->load->dbforge();
    }
    public function up()
{
    $fields = array(
        'item_id' => array(
          'type' => 'TEXT',
          'after' => 'client_id'
        )
      );
      $this->dbforge->add_column('estimate', $fields);
    }

    public function down()
    {
        
        $this->dbforge->drop_column('estimate', 'item_id');
        $this->dbforge->drop_table('estimate', TRUE);
    }
}
