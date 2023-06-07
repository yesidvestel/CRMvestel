<!-- BEGIN VENDOR JS-->
<style type="text/css">
    
    .class_resuelta{
        color: green;
    }
</style>
<script type="text/javascript">

    $('[data-toggle="datepicker"]').datepicker({autoHide: true, format: '<?php echo $this->config->item('dformat2'); ?>'});
    $('[data-toggle="datepicker"]').datepicker('setDate', new Date());
    $('#sdate').datepicker({autoHide: true, format: '<?php echo $this->config->item('dformat2'); ?>'});
    $('#sdate').datepicker('setDate', '<?php echo dateformat(date('Y-m-d', strtotime('-30 days', strtotime(date('Y-m-d'))))); ?>');

    $('#sdate2').datepicker({autoHide: true, format: '<?php echo $this->config->item('dformat2'); ?>'});
    $('#sdate2').datepicker('setDate', '<?php echo dateformat(date('Y-m-d')); ?>');

    $('#sdate3').datepicker({autoHide: true, format: '<?php echo $this->config->item('dformat2'); ?>'});
    $('#sdate3').datepicker('setDate', '<?php echo dateformat(date('Y-m-d', strtotime('-30 days', strtotime(date('Y-m-d'))))); ?>');

    $('.date30').datepicker('setDate', '<?php echo dateformat(date('Y-m-d', strtotime('-30 days', strtotime(date('Y-m-d'))))); ?>');

    if(typeof editar_datepickerts === 'function') {
        //ejecucion de funcion para cambiar fechas como sdate3 o como se le coloque pues se esta ejecutando al momento oportuno para hacer la edicion que se desee; solo es crear esta funcion en donde se quiera manejar fechas y listo mirar el ejemplo de views/support/tickets.php
        editar_datepickerts('<?php echo $this->config->item('dformat2'); ?>','<?php echo dateformat(date('Y-m-d', strtotime('-30 days', strtotime(date('Y-m-d'))))); ?>');    
    }
    
</script>
<script src="<?php echo base_url(); ?>assets/myjs/jquery-ui.js"></script>
<script src="<?php echo base_url(); ?>assets/vendors/js/ui/perfect-scrollbar.jquery.min.js"
        type="text/javascript"></script>
<script src="<?php echo
base_url(); ?>assets/vendors/js/ui/unison.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/vendors/js/ui/blockUI.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/vendors/js/ui/jquery.matchHeight-min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/vendors/js/ui/screenfull.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/vendors/js/extensions/pace.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/myjs/jquery.dataTables.min.js"></script>
<!-- DATATABLE JS-->
<script type="text/javascript" src="<?php echo base_url(); ?>assets/DataTables/JSZip-2.5.0/jszip.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/DataTables/pdfmake-0.1.36/pdfmake.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/DataTables/pdfmake-0.1.36/vfs_fonts.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/DataTables/DataTables-1.12.1/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/DataTables/Buttons-2.2.3/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/DataTables/Buttons-2.2.3/js/buttons.html5.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/DataTables/Buttons-2.2.3/js/buttons.print.min.js"></script>
<!--END DATATABLE JS-->

<script type="text/javascript">var dtformat = $('#hdata').attr('data-df');
    var currency = $('#hdata').attr('data-curr');
    ;</script>
<script src="<?php echo base_url('assets/myjs/custom.js?'.time()) . APPVER; ?>"></script>
<script src="<?php echo base_url('assets/myjs/basic.js') . APPVER; ?>"></script>
<script src="<?php echo base_url('assets/myjs/control.js?'.time()) . APPVER; ?>"></script>

<script src="<?php echo base_url('assets/js/core/app.js') . APPVER; ?>" type="text/javascript"></script>

<script src="<?php echo base_url(); ?>assets/js/core/app-menu.js" type="text/javascript"></script>
<script type="text/javascript">
    $.ajax({

        url: baseurl + 'manager/pendingtasks',
        dataType: 'json',
        success: function (data) {
            $('#tasklist').html(data.tasks);
            $('#taskcount').html(data.tcount);

        },
        error: function (data) {
            $('#response').html('Error')
        }

    });


    var winh = document.body.scrollHeight;
    var sideh = document.getElementById('side').scrollHeight;
    var opx = winh - sideh;
    document.getElementById('rough').style.height = opx + "px";
    $('body').on('click', '.menu-toggle', function () {


        var opx2 = winh - sideh + 180;
        document.getElementById('rough').style.height = opx2 + "px";
    });
    
    if($("head link").length==0){
        $("head").html('<link rel="shortcut icon" type="image/x-icon" href="'+baseurl+'assets/images/ico/favicon.png">');
    }
    
