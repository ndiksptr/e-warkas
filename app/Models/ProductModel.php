<?php 
namespace App\Models;
use CodeIgniter\Model;

class ProductModel extends Model
{
  protected $table = 'products';
  protected $primaryKey = 'product_id';
  protected $allowedFields = [
    'category_id',
    'unit_id',
    'product_name',
    'purchase_price',
    'selling_price',
    'stock',
    'product_img'
  ];
  protected $returnType = 'array';
  protected $useTimestamps = false;

  public function baseQuery()
  {
    return $this->db->table('products')
      ->join('categories','categories.category_id = products.category_id')
      ->join('units','units.unit_id = products.unit_id');
  }

  public function getAll()
  {
    return $this->baseQuery()
      ->get()
      ->getResultArray();
  }

  public function search($keyword)
  {
    return $this->baseQuery()
      ->groupStart()
        ->like('products.product_name', $keyword)
        ->orLike('categories.category_name', $keyword)
      ->groupEnd()
      ->get()
      ->getResultArray();
  }
}
