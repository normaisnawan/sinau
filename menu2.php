<?php
include "configurasi/koneksi.php";
 
echo "
<li>
	<a href='#'>
		<i class='fa fa-user fa-fw'></i> Edit
	</a>
	<ul class='nav nav-second-level'>
		<li>
			<a href='media.php?module=users&act=detailprofilusers&id=$_SESSION[idusers]'>
				Edit Profil
			</a>
		</li>
		<li>
			<a href='media.php?module=users&act=detailaccount'>
				Edit Username & Password
			</a>
		</li>
	</ul>
</li>";

?>

