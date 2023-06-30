<?php

namespace App\Models;

use CodeIgniter\Model;

class DetalleVentasModel extends Model
{
    protected $table      = 'detalle_venta';
    protected $primaryKey = 'id_detalle';
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = ['id_producto', 'precio', 'cantidad', 'id_venta'];
    protected $useTimestamps = false;
    protected $validationRules = [];
    protected $validationMessages = [];
    protected $skipValidation = false;
}
