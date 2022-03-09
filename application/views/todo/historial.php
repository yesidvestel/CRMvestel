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
                                                            if ($row['comentario']) echo '</p><p><strong>[Sub Tarea]</strong> ' . $row['comentario']; ?></p>

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


                                </div>
                    </div>

                </div>

        </div>
            <p><strong>[Descripcion de la Tarea]</strong><?=$tarea->description  ?></p>
    </div>
</article>

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
        


     });
    
</script>
