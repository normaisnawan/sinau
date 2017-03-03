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
  // Input pesan
  if ($module=='pesan' AND $act=='input_pesan'){
//Jika di NIK terdapat koma maka asksinya
      foreach ($_POST[NIK_penerima] as $pilih) {
         $hasilpilih .= $pilih . ",";
      } $hasilpilih = substr($hasilpilih,0,-1);

  // Input pesan
    if ($module=='pesan' AND $act=='input_pesan'){
      mysqli_query($DBcon, "INSERT INTO dbphapros.pesan
          (idpesan,
          NIK_penerima,
          NIK_pengirim, 
          judul, 
          isipesan, 
          perintah,
          waktupengiriman) 
          VALUES (
          NULL, 
          '$hasilpilih', 
          '$_SESSION[NIK]',
          '$_POST[judulpesan]',
          '$_POST[isipesan]', 
          '$_POST[perintah]', 
          '$_POST[waktu]')") or die (mysqli_error($DBcon));
      header('location:../../media_admin.php?module='.$module);
      }
    }

  elseif ($module=='pesan' AND $act=='update_pesan'){
    $hasil = implode(",",$_POST[NIK_penerima]);
    
    echo "$hasil";
     mysqli_query($DBcon, "UPDATE pesan SET 
      NIK_penerima    = '$hasil',
      NIK_pengirim    = '$_SESSION[NIK]',
      judul             = '$_POST[judulpesan]',
      isipesan          = '$_POST[isipesan]',
      perintah          = '$_POST[perintah]',
      waktupengiriman   = '$_POST[waktu]'
      WHERE  idpesan    = '$_POST[idpesan]'") or die(mysqli_error($DBcon));
      header('location:../../media_admin.php?module='.$module);
  }

  elseif ($module=='pesan' AND $act=='hapus_pesan_users'){
    mysqli_query($DBcon, "DELETE FROM pesan WHERE idpesan = '$_GET[idpesan]'");
    header('location:../../../media.php?module=pesan&act=semuapesan');
  }  
  elseif ($module=='pesan' AND $act=='hapus_pesan'){
    mysqli_query($DBcon, "DELETE FROM pesan WHERE idpesan = '$_GET[idpesan]'");
    header('location:../../media_admin.php?module='.$module);
  }
  elseif ($module=='pesan' AND $act=='ubahstatus'){
    $pesan=mysqli_query($DBcon, "SELECT * FROM pesan WHERE idpesan = '$_GET[idpesan]'");
    $m=mysqli_fetch_array($pesan);
    if ($m[dibacauser]=='Sudah') {
       mysqli_query($DBcon, "UPDATE pesan set dibacauser='Belum' WHERE idpesan = '$_GET[idpesan]'");
         header('location:../../media_admin.php?module='.$module);
    }elseif($m[dibacauser]=='Belum'){
      mysqli_query($DBcon, "UPDATE pesan set dibacauser='Sudah' WHERE idpesan = '$_GET[idpesan]'");
        header('location:../../media_admin.php?module='.$module);
    }else{
      echo "
      <script>
        window.alert('Tidak ada pesan yang dipilih'); 
        window.location=(href='media.php?module=pesan')
      </script>";
    }
  }

}
?>
