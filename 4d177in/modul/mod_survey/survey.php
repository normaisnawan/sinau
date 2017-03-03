<?php
session_start();
 if (empty($_SESSION['username']) AND empty($_SESSION['passuser'])){
  echo "<link href=../css/style.css rel=stylesheet type=text/css>";
  echo "<div class='error msg'>Untuk mengakses Modul anda harus login.</div>";
}
else{

include "../../../configurasi/class_paging.php";

$aksi="modul/mod_survey/aksi_survey.php";
$aksi_users = "4d177in/modul/mod_survey/aksi_survey.php";
switch($_GET[act]){
  // Tampil User
  default:
    if ($_SESSION[leveluser]=='admin'){
    echo "Hello!!";
    }
    elseif ($_SESSION[leveluser]=='pengajar') {
      $tampil_users = mysqli_query($DBcon, "SELECT * FROM survey");
      echo "<h2>Manajemen User</h2><hr>
          <input class='btn btn-success' type=button value='Tambah Survey' onclick=\"window.location.href='?module=survey&act=tambahsurvey';\">";
      echo "
          <table width=\"100%\" class=\"table table-striped table-bordered table-hover\" id=\"dataTables-example\">
            <thead>
              <tr>
                <th>No</th>
                <th>Survey</th>
                <th>Hasil</th>
                <th>Aksi</th>
              </tr>
            </thead>";
      $no =1;
    while ($r=mysqli_fetch_array($tampil_users)){
       echo "<tr>
              <td>$no</td>
             <td>$r[NIK]</td>
             <td>$r[EmployeeName]</td>
             <td><p align='center'>$r[jenis_kelamin]</p></td>             
             <td><p align='center'>$r[blokir]</p></td>
             <td><a href='?module=users&act=editsurvey&id=$r[id_users]' title='Edit'><img src='images/icons/edit.png' alt='Edit' /></a> |
                 <a href=?module=detailuser&act=detailuser&id=$r[id_users]>Detail</a></td>
            </tr>";
      $no++;
      }
    echo "</table>";
    }
    break;

case "lihatusers":
    if ($_SESSION[leveluser]=='admin'){

    $tampil = mysqli_query($DBcon, "SELECT * FROM users WHERE id_kelas = '$_GET[id]' ORDER BY EmployeeName LIMIT $posisi,$batas");
    $cek_users = mysqli_num_rows($tampil);
    if(!empty($cek_users)){
    echo "<div class='information msg'>Daftar User</div>
          <br><table id='' class='gtable sortable'><thead>
          <tr><th>No</th><th>No Cek</th><th>Nama</th><th>Jenis Kelamin</th>
            <th>Blokir</th><th>Aksi</th></tr></thead>";
     $no=$posisi+1;
    while ($r=mysqli_fetch_array($tampil)){
       echo "<tr><td>$no</td>
             <td>$r[NIK]</td>
             <td>$r[EmployeeName]</td>
             ";
             $kelas = mysqli_query($DBcon, "SELECT * FROM kelas WHERE id_kelas = '$r[id_kelas]'");
             while($k=mysqli_fetch_array($kelas)){
             echo"<td><a href=?module=kelas&act=detailkelas&id=$k[id_kelas]>$k[nama]</a></td>";
             }
             echo "<td><p align='center'>$r[jenis_kelamin]</p></td>             
             <td><p align='center'>$r[blokir]</p></td>
             <td><a href='?module=users&act=editsurvey&id=$r[id_users]' title='Edit'><img src='images/icons/edit.png' alt='Edit' /></a> |
                 <a href=?module=detailuser&act=detailuser&id=$r[id_users]>Detail User</a></td></tr>";
      $no++;
    }
    echo "</table>";
    
    $jmldata=mysqli_num_rows(mysqli_query($DBcon, "SELECT * FROM users"));
    echo "<div class='buttons'><input class='button blue' type=button value=Kembali onclick=self.history.back()></div>";
    }else{
        echo "<script>window.alert('Tidak ada users dikelas ini');
            window.location=(href='?module=kelas')</script>";
    }
    }
    elseif ($_SESSION[leveluser]=='pengajar'){

    $tampil = mysqli_query($DBcon, "SELECT * FROM users ORDER BY EmployeeName");
    $cek_users = mysqli_num_rows($tampil);
    if(!empty($cek_users)){
    echo "<form>
          <fieldset>
          <legend>Daftar User</legend>
          <dl class='inline'>";
    echo "<table id=\"dataTables-example\" class='gtable sortable'><thead>
          <tr><th>No</th><th>No Cek</th><th>Nama</th><th>Kelas</th><th>Jenis Kelamin</th>
           <th>Aksi</th></tr></thead>";
     $no=1;
    while ($r=mysqli_fetch_array($tampil)){
       echo "<tr><td>$no</td>
             <td>$r[NIK]</td>
             <td>$r[EmployeeName]</td>
             <td><p align='center'>$r[jenis_kelamin]</p></td>                       
             <td><input type=button class='button small white' value='Detail User' onclick=\"window.location.href='?module=detailuserpengajar&act=detailuser&id=$r[id_users]';\">";
      $no++;
    }
    echo "</table>";
    $jmldata=mysqli_num_rows(mysqli_query($DBcon, "SELECT * FROM users"));

    echo "<input type=button class='button blue' value=Kembali onclick=self.history.back()>";
    }else{
        echo "<script>window.alert('Tidak ada users dikelas ini');
            window.location=(href='?module=kelas')</script>";
    }
    }
    else{
    $tampil = mysqli_query($DBcon, "SELECT * FROM users ORDER BY EmployeeName");
    $cek_users = mysqli_num_rows($tampil);
    if(!empty($cek_users)){
    echo"<br><b class='judul'>Daftar Teman</b><br><p class='garisbawah'></p>";
    echo "<table>
          <tr><th>No</th><th>No Cek</th><th>Nama</th><th>Jenis Kelamin</th><th>Th Masuk</th>
           <th>Aksi</th></tr>";
     $no=1;
    while ($r=mysqli_fetch_array($tampil)){
       echo "<tr><td>$no</td>
             <td>$r[NIK]</td>
             <td>$r[EmployeeName]</td>             
             <td>$r[jenis_kelamin]</td>
             <td>$r[th_masuk]</td>
             <td><input type=button class='tombol' value='Detail User'
                 onclick=\"window.location.href='?module=users&act=detailuser&id=$r[id_users]';\">";
      $no++;
    }
    echo "</table>";
    $jmldata=mysqli_num_rows(mysqli_query($DBcon, "SELECT * FROM users"));
    echo "<input type=button class='tombol' value='Kembali'
          onclick=self.history.back()>";
    }else{
        echo "<script>window.alert('Tidak ada users dikelas ini');
            window.location=(href='?module=kelas')</script>";
    }
    }
    break;

case "tambahsurvey":
    if ($_SESSION[leveluser]=='admin'){
        $tampil = mysqli_query($DBcon, "SELECT * FROM users WHERE id_users = '$_GET[id]'");
       
        echo " <div class=\"panel-body\">
            <div class=\"row\">
            <div class=\"col-lg-6\">
          <form method=POST action='$aksi?module=users&act=input_users' enctype='multipart/form-data'>
          <legend>Tambah User</legend>
          <div class=\"form-group\">
            <label>No Cek</label>
              <input class=\"form-control\" type='number' name='NIK' required>
              </div>
          <div class=\"form-group\">
            <label>Nama Lengkap</label>
              <input class=\"form-control\" type='text' name='EmployeeName' required>
              </div>
          <div class=\"form-group\">
            <label>Username Login</label>
              <input class=\"form-control\" type='text' name='username' required>
              </div>
          <div class=\"form-group\">
            <label>Password Login</label>
              <input class=\"form-control\" type='text' name='password' required>
              </div>
          <div class=\"form-group\">
            <label>PosTitle</label>
              <input class=\"form-control\" type='text' name='PosTitle' required>
              </div>
          <div class=\"form-group\">
            <label>Alamat</label>
              <input class=\"form-control\" type='text' name='alamat' required>
              </div>
          <div class=\"form-group\">
            <label>Jenis Kelamin</label>
            <div class=\"radio\">
            <label>
              <input type=\"radio\" name=\"jk\" value=\"L\" required>Laki- Laki
              </label>
              </div>
            <label>
            <div class=\"radio\">
            <label>
              <input type=\"radio\" name=\"jk\" value=\"P\">Perempuan
            </label>
            </div>
          </div>

          
          <div class=\"form-group\">
            <label>Email</label>
            <input class=\"form-control\" type=text name='email' size=30>
          </div>
          
          <div class=\"form-group\">
            <label>No Telp/HP</label>
            <input class=\"form-control\" type=text name='no_telp' size=20 required>
          </div>

          <div class=\"form-group\">
            <label>Foto</label>
            <input class=\"form-control\" type=file name='fupload' size=40 required>
            <small>Tipe foto harus JPG/JPEG dan ukuran lebar maks: 400 px</small>
          </div>

          <div class=\"form-group\">
            <label>Blokir</label>
            <label><input type=radio name='blokir' value='Y' required> Y</label>
            <label><input type=radio name='blokir' value='N' checked> N </label>
          </div>

          <div class=\"form-group pull-right\">
          <input class='btn btn-danger' type=button value=Batal onclick=self.history.back()>
          <input class='btn btn-success' type=submit value=Simpan>
          </div>
          </fieldset></form>";
    }
    elseif ($_SESSION[leveluser]=='pengajar') {
       $tampil = mysqli_query($DBcon, "SELECT * FROM users WHERE id_users = '$_GET[id]'");
       
              echo " <div class=\"panel-body\">
            <div class=\"row\">
            <div class=\"col-lg-6\">
          <form method=POST action='$aksi?module=users&act=input_users' enctype='multipart/form-data'>
          <legend>Tambah Survey</legend>
          <div class=\"form-group\">
            <label>Nama Survey</label>
              <input class=\"form-control\" type='text' name='nama' required>
              </div>
          <div class=\"form-group\">
            <label>Pilihan 1</label>
              <input class=\"form-control\" type='text' name='pilihan1' required>
              </div>
          <div class=\"form-group\">
            <label>Pilihan 2</label>
              <input class=\"form-control\" type='text' name='pilihan2' required>
              </div>
          <div class=\"form-group\">
            <label>Pilihan 3</label>
              <input class=\"form-control\" type='text' name='pilihan3' required>
              </div>
          <div class=\"form-group\">
            <label>Pilihan 4</label>
              <input class=\"form-control\" type='text' name='pilihan4' required>
              </div>

          <div class=\"form-group pull-right\">
          <input class='btn btn-danger' type=button value=Batal onclick=self.history.back()>
          <input class='btn btn-success' type=submit value=Simpan>
          </div>
          </fieldset></form>";
    }
    break;

  case "NIK_ada":
     if ($_SESSION[leveluser]=='admin'){
         echo "<span class='judulhead'><p class='garisbawah'>NIK SUDAH PERNAH DIGUNAKAN<br>
               <input type=button value=Kembali onclick=self.history.back()></p></span>";
     }
     break;

  case "editsurvey":
    $edit=mysqli_query($DBcon, "SELECT * FROM users WHERE id_users='$_GET[id]'");
    $r=mysqli_fetch_array($edit);

    if ($_SESSION[leveluser]=='admin'){
    echo "<div class=\"panel-body\">
            <div class=\"row\">
            <div class=\"col-lg-6\">
            <form method='POST' action='$aksi?module=users&act=update_users' enctype='multipart/form-data'>
          <input type=hidden name=id value='$r[id_users]'>
          <legend>Edit User</legend>

          <div class=\"form-group\">
            <label>No Cek</label>
              <input type=text class='form-control' name=NIK value='$r[NIK]'>
          </div>

          <div class=\"form-group\">
            <label>Nama</label>
            <input class='form-control' type=text name='nama' value='$r[EmployeeName]' size=70>
          </div>

          <div class=\"form-group\">
            <label>Username Login</label>
            <input class='form-control' type=text name='username' value='$r[username_login]'>
          </div>

          <div class=\"form-group\">
            <label>Password Login</label>
            <input class='form-control' type=text name='password' size=30><small>Apabila password tidak diubah, dikosongkan saja</small>
          </div>

          <div class=\"form-group\">
            <label>PosTitle</label>
            <input class='form-control' type=text name='PosTitle' size=50 value='$r[PosTitle]'>
          </div>

          <div class=\"form-group\">
            <label>Alamat</label>
            <input class='form-control' type=text name='alamat' size=70 value='$r[alamat]'>
          </div>";

          if ($r[jenis_kelamin]=='L'){
             echo "
              <div class=\"form-group\">
                <label>Jenis Kelamin</label>
                  <div class=\"radio\">
                    <label>
                      <input type=radio name='jk' value='L' checked>Laki - Laki
                    </label>
                  </div>
                  <div class=\"radio\">
                    <label>
                      <input type=radio name='jk' value='P'>Perempuan
                    </label>
                  </div>
              </div>";
          }else{
              echo "<div class=\"form-group\">
                      <label>Jenis Kelamin</label>
                        <div class=\"radio\">
                          <label>
                            <input type=radio name='jk' value='L'>Laki - Laki
                          </label>
                        </div>
                        <div class=\"radio\">
                          <label>
                            <input type=radio name='jk' value='P' checked>Perempuan
                          </label>
                        </div>
                    </div>";
          }      
          echo "
          <div class=\"form-group\">
            <label>Email</label>
            <input class='form-control' type=text name='email' size=30 value='$r[email]'>
          </div>

          <div class=\"form-group\">
            <label>No Telp/HP</label>
            <input class='form-control' type=text name='no_telp' size=20 value='$r[no_telp]'>
          </div>

          <div class=\"form-group\">
            <label>Foto</label>: ";
            if (empty($r[foto])){
              echo "<a href='foto_users/medium_no-image.jpg' data-lightbox='image-1'>
                    <img class='img-responsive' src='foto_users/medium_no-image.jpg'>
                    </a>
          <div>";
          }else{
             echo "<a href='foto_users/medium_$r[foto]' data-lightbox='image-1'>
                    <img class='img-responsive' src='foto_users/medium_$r[foto]'>
                    </a>
          <div>";
          }
          echo "</div>

          <div class=\"form-group\">
            <label>Ganti Foto</label>
            <input type=file class='btn btn-default' name='fupload' size=40>
                <small>Tipe foto harus JPG/JPEG dan ukuran lebar maks: 400 px</small>
                <small>Apabila foto tidak diganti, dikosongkan saja</small></div>";
    if ($r[blokir]=='N'){
      echo "
          <div class=\"form-group\">
            <label>Blokir</label>
              <div class=\"radio\">
              <label><input type=radio name='blokir' value='Y'> Y</label>
              </div>
              <div class=\"radio\">
              <label><input type=radio name='blokir' value='N' checked> N </label>
              </div></div>";
    }
    else{
      echo "<div class=\"form-group\">
            <label>Blokir</label>
            <label><input type=radio name='blokir' value='Y' checked> Y</label>
            <label><input type=radio name='blokir' value='N'> N </label>
            </div>";
    }

    echo "
          <div class='pull-right'>
          <input class='btn btn-danger' type=button value=Batal onclick=self.history.back()>
          <input class='btn btn-success' type=submit value=Update>
          </div></form></div></div></div>";
    }elseif ($_SESSION[leveluser]=='pengajar') {
          echo "<div class=\"panel-body\">
            <div class=\"row\">
            <div class=\"col-lg-6\">
            <form method='POST' action='$aksi?module=users&act=update_users' enctype='multipart/form-data'>
          <input type=hidden name=id value='$r[id_users]'>
          <legend>Edit User</legend>

          <div class=\"form-group\">
            <label>No Cek</label>
              <input type=text class='form-control' name='NIK' value='$r[NIK]'>
          </div>

          <div class=\"form-group\">
            <label>Nama</label>
            <input class='form-control' type=text name='nama' value='$r[EmployeeName]' size=70>
          </div>

          <div class=\"form-group\">
            <label>Username Login</label>
            <input class='form-control' type=text name='username' value='$r[username_login]'>
          </div>

          <div class=\"form-group\">
            <label>Password Login</label>
            <input class='form-control' type=text name='password' size=30><small>Apabila password tidak diubah, dikosongkan saja</small>
          </div>

          <div class=\"form-group\">
            <label>PosTitle</label>
            <input class='form-control' type=text name='PosTitle' size=50 value='$r[PosTitle]'>
          </div>

          <div class=\"form-group\">
            <label>Unit</label>
            <input class='form-control' type=text name='Unit' size=50 value='$r[Unit]'>
          </div>

          <div class=\"form-group\">
            <label>Alamat</label>
            <input class='form-control' type=text name='alamat' size=70 value='$r[alamat]'>
          </div>";

          if ($r[jenis_kelamin]=='L'){
             echo "
              <div class=\"form-group\">
                <label>Jenis Kelamin</label>
                  <div class=\"radio\">
                    <label>
                      <input type=radio name='jk' value='L' checked>Laki - Laki
                    </label>
                  </div>
                  <div class=\"radio\">
                    <label>
                      <input type=radio name='jk' value='P'>Perempuan
                    </label>
                  </div>
              </div>";
          }else{
              echo "<div class=\"form-group\">
                      <label>Jenis Kelamin</label>
                        <div class=\"radio\">
                          <label>
                            <input type=radio name='jk' value='L'>Laki - Laki
                          </label>
                        </div>
                        <div class=\"radio\">
                          <label>
                            <input type=radio name='jk' value='P' checked>Perempuan
                          </label>
                        </div>
                    </div>";
          }      
          echo "
          <div class=\"form-group\">
            <label>Email</label>
            <input class='form-control' type=text name='email' size=30 value='$r[email]'>
          </div>

          <div class=\"form-group\">
            <label>No Telp/HP</label>
            <input class='form-control' type=text name='no_telp' size=20 value='$r[no_telp]'>
          </div>

          <div class=\"form-group\">
            <label>Foto</label>: ";
            if (empty($r[foto])){
              echo "<a data-lightbox='image-1' href='foto_users/medium_no-image.jpg'>
                    <img class='img-responsive' src='foto_users/medium_no-image.jpg'>
                    </a>
          <div>";
          }else{
             echo "<a data-lightbox='image-1' href='foto_users/medium_$r[foto]'>
                    <img class='img-responsive' src='foto_users/medium_$r[foto]'>
                    </a>
          <div>";
          }echo "</div>

          <div class=\"form-group\">
            <label>Ganti Foto</label>
            <input type=file class='btn btn-default' name='fupload' size=40>
                <small>Tipe foto harus JPG/JPEG dan ukuran lebar maks: 400 px</small>
                <small>Apabila foto tidak diganti, dikosongkan saja</small></div>";
    if ($r[blokir]=='N'){
      echo "
          <div class=\"form-group\">
            <label>Blokir</label>
              <div class=\"radio\">
              <label><input type=radio name='blokir' value='Y'> Y</label>
              </div>
              <div class=\"radio\">
              <label><input type=radio name='blokir' value='N' checked> N </label>
              </div></div>";
    }
    else{
      echo "<div class=\"form-group\">
            <label>Blokir</label>
            <label><input type=radio name='blokir' value='Y' checked> Y</label>
            <label><input type=radio name='blokir' value='N'> N </label>
            </div>";
    }

    echo "
          <div class='pull-right'>
          <input class='btn btn-danger' type=button value=Batal onclick=self.history.back()>
          <input class='btn btn-success' type=submit value=Update>
          </div></form></div></div></div>";
    }
    elseif ($_SESSION[leveluser]=='users') {
     echo"<br><b class='judul'>Edit Profil</b><br><p class='garisbawah'></p>";
     echo"<div class=\"panel-body\">
            <div class=\"row\">
            <div class=\"col-lg-6\">
            <form method='POST' action='$aksi_users?module=users&act=update_profil_users' enctype='multipart/form-data'>
          <input type='hidden' name='id' value='$r[id_users]'>

          <div class=\"form-group\">
            <label>No Cek</label>
            <input type=text class='form-control' name=NIK value='$r[NIK]' >
          </div>

          <div class=\"form-group\">
            <label>Nama</label>
            <input type=text name='nama' class='form-control' value='$r[EmployeeName]' size=40></td>
          </div>

          <div class=\"form-group\">
            <label>Alamat</label>
            <input class='form-control' type=text name='alamat' size=80 value='$r[alamat]'></td>
          ";
    echo "</div>";
          if ($r[jenis_kelamin]=='L'){
              echo "
          <div class=\"form-group\">
            <label>Jenis Kelamin</label>
              <div class=\"radio\">
              <label>
              <input type=radio name='jk' value='L' checked>Laki - Laki
              </label>
              </div>
              <div class=\"radio\">              
              <label>
              <input type=radio name='jk' value='P'>Perempuan
              </label></div></div>";
          }else{
              echo "
          <div class=\"form-group\">
            <label>Jenis Kelamin</label>
              <div class=\"radio\">
              <label>
                <input type=radio name='jk' value='L'>Laki - Laki
                </label>
                </div>
              <div class=\"radio\">     
              <label>           
                <input type=radio name='jk' value='P' checked>Perempuan
              </label>
                </div>
          </div>";
          }
          echo "
          <div class=\"form-group\">
            <label>E-Mail </label>
            <input type='email' class='form-control' name='email' size=30 value='$r[email]'>
          </div>

          <div class=\"form-group\">
            <label>No Telepon</label>
            <input type='number' class='form-control' name='no_telp' size=20 value='$r[no_telp]'>
          </div>

          <div class=\"form-group\">
            <label>Foto</label>";
          if (empty($r[foto])){
              echo "<a data-lightbox='image-1' href='foto_users/medium_no-image.jpg'>
                    <img class='img-responsive' src='foto_users/medium_no-image.jpg'>
                    </a>
          <div>";
          }else{
             echo "<a data-lightbox='image-1' href='foto_users/medium_$r[foto]'>
                    <img class='img-responsive' src='foto_users/medium_$r[foto]'>
                    </a>
          <div>";
          }echo "</div>
          
          <div class=\"form-group\">
            <label>Ganti Foto</label>
              <input type=file name='fupload' size=40>
                  <br>**) Tipe foto harus JPG/JPEG dan ukuran lebar maks: 400 px<br>
                       ***) Apabila foto tidak diganti, dikosongkan saja
          </div>";   

    echo "
          <div class=\"form-group\">
            <label>Jabatan</label>
              <input type='text' class='form-control' name='PosTitle' size=70 value='$r[PosTitle]' readonly>
          </div>
          <div class=\"form-group\">
            <label>Unit</label>
              <input type='text' class='form-control' name='PosTitle' size=70 value='$r[Unit]' readonly>
          </div>
          <div class='pull-right'>
          <input type='button' class='btn btn-danger' class='tombol' value='Batal' onclick=self.history.back()>
          <input type='submit' class='btn btn-success' class='tombol' value='Update'>
          </div>
          </form></div></div>";
    }
    break;

    
 case "detailuser":
    if ($_SESSION[leveluser]=='admin'){
       $detail=mysqli_query($DBcon, "SELECT * FROM users WHERE id_users='$_GET[id]'");
       $users=mysqli_fetch_array($detail);
       $tgl_lahir   = tgl_indo($users[tgl_lahir]);

       echo "
       <div class=\"row\">
          <div class=\"col-lg-6\">
            <div class=\"panel panel-default\">
                <div class=\"panel-heading\">
                  Detail User
                </div>
              <div class=\"panel-body\">
          <div class=\"table-responsive\">
              <table class=\"table table-hover\">
          <thead>
              <tr>
                <th>No Cek</th>
              </tr>
          </thead>
          <tbody>
            <td>$users[NIK]</td>
          </tbody>
          <thead>
              <tr>
                <th>Nama</th>
              </tr>
          </thead>
          <tbody>
            <td>$users[EmployeeName]</td>
          </tbody>
          <thead>
              <tr>
                <th>Username Login</th>
              </tr>
          </thead>
          <tbody>
            <td>$users[username_login]</td>
          </tbody>

          <thead>
              <tr>
                <th>Alamat</th>
              </tr>
          </thead>
          <tbody>
            <td>$users[alamat]</td>
          </tbody>

          <thead>
              <tr>
                <th>PosTitle</th>
              </tr>
          </thead>
          <tbody>
            <td>$users[PosTitle]</td>
          </tbody>";
          if ($users[jenis_kelamin]=='P'){
           echo "
          <thead>
              <tr>
                <th>Jenis Kelamin</th>
              </tr>
          </thead>
          <tbody>
            <td>Perempuan</td>
          </tbody>
           ";
            }
            else{
           echo "
          <thead>
              <tr>
                <th>Jenis Kelamin</th>
              </tr>
          </thead>
          <tbody>
            <td>Laki - Laki</td>
          </tbody>
           ";
            }echo"

          <thead>
              <tr>
                <th>E-Mail</th>
              </tr>
          </thead>
          <tbody>
            <td><a href=mailto:$users[email]>$users[email]</a></td>
          </tbody>
          <thead>
              <tr>
                <th>No Telepon/HP</th>
              </tr>
          </thead>
          <tbody>
            <td>$users[no_telp]</td>
          </tbody>

          <thead>
              <tr>
                <th>Blokir</th>
              </tr>
          </thead>
          <tbody>
            <td>$users[blokir]</td>
          </tbody>          

          <thead>
              <tr>
                <th>Foto</th>
              </tr>
          </thead>
          <tbody>
            <td>";
            if ($users[foto]!=''){
              echo "
              <img class='img-responsive' src='foto_users/medium_$users[foto]'>
              <a href='foto_users/medium_$users[foto]' rel='facebox'>View</a>
            </td>
          </tbody>";
          }
          echo "
          <thead class='pull-right'>
              <tr>
                <th><input class='btn btn-danger' type=button value=Kembali onclick=self.history.back()></th>
              </tr>
          </thead> 
          </table></div></div></div></div></div>";
    }
    elseif ($_SESSION[leveluser]=='pengajar'){
           $detail=mysqli_query($DBcon, "SELECT * FROM users WHERE id_users='$_GET[id]'");
       $users=mysqli_fetch_array($detail);
       $tgl_lahir   = tgl_indo($users[tgl_lahir]);

       echo "
       <div class=\"row\">
          <div class=\"col-lg-6\">
            <div class=\"panel panel-default\">
                <div class=\"panel-heading\">
                  Detail User
                </div>
              <div class=\"panel-body\">
          <div class=\"table-responsive\">
              <table class=\"table table-hover\">
          <thead>
              <tr>
                <th>No Cek</th>
              </tr>
          </thead>
          <tbody>
            <td>$users[NIK]</td>
          </tbody>
          <thead>
              <tr>
                <th>Nama</th>
              </tr>
          </thead>
          <tbody>
            <td>$users[EmployeeName]</td>
          </tbody>
          <thead>
              <tr>
                <th>Username Login</th>
              </tr>
          </thead>
          <tbody>
            <td>$users[username_login]</td>
          </tbody>

          <thead>
              <tr>
                <th>Alamat</th>
              </tr>
          </thead>
          <tbody>
            <td>$users[alamat]</td>
          </tbody>

          <thead>
              <tr>
                <th>PosTitle</th>
              </tr>
          </thead>
          <tbody>
            <td>$users[PosTitle]</td>
          </tbody>";
          if ($users[jenis_kelamin]=='P'){
           echo "
          <thead>
              <tr>
                <th>Jenis Kelamin</th>
              </tr>
          </thead>
          <tbody>
            <td>Perempuan</td>
          </tbody>
           ";
            }
            else{
           echo "
          <thead>
              <tr>
                <th>Jenis Kelamin</th>
              </tr>
          </thead>
          <tbody>
            <td>Laki - Laki</td>
          </tbody>
           ";
            }echo"

          <thead>
              <tr>
                <th>E-Mail</th>
              </tr>
          </thead>
          <tbody>
            <td><a href=mailto:$users[email]>$users[email]</a></td>
          </tbody>
          <thead>
              <tr>
                <th>No Telepon/HP</th>
              </tr>
          </thead>
          <tbody>
            <td>$users[no_telp]</td>
          </tbody>

          <thead>
              <tr>
                <th>Blokir</th>
              </tr>
          </thead>
          <tbody>
            <td>$users[blokir]</td>
          </tbody>          

          <thead>
              <tr>
                <th>Foto</th>
              </tr>
          </thead>
          <tbody>
            <td>";
            if ($users[foto]!=''){
              echo "
              <img class='img-responsive' src='foto_users/medium_$users[foto]'>
              <a href='foto_users/medium_$users[foto]' rel='facebox'>View</a>
            </td>
          </tbody>";
          }
          echo "
          <thead class='pull-right'>
              <tr>
                <th><input class='btn btn-danger' type=button value=Kembali onclick=self.history.back()></th>
              </tr>
          </thead> 
          </table></div></div></div></div></div>";
    }
    elseif ($_SESSION[leveluser]=='users'){
       $detail=mysqli_query($DBcon, "SELECT * FROM users WHERE id_users='$_GET[id]'");
       $users=mysqli_fetch_array($detail);
      echo"
      <h3>Detail User</h3>
       <table>
             <tr>
             <td rowspan='14'>";
             if ($users[foto]!=''){
              echo "<img src='foto_users/medium_$users[foto]'>";
          }
          echo "</td><td>No Cek</td>        <td> $users[NIK]</td></tr>
          <tr><td>Nama</td>               <td> $users[EmployeeName]</td></tr>  
          <tr><td>alamat</td>             <td> $users[alamat]</td></tr>
          <tr><td>Tempat Lahir</td> <td> $users[tempat_lahir]</td></tr>
          <tr><td>Tanggal Lahir</td><td> $tgl_lahir</td></tr>";
          if ($users[jenis_kelamin]=='P'){
           echo "<tr><td>Jenis Kelamin</td>     <td>  Perempuan</td></tr>";
            }
            else{
           echo "<tr><td>Jenis kelamin</td>     <td>  Laki - Laki </td></tr>";
            }echo"
          <tr><td>E-Mail</td>             <td> <a href=mailto:$users[email]>$users[email]</a></td></tr>
          <tr><td>No.Telp/Hp</td>         <td> $users[no_telp]</td></tr>
          <tr><Td>PosTitle</td>            <td> $users[PosTitle]</td></tr>";
          echo"<tr><td colspan='3'><input type=button class='tombol' value='Kembali'
          onclick=self.history.back()></td></tr></table>";

    }
    break;

