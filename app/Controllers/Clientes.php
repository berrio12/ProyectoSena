<?php 
namespace App\Controllers;

use App\Models\ClientesModel;
use App\Models\DetallePermisosModel;
class Clientes extends BaseController{
    protected $reglas, $clientes, $session, $detalle_permisos;
    public function __construct()
    {
        helper(['form']);
        $this->clientes = new ClientesModel();
        $this->detalle_permisos = new DetallePermisosModel();
        $this->session = session();
        $perm = $this->detalle_permisos->verificarPermisos($this->session->id_usuario, "clientes");
        if (!$perm && $this->session->id_usuario != 1) {
            echo view('permisos');
            exit;
        }
        $this->reglas = [
            'nombre' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'El campo {field} es requerido'
                ]
            ],
            'telefono' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'El campo {field} es requerido'
                ]
            ],
            'direccion' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'El campo {field} es requerido'
                ]
            ],
            'correo' => [
                'rules' => 'required|valid_email|is_unique[clientes.correo,id,{id}]',
                'errors' => [
                    'required' => 'El campo {field} es requerido',
                    'valid_email' => 'Ingresa un correo valido',
                    'is_unique' => 'El {field} debe ser único'
                ]
            ]
        ];
    }
    public function index()
    {
        echo view("templates/header");
        echo view("clientes/index");
        echo view("templates/footer");
    }
    public function nuevo()
    {
        echo view("templates/header");
        echo view("clientes/nuevo");
        echo view("templates/footer");
    }
    public function registrar()
    {
        if ($this->request->getMethod() == 'post' && $this->validate($this->reglas)) {
            $nombre = $this->request->getPost('nombre');
            $telefono = $this->request->getPost('telefono');
            $correo = $this->request->getPost('correo');
            $direccion = $this->request->getPost('direccion');
            $data = $this->clientes->save([
                'nombre' => $nombre,
                'telefono' => $telefono,
                'direccion' => $direccion,
                'correo' => $correo
            ]);
            return redirect()->to(base_url() . '/clientes')->with('message', 'Cliente registrado con exíto.');
        } else {
            $data['validation'] = $this->validator;
            echo view("templates/header");
            echo view("clientes/nuevo", $data);
            echo view("templates/footer");
        }
    }
    public function listar()
    {
        $data = $this->clientes->where('estado', 1)->findAll();
        for ($i = 0; $i < count($data); $i++) {
            if ($data[$i]['estado'] == 1) {
                $data[$i]['estado'] = '<span class="badge bg-success">Activo</span>';
                $data[$i]['acciones'] = '<div class"text-center">
                    <a href="' . base_url("clientes/editar/" . $data[$i]['id']) . '" class="btn btn-info"><i class="fas fa-edit"></i></a>
                    <button class="btn btn-danger" onclick="btnEliminarCli(' . $data[$i]['id'] . ')"><i class="fas fa-trash-alt"></i></button>
                    </div>';
            }
        }
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function editar($id)
    {
        $data['cliente'] = $this->clientes->where('id', $id)->first();
        echo view("templates/header");
        echo view("clientes/editar", $data);
        echo view("templates/footer");
    }
    public function actualizar()
    {
        if ($this->request->getMethod() == 'post' && $this->validate($this->reglas)) {
            $data = $this->clientes->update(
                $this->request->getPost('id'),
                [
                    'nombre' => $this->request->getPost('nombre'),
                    'telefono' => $this->request->getPost('telefono'),
                    'direccion' => $this->request->getPost('direccion'),
                    'correo' => $this->request->getPost('correo')
                ]
            );
            return redirect()->to(base_url() . '/clientes')->with('message', 'Cliente modificado con exíto.');
        } else {
            $data['validation'] = $this->validator;
            $data['cliente'] = $this->clientes->where('id', $this->request->getPost('id'))->first();
            echo view("templates/header");
            echo view("clientes/editar", $data);
            echo view("templates/footer");
        }
    }
    public function eliminar($id)
    {
        $data = $this->clientes->update($id, ['estado' => 0]);
        if ($data) {
            $mensaje = array('icono' => 'success', "mensaje" => 'Cliente eliminado con éxito');
        } else {
            $mensaje = array('icono' => 'error', "mensaje" => 'Error al eliminar el cliente');
        }
        echo json_encode($mensaje, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function reciclaje()
    {
        echo view("templates/header");
        echo view("clientes/reciclaje");
        echo view("templates/footer");
    }
    public function vaciar()
    {
        $data = $this->clientes->where('estado', 0)->findAll();
        for ($i = 0; $i < count($data); $i++) {
            if ($data[$i]['estado'] == 0) {
                $data[$i]['estado'] = '<span class="badge bg-danger">Inactivo</span>';
                $data[$i]['acciones'] = '<div class"text-center">
                    <button class="btn btn-success" onclick="btnreingresar_cli(' . $data[$i]['id'] . ')"><i class="fas fa-reply"></i></button>
                    </div>';
            }
        }
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function restaurar($id)
    {
        $data = $this->clientes->update($id, ['estado' => 1]);
        if ($data) {
            $mensaje = array('icono' => 'success', "mensaje" => 'Cliente reingresado con éxito');
        } else {
            $mensaje = array('icono' => 'error', "mensaje" => 'Error al reingresar el cliente');
        }
        echo json_encode($mensaje, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function buscar()
    {
        $valor = $this->request->getGet('cli');
        $data = $this->clientes->like('nombre', $valor)->orLike('telefono', $valor)->findAll();
        $datos = array();
        foreach ($data as $row) {
            $data['id'] = $row['id'];
            $data['label'] = $row['nombre'] . ' - '. $row['telefono'] . ' - ' . $row['direccion'];
            $data['value'] = $row['nombre'];
            $data['direccion'] = $row['direccion'];
            array_push($datos, $data);
        }
        echo json_encode($datos, JSON_UNESCAPED_UNICODE);
        die();
    }
}