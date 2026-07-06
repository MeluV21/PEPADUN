<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Category_model extends MY_Model {
    protected $table            = 'categories';
    protected $primaryKey       = 'id';
    protected $allowedFields    = ['name', 'description'];
    protected $useTimestamps    = TRUE;
    protected $createdField     = 'created_at';
    protected $updatedField     = 'updated_at';
}
