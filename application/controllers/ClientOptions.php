<?php
defined('BASEPATH') or exit('No direct script access allowed');

class ClientOptions extends CI_Controller
{
    private $title = 'Client Options';

    public function __construct()
    {
        parent::__construct();

        $this->load->model(['ClientLeadSourceModel', 'ClientClassificationModel']);

        $this->leadSource = new ClientLeadSourceModel();
        $this->classification = new ClientClassificationModel();
    }

    public function index()
    {
        authAccess();

        $leadSource = $this->leadSource->allLeadSource();
        $classification = $this->classification->allClassification();

        $this->load->view('header', [
            'title' => $this->title
        ]);
        $this->load->view('setting/client-options', [
            'leadSource' => $leadSource,
            'classification' => $classification
        ]);
        $this->load->view('footer');
    }

    public function insertLeadSource()
    {
        authAccess();

        $this->form_validation->set_rules('name', 'Name', 'trim|required');

        if ($this->form_validation->run() == TRUE) {
            $data = $this->input->post();
            $insert = $this->leadSource->insert([
                'name' => $data['name']
            ]);
            if (!$insert) {
                $this->session->set_flashdata('errors', '<p>Unable to Create Client Option Lead Source.</p>');
            }
        } else {
            $this->session->set_flashdata('errors', validation_errors());
        }
        redirect('setting/client-options');
    }

    public function updateLeadSource($id)
    {
        authAccess();

        $this->form_validation->set_rules('name', 'Name', 'trim|required');

        if ($this->form_validation->run() == TRUE) {
            $data = $this->input->post();
            $update = $this->leadSource->update($id, [
                'name' => $data['name']
            ]);
            if (!$update) {
                $this->session->set_flashdata('errors', '<p>Unable to Update Client Option Lead Source.</p>');
            }
        } else {
            $this->session->set_flashdata('errors', validation_errors());
        }

        redirect('setting/client-options');
    }

    public function deleteLeadSource($id)
    {
        authAccess();

        $this->leadSource->delete($id);
        redirect('setting/client-options');
    }

    public function insertClassification()
    {
        authAccess();

        $this->form_validation->set_rules('name', 'Name', 'trim|required');

        if ($this->form_validation->run() == TRUE) {
            $data = $this->input->post();
            $insert = $this->classification->insert([
                'name' => $data['name']
            ]);
            if (!$insert) {
                $this->session->set_flashdata('errors', '<p>Unable to Create Client Option Classification.</p>');
            }
        } else {
            $this->session->set_flashdata('errors', validation_errors());
        }
        redirect('setting/client-options');
    }

    public function updateClassification($id)
    {
        authAccess();

        $this->form_validation->set_rules('name', 'Name', 'trim|required');

        if ($this->form_validation->run() == TRUE) {
            $data = $this->input->post();
            $update = $this->classification->update($id, [
                'name' => $data['name']
            ]);
            if (!$update) {
                $this->session->set_flashdata('errors', '<p>Unable to Update Client Option Classification.</p>');
            }
        } else {
            $this->session->set_flashdata('errors', validation_errors());
        }

        redirect('setting/client-options');
    }

    public function deleteClassification($id)
    {
        authAccess();

        $this->classification->delete($id);
        redirect('setting/client-options');
    }
}