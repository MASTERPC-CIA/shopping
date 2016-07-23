<div class="footer-top-area">
        <div class="zigzag-bottom"></div>
        <div class="container">
            <div class="row">
                <div class="col-md-5 col-sm-8">
                    <div class="footer-about-us">
                        <h2>Master<span>PC</span></h2>
                        <p>
						
						Master Pc Cía. Ltda. Es un icono de la tecnología en el sur del país, posicionándose como líder de tecnología en la región sur
						por su participación en el mercado, cantidad de clientes y volumen de ventas, este plan consiste en aclarar lo que pretendemos conseguir y como proponemos conseguirlo.
						</p>
                        <div class="footer-social">
                            <a href="https://www.facebook.com/masterpcloja/" target="_blank"><i class="fa fa-facebook"></i></a>
                            <a href="#" target="_blank"><i class="fa fa-twitter"></i></a>
                            <a href="https://www.youtube.com/user/MasterPcification" target="_blank"><i class="fa fa-youtube"></i></a>
                            <a href="#" target="_blank"><i class="fa fa-linkedin"></i></a>
                            <a href="#" target="_blank"><i class="fa fa-pinterest"></i></a>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-3 col-sm-6">
                    <div class="footer-menu">
                        <h2 class="footer-wid-title">Usuario</h2>
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
                                               
                                                echo $value->name;
                                            echo Close('a');
                                        echo '</li>';
                                }
                            ?>
                           
                        </ul>                        
                    </div>
                </div>
                
                <div class="col-md-3 col-sm-6">
                    <div class="footer-menu">
                        <h2 class="footer-wid-title">Navegaci&oacuten</h2>
                        <ul>
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
        </div>
    </div>
    <div class="footer-bottom-area">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <div class="copyright">
                        <div>Master PC Cia. Ltda <a href="https://www.masterpc.com.ec" target="_blank">3700520</a></div>
                    </div>
                </div>
                
                
            </div>
        </div>
    </div>