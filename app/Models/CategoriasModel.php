<?php 
namespace App\Models;

use CodeIgniter\Model;

class CategoriasModel extends Model{
    protected $table      = 'categorias';
    protected $primaryKey = 'idcat';
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = ['categoria', 'estado'];
    protected $useTimestamps = false;
    protected $validationRules = [];
    protected $validationMessages = [];
    protected $skipValidation = false;
}