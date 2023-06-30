<?php

namespace App\Models;

use CodeIgniter\Model;

class DetalleComprasModel extends Model
{
    protected $table      = 'detalle_compra';
    protected $primaryKey = 'id_detalle';
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = ['id_producto', 'precio', 'cantidad', 'id_compra'];
    protected $useTimestamps = false;
    protected $validationRules = [];
    protected $validationMessages = [];
    protected $skipValidation = false;
}
