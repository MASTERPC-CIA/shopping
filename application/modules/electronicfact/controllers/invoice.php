<?php
Class Invoice extends MX_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->user->check_session();
    }
        
//    function index()
//    {
//       $this->load->view('index');
//   //    $res['slidebar'] = $this->load->view('slidebar','',TRUE);
//   //    $res['slidebar'] = '';
//   //    $this->load->view('dashboard',$res);     
//    }
    
     public function get() {
        $this->load->library('grocery_CRUD');
        $this->config->load('grocery_crud');
        $this->config->set_item('grocery_crud_dialog_forms',true);
    //		$this->config->set_item('grocery_crud_default_per_page',10);            
                $crud = new grocery_CRUD();
                $crud->set_theme('datatables');

                $f_emision_desde = $this->input->post('f_emision_desde');
                $f_emision_hasta = $this->input->post('f_emision_hasta');
//                $f_vence_desde = $this->input->post('f_vence_desde');
//                $f_vence_hasta = $this->input->post('f_vence_hasta');
                $nro = $this->input->post('nro');
                    
                $crud->where('autorizado_sri', 1);
                    if(!empty($f_emision_desde) AND !empty($f_emision_hasta)){
                        $crud->where('fechaarchivada >=', $f_emision_desde);
                        $crud->where('fechaarchivada <=', $f_emision_hasta);
                    }
//                    if(!empty($f_vence_desde) AND !empty($f_vence_hasta)){
//                        $crud->where('fechavencefact >=', $f_vence_desde);
//                        $crud->where('fechavencefact <=', $f_vence_hasta);
//                    }

                    if(!empty($nro)){
                        $crud->where('secuenciafactventa', $nro);
                    }                
                
                $tiposcomprobante_cod = $this->input->post('tiposcomprobante_cod');
                $crud->where('puntoventaempleado_tiposcomprobante_cod', $tiposcomprobante_cod);

//                if(!empty($client_id)){
                    $crud->where('cliente_cedulaRuc', $this->user->id);
//                }

                $crud->set_table('billing_facturaventa');

                $columns = array(
                    'cliente_cedulaRuc', 
                    'nro_fact', 
                    'cod_fact_electronica', 
                    'fechaarchivada', 
//                    'fechavencefact', 
                    'totalCompra', 
//                    'subtnetobienes', 
//                    'subtnetoservicios'
                );

                $crud->columns2( $columns );
//                $edit_fields = array(
//                    'empleado_vendedor', 
//                    'tecnico_id', 
//                    'observaciones', 
//                );
//                $crud->edit_fields2($edit_fields);

                $crud->display_as('empleado_vendedor','Vendedor')
                     ->display_as('cliente_cedulaRuc','Cliente')
                     ->display_as('fechaarchivada','Emision.')
                     ->display_as('cod_fact_electronica','Clave de Acceso')
                     ->display_as('fechavencefact','Vence')
                     ->display_as('totalCompra','Total.')
                     ->display_as('subtnetobienes','Total Bienes')
                     ->display_as('subtnetoservicios','Total Serv.')
                     ->display_as('tipoprecio','Precio');

//                    $crud->callback_column('edit_client',array($this,'get_client_edit_link'));
                    $crud->callback_column('nro_fact',array($this,'get_nro_fact'));
                    $crud->callback_column('cod_fact_electronica',array($this,'get_xml_firmado'));
//                    $crud->callback_column('serie',array($this,'open_vista_series'));
//                    $crud->callback_column('utilidad',array($this,'get_utilidad_fact'));
//                    $crud->unset_actions();

                $crud->set_subject('Factuas De Venta');                        
                $crud->set_relation('cliente_cedulaRuc','billing_cliente','{PersonaComercio_cedulaRuc} {nombres} {apellidos}');
                $crud->set_relation('empleado_vendedor','billing_empleado','nombres');
                $crud->set_relation('tecnico_id','billing_empleado','nombres');

                $crud->set_relation_n_n('forma_pago', 'bill_ventatipopago', 'billing_tipopago', 'venta_id', 'tipopago_id', 'nombre');
                $crud->unset_jquery()->unset_jquery_ui();
                $crud->unset_add()->unset_edit()->unset_delete()->unset_read();
                $crud->unset_bootstrap();
                $output = $crud->render();
                $this->load->view('crud_view_datatable',$output);
    }
    
        public function get_nro_fact($value, $row)
        {          
            $sec_fact = $row->puntoventaempleado_establecimiento.$row->puntoventaempleado_puntoemision.'-'.$row->secuenciafactventa;
            $nro_fact = tagcontent('a', $sec_fact, array('target'=>'_blank','href'=>  get_settings('DOWNLOAD_FACT_XML').$row->cod_fact_electronica.'.pdf'));
            return $nro_fact;
            
        }
        
        public function get_xml_firmado($value, $row)
        {
            $nro_fact = tagcontent('a', $row->cod_fact_electronica, array('target'=>'_blank','href'=>  get_settings('DOWNLOAD_FACT_XML').$row->cod_fact_electronica.'_autorizado.xml'));
            return $nro_fact;
        }     
        
        
