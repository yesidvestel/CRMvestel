<style type="text/css">
   .wrapper1, .wrapper2 { width: 100%; overflow-x: scroll; overflow-y: hidden; }
.wrapper1 { height: 20px; }
.div1 { height: 20px; }
.div2 { overflow: none; }
</style>
<article class="content">
    <div class="card card-block">
        <div id="notify" class="alert alert-success" style="display:none;">
            <a href="#" class="close" data-dismiss="alert">&times;</a>

            <div class="message"></div>
        </div>
        <div class="grid_3 grid_4">
            <div class="header-block">
                <h3 class="title">
                    <?php echo $this->lang->line('Support Tickets') ?>
                </h3></div>


            <p>&nbsp;</p>
            <div class="row">
                <div class="col-xl-3 col-lg-6 col-xs-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-block">
                                <div class="media">
                                    <div class="media-body text-xs-left">
										<?php $numero_asignados= $this->db->select('count(idt) as numero')->from('tickets')->where('status="Pendiente"')->get()->result(); ?>
                                        <h3 class="pink"><?=$numero_asignados[0]->numero?></h3>
                                        <span><?php echo $this->lang->line('Waiting') ?></span>
                                    </div>
                                    <div class="media-right media-middle">
                                        <i class="icon-clock3 pink font-large-2 float-xs-right"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-6 col-xs-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-block">
                                <div class="media">
                                    <div class="media-body text-xs-left">
										<?php $numero_asignados= $this->db->select('count(idt) as numero')->from('tickets')->where('status="Anulada"')->get()->result(); ?>
                                        <h3 class="indigo"><?=$numero_asignados[0]->numero?></h3>
                                        <span>Anuladas</span>
                                    </div>
                                    <div class="media-right media-middle">
                                        <i class="icon-spinner5 indigo font-large-2 float-xs-right"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-6 col-xs-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-block">
                                <div class="media">
                                    <div class="media-body text-xs-left">
										<?php $numero_asignados= $this->db->select('count(idt) as numero')->from('tickets')->where('status="Resuelto"')->get()->result(); ?>
                                        <h3 class="green"><?=$numero_asignados[0]->numero?></h3>
                                        <span><?php echo $this->lang->line('Solved') ?></span>
                                    </div>
                                    <div class="media-right media-middle">
                                        <i class="icon-clipboard2 green font-large-2 float-xs-right"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-6 col-xs-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-block">
                                <div class="media">
                                    <div class="media-body text-xs-left">
                                        <h3 class="deep-cyan"><?php echo $totalt ?></h3>
                                        <span><?php echo $this->lang->line('Total') ?></span>
                                    </div>
                                    <div class="media-right media-middle">
                                        <i class="icon-stats-bars22 deep-cyan font-large-2 float-xs-right"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


			
                    <!-- paneles -->
            <div class="card">
                    <div class="card-body">
                        <div class="card-block">
                            <label class="col-sm-12 col-form-label"
                                       for="pay_cat"><h5>FILTRAR </h5> </label> 

                            <ul class="nav nav-tabs nav-justified">
                                <li class="nav-item">
                                    <a class="nav-link active" id="active-tab" data-toggle="tab" href="#active"
                                       aria-controls="active"
                                       aria-expanded="true">Tecnico</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="link-tab" data-toggle="tab" href="#link"
                                       aria-controls="link"
                                       aria-expanded="false">Estado</a>
                                </li>
								<li class="nav-item">
                                    <a class="nav-link" id="detalle-tab" data-toggle="tab" href="#detalle"
                                       aria-controls="detalle"
                                       aria-expanded="false">Detalle</a>
                                </li>

                                <li class="nav-item">
                                    <a class="nav-link" id="thread-tab" data-toggle="tab" href="#thread"
                                       aria-controls="thread">Fechas</a>
                                </li>

                                <li class="nav-item">
                                    <a class="nav-link" id="milestones-tab" data-toggle="tab" href="#milestones"
                                       aria-controls="milestones"> Sede</a>
                                </li>
                               <!-- <li class="nav-item">
                                    <a class="nav-link" id="thread-tab" data-toggle="tab" href="#activities"
                                       aria-controls="activities">Otro Filtro</a>
                                </li>-->
                               
                            </ul>
                            <div class="tab-content px-1 pt-1">
                                <div role="tabpanel" class="tab-pane fade active in" id="active" aria-labelledby="active-tab" aria-expanded="true">
                                    <div class="form-group row">
                                        
                                        <label class="col-sm-2 col-form-label"
                                               for="pay_cat">Tecnico</label>

                                        <div class="col-sm-6">
                                            <select style="width: 100%;" name="tec[]" class="form-control select-box" id="tecnicos2" multiple="multiple">
                                                
                                                <option value='Sin Asignar'>Sin Asignar</option>
                                                <?php
                                                    foreach ($tecnicoslista as $row) {
                                                        $cid = $row['id'];
                                                        $title = $row['username'];
														$nombre = $row['name'];
                                                        echo "<option value='$title' data-id='$cid'>$nombre</option>";
                                                    }
                                                    ?>
                                            </select>
                                        </div>
                                    </div>

                                </div>
                                <div class="tab-pane fade" id="link" role="tabpanel" aria-labelledby="link-tab" aria-expanded="false">
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label"
                                                   for="pay_cat">Estado</label>

                                            <div class="col-sm-6">
                                                <select style="width: 100%;" name="trans_type[]" class="form-control select-box" id="estados" multiple="multiple">
                                                    <option value='Pendiente'>Pendiente</option>
                                                    <option value='Realizando'>Realizando</option>
                                                    <option value='Resuelto'>Resuelto</option>
													<option value='Anulada'>Anulada</option>
                                                </select>
                                            </div>                              
                                        </div>    
                                </div>
								<div class="tab-pane fade" id="detalle" role="tabpanel" aria-labelledby="detalle-tab" aria-expanded="false">
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label"
                                                   for="detalle">Detalle de orden</label>

                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                <select style="width: 100%;" name="trans_type[]" class="form-control select-box detalle-class col-sm-6" id="detalle-sl" multiple="multiple">
                                                   	
                                                   	<option value='AgregarInternet'>AgregarInternet</option>
                                                  	<option value='AgregarTelevision'>AgregarTelevision</option>
                                                   	<option value='Activacion'>Activacion</option>
                                                  	<option value='AgregarTelevision'>AgregarTelevision</option>
													<option value='Cambio de equipo'>Cambio de equipo</option>
													<option value='Cambio de clave'>Cambio de clave</option>
													<option value='Corte Combo'>Corte Combo</option>
													<option value='Corte Internet'>Corte Internet</option>
													<option value='Corte Television'>Corte Television</option>
													<option value='Equipo adicional'>Equipo adicional</option>
													<option value='Instalacion'>Instalacion</option>
													<option value='Punto nuevo'>Punto nuevo</option>
													<option value='Veeduria'>Veeduria</option>
													<option value='Revision de Internet'>Revision de Internet</option>
													<option value='Revision de television'>Revision de television</option>
													<option value='Revision tv e internet'>Revision tv e internet</option>
													<option value='Reconexion Combo'>Reconexion Combo</option>
													<option value='Reinstalación'>Reinstalación</option>
													<option value='Reconexion Internet'>Reconexion Internet</option>
													<option value='Retiro voluntario'>Retiro voluntario</option>
													<option value='Reconexion Television'>Reconexion Television</option>
													<option value='Recuperación cable modem'>Recuperación cable modem</option>
													<option value='Subir megas'>Subir megas</option>
													<option value='Bajar megas'>Bajar megas</option>
													<option value='Suspension Combo'>Suspension Combo</option>
													<option value='Suspension Internet'>Suspension Internet</option>
													<option value='Suspension Television'>Suspension Television</option>
													<option value='Traslado'>Traslado</option>
													<option value='Toma Adicional'>Toma Adicional</option>
													<option value='Migracion'>Migracion</option>
                                                </select>
                                               </div>
                                            </div>                              
                                        </div>    
                                </div>
                                <!--thread-->
                                <div class="tab-pane fade" id="thread" role="tabpanel" aria-labelledby="thread-tab" aria-expanded="false">

                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label"
                                               for="pay_cat">Fechas</label>

                                        <div class="col-sm-6">
                                            <select name="trans_type" class="form-control" id="fechas" onchange="filtrado_fechas()">
                                                <option value=''>Todas</option>
                                                <option value='fcreada'>Fecha Creada</option>
                                                <option value='fcierre'>Fecha Cierre</option>
                                            </select>
                                        </div>                              
                                    </div>
                                    <div class="form-group row" id="div_fechas" style="display: none">
                                        <label class="col-sm-2 col-form-label"
                                               for="pay_cat" id="label_fechas">Fecha Creada</label>

                                        <div class="col-sm-2">
                                            <input type="text" class="form-control required"
                                                   placeholder="Start Date" name="sdate" id="sdate"
                                                    autocomplete="false">
                                        </div>
                                        <div class="col-sm-2">
                                            <input type="text" class="form-control required"
                                                   placeholder="End Date" name="edate" id="edate"
                                                   data-toggle="datepicker" autocomplete="false">
                                        </div>
                                    </div>
                                   

                                </div>
                                <!--thread-->
                                <!--milestones-->
                                <div class="tab-pane fade" id="milestones" role="tabpanel" aria-labelledby="milestones-tab" aria-expanded="false">
                                     
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label"
                                                   for="sede_sel">Sede</label>

                                            <div class="col-sm-6">
                                                <select style="width: 100%;" name="sede_sel[]" class="form-control select-box" id="sede_sel" multiple="multiple">                                        
                                                    
                                                    <?php 
                                                            foreach ($listaclientgroups as $key => $sede) {
                                                                echo "<option value='".$sede['id']."'>".$sede['title']."</option>";
                                                            }

                                                     ?>                                        
                                                </select>
                                            </div>                              
                                        </div>

                                </div>
                                <!--milestones-->
                                <!--otro filtro 
                                <div class="tab-pane fade" id="activities" role="tabpanel" aria-labelledby="activities-tab" aria-expanded="false">

                                </div>
                                activities-->
                                
                                


                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                                <label class="col-sm-3 col-form-label" for="pay_cat"></label>

                                <div class="col-sm-4">
                                    <input type="button" class="btn btn-primary btn-md" value="VER" onclick="filtrar()">


                                </div>
                            </div>
                </div>
                <!-- fin paneles -->
                <a href="#" onclick="redirect_to_export()" class="btn btn-success btn-md">Exportar a Excel .XLSX</a>
