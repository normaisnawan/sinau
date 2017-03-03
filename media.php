<?php
include "configurasi/is_function.php";
include "configurasi/koneksi.php";
include "configurasi/library.php";
include "configurasi/fungsi_indotgl.php";

session_start();
error_reporting(0);
include "timeout.php";

if($_SESSION['login']==1){
    if(!cek_login()){
        $_SESSION['login'] = 0;
    }
}
if($_SESSION['login']==0){
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

    <title>PT. Phapros, Tbk.</title>

    <!-- Bootstrap Core CSS -->
    <link href="assets/vendor/bootstrap/css/bootstrap.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="assets/vendor/metisMenu/metisMenu.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="assets/vendor/lightbox/css/lightbox.css" rel="stylesheet" />

    <link href="assets/dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- Morris Charts CSS -->
    <link href="assets/vendor/morrisjs/morris.css" rel="stylesheet">
    
    <!-- DataTables Responsive CSS -->
    <link href="assets/vendor/datatables-responsive/dataTables.responsive.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="assets/vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
       
    <link rel="stylesheet" href="./assets/vendor/plyr-master/dist/plyr.css">

    <link rel="stylesheet" href="./assets/vendor/plyr-master/dist/demo.css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
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
                <a class="navbar-brand"  href="home">
                    <img src="images/sinau-text-blue.png" height="40" style="margin-top:-10px;" width="50%">
                </a>
            </div>
            <!-- /.navbar-header -->

            <ul class="nav navbar-top-links navbar-right">

                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-user fa-fw" style="color:  #fff;"></i> <i style="color:  #fff;" class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-tasks">
                        <li><a href='media.php?module=users&act=detailprofilusers&id=<?php echo $_SESSION[idusers] ?>'><i class="fa fa-user fa-fw"></i> Profil Users</a>
                        </li> </li>
                        <li><a href="logout.php"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
                        </li>
                    </ul>
                    <!-- /.dropdown-tasks -->
                </li>
                <!--/. akhiri dropdown pengguna -->
            </ul>
            <!-- /.navbar-top-links -->


            <!-- Awal Menu -->
            <div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">
                    <?php include "menu.php"; ?>
                    <?php include "menu2.php"; ?>
                    </ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- Akhir Menu -->
            <!-- /.navbar-static-side -->
        </nav>

        <!-- Awal Konten -->
        <?php include "content.php"; ?>

        <!-- Akhir Konten -->
    <!-- /#wrapper -->

    <!-- jQuery -->
    <script type="text/javascript" src="js/clock.js"></script>
    <script src="assets/vendor/jquery/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="assets/vendor/bootstrap/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="assets/vendor/metisMenu/metisMenu.min.js"></script>

    <!-- DataTables JavaScript -->
    <script src="assets/vendor/datatables/js/jquery.dataTables.min.js"></script>
    <script src="assets/vendor/datatables-plugins/dataTables.bootstrap.min.js"></script>
    <script src="assets/vendor/datatables-responsive/dataTables.responsive.js"></script>

    <script src="assets/vendor/jQueryMedia/jquery.media.js"></script>
    <!--  Light Box JavaScript -->
    <script type="text/javascript" src="assets/vendor/lightbox/js/lightbox.js"></script>
    
    <!-- Custom Theme JavaScript -->
    <script src="assets/vendor/newsticker/jquery.bootstrap.newsbox.js"></script>

    <script type="text/javascript" src="./assets/vendor/plyr-master/dist/plyr.js"></script>

    <script src="assets/dist/js/sb-admin-2.js"></script>

    <!-- Page-Level Demo Scripts - Tables - Use for reference -->
    <script>  
    $('a.media').media({width:500, height:400});
    $(document).ready(function() { 
            /* This would select all the divisions */ 
            $("#a").click(function() {
            $("#b").removeAttr("disabled");
            })
         }); 
    $(function () {
        $(".berita").bootstrapNews({
            newsPerPage: 4,
            autoplay: true,
            pauseOnHover: true,
            navigation: false,
            direction: 'down',
            newsTickerInterval: 2500,
            onToDo: function () {
                //console.log(this);
            }
        });
    });
    $(document).ready(function(){
        $('#dataTables-example').DataTable({
            "responsive": true,
        "aLengthMenu": [5, 10, 25, 50, 100 ],
           "sPaginationType": "full_numbers", 
         "oLanguage": {
            "sLengthMenu": "Tampilkan _MENU_ data",
            "sSearch": "Pencarian: ",
            "sZeroRecords": "Tidak ditemukan data yang sesuai",
            "sInfo": "",
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
    })  
    
    $('.tooltip-demo').tooltip({
        selector: "[data-toggle=tooltip]",
        container: "body"
    })
    // popover demo
    $("[data-toggle=popover]")
        .popover()
    <?php
    $tampil_iklan = mysqli_query($DBcon, "SELECT * FROM iklan where terbit ='show' and posisi='popup'");
    $r=mysqli_fetch_array($tampil_iklan);
    if( !isset($_SESSION[terkunjungi]) && $r[terbit]=='show' && $r[posisi]='popup' ){
        $_SESSION[terkunjungi] = true;
       // echo "$('#infoModal').modal('show');";
        echo $_SESSION[terkunjungi];
    }
    else{
        echo "$('#infoModal').modal('hide');";        
    }

    ?>
    </script>
    </body>
</html>
<?php
}
}
?>
