<div class="header-area">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <div class="user-menu">
                        <ul>
						
							<?php
								 foreach ($setions as $value) {
                                    if( $value->acceso == 'no-registered' AND !empty($this->user->id) ){ continue; }                                
                                    if($value->position != 'center'){ continue; }
                                    if($value->uri_type == 'internal'){
                                        $value->uri = base_url($value->uri);
                                    }                                    
                                    
                                        echo '<li>';
                                            echo Open('a', array('href'=>$value->uri, 'data-toggle'=>"modal"));
                                                echo tagcontent('i', '', array('class'=>'fa fa-user'));
                                                echo $value->name;
                                            echo Close('a');
										echo '</li>';
                                }
							?>
						
                            
                        </ul>
                    </div>
                </div>
                
            </div>
        </div>
    </div> <!-- End header area -->
    <div class="site-branding-area">
        <div class="container">
            <div class="row">
                <div class="col-sm-6">
                    <div class="logo">
					
                        <h1><a href="#"><img src="<?= base_url('resources/img/logos/masterpc.jpg') ?>"></a></h1>
                    </div>
                </div>
                
                <div class="col-sm-6">
                    <div class="shopping-item">
						<?php 
							//$this->load->view('shopping_cart/compra');						?>
                        <a href="http://demos.wpexpand.com/html/eElectronics/cart.html">Tu compra - <span class="cart-amunt">$0.00</span> <i class="fa fa-shopping-cart"></i> <span class="product-count"></span></a>
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- End site branding area -->
	<div id="undefined-sticky-wrapper" class="sticky-wrapper" style="height: 60px;"><div class="mainmenu-area">
        <div class="container">
            <div class="row">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                        <span class="sr-only">Toggle navigat`1ionion</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                </div> 
                <div class="navbar-collapse collapse">
                    <ul class="nav navbar-nav">
						 <?php
                                foreach ($setions as $value) {
                                    if( $value->acceso == 'no-registered' AND !empty($this->user->id) ){ continue; }
                                    if($value->position != 'left'){ continue; }
                                   
                                        if($value->uri_type == 'internal'){
                                            $value->uri = base_url($value->uri);
                                        }
										echo '<li>';
                                        echo Open('a', array('href'=>$value->uri, 'data-toggle'=>"modal"));
                                            
                                            echo tagcontent('p', $value->name);
                                        echo Close('a');
										echo '</li>';
                                 
                                }
								
								foreach ($setions as $value) {
                                if( $value->acceso == 'no-registered' AND !empty($this->user->id) ){ continue; }                             
                                if($value->position != 'right'){ continue; }
                                if($value->uri_type == 'internal'){
                                    $value->uri = base_url($value->uri);
                                }                                
                                echo '<li>';
                                    echo Open('a', array('href'=>$value->uri, 'data-toggle'=>"modal"));
                                       
                                        echo tagcontent('p', $value->name);
                                    echo Close('a');
									echo '</li>';
                            }
                        ?>
					
					
					
                       
                      
                    </ul>
                </div>  
            </div>
        </div>
    </div></div> <!-- End mainmenu area -->