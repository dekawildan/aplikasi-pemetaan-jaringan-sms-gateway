<?php
include "cek-sesi.php";
include "config/config.php";
$sqlpeta=mysqli_query($koneksi,"select * from tbl_pemetaan");
while($row=mysqli_fetch_array($sqlpeta)) {
	$nopeta=$row['no_pemetaan'];
	if(!empty($_GET['id'])) {
		if($_GET['id'] == $nopeta) {
			$sqlhapus="delete from tbl_pemetaan where no_pemetaan='$nopeta'";
			if(mysqli_query($sqlhapus)) {
				header('location:pemetaan.php?hapus=sukses');
			} else {
				header('location:pemetaan.php?hapus=gagal');
			}
		}
	} else {
		header('location:pemetaan.php?hapus=kosong');
	}
}
?>