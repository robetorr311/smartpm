<?php
defined('BASEPATH') or exit('No direct script access allowed');

class ItemOptions extends CI_Controller
{
    private $title = 'Item Options';

    public function __construct()
    {
        parent::__construct();

        $this->load->model(['ItemGroupModel']);

        $this->itemGroup = new ItemGroupModel();
    }

    public function index()
    {
        authAccess();

        $itemGroups = $this->itemGroup->allItemGroups();

        $this->load->view('header', [
            'title' => $this->title
        ]);
        $this->load->view('setting/item-options', [
            'itemGroups' => $itemGroups
        ]);
        $this->load->view('footer');
    }

    public function insertItemGroup()
    {
        authAccess();

        $this->form_validation->set_rules('name', 'Name', 'trim|required');

        if ($this->form_validation->run() == TRUE) {
            $data = $this->input->post();
            $insert = $this->itemGroup->insert([
                'name' => $data['name']
            ]);
            if (!$insert) {
                $this->session->set_flashdata('errors', '<p>Unable to Create Option Item Group.</p>');
            }
        } else {
            $this->session->set_flashdata('errors', validation_errors());
        }
        redirect('setting/item-options');
    }

    public function updateItemGroup($id)
    {
        authAccess();

        $this->form_validation->set_rules('name', 'Name', 'trim|required');

        if ($this->form_validation->run() == TRUE) {
            $data = $this->input->post();
            $update = $this->itemGroup->update($id, [
                'name' => $data['name']
            ]);
            if (!$update) {
                $this->session->set_flashdata('errors', '<p>Unable to Update Option Item Group.</p>');
            }
        } else {
            $this->session->set_flashdata('errors', validation_errors());
        }

        redirect('setting/item-options');
    }

    public function deleteItemGroup($id)
    {
        authAccess();

        $this->itemGroup->delete($id);
        redirect('setting/item-options');
    }
}