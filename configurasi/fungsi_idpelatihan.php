<?php 
// Connection
$conn = mysqli_connect( "localhost", "root", "", "dbphapros" ) or die ( "Error !".mysqli_error( $conn ) );
 
date_default_timezone_set( 'Asia/Jakarta' ); // Set time zone
$date = date( 'Y' ); // Tahun
$get3number = substr( $date,-3 ); // mengambil 3 angka dari sebelah kanan pada tahun sekarang
 
// Membuat fungsi acak huruf
function random_char( $panjang ) { 
	$karakter = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ'; 
	$string = ''; 
	for ( $i = 0; $i < $panjang; $i++ ) { 
		$pos = rand( 0, strlen( $karakter ) - 1 ); 
		$string .= $karakter{$pos}; 
	} 
return $string;
}
 
// mengambil data dari database untuk pengecekan no
$get_data = mysqli_query( $conn, "SELECT * FROM pelatihan" );
 
// Check
$check = mysqli_num_rows( $get_data ); // untuk mengecek apakah di table barang "no/ kode" sudah ada atau belum
 
if ( empty( $check ) ){ // Jk kode blm ada maka
	$kd = 1; // kode dimulai dr 1
} else { // jk sudah ada maka
	$kd = $check + 1; // kode sebelumnya ditambah 1.
}
 
?>