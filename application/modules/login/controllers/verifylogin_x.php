<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Verifylogin extends MX_Controller {

 function __construct()
 {
   parent::__construct();
   $this->load->library('user');
   error_reporting(1);
 }

 function index()
 {
   //This method will have the credentials validation
   $this->load->library('form_validation');
//print_r($_POST);
   $this->form_validation->set_rules('username', 'Username', 'trim|required');
   $this->form_validation->set_rules('password', 'Password', 'trim|required|callback_check_database');

   if($this->form_validation->run() == FALSE)
   {
     //Field validation failed.  User redirected to login page
     $this->load->view('login_view');
   }
   else
   {
     //Go to private area
     echo 'SI SE IDENTIFICA AL USUARIO';
     print_r($this->user);
//     redirect('login/welcome', 'refresh');
   }

 }

 function check_database($password)
 {
   //Field validation succeeded.  Validate against database
   $username = $this->input->post('username');
   
        $row = $this->generic_model->get(
                'billing_cliente', 
                array('usuario'=>$username,'clave'=>$password), 
                $fields = 'PersonaComercio_cedulaRuc id, PersonaComercio_cedulaRuc cedulausu, nombres, apellidos, usuario, email, telefonos, celular', 
                $order_by = null, 
                $rows_num = 1
        );
        
//   if($result)
//   {
//       $USER = array(
//         'id' => $result->id,
//         'userid' => $result->cedulausu,
//         'username' => $result->usuario,
//         'nombres' => $result->nombres,
//         'apellidos' => $result->apellidos,
//         'email' => $result->email,
//         'telefonos' => $result->telefonos,
//         'celular' => $result->celular,
//         'essuperusuario' => 0,
////         'rucempresa' => $row->rucempresa,
//         'ivaporcent' => 12,
//         'numdecimales' => 2
//       );
//       $this->session->set_userdata($USER);      
//        
//     return TRUE;
//   }
        
   if($result)
   {   
     $USER = array();
//     foreach($result as $row)
//     {
       $USER = array(
         'id' => $row->id,
         'userid' => $row->cedulausu,
         'username' => $row->usuario,
         'nombres' => $row->nombres,
         'apellidos' => $row->apellidos,
         'email' => $row->email,
         'telefonos' => $row->telefonos,
         'celular' => $row->celular,
        'essuperusuario' => 0,
//      'rucempresa' => $row->rucempresa,
         'ivaporcent' => 12,
         'numdecimales' => 2
       );
        $this->session->set_userdata('userid', $row->cedulausu);
//     }
        $this->session->set_userdata($USER);      
        
     return TRUE;
   }        
        
   else
   {
     $this->form_validation->set_message('check_database', 'El nombre de usuario o la contrase&ntilde;a parecen incorrectos');
     return false;
   }
 }
}