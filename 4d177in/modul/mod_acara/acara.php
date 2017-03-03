<div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Manajemen Learning</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <div class="row">
                <div class="col-lg-12">
                    
                        <!-- /.panel-heading -->
                        <div class="panel-body">

                          <script>
                          function confirmdelete(delUrl) {
                            if (confirm("Anda yakin ingin menghapus data ini? Jika anda menghapus data ini maka pesan untuk users akan terhapus juga.")) {
                            document.location = delUrl;
                            }
                          }function confirminfo(delUrl) {
                            if (confirm("Anda yakin ingin melihat info?")) {
                            document.location = delUrl;
                            }
                          }function confirmkuis(delUrl) {
                            if (confirm("Anda yakin ingin membuat kuis?")) {
                            document.location = delUrl;
                            }
                          }
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
function konversi_tanggal($date)    
    {    
    $exp = explode('-',$date);    
    if(count($exp) == 3)    
    {    
      $date = $exp[2].'-'.$exp[1].'-'.$exp[0];    
    }    
    return $date;    
    }    
?>

<?php
session_start();
 if (empty($_SESSION['username']) AND empty($_SESSION['passuser'])){
  echo "<link href=../css/style.css rel=stylesheet type=text/css>";
  echo "<div class='error msg'>Untuk mengakses Modul anda harus login.</div>";
}
else{


include "../../../configurasi/fungsi_idpelatihan.php";
$aksi="modul/mod_acara/aksi_acara.php";
switch($_GET[act]){
  // Tampil kelas
  default:
    if ($_SESSION[leveluser]=='admin'){
  echo "Hello!!!";
    }
   
 elseif ($_SESSION[leveluser]=='pengajar'){                      
        $tampil_materi = mysqli_query($DBcon,"SELECT * FROM pelatihan ORDER BY id_pelatihan DESC");
        $cek_materi = mysqli_num_rows($tampil_materi);
  echo'<div class="panel panel-default">
                        <div class="panel-heading">
                        Daftar Learning
                        </div> 
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <!-- Button trigger modal -->
                            <button class="btn btn-primary" data-toggle="modal" data-target="#myModal"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                                Buat Learning
                            </button><hr>
                            <!-- Modal -->
                            <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                            <form method="POST" action="?module=acara&act=tambahpelatihan">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                            <h4 class="modal-title" id="myModalLabel">Silakan Pilih Kategori Post Test</h4>
                                        </div>
                                        <div class="modal-body">
                                        <div class=\"form-group\">
                                          <label>TR Katalog</label>
                                          <select class="form-control" name="idtrkatalog" id="idtrkatalog" required>
                                              <option>-pilih-</option>';
                                              $cari_trkatalog = mysqli_query($DBcon,"SELECT * FROM trkatalog");
                                              while ($k=mysqli_fetch_array($cari_trkatalog)){
                                              echo"
                                              <option value='".$k[idtrkatalog]."'>".$k[nama]."</option>";
                                            }
                                            echo '
                                            </select>
                                        </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary">Save changes</button>
                                        </div>
                                    </div>
                                    <!-- /.modal-content -->
                                </div>
                                </form>
                                <!-- /.modal-dialog -->
                            </div>
                            <!-- /.modal -->';
        echo "<br><br><table width=\"100%\" class=\"table table-striped table-bordered table-hover\" id=\"dataTables-example\">
            <thead>
          <tr><th>No</th><th>ID pelatihan</th><th>TR Katalog</th><th>Reason Codde</th><th>Prioritas</th><th>Nama pelatihan</th><th>Nama Trainer</th><th>Aksi</th></tr></thead>";
       $no=1;
    while ($r=mysqli_fetch_array($tampil_materi)){
      $tgl_posting   = tgl_indo($r[tgl_posting]);
       echo "<tr><td>$no</td>             
       <td>$r[id_pelatihan]</td>";
             $pilih="SELECT * FROM study_method where idstudy_method = '$r[idstudy_method]'";
              $query=mysqli_query($DBcon,$pilih);
              while($row=mysqli_fetch_array($query)){
              echo"<td>".$row[nama]."</td>";
              }
            $cari_trkatalog = mysqli_query($DBcon,"SELECT * FROM trkatalog WHERE idtrkatalog = '$r[idtrkatalog]'");
            while ($k=mysqli_fetch_array($cari_trkatalog)){
            echo"<td>".$k[nama]."</td>";
          } $pilih="SELECT * FROM reason_codde where idreason_codde = '$r[idreason_codde]'";
              $query=mysqli_query($DBcon,$pilih);
              while($row=mysqli_fetch_array($query)){
              echo"<td>".$row[nama]."</td>";
              }
            $cari_trkatalog = mysqli_query($DBcon,"SELECT * FROM prioritas WHERE idprioritas = '$r[idprioritas]'");
            while ($k=mysqli_fetch_array($cari_trkatalog)){
            echo"<td>".$k[nama]."</td>";
          }
      echo "<td>$r[nama_pelatihan]</td>
             <td>$r[nama_trainer]</td>
             <td>
             <ol>
                <li><a href=?module=acara&act=rincianpelatihan&id_pelatihan=$r[id_pelatihan]>Rincian Learning</a>
                </li>
                <li><a href='?module=acara&act=editpelatihan&id_pelatihan=$r[id_pelatihan]' title='Edit'><i class='fa fa-edit'/></i></a>|<a href=javascript:confirmdelete('$aksi?module=acara&act=hapus&id_pelatihan=$r[id_pelatihan]') title='Hapus'><i class='fa fa-trash'/></i></a>
                </li>
                 <li><a href=?module=buatquiz&act=buatquiz&id_pelatihan=$r[id_pelatihan]>Buat Quiz</a>
                 </li>
                 <li><a href=?module=daftarquiz&act=daftarquiz&id_pelatihan=$r[id_pelatihan]>Daftar Quiz</a></li>
                 <li><a href=?module=quiz&act=daftarusersyangtelahmengerjakan&id_pelatihan=$r[id_pelatihan]>Daftar Peserta & Koreksi</a></li>
              </ul>
              </td>
            </tr>";
      $no++;
    }
    echo "</table>";
    }
    
    else{
        echo"<br><b>Learning</b><br><p></p>";

        $mapel = mysqli_query($DBcon,"SELECT * FROM pelatihan");
       echo "<table width=\"100%\" class=\"table table-striped table-bordered table-hover\" id=\"dataTables-example\"><thead>
          <tr><th>No</th><th>Nama pelatihan</th><th>Prioritas</th><th>Tanggal Pelaksanaan</th><th>Aksi</th></tr></thead>";
        $no=1;
        while ($r=mysqli_fetch_array($mapel)){
        echo "<tr><td>$no</td>
             <td>$r[nama_pelatihan]</td>";
             echo "<td><input type=button class=\"btn btn-default\" value='Daftar'
                       onclick=\"window.location.href='?module=materi&act=daftarmateri&id=$r[id_matapelajaran]';\"></td></tr>";
        $no++;
        }
        echo "</table>";


    }
    break;

case 'rincianpelatihan':
if ($_SESSION[leveluser]=='admin') {
        $detail=mysqli_query($DBcon,"SELECT * FROM pelatihan WHERE id_pelatihan='$_GET[id_pelatihan]'");
        $lama = $pelatihan[lama]/60;
       $pelatihan=mysqli_fetch_array($detail);

       echo "
              <div class=\"panel-body\">
          <div class=\"table-responsive\">
              <table class=\"table table-hover\">
          <thead>
              <tr>
                <th>ID Learning</th>
              </tr>
          </thead>
          <tbody>
            <td>$pelatihan[id_pelatihan]</td>
          </tbody>
          <thead>
              <tr>
                <th>Studi Method</th>
              </tr>
          </thead>
          <tbody>";
          $cari_study = mysqli_query($DBcon,"SELECT * FROM study_method WHERE idstudy_method = '$pelatihan[idstudy_method]'");
            while ($k=mysqli_fetch_array($cari_study)){
            echo"
            <td>".$k[nama]."</td>";
              }
            echo"
          </tbody>
          <thead>
              <tr>
                <th>TR Katalog</th>
              </tr>
          </thead>
           <tbody>";
          $cari_trk = mysqli_query($DBcon,"SELECT * FROM trkatalog WHERE idtrkatalog = '$pelatihan[idtrkatalog]'");
            while ($k=mysqli_fetch_array($cari_trk)){
            echo"
            <td>".$k[nama]."</td>";
              }
            echo"
          </tbody>

          <thead>
              <tr>
                <th>Reason Code</th>
              </tr>
          </thead> 
          <tbody>";
          $cari_reason = mysqli_query($DBcon,"SELECT * FROM reason_codde WHERE idreason_codde = '$pelatihan[idreason_codde]'");
            while ($k=mysqli_fetch_array($cari_reason)){
            echo"
            <td>".$k[nama]."</td>";
              }
            echo"
          </tbody>

          <thead>
              <tr>
                <th>Prioritas</th>
              </tr>
          </thead>    
          <tbody>";
          $cari_prio = mysqli_query($DBcon,"SELECT * FROM prioritas WHERE idprioritas = '$pelatihan[idprioritas]'");
            while ($k=mysqli_fetch_array($cari_prio)){
            echo"
            <td>".$k[nama]."</td>";
              }
            echo"
          </tbody>

          <thead>
              <tr>
                <th>Nama Learning</th>
              </tr>
          </thead>
          <tbody>
            <td>$pelatihan[nama_pelatihan]</td>
          </tbody>

          <thead>
              <tr>
                <th>Nama Trainer</th>
              </tr>
          </thead>
          <tbody>
            <td>$pelatihan[nama_trainer]</td>
          </tbody>

          <thead>
              <tr>
                <th>Asal Trainer</th>
              </tr>
          </thead>
          <tbody>
            <td>$pelatihan[asal_trainer]</td>
          </tbody>

          <thead>
              <tr>
                <th>Tanggal Pelaksanaan</th>
              </tr>
          </thead>
          <tbody>
            <td>$pelatihan[tanggal_pelaksanaan]</td>
          </tbody>

          <thead>
              <tr>
                <th>Tanggal Selesai</th>
              </tr>
          </thead>
          <tbody>
            <td>$pelatihan[tanggal_selesai]</td>
          </tbody>

          <thead>
              <tr>
                <th>Lama</th>
              </tr>
          </thead>
          <tbody>
            <td>$lama Menit</td>
          </tbody>

          <thead>
              <tr>
                <th>Waktu </th>
              </tr>
          </thead>
          <tbody>
            <td>$pelatihan[waktu] WIB</td>
          </tbody>          

          <thead>
              <tr>
                <th>Tempat</th>
              </tr>
          </thead>
          <tbody>
            <td>$pelatihan[tempat]</td>
          </tbody>

          <thead>
              <tr>
                <th>Materi </th>
              </tr>
          </thead>
          <tbody>";
             if (!empty($pelatihan[materi])){
             $pecah = explode(".", $pelatihan[materi]);
             $ekstensi = $pecah[1];
             if ($ekstensi == 'zip'){
                 echo "<td style='vertical-align:middle;  color:blue;text-align:center; display: table-cell;'rowspan='5'><i class='fa fa-file-zip-o fa-5x'></i></td>";
             }
             elseif ($ekstensi == 'rar'){
                 echo "<td style='vertical-align:middle;  color:blue;text-align:center; display: table-cell;'rowspan='5'><i class='fa fa-file-archive-o fa-5x'></i></td>";
             }
             elseif ($ekstensi == 'doc'){
                 echo "<td style='vertical-align:middle;  color:blue;text-align:center; display: table-cell;'rowspan='5'><i class='fa fa-file-word-o fa-5x'></i></td>";
             }
             elseif ($ekstensi == 'pdf'){
                 echo "<td style='vertical-align:middle;  color:blue;text-align:center; display: table-cell;'rowspan='5'><i class='fa fa-file-pdf-o fa-5x'></i></td>
            ";
             }
             elseif ($ekstensi == 'ppt'){
                 echo "<td style='vertical-align:middle;  color:blue;text-align:center; display: table-cell;'rowspan='5'><i class='fa fa-file-powerpoint-o fa-5x'></i></td>";
             }
             elseif ($ekstensi == 'pptx'){
                 echo "<td style='vertical-align:middle;  color:blue;text-align:center; display: table-cell;'rowspan='5'><i class='fa fa-file-powerpoint-o fa-5x'></i></td>";
             }
             elseif ($ekstensi == 'docx'){
                 echo "<td style='vertical-align:middle;  color:blue;text-align:center; display: table-cell;'rowspan='5'><i class='fa fa-file-word-o fa-5x'></i></td>";
             }
             }else{
                 echo "
            <td style='vertical-align:middle;  color:blue;text-align:center; display: table-cell;'rowspan='5'><i class='fa fa-warning fa-5x'></i>
            </td>";
             }
          echo "
          </tbody> 
          <thead>
            <td><center>$pelatihan[materi]</center><td>
          </thead>         

          <thead>
              <tr>
                <th>Hits</th>
              </tr>
          </thead>
          <tbody>
            <td>$pelatihan[hits]</td>
          </tbody>
          <thead class='pull-right'>
              <tr>
                <th><input class='btn btn-danger' type=button value=Kembali onclick=self.history.back()></th>
              </tr>
          </thead> 
          </table>
          </div>
          </div>";
}
  elseif ($_SESSION[leveluser]=='pengajar') {
      $detail=mysqli_query($DBcon,"SELECT * FROM pelatihan WHERE id_pelatihan='$_GET[id_pelatihan]'");
       $pelatihan=mysqli_fetch_array($detail);

       echo "
              <div class=\"panel-body\">
          <div class=\"table-responsive\">
              <table class=\"table table-hover\">
          <thead>
              <tr>
                <th>ID Learning</th>
              </tr>
          </thead>
          <tbody>
            <td>$pelatihan[id_pelatihan]</td>
          </tbody>
          <thead>
              <tr>
                <th>Studi Method</th>
              </tr>
          </thead>
          <tbody>";
          $cari_study = mysqli_query($DBcon,"SELECT * FROM study_method WHERE idstudy_method = '$pelatihan[idstudy_method]'");
            while ($k=mysqli_fetch_array($cari_study)){
            $lama = $pelatihan[lama]/60;
            echo"
            <td>".$k[nama]."</td>";
              }
            echo"
          </tbody>
          <thead>
              <tr>
                <th>TR Katalog</th>
              </tr>
          </thead>
           <tbody>";
          $cari_trk = mysqli_query($DBcon,"SELECT * FROM trkatalog WHERE idtrkatalog = '$pelatihan[idtrkatalog]'");
            while ($k=mysqli_fetch_array($cari_trk)){
            echo"
            <td>".$k[nama]."</td>";
              }
            echo"
          </tbody>

          <thead>
              <tr>
                <th>Reason Code</th>
              </tr>
          </thead> 
          <tbody>";
          $cari_reason = mysqli_query($DBcon,"SELECT * FROM reason_codde WHERE idreason_codde = '$pelatihan[idreason_codde]'");
            while ($k=mysqli_fetch_array($cari_reason)){
            echo"
            <td>".$k[nama]."</td>";
              }
            echo"
          </tbody>

          <thead>
              <tr>
                <th>Prioritas</th>
              </tr>
          </thead>    
          <tbody>";
          $cari_prio = mysqli_query($DBcon,"SELECT * FROM prioritas WHERE idprioritas = '$pelatihan[idprioritas]'");
            while ($k=mysqli_fetch_array($cari_prio)){
            echo"
            <td>".$k[nama]."</td>";
              }
            echo"
          </tbody>

          <thead>
              <tr>
                <th>Nama Learning</th>
              </tr>
          </thead>
          <tbody>
            <td>$pelatihan[nama_pelatihan]</td>
          </tbody>

          <thead>
              <tr>
                <th>Nama Trainer</th>
              </tr>
          </thead>
          <tbody>
            <td>$pelatihan[nama_trainer]</td>
          </tbody>

          <thead>
              <tr>
                <th>Asal Trainer</th>
              </tr>
          </thead>
          <tbody>
            <td>$pelatihan[asal_trainer]</td>
          </tbody>

          <thead>
              <tr>
                <th>Tanggal Pelaksanaan</th>
              </tr>
          </thead>
          <tbody>
            <td>$pelatihan[tanggal_pelaksanaan]</td>
          </tbody>

          <thead>
              <tr>
                <th>Tanggal Selesai</th>
              </tr>
          </thead>
          <tbody>
            <td>$pelatihan[tanggal_selesai]</td>
          </tbody>

          <thead>
              <tr>
                <th>Lama</th>
              </tr>
          </thead>
          <tbody>
            <td>$lama Menit</td>
          </tbody>

          <thead>
              <tr>
                <th>Waktu </th>
              </tr>
          </thead>
          <tbody>
            <td>$pelatihan[waktu] WIB</td>
          </tbody>          

          <thead>
              <tr>
                <th>Tempat</th>
              </tr>
          </thead>
          <tbody>
            <td>$pelatihan[tempat]</td>
          </tbody>

          <thead>
              <tr>
                <th>Materi </th>
              </tr>
          </thead>
          <tbody>";
          $materi=mysqli_query($DBcon,"SELECT * FROM file_materi WHERE id_file = '$pelatihan[materi]'");
            $mi=mysqli_fetch_array($materi);
             if (!empty($mi[nama_file])){
             $pecah = explode(".", $mi[nama_file]);
             $ekstensi = $pecah[1];
             if ($ekstensi == 'zip'){
                 echo "<td style='vertical-align:middle;  color:blue;text-align:center; display: table-cell;'rowspan='5'><i class='fa fa-file-zip-o fa-5x'></td></tbody> 
                    <thead>
                      <td><center>$mi[nama_file]</center><td>
                    </thead>  ";
             }
             elseif ($ekstensi == 'rar'){
                 echo "<td style='vertical-align:middle;  color:blue;text-align:center; display: table-cell;'rowspan='5'><i class='fa fa-file-archive-o fa-5x'></td></tbody> 
                    <thead>
                      <td><center>$mi[nama_file]</center><td>
                    </thead>  ";
             }
             elseif ($ekstensi == 'doc'){
                 echo "<td style='vertical-align:middle;  color:blue;text-align:center; display: table-cell;'rowspan='5'><i class='fa fa-file-word-o fa-5x'></td></tbody> 
                    <thead>
                      <td><center>$mi[nama_file]</center><td>
                    </thead>  ";
             }
             elseif ($ekstensi == 'pdf'){
                 echo "<td style='vertical-align:middle;  color:blue;text-align:center; display: table-cell;'rowspan='5'><i class='fa fa-file-pdf-o fa-5x'></td> </tbody> 
                    <thead>
                      <td><center>$mi[nama_file]</center><td>
                    </thead>       
            ";
             }
             elseif ($ekstensi == 'ppt'){
                 echo "<td style='vertical-align:middle;  color:blue;text-align:center; display: table-cell;'rowspan='5'><i class='fa fa-file-powerpoint-o fa-5x'></td>
                  </tbody> 
                    <thead>
                      <td><center>$mi[nama_file]</center><td>
                    </thead>  ";
             }
             elseif ($ekstensi == 'pptx'){
                 echo "<td style='vertical-align:middle;  color:blue;text-align:center; display: table-cell;'rowspan='5'><i class='fa fa-file-powerpoint-o fa-5x'></td>
                 </tbody> 
                    <thead>
                      <td><center>$mi[nama_file]</center><td>
                    </thead>  ";
             }
             elseif ($ekstensi == 'docx'){
                 echo "<td style='vertical-align:middle;  color:blue;text-align:center; display: table-cell;'rowspan='5'><i class='fa fa-file-word-o fa-5x'></td></tbody> 
                    <thead>
                      <td><center>$mi[nama_file]</center><td>
                    </thead>  ";
             }
             }else{
                 echo "
            <td style='vertical-align:middle;  color:blue;text-align:center; display: table-cell;'rowspan='5'><i class='fa fa-warning fa-5x'>
            </td></tbody> 
                    <thead>
                      <td><center>Kosong</center><td>
                    </thead>  ";
             }
          echo "  

          <thead>
              <tr>
                <th>Hits</th>
              </tr>
          </thead>
          <tbody>
            <td>$pelatihan[hits]</td>
          </tbody>
          <thead class='pull-right'>
              <tr>
                <th><input class='btn btn-danger' type=button value=Kembali onclick=self.history.back()></th>
              </tr>
          </thead> 
          </table>
          </div>
          </div>";
  }
  break;
case "daftarmateri":
    if ($_SESSION[leveluser] == 'users'){
        
        $p      = new Paging;
        $batas  = 5;
        $posisi = $p->cariPosisi($batas);

        $mapel = mysqli_query($DBcon,"SELECT * FROM mata_pelajaran WHERE id_matapelajaran = '$_GET[id]'");
        $data_mapel = mysqli_fetch_array($mapel);
        $materi = mysqli_query($DBcon,"SELECT * FROM file_materi WHERE id_matapelajaran = '$_GET[id]' LIMIT $posisi,$batas ");
        $cek_materi = mysqli_num_rows($materi);
        if (!empty($cek_materi)){
        echo"<br><b class='judul'>Daftar File Materi $data_mapel[nama] </b><br><p class='garisbawah'></p>";
        echo "<table width=\"100%\" class=\"table table-striped table-bordered table-hover\" id=\"dataTables-example\">";
        $no=$posisi+1;
        while ($r=mysqli_fetch_array($materi)){
        echo "<tr><td rowspan='5'>$no</td>";
             if (!empty($r[nama_file])){
             $pecah = explode(".", $r[nama_file]);
             $ekstensi = $pecah[1];
             if ($ekstensi == 'zip'){
                 echo "<td style='vertical-align:middle;  color:blue;text-align:center; display: table-cell;'rowspan='5'><i class='fa fa-file-zip-o fa-5x'></td>";
             }
             elseif ($ekstensi == 'rar'){
                 echo "<td style='vertical-align:middle;  color:blue;text-align:center; display: table-cell;'rowspan='5'><i class='fa fa-file-archive-o fa-5x'></td>";
             }
             elseif ($ekstensi == 'doc'){
                 echo "<td style='vertical-align:middle;  color:blue;text-align:center; display: table-cell;'rowspan='5'><i class='fa fa-file-word-o fa-5x'></td>";
             }
             elseif ($ekstensi == 'pdf'){
                 echo "<td style='vertical-align:middle;  color:blue;text-align:center; display: table-cell;'rowspan='5'><i class='fa fa-file-pdf-o fa-5x'></td>";
             }
             elseif ($ekstensi == 'ppt'){
                 echo "<td style='vertical-align:middle;  color:blue;text-align:center; display: table-cell;'rowspan='5'><i class='fa fa-file-powerpoint-o fa-5x'></td>";
             }
             elseif ($ekstensi == 'pptx'){
                 echo "<td style='vertical-align:middle;  color:blue;text-align:center; display: table-cell;'rowspan='5'><i class='fa fa-file-powerpoint-o fa-5x'></td>";
             }
             elseif ($ekstensi == 'docx'){
                 echo "<td style='vertical-align:middle;  color:blue;text-align:center; display: table-cell;'rowspan='5'><i class='fa fa-file-word-o fa-5x'></td>";
             }
             }else{
                 echo "<td style='vertical-align:middle;  color:blue;text-align:center; display: table-cell;'rowspan='5'><i class='fa fa-warning fa-5x'></td>";
             }
             echo "<td>Judul</td><td>: $r[judul]</td></tr>
             <tr><td>Nama File</td><td>: $r[nama_file]</td></tr>
             <tr><td>Ukuran</td>";
                            if (!empty($r[nama_file])){
                            $file = "files_materi/$r[nama_file]";                            
                            echo "<td>: ". fsize($file)."</td></tr>";
                            }else{
                                echo "<td>: </td></tr>";
                            }
             echo"<tr><td>Tanggal Posting</td><td>: $r[tgl_posting]</td></tr>
             <tr><td colspan=2><input type=button class=\"btn btn-info\" value='Download File'
                       onclick=\"window.location.href='downlot.php?file=$r[nama_file]';\">
                       <b class='judul'>Di download : $r[hits] kali</b></td></tr>";
        $no++;
        }
        echo "</table>";
        $jmldata=mysqli_num_rows(mysqli_query($DBcon,"SELECT * FROM file_materi WHERE id_matapelajaran = '$_GET[id]'"));
        $jmlhalaman  = $p->jumlahHalaman($jmldata, $batas);
        $linkHalaman = $p->navHalaman($_GET[halaman], $jmlhalaman);

        echo "<div id=paging>$linkHalaman</div><br>";

        echo "<p class='garisbawah'></p><input type=button class=\"btn btn-primary\" value='Kembali'
          onclick=self.history.back()>";
    }
    else{
        echo "<script>window.alert('Tidak ada file materi di mata pelajaran ini?');
            window.location=(href='media.php?module=materi')</script>";
    }
    }
    break;

case "tambahpelatihan":
    if ($_SESSION[leveluser]=='admin'){
      echo "Hellow!!";
    }elseif($_SESSION[leveluser]=='pengajar'){
     $get_data = mysqli_query($DBcon,"SELECT * FROM pelatihan" );
 
      // Check
      $check = mysqli_num_rows( $get_data );
       
      if ( empty( $check ) ){ // Jk kode blm ada maka
        $kode = 1; // kode dimulai dr 1
      } else { // jk sudah ada maka
        $kode = $check + 1; // kode sebelumnya ditambah 1.
      }
      if (empty($_POST[idtrkatalog])) {
  echo "<script>window.alert('Anda belum memilih kategori pelatihan');
        window.location=(href='media_admin.php?module=acara')</script>";
      }else{
    echo "<form name='form_pelatihan' method=POST action='$aksi?module=acara&act=input_pelatihan' enctype='multipart/form-data'>
     <div class=\"panel-body\">
            <div class=\"row\">
     <legend>Tambah  Learning</legend>
      <div class=\"form-group\">
        <label>ID Learning</label>
          <input class=\"form-control\" type='text' value='A0".$kode."' name='id_pelatihan' readonly required>
      </div>
      
      <div class=\"form-group\">
        <label>TR Katalog</label> 
        <select class='form-control' name='idtrkatalog' id='idtrkatalog' readonly required>";
            $cari_trkatalog = mysqli_query($DBcon,"SELECT * FROM trkatalog where idtrkatalog='$_POST[idtrkatalog]'");
            while ($k=mysqli_fetch_array($cari_trkatalog)){
            echo"
            <option value='".$k[idtrkatalog]."' selected>".$k[nama]."</option>";
          }
          echo "
          </select>
      </div>
      <div id='idmateri' class='well well-sm' >
      <div class=\"form-group\">
      <p class=\"help-block\">Menampilkan materi berdasarkan TR Katalog.</p>
        <label>Materi</label> 
        <select class='form-control' name='idmateri' required>
            <option>-pilih-</option>";
            $cari_trkatalog = mysqli_query($DBcon,"SELECT * FROM file_materi where kategori='$_POST[idtrkatalog]'");
            while ($k=mysqli_fetch_array($cari_trkatalog)){
            echo"
            <option value='".$k[id_file]."'>".$k[nama_file]."</option>";
          }
      echo "
        </select>

      </div><button class='btn btn-default'><a href='?module=materi'>Buat Materi</a></button>
      </div>
      <div class=\"form-group\">
        <label>Reason Codde</label>
          <select class=\"form-control\" name='idreason_codde' required>
            <option>-pilih-</option>";
            $cari_reason_codde = mysqli_query($DBcon,"SELECT * FROM reason_codde");
            while ($k=mysqli_fetch_array($cari_reason_codde)) {
              echo "
              <option value='".$k[idreason_codde]."'>".$k[nama]."</option>";
            }
            echo "
          </select>
      </div>
      <div class=\"form-group\">
        <label>Prioritas</label>
          <select class=\"form-control\" name='idprioritas' required>
            <option>-pilih-</option>";
            $cari_prioritas = mysqli_query($DBcon,"SELECT * FROM prioritas");
            while ($k=mysqli_fetch_array($cari_prioritas)) {
              echo "
              <option value='".$k[idprioritas]."'>".$k[nama]."</option>";
            }
            echo "
          </select>
      </div>
      <div class=\"form-group\">
        <label>Nama Learning</label>
          <input class=\"form-control\" type='text' name='nama_pelatihan' data-validation='length' data-validation-length='min4'  required>
      </div>
      <div class=\"form-group\">
        <label>Nama Trainer Learning</label>
          <input class=\"form-control\" type='text' name='nama_trainer' data-validation='length' data-validation-length='min4'  required>
      </div>
      <div class=\"form-group\">
        <label>Asal Trainer Learning</label>
          <input class=\"form-control\" type='text' name='asal_trainer' data-validation='length' data-validation-length='min4'  required>
      </div>
      <div class=\"form-group\">
        <label>Tanggal Pelaksanaan Learning</label>
          <input class=\"tanggal form-control\" type='text' name='tanggal_pelaksanaan' required>
      </div>
      <div class=\"form-group\">
        <label>Tanggal Selesai Learning</label>
          <input class=\"tanggal form-control\" type='text' name='tanggal_selesai' required>
      </div>
       <div class=\"form-group\">
        <label>Lama Pengerjaan Post Test</label>
        <div class='form-group input-group'>
          <input class=\"form-control\" type='text' name='lama' data-validation='number' data-validation-allowing='float,negative' required>
          <span class='input-group-addon'>Menit</span>
           </div>
            <p class=\"help-block\">Dalam hitungan menit.</p>
      </div>
      <div class=\"form-group\">
        <label>Waktu Mulai Learning</label>
        <div class='input-group clockpicker'>
              <input type='text' name='waktu' class='form-control'>
              <span class='input-group-addon'>
                  <span class='glyphicon glyphicon-time'></span>
              </span>
          </div>
      </div>
      <div class=\"form-group\">
        <label>Tempat Learning</label>
          <input class=\"form-control\" type='text' data-validation='length' data-validation-length='min4'name='tempat' required>
      </div> 
                            <div class='panel-group' id='accordion'>
                                <div class='panel panel-primary'>
                                    <div class='panel-heading'>
                                        <h4 class='panel-title'>
                                            <a data-toggle='collapse' data-parent='#accordion' href='#collapseOne'>Pilih Tujuan Learning</a>
                                        </h4>
                                    </div>
                                    <div id='collapseOne' class='panel-collapse collapse'>
                                        <div class='panel-body'>
                                            <div id='idmateri' class='well well-sm' ><a href='?module=users'>
<button class='pull-right btn btn-warning '>Tambah Users</button></a>
      <p class=\"help-block\">Menampilkan Users yang ada di dalam database.</p>
        <label>Tujuan Users</label> 
                  <select class='form-control js-example-basic-multiple' multiple='multiple' name='NIK_penerima[]' required>"; 
            $tampil_users=mysqli_query($DBcon,"SELECT * FROM users ORDER BY PosTitle ASC ");
            $grup = array();
                while($p=mysqli_fetch_assoc($tampil_users)){
                $grup[$p[PosTitle].'/'.$p[Unit]][]=$p;
               }foreach($grup  as $key => $values){
                echo "
                <optgroup label='".$key."'>";
                foreach ($values as $value) {
                  echo "
                  <option value='".$value[NIK]."'>".$value[EmployeeName]."</option>";
                }
                 }echo "
                 </optgroup>
            </select>

      </div>
          <div class=\"form-group\">
            <label>Judul Pesan</label>
              <input class=\"form-control\" name='judulpesan' data-validation='length' data-validation-length='min4' required>
              </div>   
          <div class=\"form-group\">
            <label>Isi Pesan</label>
            (<span id='max-len'>20</span> chars left)<br />
              <textarea class=\"form-control\" id='text-area' name='isipesan'>
              </textarea>
          </div>
          <div class='form-group input-group'>
              <span class='input-group-addon'><i class='fa fa-link'></i>
            </span>
            <input type='text' name='link' class='form-control' value='media.php?module=quiz&act=rincianlearning&id_pelatihan=A0".$kode."' readonly>
          </div>
      </div>  
                                        </div>
                                    </div>
                                      </div>
                                    </div>
                                </div>
      
          <p align=center>
          <input class=\"btn btn-danger\" type=button value=Batal onclick=self.history.back()>
          <input class=\"btn btn-primary\" type=submit value=Simpan></p>
          </form></div></div></div>";


}

    }else{
  echo "Hello!!!";
}
    break;

case "editpelatihan":
    if ($_SESSION[leveluser]=='admin'){

    $edit=mysqli_query($DBcon,"SELECT * FROM pelatihan WHERE id_pelatihan = '$_GET[id_pelatihan]'");
    $m=mysqli_fetch_array($edit);

    echo "
    <form name='form_pelatihan' method=POST action='$aksi?module=acara&act=edit_pelatihan' enctype='multipart/form-data'>
    <div class=\"panel-body\">
            <div class=\"row\">
            <div class=\"col-lg-6\">
     <legend>Edit Materi Learning</legend>
    <input type=hidden name='id_pelatihan' value='$m[id_pelatihan]'>
          <div class=\"form-group\">
            <label>Study Method</label>
              <input class=\"form-control\" type='text' value='$m[study_method]' name='study_method' required>
          </div>
          <div class=\"form-group\">
        <label>TR Katalog</label>
        <select class='form-control' name='tr_katalog' required >";
              $pilih="SELECT * FROM trkatalog";
              $query=mysqli_query($DBcon,$pilih);
              while($row=mysqli_fetch_array($query)){
              echo"<option value='".$row[idtrkatalog]."'>".$row[nama]."</option>";
              }
              echo"</select>
      </div>
      <div class=\"form-group\">
        <label>Reason Codde</label>
          <input class=\"form-control\" type='text' name='reason_codde' value='$m[reason_codde]' required>
      </div>
      <div class=\"form-group\">
        <label>Prioritas</label>
          <input class=\"form-control\" type='text' name='prioritas' value='$m[prioritas]' required>
      </div>
      <div class=\"form-group\">
        <label>Nama Learning</label>
          <input class=\"form-control\" type='text' name='nama_pelatihan' value='$m[nama_pelatihan]' required>
      </div>
      <div class=\"form-group\">
        <label>Nama Trainer Learning</label>
          <input class=\"form-control\" type='text' name='nama_trainer' value='$m[nama_trainer]' required>
      </div>
      <div class=\"form-group\">
        <label>Asal Trainer Learning</label>
          <input class=\"form-control\" type='text' name='asal_trainer' value='$m[asal_trainer]' required>
      </div>
      <div class=\"form-group\">
        <label>Tanggal Pelaksanaan Learning</label>
          <input class=\"form-control\" type='date' name='tanggal_pelaksanaan' value='$m[tanggal_pelaksanaan]' required>
      </div>
      <div class=\"form-group\">
        <label>Tanggal Selesai Learning</label>
          <input class=\"form-control\" type='date' name='tanggal_selesai' value='$m[tanggal_selesai]' required>
      </div>
      <div class=\"form-group\">
        <label>Lama Pengerjaan Post Test</label>
          <input class=\"form-control\" type='text' name='lama' data-validation='number' data-validation-allowing='float,negative'  value='$m[lama]' required>
          <p class=\"help-block\">Dalam hitungan menit</p>
      </div>
      <div class=\"form-group\">
        <label>Waktu Mulai Learning</label>
          <input class=\"form-control\" type='time' name='waktu' value='$m[waktu]' required>
      </div>
      <div class=\"form-group\">
        <label>Tempat Learning</label>
          <input class=\"form-control\" data-validation='length' data-validation-length='min4' type='text' name='tempat' value='$m[tempat]' required>
      </div> 

      <div class=\"form-group\">
        <label>File Sekarang</label>
          <p>$m[materi]</p>
      </div> 
          <p align=center>
          <input class=\"btn btn-danger\" type=button value=Batal onclick=self.history.back()>
          <input class=\"btn btn-primary\" type=submit value=Update></p>

          </fieldset></form></div></div></div>";
    }elseif ($_SESSION[leveluser]=='pengajar') {
    $edit=mysqli_query($DBcon,"SELECT * FROM pelatihan WHERE id_pelatihan = '$_GET[id_pelatihan]'");
    $m=mysqli_fetch_array($edit);
    //study method
    $get_sm = mysqli_query($DBcon,"SELECT * FROM study_method WHERE idstudy_method = '$m[idstudy_method]'");
    $sm = mysqli_fetch_array($get_sm);
    //reason code
    $get_rc = mysqli_query($DBcon,"SELECT * FROM reason_codde WHERE idreason_codde = '$m[idreason_codde]'");
    $rc = mysqli_fetch_array($get_rc);
    //prioritas
    $get_pri = mysqli_query($DBcon,"SELECT * FROM prioritas WHERE idprioritas = '$m[idprioritas]'");
    $pri = mysqli_fetch_array($get_pri);
    //prioritas
    $get_trk = mysqli_query($DBcon,"SELECT * FROM trkatalog WHERE idtrkatalog = '$m[idtrkatalog]'");
    $trk = mysqli_fetch_array($get_trk);

    $lama = $m[lama]/60;

    echo "
    <form name='form_pelatihan' method=POST action='$aksi?module=acara&act=edit_pelatihan' enctype='multipart/form-data'>
    <div class=\"panel-body\">
            <div class=\"row\">
     <legend>Edit Materi</legend>
    <input type=hidden name='id_pelatihan' value='$m[id_pelatihan]'>
          
          <div class=\"form-group\">
        <label>TR Katalog</label>
        <select class='form-control' name='idtrkatalog' required >
              <option value=$trk[idtrkatalog] selected>$trk[nama]</option>";
              $pilih="SELECT * FROM trkatalog";
              $query=mysqli_query($DBcon,$pilih);
              while($row=mysqli_fetch_array($query)){
              echo"
              <option value='".$row[idtrkatalog]."'>".$row[nama]."</option>";
              }
              echo"
        </select>
      </div>
      <div class=\"form-group\">
        <label>Reason Codde</label>
          <select class='form-control' name='idreason_codde' required >
              <option value=$rc[idreason_codde] selected>$rc[nama]</option>";
              $pilih="SELECT * FROM reason_codde";
              $query=mysqli_query($DBcon,$pilih);
              while($row=mysqli_fetch_array($query)){
              echo"
              <option value='".$row[idreason_codde]."'>".$row[nama]."</option>";
              }
              echo"
            </select>
      </div>
      <div class=\"form-group\">
        <label>Prioritas</label>
          <select class='form-control' name='idprioritas' required >
              <option value=$pri[idprioritas] selected>$pri[nama]</option>";
              $pilih="SELECT * FROM prioritas";
              $query=mysqli_query($DBcon,$pilih);
              while($row=mysqli_fetch_array($query)){
              echo"
              <option value='".$row[idprioritas]."'>".$row[nama]."</option>";
              }
              echo"
            </select>
      </div>
      <div class=\"form-group\">
        <label>Nama Learning</label>
          <input class=\"form-control\" type='text' name='nama_pelatihan' data-validation='length' data-validation-length='min4' value='$m[nama_pelatihan]' required>
      </div>
      <div class=\"form-group\">
        <label>Nama Trainer Learning</label>
          <input class=\"form-control\" type='text' name='nama_trainer' data-validation='length' data-validation-length='min4' value='$m[nama_trainer]' required>
      </div>
      <div class=\"form-group\">
        <label>Asal Trainer Learning</label>
          <input class=\"form-control\" type='text' name='asal_trainer' data-validation='length' data-validation-length='min4' value='$m[asal_trainer]' required>
      </div>
      <div class=\"form-group\">
        <label>Tanggal Pelaksanaan Learning</label>
          <input class=\"tanggal form-control\" type='text' name='tanggal_pelaksanaan' value='".konversi_tanggal($m[tanggal_pelaksanaan])."' required>
      </div>
      <div class=\"form-group\">
        <label>Tanggal Selesai Learning</label>
          <input class=\"tanggal form-control\" type='text' name='tanggal_selesai' value='".konversi_tanggal($m[tanggal_selesai])."' required>
      </div>
      <div class=\"form-group\">
        <label>Lama Pengerjaan Post Test</label>
          <input class=\"form-control\" type='text' name='lama' value='$lama' data-validation='number' data-validation-allowing='float,negative'  required>
          <p class=\"help-block\">Dalam hitungan menit</p>
      </div>
      <div class=\"form-group\">
        <label>Waktu Mulai Learning</label>
        <div class='input-group clockpicker'>
              <input type='text' class='form-control' value='$m[waktu]' name='waktu' required>
              <span class='input-group-addon'>
                  <span class='glyphicon glyphicon-time'></span>
              </span>
          </div>
      </div>
      <div class=\"form-group\">
        <label>Tempat Learning</label>
          <input class=\"form-control\" type='text' data-validation='length' data-validation-length='min4' name='tempat' value='$m[tempat]' required>
      </div>
      <div class='well well-sm'>       
      <div class=\"form-group\">
        <label>File Sekarang</label>
          ";
          $cari = mysqli_query($DBcon,"SELECT * FROM file_materi WHERE id_file='$m[materi]'");
          $m=mysqli_fetch_array($cari);
                      if (!empty($m[nama_file])){
             $pecah = explode(".", $m[nama_file]);
             $ekstensi = $pecah[1];
             if ($ekstensi == 'zip'){
                 echo "
                 <p class=\"form-control-static text-center\"><br>
                 <i class='fa fa-file-zip-o fa-2x'>$m[nama_file]</i></p>";
             }
             elseif ($ekstensi == 'rar'){
                 echo "
                 <p class=\"form-control-static text-center\">
                 <i class='fa fa-file-archive-o fa-2x'></br>$m[nama_file]</i></p>";
             }
             elseif ($ekstensi == 'doc'){
                 echo "
                 <p class=\"form-control-static text-center\">
                 <i class='fa fa-file-word-o fa-2x'></br>$m[nama_file]</p></i>";
             }
             elseif ($ekstensi == 'pdf'){
                 echo "
                 <p class=\"form-control-static text-center\">
                    <i class='fa fa-file-pdf-o fa-2x'><br>$m[nama_file]</i>
                 </p>";
             }
             elseif ($ekstensi == 'ppt'){
                 echo "
                 <p class=\"form-control-static text-center\">
                 <i class='fa fa-file-powerpoint-o fa-2x'></br>
                 $m[nama_file]</i></p>";
             }
             elseif ($ekstensi == 'pptx'){
                 echo "
                 <p class=\"form-control-static text-center\">
                 <i class='fa fa-file-powerpoint-o fa-2x'></br>
                 $m[nama_file]</i></p>";
             }
             elseif ($ekstensi == 'docx'){
                 echo "
                 <p class=\"form-control-static text-center\">
                 <i class='fa fa-file-word-o fa-2x'></br>$m[nama_file]</i></p>";
             }
             }else{
                 echo "
                 <p class=\"form-control-static text-center\">
                 <i class='fa fa-warning fa-2x'></br>$m[nama_file]</i></p>";
             }       
             echo " </div>
      <div id='idmateri' class='well well-sm' >
      <div class=\"form-group\">
      <p class=\"help-block\">Menampilkan materi berdasarkan TR Katalog.</p>
        <label>Materi</label> 

        <select class='form-control' name='idmateri' required>";
            $cari_trkatalog = mysqli_query($DBcon,"SELECT * FROM file_materi WHERE kategori='$m[kategori]'");
            while ($k=mysqli_fetch_array($cari_trkatalog)){
            echo"
            <option value='".$k[id_file]."'>".$k[nama_file]."</option>";
          }
      echo "
        </select>

      </div>
      </div></div>";
      $pesan=mysqli_query($DBcon,"SELECT * FROM `pesan` WHERE `link` LIKE '%$m[id_pelatihan]%'");
        $m=mysqli_fetch_array($pesan);
          $pecah = explode(".", $r[nama_file]);
          $ekstensi = $pecah[1];
          $hasilpilih .= $m[NIK_penerima] . ",";
          $hasilpilih = substr($hasilpilih,0,-1);

          $tampil_users=mysqli_query($DBcon,"SELECT * FROM users WHERE find_in_set(NIK,'$hasilpilih') ORDER BY PosTitle ASC ");
          echo "                      
                            <div class='panel-group' id='accordion'>
                                <div class='panel panel-default'>
                                    <div class='panel-heading'>
                                        <h4 class='panel-title'>
                                            <a data-toggle='collapse' data-parent='#accordion' href='#collapseOne'>Daftar Nama Tujuan Pesan</a>
                                        </h4>
                                    </div>
                                    <div id='collapseOne' class='panel-collapse collapse'>
                                        <div class='panel-body'>
                                                    <table id='dataTables-example' class='table'>
            <thead>
              <th>No</th>
              <th>Nama Lengkap</th>
              <th>Jabatan</th>
              <th>Unit</th>
              </thead>
              <tbody>";
                  $no = 1;
                while($q=mysqli_fetch_array($tampil_users)){
                  echo "
                <tr>
                  <td>".$no."</td>";
                  echo "
                  <td>".$q[EmployeeName]."</td>";
                  echo "
                  <td>".$q[PosTitle]."</td>";
                  echo "
                  <td>".$q[Unit]."</td>
                </tr>";
$no++;
                 }

           echo "
              </tbody>
          </table>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.col-lg-4 -->
          <input type=hidden name=idpesan value='$m[idpesan]'>
                <div class='col-mg-12'>
                    <div class='panel panel-primary'>
                        <div class='panel-heading'>
                            Form Ubah Pesan
                        </div>
                        <div class='panel-body'>
                                 <div class=\"form-group\">
          <label>Kepada</label>
            <select class='form-control js-example-basic-multiple' multiple='multiple' name='NIK_penerima[]'>"; 
            //$olah .= $m[NIK_penerima] . ",";
            //$hasilpilih = substr($olah,0,-1);
            
           //$tampil_users=mysqli_query($DBcon,"SELECT * FROM users WHERE find_in_set(NIK,'$hasilpilih') ORDER BY PosTitle ASC ");

    
           //Untuk Users Terpilih
            if ($m[NIK_penerima] )
        $hasilpilih .= $m[NIK_penerima] . ",";
          $hasilpilih = substr($hasilpilih,0,-1);

          $tampil_users=mysqli_query($DBcon,"SELECT * FROM users WHERE find_in_set(NIK,'$hasilpilih') ORDER BY PosTitle ASC ");

          $tampil=mysqli_query($DBcon,"SELECT * FROM users ORDER BY PosTitle ASC ");
  
                $grup = array();
                while($p=mysqli_fetch_array($tampil)){
                $grup[$p[PosTitle].'/'.$p[Unit]][]=$p;
               }foreach($grup  as $key => $values){
                echo "
                <optgroup label='".$key."'>";
                foreach ($values as $value) {
                  echo "
                  <option value='".$value[NIK]."'>".$value[EmployeeName]."</option>";
                }echo "
                </optgroup>";
                 }
            
                $grup = array();
                while($p=mysqli_fetch_array($tampil_users)){
                $grup[$p[PosTitle].'/'.$p[Unit]][]=$p;
               }foreach($grup  as $key => $values){
                echo "
                <optgroup label='".$key."'>";
                foreach ($values as $value) {
                  echo "
                  <option value='".$value[NIK]."' selected>".$value[EmployeeName]."</option>";
                
                 }echo "
                </optgroup>";

            }
       echo "</select>
              </div>
          <div class=\"form-group\">
            <label>Judul Pesan</label>
              <input class=\"form-control\" name='judulpesan' value='$m[judul]' required>
              </div>          
          <div class=\"form-group\">
            <label>Waktu Pengiriman</label>
              <input class=\"form-control\" value='".indonesian_date()."' name='waktup' required readonly>
              </div>";
              if ($m[perintah]=='Ya'){
             echo "
              <div class=\"form-group\">
                <label>Perintah </label>
              <div class='radio'>
              <label>
              <input type='radio' name='perintah' value='Ya' checked>Ya
              </label>
              </div>
              <div class='radio'>              
              <label>
              <input type='radio' name='perintah' value='Tidak'>Tidak
              </label>
              </div>
              <code>Perintah bertujuan untuk memberitahukan users agar melakukan tindakan yang sudah diperintahkan di dalam pesan.</code>
            <br> ";
          }else{
              echo "<div class=\"form-group\">
                <label>Perintah  </label>
              <div class='radio'>
              <label>
              <input type='radio' name='perintah' value='Ya' >Ya
              </label>
              </div>
              <div class='radio'>              
              <label>
              <input type='radio' name=perintah'' value='Tidak' checked>Tidak
              </label></div> <code>Perintah bertujuan untuk memberitahukan users agar melakukan tindakan yang sudah diperintahkan di dalam pesan.</code>
            <br> ";
          }      
            echo "
          <div class=\"form-group\">
            <label>Isi Pesan</label>
              <textarea name='isipesan'>$m[isipesan]</textarea>
          </div>
          </form>
          </div>
                        </div>
                    </div>
                </div>
                <div class='form-group'>
          <div class='text-center'>
          <input class=\"btn btn-danger\" type=button value=Batal onclick=self.history.back()>
          <input class=\"btn btn-primary\" type=submit value=Update>
          </div>
          </div>
          </fieldset></form></div></div></div>";
    }
    else{
    $edit=mysqli_query($DBcon,"SELECT * FROM file_materi WHERE id_file = '$_GET[id]'");
    $m=mysqli_fetch_array($edit);
    echo "<form name='form_materi_pengajar' method=POST action='$aksi?module=materi&act=edit_materi' enctype='multipart/form-data'>
    <input type=hidden name=id value='$m[id_file]'>
    <div class=\"panel-body\">
            <div class=\"row\">
            <div class=\"col-lg-6\">
    <legend>Edit Materi</legend>
    <div class=\"form-group\">
      <label>Judul</label>
        <input class=\"form-control\" type='text' value='$m[judul]' name='judul'>
          <p class=\"help-block\">Example block-level help text here.</p>
    </div>
    <div class=\"form-group\">
      <label>Kelas</label>
        <select class='form-control' name='id_kelas' onChange='showpel_pengajar()'>
            <option value='".$k[id_kelas]."' selected>".$k[nama]."</option>";
              $pilih="SELECT * FROM kelas WHERE id_pengajar = '$_SESSION[idpengajar]'";
              $query=mysqli_query($DBcon,$pilih);
              while($row=mysqli_fetch_array($query)){
              echo"<option value='".$row[id_kelas]."'>".$row[nama]."</option>";
              }
              echo"</select>
              <p class=\"help-block\">Example block-level help text here.</p></div>
    <div class=\"form-group\">
      <label>Pelajaran</label>
    <select class='form-control' id='pelajaran_pengajar' name='id_matapelajaran'>
      <option value='".$p[id_matapelajaran]."' selected>".$p[nama]."</option>
    </select>
    </div>

          <p align=center>
          <input class=\"btn btn-danger\" type=button value=Batal onclick=self.history.back()>
          <input class=\"btn btn-primary\" type=submit value=Update></p>

          </fieldset></form></div></div></div>";
    }
    break;

}

}
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
