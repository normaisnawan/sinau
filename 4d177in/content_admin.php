        <div id="page-wrapper">
          <div class="container-fluid">
            
            <!-- /.row -->
            <script>
              function confirmdelete(delUrl) {
              if (confirm("Anda yakin ingin menghapus?")) {
              document.location = delUrl;
              }
              }
              </script>
              <?php

              // Bagian Home
              if ($_GET['module']=='home'){
                if ($_SESSION['leveluser']=='admin'){
                echo "<p>Hai <b>$_SESSION[namalengkap]</b>, Selamat datang di halaman Administrator E-learning PT Phapros.<br>
                        Silahkan klik menu pilihan yang berada di sebelah kiri untuk mengelola website.</p>";
                echo "<p align='right'>
                        <b class='judul'>Login : $hari_ini, 
                      <span id='date'></span>, <span id='clock'></span></p>";
                        ?>
            <div class="row">
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-home fa-5x"></i>
                                </div>
                            </div>
                        </div>
                        <a href="?module=home">
                            <div class="panel-footer">
                                <span class="pull-left">View Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-green">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-tasks fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge">12</div>
                                    <div>Manajemen Admin</div>
                                </div>
                            </div>
                        </div>
                        <a href="#">
                            <div class="panel-footer">
                                <span class="pull-left">View Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-yellow">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-shopping-cart fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge">124</div>
                                    <div>Manajemen SDM</div>
                                </div>
                            </div>
                        </div>
                        <a href="#">
                            <div class="panel-footer">
                                <span class="pull-left">View Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-red">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-support fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge">13</div>
                                    <div>Manajemen Pengguna</div>
                                </div>
                            </div>
                        </div>
                        <a href="#">
                            <div class="panel-footer">
                                <span class="pull-left">View Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-red">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-support fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge">13</div>
                                    <div>Modul</div>
                                </div>
                            </div>
                        </div>
                        <a href="#">
                            <div class="panel-footer">
                                <span class="pull-left">View Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-red">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-support fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge">13</div>
                                    <div>Materi</div>
                                </div>
                            </div>
                        </div>
                        <a href="#">
                            <div class="panel-footer">
                                <span class="pull-left">View Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-red">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-support fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge">13</div>
                                    <div>Post Test</div>
                                </div>
                            </div>
                        </div>
                        <a href="#">
                            <div class="panel-footer">
                                <span class="pull-left">View Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-red">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-support fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge">13</div>
                                    <div>Manajemen Pengguna</div>
                                </div>
                            </div>
                        </div>
                        <a href="#">
                            <div class="panel-footer">
                                <span class="pull-left">View Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
            <!-- /.row -->
        
 <?php
  
  }
  elseif ($_SESSION['leveluser']=='pengajar'){
  echo "<p>Hai <b>$_SESSION[namalengkap]</b>,  selamat datang di halaman Administrator.<br>
          Silahkan klik menu pilihan yang berada di sebelah kiri untuk mengelola website.</p><br>";

          echo "<p align=right>Login : $hari_ini,
                <span id='date'></span>, <span id='clock'></span></p>";
          //detail pengajar
          $detail_pengajar=mysqli_query($DBcon,"SELECT * FROM pengajar WHERE id_pengajar='$_SESSION[idpengajar]'");
          $p=mysqli_fetch_array($detail_pengajar);
          $tgl_lahir   = tgl_indo($p[tgl_lahir]);
          echo " 
              <legend>Detail Profil Anda</legend>
              <div class=\"table-responsive\">
              <table class=\"table table-hover\">
          
          <div  class='text-center'>";
          if ($p[foto]!=''){
              echo "
              <a data-lightbox='image-1' href='../foto_pengajar/$p[foto]'>
              <img class='img-circle'  height='250px' width='250px' src='../foto_pengajar/$p[foto]'></img></a>";
          }echo "
          </div>
          <tr><td>NIP</td> <td>$p[nip]</td><tr>
          <tr><td>Nama Lengkap</td> <td>$p[EmployeeName]</td></tr>
          <tr><td>Username</td>     <td><code>$p[username_login]</code></td></tr>
          <tr><td>Password</td>     <td><code>$p[password_login]</code></td></tr>";
          if ($p[jenis_kelamin]=='P'){
           echo "<tr><td>Jenis Kelamin</td>     <td> Perempuan</td></tr>";
            }
            else{
           echo "<tr><td>Jenis kelamin</td>     <td> Laki - Laki </td></tr>";
            }echo"
          <tr><td>E-mail</td>       <td>$p[email]</td></tr>
          <tr><td>PosTitle</td>      <td>$p[PosTitle]</td></tr>
          <tr><td>Aksi</td>         <td><input class='btn btn-primary' type=button value='Edit Profil' onclick=\"window.location.href='?module=admin&act=editpengajar';\"></td></tr>
          </table></div>";

  }
        else{
             echo "<h2>Home</h2>
          <p>Hai <b>$_SESSION[namalengkap]</b>, selamat datang di E-Learning.</p>
          <p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p>
          <p align=right>Login : $hari_ini, ";
  echo tgl_indo(date("Y m d"));
  echo " | ";
  echo date("H:i:s");
  echo " WIB</p>";
        }
}
// Bagian Modul
elseif ($_GET['module']=='modul'){
  if ($_SESSION['leveluser']=='admin'){
    include "modul/mod_modul/modul.php";
  }
}
// Bagian user admin
elseif ($_GET['module']=='admin'){
  if ($_SESSION['leveluser']=='admin'){
    include "modul/mod_admin/admin.php";
  }else{
      include "modul/mod_admin/admin.php";
  }
}

