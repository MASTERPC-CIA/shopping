<?php
Class Servicios extends MX_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('common/empleadocapacidad_model');
        $this->load->library('grocery_CRUD');
    }
        
 
    public function get_reporte_servicio_portal(){
        $client_id = $this->input->post('client_id');
        $fields='c.PersonaComercio_cedulaRuc, 
            concat(c.PersonaComercio_cedulaRuc,": ", c.nombres, " ", c.apellidos, ", Telf. ",c.telefonos) as nombres,
            s.nombre_equipo, s.problema, m.nombre, s.presupuesto, s.fecha, s.fechaentrega';

        $join_cluase = array(
                             '0' => array('table' => 'billing_cliente c', 'condition' => 's.cliente_id = c.PersonaComercio_cedulaRuc'),
                             '1' => array('table' => 'billing_marca m', 'condition' => 'm.id=s.marca_id'),
           
          );
           
          $where_data = array('c.PersonaComercio_cedulaRuc'=>$client_id);
 
         $res['equipo'] = $this->generic_model->get_join('bill_stequipo s', $where_data, $join_cluase, $fields = '', 0);
         $res['num_registros'] = count($res['equipo']);
        
       
        $this->load->view('shopping_cart/portal/list_servicio', $res);
    }
    function logout()
    {
      $this->session->sess_destroy();
      redirect( base_url('client_area/index') , 'refresh');
    }    

 }
