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

        
        redirect('shopping_cart/productos' , 'refresh');
        
        
    }
 

    
    
    function logout()
    {
      $this->session->sess_destroy();
      redirect( base_url('shopping_cart/productos') , 'refresh');
    }    

 }
