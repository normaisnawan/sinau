<?php
session_start();
 if (empty($_SESSION['username']) AND empty($_SESSION['passuser'])){
  echo "<link href='style.css' rel='stylesheet' type='text/css'>
 <center>Untuk mengakses modul, Anda harus login <br>";
  echo "<a href=../../index.php><b>LOGIN</b></a></center>";
}
else{
  include "../../../configurasi/koneksi.php";

  $module=$_GET[module];
  $act=$_GET[act];

  // Input mapel
  if ($module=='trkatalog' AND $act=='input_trkatalog'){
      mysqli_query($DBcon, "INSERT INTO trkatalog(id,
                                   idtrkatalog,
                                   nama,
                                   deskripsi)
  	                       VALUES(null,
                                  '$_POST[idtrkatalog]',
                                  '$_POST[nama]',
                                  '$_POST[deskripsi]')");

    header('location:../../media_admin.php?module='.$module);
  }

  // Input mapel
  elseif ($module=='trkatalog' AND $act=='input_matapelajaran_pengajar'){
      $cek = mysqli_query($DBcon, "SELECT * FROM trkatalog WHERE id_matapelajaran = '$_POST[id_matapelajaran]'");
      $ada = mysqli_fetch_array($cek);
      mysqli_query($DBcon, "UPDATE trkatalog SET id_pengajar         = '$_SESSION[idpengajar]',
                                           deskripsi         = '$_POST[deskripsi]'
                                           WHERE  id     = '$ada[id]'");
    header('location:../../media_admin.php?module='.$module);
  }

  elseif ($module=='trkatalog' AND $act=='update_trkatalog'){
     mysqli_query($DBcon, "UPDATE trkatalog SET idtrkatalog  = '$_POST[idtrkatalog]',
                                                      nama   = '$_POST[nama]',
                                           deskripsi         = '$_POST[deskripsi]'
                                           WHERE  id     = '$_POST[id]'");
    header('location:../../media_admin.php?module='.$module);
  }

  elseif ($module=='trkatalog' AND $act=='hapus_trkatalog'){
    mysqli_query($DBcon, "DELETE FROM trkatalog WHERE id = '$_GET[id]'");
    header('location:../../media_admin.php?module='.$module);
  }

}
?>
