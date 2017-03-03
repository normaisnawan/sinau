<?php
include "../configurasi/koneksi.php";

if ($_SESSION['leveluser']=='admin'){
  $sql=mysqli_query($DBcon,"select * from modul where aktif='Y' order by urutan");
  while ($m=mysqli_fetch_array($sql)){
    echo "
    <li>
    	<a href='$m[link]'>$m[nama_modul]</a>
    </li>";
  }
}
elseif ($_SESSION['leveluser']=='pengajar'){
  $sql=mysqli_query($DBcon,"select * from modul where status='pengajar' and aktif='Y' order by urutan");
  while ($m=mysqli_fetch_array($sql)){
    echo "
    				<li>
				    	<a href='$m[link]'>$m[nama_modul]</a>
				    </li>";
  }
}
?>
