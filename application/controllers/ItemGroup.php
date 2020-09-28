<?php
defined('BASEPATH') or exit('No direct script access allowed');

class ItemGroup extends CI_Controller
{
    private $title = 'Item Groups';

    public function __construct()
    {
        parent::__construct();

        $this->load->model(['ItemGroupModel', 'ItemModel', 'ItemGroupsItemsMapModel']);
        $this->load->library(['pagination', 'form_validation']);

        $this->itemGroup = new ItemGroupModel();
        $this->item = new ItemModel();
        $this->item_groups_items_map = new ItemGroupsItemsMapModel();
    }

    /*** Group Listing Page ***/

    public function index()
    {
        authAccess();

        $itemGroups = $this->itemGroup->allItemGroups();

        $this->load->view('header', [
            'title' => $this->title
        ]);
        $this->load->view('item_groups/index', [
            'itemGroups' => $itemGroups
        ]);
        $this->load->view('footer');
    }

    /*** Creation of New Group ***/

    public function create()
    {
        authAccess();

        $items = $this->item->getItemList();

        $this->load->view('header', [
            'title' => $this->title
        ]);
        $this->load->view('item_groups/create', [
            'items' => $items
        ]);
        $this->load->view('footer');
    }

    /*** Store New Group information ***/

    public function store()
    {
        authAccess();

        // Validations
        $this->form_validation->set_rules('name', 'Item Group Name', 'trim|required');

        if ($this->form_validation->run() == TRUE) {
            $postdata = $this->input->post();

            // Save to item-group table
            $insert = $this->itemGroup->insert([
                'name' => $postdata['name']
            ]);

            if ($insert) {
                $errors = '';

                if (!empty($postdata['items'])) {
                    $itemsArray = explode(",", $postdata['items']);
                    $itemsInsert = $this->item_groups_items_map->insertByItemArr($itemsArray, $insert);
                    if (!$itemsInsert) {
                        $errors .= '<p>Unable to add Items.</p>';
                    }
                }

                if (!empty($errors)) {
                    $this->session->set_flashdata('errors', $errors);
                }

                redirect('item-group/' . $insert);
            } else {
                $this->session->set_flashdata('errors', '<p>Unable to Create Item Group.</p>');
                redirect('item-group/create');
            }
        } else {
            $this->session->set_flashdata('errors', validation_errors());
            redirect('item-group/create');
        }
    }

    /*** View Group information by group-id ***/

    public function show($id)
    {
        authAccess();

        $itemGroup = $this->itemGroup->getItemGroupById($id);

        if ($itemGroup) {

            $groupItems = $this->item_groups_items_map->getItemsByItemGroupId($id);
            $items = $this->item->allItems();

            $this->load->view('header', [
                'title' => $this->title,
            ]);
            $this->load->view('item_groups/show', [
                'itemGroup' => $itemGroup,
                'groupItems' => $groupItems,
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

        $itemGroup = $this->itemGroup->getItemGroupById($id);

        if ($itemGroup) {
            $this->form_validation->set_rules('name', 'Item Group Name', 'trim|required');

            if ($this->form_validation->run() == TRUE) {
                $postdata = $this->input->post();

                $update = $this->itemGroup->update($id, [
                    'name' => $postdata['name']
                ]);

                if ($update) {
                    $errors = '';

                    $old_items = $this->item_groups_items_map->getItemsByItemGroupId($id);
                    $old_items = ($old_items) ? array_column($old_items, 'id') : [];
                    $items = $postdata['items'];
                    $items = (!empty($items)) ? explode(',', $items) : [];
                    $items_insert = array_diff($items, $old_items);
                    if (count($items_insert)) {
                        $itemsInsert = $this->item_groups_items_map->insertByItemArr($items_insert, $id);
                        if (!$itemsInsert) {
                            $errors .= '<p>Unable to add new Items.</p>';
                        }
                    }
                    $items_remove = array_diff($old_items, $items);
                    if (count($items_remove)) {
                        $itemsRemove = $this->item_groups_items_map->removeByItemArrId($items_remove, $id);
                        if (!$itemsRemove) {
                            $errors .= '<p>Unable to remove existing Items.</p>';
                        }
                    }
                } else {
                    $this->session->set_flashdata('error', '<p>Unable to Update Item.</p>');
                }
            } else {
                $this->session->set_flashdata('errors', validation_errors());
            }
            redirect('item-group/' . $id);
        } else {
            $this->session->set_flashdata('errors', '<p>Invalid Request.</p>');
            redirect('item-groups');
        }
    }

    /*** To Remove Group (soft-delete) ***/

    public function delete($id)
    {
        authAccess();

        $itemGroup = $this->itemGroup->getItemGroupById($id);
        if ($itemGroup) {
            $delete = $this->itemGroup->delete($id);
            if (!$delete) {
                $this->session->set_flashdata('errors', '<p>Unable to delete Item.</p>');
            }
        } else {
            $this->session->set_flashdata('errors', '<p>Invalid Request.</p>');
        }
        redirect('item-groups');
    }

    public function ajaxRecord($id)
    {
        authAccess();

        if ($id == 0) {
            $items = $this->item->getUnassignedItemList();
            if ($items) {
                echo json_encode([
                    'items' => $items
                ]);
            } else {
                echo 'ERROR';
            }
        } else {
            $itemGroup = $this->itemGroup->getItemGroupById($id);
            $groupItems = $this->item_groups_items_map->getItemsByItemGroupId($id);
            if ($itemGroup && $groupItems) {
                $itemGroup->items = $groupItems;
                echo json_encode($itemGroup);
            } else {
                echo 'ERROR';
            }
        }
    }
}