// Bagian user admin
elseif ($_GET['module']=='detailpengajar'){
  if ($_SESSION['leveluser']=='admin'){
    include "modul/mod_admin/admin.php";
  }else{
      include "modul/mod_admin/admin.php";
  }
}

// Bagian survey
elseif ($_GET['module']=='survey'){
  if ($_SESSION['leveluser']=='admin'){
    include "modul/mod_survey/survey.php";
  }
  elseif ($_SESSION['leveluser']=='pengajar'){
      include "modul/mod_survey/survey.php";
  }
  elseif ($_SESSION['leveluser']=='users'){
      include "modul/mod_survey/survey.php";
  }

}
// Bagian Acara
elseif ($_GET['module']=='acara'){
  if ($_SESSION['leveluser']=='admin'){
    include "modul/mod_acara/acara.php";
  }
  elseif ($_SESSION['leveluser']=='pengajar'){
      include "modul/mod_acara/acara.php";
  }
  elseif ($_SESSION['leveluser']=='users'){
      include "modul/mod_acara/acara.php";
  }

}

// Bagian iklan
elseif ($_GET['module']=='iklan'){
  if ($_SESSION['leveluser']=='admin'){
    include "modul/mod_iklan/iklan.php";
  }
  elseif ($_SESSION['leveluser']=='pengajar'){
      include "modul/mod_iklan/iklan.php";
  }
  elseif ($_SESSION['leveluser']=='users'){
      include "modul/mod_iklan/iklan.php";
  }

}


// Bagian rekap
elseif ($_GET['module']=='rekap'){
  if ($_SESSION['leveluser']=='admin'){
    include "modul/mod_rekap/rekap.php";
  }
  elseif ($_SESSION['leveluser']=='pengajar'){
      include "modul/mod_rekap/rekap.php";
  }
  elseif ($_SESSION['leveluser']=='users'){
      include "modul/mod_rekap/rekap.php";
  }

}


