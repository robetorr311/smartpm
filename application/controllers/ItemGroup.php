<?php
defined('BASEPATH') or exit('No direct script access allowed');

class ItemGroup extends CI_Controller
{
    private $title = 'Item Groups';

    public function __construct()
    {
        parent::__construct();

        $this->load->model(['ItemGroupModel','ItemModel','GroupItemsMappingModel']);
        $this->load->library(['pagination', 'form_validation']);

        $this->itemgroup = new ItemGroupModel();
        $this->item = new ItemModel();
        $this->group_items_mapping = new GroupItemsMappingModel();
    }

    /*** Group Listing Page ***/

    public function index()
    {
        authAccess();

        $itemgroups = $this->itemgroup->allGroups();
        
        $this->load->view('header', [
            'title' => $this->title
        ]);
        $this->load->view('item_groups/index', [
            'itemgroups' => $itemgroups,
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
        ]);
        $this->load->view('item_groups/create',['items' => $items]);
        $this->load->view('footer');
    }

    /*** Store New Group information***/

    public function store()
    {
        authAccess();
        // Validations
        $this->form_validation->set_rules('name', 'Item-Group Name', 'trim|required|is_unique[item_groups.name]',['is_unique' => 'This Item-Group Name already exists.']);

        if ($this->form_validation->run() == TRUE) {
            $postdata = $this->input->post();
            $itemsArray = (!empty($postdata['items'])) ? explode(",",$postdata['items']) : [];
            unset($postdata['items']);
            
            // Save to item-group table
            $insert = $this->itemgroup->insert([
                'name' => $postdata['name'],
            ]);

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
                        $this->group_items_mapping->insert_batch($groupMapping);
                        unset($groupMapping, $data);
                    }
                }
                redirect('item-groups/'.$insert);
            } else {
                $this->session->set_flashdata('errors', '<p>Unable to Create Group.</p>');
                redirect('item-groups/create');
            }
        } else {
            $this->session->set_flashdata('errors', validation_errors());
            redirect('item-groups/create');
        }
    }

    /*** View Group information by group-id ***/

    public function show($id)
    {   
        authAccess();

        $itemgroup = $this->itemgroup->getGroupById($id);
    
        if ($itemgroup) {

            $groupitems = $this->group_items_mapping->getItemsByGroupId($id);
            $items = $this->item->allItems();
           
            $this->load->view('header', [
                'title' => $this->title,
            ]);
            $this->load->view('item_groups/show', [
                'itemgroup' => $itemgroup,
                'groupitems' => $groupitems,
                'items' => $items
            ]);
            $this->load->view('footer');
        } else {
            $this->session->set_flashdata('errors', '<p>Invalid Request.</p>');
            redirect('item-groups');
        }
    }

    /*** To Update group inforamtions ***/

    public function update($id)
    {
        authAccess();
       
        $itemgroup = $this->itemgroup->getGroupById($id);
       
        if ($itemgroup) {
            $this->form_validation->set_rules('name', 'Item-Group Name', 'trim|required|callback_check_group_name['.$id.']');

            if ($this->form_validation->run() == TRUE) {

                $postdata = $this->input->post();
                
                $itemsArray = (!empty($postdata['items'])) ? explode(",",$postdata['items']) : [];
                unset($postdata['items']);
                $update = $this->itemgroup->update($id,[
                    'name' => $postdata['name'],
                ]);

                if($update) {
                    $this->group_items_mapping->removeGroupItemsByGroupId($id);
                    if (!empty($itemsArray)) {
                        $groupMapping = $data = [];
                        $data['group_id'] = $id;
    
                        foreach ($itemsArray as $val) {
                            $data['item_id'] = $val;
                            $groupMapping [] = $data;
                        }
                        
                        // Save to group-item table
                        if(!empty($groupMapping)) {
                            $this->group_items_mapping->insert_batch($groupMapping);
                            unset($groupMapping, $data);
                        }
                    }

                } else {
                    $this->session->set_flashdata('error', '<p>Unable to Update Item.</p>');
                }
            } else {
                $this->session->set_flashdata('errors', validation_errors());
            }
            redirect('item-groups/' . $id);
        } else {
            $this->session->set_flashdata('errors', '<p>Invalid Request.</p>');
            redirect('item-groups');
        }
    }

    /*** To Remove Group (soft-delete) ***/
    
    public function delete($id)
    {
        authAccess();
        $group = $this->itemgroup->getGroupById($id);

        if ($group) {
            $delete = $this->itemgroup->delete($id);
            if (!$delete) {
                $this->session->set_flashdata('errors', '<p>Unable to delete Item.</p>');
            }
        } else {
            $this->session->set_flashdata('errors', '<p>Invalid Request.</p>');
        }
        redirect('item-groups');
    }

    /*** Validation of Group-name while update ***/

    public function check_group_name($name, $id)
    {
        $result = $this->itemgroup->check_group_name($name, $id);

        if($result == 0)
            $response = true;
        else {
            $this->form_validation->set_message('check_group_name', 'This Item-Group Name already exists.');
            $response = false;
        }
        return $response;
    }

   
    public function getItemsByGroupId()
    {
        $group_id  = $this->input->post('group_id');
        $groupitems = $this->group_items_mapping->getItemsByGroupId($group_id);
        echo json_encode($groupitems);
    }
}
