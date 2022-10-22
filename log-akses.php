<?php
include "cek-sesi.php";
$user=strtoupper($_SESSION['username']);
?>
<!DOCTYPE html>
<html>
<head>
	<title>Sistem Pemetaan Jaringan Wifi</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<script type="text/javascript" src="bootstrap/js/tests/vendor/jquery.min.js"></script>
	<script type="text/javascript" src="bootstrap/dist/js/bootstrap.js"></script>
	<link rel="stylesheet" type="text/css" href="bootstrap/dist/css/layout.css">
	<link rel="stylesheet" type="text/css" href="bootstrap/dist/css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="bootstrap/dist/css/bootstrap-theme.css">
		<script type="text/javascript" src="fontawesome/js/all.js"></script>
	<link rel="stylesheet" type="text/css" href="fontawesome/css/all.css">
</head>
<body>
	<header>
		<div class="header1">
			<ul class="nav navbar-nav navbar-left">
				<img src="image/internet.png" width="60" height="60">
				<li class="dropdown"><a href="#" id="pintu" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user-circle fa-lg"></i>&nbsp;<strong><?php echo $user; ?></strong></a>
					<ul class="dropdown-menu">
						<?php
						echo "<li><a href='edit-user.php?user=$_SESSION[username]'><span class='glyphicon glyphicon-pencil'></span> &nbsp;EDIT PENGGUNA</a></li>";
						?>
						<li><a href="#" data-toggle="modal" data-target="#logout"><span class="glyphicon glyphicon-log-out"></span> &nbsp;KELUAR</a></li>
					</ul>
				</li>
			</ul>
		</div>
		<div class="header2">
			<h2>SISTEM PEMETAAN JARINGAN WIFI</h2>
		</div>
	</header>
	<aside>
		<nav>
			<ul class="menubar">
				<li><a href="/sistem-pemetaan-jaringan"><span class="glyphicon glyphicon-home"></span> &nbsp;BERANDA</a></li>
				<li><a href="petugas.php"><span class="glyphicon glyphicon-user"></span> &nbsp;PETUGAS</a></li>
				<li><a href="alat.php"><span class="glyphicon glyphicon-hdd"></span> &nbsp;ALAT JARINGAN</a></li>
				<li><a href="pemetaan.php"><span class="glyphicon glyphicon-map-marker"></span> &nbsp;PEMETAAN JARINGAN WIFI</a></li>
				<li><a href="log-akses.php"><span class="glyphicon glyphicon-tags"></span> &nbsp;LOG AKSES</a></li>
				<li><a href="traffic.php"><span class="glyphicon glyphicon-globe"></span> &nbsp;TRAFIK DATA</a></li>
				<?php
					echo "<li><a href='edit-user.php?user=$_SESSION[username]'><span class='glyphicon glyphicon-pencil'></span> &nbsp;EDIT PENGGUNA</a></li>";
				?>
				<li><a href="#" data-toggle="modal" data-target="#logout"><span class="glyphicon glyphicon-log-out"></span> &nbsp;KELUAR</a></li>
			</ul>
		</nav>
	</aside>
	<article>
		<div class="konten">
			<p>&nbsp;</p>
			<p>&nbsp;
				<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
					Cari Data : <input type="text" name="cari_log" placeholder="Cari Data Login..." class="form-control">
					<button class="btn btn-primary" name="cari_data">Cari Data</button>
				</form>
			</p>
			<p>&nbsp;
				<table width="100%" cellpadding="0" cellspacing="0" class="table table-bordered table-hover table-striped table-condensed">
					<thead>
					<tr>
						<td>
							NAMA PETUGAS	
						</td>
						<td>
							ALAMAT IP
						</td>
						<td>
							NAMA KOMPUTER
						</td>
						<td>
							TANGGAL AKSES
						</td>
					</tr>
					</thead>
				<?php
					include "config/config.php";
					if(!isset($_POST['cari_data'])) {
						$sql=mysqli_query($koneksi,"select * from log_ip_login");
						while($row=mysqli_fetch_array($sql)) {
							$kodepetugas=$row['kode_petugas'];
							$ip_address=$row['ip_address_login'];
							$nama_komputer=$row['nama_komputer'];
							$tgl_akses=$row['tgl_akses'];
							$ambildatapetugas=mysqli_query($koneksi,"select * from tbl_petugas where kode_petugas='$kodepetugas'");
							$ambilpetugas=mysqli_fetch_array($ambildatapetugas);
							echo "<tr>
								<td data-label='Kode Petugas'>$ambilpetugas[nama_petugas]</td>
								<td data-label='IP Address'>$ip_address</td>
								<td data-label='Nama Komputer'>$nama_komputer</td>
								<td data-label='Tanggal Akses'>$tgl_akses</td>
							</tr>";
						}
					} else {
						$cari=$_POST['cari_log'];
						$sql=mysqli_query($koneksi,"select * from log_ip_login where kode_petugas like '%$cari%' or ip_address_login like '%$cari%' or nama_komputer like '%$cari%'");
					if(mysqli_num_rows($sql) > 0) {
						while($row=mysqli_fetch_array($sql)) {
							$kodepetugas=$row['kode_petugas'];
							$ip_address=$row['ip_address_login'];
							$nama_komputer=$row['nama_komputer'];
							$tgl_akses=$row['tgl_akses'];
							$ambildatapetugas=mysqli_query($koneksi,"select * from tbl_petugas where kode_petugas='$kodepetugas'");
							$ambilpetugas=mysqli_fetch_array($ambildatapetugas);
							echo "<tr>
								<td data-label='Kode Petugas'>$ambilpetugas[nama_petugas]</td>
								<td data-label='IP Address'>$ip_address</td>
								<td data-label='Nama Komputer'>$nama_komputer</td>
								<td data-label='Tanggal Akses'>$tgl_akses</td>
							</tr>";
						}
					} else {
						echo "<tr>
							<td colspan='4'><h4>TIDAK DITEMUKAN DATA</td>
						</tr>";
					}
					}
				?>
				</table>
			</p>
			<p>&nbsp;</p>
			<p>&nbsp;</p>
		</div>
		<div class="modal fade" id="logout" role="dialog">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button class="close" data-dismiss="modal">&times;</button>
						<h2>Konfirmasi</h2>
					</div>
					<div class="modal-body">
						<p>Anda Yakin Keluar Aplikasi ?</p>
					</div>
					<div class="modal-footer">
						<a href="keluar.php"><button class="btn btn-danger">Ya</button></a>
						<button class="btn btn-default" data-dismiss="modal">Tidak</button>
					</div>
				</div>
			</div>
		</div>
	</article>
	<footer>
		<br><p align="center">Copyright&copy; <?php date_default_timezone_set('Asia/Jakarta'); echo date('Y'); ?> Deka M Wildan</p>
	</footer>
</body>
</html>