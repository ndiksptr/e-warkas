<?php

namespace App\Models;

use CodeIgniter\Model;

class SalesModel extends Model
{
    protected $table            = 'sales';
    protected $primaryKey       = 'sales_id';
    protected $returnType       = 'array';
    protected $allowedFields = [
        'sales_id',
        'user_id',
        'sales_date',
        'total_amount',
        'amount_paid',
        'cash_return',
        'payment_method'
    ];
    protected $useAutoIncrement = false;
    protected $useTimestamps = false;
}