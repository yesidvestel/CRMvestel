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
                                       aria-expanded="false">Caja</a>
                                </li>
								<li class="nav-item">
                                    <a class="nav-link" id="detalle-tab" data-toggle="tab" href="#link"
                                       aria-controls="link"
                                       aria-expanded="false">Metodo</a>
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
                                               for="pay_cat">Caja</label>

                                        <div class="col-sm-6">
                                            <select name="tec" class="form-control" id="cuentas">
                                                <option value=''>Todos</option>
                                                <?php
                                                    foreach ($cta as $row) {
                                                        $cid = $row['id'];
                                                        $title = $row['holder'];
                                                        echo "<option value='$title' data-id='$cid'>$title</option>";
                                                    }
                                                    ?>
                                            </select>
                                        </div>
                                    </div>

                                </div>
                                <div class="tab-pane fade" id="link" role="tabpanel" aria-labelledby="link-tab" aria-expanded="false">
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label"
                                                   for="pay_cat">Metodo</label>

                                            <div class="col-sm-6">
                                                <select name="trans_type" class="form-control" id="metodo">
                                                    <option value=''>Todas</option>
                                                     <?php
														foreach ($meto2 as $row) {
															$cid = $row['id'];
															$title = $row['method'];
															echo "<option value='$title'>".$this->lang->line("$title")."</option>";
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
        <div class="grid_3 grid_4 table-responsive">
            <h5><?php echo $this->lang->line('Income Transactions') ?></h5>
			<a href="#" onclick="redirect_to_export()" class="btn btn-success btn-md">Exportar a Excel .XLSX</a>
            <hr>
            <table id="trans_table" class="display" cellspacing="0" width="100%">
                <thead>
                <tr>
                    <th><?php echo $this->lang->line('Date') ?></th>
                    <th><?php echo $this->lang->line('Account') ?></th>
                    <th><?php echo $this->lang->line('Debit') ?></th>
                    <th><?php echo $this->lang->line('Credit') ?></th>
                    <th><?php echo $this->lang->line('Payer') ?></th>
					<th>Nota</th>
                    <th><?php echo $this->lang->line('Method') ?></th>
					<th>Categoria</th>
					<th>Estado</th>
                    <th><?php echo $this->lang->line('Action') ?></th>


                </tr>
                </thead>
                <tbody>
                </tbody>

                <tfoot>
                <tr>
                    <th><?php echo $this->lang->line('Date') ?></th>
                    <th><?php echo $this->lang->line('Account') ?></th>
                    <th><?php echo $this->lang->line('Debit') ?></th>
                    <th><?php echo $this->lang->line('Credit') ?></th>
                    <th><?php echo $this->lang->line('Payer') ?></th>
					<th>Nota</th>
                    <th><?php echo $this->lang->line('Method') ?></th>
					<th>Categoria</th>
					<th>Estado</th>
                    <th><?php echo $this->lang->line('Action') ?></th>


                </tr>
                </tfoot>
            </table>
        </div>
    </div>
</article>
<script type="text/javascript">
var tb;
    $(document).ready(function () {
        tb=$('#trans_table').DataTable({
            "processing": true,
            "serverSide": true,
            "stateSave": true,
            "ajax": {
                "url": "<?php echo site_url('transactions/translist?type=income')?>",
                "type": "POST"
            },
            "columnDefs": [
                {
                    "targets": [0],
                    "orderable": true,
                },
            ],
        });
    });
	function redirect_to_export(){
        var cuentas =$("#cuentas option:selected").val();
		var metodo =$("#metodo option:selected").val();
        var sdate =$("#sdate").val();
        var edate =$("#edate").val();
		var opcion_seleccionada=$("#fechas option:selected").val();
        var url_redirect=baseurl+'transactions/explortar_a_excel2?sdate='+sdate+"&edate="+edate+"&opcselect="+opcion_seleccionada+"&cuentas="+cuentas+"&metodo="+metodo;
            window.location.replace(url_redirect);

    }
	function  filtrado_fechas(){
        var opcion_seleccionada=$("#fechas option:selected").val();
        if(opcion_seleccionada=="fcreada"){
            $("#div_fechas").show();
            $("#label_fechas").text("Fecha Creada");
        }
    }
	function filtrar(){
        var cuentas=$("#cuentas option:selected").val();
        var metodo =$("#metodo option:selected").val();
        var sdate =$("#sdate").val();
        var edate =$("#edate").val();
        var opcion_seleccionada=$("#fechas option:selected").val();
        var sede_filtrar=$("#sede_sel option:selected").val();
        if(cuentas=="" && metodo=="" && opcion_seleccionada==""){
            tb.ajax.url( baseurl+'transactions/translist?type=income').load();     
        }else{
            tb.ajax.url( baseurl+"transactions/translist?sdate="+sdate+"&edate="+edate+"&opcselect="+opcion_seleccionada+"&cuentas="+cuentas+"&metodo="+metodo+"&type=income" ).load();     
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
                <p><?php echo $this->lang->line('delete this transaction') ?></p>
            </div>
            <div class="modal-footer">
                <input type="hidden" id="object-id" value="">
                <input type="hidden" id="action-url" value="transactions/delete_i">
                <button type="button" data-dismiss="modal" class="btn btn-primary"
                        id="delete-confirm"><?php echo $this->lang->line('Delete') ?></button>
                <button type="button" data-dismiss="modal"
                        class="btn"><?php echo $this->lang->line('Cancel') ?></button>
            </div>
        </div>
    </div>
</div>