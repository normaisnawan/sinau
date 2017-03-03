<?php
include "configurasi/koneksi.php";

$direktori = "files_materi/"; // folder tempat penyimpanan file yang boleh didownload
$filename = $_GET['file'];
$idusers = $_GET['id_users'];
$id_materi = $_GET['id_materi'];

$cekdata= mysqli_query($DBcon, "SELECT * from riwayat_aktivitas_users where id_materi='$id_materi' and idusers = '$idusers'");
if (mysqli_num_rows($cekdata)>0) {
  echo "
  <script>
  alert('Anda Sudah Pernah Mengunduh File Materi Ini')
  window.location=(href='media.php?module=materi')
  </script>
  ";
}else{
$file_extension = strtolower(substr(strrchr($filename,"."),1));
switch($file_extension){
  case "pdf": $ctype="application/pdf"; break;
  case "exe": $ctype="application/octet-stream"; break;
  case "zip": $ctype="application/zip"; break;
  case "rar": $ctype="application/rar"; break;
  case "doc": $ctype="application/msword"; break;
  case "xls": $ctype="application/vnd.ms-excel"; break;
  case "ppt": $ctype="application/vnd.ms-powerpoint"; break;
  case "gif": $ctype="image/gif"; break;
  case "png": $ctype="image/png"; break;
  case "jpeg":
  case "jpg": $ctype="image/jpg"; break;
  default: $ctype="application/proses";
}

if ($file_extension=='php'){
  echo "<h1>Access forbidden!</h1>
        <p>Maaf, file yang Anda download sudah tidak tersedia atau filenya (direktorinya) telah diproteksi. <br />
        Silahkan hubungi <a href='mailto:grassdev@gmail.com'>webmaster</a>.</p>";
  exit;
}
else{
  //Untuk membuat riwayat aktivitas unduhan file pelatihan
  mysqli_query($DBcon, "INSERT INTO `riwayat_aktivitas_users` VALUES (null, '$idusers', '0', '0', '0', '$id_materi')");
  mysqli_query($DBcon, "UPDATE file_materi set hits=hits+1 where nama_file='$filename'");
  header("Content-Type: octet/stream");
  header("Pragma: private"); 
  header("Expires: 0");
  header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
  header("Cache-Control: private",false); 
  header("Content-Type: $ctype");
  header("Content-Disposition: attachment; filename=\"".basename($filename)."\";" );
  header("Content-Transfer-Encoding: binary");
  header("Content-Length: ".filesize($direktori.$filename));
  readfile("$direktori$filename");
  exit();   
}
}
?>
