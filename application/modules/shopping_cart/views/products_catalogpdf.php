<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
echo Open('div',array('class'=>'col-md-12 tab-content', 'id'=>'view_catalog'));
    echo tagcontent('h4','CATALOGO DE PRODUCTOS');
//========================list view
    echo Open('div',array('class'=>'tab-pane','id'=>'listView'));
            if(!empty($productos || $producto_nombre)){
                if(empty($productos)){
                    $arreglo = $producto_nombre;
                }else{
                    $arreglo = $productos;
                }
                foreach ($arreglo as $prodlist){
//                    if($prodlist->costopromediokardex > 0.0){
                    echo Open('div',array('class'=>'row'));
                        echo Open('div',array('class'=>'col-md-2','id'=>'productView'));
                        //$imagencargar = '';
                            $imagencargar = 'https://googledrive.com/host/0ByqQkg3INrbzQWR5aXdDWjc5UG8/'.$prodlist->codigo.'.jpg'; 
                            $imagen = tagcontent('img', '', array('src' => $imagencargar, 'alt' => $prodlist->codigo, 'style' => 'height:100px;width:100px;margin: auto;','class'=>'thumbnail'));
                            echo tagcontent('a', $imagen ,array('href'=>  base_url('shopping_cart/productos/product_detail?codigo='.$prodlist->codigo)));
                        echo Close('div');//close dic span2
                        echo Open('div',array('class'=>'col-md-4'));
                            echo tagcontent('h5',$prodlist->codigo);
                            echo tagcontent('p',$prodlist->nombreUnico);

                            echo tagcontent('span','P. Oferta: $'.number_decimal($prodlist->precioOferta_con_iva).'<br>');
                            echo lineBreak2(1, array('class'=>'clr'));
                        echo Close('div');//close dic span4
                        if(!empty($clientetipo_precios) && $data_client->tipo_id == 3){
                            echo Open('div',array('class'=>'col-md-3'));
                                echo Open('table', array('class'=>'table table-bordered table-striped table-condensed','id'=>'table_bodega'));
                                    $thead = array('Tipo','P. con Iva','P. sin Iva');
                                    echo tablethead($thead);
//                                    $clientetipo_precios = $this->generic_model->get_data('billing_clientetipotiposprecio',array('clientetipo_idclientetipo ='=>$tipocliente->idclientetipo));
                                    foreach ($clientetipo_precios as $tc_tp){
                                        if($tc_tp->tiposprecio_tipoprecio != 'pF'){
                                            $precios = $this->product->get_precio_prod($prodlist->codigo,$tc_tp->tiposprecio_tipoprecio);
                                            $precio_con_iva = $precios['price_iva'];
                                            $precio_sin_iva = $precios['price'];
                                            echo Open('tr');
                                                echo tagcontent('td', $tc_tp->tiposprecio_tipoprecio);
                                                echo tagcontent('td', '$'.number_decimal($precio_con_iva));
                                                echo tagcontent('td', '$'.number_decimal($precio_sin_iva));
                                            echo Close('tr');
                                        }
                                    }
                                echo Close('table');
                            echo Close('div');
                            echo Open('div',array('class'=>'col-md-2'));
                            
                                echo Open('table', array('class'=>'table table-bordered table-striped table-condensed','id'=>'table_bodega'));
                                    $thead = array('Bodega','Stock');
                                    echo tablethead($thead);
                                    $bodegas_stock = $this->generic_model->get_data(
                                            'billing_stockbodega',
                                            array('producto_codigo ='=>$prodlist->codigo),
                                            'bodega_id,producto_codigo,stock'
                                            );
                                    foreach ($bodegas_stock as $bodega){
//                                        $nombre_bodega = $this->generic_model->get_by_id('billing_bodega', $bodega->bodega_id, 'id,nombre', 'id');
                                        $nombre_bodega = $this->generic_model->get(
                                                'billing_bodega',
                                                array('id'=>$bodega->bodega_id,'vistaweb'=>1),
                                                'id,nombre',
                                                array('nombre'=>'asc')
                                            );
                                        if(!empty($nombre_bodega)){
                                            $stock_bodega = $this->stockbodega->get_stock_bod_disponibe($nombre_bodega[0]->id,$prodlist->codigo);
                                            $bodega_name = $nombre_bodega[0]->nombre;
                                        }else{
                                            $stock_bodega = '';
                                            $bodega_name = '';
                                        }
                                        
                                        echo Open('tr');
                                            echo tagcontent('td', $bodega_name);
                                            echo tagcontent('td', $stock_bodega);
                                        echo Close('tr');
                                    }
                                echo Close('table');
                            echo Close('div');
                        }
                    echo Close('div');//close div row
                }
            }
        echo Close('div');//close div list view
echo Close('div');//close div tab-content
