<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
if($producto){
echo tagcontent('div', '', array('id'=>'res_info','class'=>'col-md-12'));
echo tagcontent('h3',$producto->nombreUnico);
echo lineBreak2(1, array('clr'=>'clr'));
echo tagcontent('h3','Codigo: '.$producto->codigo);
echo lineBreak2(1, array('clr'=>'clr'));
       
    echo Open('div',array('class'=>'col-md-4','id'=>'gallery'));//open div span3
        $imagencargar = 'https://googledrive.com/host/0ByqQkg3INrbzQWR5aXdDWjc5UG8/'.$producto->codigo.'.jpg'; 
        echo tagcontent('img','',array('src'=>$imagencargar,'alt'=>$producto->codigo,'class'=>'img-thumbnail'));
    echo Close('div');//close div col-md-4
    
    echo Open('div',array('class'=>'col-md-6'));//open div span6
        echo Open('form', array('class'=>'form-horizontal qtyFrm','method'=>'post','action'=>  base_url('shopping_cart/cart/add_product')));
            echo Open('div',array('class'=>'control-group')); 
                echo Open('div',array('class'=>'control-group'));
                    echo tagcontent('label',tagcontent('span','Precio Normal: ')  ,array('class'=>'control-label'));
                    echo tagcontent('strong', ' $' . number_decimal($precioNormal_con_iva), array('value'=>number_decimal($precioNormal_sin_iva)));         
                echo Close('div');//div close control-group
                if($producto->productogrupo_codigo == $grupo_prod->codigo){
                    $spanggrupo = tagcontent('span',$grupo_prod->nombre);
                    echo tagcontent('label', 'Grupo: '.$spanggrupo,array('class'=>'control-label'));

                }
            echo Close('div');//div close control-group
            echo tagcontent('hr','',array('class'=>'soft'));    

            if ($stock <= 0){
                echo tagcontent('strong','NO TIENE STOCK EL PRODUCTO!!');
                $icomprar = tagcontent('i','COMPRAR',array('class'=>'icon-shopping-cart'));
                echo input(array('disabled'=>'disabled','type'=>'submit','value'=>'COMPRAR','class'=>'btn btn-success btn-lg pull-right'));
            }else{
                echo tagcontent('strong','PRODUCTO DISPONIBLE!!');
                echo form_hidden('id', $producto->codigo);
                echo form_hidden('segment', $this->uri->segment(4));
                echo form_hidden('select_precio',$precioOferta_sin_iva);
                echo tagcontent('button', tagcontent('i',' ',array('class'=>'glyphicon glyphicon-shopping-cart')).'COMPRAR',array('class'=>'btn btn-success btn-lg pull-right','id'=>'ajaxformbtn','data-target'=>'res_info'));
            }
             
        echo Close('form');
  
        echo tagcontent('hr','',array('class'=>'soft'));
        echo tagcontent('strong', 'P. Oferta $'.  number_decimal($precioOferta_con_iva),array('style'=>'font-size:16pt;'));
        if($precioNormal_con_iva > 300){
            echo tagcontent('strong', '<br> Ó 18 coutas de: $'.number_decimal($cuota));        
        }
        
    echo Close('div');//close div col-md-6
}else{
    echo error_info_msg('No existe un producto con el código '.$cod.' ingresado.');
}
   
