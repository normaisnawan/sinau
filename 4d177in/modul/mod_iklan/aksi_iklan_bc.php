<?php
session_start();
 if (empty($_SESSION['username']) AND empty($_SESSION['passuser'])){
  echo "<link href='style.css' rel='stylesheet' type='text/css'>
 <center>Untuk mengakses modul, Anda harus login <br>";
  echo "<a href=../../index.php><b>LOGIN</b></a></center>";
}
else{
  include "../../../configurasi/library.php";
  include "../../../configurasi/koneksi.php";

  $module=$_GET[module];
  $act=$_GET[act];

  // Input mapel
  if ($module=='iklan' AND $act=='input_iklan'){
      mysqli_query($DBcon, "INSERT INTO iklan
        (idiklan, 
        juduliklan,
        isiiklan,posisi) 
        VALUES (
        NULL,  
        '$_POST[juduliklan]',
        '$_POST[isiiklan]',
        'header')") or die (mysqli_error($DBcon));
    header('location:../../media_admin.php?module='.$module);
  }

  elseif ($module=='iklan' AND $act=='input_video'){
  $lokasi_file = $_FILES['fupload']['tmp_name'];
  $nama_file   = $_FILES['fupload']['name'];
  $tipe_file   = $_FILES['fupload']['type'];
  $direktori_file = "../../../files_video/$nama_file";

  $extensionList = array("MP4", "mp4");
  $pecah = explode(".", $nama_file);
  $ekstensi = $pecah[1];

  if (file_exists($direktori_file)){
      echo "<script>window.alert('Nama file sudah ada, mohon diganti dulu');
            window.location=(href='../../media_admin.php?module=iklan&act=tambahiklan')</script>";
      }
  elseif (!in_array($ekstensi, $extensionList)){             
      echo "<script>window.alert('Tipe file tidak diijinkan');
                window.location=('../../media_admin.php?module=iklan&act=tambahiklan')</script>";
      }
  else{
    UploadFile_video($nama_file);
      mysqli_query($DBcon,"INSERT INTO `iklan` (`idiklan`, `juduliklan`, `gambar`, `isiiklan`, `terbit`, `posisi`) VALUES (NULL, '$_POST[judul]', '$nama_file', '', 'show', 'video')");
          header('location:../../media_admin.php?module=iklan');
      }

    
}
  elseif ($module=='iklan' AND $act=='update_iklan'){
     mysqli_query($DBcon, "UPDATE iklan SET 
      juduliklan    = '$_POST[juduliklan]',
      isiiklan      = '$_POST[isiiklan]',
      posisi        = '$_POST[posisi]'
      WHERE  idiklan  = '$_POST[idiklan]'");
    header('location:../../media_admin.php?module='.$module);
  }
 
  elseif ($module=='iklan' AND $act=='hapus_iklan'){
    mysqli_query($DBcon, "DELETE FROM iklan WHERE idiklan = '$_GET[idiklan]'");
    header('location:../../media_admin.php?module='.$module);
  }

}
?>
