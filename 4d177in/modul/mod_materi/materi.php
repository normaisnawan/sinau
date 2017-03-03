<h1 class="page-header">Pustaka</h1>
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        

<script>
function confirmdelete(delUrl) {
if (confirm("Anda yakin ingin menghapus?")) {
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
?>

<?php
session_start();
 if (empty($_SESSION['username']) AND empty($_SESSION['passuser'])){
  echo "<link href=../css/style.css rel=stylesheet type=text/css>";
  echo "<div class='error msg'>Untuk mengakses Modul anda harus login.</div>";
}
else{



$aksi="modul/mod_materi/aksi_materi.php";
switch($_GET[act]){
  // Tampil kelas
  default:
    if ($_SESSION[leveluser]=='admin'){
      echo "Admin";
    }
   
  elseif ($_SESSION[leveluser]=='pengajar'){        

    $cek_materi = mysqli_query($DBcon,"SELECT * FROM `file_materi` ORDER BY `file_materi`.`tgl_posting` DESC");
    
     echo "<div class='panel-heading'>
                            <h4>Daftar Materi</h4>
                        </div>
                        <!-- /.panel-heading -->
                        <div class='panel-body'>
        <a class=\"btn btn-primary \" href='?module=materi&act=tambahmateri';>
            <i class=\"fa fa-plus\"></i> Tambah Materi
        </a>
        <div class='pull-right'>
        <a class=\"btn btn-success \" href='?module=materi&act=carimateri';>
            <i class=\"fa fa-search\"></i> Pencarian Materi
        </a>
        </div>
        <hr>";
        echo "<table width=\"100%\" class=\"table table-striped table-bordered table-hover\" id=\"dataTables-example\">
            <thead>
          <tr><th>No</th><th>Judul</th><th>Nama File</th><th>Kategori</th><th>Tgl Posting</th><th>Pembuat</th><th>Hits</th><th>Aksi</th></tr></thead>";
       $no=1;
    while ($r=mysqli_fetch_array($cek_materi)){
      $tgl_posting   = tgl_indo($r[tgl_posting]);
       echo "<tr><td>$no</td>
             <td>$r[judul]</td>
             <td>$r[nama_file]</td>";     
             $pilih="SELECT * FROM trkatalog WHERE idtrkatalog = '$r[kategori]'";
              $query=mysqli_query($DBcon,$pilih);
              while($row=mysqli_fetch_array($query)){
              echo"<td>$row[nama]</td>";
              }
              echo"
             <td>$tgl_posting</td>
            <td>$r[pembuat]</td>
            <td>$r[hits]</td>
             <td>
              <ol>
                <li><a href='?module=materi&act=editmateri&id=$r[id_file]' title='Edit'><i class='fa fa-edit'></i></a>
                </li>
                <li>
                 <a href=javascript:confirmdelete('$aksi?module=materi&act=hapus&id=$r[id_file]') title='Hapus'><i class='fa fa-trash'></i></a>
                </li>
                <li>
                 <a href='../assets/vendor/ViewerJS/#../files_materi/Audit.pdf' title='Lihat'><i class='fa fa-search-plus'></i></a>
                </li>
              </ol>
            </td>
          </tr>";
      $no++;
    }
    echo "</table>";
    
    }
    
    else{

     $mapel = mysqli_query($DBcon,"SELECT * FROM trkatalog");
     echo "<div class='panel-heading'>
                            <h4>Daftar Materi</h4>
        <a class=\"btn btn-success \" href='?module=materi&act=carimateri';>
            <i class=\"fa fa-search\"></i> Pencarian Materi
        </a>
                        </div>
                        <!-- /.panel-heading -->
                        <div class='panel-body'>";

       echo "<table width=\"100%\" class=\"table table-striped table-bordered table-hover\" id=\"dataTables-example\"><thead>
          <tr><th>No</th><th>Kategori Materi</th><th>Materi</th></tr></thead>";
        $no=1;
        while ($r=mysqli_fetch_array($mapel)){
        echo "<tr><td>$no</td>
             <td>$r[nama]</td>";
             echo "<td><input type=button class=\"btn btn-default\" value='Lihat File Materi'
                       onclick=\"window.location.href='?module=materi&act=daftarmateri&id=$r[idtrkatalog]';\"></td></tr>";
        $no++;
        }
        echo "</table>";
    }
    break;


case "daftarmateri":
    if ($_SESSION[leveluser] == 'users'){
        $trkatalog = mysqli_query($DBcon,"SELECT * FROM trkatalog WHERE idtrkatalog = '$_GET[id]'");
        $data_mapel = mysqli_fetch_array($trkatalog);
        $materi = mysqli_query($DBcon,"SELECT * FROM file_materi WHERE kategori = '$_GET[id]' ");
        $cek_materi = mysqli_num_rows($materi);

        if (!empty($cek_materi)){
        echo "<div class='panel-heading'>
                            <h4>Hasil Pencarian ".$cari."</h4>
                        </div>
                        <!-- /.panel-heading -->
                        <div class='panel-body'>";
        echo "<table width=\"100%\" class=\"table table-striped table-bordered table-hover\" id=\"dataTables-example\">
        <thead>
          <th>No</th>
          <th >Judul</th>
          <th>Jenis File</th>
          <th>Ukuran</th>
          <th>Tanggal Posting</th>
          <th>Hits</th>
          <th>Unduh</th>
        </thead>";
        $no=$posisi+1;
        while ($r=mysqli_fetch_array($materi)){
        echo "
        <tr>
          <td>$no</td>
          <td style='max-width:100px'><span class='more'>$r[nama_file]</span></td>";
             if (!empty($r[nama_file])){
             $pecah = explode(".", $r[nama_file]);
             $ekstensi = $pecah[1];
             if ($ekstensi == 'pdf'){
                 echo "<td><i class='fa fa-file-pdf-o  fa-2x'></td>";
             }
             }else{
                 echo "<td><i class='fa fa-warning fa-2x '></i></td>";
             }
             
              if (!empty($r[nama_file])){
              $file = "files_materi/$r[nama_file]";
              echo "
              <td>". fsize($file)."</td>";
                }else{
                echo "
              <td></td>";
            }
             echo"
             <td>$r[tgl_posting]</td>
             <td> $r[hits]</td>
             <td>
             <!-- Trigger the modal with a button -->
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
                          <object class='embed-responsive-item' data='files_materi/$r[nama_file]' type='application/pdf' width='100%' height='100%'>
                          </object>
                      </div>
                    </div>
                    
                  </div>

                </div>
              </div>
             <input type=button class=\"btn btn-info\" value='Download File'
              onclick=\"window.location.href='downlot.php?file=$r[nama_file]&id_materi=$r[id_file]&id_users=$_SESSION[NIK]'\">
            </td>
          </tr>";


          echo '<script>
                  $(document).ready(function() {
                      $("#btnCart").click(function(){  
                  }
                </script>';
        $no++;
        }
        echo "</table>";

        echo "<p class='garisbawah'></p><input type=button class=\"btn btn-primary\" value='Kembali'
          onclick=self.history.back()>";
    }
    else{
        echo "<script>window.alert('Tidak ada file materi.');
            window.location=(href='media.php?module=materi')</script>";
    }
    }
    break;

case "tambahmateri":
    if (($_SESSION[leveluser]=='admin') OR ($_SESSION[leveluser]=='pengejar') ){
    echo "
    <div class='panel-heading'>
                            <h4>Tambah Materi</h4>
                        </div>
                        <!-- /.panel-heading -->
                        <div class='panel-body'>
    <form name='form_materi' method=POST action='$aksi?module=materi&act=input_materi' enctype='multipart/form-data'>
            <div class=\"row\">
            <div class=\"col-lg-6\">
      <div class=\"form-group\">
        <label>Judul</label>
          <input class=\"form-control\" type='text' name='judul' required>
      </div>
      <div class=\"form-group\">
        <label>Kategori</label>
        <select class='form-control' name='kategori' required>
          <option value=''>-pilih-</option>";                            
           $cari_trkatalog = mysqli_query($DBcon,"SELECT * FROM trkatalog ORDER BY nama");
              while ($k=mysqli_fetch_array($cari_trkatalog)){
              echo"<option value='".$k[idtrkatalog]."'>".$k[nama]."</option>";
              }              
              echo"</select>
            <p class=\"help-block\">Kategori Berdasarkan TR Katalog</p>
              </div>
      <div class=\"form-group\">
        <label>File</label>
          <input class='form-control' type=file name='fupload' size=40 required>
            <p class=\"help-block\">File dapat berupa dokumen atau berekstensi ZIP dan RAR</p>
      </div>
          
          <p align=center>
          <input class=\"btn btn-danger\" type=button value=Batal onclick=self.history.back()>
          <input class=\"btn btn-primary\" type=submit value=Simpan></p>
          </form></div></div></div>";
    }else{
    echo "
    <div class='panel-heading'>
                            <h4>Tambah Materi</h4>
                        </div>
                        <!-- /.panel-heading -->
                        <div class='panel-body'>
    <form name='form_materi_pengajar' method=POST action='$aksi?module=materi&act=input_materi' enctype='multipart/form-data'>
            <div class=\"row\">
            <div class=\"col-lg-6\">
    
      <div class=\"form-group\">
        <label>Judul</label>
          <input class=\"form-control\" type='text' name='judul' required>
      </div>
      <div class=\"form-group\">
        <label>Kategori</label>
        <select class='form-control' name='kategori' required>
          <option value=''>-pilih-</option>";                            
           $cari_trkatalog = mysqli_query($DBcon,"SELECT * FROM trkatalog ORDER BY nama");
              while ($k=mysqli_fetch_array($cari_trkatalog)){
              echo"<option value='".$k[idtrkatalog]."'>".$k[nama]."</option>";
              }              
              echo"</select>
            <p class=\"help-block\">Kategori Berdasarkan TR Katalog</p>
              </div>
      <div class=\"form-group\">
        <label>File</label>
          <input class='form-control' type=file name='fupload' size=40 required>
            <p class=\"help-block\">File dapat berupa dokumen atau berekstensi ZIP dan RAR</p>
      </div>
          
          <p align=center>
          <input class=\"btn btn-danger\" type=button value=Batal onclick=self.history.back()>
          <input class=\"btn btn-primary\" type=submit value=Simpan></p>
          </form></div></div></div>";
    }
    break;

case "editmateri":
    if ($_SESSION[leveluser]=='admin'){
      echo "Hello!!!";
    }
    else{
    $edit=mysqli_query($DBcon,"SELECT * FROM file_materi WHERE id_file = '$_GET[id]'");
    $m=mysqli_fetch_array($edit);
    $isikelas = mysqli_query($DBcon,"SELECT * FROM trkatalog WHERE idtrkatalog = '$m[kategori]'");
    $k=mysqli_fetch_array($isikelas);
    $pelajaran = mysqli_query($DBcon,"SELECT * FROM trkatalog WHERE idtrkatalog = '$m[idtrkatalog]'");
    $p=mysqli_fetch_array($pelajaran);

    echo "<form name='form_materi_pengajar' method=POST action='$aksi?module=materi&act=edit_materi' enctype='multipart/form-data'>
    <input type=hidden name=id value='$m[id_file]'>
    <div class=\"panel-body\">
            <div class=\"row\">
            <div class=\"col-lg-6\">
     <legend>Edit Materi</legend>
          <div class=\"form-group\">
            <label>Judul</label>
              <input class=\"form-control\" type='text' value='$m[judul]' name='judul'required> 
                <p class=\"help-block\">Judul Materi Yang Diubah.</p>
              </div>
          <div class=\"form-group\">
            <label>Kategori</label>
              <select class='form-control' name='kategori' required>
            <option value='".$k[idtrkatalog]."' selected>".$k[nama]."</option>";
            $pilih="SELECT * FROM trkatalog ORDER BY nama";
            $query=mysqli_query($DBcon,$pilih);
            while($row=mysqli_fetch_array($query)){
            echo"<option value='".$row[idtrkatalog]."'>".$row[nama]."</option>";
            }
            echo"
              </select>
                <p class=\"help-block\">Kategori Berdasarkan TR Katalog.</p></div>
          <div class=\"form-group\">
            <label>File</label>
          <p class=\"form-control-static\">$m[nama_file]</p>
          <label>Ganti File</label>
          <input class='form-control' type=file name='fupload' size=40>
          <small>Apabila file tidak diganti, di kosongkan saja</small>
          </div>
          <p align=center>
          <input class=\"btn btn-danger\" type=button value=Batal onclick=self.history.back()>
          <input class=\"btn btn-primary\" type=submit value=Update></p>

          </fieldset></form></div></div></div>";
    }
    break;

case "carimateri":
  if(!isset($_POST['cari'])) {
      echo '<div class="panel-heading">
                            <h4>Cari Materi</h4>
          </div>
              <div class="panel-body">
                  <form role="form" method="post" action>
                  <div class="col-md-3">
                  <div class="form-group">
                     <input class="form-control" placeholder="Masukkan Kata Kunci" name="cari" autofocus>
                  </div>
                    <input type="submit" class="btn btn-primary" value="C a r i">
                  </div>
              </div>
          </div>';
  } else {
    $cari = $_POST['cari'];
    $query=mysqli_query($DBcon,"SELECT * FROM file_materi WHERE judul LIKE '%$cari%' ");
        echo "<div class='panel-heading'>
                            <h4>Hasil Pencarian ".$cari."</h4>
                        </div>
                        <!-- /.panel-heading -->
                        <div class='panel-body'>";

        echo "<table width=\"100%\" class=\"table table-striped table-bordered table-hover\" id=\"dataTables-example\">
        <thead>
          <th>No</th>
          <th>Judul</th>
          <th>Jenis File</th>
          <th>Ukuran</th>
          <th>Tanggal Posting</th>
          <th>Hits</th>
          <th>Unduh</th>
        </thead>";
        $no=$posisi+1;
        while ($r=mysqli_fetch_array($query)){
        echo "
        <tr>
          <td>$no</td>
          <td style='max-width:100px'><span class='more'>$r[nama_file]</span></td>";
             if (!empty($r[nama_file])){
             $pecah = explode(".", $r[nama_file]);
             $ekstensi = $pecah[1];
             if ($ekstensi == 'pdf'){
                 echo "<td><i class='fa fa-file-pdf-o  fa-2x'></td>";
             }
             }else{
                 echo "<td><i class='fa fa-warning fa-2x '></i></td>";
             }
             
              if (!empty($r[nama_file])){
              $file = "files_materi/$r[nama_file]";
              echo "
              <td>". fsize($file)."</td>";
                }else{
                echo "
              <td></td>";
            }
             echo"
             <td>$r[tgl_posting]</td>
             <td> $r[hits]</td>
             <td>
             <!-- Trigger the modal with a button -->
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
                          <object class='embed-responsive-item' data='files_materi/$r[nama_file]' type='application/pdf' width='100%' height='100%'>
                          </object>
                      </div>
                    </div>
                    
                  </div>

                </div>
              </div>
             <input type=button class=\"btn btn-info\" value='Download File'
              onclick=\"window.location.href='downlot.php?file=$r[nama_file]&id_materi=$r[id_file]&id_users=$_SESSION[NIK]'\">
            </td>
          </tr>";
        $no++;
        }
        echo "</table>";

        echo "<p class='garisbawah'></p><input type=button class=\"btn btn-primary\" value='Kembali'
          onclick=self.history.back()>";
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