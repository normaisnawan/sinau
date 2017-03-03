<?php
session_start();
error_reporting(0);
include "timeout.php";

if($_SESSION[login]==1){
	if(!cek_login()){
		$_SESSION[login] = 0;
	}
}
if($_SESSION[login]==0){
  header('location:logout.php');
}
else{
if (empty($_SESSION['username']) AND empty($_SESSION['passuser']) AND $_SESSION['login']==0){
  echo "<link href=css/style.css rel=stylesheet type=text/css>";
  echo "<div class='error msg'>Untuk mengakses Modul anda harus login.</div>";
}
else{
    if ($_SESSION['leveluser']=='siswa'){
     echo "<link href=css/style.css rel=stylesheet type=text/css>";
     echo "<div class='error msg'>Anda tidak diperkenankan mengakses halaman ini.</div>";
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
    <meta name="author" content="">

    <title>PT. Phapros, Tbk.</title>


    <!-- Bootstrap CSS -->
    <link rel="stylesheet" type="text/css" href="assets/vendor/bootstrap/css/bootstrap.css" />

    <!-- MetisMenu CSS -->
    <link href="assets/vendor/metisMenu/metisMenu.min.css" rel="stylesheet">

    <!-- Select2 CSS-->
    <link href="../assets/vendor/select2/dist/css/select2.css" rel="stylesheet"> 

    <!-- Light Box CSS -->
    <link href="../assets/vendor/lightbox/css/lightbox.css" rel="stylesheet" />

    <!-- Datetime picker  -->
    <link href="../assets/vendor/bootstrap-datepicker/custom-datepicker.css" rel="stylesheet" type="text/css">

    <!-- Datetime picker  -->
    <link href="../assets/vendor/clockpicker/dist/bootstrap-clockpicker.css" rel="stylesheet" type="text/css">

    <link href="../assets/jquery-ui/jquery-ui.min.css" rel="stylesheet">

    <!-- DataTables Responsive CSS -->
    <link href="assets/vendor/datatables-responsive/dataTables.responsive.css" rel="stylesheet">

    <!-- Social Buttons CSS -->
    <link href="assets/vendor/bootstrap-social/bootstrap-social.css" rel="stylesheet">

    <!-- Fonts Awesome CSS -->
    <link href="assets/vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- Custom CSS  -->
    <link href="assets/dist/css/sb-admin-2.css" rel="stylesheet">


    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
    <?php
              include "../configurasi/koneksi.php";
              include "../configurasi/fungsi_tglwktindo.php";
              include "../configurasi/library.php";
              include "../configurasi/fungsi_indotgl.php";
              include "../configurasi/fungsi_combobox.php";
              include "../configurasi/class_paging.php";
              include "../configurasi/fungsi_thumb.php";
    ?>
<body onload="startclock()">

    <div id="wrapper">

        <!-- Navigation -->
        <nav class="navbar navbar-inverse  navbar-static-top" role="navigation" style="margin-bottom: 0; background: #a9c6e9;">
            <div class="navbar-header" >
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand"  href="media_admin.php?module=home">
                    <img src="../images/sinau-text-blue.png" height="40" style="margin-top:-10px;" width="50%">
                </a>
            </div>
            <!-- /.navbar-header -->

            <ul class="nav navbar-top-links navbar-right">
                <!-- /.dropdown -->
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-user fa-fw"></i> <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li class="divider"></li>
                        <li><a href="logout.php"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
                        </li>
                    </ul>
                    <!-- /.dropdown-user -->
                </li>
                <!-- /.dropdown -->
            </ul>
            <!-- /.navbar-top-links -->
                        <!-- Awal Menu -->
            <div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">
                    <?php include "menu.php"; ?>
                    </ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- Akhir Menu -->
            <!-- /.navbar-static-side -->
        </nav>

        <!-- Awal Konten -->
        <?php include "content_admin.php"; ?>

        <!-- Akhir Konten -->

        <!-- Akhir Konten -->
    <!-- /#wrapper -->

    <script type="text/javascript" src="../js/clock.js"></script>
    <!-- Bootstrap JavaScript -->
    <!-- jQuery -->
    <script type="text/javascript" src="../assets/vendor/jquery/jquery.js"></script>
    <script type="text/javascript" src="assets/vendor/bootstrap/js/bootstrap.min.js"></script>

     
	<script type="text/javascript" src="../assets/jquery-ui/jquery-ui.min.js"></script> 
	 <!-- Metis Menu Plugin JavaScript -->
    <script type="text/javascript" src="assets/vendor/metisMenu/metisMenu.min.js"></script>


    <script type="text/javascript" src="../assets/vendor/moment-master/moment.js"></script>

    <!-- Datepicker JavaScript -->
    <script type="text/javascript" src="../assets/vendor/bootstrap-datepicker/custom-datepicker.js"></script>

   <!--  UI Jquery -->
    <!-- <script type="text/javascript" src="../assets/vendor/jquery-ui/js/jquery-ui.js"></script> -->

   
    <!-- Validator JavaScript -->
    <script type="text/javascript" src="../assets//vendor/validator/form-validator/jquery.form-validator.js"></script>
  
    <script type="text/javascript" src="../assets//vendor/clockpicker/dist/bootstrap-clockpicker.js"></script>

    <script type="text/javascript" src="../assets//vendor/clockpicker/dist/jquery-clockpicker.js"></script>

    <script type="text/javascript" src="../assets//vendor/validator/form-validator/file.js"></script>

    <!--  Light Box JavaScript -->
    <script type="text/javascript" src="../assets/vendor/lightbox/js/lightbox.js"></script>
 
    <!-- DataTables JavaScript -->
    <script type="text/javascript" src="assets/vendor/datatables/js/jquery.dataTables.min.js"></script>

    <script type="text/javascript" src="assets/vendor/datatables-plugins/dataTables.bootstrap.min.js"></script>

    <script type="text/javascript" src="assets/vendor/datatables-responsive/dataTables.responsive.js"></script>

    <!-- Select2 JavaScript -->
    <script type="text/javascript" src="../assets/vendor/select2/dist/js/select2.js"></script> 

    <!-- TinyMCE JavaScript -->
 	<script type="text/javascript" src="../assets/vendor/tinymce/tinymce.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script type="text/javascript" src="assets/dist/js/sb-admin-2.js"></script>
  <script type="text/javascript">
  $(function() {
$(".js-example-basic-multiple").select2({
    allowClear:true,    
    maximumSelectionLength:100,
    placeholder: 'Silakan Pilih',
    tags: 'true',
    width:'100%'
});
});
$('#text-area').restrictLength($('#max-len'));
  $(function() {
    $(document).ready(function() {
        $('#dataTables-example').DataTable({
             "responsive": true,
        "aLengthMenu": [ 5, 10, 25, 50, 100 ],
           "sPaginationType": "full_numbers", 
         "oLanguage": {
            "sLengthMenu": "Tampilkan _MENU_ data",
            "sSearch": "Pencarian: ",
            "sZeroRecords": "Tidak ada data. ",
            "sInfo": "Data yang ada sesuai dengan database yang ada.",
            "sInfoEmpty": "Silakan membuat learning baru.",
            "sInfoFiltered": "Hello",
            "oPaginate": {
            "sFirst": "Awal",
            "sLast": "Akhir", 
            "sPrevious": "Balik", 
            "sNext": "Lanjut"
                }
          }
        });        
    });    
    $(document).ready(function() {
        $('#tableCustom').DataTable({
             "responsive": true,
        "aLengthMenu": [ 5, 10, 25, 50, 100 ],
           "sPaginationType": "full_numbers", 
         "oLanguage": {
            "sLengthMenu": "Tampilkan _MENU_ data",
            "sSearch": "Pencarian: ",
            "sZeroRecords": "Tidak ada data.",
            "sInfo": "Data yang ada sesuai dengan database yang ada.",
            "sInfoEmpty": "",
            "sInfoFiltered": "",
            "oPaginate": {
            "sFirst": "Awal",
            "sLast": "Akhir", 
            "sPrevious": "Balik", 
            "sNext": "Lanjut"
                }
          }
        });        
    });
});

   $.validate({
        modules : 'date, security'
    });

    $(function() {
        $('input[name="tanggalawal"]').daterangepicker({

        locale: {
          format: 'DD-MM-YYYY'
        },
            singleDatePicker: true,
            showDropdowns: true
        });

    });
    $(function() {
        $('input[name="tanggalakhir"]').daterangepicker({

        locale: {
          format: 'DD-MM-YYYY'
        },
            singleDatePicker: true,
            showDropdowns: true
        });

    });
	
	
    $('.clockpicker').clockpicker({
    placement: 'top',
    align: 'left',
    donetext: 'Done'
});
    $(function() {
        $('.tanggal').daterangepicker({

        locale: {
          format: 'DD-MM-YYYY'
        },
            singleDatePicker: true,
            showDropdowns: true
        });

    });

     $(function() {
            $( 'input[name="tglawal"]' ).datepicker({
                dateFormat: 'yy-mm-dd'
            });
     });

     $(function() {
            $( 'input[name="tglakhir"]' ).datepicker({
                dateFormat: 'yy-mm-dd'
            });
     });
 
    $(function() {
    tinymce.init({ 
        selector:'textarea',
        plugin:'wordcount',
        force_br_newlines : true,
        force_p_newlines : false,
        forced_root_block : ''

        });
});
$('#timepicker2').timepicker({
                minuteStep: 1,
                template: 'modal',
                appendWidgetTo: 'body',
                showSeconds: true,
                showMeridian: false,
                defaultTime: false
            });

$(function() {      
    // tooltip demo
    $('.tooltip-demo').tooltip({
        selector: "[data-toggle=tooltip]",
        container: "body"
    })
});

</script>
</body>
</html>
<?php
}
}
}
?>
