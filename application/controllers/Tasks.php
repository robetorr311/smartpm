<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Tasks extends CI_Controller
{
    private $title = 'Tasks';

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
            'title' => $this->title
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
            'title' => $this->title
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
                $errors = '';
                $note = $taskData['note'];

                $noteInsert = $this->task_notes->insert([
                    'note' => nl2br($note),
                    'task_id' => $insert
                ]);
                if (!$noteInsert) {
                    $errors .= '<p>Unable to add Note.</p>';
                }

                // $jobs = $taskData['tag_clients'];
                // if (!empty($jobs)) {
                //     $jobs = explode(',', $jobs);
                //     $jobsInsert = $this->task_job_tags->insertByJobArr($jobs, $insert);
                //     if (!$jobsInsert) {
                //         $errors .= '<p>Unable to tag Jobs.</p>';
                //     }
                // }

                // if (preg_match_all('~(@\w+)~', $note, $matches, PREG_PATTERN_ORDER)) {
                //     $usernames = $matches[1];
                //     array_merge($users, $usernames);
                // }

                $users = $taskData['tag_users'];
                if (!empty($users)) {
                    $users = explode(',', $users);
                    $usersInsert = $this->task_user_tags->insertByUserArr($users, $insert);
                    if (!$usersInsert) {
                        $errors .= '<p>Unable to tag Users.</p>';
                    }
                }

                $predec_tasks = $taskData['predecessor_tasks'];
                if (!empty($predec_tasks)) {
                    $predec_tasks = explode(',', $predec_tasks);
                    $predec_tasksInsert = $this->task_predecessor->insertByTaskArr($predec_tasks, $insert);
                    if (!$predec_tasksInsert) {
                        $errors .= '<p>Unable to tag Predecessor Tasks.</p>';
                    }
                }

                if (!empty($errors)) {
                    $this->session->set_flashdata('errors', $errors);
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

    public function complete($id)
    {
        $completed = $this->task->complete($id);
        if (!$completed) {
            $this->session->set_flashdata('errors', '<p>Unable to mark Task as Completed.</p>');
        }
        redirect('tasks');
    }

    public function edit($id)
    {
        $task = $this->task->getTaskById($id);
        if ($task) {
            $types = TaskModel::getTypes();
            $levels = TaskModel::getLevels();
            $status = TaskModel::getStatus();
            $tasks = $this->task->getTaskListExcept($id);
            $users = $this->login->getUserList();
            // $jobs = false;
            $tag_users = $this->task_user_tags->getUsersByTaskId($id);
            $predec_tasks = $this->task_predecessor->getTasksByTaskId($id);
            $this->load->view('header', [
                'title' => $this->title
            ]);
            $this->load->view('tasks/edit', [
                'task' => $task,
                'types' => $types,
                'levels' => $levels,
                'tasks' => $tasks,
                'users' => $users,
                'status' => $status,
                'tag_users' => $tag_users,
                'predec_tasks' => $predec_tasks
            ]);
            $this->load->view('footer');
        } else {
            redirect('tasks');
        }
    }

    public function update($id)
    {
        $task = $this->task->getTaskById($id);
        if ($task) {
            $this->form_validation->set_rules('name', 'Task Name', 'trim|required');
            $this->form_validation->set_rules('type', 'Type', 'trim|required|numeric');
            $this->form_validation->set_rules('level', 'Importance Level', 'trim|required|numeric');
            $this->form_validation->set_rules('assigned_to', 'Assigned To', 'trim|required|numeric');
            $this->form_validation->set_rules('status', 'Status', 'trim|required|numeric');
            $this->form_validation->set_rules('tag_clients', 'Tag Clients', 'is_own_ids[jobs, Clients]');
            $this->form_validation->set_rules('tag_users', 'Tag Users', 'is_own_ids[users, Users]');
            $this->form_validation->set_rules('predecessor_tasks', 'Predecessor Tasks', 'is_own_ids[tasks, Tasks]');

            if ($this->form_validation->run() == TRUE) {
                $taskData = $this->input->post();
                $update = $this->task->update($id, [
                    'name' => $taskData['name'],
                    'type' => $taskData['type'],
                    'level' => $taskData['level'],
                    'assigned_to' => $taskData['assigned_to'],
                    'status' => $taskData['status']
                ]);
                if ($update) {
                    $errors = '';

                    // $jobs = $taskData['tag_clients'];
                    // if (!empty($jobs)) {
                    //     $jobs = explode(',', $jobs);
                    //     $jobsInsert = $this->task_job_tags->insertByJobArr($jobs, $id);
                    //     if (!$jobsInsert) {
                    //         $errors .= '<p>Unable to tag new Jobs.</p>';
                    //     }
                    // }

                    // if (preg_match_all('~(@\w+)~', $note, $matches, PREG_PATTERN_ORDER)) {
                    //     $usernames = $matches[1];
                    //     array_merge($users, $usernames);
                    // }

                    $old_tag_users = $this->task_user_tags->getUsersByTaskId($id);
                    $old_tag_users = ($old_tag_users) ? array_column($old_tag_users, 'id') : [];
                    $users = $taskData['tag_users'];
                    $users = (!empty($users)) ? explode(',', $users) : [];
                    $users_insert = array_diff($users, $old_tag_users);
                    if (count($users_insert)) {
                        $usersInsert = $this->task_user_tags->insertByUserArr($users_insert, $id);
                        if (!$usersInsert) {
                            $errors .= '<p>Unable to tag new Users.</p>';
                        }
                    }
                    $users_remove = array_diff($old_tag_users, $users);
                    if (count($users_remove)) {
                        $usersRemove = $this->task_user_tags->deleteByUserArr($users_remove, $id);
                        if (!$usersRemove) {
                            $errors .= '<p>Unable to remove tagged Users.</p>';
                        }
                    }

                    $old_predec_tasks = $this->task_predecessor->getTasksByTaskId($id);
                    $old_predec_tasks = ($old_predec_tasks) ? array_column($old_predec_tasks, 'id') : [];
                    $predec_tasks = $taskData['predecessor_tasks'];
                    $predec_tasks = (!empty($predec_tasks)) ? explode(',', $predec_tasks) : [];
                    $predec_tasks_insert = array_diff($predec_tasks, $old_predec_tasks);
                    if (count($predec_tasks_insert)) {
                        $predec_tasksInsert = $this->task_predecessor->insertByTaskArr($predec_tasks_insert, $id);
                        if (!$predec_tasksInsert) {
                            $errors .= '<p>Unable to tag new Predecessor Tasks.</p>';
                        }
                    }
                    $predec_tasks_remove = array_diff($old_predec_tasks, $predec_tasks);
                    if (count($predec_tasks_remove)) {
                        $predec_tasksRemove = $this->task_predecessor->deleteByTaskArr($predec_tasks_remove, $id);
                        if (!$predec_tasksRemove) {
                            $errors .= '<p>Unable to tag new Predecessor Tasks.</p>';
                        }
                    }

                    if (!empty($errors)) {
                        $this->session->set_flashdata('errors', $errors);
                    }

                    redirect('task/' . $id);
                }

                $this->session->set_flashdata('errors', '<p>Unable to Update Task.</p>');
                redirect('task/' . $id . '/edit');
            } else {
                $this->session->set_flashdata('errors', validation_errors());
                redirect('task/' . $id . '/edit');
            }
        } else {
            redirect('tasks');
        }
    }

    public function show($id)
    {
        $task = $this->task->getTaskById($id);
        if ($task) {
            $notes = $this->task_notes->getNotesByTaskId($id);
            $jobs = false;
            $users = $this->task_user_tags->getUsersByTaskId($id);
            $predec_tasks = $this->task_predecessor->getTasksByTaskId($id);
            $this->load->view('header', [
                'title' => $this->title
            ]);
            $this->load->view('tasks/show', [
                'task' => $task,
                'notes' => $notes,
                'jobs' => $jobs,
                'users' => $users,
                'predec_tasks' => $predec_tasks
            ]);
            $this->load->view('footer');
        } else {
            redirect('tasks');
        }
    }

    public function addNote($id)
    {
        $task = $this->task->getTaskById($id);
        if ($task) {
            $this->form_validation->set_rules('note', 'Note', 'trim|required');

            if ($this->form_validation->run() == TRUE) {
                $noteData = $this->input->post();
                $insert = $this->task_notes->insert([
                    'note' => nl2br($noteData['note']),
                    'task_id' => $id
                ]);
                if (!$insert) {
                    $this->session->set_flashdata('errors', '<p>Unable to add Note.</p>');
                }
            } else {
                $this->session->set_flashdata('errors', validation_errors());
            }
            redirect('task/' . $id);
        } else {
            redirect('tasks');
        }
    }

    public function deleteNote($id, $note_id)
    {
        $delete = $this->task_notes->delete($note_id, $id);
        if (!$delete) {
            $this->session->set_flashdata('errors', '<p>Unable to Delete Note.</p>');
        }
        redirect('task/' . $id);
    }

    public function delete($id)
    {
        $task = $this->task->getTaskById($id);
        if ($task) {
            $this->task_notes->deleteRelated($id);
            $this->task_job_tags->deleteRelated($id);
            $this->task_user_tags->deleteRelated($id);
            $this->task_predecessor->deleteRelated($id);
            $delete = $this->task->delete($id);
            if (!$delete) {
                $this->session->set_flashdata('errors', '<p>Unable to delete Task.</p>');
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
