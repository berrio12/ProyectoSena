<?php

namespace App\Controllers;

use App\Models\CajasCierreModel;
use App\Models\CajasModel;
use App\Models\DetallePermisosModel;
use App\Models\VentasModel;

class Cajas extends BaseController
{
    protected $reglas, $cajas, $cierre, $ventas, $session, $detalle_permisos;
    public function __construct()
    {
        helper(['form']);
        $this->cajas = new CajasModel();
        $this->cierre = new CajasCierreModel();
        $this->cierre = new CajasCierreModel();
        $this->ventas = new VentasModel();
        $this->detalle_permisos = new DetallePermisosModel();
        $this->reglas = [
            'caja' => [
                'rules' => 'required|is_unique[cajas.caja,id,{id}]',
                'errors' => [
                    'required' => 'El campo {field} es requerido',
                    'is_unique' => 'El {field} debe ser único'

                ]
            ]
        ];
        $this->session = session();
        $perm = $this->detalle_permisos->verificarPermisos($this->session->id_usuario, "cajas");
        if (!$perm && $this->session->id_usuario != 1) {
            echo view('permisos');
            exit;
        }
    }

    public function index()
    {
        echo view("templates/header");
        echo view("cajas/index");
        echo view("templates/footer");
    }
    public function listar()
    {
        $data = $this->cajas->where('estado', 1)->findAll();
        for ($i = 0; $i < count($data); $i++) {
            if ($data[$i]['estado'] == 1) {
                $data[$i]['estado'] = '<span class="badge bg-info">Activo</span>';
                $data[$i]['acciones'] = '<div class"text-center">
                <a href="' . base_url("cajas/editar/" . $data[$i]['id']) . '" class="btn btn-dark"><i class="fas fa-edit"></i></a>
                <button class="btn btn-danger" onclick="btnEliminarCaja(' . $data[$i]['id'] . ')"><i class="fas fa-trash-alt"></i></button>
                </div>';
            }
        }
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function registrar()
    {
        if ($this->request->getMethod() == 'post' && $this->validate($this->reglas)) {
            $caja = $this->request->getPost('caja');
            $data = $this->cajas->save([
                'caja' => $caja
            ]);
            return redirect()->to(base_url() . '/cajas')->with('message', 'Caja registrado con exíto.');
        } else {
            $data['validation'] = $this->validator;
            echo view("templates/header");
            echo view("cajas/nuevo", $data);
            echo view("templates/footer");
        }
    }
    public function nuevo()
    {
        echo view("templates/header");
        echo view("cajas/nuevo");
        echo view("templates/footer");
    }
    public function editar($id)
    {
        $data['caja'] = $this->cajas->where('id', $id)->first();
        echo view("templates/header");
        echo view("cajas/editar", $data);
        echo view("templates/footer");
    }
    public function actualizar()
    {
        if ($this->request->getMethod() == 'post' && $this->validate($this->reglas)) {
            $data = $this->cajas->update(
                $this->request->getPost('id'),
                [
                    'caja' => $this->request->getPost('caja')
                ]
            );
            return redirect()->to(base_url() . '/cajas')->with('message', 'Caja registrado con exíto.');
        } else {
            $data['validation'] = $this->validator;
            $data['caja'] = $this->cajas->where('id', $this->request->getPost('id'))->first();
            echo view("templates/header");
            echo view("cajas/editar", $data);
            echo view("templates/footer");
        }
    }
    public function eliminar($id)
    {
        $data = $this->cajas->update($id, ['estado' => 0]);
        if ($data) {
            $mensaje = array('icono' => 'success', "mensaje" => 'Caja eliminado con éxito');
        } else {
            $mensaje = array('icono' => 'error', "mensaje" => 'Error al eliminar la caja');
        }
        echo json_encode($mensaje, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function reciclaje()
    {
        echo view("templates/header");
        echo view("cajas/reciclaje");
        echo view("templates/footer");
    }
    public function vaciar()
    {
        $data = $this->cajas->where('estado', 0)->findAll();
        for ($i = 0; $i < count($data); $i++) {
            if ($data[$i]['estado'] == 0) {
                $data[$i]['estado'] = '<span class="badge bg-danger">Inactivo</span>';
                $data[$i]['acciones'] = '<div class"text-center">
                    <button class="btn btn-success" onclick="btnreingresar_caja(' . $data[$i]['id'] . ')"><i class="fas fa-reply"></i></button>
                    </div>';
            }
        }
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function restaurar($id)
    {
        $data = $this->cajas->update($id, ['estado' => 1]);
        if ($data) {
            $mensaje = array('icono' => 'success', "mensaje" => 'Caja reingresado con éxito');
        } else {
            $mensaje = array('icono' => 'error', "mensaje" => 'Error al reingresar la caja');
        }
        echo json_encode($mensaje, JSON_UNESCAPED_UNICODE);
        die();
    }
    // Cierre Caja
    public function cierre()
    {
        $id_caja = $this->session->id_caja;
        $data['cierre'] = $this->getDatos($id_caja);
        $data['estado'] = $this->cierre->where(['id_caja' => $id_caja, 'status' => 1])->first();
        echo view('templates/header');
        echo view('cajas/cierre', $data);
        echo view('templates/footer');
    }
    public function abrir()
    {
        $data['id'] = $this->session->id_caja;
        echo view('templates/header');
        echo view('cajas/abrir', $data);
        echo view('templates/footer');
    }
    public function cerrar()
    {
        $id_caja = $this->session->id_caja;
        $data = $this->verficarCaja($id_caja);
        echo view('templates/header');
        echo view('cajas/cerrar', $data);
        echo view('templates/footer');
    }
    public function verficarCaja()
    {
        $id_caja = $this->session->id_caja;
        $this->ventas->select("sum(total) AS total")->where(['id_usuario' => $this->session->id_usuario, 'caja' => 1, 'estado' => 1]);
        $total = $this->ventas->first();
        $total_venta = $this->ventas->select("sum(total) AS total")->where(['id_usuario' => $this->session->id_usuario, 'caja' => 1, 'estado' => 1])->countAllResults();
        $cierreCaja = $this->cierre->where(['id', $id_caja, 'status' => 1])->first();
        $mensaje = array("monto_final" => $total['total'], "monto_inicial" => $cierreCaja['monto_inicial'], "ventas" => $total_venta, "id" => $id_caja);
        return $mensaje;
    }
    public function registrarCajaCierre()
    {
        if ($this->request->getMethod() == "post") {
            date_default_timezone_set("America/Lima");
            $fecha = date("Y-m-d h:i:s");
            $monto_inicial = (!empty($this->request->getPost('monto_inicial'))) ? $this->request->getPost('monto_inicial') : 0;
            if ($this->request->getPost('id') == "") {
                $existe = $this->cierre->where(['id_caja' => $this->session->id_caja, 'status' => 1])->first();
                if (!empty($existe)) {
                    return redirect()->to(base_url() . '/cajas/cierre/' . $this->session->id_caja)->with('message', 'La caja ya esta abierta');
                } else {
                    $data = $this->cierre->save([
                        'id_caja' => $this->session->id_caja,
                        'id_usuario' => $this->session->id_usuario,
                        'fecha_inicio' => $fecha,
                        'monto_inicial' => $monto_inicial,
                        'total_ventas' => 0
                    ]);
                    if ($data > 0) {
                        return redirect()->to(base_url() . '/cajas/cierre/' . $this->session->id_caja)->with('message', 'Caja abierta con éxito');
                    } else {
                        return redirect()->to(base_url() . '/cajas/cierre/' . $this->session->id_caja)->with('message', 'Error al abrir la caja');
                    }
                }
            } else {
                if ($this->request->getMethod() == "post") {
                    $datos = $this->verficarCaja($this->request->getPost('id'));
                    $this->cierre->set([
                        'fecha_fin' => $fecha,
                        'monto_fin' => $datos['monto_final'],
                        'total_ventas' => $datos['ventas'],
                        'status' => 0
                    ]);
                    $this->cierre->where(['id_caja' => $this->request->getPost('id'), 'status' => 1]);
                    $data = $this->cierre->update();
                    if ($data > 0) {
                        $this->ventas->set(['caja' => 0]);
                        $this->ventas->where(['id_usuario' => $this->session->id_usuario, 'caja' => 1]);
                        $this->ventas->update();
                        return redirect()->to(base_url() . '/cajas/cierre/' . $this->session->id_caja)->with('message', 'Caja cerrado con éxito');
                    } else {
                        return redirect()->to(base_url() . '/cajas/cierre/' . $this->session->id_caja)->with('message', 'Error al cerrar con éxito');
                    }
                }
            }
        }
    }
    public function getDatos()
    {
        $id_caja = $this->session->id_caja;
        $this->cierre->select('caja_cierre.*, cajas.caja');
        $this->cierre->join('cajas', 'caja_cierre.id_caja = cajas.id');
        $data = $this->cierre->where('caja_cierre.id_caja', $id_caja)
            ->orderBy('caja_cierre.id', 'desc')->findAll();
        return $data;
    }
}
