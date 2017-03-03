
<?php
session_start();
 if (empty($_SESSION['username']) AND empty($_SESSION['passuser'])){
  echo "<link href=../css/style.css rel=stylesheet type=text/css>";
  echo "<div class='error msg'>Untuk mengakses Modul anda harus login.</div>";
}
else{

$aksi="modul/mod_admin/aksi_admin.php";
switch($_GET[act]){
  // Tampil User
  default:
    if ($_SESSION[leveluser]=='admin'){
      $tampil_admin = mysqli_query($DBcon, "SELECT * FROM admin ORDER BY username");      
      echo "<h2>Manajemen Administrator</h2><hr>
          <input class='button blue' type=button value='Tambah Administrator' onclick=\"window.location.href='?module=admin&act=tambahadmin';\">";
          echo "<br><br><div class='information msg'>Account administrator tidak bisa di hapus, tapi bisa di non aktifkan.</div>";
          echo "<br><table  id='table1' class='gtable sortable'><thead>
          <tr><th>No</th><th>Username</th><th>Nama</th><th>Alamat</th><th>Email</th><th>Telp/HP</th><th>Blokir</th><th>Aksi</th></tr></thead>";
    $no=1;
    while ($r=mysqli_fetch_array($tampil_admin)){
       echo "<tr><td>$no</td>
             <td>$r[username]</td>
             <td>$r[EmployeeName]</td>
             <td>$r[alamat]</td>
		         <td><a href=mailto:$r[email]>$r[email]</a></td>
		         <td>$r[no_telp]</td>
		         <td align=center>$r[blokir]</td>
             <td><a href='?module=admin&act=editadmin&id=$r[id_session]' title='Edit'><img src='images/icons/edit.png' alt='Edit' /></a></td></tr>";
      $no++;
    }
    echo "</table>";
    }
    else{
      echo "<link href=../css/style.css rel=stylesheet type=text/css>";
      echo "<div class='error msg'>Anda tidak berhak mengakses halaman ini.</div>";
    }
    break;

  case "pengajar":
  if ($_SESSION[leveluser]=='admin'){
      $tampil_pengajar = mysqli_query($DBcon, "SELECT * FROM pengajar ORDER BY username_login");
    echo "<h2>Manajemen Pengajar</h2><hr>
          <input class='button blue' type=button value='Tambah Pengajar' onclick=\"window.location.href='?module=admin&act=tambahpengajar';\">";
          echo "<br><br><table id='table1' class='gtable sortable'><thead>
          <tr><th>No</th><th>Nip</th><th>Username</th><th>Nama</th><th>Blokir</th><th>Aksi</th></tr></thead>";
    $no=1;
    while ($r=mysqli_fetch_array($tampil_pengajar)){
       echo "<tr><td>$no</td>
             <td>$r[nip]</td>
             <td>$r[username_login]</td>
             <td>$r[EmployeeName]</td>             
		         <td align=center>$r[blokir]</td>
             <td><a href='?module=admin&act=editpengajar&id=$r[id_pengajar]' title='Edit'><img src='images/icons/edit.png' alt='Edit' /></a> |
                 <a href=?module=detailpengajar&act=detailpengajar&id=$r[id_pengajar]>Detail</a></td></tr>";
      $no++;
    }
    echo "</table>";
  }else{
        echo "<link href=../css/style.css rel=stylesheet type=text/css>";
        echo "<div class='error msg'>Anda tidak berhak mengakses halaman ini.</div>";
  }
  break;

  case "tambahadmin":
    if ($_SESSION[leveluser]=='admin'){
    echo "<form class='uniform' method=POST action='$aksi?module=admin&act=input_admin'>
          <fieldset>
          <legend>Tambah Administrator</legend>
          
          <label>Username</label>     <input type=text name='username'>
          <label>Password</label>     <input type=text name='password'>
          <label>Nama</label> <input type=text name='EmployeeName' size=30>
          <label>Alamat</label>        <input type=text name='alamat' size=70>
          <label>E-mail</label>       <input type=text name='email' size=30>
          <label>No.Telp/HP</label>   <input type=text name='no_telp' size=20>
          <label>Blokir</label>       <input type=radio name='blokir' value='Y'> Y
                                           <input type=radio name='blokir' value='N' checked> N 
          
          <div class='buttons'>
          <input class='button blue' type=submit value=Simpan>
          <input class='button blue' type=button value=Batal onclick=self.history.back()>
          </div>
          </fieldset></form>";
    }
    else{
      echo "<link href=../css/style.css rel=stylesheet type=text/css>";
      echo "<div class='error msg'>Anda tidak berhak mengakses halaman ini.</div>";
    }
     break;

  case "tambahpengajar":
    if ($_SESSION[leveluser]=='admin'){
    echo "<form method=POST action='$aksi?module=admin&act=input_pengajar' enctype='multipart/form-data'>
          <fieldset>
          <legend>Tambah Penajar</legend>
          
          <label>Nip</label>          <input type=text name='nip'>
          <label>Nama Lengkap</label>    <input type=text name='EmployeeName' size=30>
          <label>Username</label>     <input type=text name='username'>
          <label>Password</label>     <input type=text name='password'>
          <label>Alamat</label>      <input type=text name='alamat' size=70>
          <label>Tempat lahir</label>      <input type=text name='tempat_lahir' size=50>
          <label>Tanggal Lahir</label>";
          combotgl(1,31,'tgl',$tgl_skrg);
          combonamabln(1,12,'bln',$bln_sekarang);
          combothn(1950,$thn_sekarang,'thn',$thn_sekarang);
          echo "";
    echo "
          <label>Jenis Kelamin</label> <label><input type=radio name='jk' value=L>Laki-laki</input></label>
                                             <label><input type=radio name='jk' value=P>Perempuan</input></label>
          <label>Agama</label>        <select name='agama' id='select1' class='medium required' size='1'>
                                                           <option value='0' selected>-- Pilih --</option>
                                                           <option value='Islam'>Islam</option>
                                                           <option value='Kristen'>Kristen</option>
                                                           <option value='Katolik'>Katolik</option>
                                                           <option value='Hindu'>Hindu</option>
                                                           <option value='Buddha'>Buddha</option>
                                                           </select>
          <label>Telp/HP</label>   <input type=text name='no_telp' size=20>
          <label>E-mail</label>       <input type=text name='email' size=30>
          <label>Website</label>      <input type=text name='website' size=30 value='http://'>
          <label>Foto</label>      <input type='file' name='fupload' id='upload'>
                                                      <small>Tipe foto harus JPG/JPEG dan ukuran lebar maks: 400 px</small>
          <label>PosTitle</label>      <input type=text name='PosTitle' size=30>
          <label>Blokir</label>       <label><input type=radio name='blokir' value='Y'> Y</label>
                                                      <label><input type=radio name='blokir' value='N' checked> N </label>
          
          
          <div class='buttons'>
          <input class='button blue' type=submit value=Simpan>
          <input class='button blue' type=button value=Batal onclick=self.history.back()>
          </div>
          </fieldset></form>";
    }
    else{
      echo "<link href=../css/style.css rel=stylesheet type=text/css>";
      echo "<div class='error msg'>Anda tidak berhak mengakses halaman ini.</div>";
    }
     break;

  case "editadmin":
    $edit=mysqli_query($DBcon, "SELECT * FROM admin WHERE id_session='$_GET[id]'");
    $r=mysqli_fetch_array($edit);

    if ($_SESSION[leveluser]=='admin'){
    echo "<form method=POST action=$aksi?module=admin&act=update_admin>
          <input type=hidden name=id value='$r[id_session]'>
          <fieldset>
          <legend>Edit Administrator</legend>
          
          <label>Username</label>     <input type=text name='username' value='$r[username]'>
          <label>Password</label>     <input type=text name='password'>
                                                      <small>Apabila password tidak diubah, dikosongkan saja.</small>
                                               
          <label>Nama</label> <input type=text name='EmployeeName' size=30  value='$r[EmployeeName]'>
          <label>Alamat</label>       <input type=text name='alamat' size=70  value='$r[alamat]'>
          <label>E-mail</label>       <input type=text name='email' size=30 value='$r[email]'>
          <label>No.Telp/HP</label>   <input type=text name='no_telp' size=30 value='$r[no_telp]'>";

    if ($r[blokir]=='N'){
      echo "<label>Blokir</label>     <input type=radio name='blokir' value='Y'> Y
                                                      <input type=radio name='blokir' value='N' checked> N ";
    }
    else{
       echo "<label>Blokir</label>     <input type=radio name='blokir' value='Y' checked> Y
                                                       <input type=radio name='blokir' value='N'> N ";
    }
    
    echo "
          <div class='buttons'>
          <input class='button blue' type=submit value=Update>
          <input class='button blue' type=button value=Batal onclick=self.history.back()>
          </div>
          </fieldset></form>";
    }
    else{
      echo "<link href=../css/style.css rel=stylesheet type=text/css>";
      echo "<div class='error msg'>Anda tidak berhak mengakses halaman ini.</div>";
    }
    break;

 case "editpengajar":
    $edit=mysqli_query($DBcon, "SELECT * FROM pengajar WHERE id_pengajar='$_GET[id]'");
    $r=mysqli_fetch_array($edit);

    if ($_SESSION[leveluser]=='admin'){
      echo "Hello!!!";
    }
    elseif ($_SESSION[leveluser]=='pengajar'){
        $edit=mysqli_query($DBcon, "SELECT * FROM pengajar WHERE id_pengajar='$_SESSION[idpengajar]'");
        $r=mysqli_fetch_array($edit);
     echo "
     <div class='panel-body'>
        <div class='row'>
          <div class='col-lg-6'>
          <form method='POST' action='$aksi?module=admin&act=update_pengajar2' enctype='multipart/form-data'>
          <input type='hidden' name='id' value='$r[id_pengajar]'> 

          <legend>Edit Profil</legend>
          <div class='form-group'>
            <label>No Cek</label>
              <input type=text name='nip' class='form-control' value='$r[nip]'>
          </div>
          <div class='form-group'>
          <label>Nama Lengkap</label>
          <input type=text name='EmployeeName' class='form-control' size=30 value='$r[EmployeeName]'>
          </div>
          
          <div class='form-group'>
          <label>Username </label>
          <input type=text name='username' class='form-control' value='$r[username_login]'>
          </div>
          
          <div class='form-group'>
          <label>Password </label>
          <input type=text name='password' class='form-control'>
          <p><strong>Apabila password tidak diubah, dikosongkan saja</strong></p>
          </div>

          <div class='form-group'>
          <label>Alamat </label>
          <input type=text name='alamat' size=70 class='form-control' value='$r[alamat]'>
          </div>";

          if ($r[jenis_kelamin]=='L'){
              echo "
          <div class='form-group'>
            <label>Jenis Kelamin</label>
              <div class='radio'>
                <label>
                  <input type=radio name='jk' value='L' checked>Laki - Laki
                </label>
              </div>
              <div class='radio'>
                <label>
                  <input type=radio name='jk' value='P'>Perempuan
                </label>
              </div>
          </div>";
          }else{
              echo "
          <div class='form-group'>
            <label>Jenis Kelamin</label>
              <div class='radio'>
                <label>
                  <input type=radio name='jk' value='L' >Laki - Laki
                </label>
              </div>
              <div class='radio'>
                <label>
                  <input type=radio name='jk' value='P' checked>Perempuan
                </label>
              </div>
          </div>";
          }
     echo"
        
          <div class='form-group'>
            <label>E-mail</label>
              <input type=text class='form-control' name='email' size=30 value='$r[email]'>
          </div>
          <div class='form-group'>
            <label>Foto</label>";
            if ($r[foto]!=''){
              echo "
              <a data-lightbox='image-1' href='../foto_pengajar/$r[foto]'>
                <img class='img-responsive' src='../foto_pengajar/$r[foto]'>
              </a>
          ";
                }echo "<div>
          <div class='form-group'>
            <label>Jabatan</label>         
            <input type='text' name='PosTitle' value='$r[PosTitle]' class='form-control' readonly>
          </div>
          <div class='form-group'>
            <label>Ganti Foto</label>
              <input type=file name='fupload' size=40>
                <small>Tipe foto harus JPG/JPEG dan ukuran lebar maks: 400 px</small>
                <small>Apabila foto tidak diubah, dikosongkan saja</small>
            </div>
           <input class='btn btn-danger' type=button value=Batal onclick=self.history.back()>
          <input class='pull-right btn btn-success ' type=submit value=Update>
          </form>
          </div>
          </div>
          </div>";
    }
    break;

case "detailpengajar":
    $detail=mysqli_query($DBcon, "SELECT * FROM pengajar WHERE id_pengajar='$_GET[id]'");
    $r=mysqli_fetch_array($detail);
    $tgl_lahir   = tgl_indo($r[tgl_lahir]);

    if ($_SESSION[leveluser]=='admin'){
    echo "<form><fieldset>
          <legend>Detail Pengajar</legend>
          
          <label>Nip</label>   $r[nip]
          <label>Nama Lengkap</label> $r[EmployeeName]
          <label>Username</label>     $r[username_login]
          <label>Alamat</label>       $r[alamat]
          <label>Tempat Lahir</label> $r[tempat_lahir]
          <label>Tanggal Lahir</label>$tgl_lahir";
          if ($r[jenis_kelamin]=='P'){
           echo "<label>Jenis Kelamin</label>      Perempuan";
            }
            else{
           echo "<label>Jenis kelamin</label>      Laki - Laki ";
            }echo"
          <label>Agama</label>       $r[agama]
          <label>No.Telp/HP</label>   $r[no_telp]
          <label>E-mail</label>       <a href=mailto:$r[email]>$r[email]</a>
          <label>Website</label>      <a href=http://$r[website] target=_blank>$r[website]</a>
          <label>PosTitle</label>     $r[PosTitle]";
          if ($r[blokir]=='N'){
           echo "<label>Blokir</label>      N ";
            }
            else{
           echo "<label>Blokir</label>      Y ";
            }
          echo "<label>Foto</label>   :
          <ul class='photos sortable'>
                    <li>";if ($r[foto]!=''){
              echo "
                    <a href='../foto_pengajar/medium_$r[foto]' data-lightbox='image-1'><img src='../foto_pengajar/medium_$r[foto]'></a>
              <div>
              </li>
              </ul>";
          }
          echo "
          <div class='buttons'>
          <input class='button blue' type=button value=Kembali onclick=self.history.back()>
          </div>
          </fieldset></form>";
          
    }
    elseif ($_SESSION[leveluser]=='pengajar'){
        echo "<form><fieldset>
          <legend>Detail Pengajar</legend>
          
          <table id='table1' class='gtable sortable'>
          <tr><td rowspan='13'>";if ($r[foto]!=''){
              echo "<ul class='photos sortable'>
                    <li><a href='../foto_pengajar/medium_$r[foto]' data-lightbox='image-1'>
                    <img src='../foto_pengajar/medium_$r[foto]'>
                    </a>
                    <div>
                    </li>
                    </ul>";
          }echo "</td><td>Nip</td>  <td>$r[nip]</td><tr>
          <tr><td>Nama Lengkap</td> <td>$r[EmployeeName]</td></tr>          
          <tr><td>Alamat</td>       <td>$r[alamat]</td></tr>
          <tr><td>Tempat Lahir</td> <td>$r[tempat_lahir]</td></tr>
          <tr><td>Tanggal Lahir</td><td>$tgl_lahir</td></tr>";
          if ($r[jenis_kelamin]=='P'){
           echo "<tr><td>Jenis Kelamin</td>     <td> Perempuan</td></tr>";
            }
            else{
           echo "<tr><td>Jenis kelamin</td>     <td> Laki - Laki </td></tr>";
            }echo"
          <tr><td>Agama</td>        <td>$r[agama]</td></tr>
          <tr><td>No.Telp/HP</td>   <td>$r[no_telp]</td></tr>
          <tr><td>E-mail</td>       <td><a href=mailto:$r[email]>$r[email]</a></td></tr>
          <tr><td>Website</td>      <td><a href=http://$r[website] target=_blank>$r[website]</a></td></tr>
          <tr><td>PosTitle</td>      <td>$r[PosTitle]</td></tr>
          <tr><td>Aksi</td>         <td><input class='button small white' type=button value=Kembali onclick=self.history.back()></td></tr>";
           echo"</table></fieldset</form>";
    }else{
        echo"<br><b class='judul'>Detail Guru</b><br><p class='garisbawah'></p>";
        echo "<table>
          <tr><td rowspan='12'>";if ($r[foto]!=''){
              echo "<img src='foto_pengajar/medium_$r[foto]'>";
          }echo "</td><td>Nip</td>  <td>$r[nip]</td><tr>
          <tr><td>Nama Lengkap</td> <td>$r[EmployeeName]</td></tr>          
          <tr><td>Alamat</td>       <td>$r[alamat]</td></tr>
          <tr><td>Tempat Lahir</td> <td>$r[tempat_lahir]</td></tr>
          <tr><td>Tanggal Lahir</td><td>$tgl_lahir</td></tr>";
          if ($r[jenis_kelamin]=='P'){
           echo "<tr><td>Jenis Kelamin</td>     <td> Perempuan</td></tr>";
            }
            else{
           echo "<tr><td>Jenis kelamin</td>     <td> Laki - Laki </td></tr>";
            }echo"
          <tr><td>Agama</td>        <td>$r[agama]</td></tr>
          <tr><td>No.Telp/HP</td>   <td>$r[no_telp]</td></tr>
          <tr><td>E-mail</td>       <td><a href=mailto:$r[email]>$r[email]</a></td></tr>
          <tr><td>Website</td>      <td><a href=http://$r[website] target=_blank>$r[website]</a></td></tr>
          <tr><td>PosTitle</td>      <td>$r[PosTitle]</td></tr>
          <tr><td colspan='3'><input type=button class='btn btn-danger' value='Kembali'
                              onclick=self.history.back()></td></tr></table>";
    }
    break;
}
}
?>
