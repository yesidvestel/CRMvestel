<article class="content">
    <div class="card card-block">
        <div class="card">
            
                    <div class="card-body">

                        <div class="card-block">
                             <div id="notify" class="alert alert-success" style="display:none" >
                                <a href="#" class="close" data-dismiss="alert">&times;</a>
                                            asdasdasd
                                  <div class="message"></div>
                            </div>
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

                                     <div class="tab-pane fade" id="files" role="tabpanel"
                                         aria-labelledby="files-tab" aria-expanded="false"><p><a href="" class="btn btn-primary btn-sm rounded">
                                                Añadir
                                            </a></p>
                                        files
                                        
                                    </div>

                                </div>
                    </div>
                </div>
        </div>

    </div>
</article>

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
                                id="enviar"><?php echo $this->lang->line('Change Status'); ?></button>
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
     });
    
</script>
