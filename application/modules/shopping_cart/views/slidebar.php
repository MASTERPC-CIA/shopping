<aside class="main-sidebar" >
    <section class="sidebar">
        <div class="user-panel">
            <?php
                //echo $this->load->view('login/user_logo','',TRUE);
            ?>
          </div>
        <?php 
            echo Open('form', array( 'action' => base_url('shopping_cart/productos/pruducts_marca'), 'method' => 'get'));              
            $combo_marca = combobox(
                    $productos_marca, 
                    array('label'=>'nombre','value'=>'id'), 
                    array('class' => 'combobox form-control', 'name' => 'marca_id', 'id' => 'marca_id'), 
                    'Seleccionar Marca'
                );
            echo tagcontent('div', $combo_marca, array('style'=>'padding:10px'));
        echo Close('form');
        ?>
        <form action="<?= base_url('shopping_cart/productos/get_products_by_name')?>" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" id="product_name" name="product_name" class="form-control" placeholder="Nombre del Producto" required="" data-target="res_info"/>
                <span class="input-group-btn">
                  <button type='submit' id='submitButton' class="btn btn-flat" ><i class="fa fa-search" ></i></button>
                </span>
            </div>
          </form>
        <?php 
        ?>
        <form action="<?= base_url('shopping_cart/productos/product_detail/')?>" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" id="codigo" name="codigo" class="form-control" placeholder="C&oacute;digo Producto" required="" data-target="res_info"/>
                <span class="input-group-btn">
                  <button type='submit' id='submitButton' class="btn btn-flat" ><i class="fa fa-search" ></i></button>
                </span>
            </div>
          </form>
        <?php 
       echo Open('div', array('class' => 'user-panel'));
            $spanprecio = tagcontent('span',
                    '<span class="glyphicon glyphicon-shopping-cart"></span>TU COMPRA&nbsp;$'. number_decimal($this->cart->total()),
                    array('class' => 'img-thumbnail text-center','id'=>'total_cart', 'style'=>'font-size:21px'));
    //        $imgcart = tagcontent('img', '' . $spanprecio, array('alt' => 'cart', 'src' => base_url('resources/bootshop/assets/img/ico-cart.png')));
            if(empty($this->user->id)){
                $data_target = '#loginModal';
                $data_togle = 'modal';
                $href = '';
            }  else {
                $data_target = '';
                $data_togle = '';
                $href = base_url('shopping_cart/cart');
            }
            echo tagcontent('a', $spanprecio, array('id' => 'myCart', 'href' =>$href ,'style'=>'color:orange;','data-target'=>$data_target,'data-toggle'=>$data_togle));
        echo Close('div'); 
    ?>
        <ul class="sidebar-menu" >
            <li class="header">GRUPO PRODUCTOS</li>
            <?php
//                echo Open('div', array('class' => 'span3', 'id' => 'sidebar')); //open div span3
//                    $li = '';

                    foreach ($grupos_producto as $g) {
//                        $ait = tagcontent('a', $g->nombre, array('href' => base_url('shopping_cart/productos/search_group_product/' . $g->codigo . '/' . $g->nombre)));
//                        $li .= tagcontent('li', $ait);
                        $group_link = tagcontent('a', tagcontent('i','',array('class'=>'fa fa-dashboard')).$g->nombre, array('class'=>'active','href' => base_url('shopping_cart/productos/search_group_product/' . $g->codigo . '/' . $g->nombre)));
                        echo tagcontent('li', $group_link);
                    }
//                    echo tagcontent('ul', $li, array('id' => 'sideManu', 'class' => 'nav nav-tabs nav-stacked'));
//                echo Close('div'); //close div span3            
            ?>
        </ul>
    </section>
    <!-- /.sidebar-collapse -->
</aside>
<!-- /.navbar-static-side -->
<?php $this->load->view('login_modal');
      $this->load->view('register_modal');
        
 ?>