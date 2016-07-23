<?php

if (!defined('BASEPATH'))
    exit('No direct script access');

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Productos extends MX_Controller {

    public function __construct() {
        parent::__construct();
        //$this->user->check_session();
        $this->load->model(array('productos_model', 'product_model'));
        $this->load->helper('newform_helper');
        $this->load->library(array('pagination', 'cart', 'form_validation', 'table', "common/product", 'user', 'common/client', 'common/stockbodega'));
//        $this->load->library("common/product");//load library//Cargamos las librerías
        $this->load->helper('text');
    }

    public function index() {

        /* esta parte es el codigo para cargar los productos en el sidebar */
        $where_in = array('nombre' => array('PORTATILES', 'TABLETS', 'TELEFONOS/CELULARES'));
        $nombre_grupo = $this->generic_model->get_in(
                'billing_productogrupo', $where_in, $where_not_in = null, 'codigo,nombre'
        );
        $where_in_prod = array('productogrupo_codigo' => array($nombre_grupo[0]->codigo, $nombre_grupo[1]->codigo, $nombre_grupo[2]->codigo));
        $productos_remate = $this->generic_model->get_in(
                'billing_producto', $where_in_prod, $where_not_in = null, 'codigo,nombreUnico,stockactual,costopromediokardex,productogrupo_codigo', $group_by = null, array('stockactual' => 'desc')
        );
        if (!empty($this->user->id)) {
//            $dataws =  file_get_contents('http://wsbillingsof.billingsof.com/index.php/clientes/datosCliente/'.$this->user->id);
//            $xml_client = simplexml_load_string($dataws);
//
//            $datac['data_client'] = $xml_client->get_client_data;
            $datac['data_client'] = $this->client->get_client_data($this->user->id);
            $datac['tipocliente'] = $this->generic_model->get_by_id(
                    'billing_clientetipo', $datac['data_client']->tipo_id, 'idclientetipo,tipo,descuento,default_price', 'idclientetipo'
            );
            $datac['clientetipo_precios'] = $this->generic_model->get_data(
                    'billing_clientetipotiposprecio', array('clientetipo_idclientetipo ' => $datac['tipocliente']->idclientetipo)
            );
        }

        if ($productos_remate) {
            $prod = $this->products_in_bod($productos_remate);
        } else {
            $prod = array();
        }
         $datac['remate_productos'] = $prod;

        /* carga todas las marcas */
        $res_slidebar['productos_marca'] = $this->generic_model->get_all('billing_marca');
        /* consulta de todos los productos */
        $all_product = $this->generic_model->get_all(
                'billing_producto', 'codigo,nombreUnico,stockactual', array('stockactual' => 'desc')
        );
        /* consulta los productos que no se pueden ver en el portal Ej: sin stock o es un servicio */
        $rest_product = $this->generic_model->count_all_results(
                'billing_producto', '', array('stockactual' => 0, 'costopromediokardex' => 0.0, 'esServicio' => 1)
        );
        /* productos que se veran segun la cantidad configurada por paginacion */
        $productos = $this->productos_model->get_productos(
                '', get_settings('SHOPPING_CART_PAG'), $this->uri->segment(4), ''
        );
        /* productos que se veran en el portal */
        //$producto_view = $this->products_in_bod($productos);
        /* total de productos que se cargaran para hacer la paginacion */
        $this->productos_model->paginacion(
                count($all_product) - $rest_product, 'index/', 4
        );

        //detalle de los productos que se mostraran en la pagina
        if ($productos) {
            $prod_view = $this->products_in_bod($productos);
        } else {
            $prod_view = array();
        }
		$datac["productos"] = $prod_view;
        $datac['producto_nombre'] = array();
        $datac["idgrupo"] = '';
        $datac['name_prod'] = '';
        $res_slidebar['grupos_producto'] = $this->generic_model->get_data(
                'billing_productogrupo', array('vista_web' => 1, 'activo' => 1), 'codigo,nombre,descripcion, meses_garantia', array('nombre' => 'asc')
        );
		
        $res["productos"] = $prod_view;
        $res['producto_nombre'] = array();
        $res["idgrupo"] = '';
        $res['name_prod'] = '';
        $res['grupos_producto'] = $this->generic_model->get_data(
                'billing_productogrupo', array('vista_web' => 1, 'activo' => 1), 'codigo,nombre,descripcion, meses_garantia', array('nombre' => 'asc')
        );

        $res['view'] = $this->load->view('front/content', $datac, TRUE);
        //$res['slidebar'] = $this->load->view('slidebar', $res_slidebar, TRUE);
        //$res['top_nav_actions'] = $this->load->view('top_nav_actions', $datah, TRUE);        
        // $res = $this->load->view('common/templates/dashboard_lte', $res);
	    $res['img_banner'] = $this->generic_model->get('bill_empre_images',array('deleted ='=>0));
        $res['setions'] = $this->generic_model->get('bill_empre_sections');
        $this->load->view('index',$res);
        //$this->load->view('common/templates/dashboard_lte', $res);
		
	 
    }
	//portal
	 function logout()
    {
      $this->session->sess_destroy();
      redirect( base_url('client_area/index') , 'refresh');
    }  

    private function products_in_bod($productos) {
        $prod = '';
        if (!empty($this->user->id)) {
//                $dataws =  file_get_contents('http://wsbillingsof.billingsof.com/index.php/clientes/datosCliente/'.$this->user->id);
//                $xml_client = simplexml_load_string($dataws);
            $data_client = $this->client->get_client_data($this->user->id);
//                $data_client = $xml_client->get_client_data;
            $tipocliente = $this->generic_model->get_by_id(
                    'billing_clientetipo', $data_client->tipo_id, 'idclientetipo,tipo,descuento,default_price', 'idclientetipo'
            );
        }

        foreach ($productos as $key => $value) {
            $bodegas_stock = $this->generic_model->get_data(
                    'billing_stockbodega', array('producto_codigo' => $value->codigo), 'bodega_id,producto_codigo,stock'
            );
            $bodegas_ids = $this->array_prod_bodegas($bodegas_stock);

            $stock = $this->productos_model->stock_disponoble_view($bodegas_ids, $value->codigo);
            if (!empty($this->user->id)) {
                $precios = $this->product->get_precio_prod($value->codigo, $tipocliente->default_price);
                $desc = $tipocliente->descuento;
            } else {
                $desc = 20.00;
                $precios = $this->product->get_precio_prod($value->codigo, 'pB');
            }
            $preciosN = $this->product->get_precio_prod($value->codigo, 'pA');
            $precioNI = $preciosN['price_iva'];
            $couta = ($precioNI * 1.24) / 18;
            $precioOferta_sin_iva = $precios['price'];
            $precioOferta_con_iva = $precios['price_iva'];
            ///descuento
            $descuento = $precioOferta_con_iva * $desc / 100;
            $total_des = $precioOferta_con_iva - $descuento;
            if ($stock > 0) {
                $prod[$key] = (object) array(
                            'codigo' => $value->codigo,
                            'nombreUnico' => $value->nombreUnico,
                            'stockactual' => $value->stockactual,
                            'costopromediokardex' => $value->costopromediokardex,
                            'stock_bodega' => $stock,
                            'precioOferta_sin_iva' => $precioOferta_sin_iva,
                            'precioOferta_con_iva' => $precioOferta_con_iva,
                            'precioNormal_con_iva' => $precioNI,
                            'cuota' => $couta,
                            'total_desc' => $total_des
                );
            }
        }

        return $prod;
    }

    public function paypal() {
        $discount = $this->input->post('descuento');
        $config['business'] = get_settings('PAYPAL_EMAIL'); //email que debe cobrar los productos
        $config['cpp_header_image'] = ''; //Url de una imagen de 750 px ancho por 90 px de alto
        $config["cpp_cart_border_color"] = get_settings('NAV_COLOR');
        $config['return'] = base_url('shopping_cart/productos/success'); //donde nos retorna si todo sale bien con los datos
        $config['cancel_return'] = base_url('shopping_cart/productos'); //si el usuario cancela la compra desde paypal
        $config['notify_url'] = base_url('/shopping_cart/productos/data_paypal_post'); //IPN Post, en return hacemos esto
        $config['production'] = TRUE; //Poner en falso para utilizar sandbox, true para paypal
        $config['discount_rate_cart'] = $discount; //Si queremos aplicar descuento
        $desc = $this->cart->total() * $discount / 100;
        $total_con_desc = $this->cart->total() - $desc;
        $iva = $total_con_desc * get_settings('IVA') / 100;
        $config["tax_cart"] = number_decimal($iva); //impuesto
        $config["invoice"] = rand(1000, 10000); //El id de la factura
        $config['currency_code'] = "USD";
        $this->load->library('common/paypal', $config);
        $carrito = $this->cart->contents();

        foreach ($carrito as $carro) {
            $this->paypal->add($carro['name'], $carro['price'], $carro['qty'], $carro['id']);
        }
        $this->paypal->pay();
    }

    public function success() {
        //guardar datos del carrito antes de finalizar la compra
        $data = $this->cart->contents();

        foreach ($data as $prod) {
            $producto = array(
                'codigo' => $prod['id'],
                'descripcion' => $prod['name'],
                'cantidad' => $prod['qty'],
                'valor' => $prod['subtotal'],
                'fecha' => date("Y-m-d"));
            $this->generic_model->save($producto, 'bill_test_cart');
        }
        $this->cart->destroy();
    }

    public function search_group_product($idgrupo, $name_prod) {
        $datah['productos_marca'] = $this->generic_model->get_all('billing_marca');
        $datah['title'] = 'Grupos de Productos';
//        $datah['nombreproducto'] = $name_prod;
        if (!empty($idgrupo)) {
            //$data["productos"] = $this->productos_model->get_products_codigo($id);
            $productos = $this->productos_model->get_productos(
                    $idgrupo, get_settings('SHOPPING_CART_PAG'), $this->uri->segment(6)
            );
            $productoxgrupo = $this->generic_model->get_data(
                    'billing_producto', array('productogrupo_codigo' => $idgrupo, 'stockactual !=' => 0, 'costopromediokardex !=' => 0.0, 'esServicio' => 0), 'codigo,nombreUnico,stockactual,costopromediokardex'
            );
            $this->productos_model->paginacion(
                    count($productoxgrupo), 'search_group_product/' . $idgrupo . '/' . $name_prod . '/', 6
            );
            if (!empty($this->user->id)) {
//                    $dataws =  file_get_contents('http://wsbillingsof.billingsof.com/index.php/clientes/datosCliente/'.$this->user->id);
//                    $xml_client = simplexml_load_string($dataws);
//
//                    $datah['data_client'] = $xml_client->get_client_data;
                $datah['data_client'] = $this->client->get_client_data($this->user->id);
                $datah['tipocliente'] = $this->generic_model->get_by_id(
                        'billing_clientetipo', $datah['data_client']->tipo_id, 'idclientetipo,tipo,descuento,default_price', 'idclientetipo');
                $datah['clientetipo_precios'] = $this->generic_model->get_data(
                        'billing_clientetipotiposprecio', array('clientetipo_idclientetipo =' => $datah['tipocliente']->idclientetipo)
                );
            }
            foreach ($productos as $key => $value) {
                $bodegas_stock = $this->generic_model->get_data(
                        'billing_stockbodega', array('producto_codigo' => $value->codigo), 'bodega_id,producto_codigo,stock'
                );

                $bodegas_ids = $this->array_prod_bodegas($bodegas_stock);
                $stock = $this->productos_model->stock_disponoble_view($bodegas_ids, $value->codigo);
                if (!empty($this->user->id)) {

                    $precios = $this->product->get_precio_prod($value->codigo, $datah['tipocliente']->default_price);
                    $desc = $datah['tipocliente']->descuento;
                } else {
                    $desc = 20.00;
                    $precios = $this->product->get_precio_prod($value->codigo, 'pB');
                }
                $preciosN = $this->product->get_precio_prod($value->codigo, 'pA');
                $precioNI = $preciosN['price_iva'];
                $couta = ($precioNI * 1.24) / 18;
                $precioOferta_sin_iva = $precios['price'];
                $precioOferta_con_iva = $precios['price_iva'];
                ///descuento
                $descuento = $precioOferta_con_iva * $desc / 100;
                $total_des = $precioOferta_con_iva - $descuento;
                if ($stock > 0) {
                    $prod[$key] = (object) array(
                                'codigo' => $value->codigo,
                                'nombreUnico' => $value->nombreUnico,
                                'stockactual' => $value->stockactual,
                                'costopromediokardex' => $value->costopromediokardex,
                                'stock_bodega' => $stock,
                                'precioOferta_sin_iva' => $precioOferta_sin_iva,
                                'precioOferta_con_iva' => $precioOferta_con_iva,
                                'precioNormal_con_iva' => $precioNI,
                                'cuota' => $couta,
                                'total_desc' => $total_des
                    );
                }
            }
        }
        $datah["productos"] = $prod;
        $datah['producto_nombre'] = array();
        $res_slidebar['grupos_producto'] = $this->generic_model->get_data(
                'billing_productogrupo', array('vista_web' => 1, 'activo' => 1), 'codigo,nombre,descripcion, meses_garantia', array('nombre' => 'asc')
        );
        //Se crea un arreglo en el cual se envian los datos que se reciben para realizar búsquedas
        $datah['idgrupo'] = $idgrupo;
        $datah['name_prod'] = $name_prod;
        $res['view'] = $this->load->view('products', $datah, TRUE);
        $res['slidebar'] = $this->load->view('slidebar', $res_slidebar, TRUE);
        //$res['top_nav_actions'] = $this->load->view('top_nav_actions', $datah, TRUE); 
        $res['setions'] = $this->generic_model->get('bill_empre_sections');       
        $res = $this->load->view('common/templates/dashboard_lte_portal', $res);
    }

    private function array_prod_bodegas($prod_bod_stock) {
        $bodegas_id = '';
        foreach ($prod_bod_stock as $key => $bodega) {
//                                        $nombre_bodega = $this->generic_model->get_by_id('billing_bodega', $bodega->bodega_id, 'id,nombre', 'id');
            $nombre_bodega = $this->generic_model->get(
                    'billing_bodega', array('id' => $bodega->bodega_id, 'vistaweb' => 1), 'id,nombre'
            );
            if (!empty($nombre_bodega[0]->id)) {
                $bodegas_id[$key] = $nombre_bodega[0]->id;
            }
        }
        return $bodegas_id;
    }

    public function get_products_by_name() {
        //$marca_id = $this->input->get('marca_id');
        $product_name = $this->input->get('product_name');
        $nombre = explode('/', $product_name);
//        echo $nombre[0];
        $res_slidebar['productos_marca'] = $this->generic_model->get_all('billing_marca');

        $productos = $this->product_model->get_product_by_name($nombre[0]);
//        print_r($data['productos']);
        if (!empty($this->user->id)) {
//                    $dataws =  file_get_contents('http://wsbillingsof.billingsof.com/index.php/clientes/datosCliente/'.$this->user->id);
//                    $xml_client = simplexml_load_string($dataws);
//
//                    $data['data_client'] = $xml_client->get_client_data;
            $data['data_client'] = $this->client->get_client_data($this->user->id);
            $data['tipocliente'] = $this->generic_model->get_by_id(
                    'billing_clientetipo', $data['data_client']->tipo_id, 'idclientetipo,tipo,descuento,default_price', 'idclientetipo');
            $data['clientetipo_precios'] = $this->generic_model->get_data(
                    'billing_clientetipotiposprecio', array('clientetipo_idclientetipo =' => $data['tipocliente']->idclientetipo)
            );
        }
        if ($productos) {
            foreach ($productos as $key => $value) {
                $bodegas_stock = $this->generic_model->get_data(
                        'billing_stockbodega', array('producto_codigo' => $value->codigo), 'bodega_id,producto_codigo,stock'
                );
                $bodegas_ids = $this->array_prod_bodegas($bodegas_stock);

                $stock = $this->productos_model->stock_disponoble_view($bodegas_ids, $value->codigo);
                if (!empty($this->user->id)) {
                    $precios = $this->product->get_precio_prod($value->codigo, $data['tipocliente']->default_price);
                    $desc = $data['tipocliente']->descuento;
                } else {
                    $desc = 20.00;
                    $precios = $this->product->get_precio_prod($value->codigo, 'pB');
                }
                $preciosN = $this->product->get_precio_prod($value->codigo, 'pA');
                $precioNI = $preciosN['price_iva'];
                $couta = ($precioNI * 1.24) / 18;
                $precioOferta_sin_iva = $precios['price'];
                $precioOferta_con_iva = $precios['price_iva'];
                ///descuento
                $descuento = $precioOferta_con_iva * $desc / 100;
                $total_des = $precioOferta_con_iva - $descuento;
                if ($stock > 0) {
                    $prod[$key] = (object) array(
                                'codigo' => $value->codigo,
                                'nombreUnico' => $value->nombreUnico,
                                'stockactual' => $value->stockactual,
                                'costopromediokardex' => $value->costopromediokardex,
                                'stock_bodega' => $stock,
                                'precioOferta_sin_iva' => $precioOferta_sin_iva,
                                'precioOferta_con_iva' => $precioOferta_con_iva,
                                'precioNormal_con_iva' => $precioNI,
                                'cuota' => $couta,
                                'total_desc' => $total_des
                    );
                }
            }
        } else {
            $prod = array();
            $data['nombre_no_encontrado'] = $nombre[0];
        }
        $data['producto_nombre'] = $prod;
        $data['productos'] = array();
        $data['idgrupo'] = '';
        $data['name_prod'] = '';
        $this->productos_model->paginacion(
                count($prod), 'get_products_by_name?product_name=' . $nombre[0], 4
        );

        $res_slidebar['grupos_producto'] = $this->generic_model->get_data(
                'billing_productogrupo', array('vista_web' => 1, 'activo' => 1), 'codigo,nombre,descripcion, meses_garantia', array('nombre' => 'asc')
        );

        $res['view'] = $this->load->view('products', $data, TRUE);
        $res['slidebar'] = $this->load->view('slidebar', $res_slidebar, TRUE);
        //$res['top_nav_actions'] = $this->load->view('top_nav_actions', $datah, TRUE);
        $res['setions'] = $this->generic_model->get('bill_empre_sections');        
        $res = $this->load->view('common/templates/dashboard_lte_portal', $res);
    }

    public function product_detail() {

        $cod = $this->input->get('codigo');
        $data['producto'] = $this->generic_model->get_by_id('billing_producto', $cod, array('codigo', 'nombreUnico', 'stockactual', 'productogrupo_codigo'), 'codigo');
        if (sizeof($data['producto']) > 0) {
            $data['grupo_prod'] = $this->generic_model->get_by_id('billing_productogrupo', $data['producto']->productogrupo_codigo, array('codigo', 'nombre', 'vista_web'), 'codigo'
            );
            If (!empty($this->user->id)) {
//            $dataws =  file_get_contents('http://wsbillingsof.billingsof.com/index.php/clientes/datosCliente/'.$this->user->id);
//            $xml_client = simplexml_load_string($dataws);
//            
//            $data_cli = $xml_client->get_client_data;
                $data_cli = $this->client->get_client_data($this->user->id);
            }

//        $data_cli = $this->client->get_client_data($this->user->id);
            if (empty($this->user->id) || $data_cli->tipo_id == 1) {
                $precioN = $this->product->get_precio_prod($cod, 'pA');
                $precioNormal_con_iva = $precioN['price_iva'];
                $precioNormal_sin_iva = $precioN['price'];
                $data['cuota'] = ($precioNormal_con_iva * 1.24) / 18;
                $data['precioNormal_con_iva'] = $precioNormal_con_iva;
                $data['precioNormal_sin_iva'] = $precioNormal_sin_iva;
                $precioOferta = $this->product->get_precio_prod($cod, 'pB');
                $data['precioOferta_sin_iva'] = $precioOferta['price'];
                $data['precioOferta_con_iva'] = $precioOferta['price_iva'];
            } else {
                $tipocliente = $this->generic_model->get_by_id(
                        'billing_clientetipo', $data_cli->tipo_id, 'idclientetipo,tipo,descuento,default_price', 'idclientetipo'
                );
                $precioN = $this->product->get_precio_prod($cod, 'pA');
                $precioNormal_con_iva = $precioN['price_iva'];
                $precioNormal_sin_iva = $precioN['price'];
                $data['cuota'] = ($precioNormal_con_iva * 1.24) / 18;
                $data['precioNormal_con_iva'] = $precioNormal_con_iva;
                $data['precioNormal_sin_iva'] = $precioNormal_sin_iva;
                $precioO = $this->product->get_precio_prod($cod, $tipocliente->default_price);
                $precioO_sin_iva = $precioO['price'];
                $precioO_con_iva = $precioO['price_iva'];
                $data['precioOferta_sin_iva'] = $precioO_sin_iva;
                $data['precioOferta_con_iva'] = $precioO_con_iva;
            }
            $bodegas_stock = $this->generic_model->get_data(
                    'billing_stockbodega', array('producto_codigo' => $cod)
            );
            $bodegas_id = '';
            foreach ($bodegas_stock as $key => $bodega) {
//$nombre_bodega = $this->generic_model->get_by_id('billing_bodega', $bodega->bodega_id, 'id,nombre', 'id');
                $nombre_bodega = $this->generic_model->get(
                        'billing_bodega', array('id' => $bodega->bodega_id, 'vistaweb' => 1), 'id,nombre'
                );
                if (!empty($nombre_bodega[0]->id)) {
                    $bodegas_id[$key] = $nombre_bodega[0]->id;
                }
            }

            $data['stock'] = $this->productos_model->stock_disponoble_view($bodegas_id, $cod);
        }
        $data['cod'] = $cod;
        $res['view'] = $this->load->view('product_detail', $data, TRUE);
        $res_slidebar['productos_marca'] = $this->generic_model->get_all('billing_marca');
        $res_slidebar['grupos_producto'] = $this->generic_model->get_data(
                'billing_productogrupo', array('vista_web' => 1, 'activo' => 1), 
                'codigo,nombre,descripcion, meses_garantia', array('nombre' => 'asc')
        );
        $res['slidebar'] = $this->load->view('slidebar', $res_slidebar, TRUE);
        $res['setions'] = $this->generic_model->get('bill_empre_sections');
        $res = $this->load->view('common/templates/dashboard_lte_potal', $res);
    }

    public function load_image() {
//        $ds = DIRECTORY_SEPARATOR;  //1
// 
//        $storeFolder = '/../../../../img/prod_images';   //2
//        if(!empty($this->user->id)){
        if (!empty($_FILES)) {
            $_FILES['file']['name'] = $this->input->post('id') . '.jpg';
            $_FILES['file']['type'] = 'image/jpeg';
            $tempFile = $_FILES['file']['tmp_name']; //3              
//            $targetPath = dirname( __FILE__ ) . $ds. $storeFolder . $ds;  //4  
//            $targetFile =  $targetPath. $_FILES['file']['name'];  //5
            $nameImg = $_FILES['file']['name'];
            //move_uploaded_file($tempFile,$targetFile); //6 

            require_once realpath(dirname(__FILE__) . '/../../common/libraries/google-api-php-cliente/autoload.php');
            //      Datos obtenidos en la Consola de Desarrolladores de Google
            $cliente_id = '792070845245-53cs74geuk3r9l467b57mbcu216c6i9c.apps.googleusercontent.com';
            $email_servicio = '792070845245-53cs74geuk3r9l467b57mbcu216c6i9c@developer.gserviceaccount.com';
            $direccion_key = get_settings('DRIVE_KEY_PATH');
            //      Creación de un objeto tipo Client
            $client = new Google_Client();
            $client->setClientId($cliente_id);
            if (isset($_SESSION['service_token'])) {
                $client->setAccessToken($_SESSION['service_token']);
            }
            $key = file_get_contents($direccion_key);
            $credencial = new Google_Auth_AssertionCredentials(
                    $email_servicio, array('https://www.googleapis.com/auth/drive'), $key
            );
            $client->setAssertionCredentials($credencial);

            $_SESSION['service_token'] = $client->getAccessToken();
            //      Selección del tipo de servicio en este caso Drive
            $service_drive = new Google_Service_Drive($client);
            //Creación del archivo para guardarlo en Drive
            $file = new Google_Service_Drive_DriveFile();
            $file->setTitle($nameImg);
            $file->setDescription('Imagen Producto');
            $file->setMimeType('image/jpeg');
            //Id de la carpeta en Drive
            $carpetaId = get_settings('DRIVE_HOST_IMAGES');
            //Establecer la carpeta en donde se guardara en Drive
            if ($carpetaId != null) {
                $carpeta = new Google_Service_Drive_ParentReference();
                $carpeta->setId($carpetaId);
                $file->setParents(array($carpeta));
            }
            $data = file_get_contents($tempFile);
            //Inserción del archivo en Drive
            $service_drive->files->insert($file, array(
                'data' => $data,
                'uploadType' => 'media'
            ));
            //print $imagen_creada->getId();
        }
//         }else{
//            $this->load->view('login/login_view');
//        }
    }

    public function pruducts_marca() {
        $marca_id = $this->input->get('marca_id');
        $res_slidebar['productos_marca'] = $this->generic_model->get_all('billing_marca');
        $res_slidebar['title'] = 'Grupos de Productos';
        $marca = $this->generic_model->get_by_id(
                'billing_marca', $marca_id, 'nombre', 'id'
        );

        $productos = $this->generic_model->get_data(
                'billing_producto', array('marca_id' => $marca_id, 'esServicio' => 0, 'costopromediokardex >' => 0.0, 'stockactual >' => 0), 'codigo,nombreUnico,costopromediokardex,stockactual,productogrupo_codigo,marca_id', array('stockactual' => 'desc')
        );
//        print_r($data['productos']);
        $data['productos'] = array();
        $this->productos_model->paginacion(
                count($productos), 'pruducts_marca?marca_id=' . $marca_id, 4
        );
        if (!empty($this->user->id)) {
//            $dataws =  file_get_contents('http://wsbillingsof.billingsof.com/index.php/clientes/datosCliente/'.$this->user->id);
//            $xml_client = simplexml_load_string($dataws);
//
//            $data['data_client'] = $xml_client->get_client_data;
            $data['data_client'] = $this->client->get_client_data($this->user->id);
            $data['tipocliente'] = $this->generic_model->get_by_id(
                    'billing_clientetipo', $data['data_client']->tipo_id, 'idclientetipo,tipo,descuento,default_price', 'idclientetipo');
            $data['clientetipo_precios'] = $this->generic_model->get_data(
                    'billing_clientetipotiposprecio', array('clientetipo_idclientetipo =' => $data['tipocliente']->idclientetipo)
            );
        }
        if ($productos) {
            foreach ($productos as $key => $value) {
                $bodegas_stock = $this->generic_model->get_data(
                        'billing_stockbodega', array('producto_codigo' => $value->codigo), 'bodega_id,producto_codigo,stock'
                );
                $bodegas_ids = $this->array_prod_bodegas($bodegas_stock);

                $stock = $this->productos_model->stock_disponoble_view($bodegas_ids, $value->codigo);
                if (!empty($this->user->id)) {

                    $precios = $this->product->get_precio_prod($value->codigo, $data['tipocliente']->default_price);
                    $desc = $data['tipocliente']->descuento;
                } else {
                    $desc = 20.00;
                    $precios = $this->product->get_precio_prod($value->codigo, 'pB');
                }
                $preciosN = $this->product->get_precio_prod($value->codigo, 'pA');
                $precioNI = $preciosN['price_iva'];
                $couta = ($precioNI * 1.24) / 18;
                $precioOferta_sin_iva = $precios['price'];
                $precioOferta_con_iva = $precios['price_iva'];
                ///descuento
                $descuento = $precioOferta_con_iva * $desc / 100;
                $total_des = $precioOferta_con_iva - $descuento;
                if ($stock > 0) {
                    $prod[$key] = (object) array(
                                'codigo' => $value->codigo,
                                'nombreUnico' => $value->nombreUnico,
                                'stockactual' => $value->stockactual,
                                'costopromediokardex' => $value->costopromediokardex,
                                'stock_bodega' => $stock,
                                'precioOferta_sin_iva' => $precioOferta_sin_iva,
                                'precioOferta_con_iva' => $precioOferta_con_iva,
                                'precioNormal_con_iva' => $precioNI,
                                'cuota' => $couta,
                                'total_desc' => $total_des
                    );
                }
            }
        } else {
            $prod = array();
            $data['nombre_no_encontrado'] = $marca->nombre;
        }
        $data['idgrupo'] = '';
        $data['name_prod'] = '';
        $data['producto_nombre'] = $prod;
        $res_slidebar['grupos_producto'] = $this->generic_model->get_data(
                'billing_productogrupo', array('vista_web' => 1, 'activo' => 1), 'codigo,nombre,descripcion, meses_garantia', array('nombre' => 'asc')
        );

        $res['view'] = $this->load->view('products', $data, TRUE);
        $res['slidebar'] = $this->load->view('slidebar', $res_slidebar, TRUE);
//            $res['top_nav_actions'] = $this->load->view('top_nav_actions', $datah, TRUE);        
        $res['setions'] = $this->generic_model->get('bill_empre_sections');
        $res = $this->load->view('common/templates/dashboard_lte_portal', $res);
    }

    public function send_notify_email() {
//        $this->load->library("Email");
        $this->load->library('common/mailsms');
        $this->cliente = new mailsms();

        $usuario = $this->input->post('user_name');
        $tipo_usuario = $this->input->post('type_user');
        $email_usuario = $this->input->post('user_email');
        $vendedor_id = $this->input->post('vendedor_id');
        $descu = $this->input->post('descuento');
        $tipo_pago = $this->input->post('pago');
        $comentario = $this->input->post('comentario');

        $empleado = $this->generic_model->get_by_id(
                'billing_empleado', $vendedor_id, 'nombres,apellidos,email', 'id');

        if ($cart = $this->cart->contents()) {
            $this->table->set_heading('Codigo', 'Nombre', 'Cantidad', 'SubTotal'); // la tabla que irá en el correo
            foreach ($cart as $item) {
                $codigo = $item['id'];
                $nombre = $item['name'];
                $cantidad = $item['qty'];
                $precio = ($item['price'] * $item['qty']);
                $this->table->add_row($codigo, $nombre, $cantidad, $precio);
            } // fin del foreach
            $total_sin_desc = $this->cart->total();
            $total_con_desc = $total_sin_desc - $descu;
            $iva = $total_con_desc * get_settings('IVA') / 100;
            $valor_total = $total_con_desc + $iva;
            $this->table->add_row('', '', 'SubTotal: ', number_decimal($total_sin_desc));
            $this->table->add_row('', '', 'Descuento: ', number_decimal($descu));
            $this->table->add_row('', '', 'Subtotal Neto: ', number_decimal($total_con_desc));
            $this->table->add_row('', '', 'IVA'. get_settings('IVA') .'%: ', number_decimal($iva));
            $this->table->add_row('', '', 'Valor Total: ', number_decimal($valor_total));
            if (empty($tipo_pago)) {
                $tipo_pago = '30 D&iacute;as';
            }
            $message = '<h3>INFORMACI&Oacute;N DEL CLIENTE</h3><br>'
                    . '<label>Señor(a): </label>' . $usuario . '<br>'
                    . '<label>Tipo: </label>' . $tipo_usuario . '<br>'
                    . '<label>Correo: </label>' . $email_usuario . '<br>'
                    . '<label>Telefonos: </label>' . $this->input->post('telefonos') . '<br>'
                    . '<label>Tipo de Pago: ' . $tipo_pago . '</label><br>'
                    . '<h4>DETALLES DEL PEDIDO</h4>';
            $observacion = '<h3>OBSERVACI&Oacute;N</h3><br>' . $comentario;
            $pedido = $message . $this->table->generate() . '<br>'
                    . $observacion;  // concatenamos el mensaje con la tabla que contiene el pedido
            if (!empty($empleado)) {
                //$correos_to = array('dannyjimenez110@gmail.com');
                $correos_to = array($empleado->email, $email_usuario, 'rtorres@masterpc.com.ec');
            } else {
//               $correos_to = array('dannyjimenez110@gmail.com');
                $correos_to = array('masterpc@masterpc.com.ec', $email_usuario, 'rtorres@masterpc.com.ec');
            }
            foreach ($correos_to as $correo_a) {
                $correo = $this->cliente->send_mail(
                        $correo_a, //correo a quien se le envia
                        'Pedido Productos', //titulo del mensaje
                        $pedido, //mensaje a enviar
                        TRUE, //true cuando el tipo de mensaje que se envia es html
                        'webmasterpcloja@gmail.com', //correo remitente
                        'Webmasterpcloja@123'//contraseña remitente
                );
            }
            if ($correo->MailResult == 'ENVIADO') {
                $msg = 'El pedido se envió correctamente por correo!';
                echo tagcontent('script', 'alertaExito("' . $msg . '")');
                echo info_msg($msg);
                $this->cart->destroy();
                echo tagcontent('script', '$("#cart_list").html("")');
                echo tagcontent('script', '$("#total_cart").html("TU COMPRA $' . number_decimal($this->cart->total()) . '")');
            } else {
                $msg = 'El pedido no se pudo enviar por correo!';
                echo tagcontent('script', 'alertaError("' . $msg . '")');
            }
        }
    }

    /* Función que permite generar un catálogo en formato pdf por categoría de producto */

    public function generar_catalogo_pdf($idgrupo, $name_prod) {

        $datah['productos_marca'] = $this->generic_model->get_all('billing_marca');
        $datah['title'] = 'Grupos de Productos';
        if (!empty($idgrupo)) {

            $productos = $this->productos_model->get_productos(
                    $idgrupo, get_settings('SHOPPING_CART_PAG'), $this->uri->segment(6)
            );
            $productoxgrupo = $this->generic_model->get_data(
                    'billing_producto', array('productogrupo_codigo' => $idgrupo, 'stockactual !=' => 0, 'costopromediokardex !=' => 0.0, 'esServicio' => 0), 'codigo,nombreUnico,stockactual,costopromediokardex'
            );
            $this->productos_model->paginacion(
                    count($productoxgrupo), 'search_group_product/' . $idgrupo . '/' . $name_prod . '/', 6
            );
            if (!empty($this->user->id)) {
                $datah['data_client'] = $this->client->get_client_data($this->user->id);
                $datah['tipocliente'] = $this->generic_model->get_by_id(
                        'billing_clientetipo', $datah['data_client']->tipo_id, 'idclientetipo,tipo,descuento,default_price', 'idclientetipo');
                $datah['clientetipo_precios'] = $this->generic_model->get_data(
                        'billing_clientetipotiposprecio', array('clientetipo_idclientetipo =' => $datah['tipocliente']->idclientetipo)
                );
            }
            foreach ($productos as $key => $value) {
                $bodegas_stock = $this->generic_model->get_data(
                        'billing_stockbodega', array('producto_codigo' => $value->codigo), 'bodega_id,producto_codigo,stock'
                );

                $bodegas_ids = $this->array_prod_bodegas($bodegas_stock);
                $stock = $this->productos_model->stock_disponoble_view($bodegas_ids, $value->codigo);
                if (!empty($this->user->id)) {

                    $precios = $this->product->get_precio_prod($value->codigo, $datah['tipocliente']->default_price);
                    $desc = $datah['tipocliente']->descuento;
                } else {
                    $desc = 20.00;
                    $precios = $this->product->get_precio_prod($value->codigo, 'pB');
                }
                $preciosN = $this->product->get_precio_prod($value->codigo, 'pA');
                $precioNI = $preciosN['price_iva'];
                $couta = ($precioNI * 1.24) / 18;
                $precioOferta_sin_iva = $precios['price'];
                $precioOferta_con_iva = $precios['price_iva'];
                ///descuento
                $descuento = $precioOferta_con_iva * $desc / 100;
                $total_des = $precioOferta_con_iva - $descuento;

                if ($stock > 0) {
                    $prod[$key] = (object) array(
                                'codigo' => $value->codigo,
                                'nombreUnico' => $value->nombreUnico,
                                'stockactual' => $value->stockactual,
                                'costopromediokardex' => $value->costopromediokardex,
                                'stock_bodega' => $stock,
                                'precioOferta_sin_iva' => $precioOferta_sin_iva,
                                'precioOferta_con_iva' => $precioOferta_con_iva,
                                'precioNormal_con_iva' => $precioNI,
                                'cuota' => $couta,
                                'total_desc' => $total_des
                    );
                }
            }
        }
        $datah["productos"] = $prod;
        $datah['producto_nombre'] = array();

        $this->load->library('mpdf60/mpdf');
        $mpdf = new mPDF();
       
        $stylesheet = file_get_contents('./resources/bootstrap-3.2.0/css/bootstrap.min.css');
        $mpdf->WriteHTML($stylesheet, 1);
        $mpdf->WriteHTML($this->load->view('shopping_cart/products_catalogpdf', $datah, true));
        $name_catalog = time();
        $mpdf->Output('./uploads/catalogospdf/' . $name_catalog . '.pdf', 'F');
        return $mpdf;
    }
// Crea, guarda en Drive y presenta la factura en formato pdf
    public function create_pdf($idgrupo, $name_prod) {
        $mpdf = $this->generar_catalogo_pdf($idgrupo, $name_prod);
        $mpdf->Output();
    }

}
