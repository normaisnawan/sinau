<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
session_start();
?>



<?php

$bataswaktu       = time("U") - 300;
$user = mysqli_query($DBcon, "SELECT * FROM online WHERE online ='Y'");
while ($r=mysqli_fetch_array($user)){
    $siswa = mysqli_query($DBcon, "SELECT * FROM siswa WHERE id_siswa = '$r[id_siswa]'");
    $s = mysqli_fetch_array($siswa);
    if ($s[id_siswa] != $_SESSION[idsiswa]){
    if (!empty($s[foto])){       
        echo "<a href='javascript:void(0)' onclick='javascript:chatWith($s[EmployeeName])'><img src='foto_siswa/small_$s[foto]' title='$s[EmployeeName]'></a><br>";
    }
    else{
        echo "<a href='javascript:void(0)' onclick='javascript:chatWith($s[EmployeeName])'><img src='foto_siswa/foto_kosong.png' title='$s[EmployeeName]'></a><br>";
    }
    }
    else{
       if (!empty($s[foto])){
        echo "<img src='foto_siswa/small_$s[foto]' title='$s[EmployeeName]'><br>";
        }
        else{
            echo "<img src='foto_siswa/foto_kosong.png' title='$s[EmployeeName]'><br>";
        }
    }
    
}
?>
