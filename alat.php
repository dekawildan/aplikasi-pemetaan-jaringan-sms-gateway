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
	<script type="text/javascript" src="bootstrap/jquery-mask/dist/jquery.mask.min.js"></script>
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
			<p>
				<?php
				if(!empty($_GET['simpan'])) {
					if($_GET['simpan'] == 'success') {
						echo '<div class="alert alert-success">
							<button class="close" data-dismiss="alert">&times;</button>
							<h4>Data berhasil ditambahkan</h4>
						</div>';
					} elseif($_GET['simpan'] == 'gagal') {
						echo '<div class="alert alert-danger">
							<button class="close" data-dismiss="alert">&times;</button>
							<h4>Gagal menambahkan data, mungkin sudah ada data</h4>
						</div>';
					}
				} elseif (!empty($_GET['edit'])) {
					if($_GET['edit'] == 'success') {
						echo '<div class="alert alert-success">
							<button class="close" data-dismiss="alert">&times;</button>
							<h4>Data berhasil diperbarui</h4>
						</div>';
					} elseif ($_GET['edit'] == 'gagal') {
						echo '<div class="alert alert-danger">
							<button class="close" data-dismiss="alert">&times;</button>
							<h4>Gagal mengedit data</h4>
						</div>';
					}
				} elseif(!empty($_GET['hapus'])) {
					if($_GET['hapus'] == 'success') {
						echo '<div class="alert alert-success">
							<button class="close" data-dismiss="alert">&times;</button>
							<h4>Data berhasil dihapus</h4>
						</div>';
					} elseif ($_GET['hapus'] == 'gagal') {
						echo '<div class="alert alert-danger">
							<button class="close" data-dismiss="alert">&times;</button>
							<h4>Gagal menghapus</h4>
						</div>';
					}
				}
			?>
			</p>
			<button class="btn btn-primary" data-toggle="modal" data-target="#tambah"><span class="glyphicon glyphicon-plus"></span>Tambah Data</button>
			<div class="modal fade" id="tambah" role="dialog">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<button class="close" data-dismiss="modal">&times;</button>
							<h3>Tambah Access Point</h3>
						</div>
						<div class="modal-body">
							<form method="post" action="simpan_alat.php">
								<table width="90%" cellpadding="4" cellspacing="4" border="0">
									<tr>
										<td>No. Alat</td>
										<td>:</td>
										<td>
											<?php 
												include "config/config.php"; 
												$query=mysqli_query($koneksi, "select * from access_point"); 
												$jml=mysqli_num_rows($query)+1;
												if($jml>0) {
													$hitungdata=mysqli_query($koneksi,"select * from access_point where exists(select 1 from access_point)");
													if(mysqli_num_rows($hitungdata) > 0) {
														$jml2=mysqli_num_rows($query)+2;
														$no="AP-0".$jml2;
														echo "<input type='text' name='no_alat' class='form-control' value='$no' readonly='readonly'>";
													} else {
														$no="AP-0".$jml;
														echo "<input type='text' name='no_alat' class='form-control' value='$no' readonly='readonly'>";
													}
												} else {
													$no="AP-01";
													echo "<input type='text' name='no_alat' class='form-control' value='$no' readonly='readonly'>";
												}
											?>
										</td>
									</tr>
									<tr>
										<td>Merk Alat</td>
										<td>:</td>
										<td>
											<input type="text" name="merk_access_point" class="form-control" placeholder="Ketikkan merk alat..." required="required">
										</td>
									</tr>
									<tr>
										<td>Serie Alat</td>
										<td>:</td>
										<td>
											<input type="text" name="serie_access_point" class="form-control" placeholder="Ketikkan serie alat..." required="required">
										</td>
									</tr>
									<tr>
										<td>Tipe Wireless</td>
										<td>:</td>
										<td>
											<select name="tipe_wireless" class="form-control">
												<option>B/G</option>
												<option>B/G/N</option>
											</select>
										</td>
									</tr>
									<tr>
										<td>MAC Address</td>
										<td>:</td>
										<td>
											<input type="text" name="mac_address" class="form-control" id="mac" placeholder="Contoh : BD-6G-58-AF-4G-EB" required="required" maxlength="17"> Contoh : BD-6G-58-AF-4G-EB
										</td>
									</tr>
									<tr>
										<td>IP Address</td>
										<td>:</td>
										<td>
											<input type="text" name="ip_address" class="form-control" placeholder="Ketikkan IP Address alat..." required="required" maxlength="15" value="   .   .   .   ">Contoh : 192.168.1.1
										</td>
									</tr>
									<tr>
										<td></td>
										<td></td>
										<td>
											<button class="btn btn-success"><span class="glyphicon glyphicon-floppy-disk"></span> Simpan Data</button>
											<script type="text/javascript">
												$(document).ready(function() {
													$('#mac').mask('AA-AA-AA-AA-AA-AA', {reverse: true});
												});
											</script>
										</td>
									</tr>
								</table>
							</form>
						</div>
						<div class="modal-footer">
							&nbsp;
						</div>
					</div>
				</div>
			</div>
			<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
				Cari Perangkat : <input type="text" name="cari_alat" class="form-control" placeholder="Masukkan Merk Access Point atau Serie Access Point...">
				<button class="btn btn-primary" name="cari_data"><span class="glyphicon glyphicon-search"></span> Cari Data</button>
			</form>
			<table width="100%" cellpadding="0" cellspacing="0" class="table table-bordered table-hover table-striped table-responsive table-condensed">
				<thead>
					<tr>
						<td>
							No. Alat
						</td>
						<td>
							Merk Alat
						</td>
						<td>
							Serie Alat
						</td>
						<td>
							Tipe Wireless
						</td>
						<td>
							MAC Address
						</td>
						<td>
							IP Address
						</td>
						<td>
							AKSI
						</td>
					</tr>
				</thead>
				<tbody>
			<?php
				include "config/config.php";
			if(!isset($_POST['cari_data'])) {
				$sql=mysqli_query($koneksi,"select * from access_point");
				while($hasil=mysqli_fetch_array($sql)) {
					$no_alat=$hasil['no_alat'];
					$merk=$hasil['merk_access_point'];
					$serie=$hasil['serie_access_point'];
					$tipe=$hasil['tipe_wireless'];
					$mac=$hasil['mac_address'];
					$ip=$hasil['ip_address'];
					echo "<tr>
						<td data-label='No. Alat'>$no_alat</td>
						<td data-label='Merk'>$merk</td>
						<td data-label='Serie'>$serie</td>
						<td data-label='Tipe Wireless'>$tipe</td>
						<td data-label='MAC Address'>$mac</td>
						<td data-label='IP Address'>$ip</td>
						<td align='center'>
						<button class='btn btn-info' data-toggle='modal' data-target='#editalat_$no_alat'><span class='glyphicon glyphicon-pencil'></span> Edit Data</button>
						<div class='modal fade' id='editalat_$no_alat' role='dialog'>
							<div class='modal-dialog'>
								<div class='modal-content'>
									<div class='modal-header'>
										<button class='close' data-dismiss='modal'>&times;</button>
										<h3>Edit Data Alat Wifi</h3>
									</div>
									<div class='modal-body'>
										<form method='post' action='update_alat.php'>
											<table width='90%' cellspacing='3' cellpadding='3'>
												<tr>
													<td>No. alat</td>
													<td>:</td>
													<td>
													<input name='no_alat' type='text' class='form-control' value='$no_alat' readonly='readonly'>
													</td>
												</tr>
												<tr>
													<td>Merk Alat</td>
													<td>:</td>
													<td>
													<input name='merk_access_point' type='text' class='form-control' value='$merk' required='required'>
													</td>
												</tr>
												<tr>
													<td>Serie Alat</td>
													<td>:</td>
													<td>
													<input name='serie_access_point' type='text' class='form-control' value='$serie' required='required'>
													</td>
												</tr>
												<tr>
													<td>Tipe Wireless</td>
													<td>:</td>
													<td>
													<select name='tipe_wireless' class='form-control'>
														<option selected>$tipe</option>
														<option>B/G</option>
														<option>B/G/N</option>
													</select>
													</td>
												</tr>
												<tr>
													<td>MAC Address</td>
													<td>:</td>
													<td>
													<input name='mac_address' type='text' class='form-control' value='$mac' required='required'>
													</td>
												</tr>
												<tr>
													<td>IP Address</td>
													<td>:</td>
													<td>
													<input name='ip_address' type='text' class='form-control' value='$ip' required='required'>
													</td>
												</tr>
												<tr>
													<td></td>
													<td></td>
													<td>
													<button class='btn btn-success'><span class='glyphicon glyphicon-floppy-disk'></span> Update Data</button>
													</td>
												</tr>
											</table>
										</form>
									</div>
									<div class='modal-footer'>
										&nbsp;
									</div>
								</div>
							</div>
						</div>
						<button class='btn btn-danger' data-toggle='modal' data-target='#hapusalat_$no_alat'><span class='glyphicon glyphicon-trash'></span> Hapus</button>
						<div class='modal fade' id='hapusalat_$no_alat' role='dialog'>
							<div class='modal-dialog'>
								<div class='modal-content'>
									<div class='modal-header'>
										<button class='close' data-dismiss='modal'>&times;</button>
										<h3>Konfirmasi Hapus Alat $no_alat</h3>
									</div>
									<div class='modal-body'>
										<p align='left'>Anda yakin ingin menghapus alat $no_alat ?</p>
									</div>
									<div class='modal-footer'>
										<a href='hapus_alat.php?id=$no_alat'><button class='btn btn-danger'>Ya</button></a>
										<button class='btn btn-default' data-dismiss='modal'>Tidak</button>
									</div>
								</div>
							</div>
						</div>
						</td>
					</tr>
					";
				}
			} else {
					$cari_alat=$_POST['cari_alat'];
					$sql=mysqli_query($koneksi, "select * from access_point where merk_access_point LIKE '%$cari_alat%' OR serie_access_point LIKE '%$cari_alat%'");
				if(mysqli_num_rows($sql) > 0) {
					while($hasil=mysqli_fetch_array($sql)) {
					$no_alat=$hasil['no_alat'];
					$merk=$hasil['merk_access_point'];
					$serie=$hasil['serie_access_point'];
					$tipe=$hasil['tipe_wireless'];
					$mac=$hasil['mac_address'];
					$ip=$hasil['ip_address'];
					echo "<tr>
						<td data-label='No. Alat'>$no_alat</td>
						<td data-label='Merk'>$merk</td>
						<td data-label='Serie'>$serie</td>
						<td data-label='Tipe Wireless'>$tipe</td>
						<td data-label='MAC Address'>$mac</td>
						<td data-label='IP Address'>$ip</td>
						<td align='center'>
						<button class='btn btn-info' data-toggle='modal' data-target='#editalat_$no_alat'><span class='glyphicon glyphicon-pencil'></span> Edit Data</button>
						<div class='modal fade' id='editalat_$no_alat' role='dialog'>
							<div class='modal-dialog'>
								<div class='modal-content'>
									<div class='modal-header'>
										<button class='close' data-dismiss='modal'>&times;</button>
										<h3>Edit Data Alat Wifi</h3>
									</div>
									<div class='modal-body'>
										<form method='post' action='update_alat.php'>
											<table width='90%' cellspacing='3' cellpadding='3'>
												<tr>
													<td>No. alat</td>
													<td>:</td>
													<td>
													<input name='no_alat' type='text' class='form-control' value='$no_alat' readonly='readonly'>
													</td>
												</tr>
												<tr>
													<td>Merk Alat</td>
													<td>:</td>
													<td>
													<input name='merk_access_point' type='text' class='form-control' value='$merk' required='required'>
													</td>
												</tr>
												<tr>
													<td>Serie Alat</td>
													<td>:</td>
													<td>
													<input name='serie_access_point' type='text' class='form-control' value='$serie' required='required'>
													</td>
												</tr>
												<tr>
													<td>Tipe Wireless</td>
													<td>:</td>
													<td>
													<select name='tipe_wireless' class='form-control'>
														<option selected>$tipe</option>
														<option>B/G</option>
														<option>B/G/N</option>
													</select>
													</td>
												</tr>
												<tr>
													<td>MAC Address</td>
													<td>:</td>
													<td>
													<input name='mac_address' type='text' class='form-control' value='$mac' required='required'>
													</td>
												</tr>
												<tr>
													<td>IP Address</td>
													<td>:</td>
													<td>
													<input name='ip_address' type='text' class='form-control' value='$ip' required='required'>
													</td>
												</tr>
												<tr>
													<td></td>
													<td></td>
													<td>
													<button class='btn btn-success'><span class='glyphicon glyphicon-floppy-disk'></span> Update Data</button>
													</td>
												</tr>
											</table>
										</form>
									</div>
									<div class='modal-footer'>
										&nbsp;
									</div>
								</div>
							</div>
						</div>
						<button class='btn btn-danger' data-toggle='modal' data-target='#hapusalat_$no_alat'><span class='glyphicon glyphicon-trash'></span> Hapus</button>
						<div class='modal fade' id='hapusalat_$no_alat' role='dialog'>
							<div class='modal-dialog'>
								<div class='modal-content'>
									<div class='modal-header'>
										<button class='close' data-dismiss='modal'>&times;</button>
										<h3>Konfirmasi Hapus Alat $no_alat</h3>
									</div>
									<div class='modal-body'>
										<p align='left'>Anda yakin ingin menghapus alat $no_alat ?</p>
									</div>
									<div class='modal-footer'>
										<a href='hapus_alat.php?id=$no_alat'><button class='btn btn-danger'>Ya</button></a>
										<button class='btn btn-default' data-dismiss='modal'>Tidak</button>
									</div>
								</div>
							</div>
						</div>
						</td>
					</tr>
					";
				}
			} else {
				echo "<tr>
				<td colspan='7' align='center'><h4>TIDAK DITEMUKAN DATA</td>
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