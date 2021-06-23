<style>
.static {
  	position: sticky;
  	left: 0;
	width: 140px;
	background: white;
}
.staticdos {
  	position: sticky;
  	top: 0;
}
	th .static{
		background-color:#719FD0;
	}
	
.first-col {
  padding-left: 35px!important;
}
table {
  display: block;
  overflow-x: auto;
}
	th {
		background-color:#719FD0;
	}
	tr:nth-child(2n){
		background-color:aliceblue;
	}
	tr:nth-child(2n) .static{
		background-color:aliceblue;
	}
</style>
<?php $mes = date("Y-m-",strtotime($filter[2]));
	/*if ($filter[0]=="all")
	$tecnico = '';
	}else{
	$tecnico = 'asignado="'.$filter[0].'"';
	}*/?>
	
<div class="app-content content container-fluid">
    <div class="content-wrapper">
        <div class="content-header">
            <div class="card-header">
                <h4 class="card-title">Rendimiento Tecnico<a class="float-xs-right"
                                                                                               href="<?php echo base_url() ?>reports/refresh_data"><i
                                class="icon-refresh2"></i></a></h4>


            </div>
        </div>
        <div class="content-body"><!-- stats -->

            <!--/ stats -->
            <!--/ project charts -->
            <div class="row">
                <div class="col-xl-12 col-lg-12">
                    <div class="card">
                        <div class="card-header no-border">
                            <h6 class="card-title"><?php echo $this->lang->line('Sales in last 12 months') ?></h6>

                        </div>

                        <div class="card-body">


                            <div id="invoices-sales-chart"></div>

                        </div>

                    </div>
                </div>

            </div>
            <div class="row">
                <div class="col-xl-12 col-lg-12">
                    <div class="card">
                        <div class="card-header no-border">
                            <h6 class="card-title"><?php echo $this->lang->line('Products in last 12 months') ?></h6>

                        </div>

                        <div class="card-body">


                            <div id="invoices-products-chart"></div>

                        </div>

                    </div>
                </div>

            </div>
            <!--/ project charts -->
            <!-- Recent invoice with Statistics -->
            <div class="row match-height">

                <div class="col-xl-12 col-lg-12 ">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Estadisticas Detalladas <?php echo $filter[0]?></h4>
                            <a class="heading-elements-toggle"><i class="icon-ellipsis font-medium-3"></i></a>
                            <div class="heading-elements">
                                <ul class="list-inline mb-0">
                                    <li><a data-action="reload"><i class="icon-reload"></i></a></li>
                                    <li><a data-action="expand"><i class="icon-expand2"></i></a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="card-body">

                            <div class="table-responsive">
                                <table class="table table-hover mb-1">
                                    <thead>
										<tr>
										<th rowspan="2" width="140px" class="static">Tipor de orden</th>
										<th colspan="<?=$tipos['cuantos_dias_a_imprimir'] ?>" style="text-align: center">Dia</th>
										</tr>
									
                                    <tr>
                                        
                                        <?php for ($i=1;$i<=$tipos['cuantos_dias_a_imprimir'];$i++){
													echo '<th>'.$i.'</th>';}?>
                                        <th rowspan="2">TOTAL</th>
                                    </tr>
										
                                    </thead>
                                    <tbody>
										
										<tr>
											<td class="static">Ins. Tv+Int</td>
											<?php $conteo=0; foreach ($tipos['instalaciones_tv_e_internet'] as $row) {?>												
											<td class="first-col"><?php echo $row['numero'];$conteo+=$row['numero']; } ?></td>
											<td align="center"><?php echo $conteo; ?></td>
										</tr>
										<tr>
											<td class="static">Ins. Tv</td>
											<?php $conteo=0; foreach ($tipos['instalaciones_tv'] as $row) {?>												
											<td ><?php echo $row['numero'];$conteo+=$row['numero']; } ?></td>
											<td align="center"><?php echo $conteo; ?></td>
										</tr>
										<tr>
											<td class="static">Ins. Int</td>
											<?php $conteo=0; foreach ($tipos['instalaciones_internet'] as $row) {?>												
											<td ><?php echo $row['numero'];$conteo+=$row['numero']; } ?></td>
											<td align="center"><?php echo $conteo; ?></td>
										</tr>
										<tr>
											<td class="static">Agregar Tv</td>
											<?php $conteo=0; foreach ($tipos['instalaciones_Agregar_Tv'] as $row) {?>												
											<td ><?php echo $row['numero'];$conteo+=$row['numero']; } ?></td>
											<td align="center"><?php echo $conteo; ?></td>
										</tr>
										<tr>
											<td class="static">Agregar Int</td>
											<?php $conteo=0; foreach ($tipos['instalaciones_AgregarInternet'] as $row) {?>												
											<td ><?php echo $row['numero'];$conteo+=$row['numero']; } ?></td>
											<td align="center"><?php echo $conteo; ?></td>
										</tr>
										<tr>
											<td class="static">Traslado</td>
											<?php $conteo=0; foreach ($tipos['instalaciones_Traslado'] as $row) {?>												
											<td ><?php echo $row['numero'];$conteo+=$row['numero']; } ?></td>
											<td align="center"><?php echo $conteo; ?></td>
										</tr>
										<tr>
											<td class="static">Revision</td>
											<?php $conteo=0; foreach ($tipos['instalaciones_Revision'] as $row) {?>												
											<td ><?php echo $row['numero'];$conteo+=$row['numero']; } ?></td>
											<td align="center"><?php echo $conteo; ?></td>
										</tr>
										<tr>
											<td class="static">Recon. Tv</td>
											<?php $conteo=0; foreach ($tipos['instalaciones_Reconexion'] as $row) {?>												
											<td ><?php echo $row['numero'];$conteo+=$row['numero']; } ?></td>
											<td align="center"><?php echo $conteo; ?></td>
										</tr>
										<tr>
											<td class="static">Sus. Tv+Int</td>
											<?php $conteo=0; foreach ($tipos['instalaciones_Suspension_Combo'] as $row) {?>												
											<td ><?php echo $row['numero'];$conteo+=$row['numero']; } ?></td>
											<td align="center"><?php echo $conteo; ?></td>
										</tr>
										<tr>
											<td class="static">Sus. Int</td>
											<?php $conteo=0; foreach ($tipos['instalaciones_Suspension_Internet'] as $row) {?>												
											<td ><?php echo $row['numero'];$conteo+=$row['numero']; } ?></td>
											<td align="center"><?php echo $conteo; ?></td>
										</tr>
										<tr>
											<td class="static">Sus. Tv</td>
											<?php $conteo=0; foreach ($tipos['instalaciones_Suspension_Television'] as $row) {?>												
											<td ><?php echo $row['numero'];$conteo+=$row['numero']; } ?></td>
											<td align="center"><?php echo $conteo; ?></td>
										</tr>
										<tr>
											<td class="static">Corte Tv</td>
											<?php $conteo=0; foreach ($tipos['instalaciones_Corte_Television'] as $row) {?>												
											<td ><?php echo $row['numero'];$conteo+=$row['numero']; } ?></td>
											<td align="center"><?php echo $conteo; ?></td>
										</tr>
										<tr>
											<td class="static" style="background-color:#719FD0 ">TOTAL DIA</td>
											<?php $conteo=0; foreach ($tipos['total_dia'] as $row) {?>	
											<td style="background-color:#719FD0 "><?php echo $row['numero'];$conteo+=$row['numero']; } ?></td>
											<td align="center" style="background-color:#719FD0 "><?php echo $conteo; ?></td>
										</tr>
										<tr>
											<td class="static" style="background-color: cadetblue">PENDIENTES</td>
											<?php $conteo=0; foreach ($tipos['pendientes'] as $row) {?>	
											<td style="background-color: cadetblue"><?php echo $row['numero'];$conteo+=$row['numero']; } ?></td>
											<td align="center" style="background-color: cadetblue"><?php echo $conteo; ?></td>
										</tr>
                                    
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Recent invoice with Statistics -->


        </div>
    </div>
