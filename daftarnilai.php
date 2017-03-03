            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Lihat Nilai
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
<?php
include "configurasi/koneksi.php";
session_start();

if (empty($_SESSION['username']) AND empty($_SESSION['passuser']) AND $_SESSION['login']==0){
     include 'peringatan.php';
}
else{
        $users = mysqli_query($DBcon, "SELECT * FROM users WHERE id_users = '$_SESSION[idusers]'");
        $data_users = mysqli_fetch_array($users);
        $mapel = mysqli_query($DBcon, "SELECT * FROM pendaftaran WHERE NIK = '$data_users[NIK]'");
        $cek_mapel = mysqli_num_rows($mapel);
        if (!empty($cek_mapel)){
            echo"<table width=\"100%\" class=\"table table-striped table-bordered table-hover\" id=\"dataTables-example\">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Pelatihan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>";
            $no=1;
            while ($t=mysqli_fetch_array($mapel)){
                echo "<tr>
                <td>$no</td>
                <td>$t[nama_acara]</td>
                            <td>
                            <input type=button class=\"btn btn-default\" value='Lihat Nilai'onclick=\"window.location.href='?module=quiz&act=nilaiusers';\">
                            </td>
                       </tr>
                    ";
            $no++;
            }
            echo"</tbody></table>";
         }else{
            echo "<script>window.alert('Belum ada Post Test yang Anda ikuti.');
                    window.location=(href='media.php?module=home')</script>";
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