<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Search extends CI_Controller
{
    private $title = 'Search';

    public function __construct()
    {
        parent::__construct();
    }

    public function search()
    {
        authAccess();

        // $this->form_validation->set_rules('keyword', 'Keyword', 'trim|required');

        // if ($this->form_validation->run() == TRUE) {}
    }
}
