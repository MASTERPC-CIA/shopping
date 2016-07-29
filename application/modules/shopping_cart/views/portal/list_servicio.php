<?php
echo Open('div', array('class' => 'col-md-12'));
$caja_texto = '<input type="text" id="search" placeholder="Buscar" class="form-control input-sm">';

echo "<div class='panel'>";
ECHO '<div class="panel-heading">
          <div class="row">
            <div class="col-md-4"><b>Total Servicios: </b>' . $num_registros . '</div>
             <div class="col-md-4 col-md-offset-4">' . $caja_texto . '</div> 
          </div>
        </div>';

echo '<div id="div1">';
echo Open('table', array('id' => 'table', 'class' => "table table-bordered table-striped table-responsive", "style" => 'font-size:11px'));
echo '<thead>';
echo tagcontent("td", 'Cliente', array('style' => 'color:white;background:#494949'));
echo tagcontent("td", 'Nombre Equipo', array('style' => 'color:white;background:#494949'));
echo tagcontent("td", 'Problema', array('style' => 'color:white;background:#494949'));
echo tagcontent("td", 'Serie/Imei.', array('style' => 'color:white;background:#494949'));
echo tagcontent("td", 'Marca', array('style' => 'color:white;background:#494949'));
echo tagcontent("td", 'Modelo', array('style' => 'color:white;background:#494949'));
echo tagcontent("td", 'Presup', array('style' => 'color:white;background:#494949'));
echo tagcontent("td", 'Estado', array('style' => 'color:white;background:#494949'));
echo tagcontent("td", 'Detalle', array('style' => 'color:white;background:#494949'));
echo tagcontent("td", 'F. Entrega', array('style' => 'color:white;background:#494949'));
echo tagcontent("td", 'F. Ingreso', array('style' => 'color:white;background:#494949'));
echo tagcontent("td", 'Generar Documento', array('style' => 'color:white;background:#494949'));
echo tagcontent("td", 'Doc. Entrega', array('style' => 'color:white;background:#494949'));


echo '</thead>';
echo '<tbody>';
if (!empty($equipo)){
    foreach ($equipo as $val) {
        echo Open('tr');
        echo tagcontent('td', $val->nombres);
        echo tagcontent('td', $val->nombre_equipo);
        echo tagcontent('td', $val->problema);
        echo tagcontent('td', $val->problema);
        echo tagcontent('td', $val->nombre);
        echo tagcontent('td', $val->nombre);
        echo tagcontent('td', $val->presupuesto);
        echo tagcontent('td', $val->presupuesto);
        echo tagcontent('td', $val->presupuesto);
        echo tagcontent('td', $val->fechaentrega);
        echo tagcontent('td', $val->fecha);
        echo open("td");
       // echo "<td align='center'><button class='btn btn-default btnEtiqueta' id='" . $c . "' onclick='http://www.billingsof.com/demo/stecnico/documento/doc_estado_view/2236'><span class='glyphicon glyphicon-print'></button></td>";
        ?>
       
        <button type="button"  title = "Estado" data-target="opcion_elegida" id="ajaxpanelbtn" class="btn btn-default fa fa-print" data-url="<?php echo base_url('servicios/doc_estado_view/'.$val->id);  ?>"></button>
        <?php  echo close("td"); echo open("td") ?>
              
        <button type="button"  title = "Imprimir" data-target="opcion_elegida" class="btn btn-primary fa fa-edit" id="ajaxpanelbtn" data-url="<?php echo base_url('servicios/get_stequipo/'.$val->id) ?>"></button>

        <?php echo close("td");
        echo '</td>';
        echo Close('tr');
    }
} ELSE{
   echo tagcontent("td" ,"No se encontraron resultados", array('colspan'=>'13'));
}
echo '</tbody>';
echo '</table>';
echo '</div>';

echo "</div>";
echo Close('div');
?>


<script>

    var $rows = $('#table tr');
    $('#search').keyup(function () {
        var val = $.trim($(this).val()).replace(/ +/g, ' ').toLowerCase();

        $rows.show().filter(function () {
            var text = $(this).text().replace(/\s+/g, ' ').toLowerCase();
            return !~text.indexOf(val);
        }).hide();
    });
</script>