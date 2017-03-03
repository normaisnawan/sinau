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

  $module=@$_GET[module];
  $act=@$_GET[act];
  //$tglakhir = $_POST['tglkadal'];
  //$xtgl = explode('/', $tglakhir);
  //$tgl = $xtgl[1]; $bln = $xtgl[0]; $thn = $xtgl[2];
  $tglawal = $_POST['tglawal'];
  $tglakhir = $_POST['tglakhir'];
  
  // Input mapel
  if ($module=='iklan' AND $act=='input_iklan'){
      mysqli_query($DBcon, "INSERT INTO iklan
        (idiklan, 
        juduliklan,
        isiiklan,
        posisi,
        tglawal,
        tglakhir) 
        VALUES (
        NULL,  
        '$_POST[juduliklan]',
        '$_POST[isiiklan]',
        'header',
        '$tglawal',
        '$tglakhir')") or die (mysqli_error($DBcon));
    header('location:../../media_admin.php?module='.$module);
  } 
  elseif ($module=='iklan' AND $act=='input_gambar'){
       // echo "Hallo";
        $error = false;
        $file_type = array('jpg','png','jpeg','JPG','PNG','JPEG');
        $max_size = 1000000;  
        $file_name = $_FILES['gambar']['name'];
        $file_size = $_FILES['gambar']['size'];
        $folder = '../../../files_gambar';
      
        $explode = explode(".", $file_name);
        $extensi  = $explode[count($explode)- 1];
        $random = rand(00000000,99999999);
        $file_namex = $random.$file_name;

         //check apakah type file sudah sesuai
        if((!isset($_FILES['gambar'])) OR (!in_array($extensi,$file_type))){
              $error   = true;
              $pesan .= '<div class="alert alert-warning">
                  <strong>Maaf</strong> - Type file yang Anda upload tidak sesuai
                </div>';    
        }
        if($file_size > $max_size){
              $error   = true;
            $pesan .= '<div class="alert alert-warning">
                  <strong>Maaf</strong> - Ukuran file melebihi batas maximum<br />
                </div>';    
        } 

        if($error == true){
            echo '<div id="eror">'.$pesan.'</div>';
        } else {
            mysqli_query($DBcon, "INSERT INTO iklan
            (idiklan, 
            juduliklan,
            gambar,
            posisi,
            tglawal,
            tglakhir) 
            VALUES (
            NULL,  
            '$_POST[judul]',
            '$file_namex',
            'gambar',
            '$tglawal',
            '$tglakhir')") or die (mysqli_error($DBcon));

             if (move_uploaded_file($_FILES['gambar']['tmp_name'], $folder.'/'.$file_namex)) {
                 header('location:../../media_admin.php?module='.$module); 
             } else {
                echo "Fail";
             }
            
             
        }
    
  }

  elseif ($module=='iklan' AND $act=='input_video'){
     
     mysqli_query($DBcon, "INSERT INTO iklan
            (idiklan, 
            juduliklan,
            isiiklan,
            posisi,
            tglawal,
            tglakhir) 
            VALUES (
            NULL,  
            '$_POST[judul]',
            '$_POST[video]',
            'video',
            '$tglawal',
            '$tglakhir')") or die (mysqli_error($DBcon));
      header('location:../../media_admin.php?module='.$module);
  }
  elseif ($module=='iklan' AND $act=='update_iklan'){
      $id = $_POST['idiklan'];
      $pos = $_POST['posisi'];
      $judul = $_POST['juduliklan'];

      if ($pos == 'header') {
        $isiiklan = $_POST['isiiklan'];
        $q = mysqli_query($DBcon, "UPDATE iklan SET 
            juduliklan = '$judul',
            isiiklan = '$isiiklan',
            tglawal = '$tglawal',
            tglakhir = '$tglakhir' WHERE idiklan='$id'") or die (mysqli_error($DBcon));
        if($q) {
          echo "<script>alert('Update Sukses');</script>";
          header('location:../../media_admin.php?module='.$module);
        } else {
          echo "Fail";
        }

      } elseif ($pos == 'video') {
        $video = $_POST['video'];
        $q = mysqli_query($DBcon, "UPDATE iklan SET 
            juduliklan = '$judul',
            isiiklan = '$video',
            tglawal = '$tglawal',
            tglakhir = '$tglakhir' WHERE idiklan='$id'") or die (mysqli_error($DBcon));
        if($q) {
          echo "<script>alert('Update Sukses');</script>";
          header('location:../../media_admin.php?module='.$module);
        } else {
          echo "Fail";
        }
      } else {
        if ($_FILES["gambar"]["tmp_name"]=="") {
            $q = mysqli_query($DBcon, "UPDATE iklan SET 
            juduliklan = '$judul',
            tglawal = '$tglawal',
            tglakhir = '$tglakhir' WHERE idiklan='$id'") or die (mysqli_error($DBcon));
             header('location:../../media_admin.php?module='.$module); 
        } else {
            // echo "Hallo";
            $error = false;
            $file_type = array('jpg','png','jpeg','JPG','PNG','JPEG');
            $max_size = 1000000;  
            $file_name = $_FILES['gambar']['name'];
            $file_size = $_FILES['gambar']['size'];
            $folder = '../../../files_gambar';
          
            $explode = explode(".", $file_name);
            $extensi  = $explode[count($explode)- 1];
            $random = rand(00000000,99999999);
            $file_namex = $random.$file_name;

             //check apakah type file sudah sesuai
            if((!isset($_FILES['gambar'])) OR (!in_array($extensi,$file_type))){
                  $error   = true;
                  $pesan .= '<div class="alert alert-warning">
                      <strong>Maaf</strong> - Type file yang Anda upload tidak sesuai
                    </div>';    
            }
            if($file_size > $max_size){
                  $error   = true;
                $pesan .= '<div class="alert alert-warning">
                      <strong>Maaf</strong> - Ukuran file melebihi batas maximum<br />
                    </div>';    
            } 

            if($error == true){
                echo '<div id="eror">'.$pesan.'</div>';
            } else {
                $q = mysqli_query($DBcon, "UPDATE iklan SET 
            juduliklan = '$judul',
            tglawal = '$tglawal',
            tglakhir = '$tglakhir',
            gambar = '$file_namex' WHERE idiklan='$id'") or die (mysqli_error($DBcon));

                 if (move_uploaded_file($_FILES['gambar']['tmp_name'], $folder.'/'.$file_namex)) {
                     header('location:../../media_admin.php?module='.$module); 
                 } else {
                    echo "Fail";
                 }
                
                 
            }
        }

      }

  }
 
  elseif ($module=='iklan' AND $act=='hapus_iklan'){
    mysqli_query($DBcon, "DELETE FROM iklan WHERE idiklan = '$_GET[idiklan]'");
    header('location:../../media_admin.php?module='.$module);
  }
     

}
?>
