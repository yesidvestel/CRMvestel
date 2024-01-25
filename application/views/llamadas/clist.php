
<article class="content content items-list-page">
    <div class="card card-block">
        <div id="notify" class="alert alert-success" style="display:none;">
            <a href="#" class="close" data-dismiss="alert">&times;</a>

            <div class="message"></div>
        </div>
		<div class="col-sm-2">			
		 	<a href="#pop_model2" data-toggle="modal" onclick="funcion_status();" data-remote="false" class="btn btn- btn-green mb-1" title="Change Status"
			   ><i class="icon-mobile-phone"></i> NUEVO REGISTRO</a></div>
		
        <div class="grid_3 grid_4 table-responsive animated fadeInRight">
			
            <h5><?php echo $this->lang->line('Supplier')  ?></h5>
			
            <hr>
            <table id="clientstable" class="table-striped" cellspacing="0" width="100%">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Llamada #</th>
                    <th>Fecha</th>
                    <th>Hora</th>
                    <th>Realizado por</th>
                    <th>Tpo Llamada</th>
					<th>Tpo respuesta</th>
					<th>Detalle</th>					
					<th>Observacion</th>
					


                </tr>
                </thead>
                <tbody>
                </tbody>

                <tfoot>
                <tr>
                    <th>#</th>
                    <th>Llamada #</th>
                    <th>Fecha</th>
                    <th>Hora</th>
                    <th>Realizado por</th>
                    <th>Tpo Llamada</th>
					<th>Tpo respuesta</th>
					<th>Detalle</th>					
					<th>Observacion</th>


                </tr>
                </tfoot>
            </table>
			<div class="row">
				<table class="table table-striped">
					<thead>
					<tr>
						<th><?php echo $this->lang->line('Files') ?></th>
					</tr>
					</thead>
					<tbody id="activity">
					<?php foreach ($attach as $row) {

						echo '<tr><td><a data-url="' . base_url() . 'customers/file_handling?op=delete&name=' . $row['col1'] . '&type='.$row['type'].'&invoice=' . $_GET['id'] . '" class="aj_delete"><i class="btn-danger btn-lg icon-trash-a"></i></a> <a class="n_item" href="' . base_url() . 'userfiles/attach/' . $row['col1'] . '"> ' . $row['col1'] . ' </a></td></tr>';
					} ?>

					</tbody>
				</table>
					<!-- The fileinput-button span is used to style the file input field as button -->
					<span class="btn btn-success fileinput-button">
					<i class="glyphicon glyphicon-plus"></i>

						<!-- The file input field used as target for the file upload widget -->
					<input id="fileupload" type="file" name="files[]" multiple>
					</span>
					<br>
					<pre>tipos: gif, jpeg, png, docx, docs, txt, pdf, xls </pre>
					<br>
					<!-- The global progress bar -->
					<div id="progress" class="progress">
						<div class="progress-bar progress-bar-success"></div>
					</div>
					<!-- The container for the uploaded files -->
					<table id="files" class="files"></table>
					<br>
			</div>
        </div>
    </div>