// Bagian TR Katalog
elseif ($_GET['module']=='trkatalog'){
  if ($_SESSION['leveluser']=='admin'){
    include "modul/mod_trkatalog/trkatalog.php";
  }
  elseif ($_SESSION['leveluser']=='pengajar'){
      include "modul/mod_trkatalog/trkatalog.php";
  }
  elseif ($_SESSION['leveluser']=='users'){
      include "modul/mod_trkatalog/trkatalog.php";
  }

}
// Bagian kelas
elseif ($_GET['module']=='pesan'){
  if ($_SESSION['leveluser']=='admin'){
    include "modul/mod_pesan/pesan.php";
  }
  elseif ($_SESSION['leveluser']=='pengajar'){
      include "modul/mod_pesan/pesan.php";
  }
  elseif ($_SESSION['leveluser']=='users'){
      include "modul/mod_pesan/pesan.php";
  }

}



// Bagian user
elseif ($_GET['module']=='users'){
  if ($_SESSION['leveluser']=='admin'){
    include "modul/mod_users/users.php";
  }elseif ($_SESSION['leveluser']=='pengajar'){
      include "modul/mod_users/users.php";
  }elseif($_SESSION['leveluser']=='users'){
      include "modul/mod_users/users.php";
  }
}

// Bagian users
elseif ($_GET['module']=='daftarusers'){
  if ($_SESSION['leveluser']=='admin'){
    include "modul/mod_users/users.php";
  }else{
      include "modul/mod_users/users.php";
  }
}

// Bagian users
elseif ($_GET['module']=='detailuser'){
  if ($_SESSION['leveluser']=='admin'){
    include "modul/mod_users/users.php";
  }else{
      include "modul/mod_users/users.php";
  }
}

// Bagian users
elseif ($_GET['module']=='detailuserspengajar'){
  if ($_SESSION['leveluser']=='admin'){
    include "modul/mod_users/users.php";
  }else{
      include "modul/mod_users/users.php";
  }
}

// Bagian materi
elseif ($_GET['module']=='materi'){
  if ($_SESSION['leveluser']=='admin'){
    include "modul/mod_materi/materi.php";
  }else{
      include "modul/mod_materi/materi.php";
  }
}

// Bagian topik soal
elseif ($_GET['module']=='quiz'){
  if ($_SESSION['leveluser']=='admin'){
    include "modul/mod_quiz/quiz.php";
  }else{
      include "modul/mod_quiz/quiz.php";
  }
}

// Bagian topik soal
elseif ($_GET['module']=='buatquiz'){
  if ($_SESSION['leveluser']=='admin'){
    include "modul/mod_quiz/quiz.php";
  }else{
      include "modul/mod_quiz/quiz.php";
  }
}

// Bagian topik soal
elseif ($_GET['module']=='buatquizesay'){
  if ($_SESSION['leveluser']=='admin'){
    include "modul/mod_quiz/quiz.php";
  }else{
      include "modul/mod_quiz/quiz.php";
  }
}

// Bagian topik soal
elseif ($_GET['module']=='buatquizpilganda'){
  if ($_SESSION['leveluser']=='admin'){
    include "modul/mod_quiz/quiz.php";
  }else{
      include "modul/mod_quiz/quiz.php";
  }
}

// Bagian topik soal
elseif ($_GET['module']=='daftarquiz'){
  if ($_SESSION['leveluser']=='admin'){
    include "modul/mod_quiz/quiz.php";
  }else{
      include "modul/mod_quiz/quiz.php";
  }
}

// Bagian topik soal
elseif ($_GET['module']=='daftarquizesay'){
  if ($_SESSION['leveluser']=='admin'){
    include "modul/mod_quiz/quiz.php";
  }else{
      include "modul/mod_quiz/quiz.php";
  }
}

// Bagian topik soal
elseif ($_GET['module']=='daftarquizpilganda'){
  if ($_SESSION['leveluser']=='admin'){
    include "modul/mod_quiz/quiz.php";
  }else{
      include "modul/mod_quiz/quiz.php";
  }
}

// Bagian Templates
else {
  echo "Modul tidak ada";
}
?>
              </div>
            </div>
            <!-- /.row -->
        </div>
        <!-- /#page-wrapper -->