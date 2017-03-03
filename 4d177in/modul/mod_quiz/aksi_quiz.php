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

$module=$_GET['module'];
$act=$_GET['act'];

if ($module=='quiz' AND $act=='input_topikquiz'){
    $pelajaran = mysqli_query($DBcon, "SELECT * FROM mata_pelajaran WHERE idtrkatalog = '$_POST[idtrkatalog]'");
    $data = mysqli_fetch_array($pelajaran);
    $pengajar = mysqli_query($DBcon, "SELECT * FROM pengajar WHERE id_pengajar = '$data[id_pengajar]'");
    $cek_pengajar_pelajaran = mysqli_num_rows($pengajar);
    if (!empty($cek_pengajar_pelajaran)){
    
    $wpengerjaan = $_POST['waktu'] * 60;
    mysqli_query($DBcon, "INSERT INTO topik_quiz(
                                    judul,
                                    idtrkatalog,
                                    tgl_buat,
                                    pembuat,
                                    waktu_pengerjaan,
                                    info,
                                    terbit)
                            VALUES('$_POST[judul]',
                                   '$_POST[idtrkatalog]',
                                   '$tgl_sekarang',
                                   '$data[id_pengajar]',
                                   '$wpengerjaan',
                                   '$_POST[info]',
                                   '$_POST[terbit]')");
    }else{
        $wpengerjaan = $_POST['waktu'] * 60;
        mysqli_query($DBcon, $DBcon, "INSERT INTO topik_quiz(
                                    judul,
                                    idtrkatalog,
                                    tgl_buat,
                                    pembuat,
                                    waktu_pengerjaan,
                                    info,
                                    terbit)
                            VALUES('$_POST[judul]',
                                   '$_POST[idtrkatalog]',
                                   '$tgl_sekarang',
                                   '$_SESSION[leveluser]',
                                   '$wpengerjaan',
                                   '$_POST[info]',
                                   '$_POST[terbit]')");
    }
  header('location:../../media_admin.php?module='.$module);
}

