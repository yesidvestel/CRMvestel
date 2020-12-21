<article class="content">
    <div class="card card-block">
        <div id="notify" class="alert alert-success" style="display:none;">
            <a href="#" class="close" data-dismiss="alert">&times;</a>

            <div class="message"></div>
        </div>        
        <hr>
		<div class="col-sm-2">			
		 	<a href="#pop_model2" data-toggle="modal" onclick="funcion_status();" data-remote="false" class="btn btn- btn-green mb-1" title="Change Status"
                > ASIGNAR EQUIPO</a></div>
		<div class="col-sm-2">			
		 	<a href="#pop_model3" data-toggle="modal" onclick="funcion_status();" data-remote="false" class="btn btn- btn-blue mb-1" title="Change Status"
                > DEVOLVER EQUIPO</a></div>
        <div class="table-responsive">
			
            <table id="equipostable" class="display" cellspacing="0" width="100%">
                <thead>
                <tr>
                    <th>#</th>
					<th>Codigo</th>
                    <th>MAC</th>
                    <th>Serial</th>
                    <th>Estado</th>                    
					<th>Marca</th>                    
                </tr>
                </thead>
                <tbody>
                </tbody>

                <tfoot>
                <tr>
                    <th>#</th>
					<th>Codigo</th>
                    <th>MAC</th>
                    <th>Serial</th>
                    <th>Estado</th>                    
					<th>Marca</th>                    
                </tr>
                </tfoot>
            </table>
        </div>
    </div>
    <input type="hidden" id="dashurl" value="products/prd_stats">
</article>
<div id="pop_model2" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Asignar Equipo</h4>
            </div>

            <div class="modal-body">
                <form id="form_model2">


                    <div class="form-group row">
                    <div class="frmSearch">
						<label for="cst" class="caption col-sm-2 col-form-label">Burcar equipo</label>
                        <div class="col-sm-6">
							<input type="hidden" name="iduser" value="<?php echo $details['id'] ?>"></input>
							<input type="text" class="form-control" name="cst" id="equipo-box" placeholder="Ingrese mac del equipo" autocomplete="off"/>
                            <div id="equipo-box-result"></div>
                        </div>
                    </div>

                </div>
			<div id="customerpanel" class="form-group row">
                    <label for="toBizName"
                           class="caption col-sm-2 col-form-label">Equipo mac<span
                                style="color: red;">*</span></label>
                    <div class="col-sm-6"><input type="hidden" name="idequipo" id="customer_id" value="0">
                        <input type="text" class="form-control" name="mac" id="customer_name">
                    </div>
                </div>
                        <button type="button" class="btn btn-default"
                                data-dismiss="modal">Volver</button>
                        <input type="hidden" id="action-url" value="tickets/asig_equipo">
                        <button type="button" class="btn btn-primary"
                                id="submit_model2">Asignar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div id="pop_model3" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Devolucion de equipo</h4>
            </div>

            <div class="modal-body">
                <form id="form_model3">
				<div id="customerpanel" class="form-group row">
                    <label for="toBizName"
                           class="caption col-sm-2 col-form-label">Codigo equipo<span
                                style="color: red;">*</span></label>					
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="codigo" >
                    </div>
										
                </div>
				<div id="customerpanel" class="form-group row">
                    <label for="toBizName"
                           class="caption col-sm-2 col-form-label">Motivo<span
                                style="color: red;">*</span></label>
					<input type="hidden" name="iduser" value="<?php echo $details['id'] ?>"></input>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="nota">
                    </div>
										
                </div>
				<div id="customerpanel" class="form-group row">
                    <label for="toBizName"
                           class="caption col-sm-2 col-form-label">Estado<span
                                style="color: red;">*</span></label>					
                    <div class="col-sm-6">
                        <select name="estado" class="form-control">
							<option value="Bueno">Bueno</option>
							<option value="Malo">Malo</option>						
						</select>
                    </div>
										
                </div>
                        <button type="button" class="btn btn-default"
                                data-dismiss="modal">Volver</button>
                        <input type="hidden" id="action-url" value="customers/dev_equipo">
                        <button type="button" class="btn btn-primary"
                                id="submit_model3">Devolver</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">

    var table;

    $(document).ready(function () {

        //datatables
        table = $('#equipostable').DataTable({

            "processing": true, //Feature control the processing indicator.
            "serverSide": true, //Feature control DataTables' server-side processing mode.
            "order": [], //Initial no order.

            // Load data for the table's content from an Ajax source
            "ajax":  {
                'url': "<?php echo site_url('customers/equipolist')?>",				
                'type': 'POST',
                'data': {'cid':<?php echo $_GET['id'] ?> }
            },

            //Set column definition initialisation properties.
            "columnDefs": [
                {
                    "targets": [0], //first column / numbering column
                    "orderable": false, //set not orderable
                },
            ],
				"order": [[ 2, "desc" ]],
                "language": {
                    "info": "Pagina _PAGE_ de _PAGES_",
                    "zeroRecords": "No se encontraron resultados",
                    "processing": "Procesando...",
                    "lengthMenu": "Mostrar _MENU_ registros",
                    "search": "Buscar:",
                    "paginate": {
                        "first": "Primero",
                        "last": "Último",
                        "next": "Siguiente",
                        "previous": "Anterior"
                    },
                }

        });
        miniDash();
    });
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
                <p><?php echo $this->lang->line('delete this product') ?></p>
            </div>
            <div class="modal-footer">
                <input type="hidden" id="object-id" value="">
                <input type="hidden" id="action-url" value="products/delete_i">
                <button type="button" data-dismiss="modal" class="btn btn-primary"
                        id="delete-confirm"><?php echo $this->lang->line('Delete') ?></button>
                <button type="button" data-dismiss="modal"
                        class="btn"><?php echo $this->lang->line('Cancel') ?></button>
            </div>
        </div>
    </div>
</div>