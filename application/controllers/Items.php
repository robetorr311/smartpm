<?php
defined('BASEPATH') or exit('No direct script access allowed');
ob_start();

use Dompdf\Dompdf;
class Items extends CI_Controller
{
    private $title = 'Items';

    public function __construct()
    {
        parent::__construct();
        ob_start();
        $this->load->model(['ItemsModel']);
        $this->load->library(['pagination', 'form_validation']);
        $this->items = new ItemsModel();
    }
    public function index()
    {
        authAccess();
        $items = $this->items->allItems();
        $this->load->view('header', ['title' => $this->title]);
        $this->load->view('items/index', [
            'items' => $items
        ]);
        $this->load->view('footer');
    }
    public function create()
    {
        authAccess();
        $this->load->view('header', [
            'title' => $this->title
        ]);
        $this->load->view('items/create');
        $this->load->view('footer');
    }
    public function view($id){
        authAccess();
        $title="Edit item";      
        $item = $this->items->getItemById($id);
        if($item){
            $this->load->view('header', [
				'title' => $title
			]);
			$this->load->view('items/show', [
				'item' => $item,
            ]);
            $this->load->view('footer');
        }else {
			$this->session->set_flashdata('errors', '<p>Invalid Request.</p>');
			redirect('item');
		}
      
    }

    public function store(){
        authAccess();
        $this->form_validation->set_rules('item_name', 'Item Name', 'trim|required|is_unique[items.item_name]');
       

        
        if ($this->form_validation->run() == TRUE) {
            $itemsData = $this->input->post();

            $insert = $this->items->insert([
                'item_name' => $itemsData['item_name'],
                'item_type' => $itemsData['item_line'],
                'internal_part' => $itemsData['internal_parts'],
                'quantity_units' => $itemsData['quantity_units'],
                'unit_price' =>  number_format($itemsData['unit_price'], 2, '.',''),
                'item_description' => $itemsData['item_desc']
            ]);
           
            if ($insert) {
                redirect('items/'.$insert.'/view');
                redirect('items/create');
            } else {
                $this->session->set_flashdata('errors', '<p>Unable to Create items.</p>');
                redirect('items/create');
            }
        } else {
            $this->session->set_flashdata('errors', validation_errors());
            redirect('items/create');
        }
    }
    public function update($id){
        $itemData = $this->input->post();
        $update = $this->items->update($id, [
            'item_name' => $itemData['item_name'],
            'item_type' => $itemData['item_type'],
            'internal_part' => $itemData['internal_part'],
            'quantity_units' => $itemData['quantity_units'],
            'unit_price' => number_format($itemsData['unit_price'], 2, '.',''),
            'item_description' => $itemData['item_description']
        ]);
        if ($update) {
            }else {
                $this->session->set_flashdata('success', '<p>Invalid Request.</p>');
            }
            redirect('items/'.$id.'/view');
            
    }

    public function delete($id){
        authAccess();
        $item = $this->items->getItemById($id);
		if ($item) {
            $delete = $this->items->delete($id);
			if (!$delete) {
				$this->session->set_flashdata('errors', '<p>Unable to delete Team.</p>');
            }
		    redirect('items');

        } 
        else {
			$this->session->set_flashdata('errors', '<p>Invalid Request.</p>');
        }
        
        ob_clean();
    }
    
}