<?php
if(!empty($producto_info)){
            foreach ($producto_info as $val) {
                $produc_info = $val->nombreUnico;
                $cod_prod = $val->codigo;
            }
        }
            if(!empty($proveedor_info)){
        foreach ($proveedor_info as $val) {
            $provee_info = $val->nombres;
            $cod_provee = $val->id;
                    
        }
    }
    
        echo Open('table', array('class'=>'table table-striped table-condensed'));
          echo Open('tr');
                    echo Open('td');
                        echo tagcontent('td', '<label>Nro.</label> '.$equipo->anio.'-'.$equipo->prefix.str_pad($equipo->id, 11, '0', STR_PAD_LEFT));
                        echo tagcontent('td', '<label>F.Ingreso: </label> '.$equipo->fecha.' '.$equipo->hora);
                        echo tagcontent('td', '<label>Cliente.: </label>'.$equipo->client_nombres.' '.$equipo->client_apellidos);
                        echo tagcontent('td', '<label>C.I: </label>'.$equipo->client_id);
                    echo Close('td');
                echo Close('tr');
        echo Close('table');      
        /*FIN INFORMACION CLIENTE*/
        
        /*SELECCIONA PROVEEDOR Y PRODUCTO */
        /*PRODUCTO */
        
            echo Open('div',array('class'=>'col-md-12'));
               /// echo Open('div',array('class'=>'col-md-6'));
            
                   echo Open('form', array('class'=>'form-horizontal','method'=>'post','action'=>base_url('stecnico/documento/busca_producto')));
                    echo Open('div',array('class'=>'col-md-6 form-group'));
                    echo Open('div',array('class'=>'input-group'));
                    echo tagcontent('span', '<font color = green>* Ingrese el Nom.Producto: </font>', array('class'=>'input-group-addon'));
                    if(!empty($produc_info)):
                            echo input(array('required'=>'','value' => $produc_info,'name'=>'product_name','id'=>'product_name_autosug','placeholder'=>'Busca Productos','class'=>'form-control', 'callback'=>'refresh_cart_insert_prod','data-url'=>base_url('common/autosuggest/get_product_by_name/%QUERY')));
                        else:
                            echo input(array('required'=>'','value' => $pro_info_cero,'name'=>'product_name','id'=>'product_name_autosug','placeholder'=>'Busca Productos','class'=>'form-control', 'callback'=>'refresh_cart_insert_prod','data-url'=>base_url('common/autosuggest/get_product_by_name/%QUERY')));
                    endif;
                    echo Close('div');
                    echo Close('div');
                    
            //    echo input(array('type'=>'submit','id'=>'ajaxformbtn','data-target'=>'productslistout','value'=>'Buscar','class'=>'btn btn-primary ','style'=>'margin-right:10px'));
               echo tagcontent('span', tagcontent('button', '<span class="glyphicon glyphicon-search"></span>', array('class'=>'btn btn-primary','type'=>'submit','style'=>'margin-right:10px','data-target'=>'productslistout','id'=>'ajaxformbtn')));
                
                echo Close('form');
                echo tagcontent('div', '', array('id'=>'productslistout','class' => 'col-md-12'));
                
            echo Close('div');
        /*FIN PRODUCTO */
        
        /*PROVEEDOR */
        /*FIN PROVEEDOR */
        
        /*FIN SELECCIONA PROVEEDOR Y PRODUCTO */
        
//            echo'<div class ="row">';
//            echo '<div class="col-xs-6 col-md-6">';
//            echo' <h3><small><font color = green>* Seleccionar el Producto: </font></small></h4>';
            
                ?>
            <div class="col-lg-12">
                <div class="input-group">
                   <!--<input type="text"  class="form-control input-sm" placeholder="Busca Productos y servicios" callback='refresh_cart_insert_prod' id='product_name_autosug' data-url="<?= base_url('common/autosuggest/get_product_by_name/%QUERY') ?>">-->
                  <span class="input-group-btn">
                        <?php
