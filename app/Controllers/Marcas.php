<?php 
namespace App\Controllers;

use App\Models\DetallePermisosModel;
use App\Models\MarcasModel;
class Marcas extends BaseController{
    protected $reglas, $marcas, $session, $detalle_permisos;
    public function __construct()
    {
        helper(['form']);
        $this->marcas = new MarcasModel();
        $this->detalle_permisos = new DetallePermisosModel();
        $this->session = session();
        $perm = $this->detalle_permisos->verificarPermisos($this->session->id_usuario, "marcas");
        if (!$perm && $this->session->id_usuario != 1) {
            echo view('permisos');
            exit;
        }
        $this->reglas = [
            'marca' => [
                'rules' => 'required|is_unique[marcas.marca,idmarca,{id}]',
                'errors' => [
                    'required' => 'El campo {field} es requerido',
                    'is_unique' => 'El {field} debe ser único'

                ]
            ]
        ];
    }
    public function index()
    {
        echo view("templates/header");
        echo view("marcas/index");
        echo view("templates/footer");
    }
    public function listar()
    {
        $data = $this->marcas->where('estado', 1)->findAll();
        for ($i = 0; $i < count($data); $i++) {
            if ($data[$i]['estado'] == 1) {
                $data[$i]['estado'] = '<span class="badge bg-success">Activo</span>';
                $data[$i]['acciones'] = '<div class"text-center">
                <a href="' . base_url("marcas/editar/" . $data[$i]['idmarca']) . '" class="btn btn-dark"><i class="fas fa-edit"></i></a>
                <button class="btn btn-danger" onclick="btnEliminarMarca(' . $data[$i]['idmarca'] . ')"><i class="fas fa-trash-alt"></i></button>
                </div>';
            }
        }
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function registrar()
    {
        if ($this->request->getMethod() == 'post' && $this->validate($this->reglas)) {
            $marca = $this->request->getPost('marca');
            $data = $this->marcas->save([
                'marca' => $marca
            ]);
            return redirect()->to(base_url() . '/marcas')->with('message', 'Marca registrado con exíto.');
        } else {
            $data['validation'] = $this->validator;
            echo view("templates/header");
            echo view("marcas/nuevo", $data);
            echo view("templates/footer");
        }
    }
    public function nuevo()
    {
        echo view("templates/header");
        echo view("marcas/nuevo");
        echo view("templates/footer");
    }
    public function editar($id)
    {
        $data['marca'] = $this->marcas->where('idmarca', $id)->first();
        echo view("templates/header");
        echo view("marcas/editar", $data);
        echo view("templates/footer");
    }
    public function actualizar()
    {
        if ($this->request->getMethod() == 'post' && $this->validate($this->reglas)) {
            $data = $this->marcas->update(
                $this->request->getPost('id'),
                [
                    'marca' => $this->request->getPost('marca')
                ]
            );
            return redirect()->to(base_url() . '/marcas')->with('message', 'Marca modificado con exíto.');
        } else {
            $data['marca'] = $this->marcas->where('idmarca', $this->request->getPost('id'))->first();
            $data['validation'] = $this->validator;
            echo view("templates/header");
            echo view("marcas/editar", $data);
            echo view("templates/footer");
        }
    }
    public function eliminar($id)
    {
        $data = $this->marcas->update($id, ['estado' => 0]);
        if ($data) {
            $mensaje = array('icono' => 'success', "mensaje" => 'Marca eliminado con éxito');
        } else {
            $mensaje = array('icono' => 'error', "mensaje" => 'Error al eliminar la marca');
        }
        echo json_encode($mensaje, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function reciclaje()
    {
        echo view("templates/header");
        echo view("marcas/reciclaje");
        echo view("templates/footer");
    }
    public function vaciar()
    {
        $data = $this->marcas->where('estado', 0)->findAll();
        for ($i = 0; $i < count($data); $i++) {
            if ($data[$i]['estado'] == 0) {
                $data[$i]['estado'] = '<span class="badge bg-danger">Inactivo</span>';
                $data[$i]['acciones'] = '<div class"text-center">
                    <button class="btn btn-success" onclick="btnreingresar_marca(' . $data[$i]['idmarca'] . ')"><i class="fas fa-reply"></i></button>
                    </div>';
            }
        }
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function restaurar($id)
    {
        $data = $this->marcas->update($id, ['estado' => 1]);
        if ($data) {
            $mensaje = array('icono' => 'success', "mensaje" => 'Marca reingresado con éxito');
        } else {
            $mensaje = array('icono' => 'error', "mensaje" => 'Error al reingresar la marca');
        }
        echo json_encode($mensaje, JSON_UNESCAPED_UNICODE);
        die();
    }
}