<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Tasks extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        authAdminAccess();
        // sessionTimeout();

        $this->load->model(['TaskModel', 'Login', 'TaskNotesModel', 'TaskUserTagsModel', 'TaskPredecessorModel', 'TaskJobTagsModel']);
        $this->load->library(['pagination', 'form_validation']);

        $this->task = new TaskModel();
        $this->login = new Login();
        $this->task_notes = new TaskNotesModel();
        $this->task_user_tags = new TaskUserTagsModel();
        $this->task_predecessor = new TaskPredecessorModel();
        $this->task_job_tags = new TaskJobTagsModel();
    }

    public function index($start = 0)
    {
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
        $types = TaskModel::getTypes();
        $levels = TaskModel::getLevels();
        $tasks = $this->task->getTaskList();
        $users = $this->login->getUserList();

        $this->load->view('header', [
            'title' => 'Tasks'
        ]);
        $this->load->view('tasks/create', [
            'types' => $types,
            'levels' => $levels,
            'tasks' => $tasks,
            'users' => $users
        ]);
        $this->load->view('footer');
    }

    public function store()
    {
        $this->form_validation->set_rules('name', 'Task Name', 'trim|required');
        $this->form_validation->set_rules('type', 'Type', 'trim|required|numeric');
        $this->form_validation->set_rules('level', 'Importance Level', 'trim|required|numeric');
        $this->form_validation->set_rules('assigned_to', 'Assigned To', 'trim|required|numeric');
        $this->form_validation->set_rules('note', 'Note', 'trim|required');
        $this->form_validation->set_rules('tag_clients', 'Tag Clients', 'is_own_ids[jobs, Clients]');
        $this->form_validation->set_rules('tag_users', 'Tag Users', 'is_own_ids[users, Users]');
        $this->form_validation->set_rules('predecessor_tasks', 'Predecessor Tasks', 'is_own_ids[tasks, Tasks]');

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

                $this->task_notes->insert([
                    'note' => $note,
                    'task_id' => $insert
                ]);

                $jobs = $taskData['tag_clients'];
                if (!empty($jobs)) {
                    $jobs = explode(',', $jobs);
                    $this->task_job_tags->insertByJobArr($jobs, $insert);
                }

                // if (preg_match_all('~(@\w+)~', $note, $matches, PREG_PATTERN_ORDER)) {
                //     $usernames = $matches[1];
                //     array_merge($users, $usernames);
                // }

                $users = $taskData['tag_users'];
                if (!empty($users)) {
                    $users = explode(',', $users);
                    $this->task_user_tags->insertByUserArr($users, $insert);
                }

                $predec_tasks = $taskData['predecessor_tasks'];
                if (!empty($predec_tasks)) {
                    $predec_tasks = explode(',', $predec_tasks);
                    $this->task_predecessor->insertByTaskArr($predec_tasks, $insert);
                }

                redirect('task/' . $insert);
            }

            $this->session->set_flashdata('errors', '<p>Unable to Create Task.</p>');
            redirect('task/create');
        } else {
            $this->session->set_flashdata('errors', validation_errors());
            redirect('task/create');
        }
    }

    // public function edit()
    // {
    //     $this->load->view('header', [
    //         'title' => 'Tasks'
    //     ]);
    //     $this->load->view('tasks/create');
    //     $this->load->view('footer');
    // }

    public function show($id)
    {
        echo $id;
    }

    public function delete($id)
    {
        if ($id) {
            if ($this->task->isAllowedToDelete($id)) {
                $this->task_notes->deleteRelated($id);
                $this->task_job_tags->deleteRelated($id);
                $this->task_user_tags->deleteRelated($id);
                $this->task_predecessor->deleteRelated($id);
                $this->task->delete($id);
            } else {
                $this->session->set_flashdata('errors', '<p>Predecessor Tasks not Completed.</p>');
            }
        } else {
            $this->session->set_flashdata('errors', '<p>Invalid Request.</p>');
        }
        redirect('tasks');
    }

    /**
     * Private Methods
     */

    // private function extractTagsArray($string)
    // {
    //     $string = preg_replace('/ /', '', $string);
    //     $string = preg_replace('/,/', '', $string);
    //     $string = explode('@', $string);
    //     return $string;
    // }
}
