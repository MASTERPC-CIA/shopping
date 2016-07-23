<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

?>
<!--<p class="text-left">
    <button class="btn btn-primary" data-toggle="modal" data-target="#loginModal">Login</button>
</p>-->
<div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="Login" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title text-center">INGRESO AL CARRITO DE COMPRAS</h4>
                <p>Si ya es cliente de Master PC, ingrese con Usuario: su c&eacute;dula o ruc, Contrase&ntilde;a: su c&eacute;dula o ruc.</p>
            </div>

            <div class="modal-body">
                <!-- The form is placed inside the body of modal -->
                <form id="loginForm" method="post" class="form-horizontal" action="<?=  base_url('login/verifylogin')?>">
                    <div class="form-group">
                        <label class="col-xs-3 control-label">Usuario</label>
                        <div class="col-xs-6 input-group">
                            <input type="text" class="form-control" name="username" placeholder="C&eacute;dula o Ruc"/>
                            <label for="uLogin" class="input-group-addon glyphicon glyphicon-user"></label>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-xs-3 control-label">Contrase&ntilde;a</label>
                        <div class="col-xs-6 input-group">
                            <input type="password" class="form-control" name="password" placeholder="C&eacute;dula o Ruc"/>
                            <label for="uPassword" class="input-group-addon glyphicon glyphicon-lock"></label>
                        </div>
                    </div>
                    <input type="hidden" name="url" value="<?='http://'.$_SERVER["HTTP_HOST"]. $_SERVER['REQUEST_URI']?>">
                    <div class="form-group">
                        <div class="col-xs-10 col-xs-offset-3">
                            <button type="submit" class="btn btn-success">
                                Ingresar
                                <span class="fa fa-sign-in fa-f5"></span>
                            </button>
                            <button type="button" class="btn btn-primary" data-dismiss="modal" data-target="#registerModal" data-toggle="modal">
                                Registrarse
                                <span class="fa fa-sign-in fa-f4"></span>
                            </button>
                            <button type="button" class="btn btn-default" data-dismiss="modal">
                                Cancelar
                                <span class="fa fa-close fa-f5"></span>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>