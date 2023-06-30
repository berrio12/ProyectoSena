<?php 
namespace App\Controllers;

use App\Models\CategoriasModel;
use App\Models\DetallePermisosModel;

class Categorias extends BaseController{
    protected $reglas, $categorias, $session, $detalle_permisos;
    public function __construct()
    {
        helper(['form']);
        $this->categorias = new CategoriasModel();
        $this->detalle_permisos = new DetallePermisosModel();
        $this->reglas = [
            'categoria' => [
                'rules' => 'required|is_unique[categorias.categoria,idcat,{id}]',
                'errors' => [
                    'required' => 'La {field} es requerido',
                    'is_unique' => 'La {field} debe ser único'

                ]
            ]
        ];
        $this->session = session();
        $perm = $this->detalle_permisos->verificarPermisos($this->session->id_usuario, "categorias");
        if (!$perm && $this->session->id_usuario != 1) {
            echo view('permisos');
            exit;
        }
    }
    public function index()
    {
        echo view("templates/header");
        echo view("categorias/index");
        echo view("templates/footer");
    }
    public function listar()
    {
        $data = $this->categorias->where('estado', 1)->findAll();
        for ($i = 0; $i < count($data); $i++) {
            if ($data[$i]['estado'] == 1) {
                $data[$i]['estado'] = '<span class="badge bg-success">Activo</span>';
                $data[$i]['acciones'] = '<div class"text-center">
                <a href="' . base_url("categorias/editar/" . $data[$i]['idcat']) . '" class="btn btn-dark"><i class="fas fa-edit"></i></a>
                <button class="btn btn-danger" onclick="btnEliminarCat(' . $data[$i]['idcat'] . ')"><i class="fas fa-trash-alt"></i></button>
                </div>';
            }
        }
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function registrar()
    {
        if ($this->request->getMethod() == 'post' && $this->validate($this->reglas)) {
            $categoria = $this->request->getPost('categoria');
            $data = $this->categorias->save([
                'categoria' => $categoria
            ]);
            return redirect()->to(base_url() . '/categorias')->with('message', 'Categoria registrado con exíto.');
        } else {
            $data['validation'] = $this->validator;
            echo view("templates/header");
            echo view("categorias/nuevo", $data);
            echo view("templates/footer");
        }
    }
    public function nuevo()
    {
        echo view("templates/header");
        echo view("categorias/nuevo");
        echo view("templates/footer");
    }
    public function editar($id)
    {
        $data['categoria'] = $this->categorias->where('idcat', $id)->first();
        echo view("templates/header");
        echo view("categorias/editar", $data);
        echo view("templates/footer");
    }
    public function actualizar()
    {
        if ($this->request->getMethod() == 'post' && $this->validate($this->reglas)) {
            $data = $this->categorias->update(
                $this->request->getPost('id'),
                [
                    'categoria' => $this->request->getPost('categoria')
                ]
            );
            return redirect()->to(base_url() . '/categorias')->with('message', 'Categoria modificado con exíto.');
        } else {
            $data['validation'] = $this->validator;
            $data['categoria'] = $this->categorias->where('idcat', $this->request->getPost('id'))->first();
            echo view("templates/header");
            echo view("categorias/editar", $data);
            echo view("templates/footer");
        }
    }
    public function eliminar($id)
    {
        $data = $this->categorias->update($id, ['estado' => 0]);
        if ($data) {
            $mensaje = array('icono' => 'success', "mensaje" => 'Categoria eliminado con éxito');
        } else {
            $mensaje = array('icono' => 'error', "mensaje" => 'Error al eliminar la categoria');
        }
        echo json_encode($mensaje, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function reciclaje()
    {
        echo view("templates/header");
        echo view("categorias/reciclaje");
        echo view("templates/footer");
    }
    public function vaciar()
    {
        $data = $this->categorias->where('estado', 0)->findAll();
        for ($i = 0; $i < count($data); $i++) {
            if ($data[$i]['estado'] == 0) {
                $data[$i]['estado'] = '<span class="badge bg-danger">Inactivo</span>';
                $data[$i]['acciones'] = '<div class"text-center">
                    <button class="btn btn-success" onclick="btnreingresar_cat(' . $data[$i]['idcat'] . ')"><i class="fas fa-reply"></i></button>
                    </div>';
            }
        }
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function restaurar($id)
    {
        $data = $this->categorias->update($id, ['estado' => 1]);
        if ($data) {
            $mensaje = array('icono' => 'success', "mensaje" => 'Categoria reingresado con éxito');
        } else {
            $mensaje = array('icono' => 'error', "mensaje" => 'Error al reingresar la categoria');
        }
        echo json_encode($mensaje, JSON_UNESCAPED_UNICODE);
        die();
    }
}