<div class="wrapper1">
    <div class="div1"></div>
</div>
			<div class="wrapper2">
				
                <div class="div2">
            <table id="doctable" class="table table-hover" cellspacing="0" width="100%">
                <thead>
                <tr>
					<th>#</th>
					<th><i class="icon-marquee"></th>
					<th>tpo</th>
					<th>N° orden</th>	
                    <th><?php echo $this->lang->line('Subject') ?></th>
					<th style="">Detalle</th>
                    <th>F/creada</th>
					<span style=""></span>
					<th>F/cierre</th>
					<th>Abonado</th>
					<th>Usuario</th>
					<th>documento</th>
					<th>Observacion</th>
                    <th>Factura</th>
					<th>Realizada</th>
					<th>Asignado</th>
					<th>Sede</th>
					<th>Barrio</th>
					<th>Tecnologia</th>
					<th>Agenda</th>
					<th>Estado</th>
					<?php if ($this->aauth->get_user()->roleid >= 3) { ?>
                    <th>Ver</th>
					
					<th>Editar</th>
					<?php } ?>
					<?php if ($this->aauth->get_user()->roleid == 5) { ?>
					<th>Eliminar</th>
					<?php } ?>

                </tr>
                </thead>
                <tbody>
				
                </tbody>

            </table>
            </div>
			</div>
			<?php if ($this->aauth->get_user()->roleid >= 3) { ?>
			<div class="col-md-12">
			 	<div class="col-md-12">
					<h6 class="colspan 1">ASIGNAR ORDEN</h6>
				</div>
				<div class="col-xs-3 mb-1">
                    <label>Tecnicos</label>
					<select name="asignado" id="tecnicos" class="form-control mb-1">
					<option value="">-</option>
				<?php
					foreach ($tecnicoslista as $row) {
						$cid = $row['id'];
						$title = $row['username'];
						$nombre = $row['name'];
						echo "<option value='$title'>$nombre</option>";
					}
					?>
				</select>
				</div>
                
				

			</div>
            <div class="col-md-12">
               
            <div class="col-xs-3 mb-1">
                <label>Moviles</label>
                    <select name="moviles_asignar" id="moviles_asignar" class="form-control mb-1">
                   <option value="">-</option>
                        <?php
                            foreach ($moviles as $movil) {
                                $id = $movil->id_movil;
                                $nombre = $movil->nombre;
                                if($movil->estado!="Inactiva"){
                                    echo "<option value='$id'>id#$id - $nombre</option>";
                                }
                            }
                            ?>
                </select>
                </div>
            </div>
            <div class="col-md-12">
            <div class="col-xs-2 mb-1">
                    <input type="hidden" id="action-url" value="tickets/update_status">
                        <button type="button" class="btn btn-primary"
                                onclick="asignar_tecnico()">Asignar</button>
                </div>
            </div>
			<?php } ?>
			</div>
        </div>
    </div>
    <input type="hidden" id="dashurl" value="tickets/ticket_stats">
