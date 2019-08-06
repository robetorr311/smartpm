<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Leads extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		authAdminAccess();
		$this->load->model(['LeadModel', 'LeadNoteModel', 'LeadNoteReplyModel', 'UserModel', 'StatusTagModel', 'LeadStatusModel', 'PartyModel']);
		$this->load->library(['pagination', 'form_validation']);

		$this->lead = new LeadModel();
		$this->lead_note = new LeadNoteModel();
		$this->lead_note_reply = new LeadNoteReplyModel();
		$this->user = new UserModel();
		$this->status_tags = new StatusTagModel();
		$this->status = new LeadStatusModel();
		$this->party = new PartyModel();
	}

	public function index($start = 0)
	{
		$limit = 10;
		$pagiConfig = [
			'base_url' => base_url('leads'),
			'total_rows' => $this->lead->getCount(),
			'per_page' => $limit
		];
		$this->pagination->initialize($pagiConfig);

		$leads = $this->lead->getAllJob($start, $limit);
		$this->load->view('header', ['title' => 'Leads']);
		$this->load->view('leads/index', [
			'leads' => $leads,
			'pagiLinks' => $this->pagination->create_links()
		]);
		$this->load->view('footer');
	}

	public function create()
	{
		$this->load->view('header', ['title' => 'Add New Leads']);
		$this->load->view('leads/create');
		$this->load->view('footer');
	}

	public function show($jobid)
	{
		$lead = $this->lead->getLeadById($jobid);
		if ($lead) {
			$add_info = $this->party->getPartyByLeadId($jobid);
			$status = $this->status->getStatusByLeadId($jobid);
			$this->load->view('header', ['title' => 'Lead Detail']);
			$this->load->view('leads/show', ['status' => $status, 'lead' => $lead, 'add_info' => $add_info, 'jobid' => $jobid]);
			$this->load->view('footer');
		} else {
			$this->session->set_flashdata('errors', '<p>Invalid Request.</p>');
			redirect('leads');
		}
	}

	public function allAssignedLead($start = 0)
	{
		$limit = 10;
		$pagiConfig = [
			'base_url' => base_url('lead/signed'),
			'total_rows' => $this->lead->getSignedJobCount(),
			'per_page' => $limit
		];
		$this->pagination->initialize($pagiConfig);

		$leads = $this->lead->getAllSignedJob($start, $limit);
		$this->load->view('header', ['title' => 'Leads']);
		$this->load->view('leads/signed', [
			'leads' => $leads,
			'pagiLinks' => $this->pagination->create_links()
		]);
		$this->load->view('footer');
	}

	public function edit($jobid)
	{
		$lead = $this->lead->getLeadById($jobid);
		if ($lead) {
			$add_info = $this->party->getPartyByLeadId($jobid);
			$job_type_tags = $this->status_tags->getall('job_type');
			$lead_status_tags = $this->status_tags->getall('lead_status');
			$contract_status_tags = $this->status_tags->getall('contract_status');
			$status = $this->status->getStatusByLeadId($jobid);
			$this->load->view('header', ['title' => 'Lead Update']);
			$this->load->view('leads/edit', ['job_type_tags' => $job_type_tags, 'lead_status_tags' => $lead_status_tags, 'contract_status_tags' => $contract_status_tags, 'lead' => $lead, 'status' => $status, 'add_info' => $add_info, 'jobid' => $jobid]);
			$this->load->view('footer');
		} else {
			$this->session->set_flashdata('errors', '<p>Invalid Request.</p>');
			redirect('leads');
		}
	}


	public function store()
	{
		$this->form_validation->set_rules('jobname', 'Job Name', 'trim|required');
		$this->form_validation->set_rules('firstname', 'First Name', 'trim|required');
		$this->form_validation->set_rules('lastname', 'Last Name', 'trim|required');
		$this->form_validation->set_rules('address', 'Address', 'trim|required');
		$this->form_validation->set_rules('city', 'City', 'trim|required');
		$this->form_validation->set_rules('country', 'State', 'trim|required');
		$this->form_validation->set_rules('zip', 'Postal Code', 'trim|required');
		$this->form_validation->set_rules('phone1', 'Cell Phone', 'trim|required');
		$this->form_validation->set_rules('phone2', 'Home Phone', 'trim');
		$this->form_validation->set_rules('email', 'Email', 'trim');

		if ($this->form_validation->run() == TRUE) {
			$getjob = $this->db->query('SELECT * FROM jobs');
			$total = $getjob->num_rows();
			$total++;

			$posts = $this->input->post();
			$params['job_name'] 		= $posts['jobname'];
			$params['status'] 		= 'open';
			$params['firstname'] 		= $posts['firstname'];
			$params['lastname'] 		= $posts['lastname'];
			$params['address'] 		= $posts['address'];
			$params['city'] 		= $posts['city'];
			$params['state'] 		= $posts['country'];
			$params['zip'] 		= $posts['zip'];
			$params['phone1'] 		= $posts['phone1'];
			$params['phone2'] 		= $posts['phone2'];
			$params['email'] 		= $posts['email'];
			$params['entry_date'] 			= date('Y-m-d h:i:s');
			$params['is_active'] 			= TRUE;
			$params['job_number'] 		= 'RJOB' . $total;


			$query = $this->lead->add_record($params);
			$this->status->add_record([
				'jobid' => $query,
				'lead' => 'open',
				'contract' => 'unsigned'
			]);

			if ($query) {
				$message = '<div class="alert alert-success fade in alert-dismissable col-lg-12">';
				$message .= '<a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a><strong>Record Saved Successfully!</strong>';
				$message .= '</div>';
				$this->session->set_flashdata('errors', $message);
				redirect('leads');
			} else {
				$message = '<div class="alert alert-success fade in alert-dismissable col-lg-12">';
				$message .= '<a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a><strong>Job Not Saved Successfully!</strong>';
				$message .= '</div>';
				$this->session->set_flashdata('errors', $message);
			}
		} else {
			$errors = '<div class="alert alert-danger fade in alert-dismissable col-lg-12">';
			$errors .= '<a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a><strong>' . validation_errors() . ' </strong>';
			$errors .= '</div>';
			$this->session->set_flashdata('errors', $errors);
			$this->load->view('header', ['title' => 'Add New Leads']);
			$this->load->view('leads/new');
			$this->load->view('footer');
		}
	}


	public function update($id)
	{
		$this->form_validation->set_rules('jobname', 'Job Name', 'trim|required');
		$this->form_validation->set_rules('firstname', 'First Name', 'trim|required');
		$this->form_validation->set_rules('lastname', 'Last Name', 'trim|required');
		$this->form_validation->set_rules('address', 'Address', 'trim|required');
		$this->form_validation->set_rules('city', 'City', 'trim|required');
		$this->form_validation->set_rules('country', 'State', 'trim|required');
		$this->form_validation->set_rules('zip', 'Postal Code', 'trim|required');
		$this->form_validation->set_rules('phone1', 'Phone 1', 'trim|required');
		$this->form_validation->set_rules('phone2', 'Phone 2', 'trim');
		$this->form_validation->set_rules('email', 'Email', 'trim');

		if ($this->form_validation->run() == FALSE) {
			$errors = '<div class="alert alert-danger fade in alert-dismissable col-lg-12">';
			$errors .= '<a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a><strong>' . validation_errors() . '</strong>';
			$errors .= '</div>';
			$this->session->set_flashdata('errors', $errors);
			redirect('lead/' . $id . '/edit');
		} else {
			$posts = $this->input->post();
			$params = array();
			$params['job_name'] 		= $posts['jobname'];
			$params['firstname'] 		= $posts['firstname'];
			$params['lastname'] 		= $posts['lastname'];
			$params['address'] 		= $posts['address'];
			$params['city'] 		= $posts['city'];
			$params['state'] 		= $posts['country'];
			$params['zip'] 		= $posts['zip'];
			$params['phone1'] 		= $posts['phone1'];
			$params['phone2'] 		= $posts['phone2'];
			$params['email'] 		= $posts['email'];

			$this->lead->update_record($params, ['id' => $id]);
			$message = '<div class="alert alert-success fade in alert-dismissable col-lg-12">';
			$message .= '<a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a><strong>Record Saved Successfully!</strong>';
			$message .= '</div>';
			$this->session->set_flashdata('errors', $message);
			redirect('lead/' . $id . '/edit');
		}
	}

	public function updatestatus()
	{
		$posts = $this->input->post();
		if ($posts['status'] == 'job') {
			$this->status->update_record([
				'job' => $posts['value'],
				'production' => 'pre-production',
				'start_at' => date("Y-m-d h:i:s"),
			], ['jobid' => $posts['id']]);
			return true;
		} else {
			$this->status->update_record([
				$posts['status'] => $posts['value'],
				'production' => '',
				'job' => '',
				'start_at' =>  ''
			], ['jobid' => $posts['id']]);
			return true;
		}
	}

	public function closed($start = 0)
	{
		$limit = 10;
		$pagiConfig = [
			'base_url' => base_url('leads'),
			'total_rows' => $this->lead->getCountClosedJob(),
			'per_page' => $limit
		];
		$this->pagination->initialize($pagiConfig);
		$leads = $this->lead->getClosedJob();
		$this->load->view('header', ['title' => 'Closed Jobs']);
		$this->load->view('leads/closed', ['leads' => $leads, 'pagiLinks' => $this->pagination->create_links()]);
		$this->load->view('footer');
	}

	public function archive($start = 0)
	{
		$limit = 10;
		$pagiConfig = [
			'base_url' => base_url('leads'),
			'total_rows' => $this->lead->getCountClosedJob(),
			'per_page' => $limit
		];
		$this->pagination->initialize($pagiConfig);
		$leads = $this->lead->getClosedJob();
		$this->load->view('header', ['title' => 'Archive Jobs']);
		$this->load->view('leads/archive', ['leads' => $leads, 'pagiLinks' => $this->pagination->create_links()]);
		$this->load->view('footer');
	}

	public function notes($leadId)
	{
		$lead = $this->lead->getLeadById($leadId);
		if ($lead) {
			$notes = $this->lead_note->getNotesByLeadId($leadId);
			$users = $this->user->getUserList();

			$this->load->view('header', ['title' => 'Job Notes']);
			$this->load->view('leads/notes', ['lead' => $lead, 'notes' => $notes, 'users' => $users]);
			$this->load->view('footer');
		} else {
			$this->session->set_flashdata('errors', '<p>Invalid Request.</p>');
			redirect('leads');
		}
	}

	public function addNote($leadId)
	{
		$lead = $this->lead->getLeadById($leadId);
		if ($lead) {
			$this->form_validation->set_rules('note', 'Note', 'trim|required');

			if ($this->form_validation->run() == TRUE) {
				$noteData = $this->input->post();
				$insert = $this->lead_note->insert([
					'note' => nl2br($noteData['note']),
					'job_id' => $leadId
				]);
				if ($insert) {
					$userIds = [];
					if (preg_match_all('~(@\w+)~', $noteData['note'], $matches, PREG_PATTERN_ORDER)) {
						$usernames = array_map(function ($val) {
							return ltrim($val, '@');
						}, $matches[1]);
						$userIds = $this->user->getUserIdArrByUserNames($usernames);
					}
					// use userIds to send emails to those users
				} else {
					$this->session->set_flashdata('errors', '<p>Unable to add Note.</p>');
				}
			} else {
				$this->session->set_flashdata('errors', validation_errors());
			}
			redirect('lead/' . $leadId . '/notes');
		} else {
			$this->session->set_flashdata('errors', '<p>Invalid Request.</p>');
			redirect('leads');
		}
	}

	public function deleteNote($leadId, $noteId)
	{
		$lead = $this->lead->getLeadById($leadId);
		if ($lead) {
			$delete = $this->lead_note->delete($noteId, $leadId);
			if (!$delete) {
				$this->session->set_flashdata('errors', '<p>Unable to Delete Note.</p>');
			}
			redirect('lead/' . $leadId . '/notes');
		} else {
			$this->session->set_flashdata('errors', '<p>Invalid Request.</p>');
			redirect('leads');
		}
	}

	public function replies($leadId, $noteId)
	{
		$lead = $this->lead->getLeadById($leadId);
		if ($lead) {
			$note = $this->lead_note->getNoteById($noteId, $leadId);
			if ($note) {
				$note_replies = $this->lead_note_reply->getRepliesByNoteId($noteId);
				$users = $this->user->getUserList();

				$this->load->view('header', ['title' => 'Job Notes']);
				$this->load->view('leads/note_replies', ['lead' => $lead, 'note' => $note, 'note_replies' => $note_replies, 'users' => $users]);
				$this->load->view('footer');
			} else {
				$this->session->set_flashdata('errors', '<p>Invalid Request.</p>');
				redirect('lead/' . $leadId . '/notes');
			}
		} else {
			$this->session->set_flashdata('errors', '<p>Invalid Request.</p>');
			redirect('leads');
		}
	}

	public function addNoteReply($leadId, $noteId)
	{
		$lead = $this->lead->getLeadById($leadId);
		if ($lead) {
			$note = $this->lead_note->getNoteById($noteId, $leadId);
			if ($note) {
				$this->form_validation->set_rules('reply', 'Reply', 'trim|required');

				if ($this->form_validation->run() == TRUE) {
					$replyData = $this->input->post();
					$insert = $this->lead_note_reply->insert([
						'reply' => nl2br($replyData['reply']),
						'note_id' => $noteId
					]);
					if ($insert) {
						$userIds = [];
						if (preg_match_all('~(@\w+)~', $replyData['reply'], $matches, PREG_PATTERN_ORDER)) {
							$usernames = array_map(function ($val) {
								return ltrim($val, '@');
							}, $matches[1]);
							$userIds = $this->user->getUserIdArrByUserNames($usernames);
						}
						// use userIds to send emails to those users
					} else {
						$this->session->set_flashdata('errors', '<p>Unable to add Note.</p>');
					}
				} else {
					$this->session->set_flashdata('errors', validation_errors());
				}
				redirect('lead/' . $leadId . '/note/' . $noteId . '/replies');
			} else {
				$this->session->set_flashdata('errors', '<p>Invalid Request.</p>');
				redirect('lead/' . $leadId . '/notes');
			}
		} else {
			$this->session->set_flashdata('errors', '<p>Invalid Request.</p>');
			redirect('leads');
		}
	}

	public function deleteNoteReply($leadId, $noteId, $replyId)
	{
		$lead = $this->lead->getLeadById($leadId);
		if ($lead) {
			$note = $this->lead_note->getNoteById($noteId, $leadId);
			if ($note) {
				$delete = $this->lead_note_reply->delete($replyId, $noteId);
				if (!$delete) {
					$this->session->set_flashdata('errors', '<p>Unable to Delete Note.</p>');
				}
				redirect('lead/' . $leadId . '/note/' . $noteId . '/replies');
			} else {
				$this->session->set_flashdata('errors', '<p>Invalid Request.</p>');
				redirect('lead/' . $leadId . '/notes');
			}
		} else {
			$this->session->set_flashdata('errors', '<p>Invalid Request.</p>');
			redirect('leads');
		}
	}
}
