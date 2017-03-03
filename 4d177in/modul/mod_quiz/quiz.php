         <hr>
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4>Kuis</h4>
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">

<script>
  function confirmdelete(delUrl) {
    if (confirm("Anda yakin ingin menghapus?")) {
    document.location = delUrl;
    }
  }
 $(function() {
        $("#soalnya").on("submit", function () {
            location.href = "http://stackoverflow.com";
        });
    });
</script>
<?php
function fsize($file){
                            $a = array("B", "KB", "MB", "GB", "TB", "PB");
                            $pos = 0;
                            $size = filesize($file);
                            while ($size >= 1024)
                            {
                            $size /= 1024;
                            $pos++;
                            }
                            return round ($size,2)." ".$a[$pos];
                            }
?>


<?php
session_start();
 if (empty($_SESSION['username']) AND empty($_SESSION['passuser'])){
   echo "<link href=../css/style.css rel=stylesheet type=text/css>";
   echo "<div class='error msg'>Untuk mengakses Modul anda harus login.</div>";
}
else{

$aksi="modul/mod_quiz/aksi_quiz.php";
$aksi_users = "4d177in/modul/mod_quiz/aksi_quiz.php";
include "../../../configurasi/class_paging.php";
include "../../../configurasi/fungsi_kodependaftaran.php";

switch($_GET[act]){
  // Tampil topik quiz
  default:
      
    if ($_SESSION[leveluser]=='admin'){    
      echo "Hello!!!";
    }    
    elseif ($_SESSION[leveluser]=='pengajar'){
    $tampil_topik = mysqli_query($DBcon, "SELECT * FROM pelatihan");
        echo "<h2>Daftar Topik Quiz</h2><hr>
        <div class='col-md-2'>
        <a class=\"btn btn-block btn-social btn-dropbox\" href='?module=quiz&act=tambahtopikquiz';>
            <i class=\"fa fa-plus\"></i> Tambah Post Test
        </a></div></br></br>";

        echo "<br><br>
        <table width=\"100%\" class=\"table table-striped table-bordered table-hover\" id=\"dataTables-example\"><thead>
          <tr><th>No</th><th>Judul</th><th>Tgl Buat</th><th>Lama Pengerjaan</th><th>Info</th><th>Terbit</th><th>Aksi</th></tr></thead>";
        
        
        $no=1;
        while ($r=mysqli_fetch_array($tampil_topik)){
        $wpengerjaan = $r[waktu_pengerjaan] / 60;
        $tgl_buat   = tgl_indo($r[tgl_buat]);
        echo "<tr><td>$no</td>
             <td>$r[judul]</td>
         <td>$tgl_buat</td>
             <td>$wpengerjaan menit</td>
             <td>$r[info]</td>
             <td><p align='center'>$r[terbit]</p></td>
             <td><a href='?module=quiz&act=edittopikquiz&id_pelatihan=$r[id_pelatihan]' title='Edit'><i class='fa fa-edit' alt='Edit'> </i> | 
                         <a href=javascript:confirmdelete('$aksi?module=quiz&act=hapustopikquiz&id_pelatihan=$r[id_pelatihan]') title='Hapus'><i class='fa fa-trash' alt='Delete'> </i></a><br><br>
                 <input type=button class='button small white' value='Buat Quiz' onclick=\"window.location.href='?module=buatquiz&act=buatquiz&id_pelatihan=$r[id_pelatihan]';\"></input><br>
                <input type=button class='button small white' value='Daftar Quiz' onclick=\"window.location.href='?module=daftarquiz&act=daftarquiz&id_pelatihan=$r[id_pelatihan]';\"></input><br>
                <input type=button class='button small white' value='Peserta & koreksi' onclick=\"window.location.href='?module=acara&act=daftarusersyangtelahmengerjakan&id_pelatihan=$r[id_pelatihan]';\"></input></td></tr>";
      $no++;
    }
    echo "</table>";      
    }
    elseif ($_SESSION[leveluser]=='users'){
    echo "<div class='panel-body'>
            <div class='row'>
    <div class='col-lg-6'>
        <form action='simpan-daftar.php' method='POST' role='form'>
            <div class='form-group'>
                <label>Id Pendaftaran Pelatihan</label>
                <input class='form-control'type='text' name='id_daftar' value='$kode'readonly/>
            </div>

            <div class='form-group'>
                <label>Nama Pelatihan</label>
                <select class='form-control'name='nama_acara'>
                <option value=Nama Pelatihan> Nama Pelatihan 
                </option>
                </select>
            </div>

            <div class='form-group'>
                <label>No. Cek</label>
                <input class='form-control'
                        name='NIK' type='text' value='".$_SESSION[NIK]."' readonly/>
                <p class='help-block'>Nomor Cek Pegawai Tidak Dapat Di Ubah.</p>
            </div>

            <button type='submit' class='btn btn-primary'>Simpan</button>
            <button type='reset' class='btn btn-warning'>Reset</button>

        </form>
    </div>
</div>";
    }
    break;

case 'pendaftaranlearning':
    if ($_SESSION[leveluser]=='users') {
        echo "
        <table width=\"100%\" class=\"table table-striped table-bordered table-hover\" id=\"dataTables-example\">
          <thead>
              <tr>
                <th>No</th>
                <th>Nama Learning</th>
                <th>Rincian</th>
              </tr>
          </thead>";    
          $tampil_pelatihan = mysqli_query($DBcon, 'SELECT * FROM pelatihan where pengikut LIKE "%'.$_SESSION[NIK].'%"'); 
              $no=1;
        while ($r=mysqli_fetch_array($tampil_pelatihan)){ 
      echo "<tr>
              <td>$no</td>
              <td>$r[nama_pelatihan]</td>
              <td>
                <center>
                <input type='button' class='btn btn-default' value='Rincian Learning'onclick=\"window.location.href='?module=quiz&act=rincianlearning&id_pelatihan=$r[id_pelatihan]';\"/>
                </center>
              </td>
            </tr>";
          $no++;
        }echo "
      </table>";
  }
    break;

case 'daftarlearning': 
if ($_SESSION[leveluser]=='users') {
$tampil_pelatihan = mysqli_query($DBcon, "SELECT * FROM pelatihan where id_pelatihan = '$_GET[id_pelatihan]'"); 
$ambil = mysqli_query($DBcon, "SELECT * FROM pendaftaran" );
$cek = mysqli_num_rows( $ambil );  
if ( empty( $cek ) ){
  $kode = 1;
} else {
  $kode = $cek + 1; 
}

$m=mysqli_fetch_array($tampil_pelatihan);
    echo "<div class='panel-body'>
<div class='row'>
<p id='berhasil'></p>
    <div class='col-lg-6'>
                          <form method=POST action='$aksi_users?module=quiz&act=pendaftaran'>
                          <input type='hidden' name='id_pelatihan' value='$m[id_pelatihan]'/>
                          <input type='hidden' name='id_trkatalog' value='$m[id_trkatalog]'/>
            <div class='form-group'>
                <label>ID Pendaftaran Pelatihan</label>
                <input class='form-control'type='text' name='id_daftar' value='PDFT-$kode' readonly/>
            </div>

            <div class='form-group'>
                <label>Nama Pelatihan</label>
                <input class='form-control' name='nama_pelatihan' value='$m[nama_pelatihan]' readonly>
            </div>

            <div class='form-group'>
                <label>No. Cek</label>
                <input class='form-control'
                        name='NIK' type='text' value='".$_SESSION[NIK]."' readonly/>
                <p class='help-block'>Nomor Cek Pegawai Tidak Dapat Di Ubah.</p>
            </div>

            <input class='btn btn-danger' type='button' onclick=\"window.location.href='?module=quiz&act=pendaftaranlearning';\" value='Kembali'>
            <input class='btn btn-primary'  type='submit' value='Daftar'>


        </form>
    </div>
</div>";
                          }
  break;

case 'posttest':
  if ($_SESSION[leveluser]=='users') {
    $users = mysqli_query($DBcon, "SELECT * FROM users WHERE NIK = '$_SESSION[NIK]'");
        $q = mysqli_fetch_array($users);
        $mapel = mysqli_query($DBcon, "SELECT * FROM pendaftaran WHERE NIK = '$q[NIK]'");
        $cek_mapel = mysqli_num_rows($mapel);        
        if (!empty($cek_mapel)){
            echo"<b class='judul'>Daftar Pelatihan Anda</b><br><p class='garisbawah'></p>
            <table width=\"100%\" class=\"table table-striped table-bordered table-hover\" id=\"dataTables-example\"><thead>
            <tr><th>No</th><th>ID Daftar</th><th>Nama Pelatihan</th><th>No Cek</th><th>Tanggal Daftar</th><th>Aksi</th></tr></thead>";
            $no=1;
            while ($t=mysqli_fetch_array($mapel)){                
                echo "<tr><td>$no</td>
                        <td>$t[id_daftar]</td>
                        <td>$t[nama_acara]</td>
                        <td>$t[NIK]</td>
                        <td>$t[tanggal_daftar]</td>";                   
                        
                        echo"<td><input type=button class='btn btn-primary' value='POST TEST'
                       onclick=\"window.location.href='?module=quiz&act=daftartopik&id_users=$_SESSION[NIK]&id_trkatalog=$t[id_trkatalog]';\"></td></tr>";
            $no++;
            }
            echo"</table>";
        }else{
            echo "<script>window.alert('Anda Belum Terdaftar Dipelatihan. Silakan Mendaftar Terlebih Dahulu Di Menu Learning -> Pendaftaran Learning.');
                    window.location=(href='media.php?module=home')</script>";
        }
    }
  break;
case 'rincianlearning':
if ($_SESSION[leveluser]=='users') {

$cekaktivitasusers=mysqli_query($DBcon, "SELECT * FROM riwayat_aktivitas_users WHERE id_pelatihan='$_GET[id_pelatihan]' and idusers='$_SESSION[NIK]'"); 
$hasilcek = mysqli_fetch_array($cekaktivitasusers);

$kueri=mysqli_query($DBcon, "SELECT * FROM pelatihan WHERE id_pelatihan='$_GET[id_pelatihan]'"); 
$data = mysqli_fetch_array($kueri);
$kueri2=mysqli_query($DBcon, "SELECT * FROM pelatihan WHERE id_pelatihan='$_GET[id_pelatihan]'"); 

$cek_materi = mysqli_num_rows($kueri2);
if (!empty($cek_materi)){
  echo"Daftar File Materi $data[nama_pelatihan]<br><hr>";
  echo "<table width=\"100%\" class=\"table table-striped table-bordered table-hover\" id=\"dataTables-example\">
    <thead>
      <tr>
        <th>No</th>
        <th>Nama File</th>
        <th>Ukuran</th>
        <th>Jenis File</th>
        <th>Tgl Pelatihan</th>
        <th>Tgl Berakhir</th>
        <th>Hits</th>
        <th>Download </th>
      </tr>
    </thead>";
  $no=$posisi+1;
  while ($r=mysqli_fetch_array($kueri2)){
  $tanggal_pelaksanaan   = tgl_indo($r[tanggal_pelaksanaan]);
  $tgl_berakhir   = tgl_indo($r[tanggal_selesai]);
  $kueri3=mysqli_query($DBcon, "SELECT * FROM file_materi WHERE id_file='$data[materi]'"); 
        $cek_materi = mysqli_fetch_array($kueri3);
  echo "
  <tr>
    <td>$no</td>
    <td id='p'>$cek_materi[nama_file]</td>"; 
      if (!empty($cek_materi[nama_file])){
      $file = "files_materi/$cek_materi[nama_file]";      
      echo "
      <td> ". fsize($file)."</td>";
      }else{
          echo "
      <td></td>";
      }
  if (!empty($cek_materi[nama_file])){
  $pecah = explode(".", $cek_materi[nama_file]);
  $ekstensi = $pecah[1];
  if ($ekstensi == 'zip'){
      echo "
    <td style='vertical-align:middle;  color:blue;text-align:center; display: table-cell;'><i class='fa fa-file-zip-o fa-5x'></td>";
  }
  elseif ($ekstensi == 'rar'){
      echo "<
    td style='vertical-align:middle;  color:blue;text-align:center; display: table-cell;'><i class='fa fa-file-archive-o fa-5x'></td>";
  }
  elseif ($ekstensi == 'doc'){
      echo "
    <td style='vertical-align:middle;  color:blue;text-align:center; display: table-cell;'><i class='fa fa-file-word-o fa-5x'></td>";
  }
  elseif ($ekstensi == 'pdf'){
      echo "
    <td style='vertical-align:middle;  color:blue;text-align:center; display: table-cell;'><i class='fa fa-file-pdf-o fa-5x'></td>";
  }
  elseif ($ekstensi == 'ppt'){
      echo "
    <td style='vertical-align:middle;  color:blue;text-align:center; display: table-cell;'><i class='fa fa-file-powerpoint-o fa-5x'></td>";
  }
  elseif ($ekstensi == 'pptx'){
      echo "
    <td style='vertical-align:middle;  color:blue;text-align:center; display: table-cell;'><i class='fa fa-file-powerpoint-o fa-5x'></td>";
  }
  elseif ($ekstensi == 'docx'){
      echo "
    <td style='vertical-align:middle;  color:blue;text-align:center; display: table-cell;'><i class='fa fa-file-word-o fa-5x'></td>";
  }
  }else{
      echo "
    <td style='vertical-align:middle;  color:blue;text-align:center; display: table-cell;'><i class='fa fa-warning fa-5x'></td>";
  }
 
  echo"
 <td>$tanggal_pelaksanaan</td>
 <td>$tgl_berakhir</td>
 <td>$r[hits]</b></td>
    <td><!-- Trigger the modal with a button -->
              <button type='button' class='btn btn-info' data-toggle='modal' data-target='#myModal'>Lihat File</button>

              <!-- Modal -->
              <div id='myModal' class='modal fade ' role='dialog'>
                <div class='modal-dialog'>

                  <!-- Modal content-->
                  <div class='modal-content'>
                    <div class='modal-header'>
                      <button type='button' class='close' data-dismiss='modal'>&times;</button>
                      <h4 class='modal-title'>Modal Header</h4>
                      <ul class='text-center list-inline modal-actions'>
                        <li>
                          <a href='#' id='modal-fullscreen' role='button' title='Toggle fullscreen'>
                          <i class='glyphicon glyphicon-resize-full'></i>
                          </a>
                        </li>
                    </ul>
                    </div>
                    <div class='modal-body'>
                      <div class='embed-responsive embed-responsive-16by9' style='padding-bottom:150%'>
                          <object class='embed-responsive-item' data='files_materi/$cek_materi[nama_file]' type='application/pdf' width='100%' height='100%'>
                          </object>
                      </div>
                    <div class='panel-footer text-center'>
                    <input id='a' type='button' class=\"btn btn-info\" value='Unduh File' onclick=\"window.location.href='download_pelatihan.php?file=$r[materi]&id_users=$_SESSION[NIK]&id_pelatihan=$_GET[id_pelatihan]';\">
                    </div>
                    </div>
                    
                  </div>

                </div>
              </div>
    </td>
  </tr>";
        $no++;
        }
        echo "
  </table>
  <input type=button class=\"btn btn-danger\" value='Kembali' onclick=self.history.back()>";
  if ($hasilcek > 0) {
 echo " <input type='button' id='b' class='coba btn btn-primary pull-right' value='POST TEST' onclick=\"window.location.href='?module=quiz&act=daftartopik&id_pelatihan=$_GET[id_pelatihan]'; klik()\">
    <span class='blink'>Anda sudah pernah mengunduh file ini.</span>";
  }else{
 echo "<input type='button' id='b' class='coba btn btn-primary pull-right' value='POST TEST' onclick=\"window.location.href='?module=quiz&act=daftartopik&id_pelatihan=$_GET[id_pelatihan]'; klik()\" disabled>";
  }
    }
    else{
        echo "<script>window.alert('Tidak ada file materi.');
        window.location=(href='media.php?module=quiz&act=pendaftaranlearning')</script>";
    }
}
break;
case "daftarusersyangtelahmengerjakan":
    if ($_SESSION[leveluser]=='admin'){
        $users_yangmengerjakan = mysqli_query($DBcon, "SELECT * FROM users_sudah_mengerjakan WHERE id_pelatihan = '$_GET[id_pelatihan]'");
        $cek_users = mysqli_num_rows($users_yangmengerjakan);

        if (!empty($cek_users)){
        echo "<h3>Daftar User Yang Telah Mengikuti Ujian</h3><hr>";
        echo "<br><div class='information msg'>
         Pilih Aksi <b>Hapus User</b> jika ingin mereset User yang telah mengikuti ujian.<br>
        Hanya jawaban soal Essay yang bisa di koreksi.<br>
        Penilaian Soal Pilihan Ganda Sistem yang mengerjakan.</div>";

        $users_yangmengerjakan2 = mysqli_query($DBcon, "SELECT * FROM users_sudah_mengerjakan WHERE id_pelatihan = '$_GET[id_pelatihan]'");
        echo "<br><table width=\"100%\" class=\"table table-striped table-bordered table-hover\" id=\"dataTables-example\"><thead>
          <tr><th>No</th><th>Nama</th><th>Status</th><th>aksi</th></tr></thead>";
        
        $no=1;
        while ($t=mysqli_fetch_array($users_yangmengerjakan2)){
            $users = mysqli_query($DBcon, "SELECT * FROM users WHERE id_users = '$t[id_users]'");
            $s = mysqli_fetch_array($users);
            $nilai = mysqli_query($DBcon, "SELECT * FROM nilai_soal_esay WHERE id_pelatihan='$_GET[id_pelatihan]' AND id_users ='$t[id_users]'");
            $n = mysqli_fetch_array($nilai);
            $nilai2 = mysqli_query($DBcon, "SELECT * FROM nilai WHERE id_pelatihan='$_GET[id_pelatihan]' AND id_users = '$t[id_users]'");
            $n2 = mysqli_fetch_array($nilai2);
            echo "<tr><td>$no</td>                      
                      <td><a href=?module=users&act=detailusers&id_pelatihan=$s[id_users] title='Detail users'>$s[EmployeeName]</a></td>";
                      if ($t[dikoreksi]=='B'){
                          echo "<td>Jawaban soal essay <b>belum di koreksi</b>
        <br>Nilai Post Test Pilihan Ganda $n2[persentase]</td>";
                          echo "
                          <td><a href=$aksi?module=quiz&act=editusersyangtelahmengerjakan&id_pelatihan=$t[id]&id_users=$s[id_users]&id_pelatihan=$_GET[id_pelatihan]>Hapus User</a> |
                          <a href=?module=quiz&act=koreksi&id_pelatihan=$t[id_pelatihan]&id_users=$s[id_users]>Koreksi Jawaban Esay</a></td></tr>";
                      }else{
                          echo "<td>Jawaban soal essay <b>sudah di koreksi</b><br>Nilai Post Test Pilihan Ganda $n2[persentase]<br>";
                          echo "
                          <td><a href=$aksi?module=quiz&act=editusersyangtelahmengerjakan&id_pelatihan=$t[id]&id_users=$s[id_users]&id_pelatihan=$_GET[id_pelatihan]>Hapus User</a> |
                          <a href=?module=quiz&act=editkoreksi&id_pelatihan=$t[id_pelatihan]&id_users=$s[id_users]>Edit Koreksi</a></td></tr>";
                      }
                      
            $no++;
        }
        echo "</table>";
        echo "<br><input class=\"btn btn-danger\" type=button value=Kembali onclick=\"window.location.href='?module=acara';\">";
        
        }else{
            echo "<script>window.alert('Belum ada users yang mengikuti ujian.');
                    window.location=(href='media_admin.php?module=acara')</script>";
        }
    }
    elseif ($_SESSION[leveluser]=='pengajar'){
        $users_yangmengerjakan = mysqli_query($DBcon, "SELECT id_users FROM users_sudah_mengerjakan WHERE id_pelatihan = '$_GET[id_pelatihan]'");
        $cek_users = mysqli_num_rows($users_yangmengerjakan);

        if (!empty($cek_users)){

        $soal_pilganda = mysqli_query($DBcon, "SELECT * FROM quiz_pilganda WHERE id_pelatihan='$_GET[id_pelatihan]'");
        $pilganda = mysqli_num_rows($soal_pilganda);
        $soal_esay = mysqli_query($DBcon, "SELECT * FROM quiz_esay WHERE id_pelatihan='$_GET[id_pelatihan]'");
        $esay = mysqli_num_rows($soal_esay);
        if (!empty($pilganda) AND !empty($esay)){
        echo "<form><fieldset>
              <legend>users yang telah mengikuti ujian</legend>
              <dl class='inline'>";
         echo "<br><div class='information msg'>
        Pilih Aksi <b>Hapus User</b> jika ingin mereset User yang telah mengikuti ujian.<br>
        Hanya jawaban soal Essay yang bisa di koreksi.<br>
        Penilaian Soal Pilihan Ganda Sistem yang mengerjakan.</div>";

        $users_yangmengerjakan2 = mysqli_query($DBcon, "SELECT * FROM users_sudah_mengerjakan WHERE id_pelatihan = '$_GET[id_pelatihan]'");
        echo "<br><table width=\"100%\" class=\"table table-striped table-bordered table-hover\" id=\"dataTables-example\"><thead>
          <tr><th>No</th><th>ID Pelatihan</th><th>Nama</th><th>TR Katalog</th><th>Status</th><th>Aksi</th></tr></thead>";
        $no=1;
        while ($t=mysqli_fetch_array($users_yangmengerjakan2)){
            $users = mysqli_query($DBcon, "SELECT * FROM users WHERE id_users = '$t[id_users]'");
            $s = mysqli_fetch_array($users);
            $kelas = mysqli_query($DBcon, "SELECT * FROM kelas WHERE idtrkatalog = '$s[idtrkatalog]'");
            $k = mysqli_fetch_array($kelas);
            $nilai = mysqli_query($DBcon, "SELECT * FROM nilai_soal_esay WHERE id_pelatihan='$_GET[id_pelatihan]' AND id_users ='$t[id_users]'");
            $n = mysqli_fetch_array($nilai);
            $nilai2 = mysqli_query($DBcon, "SELECT * FROM nilai WHERE id_pelatihan='$_GET[id_pelatihan]' AND id_users = '$t[id_users]'");
            $n2 = mysqli_fetch_array($nilai2);
            echo "<tr><td>$no</td>
                      <td>$s[nis]</td>
                      <td><a href=?module=users&act=detailusers&id_pelatihan=$s[id_users] title='Detail users'>$s[EmployeeName]</a></td>
                      <td>$k[nama]</td>";
                      if ($t[dikoreksi]=='B'){
                          echo "<td>Jawaban soal essay <b>belum di koreksi</b>
        <br>Nilai Post Test Pilihan Ganda $n2[persentase]</td>";
                          echo "
                          <td><a href=$aksi?module=acara&act=editusersyangtelahmengerjakan&id_pelatihan=$t[id]&id_users=$s[id_users]&id_pelatihan=$_GET[id_pelatihan]>Hapus User</a> |
                          <a href=?module=quiz&act=koreksi&id_pelatihan=$t[id_pelatihan]&id_users=$s[id_users]>Koreksi Jawaban Esay</a></td></tr>";
                      }else{
                          echo "<td>Jawaban soal essay <b>sudah di koreksi</b><br>Nilai Post Test Pilihan Ganda $n2[persentase]<br>";
                          echo "
                          <td><a href=javascript:confirmdelete('$aksi?module=quiz&act=editusersyangtelahmengerjakan&id_pelatihan=$t[id]&id_users=$s[id_users]&id_pelatihan=$_GET[id_pelatihan]')>Hapus User</a> |
                          <a href=?module=acara&act=editkoreksi&id_pelatihan=$t[id_pelatihan]&id_users=$s[id_users]>Edit Koreksi</a></td></tr>";
                      }
            $no++;
        }
        echo "</table>
              <br><input class=\"btn btn-danger\" type=button value=Kembali onclick=self.history.back()>";
        }
        elseif (empty($pilganda) AND !empty($esay)){
         echo"<form><fieldset>
              <legend>users yang telah mengikuti ujian</legend>
              <dl class='inline'>";
         echo "<br><div class='information msg'>
        Pilih Aksi <b>Hapus User</b> jika ingin mereset User yang telah mengikuti ujian.<br>
        Hanya jawaban soal Essay yang bisa di koreksi.<br>
        Penilaian Soal Pilihan Ganda Sistem yang mengerjakan.</div>";

        $users_yangmengerjakan2 = mysqli_query($DBcon, "SELECT * FROM users_sudah_mengerjakan WHERE id_pelatihan = '$_GET[id_pelatihan]'");
        echo "<br><table width=\"100%\" class=\"table table-striped table-bordered table-hover\" id=\"dataTables-example\"><thead>
          <tr><th>No</th><th>ID Pelatihan</th><th>Nama</th><th>TR Katalog</th><th>Status</th><th>Aksi</th></tr></thead>";
        $no=1;
        while ($t=mysqli_fetch_array($users_yangmengerjakan2)){
            $users = mysqli_query($DBcon, "SELECT * FROM users WHERE id_users = '$t[id_users]'");
            $s = mysqli_fetch_array($users);
            $kelas = mysqli_query($DBcon, "SELECT * FROM kelas WHERE idtrkatalog = '$s[idtrkatalog]'");
            $k = mysqli_fetch_array($kelas);
            $nilai = mysqli_query($DBcon, "SELECT * FROM nilai_soal_esay WHERE id_pelatihan='$_GET[id_pelatihan]' AND id_users ='$t[id_users]'");
            $n = mysqli_fetch_array($nilai);
            echo "<tr><td>$no</td>
                      <td>$s[nis]</td>
                      <td><a href=?module=users&act=detailusers&id_pelatihan=$s[id_users] title='Detail users'>$s[EmployeeName]</a></td>
                      <td>$k[nama]</td>";
                      if ($t[dikoreksi]=='B'){
                          echo "<td>Jawaban soal essay <b>belum di koreksi</b></td>";
                          echo "
                          <td><a href=$aksi?module=acara&act=editusersyangtelahmengerjakan&id_pelatihan=$t[id]&id_users=$s[id_users]&id_pelatihan=$_GET[id_pelatihan]>Hapus User</a> |
                          <a href=?module=acara&act=koreksi&id_pelatihan=$t[id_pelatihan]&id_users=$s[id_users]>Koreksi Jawaban Esay</a></td></tr>";
                      }else{
                          echo "<td>Jawaban soal essay <b>sudah di koreksi</b><br>Nilai Post Test Essay$n[nilai]</td>";
                          echo "
                          <td><a href=$aksi?module=quiz&act=editusersyangtelahmengerjakan&id_pelatihan=$t[id]&id_users=$s[id_users]&id_pelatihan=$_GET[id_pelatihan]>Hapus User</a> |
                          <a href=?module=acara&act=editkoreksi&id_pelatihan=$t[id_pelatihan]&id_users=$s[id_users]>Edit Koreksi</a></td></tr>";
                      }
            $no++;
        }
        echo "</table>
        <br><input class=\"btn btn-danger\" type=button value=Kembali onclick=self.history.back()>";
        }
        elseif (!empty($pilganda) AND empty($esay)){
         echo "<form><fieldset>
              <legend>users yang telah mengikuti ujian</legend>
              <dl class='inline'>";
         echo "<br><div class='information msg'>
        Pilih Aksi <b>Hapus User</b> jika ingin mereset User yang telah mengikuti ujian.<br>
        Hanya jawaban soal Essay yang bisa di koreksi.<br>
        Penilaian Soal Pilihan Ganda Sistem yang mengerjakan.</div>";


        $users_yangmengerjakan2 = mysqli_query($DBcon, "SELECT * FROM users_sudah_mengerjakan WHERE id_pelatihan = '$_GET[id_pelatihan]'");
        echo "<br><table width=\"100%\" class=\"table table-striped table-bordered table-hover\" id=\"dataTables-example\"><thead>
          <tr><th>No</th><th>ID Pelatihan</th><th>Nama</th><th>TR Katalog</th><th>Status</th><th>Aksi</th></tr></thead>";
        $no=1;
        while ($t=mysqli_fetch_array($users_yangmengerjakan2)){

            $users = mysqli_query($DBcon, "SELECT * FROM users WHERE id_users = '$t[id_users]'");
            $s = mysqli_fetch_array($users);
            $cari=mysqli_query($DBcon, 'SELECT * FROM pelatihan where pengikut LIKE "%'.$s[NIK].'%"'); 
            $car = mysqli_fetch_array($cari);

            $kelas = mysqli_query($DBcon, "SELECT * FROM trkatalog WHERE idtrkatalog = '$car[idtrkatalog]'");
            $k = mysqli_fetch_array($kelas);
            $nilai = mysqli_query($DBcon, "SELECT * FROM nilai_soal_esay WHERE id_pelatihan='$_GET[id_pelatihan]' AND id_users ='$t[id_users]'");
            $n = mysqli_fetch_array($nilai);
            $nilai2 = mysqli_query($DBcon, "SELECT * FROM nilai WHERE id_pelatihan='$_GET[id_pelatihan]' AND id_users = '$t[id_users]'");
            $n2 = mysqli_fetch_array($nilai2);
            echo "<tr>
                    <td>$no</td>
                      <td>
                      ";

                        $carip=mysqli_query($DBcon, 'SELECT * FROM pelatihan where id_pelatihan ="'.$_GET[id_pelatihan].'"'); 
                        while($care = mysqli_fetch_array($carip)){

                                  echo $care[id_pelatihan];
                        }
                      echo "</td>
                      <td><a href=?module=users&act=detailusers&id_pelatihan=$s[id_users] title='Detail users'>$s[EmployeeName]</a></td><td>
                      ";
                       $carip=mysqli_query($DBcon, 'SELECT * FROM pelatihan where id_pelatihan ="'.$_GET[id_pelatihan].'"'); 
                       $j=mysqli_fetch_array($carip);
                        $ab=mysqli_query($DBcon, 'SELECT * FROM trkatalog where idtrkatalog ="'.$j[idtrkatalog].'"'); 
                        $io = mysqli_fetch_array($ab);

                                  echo $io[nama];
                        
                        echo "</td>";
                      if ($t[dikoreksi]=='B'){
                          echo "<td>Nilai Post Test Pilihan Ganda $n2[persentase]</td>";
                          echo "
                          <td><a href=$aksi?module=acara&act=editusersyangtelahmengerjakan&id_pelatihan=$t[id]&id_users=$s[id_users]&id_pelatihan=$_GET[id_pelatihan]>Hapus User</a>
                          </td></tr>";
                      }else{
                          echo "<td>Nilai Post Test Pilihan Ganda $n2[persentase]</td>";
                          echo "
                          <td><a href=$aksi?module=acara&act=editusersyangtelahmengerjakan&id_pelatihan=$t[id]&id_users=$s[id_users]&id_pelatihan=$_GET[id_pelatihan]>Hapus User</a>
                          </td></tr>";
                      }
            $no++;
        }
        echo "</table>
              <br><input class=\"btn btn-danger\" type=button value=Kembali onclick=self.history.back()>";
        }
        elseif (empty($pilganda) AND empty($esay)){
            echo "<script>window.alert('Tidak Ada Soal.');
                    window.location=(href='media_admin.php?module=acara')</script>";
        }
        }else{
            echo "<script>window.alert('Belum ada yang mengikuti ujian.');
                    window.location=(href='media_admin.php?module=acara')</script>";
        }
    }
    break;

case "koreksi":
    if ($_SESSION[leveluser]=='admin'){
        $cek = mysqli_query($DBcon, "SELECT * FROM users_sudah_mengerjakan WHERE id_users='$_GET[id_users]'");
        $c = mysqli_fetch_array($cek);
        if ($c[dikoreksi]=='B'){
        $soal_pilganda = mysqli_query($DBcon, "SELECT * FROM quiz_pilganda WHERE id_pelatihan='$_GET[id_pelatihan]'");
        $pilganda = mysqli_num_rows($soal_pilganda);
        $soal_esay = mysqli_query($DBcon, "SELECT * FROM quiz_esay WHERE id_pelatihan='$_GET[id_pelatihan]'");
        $esay = mysqli_num_rows($soal_esay);
        if (!empty($pilganda) AND !empty($esay)){
            $users = mysqli_query($DBcon, "SELECT * FROM users WHERE id_users='$_GET[id_users]'");
            $s = mysqli_fetch_array($users);
            $jawaban = mysqli_query($DBcon, "SELECT * FROM jawaban WHERE id_pelatihan='$_GET[id_pelatihan]' AND id_users='$_GET[id_users]'");
            $cek=mysqli_num_rows($jawaban);
            if (!empty($cek)){
                echo "<h2>Jawaban Soal Essay User <b>$s[EmployeeName]</b></h2><hr>";
                $no=1;
                while ($j=mysqli_fetch_array($jawaban)){
                    $soal_esay2 = mysqli_query($DBcon, "SELECT * FROM quiz_esay WHERE id_pelatihan='$j[id_pelatihan]' AND id_quiz='$j[id_quiz]'");
                    $quiz = mysqli_fetch_array($soal_esay2);
                    echo "<table width=\"100%\" class=\"table table-striped table-bordered table-hover\" id=\"dataTables-example\">
                          <form method=POST action='?module=quiz&act=hasilkoreksi'>";
if (!empty($quiz[gambar])){
echo "<tr><td rowspan=7><b>$no.</b></td><td><b>Pertanyaan :</b></td></tr>
                                  <tr><td>$quiz[pertanyaan]</td></tr>
                                  <tr><td><img src='../foto_soal/medium_$quiz[gambar]'></td></tr>
                                  <tr><td><b>Jawaban:</b></td></tr>
                                  <tr><td>$j[jawaban]</td></tr>
                                  <tr><td><b>Nilai:</b></td></tr>
                                  <tr><td><input type=radio name='nilai".$no."' value='10'>10</input>
                                          <input type=radio name='nilai".$no."' value='20'>20</input>
                                          <input type=radio name='nilai".$no."' value='30'>30</input>
                                          <input type=radio name='nilai".$no."' value='40'>40</input>
                                          <input type=radio name='nilai".$no."' value='50'>50</input>
                                          <input type=radio name='nilai".$no."' value='60'>60</input>
                                          <input type=radio name='nilai".$no."' value='70'>70</input>
                                          <input type=radio name='nilai".$no."' value='80'>80</input>
                                          <input type=radio name='nilai".$no."' value='90'>90</input>
                                          <input type=radio name='nilai".$no."' value='100'>100</input></td></tr>
                                  <input type=hidden name='jawab".$no."' value='$j[jawaban]'>
                                  </table>";

                            }
                            else{
                                echo "<tr><td rowspan=6><b>$no.</b></td><td><b>Pertanyaan :</b></td></tr>
                                  <tr><td>$quiz[pertanyaan]</td></tr>
                                  <tr><td><b>Jawaban:</b></td></tr>
                                  <tr><td>$j[jawaban]</td></tr>
                                  <tr><td><b>Nilai:</b></td></tr>
                                  <tr><td><input type=radio name='nilai".$no."' value='10'>10</input>
                                          <input type=radio name='nilai".$no."' value='20'>20</input>
                                          <input type=radio name='nilai".$no."' value='30'>30</input>
                                          <input type=radio name='nilai".$no."' value='40'>40</input>
                                          <input type=radio name='nilai".$no."' value='50'>50</input>
                                          <input type=radio name='nilai".$no."' value='60'>60</input>
                                          <input type=radio name='nilai".$no."' value='70'>70</input>
                                          <input type=radio name='nilai".$no."' value='80'>80</input>
                                          <input type=radio name='nilai".$no."' value='90'>90</input>
                                          <input type=radio name='nilai".$no."' value='100'>100</input></td></tr>
                                  <input type=hidden name='jawab".$no."' value='$j[jawaban]'>
                                  </table>";
                            }
                    $no++;                 
                }
                $jum = $no - 1;
                    echo "<input type=hidden name=jumlah_soal value='$jum'>
                          <input type=hidden name=id_pelatihan value='$_GET[id_pelatihan]'>

                          <input type=hidden name=id_users value='$_GET[id_users]'>";
                echo "<br>
                          <input class=\"btn btn-primary\" type=submit value=Simpan>
                          <input class=\"btn btn-danger\" type=button value=Batal onclick=self.history.back()>";
            }else{
                 echo "<script>window.alert('Jawaban kosong.');
                       window.location=(href='?module=quiz')</script>";
            }

        }
        elseif (empty($pilganda) AND !empty($esay)){
            $users = mysqli_query($DBcon, "SELECT * FROM users WHERE id_users='$_GET[id_users]'");
            $s = mysqli_fetch_array($users);
            $jawaban = mysqli_query($DBcon, "SELECT * FROM jawaban WHERE id_pelatihan='$_GET[id_pelatihan]' AND id_users='$_GET[id_users]'");
            $cek=mysqli_num_rows($jawaban);
            if (!empty($cek)){
                echo "<h2>Jawaban Soal Essay User <b>$s[EmployeeName]</b></h2>";
                $no=1;
                while ($j=mysqli_fetch_array($jawaban)){
                    $soal_esay2 = mysqli_query($DBcon, "SELECT * FROM quiz_esay WHERE id_pelatihan='$j[id_pelatihan]' AND id_quiz='$j[id_quiz]'");
                    $quiz = mysqli_fetch_array($soal_esay2);
                    echo "<table width=\"100%\" class=\"table table-striped table-bordered table-hover\" id=\"dataTables-example\">
                          <form method=POST action='?module=quiz&act=hasilkoreksi'>";
                            if (!empty($quiz[gambar])){
                            echo "<tr><td rowspan=7><b>$no.</b></td><td><b>Pertanyaan :</b></td></tr>
                                  <tr><td>$quiz[pertanyaan]</td></tr>
                                  <tr><td><img src='../foto_soal/medium_$quiz[gambar]'></td></tr>
                                  <tr><td><b>Jawaban:</b></td></tr>
                                  <tr><td>$j[jawaban]</td></tr>
                                  <tr><td><b>Nilai:</b></td></tr>
                                  <tr><td><input type=radio name='nilai".$no."' value='10'>10</input>
                                          <input type=radio name='nilai".$no."' value='20'>20</input>
                                          <input type=radio name='nilai".$no."' value='30'>30</input>
                                          <input type=radio name='nilai".$no."' value='40'>40</input>
                                          <input type=radio name='nilai".$no."' value='50'>50</input>
                                          <input type=radio name='nilai".$no."' value='60'>60</input>
                                          <input type=radio name='nilai".$no."' value='70'>70</input>
                                          <input type=radio name='nilai".$no."' value='80'>80</input>
                                          <input type=radio name='nilai".$no."' value='90'>90</input>
                                          <input type=radio name='nilai".$no."' value='100'>100</input></td></tr>
                                  <input type=hidden name='jawab".$no."' value='$j[jawaban]'>
                                  </table>";

                            }
                            else{
                                echo "<tr><td rowspan=6><b>$no.</b></td><td><b>Pertanyaan :</b></td></tr>
                                  <tr><td>$quiz[pertanyaan]</td></tr>
                                  <tr><td><b>Jawaban:</b></td></tr>
                                  <tr><td>$j[jawaban]</td></tr>
                                  <tr><td><b>Nilai:</b></td></tr>
                                  <tr><td><input type=radio name='nilai".$no."' value='10'>10</input>
                                          <input type=radio name='nilai".$no."' value='20'>20</input>
                                          <input type=radio name='nilai".$no."' value='30'>30</input>
                                          <input type=radio name='nilai".$no."' value='40'>40</input>
                                          <input type=radio name='nilai".$no."' value='50'>50</input>
                                          <input type=radio name='nilai".$no."' value='60'>60</input>
                                          <input type=radio name='nilai".$no."' value='70'>70</input>
                                          <input type=radio name='nilai".$no."' value='80'>80</input>
                                          <input type=radio name='nilai".$no."' value='90'>90</input>
                                          <input type=radio name='nilai".$no."' value='100'>100</input></td></tr>
                                  <input type=hidden name='jawab".$no."' value='$j[jawaban]'>
                                  </table>";
                            }
                    $no++;
                }
                $jum = $no - 1;
                    echo "<input type=hidden name=jumlah_soal value='$jum'>
                          <input type=hidden name=id_pelatihan value='$_GET[id_pelatihan]'>

                          <input type=hidden name=id_users value='$_GET[id_users]'>";
                echo "<br>
                          <input class=\"btn btn-primary\" type=submit value=Simpan>
                          <input class=\"btn btn-danger\" type=button value=Batal onclick=self.history.back()>";
            }
            else{
                 echo "<script>window.alert('Jawaban kosong.');
                        window.location=(href='?module=quiz')</script>";
            }
        }
        elseif (!empty($pilganda) AND empty($esay)){
            echo "<script>window.alert('Soal hanya pilihan ganda, sudah di koreksi oleh system.');
            window.location=(href='?module=quiz')</script>";
        }
        elseif (empty($pilganda) AND empty($esay)){
            echo "<script>window.alert('Tidak ada soal pilihan ganda atau essay.');
            window.location=(href='?module=quiz')</script>";
        }
    }
    elseif ($c[dikoreksi]=='S'){
         echo "<script>window.alert('Sudah Di Koreksi');
         window.location=(href='?module=quiz')</script>";
    }
    }
    elseif ($_SESSION[leveluser]=='pengajar'){
        $cek = mysqli_query($DBcon, "SELECT * FROM users_sudah_mengerjakan WHERE id_users='$_GET[id_users]'");
        $c = mysqli_fetch_array($cek);
        if ($c[dikoreksi]=='B'){
        $soal_pilganda = mysqli_query($DBcon, "SELECT * FROM quiz_pilganda WHERE id_pelatihan='$_GET[id_pelatihan]'");
        $pilganda = mysqli_num_rows($soal_pilganda);
        $soal_esay = mysqli_query($DBcon, "SELECT * FROM quiz_esay WHERE id_pelatihan='$_GET[id_pelatihan]'");
        $esay = mysqli_num_rows($soal_esay);
        if (!empty($pilganda) AND !empty($esay)){
            $users = mysqli_query($DBcon, "SELECT * FROM users WHERE id_users='$_GET[id_users]'");
            $s = mysqli_fetch_array($users);
            $jawaban = mysqli_query($DBcon, "SELECT * FROM jawaban WHERE id_pelatihan='$_GET[id_pelatihan]' AND id_users='$_GET[id_users]'");
            $cek=mysqli_num_rows($jawaban);
            if (!empty($cek)){
                echo "<h2>Jawaban Soal Essay User <b>$s[EmployeeName]</b></h2><hr>";
                $no=1;
                while ($j=mysqli_fetch_array($jawaban)){
                    $soal_esay2 = mysqli_query($DBcon, "SELECT * FROM quiz_esay WHERE id_pelatihan='$j[id_pelatihan]' AND id_quiz='$j[id_quiz]'");
                    $quiz = mysqli_fetch_array($soal_esay2);
                    echo "<table width=\"100%\" class=\"table table-striped table-bordered table-hover\" id=\"dataTables-example\">
                          <form method=POST action='?module=quiz&act=hasilkoreksi'>";
                            if (!empty($quiz[gambar])){
                            echo "<tr><td rowspan=7><b>$no.</b></td><td><b>Pertanyaan :</b></td></tr>
                                  <tr><td>$quiz[pertanyaan]</td></tr>
                                  <tr><td><img src='../foto_soal/medium_$quiz[gambar]'></td></tr>
                                  <tr><td><b>Jawaban:</b></td></tr>
                                  <tr><td>$j[jawaban]</td></tr>
                                  <tr><td><b>Nilai:</b></td></tr>
                                  <tr><td><input type=radio name='nilai".$no."' value='10'>10</input>
                                          <input type=radio name='nilai".$no."' value='20'>20</input>
                                          <input type=radio name='nilai".$no."' value='30'>30</input>
                                          <input type=radio name='nilai".$no."' value='40'>40</input>
                                          <input type=radio name='nilai".$no."' value='50'>50</input>
                                          <input type=radio name='nilai".$no."' value='60'>60</input>
                                          <input type=radio name='nilai".$no."' value='70'>70</input>
                                          <input type=radio name='nilai".$no."' value='80'>80</input>
                                          <input type=radio name='nilai".$no."' value='90'>90</input>
                                          <input type=radio name='nilai".$no."' value='100'>100</input></td></tr>
                                  <input type=hidden name='jawab".$no."' value='$j[jawaban]'>
                                  </table>";

                            }
                            else{
                                echo "<tr><td rowspan=6><b>$no.</b></td><td><b>Pertanyaan :</b></td></tr>
                                  <tr><td>$quiz[pertanyaan]</td></tr>
                                  <tr><td><b>Jawaban:</b></td></tr>
                                  <tr><td>$j[jawaban]</td></tr>
                                  <tr><td><b>Nilai:</b></td></tr>
                                  <tr><td><input type=radio name='nilai".$no."' value='10'>10</input>
                                          <input type=radio name='nilai".$no."' value='20'>20</input>
                                          <input type=radio name='nilai".$no."' value='30'>30</input>
                                          <input type=radio name='nilai".$no."' value='40'>40</input>
                                          <input type=radio name='nilai".$no."' value='50'>50</input>
                                          <input type=radio name='nilai".$no."' value='60'>60</input>
                                          <input type=radio name='nilai".$no."' value='70'>70</input>
                                          <input type=radio name='nilai".$no."' value='80'>80</input>
                                          <input type=radio name='nilai".$no."' value='90'>90</input>
                                          <input type=radio name='nilai".$no."' value='100'>100</input></td></tr>
                                  <input type=hidden name='jawab".$no."' value='$j[jawaban]'>
                                  </table>";
                            }
                    $no++;
                }
                $jum = $no - 1;
                    echo "<input type=hidden name=jumlah_soal value='$jum'>
                          <input type=hidden name=id_pelatihan value='$_GET[id_pelatihan]'>

                          <input type=hidden name=id_users value='$_GET[id_users]'>";
                echo "<br>
                          <input class=\"btn btn-primary\" type=submit value=Simpan>
                          <input class=\"btn btn-danger\" type=button value=Batal onclick=self.history.back()>";
            }else{
                 echo "<script>window.alert('Jawaban kosong.');
                       window.location=(href='?module=quiz')</script>";
            }

        }
        elseif (empty($pilganda) AND !empty($esay)){
            $users = mysqli_query($DBcon, "SELECT * FROM users WHERE id_users='$_GET[id_users]'");
            $s = mysqli_fetch_array($users);
            $jawaban = mysqli_query($DBcon, "SELECT * FROM jawaban WHERE id_pelatihan='$_GET[id_pelatihan]' AND id_users='$_GET[id_users]'");
            $cek=mysqli_num_rows($jawaban);
            if (!empty($cek)){
                echo "<h2>Jawaban Soal Essay User <b>$s[EmployeeName]</b></h2>";
                $no=1;
                while ($j=mysqli_fetch_array($jawaban)){
                    $soal_esay2 = mysqli_query($DBcon, "SELECT * FROM quiz_esay WHERE id_pelatihan='$j[id_pelatihan]' AND id_quiz='$j[id_quiz]'");
                    $quiz = mysqli_fetch_array($soal_esay2);
                    echo "<table width=\"100%\" class=\"table table-striped table-bordered table-hover\" id=\"dataTables-example\">
                          <form method=POST action='?module=quiz&act=hasilkoreksi'>";
                            if (!empty($quiz[gambar])){
                            echo "<tr><td rowspan=7><b>$no.</b></td><td><b>Pertanyaan :</b></td></tr>
                                  <tr><td>$quiz[pertanyaan]</td></tr>
                                  <tr><td><img src='../foto_soal/medium_$quiz[gambar]'></td></tr>
                                  <tr><td><b>Jawaban:</b></td></tr>
                                  <tr><td>$j[jawaban]</td></tr>
                                  <tr><td><b>Nilai:</b></td></tr>
                                  <tr><td><input type=radio name='nilai".$no."' value='10'>10</input>
                                          <input type=radio name='nilai".$no."' value='20'>20</input>
                                          <input type=radio name='nilai".$no."' value='30'>30</input>
                                          <input type=radio name='nilai".$no."' value='40'>40</input>
                                          <input type=radio name='nilai".$no."' value='50'>50</input>
                                          <input type=radio name='nilai".$no."' value='60'>60</input>
                                          <input type=radio name='nilai".$no."' value='70'>70</input>
                                          <input type=radio name='nilai".$no."' value='80'>80</input>
                                          <input type=radio name='nilai".$no."' value='90'>90</input>
                                          <input type=radio name='nilai".$no."' value='100'>100</input></td></tr>
                                  <input type=hidden name='jawab".$no."' value='$j[jawaban]'>
                                  </table>";

                            }
                            else{
                                echo "<tr><td rowspan=6><b>$no.</b></td><td><b>Pertanyaan :</b></td></tr>
                                  <tr><td>$quiz[pertanyaan]</td></tr>
                                  <tr><td><b>Jawaban:</b></td></tr>
                                  <tr><td>$j[jawaban]</td></tr>
                                  <tr><td><b>Nilai:</b></td></tr>
                                  <tr><td><input type=radio name='nilai".$no."' value='10'>10</input>
                                          <input type=radio name='nilai".$no."' value='20'>20</input>
                                          <input type=radio name='nilai".$no."' value='30'>30</input>
                                          <input type=radio name='nilai".$no."' value='40'>40</input>
                                          <input type=radio name='nilai".$no."' value='50'>50</input>
                                          <input type=radio name='nilai".$no."' value='60'>60</input>
                                          <input type=radio name='nilai".$no."' value='70'>70</input>
                                          <input type=radio name='nilai".$no."' value='80'>80</input>
                                          <input type=radio name='nilai".$no."' value='90'>90</input>
                                          <input type=radio name='nilai".$no."' value='100'>100</input></td></tr>
                                  <input type=hidden name='jawab".$no."' value='$j[jawaban]'>
                                  </table>";
                            }
                    $no++;
                }
                $jum = $no - 1;
                    echo "<input type=hidden name=jumlah_soal value='$jum'>
                          <input type=hidden name=id_pelatihan value='$_GET[id_pelatihan]'>

                          <input type=hidden name=id_users value='$_GET[id_users]'>";
                echo "<br>
                          <input class=\"btn btn-primary\" type=submit value=Simpan>
                          <input class=\"btn btn-danger\" type=button value=Batal onclick=self.history.back()>";
            }
            else{
                 echo "<script>window.alert('Jawaban kosong.');
                        window.location=(href='?module=quiz')</script>";
            }
        }
        elseif (!empty($pilganda) AND empty($esay)){
            echo "<script>window.alert('Soal hanya pilihan ganda, sudah di koreksi oleh system.');
            window.location=(href='?module=quiz')</script>";
        }
        elseif (empty($pilganda) AND empty($esay)){
            echo "<script>window.alert('Tidak ada soal pilihan ganda atau essay.');
            window.location=(href='?module=quiz')</script>";
        }
    }
    elseif ($c[dikoreksi]=='S'){
         echo "<script>window.alert('Sudah Di Koreksi');
         window.location=(href='?module=quiz')</script>";
    }
    }
    break;

case "editkoreksi":
    if ($_SESSION[leveluser]=='admin'){
        $soal_pilganda = mysqli_query($DBcon, "SELECT * FROM quiz_pilganda WHERE id_pelatihan='$_GET[id_pelatihan]'");
        $pilganda = mysqli_num_rows($soal_pilganda);
        $soal_esay = mysqli_query($DBcon, "SELECT * FROM quiz_esay WHERE id_pelatihan='$_GET[id_pelatihan]'");
        $esay = mysqli_num_rows($soal_esay);
        if (!empty($pilganda) AND !empty($esay)){
            $users = mysqli_query($DBcon, "SELECT * FROM users WHERE id_users='$_GET[id_users]'");
            $s = mysqli_fetch_array($users);
            $jawaban = mysqli_query($DBcon, "SELECT * FROM jawaban WHERE id_pelatihan='$_GET[id_pelatihan]' AND id_users='$_GET[id_users]'");
            $cek=mysqli_num_rows($jawaban);
            if (!empty($cek)){
                echo "<h2>Jawaban Soal Essay User <b>$s[EmployeeName]</b></h2><hr>";
                $no=1;
                while ($j=mysqli_fetch_array($jawaban)){
                    $soal_esay2 = mysqli_query($DBcon, "SELECT * FROM quiz_esay WHERE id_pelatihan='$j[id_pelatihan]' AND id_quiz='$j[id_quiz]'");
                    $quiz = mysqli_fetch_array($soal_esay2);
                    echo "<table width=\"100%\" class=\"table table-striped table-bordered table-hover\" id=\"dataTables-example\">
                          <form method=POST action='?module=quiz&act=hasileditkoreksi'>";
                            if (!empty($quiz[gambar])){
                            echo "<tr><td rowspan=7><b>$no.</b></td><td><b>Pertanyaan :</b></td></tr>
                                  <tr><td>$quiz[pertanyaan]</td></tr>
                                  <tr><td><img src='../foto_soal/medium_$quiz[gambar]'></td></tr>
                                  <tr><td><b>Jawaban:</b></td></tr>
                                  <tr><td>$j[jawaban]</td></tr>
                                  <tr><td><b>Nilai:</b></td></tr>
                                  <tr><td><input type=radio name='nilai".$no."' value='10'>10</input>
                                          <input type=radio name='nilai".$no."' value='20'>20</input>
                                          <input type=radio name='nilai".$no."' value='30'>30</input>
                                          <input type=radio name='nilai".$no."' value='40'>40</input>
                                          <input type=radio name='nilai".$no."' value='50'>50</input>
                                          <input type=radio name='nilai".$no."' value='60'>60</input>
                                          <input type=radio name='nilai".$no."' value='70'>70</input>
                                          <input type=radio name='nilai".$no."' value='80'>80</input>
                                          <input type=radio name='nilai".$no."' value='90'>90</input>
                                          <input type=radio name='nilai".$no."' value='100'>100</input></td></tr>
                                  <input type=hidden name='jawab".$no."' value='$j[jawaban]'>
                                  </table>";

                            }
                            else{
                                echo "<tr><td rowspan=6><b>$no.</b></td><td><b>Pertanyaan :</b></td></tr>
                                  <tr><td>$quiz[pertanyaan]</td></tr>
                                  <tr><td><b>Jawaban:</b></td></tr>
                                  <tr><td>$j[jawaban]</td></tr>
                                  <tr><td><b>Nilai:</b></td></tr>
                                  <tr><td><input type=radio name='nilai".$no."' value='10'>10</input>
                                          <input type=radio name='nilai".$no."' value='20'>20</input>
                                          <input type=radio name='nilai".$no."' value='30'>30</input>
                                          <input type=radio name='nilai".$no."' value='40'>40</input>
                                          <input type=radio name='nilai".$no."' value='50'>50</input>
                                          <input type=radio name='nilai".$no."' value='60'>60</input>
                                          <input type=radio name='nilai".$no."' value='70'>70</input>
                                          <input type=radio name='nilai".$no."' value='80'>80</input>
                                          <input type=radio name='nilai".$no."' value='90'>90</input>
                                          <input type=radio name='nilai".$no."' value='100'>100</input></td></tr>
                                  <input type=hidden name='jawab".$no."' value='$j[jawaban]'>
                                  </table>";
                            }
                    $no++;
                }
                $jum = $no - 1;
                    echo "<input type=hidden name=jumlah_soal value='$jum'>
                          <input type=hidden name=id_pelatihan value='$_GET[id_pelatihan]'>

                          <input type=hidden name=id_users value='$_GET[id_users]'>";
                echo "<br>
                          <input class=\"btn btn-primary\" type=submit value=Simpan>
                          <input class=\"btn btn-danger\" type=button value=Batal onclick=self.history.back()>";
            }
        }
        elseif (empty($pilganda) AND !empty($esay)){
            $users = mysqli_query($DBcon, "SELECT * FROM users WHERE id_users='$_GET[id_users]'");
            $s = mysqli_fetch_array($users);
            $jawaban = mysqli_query($DBcon, "SELECT * FROM jawaban WHERE id_pelatihan='$_GET[id_pelatihan]' AND id_users='$_GET[id_users]'");
            $cek=mysqli_num_rows($jawaban);
            if (!empty($cek)){
                echo "<h2>Jawaban Soal Essay User <b>$s[EmployeeName]</b></h2><hr>";
                $no=1;
                while ($j=mysqli_fetch_array($jawaban)){
                    $soal_esay2 = mysqli_query($DBcon, "SELECT * FROM quiz_esay WHERE id_pelatihan='$j[id_pelatihan]' AND id_quiz='$j[id_quiz]'");
                    $quiz = mysqli_fetch_array($soal_esay2);
                    echo "<table width=\"100%\" class=\"table table-striped table-bordered table-hover\" id=\"dataTables-example\">
                          <form method=POST action='?module=quiz&act=hasileditkoreksi'>";
                            if (!empty($quiz[gambar])){
                            echo "<tr><td rowspan=7><b>$no.</b></td><td><b>Pertanyaan :</b></td></tr>
                                  <tr><td>$quiz[pertanyaan]</td></tr>
                                  <tr><td><img src='../foto_soal/medium_$quiz[gambar]'></td></tr>
                                  <tr><td><b>Jawaban:</b></td></tr>
                                  <tr><td>$j[jawaban]</td></tr>
                                  <tr><td><b>Nilai:</b></td></tr>
                                  <tr><td><input type=radio name='nilai".$no."' value='10'>10</input>
                                          <input type=radio name='nilai".$no."' value='20'>20</input>
                                          <input type=radio name='nilai".$no."' value='30'>30</input>
                                          <input type=radio name='nilai".$no."' value='40'>40</input>
                                          <input type=radio name='nilai".$no."' value='50'>50</input>
                                          <input type=radio name='nilai".$no."' value='60'>60</input>
                                          <input type=radio name='nilai".$no."' value='70'>70</input>
                                          <input type=radio name='nilai".$no."' value='80'>80</input>
                                          <input type=radio name='nilai".$no."' value='90'>90</input>
                                          <input type=radio name='nilai".$no."' value='100'>100</input></td></tr>
                                  <input type=hidden name='jawab".$no."' value='$j[jawaban]'>
                                  </table>";

                            }
                            else{
                                echo "<tr><td rowspan=6><b>$no.</b></td><td><b>Pertanyaan :</b></td></tr>
                                  <tr><td>$quiz[pertanyaan]</td></tr>
                                  <tr><td><b>Jawaban:</b></td></tr>
                                  <tr><td>$j[jawaban]</td></tr>
                                  <tr><td><b>Nilai:</b></td></tr>
                                  <tr><td><input type=radio name='nilai".$no."' value='10'>10</input>
                                          <input type=radio name='nilai".$no."' value='20'>20</input>
                                          <input type=radio name='nilai".$no."' value='30'>30</input>
                                          <input type=radio name='nilai".$no."' value='40'>40</input>
                                          <input type=radio name='nilai".$no."' value='50'>50</input>
                                          <input type=radio name='nilai".$no."' value='60'>60</input>
                                          <input type=radio name='nilai".$no."' value='70'>70</input>
                                          <input type=radio name='nilai".$no."' value='80'>80</input>
                                          <input type=radio name='nilai".$no."' value='90'>90</input>
                                          <input type=radio name='nilai".$no."' value='100'>100</input></td></tr>
                                  <input type=hidden name='jawab".$no."' value='$j[jawaban]'>
                                  </table>";
                            }
                    $no++;
                }
                $jum = $no - 1;
                    echo "<input type=hidden name=jumlah_soal value='$jum'>
                          <input type=hidden name=id_pelatihan value='$_GET[id_pelatihan]'>

                          <input type=hidden name=id_users value='$_GET[id_users]'>";
                echo "<br>
                          <input class=\"btn btn-primary\" type=submit value=Simpan>
                          <input class=\"btn btn-danger\" type=button value=Batal onclick=self.history.back()>";
            }
        }
        elseif (!empty($pilganda) AND empty($esay)){
            echo "<script>window.alert('Soal hanya pilihan ganda, sudah di koreksi oleh system.');
            window.location=(href='?module=quiz')</script>";
        }
        elseif (empty($pilganda) AND empty($esay)){
            echo "<script>window.alert('Tidak ada soal pilihan ganda atau essay.');
            window.location=(href='?module=quiz')</script>";
        }
    }
    elseif ($_SESSION[leveluser]=='pengajar'){
        $soal_pilganda = mysqli_query($DBcon, "SELECT * FROM quiz_pilganda WHERE id_pelatihan='$_GET[id_pelatihan]'");
        $pilganda = mysqli_num_rows($soal_pilganda);
        $soal_esay = mysqli_query($DBcon, "SELECT * FROM quiz_esay WHERE id_pelatihan='$_GET[id_pelatihan]'");
        $esay = mysqli_num_rows($soal_esay);
        if (!empty($pilganda) AND !empty($esay)){
            $users = mysqli_query($DBcon, "SELECT * FROM users WHERE id_users='$_GET[id_users]'");
            $s = mysqli_fetch_array($users);
            $jawaban = mysqli_query($DBcon, "SELECT * FROM jawaban WHERE id_pelatihan='$_GET[id_pelatihan]' AND id_users='$_GET[id_users]'");
            $cek=mysqli_num_rows($jawaban);
            if (!empty($cek)){
                echo "<h2>Jawaban Soal Essay User <b>$s[EmployeeName]</b></h2><hr>";
                $no=1;
                while ($j=mysqli_fetch_array($jawaban)){
                    $soal_esay2 = mysqli_query($DBcon, "SELECT * FROM quiz_esay WHERE id_pelatihan='$j[id_pelatihan]' AND id_quiz='$j[id_quiz]'");
                    $quiz = mysqli_fetch_array($soal_esay2);
                    echo "<table width=\"100%\" class=\"table table-striped table-bordered table-hover\" id=\"dataTables-example\">
                          <form method=POST action='?module=quiz&act=hasileditkoreksi'>";
                            if (!empty($quiz[gambar])){
                            echo "<tr><td rowspan=7><b>$no.</b></td><td><b>Pertanyaan :</b></td></tr>
                                  <tr><td>$quiz[pertanyaan]</td></tr>
                                  <tr><td><img src='../foto_soal/medium_$quiz[gambar]'></td></tr>
                                  <tr><td><b>Jawaban:</b></td></tr>
                                  <tr><td>$j[jawaban]</td></tr>
                                  <tr><td><b>Nilai:</b></td></tr>
                                  <tr><td><input type=radio name='nilai".$no."' value='10'>10</input>
                                          <input type=radio name='nilai".$no."' value='20'>20</input>
                                          <input type=radio name='nilai".$no."' value='30'>30</input>
                                          <input type=radio name='nilai".$no."' value='40'>40</input>
                                          <input type=radio name='nilai".$no."' value='50'>50</input>
                                          <input type=radio name='nilai".$no."' value='60'>60</input>
                                          <input type=radio name='nilai".$no."' value='70'>70</input>
                                          <input type=radio name='nilai".$no."' value='80'>80</input>
                                          <input type=radio name='nilai".$no."' value='90'>90</input>
                                          <input type=radio name='nilai".$no."' value='100'>100</input></td></tr>
                                  <input type=hidden name='jawab".$no."' value='$j[jawaban]'>
                                  </table>";

                            }
                            else{
                                echo "<tr><td rowspan=6><b>$no.</b></td><td><b>Pertanyaan :</b></td></tr>
                                  <tr><td>$quiz[pertanyaan]</td></tr>
                                  <tr><td><b>Jawaban:</b></td></tr>
                                  <tr><td>$j[jawaban]</td></tr>
                                  <tr><td><b>Nilai:</b></td></tr>
                                  <tr><td><input type=radio name='nilai".$no."' value='10'>10</input>
                                          <input type=radio name='nilai".$no."' value='20'>20</input>
                                          <input type=radio name='nilai".$no."' value='30'>30</input>
                                          <input type=radio name='nilai".$no."' value='40'>40</input>
                                          <input type=radio name='nilai".$no."' value='50'>50</input>
                                          <input type=radio name='nilai".$no."' value='60'>60</input>
                                          <input type=radio name='nilai".$no."' value='70'>70</input>
                                          <input type=radio name='nilai".$no."' value='80'>80</input>
                                          <input type=radio name='nilai".$no."' value='90'>90</input>
                                          <input type=radio name='nilai".$no."' value='100'>100</input></td></tr>
                                  <input type=hidden name='jawab".$no."' value='$j[jawaban]'>
                                  </table>";
                            }
                    $no++;
                }
                $jum = $no - 1;
                    echo "<input type=hidden name=jumlah_soal value='$jum'>
                          <input type=hidden name=id_pelatihan value='$_GET[id_pelatihan]'>

                          <input type=hidden name=id_users value='$_GET[id_users]'>";
                echo "<br>
                          <input class=\"btn btn-primary\" type=submit value=Simpan>
                          <input class=\"btn btn-danger\" type=button value=Batal onclick=self.history.back()>";
            }
        }
        elseif (empty($pilganda) AND !empty($esay)){
            $users = mysqli_query($DBcon, "SELECT * FROM users WHERE id_users='$_GET[id_users]'");
            $s = mysqli_fetch_array($users);
            $jawaban = mysqli_query($DBcon, "SELECT * FROM jawaban WHERE id_pelatihan='$_GET[id_pelatihan]' AND id_users='$_GET[id_users]'");
            $cek=mysqli_num_rows($jawaban);
            if (!empty($cek)){
                echo "<h2>Jawaban Soal Essay User <b>$s[EmployeeName]</b></h2><hr>";
                $no=1;
                while ($j=mysqli_fetch_array($jawaban)){
                    $soal_esay2 = mysqli_query($DBcon, "SELECT * FROM quiz_esay WHERE id_pelatihan='$j[id_pelatihan]' AND id_quiz='$j[id_quiz]'");
                    $quiz = mysqli_fetch_array($soal_esay2);
                    echo "<table width=\"100%\" class=\"table table-striped table-bordered table-hover\" id=\"dataTables-example\">
                          <form method=POST action='?module=quiz&act=hasileditkoreksi'>";
                            if (!empty($quiz[gambar])){
                            echo "<tr><td rowspan=7><b>$no.</b></td><td><b>Pertanyaan :</b></td></tr>
                                  <tr><td>$quiz[pertanyaan]</td></tr>
                                  <tr><td><img src='../foto_soal/medium_$quiz[gambar]'></td></tr>
                                  <tr><td><b>Jawaban:</b></td></tr>
                                  <tr><td>$j[jawaban]</td></tr>
                                  <tr><td><b>Nilai:</b></td></tr>
                                  <tr><td><input type=radio name='nilai".$no."' value='10'>10</input>
                                          <input type=radio name='nilai".$no."' value='20'>20</input>
                                          <input type=radio name='nilai".$no."' value='30'>30</input>
                                          <input type=radio name='nilai".$no."' value='40'>40</input>
                                          <input type=radio name='nilai".$no."' value='50'>50</input>
                                          <input type=radio name='nilai".$no."' value='60'>60</input>
                                          <input type=radio name='nilai".$no."' value='70'>70</input>
                                          <input type=radio name='nilai".$no."' value='80'>80</input>
                                          <input type=radio name='nilai".$no."' value='90'>90</input>
                                          <input type=radio name='nilai".$no."' value='100'>100</input></td></tr>
                                  <input type=hidden name='jawab".$no."' value='$j[jawaban]'>
                                  </table>";

                            }
                            else{
                                echo "<tr><td rowspan=6><b>$no.</b></td><td><b>Pertanyaan :</b></td></tr>
                                  <tr><td>$quiz[pertanyaan]</td></tr>
                                  <tr><td><b>Jawaban:</b></td></tr>
                                  <tr><td>$j[jawaban]</td></tr>
                                  <tr><td><b>Nilai:</b></td></tr>
                                  <tr><td><input type=radio name='nilai".$no."' value='10'>10</input>
                                          <input type=radio name='nilai".$no."' value='20'>20</input>
                                          <input type=radio name='nilai".$no."' value='30'>30</input>
                                          <input type=radio name='nilai".$no."' value='40'>40</input>
                                          <input type=radio name='nilai".$no."' value='50'>50</input>
                                          <input type=radio name='nilai".$no."' value='60'>60</input>
                                          <input type=radio name='nilai".$no."' value='70'>70</input>
                                          <input type=radio name='nilai".$no."' value='80'>80</input>
                                          <input type=radio name='nilai".$no."' value='90'>90</input>
                                          <input type=radio name='nilai".$no."' value='100'>100</input></td></tr>
                                  <input type=hidden name='jawab".$no."' value='$j[jawaban]'>
                                  </table>";
                            }
                    $no++;
                }
                $jum = $no - 1;
                    echo "<input type=hidden name=jumlah_soal value='$jum'>
                          <input type=hidden name=id_pelatihan value='$_GET[id_pelatihan]'>

                          <input type=hidden name=id_users value='$_GET[id_users]'>";
                echo "<br>
                          <input class=\"btn btn-primary\" type=submit value=Simpan>
                          <input class=\"btn btn-danger\" type=button value=Batal onclick=self.history.back()>";
            }
        }
        elseif (!empty($pilganda) AND empty($esay)){
            echo "<script>window.alert('Soal hanya pilihan ganda, sudah di koreksi oleh system.');
            window.location=(href='?module=quiz')</script>";
        }
        elseif (empty($pilganda) AND empty($esay)){
            echo "<script>window.alert('Tidak ada soal pilihan ganda atau essay.');
            window.location=(href='?module=quiz')</script>";
        }
    }
    break;


case "hasilkoreksi":
    if ($_SESSION[leveluser]=='admin'){
        echo "<form method=POST action='$aksi?module=quiz&act=inputnilai'><fieldset>
             <legend>Koreksi Nilai</legend>
             <dl class='inline'>";
        $jum_soal = $_POST['jumlah_soal'];
        
                    echo "<table width=\"100%\" class=\"table table-striped table-bordered table-hover\" id=\"dataTables-example\"><thead>
                          <input type=hidden name=id_pelatihan value='$_POST[id_pelatihan]'>
                          <input type=hidden name=id_users value='$_POST[id_users]'>";
                    echo "<tr><th>No Soal</th><th>Jawaban</th><th>Nilai</th></tr></thead>";
                    for ($i=1; $i<=$jum_soal; $i++){
                        $nilai = $_POST['nilai'.$i];
                        $jawaban = $_POST['jawab'.$i];
                        if (!empty($jawaban)){
                        echo "<tr><td>$i.</td><td>$jawaban</td><td>$nilai</td></tr>";
                        }else{
                            echo "<tr><td>$i.</td><td></td><td>$nilai</td></tr>";
                        }
                        
                    }
                    echo "</table>";
                    
                    $jumlah = 0;
                    for ($i=1; $i<=$jum_soal; $i++){                        
                        $bil = array($_POST['nilai'.$i]);
                        for ($j=0; $j<=count($bil)-1; $j++){
                        $jumlah = $jumlah + $bil[$j];
                        }                        
                    }                   
                    $nilai = $jumlah / 100;
                    $nilai2 = $nilai / $jum_soal;
                    $nilai3 = $nilai2 * 100;
                echo "<h2>Nilai Keseluruhan = $nilai3</h2>";
                echo "<input type=hidden name=nilai value='$nilai3'>";
                echo "
                      <input class=\"btn btn-default\" type=submit value=Simpan>
                      <input class=\"btn btn-danger\" type=button value=Kembali onclick=self.history.back()>
                      ";
                    echo "</dl></div>
                          </fieldset></form>";
    }
    elseif ($_SESSION[leveluser]=='pengajar'){
        echo "<form method=POST action='$aksi?module=quiz&act=inputnilai'><fieldset>
             <legend>Koreksi Nilai</legend>
             <dl class='inline'>";
        $jum_soal = $_POST['jumlah_soal'];

                    echo "<table width=\"100%\" class=\"table table-striped table-bordered table-hover\" id=\"dataTables-example\"><thead>
                          <input type=hidden name=id_pelatihan value='$_POST[id_pelatihan]'>
                          <input type=hidden name=id_users value='$_POST[id_users]'>";
                    echo "<tr><th>No Soal</th><th>Jawaban</th><th>Nilai</th></tr></thead>";
                    for ($i=1; $i<=$jum_soal; $i++){
                        $nilai = $_POST['nilai'.$i];
                        $jawaban = $_POST['jawab'.$i];
                        if (!empty($jawaban)){
                        echo "<tr><td>$i.</td><td>$jawaban</td><td>$nilai</td></tr>";
                        }else{
                            echo "<tr><td>$i.</td><td></td><td>$nilai</td></tr>";
                        }

                    }
                    echo "</table>";

                    $jumlah = 0;
                    for ($i=1; $i<=$jum_soal; $i++){
                        $bil = array($_POST['nilai'.$i]);
                        for ($j=0; $j<=count($bil)-1; $j++){
                        $jumlah = $jumlah + $bil[$j];
                        }
                    }
                    $nilai = $jumlah / 100;
                    $nilai2 = $nilai / $jum_soal;
                    $nilai3 = $nilai2 * 100;
                echo "<h2>Nilai Keseluruhan = $nilai3</h2>";
                echo "<input type=hidden name=nilai value='$nilai3'>";
                echo "
                      <input class=\"btn btn-default\" type=submit value=Simpan>
                      <input class=\"btn btn-danger\" type=button value=Kembali onclick=self.history.back()>
                      ";
                    echo "</dl></div>
                          </fieldset></form>";
    }
    else{
        echo "anda tidak ber hak mengakses ini.";
    }
    break;

case "hasileditkoreksi":
    if ($_SESSION[leveluser]=='admin'){
        echo "<form method=POST action='$aksi?module=quiz&act=inputeditnilai'><fieldset>
              <legend>Koreksi Nilai</legend>
              <dl class='inline'>";
        $jum_soal = $_POST['jumlah_soal'];

                    echo "<table width=\"100%\" class=\"table table-striped table-bordered table-hover\" id=\"dataTables-example\"><thead>
                          <input type=hidden name=id_pelatihan value='$_POST[id_pelatihan]'>
                          <input type=hidden name=id_users value='$_POST[id_users]'>";
                    echo "<tr><th>No Soal</th><th>Jawaban</th><th>Nilai</th></tr></thead>";
                    for ($i=1; $i<=$jum_soal; $i++){
                        $nilai = $_POST['nilai'.$i];
                        $jawaban = $_POST['jawab'.$i];
                        if (!empty($jawaban)){
                        echo "<tr><td>$i</td><td>$jawaban</td><td>$nilai</td></tr>";
                        }else{
                            echo "<tr><td>$i</td><td></td><td>$nilai</td></tr>";
                        }

                    }
                    echo "</table>";
                    $jumlah = 0;
                    for ($i=1; $i<=$jum_soal; $i++){
                        $bil = array($_POST['nilai'.$i]);
                        for ($j=0; $j<=count($bil)-1; $j++){
                        $jumlah = $jumlah + $bil[$j];
                        }
                    }
                    $nilai = $jumlah / 100;
                    $nilai2 = $nilai / $jum_soal;
                    $nilai3 = $nilai2 * 100;
                echo "<h2>Nilai Keseluruhan = $nilai3</h2>";
                echo "<input type=hidden name=nilai value='$nilai3'>";
                echo "
                            <input class=\"btn btn-default\" type=submit value=Simpan>
                            <input class=\"btn btn-danger\" type=button value=Kembali onclick=self.history.back()>
                            ";
                    echo " </dl></fieldset></form>";
    }
    elseif ($_SESSION[leveluser]=='pengajar'){
         echo "<form method=POST action='$aksi?module=quiz&act=inputeditnilai'><fieldset>
              <legend>Koreksi Nilai</legend>
              <dl class='inline'>";
        $jum_soal = $_POST['jumlah_soal'];

                    echo "<table width=\"100%\" class=\"table table-striped table-bordered table-hover\" id=\"dataTables-example\"><thead>
                          <input type=hidden name=id_pelatihan value='$_POST[id_pelatihan]'>
                          <input type=hidden name=id_users value='$_POST[id_users]'>";
                    echo "<tr><th>No Soal</th><th>Jawaban</th><th>Nilai</th></tr></thead>";
                    for ($i=1; $i<=$jum_soal; $i++){
                        $nilai = $_POST['nilai'.$i];
                        $jawaban = $_POST['jawab'.$i];
                        if (!empty($jawaban)){
                        echo "<tr><td>$i</td><td>$jawaban</td><td>$nilai</td></tr>";
                        }else{
                            echo "<tr><td>$i</td><td></td><td>$nilai</td></tr>";
                        }

                    }
                    echo "</table>";
                    $jumlah = 0;
                    for ($i=1; $i<=$jum_soal; $i++){
                        $bil = array($_POST['nilai'.$i]);
                        for ($j=0; $j<=count($bil)-1; $j++){
                        $jumlah = $jumlah + $bil[$j];
                        }
                    }
                    $nilai = $jumlah / 100;
                    $nilai2 = $nilai / $jum_soal;
                    $nilai3 = $nilai2 * 100;
                echo "<h2>Nilai Keseluruhan = $nilai3</h2>";
                echo "<input type=hidden name=nilai value='$nilai3'>";
                echo "
                            <input class=\"btn btn-default\" type=submit value=Simpan>
                            <input class=\"btn btn-danger\" type=button value=Kembali onclick=self.history.back()>
                            ";
                    echo " </dl></fieldset></form>";
    }
    break;

case "tambahtopikquiz":
    if ($_SESSION[leveluser]=='admin'){
    echo "
    <form name='form_topik' method=POST action='$aksi?module=quiz&act=input_topikquiz'>
    <div class=\"panel-body\">
            <div class=\"row\">
            <div class=\"col-lg-6\">
    <legend>Tambah Topik</legend>

    <div class=\"form-group\">
        <label>Judul</label>
          <input class=\"form-control\" type='text' name='judul' required>
      </div>

    <div class=\"form-group\">
        <label>Kategori</label>";
              $pilih="SELECT * FROM trkatalog WHERE idtrkatalog = '$_GET[id_trkatalog]'";
              $query=mysqli_query($DBcon, $pilih);
              while($row=mysqli_fetch_array($query)){
              echo"<input type='text' class='form-control' value='".$row[nama]."' name='idtrkatalog'>";
              }
              echo"
              <p class=\"help-block\">Kategori Berdasarkan TR Katalog.</p>
    </div>

    <div class=\"form-group\">
        <label>Waktu Pengerjaan</label>
          <input class='form-control' type='number' name='waktu' required>
            <p class=\"help-block\">Waktu Pengerjaan Dalam Hitungan Menit</p>
    </div>

    <div class=\"form-group\">
        <label>Info</label>
          <textarea name='info' id='wysiwyg' class='medium' rows='6'></textarea>
    </div>

    
    <div class=\"form-group\">
      <label>Terbitkan Post Test?</label>
      <div class='radio'>
        <label>
          <input type=radio name='terbit' value='Y' required>Ya</input>
        </label>
      </div>
      <div class='radio'>
      <label>
          <input type=radio name='terbit' value='N'>Tidak</input>
      </label>
      </div>
    </div>

          <p align=center><input class=\"btn btn-primary\" type=submit value=Simpan>
          <input class=\"btn btn-danger\" type=button value=Batal onclick=self.history.back()></p>
  </form></div></div></div>";
    }
    elseif ($_SESSION[leveluser]=='pengajar'){
    echo "<form name='form_topik' method=POST action='$aksi?module=quiz&act=input_topikquiz'>
    <div class=\"panel-body\">
            <div class=\"row\">
            <div class=\"col-lg-6\">
    <legend>Tambah Topik</legend>

    <div class=\"form-group\">
        <label>Judul</label>
          <input class=\"form-control\" type='text' name='judul' required>
      </div>

    <div class=\"form-group\">
        <label>Kategori</label>
           <select class='form-control' name='idtrkatalog' required>
              <option value=''>-pilih-</option>";
              $pilih="SELECT * FROM trkatalog ORDER BY nama";
              $query=mysqli_query($DBcon, $pilih);
              while($row=mysqli_fetch_array($query)){
              echo"<option value='".$row[idtrkatalog]."'>".$row[nama]."</option>";
              }
              echo"</select>
              <p class=\"help-block\">Kategori Berdasarkan TR Katalog.</p>
    </div>

    <div class=\"form-group\">
        <label>Waktu Pengerjaan</label>
          <input class='form-control' type='number' name='waktu' required>
            <p class=\"help-block\">Waktu Pengerjaan Dalam Hitungan Menit</p>
    </div>

    <div class=\"form-group\">
        <label>Info</label>
          <textarea name='info' id='wysiwyg' class='medium' rows='6'></textarea>
    </div>

    
    <div class=\"form-group\">
      <label>Terbitkan Post Test?</label>
      <div class='radio'>
        <label>
          <input type=radio name='terbit' value='Y' required>Ya</input>
        </label>
      </div>
      <div class='radio'>
      <label>
          <input type=radio name='terbit' value='N'>Tidak</input>
      </label>
      </div>
    </div>

          <p align=center><input class=\"btn btn-primary\" type=submit value=Simpan>
          <input class=\"btn btn-danger\" type=button value=Batal onclick=self.history.back()></p>
  </form></div></div></div>";
    }
    break;

case "edittopikquiz":
    if ($_SESSION[leveluser]=='admin'){

    $edit=mysqli_query($DBcon, "SELECT * FROM pelatihan WHERE id_pelatihan = '$_GET[id_pelatihan]'");
    $t=mysqli_fetch_array($edit);
    $isikelas = mysqli_query($DBcon, "SELECT * FROM trkatalog WHERE idtrkatalog = '$t[idtrkatalog]'");
    $k=mysqli_fetch_array($isikelas);
    $pelajaran = mysqli_query($DBcon, "SELECT * FROM trkatalog WHERE idtrkatalog = '$t[idtrkatalog]'");
    $p=mysqli_fetch_array($pelajaran);

    $waktu = $t['waktu_pengerjaan']/60;

    echo "<form name='form_topik' method=POST action='$aksi?module=quiz&act=edit_topikquiz'>
    <input type=hidden name=id value='$t[id_pelatihan]'>
         <div class=\"panel-body\">
            <div class=\"row\">
            <div class=\"col-lg-6\">
    <legend>Edit Topik</legend>

    <div class=\"form-group\">
        <label>Judul</label>
          <input type='text' class='form-control' name='judul' value='$t[judul]' size='50'>
         <p class=\"help-block\">Example block-level help text here.</p>
    </div>

    <div class=\"form-group\">
      <label>Waktu Pengerjaan</label>
        <input type='number' class='form-control' name='waktu' size='10' value='$waktu'>
        <small>Dalam Hitungan Menit</small>
    </div>

    <div class=\"form-group\">
      <label>Info Post Test</label>
      <textarea name='info' id='wysiwyg' class='medium' rows='6'>$t[info]</textarea>
    </div>";

    if ($t[terbit]=='N'){
      echo "
    <div class=\"form-group\">
      <label>Terbitkan Post Test?</label>
        <div class='radio'>
          <label>
            <input type='radio' name='terbit' value='Y'> Ya
          </label>
        </div>
        <div class='radio'>
          <label>
            <input type='radio' name='terbit' value='N' checked> Tidak 
          </label>
        </div>
    </div>";
    }
    else{
      echo "<div class=\"form-group\">
      <label>Terbitkan Post Test?</label>
        <div class='radio'>
          <label>
            <input type='radio' name='terbit' value='Y' checked> Ya
          </label>
        </div>
        <div class='radio'>
          <label>
            <input type='radio' name='terbit' value='N' checked> Tidak 
          </label>
        </div>
    </div>";
    }
    echo "</dl>

          <p align=center><input class=\"btn btn-primary\" type=submit value=Update>
          <input class=\"btn btn-danger\" type=button value=Batal onclick=self.history.back()></p>

          </div></div></div></form>";
    }
    elseif ($_SESSION[leveluser]=='pengajar'){
    $edit=mysqli_query($DBcon, "SELECT * FROM pelatihan WHERE id_pelatihan = '$_GET[id_pelatihan]'");
    $t=mysqli_fetch_array($edit);
    $isikelas = mysqli_query($DBcon, "SELECT * FROM kelas WHERE idtrkatalog = '$t[idtrkatalog]'");
    $k=mysqli_fetch_array($isikelas);
    $pelajaran = mysqli_query($DBcon, "SELECT * FROM trkatalog WHERE idtrkatalog = '$t[idtrkatalog]'");
    $p=mysqli_fetch_array($pelajaran);

    $waktu = $t['waktu_pengerjaan']/60;

    echo "<form name='form_topik' method=POST action='$aksi?module=quiz&act=edit_topikquiz'>
    <input type=hidden name=id value='$t[id_pelatihan]'>
         <div class=\"panel-body\">
            <div class=\"row\">
            <div class=\"col-lg-6\">
    <legend>Edit Topik</legend>

    <div class=\"form-group\">
        <label>Judul</label>
          <input type='text' class='form-control' name='judul' value='$t[judul]' size='50'>
         <p class=\"help-block\">Example block-level help text here.</p>
    </div>

    <div class=\"form-group\">
      <label>Waktu Pengerjaan</label>
        <input type='number' class='form-control' name='waktu' value='$waktu'>
        <small>Dalam Hitungan Menit</small>
    </div>

    <div class=\"form-group\">
      <label>Info Post Test</label>
      <textarea name='info' id='wysiwyg' class='medium' rows='6'>$t[info]</textarea>
    </div>";

    if ($t[terbit]=='N'){
      echo "
    <div class=\"form-group\">
      <label>Terbitkan Post Test?</label>
        <div class='radio'>
          <label>
            <input type='radio' name='terbit' value='Y'> Ya
          </label>
        </div>
        <div class='radio'>
          <label>
            <input type='radio' name='terbit' value='N' checked> Tidak 
          </label>
        </div>
    </div>";
    }
    else{
      echo "<div class=\"form-group\">
      <label>Terbitkan Post Test?</label>
        <div class='radio'>
          <label>
            <input type='radio' name='terbit' value='Y' checked> Ya
          </label>
        </div>
        <div class='radio'>
          <label>
            <input type='radio' name='terbit' value='N' checked> Tidak 
          </label>
        </div>
    </div>";
    }
    echo "</dl>

          <p align=center><input class=\"btn btn-primary\" type=submit value=Update>
          <input class=\"btn btn-danger\" type=button value=Batal onclick=self.history.back()></p>

          </div></div></div></form>";
    }
    break;

case "daftartopik":
    if ($_SESSION[leveluser]=='users'){
        $mapel = mysqli_query($DBcon, "SELECT * FROM trkatalog WHERE idtrkatalog = '$_GET[id_trkatalog]'");
        $data_mapel = mysqli_fetch_array($mapel);
        $topik = mysqli_query($DBcon, "SELECT * FROM pelatihan WHERE id_pelatihan = '$_GET[id_pelatihan]'");
        $cek_topik = mysqli_num_rows($topik);

        if (!empty($cek_topik)){
            echo"
              <b>Daftar Post Test $data_mapel[nama]</b>
                <table width=\"100%\" class=\"table table-striped table-bordered table-hover\" id=\"dataTables-example\">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Judul</th>
                  <th>Tgl Pelaksanaan</th>
                  <th>Nama Trainer</th>
                  <th>Waktu Pengerjaan</th>
                </tr>
              </thead>";
              $no=1;
              while($t=mysqli_fetch_array($topik)){
                  $tgl_posting   = tgl_indo($t[tanggal_pelaksanaan]);
                  $tgl_berakhir   = tgl_indo($t[tanggal_selesai]);
                  $pengajar =  mysqli_query($DBcon, "SELECT * FROM pengajar WHERE id_pengajar = '$t[pembuat]'");
                  $cek_pengajar = mysqli_num_rows($pengajar);
                  $waktu = $t[lama] / 60;
                  echo"
                  <tr>
                    <td>$no</td>
                    <td><b>$t[nama_pelatihan]</b></td>
                    <td><b>$tgl_posting Sampai $tgl_berakhir</b></td>";
                       if(!empty($cek_pengajar)){

                       $p = mysqli_fetch_array($pengajar);
                       echo"
                       <td><b>$p[EmployeeName]</b></td>";
                       }else{
                           echo"
                      <td><b>$t[nama_trainer]</b></td>";
                       }
                       echo"
                       <td><b>$waktu menit</b></td></tr>
                            
                            </td></tr>
                       </form>
                       ";
              $no++;

              $tgl_now=date("Y-m-d");
              $tgl_exp="2015-02-28";//tanggal expired
              $waktu = date("H:i:s");
              if ($tgl_now >=$t[tanggal_selesai] ){
              echo "
              <div class='panel-footer'>
              <div class='tooltip-demo'>
              <input type='button' class=\"btn btn-danger\"  value='Kembali' onclick=self.history.back()>
                                <input type='button' class='pull-right btn btn-success' data-container='body' data-toggle='popover' data-placement='Top' data-content='Link Sudah Kadaluarsa.' value='Kerjakan Post Test'>
            </div>";
            }else{
                echo "
                <div  class='panel-footer'>
              <input type='button' class=\"btn btn-danger\"  value='Kembali' onclick=self.history.back()>
              <input type='button' class=\"pull-right btn btn-success\"  value='Kerjakan Post Test'
                       onclick=\"window.location.href='?module=quiz&act=infokerjakan&id_pelatihan=$t[id_pelatihan]';\">
            </div>";
            }
              }
              

        }else{
            echo "<script>window.alert('Belum ada post test, silakan tunggu informasi.')
                    window.location=(href='media.php?module=quiz&act=posttest')</script>";
        }
    }
    break;

case "daftarnilai":
    if ($_SESSION[leveluser]=='users'){

        $trkatalog = mysqli_query($DBcon, "SELECT * FROM trkatalog");
        $data_trkatalog = mysqli_fetch_array($trkatalog);
        $topik = mysqli_query($DBcon, "SELECT * FROM pelatihan");
        $cek_topik = mysqli_num_rows($topik);        
        
        if (!empty($cek_topik)){
            echo"<b>Daftar Nilai Post Test $data_trkatalog[nama] Yang Anda Ikuti</b>
            <hr>
              <table width=\"100%\" class=\"table table-striped table-bordered table-hover\" id=\"dataTables-example\">
            <thead>
              <tr><th>No</th><th>Deskripsi Post Test </th><th></th></tr></thead>";
              $no=1;
               while($t=mysqli_fetch_array($topik)){
                  $tgl_posting   = tgl_indo($t[tgl_buat]);
                  $pengajar =  mysqli_query($DBcon, "SELECT * FROM pengajar WHERE id_pengajar = '$t[pembuat]'");
                  $cek_pengajar = mysqli_num_rows($pengajar);
                  $waktu = $t[waktu_pengerjaan] / 60;
                  echo"<tr><td rowspan=6>$no</td><td><b>Judul</b></td><td><b>$[nama_pelatihan]</b></td></tr>
                       <tr><td><b>Tanggal Posting</b></td><td><b>$tgl_posting</b></td></tr>";
                       if(!empty($cek_pengajar)){

                       $p = mysqli_fetch_array($pengajar);
                       echo"<tr><td><b>Pembuat</b></td><td><b>$p[EmployeeName]</b></td></tr>";
                       }else{
                           echo"<tr><td><b>Pembuat</b></td><td><b>$t[pembuat]</b></td></tr>";
                       }
                       echo"<tr><td><b>Waktu Pengerjaan</b></td><td><b>$waktu menit</b></td></tr>
                            <tr><td><b>Info Soal/Quiz</b></td><td><b>$t[info]</b></td></tr>
                            <tr><td></td><td><input type=button class=\"btn btn-success\"  value='Lihat Nilai'
                       onclick=\"window.location.href='?module=quiz&act=nilaiusers';\"></td></tr>";
                       
              $no++;
              }
              echo"</table>
                   <input type=button class=\"btn btn-danger\"  value='Kembali' onclick=self.history.back()>";
        }else{
            echo "<script>window.alert('Belum ada post test di Kategori ini, jadi tidak ada nilai.');
                    window.location=(href='media.php?module=nilai')</script>";
        }
    }
    break;

case "nilaiusers":
    if ($_SESSION[leveluser]=='users'){
        $quiz_pilganda = mysqli_query($DBcon, "SELECT * FROM quiz_pilganda");
        $quiz_esay = mysqli_query($DBcon, "SELECT * FROM quiz_esay");
        $c_pilganda = mysqli_num_rows($quiz_pilganda);
        $c_esay = mysqli_num_rows($quiz_esay);

        if (!empty($c_pilganda) AND !empty($c_esay)){
        $pilganda = mysqli_query($DBcon, "SELECT * FROM nilai WHERE id_users = '$_SESSION[idusers]'");
        $cek_pilganda = mysqli_num_rows($pilganda);
        $esay = mysqli_query($DBcon, "SELECT * FROM nilai_soal_esay WHERE id_users = '$_SESSION[idusers]'");
        $cek_esay = mysqli_num_rows($esay);

                if (!empty($cek_pilganda) AND !empty($cek_esay)){
                    echo"<br><b class='judul'>Nilai Anda<br>
                      <table width=\"100%\" class=\"table table-striped table-bordered table-hover\" id=\"dataTables-example\">
            <thead>
                      <tr>
                        <th>Deskripsi Post Test</th>
                        <th>Nilai</th>
                      </tr>
            </thead>";
                      $n_pilganda = mysqli_fetch_array($pilganda);
                      $n_esay = mysqli_fetch_array($esay);
                      echo "
                      <tr>
                        <td>Tugas Pilihan Ganda1</td>
                        <td>$n_pilganda[persentase]</td></tr>
                        <tr><td>Tugas Essay</td><td>$n_esay[nilai]</td></tr>
                            </table></p><input type=button class=\"btn btn-danger\" value='Kembali' onclick=self.history.back()>";
                }
                elseif (empty($cek_pilganda) AND !empty($cek_esay)){
                    echo"<br><b class='judul'>Nilai Anda</b><br><p class='garisbawah'></p>
                      <table width=\"100%\" class=\"table table-striped table-bordered table-hover\" id=\"dataTables-example\">
            <thead>
                      <tr><th>Deskripsi Post Test </th><th>Nilai</th></tr></thead>";
                      $n_pilganda = mysqli_fetch_array($pilganda);
                      $n_esay = mysqli_fetch_array($esay);
                      echo "<tr><td>Tugas Pilihan Ganda2</td><td>Anda belum mengerjakan</td></tr>
                            <tr><td>Tugas Essay</td><td>$n_esay[nilai]</td></tr>
                            </table><input type=button class=\"btn btn-danger\" value='Kembali' onclick=self.history.back()>";
                }
                elseif (!empty($cek_pilganda) AND empty($cek_esay)){
                    echo"<br><b class='judul'>Nilai Anda</b><br><p class='garisbawah'></p>
                      <table width=\"100%\" class=\"table table-striped table-bordered table-hover\" id=\"dataTables-example\">
            <thead>
                      <tr><th>Deskripsi Post Test </th><th>Nilai</th><th>Keterangan</th></tr></thead>";
                      $n_pilganda = mysqli_fetch_array($pilganda);
                      $n_esay = mysqli_fetch_array($esay);
                      echo "<tr>
                      <td>Tugas Pilihan Ganda3</td>
                      <td>$n_pilganda[persentase]</td>
                      <td>$n_pilganda[kriteriapenilaian]</td>

                      </tr>
                            <tr><td>Tugas Essay</td><td>Belum di koreksi</td></tr>
                            </table><input type=button class=\"btn btn-danger\" value='Kembali' onclick=self.history.back()>";
                }
                elseif (empty($cek_pilganda) AND empty($cek_esay)){
                    echo"<br><b class='judul'>Nilai Anda</b><br><p class='garisbawah'></p>
                      <table width=\"100%\" class=\"table table-striped table-bordered table-hover\" id=\"dataTables-example\">
            <thead>
                      <tr><th>Deskripsi Post Test </th><th>Nilai</th></tr></thead>";
                      $n_pilganda = mysqli_fetch_array($pilganda);
                      $n_esay = mysqli_fetch_array($esay);
                      echo "<tr><td>Tugas Pilihan Ganda4</td><td>Anda Belum mengerjakan</td></tr>
                            <tr><td>Tugas Essay</td><td>Anda Belum mengerjakan</td></tr>
                            </table><input type=button class=\"btn btn-danger\" value='Kembali' onclick=self.history.back()>";
                }

        }
        elseif (empty($c_pilganda) AND !empty($c_esay)){
        $esay = mysqli_query($DBcon, "SELECT * FROM nilai_soal_esay WHERE  id_users = '$_SESSION[idusers]'");
        $cek_esay = mysqli_num_rows($esay);
                //jika nilai tidak kosong
                if (!empty($cek_esay)){
                    
                          echo"<br><b class='judul'>Nilai Anda</b><br><p class='garisbawah'></p>
                          <table width=\"100%\" class=\"table table-striped table-bordered table-hover\" id=\"dataTables-example\">
            <thead>
                          <tr><th>Deskripsi Post Test </th><th>Nilai</th></tr></thead>";
                          $n_esay = mysqli_fetch_array($esay);
                          echo "<tr><td>Tugas Essay</td><td>$n_esay[nilai]</td></tr>
                          </table><input type=button class=\"btn btn-primary\"value='Kembali' onclick=self.history.back()>";
                        
                }
                elseif (empty($cek_esay)) {
                    $kerjakan = mysqli_query($DBcon, "SELECT * FROM users_sudah_mengerjakan WHERE id_users = '$_SESSION[idusers]'");
                    $c_kerjakan = mysqli_num_rows($kerjakan);
                    if (!empty($c_kerjakan)){
                        $cek_kerjakan = mysqli_fetch_array($kerjakan);
                        if ($cek_kerjakan['dikoreksi']=='B'){
                        echo"<br><b class='judul'>Nilai Anda</b><br><p class='garisbawah'></p>
                          <table width=\"100%\" class=\"table table-striped table-bordered table-hover\" id=\"dataTables-example\">
            <thead>
                          <tr><th>Deskripsi Post Test </th><th>Nilai</th></tr></thead>";
                          echo "<tr><td>Tugas Essay</td><td>Belum Dikoreksi</td></tr>
                          </table>
                                <p class='garisbawah'></p><input type=button class=\"btn btn-danger\" value='Kembali' onclick=self.history.back()>";

                    }
                    elseif (empty($c_kerjakan)){
                            echo"<br><b class='judul'>Nilai Anda</b><br><p class='garisbawah'></p>
                              <table width=\"100%\" class=\"table table-striped table-bordered table-hover\" id=\"dataTables-example\">
            <thead>
                              <tr><th>Deskripsi Post Test </th><th>Nilai</th></tr></thead>";
                              echo "<tr><td>Tugas Essay</td><td>Anda belum mengerjakan</td></tr>
                              </table><input type=button class=\"btn btn-danger\" value='Kembali' onclick=self.history.back()>";


                    }
                    }
                }
                
        }
        elseif (!empty($c_pilganda) AND empty($c_esay)){
        $pilganda = mysqli_query($DBcon, "SELECT * FROM nilai WHERE  id_users = '$_SESSION[idusers]'");
        $cek_pilganda = mysqli_num_rows($pilganda);
                if (!empty($cek_pilganda)){
                    echo"<br><b class='judul'>Nilai Anda</b><br><p class='garisbawah'></p>
                      <table width=\"100%\" class=\"table table-striped table-bordered table-hover\" id=\"dataTables-example\">
            <thead>
                      <tr><th>Deskripsi Post Test</th><th>Tanggal Post Test</th><th>Nilai</th><th>Keterangan</th></tr></thead>";
                      $n_pilganda = mysqli_fetch_array($pilganda);
                      echo "<tr>
                      ";
        $cekjudul = mysqli_query($DBcon, "SELECT * FROM pelatihan where id_pelatihan='$n_pilganda[id_pelatihan]'");
        $w = mysqli_fetch_array($cekjudul);
        function konversi_tanggal($date)    
    {         
    $exp = explode('-',$date);    
    if(count($exp) == 3)    
    {    
      $date = $exp[2].'-'.$exp[1].'-'.$exp[0];    
    }    
    return $date;    
    } 
          echo "<td>$w[nama_pelatihan]</td>
                <td>".konversi_tanggal($w[tanggal_pelaksanaan])." Sampai ".konversi_tanggal($w[tanggal_selesai])."</td>";
        
echo "                
                      <td>$n_pilganda[persentase]</td>
                      <td>$n_pilganda[kriteriapenilaian]</td></tr>
                            </table><input type=button class=\"btn btn-danger\" value='Kembali' onclick=self.history.back()>";
                }
                else {
                    echo"<br><b class='judul'>Nilai Anda</b><br><p class='garisbawah'></p>
                      <table width=\"100%\" class=\"table table-striped table-bordered table-hover\" id=\"dataTables-example\">
            <thead>
                      <tr><th>Deskripsi Post Test </th><th>Nilai</th><th>Keterangan</th></tr></thead>";
                      $n_pilganda = mysqli_fetch_array($pilganda);
                      echo "<tr>
                      <td>Tugas Pilihan Ganda</td>
                      <td>Anda Belum mengerjakan</td>
                      <td>$n_pilganda[kriteriapenilaian]</td>
                      </tr>
                            </table><input type=button class=\"btn btn-primary\"  value='Kembali' onclick=self.history.back()>";
                }
        }
        elseif (!empty($c_pilganda) AND !empty($c_esay)){
            echo "<script>window.alert('Belum ada Nilai di Post Test ini.');
            window.location=(href='?module=nilai')</script>";
        }
    }
    break;

case "infokerjakan":
    if ($_SESSION[leveluser]=='users'){
        $cek = mysqli_query($DBcon, "SELECT * FROM users_sudah_mengerjakan WHERE id_pelatihan='$_GET[id_pelatihan]' AND id_users = '$_SESSION[idusers]'");
        $data = mysqli_fetch_array($cek);
        
        if ($data[hits]<=0){
        $topik = mysqli_query($DBcon, "SELECT * FROM pelatihan WHERE id_pelatihan = '$_GET[id_pelatihan]'");
        $t = mysqli_fetch_array($topik);
       
        echo"
            <h1 class='text-center'><b>INFORMASI</b></h1>
            <form method='POST' id='soalnya' action='soal.php?' target='_blank'>
            <input type='hidden' name='id_pelatihan' value='$_GET[id_pelatihan]'>
            <h3 class='text-danger'><i>Baca dengan seksama dan teliti sebelum mengerjakan Post Test</i></h3>
            <ol>
              <li>Pastikan koneksi anda terjamin dan bagus, misalnya Warnet.</li>
              <li>Jika menggunakan Modem, pastikan menggunakan operator yang handal.</li>
              <li>Pilih browser yang suport dengan E-Learning PT Phapros yaitu Google Chrome.</li>
              <li>Jika terjadi masalah hubungi admin terkait masalah anda.</li>
            </ol>";
        echo"
        <input type='button' class=\"btn btn-danger\" value='Kembali' onclick=self.history.back()>
        <input type='submit' class='pull-right btn btn-success' value='Mulai Mengerjakan' onclick='window.location.reload()'>
        ";
        }
        elseif ($data[hits] >= 1){
            echo"<br><b class='judul'>Informasi</b><br><p class='garisbawah'></p>";
            echo "<h3>Anda Sudah mengerjakan tugas / Quiz ini</h3>";
            echo "<p class='garisbawah'></p>
                <input type=button class=\"btn btn-danger\"  value='Kembali'
                onclick=self.history.back()>";
        }
    }
    break;

case "buatquiz":
    if ($_SESSION[leveluser]=='admin'){
        $topik=mysqli_query($DBcon, "SELECT * FROM pelatihan WHERE id_pelatihan = '$_GET[id_pelatihan]'");
        $t=mysqli_fetch_array($topik);
        echo "
            <legend>Jenis Kuis</legend>
          <p align=center'>
          <input class='btn btn-default' type=button value='Buat Quiz Esay' onclick=\"window.location.href='?module=buatquizesay&act=buatquizesay&id_pelatihan=$t[id_pelatihan]';\">
          <input class='btn btn-primary' type=button value='Buat Quiz Pilihan Ganda' onclick=\"window.location.href='?module=buatquizpilganda&act=buatquizpilganda&id_pelatihan=$t[id_pelatihan]';\">
          </p>
          <br><input class=\"btn btn-danger\" type=button value=Kembali onclick=self.history.back()>
          ";
    }
    else{
        $topik=mysqli_query($DBcon, "SELECT * FROM pelatihan WHERE id_pelatihan = '$_GET[id_pelatihan]'");
        $t=mysqli_fetch_array($topik);
        echo "
            <legend>Jenis Kuis</legend>

          <p align=center'>
          <input class='btn btn-default' type='button' value='Buat Quiz Esay' onclick=\"window.location.href='?module=buatquizesay&act=buatquizesay&id_pelatihan=$t[id_pelatihan]';\">
          <input class='btn btn-primary' type='button' value='Buat Quiz Pilihan Ganda' onclick=\"window.location.href='?module=buatquizpilganda&act=buatquizpilganda&id_pelatihan=$t[id_pelatihan]';\">
          </p>
          <br><input class=\"btn btn-danger\" type=button value=Kembali onclick=self.history.back()>
          ";
    }
    break;

case "buatquizesay":
    if ($_SESSION[leveluser]=='admin'){
        $jum = mysqli_query($DBcon, "SELECT COUNT(quiz_esay.id_quiz) as jml FROM quiz_esay WHERE id_pelatihan= '$_GET[id_pelatihan]'");
        $j = mysqli_fetch_array($jum);
        $jumlah = $j[jml] + 1;
        
        echo "
        <form method=POST action='$aksi?module=quiz&act=input_quizesay' enctype='multipart/form-data'>        
        <input type=hidden name=id_pelatihan value='$_GET[id_pelatihan]'>

        <div class=\"panel-body\">
                <div class=\"row\">
                <div class=\"col-lg-6\">

        <legend>Buat Post Test Essay</legend>

        <div class=\"form-group\">
          <label>Pertanyaan ".$jumlah." </label>
          <textarea name='pertanyaan' id='wysiwyg' cols='75' rows='3'></textarea>
        </div>

        <div class=\"form-group\">
        <label>Gambar</label>
          <input  type='file' class='form-control' name='fupload'>
            <small>Jika tidak ada gambar dikosongkann saja.</small>
            <small>Tipe yang di ijinkan JPG dan JPEG</small>
            <small>Jumlah soal esay di database :";
                    if ($j[jml] == 0){
                        echo "<a href='?module=quiz&act=daftarquizesay&id_pelatihan=$_GET[id_pelatihan]' target='_blank' title='Lihat Daftar Soal'><blink> 0</blink></a></small>";
                    }else{
                        echo "<a href='?module=quiz&act=daftarquizesay&id_pelatihan=$_GET[id_pelatihan]' target='_blank' title='Lihat Daftar Soal'><blink> $j[jml]</blink></a></small>";
                    }
        echo"</div>

        <div class=\"form-group\">
          <div class='col-md-6'>
            <input class=\"btn btn-primary\" type='submit' value='Simpan'>
            <input class=\"btn btn-danger\" type='button' value='Batal' onclick='self.history.back()'>
            </div>
          </div>
          </div>
          </div>
          </div>
          </form>";
    }
    else{
        $jum = mysqli_query($DBcon,"SELECT COUNT(quiz_esay.id_quiz) as jml FROM quiz_esay WHERE id_pelatihan = '$_GET[id_pelatihan]'");
        $j = mysqli_fetch_array($jum);
        $jumlah = $j[jml] + 1;

        echo "
        <button class='btn btn-success' onclick='mshow()'><i class='fa fa-search'></i> Cari Soal Lama</button><br><br>
        <form method=POST action='$aksi?module=quiz&act=input_quizesay' enctype='multipart/form-data'>        
        <input type=hidden name=id_pelatihan value='$_GET[id_pelatihan]'>

        <div class=\"panel-body\">
                <div class=\"row\">
                <div class=\"col-lg-6\">
                 
        <legend>Buat Post Test Essay</legend>

        <div class=\"form-group\">
          <label>Pertanyaan ".$jumlah." </label>
          <textarea name='pertanyaan' id='wysiwyg' cols='75' rows='3'></textarea>
        </div>

        <div class=\"form-group\">
        <label>Gambar</label>
          <input  type='file' class='form-control' name='fupload'>
            <small>Jika tidak ada gambar dikosongkann saja.</small>
            <small>Tipe yang di ijinkan JPG dan JPEG</small>
            <small>Jumlah soal esay di database :";
                    if ($j[jml] == 0){
                        echo "<a href='?module=quiz&act=daftarquizesay&id_pelatihan=$_GET[id_pelatihan]' target='_blank' title='Lihat Daftar Soal'><blink> 0</blink></a></small>";
                    }else{
                        echo "<a href='?module=quiz&act=daftarquizesay&id_pelatihan=$_GET[id_pelatihan]' target='_blank' title='Lihat Daftar Soal'><blink> $j[jml]</blink></a></small>";
                    }
        echo"</div>

        <div class=\"form-group\">
            <input class=\"btn btn-danger\" type='button' value='Batal' onclick='self.history.back()'>
            <input class=\"btn btn-primary\" type='submit' value='Simpan'>
        </div>
      </div>
     </div>
  </form>";

      echo '<div class="modal fade bs-example-modal-lg" tabindex="-1" id="modal" role="dialog">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                  <h4 class="modal-title">Soal Esay Lama</h4>
                </div>
                <div class="modal-body">
                  <div class="table-responsive">
                    <table class="table">
                        <thead>
                          <th>No.</th>
                          <th>Soal</th>
                          <th>#</th>
                        </thead>

                        <tbody>
                          <td></td>
                          <td></td>
                          <td></td>
                        </tbody>
                    </table>
                  </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                  <button type="button" class="btn btn-primary">Save changes</button>
                </div>
              </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
          </div><!-- /.modal -->';


          echo "<script>
                function mshow() {
                    $('#modal').modal('show'); 
                }
              </script>";
    }
    break;

case "buatquizpilganda":
    if ($_SESSION[leveluser]=='admin'){
        echo "Hello!!!.";
    }
    else{
        $jum = mysqli_query($DBcon,"SELECT COUNT(quiz_pilganda.id_quiz) as jml FROM quiz_pilganda WHERE id_pelatihan = '$_GET[id_pelatihan]'");
        $j = mysqli_fetch_array($jum);
        $jumlah = $j[jml] + 1;
  
        echo"<form method=POST action='$aksi?module=quiz&act=input_quizpilganda' enctype='multipart/form-data'>";
        echo"
          <div class=\"panel-body\">
                  <div class=\"row\">
                  <div class=\"col-lg-6\">
             <legend>Buat Post Test Pilihan Ganda</legend>

          <div class=\"form-group\">
          <label>Pertanyaan ".$jumlah." </label>
          <textarea name='pertanyaan' id='wysiwyg' cols='75' rows='3'></textarea>
              <p class=\"help-block\">Example block-level help text here.</p>
          </div>

          <div class=\"form-group\">
          <label>Gambar Pertanyaan</label>
            <input class='form-control' type='file' name='fupload' size=40>
              <small>Apabila tidak ada gambar pertanyaan, di kosongkan saja</small>
              <small>Tipe gambar yang di ijinkan JPG dan JPEG</small>
          </div>

          <div class=\"form-group\">
            <label>Pilihan A </label>
            <textarea name='pila' id='wysiwyg2' cols='75' rows='3'></textarea>
          </div>
          <div class=\"form-group\">
            <label>Pilihan B </label>
            <textarea name='pilb' id='wysiwyg2' cols='75' rows='3'></textarea>
          </div>
          <div class=\"form-group\">
            <label>Pilihan C </label>
            <textarea name='pilc' id='wysiwyg2' cols='75' rows='3'></textarea>
          </div>
          
          <div class=\"form-group\">
            <label>Pilihan D </label>
            <textarea name='pild' id='wysiwyg2' cols='75' rows='3'></textarea>
          </div>

          <div class=\"form-group\">
            <label>Kunci Jawaban</label>
              <div class='radio'>
                  <label>
                  <input type='radio' name='kunci' value='A'>A</input>
                  <label>
              </div>   

              <div class='radio'>
                  <label>
                  <input type='radio' name='kunci' value='B'>B</input>
                  <label>
              </div>

              <div class='radio'>
                  <label>
                  <input type='radio' name='kunci' value='C'>C</input>
                  <label>
              </div>
              
              <div class='radio'>
                  <label>
                  <input type='radio' name='kunci' value='D'>D</input>
                  <label>
              </div>

             <small>Jumlah soal pilihan ganda di database :";
                    if ($j[jml] == 0){
                        echo "<a href='?module=quiz&act=daftarquizpilganda&id_pelatihan=$_GET[id_pelatihan]' target='_blank' title='Lihat Daftar Soal'><blink> 0</blink></a></small>";
                    }else{
                        echo "<a href='?module=quiz&act=daftarquizpilganda&id_pelatihan=$_GET[id_pelatihan]' target='_blank' title='Lihat Daftar Soal'><blink> $j[jml]</blink></a></small>";
                    }
        echo"</div><input type=hidden name='id_pelatihan' value='$_GET[id_pelatihan]'>
         </dl>
          <div class='buttons'>
          <input class=\"btn btn-primary\" type=submit value=Simpan>
          <input class=\"btn btn-danger\" type=button value=Batal onclick=self.history.back()>
          </div>
          </div></div></div></form>";
    }
    break;

case "daftarquiz":
    if ($_SESSION[leveluser]=='admin'){
        $topik=mysqli_query($DBcon, "SELECT * FROM pelatihan WHERE id_pelatihan = '$_GET[id_pelatihan]'");
        $t=mysqli_fetch_array($topik);
        echo "<form><fieldset>
            <legend>Jenis Kuis</legend>
            <dl class='inline'>
            </dl>
          <p align=center'>
          <input type=button class='btn btn-default' value='Daftar Quiz Esay' onclick=\"window.location.href='?module=daftarquizesay&act=daftarquizesay&id_pelatihan=$t[id_pelatihan]';\"> 
          <input type=button class='btn btn-primary' value='Daftar Quiz Pilihan Ganda' onclick=\"window.location.href='?module=daftarquizpilganda&act=daftarquizpilganda&id_pelatihan=$t[id_pelatihan]';\">
          </p>
          <br><input type=button class=\"btn btn-danger\" value=Kembali onclick=self.history.back()>
          </fieldset></form>";
    }
    else{
        $topik=mysqli_query($DBcon, "SELECT * FROM pelatihan WHERE id_pelatihan = '$_GET[id_pelatihan]'");
        $t=mysqli_fetch_array($topik);
        echo "<form><fieldset>
            <legend>Jenis Kuis</legend>
            <dl class='inline'>
            </dl>
          <p align=center'>
          <input class='btn btn-default' type=button value='Daftar Quiz Esay' onclick=\"window.location.href='?module=daftarquizesay&act=daftarquizesay&id_pelatihan=$t[id_pelatihan]';\">
          <input class='btn btn-primary' type=button value='Daftar Quiz Pilihan Ganda' onclick=\"window.location.href='?module=daftarquizpilganda&act=daftarquizpilganda&id_pelatihan=$t[id_pelatihan]';\">
          </p>
          <br><input type=button class=\"btn btn-danger\" value=Kembali onclick=self.history.back()>
          </fieldset></form>";
    }
    break;

case "daftarquizesay":
    if ($_SESSION[leveluser]=='admin'){
        $cek = mysqli_query($DBcon, "SELECT COUNT(quiz_esay.id_quiz) as jml FROM quiz_esay WHERE id_pelatihan = '$_GET[id_pelatihan]'");
        $c = mysqli_fetch_array($cek);
        if ($c[jml] != 0){
        $quiz=mysqli_query($DBcon, "SELECT * FROM quiz_esay WHERE id_pelatihan = '$_GET[id_pelatihan]'");        
        $jquiz = mysqli_query($DBcon, "SELECT * FROM quiz_esay WHERE id_pelatihan = '$_GET[id_pelatihan]'");
        $jq = mysqli_fetch_array($jquiz);
        $topik = mysqli_query($DBcon, "SELECT * FROM pelatihan WHERE id_pelatihan = '$jq[id_pelatihan]'");
        $t=mysqli_fetch_array($topik);

        echo "
        <div class='panel-body'>
          <legend>Info Post Test</legend>
            <div class='table-responsive'>
              <table class='table table-hover'>
                <thead>
                <tr>
                  <th>Judul</th>
                </tr>
                <tbody>           
                  <td>$t[judul]</td>
                </tbody>
                <thead>
                <tbody>
                  <td>
                    $p[nama]
                  </td>
                </tbody>
                </div></div>";
        echo "<div class='col-md-6'>
        <input class=\"btn btn-primary\" type='button' value='Tambah Quiz Esay' onclick=\"window.location.href='?module=quiz&act=buatquizesay&id_pelatihan=$jq[id_pelatihan]';\">

              <input class=\"btn btn-danger\" type='button' value='Kembali' onclick=\"window.location.href='?module=acara';\"></div>";

        echo "<br><br><table width=\"100%\" class=\"table table-striped table-bordered table-hover\" id=\"dataTables-example\"><thead>
          <tr><th>No</th><th>Pertanyaan</th><th>Gambar</th><th>Tgl Buat</th><th>Aksi</th></tr></thead>";
    $no=1;
    while ($q=mysqli_fetch_array($quiz)){
       $tgl_buat   = tgl_indo($q[tgl_buat]);
       echo "<tr><td>$no</td>
             <td>$q[pertanyaan]</td>
             <td>$q[gambar]</td>
             <td>$tgl_buat</td>
             <td><a href='?module=quiz&act=editquizesay&id_quiz=$q[id_quiz]&id_pelatihan=$q[id_pelatihan]' title='Edit'><i class='fa fa-edit' alt='Edit'> </i></a> |
                 <a href=javascript:confirmdelete('$aksi?module=quiz&act=hapusquizesay&id_quiz=$q[id_quiz]&id_pelatihan=$q[id_pelatihan]') title='Hapus'><i class='fa fa-trash' alt='Delete'></i></a>
                 </td></tr>";
      $no++;
    }
    echo "</table>";
        }else{
            echo "<script>window.alert('Quiz esay masih kosong');
            window.location=(href='?module=acara')</script>";
        }
    }
    elseif ($_SESSION[leveluser]=='pengajar'){
        $cek = mysqli_query($DBcon, "SELECT COUNT(quiz_esay.id_quiz) as jml FROM quiz_esay WHERE id_pelatihan = '$_GET[id_pelatihan]'");
        $c = mysqli_fetch_array($cek);
        if ($c[jml] != 0){
        $quiz=mysqli_query($DBcon, "SELECT * FROM quiz_esay WHERE id_pelatihan = '$_GET[id_pelatihan]'");
        $jquiz = mysqli_query($DBcon, "SELECT * FROM quiz_esay WHERE id_pelatihan = '$_GET[id_pelatihan]'");
        $jq = mysqli_fetch_array($jquiz);
        $topik = mysqli_query($DBcon, "SELECT * FROM pelatihan WHERE id_pelatihan = '$jq[id_pelatihan]'");
        $t=mysqli_fetch_array($topik);
        $kelas = mysqli_query($DBcon, "SELECT * FROM kelas WHERE idtrkatalog = '$t[idtrkatalog]'");
        $k=mysqli_fetch_array($kelas);
        $pelajaran = mysqli_query($DBcon, "SELECT * FROM trkatalog WHERE idtrkatalog = '$t[idtrkatalog]'");
        $p = mysqli_fetch_array($pelajaran);

        echo "<div class='panel-body'>
          <legend>Info Post Test</legend>
            <div class='table-responsive'>
              <table class='table table-hover'>
                <thead>
                <tr>
                  <th>Judul</th>
                </tr>
                <tbody>           
                  <td>$t[judul]</td>
                </tbody>
                <thead>
                </div></div>";
        echo "
        <div class='col-md-9'>
        <input class=\"btn btn-primary\" type=button value='Tambah Quiz Esay' onclick=\"window.location.href='?module=buatquizesay&act=buatquizesay&id_pelatihan=$jq[id_pelatihan]';\">
              <input class=\"btn btn-danger\" type=button value=Kembali onclick=\"window.location.href='?module=acara';\"></div>";

        echo "<br><br><table width=\"100%\" class=\"table table-striped table-bordered table-hover\" id=\"dataTables-example\"><thead>
          <tr><th>No</th><th>Pertanyaan</th><th>Gambar</th><th>Tgl Buat</th><th>Aksi</th></tr></thead>";
    $no=1;
    while ($q=mysqli_fetch_array($quiz)){
       $tgl_buat   = tgl_indo($q[tgl_buat]);
       echo "<tr><td>$no.</td>
             <td>$q[pertanyaan]</td>
             <td>$q[gambar]</td>
             <td>$tgl_buat</td>
             <td><a href='?module=quiz&act=editquizesay&id_pelatihan=$q[id_quiz]&id_pelatihan=$q[id_pelatihan]' title='Edit'><i class='fa fa-edit' alt='Edit'> </i></a> |
                 <a href=javascript:confirmdelete('$aksi?module=quiz&act=hapusquizesay&id_pelatihan=$q[id_quiz]&id_pelatihan=$q[id_pelatihan]') title='Hapus'><i class='fa fa-trash' alt='Delete'> </i></a>
                 </td></tr>";
      $no++;
    }
    echo "</table>";
        }else{
            echo "<script>window.alert('Quiz esay masih kosong');
            window.location=(href='?module=acara')</script>";
        }
    }
    break;

case "daftarquizpilganda":
    if ($_SESSION[leveluser]=='admin'){
        $cek = mysqli_query($DBcon, "SELECT COUNT(quiz_pilganda.id_quiz) as jml FROM quiz_pilganda WHERE id_pelatihan = '$_GET[id_pelatihan]'");
        $c = mysqli_fetch_array($cek);
        if ($c[jml] != 0){
        $quiz=mysqli_query($DBcon, "SELECT * FROM quiz_pilganda WHERE id_pelatihan = '$_GET[id_pelatihan]'");
        $jquiz = mysqli_query($DBcon, "SELECT * FROM quiz_pilganda WHERE id_pelatihan = '$_GET[id_pelatihan]'");
        $jq = mysqli_fetch_array($jquiz);
        $topik = mysqli_query($DBcon, "SELECT * FROM pelatihan WHERE id_pelatihan = '$jq[id_pelatihan]'");
        $t=mysqli_fetch_array($topik);
        $pelajaran = mysqli_query($DBcon, "SELECT * FROM trkatalog WHERE idtrkatalog = '$t[idtrkatalog]'");
        $p = mysqli_fetch_array($pelajaran);

        echo "<div class='panel-body'>
          <legend>Info Post Test</legend>
            <div class='table-responsive'>
              <table class='table table-hover'>
              ";
        echo "
        <div class='col-md-12'>
          <input type='button' class=\"btn btn-primary\" value='Tambah Quiz Pilihan Ganda' onclick=\"window.location.href='?module=quiz&act=buatquizpilganda&id_pelatihan=$jq[id_pelatihan]';\">
          <input type='button' class=\"btn btn-danger\" value=Kembali onclick=\"window.location.href='?module=acara';\">
        </div>";
    echo "<table width=\"100%\" class=\"table table-striped table-bordered table-hover\" id=\"dataTables-example\">";
    $no=1;
    while ($q=mysqli_fetch_array($quiz)){
       echo "<tr><td rowspan=8><b>$no.</b></td>
             <td><b>Pertanyaan</b></td><td> $q[pertanyaan]</td></tr>";
             if (empty($q[gambar])){
                 echo "<tr><td>Gambar</td><td> Tidak ada gambar.</td></tr>";
             }else{
                 echo "<tr><td>Gambar</td><td>
                    <img src='../foto_soal_pilganda/medium_$q[gambar]'></td></tr>";
             }
             echo"<tr><td>Pilihan A</td><td> $q[pil_a]</td></tr>
             <tr><td>Pilihan B</td><td> $q[pil_b]</td></tr>
             <tr><td>Pilihan C</td><td> $q[pil_c]</td></tr>
             <tr><td>Pilihan D</td><td> $q[pil_d]</td></tr>
             <tr><td>Kunci Jawaban</td><td> $q[kunci]</td></tr>
             <tr><td>Aksi</td><td> <a href='?module=quiz&act=editquizpilganda&id_quiz=$q[id_quiz]&id_pelatihan=$q[id_pelatihan]' title='Edit'><i class='fa fa-edit' alt='Edit'> </i></a> |
                 <a href=javascript:confirmdelete('$aksi?module=quiz&act=hapusquizpilganda&id_quiz=$q[id_quiz]&id_pelatihan=$q[id_pelatihan]') title='Hapus'><i class='fa fa-trash' alt='Delete'> </i></a></td></tr>
             ";
      $no++;
    }
    echo "</table>";
    echo "<br> <input type='button' class=\"btn btn-danger\" value=Kembali onclick=\"window.location.href='?module=acara';\"><input type='button' class=\"btn btn-primary\" value='Tambah Quiz Pilihan ganda' onclick=\"window.location.href='?module=quiz&act=buatquizpilganda&id_pelatihan=$jq[id_pelatihan]';\">
             ";
    }else{
            echo "<script>window.alert('Quiz pilihan ganda masih kosong');
            window.location=(href='?module=acara')</script>";
        }
    }
    else{        

        $cek = mysqli_query($DBcon, "SELECT COUNT(quiz_pilganda.id_quiz) as jml FROM quiz_pilganda WHERE id_pelatihan = '$_GET[id_pelatihan]'");
        $c = mysqli_fetch_array($cek);
        if ($c[jml] != 0){
        $quiz=mysqli_query($DBcon, "SELECT * FROM quiz_pilganda WHERE id_pelatihan = '$_GET[id_pelatihan]' ");
        $jquiz = mysqli_query($DBcon, "SELECT * FROM quiz_pilganda WHERE id_pelatihan = '$_GET[id_pelatihan]'");
        $jq = mysqli_fetch_array($jquiz);
        $topik = mysqli_query($DBcon, "SELECT * FROM pelatihan WHERE id_pelatihan = '$jq[id_pelatihan]'");
        $t=mysqli_fetch_array($topik);
        $pelajaran = mysqli_query($DBcon, "SELECT * FROM trkatalog WHERE idtrkatalog = '$t[idtrkatalog]'");
        $p = mysqli_fetch_array($pelajaran);


        echo "            
          <legend><b>Daftar Soal Post Test Pilihan Ganda</b></legend>
              <table class='table table-hover'>
                <thead>
                <tr>
                  <th>Nama Pelatihan</th>
                  <th>Kategori</th>
                </tr>
                <tbody>           
                  <td>$t[nama_pelatihan]</td>
                  <td>
                    $p[nama]
                  </td>
                </tbody>
                </div></div>";
        echo "<div class='col-md-12'> <input type=button class=\"btn btn-danger\" value=Kembali onclick=\"window.location.href='?module=acara';\">
        <input type=button class=\"pull-right btn btn-primary\" value='Tambah Quiz Pilihan ganda' onclick=\"window.location.href='?module=quiz&act=buatquizpilganda&id_pelatihan=$jq[id_pelatihan]';\">
             </div>";

       echo "<table width=\"100%\" class=\"table table-striped table-bordered table-hover\" id=\"tableCustom\">
       <thead> 
          <th>No</th>  
          <th>Pertanyaan</th>
          <th>Gambar</th>
          <th>Pilihan</th>
          <th>Jawaban</th>
          <th>Aksi</th>
      </thead>
      <tbody>";
    $no=1;
    while($q = mysqli_fetch_array($quiz)) {
           echo "

        <td><b>".++$no_urut."</b></td>
        <td>$q[pertanyaan]</td>";
             if (empty($q[gambar])){
                 echo "
        <td> Tidak ada gambar.</td>";
             }else{
                 echo "
        <td><img src='../foto_soal_pilganda/medium_$q[gambar]'></td>";
             }
             echo"
             <td>
               <ol type='a'>
                <li>$q[pil_a]</li>
                <li>$q[pil_b]</li>
                <li>$q[pil_c]</li>
                <li>$q[pil_d]</li>
              </ol>
            </td>
             <td> $q[kunci]</td>
             <td> <a href='?module=quiz&act=editquizpilganda&id_quiz=$q[id_quiz]&id_pelatihan=$q[id_pelatihan]' title='Edit'><i class='fa fa-edit' alt='Edit'> </i></a> |
                 <a href=javascript:confirmdelete('$aksi?module=quiz&act=hapusquizpilganda&id_quiz=$q[id_quiz]&id_pelatihan=$q[id_pelatihan]') title='Hapus'><i class='fa fa-trash' alt='Delete'> </i></a></td></tr>
             "; $i++; 
                $count++;
                    }
    echo "</tbody></table>";        
    }else{
            echo "<script>window.alert('Quiz pilihan ganda masih kosong');
            window.location=(href='?module=acara')</script>";
        }
    }
    break;

case "editquizesay":
    if ($_SESSION[leveluser]=='admin'){
        $quiz=mysqli_query($DBcon, "SELECT * FROM quiz_esay WHERE id_quiz = '$_GET[id_quiz]'");
        $q = mysqli_fetch_array($quiz);     

        echo "<form method=POST action='$aksi?module=quiz&act=edit_quizesay' enctype='multipart/form-data'>
        <input type=hidden name=id_quiz value='$q[id_quiz]'>
        <input type=hidden name=id_pelatihan value='$_GET[id_pelatihan]'>
            <div class=\"panel-body\">
            <div class=\"row\">
            <div class=\"col-lg-6\">
         <legend>Edit Post Test</legend>


        <div class=\"form-group\">
          <label>Pertanyaan</label>
          <textarea name='pertanyaan' id='wysiwyg' cols=75 rows=3>$q[pertanyaan]
          </textarea>
        </div>
        
        <div class=\"form-group\">
          <label>Gambar</label>";
        if ($q[gambar]!=''){
          echo "
            <img class='img-responsive' src='../foto_soal/medium_$q[gambar]'>
        <div>";
        }else{
          echo " <p>Tidak Ada Gambar</p>";
        }
          echo"
        <div class=\"form-group\">
          <label>Ganti Gambar</label>
            <input class='form-control' type=file name='fupload'>
              <small>Jika gambar tidak diganti, dikosongkan saja.</small>
              <small>Tipe yang di ijinkan JPG dan JPEG</small></dd>
          </div>
          <div class='col-md-6'>
          <input class=\"btn btn-primary\" type=submit value=Simpan>
          <input class=\"btn btn-danger\" type=button value=Batal onclick=self.history.back()>
          </div>
          </div></div></div></form>";
    }
    else{
        $quiz=mysqli_query($DBcon, "SELECT * FROM quiz_esay WHERE id_quiz = '$_GET[id_quiz]'");
        $q = mysqli_fetch_array($quiz);

       echo "<form method=POST action='$aksi?module=quiz&act=edit_quizesay' enctype='multipart/form-data'>
        <input type=hidden name=id_quiz value='$q[id_quiz]'>
        <input type=hidden name=id_pelatihan value='$_GET[id_pelatihan]'>
            <div class=\"panel-body\">
            <div class=\"row\">
            <div class=\"col-lg-6\">
         <legend>Edit Post Test</legend>

        <div class=\"form-group\">
          <label>Pertanyaan</label>
          <textarea name='pertanyaan' id='wysiwyg' cols=75 rows=3>$q[pertanyaan]
          </textarea>
        </div>
        
        <div class=\"form-group\">
          <label>Gambar</label>";
        if ($q[gambar]!=''){
          echo "
            <img class='img-responsive' src='../foto_soal/medium_$q[gambar]'>
        <div>";
        }else{
          echo " <p>Tidak Ada Gambar</p>";
        }
          echo"
        <div class=\"form-group\">
          <label>Ganti Gambar</label>
            <input class='form-control' type=file name='fupload'>
              <small>Jika gambar tidak diganti, dikosongkan saja.</small>
              <small>Tipe yang di ijinkan JPG dan JPEG</small></dd>
          </div>
          <div class='col-md-6'>
          <input class=\"btn btn-primary\" type=submit value=Simpan>
          <input class=\"btn btn-danger\" type=button value=Batal onclick=self.history.back()>
          </div>
          </div></div></div></form>";
    }
    break;

case "editquizpilganda":
    if ($_SESSION[leveluser]=='admin'){
        $quiz=mysqli_query($DBcon, "SELECT * FROM quiz_pilganda WHERE id_quiz = '$_GET[id_quiz]'");
        $q = mysqli_fetch_array($quiz);
        echo "<form method=POST action='$aksi?module=quiz&act=edit_quizpilganda' enctype='multipart/form-data'>
        <input type=hidden name=id_quiz value='$q[id_quiz]'>
        <input type=hidden name='id_pelatihan' value='$_GET[id_pelatihan]'>
        <div class=\"panel-body\">
            <div class=\"row\">
            <div class=\"col-lg-6\">
        <legend>Edit Post Test Pilihan Ganda</legend>      

        <div class=\"form-group\">
          <label>Pertanyaan </label>
            <textarea name='pertanyaan' id='wysiwyg' cols='75' rows='3'>$q[pertanyaan]</textarea>
        </div>


        <div class=\"form-group\">
             <label>Gambar</label>";
                    if ($q[gambar]!=''){
              echo "<img class='img-responsive' src='../foto_soal_pilganda/medium_$q[gambar]'>";
             }else{
                 echo " Tidak ada gambar.";
             }
             echo "
        </div>

        <div class=\"form-group\">
          <label>Ganti Gambar</label>
            <input class='form-control' type=file name='fupload'>
          <small>Apabila gambar pertanyaan tidak diganti, di kosongkan saja</small>
          <small>Tipe gambar jang di ijinkan JPG dan JPEG</small>
        </div>

        <div class=\"form-group\">
          <label>Pilihan A </label>
            <textarea name='pila' id='wysiwyg2' cols='75' rows='3'>$q[pil_a]</textarea>
        </div>

        <div class=\"form-group\">
          <label>Pilihan B </label>
            <textarea name='pilb' id='wysiwyg2' cols='75' rows='3'>$q[pil_b]</textarea>
        </div>
        
        <div class=\"form-group\">
          <label>Pilihan C </label>
            <textarea name='pilc' id='wysiwyg2' cols='75' rows='3'>$q[pil_c]</textarea>
        </div>
        
        <div class=\"form-group\">
          <label>Pilihan D </label>
            <textarea name='pild' id='wysiwyg2' cols='75' rows='3'>$q[pil_d]</textarea>
        </div>
        
        <div class=\"form-group\">
          <label>Kunci Jawaban </label>";
            if($q[kunci]=='A'){
            echo"
          <div class='radio'>
            <label>
              <input type=radio name='kunci' value=A checked>A</input>
            </label>
          </div>

          <div class='radio'>
          <label>
            <input type=radio name='kunci' value=B>B</input>
          </label>
          </div>

          <div class='radio'>
          <label>
            <input type=radio name='kunci' value=C>C</input>
          </label>
          </div>

          <div class='radio'>
          <label>
            <input type=radio name='kunci' value=D>D</input>
          </label>
          </div>
        </div>";}
        elseif($q[kunci]=='B'){
        echo"          
        <div class='radio'>
            <label>
              <input type=radio name='kunci' value=A >A</input>
            </label>
          </div>

          <div class='radio'>
          <label>
            <input type=radio name='kunci' value=B checked>B</input>
          </label>
          </div>

          <div class='radio'>
          <label>
            <input type=radio name='kunci' value=C>C</input>
          </label>
          </div>

          <div class='radio'>
          <label>
            <input type=radio name='kunci' value=D>D</input>
          </label>
          </div>
        </div>";
    }
    elseif($q[kunci]=='C'){
        echo"          
        <div class='radio'>
            <label>
              <input type=radio name='kunci' value=A >A</input>
            </label>
          </div>

          <div class='radio'>
          <label>
            <input type=radio name='kunci' value=B>B</input>
          </label>
          </div>

          <div class='radio'>
          <label>
            <input type=radio name='kunci' value=C checked>C</input>
          </label>
          </div>

          <div class='radio'>
          <label>
            <input type=radio name='kunci' value=D>D</input>
          </label>
          </div>
        </div>";
    }
    else{
        echo"          
        <div class='radio'>
            <label>
              <input type=radio name='kunci' value=A >A</input>
            </label>
          </div>

          <div class='radio'>
          <label>
            <input type=radio name='kunci' value=B>B</input>
          </label>
          </div>

          <div class='radio'>
          <label>
            <input type=radio name='kunci' value=C>C</input>
          </label>
          </div>

          <div class='radio'>
          <label>
            <input type=radio name='kunci' value=D checked>D</input>
          </label>
          </div>
        </div>";
    }
          echo "
          <div class='col-md-6'>
            <input class=\"btn btn-primary\" type='submit' value=Update>
            <input class=\"btn btn-danger\" type='button' value=Batal onclick=self.history.back()>
            </div>
          </div></div></div></form>";
    }
    elseif ($_SESSION[leveluser]=='pengajar'){
         $quiz=mysqli_query($DBcon, "SELECT * FROM quiz_pilganda WHERE id_quiz = '$_GET[id_quiz]'");
        $q = mysqli_fetch_array($quiz);
        echo "<form method=POST action='$aksi?module=quiz&act=edit_quizpilganda' enctype='multipart/form-data'>
         <input type=hidden name='id_quiz' value='$q[id_quiz]'>
        <input type=hidden name='id_pelatihan' value='$_GET[id_pelatihan]'>
        <div class=\"panel-body\">
            <div class=\"row\">
            <div class=\"col-lg-6\">
        <legend>Edit Post Test Pilihan Ganda</legend>      

        <div class=\"form-group\">
          <label>Pertanyaan </label>
            <textarea name='pertanyaan' id='wysiwyg' cols='75' rows='3'>$q[pertanyaan]</textarea>
        </div>


        <div class=\"form-group\">
             <label>Gambar</label>";
                    if ($q[gambar]!=''){
              echo "<img class='img-responsive' src='../foto_soal_pilganda/medium_$q[gambar]'>";
             }else{
                 echo " Tidak ada gambar.";
             }
             echo "
        </div>

        <div class=\"form-group\">
          <label>Ganti Gambar</label>
            <input class='form-control' type=file name='fupload'>
          <small>Apabila gambar pertanyaan tidak diganti, di kosongkan saja</small>
          <small>Tipe gambar jang di ijinkan JPG dan JPEG</small>
        </div>

        <div class=\"form-group\">
          <label>Pilihan A </label>
            <textarea name='pila' id='wysiwyg2' cols='75' rows='3'>$q[pil_a]</textarea>
        </div>

        <div class=\"form-group\">
          <label>Pilihan B </label>
            <textarea name='pilb' id='wysiwyg2' cols='75' rows='3'>$q[pil_b]</textarea>
        </div>
        
        <div class=\"form-group\">
          <label>Pilihan C </label>
            <textarea name='pilc' id='wysiwyg2' cols='75' rows='3'>$q[pil_c]</textarea>
        </div>
        
        <div class=\"form-group\">
          <label>Pilihan D </label>
            <textarea name='pild' id='wysiwyg2' cols='75' rows='3'>$q[pil_d]</textarea>
        </div>
        
        <div class=\"form-group\">
          <label>Kunci Jawaban </label>";
            if($q[kunci]=='A'){
            echo"
          <div class='radio'>
            <label>
              <input type=radio name='kunci' value=A checked>A</input>
            </label>
          </div>

          <div class='radio'>
          <label>
            <input type=radio name='kunci' value=B>B</input>
          </label>
          </div>

          <div class='radio'>
          <label>
            <input type=radio name='kunci' value=C>C</input>
          </label>
          </div>

          <div class='radio'>
          <label>
            <input type=radio name='kunci' value=D>D</input>
          </label>
          </div>
        </div>";}
        elseif($q[kunci]=='B'){
        echo"          
        <div class='radio'>
            <label>
              <input type=radio name='kunci' value=A >A</input>
            </label>
          </div>

          <div class='radio'>
          <label>
            <input type=radio name='kunci' value=B checked>B</input>
          </label>
          </div>

          <div class='radio'>
          <label>
            <input type=radio name='kunci' value=C>C</input>
          </label>
          </div>

          <div class='radio'>
          <label>
            <input type=radio name='kunci' value=D>D</input>
          </label>
          </div>
        </div>";
    }
    elseif($q[kunci]=='C'){
        echo"          
        <div class='radio'>
            <label>
              <input type=radio name='kunci' value=A >A</input>
            </label>
          </div>

          <div class='radio'>
          <label>
            <input type=radio name='kunci' value=B>B</input>
          </label>
          </div>

          <div class='radio'>
          <label>
            <input type=radio name='kunci' value=C checked>C</input>
          </label>
          </div>

          <div class='radio'>
          <label>
            <input type=radio name='kunci' value=D>D</input>
          </label>
          </div>
        </div>";
    }
    else{
        echo"          
        <div class='radio'>
            <label>
              <input type=radio name='kunci' value=A >A</input>
            </label>
          </div>

          <div class='radio'>
          <label>
            <input type=radio name='kunci' value=B>B</input>
          </label>
          </div>

          <div class='radio'>
          <label>
            <input type=radio name='kunci' value=C>C</input>
          </label>
          </div>

          <div class='radio'>
          <label>
            <input type=radio name='kunci' value=D checked>D</input>
          </label>
          </div>
        </div>";
    }
          echo "
          <div class='col-md-6'>
            <input class=\"btn btn-primary\" type='submit' value=Update>
            <input class=\"btn btn-danger\" type='button' value=Batal onclick=self.history.back()>
            </div>
          </div></div></div></form>";
    }
    break;

}
}
?>

                            <!-- /.table-responsive -->
                            </div>
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->