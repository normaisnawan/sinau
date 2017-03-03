<?php
session_start();
error_reporting(0);

if (empty($_SESSION['username']) AND empty($_SESSION['passuser']) AND $_SESSION['login']==0){
    include 'peringatan.php';
}
else{
include "configurasi/library.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Grass Develop">

    <title>PT Phapros</title>

    <!-- Bootstrap Core CSS -->
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="assets/vendor/metisMenu/metisMenu.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="assets/dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- Morris Charts CSS -->
    <link href="assets/vendor/morrisjs/morris.css" rel="stylesheet">
    
    <!-- DataTables Responsive CSS -->
    <link href="assets/vendor/datatables-responsive/dataTables.responsive.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="assets/vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <style type="text/css">
        clock.style.display = 'block';
    </style>
    <script type="text/javascript">
       function startTimer(duration, display) {
        var start = Date.now(),
            diff,
            minutes,
            seconds;
        function timer() {
            // get the number of seconds that have elapsed since 
            // startTimer() was called
            diff = duration - (((Date.now() - start) / 1000) | 0);

            // does the same job as parseInt truncates the float
            minutes = (diff / 60) | 0;
            seconds = (diff % 60) | 0;

            minutes = minutes < 10 ? "0" + minutes : minutes;
            seconds = seconds < 10 ? "0" + seconds : seconds;

            display.textContent = minutes + ":" + seconds; 

            if (diff <= 0) {
                // add one second so that the count down starts at the full duration
                // example 05:00 not 04:59
                start = Date.now() + 1000;
            }
        };
        // we don't want to wait a full second before the timer starts
        timer();
        setInterval(timer, 1000);
    }

    window.onload = function () {
        var fiveMinutes = 60 * 10,
            display = document.querySelector('#time');
        startTimer(fiveMinutes, display);
    };
    </script>
</head>
<body onload="startclock()">

    <div id="wrapper">

        <!-- Navigation -->
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="home"><img src="images/phapros.png" height="25" width="120"></a>
            </div>
            <!-- /.navbar-header -->



            <!-- Awal Menu -->
            <div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">
                        <li>
                            <a href='#'>
                                <i class='glyphicon glyphicon-time'></i> Waktu Pengerjaan
                            </a>
                        </li>
                        <li>
                            <a href="#"><span id="time"></span> minutes!</a>
                        </li>
                    </ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- Akhir Menu -->
            <!-- /.navbar-static-side -->
        </nav>

        <!-- Awal Konten -->       
         <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <div class="page-header">
                    <p><script language=JavaScript>
                        var d = new Date();
                        var h = d.getHours();
                        if (h < 11) { document.write('Selamat pagi dan'); }
                        else { if (h < 15) { document.write('Selamat siang dan'); }
                        else { if (h < 19) { document.write('Selamat sore dan '); }
                        else { if (h <= 23) { document.write('Selamat malam dan '); }
                        }}}
                    </script> 
                    Selamat Mengerjakan <?php echo "$_SESSION[namalengkap]";?>
                     <?php
                    echo "<b class='pull-right'>Waktu: $hari_ini, 
                    <span id='date'></span>, <span id='clock'></span></b>";
                    ?></p>
                    </div>
                  
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
            <h3>Ini Soal</h3>
            <form action='nilai.php' method='post' id='formulir'>
            <?php
            include "configurasi/koneksi.php";
            $cek_siswa = mysqli_query($DBcon, "SELECT * FROM siswa_sudah_mengerjakan WHERE id_pelatihan='$_POST[id_pelatihan]' AND id_siswa='$_SESSION[idusers]'");
            $info_siswa = mysqli_fetch_array($cek_siswa);
            if ($info_siswa[hits]<= 0){
                mysqli_query($DBcon, "INSERT INTO siswa_sudah_mengerjakan (id_pelatihan,id_siswa,hits)
                                                    VALUES ('$_POST[id_pelatihan]','$_SESSION[idusers]',hits+1)");
            }
            elseif ($info_siswa[hits] > 0){
            }

            $soal = mysqli_query($DBcon, "SELECT * FROM quiz_pilganda where id_pelatihan='$_POST[id_pelatihan]' ORDER BY rand()");
            $pilganda = mysqli_num_rows($soal);
            $soal_esay = mysqli_query($DBcon, "SELECT * FROM quiz_esay WHERE id_pelatihan='$_POST[id_pelatihan]'");
            $esay = mysqli_num_rows($soal_esay);
            if (!empty($pilganda) AND !empty($esay)){
            echo "<br><b class='judul'>Daftar Soal Pilihan Ganda</b><br><p class='garisbawah'></p>
                <table width='100%' class='table table-striped table-bordered table-hover' id='dataTables-example'>
                <input type=hidden name='id_pelatihan' value='$_POST[id_pelatihan]'>";

            $no = 1;
            while($s = mysqli_fetch_array($soal)){
                if ($s[gambar]!=''){
                echo "<tr><td rowspan=6><h3>$no.</h3></td><td><h3>".$s['pertanyaan']."</h3></td></tr>";
                echo "<tr><td><img src='foto_soal_pilganda/medium_$s[gambar]'></td></tr>";    
                echo "<tr><td><input type=radio name=soal_pilganda[".$s['id_quiz']."] value='A'>A. ".$s['pil_a']."</td></tr>";
                echo "<tr><td><input type=radio name=soal_pilganda[".$s['id_quiz']."] value='B'>B. ".$s['pil_b']."</td></tr>";
                echo "<tr><td><input type=radio name=soal_pilganda[".$s['id_quiz']."] value='C'>C. ".$s['pil_c']."</td></tr>";
                echo "<tr><td><input type=radio name=soal_pilganda[".$s['id_quiz']."] value='D'>D. ".$s['pil_d']."</td></tr>";
                }else{
                    echo "<tr><td rowspan=5><h3>$no.</h3></td><td><h3>".$s['pertanyaan']."</h3></td></tr>";        
                    echo "<tr><td><input type=radio name=soal_pilganda[".$s['id_quiz']."] value='A'>A. ".$s['pil_a']."</td></tr>";
                    echo "<tr><td><input type=radio name=soal_pilganda[".$s['id_quiz']."] value='B'>B. ".$s['pil_b']."</td></tr>";
                    echo "<tr><td><input type=radio name=soal_pilganda[".$s['id_quiz']."] value='C'>C. ".$s['pil_c']."</td></tr>";
                    echo "<tr><td><input type=radio name=soal_pilganda[".$s['id_quiz']."] value='D'>D. ".$s['pil_d']."</td></tr>";
                }
                $no++;
            }
            echo "</table>";
            echo "<br><b class='judul'>Daftar Soal Essay</b><br><p class='garisbawah'></p>
                <table width='100%' class='table table-striped table-bordered table-hover' id='dataTables-example'>";
            $no2=1;
            while($e=  mysqli_fetch_array($soal_esay)){
                if (!empty($e[gambar])){
                echo "<tr><td rowspan=4><h3>$no2.</h3></td><td><h3>".$e['pertanyaan']."</h3></td></tr>";
                echo "<tr><td><img src='foto_soal/medium_$e[gambar]'></td></tr>";
                echo "<tr><td>Jawaban : </td></tr>";
                echo "<tr><td><textarea name=soal_esay[".$e['id_quiz']."] cols=95 rows=5></textarea></td></tr>";
                }else{
                    echo "<tr><td rowspan=3><h3>$no2.</h3></td><td><h3>".$e['pertanyaan']."</h3></td></tr>";
                    echo "<tr><td>Jawaban : </td></tr>";
                    echo "<tr><td><textarea name=soal_esay[".$e['id_quiz']."] cols=95 rows=5></textarea></td></tr>";
                }
                $no2++;
            }
            echo "</table>";
            $jumlahsoal = $no - 1;
            echo "<input type=hidden name=jumlahsoalpilganda value=$jumlahsoal>";
            }

            elseif (!empty($pilganda) AND empty($esay)){
                echo "<br><b class='judul'>Daftar Soal Pilihan Ganda</b><br><p class='garisbawah'></p>
                <table width='100%' class='table table-striped table-bordered table-hover' id='dataTables-example'>
                <input type=hidden name='id_pelatihan' value='$_POST[id_pelatihan]'>";

            $no = 1;
            while($s = mysqli_fetch_array($soal)){
                if ($s[gambar]!=''){
                echo "<tr><td rowspan=6><h3>$no.</h3></td><td><h3>".$s['pertanyaan']."</h3></td></tr>";
                echo "<tr><td><img src='foto_soal_pilganda/medium_$s[gambar]'></td></tr>";
                echo "<tr><td><input type=radio name=soal_pilganda[".$s['id_quiz']."] value='A'>A. ".$s['pil_a']."</td></tr>";
                echo "<tr><td><input type=radio name=soal_pilganda[".$s['id_quiz']."] value='B'>B. ".$s['pil_b']."</td></tr>";
                echo "<tr><td><input type=radio name=soal_pilganda[".$s['id_quiz']."] value='C'>C. ".$s['pil_c']."</td></tr>";
                echo "<tr><td><input type=radio name=soal_pilganda[".$s['id_quiz']."] value='D'>D. ".$s['pil_d']."</td></tr>";
                }else{
                    echo "<tr><td rowspan=5><h3>$no.</h3></td><td><h3>".$s['pertanyaan']."</h3></td></tr>";
                    echo "<tr><td><input type=radio name=soal_pilganda[".$s['id_quiz']."] value='A'>A. ".$s['pil_a']."</td></tr>";
                    echo "<tr><td><input type=radio name=soal_pilganda[".$s['id_quiz']."] value='B'>B. ".$s['pil_b']."</td></tr>";
                    echo "<tr><td><input type=radio name=soal_pilganda[".$s['id_quiz']."] value='C'>C. ".$s['pil_c']."</td></tr>";
                    echo "<tr><td><input type=radio name=soal_pilganda[".$s['id_quiz']."] value='D'>D. ".$s['pil_d']."</td></tr>";
                }
                $no++;
            }
            echo "</table>";
            $jumlahsoal = $no - 1;
            echo "<input type=hidden name=jumlahsoalpilganda value=$jumlahsoal>";
            }
            elseif (empty($pilganda) AND !empty($esay)){
                echo "<br><b class='judul'>Daftar Soal Essay</b><br><p class='garisbawah'></p>
                <table width='100%' class='table table-striped table-bordered table-hover' id='dataTables-example'><input type=hidden name=id_topik value='$_POST[id_pelatihan]'>";
            $no2=1;
            while($e=  mysqli_fetch_array($soal_esay)){
                if (!empty($e[gambar])){
                echo "<tr><td rowspan=4><h3>$no2.</h3></td><td><h3>".$e['pertanyaan']."</h3></td></tr>";
                echo "<tr><td><img src='foto_soal/medium_$e[gambar]'></td></tr>";
                echo "<tr><td>Jawaban : </td></tr>";
                echo "<tr><td><textarea name=soal_esay[".$e['id_quiz']."] cols=95 rows=10></textarea></td></tr>";
                }else{
                    echo "<tr><td rowspan=3><h3>$no2.</h3></td><td><h3>".$e['pertanyaan']."</h3></td></tr>";
                    echo "<tr><td>Jawaban : </td></tr>";
                    echo "<tr><td><textarea name=soal_esay[".$e['id_quiz']."] cols=95 rows=10></textarea></td></tr>";
                }
                $no2++;
            }
            echo "</table>";
            }
            elseif (empty($pilganda) AND empty($esay)){
                echo "<script>window.alert('Maaf belum ada soal di Topik Ini.');
                        window.location=(href='media.php?module=home')</script>";
            }
            ?>
            <br><p class='garisbawah'></p>
            <h3>Apakah anda sudah yakin dengan jawaban anda dan ingin menyimpannya?  
            <input type="submit" value="SIMPAN"></h3>
            </form>
            </div>
            <!-- /.row -->
        </div>
        <!-- /#page-wrapper -->

        <!-- Akhir Konten -->
    <!-- /#wrapper -->
    <!-- jQuery -->
    <script type="text/javascript" src="js/clock.js"></script>
    <script src="assets/vendor/jquery/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="assets/vendor/bootstrap/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="assets/vendor/metisMenu/metisMenu.min.js"></script>

    <!-- Morris Charts JavaScript -->
    <script src="assets/vendor/raphael/raphael.min.js"></script>
    <script src="assets/vendor/morrisjs/morris.min.js"></script>
    <script src="assets/data/morris-data.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="assets/dist/js/sb-admin-2.js"></script>
    <!-- DataTables JavaScript -->
    <script src="assets/vendor/datatables/js/jquery.dataTables.min.js"></script>
    <script src="assets/vendor/datatables-plugins/dataTables.bootstrap.min.js"></script>
    <script src="assets/vendor/datatables-responsive/dataTables.responsive.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="assets/dist/js/sb-admin-2.js"></script>

    <!-- Page-Level Demo Scripts - Tables - Use for reference -->
    <script>
    $(document).ready(function() {
        $('#dataTables-example').DataTable({
            responsive: true
        });
    });
    </script>
</body>
</html>
<?php
}
?>
