<?php
include "cek-sesi.php";
if(empty($_POST['no_alat']) || empty($_POST['merk_access_point']) || empty($_POST['serie_access_point']) || empty($_POST['tipe_wireless']) || empty($_POST['mac_address']) || empty($_POST['ip_address'])) {
	header('location:alat.php');
} else {
	include "config/config.php";
	$no_alat=$_POST['no_alat'];
	$merk_access_point=$_POST['merk_access_point'];
	$serie_access_point=$_POST['serie_access_point'];
	$tipe_wireless=$_POST['tipe_wireless'];
	$mac_address=$_POST['mac_address'];
	$ip_address=$_POST['ip_address'];
	if(mysqli_query($koneksi, "insert into access_point values('$no_alat','$merk_access_point','$serie_access_point','$tipe_wireless','$mac_address','$ip_address')")) {
		header('location:alat.php?simpan=success');
	} else {
		header('location:alat.php?simpan=gagal');
	}
}
?>