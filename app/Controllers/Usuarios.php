<?php

namespace App\Controllers;

use App\Models\CajasModel;
use App\Models\DetallePermisosModel;
use App\Models\PermisosModel;
use App\Models\UsuariosModel;

class Usuarios extends BaseController
{
    protected $reglas, $usuarios, $cajas, $session, $detalle_permisos, $permisos;
    public function __construct() {
        helper(['form']);
        $this->usuarios = new UsuariosModel();
        $this->cajas = new CajasModel();
        $this->permisos = new PermisosModel();
        $this->detalle_permisos = new DetallePermisosModel();
        $this->session = session();
        $this->reglas = [
            'usuario' => [
                'rules' => 'required|is_unique[usuarios.usuario,id,{id}]',
                'errors' => [
                    'required' => 'El campo {field} es requerido',
                    'is_unique' => 'El {field} debe ser único'

                ]
            ],
            'nombre' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'El campo {field} es requerido'
                ]
            ],
            'correo' => [
                'rules' => 'required|valid_email|is_unique[usuarios.correo,id,{id}]',
                'errors' => [
                    'required' => 'El campo {field} es requerido',
                    'valid_email' => 'Ingresa un correo valido',
                    'is_unique' => 'El {field} debe ser único'
                ]
            ],
            'clave' => [
                'rules' => 'required|min_length[6]',
                'errors' => [
                    'required' => 'El campo {field} es requerido',
                    'min_length' => 'La {field} debe contener mínimo 6 caracter'
                ]
            ],
            'confirmar' => [
                'rules' => 'required|min_length[6]|matches[clave]',
                'errors' => [
                    'required' => 'El campo {field} es requerido',
                    'min_length' => 'La {field} debe contener mínimo 6 caracter',
                    'matches' => 'Las contraseñas no coinciden'
                ]
            ],
            'caja' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'El campo {field} es requerido'
                ]
            ],
        ]; 
        //'email' => 'permit_empty|valid_email|is_unique[contacts.email,id,{users.id}]' 
    }
    public function index()
    {
        $perm = $this->detalle_permisos->verificarPermisos($this->session->id_usuario, "usuarios");
        if (!$perm && $this->session->id_usuario != 1) {
            echo view('permisos');
            exit;
        }
        echo view("templates/header");
        echo view("usuarios/index");
        echo view("templates/footer");
    }
    public function listar()
    {
        $data = $this->usuarios->where('estado', 1)->findAll();
        for ($i = 0; $i < count($data); $i++) {
            if ($data[$i]['estado'] == 1) {
                if ($data[$i]['id'] != 1) {
                    $data[$i]['estado'] = '<span class="badge bg-success px-1">Activo</span>';
                    $data[$i]['acciones'] = '<div class"text-center">
                    <a href="'.base_url("usuarios/rol/".$data[$i]['id']) .'" class="btn btn-outline-dark"><i class="fas fa-key"></i></a>
                    <a href="'.base_url("usuarios/editar/".$data[$i]['id']). '" class="btn btn-outline-info"><i class="fas fa-edit"></i></a>
                    <button class="btn btn-outline-danger" onclick="btnEliminarUser(' . $data[$i]['id'] . ')"><i class="fas fa-trash"></i></button>
                    </div>';
                } else {
                    $data[$i]['estado'] = '<span class="badge bg-success px-1">Activo</span>';
                    $data[$i]['acciones'] = '<div class"text-center">
                    <span class="badge bg-info px-1">Administrador</span>
                    </div>';
                }
            } 
        }
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function registrar()
    {
        $perm = $this->detalle_permisos->verificarPermisos($this->session->id_usuario, "usuarios");
        if (!$perm && $this->session->id_usuario != 1) {
            echo view('permisos');
            exit;
        }
          
        if ($this->request->getMethod() == 'post' && $this->validate($this->reglas)) {
            $usuario = $this->request->getPost('usuario');
            $nombre = $this->request->getPost('nombre');
            $correo = $this->request->getPost('correo');
            $clave = password_hash($this->request->getPost('clave'), PASSWORD_DEFAULT);
            $caja = $this->request->getPost('caja');
            $data = $this->usuarios->save([
                'usuario' => $usuario,
                'nombre' => $nombre,
                'correo' => $correo,
                'clave' => $clave,
                'id_caja' => $caja
            ]);
            return redirect()->to(base_url() . '/usuarios')->with('message', 'Usuario registrado con exíto.');
        } else {
            $data['validation'] = $this->validator;
            $data['cajas'] = $this->cajas->where('estado', 1)->findAll();
            echo view("templates/header");
            echo view("usuarios/nuevo", $data);
            echo view("templates/footer");
        }
    }
    public function nuevo()
    {
        $perm = $this->detalle_permisos->verificarPermisos($this->session->id_usuario, "usuarios");
        if (!$perm && $this->session->id_usuario != 1) {
            echo view('permisos');
            exit;
        }
        $data['cajas'] = $this->cajas->where('estado', 1)->findAll();
        echo view("templates/header");
        echo view("usuarios/nuevo", $data);
        echo view("templates/footer");
    }
    public function editar($id)
    {
        $perm = $this->detalle_permisos->verificarPermisos($this->session->id_usuario, "usuarios");
        if (!$perm && $this->session->id_usuario != 1) {
            echo view('permisos');
            exit;
        }
        $data['usuario'] = $this->usuarios->where('id', $id)->first();
        $data['cajas'] = $this->cajas->where('estado', 1)->findAll();
        echo view("templates/header");
        echo view("usuarios/editar", $data);
        echo view("templates/footer");
    }
    public function rol($id)
    {
        $perm = $this->detalle_permisos->verificarPermisos($this->session->id_usuario, "usuarios");
        if (!$perm && $this->session->id_usuario != 1) {
            echo view('permisos');
            exit;
        }
        $data['usuario'] = $this->usuarios->where('id', $id)->first();
        $data['permisos'] = $this->permisos->findAll();
        $data['asignados'] = $this->detalle_permisos->where('id_usuario', $id)->findAll();
        echo view("templates/header");
        echo view("usuarios/rol", $data);
        echo view("templates/footer");
    }
    public function actualizar()
    {
        $perm = $this->detalle_permisos->verificarPermisos($this->session->id_usuario, "usuarios");
        if (!$perm && $this->session->id_usuario != 1) {
            echo view('permisos');
            exit;
        }
        if ($this->request->getMethod() == 'post' && $this->validate($this->reglas)) {
            $data = $this->usuarios->update(
                $this->request->getPost('id'),
                [
                    'usuario' => $this->request->getPost('usuario'),
                    'nombre' => $this->request->getPost('nombre'),
                    'correo' => $this->request->getPost('correo'),
                    'id_caja' => $this->request->getPost('caja')
                ]
            );
            return redirect()->to(base_url() . '/usuarios')->with('message', 'Usuario modificado con exíto.');
        } else {
            //$data['validation'] = $this->validator;
            $data['usuario'] = $this->usuarios->where('id', $this->request->getPost('id'))->first();
            $data['cajas'] = $this->cajas->where('estado', 1)->findAll();
            echo view("templates/header");
            echo view("usuarios/editar", $data);
            echo view("templates/footer");
        }
    }
    public function eliminar($id)
    {
        $perm = $this->detalle_permisos->verificarPermisos($this->session->id_usuario, "usuarios");
        if (!$perm && $this->session->id_usuario != 1) {
            echo view('permisos');
            exit;
        }
        $data = $this->usuarios->update($id, ['estado' => 0]);
        if ($data) {
            $mensaje = array('icono' => 'success', "mensaje" => 'Usuario eliminado con éxito');
        } else {
            $mensaje = array('icono' => 'error', "mensaje" => 'Error al eliminar el usuario');
        }
        echo json_encode($mensaje, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function reciclaje()
    {
        $perm = $this->detalle_permisos->verificarPermisos($this->session->id_usuario, "usuarios");
        if (!$perm && $this->session->id_usuario != 1) {
            echo view('permisos');
            exit;
        }
        echo view("templates/header");
        echo view("usuarios/reciclaje");
        echo view("templates/footer");
    }
    public function vaciar()
    {
        $perm = $this->detalle_permisos->verificarPermisos($this->session->id_usuario, "usuarios");
        if (!$perm && $this->session->id_usuario != 1) {
            echo view('permisos');
            exit;
        }
        $data = $this->usuarios->where('estado', 0)->findAll();
        for ($i = 0; $i < count($data); $i++) {
            if ($data[$i]['estado'] == 0) {
                $data[$i]['estado'] = '<span class="badge bg-danger">Inactivo</span>';
                $data[$i]['acciones'] = '<div class"text-center">
                    <button class="btn btn-outline-success" onclick="btnreingresar_user(' . $data[$i]['id'] . ')"><i class="fas fa-reply"></i></button>
                    </div>';
            }
        }
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function restaurar($id)
    {
        $perm = $this->detalle_permisos->verificarPermisos($this->session->id_usuario, "usuarios");
        if (!$perm && $this->session->id_usuario != 1) {
            echo view('permisos');
            exit;
        }
        $data = $this->usuarios->update($id, ['estado' => 1]);
        if ($data) {
            $mensaje = array('icono' => 'success', "mensaje" => 'Usuario reingresado con éxito');
        } else {
            $mensaje = array('icono' => 'error', "mensaje" => 'Error al reingresar el usuario');
        }
        echo json_encode($mensaje, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function verificar()
    {
        $this->reglas = [
            'usuario' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'El campo {field} es requerido'

                ]
            ],
            'clave' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'El campo {field} es requerido'
                ]
            ]
        ];
        if ($this->request->getMethod() == 'post' && $this->validate($this->reglas)) {
            $usuario = $this->request->getPost('usuario');
            $clave = $this->request->getPost('clave');
            $datosUser = $this->usuarios->where(['usuario' => $usuario, 'estado' => 1])->first();
            if ($datosUser != null) {
                if (password_verify($clave, $datosUser['clave'])) {
                    $datosSesion = [
                        'id_usuario' => $datosUser['id'],
                        'usuario' => $datosUser['usuario'],
                        'nombre' => $datosUser['nombre'],
                        'id_caja' => $datosUser['id_caja']
                    ];
                    $session = session();
                    $session->set($datosSesion);
                    return redirect()->to(base_url() . '/admin/dashboard')->with('success', 'Has iniciado sesion correctamente.');
                } else {
                    return redirect()->to(base_url())->with('fail', 'Contraseña incorrecta.');
                }
            } else {
                return redirect()->to(base_url())->with('fail', 'El usuario no existe');
            }
        }else{
            $data['validation'] = $this->validator;
            echo view("login", $data);
        }
    }
    public function salir()
    {
        $this->session->destroy();
        return redirect()->to(base_url());
    }
    public function permisos()
    {
        $perm = $this->detalle_permisos->verificarPermisos($this->session->id_usuario, "usuarios");
        if (!$perm && $this->session->id_usuario != 1) {
            echo view('permisos');
            exit;
        }
        if ($this->request->getMethod() == "post") {
            $id_user = $this->request->getPost('id_usuario');
            $permisos = $this->request->getPost('permisos');
            $this->detalle_permisos->where('id_usuario', $id_user)->delete();
            if ($permisos != "") {
                foreach ($permisos as $permiso) {
                    $this->detalle_permisos->save(['id_usuario' => $id_user, 'id_permiso' => $permiso]);
                }
            }
            return redirect()->to(base_url() . '/usuarios/rol/'. $id_user)->with('rol', 'Permisos modificado con exíto.');
        }
    }
    public function perfil()
    {
        echo view("templates/header");
        echo view("usuarios/perfil");
        echo view("templates/footer");
    }
    public function cambiar()
    {
        $this->reglas = [
            'clave_actual' => [
                'rules' => 'required|min_length[6]',
                'errors' => [
                    'required' => 'La clave actual es requerido',
                    'min_length' => 'La clave debe contener mínimo 6 caracter'
                ]
            ],
            'clave_nueva' => [
                'rules' => 'required|min_length[6]',
                'errors' => [
                    'required' => 'La clave nueva es requerido',
                    'min_length' => 'La clave nueva debe contener mínimo 6 caracter'
                ]
            ],
            'confirmar' => [
                'rules' => 'required|min_length[6]|matches[clave_nueva]',
                'errors' => [
                    'required' => 'El campo {field} es requerido',
                    'min_length' => 'El {field} debe contener mínimo 6 caracter',
                    'matches' => 'Las contraseñas no coinciden'
                ]
            ]
        ]; 
        if ($this->request->getMethod() == "post" && $this->validate($this->reglas)) {
            $session = session();
            $id = $session->id_usuario;
            $clave = $this->request->getPost('clave_actual');
            $user = $this->usuarios->where('id', $id)->first();
            if (password_verify($clave, $user['clave'])) {
                $hash = password_hash($this->request->getPost('clave_nueva'), PASSWORD_DEFAULT);
                $data = $this->usuarios->update($id, ['clave' => $hash]);
                if ($data > 0) {
                    $mensaje = 'ok';
                } else {
                    $mensaje = 'error';
                }
            } else {
                $mensaje = 'incorrecta';
            }
            return redirect()->to(base_url() . '/usuarios/perfil')->with('perfil', $mensaje);
        } else {
            $data['validation'] = $this->validator;
            echo view("templates/header");
            echo view("usuarios/perfil", $data);
            echo view("templates/footer");
        }
    }
}
