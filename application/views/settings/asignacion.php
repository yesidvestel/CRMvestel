<article class="content">
    <div class="card card-block">
        <div id="notify" class="alert alert-success" style="display:none;">
            <a href="#" class="close" data-dismiss="alert">&times;</a>

            <div class="message"></div>
        </div>
        <div class="grid_3 grid_4">
            <h6><?php echo $this->lang->line('') ?>Estado de Caja</h6>
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
                                        <option value="encuesta">Encuesta</option>
                                        <option value="caja">Caja</option>
                                        <option value="titular">Titular</option>
                                    </select>


                                </div>

                            </div>
							<div id="ocultar">
							<div class="form-group row" id="caja">
                                <label class="col-sm-3 col-form-label"
                                       for="pay_cat"><?php echo $this->lang->line('') ?>Caja</label>

                                <div class="col-sm-9">
                                    <select name="caja" class="form-control" id="caja">
										<option value="0">-</option>
                                        <?php
                                        foreach ($accounts as $row) {
                                            $cid = $row['id'];
                                            $acn = $row['acn'];
                                            $holder = $row['holder'];
                                            echo "<option value='$cid'>$acn - $holder</option>";
                                        }
                                        ?>
                                    </select>


                                </div>

                            </div>
							<div class="form-group row" id="encuesta">
                                <label class="col-sm-3 col-form-label"
                                       for="pay_cat"><?php echo $this->lang->line('') ?>Sede</label>

                                <div class="col-sm-9">
                                    <select name="sedes" class="form-control" id="sede">
										<option value="">-</option>
                                         <?php
						
										foreach ($customergrouplist as $row) {
											$cid = $row['id'];
											$title = $row['title'];
											echo "<option value='$title'>$title</option>";
										}
										?>
                                    </select>


                                </div>

                            </div>
							</div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label"
                                       for="pay_cat"><?php echo $this->lang->line('') ?>Colaborador</label>

                                <div class="col-sm-9">
                                    <select name="colaborador" class="form-control">
                                         <?php
											foreach ($tecnicoslista as $row) {
												$cid = $row['id'];
												$title = $row['username'];
												$nombre = $row['name'];
												echo "<option value='$cid' data-id='$cid'>$nombre</option>";
											}
											?>
                                    </select>


                                </div>
                            </div>
                            
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label" for="pay_cat"></label>

                                <div class="col-sm-4">
                                    <input type="hidden" value="settings/add_asignar" id="action-url">
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
                    <th><?php echo $this->lang->line('') ?>Tipo</th>
                    <th><?php echo $this->lang->line('') ?>Colaborador</th>


                </tr>
                </thead>
                <tbody>
                <?php $i = 1;
                foreach ($asignaciones as $row) {
                    $cid = $row['idasig'];
                    $dtlle = $row['detalle'];
					if($row['detalle']!='caja'){
					$tpo = $row['tipo'];	
					}else{
					$tpo = $row['holder'];	
					}
                    $cdor = $row['username'];

                    echo "<tr>
                    <td>$i</td>
                    <td>$dtlle</td>
                    <td>$tpo</td>
                    <td>$cdor</td>
					</tr>";
                    $i++;
                }
                ?>
                </tbody>
                <tfoot>
                <tr>
                    <th>#</th>
                    <th><?php echo $this->lang->line('') ?>Detalle</th>
                    <th><?php echo $this->lang->line('') ?>Tipo</th>
                    <th><?php echo $this->lang->line('') ?>Colaborador</th>
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



</script>
<?php //se hizo el cambio de fecha en el archivo views/fixed/footer ?>
<!--<script type="text/javascript">
        $('#cuentas_ option[value="4"]').remove();
        $('#cuentas_ option[value="5"]').remove();
        //
        
</script>
