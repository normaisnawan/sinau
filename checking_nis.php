<?php
include "configurasi/koneksi.php";

$sql = mysqli_query($DBcon, "SELECT * FROM siswa
                   WHERE nis = '$_POST[nis]'");
$ketemu = mysqli_num_rows($sql);

echo $ketemu;
?>
