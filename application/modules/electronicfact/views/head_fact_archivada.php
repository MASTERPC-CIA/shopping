<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

echo Open('div', array('class'=>'col-md-12','style'=>'background:#4eb305'));
    echo tagcontent('span', 'Factura Archivada', array('class'=>'pull-right','style'=>'color:#fff;font-weight: bold;font-size:18px'));
    echo tagcontent('button', '<span class="glyphicon glyphicon-print"></span> Imprimir', array('class'=>'btn btn-default'));
    
//    $check_permission = $this->user->check_permission( array('admin','anular_ventas'), $this->user->id );
//    if($check_permission OR ($this->user->root == 1) ){
//        echo tagcontent('button', '<span class="glyphicon glyphicon-off"></span> Anular', array('class'=>'btn btn-danger','id'=>'ajaxidbtn','data-url'=> base_url( 'ventas/ventas/anular_venta_view/'.$venta_id ), 'data-target'=>'#fact_venta_actions_out'));        
//    }    
    
//    $check_permission = $this->user->check_permission( array('admin','make_nota_credito'), $this->user->id );
//    if($check_permission OR ($this->user->root == 1) ){
//        echo tagcontent('a', 'Nota de Credito', array('class'=>'btn btn-info','href'=> base_url( 'nota_credito_venta/index/index/'.$venta_id ), 'target'=>'_blank'));        
//    }

echo Close('div');