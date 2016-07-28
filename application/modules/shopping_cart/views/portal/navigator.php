 <div class="header-area">
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="user-menu">
                    <ul>
                        <?php
						if(@$this->user){
                        foreach ($setions as $value) {
                            if ($value->acceso == 'no-registered' AND ! empty($this->user->id)) {
                                continue;
                            }
                            if ($value->position != 'center') {
                                continue;
                            }
                            if ($value->uri_type == 'internal') {
                                $value->uri = base_url($value->uri);
                            }

                            echo '<li>';
                            echo Open('a', array('href' => $value->uri, 'data-toggle' => "modal"));
                            echo tagcontent('i', '', array('class' => 'fa fa-user'));
                            echo $value->name;
                            echo Close('a');
                            echo '</li>';
                        }
						}
						else{
							
							echo "<li><a href=''><i class='fa fa-user'></i> Logout</a></li>
                       ";
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
                    <h1><a href="<?= base_url('shopping_cart/productos') ?>"><img src="<?= base_url('resources/img/logos/masterpc.jpg') ?>"></a></h1>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="shopping-item">
                    <?php $this->load->view('compra'); ?>
                </div>
            </div>
        </div>
    </div>
</div> <!-- End site branding area -->

<div id="undefined-sticky-wrapper" class="sticky-wrapper" style="height: 60px;"><div class="mainmenu-area">
        <div class="container">
            <div class="row">

                <div class="navbar-collapse collapse">
                    <ul class="nav navbar-nav">


                        <?php
                        echo "<ul id='dc_mega-menu-orange' class='dc_mm-orange'> ";        
                        foreach ($setions as $value) {
                            if ($value->acceso == 'no-registered' AND ! empty($this->user->id)) {
                                continue;
                            }
                            if ($value->position != 'left') {
                                continue;
                            }

                            if ($value->uri_type == 'internal') {
                                $value->uri = base_url($value->uri);
                            }
                            if ($value->name == 'Productos') {
                                echo "<li><a data-toggle='modal' href='" . $value->uri . "'>" . $value->name . "</a>
                                            <ul>";

                                $c = 0;
                                foreach ($grupos_producto as $g) {

                                    if ($c == 0) {
                                        echo '  <li>';
                                        echo '   <ul>';  # code...
                                    }
                                    $c++;
                                    echo '  <li><a href="' . base_url('shopping_cart/productos/search_group_product/' . $g->codigo . '/' . $g->nombre) . '">' . $g->nombre . '</a></li>';
                                    if ($c == 20) {
                                        echo '   </ul>';  # code...
                                        echo '  </li>';
                                        $c = 0;
                                    }
                                }
                                echo '   </ul>';  # code...
                                echo '  </li>';

                                echo " </ul></li>";
                            } else {
                                echo '<li>';
                                echo Open('a', array('href' => $value->uri, 'data-toggle' => "modal"));

                                echo tagcontent('div', $value->name);
                                echo Close('a');
                                echo '</li>';
                            }
                        }
                        ?>


                    </ul> 
                    </ul>
                </div>  
            </div>
        </div>
    </div>
</div>
<?php
$this->load->view('login_modal');
$this->load->view('register_modal');
?>

<script type="text/javascript">
    $(document).ready(function ($) {
        $('#dc_mega-menu-orange').dcMegaMenu({rowItems: '4', speed: 'fast', effect: 'fade'});
    });
</script>


