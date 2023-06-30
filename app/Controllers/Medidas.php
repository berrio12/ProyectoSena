<?php 
namespace App\Controllers;

use App\Models\DetallePermisosModel;
use App\Models\MedidasModel;
class Medidas extends BaseController{
    protected $reglas, $medidas, $session, $detalle_permisos;
    public function __construct()
    {
        helper(['form']);
        $this->medidas = new MedidasModel();
        $this->detalle_permisos = new DetallePermisosModel();
        $this->session = session();
        $perm = $this->detalle_permisos->verificarPermisos($this->session->id_usuario, "medidas");
        if (!$perm && $this->session->id_usuario != 1) {
            echo view('permisos');
            exit;
        }
        $this->reglas = [
            'medida' => [
                'rules' => 'required|is_unique[medidas.medida,idmedida,{id}]',
                'errors' => [
                    'required' => 'El campo {field} es requerido',
                    'is_unique' => 'El {field} debe ser único'

                ]
            ],
            'nombre_corto' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'El campo {field} es requerido'

                ]
            ]
        ];
    }
    public function index()
    {
        echo view("templates/header");
        echo view("medidas/index");
        echo view("templates/footer");
    }
    public function listar()
    {
        $data = $this->medidas->where('estado', 1)->findAll();
        for ($i = 0; $i < count($data); $i++) {
            if ($data[$i]['estado'] == 1) {
                $data[$i]['estado'] = '<span class="badge bg-success">Activo</span>';
                $data[$i]['acciones'] = '<div class"text-center">
                <a href="' . base_url("medidas/editar/" . $data[$i]['idmedida']) . '" class="btn btn-dark"><i class="fas fa-edit"></i></a>
                <button class="btn btn-danger" onclick="btnEliminarMed(' . $data[$i]['idmedida'] . ')"><i class="fas fa-trash-alt"></i></button>
                </div>';
            }
        }
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function registrar()
    {
        if ($this->request->getMethod() == 'post' && $this->validate($this->reglas)) {
            $medida = $this->request->getPost('medida');
            $nombre_corto = $this->request->getPost('nombre_corto');
            $data = $this->medidas->save([
                'medida' => $medida,
                'nombre_corto' => $nombre_corto
            ]);
            return redirect()->to(base_url() . '/medidas')->with('message', 'Medida registrado con exíto.');
        } else {
            $data['validation'] = $this->validator;
            echo view("templates/header");
            echo view("medidas/nuevo", $data);
            echo view("templates/footer");
        }
    }
    public function nuevo()
    {
        echo view("templates/header");
        echo view("medidas/nuevo");
        echo view("templates/footer");
    }
    public function editar($id)
    {
        $data['medida'] = $this->medidas->where('idmedida', $id)->first();
        echo view("templates/header");
        echo view("medidas/editar", $data);
        echo view("templates/footer");
    }
    public function actualizar()
    {
        if ($this->request->getMethod() == 'post' && $this->validate($this->reglas)) {
            $data = $this->medidas->update(
                $this->request->getPost('id'),
                [
                    'medida' => $this->request->getPost('medida'),
                    'nombre_corto' => $this->request->getPost('nombre_corto')
                ]
            );
            return redirect()->to(base_url() . '/medidas')->with('message', 'Medida modificado con exíto.');
        } else {
            $data['validation'] = $this->validator;
            $data['medida'] = $this->medidas->where('idmedida', $this->request->getPost('id'))->first();
            echo view("templates/header");
            echo view("medidas/editar", $data);
            echo view("templates/footer");
        }
    }
    public function eliminar($id)
    {
        $data = $this->medidas->update($id, ['estado' => 0]);
        if ($data) {
            $mensaje = array('icono' => 'success', "mensaje" => 'Medida eliminado con éxito');
        } else {
            $mensaje = array('icono' => 'error', "mensaje" => 'Error al eliminar la medida');
        }
        echo json_encode($mensaje, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function reciclaje()
    {
        echo view("templates/header");
        echo view("medidas/reciclaje");
        echo view("templates/footer");
    }
    public function vaciar()
    {
        $data = $this->medidas->where('estado', 0)->findAll();
        for ($i = 0; $i < count($data); $i++) {
            if ($data[$i]['estado'] == 0) {
                $data[$i]['estado'] = '<span class="badge bg-danger">Inactivo</span>';
                $data[$i]['acciones'] = '<div class"text-center">
                    <button class="btn btn-success" onclick="btnreingresar_med(' . $data[$i]['idmedida'] . ')"><i class="fas fa-reply"></i></button>
                    </div>';
            }
        }
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function restaurar($id)
    {
        $data = $this->medidas->update($id, ['estado' => 1]);
        if ($data) {
            $mensaje = array('icono' => 'success', "mensaje" => 'Medida reingresado con éxito');
        } else {
            $mensaje = array('icono' => 'error', "mensaje" => 'Error al reingresar la medida');
        }
        echo json_encode($mensaje, JSON_UNESCAPED_UNICODE);
        die();
    }
}