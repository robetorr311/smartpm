<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Groups extends CI_Controller
{
    private $title = 'Groups';

    public function __construct()
    {
        parent::__construct();

        $this->load->model(['GroupModel','ItemModel']);
        $this->load->library(['pagination', 'form_validation']);

        $this->group = new GroupModel();
        $this->item = new ItemModel();
    }

    /*** Group Listing Page ***/

    public function index()
    {
        authAccess();

        $groups = $this->group->allGroups();
        
        $this->load->view('header', [
            'title' => $this->title
        ]);
        $this->load->view('groups/index', [
            'groups' => $groups,
        ]);
        $this->load->view('footer');
    }

    /*** Creation of New Group ***/

    public function create()
    {
        authAccess();

        $items = $this->item->allItems();

        $this->load->view('header', [
            'title' => $this->title,
            'items' => $items
        ]);
        $this->load->view('groups/create');
        $this->load->view('footer');
    }

    /*** Store New Group information***/

    public function store()
    {
        authAccess();
        // Validations
        $this->form_validation->set_rules('name', 'Group Name', 'trim|required|is_unique[groups.name]');

        if ($this->form_validation->run() == TRUE) {
            $postdata = $this->input->post();
            $itemsArray = (!empty($postdata['items'])) ? explode(",",$postdata['items']) : [];
            unset($postdata['items']);

            // Save to group table
            $insert = $this->group->insert($postdata);
            if ($insert) {
                if (!empty($itemsArray)) {
                    $groupMapping = $data = [];
                    $data['group_id'] = $insert;

                    foreach ($itemsArray as $val) {
                        $data['item_id'] = $val;
                        $groupMapping [] = $data;
                    }
                    // Save to group-item table
                    if(!empty($groupMapping)) {
                        $this->db->insert_batch('group_items_mapping', $groupMapping);
                        unset($groupMapping, $data);
                    }
                }
                //redirect('item/' . $insert);
                redirect('groups');
            } else {
                $this->session->set_flashdata('errors', '<p>Unable to Create Group.</p>');
                redirect('group/create');
            }
        } else {
            $this->session->set_flashdata('errors', validation_errors());
            redirect('group/create');
        }
    }

    /*** View Group information by group-id ***/

    public function show($id)
    {   
        authAccess();

        $group = $this->group->getGroupById($id);
    
        if ($group) {

            $groupitems = $this->item->getItemsByGroupId($id);
            $items = $this->item->allItems();
           
            $this->load->view('header', [
                'title' => $this->title,
                'groupitems' => $groupitems,
                'items' => $items
            ]);
            $this->load->view('groups/show', [
                'group' => $group
            ]);
            $this->load->view('footer');
        } else {
            $this->session->set_flashdata('errors', '<p>Invalid Request.</p>');
            redirect('groups');
        }
    }

    /*** To Update group inforamtions ***/

    public function update($id)
    {
        authAccess();
       
        $group = $this->group->getGroupById($id);
       
        if ($group) {
            $this->form_validation->set_rules('name', 'Group Name', 'trim|required|callback_check_group_name['.$id.']');

            if ($this->form_validation->run() == TRUE) {

                $postdata = $this->input->post();
                
                $itemsArray = (!empty($postdata['items'])) ? explode(",",$postdata['items']) : [];
                unset($postdata['items']);
                $update = $this->group->update($id,$postdata);

                if($update) {
                    $this->group->removeGroupItemsByGroupId($id);
                    if (!empty($itemsArray)) {
                        $groupMapping = $data = [];
                        $data['group_id'] = $id;
    
                        foreach ($itemsArray as $val) {
                            $data['item_id'] = $val;
                            $groupMapping [] = $data;
                        }
                        
                        // Save to group-item table
                        if(!empty($groupMapping)) {
                            $this->db->insert_batch('group_items_mapping', $groupMapping);
                            unset($groupMapping, $data);
                        }
                    }

                } else {
                    $this->session->set_flashdata('error', '<p>Unable to Update Item.</p>');
                }
            } else {
                $this->session->set_flashdata('errors', validation_errors());
            }
            redirect('group/' . $id);
        } else {
            $this->session->set_flashdata('errors', '<p>Invalid Request.</p>');
            redirect('groups');
        }
    }

    /*** To Remove Group (soft-delete) ***/
    
    public function delete($id)
    {
        authAccess();
        $group = $this->group->getGroupById($id);

        if ($group) {
            $delete = $this->group->delete($id);
            if (!$delete) {
                $this->session->set_flashdata('errors', '<p>Unable to delete Item.</p>');
            }
        } else {
            $this->session->set_flashdata('errors', '<p>Invalid Request.</p>');
        }
        redirect('groups');
    }

    /*** Validation of Group-name while update ***/

    public function check_group_name($name, $id)
    {
        $result = $this->group->check_group_name($name, $id);

        if($result == 0)
            $response = true;
        else {
            $this->form_validation->set_message('check_group_name', 'The Group Name field must contain a unique value.');
            $response = false;
        }
        return $response;
    }

   
    public function getItemsByGroupId()
    {
        $group_id  = $this->input->post('group_id');
        $groupitems = $this->item->getItemsByGroupId($group_id);
        echo json_encode($groupitems);
    }
}
