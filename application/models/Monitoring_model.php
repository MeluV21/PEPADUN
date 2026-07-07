<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Monitoring_model extends MY_Model {
    protected $table            = 'monitoring';
    protected $primaryKey       = 'id';
    protected $allowedFields    = ['title', 'category_id', 'description', 'status', 'created_by', 'activity_date'];
    protected $useTimestamps    = TRUE;
    protected $createdField     = 'created_at';
    protected $updatedField     = 'updated_at';
}
