<?php 

namespace App\Models;

use CodeIgniter\Model;

class RolesModel extends Model
{
  protected $table = 'roles';
  protected $primaryKey = 'roles_id';
  protected $allowedFields = ['name'];
  protected $returnType = 'array';
  
  // GUNAKAN 'FALSE' JIKA TIDAK PERLU TIMESTAMP (created_at,updated_at)
  protected $useTimestamps = false; 
}