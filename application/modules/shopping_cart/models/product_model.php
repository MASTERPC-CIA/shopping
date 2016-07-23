<?php

class Product_model extends CI_Model {

	function __construct()
	{
		parent::__construct();
	}
	
        
        function get_product_by_name($name) {
//            function get_product_by_name($name, $marca_id = -1) {
            $parambuscaprod = explode(' ', $name);
            $where = '';
            $and = '';            
            foreach ( $parambuscaprod as $val ) {
                $where .= $and.'(UPPER(nombreUnico) LIKE "%'.strtoupper($val).'%" )';
                $and = ' AND ';                 
            }           
            $this -> db -> where($where, null, false); 
            $this -> db -> where('esServicio !=', 1);
            
//            if($marca_id != -1){
//                $this -> db -> where('marca_id', $marca_id);                 
//            }
            $this -> db -> order_by('codigo', 'desc'); 
            $this -> db -> select( 'codigo,nombreUnico,stockactual,costopromediokardex,productogrupo_codigo,marca_id');
//            $this -> db -> limit(10); 
            $this -> db -> from('billing_producto p'); 
            $query = $this -> db -> get();
            return $query->result();
        }
}