<?php

namespace App\Models;
use CodeIgniter\Model;

class CajasCierreModel extends Model{
    protected $table = 'caja_cierre';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $useSoftUpdates = false;
    protected $useSoftCreates = false;
    protected $allowedFields = ['id_caja', 'id_usuario', 'fecha_inicio', 'fecha_fin', 'monto_inicial', 'monto_fin', 'total_ventas' ,'status'];
    protected $useTimestamps = false;
    protected $validationRules = [];
    protected $validationMessages = [];
    protected $skipValidation = false;
}
