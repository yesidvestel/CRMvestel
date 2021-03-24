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
                            </div>
							<div class="form-group row">
                                <label class="col-sm-2 col-form-label"
                                       for="pay_cat">Estado</label>

                                <div class="col-sm-6">
                                    <select name="trans_type" class="form-control" id="estados">
                                        <option value=''>Todas</option>
                                        <option value='Pendiente'>Pendiente</option>
                                        <option value='Resuelto'>Resuelto</option>
                                    </select>
                                </div>								
                            </div>
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
                           
							<div class="form-group row">
                                <label class="col-sm-3 col-form-label" for="pay_cat"></label>

                                <div class="col-sm-4">
                                    <input type="button" class="btn btn-primary btn-md" value="VER" onclick="filtrar()">


                                </div>
                            </div>
                        
                    </div>
            <hr>
            <table id="invoices" class="table-striped" cellspacing="0" width="100%">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Fecha</th>
                    <th>Hora</th>
                    <th>Realizado por</th>
                    <th>Tpo Llamada</th>
					<th>Tpo respuesta</th>
					<th>Detalle</th>					
					<th>Observacion</th>
                    <th class="no-sort"><?php echo $this->lang->line('Settings') ?></th>


                </tr>
                </thead>
                <tbody>
                </tbody>

                <tfoot>
                <tr>
                    <th>#</th>
                    <th>Fecha</th>
                    <th>Hora</th>
                    <th>Realizado por</th>
                    <th>Tpo Llamada</th>
					<th>Tpo respuesta</th>
					<th>Detalle</th>					
					<th>Observacion</th>
                    <th class="no-sort"><?php echo $this->lang->line('Settings') ?></th>

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
<script type="text/javascript">
    $(document).ready(function () {

        var table = $('#invoices').DataTable({
            "processing": true,
            "serverSide": true,
            "order": [],
            "ajax": {
                "url": "<?php echo site_url('llamadas/inv_list')?>",
                "type": "POST",
                //"data": {'cid':<?php echo $_GET['id'] ?> }
            },
            "columnDefs": [
                {
                    "targets": [0],
                    "orderable": false,
                },
            ],

        });

    });
	function filtrar(){
        var tecnico=$("#tecnicos2 option:selected").val();
        var opcion_seleccionada=$("#fechas option:selected").val();
        if(tecnico==""){
            tb.ajax.url( baseurl+'llamadas/inv_list' ).load();     
        }else{
            var id1=$("#tecnicos2 option:selected").data("id");
            tb.ajax.url( baseurl+"llamadas/inv_list?tecnico="+tecnico ).load();     
        }
       

    }
</script>