<?php

namespace App\Controllers;

use App\Models\MarcasModel;
use App\Models\MedidasModel;
use App\Models\CategoriasModel;
use App\Models\DetallePermisosModel;
use App\Models\ProductosModel;

class Productos extends BaseController
{
    protected $reglas, $productos, $marcas, $medidas, $categorias, $session, $detalle_permisos;
    public function __construct() {
        $this->productos = new ProductosModel();
        $this->marcas = new MarcasModel();
        $this->medidas = new MedidasModel();
        $this->categorias = new CategoriasModel();
        $this->detalle_permisos = new DetallePermisosModel();
        $this->session = session();
        helper(['form']);
        $perm = $this->detalle_permisos->verificarPermisos($this->session->id_usuario, "productos");
        if (!$perm && $this->session->id_usuario != 1) {
            echo view('permisos');
            exit;
        }
        $this->reglas = [
            'codigo' => [
                'rules' => 'required|is_unique[productos.codigo,id,{id}]',
                'errors' => [
                    'required' => 'El {field} es requerido',
                    'is_unique' => 'El {field} debe ser único'
                ]
            ],
            'descripcion' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'La {field} es requerido'
                ]
            ],
            'precio_compra' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'El {field} es requerido'
                ]
            ],
            'precio_venta' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'El {field} es requerido'
                ]
            ],
            'stock_minimo' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'El {field} es requerido'
                ]
            ],
            'marca' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'La {field} es requerido'
                ]
            ],
            'medida' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'La {field} es requerido'
                ]
            ],
            'categoria' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'La {field} es requerido'
                ]
            ]
            
        ];
        
    }
    public function index()
    {
        echo view("templates/header");
        echo view("productos/index");
        echo view("templates/footer");
    }
    public function listar()
    {
        $this->productos->select('*');
        $this->productos->join('marcas', 'productos.id_marca = marcas.idmarca');
        $this->productos->join('medidas', 'productos.id_medida = medidas.idmedida');
        $this->productos->join('categorias', 'productos.id_categoria = categorias.idcat');
        $data = $this->productos->where('productos.estado', 1)->findAll();
        for ($i = 0; $i < count($data); $i++) {
            $data[$i]['imagen'] = '<img class="img-thumbnail" src="'. base_url('img/productos/'.$data[$i]['imagen']).'" width="60">'; 
            if ($data[$i]['estado'] == 1) {
                $data[$i]['estado'] = '<span class="badge bg-success">Activo</span>';
                $data[$i]['acciones'] = '<div class"d-flex">
                    <a href="' . base_url("productos/editar/" . $data[$i]['id']) . '" class="btn btn-outline-info"><i class="fas fa-edit"></i></a>
                    <button class="btn btn-outline-danger" onclick="btnEliminarPro(' . $data[$i]['id'] . ')"><i class="fas fa-trash-alt"></i></button>
                    </div>';
            } 
        }
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function registrar()
    {
        if ($this->request->getMethod() == 'post' && $this->validate($this->reglas)) {
            $imagen = $this->request->getFile('imagen');
            if (!empty($imagen->getName())) {
                $img = 'pro_' . date("YmdHis") . '.jpg';
            }else{
                $img = 'default.jpg';
            }
            $data = $this->productos->save([
                'codigo' => $this->request->getPost('codigo'),
                'descripcion' => $this->request->getPost('descripcion'),
                'precio_compra' => $this->request->getPost('precio_compra'),
                'precio_venta' => $this->request->getPost('precio_venta'),
                'stock_minimo' => $this->request->getPost('stock_minimo'),
                'id_marca' => $this->request->getPost('marca'),
                'id_medida' => $this->request->getPost('medida'),
                'id_categoria' => $this->request->getPost('categoria'),
                'imagen' => $img
            ]);
            if (!empty($imagen->getName())) {
                $ruta_img = './img/productos/';
                $imagen->move($ruta_img, $img);
            }
            return redirect()->to(base_url() . '/productos')->with('message', 'Producto registrado con exíto.');
        } else {
            $data['marcas'] = $this->marcas->where('estado', 1)->findAll();
            $data['medidas'] = $this->medidas->where('estado', 1)->findAll();
            $data['categorias'] = $this->categorias->where('estado', 1)->findAll();
            $data['validation'] = $this->validator;
            echo view("templates/header");
            echo view("productos/nuevo", $data);
            echo view("templates/footer");
        }
    }
    public function nuevo()
    {
        $data['marcas'] = $this->marcas->where('estado', 1)->findAll();
        $data['medidas'] = $this->medidas->where('estado', 1)->findAll();
        $data['categorias'] = $this->categorias->where('estado', 1)->findAll();
        echo view("templates/header");
        echo view("productos/nuevo", $data);
        echo view("templates/footer");
    }
    public function editar($id)
    {
        $data['marcas'] = $this->marcas->where('estado', 1)->findAll();
        $data['medidas'] = $this->medidas->where('estado', 1)->findAll();
        $data['categorias'] = $this->categorias->where('estado', 1)->findAll();
        $data['producto'] = $this->productos->where('id', $id)->first();
        echo view("templates/header");
        echo view("productos/editar", $data);
        echo view("templates/footer");
    }
    public function actualizar()
    {
        if ($this->request->getMethod() == 'post' && $this->validate($this->reglas)) {
            $imagen = $this->request->getFile('imagen');
            if (!empty($imagen->getName())) {
                $img = 'pro_' . date("YmdHis") . '.jpg';
            } else {
                $img = $_POST['foto_actual'];
            }
            $imgDelete = $this->productos->where('id', $this->request->getPost('id'))->first();
            if ($imgDelete['imagen'] != 'default.jpg') {
                if (file_exists("./img/productos/" . $imgDelete['imagen'])) {
                    unlink("./img/productos/" . $imgDelete['imagen']);
                }
            }
            $data = $this->productos->update(
                $this->request->getPost('id'),
                [
                    'codigo' => $this->request->getPost('codigo'),
                    'descripcion' => $this->request->getPost('descripcion'),
                    'precio_compra' => $this->request->getPost('precio_compra'),
                    'precio_venta' => $this->request->getPost('precio_venta'),
                    'stock_minimo' => $this->request->getPost('stock_minimo'),
                    'id_marca' => $this->request->getPost('marca'),
                    'id_medida' => $this->request->getPost('medida'),
                    'id_categoria' => $this->request->getPost('categoria'),
                    'imagen' => $img
                ]
            );
            if (!empty($imagen->getName())) {
                $ruta_img = './img/productos/';
                if (!file_exists($ruta_img)) {
                    dir($ruta_img);
                }
                $imagen->move($ruta_img, $img);
            }
            return redirect()->to(base_url() . '/productos')->with('message', 'Producto modificado con exíto.');
        } else {
            $data['marcas'] = $this->marcas->where('estado', 1)->findAll();
            $data['medidas'] = $this->medidas->where('estado', 1)->findAll();
            $data['categorias'] = $this->categorias->where('estado', 1)->findAll();
            $data['producto'] = $this->productos->where('id', $this->request->getPost('id'))->first();
            $data['validation'] = $this->validator;
            echo view("templates/header");
            echo view("productos/editar", $data);
            echo view("templates/footer");
        }
    }
    public function eliminar($id)
    {
        $data = $this->productos->update($id, ['estado' => 0]);
        if ($data) {
            $mensaje = array('icono' => 'success', "mensaje" => 'Producto eliminado con éxito');
        } else {
            $mensaje = array('icono' => 'error', "mensaje" => 'Error al eliminar el producto');
        }
        echo json_encode($mensaje, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function reciclaje()
    {
        echo view("templates/header");
        echo view("productos/reciclaje");
        echo view("templates/footer");
    }
    public function vaciar()
    {
        $this->productos->select('*');
        $this->productos->join('marcas', 'productos.id_marca = marcas.idmarca');
        $this->productos->join('medidas', 'productos.id_medida = medidas.idmedida');
        $this->productos->join('categorias', 'productos.id_categoria = categorias.idcat');
        $data = $this->productos->where('productos.estado', 0)->findAll();
        for ($i = 0; $i < count($data); $i++) {
            $data[$i]['imagen'] = '<img class="img-thumbnail" src="' . base_url('img/productos/'. $data[$i]['imagen']).'" width="100">';
                $data[$i]['estado'] = '<span class="badge bg-danger">Inactivo</span>';
                $data[$i]['acciones'] = '<div class"d-flex text-center">
                    <button class="btn btn-success" onclick="ingresar_pro(' . $data[$i]['id'] . ')"><i class="fas fa-reply"></i></button>
                    </div>';
        }
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function restaurar($id)
    {
        $data = $this->productos->update($id, ['estado' => 1]);
        if ($data) {
            $mensaje = array('icono' => 'success', "mensaje" => 'Producto reingresado con éxito');
        } else {
            $mensaje = array('icono' => 'error', "mensaje" => 'Error al reingresar el producto');
        }
        echo json_encode($mensaje, JSON_UNESCAPED_UNICODE);
        die();
    }
}
