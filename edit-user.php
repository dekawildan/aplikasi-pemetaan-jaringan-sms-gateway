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
					if(!empty($_GET['edit'])) {
						if($_GET['edit'] == 'sukses') {
							echo "<div class='alert alert-success'>
							 <button class='close' data-dismiss='alert'>&times;</button>
							 <p>Data petugas berhasil diperbarui</p>
							</div>";
						} elseif ($_GET['edit'] == 'gagal') {
							echo "<div class='alert alert-danger'>
							 <button class='close' data-dismiss='alert'>&times;</button>
							 <p>Gagal mengedit petugas, pastikan data sudah benar</p>
							</div>";
						}
					}
					include "config/config.php";
					$user_aktif=$_SESSION['username'];
					if(!empty($_GET['user'])) {
						if($_GET['user'] == $user_aktif) {
							$ambiluser=mysqli_query($koneksi,"select * from tbl_petugas,tbl_login where tbl_petugas.kode_petugas=tbl_login.kode_petugas and tbl_login.username='$user_aktif'");
							while($row=mysqli_fetch_array($ambiluser)) {
								$kode_petugas=$row['kode_petugas'];
								$nama_petugas=$row['nama_petugas'];
								$jenis_kelamin=$row['jenis_kelamin'];
								$alamat=$row['alamat'];
								$no_hp=$row['no_hp'];
								$password=$row['password'];
								?>
								<form method="post" action="update_petugas.php">
								<table width="90%" cellpadding="3" cellspacing="3" border="0">
									<tr>
										<td>Kode Petugas</td>
										<td>:</td>
										<td>
											<input name="kode_petugas" type="text" class="form-control" value="<?php echo $kode_petugas; ?>" readonly="readonly">
										</td>
									</tr>
									<tr>
										<td>Nama Petugas</td>
										<td>:</td>
										<td><input type="text" name="nama_petugas" placeholder="Masukkan nama petugas..." class="form-control" required="required" value="<?php echo $nama_petugas; ?>"></td>
									</tr>
									<tr>
										<td>Jenis Kelamin</td>
										<td>:</td>
										<td>
											<select name="jenis_kelamin" class="form-control">
												<option selected="<?php echo $jenis_kelamin; ?>"><?php echo $jenis_kelamin; ?></option>
												<option>Laki-Laki</option>
												<option>Perempuan</option>
											</select>
										</td>
									</tr>
									<tr>
										<td>Alamat</td>
										<td>:</td>
										<td><textarea name="alamat" cols="45" rows="7" class="form-control"><?php echo $alamat; ?></textarea></td>
									</tr>
									<tr>
										<td>No. HP</td>
										<td>:</td>
										<td><input type="text" name="no_hp" placeholder="Masukkan nomor HP..." class="form-control" required="required" value="<?php echo $no_hp; ?>"></td>
									</tr>
									<tr>
										<td>Nama Pengguna</td>
										<td>:</td>
										<td><input type="text" name="username" placeholder="Masukkan nama pengguna..." class="form-control" required="required" value="<?php echo $user_aktif; ?>" readonly="readonly"></td>
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
										<td><button class="btn btn-success"><span class="glyphicon glyphicon-floppy-disk"></span> Perbarui Data</button></td>
									</tr>
								</table>
							</form>
							<?php
							}
						}
					}
				?>
			&nbsp;</p>
		</div>
		<br>
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
		<p>&nbsp;</p>
	</article>
	<footer>
		<br><p align="center">Copyright&copy; <?php date_default_timezone_set('Asia/Jakarta'); echo date('Y'); ?> Deka M Wildan</p>
	</footer>
</body>
</html>