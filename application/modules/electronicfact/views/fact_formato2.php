<?php

/* 
 * Formato de la factura : Formato 1
 */

echo $head; /* En el head aparece una lista de opciones a realizar con la factura */

echo lineBreak2(1, array('class'=>'clr'));

echo tagcontent('div', '', array('id'=>'fact_venta_actions_out','class'=>'col-md-12'));
//echo tagcontent('div', '', array('id'=>'vp_fp_view','class'=>'col-md-12'));
//echo tagcontent('div', '', array('id'=>'va_action_view')); /* venta archivada action vista*/
echo Open('div',array('id'=>'formaspagores_out','class'=>'col-md-12')); /* Si se confirma el pago, en este div aparecera la factura archivada */
echo Open('div',array('id'=>'factventaprint_view', 'style'=>'font-family:monospaced;font-size:11px','class'=>'col-md-12'));

    echo Open('div',array('class'=>'col-md-4','style'=>''));
        echo tagcontent('label', $empresa->razonSocial, array('class'=>'clr'));
        echo tagcontent('div', 'Direcci&oacute;n Matriz: '.$empresa->direccion, array('class'=>'clr'));
        echo tagcontent('div', 'CONTRIBUYENTE '.$contribuyente->clase.' SEG&Uacute;N RESOLUCI&Oacute;N No. NAC-PCTRSGE11-'.$contribuyente->resolucion.' DEL 29 DE JULIO DEL 2011', array('class'=>'clr'));
        echo tagcontent('div', 'OBLIGADO A LLEVAR CONTABILIDAD: '.$contribuyente->contabilidad, array('class'=>'clr'));
    echo Close('div');

    echo Open('div',array('class'=>'col-md-8','style'=>''));
        echo tagcontent('div', 'R.U.C.: '.$this->encript->decryptbase64($empresa->ruc,  get_settings('PASSWORDSALTMAIN')), array('class'=>'clr'));
        if( $data->autorizado_sri ){
            echo tagcontent('strong', 'FACTURA Nro.: '.$data->establecimiento.$data->pemision.'-'.str_pad($data->nro_fact, 9, '0', STR_PAD_LEFT), array('class'=>'','style'=>'')).'<br/>';
            echo tagcontent('div', 'Autorizacion SRI Nro.:'.$data->aut_sri, array('class'=>'col-md-12','style'=>''));
            echo tagcontent('div', 'Fecha y hora de autorizaci&oacute;n:'.$data->fechaarchivada.' '.$data->hora, array('class'=>'col-md-12','style'=>''));
            echo tagcontent('div', 'AMBIENTE: PRODUCCION', array('class'=>'col-md-12','style'=>''));
            echo tagcontent('div', 'EMISION: NORMAL', array('class'=>'col-md-12','style'=>''));
            echo tagcontent('div', 'CLAVE DE ACCESO: '.$data->cod_fact_electronica, array('class'=>'col-md-12','style'=>''));
        }else{
            echo tagcontent('strong', 'Nro. Registro '.str_pad($data->venta_id, 9, '0', STR_PAD_LEFT), array('class'=>'','style'=>'')).'<br/>';
            echo tagcontent('strong', 'Serie: '.$data->establecimiento.'-'.$data->pemision, array('class'=>'','style'=>'')).'<br/>';        
            echo tagcontent('div', 'Fecha Reg.:'.$data->fechaCreacion.' '.$data->hora , array('class'=>'','style'=>'')).'<br/>';                    
        }
    echo Close('div');
    echo lineBreak2(1, array('class'=>'clr'));

    echo Open('div',array('class'=>'col-md-12','style'=>''));
        echo tagcontent('div', 'Nombre o Raz&oacute;n Social: '.$client->apellidos.' '.$client->nombres, array('class'=>'col-md-6','style'=>''));
        echo tagcontent('div', 'RUC/CI: '.$client->PersonaComercio_cedulaRuc, array('class'=>'col-md-6','style'=>''));
        echo tagcontent('div', 'Fecha de Emisi&oacute;n: '.$data->fechaCreacion, array('class'=>'col-md-6','style'=>''));
    echo Close('div');

    echo Open('div',array('class'=>'col-md-12'));
        echo Open('table',array('class'=>'table table-striped table-condensed','style'=>'font-size:10px'));
        $thead = array('Cod.','Producto','Cant.','Precio','<span class="pull-right">Total</span>');
        echo tablethead($thead);
            if($detalle){
                foreach ($detalle as $product) {
                        echo tagcontent('td', $product->product_cod);
                        echo tagcontent('td', $product->product_name.', <strong>'.$product->meses_garantia.' meses de garantia</strong>');
                        echo tagcontent('td', $product->itemcantidad);
                        echo tagcontent('td', $product->itemprecioneto);
                        echo tagcontent('td', '<span class="pull-right">'.number_format($product->itemprecioxcantidadneto, NUMDECIMALES)).'</span>';
                    echo Close('tr');
                }
            }else{
                echo tagcontent('div', 'Su carrito de compras est&aacute; vac&iacute;o ... '.tagcontent('a', '<span class="glyphicon glyphicon-shopping-cart"></span>', array('data-url'=>base_url('ventas/product/searchview'),'href'=>'#','data-target'=>'container-fluid','id'=>'loadproductsviewbtn')), array('class'=>'text-danger font30','style'=>'font-weight: bold'));
            }
        echo Close('table');
    echo Close('div');
    echo Open('div',array('class'=>'col-md-3 pull-right font11'));
        echo Open('table',array('class'=>'table table-condensed','style'=>'font-size:11px'));
            echo tagcontent('tr', tagcontent('td', '<span class="pull-right">Tarifa cero:</span>').  tagcontent('td', '<span class="pull-right">'.  number_decimal($data->tarifacerobruto).'</span>' ));
            echo tagcontent('tr', tagcontent('td', '<span class="pull-right">Tarifa doce:</span>').  tagcontent('td', '<span class="pull-right">'.  number_decimal($data->tarifadocebruto).'</span>' ));
            echo tagcontent('tr', tagcontent('td', '<span class="pull-right">Subtotal:</span>').  tagcontent('td', '<span class="pull-right">'.  number_decimal($data->subtotalBruto).'</span>' ));/* Subotal bruto - antes del descuento */
            echo tagcontent('tr', tagcontent('td', '<span class="pull-right">Recargo:</span>').  tagcontent('td', '<span class="pull-right">'.  number_decimal($data->recargovalor).'</span>' ));
            echo tagcontent('tr', tagcontent('td', '<span class="pull-right">Descuento:</span>').  tagcontent('td', '<span class="pull-right">'.  number_decimal($data->descuentovalor).'</span>' ));
            echo tagcontent('tr', tagcontent('td', '<span class="pull-right">Subtotal Neto:</span>').  tagcontent('td', '<span class="pull-right">'.  number_decimal($data->subtotalBruto).'</span>' ));/* Subotal bruto - antes del descuento */            
            echo tagcontent('tr', tagcontent('td', '<span class="pull-right">ICE:</span>').  tagcontent('td', '<span class="pull-right">'.  number_decimal($data->iceval).'</span>' ));
            echo tagcontent('tr', tagcontent('td', '<span class="pull-right">IVA:</span>').  tagcontent('td', '<span class="pull-right">'.  number_decimal($data->ivaval).'</span>' ));
            echo tagcontent('tr', tagcontent('td', '<span class="pull-right">Total:</span>').  tagcontent('td', '<span class="pull-right">'.  number_decimal($data->totalCompra).'</span>' ));
        echo Close('table');
    echo Close('div');
    
    echo Open('div',array('class'=>'col-md-9  pull-left'));
            echo tagcontent('label', 'Informaci&oacute;n Adicional', array('class'=>'clr'));
            echo tagcontent('div', 'E-mail:'.$client->email, array('class'=>'','style'=>'clr'));
            echo tagcontent('div', 'Tel&eacute;fono:'.$client->telefonos, array('class'=>'clr','style'=>''));
            echo tagcontent('div', 'Direcci&oacute;n:'.$client->direccion, array('class'=>'clr','style'=>''));
    echo Close('div');
    
