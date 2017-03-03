<?php
session_start();
 if (empty($_SESSION['username']) AND empty($_SESSION['passuser'])){
  echo "<link href='style.css' rel='stylesheet' type='text/css'>
 <center>Untuk mengakses modul, Anda harus login <br>";
  echo "<a href=../../index.php><b>LOGIN</b></a></center>";
}
else{
include "../../../configurasi/koneksi.php";
include "../../../configurasi/fungsi_thumb.php";
include "../../../configurasi/library.php";

$module=$_GET[module];
$act=$_GET[act];

// Input admin
if ($module=='users' AND $act=='input_users'){
  $lokasi_file    = $_FILES['fupload']['tmp_name'];
  $tipe_file      = $_FILES['fupload']['type'];
  $nama_file      = $_FILES['fupload']['name'];
  $direktori_file = "../../../foto_users/$nama_file";
  
  $cek_nis = mysqli_query($DBcon,"SELECT * FROM users WHERE NIK='$_POST[NIK]'");
  $ketemu=mysqli_num_rows($cek_nis);

  //apabila NIK tersedia dan ada foto
  if (empty($ketemu) AND !empty($lokasi_file)){
      if (file_exists($direktori_file)){
            echo "<script>window.alert('Nama file gambar sudah ada, mohon diganti dulu');
            window.location=(href='../../media_admin.php?module=users&act=tambahusers')</script>";
        }else{
            if($tipe_file != "image/jpeg" AND
               $tipe_file != "image/jpg"){
                    echo "<script>window.alert('Tipe File tidak di ijinkan.');
                    window.location=(href='../../media_admin.php?module=users&act=tambahusers')</script>";
                }else{
                UploadImage_users($nama_file);
                $pass=md5($_POST[password]);
                mysqli_query($DBcon,"INSERT INTO users(NIK,
                                 EmployeeName,
                                 username_login,
                                 password_login,
                                 PosTitle,
                                 Unit,
                                 alamat,
                                 jenis_kelamin,
                                 email,
                                 no_telp,
                                 foto,
                                 blokir,
                                 id_session,
                                 id_session_soal)
                         VALUES('$_POST[NIK]',
                                '$_POST[EmployeeName]',
                                '$_POST[username]',
                                '$pass',
                                '$_POST[PosTitle]',
                                '$_POST[Unit]',
                                '$_POST[alamat]',
                                '$_POST[jk]',
                                '$_POST[email]',
                                '$_POST[no_telp]',
                                '$nama_file',
                                '$_POST[blokir]',
                                '$_POST[NIK]',
                                '$_POST[NIK]')");
            }
            header('location:../../media_admin.php?module='.$module);
        }
        header('location:../../media_admin.php?module='.$module);
  }
  //apabila NIK sudah ada dan foto tidak ada
  elseif(!empty($ketemu) AND empty($lokasi_file)){
      echo "<script>window.alert('Nis sudah digunakan mohon ulangi.');
            window.location=(href='../../media_admin.php?module=users&act=tambahusers')</script>";
      }
  //apablia NIK tersedia dan foto tidak ada
  elseif(empty($ketemu) AND empty($lokasi_file)){
    $pass=md5($_POST[password]);
    mysqli_query($DBcon,"INSERT INTO users(NIK,
                                 EmployeeName,
                                 username_login,
                                 password_login,
                                 PosTitle,
                                 Unit,
                                 alamat,
                                 jenis_kelamin,
                                 email,
                                 no_telp,
                                 blokir,
                                 id_session,
                                 id_session_soal)
                         VALUES('$_POST[NIK]',
                                '$_POST[EmployeeName]',
                                '$_POST[username]',
                                '$pass',
                                '$_POST[PosTitle]',
                                '$_POST[Unit]',
                                '$_POST[alamat]',
                                '$_POST[jk]',
                                '$_POST[email]',
                                '$_POST[no_telp]',
                                '$_POST[blokir]',
                                '$_POST[NIK]',
                                '$_POST[NIK]')");
            header('location:../../media_admin.php?module='.$module);
    }else{
       echo "<script>window.alert('Nis sudah digunakan mohon ulangi.');
                window.location=(href='../../media_admin.php?module=users&act=tambahusers')</script>";
    }
}
 //updata users
 elseif ($module=='users' AND $act=='update_users'){
  $lokasi_file    = $_FILES['fupload']['tmp_name'];
  $tipe_file      = $_FILES['fupload']['type'];
  $nama_file      = $_FILES['fupload']['name'];
  $direktori_file = "../../../foto_users/$nama_file";

  $cek_nis = mysqli_query($DBcon,"SELECT * FROM users WHERE id_users = '$_POST[id]'");
  $ketemu=mysqli_fetch_array($cek_nis);

  if($_POST['NIK']==$ketemu['NIK']){

   //apabila foto tidak diubah dan password tidak di ubah
  if (empty($lokasi_file) AND empty($_POST[password])){
      mysqli_query($DBcon,"UPDATE users SET
                                  NIK  = '$_POST[NIK]',
                                  EmployeeName    = '$_POST[nama]',
                                  username_login  = '$_POST[username]',
                                  PosTitle         = '$_POST[PosTitle]',
                                  Unit         = '$_POST[Unit]',
                                  alamat          = '$_POST[alamat]',
                                  jenis_kelamin   = '$_POST[jk]',
                                  email           = '$_POST[email]',
                                  no_telp         = '$_POST[no_telp]',
                                  blokir          = '$_POST[blokir]',
                                  id_session      = '$_POST[NIK]',
                                  id_session_soal = '$_POST[NIK]'
                           WHERE  id_users        = '$_POST[id]'") or die (mysqli_error($DBcon));
  
  }
  //apabila foto diubah dan password tidak diubah
  elseif(!empty($lokasi_file) AND empty($_POST[password])){
      if (file_exists($direktori_file)){
            echo "<script>window.alert('Nama file gambar sudah ada, mohon diganti dulu');
            window.location=(href='../../media_admin.php?module=users')</script>";
         }else{
            if($tipe_file != "image/jpeg" AND
               $tipe_file != "image/jpg"){
                     echo "<script>window.alert('Tipe File tidak di ijinkan.');
                     window.location=(href='../../media_admin.php?module=users')</script>";
            }else{
            $cek = mysqli_query($DBcon,"SELECT * FROM users WHERE id_users = '$_POST[id]'");
            $r = mysqli_fetch_array($cek);

            if(!empty($r[foto])){
            $img = "../../../foto_users/$r[foto]";
            unlink($img);
            $img2 = "../../../foto_users/medium_$r[foto]";
            unlink($img2);
            $img3 = "../../../foto_users/small_$r[foto]";
            unlink($img3);
            
            UploadImage_users($nama_file);
            mysqli_query($DBcon,"UPDATE users SET
                                  NIK              = '$_POST[NIK]',
                                  EmployeeName     = '$_POST[nama]',
                                  username_login   = '$_POST[username]',
                                  PosTitle         = '$_POST[PosTitle]',
                                  Unit         = '$_POST[Unit]',
                                  alamat           = '$_POST[alamat]',
                                  jenis_kelamin    = '$_POST[jk]',
                                  email            = '$_POST[email]',
                                  no_telp          = '$_POST[no_telp]',
                                  foto             = '$nama_file',
                                  blokir           = '$_POST[blokir]',
                                  id_session       = '$_POST[NIK]',
                                  id_session_soal  = '$_POST[NIK]'
                           WHERE  id_users         = '$_POST[id]'") or die (mysqli_error($DBcon));
            }else{
                UploadImage_users($nama_file);
                mysqli_query($DBcon,"UPDATE users SET
                                  NIK              = '$_POST[NIK]',
                                  EmployeeName     = '$_POST[nama]',
                                  username_login   = '$_POST[username]',
                                  PosTitle         = '$_POST[PosTitle]',
                                  Unit         = '$_POST[Unit]',
                                  alamat           = '$_POST[alamat]',
                                  jenis_kelamin    = '$_POST[jk]',
                                  email            = '$_POST[email]',
                                  no_telp          = '$_POST[no_telp]',
                                  foto             = '$nama_file',
                                  blokir           = '$_POST[blokir]',
                                  id_session       = '$_POST[NIK]',
                                  id_session_soal  = '$_POST[NIK]'
                           WHERE  id_users         = '$_POST[id]'") or die (mysqli_error($DBcon));
            }
         }
         }
  }
  //apabila foto tidak diubah dan password diubah
  elseif(empty($lokasi_file) AND !empty($_POST[password])){
      $pass=md5($_POST[password]);
      mysqli_query($DBcon,"UPDATE users SET
                                  NIK              = '$_POST[NIK]',
                                  EmployeeName     = '$_POST[nama]',
                                  username_login   = '$_POST[username]',
                                  password_login   = '$pass',
                                  PosTitle         = '$_POST[PosTitle]',
                                  Unit         = '$_POST[Unit]',
                                  alamat           = '$_POST[alamat]',
                                  jenis_kelamin    = '$_POST[jk]',
                                  email            = '$_POST[email]',
                                  no_telp          = '$_POST[no_telp]',
                                  blokir           = '$_POST[blokir]',
                                  id_session       = '$_POST[NIK]',
                                  id_session_soal  = '$_POST[NIK]'
                           WHERE  id_users         = '$_POST[id]'") or die (mysqli_error($DBcon));
  }else{
      if (file_exists($direktori_file)){
            echo "<script>window.alert('Nama file gambar sudah ada, mohon diganti dulu');
            window.location=(href='../../media_admin.php?module=users')</script>";
         }else{
            if($tipe_file != "image/jpeg" AND
               $tipe_file != "image/jpg"){
                echo "<script>window.alert('Tipe File tidak di ijinkan.');
                window.location=(href='../../media_admin.php?module=users')</script>";
            }else{
            $cek = mysqli_query($DBcon,"SELECT * FROM users WHERE id_users = '$_POST[id]'");
            $r = mysqli_fetch_array($cek);
            if(!empty($r[foto])){
            $img = "../../../foto_users/$r[foto]";
            unlink($img);
            $img2 = "../../../foto_users/medium_$r[foto]";
            unlink($img2);
            $img3 = "../../../foto_users/small_$r[foto]";
            unlink($img3);

            UploadImage_users($nama_file);
            $pass=md5($_POST[password]);
            mysqli_query($DBcon,"UPDATE users SET
                                  NIK              = '$_POST[NIK]',
                                  EmployeeName     = '$_POST[nama]',
                                  username_login   = '$_POST[username]',
                                  password_login   = '$pass',
                                  PosTitle         = '$_POST[PosTitle]',
                                  Unit         = '$_POST[Unit]',
                                  alamat           = '$_POST[alamat]',
                                  jenis_kelamin    = '$_POST[jk]',
                                  email            = '$_POST[email]',
                                  no_telp          = '$_POST[no_telp]',
                                  foto             = '$nama_file',
                                  blokir           = '$_POST[blokir]',
                                  id_session       = '$_POST[NIK]',
                                  id_session_soal  = '$_POST[NIK]'
                           WHERE  id_users         = '$_POST[id]'") or die (mysqli_error($DBcon));
            }
            else{
               UploadImage_users($nama_file);
               $pass=md5($_POST[password]);
               mysqli_query($DBcon,"UPDATE users SET
                                  NIK              = '$_POST[NIK]',
                                  EmployeeName     = '$_POST[nama]',
                                  username_login   = '$_POST[username]',
                                  password_login   = '$pass',
                                  PosTitle         = '$_POST[PosTitle]',
                                  Unit         = '$_POST[Unit]',
                                  alamat           = '$_POST[alamat]',
                                  jenis_kelamin    = '$_POST[jk]',
                                  email            = '$_POST[email]',
                                  no_telp          = '$_POST[no_telp]',
                                  foto             = '$nama_file',
                                  blokir           = '$_POST[blokir]',
                                  id_session       = '$_POST[NIK]',
                                  id_session_soal  = '$_POST[NIK]'
                           WHERE  id_users         = '$_POST[id]'") or die (mysqli_error($DBcon));
            }
            }
         }
  }
  header('location:../../media_admin.php?module='.$module);
  }
  elseif($_POST['NIK']!= $ketemu['NIK']){
      $cek_nis = mysqli_query($DBcon,"SELECT * FROM users WHERE NIK = '$_POST[NIK]'");
      $c = mysqli_num_rows($cek_nis);
      //apabila NIK tersedia
      if(empty($c)){
          //apabila foto tidak diubah dan password tidak di ubah
  if (empty($lokasi_file) AND empty($_POST[password])){
      mysqli_query($DBcon,"UPDATE users SET
                                  NIK  = '$_POST[NIK]',
                                  EmployeeName    = '$_POST[nama]',
                                  username_login  = '$_POST[username]',
                                  PosTitle         = '$_POST[PosTitle]',
                                  Unit         = '$_POST[Unit]',
                                  alamat          = '$_POST[alamat]',
                                  jenis_kelamin   = '$_POST[jk]',
                                  email           = '$_POST[email]',
                                  no_telp         = '$_POST[no_telp]',
                                  blokir          = '$_POST[blokir]',
                                  id_session      = '$_POST[NIK]',
                                  id_session_soal = '$_POST[NIK]'
                           WHERE  id_users        = '$_POST[id]'") or die (mysqli_error($DBcon));

  }
  //apabila foto diubah dan password tidak diubah
  elseif(!empty($lokasi_file) AND empty($_POST[password])){
      if (file_exists($direktori_file)){
            echo "<script>window.alert('Nama file gambar sudah ada, mohon diganti dulu');
            window.location=(href='../../media_admin.php?module=users')</script>";
         }else{
            if($tipe_file != "image/jpeg" AND
               $tipe_file != "image/jpg"){
                     echo "<script>window.alert('Tipe File tidak di ijinkan.');
                     window.location=(href='../../media_admin.php?module=users')</script>";
            }else{
            $cek = mysqli_query($DBcon,"SELECT * FROM users WHERE id_users = '$_POST[id]'");
            $r = mysqli_fetch_array($cek);

            if(!empty($r[foto])){
            $img = "../../../foto_users/$r[foto]";
            unlink($img);
            $img2 = "../../../foto_users/medium_$r[foto]";
            unlink($img2);
            $img3 = "../../../foto_users/small_$r[foto]";
            unlink($img3);

            UploadImage_users($nama_file);
            mysqli_query($DBcon,"UPDATE users SET
                                  NIK              = '$_POST[NIK]',
                                  EmployeeName     = '$_POST[nama]',
                                  username_login   = '$_POST[username]',
                                  PosTitle         = '$_POST[PosTitle]',
                                  Unit         = '$_POST[Unit]',
                                  alamat           = '$_POST[alamat]',
                                  jenis_kelamin    = '$_POST[jk]',
                                  email            = '$_POST[email]',
                                  no_telp          = '$_POST[no_telp]',
                                  foto             = '$nama_file',
                                  blokir           = '$_POST[blokir]',
                                  id_session       = '$_POST[NIK]',
                                  id_session_soal  = '$_POST[NIK]'
                           WHERE  id_users         = '$_POST[id]'") or die (mysqli_error($DBcon));
            }else{
                UploadImage_users($nama_file);
                mysqli_query($DBcon,"UPDATE users SET
                                  NIK              = '$_POST[NIK]',
                                  EmployeeName     = '$_POST[nama]',
                                  username_login   = '$_POST[username]',
                                  PosTitle         = '$_POST[PosTitle]',
                                  Unit         = '$_POST[Unit]',
                                  alamat           = '$_POST[alamat]',
                                  jenis_kelamin    = '$_POST[jk]',
                                  email            = '$_POST[email]',
                                  no_telp          = '$_POST[no_telp]',
                                  foto             = '$nama_file',
                                  blokir           = '$_POST[blokir]',
                                  id_session       = '$_POST[NIK]',
                                  id_session_soal  = '$_POST[NIK]'
                           WHERE  id_users         = '$_POST[id]'") or die (mysqli_error($DBcon));
            }
         }
         }
  }
  //apabila foto tidak diubah dan password diubah
  elseif(empty($lokasi_file) AND !empty($_POST[password])){
      $pass=md5($_POST[password]);
      mysqli_query($DBcon,"UPDATE users SET
                                  NIK              = '$_POST[NIK]',
                                  EmployeeName     = '$_POST[nama]',
                                  username_login   = '$_POST[username]',
                                  password_login   = '$pass',
                                  PosTitle         = '$_POST[PosTitle]',
                                  Unit         = '$_POST[Unit]',
                                  alamat           = '$_POST[alamat]',
                                  jenis_kelamin    = '$_POST[jk]',
                                  email            = '$_POST[email]',
                                  no_telp          = '$_POST[no_telp]',
                                  blokir           = '$_POST[blokir]',
                                  id_session       = '$_POST[NIK]',
                                  id_session_soal  = '$_POST[NIK]'
                           WHERE  id_users         = '$_POST[id]'") or die (mysqli_error($DBcon));
  }else{
      if (file_exists($direktori_file)){
            echo "<script>window.alert('Nama file gambar sudah ada, mohon diganti dulu');
            window.location=(href='../../media_admin.php?module=users')</script>";
         }else{
            if($tipe_file != "image/jpeg" AND
               $tipe_file != "image/jpg"){
                echo "<script>window.alert('Tipe File tidak di ijinkan.');
                window.location=(href='../../media_admin.php?module=users')</script>";
            }else{
            $cek = mysqli_query($DBcon,"SELECT * FROM users WHERE id_users = '$_POST[id]'");
            $r = mysqli_fetch_array($cek);
            if(!empty($r[foto])){
            $img = "../../../foto_users/$r[foto]";
            unlink($img);
            $img2 = "../../../foto_users/medium_$r[foto]";
            unlink($img2);
            $img3 = "../../../foto_users/small_$r[foto]";
            unlink($img3);

            UploadImage_users($nama_file);
            $pass=md5($_POST[password]);
            mysqli_query($DBcon,"UPDATE users SET
                                  NIK              = '$_POST[NIK]',
                                  EmployeeName     = '$_POST[nama]',
                                  username_login   = '$_POST[username]',
                                  password_login   = '$pass',
                                  PosTitle         = '$_POST[PosTitle]',
                                  Unit         = '$_POST[Unit]',
                                  alamat           = '$_POST[alamat]',
                                  jenis_kelamin    = '$_POST[jk]',
                                  email            = '$_POST[email]',
                                  no_telp          = '$_POST[no_telp]',
                                  foto             = '$nama_file',
                                  blokir           = '$_POST[blokir]',
                                  id_session       = '$_POST[NIK]',
                                  id_session_soal  = '$_POST[NIK]'
                           WHERE  id_users         = '$_POST[id]'") or die (mysqli_error($DBcon));
            }
            else{
               UploadImage_users($nama_file);
               $pass=md5($_POST[password]);
               mysqli_query($DBcon,"UPDATE users SET
                                  NIK              = '$_POST[NIK]',
                                  EmployeeName     = '$_POST[nama]',
                                  username_login   = '$_POST[username]',
                                  password_login   = '$pass',
                                  PosTitle         = '$_POST[PosTitle]',
                                  Unit         = '$_POST[Unit]',
                                  alamat           = '$_POST[alamat]',
                                  jenis_kelamin    = '$_POST[jk]',
                                  email            = '$_POST[email]',
                                  no_telp          = '$_POST[no_telp]',
                                  foto             = '$nama_file',
                                  blokir           = '$_POST[blokir]',
                                  id_session       = '$_POST[NIK]',
                                  id_session_soal  = '$_POST[NIK]'
                           WHERE  id_users         = '$_POST[id]'") or die (mysqli_error($DBcon));
            }
            }
         }
  }
  header('location:../../media_admin.php?module='.$module);
    }
      else{
        echo "<script>window.alert('Nis sudah pernah digunakan.');
        window.location=(href='../../media_admin.php?module=users')</script>";
      }
  }
}


elseif ($module=='users' AND $act=='update_profil_users'){
  $lokasi_file    = $_FILES['fupload']['tmp_name'];
  $tipe_file      = $_FILES['fupload']['type'];
  $nama_file      = $_FILES['fupload']['name'];
  $direktori_file = "../../../foto_users/$nama_file";

  

  $cek_nis = mysqli_query($DBcon,"SELECT * FROM users WHERE id_users = '$_POST[id]'");
  $ketemu=mysqli_fetch_array($cek_nis);

  if($_POST['NIK']==$ketemu['NIK']){

   //apabila foto tidak diubah
  if (empty($lokasi_file)){
      mysqli_query($DBcon,"UPDATE users SET
                                  NIK  = '$_POST[NIK]',
                                  EmployeeName    = '$_POST[nama]',
                                  alamat          = '$_POST[alamat]',
                                  jenis_kelamin   = '$_POST[jk]',
                                  email           = '$_POST[email]',
                                  no_telp         = '$_POST[no_telp]',
                                  PosTitle         = '$_POST[PosTitle]',
                                  id_session      = '$_POST[NIK]',
                                  id_session_soal = '$_POST[NIK]'
                           WHERE  id_users        = '$_POST[id]'") or die (mysqli_error($DBcon));

  }
  //apabila foto diubah
  elseif(!empty($lokasi_file)){
      if (file_exists($direktori_file)){
            echo "<script>window.alert('Nama file gambar sudah ada, mohon diganti dulu');
            window.location=(href='../../../media.php?module=users&act=detailprofilusers&id=$_SESSION[idusers]')</script>";
         }else{
            if($tipe_file != "image/jpeg" AND
               $tipe_file != "image/jpg"){
                     echo "<script>window.alert('Tipe File tidak di ijinkan.');
                     window.location=(href='../../../media.php?module=users&act=detailprofilusers&id=$_SESSION[idusers]')</script>";
            }else{
            $cek = mysqli_query($DBcon,"SELECT * FROM users WHERE id_users = '$_POST[id]'");
            $r = mysqli_fetch_array($cek);

            if(!empty($r[foto])){
            $img = "../../../foto_users/$r[foto]";
            unlink($img);
            $img2 = "../../../foto_users/medium_$r[foto]";
            unlink($img2);
            $img3 = "../../../foto_users/small_$r[foto]";
            unlink($img3);

            UploadImage_users($nama_file);
            mysqli_query($DBcon,"UPDATE users SET
                                  NIK              = '$_POST[NIK]',
                                  EmployeeName     = '$_POST[nama]',
                                  alamat           = '$_POST[alamat]',
                                  jenis_kelamin    = '$_POST[jk]',
                                  email            = '$_POST[email]',
                                  no_telp          = '$_POST[no_telp]',
                                  foto             = '$nama_file',
                                  PosTitle         = '$_POST[PosTitle]',
                                  id_session       = '$_POST[NIK]',
                                  id_session_soal  = '$_POST[NIK]'
                           WHERE  id_users         = '$_POST[id]'") or die (mysqli_error($DBcon));
            }else{
                UploadImage_users($nama_file);
                mysqli_query($DBcon,"UPDATE users SET
                                  NIK              = '$_POST[NIK]',
                                  EmployeeName     = '$_POST[nama]',
                                  alamat           = '$_POST[alamat]',
                                  jenis_kelamin    = '$_POST[jk]',
                                  email            = '$_POST[email]',
                                  no_telp          = '$_POST[no_telp]',
                                  foto             = '$nama_file',
                                  PosTitle         = '$_POST[PosTitle]',
                                  id_session       = '$_POST[NIK]',
                                  id_session_soal  = '$_POST[NIK]'
                           WHERE  id_users         = '$_POST[id]'") or die (mysqli_error($DBcon));
            }
         }
         }
  }
  header('location:../../../media.php?module=users&act=detailprofilusers&id='.$_SESSION[idusers]);
  }
  elseif($_POST['NIK']!= $ketemu['NIK']){
      $cek_nis = mysqli_query($DBcon,"SELECT * FROM users WHERE NIK = '$_POST[NIK]'");
      $c = mysqli_num_rows($cek_nis);
      //apabila NIK tersedia
      if(empty($c)){
          //apabila foto tidak diubah
  if (empty($lokasi_file)){
      mysqli_query($DBcon,"UPDATE users SET
                                  NIK  = '$_POST[NIK]',
                                  EmployeeName    = '$_POST[nama]',
                                  alamat          = '$_POST[alamat]',
                                  jenis_kelamin   = '$_POST[jk]',
                                  email           = '$_POST[email]',
                                  no_telp         = '$_POST[no_telp]',
                                  PosTitle         = '$_POST[PosTitle]',
                                  id_session      = '$_POST[NIK]',
                                  id_session_soal = '$_POST[NIK]'
                           WHERE  id_users        = '$_POST[id]'") or die (mysqli_error($DBcon));

  }
  //apabila foto diubah
  elseif(!empty($lokasi_file)){
      if (file_exists($direktori_file)){
            echo "<script>window.alert('Nama file gambar sudah ada, mohon diganti dulu');
            window.location=(href='../../../media.php?module=users&act=detailprofilusers&id=$_SESSION[idusers]')</script>";
         }else{
            if($tipe_file != "image/jpeg" AND
               $tipe_file != "image/jpg"){
                     echo "<script>window.alert('Tipe File tidak di ijinkan.');
                     window.location=(href='../../../media.php?module=users&act=detailprofilusers&id=$_SESSION[idusers]')</script>";
            }else{
            $cek = mysqli_query($DBcon,"SELECT * FROM users WHERE id_users = '$_POST[id]'");
            $r = mysqli_fetch_array($cek);

            if(!empty($r[foto])){
            $img = "../../../foto_users/$r[foto]";
            unlink($img);
            $img2 = "../../../foto_users/medium_$r[foto]";
            unlink($img2);
            $img3 = "../../../foto_users/small_$r[foto]";
            unlink($img3);

            UploadImage_users($nama_file);
            mysqli_query($DBcon,"UPDATE users SET
                                  NIK              = '$_POST[NIK]',
                                  EmployeeName     = '$_POST[nama]',
                                  alamat           = '$_POST[alamat]',
                                  jenis_kelamin    = '$_POST[jk]',
                                  email            = '$_POST[email]',
                                  no_telp          = '$_POST[no_telp]',
                                  foto             = '$nama_file',
                                  PosTitle         = '$_POST[PosTitle]',
                                  id_session       = '$_POST[NIK]',
                                  id_session_soal  = '$_POST[NIK]'
                           WHERE  id_users         = '$_POST[id]'") or die (mysqli_error($DBcon));
            }else{
                UploadImage_users($nama_file);
                mysqli_query($DBcon,"UPDATE users SET
                                  NIK              = '$_POST[NIK]',
                                  EmployeeName     = '$_POST[nama]',
                                  alamat           = '$_POST[alamat]',
                                  jenis_kelamin    = '$_POST[jk]',
                                  email            = '$_POST[email]',
                                  no_telp          = '$_POST[no_telp]',
                                  foto             = '$nama_file',
                                  PosTitle         = '$_POST[PosTitle]',
                                  id_session       = '$_POST[NIK]',
                                  id_session_soal  = '$_POST[NIK]'
                           WHERE  id_users         = '$_POST[id]'") or die (mysqli_error($DBcon));
            }
         }
         }
  }
  header('location:../../../media.php?module=users&act=detailprofilusers&id='.$_SESSION[idusers]);
    }
      else{
        echo "<script>window.alert('Nis sudah pernah digunakan.');
        window.location=(href='../../../media.php?module=users&act=detailprofilusers&id=$_SESSION[idusers]')</script>";
      }
  }
}

elseif ($module=='users' AND $act=='update_account_users'){
    //jika username dan password tidak diubah
    if (empty($_POST[username]) AND empty($_POST[password])){
        header('location:../../../media.php?module=users&act=detailaccount');
    }
    //jika username diubah dan pasword tidak diubah
    elseif (!empty($_POST[username]) AND empty($_POST[password])){
        $username = mysqli_query($DBcon,"SELECT * FROM users WHERE id_users = '$_SESSION[idusers]'");
        $data_username = mysqli_fetch_array($username);
           
        //jika username sama dengan username yang ada di datbase
        if ($_POST[username] == $data_username[username_login]){
        mysqli_query($DBcon,"UPDATE users SET username_login = '$_POST[username]'
                                  WHERE id_users     = '$_SESSION[idusers]'");

        echo "<script>window.alert('Username berhasil diubah');
                    window.location=(href='../../../media.php?module=home')</script>";
        }
        //jika username tidak sama username di database
        elseif ($_POST[username] != $data_username[username_login]){
            $username2 = mysqli_query($DBcon,"SELECT * FROM users WHERE username_login = '$_POST[username]'");
            $data_username2 = mysqli_num_rows($username2);
            //jika username tersedia
            if (empty($data_username2)){
                mysqli_query($DBcon,"UPDATE users SET username_login = '$_POST[username]'
                                  WHERE id_users     = '$_SESSION[idusers]'");

                echo "<script>window.alert('Username berhasil diubah');
                              window.location=(href='../../../media.php?module=home')</script>";
            }
            //jika username tiak tersedia
            else{
                echo "<script>window.alert('Username sudah digunakan mohon diganti');
                              window.location=(href='../../../media.php?module=users&act=detailaccount')</script>";
            }
        }
    }
    //jika username tidak di ubah dan pasword di ubah
    elseif (empty($_POST[username]) AND !empty($_POST[password])){
        $pass = md5($_POST[password]);
        mysqli_query($DBcon,"UPDATE users SET password_login = '$pass'
                                  WHERE id_users     = '$_SESSION[idusers]'");

        echo "<script>window.alert('Password berhasil diubah');
                    window.location=(href='../../../media.php?module=home')</script>";
    }
    //jika username di ubah dan password di ubah
    elseif (!empty($_POST[username]) AND !empty($_POST[password])){
        $username = mysqli_query($DBcon,"SELECT * FROM users WHERE username_login = '$_POST[username]'");
        $data_username = mysqli_fetch_array($username);
        //jika username sama dengan di database
        if ($_POST[username] == $data_username[username_login]){
        $pass = md5($_POST[password]);
        mysqli_query($DBcon,"UPDATE users SET username_login = '$_POST[username]',
                                      password_login = '$pass'
                                  WHERE id_users     = '$_SESSION[idusers]'");

        echo "<script>window.alert('Username & Password berhasil diubah');
                    window.location=(href='../../../media.php?module=home')</script>";
        }
        //jika username tidak sama dengan username di database
        elseif ($_POST[username] != $data_username[username_login]){
            $username2 = mysqli_query($DBcon,"SELECT * FROM users WHERE username_login = '$_POST[username]'");
            $data_username2 = mysqli_num_rows($username2);
            //jika username tersedia
            if (empty($data_username2)){
                $pass = md5($_POST[password]);
                mysqli_query($DBcon,"UPDATE users SET username_login = '$_POST[username]',
                                      password_login = '$pass'
                                  WHERE id_users     = '$_SESSION[idusers]'");

                echo "<script>window.alert('Username & Password berhasil diubah');
                                window.location=(href='../../../media.php?module=home')</script>";
            }
            //jika username tidak tersedia
            else{
                echo "<script>window.alert('Username sudah digunakan mohon diganti');
                              window.location=(href='../../../media.php?module=users&act=detailaccount')</script>";
            }
        }
    }

}

}
?>
