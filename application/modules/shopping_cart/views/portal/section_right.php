
<!-- Start Logo Section -->
<section id="logo-section" class="text-center">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="logo text-center">

                </div>
            </div>
        </div>
    </div>
</section>

<div class="maincontent-area">
    <div class="container">
        <div class="row">
            <br>   
            <div class="col-md-12">
                <div class="product-content-right">  
                    <div class="row carousel-holder">
                        <div class="col-md-12">
                            <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
                                <ol class="carousel-indicators">
                                    <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
                                    <li data-target="#carousel-example-generic" data-slide-to="1"></li>
                                    <li data-target="#carousel-example-generic" data-slide-to="2"></li>
                                </ol>
                                <div class="carousel-inner">
                                    <?php
                                    $cont = 0;
                                    foreach ($img_banner as $img) {
                                        $dir = 'https://googledrive.com/host/0ByqQkg3INrbzQWR5aXdDWjc5UG8/'.$img->img_name;
                                        if ($cont == 0) {
                                            ?>
                                            <div class="item active">
                                                <img class="slide-image"  src=<?php echo $dir ?> class="img-responsive" alt="">
                                            </div>
                                        <?php } else { ?>
                                            <div class="item">
                                                <img class="slide-image"  src=<?php echo $dir ?> class="img-responsive" alt="">
                                            </div>
                                            <?php
                                        }
                                        $cont++;
                                    }
                                    ?>


                                </div>
                                <a class="left carousel-control" href="#carousel-example-generic" data-slide="prev">
                                    <span class="glyphicon glyphicon-chevron-left"></span>
                                </a>
                                <a class="right carousel-control" href="#carousel-example-generic" data-slide="next">
                                    <span class="glyphicon glyphicon-chevron-right"></span>
                                </a>
                            </div>
                        </div>

                    </div>	
                </div>                    
            </div>
        </div>
    </div>
</div>




