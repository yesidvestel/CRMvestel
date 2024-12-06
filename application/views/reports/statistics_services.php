<style>
	
	table{
		font-family: "Lucida Sans Unicode", "Lucida Grande", Sans-Serif;
    	font-size: 12px;
		/*margin: 5px;*/
		width: 100%;
		text-align: left;
		border-collapse: collapse;
	}
	th {     
		font-size: 13px;     
		font-weight: normal;     
		padding: 8px;     
		background: #b9c9fe;
    	border-top: 4px solid #aabcfe;    
		border-bottom: 1px solid #fff; 
		border-right: 1px solid #fff; 
		color: #039;
		text-align: center;
	}
	td {    
		padding: 8px;     
		background: #e8edff;     
		border-bottom: 1px solid #fff;
		border-right: 1px solid #fff;
    	color: #669;    
		border-top: 1px solid transparent;
	}
	tr:hover td { 
		background: #d0dafd; 
		color: #339; 
	}
	tr:nth-child(odd){
		background-color: grey;
	}

</style> 
<div class="app-content content container-fluid">
 <div class="content-wrapper">
 <div class="content-body">


 <div class="row">
                <div class="col-xl-12 col-lg-12">
                    <div class="card">
                        <div class="card-header no-border">
                            <h4 style="text-align: center;" class="card-title">Usuarios por Estados <a class="float-xs-right" href="<?php echo base_url() ?>reports/refresh_data?tipo=estadisticas_servicios"><i
                                class="icon-refresh2"></i></a></h4>
                             <!-- Filtros -->
<div class="row">
    <div class="col-md-4">
        <label for="sede">Seleccione una Sede:</label>
        <select id="sede" class="form-control">
            <option value="">Todas las Sedes</option>
            <?php foreach ($sedes as $sede): ?>
                <option value="<?= $sede['id'] ?>"><?= $sede['title'] ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="col-md-4">
        <label for="start_date">Fecha Inicio:</label>
        <input type="date" id="start_date" class="form-control">
    </div>
    <div class="col-md-4">
        <label for="end_date">Fecha Fin:</label>
        <input type="date" id="end_date" class="form-control">
    </div>
</div>

<!-- Botón para filtrar -->
<button id="filter-btn" class="btn btn-primary mt-3">Filtrar</button>

<!-- Checkboxes para seleccionar datos -->
<!-- Checkboxes para seleccionar datos -->
<div class="mt-3">
    <label><input type="checkbox" class="data-checkbox" value="activos_internet"> Activos Internet</label>
    <label><input type="checkbox" class="data-checkbox" value="activos_television"> Activos Televisión</label>
    <label><input type="checkbox" class="data-checkbox" value="cortados_internet"> Cortados Internet</label>
    <label><input type="checkbox" class="data-checkbox" value="cortados_television"> Cortados Televisión</label>
    <label><input type="checkbox" class="data-checkbox" value="cartera_internet"> Cartera Internet</label>
    <label><input type="checkbox" class="data-checkbox" value="cartera_television"> Cartera Televisión</label>
    <label><input type="checkbox" class="data-checkbox" value="suspendidos_internet"> Suspendidos Internet</label>
    <label><input type="checkbox" class="data-checkbox" value="suspendidos_television"> Suspendidos Televisión</label>
    <label><input type="checkbox" class="data-checkbox" value="retirados_internet"> Retirados Internet</label>
    <label><input type="checkbox" class="data-checkbox" value="retirados_television"> Retirados Televisión</label>
</div>


