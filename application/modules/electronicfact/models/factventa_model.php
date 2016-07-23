<?php

class Factventa_model extends CI_Model {

	function __construct()
	{
		parent::__construct();
	}
	
	// --------------------------------------------------------------------
      
	function save($form_data)
	{
            $this->db->insert('billing_facturaventa', $form_data);

            return $this->db->insert_id();
	}
        
        function get_detalle($venta_id)
	{
            $this -> db -> where('fd.facturaventa_codigofactventa',$venta_id);            
            $this -> db -> select('fd.id, fd.itemcantidad, fd.itempreciobruto, fd.itemprecioxcantidadbruto, fd.itemprecioneto, fd.itemprecioxcantidadneto, fd.bodega_id, fd.meses_garantia, p.nombreUnico product_name, p.codigo product_cod, p.esServicio servicio');
            $this -> db -> from('billing_facturaventadetalle fd');
            $this -> db -> join('billing_producto p','fd.Producto_codigo = p.codigo');
            $query = $this -> db -> get();

            return $query->result();
	}
        
        function get_cotizacion_det($venta_id)
	{
            $this -> db -> where('cotizacion_id',$venta_id);            
            $this -> db -> select('fd.id, fd.itemcantidad, fd.itempreciobruto, fd.itemprecioxcantidadbruto, fd.itemprecioneto, fd.itemprecioxcantidadneto, fd.bodega_id, p.nombreUnico product_name, p.codigo product_cod, p.esServicio servicio');
            $this -> db -> from('bill_cotizacion_venta_det fd');
            $this -> db -> join('billing_producto p','fd.Producto_codigo = p.codigo');
            $query = $this -> db -> get();

            return $query->result();
	}        
        
        function update_stock($prod_id, $qty, $signo = '-') {
            $this->db->where('codigo', $prod_id);
            if($signo == '-'){
                $this->db->set('stockactual', 'stockactual - '.$qty.'', FALSE);
            }else{
                $this->db->set('stockactual', 'stockactual + '.$qty.'', FALSE);                
            }

            $this->db->update('billing_producto');            
            return $this->db->affected_rows(); 
    
        }
                        
        function update_stock_bod_1($id,$bodegaid,$new_qty) {
        /* comprobar si el producto ya tiene un historial en la bodega que se va a ingresar ... */
            $this -> db -> select('bodega_id');
            $this -> db -> from('billing_stockbodega');           
            $this -> db -> where('bodega_id',$bodegaid);
            $this -> db -> where('Producto_codigo',$id);
            $this -> db -> limit(1);
            $query = $this -> db -> get();
            
            /* si ya existe un historial del producto en la bodega, 
             * entonces actualizamos el stock, caso contrario isertamos 
             * el registro del producto en esa bodega
             */
            if(!empty($query->row()->bodega_id)){
                $this->db->where('bodega_id', $bodegaid);
                $this->db->where('Producto_codigo', $id);
                $this->db->set('stock', $new_qty);
                $this->db->set('fultimact', date('Y-m-d',time()));
                $this->db->update('billing_stockbodega');                                               
                return $this->db->affected_rows();
            }else{
                $data = array(
                    'bodega_id'=>$bodegaid,
                    'Producto_codigo'=>$id,
                    'stock'=>$new_qty,
                    'fultimact'=>date('Y-m-d',time()),
                );
                $this->db->insert('billing_stockbodega', $data);
                return $this->db->affected_rows();
            }
/***************************************************************************************/               
        }        
        
