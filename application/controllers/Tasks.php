<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Tasks extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        authAdminAccess();
        // sessionTimeout();

        $this->load->model('TaskModel');
        $this->load->library(['pagination', 'form_validation']);

        $this->task = new TaskModel();
    }

    public function index()
    {
        $start = ($this->uri->segment(2)) ? $this->uri->segment(2) : 0;
        $limit = 10;
        $pagiConfig = [
            'base_url' => base_url('tasks'),
            'total_rows' => $this->task->getCount(),
            'per_page' => $limit
        ];
        $this->pagination->initialize($pagiConfig);
        $tasks = $this->task->allTasks($start, $limit);
        $this->load->view('header', [
            'title' => 'Tasks'
        ]);
        $this->load->view('tasks/index', [
            'tasks' => $tasks,
            'pagiLinks' => $this->pagination->create_links()
        ]);
        $this->load->view('footer');
    }

    public function create()
    {
        $this->load->view('header', [
            'title' => 'Tasks'
        ]);
        $this->load->view('tasks/new');
        $this->load->view('footer');
    }

    public function store()
    {
        $this->form_validation->set_rules('name', 'Task Name', 'trim|required');
        $this->form_validation->set_rules('type', 'Type', 'trim|required|numeric');
        $this->form_validation->set_rules('level', 'Importance Level', 'trim|required|numeric');
        $this->form_validation->set_rules('assigned_to', 'Assigned To', 'trim|required|numeric');
        $this->form_validation->set_rules('note', 'Note', 'trim|required');

        if ($this->form_validation->run() == TRUE) {
            $taskData = $this->input->post();
            $insert = $this->task->insert([
                'name' => $taskData['name'],
                'type' => $taskData['type'],
                'level' => $taskData['level'],
                'assigned_to' => $taskData['assigned_to']
            ]);
            if ($insert) {
                $note = $taskData['note'];

                // insert note

                $jobs = $taskData['tag_clients'];
                $jobs = $this->extractTagsArray($jobs);

                $users = $taskData['tag_users'];
                $users = $this->extractTagsArray($users);

                $predec_tasks = $taskData['predecessor_tasks'];
                $predec_tasks = $this->extractTagsArray($predec_tasks);

                // if (preg_match_all('~(@\w+)~', $note, $matches, PREG_PATTERN_ORDER)) {
                //     $usernames = $matches[1];
                //     array_merge($users, $usernames);
                // }

                // insert TaskJobTags

                // insert TaskUserTags

                // insert TaskPredecessor

                redirect('task/' + $insert);
            }

            $this->session->set_flashdata('errors', '<p>Unable to Create Task.</p>');
        } else {
            $this->session->set_flashdata('errors', validation_errors());
            redirect('task/create');
        }
    }

    public function delete()
    {
        $id = $this->uri->segment(2);
        if ($id) {
            // check with TaskPredecessor

            $this->task->delete($id);
        } else {
            $this->session->set_flashdata('errors', '<p>Invalid Request.</p>');
        }
        redirect('tasks');
    }

    private function extractTagsArray($string)
    {
        $string = preg_replace('/ /', '', $string);
        $string = preg_replace('/,/', '', $string);
        $string = explode('@', $string);
        return $string;
    }
}
