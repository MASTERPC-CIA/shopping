<?php         
    
    echo Open('form', array( 'action' => base_url('shopping_cart/productos/pruducts_marca'), 'method' => 'get'));              
        $combo_marca = combobox(
                $productos_marca, 
                array('label'=>'nombre','value'=>'id'), 
                array('class' => 'combobox form-control', 'name' => 'marca_id', 'id' => 'marca_id'), 
                'Seleccionar Marca'
            );
        echo tagcontent('div', $combo_marca, array('class'=>'col-md-2','style'=>'padding:14px'));
    echo Close('form');
    echo Open('form', array( 'action' => base_url('shopping_cart/productos/get_products_by_name'), 'method' => 'get'));
        echo get_input_button(
                    '<span class="glyphicon glyphicon-search"></span>', 
                    array('class' => 'form-control', 'type' => 'text', 'placeholder' => 'Nombre del Producto', 'required' => '', 'name' => 'product_name','id'=>'product_name'), 
                    array('id' => 'submitButton', 'class' => 'btn btn-success', 'type' => 'submit'), 
                    $class = 'col-md-3'
                );
            
    echo Close('form');

    echo Open('div', array('class' => 'col-md-3','style'=>'padding:5px'));
        $spanprecio = tagcontent('span','<span class="glyphicon glyphicon-shopping-cart"></span>TU COMPRA&nbsp;$'. number_decimal($this->cart->total()), array('class' => 'alert alert-danger','id'=>'total_cart', 'style'=>'font-size:18px'));
//        $imgcart = tagcontent('img', '' . $spanprecio, array('alt' => 'cart', 'src' => base_url('resources/bootshop/assets/img/ico-cart.png')));
        echo tagcontent('a', $spanprecio, array('id' => 'myCart', 'href' => base_url('shopping_cart/cart'),'style'=>'color:white;'));
    echo Close('div'); //close div well