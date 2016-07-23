<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
//print_r($user);
echo tagcontent('div', '', array('id'=>'edit_profile_out','class'=>'col-md-12'));

if($user){
    echo validation_errors();
    
    echo Open('form', array('method'=>'post','action'=>  base_url('user_conf/editprofile/edit'),'class'=>'col-md-6'));
        echo Open('table',array('class'=>'table table-striped'));

            echo Open('tr');
                echo tagcontent('th','CI/RUC');
                echo tagcontent('td',$this->user->id);
            echo Close('tr');
            echo Open('tr');
                echo tagcontent('th','Nombres');
                $input = input(array('type'=>'text','name'=>'nombres','id'=>'nombres','value'=>$user->nombres,'class'=>'form-control'));
                echo tagcontent('td',$input);
            echo Close('tr');
            echo Open('tr');
                echo tagcontent('th','Apellidos');
                $input = input(array('type'=>'text','name'=>'apellidos','id'=>'apellidos','value'=>$user->apellidos,'class'=>'form-control'));                
                echo tagcontent('td',$input);
            echo Close('tr');
            echo Open('tr');
                echo tagcontent('th','Direcci&oacute;n');
                $input = input(array('type'=>'text','name'=>'direccion','id'=>'direccion','value'=>$user->direccion,'class'=>'form-control'));                                
                echo tagcontent('td',$input);
            echo Close('tr');
            echo Open('tr');
                echo tagcontent('th','E-mail');
                $input = input(array('type'=>'text','name'=>'email','id'=>'email','value'=>$user->email,'class'=>'form-control'));
                echo tagcontent('td',$input);
            echo Close('tr');
            echo Open('tr');
                echo tagcontent('th','Tel&eacute;fonos');
                $input = input(array('type'=>'text','name'=>'telefonos','id'=>'telefonos','value'=>$user->telefonos,'class'=>'form-control'));                
                echo tagcontent('td',$input);
            echo Close('tr');
            echo Open('tr');
                echo tagcontent('th','Celular');
                $input = input(array('type'=>'text','name'=>'celular','id'=>'celular','value'=>$user->celular,'class'=>'form-control'));
                echo tagcontent('td',$input);
            echo Close('tr');
            echo Open('tr');
                echo tagcontent('th','Usuario');
                $input = input(array('type'=>'text','name'=>'usuario','id'=>'usuario','value'=>$user->usuario,'class'=>'form-control'));
                echo tagcontent('td',$input);
            echo Close('tr');
            echo Open('tr');
                echo tagcontent('th','Pa&iacute;s');
                $input = input(array('type'=>'text','name'=>'pais','id'=>'pais','value'=>$user->pais,'class'=>'form-control'));
                echo tagcontent('td',$input);
            echo Close('tr');
            echo Open('tr');
                echo tagcontent('th','Ciudad');
                $input = input(array('type'=>'text','name'=>'ciudad','id'=>'ciudad','value'=>$user->ciudad,'class'=>'form-control'));
                echo tagcontent('td',$input);
            echo Close('tr');

        echo Close('table');
        echo tagcontent('button', 'Modificar Perfil de Usuario', array('id'=>'ajaxformbtn','data-target'=>'edit_profile_out','class'=>'btn btn-primary'));
    echo Close('form');

    /* Formulario para cambiar la clave */
    echo Open('form', array('method'=>'post','action'=>  base_url('user_conf/editprofile/edit_pass'),'class'=>'col-md-6'));
        echo Open('table',array('class'=>'table table-striped'));

            echo Open('tr');
                echo tagcontent('th','Clave Actual');
                $input = input(array('type'=>'password','name'=>'current_pass','id'=>'curren_pass','value'=>'','class'=>'form-control'));
                echo tagcontent('td',$input);
            echo Close('tr');           
            echo Open('tr');
                echo tagcontent('th','Nueva Clave');
                $input = input(array('type'=>'password','name'=>'new_pass','id'=>'new_pass','value'=>'','class'=>'form-control'));
                echo tagcontent('td',$input);
            echo Close('tr');
            echo Open('tr');
                echo tagcontent('th','Confirme Nueva Clave');
                $input = input(array('type'=>'password','name'=>'confirm_pass','id'=>'confirm_pass','value'=>'','class'=>'form-control'));
                echo tagcontent('td',$input);
            echo Close('tr');

        echo Close('table');
        echo tagcontent('button', 'Actualizar Clave', array('id'=>'ajaxformbtn','data-target'=>'edit_profile_out','class'=>'btn btn-primary'));
    echo Close('form');
}
   