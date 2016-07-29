<?php
//print_r($equipo);
//echo '<br/>';
//print_r($equipoattrequipo);
echo Open('div', array('id' => 'print'));

echo tagcontent('button', '<span class="glyphicon glyphicon-print"></span> Imprimir', array('id' => 'printbtn', 'data-target' => 'equipo_ingreso_print', 'class' => 'btn btn-success btn-sm'));
echo tagcontent('button', '<span class="glyphicon glyphicon-print"></span> Imprimir Tirilla', array('id' => 'printbtn', 'data-target' => 'tirillaprint_view', 'class' => 'btn btn-info btn-sm'));
/* Editar Ingreso */
echo Open('form', array('method' => 'post', 'name' => 'form1', 'id' => 'form1', 'action' => base_url('stecnico/equipo/update_equipo')));
echo input(array('type' => 'hidden', 'name' => 'stequipo_id', 'id' => 'stequipo_id', 'value' => $id));
echo tagcontent('button', '<span class="glyphicon glyphicon-pencil"></span> Editar', array('id' => 'ajaxformbtn', 'name' => 'editar', 'data-target' => 'print','onclick'=>"myClickCallback()"));
echo Close('form');

echo Close('div');
/* Fin editar ingreso */
if(get_settings('IMPRESORAS_MATRICIALES') == 0){
    $estilo = 'font-family:monospaced;font-size:11px';
}else{
    $estilo = 'letter-spacing:3px;font-family:monospace;font-size:11px';
}
echo Open('div', array('id' => 'equipo_ingreso_print', 'class' => 'col-md-12', 'style' => $estilo));
echo LineBreak(1);
echo Open('table', array('class' => 'table table-striped table-condensed', 'style' => $estilo));
echo Open('tr');
echo tagcontent('td', '<label>Nro.</label> ' . $equipo->prefix . str_pad($equipo->id, 11, '0', STR_PAD_LEFT));
if ($equipo->secuencia > 0) {
    echo tagcontent('td', '<label>Orden Nro.</label> ' . str_pad($equipo->secuencia, 9, '0', STR_PAD_LEFT), array('style' => 'font-size:12pt'));
}

echo tagcontent('td', '<label>F.Ingreso: </label> ' . $equipo->fecha . ' ' . $equipo->hora);
echo tagcontent('td', '<label>F.Entrega: </label> ' . $equipo->fechaentrega . ' ' . $equipo->horaentrega);
echo tagcontent('td', '<label>Servicio: </label> ' . $equipo->tipo_servicio);
//echo tagcontent('td', '<label>Marca: </label>'.$equipo->marca);
echo tagcontent('td', '<label>Tecnico: </label>' . $equipo->tecnico_nombres . $equipo->tecnico_apellidos);
echo Close('tr');
echo Open('tr');
echo tagcontent('td', 'Cl.: ' . $equipo->client_nombres . ' ' . $equipo->client_apellidos);
echo tagcontent('td', 'C.I: ' . $equipo->client_id);
echo tagcontent('td', 'Tlf.: ' . $equipo->client_telefonos);
echo tagcontent('td', 'E-mail: ' . $equipo->client_email);
echo tagcontent('td', 'Dir: ' . $equipo->client_direccion, array('colspan' => '2'));
echo Close('tr');
echo Open('tr');
echo tagcontent('td', '<strong>Equipo: </strong>' . $equipo->nombre_equipo, array('colspan' => '6'));
echo Close('tr');
echo Open('tr');
echo tagcontent('td', '<strong>Problema: </strong>' . $equipo->problema, array('colspan' => '6'));
echo Close('tr');
echo Open('tr');
echo tagcontent('td', '<strong>Caracteristicas: </strong>' . $equipo->caracteristicas, array('colspan' => '6'));
echo Close('tr');
echo Close('table');
//echo tagcontent('div', 'EQUIPO: '.$equipo->nombre_equipo, array('class'=>'col-md-3'));
if ($equipoattrequipo) {
    foreach ($equipoattrequipo as $val) {
        echo tagcontent('div', $val->nombreattr . ': ' . $val->valor, array('class' => 'col-md-3'));
    }
}
echo tagcontent('div', 'PRESUPUESTO: ' . $equipo->presupuesto . ' ANTICIPO: ' . $equipo->anticipocliente, array('class' => 'col-md-3'));
//print_r($equipodet);
echo LineBreak();
if ($equipodet) {
    echo tagcontent('div', 'DETALLE DE ESTADO: ' . $equipodet[0]->detalle . ' FECHA:' . $equipodet[0]->fecha . ' HORA:' . $equipodet[0]->hora, array('class' => 'col-md-12'));
}

echo Open('table', array('class' => 'table table-striped table-condensed', 'style' => $estilo));
echo Open('tr');
echo tagcontent('td', '&nbsp;');
echo tagcontent('td', '&nbsp;');
echo Close('tr');
echo Open('tr');
echo tagcontent('td', 'Usuario: ' . $usuario->nombres);
echo tagcontent('td', 'Cliente: ' . $equipo->client_nombres . ' ' . $equipo->client_apellidos);
echo Close('tr');
echo Open('tr');
echo tagcontent('td', '<strong>Condiciones: </strong>El cliente tiene la obligación de realizar sus propios respaldos, '.  get_settings('RAZON_SOCIAL').' no se responsabiliza. Pasados 90 días '.  get_settings('RAZON_SOCIAL').' no se responsabiliza del estado de equipos, en impresoras hasta 8 días, y se cobrará su permanencia en bodega. La garantía de 15 días no cubre problemas causados por programas que el cliente instale o virus. Para retirar traer el ticket de ingreso. Para toda Garantía se necesita facturas, CDs, manual, cajas, no se recibe roto, quebrado o con líquido. Este documento es el único comprobante válido para el retiro de su equipo, su reposición tendá un costo de 5 dolares. GRACIAS POR SU COLABORACIÓN. '.  get_settings('RAZON_SOCIAL').' NO ES REPONSABLE POR EL SOFTWARE PREINSTALADO DEL CLIENTE SIN LICENCICAS ORIGINALES. Por medio de mi firma en este documento autorizo para que '.  get_settings('RAZON_SOCIAL').' done este equipo si no es retirado en 90 dias ', array('colspan' => '2', 'style' => 'font-size:10px'));
echo Close('tr');
echo Open('tr');
echo tagcontent('td', '<strong>Fecha de Impresi&oacute;n: </strong>' . date('Y-m-d H:i:s', time()), array('colspan' => '2', 'style' => 'font-size:10px'));
echo Close('tr');
echo Close('table');
echo Close('div');

echo Open('div', array('id' => 'tirillaprint_view', 'class' => 'col-md-12', 'style' => 'font-family:monospaced'));
$this->load->view('comprob_tirilla_print', $equipo);
echo Close('div');

//Imprimir directamente por defecto
//echo tagcontent('script', '$("#equipo_ingreso_print").printThis({optprint1})');
?>
<script>

    //$('#editar').click(myClickCallback);
    function myClickCallback() {
        //alert('hi, hello');
        document.getElementById("print").innerHTML = "";
        document.getElementById("equipo_ingreso_print").innerHTML = "";
        document.getElementById("tirillaprint_view").innerHTML = "";
    }
</script>

