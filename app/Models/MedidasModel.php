<?php 
namespace App\Models;

use CodeIgniter\Model;

class MedidasModel extends Model{
    protected $table      = 'medidas';
    protected $primaryKey = 'idmedida';
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = ['medida', 'nombre_corto', 'estado'];
    protected $useTimestamps = false;
    protected $validationRules = [];
    protected $validationMessages = [];
    protected $skipValidation = false;
}