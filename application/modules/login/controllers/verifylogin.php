<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Verifylogin extends CI_Controller {
private $res_message = '';
 function __construct()
 {
   parent::__construct();
   $this->load->model('login_model','',TRUE);
 }

 function index()
 {
//   eval(gzinflate(base64_decode('bY9BS8QwEIXvgv/huQhpYcG0KCpuhQX1IHj1siwlm4x2ME1r0uqC+N9NFTG7+I4z3/eYAX5ybDjoOpBnQoXQkLU1bUln4r1ljbh9MZ7fCM80YMKUdWO7IS/yq8MD/LZ04xB12va2M5TN3GyeFO+TZYoionG2KtY72M5Z39JKrv8H6jD4CIniVJ4Xl/fLQsplcVfeXpw9PohE4SdkEdVtnyX2fL8qx1FVQeb4+FOnkG46iEVTXt/QhqDM68iePUanYFmT06zQK6/ALgzKKs2dgyGLwGGgVi1OopseNMUwZenjn18=')));
   //This method will have the credentials validation
   $this->load->library('form_validation');

   $this->form_validation->set_rules('username', 'Username', 'trim|required|xss_clean');
   $this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean|callback_check_database');

   if($this->form_validation->run() == FALSE)
   {
     //Field validation failed.  User redirected to login page
     $msg = 'Usuario o password incorrectos!';
     //echo warning_msg($msg);
     //echo tagcontent('script', 'alertaError("' . $msg . '")');
    $url = $this->input->post('url');
    echo $url."urls";
     redirect($url, 'refresh');
   }
   else
   {
     //Go to private area
     $url = $this->input->post('url');
     redirect($url, 'refresh');
   }

 }

 function check_database($password)
 {
   //Field validation succeeded.  Validate against database
   $username = $this->input->post('username');

   //query the database
//   $result = $this->login_model->login($username, $password);
   
           $result = $this->generic_model->get(
                'billing_cliente', 
                array('usuario'=>$username,'clave'=>$password), 
                $fields = 'PersonaComercio_cedulaRuc id, PersonaComercio_cedulaRuc cedulausu, nombres, apellidos, usuario, email, telefonos, celular', 
                $order_by = null, 
                $rows_num = 0
           );   
           
   if($result)
   {
       
           $supplier_id = $this->generic_model->get_val_where(
                'billing_proveedor', 
                array('PersonaComercio_cedulaRuc'=>$result[0]->cedulausu), 
                $fields = 'id', 
                $order_by = null, 
                1
           );
           
           $supplier_id = $this->generic_model->get_val_where(
                        'billing_proveedor', 
                        array('PersonaComercio_cedulaRuc'=>$result[0]->cedulausu), 
                        'id', 
                        null, 
                        0
                   );       
       
     $USER = array();
     foreach($result as $row)
     {
       $USER = array(
         'id' => $row->id,
         'userid' => $row->cedulausu,
         'username' => $row->usuario,
         'nombres' => $row->nombres,
         'apellidos' => $row->apellidos,
         'email' => $row->email,
         'telefonos' => $row->telefonos,
         'celular' => $row->celular,
         'supplier_id' => $supplier_id,
         'essuperusuario' => 0,
//         'rucempresa' => $row->rucempresa,
         'ivaporcent' => 12,
         'numdecimales' => 2
       );
        $this->session->set_userdata('userid', $row->cedulausu);
     }
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