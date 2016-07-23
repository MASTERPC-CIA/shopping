<?php
echo  Doctype('html5');
echo  Open('html');
        $head =  tagcontent('title', 'Facturacion');
        
        $css = array(
            base_url('resources/bootstrap-3.2.0/css/bootstrap.min.css'),
            base_url('resources/sb_admin/css/plugins/metisMenu/metisMenu.min.css'),
            base_url('resources/sb_admin/css/sb-admin-2.css'),
            base_url('resources/sb_admin/font-awesome-4.1.0/css/font-awesome.min.css'),    
            base_url('resources/bootstrap-3.2.0/css/bootstrap-theme.css'),
            base_url('resources/bootstrap-3.2.0/css/signin.css'),
        );
        $head .= csslink($css);        
        
        echo  tagcontent('head', $head);
    echo  Open('body',array('class'=>'login_body'));   
    
    
$this->load->view('templates/navigation_login.php');
        echo  Open('div',array('class'=>'container','style'=>'margin-top:20px'));  
            echo  Open('div',array('class'=>'col-md-7'));
                echo tagcontent('span', 'Billingsof te ayuda a la administraci&oacute;n de tu empresa, y a mejorar el rendimiento en cada una de las funciones que desempe&ntilde;as.', array('style'=>'font-size:20px;font-weight:bold'));
                echo LineBreak(2, array('style'=>'clear:both'));
                echo tagcontent('span', '', array('class'=>'glyphicon glyphicon-cog','style'=>'font-size:20px;')).  tagcontent('span', '&emsp;Administraci&oacute;n', array('style'=>'font-size:20px'));
                echo LineBreak(1, array('style'=>'clear:both'));
                echo tagcontent('span', '', array('class'=>'glyphicon glyphicon-shopping-cart','style'=>'font-size:20px')).  tagcontent('span', '&emsp;Compras', array('style'=>'font-size:20px'));
                echo LineBreak(1, array('style'=>'clear:both'));
                echo tagcontent('span', '', array('class'=>'glyphicon glyphicon-usd','style'=>'font-size:20px')).  tagcontent('span', '&emsp;Ventas', array('style'=>'font-size:20px'));
                echo LineBreak(1, array('style'=>'clear:both'));
                echo tagcontent('span', '', array('class'=>'glyphicon glyphicon-tasks','style'=>'font-size:20px')).  tagcontent('span', '&emsp;Cotizaciones', array('style'=>'font-size:20px'));
                echo LineBreak(1, array('style'=>'clear:both'));
                echo tagcontent('span', '', array('class'=>'glyphicon glyphicon-log-in','style'=>'font-size:20px')).  tagcontent('span', '&emsp;Cuentas x Cobrar', array('style'=>'font-size:20px'));
                echo LineBreak(1, array('style'=>'clear:both'));
                echo tagcontent('span', '', array('class'=>'glyphicon glyphicon-log-out','style'=>'font-size:20px')).  tagcontent('span', '&emsp;Cuentas x Pagar', array('style'=>'font-size:20px'));
                echo LineBreak(1, array('style'=>'clear:both'));
                echo tagcontent('span', '', array('class'=>'glyphicon glyphicon-book','style'=>'font-size:20px')).  tagcontent('span', '&emsp;Contabilidad', array('style'=>'font-size:20px'));
                echo LineBreak(1, array('style'=>'clear:both'));
                echo tagcontent('span', '', array('class'=>'glyphicon glyphicon-stats','style'=>'font-size:20px')).  tagcontent('span', '&emsp;Reportes', array('style'=>'font-size:20px'));
                echo LineBreak(1, array('style'=>'clear:both'));
                echo tagcontent('span', '', array('class'=>'glyphicon glyphicon-plus','style'=>'font-size:20px')).  tagcontent('span', '&emsp;Mucho M&aacute;s..', array('style'=>'font-size:20px'));
            echo  Close('div');

            echo  Open('div',array('class'=>'col-md-5'));  
                $message = $this->session->userdata('message');
                if(!empty($message)){
                    echo tagcontent('strong', $message, array('class'=>'text-danger'));
                    $this->session->unset_userdata('message');            
                }
                echo tagcontent('strong', validation_errors(), array('class'=>'text-danger')); 
                
                echo tagcontent('span', 'Factura Electr&oacute;nica', array('class'=>'login_title1'));
                echo tagcontent('div', 'Ingresa con tu numero de cedula para descargar tu factura electronica en Master PC', array('class'=>'')).'</br>';
                echo Open('form', array('method'=>'post','action'=> base_url('client_area/index/acceso_client') ,'class'=>'form-horizontal col-md-12','role'=>'form','style'=>''));
                    
                        echo Open('div',array('class'=>'form-group'));
                            echo input(array('id'=>"username", 'name'=>"username", 'type'=>"text", 'class'=>"form-control", 'placeholder'=>"Username", 'required'=>'', 'autofocus'=>''));
                        echo Close('div');
                        echo Open('div',array('class'=>'form-group'));
                            echo input(array('id'=>"passowrd", 'name'=>"password", 'type'=>"password", 'class'=>"form-control", 'placeholder'=>"Password", 'required'=>''));
                        echo Close('div');
                    
//                    echo tagcontent('label', 'Ingrese con su usuario y contrase&ntilde;a', array('class'=>'checkbox'));
                        echo Open('div',array('class'=>'form-group'));
                            echo tagcontent('button', 'Acceder <span class="fa fa-sign-in fa-f5"></span>', array('class'=>'btn btn-lg btn-success'));
                        echo Close('div');                            
                echo  Close('form'); /* container */            
            echo  Close('div');
        echo  Close('div'); /* container */
    echo  Close('body');
echo  Close('html');
