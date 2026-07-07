<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Model extends CI_Model {
    protected $table = '';
    protected $primaryKey = 'id';
    protected $allowedFields = [];
    protected $useTimestamps = FALSE;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function select($select) {
        $this->db->select($select);
        return $this;
    }

    public function join($table, $cond, $type = '') {
        $this->db->join($table, $cond, $type);
        return $this;
    }

    public function where($key, $value = NULL) {
        if (is_array($key)) {
            $this->db->where($key);
        } else {
            $this->db->where($key, $value);
        }
        return $this;
    }

    public function groupStart() {
        $this->db->group_start();
        return $this;
    }

    public function groupEnd() {
        $this->db->group_end();
        return $this;
    }

    public function like($field, $match = '', $side = 'both', $escape = NULL) {
        $this->db->like($field, $match, $side, $escape);
        return $this;
    }

    public function orLike($field, $match = '', $side = 'both', $escape = NULL) {
        $this->db->or_like($field, $match, $side, $escape);
        return $this;
    }

    public function orderBy($orderby, $direction = '') {
        $this->db->order_by($orderby, $direction);
        return $this;
    }

    public function limit($value, $offset = 0) {
        $this->db->limit($value, $offset);
        return $this;
    }

    public function countAllResults() {
        // count_all_results clears the active record caches, so it's a terminal query
        return $this->db->count_all_results($this->table);
    }

    public function find($id) {
        $query = $this->db->where($this->primaryKey, $id)->get($this->table);
        return $query->row_array();
    }

    public function first() {
        $query = $this->db->limit(1)->get($this->table);
        return $query->row_array();
    }

    public function findAll() {
        $query = $this->db->get($this->table);
        return $query->result_array();
    }

    public function save($data) {
        // Filter only allowed fields to match CI4 entity protection
        $filteredData = [];
        foreach ($this->allowedFields as $field) {
            if (array_key_exists($field, $data)) {
                $filteredData[$field] = $data[$field];
            }
        }

        // Check if primaryKey exists and has a value, if so do update
        if (isset($data[$this->primaryKey]) && !empty($data[$this->primaryKey])) {
            $id = $data[$this->primaryKey];
            $this->update($id, $filteredData);
            return $id;
        } else {
            if ($this->useTimestamps) {
                $now = date('Y-m-d H:i:s');
                if ($this->createdField) {
                    $filteredData[$this->createdField] = $now;
                }
                if ($this->updatedField) {
                    $filteredData[$this->updatedField] = $now;
                }
            }
            $this->db->insert($this->table, $filteredData);
            return $this->db->insert_id();
        }
    }

    public function update($id, $data) {
        $filteredData = [];
        foreach ($this->allowedFields as $field) {
            if (array_key_exists($field, $data)) {
                $filteredData[$field] = $data[$field];
            }
        }

        if ($this->useTimestamps && $this->updatedField) {
            $filteredData[$this->updatedField] = date('Y-m-d H:i:s');
        }

        return $this->db->where($this->primaryKey, $id)->update($this->table, $filteredData);
    }

    public function delete($id) {
        return $this->db->where($this->primaryKey, $id)->delete($this->table);
    }
}
