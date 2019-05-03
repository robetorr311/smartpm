<?php

class MY_Form_validation extends CI_Form_validation
{
    protected $CI;

    public function __construct()
    {
        parent::__construct();
        $this->CI = &get_instance();
    }

    public function is_own_ids($ids, $args)
    {
        $args = explode(',', $args);
        $table = trim($args[0]);
        $item = trim($args[1]);
        $ids = explode(',', $ids);
        $this->CI->db->where_in('id', $ids);
        $count = $this->CI->db->count_all_results($table);
        if ($count != count($ids)) {
            $this->CI->form_validation->set_message('is_own_ids', 'The {field} contains invalid ' . $item . '.');
            return false;
        } else {
            return true;
        }
    }
}
