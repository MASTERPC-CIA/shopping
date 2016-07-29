
<?php
echo Open('form', array('id'=>'reporte_servicio', 'method' => 'post', 'action' => base_url('portal/servicios/get_reporte_servicio_portal')));

echo Open('div', array('class' => 'col-md-4 form-group'));
echo Open('div', array('class' => 'input-group'));
echo tagcontent('span', 'RUC/CI. Cliente: ', array('class' => 'input-group-addon'));
echo input(array('name' => 'client_id', 'class' => 'form-control', 'required'=>'required'));
echo Close('div');
echo Close('div');

echo Open('div', array('class' => 'col-md-3 form-group'));
echo Open('div', array('class' => 'input-group'));
echo tagcontent('span', 'Orden Nro', array('class' => 'input-group-addon'));
echo input(array('name' => 'secuencia', 'class' => 'form-control'));
echo Close('div');
echo Close('div');?>

 <input type="submit" value='Buscar'class="btn btn-primary" id="guardar" name="guardar"/>
     <?php
//echo tagcontent('input', 'Buscar', array('id' => 'ajaxformbtn',  'class' => 'btn btn-primary'));
echo Close('form'); //cierra form de buscar proveedor

echo open("div", array('id'=>'resultado_equipos'));

echo close("div");
?>
<script type="text/javascript">
    $(document).ready(function () {
        $("#reporte_servicio").submit(function () {
            $.ajax({
                url: $(this).attr("action"),
                type: $(this).attr("method"),
                data: $(this).serialize(),
                success: function (data)
                {
                    $('#resultado_equipos').html(data);
                    
                }
            });
            return false;
        });

    });


</script>