<?php 
namespace App\Models;

use CodeIgniter\Model;

class CajasModel extends Model{
    protected $table      = 'cajas';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = ['caja', 'estado'];
    protected $useTimestamps = false;
    protected $validationRules = [];
    protected $validationMessages = [];
    protected $skipValidation = false;
}