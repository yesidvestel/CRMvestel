<article class="content">
    <div class="card card-block">
        <div id="notify" class="alert alert-success" style="display:none;">
            <a href="#" class="close" data-dismiss="alert">&times;</a>

            <div class="message"></div>
        </div>
        <div class="grid_3 grid_4">
            <h6><?php echo $this->lang->line('') ?>Promociones</h6>
            <hr>
			

            <div class="row sameheight-container">
                <div class="col-md-6">
                    <div class="card card-block sameheight-item">

                        <form id="data_form" method="post" role="form">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label"
                                       for="pay_cat"><?php echo $this->lang->line('') ?>Tipo</label>

                                <div class="col-sm-9">
                                    <select name="detalle" class="form-control" id="detalle">
                                        <option value="-">-</option>
                                        <option value="ingresar">Ingresar</option>
                                        <option value="actualizar">Actualizar</option>
                                    </select>
                                </div>
                            </div>
							<div id="ocultar">
							<div class="form-group row" id="actualizar">
                                <label class="col-sm-3 col-form-label"
                                       for="pay_cat"><?php echo $this->lang->line('') ?>Promocion</label>
                                <div class="col-sm-9">
                                    <select name="nombre1" class="form-control" id="caja">
										<option value="0">-</option>
                                        <?php
                                        foreach ($promos as $row) {
                                            $cid = $row['idprom'];
                                            $acn = $row['pro_nombre'];
                                            echo "<option value='$cid'>$acn</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
							<div class="form-group row" id="ingresar">
                                <label class="col-sm-3 col-form-label"
                                       for="pay_cat"><?php echo $this->lang->line('') ?>Promocion</label>
                                <div class="col-sm-9">
									<input type="text" placeholder="Nombre campaña" name="nombre2" class="form-control"></input>
                                </div>
                            </div>
							</div>
							<div class="form-group row">
                                <label class="col-sm-3 col-form-label" for="pay_cat"><?php echo $this->lang->line('') ?>Fecha inicia</label>
								<div class="col-sm-9">
									<div class="input-group">
										<div class="input-group-addon">
											<span class="icon-calendar4" aria-hidden="true"></span>
										</div>
										<input type="text" class="form-control required" placeholder="Billing Date" name="finicial" data-toggle="datepicker">
									</div>
								</div>
							</div>
							<div class="form-group row">
                                <label class="col-sm-3 col-form-label" for="pay_cat"><?php echo $this->lang->line('') ?>Fecha Final</label>
								<div class="col-sm-9">
									<div class="input-group">
										<div class="input-group-addon">
											<span class="icon-calendar4" aria-hidden="true"></span>
										</div>
										<input type="text" class="form-control required" placeholder="Billing Date" name="ffinal" data-toggle="datepicker">
									</div>
								</div>
							</div>
							<div class="form-group row" id="actualizar">
                                <label class="col-sm-3 col-form-label"
                                       for="pay_cat"><?php echo $this->lang->line('') ?>Porcentaje</label>
                                <div class="col-sm-9">
									<input type="text" placeholder="Porcentaje de descuento" name="porcentaje" class="form-control"></input>
                                </div>
                            </div>
							<div class="form-group row" id="actualizar">
                                <label class="col-sm-3 col-form-label"
                                       for="pay_cat"><?php echo $this->lang->line('') ?>Colaborador</label>
                                <div class="col-sm-9">
									<select type="text" class="form-control"  id="colaborador" name="colaborador[]" multiple style="border: 0">
											 <?php
												foreach ($tecnicoslista as $row) {
													$cid = $row['id'];
													$title = $row['username'];
													$nombre = $row['name'];
													echo "<option value='$cid'>$nombre</option>";
												}
												?>
										</select>
                                </div>
                            </div>
                            
                            
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label" for="pay_cat"></label>

                                <div class="col-sm-4">
                                    <input type="hidden" value="settings/add_promo" id="action-url">
                                    <input  id="submit-data" type="submit" class="btn btn-primary btn-md" value="Actualizar">
                                </div>
                            </div>
							
                        </form>
                    </div>
                </div>

            </div>
			<table id="cgrtable" class="display" cellspacing="0" width="100%">
                <thead>
                <tr>
                    <th>#</th>
                    <th><?php echo $this->lang->line('') ?>Detalle</th>
                    <th><?php echo $this->lang->line('') ?>Fecha inicial</th>
                    <th><?php echo $this->lang->line('') ?>Fecha final</th>
                    <th><?php echo $this->lang->line('') ?>Descuento</th>


                </tr>
                </thead>
                <tbody>
                <?php $i = 1;
                foreach ($promos as $row) {
                    $cid = $row['pro_nombre'];
                    $fcha1 = $row['f_inicio'];
                    $fcha2 = $row['f_final'];
                    $porcentaje = $row['porcentaje'];

                    echo "<tr>
                    <td>$i</td>
                    <td>$cid</td>
                    <td>$fcha1</td>
                    <td>$fcha2</td>
                    <td>$porcentaje%</td>
					</tr>";
                    $i++;
                }
                ?>
                </tbody>
                <tfoot>
                <tr>
                    <th>#</th>
                    <th><?php echo $this->lang->line('') ?>Detalle</th>
                    <th><?php echo $this->lang->line('') ?>Fecha inicial</th>
                    <th><?php echo $this->lang->line('') ?>Fecha final</th>
                    <th><?php echo $this->lang->line('') ?>Descuento</th>
                </tr>
                </tfoot>
            </table>
        </div>
    </div>
</article>
<script type="text/javascript">
    $(document).ready(function () {

        //datatables
        $('#cgrtable').DataTable({});

    });
</script>
<script>

$(document).ready(function(){
		ocultar();
		$('#detalle').on('change',function(){
			ocultar();
		});
	});
	
	function ocultar(){
		var selectValor = '#'+$("#detalle option:selected").val();			
			$('#ocultar').children('div').hide();			
			$('#ocultar').children(selectValor).show();
	}


$("#colaborador").select2();
</script>
<?php //se hizo el cambio de fecha en el archivo views/fixed/footer ?>
<!--<script type="text/javascript">
        $('#cuentas_ option[value="4"]').remove();
        $('#cuentas_ option[value="5"]').remove();
        //
        
</script>
