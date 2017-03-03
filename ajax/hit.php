<?php

include '../configurasi/koneksi.php';;

$act = $_GET['act'];
$id = $_GET['id'];

if ($_GET['act'] == "materi") {
	$id = $_GET['id'];
	$q =  mysqli_query($DBcon,"UPDATE file_materi SET hits=hits+1 WHERE id='$id'");
	
	echo "sukses";
} elseif ($_GET['act'] == "hapus") {
	$id =  $_GET['id'];
	$q = $mysqli->query("DELETE FROM temp_sjnsn WHERE id='$id' ");
	echo "sukses";	
}
?>