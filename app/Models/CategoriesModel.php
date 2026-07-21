<?php

namespace App\Models;

use CodeIgniter\Model;

class CategoriesModel extends Model
{
    protected $table            = 'categories';
    protected $primaryKey       = 'category_id';
    protected $returnType       = 'array';
    protected $allowedFields    = ['category_name'];
    protected $useTimestamps = false;
}