</article>
<div id="pop_model2" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Nuevo Registro</h4>
            </div>

            <div class="modal-body">
                <form id="form_model2" name="formulario1">


                    <div class="form-group row">
                    <div class="frmSearch col-sm-6">
						<label for="cst" class="caption  col-form-label">Tipo de Atencion</label>
						<div>
							<select class="form-control required" name="tllamada" id="tipo" onchange="change(this.id,'respuesta')" required>
								<option value="">seleccione</option>
								<option value="Presencial">Presencial</option>
								<option value="whatsapp">Por whatsapp</option>
								<option value="Para Venta">Para Venta</option>
								<option value="Control de Calidad">Control de Calidad</option>
								<option value="Para Recuperacion">Para Recuperacion</option>
								<option value="Recibida">Llamada Recibida</option>
								<option value="Suspensión y Retiro">Suspensión y Retiro</option>
                           </select>
                        </div>
					</div>
					<div class="frmSearch col-sm-6">
						<label for="cst" class="caption  col-form-label">Tipo de respuesta</label>
						<div>
							<select class="form-control required" name="trespuesta" id="respuesta" onchange="change2(this.id,'detalle')" required>
								<option value="">seleccione</option>
                           </select>
                        </div>
					</div>
                    <div class="frmSearch col-sm-6">
						<label for="cst" class="caption  col-form-label ">Detalle de respuesta</label>
						<div>
							<select class="form-control required" name="drespuesta" id="detalle">
								<option value="">seleccione</option>
                           </select>
                        </div>
                         <div style="width: 100%;" class="selects-venta-contestada">
                        	<div style="width: 35%;float: left;position: relative;">
                        		<select class="form-control" id="add-tv">
	                           		<option value="">Sin Tv</option>
	                           		<option value="con-tv">Tv</option>
                           		</select>
                        	</div>
                        	<div style="width: 65%;float: right;position: relative;">
                        		<select class="form-control select-box"  id="add-net" style="width: 100%;">
                           		<option value="">Sin Internet</option>
                           		<?php
											foreach ($paquete as $row) {
												$cid = $row['pid'];
												$title = $row['product_name'];
												echo "<option value='$title'>$title</option>";
											}
											?>
                           		</select>
                        	</div>
                        </div>
					</div>
                    <div class="frmSearch col-sm-6">
						<label for="cst" class="caption  col-form-label">Responsable</label>
						<div>
							<input type="text" class="form-control" name="responsable" autocomplete="off" value="<?php echo $this->aauth->get_user()->username ?>" readonly></input>
                        </div>
					</div>
                    </div>
                    <div class="form-group row" style="margin-top: -20px;">
					<div class="frmSearch col-sm-6">
						<label for="cst" class="caption  col-form-label">Fecha</label>
						<div>
							<input type="text" class="form-control" name="fcha" autocomplete="off" value="<?php echo date("Y/m/d") ?>" readonly/>
                        </div>
					</div>
					<div class="frmSearch col-sm-6">
						<label for="cst" class="caption  col-form-label">Hora</label>
						<div>
							<input type="hidden" name="iduser" value="<?php echo $this->input->get('id') ?>"></input>
							<input type="text" class="form-control" name="hra" autocomplete="off" value="<?php echo date("g:i a") ?>" readonly/>                            
                        </div>
					</div>
					<div id="ocultar">
					<div class="frmSearch col-sm-6" id="Acuerdo">
						<label for="cst" class="caption  col-form-label">Fecha de vencimiento</label>
						<div>
							<input type="text" class="form-control" name="fchavence" autocomplete="off" value="<?php echo date("Y/m/d") ?>"/>
                        </div>
					</div>
					</div>
					<div class="frmSearch col-sm-12">
						<label for="cst" class="caption  col-form-label">Observacion</label>
						<div>
							<textarea class="form-control required" name="notes" rows="2" style="text-transform:lowercase"></textarea>
                        </div>
					</div>

                </div>
			
                        <button type="button" class="btn btn-default"
                                data-dismiss="modal">Volver</button>
                        <input type="hidden" id="action-url" value="llamadas/addllamada">
                        <button type="button" class="btn btn-primary"
                                id="submit_model2">Registrar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
	ocultar_selects_venta_contestada();
	function change(tipo, respuesta){
		tipo = document.getElementById(tipo);
		respuesta = document.getElementById(respuesta);
		respuesta.value = "";
		respuesta.innerHTML ="";
		if(tipo.value == "Para Venta"){			
			var optionArray = ["","Venta Contestada","sin Contestar"];
		}else if (tipo.value == "Control de Calidad"){
			var optionArray = ["","Control Contestado","sin Contestar"];
		}else if (tipo.value == "Presencial"){
			var optionArray = ["","Reclamo","Estado de cuenta","Actualizar Datos","Otros"];
		}else if (tipo.value == "whatsapp"){
			var optionArray = ["","Reclamo","Estado de cuenta","Actualizar Datos","Otros"];
		}else if (tipo.value == "Para Recuperacion"){
			var optionArray = ["","Recuperacion Contestada","sin Contestar","Mensaje"];
		}else if (tipo.value == "Recibida"){
			var optionArray = ["","Contestada","sin Contestar","Reclamo","Estado de cuenta", "Actualizar Datos","Otros"];
		}else if (tipo.value == "Suspensión y Retiro"){
			var optionArray = ["","Suspensión Temporal","Retiro Voluntario"];
		};
		ocultar_selects_venta_contestada();
	for(option = 0;option < optionArray.length; option++){
    var pair = optionArray[option].split("|");
    var newOption = document.createElement("option");
    newOption.value = pair[0];
    newOption.innerHTML = pair[0];
    respuesta.options.add(newOption);
  };
	}
	$("#add-net").select2();
	
	$(".select2-container .select2-selection--single").css("height",$("#add-tv").height());//.select2-container .select2-selection--single
	function ocultar_selects_venta_contestada(){
		$(".selects-venta-contestada").hide();
		$("#add-tv").val("");
		$("#add-net").val("").trigger('change');
	}
	
	$("#add-tv").change(function(ev){
		validacion1();
	});
	$("#add-net").change(function(ev){
		validacion1();
	});
	function validacion1(){
		var inp=$("#tipo option:selected").val();
		var res=$("#respuesta option:selected").val();
		if(inp=="Para Venta" && res=="Venta Contestada"){
		var valor_tv=$("#add-tv option:selected").val();
		var valor_net=$("#add-net option:selected").val();
		var option="";
		if(valor_tv=="con-tv"){
			if(valor_net!=""){
				var nombre="Tv+"+valor_net;
				option="<option value='"+nombre+"'>"+nombre+"</option>";
			}else{
				option="<option value='Tv'>Tv</option>";
			}
		}else if(valor_net!=""){
				option="<option value='"+valor_net+"'>"+valor_net+"</option>";
		}else{
				option="<option value=''>Selecciona opciones tv/net...</option>";
		}
		$("#detalle").children().remove();
			$("#detalle").append(option);
		}else{
			$("#detalle").children().remove();
		}
	}
	function change2(respuesta, detalle){
		respuesta = document.getElementById(respuesta);
		detalle = document.getElementById(detalle);
		detalle.value = "";
		detalle.innerHTML ="";
		var inp=$("#tipo option:selected").val();
		if(respuesta.value == "Venta Contestada" && inp=="Para Venta"){			
			//var optionArray = ["","Solo Tv","Tv + 5MB","Tv + 10MB","Tv + 15MB","10MB","15MB"];
			
			$("#detalle").children().remove();
			$("#detalle").append("<option value=''>Selecciona opciones tv/net...</option>");
			$(".selects-venta-contestada").show();
		}else {
			//$("#detalle").show();
			
			ocultar_selects_venta_contestada();
			$("#detalle").children().remove();
			if (respuesta.value == "Control Contestado"){
				var optionArray = ["","Excelente","Bueno","Regular","Malo"];
			}else if (respuesta.value == "Recuperacion Contestada"){
				var optionArray = ["","Acuerdo de Pago","Numero equivocado","Cliente inconforme","Informado","No va a pagar","Va a pagar"];
			}else if (respuesta.value == "Contestada"){
				var optionArray = ["","Acuerdo de pago","Cliente inconforme","Informado","No va a pagar","Va a pagar","Solicitud de descuento"];
			}else if (respuesta.value == "sin Contestar"){
				var optionArray = ["","Correo de Voz","Numero no esta en uso","Timbra pero no contestan"];
			}else if (respuesta.value == "Reclamo"){
				var optionArray = ["","Mal servicio","Mala atencion","Solicitud de descuento","Otros"];
			}else if (respuesta.value == "Estado de cuenta"){
				var optionArray = ["","Valor Incorrecto","No aparece pago","Otros"];
			}else if (respuesta.value == "Actualizar Datos"){
				var optionArray = ["","De cuenta","Personales","Direccion","Otros"];
			}else if (respuesta.value == "Otros"){
				var optionArray = ["","Otros"];
			}else if (respuesta.value == "Mensaje"){
				var optionArray = ["Mensaje de texto","Mensaje de Whatsapp","Otros"];
			}else if (respuesta.value == "Suspensión Temporal"){
				var optionArray = ["Suspensión por dos meses","Continua con el servicio","Llamada para activar"];
			}else if (respuesta.value == "Retiro Voluntario"){
				var optionArray = ["Mal servicio","Cobertura","Cambio Municipio","No lo necesita","Economía","Ya Tiene Otro Servicio","Continua con el servicio","Llamada para activar","Motivo personal"];
			}
			
		for(option = 0;option < optionArray.length; option++){
	    var pair = optionArray[option].split("|");
	    var newOption = document.createElement("option");
	    newOption.value = pair[0];
	    newOption.innerHTML = pair[0];
	    detalle.options.add(newOption);
	  };
	}
		
	}
    $(document).ready(function () {
        $('#clientstable').DataTable({
            'processing': true,
            'serverSide': true,
            'stateSave': true,
            'order': [],
            'ajax': {
                'url': "<?php echo site_url('llamadas/load_list')?>",
                'type': 'POST',
				'data': {'cid':<?php echo $_GET['id'] ?> }
				
            },
            'columnDefs': [
                {
                    'targets': [0],
                    'orderable': false,
                },
            ],
        });
    });
	
