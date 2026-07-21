<?php 
namespace App\Models;
use CodeIgniter\Model;

class UsersModel extends Model
{
  protected $table = 'users';
  protected $primaryKey = 'user_id';
  protected $allowedFields = ['roles_id','user_name','password_hash','user_email','is_active','created_at'];
  protected $returnType = 'array';
  
  // GUNAKAN 'FALSE' JIKA TIDAK PERLU TIMESTAMP (created_at,updated_at)
  protected $useTimestamps = false;

  public function getAll(){
    $builder = $this->db->table('users');
    $builder->join('roles','roles.roles_id = users.roles_id');
    $query = $builder->get();
    return $query->getResultArray();
  }
}