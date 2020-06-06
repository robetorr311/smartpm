<?php
defined('BASEPATH') or exit('No direct script access allowed');

class ActivityLogsModel extends CI_Model
{
	private $table = 'activity_logs';

	// private static $module = [
	// 	0 => 'lead_client'
	// ];

	// private static $type = [
	// 	0 => 'new',
	// 	1 => 'new_note',
	// 	2 => 'new_photos',
	// 	3 => 'new_documents',
	// 	4 => 'change_status',
	//  5 => 'delete_photo',
	//  6 => 'change_dumpster_status',
	//  7 => 'change_materials_status',
	//  8 => 'change_labor_status',
	//  9 => 'change_permit_status',
	// ];

	public function getLast50()
	{
		$this->db->select("
            activity_logs.*,
            CONCAT(users_created_by.first_name, ' ', users_created_by.last_name, ' (@', users_created_by.username, ')') as created_user_fullname,
            CONCAT(client.firstname, ' ', client.lastname) as client_name
        ");
		$this->db->from($this->table);
		$this->db->join('users as users_created_by', 'activity_logs.created_by=users_created_by.id', 'left');
		$this->db->join('jobs as client', 'activity_logs.module_id=client.id', 'left');
		$this->db->where('activity_logs.is_deleted', FALSE);
		$this->db->where('client.is_deleted', FALSE);
		$this->db->order_by('created_at', 'DESC');
		$this->db->limit(50);
		$query = $this->db->get();
		return $query->result();
	}

	public function getLogsByLeadId($lead_id)
	{
		$this->db->select("
            activity_logs.*,
            CONCAT(users_created_by.first_name, ' ', users_created_by.last_name, ' (@', users_created_by.username, ')') as created_user_fullname,
            CONCAT(client.firstname, ' ', client.lastname) as client_name
        ");
		$this->db->from($this->table);
		$this->db->join('users as users_created_by', 'activity_logs.created_by=users_created_by.id', 'left');
		$this->db->join('jobs as client', 'activity_logs.module_id=client.id', 'left');
		$this->db->where('activity_logs.is_deleted', FALSE);
		$this->db->where('client.is_deleted', FALSE);
		$this->db->where('activity_logs.module_id', $lead_id);
		$this->db->where('activity_logs.module', 0);
		$this->db->order_by('created_at', 'DESC');
		$this->db->limit(50);
		$query = $this->db->get();
		return $query->result();
	}

	public function insert($data)
	{
		$data['created_by'] = $this->session->id;
		$insert = $this->db->insert($this->table, $data);
		return $insert ? $this->db->insert_id() : $insert;
	}

	/**
	 * Static Methods
	 */
	// public static function typeToStr($id)
	// {
	// 	return isset(self::$type[$id]) ? self::$type[$id] : $id;
	// }

	// public static function getType()
	// {
	// 	return self::$type;
	// }

	public static function stringifyLog($log)
	{
		if ($log->module == 0) {
			if ($log->type == 0) {
				return $log->created_user_fullname . ' - Added new Client: <a href="' . base_url('lead/' . $log->module_id) . '">' . $log->client_name . '</a> - ' . $log->created_at;
			} else if ($log->type == 1) {
				$activity_data = json_decode($log->activity_data);
				return $log->created_user_fullname . ' - Added a Note to <a href="' . base_url('lead/' . $log->module_id) . '">' . $log->client_name . '</a> - ' . $log->created_at . '<br />"' . $activity_data->note . '"';
			} else if ($log->type == 2) {
				return $log->created_user_fullname . ' - Added new Photo to <a href="' . base_url('lead/' . $log->module_id) . '">' . $log->client_name . '</a> - ' . $log->created_at;
			} else if ($log->type == 3) {
				return $log->created_user_fullname . ' - Added new Document to <a href="' . base_url('lead/' . $log->module_id) . '">' . $log->client_name . '</a> - ' . $log->created_at;
			} else if ($log->type == 4) {
				$activity_data = json_decode($log->activity_data);
				return $log->created_user_fullname . ' - Updated Client <a href="' . base_url('lead/' . $log->module_id) . '">' . $log->client_name . '</a> status to "' . LeadModel::statusToStr($activity_data->status) . '" - ' . $log->created_at;
			} else if ($log->type == 5) {
				$activity_data = json_decode($log->activity_data);
				return $log->created_user_fullname . ' - Deleted a Photo from <a href="' . base_url('lead/' . $log->module_id) . '">' . $log->client_name . '</a> - ' . $log->created_at;
			} else if ($log->type == 6) {
				$activity_data = json_decode($log->activity_data);
				return $log->created_user_fullname . ' - ' . LeadModel::dumpsterStatusToStr($activity_data->dumpster_status) . ' dumpster for <a href="' . base_url('lead/' . $log->module_id) . '">' . $log->client_name . '</a> - ' . $log->created_at;
			} else if ($log->type == 7) {
				$activity_data = json_decode($log->activity_data);
				return $log->created_user_fullname . ' - ' . LeadModel::materialStatusToStr($activity_data->materials_status) . ' materials for <a href="' . base_url('lead/' . $log->module_id) . '">' . $log->client_name . '</a> - ' . $log->created_at;
			} else if ($log->type == 8) {
				$activity_data = json_decode($log->activity_data);
				return $log->created_user_fullname . ' - ' . LeadModel::laborStatusToStr($activity_data->labor_status) . ' labor for <a href="' . base_url('lead/' . $log->module_id) . '">' . $log->client_name . '</a> - ' . $log->created_at;
			} else if ($log->type == 9) {
				$activity_data = json_decode($log->activity_data);
				return $log->created_user_fullname . ' - ' . LeadModel::permitStatusToStr($activity_data->permit_status) . ' permit for <a href="' . base_url('lead/' . $log->module_id) . '">' . $log->client_name . '</a> - ' . $log->created_at;
			}
		}

		return '-';
	}
}