</script>
<div id="notificaciones_modal" class="modal fade">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                
                <h3 class="modal-title" align="center">Notificaciones SAVES</h3>

            </div>
            <div class="modal-body">
                <h6 align="center">Tareas resueltas </h6>
                <div id="Lista Notificaciones">
                    <ol id="lista_de_notificaciones">
                    <?php
                        $id_user1=$this->aauth->get_user()->id;
                        $lista_notificaciones=$this->db->query("select * from notificaciones_tarea inner join todolist on notificaciones_tarea.id_tarea=todolist.id where id_notificar=".$id_user1." order by fecha desc")->result_array();
                        $hay_emitidas=false;                        
                        foreach ($lista_notificaciones as $key => $value) {
                            if($hay_emitidas==false && $value['estado']=="emitida"){
                                $hay_emitidas=true;
                            }
                            $name = '<a href="'.base_url().'manager/historial?id='.$value['id_tarea'].'" data-id="' . $value['id_tarea'] . '" class="view_task2">' . $value['name'] . '</a>';
                            $btn1 = '&nbsp<a href="'.base_url().'manager/historial?id='.$value['id_tarea'].'" data-id="' . $value['id_tarea'] . '" class="view_task2 btn-sm btn-indigo"><i class="icon-eye"></i>Historial</a>';
                            echo "<li>Tarea #".$value['id_tarea']." <i class='class_resuelta'><b>resuelta</b></i>, ".$name.$btn1;//&nbsp<a href="#" data-id="' . $value['id_tarea'] . '" class="view_task2 btn-sm btn-indigo"> <i class="icon-eye"></i> </a>
                            echo "<br><b class='fecha_hora_small'>".$value['fecha']."</b>"."</li><hr>";
                        }

                     ?>
                     </ol>
                     
                     
                </div>
                
            </div>
            <div class="modal-footer">
                
                <button type="button" class="btn btn-danger" onclick="borrar_notificaciones()">Borrar Notificaciones</button>
                <button type="button" class="btn btn-primary" onclick="pasar_a_vistas()">Aceptar</button>
                
            </div>
        </div>
    </div>
</div>
<div id="task_model2" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="task_title2"><?php echo $this->lang->line('Details'); ?></h4>
            </div>

            <div class="modal-body">
                <form id="form_model">


                    <div class="row">
                        <div class="col-xs-12 mb-1" id="description2">

                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-xs-12 mb-1"><?php echo $this->lang->line('Priority') ?> <strong><span
                                        id="priority2"></span></strong>

                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 mb-1"><?php echo $this->lang->line('Assigned to') ?> <strong><span
                                        id="employee2"></span></strong>

                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 mb-1"><?php echo $this->lang->line('Assigned to') ?> <span id="idorden2"></span>

                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 mb-1"><?php echo $this->lang->line('Assigned by') ?> <strong><span
                                        id="assign2"></span></strong>

                        </div>
                    </div>
                    <div class="col-md-4" style="margin-top: 5px;">
                                    
                                    <a id="link_id_encuesta2" href="<?php echo base_url('encuesta/create?id=') ?>"
                                       class="btn btn-primary btn-lg" style="border-right-width: 22px;border-left-width: 22px;"><i
                                                class="icon-file-text2"></i> Encuesta</a>

                                </div>
                    <div class="modal-footer">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th><?php echo $this->lang->line('Files') ?></th>
                        </tr>
                        </thead>
                        <tbody id="activity2">
                        </tbody>
                    </table>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" class="form-control"
                               name="tid" id="taskid5" value="">
                        <button type="button" class="btn btn-default"
                                data-dismiss="modal"><?php echo $this->lang->line('Close'); ?></button>

                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    
    <?= ($hay_emitidas) ? '$("#notificaciones_modal").modal("show");':'' ?>
    
    proceso_notificaciones();
    function pasar_a_vistas(){
        $.post(baseurl+"tools/vistas_notificaciones",{},function (data){
               $("#notificaciones_modal").modal("hide");
        });
    }
    function borrar_notificaciones(){
    $.post(baseurl+"tools/borrar_notifiaciones",{},function (data){
               $("#notificaciones_modal").modal("hide");
        });
    }
    function proceso_notificaciones(){
        
        setTimeout(function(){
            //aqui hago la consulta y tambien se debe de hacer al 
            
            $.post(baseurl+"tools/obtener_notificaciones",{},function(data){
                    if(data.hay_emitidas==true){
                        console.log(data.hay_emitidas);
                        $("#lista_de_notificaciones").html(data.str_retorno);
                        
                        if($("#notificaciones_modal").css("display")=="none"){
                                $("#notificaciones_modal").modal("show");
                        }
                    }
                    
            },'json');
            proceso_notificaciones();
        },60000);
    }
    
    $(document).on('click','#show_notify_1',function(e){
        e.preventDefault();
        $("#notificaciones_modal").modal("show");   
    });
   /* $(document).on('click', ".view_task2", function (e) {
            e.preventDefault();

            var actionurl = 'manager/view_task';
            var id = $(this).attr('data-id');
            $('#task_model2').modal({backdrop: 'static', keyboard: false});


            $.ajax({

                url: baseurl + actionurl,
                type: 'POST',
                data: {'tid': id},
                dataType: 'json',
                success: function (data) {
                    $('#idorden2').html(data.idorden);
                    $('#description2').html(data.description);                   
                    $('#task_title2').html(data.name);
                    $('#employee2').html(data.employee);
                    $('#assign2').html(data.assign);
                    $('#priority2').html(data.priority);
                    $("#link_id_encuesta2").attr("href",baseurl+"encuesta/create?id="+data.idorden);
                    var x =data.archivo;
                    var objetos="";
                    $(x).each(function(ind,dat){
                        objetos+="<tr><td><a data-url='"+baseurl+"tools/file_handling?op=delete&name="+ dat.col1+"&type="+dat.type+"&invoice="+ dat.id +"' class='aj_delete'><i class='btn-danger btn-lg icon-trash-a'></i></a> <a class='n_item' href='"+baseurl +"userfiles/attach/"+dat.col1 + "'>"+dat.col1+"</a></td></tr>";
                    });
                    $("#activity2").html(objetos);
                }

            });

        });*/
</script>
</body>
</html>
