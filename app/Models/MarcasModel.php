<?php 
namespace App\Models;

use CodeIgniter\Model;

class MarcasModel extends Model{
    protected $table      = 'marcas';
    protected $primaryKey = 'idmarca';
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = ['marca', 'estado'];
    protected $useTimestamps = false;
    protected $validationRules = [];
    protected $validationMessages = [];
    protected $skipValidation = false;
}