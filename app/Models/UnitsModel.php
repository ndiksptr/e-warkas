<?php

namespace App\Models;

use CodeIgniter\Model;

class UnitsModel extends Model
{
    protected $table            = 'units';
    protected $primaryKey       = 'unit_id';
    protected $returnType       = 'array';
    protected $allowedFields    = ['unit_name'];
    protected $useTimestamps = false;
}
