<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Editprofile extends MX_Controller {

 private $res_message = '';
 function __construct()
 {
   parent::__construct();
   //$this->user->check_session();
 }

 function index()
 {
   /* Obtenemos los datos del cliente que vamos a editar el perfil */  
   $user = $this->generic_model->get_data( 
            'billing_cliente', 
            array('PersonaComercio_cedulaRuc'=>$this->user->id), 
            $fields = 'nombres, apellidos, direccion, email, telefonos, celular, usuario, clave, pais, ciudad', 
            null, 
            1 
           );
   $res1['user'] = $user;  
   $res['view'] = $this->load->view('edit_profile',$res1,TRUE);   
   $res['slidebar'] = $this->load->view('slidebar','',TRUE);   
   $this->load->view('templates/dashboard',$res);
 }
 
 public function edit() {
   $this->load->library('form_validation');

   $this->form_validation->set_rules( 'nombres', 'Nombres', 'trim|required|xss_clean' );
   $this->form_validation->set_rules( 'apellidos', 'Apellidos', 'trim|required|xss_clean' );
   $this->form_validation->set_rules( 'direccion', 'Direccion', 'trim|required|xss_clean' );
   $this->form_validation->set_rules( 'email', 'E-mail', 'trim|required|xss_clean' );
   $this->form_validation->set_rules( 'telefonos', 'Telefonos', 'trim|required|xss_clean' );
   $this->form_validation->set_rules( 'celular', 'Celular', 'trim|required|xss_clean' );
   $this->form_validation->set_rules( 'usuario', 'Usuario', 'trim|required|xss_clean' );
   $this->form_validation->set_rules( 'ciudad', 'Ciudad', 'trim|required|xss_clean' );
   $this->form_validation->set_error_delimiters('<br /><span class="text-danger">', '</span>');

        if ($this->form_validation->run() == FALSE) // validation hasn't been passed
        {
            $this->res_message = validation_errors();
//              echo tagcontent('script', "window.location.replace('".  base_url('user_conf/editprofile/index')."')");
        } else {
            $data_set = array(
                'nombres'=>set_value('nombres'),
                'apellidos'=>set_value('apellidos'),
                'direccion'=>set_value('direccion'),
                'email'=>set_value('email'),
                'telefonos'=>set_value('telefonos'),
                'celular'=>set_value('celular'),
                'usuario'=>set_value('usuario'),
                'pais'=>set_value('pais'),
                'ciudad'=>set_value('ciudad'),
            );
            $res = $this->generic_model->update( 
                'billing_cliente', 
                $data_set, 
                array('PersonaComercio_cedulaRuc'=>$this->user->id)
            );
            
            if($res){
                $this->res_message = success_msg(', usuario Modificado.');
            }
        }
        
        echo $this->res_message;
 }
  
 public function edit_pass() {
   $this->load->library('form_validation');

   $this->form_validation->set_rules( 'current_pass', 'Clave Actual', 'trim|required|xss_clean' );
   $this->form_validation->set_rules( 'new_pass', 'Nueva Clave', 'trim|required|xss_clean' );
   $this->form_validation->set_rules( 'confirm_pass', 'Confirme Nueva Clave', 'trim|required|xss_clean' );

   $this->form_validation->set_error_delimiters('<br /><span class="text-danger">', '</span>');
   
   $form_validation = $this->form_validation->run();   
   
        if ($form_validation == FALSE) // validation hasn't been passed
        {
            $this->res_message = validation_errors();
//              echo tagcontent('script', "window.location.replace('".  base_url('user_conf/editprofile/index')."')");
        } else {
            $form_validation2 = $this->check_current_pass();            
            $form_validation = $this->confirm_pass();

            if($form_validation AND $form_validation2){
                $data_set = array(
                    'clave'=>set_value('new_pass')
                );
                $res = $this->generic_model->update( 
                    'billing_cliente', 
                    $data_set, 
                    array('PersonaComercio_cedulaRuc'=>$this->user->id)
                );

                if($res){
                    $this->res_message .= success_msg(', clave actualizada.');
                }                
            }else{
                $this->res_message .= validation_errors();
            }

        }
        
        echo $this->res_message;
 }

	public function confirm_pass()
	{
            $new_pass = $this->input->post('new_pass');
            $confirm_pass = $this->input->post('confirm_pass');
		if ($new_pass != $confirm_pass) {
			$this->res_message .= warning_msg('No coincide la confirmaci&oacute;n de la clave.');
			return FALSE;
		}
		else
		{
			return TRUE;
		}
	} 
        
	public function check_current_pass()
	{
            $current_pass = $this->input->post('current_pass');
            $user = $this->generic_model->get_data( 
                     'billing_cliente', 
                     array('PersonaComercio_cedulaRuc'=>$this->user->id), 
                     $fields = 'clave', 
                     null, 
                     1 
                    );
            
		if ($user->clave != $current_pass) {
			$this->res_message .= warning_msg('La clave actual ingresada no coicide con la clave del usuairo.');
			return FALSE;
		}
		else
		{
			return TRUE;
		}            
	} 
 
    public function save_user() {
          $this->load->library('form_validation');
          $this->load->library('common/mailsms');
          $this->load->library('docident');
          $this->cliente = new mailsms();
          $ci_ruc = $this->input->post('ci_ruc');
          $exist = $this->check_exist_user($ci_ruc);
          
          if($exist){
              $user = $this->generic_model->get_data( 
                    'billing_cliente', 
                    array('PersonaComercio_cedulaRuc'=>$ci_ruc), 
                    $fields = 'nombres, apellidos, direccion, email, telefonos, celular, usuario, clave, pais, ciudad', 
                    null, 
                    1 
                   );
              echo info_msg('El usuario con CI/RUC '.$ci_ruc.' ya existe, acceda con Usuario: '.$user->usuario.' Clave: '.$user->clave);
              die();
          }
          
          $this->form_validation->set_rules( 'ci_ruc', 'CI/RUC', 'trim|required|xss_clean' );
          $this->form_validation->set_rules( 'nombres', 'Nombres', 'trim|required|xss_clean' );
          $this->form_validation->set_rules( 'apellidos', 'Apellidos', 'trim|required|xss_clean' );
          $this->form_validation->set_rules( 'direccion', 'Direccion', 'trim|required|xss_clean' );
          $this->form_validation->set_rules( 'email', 'E-mail', 'trim|required|xss_clean' );
//          $this->form_validation->set_rules( 'telefonos', 'Telefonos', 'trim|required|xss_clean' );
//          $this->form_validation->set_rules( 'celular', 'Celular', 'trim|required|xss_clean' );
          $this->form_validation->set_rules( 'usuario', 'Usuario', 'trim|required|xss_clean' );
          $this->form_validation->set_rules( 'clave', 'Clave', 'trim|required|xss_clean' );
          $this->form_validation->set_error_delimiters('<br /><span class="text-danger">', '</span>');

        if ($this->form_validation->run() == FALSE){
             $this->res_message = validation_errors();
       //              echo tagcontent('script', "window.location.replace('".  base_url('user_conf/editprofile/index')."')");
       } else {
           $doc_ident = $this->docident->get_tipo_doc_id(NULL,set_value('ci_ruc'));
           if($doc_ident){

           }else{
               die($doc_ident);
           }
           $data_set = array(
               'PersonaComercio_cedulaRuc'=>set_value('ci_ruc'),
               'nombres'=>set_value('nombres'),
               'apellidos'=>set_value('apellidos'),
               'direccion'=>set_value('direccion'),
               'email'=>set_value('email'),
               'docidentificacion_id'=>$doc_ident['docidentificacion_id'],
               'tipo_ruc'=>$doc_ident['tipo_ruc'],
//                       'telefonos'=>set_value('telefonos'),
//                       'celular'=>set_value('celular'),
               'fecha' => date('Y-m-d',  time()),
               'usuario'=>set_value('usuario'),
               'clave'=>set_value('clave'),
               'clientetipo_idclientetipo'=>1,
           );
           $res = $this->generic_model->save($data_set, 'billing_cliente');
           if($res >= 0){
               $this->res_message .= success_msg(', usuario creado correctamente.');
           }else{
               $this->res_message .= error_msg(', el usuario no se puedo crear correctamente.');
           }

           ///notificar por correo
           $mensaje = '<div style="text-align:center;"><h2>'.get_settings('RAZON_SOCIAL').'</h2></div>';
           $mensaje .= '<h4>Se ha registrado correctamente como cliente de Master PC.</h4><br>'
                   . '<strong>Usuario: </strong>'.set_value('usuario').'<br>'
                   . '<strong>Contrase&ntilde;a: </strong>'.  set_value('clave');
            $correo = $this->cliente->send_mail(
                set_value('email'),//correo a quien se le envia
                'Registro de Clientes en Master PC',//titulo del mensaje
                $mensaje,//mensaje a enviar
                TRUE,//true cuando el tipo de mensaje que se envia es html
                'webmasterpcloja@gmail.com',//correo remitente
                'Webmasterpcloja@123'//contraseña remitente
            );
           if ($correo->MailResult == 'ENVIADO') {
               $msg = 'su usuario y clave se enviaron al correo '.set_value('email');
               $this->res_message .= success_msg(', '.$msg);
               echo tagcontent('script', 'alertaExito("' . $msg . '")');
           }else{
                $msg = 'Ocurrio un error al enviar sus credenciales por correo!';
                $this->res_message .= error_msg(', '.$msg);
                echo tagcontent('script', 'alertaError("' . $msg . '")');
           }
       }

       echo $this->res_message;
    } 
        
        
        /* Verificamos la existencia del usuario */
	public function check_exist_user($ci_ruc)
	{
            $exist = $this->generic_model->count_all_results('billing_cliente', array('PersonaComercio_cedulaRuc'=>$ci_ruc) );
            
		if ($exist > 0) {
			return TRUE;
		}
		else
		{
			return FALSE;
		}            
	}         
        
}