//                        echo Open('form', array('class'=>'form-horizontal','method'=>'post','action'=>base_url('stecnico/documento/busca_producto')));
//                        echo input(array('type'=>'submit','id'=>'ajaxformbtn','data-target'=>'productslistout','value'=>'Buscar','class'=>'btn btn-primary pull-right','style'=>'margin-right:10px'));
//                        echo Close('form');
//                        echo tagcontent('div', '', array('id'=>'productslistout','class' => 'col-md-12'));
                        ?>
                  </span>
                </div><!-- /input-group -->
            </div>
            
            


<?php
echo Open('form', array('action' => base_url('stecnico/equipo/nuevoPro'), 'method' => 'post'));
 
            echo input(array('type' => 'hidden', 'name' => 'nroGuia', 'id' => 'nroGuia', 'value' => 'S/N'));
            echo input(array('type' => 'hidden', 'name' => 'estado_id', 'id' => 'estado_id', 'value' => '2'));
            echo input(array('type' => 'hidden', 'name' => 'anio', 'id' => 'anio', 'value' => $equipo->anio));
            echo input(array('type' => 'hidden', 'name' => 'prefix', 'id' => 'prefix', 'value' => $equipo->prefix));
            echo input(array('type' => 'hidden', 'name' => 'id_doc', 'id' => 'id_doc', 'value' => $equipo->id));
            echo input(array('type' => 'hidden', 'name' => 'tiposervicio_id', 'id' => 'tiposervicio_id', 'value' => $equipo->tipo_servicio));
            if(!empty($producto_info)):
                echo input(array('type' => 'hidden', 'id' => 'prod_id', 'name' => 'prod_id', 'value' => $cod_prod));
            
                else:
                    echo input(array('type' => 'hidden', 'id' => 'prod_id', 'name' => 'prod_id', 'value' => ''));
            
              //  $cod_prod 
            endif;
            if(!empty($proveedor_info)):
                echo input(array('type' => 'hidden', 'id' => 'prove_id', 'name' => 'prove_id', 'value' => $cod_provee));
            
                else:
                echo input(array('type' => 'hidden', 'id' => 'prove_id', 'name' => 'prove_id', 'value' => ''));
            
            endif;
            echo input(array('type' => 'hidden', 'name' => 'fecha_imgreso', 'id' => 'fecha_imgreso', 'value' => $equipo->fecha));
            echo input(array('type' => 'hidden', 'name' => 'hora_imgreso', 'id' => 'hora_imgreso', 'value' => $equipo->hora));
            echo input(array('type' => 'hidden', 'name' => 'cliente_id', 'id' => 'cliente_id', 'value' => $equipo->client_id));
echo lineBreak2(1);
echo tagcontent('div', '', array('id' => 'produc_seleccionado', 'class' => 'col-md-12'));
 echo Open('div',array('class'=>'col-md-12'));

      
echo lineBreak2(1);

   // echo $pro_info_cero;
    echo Open('div',array('class'=>'col-md-5 form-group'));
            echo Open('div',array('class'=>'input-group'));
            echo tagcontent('span', '<font color = green>* Sel. Prove.:  </font>', array('class'=>'input-group-addon'));
            if(!empty($provee_info)):
                    echo input(array('required'=>'','value' => $provee_info,'name'=>'proveedor_name','id'=>'provee_name_autosug','placeholder'=>'Busca Productos','class'=>'form-control', 'callback'=>'refresh_cart_insert_prov','data-url'=>base_url('common/autosuggest/get_proveedor_by_name/%QUERY')));
                else:
                    echo input(array('required'=>'','value' => $prove_info_cero,'name'=>'proveedor_name','id'=>'provee_name_autosug','placeholder'=>'Busca Productos','class'=>'form-control', 'callback'=>'refresh_cart_insert_prov','data-url'=>base_url('common/autosuggest/get_proveedor_by_name/%QUERY')));
            endif;
            echo Close('div');
            echo Close('div');
       
            echo Open('div',array('class'=>'col-md-3 form-group'));
            echo Open('div',array('class'=>'input-group'));
            echo tagcontent('span', '<font color = green>* Serie Prod.:  </font>', array('class'=>'input-group-addon'));
           // print_r($valor_ser);
            if(!empty($valor_ser)):
                foreach ($valor_ser as $v) {
                    $valor_ser_exite = $v->valor;
                }
                // valor_ser_cero
            endif;
            $valor_ser_cero='';
