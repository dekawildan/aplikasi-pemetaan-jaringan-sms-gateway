<?php
include "cek-sesi.php";
include "config/config.php";
$sql=mysqli_query($koneksi,"SELECT * FROM access_point");
while ($row=mysqli_fetch_array($sql)) {
	$no_alat=$row['no_alat'];
	if(!empty($_GET['id'])) {
		if($_GET['id'] == $no_alat) {
			if(mysqli_query($koneksi,"DELETE FROM access_point WHERE no_alat='$no_alat'")) {
				header('location:alat.php?hapus=success');
			} else {
				header('location:alat.php?hapus=gagal');
			}
		}
	}
}
?>