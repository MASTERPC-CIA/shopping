<?php
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
if($producto){
	
echo tagcontent('div',  '',array('id'=>'res_info','class'=>'col-md-12'));

echo tagcontent('h3',$producto->nombreUnico);
echo lineBreak2(1, array('clr'=>'clr'));
echo tagcontent('h3','Codigo: '.$producto->codigo);
echo lineBreak2(1, array('clr'=>'clr'));

echo Open('div',array('class'=>'col-sm-6'));
	echo Open('div',array('class'=>'product-images'));//open div span6
		echo Open('div',array('class'=>'product-main-img'));//open div span6 
			$imagencargar = 'https://googledrive.com/host/0ByqQkg3INrbzQWR5aXdDWjc5UG8/'.$producto->codigo.'.jpg'; 
			echo tagcontent('img','',array('src'=>$imagencargar,'alt'=>$producto->codigo,'class'=>'img-thumbnail'));
		echo Close('div');
	echo Close('div');
echo Close('div');     


echo Open('div',array('class'=>'col-sm-6'));
	echo Open('form', array('class'=>'form-horizontal qtyFrm','method'=>'post','action'=>  base_url('shopping_cart/cart/add_product')));
		echo Open('div',array('class'=>'product-inner'));
			echo tagcontent('h3',$producto->nombreUnico,array('class'=>'product-name'));
			echo tagcontent('h3','Codigo: '.$producto->codigo);
			echo lineBreak2(1, array('clr'=>'clr'));
			
			if($producto->productogrupo_codigo == $grupo_prod->codigo){
				$spanggrupo = tagcontent('span',$grupo_prod->nombre);
				echo tagcontent('label', 'Grupo: '.$spanggrupo,array('class'=>'control-label'));
			}  
			
			echo Open('div',array('class'=>'product-inner-price'));
				echo tagcontent('label',tagcontent('span','Precio Normal: ')  ,array('class'=>'control-label'));
				echo tagcontent('ins', ' $' . number_decimal($precioNormal_con_iva), array('value'=>number_decimal($precioNormal_sin_iva)));  
			echo Close('div');
				// echo tagcontent('button', 'COMPRAR',array('href'=> base_url(''),'class'=>'add_to_cart_button'));
			echo Open('div',array('class'=>'product-inner-price'));
				echo tagcontent('ins', 'P. Oferta $'.  number_decimal($precioOferta_con_iva),array('style'=>'font-size:16pt;'));
				if($precioNormal_con_iva > 300){
					echo tagcontent('ins', '<br> Ó 18 coutas de: $'.number_decimal($cuota));        
			}
			echo Close('div');
			if ($stock <= 0){
				echo tagcontent('strong','NO TIENE STOCK EL PRODUCTO!!');
				$icomprar = tagcontent('i','COMPRAR',array('class'=>'icon-shopping-cart'));
				echo input(array('disabled'=>'disabled','type'=>'submit','value'=>'COMPRAR','class'=>'btn btn-success btn-lg pull-right'));
			}else{
				echo tagcontent('strong','PRODUCTO DISPONIBLE!!');
				echo "<br>";
				echo form_hidden('id', $producto->codigo);
				echo form_hidden('segment', $this->uri->segment(4));
				echo form_hidden('select_precio',$precioOferta_sin_iva);
				echo tagcontent('button', '<span class="glyphicon glyphicon-search"></span> Buscar', array('name' => 'btnreportes', 'class' => 'btn btn-success btn-sm  col-md-1', 'id' => 'ajaxformbtn', 'type' => 'submit', 'data-target' => 'res_info'));

                                //echo tagcontent('button', tagcontent('i',' ',array('class'=>'glyphicon glyphicon-shopping-cart')).'COMPRAR',array('class'=>'add_to_cart_button','id'=>'ajaxformbtn','data-target'=>'res_info', 'type'=>'submit'));
				}
		 echo Close('div');
	 echo Close('form'); 
         
echo Close('div');//close div col-md-6
echo tagcontent("div", '',array('id'=>'res_info', 'name'=>'res_info'));
            $link_compartir = base_url().'shopping_cart/productos/product_detail?codigo='.$producto->codigo;  
//             $link_compartir =  'http://www.softwarepuntopymes.com/modules/producto/viewproductdet.php?id=6';
            $text_twitter = 'Productos tecnológicos: ';
            echo LineBreak();
            ?>
            <a class="twitter-share-button" href="$link_compartir"> Tweet</a>
            <div class="fb-share-button" data-href="<?php echo $link_compartir ?>" data-layout="button_count"></div>
            <div class="fb-comments" data-href="<?php echo $link_compartir ?>" data-width="100%" data-numposts="3" data-colorscheme="light"></div>

            <script>window.twttr = (function(d, s, id) {
                var js, fjs = d.getElementsByTagName(s)[0],
                 t = window.twttr || {};
                if (d.getElementById(id)) return t;
                js = d.createElement(s);
                js.id = id;
                js.src = "https://platform.twitter.com/widgets.js";
                fjs.parentNode.insertBefore(js, fjs);

                t._e = [];
                t.ready = function(f) {
                 t._e.push(f);
                };
              return t;
                }(document, "script", "twitter-wjs"));
            </script>

            <script>(function(d, s, id) {
                var js, fjs = d.getElementsByTagName(s)[0];
                if (d.getElementById(id)) return;
                js = d.createElement(s); js.id = id;
                js.src = "//connect.facebook.net/es_LA/sdk.js#xfbml=1&version=v2.3";
                fjs.parentNode.insertBefore(js, fjs);
              }(document, 'script', 'facebook-jssdk'));
            </script>
<?php

}else{
    echo error_info_msg('No existe un producto con el código '.$cod.' ingresado.');
}
   
?>

                        
                      