<?php

namespace App\Models;

use CodeIgniter\Model;

class TemporalVentaModel extends Model
{
    protected $table      = 'temp_ventas';
    protected $primaryKey = 'id_temp';
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = ['id_producto', 'id_usuario', 'precio', 'cantidad'];
    protected $useTimestamps = false;
    protected $validationRules = [];
    protected $validationMessages = [];
    protected $skipValidation = false;
}
