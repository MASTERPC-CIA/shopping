<?php
echo Open('div', array('class' => 'col-md-12'));
$caja_texto = '<input type="text" id="search" placeholder="Buscar" class="form-control input-sm">';

echo "<div class='panel panel-success'>";
      ECHO '<div class="panel-heading">
          <div class="row">
            <div class="col-md-4">NUMEROS DE REGISTROS ENCONTRADOS : N° '.$num_registros.'</div>
             <div class="col-md-4 col-md-offset-4">'.$caja_texto.'</div> 
          </div>
        </div>';
        
            echo '<div id="div1">';
             echo Open('table', array('id'=>'table','class' => "table table-fixed-header"));
             echo '<thead>';
                    $thead = array(
                                'CLIENTE',
                                'NOMBRE EQUIPO',
                                'PROBLEMA',
                                'Serie/IMEI. 	',
                                'MARCA',
                                'MODELO',
                                'PRESUP.',
                                'ESTADO',
                                'DETALLE',
                                'F. ENTREGA',
                                'F. INGRESO',
                                'GENERAR DOCUMENTO',
                                'DOC.ENTREGA'
                              );
                    
                    echo tablethead($thead);
                echo '</thead>';
                echo '<tbody>';
                    if(!empty($equipo)):
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
   
                             //   echo tagcontent('td', $val->recomendaciones);
                                echo '<td>';
                                ?>
                               <!-- <button type="button"  title = "Imprimir Informe" data-target="opcion_elegida" id="ajaxpanelbtn" class="btn btn-default fa fa-print" data-url="<?php// echo base_url('fisiatria/informe/get_imprimir/'.$val->id_informe); ?>"></button>
                                <button type="button"  title = "Editar Informe" data-target="opcion_elegida" class="btn btn-primary fa fa-edit" id="ajaxpanelbtn" data-url="<?php //echo base_url('fisiatria/informe/modificar_informe/'.$val->id_informe)?>"></button>
                                <button type="button"  title = "Anular Informe"   data-target="opcion_elegida" id="ajaxpanelbtn" class="btn btn-danger fa fa-trash-o"  data-url="<?php //echo base_url('fisiatria/informe/anular_informe_informe/'.$val->id_informe); ?>"></button> --!>
                                <?php
                                echo '</td>';
                            echo Close('tr');
                        }
                    endif;
                echo '</tbody>';
            echo '</table>';
             echo '</div>';
     
        echo "</div>";
echo Close('div');
?>
  
<style>

#div1 {
     overflow:scroll;
     height:400px;
     width:100%;
}
#div1 table {
    width:100%;
}
</style>
<script>

var $rows = $('#table tr');
$('#search').keyup(function() {
    var val = $.trim($(this).val()).replace(/ +/g, ' ').toLowerCase();
    
    $rows.show().filter(function() {
        var text = $(this).text().replace(/\s+/g, ' ').toLowerCase();
        return !~text.indexOf(val);
    }).hide();
});
</script>