</script>
<script src="<?php echo base_url('assets/myjs/jquery.ui.widget.js') ?>"></script>
<!-- The basic File Upload plugin -->
<script src="<?php echo base_url('assets/myjs/jquery.fileupload.js') ?>"></script>
<script>
	
/*jslint unparam: true */
    /*global window, $ */
    $(function () {
        'use strict';
        // Change this to the location of your server-side upload handler:
        var url = '<?php echo base_url() ?>llamadas/file_handling?id=<?php echo $_GET['id'] ?>';
        $('#fileupload').fileupload({
            url: url,
            dataType: 'json',
            done: function (e, data) {
                $.each(data.result.files, function (index, file) {
                    $('#files').append('<tr><td><a data-url="<?php echo base_url() ?>llamadas/file_handling?op=delete&name=' + file.name + '&invoice=<?php echo $_GET['id'] ?>" class="aj_delete"><i class="btn-danger btn-sm icon-trash-a"></i> ' + file.name + ' </a></td></tr>');

                });
            },
            progressall: function (e, data) {
                var progress = parseInt(data.loaded / data.total * 100, 10);
                $('#progress .progress-bar').css(
                    'width',
                    progress + '%'
                );
            }
        }).prop('disabled', !$.support.fileInput)
            .parent().addClass($.support.fileInput ? undefined : 'disabled');
    });

    $(document).on('click', ".aj_delete", function (e) {
        e.preventDefault();

        var aurl = $(this).attr('data-url');
        var obj = $(this);

        jQuery.ajax({

            url: aurl,
            type: 'GET',
            dataType: 'json',
            success: function (data) {
                obj.closest('tr').remove();
                obj.remove();
            }
        });

    });
	$(document).ready(function(){
		ocultar();
		$('#detalle').on('change',function(){
			ocultar();
			
		});
	});
	
	function ocultar(){
		var selectValor = $("#detalle option:selected").val();			
		if(selectValor=="Acuerdo de Pago"){
			$('#ocultar').children('div').show();			
		}else{
			$('#ocultar').children('div').hide();			
		}
			
			
			
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