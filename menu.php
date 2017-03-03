<?php
$edit=mysqli_query($DBcon,"SELECT * FROM users WHERE id_users='$_SESSION[idusers]'");
    $r=mysqli_fetch_array($edit);
if (empty($r['foto'])){
echo "<li class='sidebar-search'>
        <div class='list-quotes input-group custom-search-form'>
            <a href='foto_users/medium_no-image.jpg' data-title='Foto $_SESSION[namalengkap]' data-lightbox='image-1'>
            <img style='width:250px; height:250px;' class='img-responsive' src='foto_users/medium_no-image.jpg'>
            <div class='quotes'>
                    <p>Nama : $r[EmployeeName]</br>
        Jabatan : $r[PosTitle]</p>
                </div>
   			</a>
   			
   		</div>
   	</li>
 ";
  } else{
    echo "<li class='sidebar-search'>
        <div class='list-quotes input-group custom-search-form'>
            <a href='foto_users/medium_$r[foto]' data-title='Foto $_SESSION[namalengkap]' data-lightbox='image-1'>
            <img style='width:250px; height:250px;' class='img-responsive' src='foto_users/medium_$r[foto]'>
            <div class='quotes'>
                    <p>Nama : $r[EmployeeName]</br>
        Jabatan : $r[PosTitle]</p>
                </div>
            </a>
            
        </div>
    </li>
 ";
 }
echo "
<li>
	<a href='media.php?module=home'>
		<i class='fa fa-home fa-fw'></i> Beranda 
	</a>
</li>
	<li>
	<a href='media.php?module=pesan&act=semuapesan'>
		<i class='fa fa-envelope-o fa-fw'></i> Pesan ";
		
		 $hitungpesanbaru = mysqli_fetch_array(mysqli_query($DBcon,'SELECT count(*) as hitungpesanbaru FROM pesan WHERE NIK_penerima LIKE "%'.$_SESSION['NIK'].'%" and dibacauser="belum"'));
                    $hitungpesanbaru = $hitungpesanbaru['hitungpesanbaru'];
                        if ($hitungpesanbaru >= 1){
                            echo '<span class="badge badge-red">'. $hitungpesanbaru.'</span>';
                        }else{ 
                            echo '<span class="badge badge-default">'. $hitungpesanbaru.'</span>';

                        }
        
     echo"</a>
</li>



<li>
	<a href='media.php?module=quiz&act=pendaftaranlearning'>
		<i class='fa fa-book fa-fw'></i> Learning ";

		 $hitungpesanbaru = mysqli_fetch_array(mysqli_query($DBcon,'SELECT count(*) as hitungpesanbaru FROM pesan WHERE NIK_penerima LIKE "%'.$_SESSION['NIK'].'%"  and dibacauser="belum" and perintah="Ya"'));
                    $hitungpesanbaru = $hitungpesanbaru['hitungpesanbaru'];
                        if ($hitungpesanbaru >= 1){
                            echo '<span class="badge badge-red">'. $hitungpesanbaru.'</span>';
                        }else{ 
                            echo '<span class="badge badge-default">'. $hitungpesanbaru.'</span>';

                        }
         ?>
	</a>
	
</li>
<li>
	<a href='media.php?module=materi'>
		<i class='fa fa-archive fa-fw'></i> Pustaka 
	</a>
</li>
<li>
	<a href='media.php?module=quiz&act=nilaiusers'>
		<i class='fa fa-files-o fa-fw'></i> Riwayat Post Test  
	</a>
</li>
