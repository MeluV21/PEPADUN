<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends MY_Model {
    protected $table            = 'users';
    protected $primaryKey       = 'id';
    protected $allowedFields    = ['username', 'password', 'fullname', 'role'];
    protected $useTimestamps    = TRUE;
    protected $createdField     = 'created_at';
    protected $updatedField     = 'updated_at';
}
