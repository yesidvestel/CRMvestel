<style>
.st-paid, .st-partial,.st-canceled,.st-rejected,.st-pending,.st-accepted,.st-Activo,.st-Stopped,.st-end, .st-Cortado, .st-Instalar, .st-Suspendido, .st-Exonerado
{
text-transform: lowercase;
    color:#000000;
    padding: 4px;
    border-radius: 5px;
    font-size: 10px;
}
.si-pendiente,.si-Preparado,.si-facturado
{
text-transform: lowercase;
    color:#FFFFFF;
    padding: 4px;
    border-radius: 5px;
    font-size: 10px;
}
.si-Pendiente
{
 background-color: #BCB72F;
}
.si-Preparado
{
 background-color: #34BD3B;
}
.si-Facturado
{
 background-color: #2DBCBA;
}
.st-paid,.st-accepted
{
 background-color: #5ed45e;
}
.st-pending,.st-Activo
{
 background-color:#D4BF30;
}
.st-canceled,.st-rejected,.st-end
{
 background-color: #F00;
}
.st-Cortado
{
 background-color: #C33;
}
.st-Instalar, .st-partial
{
 background-color:#E2ED30;
}
.st-Suspendido
{
 background-color: #C09;
}
.st-Exonerado
{
 background-color: #33F;
}
</style>

