<?php
session_start();
if(!empty($_SESSION['username'])) {
	header('location:index.php');
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Masuk Sistem Pemetaan Jaringan</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="refresh" content="30, login.php">
	<script type="text/javascript" src="bootstrap/js/tests/vendor/jquery.min.js"></script>
	<script type="text/javascript" src="bootstrap/dist/js/bootstrap.js"></script>
	<link rel="stylesheet" type="text/css" href="bootstrap/dist/css/desain-login.css">
	<link rel="stylesheet" type="text/css" href="bootstrap/dist/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="bootstrap/dist/css/bootstrap-theme.css">
	<link rel="stylesheet" href="leaflet-1.4/dist/leaflet.css" type="text/css" />
    <script src="leaflet-1.4/dist/leaflet.js" type="text/javascript"></script>
    <script type="text/javascript" src="leaflet-1.4/dist/Leaflet.LocationShare.js"></script>
</head>
<body onload="bukaInfo();getLocation();bukaGPS();">
	<div class="utama">
				<?php
				include "config/config.php";
					if(!empty($_GET['login'])) {
						if($_GET['login'] == 'kosong') {
							echo "<font color=red>Form masih ada yang kosong</font>";
						} else if($_GET['login'] == 'gagal') {
							echo "<font color=red>User Tidak Ditemukan</font>";
						}
					}
					
					if(@fsockopen("maps.google.com",80)) {
						$sqlip=mysqli_query($koneksi,"select * from access_point,tbl_pemetaan where access_point.no_alat=tbl_pemetaan.no_alat");
						while($rowip=mysqli_fetch_array($sqlip)) {
							$ip_ping=$rowip['ip_address'];
							$ping=shell_exec("ping $ip_ping -n 1");
						}
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
		if(!empty($cekmac)) {
			echo "L.marker([$koordinat]).addTo(alatpeta).addTo(mymap).bindPopup('<b>$no_alat $merk $serie</b><br>$ip<br>$mac<br><b>Koordinat</b><br>$koordinat<br><b>Status :<b> Aktif').openPopup();
            
			var latlngs = [";
    		$ambilkoordinat=mysqli_query($koneksi,"select koordinat from tbl_pemetaan");
    		while($lihatkoord=mysqli_fetch_array($ambilkoordinat)) {
    			$koordinat=$lihatkoord['koordinat'];
    			echo "[$koordinat],";
    		}
			echo "];
			var polyline = L.polyline(latlngs, {color: 'lightgreen'}).addTo(alatpeta).addTo(mymap);	";
		} else {
			echo "
		var MerahIcon = L.icon({
        iconUrl: 'http://".$_SERVER['HTTP_HOST']."/sistem-pemetaan-jaringan/leaflet-1.4/dist/images/marker-icon2.png',
        iconSize: [30, 40], // size of the icon
        });
			L.marker([$koordinat], {icon: MerahIcon}).addTo(alatpeta).addTo(mymap).bindPopup('<b>$no_alat $merk $serie</b><br>$ip<br>$mac<br><b>Koordinat</b><br>$koordinat<br><b>Status :<b> Mati<br>').openPopup();

			var latlngs = [";
    		$ambilkoordinat=mysqli_query($koneksi,"select koordinat from tbl_pemetaan");
    		while($lihatkoord=mysqli_fetch_array($ambilkoordinat)) {
    			$koordinat=$lihatkoord['koordinat'];
    			echo "[$koordinat],";
    		}
			echo "];
			var polyline = L.polyline(latlngs, {color: 'red'}).addTo(alatpeta).addTo(mymap); ";

			echo "
			function bukaInfo() {
				$('#terputus').modal('show');
			}";
		}
	}
       echo 'function onLocationFound(e) {
		var radius = e.accuracy / 2;

		L.marker(e.latlng).addTo(mymap)
			.bindPopup("Lokasi anda " + radius + " Meter dari Titik Pusat").openPopup();

		L.circle(e.latlng, radius).addTo(mymap);
	}

	function onLocationError(e) {
		alert(e.message);
	}';

	echo "
	var overlays = {
		'Peta Alat': alatpeta
	};
	L.control.layers(baseLayers, overlays).addTo(mymap);
	mymap.on('Lokasi ditemukan', onLocationFound);
	mymap.on('Lokasi tidak ditemukan', onLocationError);
	mymap.locate({setView: true, maxZoom: 21});";
echo "
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
						<thead>
							<tr>
								<td>No. alat</td>
								<td>Spesifikasi</td>
								<td>IP Address</td>
								<td>MAC Address</td>
								<td>Koordinat</td>
								<td>Status</td>
							</tr>
						</thead>';
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
								<td data-label="No. Alat">'.$rowcek['no_alat'].'</td>
								<td data-label="Spesifikasi">'.$rowcek['merk_access_point'].'&nbsp;'.$rowcek['serie_access_point'].'</td>
								<td data-label="IP Address">'.$rowcek['ip_address'].'</td>
								<td data-label="MAC Address">'.$rowcek['mac_address'].'</td>
								<td data-label="Koordinat">'.$rowcek['koordinat'].'</td>
								<td data-label="Status"><font color=red>Terputus</font></td>
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
} else {
						echo "<h3 align=center><font color=red>TIDAK TERHUBUNG KE INTERNET</font></h3>";
					}
	?>
	<script type="text/javascript">
		function getLocation() {
  			if (navigator.geolocation) {
    			break;
  			} else { 
    			function bukaGPS() {
    				$('#gps').modal('show');
    			}
  			}
		}
	</script>
	<div class="modal fade" id="gps" role="dialog">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button class="close" data-dismiss="modal">&times;</button>
					<h3>Info Lokasi GPS</h3>
				</div>
				<div class="modal-body">
					<h4>Maaf Lokasi GPS anda belum diaktifkan</h4>
				</div>
				<div class="modal-footer">
					&nbsp;
				</div>
			</div>
		</div>
	</div>
		<form method="post" action="cek-login.php">
			<table width="90%" cellpadding="0" cellspacing="0" border="0" align="center">
				<tr>
					<td align="center">
						<h2><font color=yellow>MASUK APLIKASI PEMETAAN JARINGAN</font></h2>
					</td>
				</tr>
				<tr>
					<td width="90%" align="center"><font color=yellow>Nama Pengguna :</font><input type="text" name="username" required="required" placeholder="Masukkan user..." class="masukan"></td>
				</tr>
				<tr>
					<td width="90%" align="center"><font color=yellow>Kata Sandi :</font><input type="password" name="password" required="required" placeholder="Masukkan password..." class="masukan"></td>
				</tr>
				<tr>
					<td width="90%" align="center"><button class="tombol">Masuk</button></td>
				</tr>
				<tr>
					<td>&nbsp;</td>
				</tr>
			</table>
		</form>
	</div>
</body>
</html>