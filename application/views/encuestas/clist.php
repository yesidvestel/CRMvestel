<article class="content content items-list-page">
    <div class="card card-block">
        <div id="notify" class="alert alert-success" style="display:none;">
            <a href="#" class="close" data-dismiss="alert">&times;</a>

            <div class="message"></div>
			
        </div>
		
        <div class="grid_3 grid_4 table-responsive animated fadeInRight">
            <h5><?php echo $this->lang->line('') ?>Listado de Encuestas</h5>
			<!-- paneles -->
            <div class="card">
                    <div class="card-body">
                        <div class="card-block">
                            <label class="col-sm-12 col-form-label"
                                       for="pay_cat"><h5>FILTRAR </h5> </label> 

                            <ul class="nav nav-tabs nav-justified">
                                <li class="nav-item">
                                    <a class="nav-link active" id="active-tab" data-toggle="tab" href="#thread"
                                       aria-controls="thread"
                                       aria-expanded="true">Fecha</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="link-tab" data-toggle="tab" href="#tecnico"
                                       aria-controls="tecnico"
                                       aria-expanded="false">Tecnico</a>
                                </li>
								<li class="nav-item">
                                    <a class="nav-link" id="detalle-tab" data-toggle="tab" href="#realizador"
                                       aria-controls="realizador"
                                       aria-expanded="false">Realizado por</a>
                                </li>
                            </ul>
                            <div class="tab-content px-1 pt-1">
								<!--thread-->
                                <div class="tab-pane fade  active in" id="thread" role="tabpanel" aria-labelledby="thread-tab" aria-expanded="true">

                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label"
                                               for="pay_cat">Fechas</label>

                                        <div class="col-sm-6">
                                            <select name="trans_type" class="form-control" id="fechas" onchange="filtrado_fechas()">
                                                <option value=''>Todas</option>
                                                <option value='fcreada'>Fecha Creada</option>
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
                                <div role="tabpanel" class="tab-pane fade" id="tecnico" aria-labelledby="active-tab" aria-expanded="false">
                                    <div class="form-group row">
                                        
                                        <label class="col-sm-2 col-form-label"
                                               for="pay_cat">Tecnico</label>

                                        <div class="col-sm-6">
                                            <select name="tec" class="form-control" id="tecnico">
                                                <option value=''>Todos</option>
                                               <?php
                                                    foreach ($tecnicoslista as $row) {
                                                        $cid = $row['id'];
                                                        $title = $row['username'];
                                                        echo "<option value='$title' data-id='$cid'>$title</option>";
                                                    }
                                                    ?>
                                            </select>
                                        </div>
                                    </div>

                                </div>
                                <div class="tab-pane fade" id="realizador" role="tabpanel" aria-labelledby="link-tab" aria-expanded="false">
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label"
                                                   for="pay_cat">Realizador</label>

                                            <div class="col-sm-6">
                                                <select name="trans_type" class="form-control" id="realizador">
                                                    <option value=''>Todas</option>
                                                     <?php
                                                    foreach ($tecnicoslista as $row) {
                                                        $cid = $row['id'];
                                                        $title = $row['username'];
                                                        echo "<option value='$cid' data-id='$cid'>$title</option>";
                                                    }
                                                    ?>
                                                </select>
                                            </div>                              
                                        </div>    
                                </div>
								
                                
                                <!--milestones-->
                                
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
            <hr><a href="#" onclick="redirect_to_export()" class="btn btn-success btn-md">Exportar a Excel .XLSX</a>
            <table id="clientstable" class="table-striped" cellspacing="0" width="100%">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Orden #</th>
					<th>Fecha</th>
                    <th>Tecnico</th>
                    <th>Realizado por</th>
                    <th>Presentacion</th>
                    <th>Trato</th>
					<th>Estado</th>
					<th>Tiempo</th>
					<th>Recomendaria</th>
					<th>Observacion</th>
					


                </tr>
                </thead>
                <tbody>
                </tbody>

                <tfoot>
                <tr>
                    <th>#</th>
                    <th>Orden #</th>
					<th>Fecha</th>
                    <th>Tecnico</th>
                    <th>Realizado por</th>
                    <th>Presentacion</th>
                    <th>Trato</th>
					<th>Estado</th>
					<th>Tiempo</th>
					<th>Recomendaria</th>
					<th>Observacion</th>


                </tr>
                </tfoot>
            </table>
        </div>
    </div>
</article>

<script type="text/javascript">
	var tb;
    $(document).ready(function () {
      tb=  $('#clientstable').DataTable({
            'processing': true,
            'serverSide': true,
            'stateSave': true,
            'order': [],
            'ajax': {
                'url': "<?php echo site_url('encuesta/load_list')?>",
                'type': 'POST'
            },
            'columnDefs': [
                {
                    'targets': [0],
                    'orderable': false,
                },
            ],
        });
    });
	function  filtrado_fechas(){
        var opcion_seleccionada=$("#fechas option:selected").val();
        if(opcion_seleccionada=="fcreada"){
            $("#div_fechas").show();
            $("#label_fechas").text("Fecha Creada");
        }
    }
	function filtrar(){
        var tecnico=$("#tecnico option:selected").val();
        var realizador =$("#realizador option:selected").val();
        var sdate =$("#sdate").val();
        var edate =$("#edate").val();
        var opcion_seleccionada=$("#fechas option:selected").val();
        if(tecnico=="" && realizador=="" && opcion_seleccionada==""){
            tb.ajax.url( baseurl+'encuesta/load_list').load();     
        }else{
            tb.ajax.url( baseurl+"encuesta/load_list?sdate="+sdate+"&edate="+edate+"&opcselect="+opcion_seleccionada+"&tecnico="+tecnico+"&realizador="+realizador ).load();     
        }
       

    }
	function redirect_to_export(){
        var tecnico=$("#tecnico option:selected").val();
        var realizador =$("#realizador option:selected").val();
        var sdate =$("#sdate").val();
        var edate =$("#edate").val();
		var opcion_seleccionada=$("#fechas option:selected").val();
        var url_redirect=baseurl+'encuesta/explortar_a_excel?sdate='+sdate+"&edate="+edate+"&opcselect="+opcion_seleccionada+"&tecnico="+tecnico+"&realizador="+realizador;
            window.location.replace(url_redirect);

    }
</script>
<div id="delete_model" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><?php echo $this->lang->line('Delete') ?></h4>
            </div>
            <div class="modal-body">
                <p><?php echo $this->lang->line('delete this supplier') ?></p>
            </div>
            <div class="modal-footer">
                <input type="hidden" id="object-id" value="">
                <input type="hidden" id="action-url" value="supplier/delete_i">
                <button type="button" data-dismiss="modal" class="btn btn-primary"
                        id="delete-confirm"><?php echo $this->lang->line('Delete') ?></button>
                <button type="button" data-dismiss="modal"
                        class="btn"><?php echo $this->lang->line('Cancel') ?></button>
            </div>
        </div>
    </div>
</div>