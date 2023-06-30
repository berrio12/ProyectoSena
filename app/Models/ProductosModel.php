<?php 
namespace App\Models;

use CodeIgniter\Model;

class ProductosModel extends Model{
    protected $table      = 'productos';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = ['codigo', 'descripcion', 'precio_compra', 'precio_venta', 'stock_minimo', 'stock', 'id_marca', 'id_medida', 'id_categoria','imagen', 'estado'];
    protected $useTimestamps = false;
    protected $validationRules = [];
    protected $validationMessages = [];
    protected $skipValidation = false;
}