<?php
session_start();
 if (empty($_SESSION['username']) AND empty($_SESSION['passuser'])){
  echo "<link href='style.css' rel='stylesheet' type='text/css'>
 <center>Untuk mengakses modul, Anda harus login <br>";
  echo "<a href=../../index.php><b>LOGIN</b></a></center>";
}
else{
include "../../../configurasi/koneksi.php";
include "../../../assets/vendor/PHPExcel/PHPExcel.php";

$module=$_GET['module'];
$act=$_GET['act'];

if ($module=='rekap' AND $act=='cetakrekap'){
$iduser = mysql_real_escape_string($_GET[iduser]);
$tanggal = mysql_real_escape_string(($_GET[tanggal]));
$tanggal2 = mysql_real_escape_string(($_GET[tanggal2]));
$idtrkatalog = mysql_real_escape_string(($_GET[idtrkatalog]));	
 $tampildata = mysqli_query($DBcon, "SELECT * FROM `pelatihan` WHERE `idtrkatalog` = '$idtrkatalog' AND `tanggal_pelaksanaan` BETWEEN '$tanggal' AND '$tanggal2' AND `tanggal_selesai` BETWEEN '$tanggal' AND '$tanggal2' AND `pengikut` LIKE '%$iduser%'");
       //mencari data pelatihan dengan kisaran tanggal
      $td=mysqli_fetch_array($tampildata);

      $cariusers = mysqli_query($DBcon, "SELECT * FROM users where NIK ='$iduser'");
            //mencari nama users
      $cu=mysqli_fetch_array($cariusers);


      $trkatalog = mysqli_query($DBcon, "SELECT * FROM trkatalog where idtrkatalog ='$td[idtrkatalog]'");
            //mencari nama users
      $tr=mysqli_fetch_array($trkatalog);

      $cariuserskerja = mysqli_query($DBcon, "SELECT * FROM `users_sudah_mengerjakan` where id_users ='$cu[id_users]' and id_pelatihan='$td[id_pelatihan]'");
      //cari user yang sudah mengerjakan dengan id dan tanggal tadi.
      $cuk=mysqli_fetch_array($cariuserskerja);
     
      $carinilai = mysqli_query($DBcon, "SELECT * FROM nilai where id_users ='$cu[id_users]' and id_pelatihan='$td[id_pelatihan]'");
      //mencari nilai users
      $cn=mysqli_fetch_array($carinilai);
      $no=1;
/** Error reporting */
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);
date_default_timezone_set('Europe/London');

define('EOL',(PHP_SAPI == 'cli') ? PHP_EOL : '<br />');

/** Include PHPExcel */
require_once '../../../assets/vendor/PHPExcel/PHPExcel.php';
require_once '../../../assets/vendor/PHPExcel/phpExcel/IOFactory.php';


// Create new PHPExcel object
echo date('H:i:s') , " Create new PHPExcel object" , EOL;
$objPHPExcel = new PHPExcel();

// Set document properties
echo date('H:i:s') , " Set document properties" , EOL;

$objPHPExcel->getProperties()->setCreator("4d177in")
							 ->setLastModifiedBy("Adminsitrator")
							 ->setTitle("Rekap Feri Agusetiawan")
							 ->setSubject("Rekap Data")
							 ->setDescription("Rekap Data Pelatihan Feri Agusetiawan.")
							 ->setKeywords("Rekap Data Traning")
							 ->setCategory("Rekap Data Traning");

for($col = 'A'; $col !== 'J'; $col++) {
    $objPHPExcel->getActiveSheet()
        ->getColumnDimension($col)
        ->setAutoSize(true);
}
// Add some data
echo date('H:i:s') , " Add some data" , EOL;
$objPHPExcel->getActiveSheet()->getStyle('A1:J1')->getFont()->setBold(true);
$objPHPExcel->setActiveSheetIndex(0);
$objPHPExcel->getActiveSheet()->setCellValue('A1', 'NIK');
$objPHPExcel->getActiveSheet()->setCellValue('B1', 'Nama');
$objPHPExcel->getActiveSheet()->setCellValue('C1', 'Jabatan');
$objPHPExcel->getActiveSheet()->setCellValue('D1', 'Nama Trainer');
$objPHPExcel->getActiveSheet()->setCellValue('E1', 'Tgl Traning');
$objPHPExcel->getActiveSheet()->setCellValue('F1', 'Tgl Selesai');
$objPHPExcel->getActiveSheet()->setCellValue('G1', 'Provider/Penyelenggara');
$objPHPExcel->getActiveSheet()->setCellValue('H1', 'Traning Katalog');
$objPHPExcel->getActiveSheet()->setCellValue('I1', 'Nilai');
$objPHPExcel->getActiveSheet()->setCellValue('J1', 'Rekomendasi');

// Rows to repeat at top
echo date('H:i:s') , " Rows to repeat at top" , EOL;
$objPHPExcel->getActiveSheet()->getPageSetup()->setRowsToRepeatAtTopByStartAndEnd(1, 1);

// Miscellaneous glyphs, UTF-8
$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A2', $cu['NIK'])
            ->setCellValue('B2', $cu['EmployeeName'])
            ->setCellValue('C2', $cu['PosTitle'])
            ->setCellValue('D2', $td['nama_trainer'])
            ->setCellValue('E2', $td['tanggal_pelaksanaan'])
            ->setCellValue('F2', $td['tanggal_selesai'])
            ->setCellValue('G2', 'PT Phapros, Tbk')
            ->setCellValue('H2', $tr['nama'])
            ->setCellValue('I2', $cn['persentase'])
            ->setCellValue('J2', $cn['kriteriapenilaian']);


$objPHPExcel->getActiveSheet()->getRowDimension(8)->setRowHeight(-1);
$objPHPExcel->getActiveSheet()->getStyle('A8')->getAlignment()->setWrapText(true);


$objPHPExcel->getActiveSheet()->setTitle($cu['EmployeeName']);


// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);



$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
ob_end_clean();
// We'll be outputting an excel file
header('Content-type: application/vnd.ms-excel');
header('Content-Disposition: attachment; filename="Nama File.xlsx"');
$objWriter->save('php://output');

	}elseif ($module=='rekap' AND $act=='semuarekap'){

$iduser = mysql_real_escape_string($_GET[iduser]);
$tanggal = mysql_real_escape_string(($_GET[tanggal]));
$tanggal2 = mysql_real_escape_string(($_GET[tanggal2]));
$idtrkatalog = mysql_real_escape_string(($_GET[idtrkatalog])); 
       //mencari data pelatihan dengan kisaran tanggal
 $tampildata = mysqli_query($DBcon, "SELECT * FROM `pelatihan` WHERE `idtrkatalog` = '$idtrkatalog' AND `tanggal_pelaksanaan` BETWEEN '$tanggal' AND '$tanggal2' AND `tanggal_selesai` BETWEEN '$tanggal' AND '$tanggal2'");
 $no=2;
 include 'header.html';
echo"<table width=\"100%\" class=\" table2excel table table-striped table-bordered table-hover\" id=\"dataTables-example\">
      <thead>
        <th>NIK</th>
        <th>Nama</th>
        <th>Jabatan</th>
        <th>Nama Trainer</th>
        <th>Tgl Traning</th>
        <th>Tgl Selesai</th>
        <th>Provider/Penyelenggara</th>
        <th>Traning Katalog</th>
        <th>Nilai</th>
        <th>Rekomendasi</th>
     </thead>
      <tbody>";
while ($td=mysqli_fetch_array($tampildata)) {
          $hasilpilih .= $td[pengikut] . ",";
          $hasilpilih = substr($hasilpilih,0,-1);
          $tampil_users=mysqli_query($DBcon, "SELECT * FROM users WHERE find_in_set(NIK,'$hasilpilih')");
          while ($p=mysqli_fetch_array($tampil_users)) {  
          echo"
        <tr>
          <td>".$p['NIK']."</td>
          <td>".$p['EmployeeName']."</td>
          <td>".$p['PosTitle']."</td>
          <td>".$td['nama_trainer']."</td>
          <td>".$td['tanggal_pelaksanaan']."</td>
          <td>".$td['tanggal_selesai']."</td>
          <td>PT Phapros, Tbk</td>";

          $trkatalog = mysqli_query($DBcon, "SELECT * FROM trkatalog where idtrkatalog ='$td[idtrkatalog]'");
            //mencari nama users
          $tr=mysqli_fetch_array($trkatalog);
          
          echo "
          <td>".$tr['nama']."</td>";

          $cariuserskerja = mysqli_query($DBcon, "SELECT * FROM `users_sudah_mengerjakan` where id_users ='$p[id_users]' and id_pelatihan='$td[id_pelatihan]'");
          //cari user yang sudah mengerjakan dengan id dan tanggal tadi.
          $cuk=mysqli_fetch_array($cariuserskerja);
         
          $carinilai = mysqli_query($DBcon, "SELECT * FROM nilai where id_users ='$p[id_users]' and id_pelatihan='$td[id_pelatihan]'");
          //mencari nilai users
          $cn=mysqli_fetch_array($carinilai); 
          echo "
          
          <td>".$cn['persentase']."</td>
          <td>".$cn['kriteriapenilaian']."<td>
        </tr>";
            }
          }
        echo "
        <div class='text-center'>
          <button class='btn btn-danger' onclick=\"window.location.href='../../media_admin.php?module=rekap'; klik()\">Kembali</button>
        </div>
      <tbody>
</table>
        ";
include 'footer.html';

}
}
?>    
