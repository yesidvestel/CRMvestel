<style>
  /* Cambios sobre la propia tabla */
  table {
    border-collapse: collapse;
    border: 1px solid #5F5F5F;
	  width: 80%;
  }
  /* Espacio de relleno en celdas y cabeceras */
  td,
  th {
    padding: 10px;
  }
  /* Modificación de estilos en cabeceras */
  th {
    background: #555;
    color: #fff;
    text-transform: uppercase;
	  text-align: center;
	  font-size: 14px;
  }
  /* Modificación de estilos en celdas */
  td {   
    border-bottom: 2px solid #111;
    color: #333;
    font-size: 12px;
  }
	/* Modificación de estilos en celdas */
  . {
    text-align: left;
    border-bottom: 2px solid #111;
    color: #333;
    font-size: 12px;
  }
	.cen
	{
		text-align: left;
	}
	/* Modificación de estilos en pie de tabla */
  .pie {
    background:#E1E1E1;
    color: #000000;
    text-transform: uppercase;
	text-align: center;
	  font-size: 10px;
  }
.sub {
	color: #000000;
    text-transform: uppercase;
	text-align: center;
	  font-size: 10px;
	font-weight: bold;
  }
</style>
<article class="content">
    <div class="card card-block">
        <div id="notify" class="alert alert-success" style="display:none;">
            <a href="#" class="close" data-dismiss="alert">&times;</a>

            <div class="message"></div>
        </div>
		 <div class="card card-block">

        
            <h6><?php echo $this->lang->line('') ?>Estado de Caja</h6>
			 <hr>
            <p><?php echo $this->lang->line('') ?>Caja : <?php echo $filter[5] ?></p>
            <hr>
			 <div class="col-sm-6">
			<h6><?php echo $this->lang->line('') ?>Resumen Cobranza</h6>
				 
			<table class="party">
				<thead>
					<tr>
						<th>DESCRIPCION</th><th>CANT</th><th>MONTO</th>	
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>Excento</td><td style="text-align: center">500</td><td style="text-align: center">0</td>
					</tr>
					<tr>
						<td>Base</td><td style="text-align: center">0</td><td style="text-align: center">0</td>
					</tr>
					<tr>
						<td>iva</td><td style="text-align: center">0</td><td style="text-align: center">0</td>
					</tr>
					
				</tbody>
				<tfoot>
					<tr>
						<th class="pie">TOTAL COBRANZA</th>
						<th class="pie">0</th>
						<th class="pie">0</th>			
					</tr>
				</tfoot>
			</table>
			<hr>
			<h6><?php echo $this->lang->line('') ?>Resumen por Banco</h6>
			<table class="party">
				<thead>
					<tr>
						<th>DESCRIPCION</th>
						<th>CANT</th>
						<th>MONTO</th>			
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>Bancolombia</td>
						<td style="text-align: center">0</td>
						<td style="text-align: center">0</td>
					</tr>
					<tr>
						<td>BBVA colombia</td>
						<td style="text-align: center">0</td>
						<td style="text-align: center">0</td>
					</tr>					
				</tbody>
				<tfoot>
					<tr>
						<th class="pie">TOTAL COBRANZA</th>
						<th class="pie">0</th>
						<th class="pie"><?php echo amountFormat($income['monthinc']) ?></th>			
					</tr>
				</tfoot>
			</table>
			<hr>
			<h6><?php echo $this->lang->line('') ?>Resumen por Servicios</h6>
			<table class="party">
				<thead>
					<tr>
						<th>DESCRIPCION</th>
						<th>CANT</th>
						<th>MONTO</th>			
					</tr>
				</thead>
				<tbody>

					<?php 
					$var_cuenta_planes=array("1Mega"=>0,"2Megas"=>0,"3Megas"=>0,"5Megas"=>0,"10Megas"=>0,"Television"=>0); 
					foreach ($lista as $key => $value) { 
						$invoice = $this->db->get_where("invoices",array("tid"=>$value['tid']))->row(); 
					
						if($invoice->combo=="1Mega"){
						 		$var_cuenta_planes['1Mega']++;

						}else if($invoice->combo=="2Megas"){
								$var_cuenta_planes['2Megas']++;

						}else if($invoice->combo=="3Megas"){
								$var_cuenta_planes['3Megas']++;

						}else if($invoice->combo=="5Megas"){
								$var_cuenta_planes['5Megas']++;

						}else if($invoice->combo=="10Megas"){
								$var_cuenta_planes['10Megas']++;

						}else{
								$var_cuenta_planes['Television']++;
						}

					 } 
					 	
					 ?>
					<?php if($var_cuenta_planes['1Mega']!=0){  ?>
					<tr>
						<td>Internet 1MG</td>
						<td style="text-align: center"><?=$var_cuenta_planes['1Mega']?></td>
						<td style="text-align: center">0</td>
					</tr>
					<?php } ?>
					<?php if($var_cuenta_planes['2Megas']!=0){  ?>
					<tr>
						<td>Internet 2MG</td>
						<td style="text-align: center"><?=$var_cuenta_planes['2Megas']?></td>
						<td style="text-align: center">0</td>
					</tr>
					<?php } ?>
					<?php if($var_cuenta_planes['3Megas']!=0){  ?>
					<tr>
						<td>Internet 3MG</td>
						<td style="text-align: center"><?=$var_cuenta_planes['3Megas']?></td>
						<td style="text-align: center">0</td>
					</tr>
					<?php } ?>
					<?php if($var_cuenta_planes['5Megas']!=0){  ?>
					<tr>
						<td>Internet 5MG</td>
						<td style="text-align: center"><?=$var_cuenta_planes['5Megas']?></td>
						<td style="text-align: center">0</td>
					</tr>
					<?php } ?>
					<?php if($var_cuenta_planes['10Megas']!=0){  ?>
					<tr>
						<td>Internet 10MG</td>
						<td style="text-align: center"><?=$var_cuenta_planes['10Megas']?></td>
						<td style="text-align: center">0</td>
					</tr>
					<?php } ?>
					<?php if($var_cuenta_planes['Television']!=0){  ?>
					<tr>
						<td>Television</td>
						<td style="text-align: center"><?=$var_cuenta_planes['Television']?></td>
						<td style="text-align: center">0</td>
					</tr>
					<?php } ?>
					<tr>
						<th class="pie">TOTAL MENSUALIDADES</th>
						<th class="pie">0</th>
						<th class="pie"><?php echo amountFormat($income['monthinc']) ?></th>			
					</tr>
					<tr>
						<td class="sub">Total Ventas</td>
						<td class="sub">0</td>
						<td class="sub">0</td>
					</tr>
					<tr>
						<td class="sub">Total Reconexiones</td>
						<td class="sub">0</td>
						<td class="sub">0</td>
					</tr>
					<tr>
						<td class="sub">Total Materiales</td>
						<td class="sub">0</td>
						<td class="sub">0</td>
					</tr>
					<tr>
						<td class="sub">Total Otros</td>
						<td class="sub">0</td>
						<td class="sub">0</td>
					</tr>
				</tbody>
				<tfoot>
					<tr>
						<th class="pie">TOTAL</th>
						<th class="pie">0</th>
						<th class="pie"><?php echo amountFormat($income['monthinc']) ?></th>			
					</tr>
				</tfoot>
			</table>
			<hr>
			<h6><?php echo $this->lang->line('') ?>Resumen de cargos cobrados por meses</h6>
			<table class="party">
				<thead>
					<tr>
						<th>DESCRIPCION</th>
						<th>CANT</th>
						<th>MONTO</th>			
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>Octubre 2020</td>
						<td style="text-align: center">0</td>
						<td style="text-align: center">0</td>
					</tr>
					<tr>
						<td>Septiembre 2020</td>
						<td style="text-align: center">0</td>
						<td style="text-align: center">0</td>
					</tr>					
				</tbody>
				<tfoot>
					<tr>
						<th class="pie">TOTAL COBRANZA POR MESES</th>
						<th class="pie">0</th>
						<th class="pie"><?php echo amountFormat($income['monthinc']) ?></th>			
					</tr>
				</tfoot>
			</table>
        </div>
			 <div class="col-sm-6">            
			<h6><?php echo $this->lang->line('') ?>Resumen por Forma de pago</h6>
			<table class="party">
				<thead>
					<tr>
						<th>DESCRIPCION</th>
						<th>CANT</th>
						<th>MONTO</th>			
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>Efectivo</td>
						<td style="text-align: center">0</td>
						<td style="text-align: center">0</td>
					</tr>
					<tr>
						<td>Tarjeta Debito</td>
						<td style="text-align: center">0</td>
						<td style="text-align: center">0</td>
					</tr>
					<tr>
						<td>Tarjeta Credito</td>
						<td style="text-align: center">0</td>
						<td style="text-align: center">0</td>
					</tr>
					<tr>
						<td>Deposito</td>
						<td style="text-align: center">0</td>
						<td style="text-align: center">0</td>
					</tr>
					<tr>
						<td>Transferencia</td>
						<td style="text-align: center">0</td>
						<td style="text-align: center">0</td>
					</tr>
					<tr>
						<td>Cheque</td>
						<td style="text-align: center">0</td>
						<td style="text-align: center">0</td>
					</tr>
					<tr>
						<td>Retencion</td>
						<td style="text-align: center">0</td>
						<td style="text-align: center">0</td>
					</tr>
					<tr>
						<td>Domiciliacion Bancaria</td>
						<td style="text-align: center">0</td>
						<td style="text-align: center">0</td>
					</tr>
					
				</tbody>
				<tfoot>
					<tr>
						<th class="pie">TOTAL FORMA PAGO</th>
						<th class="pie">0</th>
						<th class="pie">0</th>			
					</tr>
				</tfoot>
			</table>
			<hr>
			<h6><?php echo $this->lang->line('') ?>Resumen Anulaciones</h6>
			<table class="party">
				<thead>
					<tr>
						<th>DESCRIPCION</th>
						<th>CANT</th>
						<th>MONTO</th>			
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>Cobranza efectiva</td>
						<td style="text-align: center">0</td>
						<td style="text-align: center">0</td>
					</tr>
					<tr>
						<td>Anulado de cierre</td>
						<td style="text-align: center">0</td>
						<td style="text-align: center">0</td>
					</tr>
					<tr>
						<td>Anulado de otros cierres</td>
						<td style="text-align: center">0</td>
						<td style="text-align: center">0</td>
					</tr>
					<tr>
						<td>Anulado de otros cierres</td>
						<td style="text-align: center">0</td>
						<td style="text-align: center">0</td>
					</tr>
					
				</tbody>
				<tfoot>
					<tr>
						<th class="pie">COBRADO - ANULADO DE OTRAS FECHAS</th>
						<th class="pie">0</th>
						<th class="pie">0</th>			
					</tr>
				</tfoot>
			</table>
			<hr>
			<h6><?php echo $this->lang->line('') ?>Resumen de cargos cobrados por meses</h6>
			<table class="party">
				<thead>
					<tr>
						<th>DESCRIPCION</th>
						<th>CANT</th>
						<th>MONTO</th>			
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>Octubre 2020</td>
						<td style="text-align: center">0</td>
						<td style="text-align: center"><?php echo amountFormat($income['monthinc']) ?></td>
					</tr>
					<tr>
						<td>Septiembre 2020</td>
						<td style="text-align: center">0</td>
						<td style="text-align: center">0</td>
					</tr>					
				</tbody>
				<tfoot>
					<tr>
						<th class="pie">TOTAL COBRANZA POR MESES</th>
						<th class="pie">0</th>
						<th class="pie"><?php echo amountFormat($income['monthinc']) ?></th>			
					</tr>
				</tfoot>
			</table>
			<hr>
			<h6><?php echo $this->lang->line('') ?>Resumen de cargos cobrados por meses TV</h6>
			<table class="party">
				<thead>
					<tr>
						<th>DESCRIPCION</th>
						<th>CANT</th>
						<th>MONTO</th>			
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>Octubre 2020</td>
						<td style="text-align: center">0</td>
						<td style="text-align: center">0</td>
					</tr>
					<tr>
						<td>Septiembre 2020</td>
						<td style="text-align: center">0</td>
						<td style="text-align: center">0</td>
					</tr>					
				</tbody>
				<tfoot>
					<tr>
						<th class="pie">TOTAL COBRANZA POR MESES</th>
						<th class="pie">0</th>
						<th class="pie"><?php echo amountFormat($income['monthinc']) ?></th>			
					</tr>
				</tfoot>
			</table>
			<hr>
			<h6><?php echo $this->lang->line('') ?>Resumen por tipo de servicio</h6>
			<table class="party">
				<thead>
					<tr>
						<th>DESCRIPCION</th>
						<th>CANT</th>
						<th>MONTO</th>			
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>Internet</td>
						<td style="text-align: center">0</td>
						<td style="text-align: center">0</td>
					</tr>
					<tr>
						<td>Television</td>
						<td style="text-align: center">0</td>
						<td style="text-align: center">0</td>
					</tr>					
				</tbody>
				<tfoot>
					<tr>
						<th class="pie">TOTAL TIPO DE SERVICIOS</th>
						<th class="pie">0</th>
						<th class="pie"><?php echo amountFormat($income['monthinc']) ?></th>			
					</tr>
				</tfoot>
			</table>
        </div>
		
    </div>
		
        <div class="grid_3 grid_4">
            

            


            <table class="table table-striped" cellspacing="0" width="100%">
                <thead>
                <tr>
                    <th><?php echo $this->lang->line('Date') ?></th>
                    <th><?php echo $this->lang->line('Description') ?></th>

                    <th><?php echo $this->lang->line('Debit') ?></th>
                    <th><?php echo $this->lang->line('Credit') ?></th>

                    <th><?php echo $this->lang->line('Balance') ?></th>


                </tr>
                </thead>
                <tbody id="entries">
                </tbody>

                <tfoot>
                <tr>
                    <th><?php echo $this->lang->line('Date') ?></th>
                    <th><?php echo $this->lang->line('Description') ?></th>

                    <th><?php echo $this->lang->line('Debit') ?></th>
                    <th><?php echo $this->lang->line('Credit') ?></th>

                    <th><?php echo $this->lang->line('Balance') ?></th>


                </tr>
                </tfoot>
            </table>
        </div>
    </div>
</article>
<script type="text/javascript">


    $(document).ready(function () {

        $('#entries').html('<td class="text-lg-center" colspan="5">Data loading...</td>');

        $.ajax({

            url: baseurl + 'reports/statements',
            type: 'POST',
            data: <?php echo "{'ac': '" . $filter[0] . "','sd':'" . $filter[2] . "','ed':'" . $filter[3] . "','ty':'" . $filter[1] . "'}"; ?>,
            dataType: 'html',
            success: function (data) {
                $('#entries').html(data);

            },
            error: function (data) {
                $('#response').html('Error')
            }

        });
    });
</script>
