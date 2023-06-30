<?php

namespace App\Models;

use CodeIgniter\Model;

class DetallePermisosModel extends Model
{
    protected $table = 'detalle_permisos';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $useSoftUpdates = false;
    protected $useSoftCreates = false;
    protected $allowedFields = ['id_usuario', 'id_permiso'];
    protected $useTimestamps = false;
    protected $validationRules = [];
    protected $validationMessages = [];
    protected $skipValidation = false;
    public function verificarPermisos($id_user, $permiso)
    {
        $tiene = false;
        $this->select('*');
        $this->join('permisos', "detalle_permisos.id_permiso = permisos.id");
        $existe = $this->where(['id_usuario' => $id_user, 'permisos.nombre' => $permiso])->first();
        if ($existe != null || $existe != "") {
            $tiene = true;
        }
        return $tiene;
    }
}
