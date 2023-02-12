<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>POS - by Handal Inti Boga</title>
	<link rel="icon" type="image/x-icon" href="<?= base_url() ?>assets/dist/img/Handal Logo Only.jpg">
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	<link rel="stylesheet" href="<?= base_url() ?>assets/bower_components/bootstrap/dist/css/bootstrap.min.css">
	<link rel="stylesheet" href="<?= base_url() ?>assets/bower_components/font-awesome/css/font-awesome.min.css">
	<link rel="stylesheet" href="<?= base_url() ?>assets/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
	<link rel="stylesheet" href="<?= base_url() ?>assets/dist/css/AdminLTE.min.css">
	<link rel="stylesheet" href="<?= base_url() ?>assets/dist/css/skins/_all-skins.min.css">
	<!--[if lt IE 9]>
	<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
	<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
	<link rel="stylesheet" href="<?= base_url() ?>assets/plugins/sweetalert2/sweetalert2.min.css">
	<link rel="stylesheet" href="<?= base_url() ?>assets/plugins/sweetalert2/animate.min.css">
	<style>
		.swal2-popup {
			font-size: 1.6rem !important;
		}
	</style>

	<style>
		/* Center the loader */
		#loader {
			display: none;
			position: absolute;
			left: 50%;
			top: 50%;
			z-index: 99999;
			width: 120px;
			height: 120px;
			margin: -76px 0 0 -76px;
			border: 16px solid #f3f3f3;
			border-radius: 50%;
			border-top: 16px solid #3498db;
			-webkit-animation: spin 2s linear infinite;
			animation: spin 2s linear infinite;
		}

		#wadah_loader {
			display: none;
			position: absolute;
			width: 100%;
			height: 100%;
			margin: 0 !important;
			padding: 0 !important;
			background-color: rgba(0, 0, 0, 0.3);
			z-index: 9999;
		}

		@-webkit-keyframes spin {
			0% {
				-webkit-transform: rotate(0deg);
			}

			100% {
				-webkit-transform: rotate(360deg);
			}
		}

		@keyframes spin {
			0% {
				transform: rotate(0deg);
			}

			100% {
				transform: rotate(360deg);
			}
		}

		/* Add animation to "page content" */
		.animate-bottom {
			position: relative;
			-webkit-animation-name: animatebottom;
			-webkit-animation-duration: 1s;
			animation-name: animatebottom;
			animation-duration: 1s
		}

		@-webkit-keyframes animatebottom {
			from {
				bottom: -100px;
				opacity: 0
			}

			to {
				bottom: 0px;
				opacity: 1
			}
		}

		@keyframes animatebottom {
			from {
				bottom: -100px;
				opacity: 0
			}

			to {
				bottom: 0;
				opacity: 1
			}
		}
	</style>
</head>