//        function open_fact($venta_id) {
//            $this->load->model('factventa_model');
//            $fields_fact = 'codigofactventa venta_id, nroAutorizacion aut_sri, fvenceautorizacion aut_vence, puntoventaempleado_establecimiento establecimiento, puntoventaempleado_puntoemision pemision, secuenciafactventa nro_fact, totalCompra, subtnetobienes, subtnetoservicios, iceval, ivaval, cliente_cedulaRuc client_id, estado estado, descuentovalor, recargovalor, subtotalBruto, tarifacerobruto, tarifadocebruto, bodega_id, estado, puntoventaempleado_tiposcomprobante_cod, fechaarchivada, tipo_pago, tecnico_id, empleado_vendedor, tipoprecio, fechaCreacion, hora, autorizado_sri, cod_fact_electronica';
//            $fact_data = $this->generic_model->get('billing_facturaventa', array('codigofactventa'=>$venta_id), $fields_fact, null, 1 );
//
//            $fields_client = '';
//            $client = $this->generic_model->get('billing_cliente', array('PersonaComercio_cedulaRuc'=>$fact_data->client_id), $fields_client, null, 1 );
//            
//            $fact['data'] = $fact_data;
//            $fact['client'] = $client;
//            
//            $fact['detalle'] = $this->factventa_model->get_detalle($venta_id);
//            $fact['bodega_name'] = $this->generic_model->get_val_where('billing_bodega', array('id'=>$fact_data->bodega_id), 'nombre', null, 0);
//            $fact['vendedor'] = $this->generic_model->get('billing_empleado', array( 'id'=>$fact_data->empleado_vendedor), 'nombres,apellidos', null, 1 );
//            $fact['tecnico'] = $this->generic_model->get('billing_empleado', array('id'=>$fact_data->tecnico_id), 'nombres, apellidos', null, 1);
//            $fact['pago'] = $this->generic_model->get('bill_venta_tipo', array('id'=>$fact_data->tipo_pago), 'tipo', null, 1);
//
//            $res_head['venta_id'] =  $venta_id;
//            $res_head['fact_data'] =  $fact_data;
//            
//            if($fact_data->puntoventaempleado_tiposcomprobante_cod == '01'){
//                if($fact_data->estado == 1){
//                    $fact['head'] = $this->load->view('head_fact_pendiente',$res_head,TRUE);
//                }  elseif ($fact_data->estado == 2) {
//                    $fact['head'] = $this->load->view('head_fact_archivada',$res_head,TRUE);                    
//                }  elseif ($fact_data->estado < 0) {
//                    $fact['head'] = $this->load->view('head_fact_anulada',$res_head,TRUE); 
//                }                
//            }elseif($fact_data->puntoventaempleado_tiposcomprobante_cod == '04'){
//                if($fact_data->estado == 1){
//                    $fact['head'] = $this->load->view('nota_credito_venta/head_ndc_pendiente',$res_head,TRUE);
//                }  elseif ($fact_data->estado == 2) {
//                    $fact['head'] = $this->load->view('nota_credito_venta/head_ndc_archivada',$res_head,TRUE);                    
//                }  elseif ($fact_data->estado < 0) {
//                    $fact['head'] = $this->load->view('nota_credito_venta/head_ndc_anulada',$res_head,TRUE); 
//                }                
//            }
//            
//            $this->load->view('fact_formato1',$fact);
//            echo tagcontent('script', '$("#factventaprint_view").printThis(optprint1)');            
//        }
        
         function open_fact($venta_id) {
             $this->load->model('factventa_model');
            $this->load->library('encript');
            
            $empresa_data = $this->generic_model->get(
                        'billing_empresa', 
                        array('id >'=>'0'), 
                        $fields = '', 
                        $order_by = null, 
                        $rows_num = 1
                    );
            $contribuyente_data = $this->generic_model->get(
                        'bill_contribuyente', 
                        array('id >'=>0), 
                        $fields = '', 
                        $order_by = null, 
                        $rows_num = 1
                    );
            
            $fields_fact = 'codigofactventa venta_id, nroAutorizacion aut_sri, fvenceautorizacion aut_vence, puntoventaempleado_establecimiento establecimiento, puntoventaempleado_puntoemision pemision, secuenciafactventa nro_fact, totalCompra, subtnetobienes, subtnetoservicios, iceval, ivaval, cliente_cedulaRuc client_id, estado estado, descuentovalor, recargovalor, subtotalBruto, subtotalNeto, tarifacerobruto, tarifadocebruto, bodega_id, estado, puntoventaempleado_tiposcomprobante_cod, fechaarchivada, tipo_pago, tecnico_id, empleado_vendedor, tipoprecio, fechaCreacion, hora, autorizado_sri, cod_fact_electronica';
            $fact_data = $this->generic_model->get('billing_facturaventa', array('codigofactventa'=>$venta_id), $fields_fact, null, 1 );

            $fields_client = '';
            $client = $this->generic_model->get('billing_cliente', array('PersonaComercio_cedulaRuc'=>$fact_data->client_id), $fields_client, null, 1 );
            
            $fact['empresa'] = $empresa_data;
            $fact['contribuyente'] = $contribuyente_data;
            $fact['data'] = $fact_data;
            $fact['client'] = $client;
            
            $fact['detalle'] = $this->factventa_model->get_detalle($venta_id);
            $fact['bodega_name'] = $this->generic_model->get_val_where('billing_bodega', array('id'=>$fact_data->bodega_id), 'nombre', null, 0);
            $fact['vendedor'] = $this->generic_model->get('billing_empleado', array( 'id'=>$fact_data->empleado_vendedor), 'nombres,apellidos', null, 1 );
            $fact['tecnico'] = $this->generic_model->get('billing_empleado', array('id'=>$fact_data->tecnico_id), 'nombres, apellidos', null, 1);
            $fact['pago'] = $this->generic_model->get('bill_venta_tipo', array('id'=>$fact_data->tipo_pago), 'tipo', null, 1);

            $res_head['venta_id'] =  $venta_id;
            $res_head['fact_data'] =  $fact_data;
            
            if($fact_data->puntoventaempleado_tiposcomprobante_cod == '01'){
                if($fact_data->estado == 1){
                    $fact['head'] = $this->load->view('head_fact_pendiente',$res_head,TRUE);
                }  elseif ($fact_data->estado == 2) {
                    $fact['head'] = $this->load->view('head_fact_archivada',$res_head,TRUE);                    
                }  elseif ($fact_data->estado < 0) {
                    $fact['head'] = $this->load->view('head_fact_anulada',$res_head,TRUE); 
                }                
            }elseif($fact_data->puntoventaempleado_tiposcomprobante_cod == '04'){
                if($fact_data->estado == 1){
                    $fact['head'] = $this->load->view('nota_credito_venta/head_ndc_pendiente',$res_head,TRUE);
                }  elseif ($fact_data->estado == 2) {
                    $fact['head'] = $this->load->view('nota_credito_venta/head_ndc_archivada',$res_head,TRUE);                    
                }  elseif ($fact_data->estado < 0) {
                    $fact['head'] = $this->load->view('nota_credito_venta/head_ndc_anulada',$res_head,TRUE); 
                }                
            }
            
            $this->load->view( 'fact_formato2', $fact );
            echo tagcontent( 'script', '$("#factventaprint_view").printThis(optprint1)' );
        }
        
 }
