<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

?>

<div class="modal fade" id="registerModal" tabindex="-1" role="dialog" aria-labelledby="Register" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title">Registro de Clientes</h4>
            </div>

            <div class="modal-body">
                <!-- The form is placed inside the body of modal -->
                <?php echo tagcontent('div', '', array('id'=>'user_new_out')); ?>
                <form id="loginForm" method="post" class="form-horizontal" action="<?=  base_url('user_conf/editprofile/save_user')?>">
                    <?php
                        
                            echo Open('table',array('class'=>'table table-striped'));

                                echo Open('tr');
                                    echo tagcontent('th','CI/RUC');
                                    $input = input(array('type'=>'text','name'=>'ci_ruc','id'=>'ci_ruc','value'=>'','class'=>'form-control'));
                                    echo tagcontent('td',$input);
                                echo Close('tr');
                                echo Open('tr');
                                    echo tagcontent('th','Nombres');
                                    $input = input(array('type'=>'text','name'=>'nombres','id'=>'nombres','value'=>'','class'=>'form-control'));
                                    echo tagcontent('td',$input);
                                echo Close('tr');
                                echo Open('tr');
                                    echo tagcontent('th','Apellidos');
                                    $input = input(array('type'=>'text','name'=>'apellidos','id'=>'apellidos','value'=>'','class'=>'form-control'));                
                                    echo tagcontent('td',$input);
                                echo Close('tr');
                                echo Open('tr');
                                    echo tagcontent('th','Direcci&oacute;n');
                                    $input = input(array('type'=>'text','name'=>'direccion','id'=>'direccion','value'=>'','class'=>'form-control'));                                
                                    echo tagcontent('td',$input);
                                echo Close('tr');
                                echo Open('tr');
                                    echo tagcontent('th','E-mail');
                                    $input = input(array('type'=>'text','name'=>'email','id'=>'email','value'=>'','class'=>'form-control'));
                                    echo tagcontent('td',$input);
                                echo Close('tr');

                                echo Open('tr');
                                    echo tagcontent('th','Usuario');
                                    $input = input(array('type'=>'text','name'=>'usuario','id'=>'usuario','value'=>'','class'=>'form-control'));
                                    echo tagcontent('td',$input);
                                echo Close('tr');
                                echo Open('tr');
                                    echo tagcontent('th','Clave');
                                    $input = input(array('type'=>'text','name'=>'clave','id'=>'clave','value'=>'','class'=>'form-control'));
                                    echo tagcontent('td',$input);
                                echo Close('tr');

                            echo Close('table');
                            $span = tagcontent('span','',array('class'=>'fa fa-sign-in fa-f5'));
                            echo tagcontent('button', 'Crear Usuario'. $span, array('type'=>'submit','id'=>'ajaxformbtn','data-target'=>'user_new_out','class'=>'btn btn-success'));
                        //echo Close('form');                        
                                        
                    
                    
                        //echo Open('div',array('class'=>'col-md-6'));
                    ?>
                    <button type="button" class="btn btn-default" data-dismiss="modal">
                        Cancelar
                        <span class="fa fa-close fa-f5"></span>
                    </button>
                </form>
                
            </div>
        </div>
    </div>
</div>