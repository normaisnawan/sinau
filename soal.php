<?php

include "configurasi/koneksi.php";
include "configurasi/library.php";
include "configurasi/fungsi_indotgl.php";
include "configurasi/fungsi_combobox.php";
include "configurasi/class_paging.php";

session_start();
error_reporting(0);
include "timeout.php";

if($_SESSION[login]==1){
    if(!cek_login()){
        $_SESSION[login] = 0;
    }
}
if($_SESSION[login]==0){
  include 'peringatan.php';
}
else{
if (empty($_SESSION['username']) AND empty($_SESSION['passuser']) AND $_SESSION['login']==0){
    include 'peringatan.php';
}
else{
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
    
    <style type="text/css">
    #qid {
      padding: 10px 15px;
      -moz-border-radius: 50px;
      -webkit-border-radius: 50px;
      border-radius: 20px;
    }
    .btn:focus,.btn:active{
    color: #fff;
    background-color: red;
    border-color: red;
    }
    label.btn {
        padding: 18px 60px;
        white-space: normal;
        -webkit-transform: scale(1.0);
        -moz-transform: scale(1.0);
        -o-transform: scale(1.0);
        -webkit-transition-duration: .3s;
        -moz-transition-duration: .3s;
        -o-transition-duration: .3s
    }

    label.btn:hover {
        text-shadow: 0 3px 2px rgba(0,0,0,0.4);
        -webkit-transform: scale(1.1);
        -moz-transform: scale(1.1);
        -o-transform: scale(1.1)
    }
    label.btn-block {
        text-align: left;
        position: relative;
        background-color: grey;
        border-color: grey;

    }

    label .btn-label {
        position: absolute;
        left: 0;
        top: 0;
        display: inline-block;
        padding: 0 10px;
        background: rgba(0,0,0,.15);
        height: 100%
    }

    label .glyphicon {
        top: 34%
    }

    .element-animation1 {
        animation: animationFrames ease .8s;
        animation-iteration-count: 1;
        transform-origin: 50% 50%;
        -webkit-animation: animationFrames ease .8s;
        -webkit-animation-iteration-count: 1;
        -webkit-transform-origin: 50% 50%;
        -ms-animation: animationFrames ease .8s;
        -ms-animation-iteration-count: 1;
        -ms-transform-origin: 50% 50%
    }
    .element-animation2 {
        animation: animationFrames ease 1s;
        animation-iteration-count: 1;
        transform-origin: 50% 50%;
        -webkit-animation: animationFrames ease 1s;
        -webkit-animation-iteration-count: 1;
        -webkit-transform-origin: 50% 50%;
        -ms-animation: animationFrames ease 1s;
        -ms-animation-iteration-count: 1;
        -ms-transform-origin: 50% 50%
    }
    .element-animation3 {
        animation: animationFrames ease 1.2s;
        animation-iteration-count: 1;
        transform-origin: 50% 50%;
        -webkit-animation: animationFrames ease 1.2s;
        -webkit-animation-iteration-count: 1;
        -webkit-transform-origin: 50% 50%;
        -ms-animation: animationFrames ease 1.2s;
        -ms-animation-iteration-count: 1;
        -ms-transform-origin: 50% 50%
    }
    .element-animation4 {
        animation: animationFrames ease 1.4s;
        animation-iteration-count: 1;
        transform-origin: 50% 50%;
        -webkit-animation: animationFrames ease 1.4s;
        -webkit-animation-iteration-count: 1;
        -webkit-transform-origin: 50% 50%;
        -ms-animation: animationFrames ease 1.4s;
        -ms-animation-iteration-count: 1;
        -ms-transform-origin: 50% 50%
    }
    @keyframes animationFrames {
        0% {
            opacity: 0;
            transform: translate(-1500px,0px)
        }

        60% {
            opacity: 1;
            transform: translate(30px,0px)
        }

        80% {
            transform: translate(-10px,0px)
        }

        100% {
            opacity: 1;
            transform: translate(0px,0px)
        }
    }

    @-webkit-keyframes animationFrames {
        0% {
            opacity: 0;
            -webkit-transform: translate(-1500px,0px)
        }
        60% {
            opacity: 1;
            -webkit-transform: translate(30px,0px)
        }

        80% {
            -webkit-transform: translate(-10px,0px)
        }

        100% {
            opacity: 1;
            -webkit-transform: translate(0px,0px)
        }
    }

    @-ms-keyframes animationFrames {
        0% {
            opacity: 0;
            -ms-transform: translate(-1500px,0px)
        }

        60% {
            opacity: 1;
            -ms-transform: translate(30px,0px)
        }
        80% {
            -ms-transform: translate(-10px,0px)
        }

        100% {
            opacity: 1;
            -ms-transform: translate(0px,0px)
        }
    }

    .modal-header {
        background-color: transparent;
        color: inherit
    }

    .modal-body {
        min-height: 205px
    }
    #loadbar {
        position: absolute;
        width: 62px;
        height: 77px;
        top: 2em
    }
    .blockG {
        position: absolute;
        background-color: #FFF;
        width: 10px;
        height: 24px;
        -moz-border-radius: 8px 8px 0 0;
        -moz-transform: scale(0.4);
        -moz-animation-name: fadeG;
        -moz-animation-duration: .8800000000000001s;
        -moz-animation-iteration-count: infinite;
        -moz-animation-direction: linear;
        -webkit-border-radius: 8px 8px 0 0;
        -webkit-transform: scale(0.4);
        -webkit-animation-name: fadeG;
        -webkit-animation-duration: .8800000000000001s;
        -webkit-animation-iteration-count: infinite;
        -webkit-animation-direction: linear;
        -ms-border-radius: 8px 8px 0 0;
        -ms-transform: scale(0.4);
        -ms-animation-name: fadeG;
        -ms-animation-duration: .8800000000000001s;
        -ms-animation-iteration-count: infinite;
        -ms-animation-direction: linear;
        -o-border-radius: 8px 8px 0 0;
        -o-transform: scale(0.4);
        -o-animation-name: fadeG;
        -o-animation-duration: .8800000000000001s;
        -o-animation-iteration-count: infinite;
        -o-animation-direction: linear;
        border-radius: 8px 8px 0 0;
        transform: scale(0.4);
        animation-name: fadeG;
        animation-duration: .8800000000000001s;
        animation-iteration-count: infinite;
        animation-direction: linear
    }
    #rotateG_01 {
        left: 0;
        top: 28px;
        -moz-animation-delay: .33s;
        -moz-transform: rotate(-90deg);
        -webkit-animation-delay: .33s;
        -webkit-transform: rotate(-90deg);
        -ms-animation-delay: .33s;
        -ms-transform: rotate(-90deg);
        -o-animation-delay: .33s;
        -o-transform: rotate(-90deg);
        animation-delay: .33s;
        transform: rotate(-90deg)
    }
    #rotateG_02 {
        left: 8px;
        top: 10px;
        -moz-animation-delay: .44000000000000006s;
        -moz-transform: rotate(-45deg);
        -webkit-animation-delay: .44000000000000006s;
        -webkit-transform: rotate(-45deg);
        -ms-animation-delay: .44000000000000006s;
        -ms-transform: rotate(-45deg);
        -o-animation-delay: .44000000000000006s;
        -o-transform: rotate(-45deg);
        animation-delay: .44000000000000006s;
        transform: rotate(-45deg)
    }
    #rotateG_03 {
        left: 26px;
        top: 3px;
        -moz-animation-delay: .55s;
        -moz-transform: rotate(0deg);
        -webkit-animation-delay: .55s;
        -webkit-transform: rotate(0deg);
        -ms-animation-delay: .55s;
        -ms-transform: rotate(0deg);
        -o-animation-delay: .55s;
        -o-transform: rotate(0deg);
        animation-delay: .55s;
        transform: rotate(0deg)
    }
    #rotateG_04 {
        right: 8px;
        top: 10px;
        -moz-animation-delay: .66s;
        -moz-transform: rotate(45deg);
        -webkit-animation-delay: .66s;
        -webkit-transform: rotate(45deg);
        -ms-animation-delay: .66s;
        -ms-transform: rotate(45deg);
        -o-animation-delay: .66s;
        -o-transform: rotate(45deg);
        animation-delay: .66s;
        transform: rotate(45deg)
    }
    #rotateG_05 {
        right: 0;
        top: 28px;
        -moz-animation-delay: .7700000000000001s;
        -moz-transform: rotate(90deg);
        -webkit-animation-delay: .7700000000000001s;
        -webkit-transform: rotate(90deg);
        -ms-animation-delay: .7700000000000001s;
        -ms-transform: rotate(90deg);
        -o-animation-delay: .7700000000000001s;
        -o-transform: rotate(90deg);
        animation-delay: .7700000000000001s;
        transform: rotate(90deg)
    }
    #rotateG_06 {
        right: 8px;
        bottom: 7px;
        -moz-animation-delay: .8800000000000001s;
        -moz-transform: rotate(135deg);
        -webkit-animation-delay: .8800000000000001s;
        -webkit-transform: rotate(135deg);
        -ms-animation-delay: .8800000000000001s;
        -ms-transform: rotate(135deg);
        -o-animation-delay: .8800000000000001s;
        -o-transform: rotate(135deg);
        animation-delay: .8800000000000001s;
        transform: rotate(135deg)
    }
    #rotateG_07 {
        bottom: 0;
        left: 26px;
        -moz-animation-delay: .99s;
        -moz-transform: rotate(180deg);
        -webkit-animation-delay: .99s;
        -webkit-transform: rotate(180deg);
        -ms-animation-delay: .99s;
        -ms-transform: rotate(180deg);
        -o-animation-delay: .99s;
        -o-transform: rotate(180deg);
        animation-delay: .99s;
        transform: rotate(180deg)
    }
    #rotateG_08 {
        left: 8px;
        bottom: 7px;
        -moz-animation-delay: 1.1s;
        -moz-transform: rotate(-135deg);
        -webkit-animation-delay: 1.1s;
        -webkit-transform: rotate(-135deg);
        -ms-animation-delay: 1.1s;
        -ms-transform: rotate(-135deg);
        -o-animation-delay: 1.1s;
        -o-transform: rotate(-135deg);
        animation-delay: 1.1s;
        transform: rotate(-135deg)
    }
    @-moz-keyframes fadeG {
        0% {
            background-color: #000
        }

        100% {
            background-color: #FFF
        }
    }

    @-webkit-keyframes fadeG {
        0% {
            background-color: #000
        }

        100% {
            background-color: #FFF
        }
    }

    @-ms-keyframes fadeG {
        0% {
            background-color: #000
        }

        100% {
            background-color: #FFF
        }
    }

    @-o-keyframes fadeG {
        0% {
            background-color: #000
        }
        100% {
            background-color: #FFF
        }
    }

    @keyframes fadeG {
        0% {
            background-color: #000
        }

        100% {
            background-color: #FFF
        }
    }
    #footer {
      position: fixed;
      width: 100%;
      bottom: 0px;
      background: #FFFFFF;
      height: 10%;
    }

    </style>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body onload="init(),noBack();" onpageshow="if (event.persisted) noBack();" onunload="keluar()">
    <div id="wrapper">
        <!-- Navigation -->
        <nav class="navbar navbar-default navbar-fixed-top" role="navigation" style="margin-bottom: 0;background: black;"> 
            <div class="navbar-header">
                <a class="navbar-brand" href="home">

                    <img src="images/Heading.png" height="40" style="margin-top:-10px;" width="40%">
                </a>
            </div>
            <!-- /.navbar-header -->
            <ul class="nav navbar-top-links navbar-right">
                <!-- /.dropdown -->
                    <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-clock-o fa-2x "></i>
                            <span id=divwaktu></span>
                    </a>
                    <!-- /.dropdown-messages -->
                </li>
            </ul>
            <!-- /.navbar-top-links -->
        </nav>
          
        <div class="col-lg-12">
            <div class="page-header">
                <div class="row">
                    <form action='nilai.php' method='post' id='formulir'>
