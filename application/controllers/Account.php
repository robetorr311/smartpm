<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Account extends CI_Controller {
	public function __construct()
	{
	    parent::__construct();
        $this->load->model('AccountModel');

    	$this->account = new AccountModel();
    }

	public function index()
	{
		$this->load->view('account/index');
	}

	public function login()
	{
		if($this->account->login($_POST['username'], $_POST['password']) == NULL) {
			$message = '<div class="error" title="Error:" >Invalid Account!</div>';
			$this->session->set_flashdata('message',$message);
			$this->load->view('account/index');
		}else{

			$array = json_decode(json_encode($_SESSION['admininfo']),true);
			$result1 = $this->account->get_crm_data('admin_setting',['color','url','favicon'],['user_id'=>$array['id']]);
			$this->session->set_userdata('admindata',$result1);
			redirect('dashboard');
		}

	}

	public function signup()
	{
		$this->load->view('account/register');
	}

	public function save()
	{
		if($this->account->mail_exists($_POST['username']) == TRUE){
			$message = '<div class="error" title="Error:" >Email Already Registered!</div>';
			$this->session->set_flashdata('message',$message);
			$this->load->view('account/register');
		}else{
			$_POST['password']=password_hash($_POST['password'], PASSWORD_BCRYPT);
			$_POST['usertype']='user';
			$query = $this->account->signup($_POST);	
			if( $query ) {

				$message = '<div class="error" title="Error:" style="color:white;background-color: green;border: green;">Registered Successfully.Please login!</div>';
				$this->session->set_flashdata('message',$message);
				redirect('account/index');
			} else {
				$message = '<div class="error" title="Error:" >Account not created. Please try again!</div>';
				$this->session->set_flashdata('message',$message);
			    redirect('account/index');
			}
		}



	}

	
}
