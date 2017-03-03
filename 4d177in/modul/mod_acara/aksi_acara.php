<?php
session_start();
 if (empty($_SESSION['username']) AND empty($_SESSION['passuser'])){
  echo "<link href='style.css' rel='stylesheet' type='text/css'>
 <center>Untuk mengakses modul, Anda harus login <br>";
  echo "<a href=../../index.php><b>LOGIN</b></a></center>";
}
else{
include "../../../configurasi/koneksi.php";
include "../../../configurasi/library.php";
include "../../../configurasi/fungsi_thumb.php";
include "../../../configurasi/fungsi_tglwktindo.php";
include "../../../configurasi/fungsi_indotgl.php";
function konversi_tanggal($date)    
    {         
    $exp = explode('-',$date);    
    if(count($exp) == 3)    
    {    
      $date = $exp[2].'-'.$exp[1].'-'.$exp[0];    
    }    
    return $date;    
    }    
$module=$_GET[module];
$act=$_GET[act];

if ($module=='acara' AND $act=='input_pelatihan'){
  if (empty($_POST[idmateri])) {
  echo "<script>window.alert('Materi masih kosong.');
            window.location=(href='../../media_admin.php?module=acara')</script>";
}else{
      foreach ($_POST[NIK_penerima] as $pilih) {
         $hasilpilih .= $pilih . ",";
      } $hasilpilih = substr($hasilpilih,0,-1);

      $wpengerjaan = $_POST['lama'] * 60;
      mysqli_query($DBcon,"INSERT INTO dbphapros.pesan
          (idpesan,
          NIK_penerima,
          NIK_pengirim, 
          judul, 
          isipesan, 
          perintah,
          waktupengiriman,link) 
          VALUES (
          NULL, 
          '$hasilpilih', 
          '$_SESSION[NIK]',
          '$_POST[judulpesan]',
          '$_POST[isipesan]</br> Silakan klik link yang tersedia di bawah ini.', 
          'Ya', 
          '".indonesian_date()."',
          '$_POST[link]')") or die (mysqli_error($DBcon));

          require '../../../assets/vendor/PHPMailer/PHPMailerAutoload.php';
          require '../../../assets/vendor/PHPMailer/class.phpmailer.php';
          //Create a new PHPMailer instance
          $mail = new PHPMailer;
          //Tell PHPMailer to use SMTP
          $mail->isSMTP();
          //Enable SMTP debugging
          // 0 = off (for production use)
          // 1 = client messages
          // 2 = client and server messages
          $mail->SMTPDebug = 2;
          //Ask for HTML-friendly debug output
          $mail->Debugoutput = 'html';
          //Set the hostname of the mail server
          //$mail->Host = 'smtp.gmail.com';
          // use
          $mail->Host = 'tls://smtp.gmail.com:587';
          $mail->SMTPAuth = true;
          //Username to use for SMTP authentication - use full email address for gmail
          $mail->Username = "elearning.phapros@gmail.com";
          //Password to use for SMTP authentication
          $mail->Password = "Phapros Ceria";
          //Set who the message is to be sent from
          $mail->setFrom('elearning.phapros@gmail.com', 'Admin E-PED');
          //Set an alternative reply-to address
          $mail->addReplyTo('elearning.phapros@gmail.com', 'Admin E-PED');
          //Set who the message is to be sent to
          $mail->addAddress('feriagusetiawan@yahoo.co.uk', 'Feri Agusetiawan');
          //Set the subject line
          $mail->Subject = 'PHPMailer GMail SMTP test';
          //Read an HTML message body from an external file, convert referenced images to embedded,
          //convert HTML into a basic plain-text alternative body
          $mail->Body    = 'This is the HTML message body <b>in bold!</b>';
          $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
          //Attach an image file
          //send the message, check for errors
          if (!$mail->send()) {
                echo "<script>window.alert('Pesan Berhasil Terkirim')</script>";
          } else {
                echo "<script>window.alert('Pesan Gagal Terkirim')</script>";
          }



      mysqli_query($DBcon,"INSERT INTO pelatihan(
             id_pelatihan,
             idtrkatalog,
             idreason_codde,
             idprioritas,
             nama_pelatihan,
             nama_trainer,
             asal_trainer,
             tanggal_pelaksanaan,
             tanggal_selesai,
             lama,
             waktu,
             tempat,
             materi,
             pengikut)
      VALUES('$_POST[id_pelatihan]',
             '$_POST[idtrkatalog]',
             '$_POST[idreason_codde]',
             '$_POST[idprioritas]',
             '$_POST[nama_pelatihan]',
             '$_POST[nama_trainer]',
             '$_POST[asal_trainer]',
             '".konversi_tanggal($_POST[tanggal_pelaksanaan])."',
             '".konversi_tanggal($_POST[tanggal_selesai])."',
             '$wpengerjaan',
             '$_POST[waktu]',
             '$_POST[tempat]',
             '$_POST[idmateri]',
             '$hasilpilih')")or die(mysqli_error($DBcon));
              echo "
            <script>window.alert('Pesan Gagal Terkirim');
            window.location=(href='../../media_admin.php?module=acara')</script>";
   
  }
}


elseif ($module=='acara' AND $act=='hapus'){
  mysqli_query($DBcon,"DELETE FROM pelatihan WHERE id_pelatihan = '$_GET[id_pelatihan]'");
  header('location:../../media_admin.php?module='.$module);
}

elseif ($module=='acara' AND $act=='edit_pelatihan'){
    $hasil = implode(",",$_POST[NIK_penerima]);
    
                     $wpengerjaan = $_POST[lama] * 60;
                     $tanggal1 = konversi_tanggal($_POST[tanggal_pelaksanaan]);
                     $tanggal2 = konversi_tanggal($_POST[tanggal_selesai]);
                      mysqli_query($DBcon,"UPDATE `dbphapros`.`pelatihan` SET 
                        `idreason_codde` = '$_POST[idreason_codde]',
                        `idtrkatalog` = '$_POST[idtrkatalog]',  
                        `idprioritas` = '$_POST[idprioritas]', 
                        `nama_pelatihan` = '$_POST[nama_pelatihan]', 
                        `nama_trainer` = '$_POST[nama_trainer]',
                        `asal_trainer` = '$_POST[asal_trainer]',
                        `tanggal_pelaksanaan` = '$tanggal1',
                        `tanggal_selesai` = '$tanggal2',
                        `lama` = '$wpengerjaan',
                        `waktu` = '$_POST[waktu]',
                        `tempat` = '$_POST[tempat]',
                        `materi` = '$_POST[idmateri]'
                        WHERE `pelatihan`.`id_pelatihan` = '$_POST[id_pelatihan]'") or die(mysqli_error($DBcon));

     mysqli_query($DBcon,"UPDATE pesan SET 
      NIK_penerima    = '$hasil',
      NIK_pengirim    = '$_SESSION[NIK]',
      judul             = '$_POST[judulpesan]',
      isipesan          = '$_POST[isipesan]',
      perintah          = 'Ya',
      waktupengiriman   = '$_POST[waktu]'
      WHERE  idpesan    = '$_POST[idpesan]'") or die(mysqli_error($DBcon));
      header('location:../../media_admin.php?module='.$module);

  }
}
?>
