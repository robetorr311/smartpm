<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Vendors extends CI_Controller
{
	private $title = 'Vendors';

	public function __construct()
	{
		parent::__construct();

		$this->load->model(['VendorModel', 'VendorContactModel']);
		$this->load->library(['form_validation']);

		$this->vendor = new VendorModel();
		$this->vendor_contact = new VendorContactModel();
	}

	public function index()
	{
		authAccess();

		$vendors = $this->vendor->allVendors();
		$this->load->view('header', [
			'title' => $this->title
		]);
		$this->load->view('vendors/index', [
			'vendors' => $vendors
		]);
		$this->load->view('footer');
	}

	public function create()
	{
		authAccess();

		$this->load->view('header', [
			'title' => $this->title
		]);
		$this->load->view('vendors/create');
		$this->load->view('footer');
	}

	public function store()
	{
		authAccess();

		$this->form_validation->set_rules('name', 'Name', 'trim|required');
		$this->form_validation->set_rules('email_id', 'Email ID', 'valid_email');

		if ($this->form_validation->run() == TRUE) {
			$vendorData = $this->input->post();
			$insert = $this->vendor->insert([
				'name' => $vendorData['name'],
				'address' => $vendorData['address'],
				'city' => $vendorData['city'],
				'state' => $vendorData['state'],
				'zip' => $vendorData['zip'],
				'phone' => $vendorData['phone'],
				'email_id' => $vendorData['email_id'],
				'tax_id' => $vendorData['tax_id'],
				'credit_line' => $vendorData['credit_line']
			]);

			if ($insert) {
				redirect('vendor/' . $insert);
			} else {
				$this->session->set_flashdata('errors', '<p>Unable to Create Vendor.</p>');
				redirect('vendor/create');
			}
		} else {
			$this->session->set_flashdata('errors', validation_errors());
			redirect('vendor/create');
		}
	}

	public function update($id)
	{
		authAccess();

		$vendor = $this->vendor->getVendorById($id);
		if ($vendor) {
			$this->form_validation->set_rules('name', 'Name', 'trim|required');
			$this->form_validation->set_rules('email_id', 'Email ID', 'valid_email');

			if ($this->form_validation->run() == TRUE) {
				$vendorData = $this->input->post();
				$update = $this->vendor->update($id, [
					'name' => $vendorData['name'],
					'address' => $vendorData['address'],
					'city' => $vendorData['city'],
					'state' => $vendorData['state'],
					'zip' => $vendorData['zip'],
					'phone' => $vendorData['phone'],
					'email_id' => $vendorData['email_id'],
					'tax_id' => $vendorData['tax_id'],
					'credit_line' => $vendorData['credit_line']
				]);

				if (!$update) {
					$this->session->set_flashdata('errors', '<p>Unable to Update Vendor.</p>');
				}
			} else {
				$this->session->set_flashdata('errors', validation_errors());
			}
		} else {
			$this->session->set_flashdata('errors', '<p>Invalid Request.</p>');
		}
		redirect('vendor/' . $id);
	}

	public function show($id)
	{
		authAccess();

		$vendor = $this->vendor->getVendorById($id);
		if ($vendor) {
			$vednor_contacts = $this->vendor_contact->allVendorContactsByVendorId($id);
			$this->load->view('header', [
				'title' => $this->title
			]);
			$this->load->view('vendors/show', [
				'vendor' => $vendor,
				'vednor_contacts' => $vednor_contacts
			]);
			$this->load->view('footer');
		} else {
			$this->session->set_flashdata('errors', '<p>Invalid Request.</p>');
			redirect('vendors');
		}
	}

	public function delete($id)
	{
		authAccess();

		$vendor = $this->vendor->getVendorById($id);
		if ($vendor) {
			$delete = $this->vendor->delete($id);
			if (!$delete) {
				$this->session->set_flashdata('errors', '<p>Unable to delete Vendor.</p>');
			}
		} else {
			$this->session->set_flashdata('errors', '<p>Invalid Request.</p>');
		}
		redirect('vendors');
	}

	public function createContact($id)
	{
		authAccess();

		$vendor = $this->vendor->getVendorById($id);
		if ($vendor) {
			$this->form_validation->set_rules('name', 'Name', 'trim|required');
			$this->form_validation->set_rules('email_id', 'Email ID', 'valid_email');
			if ($this->form_validation->run() == TRUE) {
				$vendorContactData = $this->input->post();
				$insert = $this->vendor_contact->insert([
					'name' => $vendorContactData['name'],
					'cell' => $vendorContactData['cell'],
					'email_id' => $vendorContactData['email_id'],
					'vendor_id' => $id
				]);

				if (!$insert) {
					$this->session->set_flashdata('errors', '<p>Unable to Create Vendor Contact.</p>');
				}
			} else {
				$this->session->set_flashdata('errors', validation_errors());
			}
			redirect('vendor/' . $id);
		} else {
			$this->session->set_flashdata('errors', '<p>Invalid Request.</p>');
			redirect('vendors');
		}
	}

	public function deleteContact($vendor_id, $id)
	{
		authAccess();

		$vendor = $this->vendor->getVendorById($id);
		if ($vendor) {
			$delete = $this->vendor_contact->delete($vendor_id, $id);
			if (!$delete) {
				$this->session->set_flashdata('errors', '<p>Unable to delete Vendor Contact.</p>');
			}
		} else {
			$this->session->set_flashdata('errors', '<p>Invalid Request.</p>');
		}
		redirect('vendors');
	}
}
