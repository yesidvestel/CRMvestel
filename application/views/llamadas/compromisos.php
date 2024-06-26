<article class="content">
    <div class="card card-block">
        <div id="notify" class="alert alert-success" style="display:none;">
            <a href="#" class="close" data-dismiss="alert">&times;</a>

            <div class="message"></div>
        </div>
        <div class="grid_3 grid_4 animated fadeInRight table-responsive">
            <h5>Llamadas</h5>
			
            <hr>
            <div class="card card-block sameheight-item">

                        
                            <div class="form-group row">
								<label class="col-sm-12 col-form-label"
                                       for="pay_cat"><h5>FILTRAR</h5></label>
								<?php if ($this->aauth->get_user()->roleid > 3) { ?>
                                <label class="col-sm-2 col-form-label"
                                       for="pay_cat">Realizadas por</label>

                                <div class="col-sm-6">
                                    <select name="tec" class="form-control" id="tecnicos2">
										
                                        <option value='0'>Todos</option>
                                        <?php
											foreach ($tecnicoslista as $row) {
												$cid = $row['id'];
												$title = $row['username'];
												echo "<option value='$title' data-id='$title'>$title</option>";
											}
											?>
                                    </select>
                                </div>
								<?php } ?>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label"
                                       for="pay_cat">Fechas</label>

                                <div class="col-sm-6">
                                    <select name="trans_type" class="form-control" id="fechas" onchange="filtrado_fechas()">
                                        <option value=''>Todas</option>
                                        <option value='fcreada'>Especificar Fecha</option>
                                        <option value='fecha_final'>Fecha Vencimiento</option>
                                        
                                    </select>
                                </div>                              
                            </div>
				 			<div class="form-group row" id="div_fechas" style="display: none">
                                <label class="col-sm-2 col-form-label"
                                       for="pay_cat" id="label_fechas">Fechas</label>

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
							<div class="form-group row" id="div_fecha_final" style="display: none">
                                <label class="col-sm-2 col-form-label"
                                       for="pay_cat" id="label_fecha_final">Fechas Vence</label>

                                <div class="col-sm-2">
                                    <input type="text" class="form-control required" data-toggle="datepicker" 
                                           placeholder="Start Date" name="sdatefin" id="sdatefin"
                                            autocomplete="false">
                                </div>
								<div class="col-sm-2">
									<input type="text" class="form-control required"
                                           placeholder="End Date" name="edatefin" id="edatefin"
                                           data-toggle="datepicker" autocomplete="false">
								</div>
                            </div>
                           
							<div class="form-group row">
                                <label class="col-sm-3 col-form-label" for="pay_cat"></label>

                                <div class="col-sm-4">
                                    <input type="button" class="btn btn-primary btn-md" value="VER" onclick="filtrar()">


                                </div>
                            </div>
                        
                    </div>
			<a href="#" onclick="redirect_to_export()" class="btn btn-success fa-sharp fa-solid fa-file-excel"></a>
            <hr>
            <table id="invoices" class="table-striped" cellspacing="0" width="100%">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Fecha</th>
                    <th>Hora</th>
                    <th>Vence</th>
					<?php if ($this->aauth->get_user()->roleid > 3) { ?>
                    <th>Realizado por</th>
					<?php } ?>
                    <th>Usuario</th>
                    <th>Documento</th>
					<th>Debe</th>
					<th>Pago</th>					
					<th>Observacion</th>
                    <th class="no-sort"><?php echo $this->lang->line('Settings') ?></th>
					<?php if ($this->aauth->get_user()->roleid > 4) { ?>
                    <th class="no-sort"><?php echo $this->lang->line('') ?>Eliminar</th>
					<?php } ?>

                </tr>
                </thead>
                <tbody>
					
                </tbody>

                <tfoot>
                <tr>
                    <th>#</th>
                    <th>Fecha</th>
                    <th>Hora</th>
                    <th>Vence</th>
					<?php if ($this->aauth->get_user()->roleid > 3) { ?>
                    <th>Realizado por</th>
					<?php } ?>
                    <th>Usuario</th>
                    <th>Documento</th>
					<th>Debe</th>
					<th>Pago</th>					
					<th>Observacion</th>
                    <th class="no-sort"><?php echo $this->lang->line('Settings') ?></th>
					<?php if ($this->aauth->get_user()->roleid > 4) { ?>
                    <th class="no-sort"><?php echo $this->lang->line('') ?>Eliminar</th>
					<?php } ?>
                </tr>
                </tfoot>
            </table>
        </div>
    </div>


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
                <p><?php echo $this->lang->line('delete this order') ?></p>
            </div>
            <div class="modal-footer">
                <input type="hidden" id="object-id" value="">
                <input type="hidden" id="action-url" value="llamadas/delete_i">
                <button type="button" data-dismiss="modal" class="btn btn-primary"
                        id="delete-confirm"><?php echo $this->lang->line('Delete') ?></button>
                <button type="button" data-dismiss="modal"
                        class="btn"><?php echo $this->lang->line('Cancel') ?></button>
            </div>
			
        </div>
    </div>
