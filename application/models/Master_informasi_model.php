<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Master_informasi_model extends MY_Model {
    protected $table            = 'master_informasi';
    protected $primaryKey       = 'id';
    protected $allowedFields    = ['name', 'category_id', 'timeline', 'tautan'];
    protected $useTimestamps    = TRUE;
    protected $createdField     = 'created_at';
    protected $updatedField     = 'updated_at';
}
