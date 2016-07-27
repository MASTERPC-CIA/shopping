<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>

<div class="section-modal modal fade" id="services-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>

        <div class="container">              

            <?php



            echo Open('div', array('class' => 'tab-content')) . LineBreak(1, array('class' => 'clr'));
                echo Open('div', array('id' => 'equipo', 'class' => 'tab-pane active'));
                    echo Open('form', array('method' => 'post', 'action' => base_url('portal/servicios/get_reporte_servicio_portal')));
                        
                        echo Open('div', array('class' => 'col-md-3 form-group'));
                            echo Open('div', array('class' => 'input-group'));
                                echo tagcontent('span', 'RUC/CI. Cliente: ', array('class' => 'input-group-addon'));
                                echo input(array('name' => 'client_id', 'class' => 'form-control'));
                            echo Close('div');
                        echo Close('div');

                        echo Open('div', array('class' => 'col-md-3 form-group'));
                            echo Open('div', array('class' => 'input-group'));
                                echo tagcontent('span', 'Orden Nro', array('class' => 'input-group-addon'));
                                echo input(array('name' => 'secuencia', 'class' => 'form-control'));
                            echo Close('div');
                        echo Close('div');
                        
                       
                        echo tagcontent('button', 'Buscar', array('id' => 'ajaxformbtn', 'data-target' => 'equipos_ingresados_out', 'class' => 'btn btn-primary'));
                    echo Close('form'); //cierra form de buscar proveedor

                    echo tagcontent('div', '', array('id' => 'equipos_ingresados_out', 'class' => 'col-md-12'));

            echo closeTag('div'); /* cierre de pestania attrequipo */

            echo closeTag('div'); /* cierra tab-content */


            echo tagcontent('script', "$('.pick-a-color').pickAColor();");
            echo tagcontent('script', "$('.pick-a-color2').pickAColor();");



?>


            </div>

            </div>
            </div>