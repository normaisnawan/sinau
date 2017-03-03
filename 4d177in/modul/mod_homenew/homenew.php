<hr>
<div class="row">
	<div class="col-md-8">
		<div class="panel panel-primary">
			<div class="panel-heading"><i class="fa  fa-bullhorn   fa-fw"></i> Iklan</div>
			<div class="panel-body">
			<div id="myCarousel" class="carousel slide" data-ride="carousel">
                  <!-- Indicators -->
                  <ol class="carousel-indicators">
                    <?php
                    /*
                    	$q = mysqli_query($DBcon, "SELECT * FROM iklan WHERE posisi='gambar'");
                    	$n = 1;
                    	while ($r=$q->fetch_assoc()) {
                    		if ($n == 1) {
                    			echo '<li data-target="#myCarousel" data-slide-to="0" class="active"></li>'
                    		} else {
                    			echo '<li data-target="#myCarousel" data-slide-to="1"></li>';
                    		}
                    	$n++;		  		
                    	}
                    	*/
                    ?>
                    
                  </ol>

                  <!-- Wrapper for slides -->
                  <div class="carousel-inner" role="listbox">
                  	<?php
                      $tday = date('Y-m-d');
                  		$q = mysqli_query($DBcon, "SELECT * FROM iklan WHERE posisi='gambar' AND '$tday' between tglawal and tglakhir");
                      $n = 1;
                    	while ($r=$q->fetch_assoc()) {
                    		if ($n == 1) {
                    			echo '<div class="item active">
					                      <img style="height:300px;width:100%" src="'.url().'/files_gambar/'.$r['gambar'].'" alt="Chania">
					                    </div>';
                    		} else {
                    			echo '<div class="item">
					                      <img style="height:300px;width:100%" src="'.url().'/files_gambar/'.$r['gambar'].'" alt="Chania">
					                  </div>';
                    		}
                    	$n++;		  		
                    	}
                    ?>
                  </div>

                  <!-- Left and right controls -->
                  <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
                    <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                  </a>
                  <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
                    <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                  </a>
                </div>
            </div>
			</div>
			<div class="panel panel-primary">
			<div class="panel-heading"><i class="fa  fa-play-circle  fa-fw"></i> Video</div>
				<div class="panel-body">
					<?php
                                      $q = mysqli_query($DBcon, "SELECT * FROM iklan WHERE posisi='video'  AND '$tday' between tglawal and tglakhir");
                                      while ($r=mysqli_fetch_array($q)) {
                                      echo $r['isiiklan'];
                                    } 
                                  
                                  ?>   
				</div>
			</div>
	</div>
	<div>
	<div class="col-md-4">
		<div class="panel panel-primary">
                        <div class="panel-heading">
                            <i class="fa fa-bell fa-fw"></i> Materi Terbaru
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="list-group">
                            	<?php
                                      $q = mysqli_query($DBcon, "SELECT * FROM file_materi ORDER BY id_file DESC LIMIT 5");
                                      while ($r=mysqli_fetch_array($q)) { 
                                        echo '
                                      <a href="media.php?module=materi&act=daftarmateri&id='.$r['kategori'].'" class="list-group-item">
		                                    <i class="fa  fa-book fa-fw"></i> '.$r['judul'].'
		                                    </span>
		                                </a>';
                                    }
                                  
                                  ?>      
                                
                                
                            </div>
                          </div>
                        <!-- /.panel-body -->
                    </div>
		<div class="panel panel-primary">
            <div class="panel-heading">
                <i class="fa  fa-info  fa-fw"></i> Berita
            </div>
            <!-- /.panel-heading -->
            <div class="panel-body">
                <div id="collapseOne" class="panel-collapse ">
                        <div class="panel-body" >
                            <ul class="berita" > 
                                  <?php
                                      $tampil_iklan = mysqli_query($DBcon, "SELECT * FROM iklan where terbit='show' and posisi='header'   AND '$tday' between tglawal and tglakhir");
                                      while ($r=mysqli_fetch_array($tampil_iklan)) { 
                                        echo "
                                      <li class='news-item' id='isi'><p>".substr($r['isiiklan'],0, 70 )."<a href='media.php?module=iklan&act=bacaiklan&idiklan=$r[idiklan]'> Selengkapnya</a></p></li> ";
                                    }
                                  
                                        ?>      
                                    </ul>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.panel-body -->
        </div>
	<div>	
</div>