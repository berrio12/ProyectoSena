<!DOCTYPE html>
<html>

<head>
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!--favicon-->
	<!-- <link rel="shortcut icon" type="image/x-icon" href="<?php echo base_url('assets/images/favicon.ico'); ?>"> -->
	<!--plugins-->
	<!-- loader-->
	<link href="<?php echo base_url('assets/css/pace.min.css'); ?>" rel="stylesheet" />
	<script src="<?php echo base_url('assets/js/pace.min.js'); ?>"></script>
	<!-- Bootstrap CSS -->
	<link href="<?php echo base_url('assets/css/bootstrap.min.css'); ?>" rel="stylesheet">
	<link href="<?php echo base_url('assets/css/bootstrap-extended.css'); ?>" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
	<link href="<?php echo base_url('assets/css/app.css'); ?>" rel="stylesheet">
	<link href="<?php echo base_url('assets/css/icons.css'); ?>" rel="stylesheet">
	<title>Acceso al sistema</title>
</head>

<body class="bg-login">
	<!--wrapper-->
	<div class="wrapper">
		<div class="section-authentication-signin d-flex align-items-center justify-content-center my-5 my-lg-0">
			<div class="container-fluid">
				<div class="row row-cols-1 row-cols-lg-3 row-cols-xl-4">
					<div class="col mx-auto">
						<div class="mb-4 text-center">
							<img src="<?php echo base_url('pan.png'); ?>" width="500" alt="logo" />
						</div>
						<div class="card">
							<div class="card-body">
								<div class="border p-4 rounded">
									<div class="text-center">
										<h3 class="">Iniciar Sesión</h3>
										<?php if (!empty(session()->getFlashdata('fail'))) { ?>
											<div class="alert border-0 border-start border-5 border-danger alert-dismissible fade show py-2">
												<div class="d-flex align-items-center">
													<div class="font-35 text-danger"><i class='bx bxs-check-circle'></i>
													</div>
													<div class="ms-3">
														<div><?php echo session()->getFlashdata('fail'); ?></div>
													</div>
												</div>
												<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
											</div>
										<?php } ?>
									</div>
									<div class="login-separater text-center mb-4"> <span>Ingresa a Dcanos</span>
										<hr />
									</div>
									<div class="form-body">
										<form class="row g-3" action="<?php echo base_url('usuarios/validar') ?>" method="POST" autocomplete="off">
											<div class="col-12">
												<label for="usuario" class="form-label">Usuario</label>
												<input type="text" class="form-control" id="usuario" name="usuario" placeholder="Ejm: admin">
												<?php if (isset($validation)) { ?>
													<span class="text-danger fw-bold"><?php echo $validation->getError('usuario'); ?></span>
												<?php } ?>
											</div>
											<div class="col-12">
												<label for="clave" class="form-label">Contraseña</label>
												<div class="input-group" id="show_hide_password">
													<input type="password" class="form-control border-end-0" id="clave" name="clave" placeholder="Contraseña">
													<a href="javascript:;" class="input-group-text bg-transparent"><i class='bx bx-hide'></i></a>
												</div>
												<?php if (isset($validation)) { ?>
													<span class="text-danger fw-bold"><?php echo $validation->getError('clave'); ?></span>
												<?php } ?>
											</div>
											<div class="col-12">
												<div class="d-grid">
													<button type="submit" class="btn btn-primary"><i class="bx bxs-lock-open"></i>Acceso</button>
												</div>
											</div>
										</form>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<!--end row-->
			</div>
		</div>
	</div>
	<!--end wrapper-->
	<!-- Bootstrap JS -->
	<script src="<?php echo base_url('assets/js/bootstrap.bundle.min.js'); ?>"></script>
	<!--plugins-->
	<script src="<?php echo base_url('assets/js/jquery.min.js'); ?>"></script>
	<script src="<?php echo base_url('assets/plugins/perfect-scrollbar/js/perfect-scrollbar.js'); ?>"></script>
	<!--Password show & hide js -->
	<script>
		$(document).ready(function() {
			$("#show_hide_password a").on('click', function(event) {
				event.preventDefault();
				if ($('#show_hide_password input').attr("type") == "text") {
					$('#show_hide_password input').attr('type', 'password');
					$('#show_hide_password i').addClass("bx-hide");
					$('#show_hide_password i').removeClass("bx-show");
				} else if ($('#show_hide_password input').attr("type") == "password") {
					$('#show_hide_password input').attr('type', 'text');
					$('#show_hide_password i').removeClass("bx-hide");
					$('#show_hide_password i').addClass("bx-show");
				}
			});
		});
	</script>
</body>