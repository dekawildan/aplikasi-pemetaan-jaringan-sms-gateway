<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body bgcolor="black">
<?php
if(empty($_POST['username']) || empty($_POST['password'])) {
	header('location:login.php?login=kosong');
} else {
	include "config/config.php";
	$username=mysqli_real_escape_string($koneksi,$_POST['username']);
	$password=mysqli_real_escape_string($koneksi,$_POST['password']);
	$sql="SELECT * FROM tbl_login WHERE username='$username' AND password='$password'";
	$execute=mysqli_query($koneksi,$sql);
	if(mysqli_num_rows($execute)>0) {
		$ambil_petugas=mysqli_fetch_array($execute);
		$kode_petugas=$ambil_petugas['kode_petugas'];
		$ip=$_SERVER['REMOTE_ADDR'];
		$komputer=gethostbyaddr($_SERVER['REMOTE_ADDR']);
		$simpanlog=mysqli_query($koneksi,"INSERT INTO log_ip_login VALUES('$kode_petugas','$ip','$komputer',now())");
		$_SESSION['username']=$username;
		echo "
		<p>&nbsp;</p>
		<p>&nbsp;</p>
		<p>&nbsp;</p>
		<p>&nbsp;</p>
		<p align='center'><img src='image/satelit.gif' width='200' height='155'></p>
		<h3 align='center'><font color=white>LOADING... <span id='waktu'>10</span></h3>";
		?>
		<script>
			var waktu = 10;
setInterval(function() {
waktu--;
document.getElementById("waktu").innerHTML = waktu;
}, 1000);
		</script>
		<?php
		echo "<div class='seconds'>
    
  		</div> ";
		echo "<meta http-equiv='refresh' content='10, index.php'>";
	} else {
		header('location:login.php?login=gagal');
	}
}
?>
</body>
</html>
