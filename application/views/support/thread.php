<article class="content">
    <div class="card card-block">
        <?php $lista_productos_orden=$this->db->get_where('transferencia_products_orden',array('tickets_id'=>$id_orden_n))->result_array(); ?>
        
        
    </div>
	<input type="hidden" name="factura" value="<?php echo $thread_info['id_invoice'] ?>"></input>
    <div class="card card-block">
        <?php if ($response == 1) {
            echo '<div id="notify" class="alert alert-success">
            <a href="#" class="close" data-dismiss="alert">&times;</a>

            <div class="message">' . $responsetext . '</div>
        </div>';
        } else if ($response == 0) {
            echo '<div id="notify" class="alert alert-danger">
            <a href="#" class="close" data-dismiss="alert">&times;</a>

            <div class="message">' . $responsetext . '</div>
        </div>';
        } else {
            echo ' <div id="notify" class="alert alert-success" style="display:none;">
            <a href="#" class="close" data-dismiss="alert">&times;</a>

            <div class="message"></div>
        </div>';

        } ?>
        <div class="grid_3 grid_4"><h4><?php echo $thread_info['subject'] ?> </h4>
			<input type="hidden" name="detalle" value="<?php echo $thread_info['detalle'] ?>"></input>
			<input type="text" name="ids" value="<?php echo $thread_info['id'] ?>"></input>
            <p class="card card-block"><?php echo '<strong>Creado el: </strong> ' . $thread_info['created'];
                echo '<br><strong>Usuario:</strong> ' . $thread_info['name'] .' '. $thread_info['unoapellido'];
				echo '<br><strong>Celular:</strong> ' . $thread_info['celular'];
				echo '<br><strong>Direccion:</strong> ' . $thread_info['nomenclatura'].' '. $thread_info['numero1']. $thread_info['adicionauno'].' N°'. $thread_info['numero2']. $thread_info['adicional2'].' - '. $thread_info['numero3'];
				echo '<br><strong>Barrio:</strong> ' . $thread_info['barrio'];
                echo '<br><strong>Estado:</strong> <span id="pstatus">' . $thread_info['status'];		
                ?></p>
<<<<<<< Updated upstream
			<?php echo '<h4>Detalles:</h4><code class="card card-block">' . $thread_info['section']?></code>
			<table  class="table table-hover table-condensed" width="100%"> 
=======
			<?php echo '<h4>Detalles:</h4><code class="card card-block"><h5 style="text-decoration: underline;">' .$thread_info['detalle'].'</h5>'. $thread_info['section']?>
		</code>			
			<table  class="table" width="100%">
				
