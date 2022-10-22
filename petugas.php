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
			<p>
				<?php
					if(!empty($_GET['simpan'])) {
						if($_GET['simpan'] == 'sukses') {
							echo "<div class='alert alert-success'>
							 <button class='close' data-dismiss='alert'>&times;</button>
							 <h3>Data petugas berhasil ditambahkan</h3>
							</div>";
						} elseif ($_GET['simpan'] == 'gagal') {
							echo "<div class='alert alert-danger'>
							 <button class='close' data-dismiss='alert'>&times;</button>
							 <h3>Gagal menambahkan petugas, mungkin kode sudah ada</h3>
							</div>";
						}
					}
				?>
			</p>
			<p>&nbsp;</p>
			<button class="btn btn-primary" data-toggle="modal" data-target="#tambah"><span class="glyphicon glyphicon-plus"></span> Tambah Data</button>
			<div class="modal fade" id="tambah" role="dialog">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<button class="close" data-dismiss="modal">&times;</button>
							<h4>Tambah Petugas</h4>
						</div>
						<div class="modal-body">
							<form method="post" action="simpan_petugas.php">
								<table width="90%" cellpadding="3" cellspacing="3" border="0">
									<tr>
										<td>Kode Petugas</td>
										<td>:</td>
										<td>
											<?php
											include "config/config.php";
											$sql=mysqli_query($koneksi,"select * from tbl_petugas");
											$jmlkode=mysqli_num_rows($sql)+1;
											$tgl_kode=date('m.Y');
											$kodepetugas="P-".$tgl_kode.".".$jmlkode;
											echo "<input name='kode_petugas' type='text' class='form-control' value='$kodepetugas' readonly='readonly'>";
											?>
										</td>
									</tr>
									<tr>
										<td>Nama Petugas</td>
										<td>:</td>
										<td><input type="text" name="nama_petugas" placeholder="Masukkan nama petugas..." class="form-control" required="required"></td>
									</tr>
									<tr>
										<td>Jenis Kelamin</td>
										<td>:</td>
										<td>
											<select name="jenis_kelamin" class="form-control">
												<option>Laki-Laki</option>
												<option>Perempuan</option>
											</select>
										</td>
									</tr>
									<tr>
										<td>Alamat</td>
										<td>:</td>
										<td><textarea name="alamat" cols="45" rows="7" class="form-control"></textarea></td>
									</tr>
									<tr>
										<td>No. HP</td>
										<td>:</td>
										<td><input type="text" name="no_hp" placeholder="Masukkan nomor HP..." class="form-control" required="required"></td>
									</tr>
									<tr>
										<td>Nama Pengguna</td>
										<td>:</td>
										<td><input type="text" name="username" placeholder="Masukkan nama pengguna..." class="form-control" required="required"></td>
									</tr>
									<tr>
										<td>Kata Sandi</td>
										<td>:</td>
										<td><input type="password" name="password" placeholder="Masukkan kata sandi..." class="form-control" required="required"></td>
									</tr>
									<tr>
										<td>Konfirmasi Kata Sandi</td>
										<td>:</td>
										<td><input type="password" name="confirm_password" placeholder="Masukkan konfirmasi kata sandi..." class="form-control" required="required"></td>
									</tr>
									<tr>
										<td></td>
										<td></td>
										<td><button class="btn btn-success"><span class="glyphicon glyphicon-floppy-disk"></span> Simpan Data</button></td>
									</tr>
								</table>
							</form>
						</div>
						<div class="modal-footer">
							
						</div>
					</div>
				</div>
			</div>
			<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
				Cari Petugas : <input type="text" name="cari_petugas" class="form-control" placeholder="Masukkan nama petugas...">
				<button class="btn btn-primary" name="cari_data"><span class="glyphicon glyphicon-search"></span> Cari</button>
			</form>
			<table width="100%" cellspacing="0" cellpadding="0" class="table table-bordered table-responsive table-hover table-striped table-condensed">
				<thead>
					<tr>
						<th>
							KODE PETUGAS
						</th>
						<th>
							NAMA PETUGAS
						</th>
						<th>
							JENIS KELAMIN
						</th>
						<th>
							ALAMAT
						</th>
						<th>
							NO. HP
						</th>
					</tr>
				</thead>
				<tbody>
				<?php
						include "config/config.php";
					if(!isset($_POST['cari_data'])) {
						$query=mysqli_query($koneksi,"select * from tbl_petugas");
						while($hasil=mysqli_fetch_array($query)) {
							$kode_petugas=$hasil['kode_petugas'];
							$nama_petugas=$hasil['nama_petugas'];
							$jenis_kelamin=$hasil['jenis_kelamin'];
							$alamat=$hasil['alamat'];
							$no_hp=$hasil['no_hp'];
							echo "<tr>
								<td data-label='Kode'>$kode_petugas</td>
								<td data-label='Nama'>$nama_petugas</td>
								<td data-label='Jenis'>$jenis_kelamin</td>
								<td data-label='Alamat'>$alamat</td>
								<td data-label='No. HP'>$no_hp</td>
							</tr>";
						}
					} else {
						$cari=$_POST['cari_petugas'];
						$query=mysqli_query($koneksi,"select * from tbl_petugas where kode_petugas like '%$cari%' or nama_petugas like '%$cari%'");
					if(mysqli_num_rows($query) > 0) {
						while($hasil=mysqli_fetch_array($query)) {
							$kode_petugas=$hasil['kode_petugas'];
							$nama_petugas=$hasil['nama_petugas'];
							$jenis_kelamin=$hasil['jenis_kelamin'];
							$alamat=$hasil['alamat'];
							$no_hp=$hasil['no_hp'];
							echo "<tr>
								<td data-label='Kode'>$kode_petugas</td>
								<td data-label='Nama'>$nama_petugas</td>
								<td data-label='Jenis'>$jenis_kelamin</td>
								<td data-label='Alamat'>$alamat</td>
								<td data-label='No. HP'>$no_hp</td>
							</tr>";
						}
					} else {
						echo "<tr>
							<td colspan='5'><h4 align='center'>DATA TIDAK DITEMUKAN</h4></td>
						</tr>";
					}
					}
				?>
				</tbody>
			</table>
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