<!-- Gráfico -->
<div id="statistics-chart" style="height: 250px;"></div>

                        </div>
						
                        
						
                    </div>
					<div class="card">
                        <div class="card-header no-border">
                            <h4 style="text-align: center;" class="card-title">Usuarios por Estados <a class="float-xs-right" href="<?php echo base_url() ?>reports/refresh_data?tipo=estadisticas_servicios"><i
                                class="icon-refresh2"></i></a></h4>
                             <div class="row">
                             	<?php 	$x1=$lista_estadisticas;?>
								 <?php foreach ($x1 as $key => $row) { 
									$datex = new DateTime($row['fecha']);?>	
				            	<div class="col-md-6 mb-1"><!-- ['y','z','a','b','c','d','e','f','g','h','i','j'] -->
							 	
							<table>
								<tr>
								<td><?PHP echo $datex->format("d-m-Y") ?></td>
								</tr>
								<tr>
								<th>Franquicia</th>	
								<th>Estado</th>	
								<th>Internet</th>	
								<th>Tv + Internet</th>	
								<th>Television</th>	
								<th>Total</th>	
								<th>Cartera</th>	
								</tr>
								<?PHP if($this->config->item('ctitle')=='VESTEL S.A.S'){ ?>
								<tr>
									<td rowspan="5">Yopal</td>	
									<td>Activo<?php echo $sede['id'] ?></td>	
									<td><?php echo $intsolo=$row['n_internet']-$row['internet_y_tv'] ?></td>	
									<td><?php echo $combo=$row['internet_y_tv'] ?></td>	
									<td><?php echo $tvsolo=$row['n_tv']-$row['internet_y_tv'] ?></td>	
									<td><?php echo $intsolo+$tvsolo+$combo ?></td>	
									<td><?php echo amountFormat($row['debido_activos']) ?></td>	
								</tr>
								<tr>	
									<td>Cortado</td>	
									<td><?php echo $intsolo2=$row['cor_int']-$row['internet_y_tv_cor'] ?></td>	
									<td><?php echo $combo2=$row['internet_y_tv_cor'] ?></td>	
									<td><?php echo $tvsolo2=$row['cor_tv']-$row['internet_y_tv_cor'] ?></td>	
									<td><?php echo $intsolo2+$tvsolo2+$combo2 ?></td>	
									<td><?php echo amountFormat($row['debido_cortados']) ?></td>	
								</tr>
								<tr>	
									<td>Cartera</td>	
									<td><?php echo $intsolo2=$row['car_int']-$row['internet_y_tv_car'] ?></td>	
									<td><?php echo $combo2=$row['internet_y_tv_car'] ?></td>	
									<td><?php echo $tvsolo2=$row['car_tv']-$row['internet_y_tv_car'] ?></td>	
									<td><?php echo $intsolo2+$tvsolo2+$combo2 ?></td>	
									<td><?php echo amountFormat($row['debido_cartera']) ?></td>	
								</tr>
								<tr>	
									<td>Suspendido</td>	
									<td><?php echo $intsolo2=$row['sus_int']-$row['internet_y_tv_sus'] ?></td>	
									<td><?php echo $combo2=$row['internet_y_tv_sus'] ?></td>	
									<td><?php echo $tvsolo2=$row['sus_tv']-$row['internet_y_tv_sus'] ?></td>	
									<td><?php echo $intsolo2+$tvsolo2+$combo2 ?></td>	
									<td><?php echo amountFormat($row['debido_suspendidos']) ?></td>
								</tr>
								<tr>	
									<td>Retirado</td>	
									<td><?php echo $intsolo2=$row['ret_int']-$row['internet_y_tv_ret'] ?></td>	
									<td><?php echo $combo2=$row['internet_y_tv_ret'] ?></td>	
									<td><?php echo $tvsolo2=$row['ret_tv']-$row['internet_y_tv_ret'] ?></td>	
									<td><?php echo $intsolo2+$tvsolo2+$combo2 ?></td>	
									<td><?php echo amountFormat($row['debido_retirados']) ?></td>
								</tr>
								<tr>
									<td rowspan="5">Monterrey</td>	
									<td>Activo</td>	
									<td><?php echo $intsolo=$row['n_internet_mon']-$row['internet_y_tv_act_mon'] ?></td>	
									<td><?php echo $combo=$row['internet_y_tv_act_mon'] ?></td>	
									<td><?php echo $tvsolo=$row['n_tv_mon']-$row['internet_y_tv_act_mon'] ?></td>	
									<td><?php echo $intsolo+$tvsolo+$combo ?></td>	
									<td><?php echo amountFormat($row['debido_act_mon']) ?></td>	
								</tr>
								<tr>	
									<td>Cortado</td>	
									<td><?php echo $intsolo2=$row['cor_int_mon']-$row['internet_y_tv_cor_mon'] ?></td>	
									<td><?php echo $combo2=$row['internet_y_tv_cor_mon'] ?></td>	
									<td><?php echo $tvsolo2=$row['cor_tv_mon']-$row['internet_y_tv_cor_mon'] ?></td>	
									<td><?php echo $intsolo2+$tvsolo2+$combo2 ?></td>	
									<td><?php echo amountFormat($row['debido_cor_mon']) ?></td>	
								</tr>
								<tr>	
									<td>Cartera</td>	
									<td><?php echo $intsolo2=$row['car_int_mon']-$row['internet_y_tv_car_mon'] ?></td>	
									<td><?php echo $combo2=$row['internet_y_tv_car_mon'] ?></td>	
									<td><?php echo $tvsolo2=$row['car_tv_mon']-$row['internet_y_tv_car_mon'] ?></td>	
									<td><?php echo $intsolo2+$tvsolo2+$combo2 ?></td>	
									<td><?php echo amountFormat($row['debido_car_mon']) ?></td>		
								</tr>
								<tr>	
									<td>Suspendido</td>	
									<td><?php echo $intsolo2=$row['sus_int_mon']-$row['internet_y_tv_sus_mon'] ?></td>	
									<td><?php echo $combo2=$row['internet_y_tv_sus_mon'] ?></td>	
									<td><?php echo $tvsolo2=$row['sus_tv_mon']-$row['internet_y_tv_sus_mon'] ?></td>	
									<td><?php echo $intsolo2+$tvsolo2+$combo2 ?></td>	
									<td><?php echo amountFormat($row['debido_sus_mon']) ?></td>	
								</tr>
								<tr>	
									<td>Retirado</td>	
									<td><?php echo $intsolo2=$row['ret_int_mon']-$row['internet_y_tv_ret_mon'] ?></td>	
									<td><?php echo $combo2=$row['internet_y_tv_ret_mon'] ?></td>	
									<td><?php echo $tvsolo2=$row['ret_tv_mon']-$row['internet_y_tv_ret_mon'] ?></td>	
									<td><?php echo $intsolo2+$tvsolo2+$combo2 ?></td>	
									<td><?php echo amountFormat($row['debido_ret_mon']) ?></td>	
								</tr>
								<tr>
									<td rowspan="5">Villanueva</td>	
									<td>Activo</td>	
									<td><?php echo $intsolo=$row['n_internet_vill']-$row['internet_y_tv_act_vill'] ?></td>	
									<td><?php echo $combo=$row['internet_y_tv_act_vill'] ?></td>	
									<td><?php echo $tvsolo=$row['n_tv_vill']-$row['internet_y_tv_act_vill'] ?></td>	
									<td><?php echo $intsolo+$tvsolo+$combo ?></td>	
									<td><?php echo amountFormat($row['debido_act_vill']) ?></td>
								</tr>
								<tr>	
									<td>Cortado</td>	
									<td><?php echo $intsolo2=$row['cor_int_vill']-$row['internet_y_tv_cor_vill'] ?></td>	
									<td><?php echo $combo2=$row['internet_y_tv_cor_vill'] ?></td>	
									<td><?php echo $tvsolo2=$row['cor_tv_vill']-$row['internet_y_tv_cor_vill'] ?></td>	
									<td><?php echo $intsolo2+$tvsolo2+$combo2 ?></td>	
									<td><?php echo amountFormat($row['debido_cor_vill']) ?></td>	
								</tr>
								<tr>	
									<td>Cartera</td>	
									<td><?php echo $intsolo2=$row['car_int_vill']-$row['internet_y_tv_car_vill'] ?></td>	
									<td><?php echo $combo2=$row['internet_y_tv_car_vill'] ?></td>	
									<td><?php echo $tvsolo2=$row['car_tv_vill']-$row['internet_y_tv_car_vill'] ?></td>	
									<td><?php echo $intsolo2+$tvsolo2+$combo2 ?></td>	
									<td><?php echo amountFormat($row['debido_car_vill']) ?></td>	
								</tr>
								<tr>	
									<td>Suspendido</td>	
									<td><?php echo $intsolo2=$row['sus_int_vill']-$row['internet_y_tv_sus_vill'] ?></td>	
									<td><?php echo $combo2=$row['internet_y_tv_sus_vill'] ?></td>	
									<td><?php echo $tvsolo2=$row['sus_tv_vill']-$row['internet_y_tv_sus_vill'] ?></td>	
									<td><?php echo $intsolo2+$tvsolo2+$combo2 ?></td>	
									<td><?php echo amountFormat($row['debido_sus_vill']) ?></td>
								</tr>
								<tr>	
									<td>Retirado</td>	
									<td><?php echo $intsolo2=$row['ret_int_vill']-$row['internet_y_tv_ret_vill'] ?></td>	
									<td><?php echo $combo2=$row['internet_y_tv_ret_vill'] ?></td>	
									<td><?php echo $tvsolo2=$row['ret_tv_vill']-$row['internet_y_tv_ret_vill'] ?></td>	
									<td><?php echo $intsolo2+$tvsolo2+$combo2 ?></td>	
									<td><?php echo amountFormat($row['debido_ret_vill']) ?></td>
								</tr>
								<?php } foreach ($grupos as $row2) { 
								$cod=$row2['id']; ?>
								
								<tr>
									<td rowspan="5"><?php echo $row2['title'] ?></td>	
									<td>Activo</td>	
									<td><?php echo $intsolo=$row['n_internet_'.$cod]-$row['internet_y_tv_act_'.$cod] ?></td>	
									<td><?php echo $combo=$row['internet_y_tv_act_'.$cod] ?></td>	
									<td><?php echo $tvsolo=$row['n_tv_'.$cod]-$row['internet_y_tv_act_'.$cod] ?></td>	
									<td><?php echo $intsolo+$tvsolo+$combo ?></td>	
									<td><?php echo amountFormat($row['debido_act_'.$cod]) ?></td>
								</tr>
								<tr>	
									<td>Cortado</td>	
									<td><?php echo $intsolo2=$row['cor_int_'.$cod]-$row['internet_y_tv_cor_'.$cod] ?></td>	
									<td><?php echo $combo2=$row['internet_y_tv_cor_'.$cod] ?></td>	
									<td><?php echo $tvsolo2=$row['cor_tv_'.$cod]-$row['internet_y_tv_cor_'.$cod] ?></td>	
									<td><?php echo $intsolo2+$tvsolo2+$combo2 ?></td>	
									<td><?php echo amountFormat($row['debido_cor_'.$cod]) ?></td>	
								</tr>
								<tr>	
									<td>Cartera</td>	
									<td><?php echo $intsolo2=$row['car_int_'.$cod]-$row['internet_y_tv_car_'.$cod] ?></td>	
									<td><?php echo $combo2=$row['internet_y_tv_car_'.$cod] ?></td>	
									<td><?php echo $tvsolo2=$row['car_tv_'.$cod]-$row['internet_y_tv_car_'.$cod] ?></td>	
									<td><?php echo $intsolo2+$tvsolo2+$combo2 ?></td>	
									<td><?php echo amountFormat($row['debido_car_'.$cod]) ?></td>	
								</tr>
								<tr>	
									<td>Suspendido</td>	
									<td><?php echo $intsolo2=$row['sus_int_'.$cod]-$row['internet_y_tv_sus_'.$cod] ?></td>	
									<td><?php echo $combo2=$row['internet_y_tv_sus_'.$cod] ?></td>	
									<td><?php echo $tvsolo2=$row['sus_tv_'.$cod]-$row['internet_y_tv_sus_'.$cod] ?></td>	
									<td><?php echo $intsolo2+$tvsolo2+$combo2 ?></td>	
									<td><?php echo amountFormat($row['debido_sus_'.$cod]) ?></td>
								</tr>
								<tr>	
									<td>Retirado</td>	
									<td><?php echo $intsolo2=$row['ret_int_'.$cod]-$row['internet_y_tv_ret_'.$cod] ?></td>	
									<td><?php echo $combo2=$row['internet_y_tv_ret_'.$cod] ?></td>	
									<td><?php echo $tvsolo2=$row['ret_tv_'.$cod]-$row['internet_y_tv_ret_'.$cod] ?></td>	
									<td><?php echo $intsolo2+$tvsolo2+$combo2 ?></td>	
									<td><?php echo amountFormat($row['debido_ret_'.$cod]) ?></td>
								</tr>
								<?php } ?>
								</table>
									
				            	</div>
								 <?php } ?>
				            </div>
                        </div>
                </div>
				
            </div>

       </div>
     </div>
			
   </div>

   <script type="text/javascript">
   $(document).ready(function () {
    // Renderizar gráfico inicial
    var data = <?= json_encode($statistics) ?>;
    var selectedKeys = [
        'activos_internet', 'activos_television', 'cortados_internet', 'cortados_television',
        'cartera_internet', 'cartera_television', 'suspendidos_internet', 'suspendidos_television',
        'retirados_internet', 'retirados_television'
    ];

    var colors = {
        'activos_internet': '#1D7A46',
        'activos_television': '#FF5733',
        'cortados_internet': '#FFC300',
        'cortados_television': '#DAF7A6',
        'cartera_internet': '#C70039',
        'cartera_television': '#900C3F',
        'suspendidos_internet': '#581845',
        'suspendidos_television': '#3498DB',
        'retirados_internet': '#8E44AD',
        'retirados_television': '#2ECC71'
    };

    renderChart(data, selectedKeys);

    // Filtrar datos
    $('#filter-btn').click(function () {
        var sede_id = $('#sede').val();
        var start_date = $('#start_date').val();
        var end_date = $('#end_date').val();

        $.post('<?= base_url('reports/filter') ?>', { sede_id, start_date, end_date }, function (response) {
            var data = JSON.parse(response);
            renderChart(data, selectedKeys);
        });
    });

    // Cambiar datos del gráfico según checkboxes
    $('.data-checkbox').change(function () {
        selectedKeys = $('.data-checkbox:checked').map(function () {
            return $(this).val();
        }).get();

        renderChart(data, selectedKeys);
    });

    // Función para renderizar el gráfico
    function renderChart(data, keys) {
        var chartData = data.map(function (item) {
            var result = { fecha: item.fecha }; // La fecha será el eje X
            keys.forEach(function (key) {
                result[key] = item[key] || 0; // Agregar los valores de las claves seleccionadas
            });
            return result;
        });

        var chartColors = keys.map(function (key) {
            return colors[key] || '#000000'; // Asignar el color según la clave, con negro como predeterminado
        });

        $('#statistics-chart').empty();
        Morris.Line({
            element: 'statistics-chart',
            data: chartData,
            xkey: 'fecha',
            ykeys: keys,
            labels: keys.map(function (key) { return key.replace('_', ' ').toUpperCase(); }),
            lineColors: chartColors,
            hideHover: 'auto',
            resize: true,
            xLabelAngle: 45
        });
    }
});





		
	

   </script>