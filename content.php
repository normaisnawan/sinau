        <div id="page-wrapper">
            <div class="container-fluid">
              <div class="row">
                <div class="col-lg-12">
                    <div class="page-header">
                      <div class="row">
                        <p>
                        <script language=JavaScript>
                        var d = new Date();
                        var h = d.getHours();
                        if (h < 11) { document.write('Selamat pagi dan'); }
                        else { if (h < 15) { document.write('Selamat siang dan'); }
                        else { if (h < 19) { document.write('Selamat sore dan '); }
                        else { if (h <= 23) { document.write('Selamat malam dan '); }
                        }}}
                      </script> 
                     Selamat Datang <?php echo "$_SESSION[namalengkap]";?>
                      <?php
                      echo "
                      <b class='pull-right'>Waktu: $hari_ini, 
                      <span id='date'></span>, <span id='clock'></span></b>";
                      ?>
                      </p>
                      </div>

                    
            <!-- /.row -->
                    <!--Akhiri Berita Berjalan-->

                    <!--Mulai Modal Berita -->
                    <div class="modal fade" id="infoModal" role="dialog">
                      <div class="modal-dialog"> 

                      <div class="modal-content">
                          <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                      <?php
                       $tampil_iklan = mysqli_query($DBcon,"SELECT * FROM iklan where posisi='popup' ORDER BY idiklan limit 1");
                        //tampilkan seluruh data yang ada pada tabel user
                        
                        $data = mysqli_fetch_array($tampil_iklan);
                          echo '
                            <h4 class="modal-title">'.$data[juduliklan].'</h4>
                               </div>
                            <div class="modal-body">
                              <p>'.$data[isiiklan].'</p>
                            </div>
                            <div class="modal-footer">
                              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            </div>
                          </div>
                          ';
                         
                        ?>
                      </div>
                    </div>
                    <!--Akhir Modal Berita -->
              
          
                <?php
// Bagian Home
if ($_GET['module']=='home'){
  if ($_SESSION['leveluser']=='users'){
    include "4d177in/modul/mod_homenew/homenew.php";
  }
}

// Bagian users
elseif ($_GET['module']=='users'){
  if ($_SESSION['leveluser']=='users'){
      include "4d177in/modul/mod_users/users.php";
  }
}

// Bagian admin
elseif ($_GET['module']=='admin'){
  if ($_SESSION['leveluser']=='users'){
      include "4d177in/modul/mod_admin/admin.php";
  }
}
//Bagian Iklan
elseif ($_GET['module']=='admin'){
  if ($_SESSION['leveluser']=='users'){
      include "4d177in/modul/mod_admin/admin.php";
  }
}


// Bagian materi
elseif ($_GET['module']=='materi'){
  if ($_SESSION['leveluser']=='users'){
      include "4d177in/modul/mod_materi/materi.php";
  }
}

// Bagian materi
elseif ($_GET['module']=='quiz'){
  if ($_SESSION['leveluser']=='users'){
      include "4d177in/modul/mod_quiz/quiz.php";
  }
}

// Bagian materi
elseif ($_GET['module']=='kerjakan_quiz'){
  if ($_SESSION['leveluser']=='users'){
      include "4d177in/modul/mod_quiz/soal.php";
  }
}
elseif ($_GET['module']=='pesan'){
  if ($_SESSION['leveluser']=='users'){
      include "4d177in/modul/mod_pesan/pesan.php";
  }
}
elseif ($_GET['module']=='iklan'){
  if ($_SESSION['leveluser']=='users'){
      include "4d177in/modul/mod_iklan/iklan.php";
  }
}
// Bagian materi
elseif ($_GET['module']=='nilai'){
  if ($_SESSION['leveluser']=='users'){
      include "daftarnilai.php";
  }
}
?>
  </div>
            </div>
            <!-- /.row -->
        </div>
        <!-- /#page-wrapper -->