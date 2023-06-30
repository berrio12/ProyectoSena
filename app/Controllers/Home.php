<?php

namespace App\Controllers;

use App\Models\CajasModel;
use App\Models\UsuariosModel;

class Home extends BaseController
{
	protected $usuarios, $cajas;
	public function __construct() {
		$this->usuarios = new UsuariosModel();
		$this->cajas = new CajasModel();
	}
	public function index()
	{
		$data = $this->usuarios->first();
		if (empty($data)) {
			$caja['cajas'] = $this->cajas->findAll();
			return view('registro', $caja);
		}else{
			return view('login');
		}
	}
}