        /* 
         * Actualizar el stock en la bodega
         * $signo => indica si el stock disminuye o aumenta
         */
        function update_stock_bod($prod_id,$bodegaid, $qty, $signo = '-') {
            /* actualizamos el stock del producto (salida) en la bodega correspondiente */
//            echo 'Paso 1';
                $this->db->where('bodega_id', $bodegaid);
                $this->db->where('Producto_codigo', $prod_id);
                if($signo == '-'){
                    echo 'Paso 2';
                    $this->db->set('stock', 'stock - '.$qty.'', FALSE);    
                }else{
                    echo 'Paso 3--->'.$qty;
                    $this->db->set('stock', 'stock + '.$qty.'', FALSE);    
                }
//                echo 'Paso 4';
                $this->db->update('billing_stockbodega');
                return $this->db->affected_rows();
/***************************************************************************************/               
        }
        
        
        /* obtenemos datos de la factura ( para registrar los asientos contables ) */
	function get($veta_id)
	{
            $this -> db -> where('codigofactventa',$veta_id);
            $this -> db -> select('fv.codigofactventa venta_id, fv.nroAutorizacion aut_sri, fv.fvenceautorizacion aut_vence, fv.puntoventaempleado_establecimiento establecimiento, fv.puntoventaempleado_puntoemision pemision, fv.secuenciafactventa nro_fact, fv.totalCompra, fv.subtnetobienes, fv.subtbrutobienes, fv.subtnetoservicios, fv.subtbrutoservicios, fv.iceval, fv.ivaval, fv.cliente_cedulaRuc client_id, fv.estado estado, fv.descuentovalor, fv.recargovalor, fv.subtotalBruto, fv.tarifacerobruto, fv.tarifadocebruto, fv.bodega_id, fv.descuentovalor descuento_venta, c.nombres client_nombres, c.apellidos client_apellidos, c.razonsocial razon_social, c.direccion client_direccion, c.telefonos client_telefonos');
            $this -> db -> from('billing_facturaventa fv');
            $this -> db -> join('billing_cliente c','fv.cliente_cedulaRuc = c.PersonaComercio_cedulaRuc');
            $this -> db -> limit(1);
            $query = $this -> db -> get();
            return $query->row_array();
	}
        
        
        /*  
         * return: estado de la factura (1,2,-1,-2)
         */
	function get_info($veta_id)
	{
            $this -> db -> where('codigofactventa',$veta_id);
            $this -> db -> select('estado, fechaarchivada');
            $this -> db -> from('billing_facturaventa');
            $this -> db -> limit(1);
            $query = $this -> db -> get();
//            $estado = $query->row()->estado;
            return $query->row();
	}
        
        
        function set_venta_archivada($venta_id) {
            $punto_venta = $this->get_punto_venta();
            
            $establecimiento = $this->session->userdata('establecimiento_venta');
            $pemision = $this->session->userdata('pemision_venta'); 
            
            /* actualizamos el stock del producto (salida) en la bodega correspondiente */
                $this->db->where('codigofactventa', $venta_id);
                $this->db->set('secuenciafactventa', $punto_venta['secuenciaultima'] + 1 );
                $this->db->set('puntoventaempleado_establecimiento', $establecimiento );
                $this->db->set('puntoventaempleado_puntoemision', $pemision );
                $this->db->set('fechaarchivada', date('Y-m-d',time()));
                $this->db->set('horaarchivada', date('H:i:s',time()));
                $this->db->set('estado', 2); //estado 2 => fact. archivada, 1 => fact. pendiente, -1 => pendiente anulada, -2 archivada anulada 
                $this->db->update('billing_facturaventa');
                
                $this->incrementa_secuencia();
                
                return $this->db->affected_rows();            
        }
        
        private function incrementa_secuencia() {
            $establecimiento = $this->session->userdata('establecimiento_venta');
            $pemision = $this->session->userdata('pemision_venta');            
            $secuencia = $this->session->userdata('secuencia_venta');
            
            /* Incrementamos la secuencia del punto de venta */    
                $this -> db -> where('establecimiento',$establecimiento);
                $this -> db -> where('puntoemision',$pemision);
                $this -> db -> where('tiposcomprobante_cod','01');
                $this->db->set('secuenciaultima', 'secuenciaultima + '. 1 .'', FALSE);
                $this->db->update('billing_puntoventaempleado');
                
                $new_secuencia = $secuencia + 1;
                $this->session->set_userdata('secuencia_venta', $new_secuencia );
                echo tagcontent('script', "$('#numerofactura').val('{$new_secuencia}')");
        }
        
        private function get_punto_venta() {
            $establecimiento = $this->session->userdata('establecimiento_venta');
            $pemision = $this->session->userdata('pemision_venta');
            
            /* Obtenemos la secuencia de la factura, junto con el nro autorizacion del SRI y su fecha de caducidad */
            $this -> db -> select('secuenciaultima');
            $this -> db -> from('billing_puntoventaempleado');
            $this -> db -> where('establecimiento',$establecimiento);
            $this -> db -> where('puntoemision',$pemision);
            $this -> db -> where('tiposcomprobante_cod','01');            
            $this -> db -> limit(1);
            $query = $this -> db -> get();
            $punto_venta = $query->row_array();
            return $punto_venta;
        }
        
        /*
         * Establece el estado de pendiente anulada o archivada anualda
         * param:
         * array(
         *      venta_id = $venta_id,
         *      observaciones = $observaciones,
         * )
         */
        function set_estado($data){
            $this -> db -> where('codigofactventa',$data['venta_id']);
            $this->db->set('estado', 'estado * (-1)', FALSE); // cambiamos el estado a anulado , con signo negativo 
            $this->db->set('estado_observ', $data['observaciones']);
            $this->db->set('estado_user', $this->user->id);
            $this->db->set('estado_fecha', date('Y-m-d',time()));
            $this->db->update('billing_facturaventa');      
            
            return $this->db->affected_rows();
        }
}