//    echo Open('div',array('class'=>'col-md-9  pull-left'));
//        echo tagcontent('strong', 'Vendedor:'.$vendedor->nombres.' '.$vendedor->apellidos, array('class'=>'','style'=>'')).'<br/>';
//        echo tagcontent('strong', 'Tecnico:'.$tecnico->nombres.' '.$tecnico->apellidos, array('class'=>'','style'=>'')).'<br/>';
//        echo tagcontent('strong', 'Tipo:'.$pago->tipo.', '.$data->tipoprecio, array('class'=>'','style'=>'')).'<br/>';
//    echo Close('div');    
    
    $texto_info = 'Este documento es v&aacute;lido cuando incluye la clave de acceso autorizada o autorizaci&oacute;n SRI. Para descargar este documento autorizado ingrese a nuestro sitio web www.masterpc.com.ec en la opcion Facturaci&oacute;n Electr&oacute;nica, con su Cedula/Ruc como usuario y password';
    echo tagcontent('div', $texto_info, array('class'=>'col-md-9 pull-left'));    
    
    
//    $f_venta = tagcontent('div', 'F. Usuario:'.$this->user->nombres.'...........................', array('clas'=>'col-md-6'));
//    $f_venta .= tagcontent('div', 'F. Cliente:'.$client->nombres.' '.$client->apellidos.'...........................', array('clas'=>'col-md-6'));    
//    echo tagcontent('div', $f_venta, array('class'=>'col-md-9  pull-left'));
    echo lineBreak(1, array('class'=>'clr'));
    echo tagcontent('span', 'Software desarrollado por MASTER PC CIA. LTDA, Tlf. 0996534865', array('class'=>'col-md-12'));    
echo Close('div');
echo Close('div'); /* cierra factventaprint_view */