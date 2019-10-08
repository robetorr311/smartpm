<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Leads extends CI_Controller
{
	private $title = 'Leads / Clients';

	public function __construct()
	{
		parent::__construct();

		$this->load->model(['LeadModel', 'LeadNoteModel', 'LeadNoteReplyModel', 'UserModel', 'PartyModel', 'InsuranceJobDetailsModel', 'InsuranceJobAdjusterModel', 'TeamModel', 'TeamJobTrackModel', 'PartyModel']);
		$this->load->library(['pagination', 'form_validation']);

		$this->lead = new LeadModel();
		$this->lead_note = new LeadNoteModel();
		$this->lead_note_reply = new LeadNoteReplyModel();
		$this->user = new UserModel();
		$this->party = new PartyModel();
		$this->insurance_job_details = new InsuranceJobDetailsModel();
		$this->insurance_job_adjuster = new InsuranceJobAdjusterModel();
		$this->team = new TeamModel();
		$this->team_job_track = new TeamJobTrackModel();
	}

	public function index($start = 0)
	{
		authAccess();

		$limit = 10;
		$pagiConfig = [
			'base_url' => base_url('leads'),
			'total_rows' => $this->lead->getLeadsCount(),
			'per_page' => $limit
		];
		$this->pagination->initialize($pagiConfig);

		$leads = $this->lead->allLeads($start, $limit);
		$this->load->view('header', ['title' => $this->title]);
		$this->load->view('leads/index', [
			'leads' => $leads,
			'pagiLinks' => $this->pagination->create_links()
		]);
		$this->load->view('footer');
	}

	public function create()
	{
		authAccess();

		$this->load->view('header', ['title' => $this->title]);
		$this->load->view('leads/create');
		$this->load->view('footer');
	}

	public function store()
	{
		authAccess();

		$this->form_validation->set_rules('firstname', 'First Name', 'trim|required');
		$this->form_validation->set_rules('lastname', 'Last Name', 'trim|required');
		$this->form_validation->set_rules('address', 'Address', 'trim|required');
		$this->form_validation->set_rules('city', 'City', 'trim|required');
		$this->form_validation->set_rules('state', 'State', 'trim|required');
		$this->form_validation->set_rules('zip', 'Postal Code', 'trim|required');
		$this->form_validation->set_rules('phone1', 'Cell Phone', 'trim|required');
		$this->form_validation->set_rules('phone2', 'Home Phone', 'trim');
		$this->form_validation->set_rules('email', 'Email', 'trim|valid_email');
		// $this->form_validation->set_rules('ap_firstname', 'Additional Party First Name', 'trim|required');

		if ($this->form_validation->run() == TRUE) {
			$posts = $this->input->post();
			$insert = $this->lead->insert([
				'firstname' => $posts['firstname'],
				'lastname' => $posts['lastname'],
				'address' => $posts['address'],
				'city' => $posts['city'],
				'state' => $posts['state'],
				'zip' => $posts['zip'],
				'phone1' => $posts['phone1'],
				'phone2' => $posts['phone2'],
				'email' => $posts['email'],
				'entry_date' => date('Y-m-d h:i:s')
			]);

			if ($insert) {
				$ap_insert = $this->party->insert([
					'job_id' => $insert,
					'fname' => $posts['ap_firstname'],
					'lname' => $posts['ap_lastname'],
					'email' => $posts['ap_email'],
					'phone' => $posts['ap_phone']
				]);
				redirect('lead/' . $insert);
			} else {
				$this->session->set_flashdata('errors', '<p>Unable to Create Lead.</p>');
				redirect('lead/create');
			}
		} else {
			$this->session->set_flashdata('errors', validation_errors());
			redirect('lead/create');
		}
	}

	public function edit($jobid, $sub_base_path = '')
	{
		authAccess();

		$o_sub_base_path = $sub_base_path;
		$sub_base_path = $sub_base_path != '' ? ($sub_base_path . '/') : $sub_base_path;
		$lead = $this->lead->getLeadById($jobid);
		if ($lead) {
			$add_info = $this->party->getPartyByLeadId($jobid);
			$teams_detail = false;
			$teams = [];
			if (in_array($lead->status, [7, 8, 9, 12])) {
				$teams_detail = $this->team_job_track->getTeamName($jobid);
				$teams = $this->team->getTeamOnly(['is_deleted' => 0]);
			}
			$insurance_job_details = false;
			$insurance_job_adjusters = false;
			if ($lead->status == 7) {
				$insurance_job_details = $this->insurance_job_details->getInsuranceJobDetailsByLeadId($jobid);
				$insurance_job_adjusters = $this->insurance_job_adjuster->allAdjusters($jobid);
			}
			$job_type_tags = LeadModel::getType();
			$lead_status_tags = LeadModel::getStatus();
			$this->load->view('header', ['title' => $this->title]);
			$this->load->view('leads/edit', [
				'job_type_tags' => $job_type_tags,
				'lead_status_tags' => $lead_status_tags,
				'lead' => $lead,
				'add_info' => $add_info,
				'jobid' => $jobid,
				'sub_base_path' => $sub_base_path,
				'insurance_job_details' => $insurance_job_details,
				'insurance_job_adjusters' => $insurance_job_adjusters,
				'teams_detail' => $teams_detail,
				'teams' => $teams
			]);
			$this->load->view('footer');
		} else {
			$this->session->set_flashdata('errors', '<p>Invalid Request.</p>');
			redirect($o_sub_base_path != '' ? ('lead/' . $o_sub_base_path . 's') : 'leads');
		}
	}

	public function update($id, $sub_base_path = '')
	{
		authAccess();

		$sub_base_path = $sub_base_path != '' ? ($sub_base_path . '/') : $sub_base_path;
		$this->form_validation->set_rules('firstname', 'First Name', 'trim|required');
		$this->form_validation->set_rules('lastname', 'Last Name', 'trim|required');
		$this->form_validation->set_rules('address', 'Address', 'trim|required');
		$this->form_validation->set_rules('city', 'City', 'trim|required');
		$this->form_validation->set_rules('state', 'State', 'trim|required');
		$this->form_validation->set_rules('zip', 'Postal Code', 'trim|required');
		$this->form_validation->set_rules('phone1', 'Phone 1', 'trim|required');
		$this->form_validation->set_rules('phone2', 'Phone 2', 'trim');
		$this->form_validation->set_rules('email', 'Email', 'trim|valid_email');

		if ($this->form_validation->run() == TRUE) {
			$posts = $this->input->post();
			$update = $this->lead->update($id, [
				'firstname' => $posts['firstname'],
				'lastname' => $posts['lastname'],
				'address' => $posts['address'],
				'city' => $posts['city'],
				'state' => $posts['state'],
				'zip' => $posts['zip'],
				'phone1' => $posts['phone1'],
				'phone2' => $posts['phone2'],
				'email' => $posts['email'],
			]);
			if ($update) {
				redirect('lead/' . $sub_base_path . $id);
			} else {
				$this->session->set_flashdata('errors', '<p>Unable to Update Task.</p>');

				redirect('lead/' . $sub_base_path . $id . '/edit');
			}
		} else {
			$this->session->set_flashdata('errors', validation_errors());
			redirect('lead/' . $sub_base_path . $id . '/edit');
		}
	}

	public function updatestatus($id, $sub_base_path = '')
	{
		authAccess();

		$sub_base_path = $sub_base_path != '' ? ($sub_base_path . '/') : $sub_base_path;
		$this->form_validation->set_rules('status', 'Status', 'trim|required|numeric');
		$this->form_validation->set_rules('type', 'Type', 'trim|required|numeric');

		if ($this->form_validation->run() == TRUE) {
			$posts = $this->input->post();
			$update = $this->lead->update($id, [
				'status' => $posts['status'],
				'type' => $posts['type']
			]);

			if ($update) {
				$lead = $this->lead->getLeadById($id);
				if ($lead->signed_stage == 1 && ($lead->status == 7 || $lead->status == 8 || $lead->status == 9)) {
					$sub_base_path = 'production-job/';
				} else if ($lead->signed_stage == 2 && ($lead->status == 7 || $lead->status == 8 || $lead->status == 9)) {
					$sub_base_path = 'completed-job/';
				} else if ($lead->status == 7) {
					$sub_base_path = 'insurance-job/';
				} else if ($lead->status == 8) {
					$sub_base_path = 'cash-job/';
				} else if ($lead->status == 9) {
					$sub_base_path = 'labor-job/';
				} else {
					$sub_base_path = '';
				}
				redirect('lead/' . $sub_base_path . $id);
			} else {
				$this->session->set_flashdata('errors', '<p>Unable to Update Task.</p>');
				redirect('lead/' . $sub_base_path . $id . '/edit');
			}
		} else {
			$this->session->set_flashdata('errors', validation_errors());
			redirect('lead/' . $sub_base_path . $id . '/edit');
		}
	}

	public function show($jobid)
	{
		authAccess();

		$lead = $this->lead->getLeadById($jobid);
		if ($lead) {
			$add_info = $this->party->getPartyByLeadId($jobid);
			$this->load->view('header', ['title' => $this->title]);
			$this->load->view('leads/show', [
				'lead' => $lead,
				'add_info' => $add_info,
				'jobid' => $jobid
			]);
			$this->load->view('footer');
		} else {
			$this->session->set_flashdata('errors', '<p>Invalid Request.</p>');
			redirect('leads');
		}
	}

	public function delete($id, $sub_base_path = '')
	{
		authAccess();

		$this->lead->delete($id);
		redirect($sub_base_path != '' ? ('lead/' . $sub_base_path . 's') : 'leads');
	}

	public function notes($leadId, $sub_base_path = '')
	{
		authAccess();

		$o_sub_base_path = $sub_base_path;
		$sub_base_path = $sub_base_path != '' ? ($sub_base_path . '/') : $sub_base_path;
		$lead = $this->lead->getLeadById($leadId);
		if ($lead) {
			$notes = $this->lead_note->getNotesByLeadId($leadId);
			$users = $this->user->getUserList();

			$this->load->view('header', ['title' => $this->title . ' Notes']);
			$this->load->view('leads/notes', [
				'lead' => $lead,
				'notes' => $notes,
				'users' => $users,
				'sub_base_path' => $sub_base_path
			]);
			$this->load->view('footer');
		} else {
			$this->session->set_flashdata('errors', '<p>Invalid Request.</p>');
			redirect($o_sub_base_path != '' ? ('lead/' . $o_sub_base_path . 's') : 'leads');
		}
	}

	public function addNote($leadId, $sub_base_path = '')
	{
		authAccess();

		$o_sub_base_path = $sub_base_path;
		$sub_base_path = $sub_base_path != '' ? ($sub_base_path . '/') : $sub_base_path;
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
			redirect('lead/' . $sub_base_path . $leadId . '/notes');
		} else {
			$this->session->set_flashdata('errors', '<p>Invalid Request.</p>');
			redirect($o_sub_base_path != '' ? ('lead/' . $o_sub_base_path . 's') : 'leads');
		}
	}

	public function deleteNote($leadId, $noteId, $sub_base_path = '')
	{
		authAccess();

		$o_sub_base_path = $sub_base_path;
		$sub_base_path = $sub_base_path != '' ? ($sub_base_path . '/') : $sub_base_path;
		$lead = $this->lead->getLeadById($leadId);
		if ($lead) {
			$delete = $this->lead_note->delete($noteId, $leadId);
			if (!$delete) {
				$this->session->set_flashdata('errors', '<p>Unable to Delete Note.</p>');
			}
			redirect('lead/' . $sub_base_path . $leadId . '/notes');
		} else {
			$this->session->set_flashdata('errors', '<p>Invalid Request.</p>');
			redirect($o_sub_base_path != '' ? ('lead/' . $o_sub_base_path . 's') : 'leads');
		}
	}

	public function replies($leadId, $noteId, $sub_base_path = '')
	{
		authAccess();

		$o_sub_base_path = $sub_base_path;
		$sub_base_path = $sub_base_path != '' ? ($sub_base_path . '/') : $sub_base_path;
		$lead = $this->lead->getLeadById($leadId);
		if ($lead) {
			$note = $this->lead_note->getNoteById($noteId, $leadId);
			if ($note) {
				$note_replies = $this->lead_note_reply->getRepliesByNoteId($noteId);
				$users = $this->user->getUserList();

				$this->load->view('header', ['title' => $this->title . ' Notes']);
				$this->load->view('leads/note_replies', [
					'lead' => $lead,
					'note' => $note,
					'note_replies' => $note_replies,
					'users' => $users,
					'sub_base_path' => $sub_base_path
				]);
				$this->load->view('footer');
			} else {
				$this->session->set_flashdata('errors', '<p>Invalid Request.</p>');
				redirect('lead/' . $sub_base_path . $leadId . '/notes');
			}
		} else {
			$this->session->set_flashdata('errors', '<p>Invalid Request.</p>');
			redirect($o_sub_base_path != '' ? ('lead/' . $o_sub_base_path . 's') : 'leads');
		}
	}

	public function addNoteReply($leadId, $noteId, $sub_base_path = '')
	{
		authAccess();

		$o_sub_base_path = $sub_base_path;
		$sub_base_path = $sub_base_path != '' ? ($sub_base_path . '/') : $sub_base_path;
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
				redirect('lead/' . $sub_base_path . $leadId . '/note/' . $noteId . '/replies');
			} else {
				$this->session->set_flashdata('errors', '<p>Invalid Request.</p>');
				redirect('lead/' . $sub_base_path . $leadId . '/notes');
			}
		} else {
			$this->session->set_flashdata('errors', '<p>Invalid Request.</p>');
			redirect($o_sub_base_path != '' ? ('lead/' . $o_sub_base_path . 's') : 'leads');
		}
	}

	public function deleteNoteReply($leadId, $noteId, $replyId, $sub_base_path = '')
	{
		authAccess();

		$o_sub_base_path = $sub_base_path;
		$sub_base_path = $sub_base_path != '' ? ($sub_base_path . '/') : $sub_base_path;
		$lead = $this->lead->getLeadById($leadId);
		if ($lead) {
			$note = $this->lead_note->getNoteById($noteId, $leadId);
			if ($note) {
				$delete = $this->lead_note_reply->delete($replyId, $noteId);
				if (!$delete) {
					$this->session->set_flashdata('errors', '<p>Unable to Delete Note.</p>');
				}
				redirect('lead/' . $sub_base_path . $leadId . '/note/' . $noteId . '/replies');
			} else {
				$this->session->set_flashdata('errors', '<p>Invalid Request.</p>');
				redirect('lead/' . $sub_base_path . $leadId . '/notes');
			}
		} else {
			$this->session->set_flashdata('errors', '<p>Invalid Request.</p>');
			redirect($o_sub_base_path != '' ? ('lead/' . $o_sub_base_path . 's') : 'leads');
		}
	}

	public function addTeam($jobid, $sub_base_path = '')
	{
		authAccess();

		$sub_base_path = $sub_base_path != '' ? ($sub_base_path . '/') : $sub_base_path;
		$this->form_validation->set_rules('team_id', 'Team', 'trim|required');

		if ($this->form_validation->run() == TRUE) {
			$posts = $this->input->post();
			$params = array();
			$params['team_id'] = $posts['team_id'];
			$params['job_id'] = $jobid;
			$params['assign_date'] = date('Y-m-d h:i:s');
			$params['is_deleted'] = false;
			$this->team_job_track->add_record($params);
		} else {
			$this->session->set_flashdata('errors', validation_errors());
		}
		redirect('lead/' . $sub_base_path . $jobid . '/edit');
	}

	public function removeTeam($jobid, $sub_base_path = '')
	{
		authAccess();

		$sub_base_path = $sub_base_path != '' ? ($sub_base_path . '/') : $sub_base_path;
		$this->team_job_track->remove_team($jobid);
		redirect('lead/' . $sub_base_path . $jobid . '/edit');
	}
}
