<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Items extends CI_Controller
{
    private $title = 'Items';

    public function __construct()
    {
        parent::__construct();

        $this->load->model(['ItemModel', 'ItemGroupModel']);
        $this->load->library(['pagination', 'form_validation']);

        $this->item = new ItemModel();
        $this->item_group = new ItemGroupModel();
    }

    public function index()
    {
        authAccess();

        $items = $this->item->allItems();
        
        $this->load->view('header', [
            'title' => $this->title
        ]);
        $this->load->view('items/index', [
            'items' => $items
        ]);
        $this->load->view('footer');
    }

    public function create()
    {
        authAccess();

        $itemGroups = $this->item_group->allItemGroups();
        $this->load->view('header', [
            'title' => $this->title
        ]);
        $this->load->view('items/create', [
            'itemGroups' => $itemGroups
        ]);
        $this->load->view('footer');
    }

    public function store()
    {
        authAccess();

        $itemGroupKeys = implode(',', array_column($this->item_group->allItemGroups(), 'id'));

        $this->form_validation->set_rules('name', 'Item Name', 'trim|required');
        $this->form_validation->set_rules('item_group_id', 'Item Group', 'trim|required|numeric|in_list[' . $itemGroupKeys . ']');

        if ($this->form_validation->run() == TRUE) {
            $itemData = $this->input->post();
            $insert = $this->item->insert([
                'name' => $itemData['name'],
                'item_group_id' => $itemData['item_group_id'],
                'line_style_type' => $itemData['line_style_type'],
                'internal_part_no' => ($itemData['internal_part_no'] == '') ? null : $itemData['internal_part_no'],
                'quantity_units' => $itemData['quantity_units'],
                'unit_price' =>  ($itemData['unit_price'] == '') ? null : $itemData['unit_price'],
                'description' => $itemData['description']
            ]);

            if ($insert) {
                redirect('item/' . $insert);
            } else {
                $this->session->set_flashdata('errors', '<p>Unable to Create Item.</p>');
                redirect('item/create');
            }
        } else {
            $this->session->set_flashdata('errors', validation_errors());
            redirect('item/create');
        }
    }

    public function update($id)
    {
        authAccess();

        $item = $this->item->getItemById($id);
        if ($item) {
            $itemGroupKeys = implode(',', array_column($this->item_group->allItemGroups(), 'id'));

            $this->form_validation->set_rules('name', 'Item Name', 'trim|required');
            $this->form_validation->set_rules('item_group_id', 'Item Group', 'trim|required|numeric|in_list[' . $itemGroupKeys . ']');

            if ($this->form_validation->run() == TRUE) {
                $itemData = $this->input->post();
                $update = $this->item->update($id, [
                    'name' => $itemData['name'],
                    'item_group_id' => $itemData['item_group_id'],
                    'line_style_type' => $itemData['line_style_type'],
                    'internal_part_no' => ($itemData['internal_part_no'] == '') ? null : $itemData['internal_part_no'],
                    'quantity_units' => $itemData['quantity_units'],
                    'unit_price' =>  ($itemData['unit_price'] == '') ? null : $itemData['unit_price'],
                    'description' => $itemData['description']
                ]);

                if (!$update) {
                    $this->session->set_flashdata('success', '<p>Unable to Update Item.</p>');
                }
            } else {
                $this->session->set_flashdata('errors', validation_errors());
            }
            redirect('item/' . $id);
        } else {
            $this->session->set_flashdata('errors', '<p>Invalid Request.</p>');
            redirect('items');
        }
    }

    public function show($id)
    {
        authAccess();

        $item = $this->item->getItemById($id);
        $itemGroups = $this->item_group->allItemGroups();
        if ($item) {
            $this->load->view('header', [
                'title' => $this->title
            ]);
            $this->load->view('items/show', [
                'item' => $item,
                'itemGroups' => $itemGroups
            ]);
            $this->load->view('footer');
        } else {
            $this->session->set_flashdata('errors', '<p>Invalid Request.</p>');
            redirect('items');
        }
    }

    public function delete($id)
    {
        authAccess();

        $item = $this->item->getItemById($id);
        if ($item) {
            $delete = $this->item->delete($id);
            if (!$delete) {
                $this->session->set_flashdata('errors', '<p>Unable to delete Item.</p>');
            }
        } else {
            $this->session->set_flashdata('errors', '<p>Invalid Request.</p>');
        }
        redirect('items');
    }

    public function ajaxRecord($id)
    {
        authAccess();

        $item = $this->item->getItemById($id);
        if ($item) {
            echo json_encode($item);
        } else {
            echo 'ERROR';
        }
    }
}
