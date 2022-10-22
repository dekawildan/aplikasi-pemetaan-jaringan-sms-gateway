<?php
include "cek-sesi.php";
if(empty($_POST['kode_petugas']) || empty($_POST['nama_petugas']) || empty($_POST['alamat']) || empty($_POST['no_hp']) || empty($_POST['username']) || empty($_POST['password'])) {
	header('location:petugas.php');
} else {
	include "config/config.php";
	$kode_petugas=$_POST['kode_petugas'];
	$nama_petugas=$_POST['nama_petugas'];
	$jenis_kelamin=$_POST['jenis_kelamin'];
	$alamat=$_POST['alamat'];
	$no_hp=$_POST['no_hp'];
	$username=$_POST['username'];
	$password=$_POST['password'];
	$confirm_password=$_POST['confirm_password'];
	if($password != $confirm_password) {
		header('location:petugas.php?password=tidak_sama');
	} else {
		$sqlsimpan1="update tbl_petugas set nama_petugas='$nama_petugas', jenis_kelamin='$jenis_kelamin', alamat='$alamat', no_hp='$no_hp' where kode_petugas='$kode_petugas'";
		$sqlsimpan2="update tbl_login set password='$password' where kode_petugas='$kode_petugas'";
		if(mysqli_query($koneksi,$sqlsimpan1) && mysqli_query($koneksi,$sqlsimpan2)) {
			header('location:edit-user.php?user='.$_SESSION['username'].'&edit=sukses');
		} else {
			header('location:edit-user.php?user='.$_SESSION['username'].'&edit=gagal');
		}
	}
}
?>