</div>
<script src="https://kit.fontawesome.com/317775a1b1.js" crossorigin="anonymous"></script>
<script type="text/javascript">
    var table;
	var id_col="<?=$_GET['id'] ?>";
    $(document).ready(function () {

        table = $('#invoices').DataTable({
            "processing": true,
            "serverSide": true,
            "order": [],
            "ajax": {
                "url": "<?php echo site_url('llamadas/com_list')?>",
                "type": "POST",
                //"data": {'cid':<?php //echo $_GET['id'] ?> }
            },
            "columnDefs": [
                {
                    "targets": [0],
                    "orderable": false,
                },
            ],
			

        });

    });
	/*$(document).ready(function () {

        //datatables
        $('#invoices').DataTable({
			 order: [[2, 'desc']],
			language: {
                "lengthMenu": "Mostrar _MENU_ registros",
                "zeroRecords": "No se encontraron resultados",
                "info": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros &nbsp",
                "infoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
                "infoFiltered": "(filtrado de un total de _MAX_ registros)",
                "sSearch": "Buscar:",
                "oPaginate": {
                    "sFirst": "Primero",
                    "sLast":"Último",
                    "sNext":"Siguiente",
                    "sPrevious": "Anterior"
			     },
			     "sProcessing":"Procesando...",
            },
            dom: 'Bfrtilp',       
        buttons:[ 
            {
                extend:    'excelHtml5',
                text:      '<i class="fa-sharp fa-solid fa-file-excel"></i>',
                titleAttr: 'Exportar a Excel',
                className: 'btn btn-success',
                messageTop :'Historial Cuenta <?php echo $details['name'].' '.$details['unoapellido'] ?>'
            },
            {
                extend:    'pdfHtml5',
                text:      '<i class="fa-sharp fa-solid fa-file-pdf"></i>',
                titleAttr: 'Exportar a PDF',
                className: 'btn btn-danger',
                messageTop :'Historial Cuenta <?php echo $details['name'].' '.$details['unoapellido'] ?>'
            },
            {
                extend:    'print',
                text:      '<i class="icon-print"></i> ',
                titleAttr: 'Imprimir',
                className: 'btn btn-info'
            },
        ]
			
		});
	$(".buttons-pdf").removeClass("dt-button");		
    $(".buttons-excel").removeClass("dt-button");     
    $(".buttons-print").removeClass("dt-button");     
    });*/
	function filtrar(){
        var tecnico=$("#tecnicos2 option:selected").val();
		var tipo=$("#tipo option:selected").val();
        var opcion_seleccionada=$("#fechas option:selected").val();
        var edate=$("#edate").val();
        var edatefin=$("#edatefin").val();
        var sdate=$("#sdate").val();
        var sdatefin=$("#sdatefin").val();
        if(tecnico=="" && tipo=="" && opcion_seleccionada==""){
            table.ajax.url( baseurl+'llamadas/com_list').load();     
        }else{
            //var tec=$("#tecnicos2 option:selected").data("id");
            table.ajax.url( baseurl+"llamadas/com_list?tecnico="+tecnico+"&tipo="+tipo+"&edate="+edate+"&edatefin="+edatefin+"&sdate="+sdate+"&sdatefin="+sdatefin+"&filtro_fecha="+opcion_seleccionada ).load();     
        }
       

    }
     function  filtrado_fechas(){
        var opcion_seleccionada=$("#fechas option:selected").val();
        if(opcion_seleccionada=="fcreada"){
            $("#div_fechas").show();
            $("#label_fechas").text("Fechas")
        }else{
            $("#div_fechas").hide();
        }
		 if(opcion_seleccionada=="fecha_final"){
            $("#div_fecha_final").show();
            $("#label_fecha_final").text("Fechas")
        }else{
            $("#div_fecha_final").hide();
        }
    }
	//export excel
	function redirect_to_export(){
       var tecnico=$("#tecnicos2 option:selected").val();
		var tipo=$("#tipo option:selected").val();
        var opcion_seleccionada=$("#fechas option:selected").val();
        var edate=$("#edate").val();
        var edatefin=$("#edatefin").val();
        var sdate=$("#sdate").val();
        var sdatefin=$("#sdatefin").val();
        var url_redirect=baseurl+"llamadas/explortar_acuerdos?tecnico="+tecnico+"&tipo="+tipo+"&edate="+edate+"&edatefin="+edatefin+"&sdate="+sdate+"&sdatefin="+sdatefin+"&filtro_fecha="+opcion_seleccionada;
            window.location.replace(url_redirect);

    }
	
</script>