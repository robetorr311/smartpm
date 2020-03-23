<?php
defined('BASEPATH') or exit('No direct script access allowed');

class UserOptions extends CI_Controller
{
    private $title = 'User Options';

    public function __construct()
    {
        parent::__construct();

        $this->load->model(['UserCellNotifSuffixModel']);

        $this->userCellNotifSuffix = new UserCellNotifSuffixModel();
    }

    public function index()
    {
        authAccess();

        $userCellNotifSuffixs = $this->userCellNotifSuffix->allCellNotifSuffix();

        $this->load->view('header', [
            'title' => $this->title
        ]);
        $this->load->view('setting/user-options', [
            'userCellNotifSuffixs' => $userCellNotifSuffixs
        ]);
        $this->load->view('footer');
    }

    public function insertCellNotifSuffix()
    {
        authAccess();

        $this->form_validation->set_rules('cell_provider', 'Cell Provider', 'trim|required');
        $this->form_validation->set_rules('suffix', 'Suffix', 'trim|required');

        if ($this->form_validation->run() == TRUE) {
            $data = $this->input->post();
            $insert = $this->userCellNotifSuffix->insert([
                'cell_provider' => $data['cell_provider'],
                'suffix' => $data['suffix']
            ]);
            if (!$insert) {
                $this->session->set_flashdata('errors', '<p>Unable to Create User Cell Notification Suffix.</p>');
            }
        } else {
            $this->session->set_flashdata('errors', validation_errors());
        }
        redirect('setting/user-options');
    }

    public function updateCellNotifSuffix($id)
    {
        authAccess();

        $this->form_validation->set_rules('cell_provider', 'Cell Provider', 'trim|required');
        $this->form_validation->set_rules('suffix', 'Suffix', 'trim|required');

        if ($this->form_validation->run() == TRUE) {
            $data = $this->input->post();
            $update = $this->userCellNotifSuffix->update($id, [
                'cell_provider' => $data['cell_provider'],
                'suffix' => $data['suffix']
            ]);
            if (!$update) {
                $this->session->set_flashdata('errors', '<p>Unable to Update User Cell Notification Suffix.</p>');
            }
        } else {
            $this->session->set_flashdata('errors', validation_errors());
        }

        redirect('setting/user-options');
    }

    public function deleteCellNotifSuffix($id)
    {
        authAccess();

        $this->userCellNotifSuffix->delete($id);
        redirect('setting/user-options');
    }
}