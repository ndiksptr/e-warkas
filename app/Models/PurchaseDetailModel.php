<?php 

namespace App\Models;

use CodeIgniter\Model;

class PurchaseDetailModel extends Model
{
  protected $table = 'purchase_detail';
  protected $primaryKey = 'purchase_detail_id';
  protected $allowedFields = ['purchase_id', 'product_id', 'price', 'quantity', 'subtotal'];
}