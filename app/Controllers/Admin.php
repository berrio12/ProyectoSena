<?php

namespace App\Controllers;

use App\Models\AdminModel;
use App\Models\CategoriasModel;
use App\Models\ClientesModel;
use App\Models\ComprasModel;
use App\Models\DetallePermisosModel;
use App\Models\MarcasModel;
use App\Models\MedidasModel;
use App\Models\ProductosModel;
use App\Models\UsuariosModel;
use App\Models\VentasModel;

class Admin extends BaseController
{
    protected $reglas, $admin, $productos, $clientes, $usuarios,
        $marcas, $medidas, $categorias, $ventas, $compras, $session, $detalle_permisos;
    public function __construct()
    {
        helper(['form']);
        $this->admin = new AdminModel();
        $this->productos = new ProductosModel();
        $this->medidas = new MedidasModel();
        $this->categorias = new CategoriasModel();
        $this->marcas = new MarcasModel();
        $this->usuarios = new UsuariosModel();
        $this->clientes = new ClientesModel();
        $this->ventas = new VentasModel();
        $this->compras = new ComprasModel();
        $this->detalle_permisos = new DetallePermisosModel();
        $this->session = session();
    }
    public function index()
    {
        $perm = $this->detalle_permisos->verificarPermisos($this->session->id_usuario, "configuracion");
        if (!$perm && $this->session->id_usuario != 1) {
            echo view('permisos');
            exit;
        }
        $datos['data'] = $this->admin->first();
        echo view("templates/header");
        echo view("admin/index", $datos);
        echo view("templates/footer");
    }
    public function modificar()
    {
        $perm = $this->detalle_permisos->verificarPermisos($this->session->id_usuario, "configuracion");
        if (!$perm && $this->session->id_usuario != 1) {
            echo view('permisos');
            exit;
        }
        $this->reglas = [
            'ruc' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'El {field} es requerido'
                ]
            ],
            'nombre' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'El {field} es requerido'
                ]
            ],
            'telefono' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'El {field} es requerido'

                ]
            ],
            'direccion' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'El {field} es requerido'

                ]
            ],
        ];
        if ($this->request->getMethod() == 'post' && $this->validate($this->reglas)) {
            $data = $this->admin->update(
                $this->request->getPost('id'),
                [
                    'ruc' => $this->request->getPost('ruc'),
                    'nombre' => $this->request->getPost('nombre'),
                    'telefono' => $this->request->getPost('telefono'),
                    'direccion' => $this->request->getPost('direccion'),
                    'correo' => $this->request->getPost('correo'),
                    'mensaje' => $this->request->getPost('mensaje')
                ]
            );
            return redirect()->to(base_url() . '/admin')->with('modificado', 'Datos modificado con exíto.');
        } else {
            $data['validation'] = $this->validator;
            $data['data'] = $this->admin->first();
            echo view("templates/header");
            echo view("admin/index", $data);
            echo view("templates/footer");
        }
    }
    public function dashboard()
    {
        $fecha = date('Y-m-d');
        $data['productos'] = $this->productos->where('estado', 1)->countAllResults();
        $data['usuarios'] = $this->usuarios->where('estado', 1)->countAllResults();
        $data['clientes'] = $this->clientes->where('estado', 1)->countAllResults();
        $data['marcas'] = $this->marcas->where('estado', 1)->countAllResults();
        $data['medidas'] = $this->medidas->where('estado', 1)->countAllResults();
        $data['categorias'] = $this->categorias->where('estado', 1)->countAllResults();
        $where = "estado = 1 AND DATE(fecha) = '$fecha'";
        $data['ventas'] = $this->ventas->where($where)->countAllResults();
        $data['compras'] = $this->compras->where($where)->countAllResults();
        echo view("templates/header");
        echo view("admin/home", $data);
        echo view("templates/footer");
    }

    //reporte graficos
    public function comparacion($anio)
    {
        $desde = $anio . '-01-01';
        $hasta = $anio . '-12-31';
        $id_usuario = $this->session->id_usuario;
        $where = "fecha BETWEEN '$desde' AND '$hasta' AND estado = 1 AND id_usuario = $id_usuario";
        $this->ventas->select("SUM(IF(MONTH(fecha) = 1, total, 0)) AS ene,
        SUM(IF(MONTH(fecha) = 2, total, 0)) AS feb,
        SUM(IF(MONTH(fecha) = 3, total, 0)) AS mar,
        SUM(IF(MONTH(fecha) = 4, total, 0)) AS abr,
        SUM(IF(MONTH(fecha) = 5, total, 0)) AS may,
        SUM(IF(MONTH(fecha) = 6, total, 0)) AS jun,
        SUM(IF(MONTH(fecha) = 7, total, 0)) AS jul,
        SUM(IF(MONTH(fecha) = 8, total, 0)) AS ago,
        SUM(IF(MONTH(fecha) = 9, total, 0)) AS sep,
        SUM(IF(MONTH(fecha) = 10, total, 0)) AS oct,
        SUM(IF(MONTH(fecha) = 11, total, 0)) AS nov,
        SUM(IF(MONTH(fecha) = 12, total, 0)) AS dic");
        $data['venta'] = $this->ventas->where($where)->first();

        $this->compras->select("SUM(IF(MONTH(fecha) = 1, total, 0)) AS ene,
        SUM(IF(MONTH(fecha) = 2, total, 0)) AS feb,
        SUM(IF(MONTH(fecha) = 3, total, 0)) AS mar,
        SUM(IF(MONTH(fecha) = 4, total, 0)) AS abr,
        SUM(IF(MONTH(fecha) = 5, total, 0)) AS may,
        SUM(IF(MONTH(fecha) = 6, total, 0)) AS jun,
        SUM(IF(MONTH(fecha) = 7, total, 0)) AS jul,
        SUM(IF(MONTH(fecha) = 8, total, 0)) AS ago,
        SUM(IF(MONTH(fecha) = 9, total, 0)) AS sep,
        SUM(IF(MONTH(fecha) = 10, total, 0)) AS oct,
        SUM(IF(MONTH(fecha) = 11, total, 0)) AS nov,
        SUM(IF(MONTH(fecha) = 12, total, 0)) AS dic");
        $data['compra'] = $this->compras->where($where)->first();

        echo json_encode($data);
        die();
    }

    public function stockMinimo()
    {
        $where = "stock_minimo >= stock AND estado = 1";
        $data = $this->productos->where($where)->findAll();
        echo json_encode($data);
        die();
    }

    public function minimo()
    {
        $where = "stock_minimo >= stock AND estado = 1";
        $datos = $this->productos->where($where)->findAll();
        $pdf = new \FPDF('P', 'mm', 'letter');
        $pdf->AddPage();
        $pdf->SetMargins(10, 10, 10);
        $pdf->SetTitle(utf8_decode("Productos con Stock Mínimo"));
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->image(base_url() . "/img/logo.png", 10, 5, 30, 30, 'PNG');
        $pdf->Cell(0, 5, utf8_decode("Reporte de productos con stock mínimo"), 0, 1, 'C');
        $pdf->Ln(15);
        $pdf->SetFillColor(0, 0, 0);
        $pdf->SetTextColor(255, 255, 255);
        $pdf->Cell(40, 5, utf8_decode("Código"), 0, 0, 'L', true);
        $pdf->Cell(100, 5, utf8_decode("Nombre"), 0, 0, 'L', true);
        $pdf->Cell(20, 5, utf8_decode("Stock"), 0, 0, 'L', true);
        $pdf->Cell(30, 5, utf8_decode("Precio Compra"), 0, 1, 'L', true);
        $pdf->SetFont('Arial', '', 10);
        $pdf->SetTextColor(0, 0, 0);
        foreach ($datos as $producto) {
            $pdf->Cell(40, 5, $producto['codigo'], 1, 0, 'L');
            $pdf->Cell(100, 5, utf8_decode($producto['descripcion']), 1, 0, 'L');
            $pdf->Cell(20, 5, utf8_decode($producto['stock']), 1, 0, 'L');
            $pdf->Cell(30, 5, utf8_decode($producto['precio_compra']), 1, 1, 'L');
        }

        $this->response->setHeader('Content-Type', 'application/pdf');
        $pdf->Output("Productos.pdf", "I");
    }
}
