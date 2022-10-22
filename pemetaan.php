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
	<meta http-equiv="refresh" content="60, pemetaan.php">
	<script type="text/javascript" src="bootstrap/js/tests/vendor/jquery.min.js"></script>
	<script type="text/javascript" src="bootstrap/jquery-mask/dist/jquery.mask.min.js"></script>
	<script type="text/javascript" src="bootstrap/dist/js/bootstrap.js"></script>
	<link rel="stylesheet" type="text/css" href="bootstrap/dist/css/layout.css">
	<link rel="stylesheet" type="text/css" href="bootstrap/dist/css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="bootstrap/dist/css/bootstrap-theme.css">
<link rel="stylesheet" href="leaflet-1.4/dist/leaflet.css" type="text/css" />
    <script src="leaflet-1.4/dist/leaflet.js" type="text/javascript"></script>
    	<script type="text/javascript" src="fontawesome/js/all.js"></script>
	<link rel="stylesheet" type="text/css" href="fontawesome/css/all.css">

</head>
<body onload="getLocation();bukaInfo();">
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
						echo '<div class="alert alert-success">
							<button class="close" data-dismiss="alert">&times;</button>
							<p>Data pemetaan berhasil ditambahkan</p>
						</div>';
					} elseif($_GET['simpan'] == 'gagal') {
						echo '<div class="alert alert-danger">
							<button class="close" data-dismiss="alert">&times;</button>
							<p>Gagal menambahkan data, mungkin sudah ada data</p>
						</div>';
					} elseif($_GET['simpan'] == 'kosong') {
						echo '<div class="alert alert-warning">
							<button class="close" data-dismiss="alert">&times;</button>
							<p>Pastikan web browser anda mengijinkan akses lokasi atau data alat sudah terisi</p>
						</div>';
					} elseif($_GET['simpan'] == 'koordinat') {
						echo '<div class="alert alert-warning">
							<button class="close" data-dismiss="alert">&times;</button>
							<p>Pastikan browser anda mendukung geolocation</p>
						</div>';
					}
				} elseif(!empty($_GET['hapus'])) {
					if($_GET['hapus'] == 'sukses') {
						echo '<div class="alert alert-success">
							<button class="close" data-dismiss="alert">&times;</button>
							<p>Data pemetaan berhasil dihapus</p>
						</div>';
					} elseif($_GET['hapus'] == 'gagal') {
						echo '<div class="alert alert-danger">
							<button class="close" data-dismiss="alert">&times;</button>
							<p>Gagal menghapus data pemetaan</p>
						</div>';
					} elseif($_GET['hapus'] == 'kosong') {
						echo '<div class="alert alert-warning">
							<button class="close" data-dismiss="alert">&times;</button>
							<p>Pastikan akses melalui halaman pemetaan</p>
						</div>';
					}
				} elseif(!empty($_GET['edit'])) {
					if($_GET['edit'] == 'sukses') {
						echo '<div class="alert alert-success">
							<button class="close" data-dismiss="alert">&times;</button>
							<p>Data pemetaan berhasil diperbarui</p>
						</div>';
					} elseif($_GET['edit'] == 'gagal') {
						echo '<div class="alert alert-danger">
							<button class="close" data-dismiss="alert">&times;</button>
							<p>Gagal memperbarui data pemetaan, mungkin alat sudah terpasang</p>
						</div>';
					} elseif($_GET['edit'] == 'kosong') {
						echo '<div class="alert alert-warning">
							<button class="close" data-dismiss="alert">&times;</button>
							<p>Pastikan koordinat dan alat tidak kosong</p>
						</div>';
					}
				}
			?>
				<button class="btn btn-primary" data-toggle="modal" data-target="#tambah-peta"><span class="glyphicon glyphicon-plus"></span> Tambah Pemetaan</button>
				<div class="modal fade" role="dialog" id="tambah-peta">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header">
								<button class="close" data-dismiss="modal">&times;</button>
								<h4>Tambah Data Pemetaan</h4>
							</div>
							<div class="modal-body">
								<form method="post" action="simpan_pemetaan.php">
									<table width="90%">
										<tr>
											<td>
												No. Pemetaan
											</td>
											<td>:</td>
											<td> 
												<?php
													include "config/config.php";
													$no_tgl_peta=date('Ymd');
													$ambiljumlah=mysqli_query($koneksi,"select * from tbl_pemetaan");
													if(mysqli_num_rows($ambiljumlah) > 0) {
														$hitungjml=mysqli_num_rows($ambiljumlah)+1;
														$no_peta="PT".$no_tgl_peta.$hitungjml;
														echo "<input type='text' name='no_pemetaan' readonly='readonly' required='required' value='$no_peta' class='form-control'>";
													} else {
														$no_peta="PT".$no_tgl_peta.'1';
														echo "<input type='text' name='no_pemetaan' readonly='readonly' required='required' value='$no_peta' class='form-control'>";
													}
												?>
											</td>
										</tr>
										<tr>
											<td>Tanggal Pemetaan</td>
											<td>:</td>
											<td>
												<input type="text" name="tgl_pemetaan" readonly="readonly" value="<?php date_default_timezone_set('Asia/Jakarta'); echo date('Y-m-d'); ?>" class="form-control">
											</td>
										</tr>
										<tr>
											<td>Koordinat</td>
											<td>:
											</td>
											<td>
												<input type="text" name="koordinat" id="koordinat" class="form-control" readonly="readonly">
											</td>
										</tr>
										<tr>
											<td>Petugas</td>
											<td>:</td>
											<td>
												<input type="text" name="user_petugas" required="required" readonly="readonly" value="<?php echo $_SESSION['username']; ?>" class="form-control">
											</td>
										</tr>
										<tr>
											<td>Alat Wifi</td>
											<td>:</td>
											<td>
												<select name='no_alat' class='form-control'>
												<?php
													$ambilalat=mysqli_query($koneksi,"select * from access_point,alat_wifi where access_point.no_alat=alat_wifi.no_alat");
													while($row=mysqli_fetch_array($ambilalat)) {
														$no_alat=$row['no_alat'];
														$merk=$row['merk_access_point'];
														$serie=$row['serie_access_point'];
														$mac=$row['mac_address'];
														$ip=$row['ip_address'];
														echo "
															<option>$no_alat $merk $serie $mac $ip</option>
														";
													}
												?>
												</select>
											</td>
										</tr>
										<tr>
											<td></td>
											<td></td>
											<td>
												<button class="btn btn-success"><span class="glyphicon glyphicon-floppy-disk"></span> Simpan Pemetaan</button>
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
			</p>
			<p>
				<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>?tombol=nonaktif">
					<button class="btn btn-warning btn-lg" name="btnNonaktif" id="btnNonaktif"><span class="glyphicon glyphicon-ban-circle"></span> Nonaktifkan Jaringan</button>
				</form>
				<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>?tombol=aktif">
					<button class="btn btn-success btn-lg" name="btnAktif" id="btnAktif"><span class="glyphicon glyphicon-ok-circle"></span> Aktifkan Jaringan</button>
				</form>
				<?php
					if(!empty($_GET['tombol'])) {
						if($_GET['tombol'] == 'nonaktif') {
							if(isset($_POST['btnNonaktif'])) {
								system('netsh interface set interface "Wi-Fi" disable');
								system('netsh interface set interface "Ethernet" disable');
								system('netsh interface set interface "Local Area Connection" disable');
								echo "<script>
									$(document).ready(function() {
										$('#nonaktifkan').modal('show');
									});
								</script>";
							}
						} else if($_GET['tombol'] == 'aktif') {
							if(isset($_POST['btnAktif'])) {
								system('netsh interface set interface "Wi-Fi" enable');
								system('netsh interface set interface "Ethernet" enable');
								system('netsh interface set interface "Local Area Connection" enable');
								echo "<script>
									$(document).ready(function() {
										$('#aktifkan').modal('show');
									});
								</script>";
							}
						}
					}
				?>
				<div class="modal fade" id="nonaktifkan" role="dialog">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header">
								<button class="close" data-dismiss="modal">&times;</button>
								<h3>Informasi Jaringan</h3>
							</div>
							<div class="modal-body">
								<h4>Perangkat jaringan komputer telah dinonaktifkan</h4>
								<h4>Silahkan Aktifkan kembali</h4>
							</div>
							<div class="modal-footer">
								<button class="btn btn-default" data-dismiss="modal">Tutup</button>
							</div>
						</div>
					</div>
				</div>
				<div class="modal fade" id="aktifkan" role="dialog">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header">
								<button class="close" data-dismiss="modal">&times;</button>
								<h3>Informasi Jaringan</h3>
							</div>
							<div class="modal-body">
								<h4>Perangkat jaringan komputer telah diaktifkan</h4>
							</div>
							<div class="modal-footer">
								<button class="btn btn-default" data-dismiss="modal">Tutup</button>
							</div>
						</div>
					</div>
				</div>
				<?php
					
					if(@fsockopen("maps.google.com",80)) {
	echo '<div id="mapid" style="width: 100%; height: 70vh;"></div>';
	echo "<script>

	var mymap = L.map('mapid').fitWorld().setView(
	[";
	$sqlambilkoordinat=mysqli_query($koneksi,"select koordinat from tbl_pemetaan order by tgl_pemetaan asc limit 1");
	while($hasilkoordinat=mysqli_fetch_array($sqlambilkoordinat)) {
		echo $hasilkoordinat['koordinat'];
	}
	echo "], 17);
	var googleSat = L.tileLayer('http://{s}.google.com/vt/lyrs=s,h&x={x}&y={y}&z={z}',{
    minZoom: 15,
    maxZoom: 21,
    subdomains:['mt0','mt1','mt2','mt3']
}).addTo(mymap);
var googleMap = L.tileLayer('http://{s}.google.com/vt/lyrs=r&x={x}&y={y}&z={z}',{
    minZoom: 15,
    maxZoom: 25,
    subdomains:['mt0','mt1','mt2','mt3']
});
var baseLayers = {
	'Satelit': googleSat,
	'Jalan': googleMap
};
var alatpeta = L.layerGroup();
 mymap.attributionControl.setPrefix('');";
	$sqlpeta=mysqli_query($koneksi,"select * from access_point,tbl_pemetaan where access_point.no_alat=tbl_pemetaan.no_alat");
	while($hasilpeta=mysqli_fetch_array($sqlpeta)) {
		$nopeta=$hasilpeta['no_pemetaan'];
		$no_alat=$hasilpeta['no_alat'];
		$merk=$hasilpeta['merk_access_point'];
		$serie=$hasilpeta['serie_access_point'];
		$mac=$hasilpeta['mac_address'];
		$ip=$hasilpeta['ip_address'];
		$koordinat=$hasilpeta['koordinat'];
		$cek=exec("arp -a $ip");
		$ambilmac=strtolower($mac);
		$cekmac=strpos($cek, $ambilmac);
		$ping=shell_exec("ping $ip -n 1");
		if(!empty($cekmac)) {
			echo "L.marker([$koordinat]).addTo(alatpeta).addTo(mymap).bindPopup('<b>$no_alat $merk $serie</b><br>$ip<br>$mac<br><b>Koordinat</b><br>$koordinat<br><b>Status :<b> Aktif<br><button class=btn-primary onclick=bukaModal$nopeta();>Edit</button> <button class=btn-danger onclick=getConfirmation$nopeta();>Hapus</button>').openPopup();
            
			var latlngs = [";
    		$ambilkoordinat=mysqli_query($koneksi,"select koordinat from tbl_pemetaan");
    		while($lihatkoord=mysqli_fetch_array($ambilkoordinat)) {
    			$koordinat=$lihatkoord['koordinat'];
    			echo "[$koordinat],";
    		}
			echo "];
			var polyline = L.polyline(latlngs, {color: 'lightgreen'}).addTo(alatpeta).addTo(mymap);

            function getConfirmation$nopeta() {
               $('#hapuspeta$nopeta').modal('show');
            }
			function bukaModal$nopeta() {
				$('#editpeta$nopeta').modal('show');
			}
			";
		} else {
			echo "
		var MerahIcon = L.icon({
        iconUrl: 'http://".$_SERVER['HTTP_HOST']."/sistem-pemetaan-jaringan/leaflet-1.4/dist/images/marker-icon2.png',
        iconSize: [26, 40], // size of the icon
        });
			L.marker([$koordinat], {icon: MerahIcon}).addTo(alatpeta).addTo(mymap).bindPopup('<b>$no_alat $merk $serie</b><br>$ip<br>$mac<br><b>Koordinat</b><br>$koordinat<br><b>Status :<b> Mati<br><button class=btn-primary onclick=bukaModal$nopeta();>Edit</button> <button class=btn-danger onclick=getConfirmation$nopeta();>Hapus</button>').openPopup();

			var latlngs = [";
    		$ambilkoordinat=mysqli_query($koneksi,"select koordinat from tbl_pemetaan");
    		while($lihatkoord=mysqli_fetch_array($ambilkoordinat)) {
    			$koordinat=$lihatkoord['koordinat'];
    			echo "[$koordinat],";
    		}
			echo "];
			var polyline = L.polyline(latlngs, {color: 'red'}).addTo(alatpeta).addTo(mymap);
			var overlays = {
				'Peta Alat': alatpeta
			};

            function getConfirmation$nopeta() {
               $('#hapuspeta$nopeta').modal('show');
            }

			function bukaModal$nopeta() {
				$('#editpeta$nopeta').modal('show');
			}
			function bukaInfo() {
				$('#terputus').modal('show');
			}
			";
		}
	}
echo '
function onLocationFound(e) {
		var radius = e.accuracy / 2;

		L.marker(e.latlng).addTo(mymap)
			.bindPopup("Lokasi anda " + radius + " Meter dari Titik Pusat").openPopup();

		L.circle(e.latlng, radius).addTo(mymap);
	}

	function onLocationError(e) {
		alert(e.message);
	}';
echo "
L.control.layers(baseLayers, overlays).addTo(mymap);
</script>";
$ambildata=mysqli_query($koneksi,"select * from access_point,tbl_pemetaan where access_point.no_alat=tbl_pemetaan.no_alat");
while($pilihdata=mysqli_fetch_array($ambildata)) {
	$noalat=$pilihdata['no_alat'];
	$merk2=$pilihdata['merk_access_point'];
	$serie2=$pilihdata['serie_access_point'];
	$ip2=$pilihdata['ip_address'];
	$mac2=$pilihdata['mac_address'];
	$koordinat2=$pilihdata['koordinat'];
	$cek2=exec("arp -a $ip2");
	$ambilmac2=strtolower($mac2);
	$cekmac2=strpos($cek2, $ambilmac2);
	if(!empty($cekmac2)) {
		echo '';
	} else {
	$simpansms=mysqli_query($koneksi, "insert into outbox (DestinationNumber,TextDecoded,CreatorID) values('085225539836','Alat dengan nomor $noalat Merk $merk2 $serie2 Alamat IP $ip2 MAC Address $mac2 dan koordinat $koordinat2 Terputus','Admin')");
	}
}
echo '<div class="modal fade" id="terputus" role="dialog">
		<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button class="close" data-dismiss="modal">&times;</button>
						<h2>Informasi Alat Terputus</h2>
					</div>
					<div class="modal-body">
						<table width="100%" cellpadding="0" cellspacing="0" class="table table-bordered table-hover table-striped table-condensed">
							<tr>
								<td>No. alat</td>
								<td>Spesifikasi</td>
								<td>IP Address</td>
								<td>MAC Address</td>
								<td>Koordinat</td>
								<td>Status</td>
							</tr>';
$ambildata2=mysqli_query($koneksi,"select * from access_point,tbl_pemetaan where access_point.no_alat=tbl_pemetaan.no_alat");
while($rowcek=mysqli_fetch_array($ambildata2)) {
	$nopeta3=$rowcek['no_pemetaan'];
	$no_alat3=$rowcek['no_alat'];
	$merk3=$rowcek['merk_access_point'];
	$serie3=$rowcek['serie_access_point'];
	$mac3=$rowcek['mac_address'];
	$ip3=$rowcek['ip_address'];
	$koordinat3=$rowcek['koordinat'];
	$cek3=exec("arp -a $ip3");
	$ambilmac3=strtolower($mac3);
	$cekmac3=strpos($cek3, $ambilmac3);
	if(!empty($cekmac3)) {
		echo '';
	} else {
		echo '<tr>
								<td>'.$rowcek['no_alat'].'</td>
								<td>'.$rowcek['merk_access_point'].'&nbsp;'.$rowcek['serie_access_point'].'</td>
								<td>'.$rowcek['ip_address'].'</td>
								<td>'.$rowcek['mac_address'].'</td>
								<td>'.$rowcek['koordinat'].'</td>
								<td><font color=red>Terputus</font></td>
								</tr>
								';
	}
}
echo '</table>
					</div>
					<div class="modal-footer">
						&nbsp;
					</div>
				</div>
			</div>
		</div>';
$sqlpemetaan=mysqli_query($koneksi,"select * from access_point,tbl_pemetaan where access_point.no_alat=tbl_pemetaan.no_alat");
while($rowpemetaan=mysqli_fetch_array($sqlpemetaan)) {
	$nopemetaan=$rowpemetaan['no_pemetaan'];
	$noalat=$rowpemetaan['no_alat'];
	$koord=$rowpemetaan['koordinat'];
echo '<div class="modal fade" id="editpeta'.$nopemetaan.'" role="dialog">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button class="close" data-dismiss="modal">&times;</button>
						<h2>Edit Data Nomor '.$nopemetaan.' Alat '.$noalat.'</h2>
					</div>
					<div class="modal-body">
						<form method="post" action="update-peta.php">
							<table width="90%" cellpadding="0" cellspacing="0" border="0">
								<tr>
									<td>No. Pemetaan</td>
									<td>:</td>
									<td><input type="text" name="no_pemetaan" readonly="readonly" required="required" value="'.$nopemetaan.'" class="form-control"></td>
								</tr>
								<tr>
									<td>Tanggal Perubahan</td>
									<td>:</td>
									<td><input type="text" name="tgl_pemetaan" readonly="readonly" required="required" value="'.date('Y-m-d').'" class="form-control"></td>
								</tr>
								<tr>
											<td>Koordinat</td>
											<td>:
											</td>
											<td>
												<select name="koordinat" class="form-control">
													<option id="posisilokasi'.$nopemetaan.'"></option>
													<option>'.$koord.'</option>
												</select>
											</td>
										</tr>
										<tr>
											<td>Petugas</td>
											<td>:</td>
											<td>
												<input type="text" name="user_petugas" required="required" readonly="readonly" value="'.$_SESSION['username'].'" class="form-control">
											</td>
										</tr>
										<tr>
											<td>Alat Wifi</td>
											<td>:</td>
											<td>';
												$pilihalat=mysqli_query($koneksi,"select * from access_point where no_alat='$noalat'");
												$seleksialat=mysqli_fetch_array($pilihalat);
												echo '<input type="text" name="no_alat" class="form-control" value="'.$seleksialat['no_alat'].' '.$seleksialat['merk_access_point'].' '.$seleksialat['serie_access_point'].' '.$seleksialat['mac_address'].' '.$seleksialat['ip_address'].'" readonly="readonly" required="required">';
												
												echo '</select>
											</td>
										</tr>
										<tr>
											<td></td>
											<td></td>
											<td>
												<button class="btn btn-success"><span class="glyphicon glyphicon-floppy-disk"></span> Edit Pemetaan</button>
											</td>
										</tr>
							</table>
						</form>
					</div>
					<div class="modal-footer">
						<p><button class="btn btn-primary" onclick="ambilLokasi'.$nopemetaan.'()"><span class="glyphicon glyphicon-search"></span> Cek Koordinat Terkini</button></p>
	<script>
	function ambilLokasi'.$nopemetaan.'() {
	if(navigator.geolocation) {
		navigator.geolocation.getCurrentPosition(posisi'.$nopemetaan.');
	} else {
		document.getElementById("posisilokasi'.$nopemetaan.'").innerHTML="Geolocation Tidak Didukung";
	}
}

function posisi'.$nopemetaan.'(pos'.$nopemetaan.') {
	document.getElementById("posisilokasi'.$nopemetaan.'").innerHTML=pos'.$nopemetaan.'.coords.latitude +", "+pos'.$nopemetaan.'.coords.longitude;
}
</script>
					</div>
				</div>
			</div>
		</div>
		<div class="modal fade" id="hapuspeta'.$nopemetaan.'" role="dialog">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button class="close" data-dismiss="modal">&times;</button>
						<h2>Hapus Data Nomor '.$nopemetaan.' Alat '.$noalat.'</h2>
					</div>
					<div class="modal-body">
						<h3>Anda yakin ingin menghapus data ini ?</h3>
					</div>
					<div class="modal-footer">
						<a href="hapus-peta.php?id='.$nopemetaan.'"><button class="btn btn-danger">Ya</button></a> <button class="btn btn-default" data-dismiss="modal">Tidak</button>
					</div>
				</div>
			</div>
		</div>';
}
					} else {
						echo "<h3 align=center><font color=red>TIDAK TERHUBUNG KE INTERNET</font></h3>";
					}
				?>
			</p>
				
			</div>
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
		<script>
var x = document.getElementById("koordinat");

function getLocation() {
  if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(showPosition);
  } else { 
    x.value = "Geolocation Tidak Di dukung di Browser Anda.";
  }
}

function showPosition(position) {
  x.value = position.coords.latitude + 
  ", " + position.coords.longitude;
}
</script>
	</article>
	<footer>
		<br><p align="center">Copyright&copy; <?php date_default_timezone_set('Asia/Jakarta'); echo date('Y'); ?> Deka M Wildan</p>
	</footer>
</body>
</html>