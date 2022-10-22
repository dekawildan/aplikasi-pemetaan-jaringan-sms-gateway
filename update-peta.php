<?php
include "cek-sesi";
include "config/config.php";
if(empty($_POST['koordinat']) || empty($_POST['no_alat'])) {
	header('location:pemetaan.php?edit=kosong');
} else {
	$no_pemetaan=$_POST['no_pemetaan'];
	$tgl_pemetaan=$_POST['tgl_pemetaan'];
	$koordinat=$_POST['koordinat'];
	$petugas=$_POST['user_petugas'];
	$alat=$_POST['no_alat'];
	$ambilalat=explode(" ", $alat);
	$no_alat=$ambilalat[0];
	if($koordinat == 'Geolocation Tidak Di dukung di Browser Anda.') {
		header('location:pemetaan.php?simpan=koordinat');
	} else {
		$ambilkodepetugas=mysqli_query($koneksi,"select * from tbl_login where username='$petugas'");
		$kodepetugas=mysqli_fetch_array($ambilkodepetugas);
		$sqlsimpan="update tbl_pemetaan set koordinat='$koordinat', kode_petugas='$kodepetugas[kode_petugas]', no_alat='$no_alat' where no_pemetaan='$no_pemetaan'";
		if(mysqli_query($koneksi,$sqlsimpan) ) {
			header('location:pemetaan.php?edit=sukses');
		} else {
			header('location:pemetaan.php?edit=gagal');
		}
	}
}
?>