case "detailprofilusers":
    if ($_SESSION[leveluser]=='users'){
       $detail=mysqli_query($DBcon, "SELECT * FROM users WHERE id_users='$_GET[id]'") or die (mysql_error());
       $users=mysqli_fetch_array($detail);

      echo"
      <h3>Detail $users[EmployeeName]</h3>
      <div class='text-center'>";
                     if (empty($users[foto])){
              echo "
            <a data-lightbox='image-1' href='foto_users/medium_no-image.jpg'>
                <img class='text-center img-circle' src='foto_users/medium_no-image.jpg'>
              </a>
          </div>";
          }else{
             echo "
            <a data-lightbox='image-1' href='foto_users/medium_$users[foto]'>
              <img class='text-center img-circle' src='foto_users/medium_$users[foto]'>
            </a>
          </div>
          ";
          }
      echo "
       <table width=\"100%\" class=\"table table-striped table-bordered table-hover\" id=\"dataTables-example\">
          
          <tr>
            <td>NIK</td>        
            <td>$users[NIK]</td>
          </tr>
          <tr>
            <td>Nama</td>
            <td> $users[EmployeeName]</td>
          </tr>
          <tr>
            <td>alamat</td>
            <td> $users[alamat]</td>
          </tr>";
          if ($users[jenis_kelamin]=='P'){
           echo "
          <tr>
            <td>Jenis Kelamin</td>
            <td>Perempuan</td>
          </tr>";
            }
            else{
           echo "
           <tr>
            <td>Jenis kelamin</td>
            <td>Laki - Laki </td>
          </tr>";
            }echo"
          <tr>
            <td>E-Mail</td>
            <td><a href=mailto:$users[email]>$users[email]</a>
            </td>
          </tr>
          <tr>
            <td>No.Telp/Hp</td>
            <td> $users[no_telp]</td>
          </tr>
          <tr>
            <td>Jabatan</td>
            <td> $users[PosTitle]</td>
          </tr>";
          echo"
          <tr>
            <td colspan='3'>
              <input type=button class=\"btn btn-primary pull-right\" value='Edit Profil' onclick=\"window.location.href='?module=users&act=editsurvey&id=$users[id_users]';\">
            </td>
          </tr>
        </table>";
    }
    break;

case "detailaccount":
    if ($_SESSION[leveluser]=='users'){
        $detail=mysqli_query($DBcon, "SELECT * FROM users WHERE id_users='$_GET[id]'");
        $users=mysqli_fetch_array($detail);
        echo"<form method=POST action=$aksi_users?module=users&act=update_account_users>";
        echo"<br><b class='judul'>Edit Account Login</b><br><p class='garisbawah'></p>
         <div class=\"panel-body col-md-6\">
          <div class=\"form-group\">
            <input class=\"form-control\" placeholder=\"Username\" name=\"username\" type=\"text\">
            </div>
            <div class=\"form-group\">
            <input class=\"form-control\" placeholder=\"Password\" name=\"password\" type=\"password\">
            </div>
          <p>Apabila Username tidak diubah di kosongkan saja.</p>
          <p>**) Apabila Password tidak diubah di kosongkan saja.</p>
          <p><input type=submit class='btn btn-primary' value='Update'></p>
        </div>";
    }
    break;
}
}
?>