elseif($module=='quiz' AND $act=='inputnilai'){
    mysqli_query($DBcon, "UPDATE siswa_sudah_mengerjakan SET dikoreksi = 'S'
                                                WHERE id_pelatihan ='$_POST[id_pelatihan]' AND id_users = '$_POST[id_users]'");
    mysqli_query($DBcon, "INSERT INTO nilai_soal_esay (id_pelatihan,id_users,nilai)
                                   VALUES ('$_POST[id_pelatihan]','$_POST[id_users]','$_POST[nilai]')");
    header('location:../../media_admin.php?module=quiz&act=daftaruseryangtelahmengerjakan&id_pelatihan='.$_POST[id_pelatihan]);
}

elseif($module=='quiz' AND $act=='inputeditnilai'){
    mysqli_query($DBcon, "UPDATE nilai_soal_esay SET nilai = '$_POST[nilai]' WHERE id_pelatihan ='$_POST[id_pelatihan]' AND id_users = '$_POST[id_users]' ");
    header('location:../../media_admin.php?module=quiz&act=daftaruseryangtelahmengerjakan&id_pelatihan='.$_POST[id_pelatihan]);
}


elseif($module=='acara' AND $act=='editusersyangtelahmengerjakan'){
    mysqli_query($DBcon, "DELETE FROM users_sudah_mengerjakan WHERE id_users='$_GET[id_users]' AND id_pelatihan = '$_GET[id_pelatihan]'");
    mysqli_query($DBcon, "DELETE FROM nilai_soal_esay WHERE id_pelatihan='$_GET[id_tq]' AND id_users='$_GET[id_siswa]'");
    mysqli_query($DBcon, "DELETE FROM nilai WHERE id_pelatihan='$_GET[id_pelatihan]' AND id_users='$_GET[id_users]'");
    mysqli_query($DBcon, "DELETE FROM jawaban WHERE id_pelatihan='$_GET[id_pelatihan]' AND id_users ='$_GET[id_users]'");
    header('location:../../media_admin.php?module='.$module);

}
elseif($module=='quiz' AND $act=='edit_topikquiz'){
$pengajar = mysqli_query($DBcon, "SELECT * FROM pengajar WHERE id_pengajar = '$data[id_pengajar]'");
    $cek_pengajar_pelajaran = mysqli_num_rows($pengajar);
    if (!empty($cek_pengajar_pelajaran)){
    $waktu = $_POST['waktu'] * 60;
    mysqli_query($DBcon, "UPDATE topik_quiz SET judul = '$_POST[judul]',
                                        idtrkatalog = '$_POST[idtrkatalog]',
                                        tgl_buat = '$tgl_sekarang',
                                        pembuat = '$_SESSION[leveluser]',
                                        waktu_pengerjaan = '$waktu',
                                        info = '$_POST[info]',
                                        terbit = '$_POST[terbit]'
                             WHERE id_pelatihan = '$_POST[id]'");
    }else{
        $waktu = $_POST['waktu'] * 60;
        mysqli_query($DBcon, "UPDATE topik_quiz SET judul = '$_POST[judul]',
                                        idtrkatalog = '$_POST[idtrkatalog]',
                                        tgl_buat = '$tgl_sekarang',
                                        pembuat = '$_SESSION[leveluser]',
                                        waktu_pengerjaan = '$waktu',
                                        info = '$_POST[info]',
                                        terbit = '$_POST[terbit]'
                             WHERE id_pelatihan = '$_POST[id]'") or die (mysql_error());
    }
header('location:../../media_admin.php?module='.$module);
}

elseif($module=='quiz' AND $act=='editsiswayangtelahmengerjakan'){
    mysqli_query($DBcon, "DELETE FROM siswa_sudah_mengerjakan WHERE id_users='$_GET[id_users]' AND id = '$_GET[id_pelatihan]'");
    mysqli_query($DBcon, "DELETE FROM nilai_soal_esay WHERE id_pelatihan='$_GET[id_pelatihan]' AND id_users='$_GET[id_users]'");
    mysqli_query($DBcon, "DELETE FROM nilai WHERE id_pelatihan='$_GET[id_pelatihan]' AND id_users='$_GET[id_users]'");
    mysqli_query($DBcon, "DELETE FROM jawaban WHERE id_pelatihan='$_GET[id_pelatihan]' AND id_users ='$_GET[id_users]'");
    header('location:../../media_admin.php?module='.$module);

}
elseif($module=='quiz' AND $act=='pendaftaran'){
  $cekdata="SELECT * FROM pendaftaran where NIK='$_POST[NIK]' and nama_acara='$_POST[nama_pelatihan]'"; 
  $ada=mysqli_query($DBcon, $cekdata); 
  if (mysqli_num_rows($ada)>0) {
    echo "
  <script>
      window.alert('Maaf $_SESSION[namalengkap] Anda Sudah Mendaftar Pelatihan')
      window.location=(href='../../../media.php?module=quiz&act=pendaftaranlearning')
  </script>";
  }else{
    if (mysqli_query($DBcon, "INSERT INTO pendaftaran (id_daftar,id_pelatihan,id_trkatalog,nama_acara,NIK,tanggal_daftar)
                                     VALUES ('$_POST[id_daftar]','$_POST[id_pelatihan]','$_POST[id_trkatalog]','$_POST[nama_pelatihan]','$_POST[NIK]','$tgl_sekarang')"))
     {
      echo "<script>
        window.alert('Selamat $_SESSION[namalengkap] Anda Berhasil Mendaftar Pelatihan')
        window.location=(href='../../../media.php?module=quiz&act=pendaftaranlearning')
            </script>";
      }
    else {
      echo "<script>
      window.alert('Maaf $_SESSION[namalengkap] Anda Gagal Mendaftar Pelatihan, Hubungi Admin Untuk Masalah Ini.')
      window.location=(href='../../../media.php?module=quiz&act=pendaftaranlearning')
            </script>";
          }
        } 
  }

elseif($module=='quiz' AND $act=='hapustopikquiz'){
    //hapus topik
  mysqli_query($DBcon, "DELETE FROM topik_quiz WHERE id_pelatihan = '$_GET[id_pelatihan]'");
  //hapus kuiz esay
  $cek = mysqli_query($DBcon, "SELECT * FROM quiz_esay WHERE id_pelatihan = '$_GET[id_pelatihan]'");
     $r = mysqli_fetch_array($cek);
     if(empty($r[gambar])){
        mysqli_query($DBcon, "DELETE FROM quiz_esay WHERE id_pelatihan = '$_GET[id_pelatihan]'");
     }else{
         $img = "../../../foto_soal/$r[gambar]";
         unlink($img);
         $img2 = "../../../foto_soal/medium_$r[gambar]";
         unlink($img2);
         mysqli_query($DBcon, "DELETE FROM quiz_esay WHERE id_pelatihan = '$_GET[id_pelatihan]'");
     }
  //hapus kuiz pilihan ganda
  $cek2 = mysqli_query($DBcon, "SELECT * FROM quiz_pilganda WHERE id_pelatihan = '$_GET[id_pelatihan]'");
     $r2 = mysqli_fetch_array($cek2);
     if(empty($r2[gambar])){
        mysqli_query($DBcon, "DELETE FROM quiz_pilganda WHERE id_pelatihan = '$_GET[id_pelatihan]'");
     }else{
         $img = "../../../foto_soal_pilganda/$r2[gambar]";
         unlink($img);
         $img2 = "../../../foto_soal_pilganda/medium_$r2[gambar]";
         unlink($img2);
         mysqli_query($DBcon, "DELETE FROM quiz_pilganda WHERE id_pelatihan = '$_GET[id_pelatihan]'");
     }
  header('location:../../media_admin.php?module='.$module);
}


elseif($module=='quiz' AND $act=='input_quizesay'){
  $lokasi_file = $_FILES['fupload']['tmp_name'];
  $nama_file   = $_FILES['fupload']['name'];
  $direktori_file = "../../../foto_soal/$nama_file";
  $tipe_file = $_FILES['fupload']['type'];
  
  // Apabila ada gambar yang diupload
  if (!empty($lokasi_file)){
        if (file_exists($direktori_file)){
            echo "<script>window.alert('Nama file sudah ada, mohon diganti dulu');
            window.location=(href='../../media_admin.php?module=quiz&&act=buatquizesay&id_pelatihan=$_POST[id_pelatihan]')</script>";
        }else{
            if($tipe_file != "image/jpeg" AND
               $tipe_file != "image/jpg"             
            ){
                echo "<script>window.alert('Tipe File tidak di ijinkan.');
                window.location=(href='../../media_admin.php?module=quiz&act=buatquizesay&id_pelatihan=$_POST[id_pelatihan]')</script>";
            }else{
                UploadImage_soal($nama_file);
                mysqli_query($DBcon, "INSERT INTO quiz_esay(id_pelatihan,pertanyaan,gambar,tgl_buat)
                   VALUES('$_POST[id_pelatihan]','$_POST[pertanyaan]','$nama_file','$tgl_sekarang')");
            }
        }     
    }else{
        mysqli_query($DBcon, "INSERT INTO quiz_esay(id_pelatihan,pertanyaan,tgl_buat)
                   VALUES('$_POST[id_pelatihan]','$_POST[pertanyaan]','$tgl_sekarang')");
    }
header('location:../../media_admin.php?module=daftarquizesay&act=daftarquizesay&id_pelatihan='.$_POST[id_pelatihan]);
}

elseif($module=='quiz' AND $act=='input_quizpilganda'){
    $lokasi_file = $_FILES['fupload']['tmp_name'];
    $nama_file   = $_FILES['fupload']['name'];
    $direktori_file = "../../../foto_soal_pilganda/$nama_file";
    $tipe_file = $_FILES['fupload']['type'];

     // Apabila ada gambar yang diupload
  if (!empty($lokasi_file)){
      if (file_exists($direktori_file)){
            echo "<script>window.alert('Nama file sudah ada, mohon diganti dulu');
            window.location=(href='../../media_admin.php?module=buatquizpilganda&&act=buatquizpilganda&id_pelatihan=$_POST[id_pelatihan]')</script>";
        }else{
            if($tipe_file != "image/jpeg" AND
               $tipe_file != "image/jpg"
            ){
                echo "<script>window.alert('Tipe File tidak di ijinkan.');
                window.location=(href='../../media_admin.php?module=buatquizpilganda&act=buatquizpilganda&id_pelatihan=$_POST[id_pelatihan]')</script>";
            }else{
                UploadImage_soal_pilganda($nama_file);
                mysqli_query($DBcon, "INSERT INTO quiz_pilganda(id_pelatihan,pertanyaan,gambar,pil_a,pil_b,pil_c,pil_d,kunci,tgl_buat)
                   VALUES('$_POST[id_pelatihan]','$_POST[pertanyaan]','$nama_file','$_POST[pila]','$_POST[pilb]','$_POST[pilc]','$_POST[pild]','$_POST[kunci]','$tgl_sekarang')");
            }
        }
    }else{
        mysqli_query($DBcon, "INSERT INTO quiz_pilganda(id_pelatihan,pertanyaan,pil_a,pil_b,pil_c,pil_d,kunci,tgl_buat)
                   VALUES('$_POST[id_pelatihan]','$_POST[pertanyaan]','$_POST[pila]','$_POST[pilb]','$_POST[pilc]','$_POST[pild]','$_POST[kunci]','$tgl_sekarang')");
    }          
    header('location:../../media_admin.php?module=daftarquizpilganda&act=daftarquizpilganda&id_pelatihan='.$_POST[id_pelatihan]);
}

elseif($module=='quiz' AND $act=='edit_quizesay'){
  $lokasi_file = $_FILES['fupload']['tmp_name'];
  $nama_file   = $_FILES['fupload']['name'];
  $direktori_file = "../../../foto_soal/$nama_file";
  $tipe_file = $_FILES['fupload']['type'];

  // Apabila ada gambar yang diupload
  if (!empty($lokasi_file)){
        if (file_exists($direktori_file)){
            echo "<script>window.alert('Nama file sudah ada, mohon diganti dulu');
            window.location=(href='../../media_admin.php?module=daftarquizesay&act=daftarquizesay&id_pelatihan=$_POST[topik]')</script>";
        }else{
            if($tipe_file != "image/jpeg" AND
               $tipe_file != "image/jpg"               
            ){
                echo "<script>window.alert('Tipe File tidak di ijinkan.');
                window.location=(href='?module=quiz&act=daftarquizesay&id_pelatihan=$_POST[topik]')</script>";
            }else{
                $cek = mysqli_query($DBcon, "SELECT * FROM quiz_esay WHERE id_quiz = '$_POST[id_quiz]'");
                $r = mysqli_fetch_array($cek);
                if(!empty($r[gambar])){
                $img = "../../../foto_soal/$r[gambar]";
                unlink($img);
                $img2 = "../../../foto_soal/medium_$r[gambar]";
                unlink($img2);
                UploadImage_soal($nama_file);
                mysqli_query($DBcon, "UPDATE quiz_esay SET pertanyaan = '$_POST[pertanyaan]',
                                                  gambar     = '$nama_file',
                                                  tgl_buat   = '$tgl_sekarang'
                                            WHERE id_quiz = '$_POST[id_quiz]'");
                }else{
                    UploadImage_soal($nama_file);
                    mysqli_query($DBcon, "UPDATE quiz_esay SET pertanyaan = '$_POST[pertanyaan]',
                                                  gambar     = '$nama_file',
                                                  tgl_buat   = '$tgl_sekarang'
                                            WHERE id_quiz = '$_POST[id_quiz]'");
                }
            }
        }
    }else{
        mysqli_query($DBcon, "UPDATE quiz_esay SET pertanyaan = '$_POST[pertanyaan]',
                                          tgl_buat   = '$tgl_sekarang'
                                       WHERE id_quiz = '$_POST[id_quiz]'");
    }
    header('location:../../media_admin.php?module=daftarquizesay&act=daftarquizesay&id_pelatihan='.$_POST[id_pelatihan]);
}

elseif($module=='quiz' AND $act=='hapusquizesay'){
     $cek = mysqli_query($DBcon, "SELECT * FROM quiz_esay WHERE id_quiz = '$_GET[id_quiz]'");
     $r = mysqli_fetch_array($cek);
     if(empty($r[gambar])){
        mysqli_query($DBcon, "DELETE FROM quiz_esay WHERE id_quiz = '$_GET[id_quiz]'");
     }else{
         $img = "../../../foto_soal/$r[gambar]";
         unlink($img);
         $img2 = "../../../foto_soal/medium_$r[gambar]";
         unlink($img2);
         mysqli_query($DBcon, "DELETE FROM quiz_esay WHERE id_quiz = '$_GET[id_quiz]'");
     }
     header('location:../../media_admin.php?module=daftarquizesay&act=daftarquizesay&id_pelatihan='.$_GET[id_pelatihan]);
}

elseif($module=='quiz' AND $act=='edit_quizpilganda'){
    $lokasi_file = $_FILES['fupload']['tmp_name'];
    $nama_file   = $_FILES['fupload']['name'];
    $direktori_file = "../../../foto_soal_pilganda/$nama_file";
    $tipe_file = $_FILES['fupload']['type'];

    // Apabila ada gambar yang diupload
  if (!empty($lokasi_file)){
      if (file_exists($direktori_file)){
            echo "<script>window.alert('Nama file sudah ada, mohon diganti dulu');
            window.location=(href='../../media_admin.php?module=daftarquizpilganda&act=daftarquizpilganda&id_pelatihan=$_POST[topik]')</script>";
        }else{
            if($tipe_file != "image/jpeg" AND
               $tipe_file != "image/jpg"
            ){
                echo "<script>window.alert('Tipe File tidak di ijinkan.');
                window.location=(href='../../media_admin.php?module=daftarquizpilganda&act=daftarquizpilganda&id_pelatihan=$_POST[topik]')</script>";
            }else{
                $cek = mysqli_query($DBcon, "SELECT * FROM quiz_pilganda WHERE id_pelatihan = '$_POST[id]'");
                $r = mysqli_fetch_array($cek);
                if(!empty($r[gambar])){
                $img = "../../../foto_soal_pilganda/$r[gambar]";
                unlink($img);
                $img2 = "../../../foto_soal_pilganda/medium_$r[gambar]";
                unlink($img2);
                UploadImage_soal_pilganda($nama_file);
                mysqli_query($DBcon, "UPDATE quiz_pilganda SET pertanyaan = '$_POST[pertanyaan]',
                                           gambar     = '$nama_file',
                                           pil_a      = '$_POST[pila]',
                                           pil_b      = '$_POST[pilb]',
                                           pil_c      = '$_POST[pilc]',
                                           pil_d      = '$_POST[pild]',
                                           kunci      = '$_POST[kunci]',
                                           tgl_buat   = '$tgl_sekarang'
                                        WHERE id_quiz = '$_POST[id_quiz]'");
                }else{
                    UploadImage_soal_pilganda($nama_file);
                    mysqli_query($DBcon, "UPDATE quiz_pilganda SET pertanyaan = '$_POST[pertanyaan]',
                                           gambar     = '$nama_file',
                                           pil_a      = '$_POST[pila]',
                                           pil_b      = '$_POST[pilb]',
                                           pil_c      = '$_POST[pilc]',
                                           pil_d      = '$_POST[pild]',
                                           kunci      = '$_POST[kunci]',
                                           tgl_buat   = '$tgl_sekarang'
                                        WHERE id_quiz = '$_POST[id_quiz]'");
                }
            }
        }
    }else{
        mysqli_query($DBcon, "UPDATE quiz_pilganda SET pertanyaan = '$_POST[pertanyaan]',
                                           pil_a      = '$_POST[pila]',
                                           pil_b      = '$_POST[pilb]',
                                           pil_c      = '$_POST[pilc]',
                                           pil_d      = '$_POST[pild]',
                                           kunci      = '$_POST[kunci]',
                                           tgl_buat   = '$tgl_sekarang'
                                        WHERE id_quiz = '$_POST[id_quiz]'");
    }
     header('location:../../media_admin.php?module=daftarquizpilganda&act=daftarquizpilganda&id_pelatihan='.$_POST[id_pelatihan]);
}

elseif($module=='quiz' AND $act=='hapusquizpilganda'){
    $cek = mysqli_query($DBcon, "SELECT * FROM quiz_pilganda WHERE id_quiz = '$_GET[id_quiz]'");
     $r = mysqli_fetch_array($cek);
     if(empty($r[gambar])){
        mysqli_query($DBcon, "DELETE FROM quiz_pilganda WHERE id_quiz = '$_GET[id_quiz]'");
     }else{
         $img = "../../../foto_soal_pilganda/$r[gambar]";
         unlink($img);
         $img2 = "../../../foto_soal_pilganda/medium_$r[gambar]";
         unlink($img2);
         mysqli_query($DBcon, "DELETE FROM quiz_pilganda WHERE id_quiz = '$_GET[id_quiz]'");
     }
     header('location:../../media_admin.php?module=daftarquizpilganda&act=daftarquizpilganda&id_pelatihan='.$_GET[id_pelatihan]);
}


}
?>
