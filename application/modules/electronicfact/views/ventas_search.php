<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

    /* Cargamos el punto de venta, para cuando se vaya a pagar una factura en pendiente */
        echo '<div class="tab-content">';
        
            echo Open('div',array('class'=>"tab-pane active",'id'=>"clientsearch"));        
                echo Open('form', array('method'=>'post','action'=>  base_url('electronicfact/invoice/get'),'style'=>'margin-top:10px'));
                
                    echo input(array('type'=>'hidden','value'=>'01','name'=>'tiposcomprobante_cod','id'=>'tiposcomprobante_cod'));
                    
                    echo Open('div',array('class'=>'col-md-2 form-group'));
                        echo Open('div',array('class'=>'input-group'));
                          echo tagcontent('span', 'Nro.', array('class'=>'input-group-addon'));
                          echo input(array('name'=>"nro",'id'=>"f_emision_desde", 'type'=>"text",'class'=>"form-control positive",'placeholder'=>"Nro. Fact", 'style'=>"width: 100%"));
                        echo Close('div');
                    echo Close('div');                
                    
                    echo Open('div',array('class'=>'col-md-3 form-group'));
                        echo Open('div',array('class'=>'input-group'));
                          echo tagcontent('span', 'F. Emision', array('class'=>'input-group-addon'));
                          echo input(array('name'=>"f_emision_desde",'id'=>"f_emision_desde", 'type'=>"text",'class'=>"form-control datepicker",'placeholder'=>"Desde", 'style'=>"width: 50%"));
                          echo input(array('name'=>"f_emision_hasta",'id'=>"f_emision_hasta", 'type'=>"text", 'class'=>"form-control datepicker", 'placeholder'=>"Hasta", 'style'=>"width: 50%"));
                        echo Close('div');
                    echo Close('div');                
                    
//                    echo Open('div',array('class'=>'col-md-3 form-group'));
//                        echo Open('div',array('class'=>'input-group'));
//                          echo tagcontent('span', 'F. Vence', array('class'=>'input-group-addon'));
//                          echo input(array('name'=>"f_vence_desde",'id'=>"f_vence_desde", 'type'=>"text",'class'=>"form-control datepicker",'placeholder'=>"Desde", 'style'=>"width: 50%"));
//                          echo input(array('name'=>"f_vence_hasta",'id'=>"f_vence_hasta", 'type'=>"text", 'class'=>"form-control datepicker", 'placeholder'=>"Hasta", 'style'=>"width: 50%"));
//                        echo Close('div');
//                    echo Close('div');                

//                    $inp_btn = input(array('name'=>'femision','class'=>'form-control datepicker','placeholder'=>'Fecha Emision'));                    
                    echo tagcontent('button', '<span class="glyphicon glyphicon-search"></span> Buscar Facturas', array('type'=>'submit','id'=>'ajaxformbtn','data-target'=>'clientslistout','class'=>'btn btn-primary'));                                       
//                    echo Open('div',array('class'=>'input-group col-md-6'));
//                        echo $inp_btn; 
//                        echo tagcontent('span', $searchbtn, array('class'=>'input-group-btn'));
//                        echo tagcontent('span', tagcontent('button', 'Reset', array('type'=>'button','class'=>'btn btn-info','id'=>'ajaxidbtn','rowid'=>'1','data-url'=> base_url().'compras/compras/reset_form', 'data-target'=>'reset_form' )), array('class'=>'input-group-btn'));
//                    echo Close('div');
                echo Close('form');
                echo tagcontent('div', '', array('id'=>'reset_form'));
                echo lineBreak2(1, array('class'=>'clr'));
                echo tagcontent('div', '', array('id'=>'firma_fact_sri_out','class'=>'col-md-12'));                
                
                echo tagcontent('div', '', array('id'=>'clientslistout','class'=>'col-md-12'));
            echo Close('div');        
            
$js = array(
    base_url('resources/js/modules/venta_admin.js'),

);
echo jsload($js);            