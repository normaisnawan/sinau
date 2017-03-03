<!--Mulai Berita Berjalan-->
                     <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-primary" id="panel" role="dialog" aria-hidden="true">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                             <a data-toggle="collapse" data-parent="#accordion" href="#collapseFour">
                             <span class="fa fa-info"> QUICK MENU</span></a>
                             <a href="#panel" class="close" data-dismiss="alert" aria-label="close" id="panel">&times;</a>
                             </h4>
                        </div>
                        <!-- .panel-heading -->
                        <div id="collapseFour" class="panel-collapse">
                         <div class="panel-body">
                            <div class="panel-group" id="accordion">
                                <div class="panel panel-red">
                                    <div class="panel-heading">
                                        <h4 class="panel-title">
                                            <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne"><span class="fa fa-bullhorn "></span> News</a>
                                        </h4>
                                    </div>
                                    <div id="collapseOne" class="panel-collapse ">
                                        <div class="panel-body" >
                                            <ul class="berita" > 
                                                  <?php
                                                      $tampil_iklan = mysqli_query($DBcon, "SELECT * FROM iklan where terbit='show' and posisi='header'");
                                                      while ($r=mysqli_fetch_array($tampil_iklan)) { 
                                                        echo "
                                                      <li class='news-item' id='isi'><p>".substr($r['isiiklan'],0, 70 )."<a href='media.php?module=iklan&act=bacaiklan&idiklan=$r[idiklan]'> Selengkapnya</a></p></li> ";
                                                    }
                                                  
                                                        ?>      
                                                    </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel panel-yellow">
                                    <div class="panel-heading">
                                        <h4 class="panel-title">
                                            <a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo">
                                            <span class="fa fa-video-camera"></span> Video</a>
                                        </h4>
                                    </div>
                                    <div id="collapseTwo" class="panel-collapse ">
                                        <div class="panel-body text-center">
                                            <video poster="images/phapros.png" controls crossorigin>
                                            <!-- Video files -->
                                            <?php
                                            $video = "SELECT * FROM iklan WHERE posisi = 'video' limit 1";

                                            $olah = mysqli_query($DBcon, $video);
                                            $tampilkan = mysqli_fetch_array($olah);

                                            echo '
                                            <source src="files_video/'.$tampilkan[gambar].'" type="video/mp4">
                                            <a href="files_video/Larva-Christmas.mp4" download>Download</a>';

                                            ?>

                                            <!-- Text track file -->
                                            <!-- <track kind="captions" label="English" srclang="en" src="https://cdn.selz.com/plyr/1.5/View_From_A_Blue_Moon_Trailer-HD.en.vtt" default> -->

                                            <!-- Fallback for browsers that don't support the <video> element -->
                                        </video>

                                        </div>
                                    </div>
                                </div>
                                <div class="panel panel-info">
                                    <div class="panel-heading">
                                        <h4 class="panel-title">
                                            <a data-toggle="collapse" data-parent="#accordion" href="#collapseThree"><span class="fa fa-video-camera"></span> Iklan</a>
                                        </h4>
                                    </div>

                                    <div id="collapseThree" class="panel-collapse">
                                      <div class="panel-body">
                                        <marquee>Basic panel example</marquee>
                                      </div>
                                    
                                        <div class="panel-body">
                                            <div id="myCarousel" class="carousel slide" data-ride="carousel">
                                              <!-- Indicators -->
                                              <ol class="carousel-indicators">
                                                <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
                                                <li data-target="#myCarousel" data-slide-to="1"></li>
                                                </ol>

                                              <!-- Wrapper for slides -->
                                              <div class="carousel-inner" role="listbox">
                                                <div class="item active">
                                                  <img style="height:300px;width:100%" src="<?php echo url(); ?>/foto_iklan/1.jpg" alt="Chania">
                                                </div>

                                                <div class="item">
                                                  <img style="height:300px;width:100%" src="<?php echo url(); ?>/foto_iklan/2.jpg" alt="Chania">
                                                </div>

                                                
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
                                </div>
                            </div>
                        <div class="panel-footer">
                            Copyright &copy; e-Ped 2017
                        </div>
                        </div>
                        </div>
                        <!-- .panel-body -->
                    </div>
                    <!-- /.panel -->