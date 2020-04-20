<?php
defined('BASEPATH') or exit('No direct script access allowed');

class CompanyPhotosModel extends CI_Model
{
    private $table = 'company_photos';

    // private static $type = [
    //     0 => 'File',
    //     1 => 'Folder'
    // ];

    public function allFilesFolders($id = false)
    {
        $this->db->from($this->table);
        if ($id) {
            $this->db->where('path', "(SELECT CONCAT(path, name, '/') FROM company_photos WHERE id=" . $id . ")", false);
        } else {
            $this->db->where('path', '/');
        }
        $query = $this->db->get();
        return $query->result();
    }

    public function getById($id)
    {
        $this->db->from($this->table);
        $this->db->where([
            'id' => $id
        ]);
        $query = $this->db->get();
        $result = $query->first_row();
        return $result ? $result : false;
    }

    public function getByPublicKey($company_code, $public_key)
    {
        $this->db->from('smartpm_' . $company_code . '.' . $this->table);
        $this->db->where([
            'public_key' => $public_key
        ]);
        $query = $this->db->get();
        $result = $query->first_row();
        return $result ? $result : false;
    }

    public function getByIdAndPathCompanyCode($company_code, $path, $id = false)
    {
        $this->db->from('smartpm_' . $company_code . '.' . $this->table);
        if ($id) {
            $this->db->where([
                'id' => $id,
                'path LIKE ' => $path . '%'
            ]);
        } else {
            $this->db->where('path LIKE ', $path);
        }
        $query = $this->db->get();
        $result = $query->first_row();
        return $result ? $result : false;
    }

    public function getFileByIdAndPathCompanyCode($company_code, $path, $id = false)
    {
        $this->db->from('smartpm_' . $company_code . '.' . $this->table);
        if ($id) {
            $this->db->where([
                'id' => $id,
                'type' => 0,
                'path LIKE ' => $path . '%'
            ]);
        } else {
            $this->db->where('path LIKE ', $path);
        }
        $query = $this->db->get();
        $result = $query->first_row();
        return $result ? $result : false;
    }

    public function allFilesFoldersOfCompany($company_code, $id = false)
    {
        $this->db->from('smartpm_' . $company_code . '.' . $this->table);
        if ($id) {
            $this->db->where('path', "(SELECT CONCAT(path, name, '/') FROM smartpm_" . $company_code . ".company_photos WHERE id=" . $id . ")", false);
        } else {
            $this->db->where('path', '/');
        }
        $query = $this->db->get();
        return $query->result();
    }

    public function insert($data)
    {
        $insert = $this->db->insert($this->table, $data);
        return $insert ? $this->db->insert_id() : $insert;
    }

    public function update($id, $data)
    {
        $this->db->where('id', $id);
        $update = $this->db->update($this->table, $data);
        return $update;
    }

    public function delete($id)
    {
        $this->db->where('id', $id);
        return $this->db->delete($this->table);
    }

    public function deleteSubPaths($path)
    {
        $this->db->where('path LIKE', ("'" . $path . "%'"), false);
        return $this->db->delete($this->table);
    }

    public function savePublicKey($id)
    {
        return $this->update($id, [
            'public_key' => $this->generatePublicKey($id)
        ]);
    }

    /**
     * Private Methods
     */
    private function generatePublicKey($id)
    {
        $md5Key1 = md5(time());
        $md5Key2 = md5($id . rand());
        return $md5Key1 . $id . $md5Key2;
    }
}
