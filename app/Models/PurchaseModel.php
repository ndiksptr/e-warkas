<?php 

namespace App\Models;

use CodeIgniter\Model;

class PurchaseModel extends Model
{
  protected $table = 'purchase';
  protected $primaryKey = 'purchase_id';
  protected $allowedFields = ['user_id', 'purchase_date', 'total_amount'];
}