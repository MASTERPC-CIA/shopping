<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Cart extends MX_Controller{
    
    public function __construct() {
        parent::__construct();
        $this->load->model(array('productos_model','product_model'));
        $this->load->helper('newform_helper');
        $this->load->library(array('pagination', 'cart', 'form_validation', 'table',"common/product",'user','common/client','common/stockbodega'));
//        $this->load->library("common/product");//load library//Cargamos las librerías
        $this->load->helper('text');
    }
    
    public function index() {
        
//            $pago = $this->input->get('pago');
            $datac['data_client'] = $this->client->get_client_data($this->user->id);
            $datac['tipocliente'] = $this->generic_model->get_by_id(
                    'billing_clientetipo',
                    $datac['data_client']->tipo_id,
                    'idclientetipo,tipo,descuento,default_price',
                    'idclientetipo');
            
            $datac['diferencia'] = $this->cart->total()*$datac['tipocliente']->descuento/100;
            $datac['total_sin_desc'] = number_decimal($this->cart->total());
            $datac['total_con_desc'] = $datac['total_sin_desc'] - $datac['diferencia'];
            $datac['iva'] = $datac['total_con_desc'] * 12 / 100;
            $datac['total'] = $datac['total_con_desc'] + $datac['iva'];

            $res_slidebar['title'] = 'Carrito de Compras';
            $res_slidebar['productos_marca'] = $this->generic_model->get_all('billing_marca');    
            
            $res_slidebar['grupos_producto'] = $this->generic_model->get_data( 
                'billing_productogrupo', 
               array('vista_web'=>1,'activo'=>1),
                'codigo,nombre,descripcion, meses_garantia', 
                array('nombre'=>'asc')  
            );            
                       
            $res['view'] = $this->load->view('cart_detail', $datac, TRUE);
            $res['slidebar'] = $this->load->view('slidebar', $res_slidebar, TRUE);
            //$res['top_nav_actions'] = $this->load->view('top_nav_actions', $datah, TRUE);        
            $res = $this->load->view('common/templates/dashboard_lte',$res);            

    }
    
    public function add_product() {
        $id = $this->input->post('id');
        $segment = $this->input->post('segment');
        $producto = $this->generic_model->get_by_id('billing_producto', $id, 'codigo,nombreUnico,stockactual', 'codigo');
//        $producto = $this->productos_model->por_Id($id);
        $url = base_url() . 'shopping_cart/productos/index/' . $segment;
//        echo 'hollllllll'.$id;    
        $row = '';
        $carrito = $this->cart->contents();
//        $stock = $this->product->get_stock_disponible($id);
        $bodegas_stock = $this->generic_model->get_data(
                'billing_stockbodega',
                array('producto_codigo'=>$id)
                );
        $bodegas_id = '';
        foreach ($bodegas_stock as $key => $bodega){
//                                        $nombre_bodega = $this->generic_model->get_by_id('billing_bodega', $bodega->bodega_id, 'id,nombre', 'id');
            $nombre_bodega = $this->generic_model->get(
                    'billing_bodega',
                    array('id'=>$bodega->bodega_id,'vistaweb'=>1),
                    'id,nombre'
                );
            if(!empty($nombre_bodega[0]->id)){
                $bodegas_id[$key] = $nombre_bodega[0]->id;
            }

            //$bod_arr['id'] = $bodegas_id; 

        }
//                            $bod = $bodegas_id;

        $stock = $this->productos_model->stock_disponoble_view($bodegas_id,$id);
        if ($carrito) {// verificamos si el carrito existe
            foreach ($carrito as $item) {//foreach contenedor
                if ($item['id'] === $id and $item['qty'] <= $stock) {
                    
                    $row = $item['rowid'] . "-" . ($item['qty'] + 1);
                    break;
                    // si se cumple la condición el foreach dejará de ejecutarse
                }else{
                    
                }
            }// fin del foreach contenedor
        }// fin del if que evalua si el carrito existe
        /* la variable $row contiene el rowid y el qty de cada producto concatenados; si esta
         * variable no está vacia significa que se debe actualizar el producto */

        if ($row !== '') {

            $this->update($row, $url);
        } elseif($stock > 0){
            $precio = $this->input->post('select_precio');
            $insert = array(
                'id' => $id,
                'price' => $precio,
                'qty' => 1,
                'name' => convert_accented_characters($producto->nombreUnico) // para quitar los acentos
            );

            $this->cart->insert($insert);
            echo tagcontent('script', '$("#total_cart").html("TU COMPRA $'. number_decimal($this->cart->total()).'+iva")');
            
            $msg = 'El producto '.$producto->nombreUnico.' fue agregado correctamente!';
            echo tagcontent('script', 'alertaExito("'.$msg.'")');
        }else{
            $msg = 'El producto '.$producto->nombreUnico.' tiene agotado el stock!';
            echo tagcontent('script', 'alertaError("'.$msg.'")');
//           echo warning_msg('El producto no se pudo agregar!');
        }
    }

/// fin de la método  add

    function update($row, $url) {
        $fila = explode('-', $row);
        $this->cart->update(array('rowid' => $fila[0], 'qty' => $fila[1]));

        //redirect($url);
    }

    function update_cart() {
        $row = $this->input->post('row');
        $fila = explode('-', $row);
        //$producto = $this->productos_model->por_Id($fila[2]);
        $producto = $this->generic_model->get_by_id(
                    'billing_producto',
                    $fila[2],
                    array('codigo','nombreUnico','stockactual','productogrupo_codigo'),
                    'codigo'
                );
        $stock = $this->product->get_stock_disponible($fila[2]);
        $datac['data_client'] = $this->client->get_client_data($this->user->id);
        $datac['tipocliente'] = $this->generic_model->get_by_id(
            'billing_clientetipo',
            $datac['data_client']->tipo_id,
            'idclientetipo,tipo,descuento,default_price',
            'idclientetipo');

        if($fila[1] <= $stock){
            $this->cart->update(array('rowid' => $fila[0], 'qty' => $fila[1]));

            $datac['diferencia'] = $this->cart->total()*$datac['tipocliente']->descuento/100;
            $datac['total_sin_desc'] = $this->cart->format_number($this->cart->total());
            $datac['total_con_desc'] = $datac['total_sin_desc'] - $datac['diferencia'];
            $datac['iva'] = $datac['total_con_desc'] * 12 / 100;
            $datac['total'] = $datac['total_con_desc'] + $datac['iva'];

            $this->load->view('cart_detail',$datac);
            echo tagcontent('script', '$("#total_cart").html("TU COMPRA $'. number_decimal($this->cart->total()).'+iva")');
        }else{
            $datac['diferencia'] = $this->cart->total()*$datac['tipocliente']->descuento/100;
            $datac['total_sin_desc'] = $this->cart->format_number($this->cart->total());
            $datac['total_con_desc'] = $datac['total_sin_desc'] - $datac['diferencia'];
            $datac['iva'] = $datac['total_con_desc'] * 12 / 100;
            $datac['total'] = $datac['total_con_desc'] + $datac['iva'];

            echo warning_msg('El producto '.$producto->nombreUnico.' solo tiene un stock de '.$stock.' !!');
            $this->load->view('cart_detail',$datac);
            //redirect('shopping_cart/productos/cart');
        }
//       
    }

    function delete_product() {
        $rowid = $this->input->post('row');

        $datac['data_client'] = $this->client->get_client_data($this->user->id);
        $datac['tipocliente'] = $this->generic_model->get_by_id(
            'billing_clientetipo',
            $datac['data_client']->tipo_id,
            'idclientetipo,tipo,descuento,default_price',
            'idclientetipo');
        $this->cart->update(array('rowid' => $rowid, 'qty' => 0));
        $datac['diferencia'] = $this->cart->total()*$datac['tipocliente']->descuento/100;
        $datac['total_sin_desc'] = $this->cart->format_number($this->cart->total());
        $datac['total_con_desc'] = $datac['total_sin_desc'] - $datac['diferencia'];
        $datac['iva'] = $datac['total_con_desc'] * 12 / 100;
        $datac['total'] = $datac['total_con_desc'] + $datac['iva'];

        $this->load->view('cart_detail',$datac);
        echo tagcontent('script', '$("#total_cart").html("TU COMPRA $'. number_decimal($this->cart->total()).'+iva")');
    }

    function delete_cart() {
        $this->cart->destroy();
        $this->session->set_flashdata('destruido', 'El carrito fue eliminado correctamente');
        $this->load->view('cart_detail');
        echo tagcontent('script', '$("#total_cart").html("TU COMPRA $'. number_decimal($this->cart->total()).'")');
//        redirect('/shopping_cart/productos/cart', 'refresh');
    }

}