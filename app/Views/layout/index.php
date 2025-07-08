<!doctype html>
<html lang="id">

<head>
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!--favicon-->
	<link rel="icon" href="<?= base_url(); ?>assets/images/favicon-32x32.png" type="image/png" />
	<!--plugins-->
	<!-- <link href="<?= base_url(); ?>assets/plugins/vectormap/jquery-jvectormap-2.0.2.css" rel="stylesheet"/> -->
	<link href="<?= base_url(); ?>assets/plugins/simplebar/css/simplebar.css" rel="stylesheet" />
	<link href="<?= base_url(); ?>assets/plugins/perfect-scrollbar/css/perfect-scrollbar.css" rel="stylesheet" />
	<link href="<?= base_url(); ?>assets/plugins/metismenu/css/metisMenu.min.css" rel="stylesheet" />
	<link href="<?= base_url(); ?>assets/plugins/datatable/css/dataTables.bootstrap5.min.css" rel="stylesheet" />
	<link type="text/css" href="<?= base_url(); ?>assets/plugins/sweetalert2/dist/sweetalert2.min.css" rel="stylesheet"/>	

	<!-- loader-->
	<link href="<?= base_url(); ?>assets/css/pace.min.css" rel="stylesheet" />
	<script src="<?= base_url(); ?>assets/js/pace.min.js"></script>
	<!-- Bootstrap CSS -->
	<link href="<?= base_url(); ?>assets/css/bootstrap.min.css" rel="stylesheet">
	<link href="<?= base_url(); ?>assets/css/bootstrap-extended.css" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&amp;display=swap" rel="stylesheet">
	<link href="<?= base_url(); ?>assets/css/app.css" rel="stylesheet">
	<link href="<?= base_url(); ?>assets/css/icons.css" rel="stylesheet">
	<!-- Theme Style CSS -->
	<link rel="stylesheet" href="<?= base_url(); ?>assets/css/dark-theme.css" />
	<link rel="stylesheet" href="<?= base_url(); ?>assets/css/semi-dark.css" />
	<link rel="stylesheet" href="<?= base_url(); ?>assets/css/header-colors.css" />

	<!--plugins-->
	<script src="<?= base_url(); ?>assets/js/jquery.min.js"></script>
	<script src="<?= base_url(); ?>assets/plugins/datatable/js/jquery.dataTables.min.js"></script>
	<script src="<?= base_url(); ?>assets/plugins/datatable/js/dataTables.bootstrap5.min.js"></script>
	
	<title><?= $title; ?> - Sistem Manajemen Bengkel Bodyrepair</title>

	<style>
		label.required::after {
			content: '* ';
			color: red;
		}
	</style>
	
</head>

<body>
	<!--wrapper-->
	<div class="wrapper">
		<!--sidebar wrapper -->
		<?= $this->include('layout/sidebar'); ?>
		<!--end sidebar wrapper -->
		<!--start header -->
		<?= $this->include('layout/header'); ?>
		<!--end header -->
		<!--start page wrapper -->
		<div class="page-wrapper">
			<?= $this->renderSection('content'); ?>
		</div>
		<!--end page wrapper -->
		<!--Start Back To Top Button-->
		<a href="javaScript:;" class="back-to-top"><i class='bx bxs-up-arrow-alt'></i></a>
		<!--End Back To Top Button-->
		<footer class="page-footer">
			<p class="mb-0">Copyright © 2023. All right reserved.</p>
		</footer>
	</div>
	<!--end wrapper-->


	<!-- Bootstrap JS -->
	<script src="<?= base_url(); ?>assets/js/bootstrap.bundle.min.js"></script>
	<!--plugins-->
	<script src="<?= base_url(); ?>assets/plugins/simplebar/js/simplebar.min.js"></script>
	<script src="<?= base_url(); ?>assets/plugins/metismenu/js/metisMenu.min.js"></script>
	<script src="<?= base_url(); ?>assets/plugins/perfect-scrollbar/js/perfect-scrollbar.js"></script>
	<script src="<?= base_url(); ?>assets/plugins/chartjs/js/chart.js"></script>
	<!--Morris JavaScript -->
	<!-- <script src="<?= base_url(); ?>assets/plugins/raphael/raphael-min.js"></script> -->
	<script src="<?= base_url(); ?>assets/plugins/morris/js/morris.js"></script>
	<!-- <script src="<?= base_url(); ?>assets/js/index2.js"></script> -->
	
	<!--app JS-->
	<script src="<?= base_url(); ?>assets/js/app.js"></script>
	<script>
		$(document).ready(function() {
			$('#example').DataTable({
				language: {
					url: 'https://cdn.datatables.net/plug-ins/2.0.8/i18n/id.json',
				},
			});
		});

		$(function () {
			$('[data-bs-toggle="tooltip"]').tooltip();
		})
	</script>
	
	<script src="<?= base_url(); ?>assets/plugins/sweetalert2/dist/sweetalert2.min.js"></script>

	<script>
		//alert
		const Toast = Swal.mixin({
			toast: true,
			position: 'top-start',
			showConfirmButton: false,
			timerProgressBar: true,
			didOpen: (toast) => {
				toast.addEventListener('mouseenter', Swal.stopTimer)
				toast.addEventListener('mouseleave', Swal.resumeTimer)
			}
		})

		function alertMesage(status, message) {
			if (status == 200) {
				Toast.fire({
					timer: 2000,
					icon: 'success',
					title: message
				});
			} else {
				Toast.fire({
					timer: 2000,
					icon: 'error',
					title: message
				});
			}
		}

	</script>
</body>

</html>