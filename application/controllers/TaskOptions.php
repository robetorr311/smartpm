<?php
defined('BASEPATH') or exit('No direct script access allowed');

class TaskOptions extends CI_Controller
{
    private $title = 'Task Options';

    public function __construct()
    {
        parent::__construct();

        $this->load->model(['TaskTypeModel']);

        $this->taskType = new TaskTypeModel();
    }

    public function index()
    {
        authAccess();

        $taskTypes = $this->taskType->allTypes();

        $this->load->view('header', [
            'title' => $this->title
        ]);
        $this->load->view('setting/task-options', [
            'taskTypes' => $taskTypes
        ]);
        $this->load->view('footer');
    }

    public function insertType()
    {
        authAccess();

        $this->form_validation->set_rules('name', 'Name', 'trim|required');

        if ($this->form_validation->run() == TRUE) {
            $data = $this->input->post();
            $insert = $this->taskType->insert([
                'name' => $data['name']
            ]);
            if (!$insert) {
                $this->session->set_flashdata('errors', '<p>Unable to Create Task Option Type.</p>');
            }
        } else {
            $this->session->set_flashdata('errors', validation_errors());
        }
        redirect('setting/task-options');
    }

    public function updateType($id)
    {
        authAccess();

        $this->form_validation->set_rules('name', 'Name', 'trim|required');

        if ($this->form_validation->run() == TRUE) {
            $data = $this->input->post();
            $update = $this->taskType->update($id, [
                'name' => $data['name']
            ]);
            if (!$update) {
                $this->session->set_flashdata('errors', '<p>Unable to Update Task Option Type.</p>');
            }
        } else {
            $this->session->set_flashdata('errors', validation_errors());
        }

        redirect('setting/task-options');
    }

    public function deleteType($id)
    {
        authAccess();

        $this->taskType->delete($id);
        redirect('setting/task-options');
    }
}