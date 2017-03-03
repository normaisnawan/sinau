         <hr>
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4>Pesan</h4>
                        </div>
                        <!-- /.panel-heading -->
                        <div class="pael-body">
<script>
function confirmdelete(delUrl) {
  if (confirm("Anda yakin ingin menghapus?")) {
  document.location = delUrl;
  }
}function confirmchange(delUrl) {
  if (confirm("Anda yakin ingin mengubah status pesan ini?")) {
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

$aksi="modul/mod_pesan/aksi_pesan.php";
$aksi_users="4d177in/modul/mod_pesan/aksi_pesan.php";
switch($_GET[act]){
// Tampil Kategori
  default:
    if ($_SESSION[leveluser]=='admin'){
 echo "Hellow";
    }
    elseif ($_SESSION[leveluser]=='pengajar'){
    $tampil_pesan = mysqli_query($DBcon, "SELECT * FROM pesan ORDER BY idpesan");
      echo "<div class=\"panel-body\">
            <div class=\"row\">
              <div class='col-md-12'>
                <h2>Manajemen Pesan</h2><hr>
                <input class=\"btn btn-primary pull-right\" type=button value='Tambah Pesan' onclick=\"window.location.href='?module=pesan&act=tambahpesan';\">
                <div class='clearfix'></div></br>";
          echo "
                  <table width=\"100%\" class=\"table table-striped table-bordered table-hover\" id=\"dataTables-example\">
                  <thead>
                  <tr>
                    <th>No</th>
                    <th>Kepada</th>
                    <th>Tanggal Pengiriman</th>
                    <th>Isi Pesan</th>
                    <th>Dari</th>
                    <th>Status</th>
                    <th>Aksi</th>
                    </tr>
                  </thead>";
    $no=1;

    while ($r=mysqli_fetch_array($tampil_pesan)){
       echo "<tr><td>$no</td>";
       
       $tampil_users=mysqli_query($DBcon, "SELECT * FROM users WHERE find_in_set(NIK,'$r[NIK_penerima]')");
       echo "
            <td>";
                 while ($p=mysqli_fetch_array($tampil_users)) {
                   echo $p[EmployeeName]."<br>";

                 }
        echo"</td>
             <td>$r[waktupengiriman]</td>
             <td>".wordwrap($r[isipesan],15,"<br>\n",TRUE)."</td>";
               $tampil_users=mysqli_query($DBcon, "SELECT * FROM pengajar WHERE NIK = '$r[NIK_pengirim]'");
                while($p=mysqli_fetch_array($tampil_users)){
                  echo "<td>$p[EmployeeName]</td>";
                 }
              if ($r[dibacauser]=='Sudah') {
                echo "<td><span class='btn btn-outline btn-success btn-xs'>Sudah Terbaca</span></td>";
              }else{
                echo "<td><span class='btn btn-outline btn-danger btn-xs'>Belum Terbaca</span></td>";
              }
             echo "
             <td>
                <ol>
                  <li>
                    <div class='tooltip-demo'>
                      <i data-toggle='tooltip' data-placement='top' title='Klik untuk mengubah.' class='btn btn-default btn-xs' > <a href='?module=pesan&act=editpesan&idpesan=$r[idpesan]' title='Edit'><i class='fa fa-edit'></i></a>
                        </a>
                      </i>
                    </div>
                  </li>
                 <li>
                  <div class='tooltip-demo'>
                      <i data-toggle='tooltip' data-placement='top' title='Klik untuk mengubah.' class='btn btn-default btn-xs' > <a href=javascript:confirmdelete('$aksi?module=pesan&act=hapus_pesan&idpesan=$r[idpesan]') title='Hapus'><i class='fa fa-trash'></i></a>
                      </i>
                    </div>
                  </li>
                   <li>
                  <div class='tooltip-demo'>
                      <i data-toggle='tooltip' data-placement='top' title='Klik untuk mengubah status.' class='btn btn-default btn-xs' > <a href=javascript:confirmchange('$aksi?module=pesan&act=ubahstatus&idpesan=$r[idpesan]') title='Ubah'><i class='fa fa-refresh'></i></a>
                      </i>
                    </div>
                  </li>
                </ol>
                </td>
              </tr>";
      $no++;
    }
    echo "</table></div></div></div>";
    }
    elseif ($_SESSION[leveluser]=='users'){
        $users = mysqli_query($DBcon, "SELECT * FROM users WHERE id_users = $_SESSION[idusers]");
        $data_users = mysqli_fetch_array($users);
        echo"<br><b class='judul'>Daftar Kategori di Kelas Anda</b><br><p class='garisbawah'></p>";
        echo "<table width=\"100%\" class=\"table table-striped table-bordered table-hover\" id=\"dataTables-example\">
            <thead>
          <tr><th>No</th><th>Nama</th><th>Pengajar</th><th>Deskripsi</th></tr></thead>/";
        $no=1;
        while ($r=mysqli_fetch_array($tampil_pesan)){
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
case 'semuapesan':
  if ($_SESSION[leveluser]=='users') {
$tampil_pesan = mysqli_query($DBcon, 'SELECT * FROM pesan WHERE NIK_penerima LIKE "%'.$_SESSION[NIK].'%" ORDER BY `dibacauser` DESC');
      echo "<div class=\"panel-body\">
            <div class=\"row\">
                <div class='col-md-12'>
      <table width=\"100%\" class=\"table table-striped table-bordered table-hover\" id=\"dataTables-example\">
            <thead>
          <tr><th>No</th><th>Tanggal Pengiriman</th><th>Isi Pesan</th><th>Dari</th><th>Aksi</th></tr></thead>";
    $no=1;
    while ($r=mysqli_fetch_array($tampil_pesan)){
       echo "<tr><td>$no</td>
             <td>$r[waktupengiriman]</td>";
               if ($r[dibacauser]=='Belum') {
                 echo "<td><code><b style='font-size='10';'><a href='?module=pesan&act=bacapesan&idpesan=$r[idpesan]'>Klik Untuk Membuka Pesan.</a></b></code></td>";
               }
               else{
             echo "<td>
             <p style=\"font-size:12px; width:500; color: black; \"><a style=\"font-size:12px; width:500; color: black; \"  href='?module=pesan&act=bacapesan&idpesan=$r[idpesan]'>Klik Untuk Membuka Pesan.</a>
             </p></td>";
               
             }
               $tampil_users=mysqli_query($DBcon, "SELECT * FROM pengajar WHERE NIK = '$r[NIK_pengirim]'");
                while($p=mysqli_fetch_array($tampil_users)){
                  echo "<td>$p[EmployeeName]</td>";
                 }
             echo "
             <td>
                 <ol>
                  <li>
                    <div class='tooltip-demo'>
                      <a href='?module=pesan&act=bacapesan&idpesan=$r[idpesan]'>
                          <div data-toggle='tooltip' data-placement='top' title='Klik gambar buku untuk membaca.' class='btn btn-default btn-xs' >
                              <i class='fa fa-book'>
                              </i>
                          </div>
                      </a>
                    </div>
                  </li>
                  <li> 
                    <div class='tooltip-demo'>
                      <a href=javascript:confirmdelete('$aksi_users?module=pesan&act=hapus_pesan_users&idpesan=$r[idpesan]') title='Hapus'>
                      <div data-toggle='tooltip' data-placement='bottom' title='Klik gambar tong sampah untuk menghapus pesan.' class='btn btn-default btn-xs' >
                      <i class='fa fa-trash'></i>
                      </div>
                    </a>
                    </div>
                  </li>

            </td>
          </tr>";
      $no++;
    }
    echo "</table>";
    }
  break;
case "tambahpesan":
    if ($_SESSION[leveluser]=='admin'){
        echo "<form role='form' method=POST action='$aksi?module=pesan&act=input_pesan'>
           
          <div class=\"panel-body\">
            <div class=\"row\">
            <div class=\"col-lg-6\">
          <legend>Tambah Pesan</legend>
          <div class=\"form-group\">
            <label>Kepada</label>
            <select class=\"form-control\" name='NIK_penerima'>";
                $tampil_users=mysqli_query($DBcon, "SELECT * FROM users ORDER BY EmployeeName");
                while($p=mysqli_fetch_array($tampil_users)){
                  echo "<option value=$p[NIK]>$p[EmployeeName]</option>";
                 }echo "</select>
              </div>
          <div class=\"form-group\">
            <label>Judul Pesan</label>
              <input class=\"form-control\" name='judulpesan' required>
              </div>          
          <div class=\"form-group\">
            <label>Waktu Pengiriman</label>
              <input class=\"form-control\" value='".indonesian_date()."' name='waktu' required readonly>
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
              </label></div> <code>Perintah bertujuan untuk memberitahukan users agar melakukan tindakan yang sudah diperintahkan di dalam pesan.</code>
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
              </label> </div><code>Perintah bertujuan untuk memberitahukan users agar melakukan tindakan yang sudah diperintahkan di dalam pesan.</code>
            <br> ";
          }      
            echo "
          <div class=\"form-group\">
            <label>Isi Pesan</label>
              <textarea class=\"form-control\" name='isipesan'>
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
         echo "<form role='form' method=POST action='$aksi?module=pesan&act=input_pesan'>
           <div class=\"panel-body\">
            <div class=\"row\">
            <div class=\"col-lg-6\">
          <legend>Tambah Pesan</legend>
          <div class=\"form-group\">
            <label>Kepada</label>
            <select class='form-control js-example-basic-multiple' multiple='multiple' name='NIK_penerima[]'>"; 
            $tampil_users=mysqli_query($DBcon, "SELECT * FROM users ORDER BY PosTitle ASC ");
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
              <input class=\"form-control\" name='judulpesan' required>
              </div>          
          <div class=\"form-group\">
            <label>Waktu Pengiriman</label>
              <input class=\"form-control\" value='".indonesian_date()."' name='waktu' required readonly>
              </div> 
          <div class=\"form-group\">
             <label>Perintah</label>
              <div class='radio'>
              <label>
              <input type='radio' name='perintah' value='Ya'>Ya
              </label>
              </div>
              <div class='radio'>              
              <label>
              <input type='radio' name='perintah' value='Tidak'>Tidak
              </label></div>
            <br>
            <code>Perintah bertujuan untuk memberitahukan users agar melakukan tindakan yang sudah diperintahkan di dalam pesan.</code>
            <br> 
          </div>      
          <div class=\"form-group\">
            <label>Isi Pesan</label>
              <textarea class=\"form-control\" name='isipesan'>
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
case "bacapesan":
  if ($_SESSION[leveluser]=='users') {
    if (empty($_GET[idpesan])) {
      echo"
      <script>
        window.alert('Tidak ada pesan yang dipilih'); 
        window.location=(href='pesan')
      </script>
      ";
    }else{
    $pesan=mysqli_query($DBcon, "SELECT * FROM pesan WHERE idpesan = '$_GET[idpesan]'");
        $m=mysqli_fetch_array($pesan);
            mysqli_query($DBcon, "UPDATE pesan set dibacauser='Sudah' where idpesan='$_GET[idpesan]'");
    echo" <div class='panel-body'>
            <div class='row'>
              <div class='col-lg-12'>
                <div class='col-sm-6 col-md-12'>
                        <div class='compose-mail'>
                            <div class='portlet box portlet-white'>
                                <div class='portlet-header'>
                                    <div class='caption'><h3>".$m[judul]."</h3><div class='tools'>
                                      <a href=javascript:confirmdelete('$aksi_users?module=pesan&act=hapus_pesan_users&idpesan=".$m[idpesan]."') title='Hapus'><i class='fa fa-trash'></i></a></div>
                                </div></div>
                                    <hr>
                                    
           <div class='portlet-body'>
          <div class='mail-content'>
                  <div class='mail-sender'>
                            <div class='row'>
        <div class='col-md-6'>Dari <strong>";
               $tampil_users=mysqli_query($DBcon, "SELECT * FROM pengajar WHERE NIK = '$m[NIK_pengirim]'");
                while($p=mysqli_fetch_array($tampil_users)){
                  echo "$p[EmployeeName]";
                 }
             echo "


        </strong>&nbsp;untuk
          &nbsp;<strong>".$_SESSION[namalengkap]."</strong></div>
             <div class='col-md-6'><p class='date'> ".$m[waktupengiriman]."</p></div>
                       </div>
                         </div>
                      <div class='mail-view'>
                              <p>".$m[isipesan]."</p>";
                      if ($m[link] == TRUE) {
                        echo '<center><a href="'.$m[link].'"><button type="button" class="btn btn-outline btn-info">Klik Di sini</button></a></center>';
                      }
                      echo"</div>
                  
                        <div class='clearfix'></div>
                                <hr/>
                             </div>
                        </div>
                    </div>
                </div>
            </div>
              </div>
            </div>
          </div>";
    }
  }
  break;
case "editpesan":
    if ($_SESSION[leveluser]=='admin'){
        $pesan=mysqli_query($DBcon, "SELECT * FROM pesan WHERE idpesan = '$_GET[idpesan]'");
        $m=mysqli_fetch_array($pesan);
        
        echo "<form method=POST role='form' action='$aksi?module=pesan&act=update_pesan'>
          <input type=hidden name=idpesan value='$m[idpesan]'>
          <div class=\"panel-body\">
            <div class=\"row\">
            <div class=\"col-md-12\">
          <legend>Tambah Pesan</legend>
          <div class=\"form-group\">";
          $tampil_users=mysqli_query($DBcon, "SELECT * FROM users WHERE NIK='$m[NIK_penerima]'");
                while($q=mysqli_fetch_array($tampil_users)){
                  echo "Saat ini Pesan ditujukan kepada <p><code><b>$q[EmployeeName]</b></code></p>";
                 }
           echo "<label>Kepada</label>";
             echo "<select class=\"form-control\" name='NIK_penerima'>";
                $tampil_users=mysqli_query($DBcon, "SELECT * FROM users");
                while($p=mysqli_fetch_array($tampil_users)){
                  echo "<option value=$p[NIK]>$p[EmployeeName]</option>";
                 }echo "</select>
              </div>
          <div class=\"form-group\">
            <label>Judul Pesan</label>
              <input class=\"form-control\" name='judulpesan' value='$m[judul]' required>
              </div>          
          <div class=\"form-group\">
            <label>Waktu Pengiriman</label>
              <input class=\"form-control\" value='".indonesian_date()."' name='waktu' required readonly>
              </div>>";
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
              </label> <code>Perintah bertujuan untuk memberitahukan users agar melakukan tindakan yang sudah diperintahkan di dalam pesan.</code>
            <br> </div>";
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
              </label> <code>Perintah bertujuan untuk memberitahukan users agar melakukan tindakan yang sudah diperintahkan di dalam pesan.</code>
            <br> </div>";
          }      
            echo "
          <div class=\"form-group\">
            <label>Isi Pesan</label>
              <textarea name='isipesan'>$m[isipesan]</textarea>
          </div>
          <div class='pull-right'>
          <input class=\"btn btn-primary\" type=submit value=Simpan>
          <input class=\"btn btn-danger\"  type=button value=Batal onclick=self.history.back()>
          </div>
          </form>
          </div></div></div>";
    }else{
 $pesan=mysqli_query($DBcon, "SELECT * FROM pesan WHERE idpesan = '$_GET[idpesan]'");
        $m=mysqli_fetch_array($pesan);
        
        echo "<div class=\"panel-body\">
            <div class=\"row\">
            <div class=\"col-md-12\">
          <legend>Tambah Pesan</legend>
       ";
          $hasilpilih .= $m[NIK_penerima] . ",";
          $hasilpilih = substr($hasilpilih,0,-1);

          $tampil_users=mysqli_query($DBcon, "SELECT * FROM users WHERE find_in_set(NIK,'$hasilpilih') ORDER BY PosTitle ASC ");
          echo "                      
                        <div class='panel-body'>
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
                </div>
                <!-- /.col-lg-12 -->   
                                <!-- /.col-lg-4 -->
<form method=POST role='form' action='$aksi?module=pesan&act=update_pesan'>
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
            
           //$tampil_users=mysqli_query($DBcon, "SELECT * FROM users WHERE find_in_set(NIK,'$hasilpilih') ORDER BY PosTitle ASC ");

    
           //Untuk Users Terpilih
            if ($m[NIK_penerima] )
        $hasilpilih .= $m[NIK_penerima] . ",";
          $hasilpilih = substr($hasilpilih,0,-1);

          $tampil_users=mysqli_query($DBcon, "SELECT * FROM users WHERE find_in_set(NIK,'$hasilpilih') ORDER BY PosTitle ASC ");

          $tampil=mysqli_query($DBcon, "SELECT * FROM users ORDER BY PosTitle ASC ");
  
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
              <input class=\"form-control\" value='".indonesian_date()."' name='waktu' required readonly>
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
          <div class='pull-right'>
          <input class=\"btn btn-primary\" type=submit value=Simpan>
          <input class=\"btn btn-danger\"  type=button value=Batal onclick=self.history.back()>
          </div>
          </form>
          </div>
                        </div>
                    </div>
                </div>
           </div></div>";
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