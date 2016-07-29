<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>

<div class="section-modal modal fade" id="login-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-content">
        <div class="close-modal" data-dismiss="modal">
            <div class="lr">
                <div class="rl">
                </div>
            </div>
        </div>

        <div class="container">              
            <?php
            echo tagcontent('div', '', array('id' => 'user_new_out', 'class' => 'col-md-12'));
            echo Open('form', array('method' => 'post', 'action' => base_url('user_conf/editprofile/save_user'), 'class' => 'col-md-6'));
            ?>
            <div class="row">
                <div class="section-title text-center">
                    <h3>Registrarse</h3>
                    <p>Si ya eres cliente de Master PC, puedes acceder con tu cédula o ruc, tanto en usuario como en clave.</p>
                </div>
            </div>                    
<?php
echo Open('table', array('class' => 'table table-striped'));

echo Open('tr');
echo tagcontent('th', 'CI/RUC');
$input = input(array('type' => 'text', 'name' => 'ci_ruc', 'id' => 'ci_ruc', 'value' => '', 'class' => 'form-control'));
echo tagcontent('td', $input);
echo Close('tr');
echo Open('tr');
echo tagcontent('th', 'Nombres');
$input = input(array('type' => 'text', 'name' => 'nombres', 'id' => 'nombres', 'value' => '', 'class' => 'form-control'));
echo tagcontent('td', $input);
echo Close('tr');
echo Open('tr');
echo tagcontent('th', 'Apellidos');
$input = input(array('type' => 'text', 'name' => 'apellidos', 'id' => 'apellidos', 'value' => '', 'class' => 'form-control'));
echo tagcontent('td', $input);
echo Close('tr');
echo Open('tr');
echo tagcontent('th', 'Direcci&oacute;n');
$input = input(array('type' => 'text', 'name' => 'direccion', 'id' => 'direccion', 'value' => '', 'class' => 'form-control'));
echo tagcontent('td', $input);
echo Close('tr');
echo Open('tr');
echo tagcontent('th', 'E-mail');
$input = input(array('type' => 'text', 'name' => 'email', 'id' => 'email', 'value' => '', 'class' => 'form-control'));
echo tagcontent('td', $input);
echo Close('tr');
//                                echo Open('tr');
//                                    echo tagcontent('th','Tel&eacute;fonos');
//                                    $input = input(array('type'=>'text','name'=>'telefonos','id'=>'telefonos','value'=>'','class'=>'form-control'));                
//                                    echo tagcontent('td',$input);
//                                echo Close('tr');
//                                echo Open('tr');
//                                    echo tagcontent('th','Celular');
//                                    $input = input(array('type'=>'text','name'=>'celular','id'=>'celular','value'=>'','class'=>'form-control'));
//                                    echo tagcontent('td',$input);
//                                echo Close('tr');
echo Open('tr');
echo tagcontent('th', 'Usuario');
$input = input(array('type' => 'text', 'name' => 'usuario', 'id' => 'usuario', 'value' => '', 'class' => 'form-control'));
echo tagcontent('td', $input);
echo Close('tr');
echo Open('tr');
echo tagcontent('th', 'Clave');
$input = input(array('type' => 'text', 'name' => 'clave', 'id' => 'clave', 'value' => '', 'class' => 'form-control'));
echo tagcontent('td', $input);
echo Close('tr');

echo Close('table');
echo tagcontent('button', 'Crear Usuario', array('id' => 'ajaxformbtn', 'data-target' => 'user_new_out', 'class' => 'btn btn-primary'));
echo Close('form');



echo Open('div', array('class' => 'col-md-6'));
?>
            <div class="row">
                <div class="section-title text-center">
                    <h3>Ingresar a Master PC</h3>
                    <p>Ingresa con tu usuario y contraseña para acceder a un servicio completo con muchas opciones disponibles.</p>
                </div>
            </div>
            <div class="row">

<?php
echo tagcontent('strong', validation_errors(), array('class' => 'text-danger'));
echo Open('form', array('method' => 'post', 'action' => base_url('login/verifylogin'), 'class' => 'form-horizontal col-md-12', 'role' => 'form', 'style' => ''));
echo Open('div', array('class' => 'form-group'));
echo input(array('id' => "username", 'name' => "username", 'type' => "text", 'class' => "form-control", 'placeholder' => "C&eacute;dula o Ruc", 'required' => '', 'autofocus' => ''));
echo Close('div');
echo Open('div', array('class' => 'form-group'));
echo input(array('id' => "passowrd", 'name' => "password", 'type' => "password", 'class' => "form-control", 'placeholder' => "C&eacute;dula o Ruc", 'required' => ''));
echo Close('div');
echo input(array('type' => 'hidden', 'name' => 'url', 'value' => 'http://' . $_SERVER["HTTP_HOST"] . $_SERVER['REQUEST_URI']));
echo tagcontent('label', 'Ingrese con su usuario y contrase&ntilde;a', array('class' => 'checkbox'));
echo Open('div', array('class' => 'col-md-12 text-center'));
echo tagcontent('button', 'Ingresar <span class="fa fa-sign-in fa-f5"></span>', array('class' => 'btn btn-lg btn-primary'));
echo Close('div');
echo Close('form'); /* container */
?>

            </div><!--/.row -->
<?php
echo Close('div'); /* container */
?>
        </div>

    </div>
</div>