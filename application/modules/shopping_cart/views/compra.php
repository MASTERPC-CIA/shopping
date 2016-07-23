
   <?php 
       
           /* $spanprecio = tagcontent('span',
                    'TU COMPRA <span class="cart-amunt">'. number_decimal($this->cart->total()).'</span><span class="glyphicon glyphicon-shopping-cart"></span>',
                    array('class' => 'img-thumbnail text-center','id'=>'total_cart', 'style'=>'font-size:21px'));*/
    //$imgcart = tagcontent('img', '' . $spanprecio, array('alt' => 'cart', 'src' => base_url('resources/bootshop/assets/img/ico-cart.png')));
	$spanprecio = number_decimal($this->cart->total());
	  if(empty($this->user->id)){
                $data_target = '#loginModal';
                $data_togle = 'modal';
                $href = '';
            }  else {
                $data_target = '';
                $data_togle = '';
                $href = base_url('shopping_cart/cart');
            }
		echo '<a href="'.$href.'" id="myCart" data-toggle='.$data_togle.'  data-target='.$data_target.'>Tu compra - <span class="cart-amunt" >'.$spanprecio.'</span> <i class="glyphicon glyphicon-shopping-cart"></i> <span class="product-count"></span></a>';
                  
           // echo tagcontent('a', $spanprecio, array( 'href' => ,'data-target'=>$data_target,'data-toggle'=>$data_togle));
    
    ?>