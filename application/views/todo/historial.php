<?php $lista_productos_orden=$this->db->get_where('transferencia_products_orden',array('id_tarea'=>$id_tarea))->result_array(); ?>
<article class="content">
    <div class="card card-block">
        <div class="card">
            
                    <div class="card-body">

                        <div class="card-block">
                             <div id="notify" class="alert alert-success" style="display:none" >
                                <a href="#" class="close" data-dismiss="alert">&times;</a>
                                            
                                  <div class="message"></div>
                            </div>
                            <h3 align="center"><strong><?=$tarea->name ?></strong></h3>
                            <p></p>
                            <ul class="nav nav-tabs nav-justified">
                                

                                <li class="nav-item">
                                    <a class="nav-link active" id="milestones-tab" data-toggle="tab" href="#milestones"
                                       aria-controls="active" aria-expanded="true"><?php echo $this->lang->line('Activities') ?></a>
                                </li>
                                
                                <li class="nav-item">
                                    <a class="nav-link" id="linkOpt-tab" data-toggle="tab" href="#files"
                                       aria-controls="files"><?php echo $this->lang->line('Files') ?></a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="linkmaterial-tab" data-toggle="tab" href="#material"
                                       aria-controls="material">Material </a>
                                </li>
                                
                            </ul>
                            <div class="tab-content px-1 pt-1">
                                <div class="tab-pane fade active in" id="milestones" role="tabpanel"
                                         aria-labelledby="milestones-tab" aria-expanded="true"><p><a id="add_historia" href="" class="btn btn-primary btn-sm rounded">
                                                Añadir
                                            </a></p>
                                         <ul class="timeline">
                                        <?php $flag = true;
                                        $total = count($historial);

                                        foreach ($historial as $row) {


                                            ?>
                                            <li data-block="sec" class="<?php if (!$flag) {
                                                echo 'timeline-inverted';
                                            } ?>">
                                                <div class="timeline-badge"
                                                     style="background-color: <?php echo $row['color'] ?>;"><?php echo $total ?></div>
                                                <div class="timeline-panel">
                                                    <div class="timeline-heading">
                                                        <h4 class="timeline-title"><?php echo $row['titulo'] ?></h4>
                                                        <p>
                                                            <small class="text-muted"><i
                                                                        class="glyphicon glyphicon-time"></i> <?php echo $row['fecha'] . ' ~ ' . $row['fecha'] . '</small><a href="" class=" float-xs-right borrar_item" data-did="2" data-object-id="' . $row['id_historial_tareas'] . '"><i class="danger icon-trash-o"></i></a>'; ?>
                                                        </p>
                                                    </div>
                                                    <div class="timeline-body">
                                                        <p><?php //echo $row['comentario'];
                                                            if ($row['comentario']){ echo '</p><p><strong>[Sub Tarea]</strong> ' . $row['comentario']; }?></p>
                                                               <p>  
                                                                    <?php 
                                                                    $p_files2=$this->manager->p_files_historial_tareas($row['id_historial_tareas']);
                                                                    foreach ($p_files2 as $row2) {//inicio archivos en subtareas ?>


                                                                        <section class="form-group row">


                                                                            <div data-block="sec" class="col-sm-12">
                                                                                <div class="card card-block"><?php


                                                                                    echo '<a href="' . base_url('userfiles/historias_tareas/' . $row2['nombre']) . '">' . $row2['nombre'] . '</a><a href="#" class="btn btn-danger float-xs-right delete-custom" data-did="1" data-object-id="' . $row2['id'] . '"><i class="icon-trash-b"></i></a> ';

                                                                                    echo '<br><br>';
                                                                                    ?></div>
                                                                            </div>
                                                                        </section>
                                                                    <?php } ?>
                                                                </p>
                                                                          <span class="btn btn-success fileinput-button">
                                                                                <i class="glyphicon glyphicon-plus"></i>
                                                                                
                                                                                                                <!-- The file input field used as target for the file upload widget -->
                                                                                <input id="fileupload<?=$row['id_historial_tareas']?>" type="file" name="files[]" multiple>
                                                                            </span>
                                                                <br>
                                                                <br>
                                                                <!-- The global progress bar -->
                                                                <div id="progress<?=$row['id_historial_tareas']?>" class="progress">
                                                                    <div class="progress-bar progress-bar-success"></div>
                                                                </div>
                                                                <!-- The container for the uploaded files -->
                                                                <div id="files<?=$row['id_historial_tareas']?>" class="files"></div>
                                                                <br><!-- final archivos en subtareas -->
                                                    </div>
                                                </div>
                                            </li>
                                            <?php $flag = !$flag;
                                            $total--;
                                        } ?>


                                    </ul>
                                        
                                    </div>

                                     <div class="tab-pane fade" id="files" role="tabpanel" aria-labelledby="files-tab"
                                     aria-expanded="false">
                                    <p>
                                        <?php foreach ($p_files as $row) { ?>


                                            <section class="form-group row">


                                                <div data-block="sec" class="col-sm-12">
                                                    <div class="card card-block"><?php


                                                        echo '<a href="' . base_url('userfiles/historias_tareas/' . $row['nombre']) . '">' . $row['nombre'] . '</a><a href="#" class="btn btn-danger float-xs-right delete-custom" data-did="1" data-object-id="' . $row['id'] . '"><i class="icon-trash-b"></i></a> ';

                                                        echo '<br><br>';
                                                        ?></div>
                                                </div>
                                            </section>
                                        <?php } ?>
                                    </p>
                                              <span class="btn btn-success fileinput-button">
                                                    <i class="glyphicon glyphicon-plus"></i>
                                                    <span>...</span>
                                                                                    <!-- The file input field used as target for the file upload widget -->
                                                    <input id="fileupload" type="file" name="files[]" multiple>
                                                </span>
                                    <br>
                                    <br>
                                    <!-- The global progress bar -->
                                    <div id="progress" class="progress">
                                        <div class="progress-bar progress-bar-success"></div>
                                    </div>
                                    <!-- The container for the uploaded files -->
                                    <div id="files" class="files"></div>
                                    <br>
                                </div><!-- aqui termina lo de los archivos -->

                                <div class="tab-pane fade" id="material" role="tabpanel" aria-labelledby="files-tab"
                                     aria-expanded="false">
                                    
                                        <p><a href="#pop_model3" data-toggle="modal"  data-remote="false" class="btn btn-success sub-btn" title="Change Status">ASIGNAR MATERIAL</a></p>

                                    <div class="table-responsive">
                                        <table  class="table-responsive tfr my_stripe" width="100%">
                                        <thead>
                                            <tr>
                                                <th colspan="3" ><h5 align="left"><strong>Material usado en la red</strong></h5></th>
                                            </tr>
                                            <tr>
                                                <th style="text-align: center;" width="10%">PID</th>
                                                <th style="text-align: center;" width="40%">Nombre</th>
                                                <th style="text-align: center;" width="30%">Cantidad Tot.</th>
                                                <th style="text-align: center;" width="20%">Valor a Transferir</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            <?php foreach ($lista_productos_orden as $key => $prod) { $prod_padre=$this->db->get_where('products',array('pid'=>$prod['products_pid']))->row(); ?>        
                                                <tr>
                                                    <td style="text-align: center;" width="10%"><?=$prod_padre->pid?></td>
                                                    <td style="text-align: center;" width="30%"><?=$prod_padre->product_name?></td>
                                                    <td style="text-align: center;" width="20%"><?=$prod['cantidad']?></td>
                                                    <td style="text-align: center;" width="20%"><a onclick="eliminar_prod_lista(<?=$prod['idtransferencia_products_orden']?>)"><img src="<?=base_url()?>/assets/img/trash.png"></a></td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                    </div>

                                </div><!-- aqui termina lo de los materiales -->

                                </div>
                    </div>

                </div>

        </div>
            <p><strong>[Descripcion de la Tarea]</strong><?php $x1a=explode('<img src="data', $tarea->description);echo $x1a[0];  ?></p>
    </div>
</article>
<div id="pop_model3" class="modal fade">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                <h4 class="modal-title">Asignar Material</h4>
                            </div>
                            <div class="modal-body">
                                <form id="form_model3">

                            <div class="form-group row">

                        <div class="col-sm-10">
                            <label class="col-sm-4 col-form-label" for="name">Nombre del articulo</label> 
                            <select class="form-control select-box" id="lista_productos" name="lista_productos[]" multiple="multiple" style="width: 100%;">
                                <?php foreach ($lista_productos_tecnico as $key => $producto) { ?>
                                    <option value="<?=$producto['pid']?>"  data-qty="<?=$producto['qty']?>" data-pid="<?=$producto['pid']?>" data-product_name="<?=$producto['product_name']?>" ><?=$producto['product_name']?></option>
                               <?php } ?>
                            </select>
                        </div>
                                     </div>   
                                     <table width="80%" style="text-align: center;" class="table-responsive tfr my_stripe">
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
                                        <br>
                                        <input  type="button" class="btn btn-primary" value="Agregar" onclick="guardar_productos()">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Volver</button>

                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
</div>                
<div id="pop_model" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Agregar</h4>
            </div>

            <div class="modal-body">
                <form id="form_model">


                    <div class="row">
                        <div class="col-xs-12 mb-1"><label
                                    for="status">Titulo</label>
                            <input type="text" name="titulo" class="form-control mb-1">

                        </div>
                    </div>
                    <div class="form-group row">

                    <label class="col-sm-10 control-label"
                           for="content"><?php echo $this->lang->line('Description') ?></label>

                        <div class="col-sm-10" style="width: 100%;">
                            <textarea class="summernote"
                                      placeholder=" Note"
                                      autocomplete="false" rows="10" name="content"></textarea>
                        </div>
                    </div>
                     

                    <div class="modal-footer">
                        <input type="hidden" name="id_tarea" value="<?= $_GET['id'] ?>">
                        <button type="button" class="btn btn-default"
                                data-dismiss="modal"><?php echo $this->lang->line('Close'); ?></button>
                       
                        <button type="button" class="btn btn-primary"
                                id="enviar">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div id="pop_model_borrar" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Borrar</h4>
            </div>

            <div class="modal-body">
                <form id="form_model2">


                    
                     

                    <div class="modal-footer">
                        
                        <button type="button" class="btn btn-default"
                                data-dismiss="modal"><?php echo $this->lang->line('Close'); ?></button>
                       
                        <button type="button" class="btn btn-primary"
                                id="borrar_historia">Borrar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
    <script src="<?php echo base_url('assets/vendors/js/upload/jquery.iframe-transport.js') ?>"></script>
    <script src="<?php echo base_url('assets/vendors/js/upload/jquery.ui.widget.js') ?>"></script>
    <script src="<?php echo base_url('assets/vendors/js/upload/load-image.all.min.js') ?>"></script>
    <script src="<?php echo base_url('assets/vendors/js/upload/canvas-to-blob.min.js') ?>"></script>
<script src="<?php echo base_url('assets/vendors/js/upload/jquery.fileupload.js') ?>"></script>
    <!-- The File Upload processing plugin -->
    <script src="<?php echo base_url('assets/vendors/js/upload/jquery.fileupload-process.js') ?>"></script>
    <!-- The File Upload image preview & resize plugin -->
    <script src="<?php echo base_url('assets/vendors/js/upload/jquery.fileupload-image.js') ?>"></script>
    <!-- The File Upload audio preview plugin -->
    <script src="<?php echo base_url('assets/vendors/js/upload/jquery.fileupload-audio.js') ?>"></script>
    <!-- The File Upload video preview plugin -->
    <script src="<?php echo base_url('assets/vendors/js/upload/jquery.fileupload-video.js') ?>"></script>
    <!-- The File Upload validation plugin -->
    <script src="<?php echo base_url('assets/vendors/js/upload/jquery.fileupload-validate.js') ?>"></script>

<script type="text/javascript">
    var id_tarea="<?= $_GET['id'] ?>";
    var id_historia_tarea=0;
    function eliminar_prod_lista(idtransferencia_products_orden){
        var confirmacion =confirm("¿Deseas realmente eliminar este item ?");
        if(confirmacion==true){
            $.post(baseurl+"tickets/eliminar_prod_lista",{id:idtransferencia_products_orden},function(data){
                alert("Producto Eliminado");
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
    var id_orden_n="<?=$id_tarea?>";
    function guardar_productos(){
        var datos_lista=$("#lista_productos").val();
        if(datos_lista==null){
            $("#lista_productos").attr("required", true);
            $("#document_add").click();
            setTimeout(function(){
            $("#lista_productos").attr("required", false);    
            },1000);
        }else{
         $.post(baseurl+"manager/add_products_tarea",{lista:listaProductos,id_orden_n:id_orden_n},function(data){
                alert("Productos Agregados");
                window.location.reload();
            });   
        }
    }
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
    $("#add_historia").click(function(e){
        e.preventDefault();

        $("#pop_model").modal("show");
    });
    $("#enviar").click(function(e){
        var o_data=$("#form_model").serialize();
        $.post(baseurl+"manager/guardar_historia_tarea",o_data,function(data){
            
            $("#form_model").val();
            $("#pop_model").modal("hide");
            location.reload();
        });
    });
    $("#borrar_historia").click(function(){
        $.post(baseurl+"manager/borrar_historia_tarea",{id:id_historia_tarea},function(data){
           location.reload(); 
        });
    });
     $(function () {
        
        $(".borrar_item").click(function(ev){
            ev.preventDefault();            
            id_historia_tarea=$(this).data("object-id");
            $("#pop_model_borrar").modal("show");
        });
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


 var url = baseurl + 'manager/file_handling?id=<?php echo $_GET['id']; ?>',
                uploadButton = $('<button/>')
                    .addClass('btn btn-primary')
                    .prop('disabled', true)
                    .text('Processing...')
                    .on('click', function () {
                        var $this = $(this),
                            data = $this.data();
                        $this
                            .off('click')
                            .text('Abort')
                            .on('click', function () {
                                $this.remove();
                                data.abort();
                            });
                        data.submit().always(function () {
                            $this.remove();
                        });
                    });

                    $('#fileupload').fileupload({
                url: url,
                dataType: 'json',
                autoUpload: false,
                acceptFileTypes: /(\.|\/)(gif|jpe?g|png|docx|docs|txt|pdf|xls)$/i,
                maxFileSize: 999000,
                // Enable image resizing, except for Android and Opera,
                // which actually support image resizing, but fail to
                // send Blob objects via XHR requests:
                disableImageResize: /Android(?!.*Chrome)|Opera/
                    .test(window.navigator.userAgent),
                previewMaxWidth: 100,
                previewMaxHeight: 100,
                previewCrop: true
            }).on('fileuploadadd', function (e, data) {
                data.context = $('<div/>').appendTo('#files');
                $.each(data.files, function (index, file) {
                    var node = $('<p/>')
                        .append($('<span/>').text(file.name));
                    if (!index) {
                        node
                            .append('<br>')
                            .append(uploadButton.clone(true).data(data));
                    }
                    node.appendTo(data.context);
                });
            }).on('fileuploadprocessalways', function (e, data) {
                var index = data.index,
                    file = data.files[index],
                    node = $(data.context.children()[index]);
                if (file.preview) {
                    node
                        .prepend('<br>')
                        .prepend(file.preview);
                }
                if (file.error) {
                    node
                        .append('<br>')
                        .append($('<span class="text-danger"/>').text(file.error));
                }
                if (index + 1 === data.files.length) {
                    data.context.find('button')
                        .text('Upload')
                        .prop('disabled', !!data.files.error);
                }
            }).on('fileuploadprogressall', function (e, data) {
                var progress = parseInt(data.loaded / data.total * 100, 10);
                $('#progress .progress-bar').css(
                    'width',
                    progress + '%'
                );
            }).on('fileuploaddone', function (e, data) {
                $.each(data.result.files, function (index, file) {
                    if (file.url) {
                        var link = $('<a>')
                            .attr('target', '_blank')
                            .prop('href', file.url);
                        $(data.context.children()[index])
                            .wrap(link);
                    } else if (file.error) {
                        var error = $('<span class="text-danger"/>').text(file.error);
                        $(data.context.children()[index])
                            .append('<br>')
                            .append(error);
                    }
                });
            }).on('fileuploadfail', function (e, data) {
                $.each(data.files, function (index) {
                    var error = $('<span class="text-danger"/>').text('File upload failed.');
                    $(data.context.children()[index])
                        .append('<br>')
                        .append(error);
                });
            }).prop('disabled', !$.support.fileInput)
                .parent().addClass($.support.fileInput ? undefined : 'disabled');
        
<?php foreach ($historial as $row) { ?>
var url = baseurl + 'manager/file_handling?id=<?php echo $_GET['id']."&historia_id=".$row['id_historial_tareas']; ?>',
                uploadButton = $('<button/>')
                    .addClass('btn btn-primary')
                    .prop('disabled', true)
                    .text('Processing...')
                    .on('click', function () {
                        var $this = $(this),
                            data = $this.data();
                        $this
                            .off('click')
                            .text('Abort')
                            .on('click', function () {
                                $this.remove();
                                data.abort();
                            });
                        data.submit().always(function () {
                            $this.remove();
                        });
                    });

                    $('#fileupload<?=$row['id_historial_tareas']?>').fileupload({
                url: url,
                dataType: 'json',
                autoUpload: false,
                acceptFileTypes: /(\.|\/)(gif|jpe?g|png|docx|docs|txt|pdf|xls)$/i,
                maxFileSize: 999000,
                // Enable image resizing, except for Android and Opera,
                // which actually support image resizing, but fail to
                // send Blob objects via XHR requests:
                disableImageResize: /Android(?!.*Chrome)|Opera/
                    .test(window.navigator.userAgent),
                previewMaxWidth: 100,
                previewMaxHeight: 100,
                previewCrop: true
            }).on('fileuploadadd', function (e, data) {
                data.context = $('<div/>').appendTo('#files<?=$row['id_historial_tareas']?>');
                
                $.each(data.files, function (index, file) {
                    var node = $('<p/>')
                        .append($('<span/>').text(file.name));
                    if (!index) {
                        node
                            .append('<br>')
                            .append(uploadButton.clone(true).data(data));
                    }
                    node.appendTo(data.context);
                });
            }).on('fileuploadprocessalways', function (e, data) {

                var index = data.index,
                    file = data.files[index],
                    node = $(data.context.children()[index]);
                if (file.preview) {
                    node
                        .prepend('<br>')
                        .prepend(file.preview);
                }
                if (file.error) {
                    node
                        .append('<br>')
                        .append($('<span class="text-danger"/>').text(file.error));
                }
                if (index + 1 === data.files.length) {
                    data.context.find('button')
                        .text('Upload')
                        .prop('disabled', !!data.files.error);
                }
            }).on('fileuploadprogressall', function (e, data) {
                var progress = parseInt(data.loaded / data.total * 100, 10);
                $('#progress1 .progress-bar').css(
                    'width',
                    progress + '%'
                );
            }).on('fileuploaddone', function (e, data) {
                $.each(data.result.files, function (index, file) {
                    if (file.url) {
                        var link = $('<a>')
                            .attr('target', '_blank')
                            .prop('href', file.url);
                        $(data.context.children()[index])
                            .wrap(link);
                    } else if (file.error) {
                        var error = $('<span class="text-danger"/>').text(file.error);
                        $(data.context.children()[index])
                            .append('<br>')
                            .append(error);
                    }
                });
            }).on('fileuploadfail', function (e, data) {
                $.each(data.files, function (index) {
                    var error = $('<span class="text-danger"/>').text('File upload failed.');
                    $(data.context.children()[index])
                        .append('<br>')
                        .append(error);
                });
            }).prop('disabled', !$.support.fileInput)
                .parent().addClass($.support.fileInput ? undefined : 'disabled');
<?php } ?>
     });
    
</script>
