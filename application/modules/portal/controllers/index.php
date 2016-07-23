<?php
Class Index extends MX_Controller
{

    function __construct()
    {
        parent::__construct();
//        $this->user->check_session();
    }
        
    function index()
    {
//            $res['title'] = 'Bienvenido '.$this->user->nombres;
           // $res['img_banner'] = $this->generic_model->get('bill_empre_images',array('deleted ='=>0));
            //$res['setions'] = $this->generic_model->get('bill_empre_sections');
            //$this->load->view('index',$res);
//            $res['slidebar'] = $this->load->view('slidebar','',TRUE);
//            $this->load->view('templates/dashboard',$res);
            
//       $this->load->view('index');
   //    $res['slidebar'] = $this->load->view('slidebar','',TRUE);
   //    $res['slidebar'] = '';
   //    $this->load->view('dashboard',$res);     
        
        redirect('shopping_cart/productos' , 'refresh');
        
        
    }
 
//    public function acceso_client(){
//        $user = $this->input->post('username');
//        $pass = $this->input->post('password');
//        
//        $client_data = $this->generic_model->get(
//                'billing_cliente', 
//                array('PersonaComercio_cedulaRuc'=>$user,'clave'=>$pass), 
//                $fields = 'PersonaComercio_cedulaRuc, nombres, apellidos', 
//                $order_by = null, 
//                $rows_num = 1
//        );
////        print_r($client_data);
//        if($client_data){
//            $res['title'] = 'Bienvenido '.$client_data->nombres;
//            $res['view'] = $this->load->view('ventas_search','',TRUE);
//            $res['slidebar'] = $this->load->view('slidebar','',TRUE);
//            $this->load->view('dashboard',$res);     
//        }else{
//            redirect(base_url('client_area/index'));
//        }
//        
////        print_r($client_data);
//            $newdata = array(
//                'client_id'  => $client_data->PersonaComercio_cedulaRuc,
//                'nombres_user_client'  => $client_data->nombres,
//                'email_user_client'     => $client_data->apellidos
//            );
//
//        $this->session->set_userdata($newdata);        
//        
    
    
    function logout()
    {
      $this->session->sess_destroy();
      redirect( base_url('client_area/index') , 'refresh');
    }    

 }