</article>

<div id="delete_model" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><?php echo $this->lang->line('Delete') ?></h4>
            </div>
            <div class="modal-body">
                <p><?php echo $this->lang->line('delete this ticket') ?></p>
            </div>
            <div class="modal-footer">
                <input type="hidden" id="object-id" value="">
                <input type="hidden" id="action-url" value="tickets/delete_ticket">
                <button type="button" data-dismiss="modal" class="btn btn-primary"
                        id="delete-confirm"><?php echo $this->lang->line('Delete') ?></button>
                <button type="button" data-dismiss="modal"
                        class="btn"><?php echo $this->lang->line('Cancel') ?></button>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    var tb;
   
    $(function () {
    $('.wrapper1').on('scroll', function (e) {
        $('.wrapper2').scrollLeft($('.wrapper1').scrollLeft());
    }); 
    $('.wrapper2').on('scroll', function (e) {
        $('.wrapper1').scrollLeft($('.wrapper2').scrollLeft());
    });
});
$(window).on('load', function (e) {
    var x1a=$('#doctable').width();
    
    $('.div1').width(x1a+210);
    $('.div2').width(x1a+210);
});
    $(document).ready(function () {

        tb=$('#doctable').DataTable({

            "processing": true,
            "serverSide": true,
            "ajax": {
                "url": "<?php if (isset($_GET['filter'])) {
                    $filter = $_GET['filter'];
                } else {
                    $filter = '';
                }    echo site_url('tickets/tickets_load_list?stat=' . $filter)?>",
                "type": "POST"
            },
            "columnDefs": [
                {
                    "targets": [0],
                    "orderable": false,
                },
            ],
			"order": [[ 2, "desc" ]],
                "language":{
                    "processing": "Procesando...",
                    "lengthMenu": "Mostrar _MENU_ registros",
                    "zeroRecords": "No se encontraron resultados",
                    "emptyTable": "Ningún dato disponible en esta tabla",
                    "infoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
                    "infoFiltered": "(filtrado de un total de _MAX_ registros)",
                    "search": "Buscar:",
                    "infoThousands": ",",
                    "loadingRecords": "Cargando...",
                    "paginate": {
                        "first": "Primero",
                        "last": "Último",
                        "next": "Siguiente",
                        "previous": "Anterior"
                    },
                     "info": "Mostrando de _START_ a _END_ de _TOTAL_ entradas"

                }

        });
        //miniDash();

 

 

       
    });
 /*  lo comento porque no fue necesario, porque puedo validar solo con una serie de fechas y no necesito estos campos pero lo dejo porque es funcional para futuras ediciones con fecha
    
    function editar_datepickerts(formato,fecha){
        $('#sdate3').datepicker({autoHide: true, format: formato});
        $('#sdate3').datepicker('setDate', fecha);
    }
*/
  function  filtrado_fechas(){
        var opcion_seleccionada=$("#fechas option:selected").val();
        if(opcion_seleccionada=="fcreada"){
            $("#div_fechas").show();
            $("#label_fechas").text("Fecha Creada");
        }else if(opcion_seleccionada=="fcierre"){
            $("#label_fechas").text("Fecha Cierre");
            $("#div_fechas").show();
        }else{
            $("#div_fechas").hide();
        }
    }

    let lista_ordenes=[];
    function asignar_orden(elemento){
        var indice_elemento=lista_ordenes.indexOf($(elemento).data("id"));
        
        if(indice_elemento==-1){
                if(elemento.checked==true){
                    lista_ordenes.push($(elemento).data("id"));                   
                }
        }else{
            if(elemento.checked==false){
                lista_ordenes.splice(indice_elemento,1);
            }
        }
    }

    $("#doctable").on('draw.dt',function (){
        $(lista_ordenes).each(function(index,value){
            var checked_seleccionado=document.getElementById("input_"+value);            
            try{
                if(checked_seleccionado.checked==false){
                        console.log("si esta imprimiendo todo esta bien Gloria Al Dios Altisimo Jesus de Nazaret.");
                        $(checked_seleccionado).prop("checked",true);

                }
            }catch(error){

            }
            
        });

    });
    function asignar_tecnico (){
        var id_tecnico_seleccionado=$("#tecnicos").val();
        var id_movil_seleccionada=$("#moviles_asignar").val();
	
        $.post(baseurl+"tickets/asignar_ordenes",{id_movil_seleccionada:id_movil_seleccionada,id_tecnico_seleccionado:id_tecnico_seleccionado,lista:lista_ordenes},function(data){

                if(data=="correcto"){
                    var url1=baseurl+"tickets/";
                    window.location.replace(url1);
                }
        });
    }
    function eliminar_ticket(id){
        var confirmacion = confirm("Deseas Eliminar esta orden ?");
        if(confirmacion==true){
            $.post(baseurl+"tickets/delete_ticket",{deleteid:id},function (data){
                alert("Orden Eliminada...");                
                window.location.reload();
            },'json');
      }
    }
    function filtrar(){
        var tecnico=$("#tecnicos2").val();
        var estado =$("#estados").val();
		var detalle =$("#detalle-sl").val();
        var sdate =$("#sdate").val();
        var edate =$("#edate").val();
        var opcion_seleccionada=$("#fechas option:selected").val();
        var sede_filtrar=$("#sede_sel").val();
        
        if(tecnico=="" && estado=="" && opcion_seleccionada=="" && ciudad_filtrar==""){
            tb.ajax.url( baseurl+'tickets/tickets_load_list?stat=' ).load();     
        }else{
            var id1=$("#tecnicos2 option:selected").data("id");
            tb.ajax.url( baseurl+"tickets/tickets_load_list?sdate="+sdate+"&edate="+edate+"&opcselect="+opcion_seleccionada+"&tecnico="+tecnico+"&estado="+estado+"&detalle="+detalle+"&tec1="+id1+"&sede_filtrar="+sede_filtrar+"&stat=" ).load();     
        }
       

    }
	function redirect_to_export(){
         var tecnico=$("#tecnicos2").val();
        var estado =$("#estados").val();
		var detalle =$("#detalle-sl").val();
        var sdate =$("#sdate").val();
        var edate =$("#edate").val();
        var opcion_seleccionada=$("#fechas option:selected").val();
        var sede_filtrar=$("#sede_sel").val();
        var id1=$("#tecnicos2 option:selected").data("id");
        var url_redirect=baseurl+'tickets/explortar_a_excel?sdate='+sdate+"&edate="+edate+"&opcselect="+opcion_seleccionada+"&tecnico="+tecnico+"&estado="+estado+"&detalle="+detalle+"&tec1="+id1+"&sede_filtrar="+sede_filtrar+"&id=<?=$_GET['id']?>";
            window.location.replace(url_redirect);

    }
    $("#detalle-sl").select2();
    $("#tecnicos2").select2();
    $("#estados").select2();
    $("#sede_sel").select2();
    
</script>
