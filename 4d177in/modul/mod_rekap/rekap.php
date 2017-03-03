            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">Manajemen Rekap</div>
                        <!-- /.panel-heading -->
                        <div class="panel-body"><script>
function confirmdelete(delUrl) {
if (confirm("Anda yakin ingin menghapus?")) {
document.location = delUrl;
}
}
$(document).ready(function(){
    $(".form-control").change(function(){
        $(this).css("background-color", "#D6D6FF");
    });
});
</script>
<?php
session_start();
 if (empty($_SESSION['username']) AND empty($_SESSION['passuser'])){
  echo "<link href=../css/style.css rel=stylesheet type=text/css>";
  echo "<div class='error msg'>Untuk mengakses Modul anda harus login.</div>";
}
else{


$act="modul/mod_rekap/aksi_rekap.php";
function konversi_tanggal($date)    
    {         
    $exp = explode('-',$date);    
    if(count($exp) == 3){
      $date = $exp[2].'-'.$exp[1].'-'.$exp[0];    
    }return $date;
  }    
switch($_GET[act]){
// Tampil Kategori
  default:
    if ($_SESSION[leveluser]=='admin'){
      echo "Super Admin";
    }
    elseif ($_SESSION[leveluser]=='pengajar'){
      $caritrkatalog = mysqli_query($DBcon, 'SELECT * FROM trkatalog');
      $tk = mysqli_num_rows($caritrkatalog);
         echo "
        <form role='form' method=POST action='?module=rekap&act=lihatrekap'>
          <div class=\"panel-body\">
            <div class=\"row\">
                <legend>Rekap </legend>
                    <div class=\"form-group\">
                      <div class='col-md-4'>
                        <input type='text' id='demo' class='form-control' name='tanggalawal' required/>
                      </div>
                    </div>
                    <div class=\"form-group\">
                      <div class='col-md-4'>
                        <input type='text' id='demo' class='form-control' name='tanggalakhir' required/>
                        </div>
                    </div>
                    <div class=\"form-group\">
                      <div class='col-md-4'>
                        <select class='form-control' name='idtrkatalog' required>
                          <option> Silakan Pilih ...</option>";
                         $caritrkatalog = mysqli_query($DBcon, 'SELECT * FROM trkatalog');
                         while ($tk=mysqli_fetch_array($caritrkatalog)) {
                           echo"
                           <option value='$tk[idtrkatalog]'>$tk[nama]</option>";
                         }

                        
                        echo "</select>
                        </div>
                    </div>

            </div> </div>
            <div class='panel-footer'>
                        <input type='submit' class='btn btn-primary' value='Cek'>
                        </div>
            </form>
          </div>
        </form>

          </div></div></div>";
    }
    else{
      echo "Hello";
    }
    break;
    case 'lihatrekap':
        if ($_SESSION[leveluser]=='admin'){
      echo "Super Admin";
    }
    elseif ($_SESSION[leveluser]=='pengajar'){
      $tanggal = mysql_real_escape_string(konversi_tanggal($_POST[tanggalawal]));
      $tanggal2 = mysql_real_escape_string(konversi_tanggal($_POST[tanggalakhir]));
      $idtrkatalog = mysql_real_escape_string(konversi_tanggal($_POST[idtrkatalog]));

       $tampildata = mysqli_query($DBcon, "SELECT * FROM `pelatihan` WHERE `idtrkatalog` = '$idtrkatalog' AND `tanggal_pelaksanaan` BETWEEN '$tanggal' AND '$tanggal2' AND `tanggal_selesai` BETWEEN '$tanggal' AND '$tanggal2'");//mencari data pelatihan dengan kisaran tanggal
      $td=mysqli_fetch_array($tampildata);

      $cariuserskerja = mysqli_query($DBcon, 'SELECT * FROM `users_sudah_mengerjakan` where id_pelatihan ="'.$td[id_pelatihan].'"');//cari user yang sudah mengerjakan dengan id dan tanggal tadi.
      $cuk=mysqli_fetch_array($cariuserskerja);
     
      //Mencari TR Katalog Berdasarkan ID
      $trkatalog = mysqli_query($DBcon, 'SELECT * FROM `trkatalog` where idtrkatalog ="'.$td[idtrkatalog].'"');
      $ttr=mysqli_fetch_array($trkatalog);

      $cariusers = mysqli_query($DBcon, 'SELECT * FROM users where NIK ="'.$q[pengikut].'"');
      //mencari nama users
      $cu=mysqli_fetch_array($cariusers);
      echo $cu[EmployeeName];

      $carinilai = mysqli_query($DBcon, 'SELECT * FROM nilai where id_users ="'.$q[pengikut].'"');
      //mencari nilai users
      $cn=mysqli_fetch_array($calai);

      echo "
      <label>Menampilkan data dengan kategori $ttr[nama]</label>
      <table class='table table-striped table-bordered table-hover' id='dataTables-example'>
        <thead>
          <th>No</th>
          <th>Nama Pelatihan</th>
          <th>Tanggal Pelatihan</th>
          <th>Berakhir Pelatihan</th>
          <th>Nama</th>
          <th>Aksi</th>
        </head>";
       $tampildata = mysqli_query($DBcon, "SELECT * FROM `pelatihan` WHERE `idtrkatalog` = '$idtrkatalog' AND `tanggal_pelaksanaan` BETWEEN '$tanggal' AND '$tanggal2' AND `tanggal_selesai` BETWEEN '$tanggal' AND '$tanggal2'");//mencari data pelatihan dengan kisaran tanggal
       $no = 1;
      while ($q=mysqli_fetch_array($tampildata)) {
      echo "
      <tbody>
        <tr>
          <td>$no</td>
          <td>
            $q[nama_pelatihan]
          </td>
          <td>
            ".konversi_tanggal($q[tanggal_pelaksanaan])."
          </td>
          <td>
            ".konversi_tanggal($q[tanggal_selesai])."
          </td>
          <td>";
           $hasilpilih .= $q[pengikut] . ",";
          $hasilpilih = substr($hasilpilih,0,-1);
          $tampil_users=mysqli_query($DBcon, "SELECT * FROM users WHERE find_in_set(NIK,'$hasilpilih')");
          while ($p=mysqli_fetch_array($tampil_users)) {
                  echo "<a href='?module=rekap&act=rincirekap&iduser=$p[NIK]&idpelatihan=$q[id_pelatihan]&tanggal=$tanggal&tanggal2=$tanggal2&idtrkatalog=$td[idtrkatalog]'>".$p[EmployeeName]."</a><br>";

                 }
      echo "
          </td>
          <td>
            <a href='$act?module=rekap&act=semuarekap&idpelatihan=$q[id_pelatihan]&tanggal=$tanggal&tanggal2=$tanggal2&idtrkatalog=$td[idtrkatalog]'>Rekap</td>
          </td>
        </tr>
      </tbody>";
    $no++;
         }
   }
    else{
      echo "Hello";
    }
      break;
    case 'rincirekap':
        if ($_SESSION[leveluser]=='admin'){
      echo "Super Admin";
    }
    elseif ($_SESSION[leveluser]=='pengajar'){
      $iduser = mysql_real_escape_string($_GET[iduser]);
      $tanggal = mysql_real_escape_string(($_GET[tanggal]));
      $tanggal2 = mysql_real_escape_string(($_GET[tanggal2]));
      $idtrkatalog = mysql_real_escape_string(($_GET[idtrkatalog]));

       $tampildata = mysqli_query($DBcon, "SELECT * FROM `pelatihan` WHERE `idtrkatalog` = '$idtrkatalog' AND `tanggal_pelaksanaan` BETWEEN '$tanggal' AND '$tanggal2' AND `tanggal_selesai` BETWEEN '$tanggal' AND '$tanggal2' AND `pengikut` LIKE '%$iduser%'");
       //mencari data pelatihan dengan kisaran tanggal
      $td=mysqli_fetch_array($tampildata);

      $cariusers = mysqli_query($DBcon, "SELECT * FROM users where NIK ='$iduser'");
            //mencari nama users
      $cu=mysqli_fetch_array($cariusers);


      $trkatalog = mysqli_query($DBcon, "SELECT * FROM trkatalog where idtrkatalog ='$td[idtrkatalog]'");
            //mencari nama users
      $tr=mysqli_fetch_array($trkatalog);

      $cariuserskerja = mysqli_query($DBcon, "SELECT * FROM `users_sudah_mengerjakan` where id_users ='$cu[id_users]' and id_pelatihan='$td[id_pelatihan]'");
      //cari user yang sudah mengerjakan dengan id dan tanggal tadi.
      $cuk=mysqli_fetch_array($cariuserskerja);
     
      $carinilai = mysqli_query($DBcon, "SELECT * FROM nilai where id_users ='$cu[id_users]' and id_pelatihan='$td[id_pelatihan]'");
      //mencari nilai users
      $cn=mysqli_fetch_array($carinilai);
      $no=1;
      if (mysqli_num_rows($cariuserskerja)<1) {
    echo "<script>window.alert('Users Belum Mengerjakan.');
                       window.location=(href='?module=rekap')</script>";
      }else{

      echo "
      <div class='table-responsive'>
                                <table class='table'>
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>NIK</th>
                                            <th>Nama</th>
                                            <th>Jabatan</th>
                                            <th>Nama Trainer</th>
                                            <th>Tgl Traning</th>
                                            <th>Tgl Selesai</th>
                                            <th>Provider/Penyelenggara</th>
                                            <th>Traning Katalog</th>
                                            <th>Nilai</th>
                                            <th>Rekomendasi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>$no</td>
                                            <td>$cu[NIK]</td>
                                            <td>$cu[EmployeeName]</td>
                                            <td>$cu[PosTitle]</td>
                                            <td>$td[nama_trainer]</td>
                                            <td>$td[tanggal_pelaksanaan]</td>
                                            <td>$td[tanggal_selesai]</td>
                                            <td>PT Phapros, Tbk</td>
                                            <td>$tr[nama]</td>
                                            <td>$cn[persentase]</td>
                                            <td>$cn[kriteriapenilaian]</td>
                                        </tr>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.table-responsive -->
                        </div>
                        <!-- /.panel-body -->";
                        $no++;
      }
      echo "
      <center><div class='panel-footer'><a href='$act?module=rekap&act=cetakrekap&iduser=$cu[NIK]&idpelatihan=$q[id_pelatihan]&tanggal=$tanggal&tanggal2=$tanggal2&idtrkatalog=$td[idtrkatalog]'><button class='btn btn-primary'><i class='fa fa-print'></i>Excel</button></a>
      </div></center>";
    }
    else{
      echo "Hello";
    }
      break;
}}
?>

                            <!-- /.table-responsive -->
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->