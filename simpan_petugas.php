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
		$sqlsimpan1="insert into tbl_petugas values('$kode_petugas','$nama_petugas','$jenis_kelamin','$alamat','$no_hp')";
		$sqlsimpan2="insert into tbl_login values('$kode_petugas','$username','$password')";
		if(mysqli_query($koneksi,$sqlsimpan1) && mysqli_query($koneksi,$sqlsimpan2)) {
			header('location:petugas.php?simpan=sukses');
		} else {
			header('location:petugas.php?simpan=gagal');
		}
	}
}
?>