//            echo $valor_ser_exite;
            if(!empty($valor_ser_exite)):
                echo input(array('required'=>'','value' => $valor_ser_exite,'name'=>'seriePro','id'=>'seriePro','placeholder'=>'Nombre del Producto','class'=>'form-control'));
                else:
                echo input(array('required'=>'','value' => $valor_ser_cero,'name'=>'seriePro','id'=>'seriePro','placeholder'=>'Nombre del Producto','class'=>'form-control'));
                
            endif;
            echo Close('div');
            echo Close('div');
            
            echo Open('div',array('class'=>'col-md-2 form-group'));
            echo Open('div',array('class'=>'input-group'));
            echo tagcontent('span', '<font color = green>* Cant.:  </font>', array('class'=>'input-group-addon'));
            echo input(array('required'=>'','value' => '1','name'=>'cant','id'=>'cant','placeholder'=>'Cantidad','class'=>'form-control'));
            echo Close('div');
            echo Close('div');
            
            echo Open('div',array('class'=>'col-md-2 form-group'));
            echo Open('div',array('class'=>'input-group'));
            echo tagcontent('span', '<font color = green>* Fecha E.G:  </font>', array('class'=>'input-group-addon'));
            echo input(array('required'=>'','value' =>date('Y-m-d',time()),'name'=>'fechaEnGuia','id'=>'fechaEnGuia','class'=>'form-control datepicker'));
            echo Close('div');
            echo Close('div');
        echo Close('div');
        
        echo Open('div',array('class'=>'col-md-12'));
            echo Open('div',array('class'=>'col-md-6'));
            echo '<h3><small><font color = green>* Informe Tecnico: </font></small></h4>';
            ?>
                <textarea   name="notaInfTec" id="notaInfTec" placeholder="Ingrese el Informe Tecnico" required="" class="form-control" rows="8"></textarea>
            <?php
            echo Close('div');
        
            echo Open('div',array('class'=>'col-md-6'));
            echo '<h3><small><font color = green>* Observaciones: </font></small></h4>';
            ?>
                <textarea   name="observacion" id="observacion" placeholder="Ingrese las Observaciones"  class="form-control" rows="8"></textarea>
            <?php
             echo lineBreak(2);
            echo Close('div');
        echo Close('div');
       echo Close('div');
        echo tagcontent('button', ' GRABAR', array('name' => 'btnAgregar', 'class' => 'btn btn-success  fa fa-save', 'id' => 'ajaxformbtn', 'type' => 'submit', 'data-target' => 'list_trans'));
        echo Close('form');
        echo tagcontent('div', '', array('id' => 'list_trans', 'class' => 'col-md-12'));
        ?>
<script>
/* refresca la lista de productos despues de insertar uno nuevo */
    var refresh_cart_insert_prod = function (datum) {
        var url = main_path+'stecnico/equipo/recoge_id_producto/time/'+$.now();
            $.ajax({
                type: "POST",
                url: url,
                data: { id: datum.ci, qty: 1 },       
                success: function(html){
                    $('#list_trans').html(html);  
                    document.getElementById('prod_id').value = datum.ci;
                },
                error: function(){
                    alertaError("Error!! No se pudo alcanzar el archivo de proceso", "Error!!");
                }              
            });  
            $('#product_name_autosug').val('');
    };    
     
     $.autosugest_search('#product_name_autosug');

var refresh_cart_insert_prov = function (datum) {
        var url = main_path+'stecnico/equipo/recoge_id_producto/time/'+$.now();
            $.ajax({
                type: "POST",
                url: url,
                data: { prove_id: datum.ci, qty: 1 },       
                success: function(html){
                    $('#list_trans').html(html);  
                    document.getElementById('prove_id').value = datum.ci;
                },
                error: function(){
                    alertaError("Error!! No se pudo alcanzar el archivo de proceso", "Error!!");
                }              
            });  
            $('#provee_name_autosug').val('');
    };    
     
     $.autosugest_search('#provee_name_autosug');
   
</script>      