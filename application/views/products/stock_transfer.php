
<article class="content">
    <div class="card card-block">
        <div id="notify" class="alert alert-success" style="display:none;">
            <a href="#" class="close" data-dismiss="alert">&times;</a>

            <div class="message"></div>
        </div>
        <form method="post"  class="form-horizontal" onsubmit="al_enviar_form(event);">
            <div class="grid_3 grid_4">
                <h5><?php echo $this->lang->line('Stock Transfer') ?></h5>
                <hr>


                <input type="hidden" name="act" value="add_product">
              


                <div class="form-group row">

                    <label class="col-sm-2 col-form-label"
                           for="product_cat"><?php echo $this->lang->line('Transfer From') ?></label>

                    <div class="col-sm-6">
                        <select id="wfrom" name="from_warehouse" class="form-control" onchange="al_cambiar_almacen();" required>
                            <option value='0'>Select</option>
                            <?php
                            foreach ($warehouse as $row) {
                                $cid = $row['id'];
                                $title = $row['title'];
                                echo "<option value='$cid'>$title</option>";
                            }
                            ?>
                        </select>


                    </div>
                </div>
				<div class="form-group row">

                    <label class="col-sm-2 col-form-label"
                           for="product_cat"><?php echo $this->lang->line('Transfer To') ?></label>

                    <div class="col-sm-6">
                        <select name="to_warehouse" class="form-control" id="sel2" required>
                            <option value="">Seleccionar</option>
                            <?php
                            foreach ($warehouse as $row) {
                                $cid = $row['id'];
                                $title = $row['title'];
                                echo "<option value='$cid'>$title</option>";
                            }
                            ?>
                        </select>


                    </div>
                </div>
                <div class="form-group row">

                    <label class="col-sm-2 col-form-label"
                           for="pay_cat"><?php echo $this->lang->line('Products') ?></label>
                           

                    <div class="col-sm-8">
                        <select id="products_l" name="products_l[]" class="form-control required select-box" required multiple="multiple">

                       </select>                  
                      
                    </div><br>
                   
            </div>
				
            
                    <div id="saman-row">
                        <table width="100%" style="text-align: center;" class="table">
                            <thead >
                                <tr >
                                    <th style="text-align: center;">PID</th>
                                    <th style="text-align: center;">Nombre</th>
                                    <th style="text-align: center;">Cantidad Tot.</th>
                                    <th style="text-align: center;">Valor a Transferir</th>
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
                    </div>
                </div>
                <br>
                
				

                <div class="form-group row">

                    <label class="col-sm-2 col-form-label"></label>

                    <div class="col-sm-4">
                        <input type="submit" class="btn btn-success margin-bottom"
                               value="<?php echo $this->lang->line('Stock Transfer') ?>" data-loading-text="Adding...">
                        <input type="text" hidden id="prods_change" name="prods_change">
                    </div>
                </div>
            </div>

        </form>
    </div>
</article>

<script type="text/javascript">
    var dataglobal;
    var listaProductos=[];
    $("#products_l").select2();

    $("#wfrom").on('change', function(){
    var tips=$('#wfrom').val();
    //este es el escucha cuando se cambia el select
    listaProductos=[];
     $.post(baseurl + 'products/stock_transfer_products?wid='+tips,{},function(data){
            
            $("#products_l").val("");
            $("#products_l").trigger("change");
            var options="";
            $(data).each(function(index,data2){
                options+="<option value='"+data2.pid+"'>"+data2.product_name+"</option>";
            });
            dataglobal=data;
            $("#products_l").html(options);
            $("#products_l").trigger("change");
        },'json');

});

    $("#products_l").on("select2:unselect",function(e){
        console.log("eliminado "+e.params.data.id);
        console.log(listaProductos);
        $("#fila_"+e.params.data.id).remove();
        var remove_index=0;
        $(listaProductos).each(function(index,value){
            if(e.params.data.id==value.pid){
                remove_index=index;
            }    
            
            
        });
        listaProductos.splice(remove_index,1);
        
    });
    $("#products_l").on('select2:select',function(e){
                var itemSeleccionado;
                $(dataglobal).each(function(index,data){
                    if(e.params.data.id==data.pid){
                        itemSeleccionado=data;
                    }
                    
                });
                
               
                listaProductos.push(itemSeleccionado);
                $("#remover_fila").html('');
                var max_var=itemSeleccionado.qty;
                if(max_var<0){
                    max_var=0;
                }
                $("#itemsx").append('<tr id="fila_'+itemSeleccionado.pid+'"> <td>'+itemSeleccionado.pid+'</td><td>'+itemSeleccionado.product_name+'</td>       <td>'+itemSeleccionado.qty+'</td>           <td><input type="number" name="" data-max="'+max_var+'" data-pid="'+itemSeleccionado.pid+'" class="form-control" onfocusout="validar_numeros(this);" value="'+max_var+'"></td>     </tr>');

                 
            });
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
    var option_hid=null;
    function al_cambiar_almacen(){
        $("#products_l").val("");
        $("#products_l").trigger("change");
        $("#itemsx").html('<tr id="remover_fila"><td>PID</td><td>Nombre</td><td>##</td><td><input type="number" data-max="5" data-pid="0" class="form-control" onfocusout="validar_numeros(this);" disabled></td>   </tr>');
        
        $("#sel2").val("").change();

        if(option_hid!=null){
            $('#sel2 option[value="'+option_hid+'"]').removeAttr("hidden");
        }
        $('#sel2 option[value="'+$("#wfrom").val()+'"]').attr("hidden","true");
        option_hid=$("#wfrom").val();
    }
    function al_enviar_form(event){
        event.preventDefault();
        $.post(baseurl+'products/stock_transfer',{lista:listaProductos,from_warehouse:$("#wfrom").val(),to_warehouse:$("#sel2").val()},function(data){
                if(data.status=="success"){
                    
                    alert("Productos Transferidos a PID = "+data.transferido_a);
                    window.location.reload();   
                }else{
                    alert("A ocurrido un error");
                }
        },'json');
           
    }
    
</script>