<article class="content">
    <div class="card card-block">
        <div id="notify" class="alert alert-success" style="display:none;">
            <a href="#" class="close" data-dismiss="alert">&times;</a>

            <div class="message"></div>
			
        </div>
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
                                    <a class="nav-link" id="link-tab" data-toggle="tab" href="#cuenta"
                                       aria-controls="cuenta"
                                       aria-expanded="false">Estado</a>
                                </li>
								<li class="nav-item">
                                    <a class="nav-link" id="detalle-tab" data-toggle="tab" href="#link"
                                       aria-controls="link"
                                       aria-expanded="false">Sede</a>
                                </li>
								<li class="nav-item">
                                    <a class="nav-link" id="detalle-tab" data-toggle="tab" href="#fac"
                                       aria-controls="fac"
                                       aria-expanded="false">Facturacion</a>
                                </li>
                            </ul>
                            <div class="tab-content px-1 pt-1">
								<!--thread-->
                                <div class="tab-pane fade active in" id="thread" role="tabpanel" aria-labelledby="thread-tab" aria-expanded="false">

                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label"
                                               for="pay_cat">Fechas</label>

                                        <div class="col-sm-6">
                                            <select name="trans_type" class="form-control " id="fechas" onchange="filtrado_fechas()">
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
                                <div role="tabpanel" class="tab-pane fade " id="cuenta" aria-labelledby="active-tab" aria-expanded="true">
                                    <div class="form-group row">
                                        
                                        <label class="col-sm-2 col-form-label"
                                               for="pay_cat">Estado factura</label>

                                        <div class="col-sm-6">
                                            <select name="tec" class="form-control" id="estado">
                                                <option value=''>Todos</option>
                                                <option value='due'>Debido</option>
                                                <option value='Paid'>Cancelado</option>
                                                <option value='partial'>Abonado</option>
                                                <option value='canceled'>Anulado</option>
                                                
                                            </select>
                                        </div>
                                    </div>

                                </div>
                                <div class="tab-pane fade" id="link" role="tabpanel" aria-labelledby="link-tab" aria-expanded="false">
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label"
                                                   for="pay_cat">Sede</label>

                                            <div class="col-sm-6">
                                                <select name="trans_type" class="form-control" id="sede">
                                                    <option value=''>Todas</option>
                                                     <?php
														foreach ($groups_list as $row) {
															$cid = $row['id'];
															$holder = $row['title'];
															echo "<option value='$holder'>$holder</option>";
														}
														?>
                                                </select>
                                            </div>                              
                                        </div>    
                                </div>
								<div role="tabpanel" class="tab-pane fade " id="fac" aria-labelledby="active-tab" aria-expanded="true">
                                    <div class="form-group row">
                                        
                                        <label class="col-sm-2 col-form-label"
                                               for="pay_cat">Estado facturacion</label>

                                        <div class="col-sm-6">
                                            <select name="siigo" class="form-control" id="siigo">
                                                <option value=''>Todos</option>
                                                <option value='null'>Pendiente</option>
                                                <option value='Crear Factura Electronica'>Preparado</option>
                                                <option value='Factura Electronica Creada'>Facturado</option>
                                                <option value='facint'>Fac Internet</option>
                                                <option value='factv'>Fac Television</option>
                                            </select>
                                        </div>
                                    </div>

                                </div>
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
        <div class="grid_3 grid_4 animated fadeInRight table-responsive">
            <h5><?php echo $this->lang->line('Invoices') ?></h5>

            <hr>
            <a href="#" onclick="redirect_to_export()" class="btn btn-success">Exportar a Excel .XLSX</a>
            <table id="invoices" class="table-striped" cellspacing="0" width="100%">
                <thead>
                <tr>
                    <th width="1%"><?php echo $this->lang->line('No') ?></th>
                    <th>F/ra #</th>
                    <th><?php echo $this->lang->line('Customer') ?></th>
					<th>Abonado</th>
					<th>Cedula</th>
                    <th>Vence</th>
                    <th><?php echo $this->lang->line('') ?>Estado</th>
                    <th><?php echo $this->lang->line('Total') ?></th>
                    <th class="no-sort"><?php echo $this->lang->line('') ?>Pago</th>
					<th><?php echo $this->lang->line('') ?>Siigo</th>
                    <th class="no-sort"><?php echo $this->lang->line('Settings') ?></th>
					<?php if ($this->aauth->get_user()->roleid > 4) { ?>
					<th><?php echo $this->lang->line('') ?>Eliminar</th>
					<?php } ?>

                </tr>
                </thead>
                <tbody>
                </tbody>

                <tfoot>
                <tr>
                    <th width="1%"><?php echo $this->lang->line('No') ?></th>
                    <th>F/ra #</th>
                    <th><?php echo $this->lang->line('Customer') ?></th>
					<th>Abonado</th>
					<th>Cedula</th>
                    <th>Vence</th>
                    <th><?php echo $this->lang->line('') ?>Estado</th>
                    <th><?php echo $this->lang->line('Total') ?></th>
                    <th class="no-sort"><?php echo $this->lang->line('') ?>Pago</th>
					<th><?php echo $this->lang->line('') ?>Siigo</th>
                    <th class="no-sort"><?php echo $this->lang->line('Settings') ?></th>
					<?php if ($this->aauth->get_user()->roleid > 3) { ?>
					<th><?php echo $this->lang->line('') ?>Eliminar</th>
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
                <h4 class="modal-title"><?php echo $this->lang->line('Delete Invoice') ?></h4>
            </div>
            <div class="modal-body">
                <p><?php echo $this->lang->line('delete this invoice') ?> ?</p>
            </div>
            <div class="modal-footer">
                <input type="hidden" id="object-id" value="">
                <input type="hidden" id="action-url" value="invoices/delete_i">
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
       tb=$('#invoices').DataTable({
            'processing': true,
            'serverSide': true,
            'stateSave': true,
            'order': [],
            'ajax': {
                'url': "<?php echo site_url('invoices/ajax_list')?>",
                'type': 'POST'
            },
            'columnDefs': [
                {
                    'targets': [0],
                    'orderable': false,
                },
            ],
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
    });
	function  filtrado_fechas(){
        var opcion_seleccionada=$("#fechas option:selected").val();
        if(opcion_seleccionada=="fcreada"){
            $("#div_fechas").show();
            $("#label_fechas").text("Fecha Creada");
        }
    }
	function filtrar(){
        var estado=$("#estado option:selected").val();
        var sede =$("#sede option:selected").val();
        var siigo =$("#siigo option:selected").val();
        var sdate =$("#sdate").val();
        var edate =$("#edate").val();
		var estfac = 1;
        var opcion_seleccionada=$("#fechas option:selected").val();
        var sede_filtrar=$("#sede_sel option:selected").val();
        if(estado=="" && sede=="" && siigo=="" && opcion_seleccionada==""){
            tb.ajax.url( baseurl+'invoices/ajax_list').load();     
        }else{
            tb.ajax.url( baseurl+"invoices/ajax_list?sdate="+sdate+"&edate="+edate+"&opcselect="+opcion_seleccionada+"&estado="+estado+"&sede="+sede+"&siigo="+siigo+"&estfac="+estfac).load();     
        }
       

    }
	function redirect_to_export(){
        var estado =$("#estado option:selected").val();
		var sede =$("#sede option:selected").val();
		var siigo =$("#siigo option:selected").val();
        var sdate =$("#sdate").val();
        var edate =$("#edate").val();
		var opcion_seleccionada=$("#fechas option:selected").val();
        var url_redirect=baseurl+'invoices/exportar_a_excel_inv?sdate='+sdate+"&edate="+edate+"&opcselect="+opcion_seleccionada+"&estado="+estado+"&sede="+sede+"&siigo="+siigo;
            window.location.replace(url_redirect);

    }
</script>