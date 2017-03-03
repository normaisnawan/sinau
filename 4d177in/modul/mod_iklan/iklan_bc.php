            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Manajemen Iklan
                            <?php
                            if ($_SESSION[leveluser]=='admin') {
                              echo "  <div class='pull-right'>
                                <div class='btn-group'>
                                <div class='tooltip-demo'>
                                   <button type='button' class='btn btn-default btn-xs' data-container='body' data-toggle='popover' data-placement='left' data-content='Iklan hanya akan tampil di halaman users saja.'>
                                    <i class='fa fa-info-circle'></i>
                                </button>
                                </div>
                                </div>
                            </div>";
                            }elseif ($_SESSION[leveluser]=='pengajar') {
                              echo "  <div class='pull-right'>
                                <div class='btn-group'>
                                <div class='tooltip-demo'>
                                   <button type='button' class='btn btn-default btn-xs' data-container='body' data-toggle='popover' data-placement='left' data-content='Iklan hanya akan tampil di halaman users saja.'>
                                    <i class='fa fa-info-circle'></i>
                                </button>
                                </div>
                                </div>
                            </div>";
                            }
                          
                            ?>
                        </div>
                        <!-- /.panel-heading -->
                        <div class="pael-body">
<script>
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

$aksi="modul/mod_iklan/aksi_iklan.php";
$aksi_users="4d177in/modul/mod_iklan/aksi_iklan.php";
switch($_GET[act]){
// Tampil Kategori
  default:
    if ($_SESSION[leveluser]=='admin'){
      $tampil_iklan = mysqli_query($DBcon, "SELECT * FROM iklan ORDER BY idiklan");
      echo "<div class=\"panel-body\">
            <div class=\"row\">
                <div class='col-md-12'>

            <h2>Manajemen iklan</h2><hr>
          <input class=\"btn btn-primary pull-right\" type=button value='Tambah iklan' onclick=\"window.location.href='?module=iklan&act=tambahiklan';\">";
          echo "<br><br><table width=\"100%\" class=\"table table-striped table-bordered table-hover\" id=\"dataTables-example\">
            <thead>
          <tr><th>ID Iklan</th><th>Isi iklan</th><th>Aksi</th></tr></thead>";
    $no=1;
    while ($r=mysqli_fetch_array($tampil_iklan)){
       echo "<tr>
             <td>$r[idiklan]</td>
             <td>$r[isiiklan]</td>
             <td>
                <a href='?module=iklan&act=editiklan&idiklan=$r[idiklan]' title='Edit'><i class='fa fa-edit'></i></a> |
                <a href=javascript:confirmdelete('$aksi?module=iklan&act=hapus_iklan&idiklan=$r[idiklan]') title='Hapus'><i class='fa fa-trash'></i></a></td></tr>";
      $no++;
    }
    echo "</table></div></div>";
    }
    elseif ($_SESSION[leveluser]=='pengajar'){
    $tampil_iklan = mysqli_query($DBcon, "SELECT * FROM iklan ORDER BY idiklan");
      echo "<div class=\"panel-body\">
            <div class=\"row\">
                <div class='col-md-12'>

            <h2>Manajemen iklan</h2><hr>
          <input class=\"btn btn-primary pull-right\" type=button value='Tambah iklan' onclick=\"window.location.href='?module=iklan&act=tambahiklan';\">";
          echo "<table width=\"100%\" class=\"table table-striped table-bordered table-hover\" id=\"dataTables-example\">
            <thead>
          <tr><th>ID Iklan</th><th>Isi iklan</th><th>Aksi</th></tr></thead>";
    $no=1;
    while ($r=mysqli_fetch_array($tampil_iklan)){
       echo "<tr>
            <td>$r[idiklan]</td>
             <td>$r[isiiklan]</td>
             <td> 
             <ol>
              <li><div class='tooltip-demo'>
                  <i class='btn btn-default btn-xs' data-container='body' data-toggle='popover' data-placement='top'><a href='?module=iklan&act=editiklan&idiklan=$r[idiklan]' title='Edit'><i class='fa fa-edit'></i></a>
                  </i>
                  </div>
              </li>

              <li><div class='tooltip-demo'>
                  <i class='btn btn-default btn-xs' data-container='body' data-toggle='popover' data-placement='top'><a href=javascript:confirmdelete('$aksi?module=iklan&act=hapus_iklan&idiklan=$r[idiklan]') title='Hapus'><i class='fa fa-trash'></i></a>
                  </i>
                </div>
              </li>
              <li><div class='btn-group'>
                <div class='tooltip-demo'>
                  <i class='btn btn-default btn-xs' data-container='body' data-toggle='popover' data-placement='top' data-content='Iklan yang ada akan tampil sesuai ID Iklan yang ada. Jika Iklan yang anda tampilkan tidak ada, silakan hapus dulu iklan yang dahulu-dahulu.'>
                  <i class='fa fa-info-circle'></i>
                  </i>
                </div>
              </li>
            </div></td></tr>";
      $no++;
    }
    echo "</table></div></div>";
    }
    elseif ($_SESSION[leveluser]=='users'){
        $users = mysqli_query($DBcon, "SELECT * FROM users WHERE id_users = $_SESSION[idusers]");
        $data_users = mysqli_fetch_array($users);
        $tampil_iklan = mysqli_query($DBcon, "SELECT * FROM mata_pelajaran WHERE id_kelas = '$data_users[id_kelas]'");
        echo"<br><b class='judul'>Daftar Kategori di Kelas Anda</b><br><p class='garisbawah'></p>";
        echo "<table width=\"100%\" class=\"table table-striped table-bordered table-hover\" id=\"dataTables-example\">
            <thead>
          <tr><th>No</th><th>Nama</th><th>Pengajar</th><th>Deskripsi</th></tr></thead>/";
        $no=1;
        while ($r=mysqli_fetch_array($tampil_iklan)){
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
case 'bacaiklan':
  if ($_SESSION[leveluser]=='users') {    
    $tampil_iklan = mysqli_query($DBcon, "SELECT * FROM iklan where idiklan='$_GET[idiklan]' and posisi='header'");
     $q=mysqli_fetch_array($tampil_iklan);
       
    if (empty($_GET[idiklan])) {
      echo "<script>window.alert('Tidak ada iklan.');
            window.location=(href='?module=home')</script>";
    }
    elseif ($q[idiklan]==$_GET[idiklan]) {
      $tampil_iklan = mysqli_query($DBcon, "SELECT * FROM iklan where idiklan='$_GET[idiklan]' and posisi='header'");
      while ($q=mysqli_fetch_array($tampil_iklan)) {
        echo "
        <div class='panel-heading'>
        ".$q[juduliklan]."
        </div>
        <div class='panel-body'>
        <p> ".$q[isiiklan]."</p>
        </div>";
      }
    }
    else{
     echo "<script>window.location=(href='?module=home')</script>";
    }
    }
  break;
case "tambahiklan":
    if ($_SESSION[leveluser]=='admin'){
        echo "<form role='form' method=POST action='$aksi?module=iklan&act=input_iklan'>
           
          <div class=\"panel-body\">
            <div class=\"row\">
            <div class=\"col-lg-6\">
          <legend>Tambah iklan</legend>
          <div class=\"form-group\">
            <label>Judul iklan</label>
              <input class=\"form-control\" name='juduliklan' required>
              </div>  
          <div class=\"form-group\">
             <label>Posisi Iklan </label>
              <div class='radio'>
              <label>
              <input type='radio' name='posisi' value='popup'>POP-UP
              </label>
              </div>
              <div class='radio'>              
              <label>
              <input type='radio' name='posisi' value='header'>Header
              </label></div>
            <br>
            <code>Jika anda mengatur Posisi iklan untuk <i><em>HEADER</em></i> maka jangan menggunakan <i>Heading</i>, atau mengubah ukuran isi iklan, dikarenakan iklan tidak bisa muncul jika anda mengubah ukurannya.</code>
            <br> 
          </div>      
          <div class=\"form-group\">
            <label>Isi iklan</label>
              <textarea class=\"form-control\" name='isiiklan'>
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
         echo "
            <div class='row'>
                <div class='col-lg-12'>
                        <div class='panel-body'>
                            <!-- Nav tabs -->
                            <ul class='nav nav-tabs'>
                                <li class='active'><a href='#home' data-toggle='tab'>Iklan</a>
                                </li>
                                <li><a href='#profile' data-toggle='tab'>Video</a>
                                </li>
                            </ul>

                            <!-- Tab panes -->
                            <div class='tab-content'>
                                <div class='tab-pane fade in active' id='home'>
                                             <form role='form' method=POST action='$aksi?module=iklan&act=input_iklan'>
                                              <legend>Tambah iklan</legend>
                                              <div class=\"form-group\">
                                                <label>Judul iklan</label>
                                                  <input class=\"form-control\" name='juduliklan' required>
                                                  </div>  
                                              <div class=\"form-group\">
                                                  <label>Posisi Iklan </label>
                                                  <div class='radio'>
                                                  <label>
                                                  <input type='radio' name='posisi' value='popup' >POP-UP
                                                  </label>
                                                  </div>
                                                  <div class='radio'>              
                                                  <label>
                                                  <input type='radio' name='posisi' value='header'>Header
                                                  </label></div>
                                                <br>
                                                <code>Jika anda mengatur Posisi iklan untuk <i><em>HEADER</em></i> maka jangan menggunakan <i>Heading</i>, atau mengubah ukuran isi iklan, dikarenakan iklan tidak bisa muncul jika anda mengubah ukurannya.</code>
                                                <br> 
                                              </div>
                                                              
                                              <div class=\"form-group\">
                                                <label>Isi iklan</label>
                                                  <textarea class=\"form-control\" name='isiiklan'>
                                                  </textarea>
                                              </div>
                                              <div class='pull-right'>
                                              <input class=\"btn btn-primary\" type=submit value=Simpan>
                                              <input class=\"btn btn-danger\"  type=button value=Batal onclick=self.history.back()>
                                              </div>
                                              </form>
                                </div>
                                <div class='tab-pane fade' id='profile'>
                                      <form role='form' method=POST action='$aksi?module=iklan&act=input_video' enctype='multipart/form-data'>
                                      <legend>Tambah Video</legend>
                                      <div class=\"form-group\">
                                        <label>Judul Video</label>
                                          <input class=\"form-control\" name='judul' required>
                                          </div>  
                                                      
                                      <div class=\"form-group\">
                                        <label>Unggah Video</label>
                                        <input type='file' name='fupload' class='form-control'>
                                      </div>
                                      <div class='pull-right'>
                                      <input class=\"btn btn-primary\" type=submit value=Simpan>
                                      <input class=\"btn btn-danger\"  type=button value=Batal onclick=self.history.back()>
                                      </div>
                                 </form>
                                </div>
                                
                            </div>
                        </div>
                        <!-- /.panel-body -->
                    </div>
          </div></div></div>";

    }
    break;

case "editiklan":
    if ($_SESSION[leveluser]=='admin'){
        $iklan=mysqli_query($DBcon, "SELECT * FROM iklan WHERE idiklan = '$_GET[idiklan]'");
        $m=mysqli_fetch_array($iklan);
        
        echo "<form method=POST role='form' action='$aksi?module=iklan&act=update_iklan'>
          <input type=hidden name=idiklan value='$m[idiklan]'><div class=\"panel-body\">
            <div class=\"row\">
            <div class=\"col-lg-6\">
          <legend>Edit iklan</legend>
 <div class=\"form-group\">
            <label>Judul iklan</label>
              <input class=\"form-control\" name='juduliklan' value='$m[juduliklan]' required>
          </div>";
          if ($m[posisi]=='popup'){
             echo "
              <div class=\"form-group\">
                <label>Posisi Iklan </label>
              <div class='radio'>
              <label>
              <input type='radio' name='posisi' value='popup' checked>POP-UP
              </label>
              </div>
              <div class='radio'>              
              <label>
              <input type='radio' name='posisi' value='header'>Header
              </label></div>";
          }else{
              echo "<div class=\"form-group\">
                <label>Posisi Iklan </label>
              <div class='radio'>
              <label>
              <input type='radio' name='posisi' value='popup' >POP-UP
              </label>
              </div>
              <div class='radio'>              
              <label>
              <input type='radio' name='posisi' value='header' checked>Header
              </label></div>";
          }      
            echo "<br>
            <code>Jika anda mengatur Posisi iklan untuk <i><em>HEADER</em></i> maka jangan menggunakan <i>Heading</i>, atau mengubah ukuran isi iklan, dikarenakan iklan tidak bisa muncul jika anda mengubah ukurannya.</code>
            <br> 
            
          </div> 
          <div class=\"form-group\">
            <label>Isi iklan</label>            
              <textarea name='isiiklan'>$m[isiiklan]</textarea>
          </div>
          <div class='pull-right'>
          <input class=\"btn btn-primary\" type=submit value=Simpan>
          <input class=\"btn btn-danger\"  type=button value=Batal onclick=self.history.back()>
          </div>
          </form>
          </div></div></div>";
    }else{
 $iklan=mysqli_query($DBcon, "SELECT * FROM iklan WHERE idiklan = '$_GET[idiklan]'");
        $m=mysqli_fetch_array($iklan);
        
         echo "<form method=POST role='form' action='$aksi?module=iklan&act=update_iklan'>
          <input type=hidden name=idiklan value='$m[idiklan]'><div class=\"panel-body\">
            <div class=\"row\">
            <div class=\"col-lg-6\">
          <legend>Edit iklan</legend>
          <div class=\"form-group\">
            <label>Judul iklan</label>
              <input class=\"form-control\" name='juduliklan' value='$m[juduliklan]' required>
          </div>";
          if ($m[posisi]=='popup'){
             echo "
              <div class=\"form-group\">
                <label>Posisi Iklan </label>
              <div class='radio'>
              <label>
              <input type='radio' name='posisi' value='popup' checked>POP-UP
              </label>
              </div>
              <div class='radio'>              
              <label>
              <input type='radio' name='posisi' value='header'>Header
              </label></div>";
          }else{
              echo "<div class=\"form-group\">
                <label>Posisi Iklan </label>
              <div class='radio'>
              <label>
              <input type='radio' name='posisi' value='popup' >POP-UP
              </label>
              </div>
              <div class='radio'>              
              <label>
              <input type='radio' name='posisi' value='header' checked>Header
              </label></div>";
          }      
            echo "<br>
            <code>Jika anda mengatur Posisi iklan untuk <i><em>HEADER</em></i> maka jangan menggunakan <i>Heading</i>, atau mengubah ukuran isi iklan, dikarenakan iklan tidak bisa muncul jika anda mengubah ukurannya.</code>
            <br> 
            
          </div> 
          <div class=\"form-group\">
            <label>Isi iklan</label>
              <textarea name='isiiklan'>$m[isiiklan]</textarea>
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