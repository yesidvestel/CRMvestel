<article class="content">
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
            <p class="card card-block"><?php echo '<strong>Creado el: </strong> ' . $thread_info['created'];
                echo '<br><strong>Usuario:</strong> ' . $thread_info['name'] .' '. $thread_info['unoapellido'];
				echo '<br><strong>Celular:</strong> ' . $thread_info['celular'];
				echo '<br><strong>Direccion:</strong> ' . $thread_info['nomenclatura'].' '. $thread_info['numero1']. $thread_info['adicionauno'].' N°'. $thread_info['numero2']. $thread_info['adicional2'].' - '. $thread_info['numero3'];
				echo '<br><strong>Barrio:</strong> ' . $thread_info['barrio'];
                echo '<br><strong>Estado:</strong> <span id="pstatus">' . $thread_info['status']
                ?></span></p>
			<a href="#pop_model" data-toggle="modal" onclick="funcion_status();" data-remote="false" class="btn btn-sm btn-cyan mb-1" title="Change Status"
                ><span class="icon-tab"></span> CAMBIAR ESTADO</a>
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
	<table class="table-responsive tfr my_stripe" style="padding-left: 17%">

<thead>
                            <tr class="item_header">
                                <th width="25%" class="text-center"><?php echo $this->lang->line('Item Name') ?></th>
                                <th width="8%" class="text-center"><?php echo $this->lang->line('Quantity') ?></th>
								<th width="5%" class="text-center"><?php echo $this->lang->line('Action') ?></th>
                                
                            </tr>

</thead>  <tbody>
                            <tr>
                                <td><input type="text" class="form-control text-center" name="product_name[]"
                                           placeholder="<?php echo $this->lang->line('Enter Product name') ?>" id='productname-0'>
                                </td>
                                <td><input type="text" class="form-control req amnt" name="product_qty[]" id="amount-0"
                                           onkeypress="return isNumber(event)" onkeyup="rowTotal('0'), billUpyog()"
                                           autocomplete="off" value="<?php date('d') ?>"></td>
								
                                
                            </tr>
                           

                            <tr class="last-item-row sub_c">
                                <td class="add-row">
                                    <button type="button" class="btn btn-success" aria-label="Left Align"
                                            data-toggle="tooltip"
                                            data-placement="top" title="Add product row" id="addproduct">
                                        <i class="icon-plus-square"></i> <?php echo $this->lang->line('Add Row') ?>
                                    </button>
                                </td>
                                <td colspan="7"></td>
								
                            </tr>

                            </tbody>
                        </table>
                     <div class="form-group row">
        <label class="col-sm-2 col-form-label" for="name">Nombre del articulo</label>                        
        <div class="col-sm-10">
            <select class="form-control select-box" id="lista_productos" name="lista_productos[]" multiple="multiple">
                <?php foreach ($lista_productos_tecnico as $key => $producto) { ?>
                    <option value="<?=$producto['pid']?>"><?=$producto['product_name']?></option>
               <?php } ?>
            </select>
        </div>
                     </div>   
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
    $("#lista_productos").select2();
</script>