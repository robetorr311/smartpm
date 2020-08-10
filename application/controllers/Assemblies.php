<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Assemblies extends CI_Controller
{
    private $title = 'Assemblies';

    public function __construct()
    {
        parent::__construct();

        $this->load->model(['AssembliesModel', 'ItemModel', 'AssembliesDescriptionModel']);
        $this->load->library(['pagination', 'form_validation']);

        $this->assemblies = new AssembliesModel();
        $this->item = new ItemModel();
        $this->assemblies_description = new AssembliesDescriptionModel();
    }

    public function index()
    {
        authAccess();

        $assemblies = $this->assemblies->allAssemblies();

        $this->load->view('header', [
            'title' => $this->title
        ]);
        $this->load->view('assemblies/index', [
            'assemblies' => $assemblies
        ]);
        $this->load->view('footer');
    }

    public function create()
    {
        authAccess();

        $items = $this->item->getItemList();

        $this->load->view('header', [
            'title' => $this->title
        ]);
        $this->load->view('assemblies/create', [
            'items' => $items
        ]);
        $this->load->view('footer');
    }

    public function store()
    {
        authAccess();

        $this->form_validation->set_rules('name', 'Name', 'trim|required');
        if (isset($_POST['items']) && is_array($_POST['items'])) {
            foreach ($_POST['items'] as $id_item => $item) {
                $this->form_validation->set_rules('items[' . $id_item . '][item_id]', 'Item', 'trim|required|numeric');
                $this->form_validation->set_rules('items[' . $id_item . '][description]', 'Description', 'trim|required');
            }
        }

        if ($this->form_validation->run() == TRUE) {
            $assembly = $this->input->post();
            $insert_assembly = $this->assemblies->insert([
                'name' => $assembly['name']
            ]);

            if ($insert_assembly) {
                foreach ($assembly['items'] as $item) {
                    $insert_assemblies_description = $this->assemblies_description->insert([
                        'item' => $item['item_id'],
                        'description' => $item['description'],
                        'assemblies_id' => $insert_assembly
                    ]);
                }
            } else {
                $this->session->set_flashdata('errors', '<p>Unable to Create Assembly.</p>');
                redirect('assembly/create');
            }

            redirect('assemblies');
        } else {
            $this->session->set_flashdata('errors', validation_errors());
            redirect('assembly/create');
        }
    }

    public function update($id)
    {
        authAccess();

        $assembly = $this->assemblies->getAssemblyById($id);
        $assemblies_description = $this->assemblies_description->allAssembliesDescsByAssemblyId($id);

        if ($assembly) {
            $this->form_validation->set_rules('name', 'Name', 'trim|required');
            if (isset($_POST['items']) && is_array($_POST['items'])) {
                foreach ($_POST['items'] as $id_item => $item) {
                    $this->form_validation->set_rules('items[' . $id_item . '][item_id]', 'Item', 'trim|required|numeric');
                    $this->form_validation->set_rules('items[' . $id_item . '][description]', 'Description', 'trim|required');
                }
            }

            if ($this->form_validation->run() == TRUE) {
                $_assembly = $this->input->post();
                $update_assembly = $this->assemblies->update($id, [
                    'name' => $_assembly['name']
                ]);

                if ($update_assembly) {
                    $exception_ids = array_column($_assembly['items'], 'id');
                    if (is_array($exception_ids) && count($exception_ids) > 0) {
                        $this->assemblies_description->deleteByAssemblyIdWithExceptionIds($id, $exception_ids);
                    } else {
                        $this->assemblies_description->deleteByAssemblyId($id);
                    }
                    foreach ($_assembly['items'] as $item) {
                        if (isset($item['id'])) {
                            $update_assemblies_description = $this->assemblies_description->update($item['id'], [
                                'item' => $item['item_id'],
                                'description' => $item['description']
                            ]);
                        } else {
                            $insert_assemblies_description = $this->assemblies_description->insert([
                                'item' => $item['item_id'],
                                'description' => $item['description'],
                                'assemblies_id' => $id
                            ]);
                        }
                    }
                } else {
                    $this->session->set_flashdata('errors', '<p>Unable to Update Assembly.</p>');
                }
            } else {
                $this->session->set_flashdata('errors', validation_errors());
            }
        }
        
        redirect('assembly/' . $id);
    }

    public function show($id)
    {
        authAccess();

        $assembly = $this->assemblies->getAssemblyById($id);
        $assemblies_description = $this->assemblies_description->allAssembliesDescsByAssemblyId($id);
        $items = $this->item->getItemList();

        if ($assembly) {
            $this->load->view('header', [
                'title' => $this->title
            ]);
            $this->load->view('assemblies/show', [
                'assembly' => $assembly,
                'assemblies_description' => $assemblies_description,
                'items' => $items
            ]);
            $this->load->view('footer');
        } else {
            $this->session->set_flashdata('errors', '<p>Invalid Request.</p>');
            redirect('assemblies');
        }
    }

    public function delete($id)
    {
        authAccess();

        $assembly = $this->assemblies->getAssemblyById($id);
        if ($assembly) {
            $this->assemblies_description->deleteByAssemblyId($id);
            $delete = $this->assemblies->delete($id);
            if (!$delete) {
                $this->session->set_flashdata('errors', '<p>Unable to delete Assembly.</p>');
            }
        } else {
            $this->session->set_flashdata('errors', '<p>Invalid Request.</p>');
        }
        redirect('assemblies');
    }

    public function ajaxRecord($id)
    {
        authAccess();

        $assembly = $this->assemblies->getAssemblyById($id);
        if ($assembly) {
            $assemblies_description = $this->assemblies_description->allAssembliesDescsByAssemblyId($id);
            $assembly->items = $assemblies_description;
            echo json_encode($assembly);
        } else {
            echo 'ERROR';
        }
    }
}