<?php
include "configurasi/koneksi.php";
$cek_users = mysqli_query($DBcon, "SELECT * FROM users_sudah_mengerjakan WHERE id_pelatihan='$_POST[id_pelatihan]' AND id_users='$_SESSION[idusers]'");
$info_siswa = mysqli_fetch_array($cek_users);
if ($info_siswa[hits]<= 0){
    mysqli_query($DBcon, "INSERT INTO users_sudah_mengerjakan (id_pelatihan,id_users,hits)
        VALUES ('$_POST[id_pelatihan]','$_SESSION[idusers]',hits+1)");
}
elseif ($info_siswa[hits] > 0){
}

$soal = mysqli_query($DBcon, "SELECT * FROM quiz_pilganda where id_pelatihan='$_POST[id_pelatihan]' ORDER BY rand()");
$pilganda = mysqli_num_rows($soal);
$soal_esay = mysqli_query($DBcon, "SELECT * FROM quiz_esay WHERE id_pelatihan='$_POST[id_pelatihan]'");
$esay = mysqli_num_rows($soal_esay);
if (!empty($pilganda) AND !empty($esay)){
echo "<input type=hidden name=id_pelatihan value='$_POST[id_pelatihan]'>";

$no = 1;
while($s = mysqli_fetch_array($soal)){
    if ($s[gambar]!=''){
     echo " <div class='col-lg-12'>
            <div class='page-header'>
                <div class='row'>
                    <div class='container-fluid bg-info'>
                        <div class='modal-dialog'>
                          <div class='modal-content'>
                             <div class='modal-header'>
            <h5><span class='label label-warning'>Pertanyan Nomor ".$no."</span> <br>
            </h5>
            <h3>".$s['pertanyaan']."</h3> 
            </div>
            <div class='modal-body'>
            <div class='quiz' id='quiz' data-toggle='buttons'>";
    echo "<center><label class='element-animation2'><img class='img-rounded text-center' src='foto_soal_pilganda/medium_$s[gambar]'></label></center>";
      echo "<label class='element-animation1 btn btn-lg btn-primary btn-block'><span class='btn-label'><i class='glyphicon glyphicon-chevron-right'></i></span> <input type=radio name=soal_pilganda[".$s['id_quiz']."] value='A' required>A. ".$s['pil_a']."</label>";
        echo "<label class='element-animation1 btn btn-lg btn-primary btn-block'><span class='btn-label'><i class='glyphicon glyphicon-chevron-right'></i></span> <input type=radio name=soal_pilganda[".$s['id_quiz']."] value='B' required>B. ".$s['pil_b']."</label>";
        echo "<label class='element-animation1 btn btn-lg btn-primary btn-block'><span class='btn-label'><i class='glyphicon glyphicon-chevron-right'></i></span> <input type=radio name=soal_pilganda[".$s['id_quiz']."] value='C' required>C. ".$s['pil_c']."</label>";
        echo "<label class='element-animation1 btn btn-lg btn-primary btn-block'><span class='btn-label'><i class='glyphicon glyphicon-chevron-right'></i></span> <input type=radio name=soal_pilganda[".$s['id_quiz']."] value='D' required>D. ".$s['pil_d']."</label></div>
                    </div>
                    </div>
                    </div>
                </div>
            </div>
        </div";
    }else{
        echo " <div class='col-lg-12'>
            <div class='page-header'>
                <div class='row'>
                    <div class='container-fluid bg-info'>
                        <div class='modal-dialog'>
                          <div class='modal-content'>
                             <div class='modal-header'>
            <h5><span class='label label-warning'>Pertanyan Nomor ".$no."</span> <br>
            </h5>
            <h3>".$s['pertanyaan']."</h3>
            </div>
            <div class='modal-body'>
            <div class='quiz' id='quiz' data-toggle='buttons'>";
        echo "<label class='element-animation1 btn btn-lg btn-primary btn-block'><span class='btn-label'><i class='glyphicon glyphicon-chevron-right'></i></span> <input type=radio name=soal_pilganda[".$s['id_quiz']."] value='A' required>A. ".$s['pil_a']."</label>";
        echo "<label class='element-animation1 btn btn-lg btn-primary btn-block'><span class='btn-label'><i class='glyphicon glyphicon-chevron-right'></i></span> <input type=radio name=soal_pilganda[".$s['id_quiz']."] value='B' required>B. ".$s['pil_b']."</label>";
        echo "<label class='element-animation1 btn btn-lg btn-primary btn-block'><span class='btn-label'><i class='glyphicon glyphicon-chevron-right'></i></span> <input type=radio name=soal_pilganda[".$s['id_quiz']."] value='C' required>C. ".$s['pil_c']."</label>";
        echo "<label class='element-animation1 btn btn-lg btn-primary btn-block'><span class='btn-label'><i class='glyphicon glyphicon-chevron-right'></i></span> <input type=radio name=soal_pilganda[".$s['id_quiz']."] value='D' required>D. ".$s['pil_d']."</label></div>
                    </div>
                    </div>
                    </div>
                </div>
            </div>
        </div";

    }
    $no++;
};
$no2=1;
while($e=  mysqli_fetch_array($soal_esay)){
    if (!empty($e[gambar])){
        echo " <div class='col-lg-12'>
            <div class='page-header'>
                <div class='row'>
                    <div class='container-fluid bg-info'>
                        <div class='modal-dialog'>
                          <div class='modal-content'>
                             <div class='modal-header'>
            <h5><span class='label label-warning'>Pertanyan Nomor ".$no."</span> <br>
            </h5>
            <h3>".$e['pertanyaan']."</h3> 
            </div>
            <div class='modal-body'>
            <div class='quiz' id='quiz' data-toggle='buttons'>";
    echo "<center><label class='element-animation2'><img class='img-rounded text-center' src='foto_soal/medium_$e[gambar]'></label></center>";
    echo "<center><img class='img-rounded text-center'  src='foto_soal/medium_$e[gambar]'></center>";
    echo "<label>Jawaban </label>";
    echo "<textarea name=soal_esay[".$e['id_quiz']."] cols=95 rows=5></textarea></div>
                    </div>
                    </div>
                    </div>
                </div>
            </div>
        </div";
    }else{
       echo " <div class='col-lg-12'>
            <div class='page-header'>
                <div class='row'>
                    <div class='container-fluid bg-info'>
                        <div class='modal-dialog'>
                          <div class='modal-content'>
                             <div class='modal-header'>
            <h5><span class='label label-warning'>Pertanyan Nomor ".$no."</span> <br>
            </h5>
            <h3>".$e['pertanyaan']."</h3> 
            </div>
            <div class='modal-body'>
            <div class='quiz' id='quiz' data-toggle='buttons'>";
    echo "Jawaban : ";
    echo "<textarea name=soal_esay[".$e['id_quiz']."] class='form-control' rows=5></textarea></div>
                    </div>
                    </div>
                    </div>
                </div>
            </div>
        </div";
    }
    $no2++;
};
$jumlahsoal = $no - 1;
echo "<input type=hidden name=jumlahsoalpilganda value=$jumlahsoal>";
}

elseif (!empty($pilganda) AND empty($esay)){
    echo "
    <input type=hidden name=id_pelatihan value='$_POST[id_pelatihan]'>";

$no = 1;
while($s = mysqli_fetch_array($soal)){
    if ($s[gambar]!=''){
    echo " <div class='col-lg-12'>
            <div class='page-header'>
                <div class='row'>
                    <div class='container-fluid bg-info'>
                        <div class='modal-dialog'>
                          <div class='modal-content'>
                             <div class='modal-header'>
            <h5><span class='label label-warning'>Pertanyan Nomor ".$no."</span> <br>
            </h5>
            <h3>".$s['pertanyaan']."</h3> 
            </div>
            <div class='modal-body'>
            <div class='quiz' id='quiz' data-toggle='buttons'>";
    echo "<center><label class='element-animation2'><img class='img-rounded text-center' src='foto_soal_pilganda/medium_$s[gambar]'></label></center>";
      echo "<label class='element-animation1 btn btn-lg btn-primary btn-block'><span class='btn-label'><i class='glyphicon glyphicon-chevron-right'></i></span> <input type=radio name=soal_pilganda[".$s['id_quiz']."] value='A' required>A. ".$s['pil_a']."</label>";
        echo "<label class='element-animation1 btn btn-lg btn-primary btn-block'><span class='btn-label'><i class='glyphicon glyphicon-chevron-right'></i></span> <input type=radio name=soal_pilganda[".$s['id_quiz']."] value='B' required>B. ".$s['pil_b']."</label>";
        echo "<label class='element-animation1 btn btn-lg btn-primary btn-block'><span class='btn-label'><i class='glyphicon glyphicon-chevron-right'></i></span> <input type=radio name=soal_pilganda[".$s['id_quiz']."] value='C' required>C. ".$s['pil_c']."</label>";
        echo "<label class='element-animation1 btn btn-lg btn-primary btn-block'><span class='btn-label'><i class='glyphicon glyphicon-chevron-right'></i></span> <input type=radio name=soal_pilganda[".$s['id_quiz']."] value='D' required>D. ".$s['pil_d']."</label></div>
                    </div>
                    </div>
                    </div>
                </div>
            </div>
        </div";
    }else{
        echo " <div class='col-lg-12'>
            <div class='page-header'>
                <div class='row'>
                    <div class='container-fluid bg-info'>
                        <div class='modal-dialog'>
                          <div class='modal-content'>
                             <div class='modal-header'>
            <h5><span class='label label-warning'>Pertanyan Nomor ".$no."</span> <br>
            </h5>
            <h3>".$s['pertanyaan']."</h3>
            </div>
            <div class='modal-body'>
            <div class='quiz' id='quiz' data-toggle='buttons'>";
        echo "<label class='element-animation1 btn btn-lg btn-primary btn-block'><span class='btn-label'><i class='glyphicon glyphicon-chevron-right'></i></span> <input type=radio name=soal_pilganda[".$s['id_quiz']."] value='A' required>A. ".$s['pil_a']."</label>";
        echo "<label class='element-animation1 btn btn-lg btn-primary btn-block'><span class='btn-label'><i class='glyphicon glyphicon-chevron-right'></i></span> <input type=radio name=soal_pilganda[".$s['id_quiz']."] value='B' required>B. ".$s['pil_b']."</label>";
        echo "<label class='element-animation1 btn btn-lg btn-primary btn-block'><span class='btn-label'><i class='glyphicon glyphicon-chevron-right'></i></span> <input type=radio name=soal_pilganda[".$s['id_quiz']."] value='C' required>C. ".$s['pil_c']."</label>";
        echo "<label class='element-animation1 btn btn-lg btn-primary btn-block'><span class='btn-label'><i class='glyphicon glyphicon-chevron-right'></i></span> <input type=radio name=soal_pilganda[".$s['id_quiz']."] value='D' required>D. ".$s['pil_d']."</label></div>
                    </div>
                    </div>
                    </div>
                </div>
            </div>
        </div";

    }
    $no++;
};
$jumlahsoal = $no - 1;
echo " ><input type=hidden name=jumlahsoalpilganda value=$jumlahsoal>";
}
elseif (empty($pilganda) AND !empty($esay)){
    echo "<br><b class='judul'>Daftar Soal Essay</b><br><p class='garisbawah'></p>
    <table><input type=hidden name=id_pelatihan value='$_POST[id_pelatihan]'>";
$no2=1;
while($e=  mysqli_fetch_array($soal_esay)){
    if (!empty($e[gambar])){
    echo "<tr><td rowspan=4><h3>$no2.</h3></td><td><h3>".$e['pertanyaan']."</h3>";
    echo "<img src='foto_soal/medium_$e[gambar]'>";
    echo "Jawaban : ";
    echo "<textarea name=soal_esay[".$e['id_quiz']."] cols=95 rows=10></textarea>";
    }else{
        echo "<tr><td rowspan=3><h3>$no2.</h3></td><td><h3>".$e['pertanyaan']."</h3>";
        echo "Jawaban : ";
        echo "<textarea name=soal_esay[".$e['id_quiz']."] cols=95 rows=10></textarea>";
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
            <div id="footer" class="panel-footer text-muted">
                <h6>Apakah anda sudah yakin dengan jawaban anda dan ingin menyimpannya?
                <input type='button' class="btn btn-primary btn-sm" onclick="tombol()" value="Ya">   
                        <span id="tombol"></span>
                </h6>
                
            </form>     
            </div>
                    </div>
                    </div>
                    </div>
                </div>
            </div>
        </div>
            <!-- /.row -->

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

    <!-- Page-Level Demo Scripts - Tables - Use for reference -->
<script>
<?php
  $sql1 = "SELECT * FROM pelatihan WHERE id_pelatihan = '$_POST[id_pelatihan]'"; 
  $sql_result1 = mysqli_query($DBcon, $sql1); 
  $rows1=mysqli_fetch_array($sql_result1);
  echo "
  var waktunya=$rows1[lama];";
?>
    var waktu;
    var jalan = 0;
    var habis = 0;
    function init(){
        checkCookie()
        mulai();
    }
    function keluar(){
        if(habis==0){
            setCookie('waktux',waktu,365);
        }else{
            setCookie('waktux',0,-1);
        }
    }
    function mulai(){
        jam = Math.floor(waktu/3600);
        sisa = waktu%3600;
        menit = Math.floor(sisa/60);
        sisa2 = sisa%60
        detik = sisa2%60;
        if(detik<10){
            detikx = "0"+detik;
        }else{
            detikx = detik;
        }
        if(menit<10){
            menitx = "0"+menit;
        }else{
            menitx = menit;
        }
        if(jam<10){
            jamx = "0"+jam;
        }else{
            jamx = jam;
        }
        document.getElementById("divwaktu").innerHTML = jamx+" H : "+menitx+" M : "+detikx +" S";
        waktu --;
        if(waktu>0){
            t = setTimeout("mulai()",1000);
            jalan = 1;
        }else{
            if(jalan==1){
                clearTimeout(t);
            }
            habis = 1;
            document.getElementById("formulir").submit();
        }
    }
    function selesai(){    
        if(jalan==1){
                clearTimeout(t);
            }
            habis = 1;
        document.getElementById("formulir").submit();
    }
    function getCookie(c_name){
        if (document.cookie.length>0){
            c_start=document.cookie.indexOf(c_name + "=");
            if (c_start!=-1){
                c_start=c_start + c_name.length+1;
                c_end=document.cookie.indexOf(";",c_start);
                if (c_end==-1) c_end=document.cookie.length;
                return unescape(document.cookie.substring(c_start,c_end));
            }
        }
        return "";
    }

    function setCookie(c_name,value,expiredays){
        var exdate=new Date();
        exdate.setDate(exdate.getDate()+expiredays);
        document.cookie=c_name+ "=" +escape(value)+((expiredays==null) ? "" : ";expires="+exdate.toGMTString());
    }

    function checkCookie(){
        waktuy=getCookie('waktux');
        if (waktuy!=null && waktuy!=""){
            waktu = waktuy;
        }else{
            waktu = waktunya;
            setCookie('waktux',waktunya,7);
        }
    }
    window.history.forward();
    function noBack(){ window.history.forward(); }
    function tombol()
    {
        alert('Apakah anda sudah benar-benar yakin dengan jawaban anda?. Jika yakin silakan klik tombol OK lalu klik tombol simpan yang berada dibagian bawah.')
    document.getElementById("tombol").innerHTML= "<input type='button' value='Simpan' class='btn btn-success' onclick=selesai()>";
    }
</script>
</body>
</html>
<?php
}
}
?>