</div>

<script type="text/javascript">


    $('#invoices-sales-chart').empty();

    Morris.Bar({
        element: 'invoices-sales-chart',
        data: [
            <?php foreach ($stat as $row) {
            
            //$num = cal_days_in_month(CAL_GREGORIAN, $row['month'], $row['year']);
            echo "{ x: '" . $row['year'] . '-' . $row['month'] . "-01', y: " . intval($row['numero']) . "},";
            
        } ?>

        ],
        xkey: 'x',
        ykeys: ['y'],
        labels: ['Ordenes Resueltas'],
        hideHover: 'auto',
        resize: true,
        barColors: ['#34cea7', '#ff6e40'],
    });


    $('#invoices-products-chart').empty();

    Morris.Line({
        element: 'invoices-products-chart',
        data: [
            <?php foreach ($stat as $row) {
            
            //$num = cal_days_in_month(CAL_GREGORIAN, $row['month'], $row['year']);
            echo "{ x: '" . $row['year'] . '-' . $row['month'] . "-01', y: " . intval($row['numero']) . "},";
            
        } ?>

        ],
        xkey: 'x',
        ykeys: ['y'],
        labels: ['Ordenes Resueltas'],
        hideHover: 'auto',
        resize: true,
        lineColors: ['#34cea7', '#ff6e40'],
    });


</script>