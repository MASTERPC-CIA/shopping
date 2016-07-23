<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

//============================================================================

    echo Open('div', array('class' => 'well well-small')); //open div well
        echo tagcontent('strong',tagcontent('label', 'Promoci&oacute;n: Port&aacute;tiles - Tablets - Tel&eacute;fonos/Celulares', array('class'=>'bg-info text-center')));
        echo Open('div', array('class' => 'row-fluid'));
            echo Open('div', array('class' => 'carousel slide', 'id' => 'featured'));
                echo Open('div', array('class' => 'carousel-inner'));
                    if (!empty($remate_productos)) {
                        $liu = '';
                        $cont = 1;
                        //print_r($ultimos_productos);
                        foreach ($remate_productos as $up) {
                           //$imagencargar = '';
                                $imagencargar  = 'https://googledrive.com/host/0ByqQkg3INrbzQWR5aXdDWjc5UG8/'.$up->codigo.'.jpg'; 
                                $imagen = tagcontent('img', '', array('src' => $imagencargar, 'alt' => $up->codigo, 'style' => 'height:100px;width:100px;margin: auto;','class'=>'thumbnail'));
                                $ite = tagcontent('a', $imagen,array('href'=>  base_url('shopping_cart/productos/product_detail?codigo='.$up->codigo)));

                                $h5nombre = tagcontent('p',$up->codigo.' - '.get_short_string($up->nombreUnico , 50 , false),array('style'=>'font-size:7pt'));
                                if(number_decimal($up->precioNormal_con_iva) > 300){
                                    $cuot = '<br>Ó 18 Coutas de: $'.number_decimal($up->cuota);
                                }else{
                                    $cuot ='';
                                }
                                $p_descuent = tagcontent('span','<b>P. HOY: $'.number_decimal($up->total_desc).'</b>',array('class'=>'text-success'));
                                $poferta = tagcontent('div',' P. Oferta: $<del>'.number_decimal($up->precioOferta_con_iva).'</del>',array('class'=>'text-warning','style'=>'font-size:9pt;'));
                                $pcuotas= tagcontent('div',' P. Normal: $'.number_decimal($up->precioNormal_con_iva).$cuot,array('style'=>'font-size:7pt;'));

                                    $ver = tagcontent('a',  tagcontent('i','',array('class'=>'glyphicon glyphicon-search')),array('href'=> base_url('shopping_cart/productos/product_detail?codigo='.$up->codigo),'class'=>'btn btn-primary btn-xs'));
                                    $ver .= input(array('type'=>'hidden','name'=>'id', 'value'=>$up->codigo));
                                    $ver .= input(array('type'=>'hidden','name'=>'segment', 'value'=>$this->uri->segment(4)));
                                    $ver .= input(array('type'=>'hidden','name'=>'select_precio', 'value'=>number_decimal($up->precioOferta_sin_iva)));
                                    $ver .= tagcontent('button','Agregar'.  tagcontent('i','',array('class'=>'glyphicon glyphicon-shopping-cart')),array('class'=>'btn btn-success btn-xs','id'=>'ajaxformbtn','data-target'=>'res_info'));
    //                            echo Close('form');                                
                                $verform = tagcontent('form',$ver,array('method'=>'post','action'=>  base_url('shopping_cart/cart/add_product')));    

                                $h5btn = tagcontent('div',  $verform);
                                //AQUI CAMBIAR PRECIOS
                                $divcap = tagcontent('div',$h5nombre.$h5btn.$p_descuent.$poferta.$pcuotas,array('class'=>'caption','style'=>'text-align:center;'));
                                $divt = tagcontent('div', $ite . $divcap, array('class' => 'thumbnail'));
                                $liu .= tagcontent('div', $divt, array('class' => 'col-md-3'));
                                if ($cont == 4 ) {
                                    echo Open('div', array('class' => 'item active'));
                                        echo tagcontent('div', $liu, array('class' => 'thumbnails', 'height' => '200px'));
                                    echo Close('div'); //close div item
                                    $liu = '';
                                } else if ($cont % 4 == 0) {
                                    echo Open('div', array('class' => 'item'));
                                        echo tagcontent('div', $liu, array('class' => 'thumbnails', 'height' => '200px'));
                                    echo Close('div'); //close div item
                                    $liu = '';
                                }
                                if(sizeof($remate_productos) == $cont ){
                                    echo Open('div', array('class' => 'item'));
                                        echo tagcontent('div', $liu, array('class' => 'thumbnails', 'height' => '200px'));
                                    echo Close('div'); //close div item
                                    $liu = '';
                                }
                                $cont ++;
                            }
                        }
                   // }

                echo Close('div'); //close div carousel-inner
                $slide_left = tagcontent('span','',array('class'=>'glyphicon glyphicon-chevron-left btn','aria-hidden'=>TRUE,'color'=>'blue'));
                $slide_right = tagcontent('span','',array('class'=>'glyphicon glyphicon-chevron-right btn','aria-hidden'=>TRUE));
                echo tagcontent('a', $slide_left, array('href' => '#featured', 'class' => 'left carousel-control', 'data-slide' => 'prev', 'role' => 'button'));
                echo tagcontent('a', $slide_right, array('href' => '#featured', 'class' => 'right carousel-control', 'data-slide' => 'next', 'role' => 'button'));
            echo Close('div'); //close div myCarousel1
        echo Close('div'); //close div row
    echo Close('div'); //close div well
//=============================================================
    
    $this->load->view('products');