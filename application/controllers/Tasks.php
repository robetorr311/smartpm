<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Tasks extends CI_Controller
{
    private $title = 'Tasks';

    public function __construct()
    {
        parent::__construct();

        $this->load->model(['TaskModel', 'UserModel', 'TaskNotesModel', 'TaskUserTagsModel', 'TaskPredecessorModel', 'TaskJobTagsModel', 'TaskTypeModel']);
        $this->load->library(['form_validation', 'notify']);

        $this->task = new TaskModel();
        $this->user = new UserModel();
        $this->task_notes = new TaskNotesModel();
        $this->task_user_tags = new TaskUserTagsModel();
        $this->task_predecessor = new TaskPredecessorModel();
        $this->task_job_tags = new TaskJobTagsModel();
        $this->taskType = new TaskTypeModel();
    }

    public function index()
    {
        authAccess();

        $tasks = $this->task->allTasks();
        $this->load->view('header', [
            'title' => $this->title
        ]);
        $this->load->view('tasks/index', [
            'tasks' => $tasks
        ]);
        $this->load->view('footer');
    }

    public function status($status)
    {
        authAccess();

        $tasks = $this->task->allTasksByStatus($status);
        $this->load->view('header', [
            'title' => $this->title
        ]);
        $this->load->view('tasks/index', [
            'tasks' => $tasks
        ]);
        $this->load->view('footer');
    }

    public function create()
    {
        authAccess();

        $levels = TaskModel::getLevels();
        $tasks = $this->task->getTaskList();
        $users = $this->user->getUserList();
        $taskTypes = $this->taskType->allTypes();

        $this->load->view('header', [
            'title' => $this->title
        ]);
        $this->load->view('tasks/create', [
            'types' => $taskTypes,
            'levels' => $levels,
            'tasks' => $tasks,
            'users' => $users
        ]);
        $this->load->view('footer');
    }

    public function store()
    {
        authAccess();

        $typeKeys = implode(',', array_column($this->taskType->allTypes(), 'id'));
        $levelKeys = implode(',', array_keys(TaskModel::getLevels()));
        $userKeys = implode(',', array_column($this->user->getUserList(), 'id'));

        $this->form_validation->set_rules('name', 'Task Name', 'trim|required');
        $this->form_validation->set_rules('type', 'Type', 'trim|required|numeric|in_list[' . $typeKeys . ']');
        $this->form_validation->set_rules('level', 'Importance Level', 'trim|required|numeric|in_list[' . $levelKeys . ']');
        $this->form_validation->set_rules('assigned_to', 'Assigned To', 'trim|required|numeric|in_list[' . $userKeys . ']');
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
                $assignedUser = $this->user->getUserById($taskData['assigned_to']);
                $this->notify = new Notify();
                $this->notify->sendTaskAssignNotification($assignedUser->email_id, $insert, $taskData['name']);

                $errors = '';
                if (!empty(trim($taskData['note']))) {
                    $note = $taskData['note'];

                    $noteInsert = $this->task_notes->insert([
                        'note' => nl2br($note),
                        'task_id' => $insert
                    ]);
                    if (!$noteInsert) {
                        $errors .= '<p>Unable to add Note.</p>';
                    }
                }

                // $jobs = $taskData['tag_clients'];
                // if (!empty($jobs)) {
                //     $jobs = explode(',', $jobs);
                //     $jobsInsert = $this->task_job_tags->insertByJobArr($jobs, $insert);
                //     if (!$jobsInsert) {
                //         $errors .= '<p>Unable to tag Jobs.</p>';
                //     }
                // }

                $users = $taskData['tag_users'];
                $userIds = [];
                if (preg_match_all('~(@\w+)~', $note, $matches, PREG_PATTERN_ORDER)) {
                    $usernames = array_map(function ($val) {
                        return ltrim($val, '@');
                    }, $matches[1]);
                    $userIds = $this->user->getUserIdArrByUserNames($usernames);
                }

                if (!empty($users) || count($userIds)) {
                    $users = empty($users) ? [] : explode(',', $users);
                    $users = array_unique(array_merge($users, $userIds));
                    $usersInsert = $this->task_user_tags->insertByUserArr($users, $insert);
                    if (!$usersInsert) {
                        $errors .= '<p>Unable to tag Users.</p>';
                    }

                    $userEmailIds = $this->user->getEmailIdArrByUserIds($users);
                    foreach ($userEmailIds as $userEmailId) {
                        $this->notify = new Notify();
                        $this->notify->sendTaskTagNotification($userEmailId, $insert, $taskData['name'], $taskData['note'], base_url('task/' . $insert));
                    }

                    $phoneNos = $this->user->getPhoneArrByUserIds($users);
                    foreach ($phoneNos as $phoneNo) {
                        $this->notify = new Notify();
                        $this->notify->sendTaskTagNotificationMob($phoneNo, $insert, $taskData['name'], $taskData['note'], base_url('task/' . $insert));
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
            } else {
                $this->session->set_flashdata('errors', '<p>Unable to Create Task.</p>');
                redirect('task/create');
            }
        } else {
            $this->session->set_flashdata('errors', validation_errors());
            redirect('task/create');
        }
    }

    public function complete($id)
    {
        authAccess();

        $task = $this->task->getTaskById($id);
        if ($task) {
            // >>>>> TEAM CHANGES >>>>> check if current user has access to this task for completion
            if ($this->task->predecessorCheck($id)) {
                $completed = $this->task->complete($id);
                if (!$completed) {
                    $this->session->set_flashdata('errors', '<p>Unable to mark Task as Completed.</p>');
                }
            } else {
                $this->session->set_flashdata('errors', '<p>Predecessor Tasks not Completed.</p>');
            }
        } else {
            $this->session->set_flashdata('errors', '<p>Invalid Request.</p>');
        }
        redirect('tasks');
    }

    public function edit($id)
    {
        authAccess();

        $task = $this->task->getTaskById($id);
        if ($task) {
            // >>>>> TEAM CHANGES >>>>> check if current user has access to this task
            $levels = TaskModel::getLevels();
            $status = TaskModel::getStatus();
            $tasks = $this->task->getTaskListExcept($id);
            $users = $this->user->getUserList();
            $taskTypes = $this->taskType->allTypes();
            // $jobs = false;
            $tag_users = $this->task_user_tags->getUsersByTaskId($id);
            $predec_tasks = $this->task_predecessor->getTasksByTaskId($id);
            $this->load->view('header', [
                'title' => $this->title
            ]);
            $this->load->view('tasks/edit', [
                'task' => $task,
                'types' => $taskTypes,
                'levels' => $levels,
                'tasks' => $tasks,
                'users' => $users,
                'status' => $status,
                'tag_users' => $tag_users,
                'predec_tasks' => $predec_tasks
            ]);
            $this->load->view('footer');
        } else {
            $this->session->set_flashdata('errors', '<p>Invalid Request.</p>');
            redirect('tasks');
        }
    }

    public function update($id)
    {
        authAccess();

        $task = $this->task->getTaskById($id);
        if ($task) {
            // >>>>> TEAM CHANGES >>>>> check if current user has access to this task

            $typeKeys = implode(',', array_column($this->taskType->allTypes(), 'id'));
            $levelKeys = implode(',', array_keys(TaskModel::getLevels()));
            $userKeys = implode(',', array_column($this->user->getUserList(), 'id'));
            $statusKeys = implode(',', array_keys(TaskModel::getStatus()));

            $this->form_validation->set_rules('name', 'Task Name', 'trim|required');
            $this->form_validation->set_rules('type', 'Type', 'trim|required|numeric|in_list[' . $typeKeys . ']');
            $this->form_validation->set_rules('level', 'Importance Level', 'trim|required|numeric|in_list[' . $levelKeys . ']');
            $this->form_validation->set_rules('assigned_to', 'Assigned To', 'trim|required|numeric|in_list[' . $userKeys . ']');
            $this->form_validation->set_rules('status', 'Status', 'trim|required|numeric|in_list[' . $statusKeys . ']');
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
                    if ($task->assigned_to != $taskData['assigned_to']) {
                        $assignedUser = $this->user->getUserById($taskData['assigned_to']);
                        $this->notify = new Notify();
                        $this->notify->sendTaskAssignNotification($assignedUser->email_id, $task->id, $task->name);
                    }

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

                        $userEmailIds = $this->user->getEmailIdArrByUserIds($users_insert);
                        foreach ($userEmailIds as $userEmailId) {
                            $this->notify = new Notify();
                            $this->notify->sendTaskTagNotification($userEmailId, $task->id, $task->name, '', base_url('task/' . $id));
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
                } else {
                    $this->session->set_flashdata('errors', '<p>Unable to Update Task.</p>');
                }
            } else {
                $this->session->set_flashdata('errors', validation_errors());
            }
        } else {
            $this->session->set_flashdata('errors', '<p>Invalid Request.</p>');
        }
        redirect('tasks');
    }

    public function show($id)
    {
        authAccess();

        $task = $this->task->getTaskById($id);
        if ($task) {
            $notes = $this->task_notes->getNotesByTaskId($id);
            $jobs = false;
            $users = $this->user->getUserList();
            $tag_users = $this->task_user_tags->getUsersByTaskId($id);
            $predec_tasks = $this->task_predecessor->getTasksByTaskId($id);
            // >>>>> TEAM CHANGES >>>>> check if current user has access to this task
            $levels = TaskModel::getLevels();
            $status = TaskModel::getStatus();
            $tasks = $this->task->getTaskListExcept($id);
            $taskTypes = $this->taskType->allTypes();
            // $jobs = false;
            $this->load->view('header', [
                'title' => $this->title
            ]);
            $this->load->view('tasks/show', [
                'types' => $taskTypes,
                'levels' => $levels,
                'tasks' => $tasks,
                'status' => $status,
                'task' => $task,
                'notes' => $notes,
                'jobs' => $jobs,
                'users' => $users,
                'tag_users' => $tag_users,
                'predec_tasks' => $predec_tasks
            ]);
            $this->load->view('footer');
        } else {
            $this->session->set_flashdata('errors', '<p>Invalid Request.</p>');
            redirect('tasks');
        }
    }

    public function addNote($id)
    {
        authAccess();

        $task = $this->task->getTaskById($id);
        if ($task) {
            $this->form_validation->set_rules('note', 'Note', 'trim|required');

            if ($this->form_validation->run() == TRUE) {
                $noteData = $this->input->post();
                $insert = $this->task_notes->insert([
                    'note' => nl2br($noteData['note']),
                    'task_id' => $id
                ]);
                if ($insert) {
                    $userIds = [];
                    if (preg_match_all('~(@\w+)~', $noteData['note'], $matches, PREG_PATTERN_ORDER)) {
                        $usernames = array_map(function ($val) {
                            return ltrim($val, '@');
                        }, $matches[1]);
                        $userIds = $this->user->getUserIdArrByUserNames($usernames);
                    }

                    // $old_tag_users = $this->task_user_tags->getUsersByTaskId($id);
                    // $old_tag_users = ($old_tag_users) ? array_column($old_tag_users, 'id') : [];
                    // $users = array_unique(array_merge($old_tag_users, $userIds));
                    // $users_insert = array_diff($users, $old_tag_users);
                    $users_insert = $userIds;
                    if (count($users_insert)) {
                        $usersInsert = $this->task_user_tags->insertByUserArr($users_insert, $id);
                        if (!$usersInsert) {
                            $this->session->set_flashdata('errors', '<p>Unable to tag new Users.</p>');
                        }

                        $userEmailIds = $this->user->getEmailIdArrByUserIds($users_insert);
                        foreach ($userEmailIds as $userEmailId) {
                            $this->notify = new Notify();
                            $this->notify->sendTaskTagNotification($userEmailId, $task->id, $task->name, $noteData['note'], base_url('task/' . $id));
                        }

                        $phoneNos = $this->user->getPhoneArrByUserIds($users_insert);
                        foreach ($phoneNos as $phoneNo) {
                            $this->notify = new Notify();
                            $this->notify->sendTaskTagNotificationMob($phoneNo, $task->id, $task->name, $noteData['note'], base_url('task/' . $id));
                        }
                    }
                } else {
                    $this->session->set_flashdata('errors', '<p>Unable to add Note.</p>');
                }
            } else {
                $this->session->set_flashdata('errors', validation_errors());
            }
            redirect('task/' . $id);
        } else {
            $this->session->set_flashdata('errors', '<p>Invalid Request.</p>');
            redirect('tasks');
        }
    }

    public function updateNote($id, $noteId)
    {
        authAccess();

        $task = $this->task->getTaskById($id);
        if ($task) {
            $this->form_validation->set_rules('note', 'Note', 'trim|required');

            if ($this->form_validation->run() == TRUE) {
                $noteData = $this->input->post();
                $update = $this->task_notes->update($noteId, [
                    'note' => nl2br($noteData['note'])
                ]);
                if ($update) {
                    // $userIds = [];
                    // if (preg_match_all('~(@\w+)~', $noteData['note'], $matches, PREG_PATTERN_ORDER)) {
                    //     $usernames = array_map(function ($val) {
                    //         return ltrim($val, '@');
                    //     }, $matches[1]);
                    //     $userIds = $this->user->getUserIdArrByUserNames($usernames);
                    // }
                    // $users_insert = $userIds;
                    // if (count($users_insert)) {
                    //     $usersInsert = $this->task_user_tags->insertByUserArr($users_insert, $id);
                    //     if (!$usersInsert) {
                    //         $this->session->set_flashdata('errors', '<p>Unable to tag new Users.</p>');
                    //     }

                    //     $userEmailIds = $this->user->getEmailIdArrByUserIds($users_insert);
                    //     foreach ($userEmailIds as $userEmailId) {
                    //         $this->notify = new Notify();
                    //         $this->notify->sendTaskTagNotification($userEmailId, $task->id, $task->name);
                    //     }

                    //     $userMobEmailIds = $this->user->getMobEmailIdArrByUserIds($users_insert);
                    //     foreach ($userMobEmailIds as $userMobEmailId) {
                    //         $this->notify = new Notify();
                    //         $this->notify->sendTaskTagNotificationMob($userMobEmailId, $task->id, $task->name);
                    //     }
                    // }
                } else {
                    $this->session->set_flashdata('errors', '<p>Unable to Update Note.</p>');
                }
            } else {
                $this->session->set_flashdata('errors', validation_errors());
            }
            redirect('task/' . $id);
        } else {
            $this->session->set_flashdata('errors', '<p>Invalid Request.</p>');
            redirect('tasks');
        }
    }

    public function deleteNote($id, $note_id)
    {
        authAccess();

        $task = $this->task->getTaskById($id);
        if ($task) {
            // >>>>> TEAM CHANGES >>>>> check if current user has access to this taskNote
            $delete = $this->task_notes->delete($note_id, $id);
            if (!$delete) {
                $this->session->set_flashdata('errors', '<p>Unable to Delete Note.</p>');
            }
            redirect('task/' . $id);
        } else {
            $this->session->set_flashdata('errors', '<p>Invalid Request.</p>');
            redirect('tasks');
        }
    }

    public function delete($id)
    {
        authAccess();

        $task = $this->task->getTaskById($id);
        if ($task) {
            // >>>>> TEAM CHANGES >>>>> check if current user has access to this task
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
