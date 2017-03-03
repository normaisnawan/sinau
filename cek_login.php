<?php
include "configurasi/koneksi.php";
$username = mysqli_real_escape_string($DBcon, $_POST['username']);
$pass     = mysqli_real_escape_string($DBcon, md5($_POST['password']));

// pastikan username dan password adalah berupa huruf atau angka.
if (!ctype_alnum($username) OR !ctype_alnum($pass)){
  include 'peringatan.php';
}
else{
$login=mysqli_query($DBcon,"SELECT * FROM users WHERE username_login='$username' AND password_login='$pass' AND blokir='N'");
$ketemu=mysqli_num_rows($login);
$r=mysqli_fetch_array($login);

// Apabila username dan password ditemukan
if ($ketemu > 0){
  session_start();
  include "timeout.php";

  $_SESSION[NIK]        = $r[NIK];
  $_SESSION[namauser]     = $r[username_login];
  $_SESSION[namalengkap]  = $r[EmployeeName];
  $_SESSION[passuser]     = $r[password_login];
  $_SESSION[leveluser]    = $r[level];
  $_SESSION[idusers]      = $r[id_users];

  // session timeout
  $_SESSION[login] = 1;
  timer();

	$sid_lama = session_id();

	session_regenerate_id();

	$sid_baru = session_id();

  mysqli_query($DBcon,"UPDATE users SET id_session='$sid_baru' WHERE username_login='$username'");

  $user = mysqli_query($DBcon,"SELECT * FROM online WHERE id_users='$_SESSION[idusers]'");
  if (mysqli_num_rows($user)== 0){
              $ip      = $_SERVER['REMOTE_ADDR']; // Mendapatkan IP komputer user
              $tanggal = date("Ymd"); // Mendapatkan tanggal sekarang
              $waktu   = time("U"); //
      mysqli_query($DBcon,"INSERT INTO online (ip,id_users,tanggal,online)
                               VALUES ('$ip','$_SESSION[idusers]','$tanggal','Y')");
  }
  else{
     $ip      = $_SERVER['REMOTE_ADDR']; // Mendapatkan IP komputer user
     $tanggal = date("Ymd"); // Mendapatkan tanggal sekarang
     $waktu   = time("U"); //
     mysqli_query($DBcon,"UPDATE online SET ip='$ip',tanggal='$tanggal',online='Y' WHERE id_users = '$_SESSION[idusers]'");
  }
  header('location:media.php?module=home');
}
else{  
  echo "<script>window.alert('LOGIN GAGAL! Username atau Password tidak benar. Atau account anda sedang di blokir!');
            window.location=(href='index.php')</script>";
}
}
?>
