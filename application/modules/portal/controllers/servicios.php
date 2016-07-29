<?php

Class Servicios extends MX_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('common/empleadocapacidad_model');
        $this->load->library('grocery_CRUD');
        // $this->load->model(array('productos_model','product_model'));
        $this->load->helper('newform_helper');
        $this->load->library(array('pagination', 'cart', 'form_validation', 'table', "common/product", 'user', 'common/client', 'common/stockbodega'));
//        $this->load->library("common/product");//load library//Cargamos las librerías
        $this->load->helper('text');
    }

    public function get_reporte_servicio_portal() {
        $client_id = $this->input->post('client_id');
        $secuencia =  $this->input->post('secuencia');
        
        if($client_id!='' && $secuencia!='' ){
            $where_data = array('c.PersonaComercio_cedulaRuc' => $client_id, 's.id'=>$secuencia);
        }else if($client_id!='' && $secuencia==''){
            $where_data = array('c.PersonaComercio_cedulaRuc');
        }else if($client_id=''&& $secuencia!=''){
               $where_data = array('s.id'=>$secuencia);
        }
        
        
        $fields = 's.id, c.PersonaComercio_cedulaRuc, 
            concat(c.PersonaComercio_cedulaRuc,": ", c.nombres, " ", c.apellidos, ", Telf. ",c.telefonos) as nombres,
            s.nombre_equipo, s.problema, m.nombre, s.presupuesto, s.fecha, s.fechaentrega';
        $join_cluase = array(
            '0' => array('table' => 'billing_cliente c', 'condition' => 's.cliente_id = c.PersonaComercio_cedulaRuc'),
            '1' => array('table' => 'billing_marca m', 'condition' => 'm.id=s.marca_id'),
        );

        $where_data = array('c.PersonaComercio_cedulaRuc' => $client_id);

        $res['equipo'] = $this->generic_model->get_join('bill_stequipo s', $where_data, $join_cluase, $fields = '', 0);
        $res['num_registros'] = count($res['equipo']);


        $resultado = $this->load->view('shopping_cart/portal/list_servicio', $res);
        // echo $resultado;
    }

    public function doc_estado_view($id) {
        // $id;
        $where_data = array('e.id' => $id);
        $join_cluase = array(
            '0' => array('table' => 'billing_cliente c', 'condition' => 'e.cliente_id = c.PersonaComercio_cedulaRuc'),
            '1' => array('table' => 'bill_sttiposervicio ts', 'condition' => 'e.tiposervicio_id = ts.id'),
            //'2' => array('table' => 'billing_marca m', 'condition' => 'e.marca_id = m.id'),
            '2' => array('table' => 'billing_empleado tec', 'condition' => 'e.tecnicoencargado = tec.id')
                //   '4' => array('table' => 'bill_stequipoattrequipo bts', 'condition' => 'bts.equipo = e.id'));
        );
        // $res['equipo'] = $this->generic_model->get_join('bill_stequipo e', $where_data, $join_cluase, $fields = 'e.*,m.nombre ,c.PersonaComercio_cedulaRuc client_id,c.nombres client_nombres,c.apellidos client_apellidos,bts.id id_ser, bts.valor serie_prod ,c.telefonos client_telefonos, c.email client_email, c.direccion client_direccion, c.celular client_celular,ts.prefix, ts.tipo tipo_servicio,  ts.prefix, m.nombre marca, tec.nombres tecnico_nombres, tec.apellidos tecnico_apellidos ', 1);
        //$res['equipo'] = $this->generic_model->get_join('bill_stequipo e', $where_data, $join_cluase, 'e.*, m.* ,c.*,tec.*, ts.*, m.* ,bts.*','');
        // $res['equipo'] = $this->generic_model->get_join('bill_stequipo e', $where_data, $join_cluase, $fields='m.*, tec.*, c.*, e.*, ts.prefix',1);
        $res['equipo'] = $this->generic_model->get_join('bill_stequipo e', $where_data, $join_cluase, $fields = 'e.*,c.PersonaComercio_cedulaRuc client_id,c.nombres client_nombres,c.apellidos client_apellidos, c.telefonos client_telefonos, c.email client_email, c.direccion client_direccion, c.celular client_celular, ts.id tipo_servicio, ts.prefix, tec.nombres tecnico_nombres, tec.apellidos tecnico_apellidos ', 1);


        $res['estadosequ'] = $this->generic_model->get('bill_stdoctipo');
        $res['produc'] = $this->generic_model->get('billing_producto');
        $res['proveedor'] = $this->generic_model->get('billing_proveedor');
        $param = "serie";

        $parambuscaprod = explode('%20', $param);
        $where = '';
        $and = '';
        foreach ($parambuscaprod as $val) {
            $where .= $and . '(UPPER(nombreattr) LIKE "%' . strtoupper($val) . '%" )';
            $and = ' AND ';
        }
        $this->db->where($where, null, false);
        $this->db->select('p.id cod, nombreattr nomb');
        $this->db->from('bill_stequipoattr p');
        $query = $this->db->get();
        foreach ($query->result() as $value) {
            $id_ser = $value->cod;
        }

        $resa = $this->generic_model->get('bill_stequipoattrequipo', array('equipo' => $id, 'equipoattr_id' => $id_ser), 'valor');
        if (!empty($resa[0]->valor)):
            $res['valor_ser'] = $this->generic_model->get('bill_stequipoattrequipo', array('equipo' => $id, 'equipoattr_id' => $id_ser));
            $pro_prove = $this->generic_model->get('bill_productoattr', array('valor_attr' => $resa[0]->valor), 'producto_id, doc_id');

        else:
            $res['valor_ser_cero'] = '';
        endif;



        if ((!empty($pro_prove[0]->producto_id)) AND ( !empty($pro_prove[0]->doc_id))) {
            foreach ($pro_prove as $row) {
                $res['producto_info'] = $this->generic_model->get('billing_producto', array('codigo' => $row->producto_id), 'nombreUnico, codigo');
            }
            $fac_prove = $this->generic_model->get('billing_facturacompra', array('codigoFacturaCompra' => $pro_prove[0]->doc_id), 'proveedor_id');
            $res['proveedor_info'] = $this->generic_model->get('billing_proveedor', array('id' => $fac_prove[0]->proveedor_id), 'nombres, PersonaComercio_cedulaRuc,id');
        } else {
            echo warning_msg('El producto no es adquirido en la empresa --- Por favor llene los campos requeridos');
            $res['pro_info_cero'] = '';
            $res['prove_info_cero'] = '';
        }



        $this->load->view('new_documento', $res);
    }

     public function get_stequipo($id) {
//        $res['equipo'] = $this->generic_model->get_by_id('bill_stequipo', $id);

        /* Obtenemos los datos del equipo registrado */
        $res['id'] = $id;
        $where_data = array('e.id' => $id);
        $join_cluase = array(
            '0' => array('table' => 'billing_cliente c', 'condition' => 'e.cliente_id = c.PersonaComercio_cedulaRuc'),
            '1' => array('table' => 'bill_sttiposervicio ts', 'condition' => 'e.tiposervicio_id = ts.id'),
            //'2' => array('table' => 'billing_marca m', 'condition' => 'e.marca_id = m.id'),
            '2' => array('table' => 'billing_empleado tec', 'condition' => 'e.tecnicoencargado = tec.id'),
        );
        $fields = 'e.*,c.PersonaComercio_cedulaRuc client_id,c.nombres client_nombres,c.apellidos client_apellidos, c.telefonos client_telefonos, c.email client_email, c.direccion client_direccion, ts.tipo tipo_servicio, ts.prefix, tec.nombres tecnico_nombres, tec.apellidos tecnico_apellidos';
        $res['equipo'] = $this->generic_model->get_join('bill_stequipo e', $where_data, $join_cluase, $fields, 1);

        $res['usuario'] = $this->generic_model->get('billing_empleado',array('id'=>$res['equipo']->user_id),'CONCAT(nombres," ",apellidos) nombres')[0];
        $where_data = array('equipo' => $res['equipo']->id);
        $join_cluase = array(
            '0' => array('table' => 'bill_stequipoattr ea', 'condition' => 'eae.equipoattr_id = ea.id'),
        );
        $res['equipoattrequipo'] = $this->generic_model->get_join('bill_stequipoattrequipo eae', $where_data, $join_cluase, $fields = '', 0);

        $where_data = array('equipo_id' => $res['equipo']->id);
        $join_cluase = array(
            '0' => array('table' => 'bill_stequipo eq', 'condition' => 'eqrep.equipo_id = eq.id and eq.equestado_id = eqrep.equestado_id'),
        );
        $res['equipodet'] = $this->generic_model->get_join('bill_steqreparacion eqrep', $where_data, $join_cluase, $fields = 'eqrep.*', 0);

        $this->load->view('equipo_ingreso', $res);
    }
    function logout() {
        $this->session->sess_destroy();
        redirect(base_url('client_area/index'), 'refresh');
    }

}
