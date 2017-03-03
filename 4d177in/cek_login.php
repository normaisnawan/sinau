<?php
include "../configurasi/koneksi.php";

$username = mysqli_real_escape_string($DBcon, $_POST['username']);
$pass     = mysqli_real_escape_string($DBcon, md5($_POST['password']));

// pastikan username dan password adalah berupa huruf atau angka.
if (!ctype_alnum($username) OR !ctype_alnum($pass)){
  echo "<link href=css/style.css rel=stylesheet type=text/css>";
  echo "<div class='error msg'>Injeksi Gagal</div>";
}
else{
$login=mysqli_query($DBcon,"SELECT * FROM admin WHERE username='$username' AND password='$pass' AND blokir='N'");
$ketemu=mysqli_num_rows($login);
$r=mysqli_fetch_array($login);

$login_guru =mysqli_query($DBcon,"SELECT * FROM pengajar WHERE username_login='$username' AND password_login='$pass' AND blokir='N'");
$ketemu_guru=mysqli_num_rows($login_guru);
$g=mysqli_fetch_array($login_guru);

// Apabila username dan password ditemukan
if ($ketemu > 0){
  session_start();
  include "timeout.php";

  $_SESSION[namauser]     = $r[username];
  $_SESSION[namalengkap]  = $r["Employee Name"];
  $_SESSION[passuser]     = $r[password];
  $_SESSION[leveluser]    = $r[level];
  $_SESSION[idadmin]      = $r[id_admin];
  $_SESSION[NIK]        = $r[NIK];

  // session timeout
  $_SESSION[login] = 1;
  timer();

	$sid_lama = session_id();

	session_regenerate_id();

	$sid_baru = session_id();

  mysqli_query($DBcon,"UPDATE admin SET id_session='$sid_baru' WHERE username='$username'");
  header('location:media_admin.php?module=home');
}
elseif($ketemu_guru > 0){
  session_start();
  include "timeout.php";

  $_SESSION[NIK]        = $g[NIK];
  $_SESSION[idpengajar]   = $g[id_pengajar];
  $_SESSION[namauser]     = $g[username_login];
  $_SESSION[namalengkap]  = $g[EmployeeName];
  $_SESSION[passuser]     = $g[password_login];
  $_SESSION[leveluser]    = $g[level];

  // session timeout
  $_SESSION[login] = 1;
  timer();

	$sid_lama = session_id();

	session_regenerate_id();

	$sid_baru = session_id();

  mysqli_query($DBcon,"UPDATE pengajar SET id_session='$sid_baru' WHERE username_login='$username'");
  header('location:media_admin.php?module=home');
}
else{
   echo "<link href=css/style.css rel=stylesheet type=text/css>";
  echo "<div class='error msg'>Login Gagal, Username atau Password salah, atau account anda sedang di blokir. ";
  echo "<a href=index.php><b>ULANGI LAGI</b></a></center></div>";
}
}
?>
