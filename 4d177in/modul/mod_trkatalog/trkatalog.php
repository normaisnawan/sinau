            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Manajemen TR Katalog
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body"><script>
function confirmdelete(delUrl) {
if (confirm("Anda yakin ingin menghapus?")) {
document.location = delUrl;
}
}
</script>
<?php
session_start();
 if (empty($_SESSION['username']) AND empty($_SESSION['passuser'])){
  echo "<link href=../css/style.css rel=stylesheet type=text/css>";
  echo "<div class='error msg'>Untuk mengakses Modul anda harus login.</div>";
}
else{

$aksi="modul/mod_trkatalog/aksi_trkatalog.php";
switch($_GET[act]){
// Tampil Kategori
  default:
    if ($_SESSION[leveluser]=='admin'){
      $tampil_trkatalog = mysqli_query($DBcon, "SELECT * FROM trkatalog ORDER BY id");
      echo "<h2>Manajemen TR Katalog</h2><hr>
          <input class=\"btn btn-default pull-right\" type=button value='Tambah TR Katalog' onclick=\"window.location.href='?module=trkatalog&act=tambahtrkatalog';\">";
          echo "<br><br><table width=\"100%\" class=\"table table-striped table-bordered table-hover\" id=\"dataTables-example\">
            <thead>
          <tr><th>No</th><th>Id TR Katalog</th><th>Nama</th><th>Deskripsi</th><th>Aksi</th></tr></thead>";
    $no=1;
    while ($r=mysqli_fetch_array($tampil_trkatalog)){
       echo "<tr><td>$no</td>
             <td>$r[idtrkatalog]</td>
             <td>$r[nama]</td>
             <td>$r[deskripsi]</td>
             <td><a href='?module=trkatalog&act=edittrkatalog&id=$r[id]' title='Edit'><i class='fa fa-edit'></i></a> |
                 <a href=javascript:confirmdelete('$aksi?module=trkatalog&act=hapus&id=$r[id]') title='Hapus'><i class='fa fa-trash'></i></a></td></tr>";
      $no++;
    }
    echo "</table>";
    }
    elseif ($_SESSION[leveluser]=='pengajar'){
     //Kategori

    $tampil_trkatalog = mysqli_query($DBcon, "SELECT * FROM trkatalog ORDER BY id");
  $cek_trkatalog = mysqli_num_rows($tampil_trkatalog);
  if (!empty($cek_trkatalog)){
    echo"
    <input type=button class='btn btn-primary' value='Tambah' onclick=\"window.location.href='?module=trkatalog&act=tambahtrkatalog';\">";
    echo "<br><br><table width=\"100%\" class=\"table table-striped table-bordered table-hover\" id=\"dataTables-example\">
            <thead>
          <tr><th>No</th><th>ID TR Katalog</th><th>Nama</th><th>Deskripsi</th><th>Aksi</th></tr></thead>";
    $no=1;
    while ($r=mysqli_fetch_array($tampil_trkatalog)){
       echo "<tr><td>$no</td>             
             <td>$r[idtrkatalog]</td>           
             <td>$r[nama]</td>
              <td>$r[deskripsi]</td>
             <td><a href='?module=trkatalog&act=edittrkatalog&id=$r[id]' title='Edit'><i class='fa fa-edit'></i></a> |
                <a href=javascript:confirmdelete('$aksi?module=trkatalog&act=hapus_trkatalog&id=$r[id]') title='Hapus'><i class='fa fa-trash'></i></a>";
      $no++;
    }
    echo "</table>";
        }else{
            echo "<script>window.alert('Tidak ada kategori yang anda ampu, Kembali ke home untuk menambah kategori yang diampu');
            window.location=(href='?module=home')</script>";
        }
    }
    elseif ($_SESSION[leveluser]=='siswa'){
        $siswa = mysqli_query($DBcon, "SELECT * FROM siswa WHERE id_siswa = $_SESSION[idsiswa]");
        $data_siswa = mysqli_fetch_array($siswa);
        $tampil_trkatalog = mysqli_query($DBcon, "SELECT * FROM mata_pelajaran WHERE id_kelas = '$data_siswa[id_kelas]'");
        echo"<br><b class='judul'>Daftar Kategori di Kelas Anda</b><br><p class='garisbawah'></p>";
        echo "<table width=\"100%\" class=\"table table-striped table-bordered table-hover\" id=\"dataTables-example\">
            <thead>
          <tr><th>No</th><th>Nama</th><th>Pengajar</th><th>Deskripsi</th></tr></thead>/";
        $no=1;
        while ($r=mysqli_fetch_array($tampil_trkatalog)){
        echo "<tr><td>$no</td>
             <td>$r[nama]</td>";             
             $pengajar = mysqli_query($DBcon, "SELECT * FROM pengajar WHERE id_pengajar = '$r[id_pengajar]'");
             $cek_pengajar = mysqli_num_rows($pengajar);
             if(!empty($cek_pengajar)){
             while($p=mysqli_fetch_array($pengajar)){
             echo "<td><a href=?module=admin&act=detailpengajar&id=$r[id_pengajar] title='Detail Pengajar'>$p[EmployeeName]</a></td>";
             }
             }else{
                 echo"<td></td>";
             }
             echo "<td>$r[deskripsi]</td>";
        $no++;
        }
        echo "</table>";
    }
    break;

case "tambahtrkatalog":
    if ($_SESSION[leveluser]=='admin'){
        echo "<form role='form' method=POST action='$aksi?module=trkatalog&act=input_trkatalog'>
          <div class=\"panel-body\">
            <div class=\"row\">
            <div class=\"col-lg-6\">
          <legend>Tambah TR Katalog</legend>
          <div class=\"form-group\">
            <label>ID TR Katalog</label>
              <input class=\"form-control\" type='number' name='idtrkatalog' required>
            <p class=\"help-block\">ID TR Katalog Hanya Berupa Angka</p>
              </div>
          <div class=\"form-group\">
            <label>Nama TR Katalog</label>
              <input class=\"form-control\" name='nama' required>
              </div>
          <div class=\"form-group\">
            <label>Deskripsi</label>
              <textarea class=\"form-control\" name='deskripsi'>
              </textarea>
          </div>
          <div class='pull-right'>
          <input class=\"btn btn-primary\" type=submit value=Simpan>
          <input class=\"btn btn-danger\"  type=button value=Batal onclick=self.history.back()>
          </div>
          </form>
          </div></div></div>";
    }
    elseif ($_SESSION[leveluser]=='pengajar'){
        echo "<form role='form' method=POST action='$aksi?module=trkatalog&act=input_trkatalog'>        
          <div class=\"panel-body\">
            <div class=\"row\">
            <div class=\"col-lg-6\">
          <legend>Tambah TR Katalog</legend>
          <div class=\"form-group\">
            <label>ID TR Katalog</label>
              <input class=\"form-control\" type='number' name='idtrkatalog' required>
            <p class=\"help-block\">ID TR Katalog Hanya Berupa Angka</p>
              </div>
          <div class=\"form-group\">
            <label>Nama TR Katalog</label>
              <input class=\"form-control\" name='nama' required>
              </div>
          <div class=\"form-group\">
            <label>Deskripsi</label>
              <textarea class=\"form-control\" name='deskripsi'>
              </textarea>
          </div>
          <div class='pull-right'>
          <input class=\"btn btn-primary\" type=submit value=Simpan>
          <input class=\"btn btn-danger\"  type=button value=Batal onclick=self.history.back()>
          </div>
          </form>
          </div></div></div>";
    }
    break;

case "edittrkatalog":
    if ($_SESSION[leveluser]=='admin'){
        $trkatalog=mysqli_query($DBcon, "SELECT * FROM trkatalog WHERE id = '$_GET[id]'");
        $m=mysqli_fetch_array($trkatalog);
        
        echo "
          <form method=POST role='form' action='$aksi?module=trkatalog&act=update_trkatalog'>
          <input type=hidden name=id value='$m[id]'> <div class=\"panel-body\">
          <legend>Edit TR Katalog</legend>
         <div class=\"panel-body\">
            <div class=\"row\">
            <div class=\"col-lg-6\">
          <div class=\"form-group\">
            <label>ID TR Katalog</label>
              <input class=\"form-control\" type='text' value='$m[idtrkatalog]' name='idtrkatalog' readonly>
            <p class=\"help-block\">ID TR Katalog Tidak Dapat Diubah</p>
              </div>
          <div class=\"form-group\">
            <label>Nama TR Katalog</label>
              <input class=\"form-control\"  value='$m[nama]'  name='nama' required>
              </div>
          <div class=\"form-group\">
            <label>Deskripsi</label>
              <textarea class=\"form-control\" name='deskripsi'> $m[deskripsi]
              </textarea>
          </div>
          <div class='pull-right'>
          <input class=\"btn btn-primary\" type=submit value=Simpan>
          <input class=\"btn btn-danger\"  type=button value=Batal onclick=self.history.back()>
          </div>
          </form>
          </div></div></div>";
    }else{
   $trkatalog=mysqli_query($DBcon, "SELECT * FROM trkatalog WHERE id = '$_GET[id]'");
        $m=mysqli_fetch_array($trkatalog);

       echo "
          <form method=POST role='form' action='$aksi?module=trkatalog&act=update_trkatalog'>
          <input type=hidden name=id value='$m[id]'> <div class=\"panel-body\">
          <legend>Edit TR Katalog</legend>
         <div class=\"panel-body\">
            <div class=\"row\">
            <div class=\"col-lg-6\">
          <div class=\"form-group\">
            <label>ID TR Katalog</label>
              <input class=\"form-control\" type='text' value='$m[idtrkatalog]' name='idtrkatalog' readonly>
            <p class=\"help-block\">ID TR Katalog Tidak Dapat Diubah</p>
              </div>
          <div class=\"form-group\">
            <label>Nama TR Katalog</label>
              <input class=\"form-control\"  value='$m[nama]'  name='nama' required>
              </div>
          <div class=\"form-group\">
            <label>Deskripsi</label>
              <textarea class=\"form-control\" name='deskripsi'> $m[deskripsi]
              </textarea>
          </div>
          <div class='pull-right'>
          <input class=\"btn btn-primary\" type=submit value=Simpan>
          <input class=\"btn btn-danger\"  type=button value=Batal onclick=self.history.back()>
          </div>
          </form>
          </div></div></div>";
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