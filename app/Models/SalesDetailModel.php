<?php

namespace App\Models;

use CodeIgniter\Model;

class SalesDetailModel extends Model
{
    protected $table            = 'sales_detail';
    protected $primaryKey       = 'sales_detail_id';
    protected $returnType       = 'array';
    protected $allowedFields = [
        'sales_id',
        'user_id',
        'product_id',
        'current_capital',
        'price',
        'quantity',
        'subtotal',
    ];
    protected $useTimestamps = false;
}