>>>>>>> Stashed changes
            <thead>
                <tr>
                    <th colspan="3" ><h5 align="left"><strong>Material usado en la Orden</strong></h5></th>
                </tr>
                <tr>
                    <th style="text-align: center;" width="10%">PID</th>
                    <th style="text-align: center;" width="30%">Nombre</th>
                    <th style="text-align: center;" width="20%">Cantidad Tot.</th>
                    <th style="text-align: center;" width="20%">Valor a Transferir</th>
                </tr>
            </thead>
            <tbody>

                <?php foreach ($lista_productos_orden as $key => $prod) { $prod_padre=$this->db->get_where('products',array('pid'=>$prod['products_pid']))->row(); ?>        
                    <tr>
                        <td style="text-align: center;"><?=$prod_padre->pid?></td>
                        <td style="text-align: center;"><?=$prod_padre->product_name?></td>
                        <td style="text-align: center;"><?=$prod['cantidad']?></td>
                        <td style="text-align: center;"><a onclick="eliminar_prod_lista(<?=$prod['idtransferencia_products_orden']?>)"><img src="<?=base_url()?>/assets/img/trash.png"></a></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
			<div align="center">
			<a href="#pop_model" data-toggle="modal" onclick="funcion_status();" data-remote="false" class="btn btn-sm btn-cyan mb-1" title="Change Status"
                ><span class="icon-tab"></span> CAMBIAR ESTADO</a></div>
            <?php foreach ($thread_list as $row) { ?>


                <div class="form-group row">


                    <div class="col-sm-10">
                        <div class="card card-block"><?php
                            if ($row['custo']) echo 'Customer <strong>' . $row['custo'] . '</strong> Replied<br><br>';

                            if ($row['emp']) echo 'Tecnico <strong>' . $row['emp'] . '</strong> Respondio<br><br>';

                            echo $row['message'] . '';

                            if ($row['attach']) echo '<br><br><strong>Documentacion: </strong><a href="' . base_url('userfiles/support/' . $row['attach']) . '">' . $row['attach'] . '</a><br><br>';
                            ?></div>
                    </div>
                </div>
            <?php }
            echo form_open_multipart('tickets/thread?id=' . $thread_info['id']); ?>

            <h5><?php echo $this->lang->line('Your Response') ?></h5>
            <hr>

            <div class="form-group row">

                <label class="col-sm-2 control-label"
                       for="edate"><?php echo $this->lang->line('Reply') ?></label>

                <div class="col-sm-10">
                        <textarea class="summernote"
                                  placeholder=" Message"
                                  autocomplete="false" rows="10" name="content"></textarea>
                </div>
            </div>
	   
                     <div class="form-group row">
        <label class="col-sm-2 col-form-label" for="name">Nombre del articulo</label>                        
        <div class="col-sm-10">
            <select class="form-control select-box" id="lista_productos" name="lista_productos[]" multiple="multiple">
                <?php foreach ($lista_productos_tecnico as $key => $producto) { ?>
                    <option value="<?=$producto['pid']?>"  data-qty="<?=$producto['qty']?>" data-pid="<?=$producto['pid']?>" data-product_name="<?=$producto['product_name']?>" ><?=$producto['product_name']?></option>
               <?php } ?>
            </select>
        </div>
                     </div>   
                     <table width="80%" style="text-align: center;padding-left: 17%;" class="table-responsive tfr my_stripe">
                            <thead >
                                <tr>
                                    <th style="text-align: center;" width="10%">PID</th>
                                    <th style="text-align: center;" width="30%">Nombre</th>
                                    <th style="text-align: center;" width="20%">Cantidad Tot.</th>
                                    <th style="text-align: center;" width="20%">Valor a Transferir</th>
                                </tr>
                            </thead>
                            <tbody id="itemsx">
                                <tr id="remover_fila">
                                    <td>PID</td>
                                    <td>Nombre</td>
                                    <td>##</td>
                                    <td><input type="number" name="" data-max="5" data-pid="0" class="form-control" onfocusout="validar_numeros(this);" disabled></td>   
                                </tr>
                            </tbody>
                        </table>
                        <div align="center" style="padding-left: 17%;"><input  type="button" class="btn " style="background-color: #767676;color: aliceblue;"  value="Agregar Material a la Orden" onclick="guardar_productos()"></div>
                    
            <div class="form-group row">

                <label class="col-sm-2 col-form-label" for="name">Documentacion</label>

                <div class="col-sm-6">
                    <input type="file" name="userfile" size="20"/><br>
                    <small>(docx, docs, txt, pdf, xls, png, jpg, gif)</small>
                </div>
            </div>


            <div class="form-group row">

                <label class="col-sm-2 col-form-label"></label>

                <div class="col-sm-4">
                    <input type="submit" id="document_add" class="btn btn-success margin-bottom"
                           value="<?php echo $this->lang->line('Update') ?>" data-loading-text="Updating...">
                </div>
            </div>


            </form>
        </div>
    </div>
</article>
<script type="text/javascript">
    $(function () {
        $('.summernote').summernote({
            height: 250,
            toolbar: [
                // [groupName, [list of button]]
                ['style', ['bold', 'italic', 'underline', 'clear']],
                ['font', ['strikethrough', 'superscript', 'subscript']],
                ['fontsize', ['fontsize']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['height', ['height']],
                ['fullscreen', ['fullscreen']],
                ['codeview', ['codeview']]
            ]
        });
    });
</script>

<script type="text/javascript">
    function funcion_status(){
        //aqui estoy toca terminar esto de que muestre y n el div
        var x= $('#estadoid option:selected').text();
        if(x!='Resuelto'){
            $("#fecha_final_div").css('visibility','hidden');
            $("#submit_model").removeAttr("disabled");
        }else{
            $("#fecha_final_div").css('visibility','visible');    
             $("#submit_model").prop("disabled","true");
        }
        
    }
    <?php $fec=new DateTime($thread_info['created'] );  ?>
    var fecha_ano='<?= $fec->format("Y-m-d") ?>';
    function funcion_fecha(){

            fecha_inicialjs=new Date(fecha_ano);
            var fecha_finaljs=new Date($("#fecha_final").val());
            if(fecha_finaljs<fecha_inicialjs){
                $("#fecha_final").val('');
                $("#submit_model").prop("disabled","true");
            }else{
                $("#submit_model").removeAttr("disabled");
            }
    }
</script>
<div id="pop_model" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"><?php echo $this->lang->line('Change Status'); ?></h4>
            </div>

            <div class="modal-body">
                <form id="form_model">


                    <div class="row">
                        <div class="col-xs-12 mb-1"><label
                                    for="pmethod"><?php echo $this->lang->line('Mark As') ?></label>
                            <select id="estadoid" name="status" class="form-control mb-1" onchange="funcion_status();">
                                <option value="Resuelto">Resuelto</option>
                                <option value="Realizando">Realizando</option>
                                <option value="Pendiente">Pendiente</option>
                            </select>

                        </div>
                    </div>
                    <div class="row" id="fecha_final_div">
                        <div class="col-xs-12 mb-1" ><label>Fecha Final</label>
                            <input type="date" class="form-control" id="fecha_final" onchange="funcion_fecha()" name="fecha_final">
                        </div>
                    </div>

                    <div class="modal-footer">
                        <input type="hidden" class="form-control required"
                               name="tid" id="invoiceid" value="<?php echo $thread_info['id'] ?>">
                        <button type="button" class="btn btn-default"
                                data-dismiss="modal"><?php echo $this->lang->line('Close'); ?></button>
                        <input type="hidden" id="action-url" value="tickets/update_status">
                        <button type="button" class="btn btn-primary"
                                id="submit_model"><?php echo $this->lang->line('Change Status'); ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    var id_orden_n="<?=$id_orden_n?>";

    $("#lista_productos").select2();
    let listaProductos=[];
    $("#lista_productos").on('select2:select',function(e){
                var itemSeleccionado;
                itemSeleccionado= {pid:e.params.data.element.dataset.pid,qty:e.params.data.element.dataset.qty,product_name:e.params.data.element.dataset.product_name};

                
                listaProductos.push(itemSeleccionado);
                $("#remover_fila").html('');
                var max_var=itemSeleccionado.qty;
                if(max_var<0){
                    max_var=0;
                }
                $("#itemsx").append('<tr id="fila_'+itemSeleccionado.pid+'"> <td>'+itemSeleccionado.pid+'</td><td>'+itemSeleccionado.product_name+'</td>       <td>'+itemSeleccionado.qty+'</td>           <td><input type="number" name="" data-max="'+max_var+'" data-pid="'+itemSeleccionado.pid+'" class="form-control" onfocusout="validar_numeros(this);" value="'+max_var+'"></td>     </tr>');

console.log(e);
console.log(itemSeleccionado);
                 
            });

        $("#lista_productos").on("select2:unselect",function(e){
        console.log("eliminado "+e.params.data.element.dataset.pid);
        
        $("#fila_"+e.params.data.element.dataset.pid).remove();
        var remove_index=0;
        $(listaProductos).each(function(index,value){
            if(e.params.data.element.dataset.pid==value.pid){
                remove_index=index;
            }    
            
            
        });
        listaProductos.splice(remove_index,1);
        
    });


    function guardar_productos(){
        var datos_lista=$("#lista_productos").val();
        if(datos_lista==null){
            $("#lista_productos").attr("required", true);
            $("#document_add").click();
            setTimeout(function(){
            $("#lista_productos").attr("required", false);    
            },1000);
            

        }else{

         $.post(baseurl+"tickets/add_products_orden",{lista:listaProductos,id_orden_n:id_orden_n},function(data){
                alert("Productos Agregados");
                window.location.reload();
            });   
        }
    }

    function validar_numeros (input){
        var valorInput =parseInt($(input).val());
        var valorMaximo = parseInt($(input).data('max'));
        var valor_pid=parseInt($(input).data('pid'));
        if(isNaN(valorInput)){
            $(input).val(0);
        }else if(valorInput<0){
            $(input).val(0);    
        }else if(valorInput>valorMaximo){
            $(input).val(valorMaximo);
        }
        // cambia el valor total del la listaProductos y pasar los valores al input para que se envien al submit
        valorInput =parseInt($(input).val());
        var index_cambiar=0;
        $(listaProductos).each(function(index,value){
            if(value.pid==valor_pid){
                index_cambiar=index;
            }
        });
        listaProductos[index_cambiar].qty=valorInput;
    }

    function eliminar_prod_lista(idtransferencia_products_orden){
        var confirmacion =confirm("¿Deseas realmente eliminar este item ?");
        if(confirmacion==true){
            $.post(baseurl+"tickets/eliminar_prod_lista",{id:idtransferencia_products_orden},function(data){
                alert("Producto Eliminado");
                window.location.reload();
            });
        }
    }

    
</script>