<?php
session_start();
error_reporting(0);

if (empty($_SESSION['username']) AND empty($_SESSION['passuser']) AND $_SESSION['login']==0){
    include 'peringatan.php';
}
else{
include "configurasi/koneksi.php";

$soal = mysqli_query($DBcon, "SELECT * FROM quiz_pilganda where id_pelatihan='$_POST[id_pelatihan]'");
$pilganda = mysqli_num_rows($soal);
$soal_esay = mysqli_query($DBcon, "SELECT * FROM quiz_esay WHERE id_pelatihan='$_POST[id_pelatihan]'");
$esay = mysqli_num_rows($soal_esay);
//jika ada pilihan ganda dan ada esay
if (!empty($pilganda) AND !empty($esay)){

//jika ada inputan soal pilganda
if(!empty($_POST['soal_pilganda'])){
    $benar = 0;
    $salah = 0;

    foreach($_POST['soal_pilganda'] as $key => $value){
    $cek = mysqli_query($DBcon, "SELECT * FROM quiz_pilganda WHERE id_quiz=$key");
    while($c = mysqli_fetch_array($cek)){
        $jawaban = $c['kunci'];
    }
      if($value==$jawaban){
          $benar++;
      }else{
          $salah++;
      }
    }

  $jumlah = $_POST['jumlahsoalpilganda'];
  $tidakjawab = $jumlah - $benar - $salah;
  $persen = $benar / $jumlah;
  $hasil = $persen * 100;

  if ($hasil<50) {
    $kriteriapenilaian = "Sangat Kurang";
  }elseif ($hasil<60) {
    $kriteriapenilaian = "Kurang";
  }elseif ($hasil<80) {
    $kriteriapenilaian = "Cukup";
  }elseif ($hasil<90) {
    $kriteriapenilaian = "Baik";
  }else {
    $kriteriapenilaian = "Sangat Baik";
  }

  mysqli_query($DBcon, "INSERT INTO nilai (id_pelatihan, id_users, benar, salah, tidak_dikerjakan,persentase,kriteriapenilaian)
                           VALUES ('$_POST[id_pelatihan]','$_SESSION[idusers]','$benar','$salah','$tidakjawab','$hasil','$kriteriapenilaian')");

  }
  elseif (empty($_POST['soal_pilganda'])){
    $jumlah = $_POST['jumlahsoalpilganda'];
    mysqli_query($DBcon, "INSERT INTO nilai (id_pelatihan, id_users, benar, salah, tidak_dikerjakan,persentase,kriteriapenilaian)
                           VALUES ('$_POST[id_pelatihan]','$_SESSION[idusers]','0','0','$jumlah','0',null)");
  }

  //jika ada inputan soal esay
  if(!empty($_POST['soal_esay'])){
      foreach($_POST['soal_esay'] as $key2 => $value){
      $jawaban = $value;
      $cek = mysqli_query($DBcon, "SELECT * FROM quiz_esay WHERE id_quiz=$key2");
      while($data = mysqli_fetch_array($cek)){
          mysqli_query($DBcon, "INSERT INTO jawaban(id_pelatihan,id_quiz,id_users,jawaban)
                                   VALUES('$_POST[id_pelatihan]','$data[id_quiz]','$_SESSION[idusers]','$jawaban')");

      }
      
      }

  }
  elseif (empty($_POST['soal_esay'])){
      mysqli_query($DBcon, "INSERT INTO jawaban(id_pelatihan,id_quiz,id_users,jawaban)
                                   VALUES('$_POST[id_pelatihan]','$data[id_quiz]','$_SESSION[idusers]','')");
  }
  header ('location:home');
  }

  //jika soal hanya esay
  if (empty($pilganda) AND !empty($esay)){
      //jika ada inputan soal esay
  if(!empty($_POST['soal_esay'])){
      foreach($_POST['soal_esay'] as $key2 => $value){
      $jawaban = $value;
      $cek = mysqli_query($DBcon, "SELECT * FROM quiz_esay WHERE id_quiz=$key2");
      while($data = mysqli_fetch_array($cek)){
          mysqli_query($DBcon, "INSERT INTO jawaban(id_pelatihan,id_quiz,id_users,jawaban)
                                   VALUES('$_POST[id_pelatihan]','$data[id_quiz]','$_SESSION[idusers]','$jawaban')");

      }

      }

  }
  elseif (empty($_POST['soal_esay'])){
      mysqli_query($DBcon, "INSERT INTO jawaban(id_pelatihan,id_quiz,id_users,jawaban)
                                   VALUES('$_POST[id_pelatihan]','$data[id_quiz]','$_SESSION[idusers]','')");
  }
  header ('location:home');
  }

  //jika soal hanya pilihan ganda
  if (!empty($pilganda) AND empty($esay)){
      //jika ada inputan soal pilganda
  if(!empty($_POST['soal_pilganda'])){
      $benar = 0;
      $salah = 0;
      foreach($_POST['soal_pilganda'] as $key => $value){
      $cek = mysqli_query($DBcon, "SELECT * FROM quiz_pilganda WHERE id_quiz=$key");
      while($c = mysqli_fetch_array($cek)){
          $jawaban = $c['kunci'];
      }
          if($value==$jawaban){
              $benar++;
          }else{
              $salah++;
          }
      }

      $jumlah = $_POST['jumlahsoalpilganda'];
      $tidakjawab = $jumlah - $benar - $salah;
      $persen = $benar / $jumlah;
      $hasil = $persen * 100;

      if ($hasil<50) {
        $kriteriapenilaian = "Sangat Kurang";
      }elseif ($hasil<60) {
        $kriteriapenilaian = "Kurang";
      }elseif ($hasil<80) {
        $kriteriapenilaian = "Cukup";
      }elseif ($hasil<90) {
        $kriteriapenilaian = "Baik";
      }else {
        $kriteriapenilaian = "Sangat Baik";
      }

    if ($hasil<50) {
      mysqli_query($DBcon, "INSERT INTO nilai (id_pelatihan, id_users, benar, salah, tidak_dikerjakan,persentase,kriteriapenilaian)
        VALUES ('$_POST[id_pelatihan]','$_SESSION[idusers]','$benar','$salah','$tidakjawab','$hasil','$kriteriapenilaian')");
       echo "
       <script>
        alert('Maaf, nilai anda kurang dari 60, silakan mengulang post test lagi 3 hari lagi mulai dari sekarang.')
        window.location.href='media.php?module=quiz&act=pendaftaranlearning';
      </script>"; 

    }else{
      mysqli_query($DBcon, "INSERT INTO nilai (id_pelatihan, id_users, benar, salah, tidak_dikerjakan,persentase,kriteriapenilaian)
        VALUES ('$_POST[id_pelatihan]','$_SESSION[idusers]','$benar','$salah','$tidakjawab','$hasil','$kriteriapenilaian')");
      echo "
       <script>
        alert('Selamat nilai anda ".$hasil.".')
        window.location.href='home';
      </script>"; 
    }

    }
  elseif (empty($_POST['soal_pilganda'])){
      if ($hasil<50) {
     // mysqli_query($DBcon, "DELETE FROM `dbphapros`.`users_sudah_mengerjakan` WHERE `id_users`='$_SESSION[idusers]' and id_pelatihan = '$_POST[id_pelatihan]' ");     
         mysqli_query($DBcon, "INSERT INTO nilai (id_pelatihan, id_users, benar, salah, tidak_dikerjakan,persentase,kriteriapenilaian)
        VALUES ('$_POST[id_pelatihan]','$_SESSION[idusers]','$benar','$salah','$tidakjawab','$hasil','$kriteriapenilaian')");
      echo "
      <script>
        alert('Maaf, nilai anda kurang dari 60, silakan mengulang post test lagi 3 hari mulai dari sekarang.')
        window.location.href='media.php?module=quiz&act=pendaftaranlearning';
      </script>
      ";
      
      }else{
        $jumlah = $_POST['jumlahsoalpilganda'];
      mysqli_query($DBcon, "INSERT INTO nilai (id_pelatihan, id_users, benar, salah, tidak_dikerjakan,persentase,kriteriapenilaian)
                             VALUES ('$_POST[id_pelatihan]','$_SESSION[idusers]','0','0','$jumlah','0',null)");
              echo "
       <script>
        alert('Selamat nilai anda ".$hasil.".')
        window.location.href='home';
      </script>"; 
      }
  }
  }

  }
?>
