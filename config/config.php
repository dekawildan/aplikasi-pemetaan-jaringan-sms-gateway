<?php
$koneksi=mysqli_connect("localhost","root","","sistem_pemetaan") or die("Gagal mengkoneksikan");
mysqli_select_db($koneksi,"sistem_pemetaan") or die("Gagal memilih database");