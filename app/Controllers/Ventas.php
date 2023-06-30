<?php

namespace App\Controllers;

use App\Models\AdminModel;
use App\Models\CajasCierreModel;
use App\Models\ClientesModel;
use App\Models\DetallePermisosModel;
use App\Models\TemporalVentaModel;
use App\Models\ProductosModel;
use App\Models\VentasModel;
use App\Models\DetalleVentasModel;

class Ventas extends BaseController
{
    protected $reglas, $ventas, $tem, $productos, $detalle, 
    $cajas, $session, $detalle_permisos, $empresa, $clientes;
    public function __construct()
    {
        helper(['form']);
        $this->tem = new TemporalVentaModel();
        $this->productos = new ProductosModel();
        $this->ventas = new VentasModel();
        $this->detalle = new DetalleVentasModel();
        $this->cajas = new CajasCierreModel();
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
        $perm = $this->detalle_permisos->verificarPermisos($this->session->id_usuario, "nueva_venta");
        if (!$perm && $this->session->id_usuario != 1) {
            echo view('permisos');
            exit;
        }
        echo view("templates/header");
        echo view("compras/ventas");
        echo view("templates/footer");
    }
    public function historial()
    {
        $perm = $this->detalle_permisos->verificarPermisos($this->session->id_usuario, "ventas");
        if (!$perm && $this->session->id_usuario != 1) {
            echo view('permisos');
            exit;
        }
        echo view("templates/header");
        echo view("compras/historial_venta");
        echo view("templates/footer");
    }
    public function listar()
    {
        $data = $this->ventas->findAll();
        for ($i = 0; $i < count($data); $i++) {
            if ($data[$i]['estado'] == 1) {
                $data[$i]['estado'] = '<span class="badge bg-success">Completado</span>';
                $data[$i]['acciones'] = '<div class"text-center">
                    <a href="' . base_url("ventas/generarPdf/" . $data[$i]['id']) . '" class="btn btn-danger" target="_blank"><i class="fas fa-file-pdf"></i></a>
                    <button class="btn btn-info" onclick="Anular(' . $data[$i]['id'] . ', 0)"><i class="fas fa-ban"></i></button>
                </div>';
            }else{
                $data[$i]['estado'] = '<span class="badge bg-danger">Anulado</span>';
                $data[$i]['acciones'] = '<div class"text-center">
                    <a href="' . base_url("ventas/generarPdf/" . $data[$i]['id']) . '" class="btn btn-danger" target="_blank"><i class="fas fa-file-pdf"></i></a>
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
            $data['precio'] = $row['precio_venta'];
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
            $cantidad_dis = $pro['stock'];
            if ($cantidad_dis < $cantidad) {
                $msg = array('msg' => 'No hay Stock, te quedan '.$cantidad_dis, 'icono' => 'warning');
            }else{
                $existe = $this->tem->where([
                    'id_producto' => $id,
                    'id_usuario' => $this->session->id_usuario
                ])->first();
                if (empty($existe)) {
                    $this->tem->save([
                        'id_producto' => $id,
                        'id_usuario' => $this->session->id_usuario,
                        'precio' => $pro['precio_venta'],
                        'cantidad' => $cantidad
                    ]);
                    $msg = array('msg' => 'Producto agregado', 'icono' => 'success');
                } else {
                    $cant = $cantidad + $existe['cantidad'];
                    $stock_disponible = $cantidad_dis - $existe['cantidad'];
                    if ($cantidad_dis < $cant) {
                        $msg = array('msg' => 'No hay Stock, te quedan ' . $stock_disponible, 'icono' => 'warning');
                    }else{
                        $this->tem->update(
                            $existe['id_temp'],
                            [
                                'cantidad' => $existe['cantidad'] + $cantidad
                            ]
                        );
                        $msg = array('msg' => 'Producto actualizado', 'icono' => 'success');
                    }
                }
            }
            echo json_encode($msg);
            die();
        }
    }
    public function anular($id)
    {
        if ($this->request->getMethod() == 'get') {
            $existe = $this->detalle->where(['id_venta' => $id])->findAll();
            if (!empty($existe)) {
                foreach ($existe as $row) {
                    $stock = $this->productos->where('id', $row['id_producto'])->first();
                    $cantidad = $stock['stock'] + $row['cantidad'];
                    $this->productos->update(
                        $stock['id'],
                        [
                            'stock' => $cantidad
                        ]
                    );
                }
                $this->ventas->update($id, ['estado' => 0]);
                $msg = array('msg' => 'Venta anulado', 'icono' => 'success');
            } else {
                $msg = array('msg' => 'Error anulado', 'icono' => 'error');
            }
            echo json_encode($msg);
            die();
        }
    }
    public function detalle()
    {
        $this->tem->select('*');
        $this->tem->join('productos', 'productos.id = temp_ventas.id_producto');
        $this->tem->where('temp_ventas.id_usuario', $this->session->id_usuario);
        $data['detalle'] = $this->tem->orderBy('temp_ventas.id_temp', 'DESC')->findAll();
        $data['total_pagar'] = number_format($this->totalVenta(), 2, '.', ',');
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function generar($id_cli)
    {
        $caja = $this->cajas->where(['id_caja' => $this->session->id_caja, 'status' => 1])->first();
        if (empty($caja)) {
            $msg = array('msg' => 'No hay caja abierta', 'icono' => 'warning', 'estado' => false);
        }else{
            if (empty($id_cli)) {
                $id_cli == 1;
            }
            $datos = $this->tem->where('id_usuario', $this->session->id_usuario)->findAll();
            $data = $this->ventas->save([
                    'total' => $this->totalVenta(),
                    'id_usuario' => $this->session->id_usuario,
                    'id_cliente' => $id_cli
                ]);
            if ($data) {
                $id_venta = $this->ventas->insertID();
                foreach ($datos as $row) {
                    $this->detalle->save([
                        'id_producto' => $row['id_producto'],
                        'precio' => $row['precio'],
                        'cantidad' => $row['cantidad'],
                        'id_venta' => $id_venta
                    ]);
                    $stock = $this->productos->where('id', $row['id_producto'])->first();
                    $cantidad = $stock['stock'] - $row['cantidad'];
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
                    $msg = array('msg' => 'Venta generada', 'icono' => 'success', 'estado' => true, 'id' => $id_venta);
                }
            } else {
                $msg = array('msg' => 'Error al realizar la Venta', 'icono' => 'error', 'estado' => false);
            }
        }
        
        echo json_encode($msg);
        die();
    }
    public function totalVenta()
    {
        $datos = $this->tem->where('id_usuario', $this->session->id_usuario)->findAll();
        $total = 0;
        foreach ($datos as $row) {
            $sub_total = $row['precio'] * $row['cantidad'];
            $total += $sub_total;
        }
        return $total;
    }
    public function eliminar($id)
    {
        $data = $this->tem->delete($id);
        if ($data) {
            $mensaje = array('icono' => 'success', "msg" => 'Producto eliminado de la venta');
        } else {
            $mensaje = array('icono' => 'error', "msg" => 'Error al eliminar');
        }
        echo json_encode($mensaje, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function generarPdf($id_venta)
    {
        $datosVenta = $this->ventas->where('id', $id_venta)->first();
        $resultado = $this->detalle->select('*')->where('id_venta', $id_venta)->findAll();
        $this->empresa = new AdminModel();
        $this->clientes = new ClientesModel();
        $empresa = $this->empresa->first();
        $pdf = new \FPDF('P', 'mm', array(80, 200));
        $pdf->AddPage();
        $pdf->SetTitle('Reporte Venta');
        $pdf->SetMargins(2, 0, 0);
        $pdf->SetFont('Arial', 'B', 14);
        $pdf->Cell(65, 10, utf8_decode($empresa['nombre']), 0, 1, 'C');
        $pdf->Image(base_url('img/logo.png'), 50, 16, 25, 25);
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
        $pdf->Cell(20, 5, $id_venta, 0, 1, 'L');        
        $pdf->Ln(2);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(70, 5, 'Datos del cliente', 0, 1, 'C');
        $pdf->Cell(42, 5, '========================================', 0, 1, 'L');
        $pdf->Cell(50, 5, 'Nombre', 0, 0, 'L');
        $pdf->Cell(15, 5, utf8_decode('Teléfono'), 0, 1, 'L');
        $pdf->SetFont('Arial', '', 9);
        $cliente = $this->clientes->where('id', $datosVenta['id_cliente'])->first();
        $pdf->Cell(50, 5, utf8_decode($cliente['nombre']), 0, 0, 'L');
        $pdf->Cell(15, 5, utf8_decode($cliente['telefono']), 0, 1, 'L');
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(20, 5, utf8_decode('Dirección:'), 0, 0, 'L');
        $pdf->SetFont('Arial', '', 9);
        $pdf->MultiCell(45, 5, utf8_decode($cliente['direccion']), 0, 'L');
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
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(75, 5, 'Total a pagar', 0, 1, 'R');
        $pdf->Cell(75, 5, number_format($datosVenta['total'], 2, '.', ','), 0, 1, 'R');
        $this->response->setHeader('Content-Type', 'application/pdf');
        $pdf->Output("reportes.pdf", "I");
    }
}
