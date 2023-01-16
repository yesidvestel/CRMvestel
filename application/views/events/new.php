<script type="text/javascript">
    $("#datepicker_css").remove();
    $("#datepicker_js").remove();
</script>
<script src="<?php echo base_url('assets/myjs/bootstrap-datepicker.js') . APPVER; ?>"></script>

<link rel="stylesheet" href="<?php echo base_url('assets/css/datepicker/bootstrap-datepicker3.standalone.css') . APPVER ?>">
<script src='<?php echo base_url(); ?>assets/portjs/moment.min.js'></script>
<script src='<?php echo base_url(); ?>assets/myjs/locales/bootstrap-datepicker.es.js'></script>
<link rel="stylesheet" type="text/css" href="<?=base_url()  ?>assets/css/estilos_new_calendar.css?<?=time() ?>">
<style type="text/css">
    .text_center{
        text-align: center;
    }
    .tabla_eventos_por_hora,.td_h, .td_event{
        border: solid 1px black;
    }
    .event_class{
        width: 100%;
        margin-bottom: 7px;
        margin-top: 7px;
        border-radius: 20px;
        white-space:initial;
    }
</style>

<article class="content">
    
    <div class="card card-block">
        <?php if($this->aauth->get_user()->roleid>=3){ ?>
        <div class="form-group row" >
                    
                    <div class="col-sm-6">
                        <label >Tecnico</label><br>
                        <select id="tecnicos_f" class="form-control">
                            <option value="all">Todo</option>
                            <?php foreach ($tecnicoslista as $key => $value) {
                                $username=$value['username'];
                                echo "<option value='$username'>$username</option>";
                            } ?>
                        </select>
                    </div>

                </div>
        <?php  }?>
                <!--div class="form-group row" >
                    
                    <div class="col-sm-6">
                        <label for="movil_f">Movil</label>
                        <select id="movil_f" class="form-control">
                            <option value="all">Todo</option>
                            <?php 
                                foreach ($moviles as $key => $value) {
                                    $nombre=$value->nombre;
                                    $id_movil=$value->id_movil;
                                    echo "<option value='$id_movil'>$nombre</option>";
                                }
                             ?>
                        </select>
                    </div>

                </div-->
        <div class="form-group row">


                                <div class="col-sm-6">
                                    <input type="text" class="form-control required"
                                           placeholder="Start Date" name="sdate4" id="sdate4"
                                            autocomplete="false" readonly style="background-color:white;" >
                                </div>
        </div>
        <hr>
       


        <table width="100%" class="tabla_eventos_por_hora">
            <thead>
                <tr>
                    <th class="text_center"><img width="50%" src="<?=base_url()."assets/images/icons/reloj.png" ?>"></th><!-- colocar icono de relog-->
                    <th class="text_center titulo_h2"><?=$fecha_titulo ?></th>                </tr>
            </thead>
            <tbody>
                <?php for ($hora=0; $hora <24 ; $hora++) { ?>
                        <tr>
                            <td width="10%" class="td_h text_center"><?=$hora ?></td>
                            <td class="td_event" id="eventos_h_<?=$hora  ?>">
                                <?php if(isset($lista_eventos[$hora])){
                                    foreach ($lista_eventos[$hora] as $key => $event) { ?>

                                        <a title="<?=$event->description ?>" href="#" style="background-color:<?=$event->color ?>" data-info="<?=$event->start ?>" data-idorden="<?=$event->idt ?>" data-idtarea="<?=$event->id_tarea ?>" data-titulo="<?= $event->title?>" class="btn btn-success event_class">Servicio #<?=$event->idt."<br>".$event->title ?><a>

                                   <?php }
                                } ?>
                                

                            </td>
                        </tr>
                <?php } ?>
            </tbody>
            <tbody>
                <tr>
                    <th class="text_center"><img width="50%" src="<?=base_url()."assets/images/icons/reloj.png" ?>"></th><!-- colocar icono de relog-->
                    <th class="text_center titulo_h2"><?=$fecha_titulo ?></th>
                </tr>
            </tbody>
        </table>
        
        
    </div>
</article>
<!-- BEGIN VENDOR JS-->
<div id="modal-notificacion-calendario" class="modal fade">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                
                <h4 class="modal-title" align="center" id="modal_titulo">Titulo</h4>
            </div>
            <div class="modal-body">
                    
            </div>
            <div class="modal-footer">
                
                <a id="ver_orden_a" class="btn btn-success" href="#">Ver Orden</a>
                <button type="button" class="btn btn-primary" onclick="$('#modal-notificacion-calendario').modal('hide')">Accept</button>
                
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    
    $(document).on("click",".event_class",function(ev){
        ev.preventDefault();
        var idorden=$(this).data("idorden");
        var idtarea=$(this).data("idtarea");
        var dtitulo=$(this).data("titulo");
        var urlx=baseurl;
        if(idorden!="" && idorden!=null){
            urlx+="tickets/thread/?id="+idorden;    
            $("#modal_titulo").html("Servicio #"+idorden+"<br>"+dtitulo);
            $("#ver_orden_a").text("Ver Orden");    
        }else{
            urlx+="manager/historial/?id="+idtarea;    
            $("#ver_orden_a").text("Ver Tarea");    
            $("#modal_titulo").html("Tarea #"+idtarea+"<br>"+dtitulo);
        }
        
        $("#ver_orden_a").attr("href",urlx);
        $("#modal-notificacion-calendario").modal("show");
    });


    $('#sdate4').datepicker({autoclose: true, format: "dd-mm-yyyy",language:'es',todayHighlight:true});
    $('#sdate4').datepicker('setDate', "<?=date("d-m-Y") ?>");
    var fecha_actual="<?=date("d-m-Y") ?>";
 
$('#sdate4').datepicker().on("change", function(e) {
        var fecha_cambio=$(this).val();
        $(".pace").removeClass("pace-inactive");
        $(".pace").addClass("pace-active");
        $(".pace-progress").css("transform","translate3d(70%, 0px, 0px)");

        var usuario =$("#tecnicos_f option:selected").val();
        $.post(baseurl+"events/get_events_new_calendar",{'fecha':fecha_cambio,'tecnico':usuario},function(data){
            $(".pace-progress").css("transform","translate3d(90%, 0px, 0px)");
            $(".titulo_h2").text(data.fecha_titulo);
            var eventos=data.lista_eventos;
           for(var i in eventos){
            //console.log(data[i]);
                for(var i1 in eventos[i]){
                    var event_dta=eventos[i][i1];
                    var event_html=devolver_evento(event_dta);
                    $("#eventos_h_"+i).append(event_html);
                    

                }
           }
           $(".pace-progress").css("transform","translate3d(100%, 0px, 0px)");
           $(".pace").removeClass("pace-active");
        $(".pace").addClass("pace-inactive");
        },'json');
        $(".event_class").remove();
        
    });

    function devolver_evento(event_dta){
        return '<a href="#" style="background-color:'+event_dta.color+'" data-idtarea="'+event_dta.id_tarea+'" data-idorden="'+event_dta.idt+'" data-info="'+event_dta.start+'" data-titulo="'+event_dta.title+'"" class="btn btn-success event_class">Servicio #'+event_dta.idt+"<br>"+event_dta.title+'<a>';
    }
        //https://bootstrap-datepicker.readthedocs.io/en/latest/markup.html
        //https://github.com/uxsolutions/bootstrap-datepicker
        //$('#sdate4').datepicker('Locale', 'es');
</script>