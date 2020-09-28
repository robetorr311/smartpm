<?php
defined('BASEPATH') or exit('No direct script access allowed');

class FinancialAttachmentModel extends CI_Model
{
    private $table = 'financial_attachments';

    public function allAttachmentsByFinancialId($financial_id)
    {
        $this->db->from($this->table);
        $this->db->where('financial_id', $financial_id);
        $this->db->where('is_deleted', FALSE);
        $this->db->order_by('created_at', 'ASC');
        $query = $this->db->get();
        return $query->result();
    }

    public function insertArr($attachments, $financial_id)
    {
        if (is_array($attachments) && count($attachments) > 0) {
            $data = $this->buildFinancialAttachmentsInsertArr($attachments, $financial_id);
            $insert = $this->db->insert_batch($this->table, $data);
            return $insert;
        } else {
            return false;
        }
    }

    public function deleteByFinancialIdWithExceptionIds($financial_id, $exception_ids)
    {
        $this->db->where('financial_id', $financial_id);
        $this->db->where_not_in('id', $exception_ids);
        return $this->db->update($this->table, [
            'is_deleted' => TRUE
        ]);
    }

    /**
     * Private Methods
     */
    private function buildFinancialAttachmentsInsertArr($attachments, $financial_id)
    {
        $return = [];
        foreach ($attachments as $attachment) {
            $return[] = [
                'financial_id' => $financial_id,
                'attachment' => $attachment
            ];
        }
        return $return;
    }
}
