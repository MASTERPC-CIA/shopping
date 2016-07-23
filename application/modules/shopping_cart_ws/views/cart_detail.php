<script type="text/javascript">
    function obtenerComment(){
        var area = document.getElementById("comment").value;
        document.getElementById("comentario").value = area;
    }
            
</script>
<?php
echo lineBreaK(1, array('class'=>'clr'));
if(!empty($this->user->id)){
echo Open('div', array('id'=>'cart_list','class'=>'col-md-12'));
    $aregresar = tagcontent('a','Continuar Comprando',array('href'=>  base_url('shopping_cart/productos'),'class'=>'btn btn-default pull-right'));

    echo tagcontent('h3','Carrito de Compras [<small>'.$this->cart->total_items().'-Item(s)</small>]'.$aregresar);
    echo tagcontent('hr','',array('class'=>'soft'));

    if ($cart = $this->cart->contents()){
         echo Open('table', array('class'=>'table table-bordered table-striped table-condensed','id'=>'table_cart'));
                $thead = array('Cod.','Nombre','Cantidad','<span class="pull-left">Sub-Total</span>','Update');
                echo tablethead($thead);
               
                 foreach ($cart as $item){ 

                    echo Open('tr');
                        echo tagcontent('td', $item['id']);
                        echo tagcontent('td', tagcontent('a', $item['name'], array('id'=>"ajaxpanelbtnproductget",'data-target'=>"cxcpaneloutput",'title'=>"Enlace del Producto",'data-url'=>base_url().'admin/product/findbyid/'.$item['id'],'href'=>  base_url('shopping_cart/productos/product_detail?codigo='.$item['id']))));
                        echo tagcontent('td', $item['qty'],array('class'=>'pull-center'.$item['id']));
                        echo tagcontent('td','$ '. number_decimal($item['subtotal']),array('class'=>'number'.$item['id']));
                            echo Open('td');

                                echo Open('form',array('method'=>'post','action'=>  base_url('shopping_cart/cart/update_cart'),'class'=>'pull-left'));
                                    $rowmenos = $item['rowid'] . "-" . ($item['qty'] - 1 . "-" . $item['id']);
                                    $imenos = tagcontent('i','',array('class'=>'glyphicon glyphicon-minus'));
                                    echo input(array('type'=>'hidden','name'=>'row', 'value'=>$rowmenos));
                                    echo input(array('type'=>'hidden','name'=>'pago', 'value'=>'#pago'));
                                    echo tagcontent('button',$imenos,array('class'=>'btn btn-sm','id'=>'ajaxformbtn','data-target'=>'cart_list'));
                                echo Close('form');

                                echo Open('form',array('method'=>'post','action'=>  base_url('shopping_cart/cart/update_cart'),'class'=>'pull-left'));
                                    $rowmas = $item['rowid'] . "-" . ($item['qty'] + 1 . "-" . $item['id']);
                                    echo input(array('type'=>'hidden','name'=>'row', 'value'=>$rowmas));
                                    echo input(array('type'=>'hidden','name'=>'pago', 'value'=>'#pago'));
                                    $imas = tagcontent('i','',array('class'=>'glyphicon glyphicon-plus'));
                                    //echo tagcontent('a',$imas,array('class'=>'btn .btn-default','type'=>'button','href'=>  base_url('shopping_cart/productos/update_cart/'.$rowmas),'title'=>'Aumenta Producto al Carrito','data-target'=>'res_info'));
                                    echo tagcontent('button',$imas,array('class'=>'btn btn-sm','id'=>'ajaxformbtn','data-target'=>'cart_list'));
                                echo Close('form');

                                echo Open('form',array('method'=>'post','action'=>  base_url('shopping_cart/cart/delete_product'),'class'=>'pull-left'));
                                    $idrop = tagcontent('i','',array('class'=>'glyphicon glyphicon-remove icon-black'));
                                    echo input(array('type'=>'hidden','name'=>'row', 'value'=>$item['rowid']));
                                    echo input(array('type'=>'hidden','name'=>'pago', 'value'=>'#pago'));
                                    echo tagcontent('button',$idrop,array('class'=>'btn btn-sm','id'=>'ajaxformbtn','data-target'=>'cart_list'));
                                    //echo tagcontent('a',$idrop,array('class'=>'btn .btn-default btn-danger','title'=>'Retirar Producto del Carrito','href'=>base_url().'shopping_cart/productos/delete_product/' . $item['rowid']));
                                echo Close('form');

                            echo Close('td');

                   echo Close('tr');


                 } 

                 echo Open('tr');
                        echo tagcontent('td');
                        echo tagcontent('td', '<strong class="pull-right">Subtotal :</strong>',array('colspan'=>'1'));
                        echo tagcontent('td');
                        echo tagcontent('td', '<strong class="pull-left">$ '.  number_decimal($total_sin_desc).'</strong>',array('colspan'=>'2'));
                    echo Close('tr');
                    echo Open('tr');
                        echo tagcontent('td');
                        echo tagcontent('td', '<strong class="pull-right">Descuento :</strong>',array('colspan'=>'1'));
                        echo tagcontent('td',$tipocliente->descuento.'%');
                        echo tagcontent('td', '<strong class="pull-left">$ '.  number_decimal($diferencia).'</strong>',array('colspan'=>'2'));
                    echo Close('tr');
                    echo Open('tr');
                        echo tagcontent('td');
                        echo tagcontent('td', '<strong class="pull-right">Subtotal Neto :</strong>',array('colspan'=>'1'));
                        echo tagcontent('td');
                        echo tagcontent('td', '<strong class="pull-left">$ '.  number_decimal($total_con_desc).'</strong>',array('colspan'=>'2'));
                    echo Close('tr');
                    echo Open('tr');
                        echo tagcontent('td');
                        echo tagcontent('td', '<strong class="pull-right">IVA :</strong>',array('colspan'=>'1'));
                        echo tagcontent('td','12%');
                        echo tagcontent('td', '<strong class="pull-left">$ '.  number_decimal($iva).'</strong>',array('colspan'=>'2'));
                    echo Close('tr');
                    echo Open('tr');
                        echo tagcontent('td');
                        echo tagcontent('td', '<strong class="pull-right">Valor Total :</strong>',array('colspan'=>'1'));
                        $cantidad = $this->cart->total_items();
                        echo tagcontent('td', '<strong class="pull-left">'.$cantidad.'</strong>',array('colspan'=>'1'));
                        echo tagcontent('td', '<strong class="pull-left">$ '.  number_decimal($total).'</strong>',array('colspan'=>'2'));
                    echo Close('tr');

            echo Close('table');
            echo Open('form', array('action' => base_url('shopping_cart/cart/delete_cart/'), 'method' => 'post'));
                $rem = tagcontent('span','',array('class'=>'glyphicon glyphicon-remove'));
                echo tagcontent('button',$rem.' VACIAR CARRITO',array('type'=>'submit','class'=>'btn btn-danger btn-small pull-right','style'=>'margin-top: 8px;margin-left:3px;','id'=>'ajaxformbtn','data-target'=>'cart_list'));
            echo Close('form');
            echo Open('form', array('action' => base_url('shopping_cart/productos/paypal'), 'method' => 'post'));
                echo input(array('type'=>'hidden','name'=>'descuento', 'value'=>$tipocliente->descuento));
//                echo tagcontent('button','<i class="icon-paypal on-right on-left"></i>COMPRA PAYPAL',array('type'=>'submit','class'=>'btn btn-primary btn-small pull-right','style'=>'margin:3px;'));
                echo input(array('type'=>'image','src'=> base_url('img/Paypal-tarjeta-credit.png'),'class'=>' pull-right','width'=>130,'height'=>40, 'style'=>'border:outset;margin-top: 6px;margin-left:4px;'));
                //echo tagcontent('button',$rpay.' COMPRAR',array('type'=>'submit','class'=>'btn btn-primary btn-small pull-right','style'=>'margin:3px;'));
            echo Close('form');
        $desc = $this->cart->total() * $tipocliente->descuento / 100;
        $total_con_desc = $this->cart->total() - $desc;
        $iva = $total_con_desc * 12 / 100;  
        echo Open('form',array('action'=>'https://www.2checkout.com/checkout/purchase','method'=>'post'));
            echo input(array('type'=>'hidden','name'=>'sid','value'=>'202502630'));
            echo input(array('type'=>'hidden','name'=>'mode','value'=>'2CO'));
            $cont = 0; 
            foreach ($cart = $this->cart->contents() as $car){
                echo input(array('type'=>'hidden','name'=>'li_'.$cont.'_type','value'=>$car['id']));
                echo input(array('type'=>'hidden','name'=>'li_'.$cont.'_name','value'=>$car['name']));
                echo input(array('type'=>'hidden','name'=>'li_'.$cont.'_price','value'=>$car['price']));
                echo input(array('type'=>'hidden','name'=>'li_'.$cont.'_quantity','value'=>$car['qty']));
                $cont++;
            }
            $num_coupon = $cont+1;
            $num_imp = $cont+2;
            echo input(array('type'=>'hidden','name'=>'li_'.$num_coupon.'_type','value'=>'coupon'));
            echo input(array('type'=>'hidden','name'=>'li_'.$num_coupon.'_name','value'=>'Descuento'));
            echo input(array('type'=>'hidden','name'=>'li_'.$num_coupon.'_price','value'=>number_decimal($desc)));
            
            echo input(array('type'=>'hidden','name'=>'li_'.$num_imp.'_type','value'=>'tax'));
            echo input(array('type'=>'hidden','name'=>'li_'.$num_imp.'_name','value'=>'IVA 12%'));
            echo input(array('type'=>'hidden','name'=>'li_'.$num_imp.'_price','value'=>number_decimal($iva)));
            
            echo input(array('type'=>'hidden','name'=>'card_holder_name','value'=>$data_client->razonsocial));
            echo input(array('type'=>'hidden','name'=>'street_address','value'=>$data_client->direccion));
            echo input(array('type'=>'hidden','name'=>'country','value'=>'Ecuador'));
            echo input(array('type'=>'hidden','name'=>'email','value'=>$data_client->email));
            echo input(array('type'=>'hidden','name'=>'phone','value'=>$data_client->celular));
            echo input(array('type'=>'hidden','name'=>'lang','value'=>'es_la'));
            echo input(array('type'=>'image','src'=>base_url('img/logo-tarjetas-credito.png'),'class'=>'pull-right','width'=>'130','height'=>'40','style'=>'border:outset;margin-top: 6px;margin-left: 3px;'));
            
        echo Close('form');
                
//echo tagcontent('textarea','',array('id'=>'comentario','class'=>'form-control','name'=>'comentario','rows'=>'1','placeholder'=>'Escribenos tus observaciones...'));
//$comment = '<script type="text/javascript"> this.document.write(area) </script>';
                
            if($tipocliente->tipo == 'Concesionarios'){

                echo Open('form', array('action' => base_url('shopping_cart/productos/send_notify_email/'), 'method' => 'post','class'=>'col-md-6 pull-right'));
                    echo input(array('type'=>'hidden','name'=>'user_name', 'value'=>$data_client->razonsocial));
                    echo input(array('type'=>'hidden','name'=>'user_email', 'value'=>$data_client->email));
                    echo input(array('type'=>'hidden','name'=>'type_user', 'value'=>$tipocliente->tipo));
                    echo input(array('type'=>'hidden','name'=>'vendedor_id', 'value'=>$data_client->vendedor_id));
                    echo input(array('type'=>'hidden','name'=>'descuento', 'value'=>$diferencia));
                    echo input(array('type'=>'hidden','id'=>'comentario','name'=>'comentario','value'=>''));

                    echo lineBreaK(1, array('class'=>'clr'));
                    echo Open('div',array('class'=>'btn-group','data-toggle'=>'buttons'));
                        echo tagcontent('label','Difiere tu Compra a:');
                        echo lineBreaK(1, array('class'=>'clr'));
                        echo tagcontent('label',  input(array('type'=>'radio','name'=>'pago', 'value' => '30/60 D&iacute;as')).'60 D&iacute;as',array('class'=>'btn btn-default'));
                        echo tagcontent('label',  input(array('type'=>'radio','name'=>'pago', 'value' => '30/60/90 D&iacute;as')).'90 D&iacute;as',array('class'=>'btn btn-default'));
                        echo tagcontent('label',  input(array('type'=>'radio','name'=>'pago', 'value' => '30/60/120 D&iacute;as')).'120 D&iacute;as',array('class'=>'btn btn-default'));
                    echo Close('div');

                    $ema = tagcontent('span','',array('class'=>'glyphicon glyphicon-envelope'));
                    echo tagcontent('button',$ema.' NOTIFICAR PEDIDO',array('type'=>'submit','class'=>'btn btn-success btn-small','style'=>'margin:3px;','data-target'=>'res_info','id'=>'ajaxformbtn','onclick'=>"obtenerComment();"));
                echo Close('form');

            }
            echo tagcontent('textarea','',array('id'=>'comment','class'=>'form-control','name'=>'comment','rows'=>'1','placeholder'=>'Escribenos tus observaciones ó sugerencias...'));
//                echo Open('form', array('action' => base_url().'shopping_cart/twocheckout', 'method' => 'post'));
////                    //echo input(array('type'=>'hidden','name'=>'descuento', 'value'=>$tipocliente->descuento));
////    //                echo tagcontent('button','<i class="icon-paypal on-right on-left"></i>COMPRA PAYPAL',array('type'=>'submit','class'=>'btn btn-primary btn-small pull-right','style'=>'margin:3px;'));
////                    //echo input(array('type'=>'image','src'=> base_url('img/PayPal-tarjeta-credito.jpg'),'class'=>' pull-right','width'=>150,'height'=>40, 'style'=>'border:outset;'));
//                    echo tagcontent('button','2CHECKOUT',array('type'=>'submit','class'=>'btn btn-primary btn-small pull-right','style'=>'margin:3px;'));
//                echo Close('form');
 
            echo lineBreaK(2, array('class'=>'clr'));
            echo Open('div',array('class'=>'col-md-12 text-center'));
                $msg = 'Env&iacute;o a Nivel Nacional 48 horas sin costo!!!';
                echo info_msg($msg);
                echo lineBreaK(1, array('class'=>'clr'));
                echo tagcontent('label','PARA TRANSFERENCIAS');
                echo lineBreaK(1, array('class'=>'clr'));
                echo tagcontent('span','BANCO DE LOJA CTA. CTE. NRO. <strong style="background-color: yellow">2900954305</strong> A NOMBRE MASTERPC <br>'
                                        .'BANCO DEL PICHINCHA CTA. CTE. NRO. <strong style="background-color: yellow">2100074558</strong> A NOMBRE MASTERPC',array('style'=>'font-size:8pt'));
                echo lineBreaK(2, array('class'=>'clr'));
                echo tagcontent('label','CONTACTOS:');
                echo lineBreaK(2, array('class'=>'clr'));
                echo Open('div',array('class'=>'col-md-5'));//open div span3
                    
                    echo tagcontent('img','',array('src'=>base_url().'img/whatsapp.png','alt'=>'whatsapp','class'=>'col-md-4'));
                    echo Open('div',array('class'=>'col-md-7'));
                        echo tagcontent('label','EDDY: 0996534865');
                        echo lineBreaK(1, array('class'=>'clr'));
                        echo tagcontent('label','ROSITA: 099004989');
                    echo Close('div');
                echo Close('div');
                //echo lineBreaK(2, array('class'=>'clr'));
                echo Open('div',array('class'=>'col-md-5'));//open div span3
                    
                    echo tagcontent('img','',array('src'=>base_url().'img/logo-facebook.PNG','alt'=>'facebook','class'=>'col-md-3'));
                    echo Open('div',array('class'=>'col-md-8'));
                        echo tagcontent('label','Enlace a:');
                        echo tagcontent('a',' Master PC Loja',array('href'=>'https://www.facebook.com/masterpcloja'));
                    echo Close('div');
                echo Close('div');
            echo Close('div');
            
            
        }else{
            echo info_msg('El carrito de compras se encuentra vacio.');
        }    
      //=============================================cierre de div del header
echo Close('div');
echo tagcontent('div', '', array('id'=>'res_info','class'=>'col-md-12'));
}else{
    $msg = 'Debe loguearse para poder tener acceso al detalle del carrito de compras!!';
    echo warning_msg($msg);
}