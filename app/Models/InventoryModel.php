<?php 

namespace App\Models;

use CodeIgniter\Model;

class InventoryModel extends Model
{
  protected $table = 'inventory';
  protected $primaryKey = 'inventory_id';
  protected $allowedFields = ['product_id', 'user_id', 'transaction_type', 'quantity', 'description', 'created_at'];
}