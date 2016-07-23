<div class="brands-area">
        <div class="zigzag-bottom"></div>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="brand-wrapper">
                        <h2 class="section-title">Búsqueda</h2>
                        
                <div class="col-md-6 col-sm-3">
                    <div class="single-promo">
                        <i class="fa fa-search"></i>
                       <a data-toggle="modal" href="#nombre"> <p>Nombre del producto</p></a>
                    </div>
                </div>
                
                <div class="col-md-6 col-sm-3">
                    <div class="single-promo">
                        <i class="fa fa-search"></i>
                       <a data-toggle="modal" href="#codigo"> <p>Codigo del producto</p></a>
                    </div>
                </div>
                         </div>
                </div>
            </div>
        </div>
    </div> <!-- End brands area -->   

    <div class="section-modal modal fade" id="nombre" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-content">
                <div class="close-modal" data-dismiss="modal">
                    <div class="lr">
                        <div class="rl">
                        </div>
                    </div>
                </div>
                
                <div class="container">              
                    <div class="single-sidebar">
                        <h2 class="sidebar-title">Nombre del producto</h2>
                        <form action="<?= base_url('shopping_cart/productos/get_products_by_name')?>" method="get">
                            <input type="text" name="product_name" placeholder="Nombre...">
                            <input type="submit" value="Buscar">
                        </form>
                    </div>
                </div>
                
            </div>
        </div>

<div class="section-modal modal fade" id="codigo" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-content">
                <div class="close-modal" data-dismiss="modal">
                    <div class="lr">
                        <div class="rl">
                        </div>
                    </div>
                </div>
                
            <div class="container">              
                    <div class="single-sidebar">
                        <h2 class="sidebar-title">Codigo del producto</h2>
                        <form action="<?= base_url('shopping_cart/productos/product_detail/')?>" method="get">
                            <input type="text" name="codigo" placeholder="Codigo...">
                            <input type="submit" value="Buscar">
                        </form>
                    </div>
                </div>
                
            </div>
        </div>
 

<?php 
echo $view; ?>
        
       
 