<body class="hold-transition skin-purple sidebar-mini <?= $this->uri->segment(1) == 'sale' && $this->uri->segment(2) != 'stock' ? 'sidebar-collapse' : null ?> ">
	<div id="wadah_loader">
		<div id="loader"></div>
	</div>
	<div class="wrapper">
		<header class="main-header">
			<a href="<?= base_url('dashboard') ?>" class="logo">
				<span class="logo-mini"><img src="<?= base_url() ?>assets/dist/img/Handal Logo Only.jpg" style="max-width:30px;border-radius: 50%" alt=""></span>
				<span class="logo-lg"><b>POS</b></span>
			</a>
			<nav class="navbar navbar-static-top">
				<a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</a>

				<div class="navbar-custom-menu">
					<ul class="nav navbar-nav">
						<!-- User Account -->
						<li class="dropdown user user-menu">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown">
								<img src="<?= base_url() ?>assets/dist/img/user1234.png" class="user-image">
								<span class="hidden-xs"><?= $this->fungsi->user_login()->name ?></span>
								<span class="hidden-xs"> / <?= get_counter()->nama_toko ?></span>
							</a>
							<ul class="dropdown-menu">
								<li class="user-header">
									<img src="<?= base_url() ?>assets/dist/img/user1234.png" class="img-circle">
									<p><?= $this->fungsi->user_login()->name ?>
									</p>
								</li>
								<li class="user-footer">
									<div class="pull-left">
									</div>
									<div class="pull-right">
										<a href="<?= site_url('auth/logout') ?>" class="btn btn-flat bg-red">Sign out</a>
									</div>
								</li>
							</ul>
						</li>
					</ul>
				</div>
			</nav>
		</header>

		<!-- Left side column -->
		<aside class="main-sidebar">
			<section class="sidebar">
				<div class="user-panel">
					<div class="pull-left image">
						<img src="<?= base_url() ?>assets/dist/img/user1234.png" class="img-circle">
					</div>
					<div class="pull-left info">
						<p><?= ucfirst($this->fungsi->user_login()->username) ?></p>
						<a href="#"><i class="fa fa-circle text-success"></i> Online</a>
					</div>
				</div>
				<!-- sidebar menu -->
				<ul class="sidebar-menu" data-widget="tree">
					<li class="header">MAIN NAVIGATION</li>
					<li <?= $this->uri->segment(1) == 'dashboard' || $this->uri->segment(1) == '' ? 'class="active"' : '' ?>>
						<a href="<?= site_url('dashboard') ?>"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a>
					</li>
					<li class="treeview <?= $this->uri->segment(1) == 'sale' ? 'active' : '' ?>">
						<a href="#">
							<i class="fa fa-shopping-cart"></i> <span>Transaction</span>
							<span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
						</a>
						<ul class="treeview-menu">
							<li <?= $this->uri->segment(1) == 'sale' && $this->uri->segment(2) != 'stock' ? 'class="active"' : '' ?>>
								<a href="<?= site_url('sale') ?>"><i class="fa fa-circle-o"></i> Sales</a>
							</li>
							<!-- <li <?= $this->uri->segment(2) == 'stock' ? 'class="active"' : '' ?>>
								<a href="<?= site_url('sale/stock') ?>"><i class="fa fa-circle-o"></i> Stocks</a>
							</li> -->

						</ul>
					</li>
					<li class="treeview <?= $this->uri->segment(1) == 'report' || $this->uri->segment(1) == 'stock' || $this->uri->segment(1) == 'upload' ? 'active' : '' ?>">
						<a href="#">
							<i class="fa fa-pie-chart"></i> <span>Reports</span>
							<span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
						</a>
						<ul class="treeview-menu">
							<li <?= $this->uri->segment(1) == 'report' && $this->uri->segment(2) == 'sale' ? 'class="active"' : '' ?>>
								<a href="<?= site_url('report/sale') ?>"><i class="fa fa-circle-o"></i> Sales</a>
							</li>
							<li <?= $this->uri->segment(2) == 'stock_detail' ? 'class="active"' : '' ?>>
								<a href="<?= site_url('stock/stock_detail') ?>"><i class="fa fa-circle-o"></i> Stock Detail</a>
							</li>
							<li <?= $this->uri->segment(1) == 'stock' && $this->uri->segment(2) == 'in' ? 'class="active"' : '' ?>>
								<a href="<?= site_url('stock/in') ?>"><i class="fa fa-circle-o"></i> Data Stock In</a>
							</li>
							<li <?= $this->uri->segment(1) == 'stock' && $this->uri->segment(2) == 'out' ? 'class="active"' : '' ?>>
								<a href="<?= site_url('stock/out') ?>"><i class="fa fa-circle-o"></i> Data Stock Out</a>
							</li>
							<li <?= $this->uri->segment(1) == 'upload' ? 'class="active"' : '' ?>>
								<a href="<?= site_url('upload') ?>"><i class="fa fa-circle-o"></i> Upload Data</a>
							</li>
							<li <?= $this->uri->segment(2) == 'daily' ? 'class="active"' : '' ?>>
								<a href="<?= site_url('report/daily') ?>">
									<i class="fa fa-circle-o"></i> Sales Daily
								</a>
							</li>
						</ul>
					</li>
					<?php if ($this->fungsi->user_login()->level == 1) { ?>
						<li class="header">SETTINGS</li>

						<li class="treeview <?= $this->uri->segment(1) == 'transfer' ? 'active' : '' ?>">
							<a href=" #">
								<i class="fa fa-folder"></i> <span>Transfer Stock</span>
								<span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
							</a>
							<ul class="treeview-menu">
								<li <?= $this->uri->segment(2) == 'data_transfer_out' || $this->uri->segment(2) == '' ? 'class="active"' : '' ?>>
									<a href="<?= site_url('transfer/data_transfer_out') ?>"><i class="fa fa-circle-o"></i> <span>Transfer Stock Out</span></a>
								</li>
								<li <?= $this->uri->segment(2) == 'data_transfer_in' || $this->uri->segment(2) == 'in' ? 'class="active"' : '' ?>>
									<a href="<?= site_url('transfer/data_transfer_in') ?>"><i class="fa fa-circle-o"></i> <span>Transfer Stock In</span></a>
								</li>
							</ul>
						</li>

						<li class="treeview <?= $this->uri->segment(1) == 'produksi' ? 'active' : '' ?>">
							<a href="#">
								<i class="fa fa-folder"></i> <span>Produksi</span>
								<span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
							</a>
							<ul class="treeview-menu">
								<li <?= $this->uri->segment(2) == '' ? 'class="active"' : '' ?>>
									<a href="<?= site_url('produksi') ?>"><i class="fa fa-circle-o"></i> <span>Produksi (Buat Baru)</span></a>
								</li>
								<li <?= $this->uri->segment(2) == 'ready' ? 'class="active"' : '' ?>>
									<a href="<?= site_url('produksi/ready') ?>"><i class="fa fa-circle-o"></i> <span>Produksi (Item Exists)</span></a>
								</li>
							</ul>
						</li>

						<li class="treeview <?= $this->uri->segment(1) == 'item' || $this->uri->segment(1) == 'mypos_api' || $this->uri->segment(1) == 'stockout' ? 'active' : '' ?>">
							<a href="#">
								<i class="fa fa-folder"></i> <span>Stock</span>
								<span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
							</a>
							<ul class="treeview-menu">
								<li class="<?= $this->uri->segment(1) == 'item' ? 'active' : '' ?>">
									<a href="<?= site_url('item') ?>"><i class="fa fa-circle-o"></i> <span>Data Stock</span></a>
								</li>
								<li class="<?= $this->uri->segment(2) == 'stock_in' ? 'active' : '' ?>">
									<a onclick="showLoading()" href="<?= site_url('mypos_api/stock_in') ?>"><i class="fa fa-circle-o"></i> <span>Stock In</span></a>
								</li>
								<li class="<?= $this->uri->segment(1) == 'stockout' ? 'active' : '' ?>">
									<a href="<?= site_url('stockout') ?>"><i class="fa fa-circle-o"></i> <span>Stock Out</span></a>
								</li>
							</ul>
						</li>

						<li class="treeview <?= $this->uri->segment(1) == 'bonus' || $this->uri->segment(1) == 'user' || $this->uri->segment(1) == 'tax' || $this->uri->segment(1) == 'toko' || $this->uri->segment(1) == 'payment' || $this->uri->segment(1) == 'printer' ? 'active' : '' ?>">
							<a href="#">
								<i class="fa fa-folder"></i> <span>Other</span>
								<span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
							</a>
							<ul class="treeview-menu">
								<li>
									<a href="<?= site_url('bonus') ?>"><i class="fa fa-circle-o"></i> <span>Setting Bonus</span></a>
								</li>
								<li <?= $this->uri->segment(1) == 'user' ? 'class="active"' : '' ?>>
									<a href="<?= site_url('user') ?>"><i class="fa fa-circle-o"></i> <span>Users</span></a>
								</li>
								<li <?= $this->uri->segment(1) == 'tax' ? 'class="active"' : '' ?>>
									<a href="<?= site_url('tax') ?>"><i class="fa fa-circle-o"></i> <span>Tax</span></a>
								</li>
								<li <?= $this->uri->segment(1) == 'toko' ? 'class="active"' : '' ?>>
									<a href="<?= site_url('toko') ?>"><i class="fa fa-circle-o"></i> <span>Toko</span></a>
								</li>
								<li <?= $this->uri->segment(1) == 'type_bayar' ? 'class="active"' : '' ?>>
									<a href="<?= site_url('payment') ?>"><i class="fa fa-circle-o"></i> <span>Type Bayar</span></a>
								</li>
								<li>
									<a href="<?= site_url('printer') ?>"><i class="fa fa-circle-o"></i> <span>Setting Printer</span></a>
								</li>
							</ul>
						</li>
					<?php } ?>
				</ul>
			</section>
		</aside>

		<!-- <div id="loadingIndicator" class="d-none">
			<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i>
			<span class="sr-only">Loading...</span>
		</div> -->

		<script src="<?= base_url() ?>assets/bower_components/jquery/dist/jquery.min.js"></script>
		<script src="<?= base_url() ?>assets/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
		<script src="<?= base_url() ?>assets/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
		<script src="<?= base_url() ?>assets/plugins/sweetalert2/sweetalert2.min.js"></script>
		<!-- Content Wrapper -->
		<div class="content-wrapper">
			<?php echo $contents ?>
		</div>

		<footer class="main-footer">
			<div class="pull-right hidden-xs">
				<b>Version</b> 1.0
			</div>
			<span>myPOS</span><strong> By <a href="#"> <strong> Handal Inti Boga</strong></a></strong>
		</footer>

	</div>

	<script src="<?= base_url() ?>assets/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
	<script src="<?= base_url() ?>assets/bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
	<script src="<?= base_url() ?>assets/dist/js/adminlte.min.js"></script>

	<script src="<?= base_url() ?>assets/myjs/myjs.js"></script>
	<script>
		$(document).ready(function() {
			$('#table1').DataTable()
		})
	</script>
	<script>
		function showLoading() {
			document.getElementById("wadah_loader").style.display = "block";
			document.getElementById("loader").style.display = "block";
		}
	</script>
	<script>
		var flash = $('#flash').data('flash');
		if (flash) {
			Swal.fire({
				icon: 'success',
				title: 'Success',
				text: flash,
				showClass: {
					popup: 'animate__animated animate__fadeInDown'
				},
				hideClass: {
					pupup: 'animate__animated animate__fadeOutUp'
				}
			})
		}

		$(document).on('click', '#btn-hapus', function(e) {
			e.preventDefault();
			var link = $(this).attr('href');
			Swal.fire({
				title: 'Apakah Anda yakin?',
				text: "Data akan dihapus!",
				icon: 'warning',
				showCancelButton: true,
				confirmButtonColor: '#3085d6',
				cancelButtonColor: '#d33',
				confirmButtonText: 'Ya, hapus!',
				showClass: {
					popup: 'animate__animated animate__jackInTheBox'
				},
				hideClass: {
					pupup: 'animate__animated animate__zoomOut'
				}
			}).then((result) => {
				if (result.isConfirmed) {
					window.location = link;
				}
			})
		})
	</script>

</body>

</html>