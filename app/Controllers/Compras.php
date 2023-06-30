<?php

namespace App\Controllers;

use App\Models\AdminModel;
use App\Models\TemporalCompraModel;
use App\Models\ProductosModel;
use App\Models\ComprasModel;
use App\Models\DetalleComprasModel;
use App\Models\DetallePermisosModel;

class Compras extends BaseController
{
    protected $reglas, $compras, $tem, $productos, $detalle, $session, $detalle_permisos, $empresa;
    public function __construct()
    {
        helper(['form']);
        $this->tem = new TemporalCompraModel();
        $this->productos = new ProductosModel();
        $this->compras = new ComprasModel();
        $this->detalle = new DetalleComprasModel();
        $this->detalle_permisos = new DetallePermisosModel();
        $this->reglas = [
            'codigo' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'El {field} es requerido'

                ]
            ]
        ];
        $this->session = session();
    }
    public function index()
    {
        $perm = $this->detalle_permisos->verificarPermisos($this->session->id_usuario, "nueva_compra");
        if (!$perm && $this->session->id_usuario != 1) {
            echo view('permisos');
            exit;
        }
        echo view("templates/header");
        echo view("compras/index");
        echo view("templates/footer");
    }
    public function historial()
    {
        $perm = $this->detalle_permisos->verificarPermisos($this->session->id_usuario, "compras");
        if (!$perm && $this->session->id_usuario != 1) {
            echo view('permisos');
            exit;
        }
        echo view("templates/header");
        echo view("compras/historial_compra");
        echo view("templates/footer");
    }
    public function listar()
    {
        $data = $this->compras->findAll();
        for ($i = 0; $i < count($data); $i++) {
            if ($data[$i]['estado'] == 1) {
                $data[$i]['estado'] = '<span class="badge bg-success">Completado</span>';
                $data[$i]['acciones'] = '<div class"text-center">
                    <a href="' . base_url("compras/generarPdf/" . $data[$i]['id']) . '" class="btn btn-danger" target="_blank"><i class="fas fa-file-pdf"></i></a>
                    <button class="btn btn-info" onclick="Anular(' . $data[$i]['id'] . ', 1)"><i class="fas fa-ban"></i></button>
                </div>';
            }else{
                $data[$i]['estado'] = '<span class="badge bg-danger">Anulado</span>';
                $data[$i]['acciones'] = '<div class"text-center">
                    <a href="' . base_url("compras/generarPdf/" . $data[$i]['id']) . '" class="btn btn-danger" target="_blank"><i class="fas fa-file-pdf"></i></a>
                </div>';
            }
        }
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function buscar()
    {
        $valor = $this->request->getGet('pro');
        $data = $this->productos->like('codigo', $valor)->where('estado', 1)->orLike('descripcion', $valor)->where('estado', 1)->findAll();
        $datos = array();
        foreach ($data as $row) {
            $data['id'] = $row['id'];
            $data['label'] = $row['codigo'] . ' - ' . $row['descripcion'];
            $data['value'] = $row['codigo'];
            $data['precio'] = $row['precio_compra'];
            $data['descripcion'] = $row['descripcion'];
            array_push($datos, $data);
        }
        echo json_encode($datos, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function ingresar($id, $cantidad)
    {
        if ($this->request->getMethod() == 'get') {
            $pro = $this->productos->where('id', $id)->first();
            $existe = $this->tem->where(['id_producto' => $id,
            'id_usuario' => $this->session->id_usuario])->first();
            if (empty($existe)) {
                $this->tem->save([
                    'id_producto' => $id,
                    'id_usuario' => $this->session->id_usuario,
                    'precio' => $pro['precio_compra'],
                    'cantidad' => $cantidad
                ]);
                $msg = array('msg' => 'Producto agregado', 'icono' => 'success');
            }else{
                $this->tem->update($existe['id_temp'], 
                [
                    'cantidad' => $existe['cantidad'] + $cantidad
                ]);
                $msg = array('msg' => 'Producto actualizado', 'icono' => 'success');
            }
            echo json_encode($msg);
            die();
        }
    }
    public function detalle()
    {
        $this->tem->select('*');
        $this->tem->join('productos', 'temp_compras.id_producto = productos.id');
        $this->tem->where('temp_compras.id_usuario', $this->session->id_usuario);
        $data['detalle'] = $this->tem->orderBy('temp_compras.id_temp', 'DESC')->findAll();
        $data['total_pagar'] = number_format($this->totalCompra(), 2, '.', ',');
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function generar()
    {
        $datos = $this->tem->where('id_usuario', $this->session->id_usuario)->findAll();
        $data = $this->compras->save([
            'total' => $this->totalCompra(),
            'id_usuario' => $this->session->id_usuario
        ]);
        if ($data) {
            $id_compra = $this->compras->insertID();
           foreach ($datos as $row) {
                $this->detalle->save([
                    'id_producto' => $row['id_producto'],
                    'precio' => $row['precio'],
                    'cantidad' => $row['cantidad'],
                    'id_compra' => $id_compra
                ]);
                $stock = $this->productos->where('id', $row['id_producto'])->first();
                $cantidad = $stock['stock'] + $row['cantidad'];
                $this->productos->update(
                    $stock['id'],
                    [
                        'stock' => $cantidad
                    ]
                );
           }
            $this->tem->where('id_usuario', $this->session->id_usuario);
            $eliminar = $this->tem->delete();
            if ($eliminar) {
                $msg = array('msg' => 'Compra generada', 'icono' => 'success' ,'estado' => true, 'id' => $id_compra);
            }
        }else{
            $msg = array('msg' => 'Error al realizar la compra', 'icono' => 'error' ,'estado' => false);
        }
        echo json_encode($msg);
        die();
    }
    public function totalCompra()
    {
        $datos = $this->tem->where('id_usuario', $this->session->id_usuario)->findAll();
        $total = 0;
        foreach ($datos as $row) {
            $sub_total = $row['precio'] * $row['cantidad'];
            $total += $sub_total;
        }
        return $total;
    }
    public function anular($id)
    {
        if ($this->request->getMethod() == 'get') {
            $existe = $this->detalle->where(['id_compra' => $id])->findAll();
            if (!empty($existe)) {
                foreach ($existe as $row) {
                    $stock = $this->productos->where('id', $row['id_producto'])->first();
                    $cantidad = $stock['stock'] - $row['cantidad'];
                    $this->productos->update(
                        $stock['id'],
                        [
                            'stock' => $cantidad
                        ]
                    );
                }
                $this->compras->update($id, ['estado' => 0]);
                $msg = array('msg' => 'Compra anulado', 'icono' => 'success');
            } else{
                $msg = array('msg' => 'Error anulado', 'icono' => 'error');
            }
            echo json_encode($msg);
            die(); 
        }
    }
    public function eliminar($id)
    {
        $data = $this->tem->delete($id);
        if ($data) {
            $mensaje = array('icono' => 'success', "msg" => 'Producto eliminado de la compra');
        } else {
            $mensaje = array('icono' => 'error', "msg" => 'Error al eliminar');
        }
        echo json_encode($mensaje, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function generarPdf($id_compra)
    {
        $datosCompra = $this->compras->where('id', $id_compra)->first();
        $resultado = $this->detalle->select('*')->where('id_compra', $id_compra)->findAll();
        $this->empresa = new AdminModel();
        $empresa = $this->empresa->first();
        $pdf = new \FPDF('P', 'mm', array(80, 200));
        $pdf->AddPage();
        $pdf->SetTitle('Reporte Compra');
        $pdf->SetMargins(2, 0, 0);
        $pdf->SetFont('Arial', 'B', 14);
        $pdf->Cell(65, 10, utf8_decode($empresa['nombre']), 0, 1, 'C');
        $pdf->Image(base_url('img/logo.png'), 60, 16, 20, 20);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(18, 5, 'Ruc: ', 0, 0, 'L');
        $pdf->SetFont('Arial', '', 9);
        $pdf->Cell(20, 5, $empresa['ruc'], 0, 1, 'L');

        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(18, 5, utf8_decode('Teléfono: '), 0, 0, 'L');
        $pdf->SetFont('Arial', '', 9);
        $pdf->Cell(20, 5, $empresa['telefono'], 0, 1, 'L');

        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(18, 5, utf8_decode('Dirección: '), 0, 0, 'L');
        $pdf->SetFont('Arial', '', 9);
        $pdf->MultiCell(35, 5, utf8_decode($empresa['direccion']), 0, 'L');
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(18, 5, 'Folio: ', 0, 0, 'L');
        $pdf->SetFont('Arial', '', 9);
        $pdf->Cell(20, 5, $id_compra, 0, 1, 'L');
        $pdf->Ln(2);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(42, 5, '========================================', 0, 1, 'L');
        //Encabezado de productos        
        $pdf->Cell(20, 5, 'Cant - precio', 0, 0, 'L');
        $pdf->Cell(40, 5, utf8_decode('Descripción'), 0, 0, 'L');        
        $pdf->Cell(15, 5, 'Sub Total', 0, 1, 'L');
        $pdf->SetTextColor(0, 0, 0);
        $pdf->Cell(42, 5, '========================================', 0, 1, 'L');
        $pdf->SetFont('Arial', '', 9);
        foreach ($resultado as $row) {
            $this->productos->select('id, descripcion');
            $des = $this->productos->where('id', $row['id_producto'])->first();
            $pdf->Cell(20, 5, $row['cantidad'] . ' x ' . $row['precio'], 0, 0, 'L');
            $pdf->MultiCell(45, 5, utf8_decode($des['descripcion']), 0, 'L');
            $pdf->Cell(75, 5, number_format($row['precio'] * $row['cantidad'], 2, '.', ','), 0, 1, 'R');
            $pdf->Cell(70, 5, '--------------------------------------------------------------------', 0, 1, 'L');
        }
        $pdf->Ln();
        $pdf->Cell(75, 5, 'Total a pagar', 0, 1, 'R');
        $pdf->Cell(75, 5, number_format($datosCompra['total'], 2, '.', ','), 0, 1, 'R');
        $this->response->setHeader('Content-Type', 'application/pdf');
        $pdf->Output("reportes.pdf", "I");
    }
}
