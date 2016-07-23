<div class="col-md-4">
                    <div class="single-sidebar">
                        <h2 class="sidebar-title">Nombre del produto</h2>
                        <form action="<?= base_url('shopping_cart/productos/get_products_by_name')?>" method="get" class="sidebar-form">
                            <input name="product_name" type="text" placeholder="Buscar productos...">
                            <input type="submit" value="Buscar">
                        </form>
                    </div>
					
                    <div class="single-sidebar">
                        <h2 class="sidebar-title">Codigo del producto</h2>
                        <form action="<?= base_url('shopping_cart/productos/product_detail/')?>" method="get" class="sidebar-form">
                            <input name="codigo" type="text" placeholder="Buscar productos...">
                            <input type="submit" value="Buscar">
                        </form>
                    </div>
                    
                    
                    <div class="single-sidebar">
                        <h2 class="sidebar-title">Productos</h2>
                        <ul class="sidebar-menu" >
            
            <?php
//                echo Open('div', array('class' => 'span3', 'id' => 'sidebar')); //open div span3
//                    $li = '';
                /*
                    foreach ($grupos_producto as $g) {
//                        $ait = tagcontent('a', $g->nombre, array('href' => base_url('shopping_cart/productos/search_group_product/' . $g->codigo . '/' . $g->nombre)));
//                        $li .= tagcontent('li', $ait);
                        $group_link = tagcontent('a', tagcontent('i','',array('class'=>'fa fa-dashboard')).$g->nombre, array('class'=>'active','href' => base_url('shopping_cart/productos/search_group_product/' . $g->codigo . '/' . $g->nombre)));
                        echo tagcontent('li', $group_link);
                    }*/
//                    echo tagcontent('ul', $li, array('id' => 'sideManu', 'class' => 'nav nav-tabs nav-stacked'));
//                echo Close('div'); //close div span3            
            ?>
        </ul>
    </div>                      
</div>