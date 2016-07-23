<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Editprofile extends MX_Controller {

 function __construct()
 {
   parent::__construct();

 }

 function index()
 {
   /* Obtenemos los datos del cliente que vamos a editar el perfil */  
   $user = $this->generic_model->get_data( 
            'billing_cliente', 
            array('PersonaComercio_cedulaRuc'=>''), 
            $fields = 'nombres, apellidos, direccion, email, telefonos, celular, usuario, clave', 
            null, 
            1 
           );
   $res1['user'] = $user;  
   $res['view'] = $this->load->view('edit_profile',$res1,TRUE);   
   $res['slidebar'] = $this->load->view('slidebar','',TRUE);   
   $this->load->view('templates/dashboard',$res);
 }

}