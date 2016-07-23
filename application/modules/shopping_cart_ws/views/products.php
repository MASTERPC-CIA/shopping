<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
//echo lineBreak(1, array('class'=>'clr'));
    echo Open('div',array('class'=>'col-md-12 text-center'));
        if(!empty($this->user->id)){
            echo tagcontent('label','BIENVENIDO '.$data_client->razonsocial.' OBTEN UN DESCUENTO DEL<span style="font-size:40pt;color:orange;text-shadow: 3px 5px 10px #000;"> '. $tipocliente->descuento .'%</span> POR LA COMPRA EN NUETRO SITIO WEB',array('class'=>'bg-info'));
        }else{
            echo tagcontent('label','BIENVENIDO OBTEN UN DESCUENTO DEL<span style="font-size:40pt;color:orange;text-shadow: 3px 5px 10px #000;"> 20% </span>POR LA COMPRA EN NUESTRO SITIO WEB',array('class'=>'bg-info'));
        }
    echo Close('div');
    //echo tagcontent('div', $data_client->razonsocial, array('id'=>'user_info','class'=>'col-md-12'));
    echo tagcontent('div', '', array('id'=>'res_info','class'=>'col-md-12'));
    
    echo Open('div', array('class'=>'pull-right','id'=>'myTab'));
        
        $iconlist = tagcontent('i','',array('class'=>'glyphicon glyphicon-th-list'));
        $spanlist = tagcontent('span',$iconlist,array('class'=>'btn btn-large'));
        echo tagcontent('a',$spanlist,array('data-toggle'=>'tab','href'=>'#listView'));

        $iconbloc = tagcontent('i','',array('class'=>'glyphicon glyphicon-th-large'));
        $spanbloc = tagcontent('span',$iconbloc,array('class'=>'btn btn-large btn-primary'));
        echo tagcontent('a',$spanbloc,array('data-toggle'=>'tab','href'=>'#blockView'));
    echo Close('div');//close div mytab
 
    echo Open('div',array('class'=>'col-md-12 tab-content'));
//========================list view
    echo Open('nav',array('class'=>'text-center')); //open div paginacion
        echo tagcontent('ul', $this->pagination->create_links(),array('class'=>'pagination pagination-centered'));
    echo Close('nav'); //close div paginacion   
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

                            if($prodlist->stock_bodega > 0){
                                echo tagcontent('h3','Producto Disponible');
                            }else{
                                echo tagcontent('h3','Producto No Disponible');
                            }
                            echo lineBreak2(1, array('class'=>'clr'));
                            echo tagcontent('h5',$prodlist->codigo);
                            echo tagcontent('p',get_short_string($prodlist->nombreUnico , 70 , false));

                            echo tagcontent('span','P. Oferta: $'.number_decimal($prodlist->precioOferta_con_iva).'<br>');
                            echo Open('form',array('method'=>'post','action'=>  base_url('shopping_cart/cart/add_product'),'class'=>'pull-right'));
                                echo tagcontent('a',  tagcontent('i','',array('class'=>'glyphicon glyphicon-search')).' Detalles',array('href'=> base_url('shopping_cart/productos/product_detail?codigo='.$prodlist->codigo),'class'=>'btn btn-primary btn-xs'));
                                echo input(array('type'=>'hidden','name'=>'id', 'value'=>$prodlist->codigo));
                                echo input(array('type'=>'hidden','name'=>'segment', 'value'=>$this->uri->segment(4)));
                                echo input(array('type'=>'hidden','name'=>'select_precio', 'value'=>number_decimal($prodlist->precioOferta_sin_iva)));
                                
                                if($prodlist->stock_bodega){
                                    echo tagcontent('button','Agregar'.  tagcontent('i','',array('class'=>'glyphicon glyphicon-shopping-cart')),array('class'=>'btn btn-success btn-xs','id'=>'ajaxformbtn','data-target'=>'res_info'));
                                }else{
                                    echo tagcontent('button','Agregar'.  tagcontent('i','',array('class'=>'glyphicon glyphicon-shopping-cart')),array('disabled'=>'','class'=>'btn btn-success btn-xs','id'=>'ajaxformbtn','data-target'=>'res_info'));
                                }
                                
                            echo Close('form');
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
//                    }
                }
            }
        echo Close('div');//close div list view
//==========================block view
        echo Open('div',array('class'=>'tab-pane active','id'=>'blockView'));
            
            echo Open('ul',array('class'=>'thumbnails'),'');
            if(!empty($productos || $producto_nombre)){
                if(empty($productos)){
                    $arreglo = $producto_nombre;
                }else{
                    $arreglo = $productos;
                }
                foreach ($arreglo as $prod){
                    //$imagencargar = '';
                    $imagencargar = 'https://googledrive.com/host/0ByqQkg3INrbzQWR5aXdDWjc5UG8/'.$prod->codigo.'.jpg'; 
                        $imagenbloc = tagcontent('img', '', array('src' => $imagencargar, 'alt' => $prod->codigo, 'style' => 'height:100px;width:100px;margin: auto;','class'=>'thumbnail'));
                        echo Open('div',array('class'=>'col-md-3 pull-left', 'style'=>'min-height:300px;overflow:hidden'));
                            echo Open('div',array('class'=>'thumbnail text-center'));
                                if($prod->stock_bodega == 0){
                                        $danger= tagcontent('span','AGOTADO',array('class'=>'badge'));
                                    }else{
                                        $danger = '';
                                    }
                                echo tagcontent('a',$imagenbloc . $danger ,array('href'=>  base_url('shopping_cart/productos/product_detail?codigo='.$prod->codigo)));
                                echo Open('div',array('class'=>'caption','style'=>'text-align:center;'));
                                    echo tagcontent('p',$prod->codigo.' - '.get_short_string($prod->nombreUnico , 50 , false),array('style'=>'font-size:7pt'));
                                    echo Open('form',array('method'=>'post','action'=>  base_url('shopping_cart/cart/add_product')));
                                        echo tagcontent('a',  tagcontent('i','',array('class'=>'glyphicon glyphicon-search')),array('href'=> base_url('shopping_cart/productos/product_detail?codigo='.$prod->codigo),'class'=>'btn btn-primary btn-xs'));
                                       
                                        echo input(array('type'=>'hidden','name'=>'id', 'value'=>$prod->codigo));
                                        echo input(array('type'=>'hidden','name'=>'segment', 'value'=>$this->uri->segment(4)));
                                        echo input(array('type'=>'hidden','name'=>'select_precio', 'value'=>number_decimal($prod->precioOferta_sin_iva)));
                                        if($prod->stock_bodega > 0){
                                            echo tagcontent('button','Agregar'.  tagcontent('i','',array('class'=>'glyphicon glyphicon-shopping-cart')),array('class'=>'btn btn-success btn-xs','id'=>'ajaxformbtn','data-target'=>'res_info'));
                                        }else{
                                            echo tagcontent('button','Agregar'.  tagcontent('i','',array('class'=>'glyphicon glyphicon-shopping-cart')),array('disabled'=>'','class'=>'btn btn-success btn-xs','id'=>'ajaxformbtn','data-target'=>'res_info'));
                                        }
                                        
                                    echo Close('form');

                                    if(number_decimal($prod->precioNormal_con_iva) > 300){
                                        $span_cuotas = '<br>Ó 18 Coutas de: $'.  number_decimal($prod->cuota);
                                    }else{
                                        $span_cuotas = '';
                                    }
                                    echo tagcontent('strong','P. HOY: $'. number_decimal($prod->total_desc),array('class'=>'text-success'));
                                    echo tagcontent('div','P. Oferta: $<del>'. number_decimal($prod->precioOferta_con_iva).'</del>',array('class'=>'text-warning','style'=>'font-size:9pt','id'=>'precio','alt'=>  number_decimal($prod->precioOferta_con_iva)));
                                    echo tagcontent('div','P. Normal: $'.number_decimal($prod->precioNormal_con_iva).$span_cuotas,array('style'=>'font-size:7pt','id'=>'precio','alt'=>  number_decimal($prod->precioNormal_con_iva)));                                
                                    
                                echo Close('div');

                            echo Close('div');
                    //    $lipro = tagcontent('li',$divtub);
                        echo Close('div');
//                    }//fin if precios
                }//end foreach
            }else{
                $msj = ' con el nombre: '.$nombre_no_encontrado;
                echo no_results_msg($msj);
            }
            echo Close('ul');
            //echo tagcontent('ul',$div3,array('class'=>'thumbnails'));
        echo Close('div');//close div bloc-view
//        //---------------------------------
        echo lineBreak2(1, array('class'=>'clr'));
        echo Open('nav',array('class'=>'text-center')); //open div paginacion
            echo tagcontent('ul', $this->pagination->create_links(),array('class'=>'pagination'));
        echo Close('nav'); //close div paginacion
    echo Close('div');//close div tab-content

    
//=====================================================