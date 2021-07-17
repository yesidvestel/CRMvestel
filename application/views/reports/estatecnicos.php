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
                <h4 class="card-title">Rendimiento Tecnico<a class="float-xs-right" href="<?php echo base_url() ?>reports/refresh_data"><i
                                class="icon-refresh2"></i></a></h4><hr>
				<h6 class="card-title" style="text-align: center;">Grafico de Tickets realizados por meses</h6>
				<div class="col-xl-12 col-lg-12"><!-- ['y','z','a','b','c','d','e','f','g','h','i','j'] -->
								
					<input type="checkbox" id="instalacion_tv_int" style="cursor:pointer;" onclick="activar_desactivar_meses(null,'y');" class="case"><b style="cursor:pointer;" onclick="activar_desactivar_meses('instalacion_tv_int','y');" ><i>&nbsp;Instalaciones Tv + Internet&nbsp;</b></i>
					<input type="checkbox" id="inst_tv" style="cursor:pointer;" onclick="activar_desactivar_meses(null,'z');" class="case"><b style="cursor:pointer;" onclick="activar_desactivar_meses('inst_tv','z');"><i>&nbsp;Instalaciones Tv&nbsp;</b></i>
					<input type="checkbox" id="inst_internet" style="cursor:pointer;" onclick="activar_desactivar_meses(null,'a');" class="case"><b style="cursor:pointer;" onclick="activar_desactivar_meses('inst_internet','a');"><i>&nbsp;instalaciones Internet&nbsp;</b></i>
					<input type="checkbox" id="Agregar_Tv" style="cursor:pointer;" onclick="activar_desactivar_meses(null,'b');" class="case"><b style="cursor:pointer;" onclick="activar_desactivar_meses('Agregar_Tv','b');"><i>&nbsp;Agregar Tv&nbsp;</b></i>
					<input type="checkbox" id="AgregarInternet" style="cursor:pointer;" onclick="activar_desactivar_meses(null,'c');" class="case"><b style="cursor:pointer;" onclick="activar_desactivar_meses('AgregarInternet','c');"><i>&nbsp;Agregar Internet&nbsp;</b></i>
					<input type="checkbox" id="Traslado" style="cursor:pointer;" onclick="activar_desactivar_meses(null,'d');" class="case"><b style="cursor:pointer;" onclick="activar_desactivar_meses('Traslado','d');"><i>&nbsp;Traslado&nbsp;</b></i>
					<input type="checkbox" id="Revision" style="cursor:pointer;" onclick="activar_desactivar_meses(null,'e');" class="case"><b style="cursor:pointer;" onclick="activar_desactivar_meses('Revision','e');"><i>&nbsp;Revision&nbsp;</b></i>
					<input type="checkbox" id="Reconexion" style="cursor:pointer;" onclick="activar_desactivar_meses(null,'f');" class="case"><b style="cursor:pointer;" onclick="activar_desactivar_meses('Reconexion','f');"><i>&nbsp;Reconexion&nbsp;</b></i>
					<input type="checkbox" id="Suspension_Combo" style="cursor:pointer;" onclick="activar_desactivar_meses(null,'g');" class="case"><b style="cursor:pointer;" onclick="activar_desactivar_meses('Suspension_Combo','g');"><i>&nbsp;Suspension Combo&nbsp;</b></i>
					<input type="checkbox" id="Suspension_Internet" style="cursor:pointer;" onclick="activar_desactivar_meses(null,'h');" class="case"><b style="cursor:pointer;" onclick="activar_desactivar_meses('Suspension_Internet','h');"><i>&nbsp;Suspension Internet&nbsp;</b></i>
					<input type="checkbox" id="Suspension_Television" style="cursor:pointer;" onclick="activar_desactivar_meses(null,'i');" class="case"><b style="cursor:pointer;" onclick="activar_desactivar_meses('Suspension_Television','i');"><i>&nbsp;Suspension Television&nbsp;</b></i> 
					<input type="checkbox" id="Corte_Television" style="cursor:pointer;" onclick="activar_desactivar_meses(null,'j');" class="case"><b style="cursor:pointer;" onclick="activar_desactivar_meses('Corte_Television','j');"><i>&nbsp;Cortes Television&nbsp;</b></i>
				</div>
            </div>
        </div>
        <div class="content-body"><!-- stats -->

            <!--/ stats -->
            <!--/ project charts -->
            <div class="row">
                <div class="col-xl-12 col-lg-12">
                    <div class="card">
                        <div class="card-header no-border">
                            

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
                            <h6 style="text-align: center;" class="card-title">Grafico de Tickets realizados por días</h6>
                             <div class="row">
				            	<div class="col-xl-12 col-lg-12"><!-- ['y','z','a','b','c','d','e','f','g','h','i','j'] -->
								
				            	<input type="checkbox" id="instalaciones_tv_e_internet" style="cursor:pointer;" onclick="activar_desactivar_lines(null,'y');" class="case"><b style="cursor:pointer;" onclick="activar_desactivar_lines('instalaciones_tv_e_internet','y');" ><i>&nbsp;Instalaciones Tv + Internet&nbsp;</b></i>
					<input type="checkbox" id="instalaciones_tv" style="cursor:pointer;" onclick="activar_desactivar_lines(null,'z');" class="case"><b style="cursor:pointer;" onclick="activar_desactivar_lines('instalaciones_tv','z');"><i>&nbsp;Instalaciones Tv&nbsp;</b></i>
					<input type="checkbox" id="instalaciones_internet" style="cursor:pointer;" onclick="activar_desactivar_lines(null,'a');" class="case"><b style="cursor:pointer;" onclick="activar_desactivar_lines('instalaciones_internet','a');"><i>&nbsp;instalaciones Internet&nbsp;</b></i>
					<input type="checkbox" id="instalaciones_Agregar_Tv" style="cursor:pointer;" onclick="activar_desactivar_lines(null,'b');" class="case"><b style="cursor:pointer;" onclick="activar_desactivar_lines('instalaciones_Agregar_Tv','b');"><i>&nbsp;Agregar Tv&nbsp;</b></i>
					<input type="checkbox" id="instalaciones_AgregarInternet" style="cursor:pointer;" onclick="activar_desactivar_lines(null,'c');" class="case"><b style="cursor:pointer;" onclick="activar_desactivar_lines('instalaciones_AgregarInternet','c');"><i>&nbsp;Agregar Internet&nbsp;</b></i>
					<input type="checkbox" id="instalaciones_Traslado" style="cursor:pointer;" onclick="activar_desactivar_lines(null,'d');" class="case"><b style="cursor:pointer;" onclick="activar_desactivar_lines('instalaciones_Traslado','d');"><i>&nbsp;Traslado&nbsp;</b></i>
					<input type="checkbox" id="instalaciones_Revision" style="cursor:pointer;" onclick="activar_desactivar_lines(null,'e');" class="case"><b style="cursor:pointer;" onclick="activar_desactivar_lines('instalaciones_Revision','e');"><i>&nbsp;Revision&nbsp;</b></i>
					<input type="checkbox" id="instalaciones_Reconexion" style="cursor:pointer;" onclick="activar_desactivar_lines(null,'f');" class="case"><b style="cursor:pointer;" onclick="activar_desactivar_lines('instalaciones_Reconexion','f');"><i>&nbsp;Reconexion&nbsp;</b></i>
					<input type="checkbox" id="instalaciones_Suspension_Combo" style="cursor:pointer;" onclick="activar_desactivar_lines(null,'g');" class="case"><b style="cursor:pointer;" onclick="activar_desactivar_lines('instalaciones_Suspension_Combo','g');"><i>&nbsp;Suspension Combo&nbsp;</b></i>
					<input type="checkbox" id="instalaciones_Suspension_Internet" style="cursor:pointer;" onclick="activar_desactivar_lines(null,'h');" class="case"><b style="cursor:pointer;" onclick="activar_desactivar_lines('instalaciones_Suspension_Internet','h');"><i>&nbsp;Suspension Internet&nbsp;</b></i>
					<input type="checkbox" id="instalaciones_Suspension_Television" style="cursor:pointer;" onclick="activar_desactivar_lines(null,'i');" class="case"><b style="cursor:pointer;" onclick="activar_desactivar_lines('instalaciones_Suspension_Television','i');"><i>&nbsp;Suspension Television&nbsp;</b></i> 
					<input type="checkbox" id="instalaciones_Corte_Television" style="cursor:pointer;" onclick="activar_desactivar_lines(null,'j');" class="case"><b style="cursor:pointer;" onclick="activar_desactivar_lines('instalaciones_Corte_Television','j');"><i>&nbsp;Cortes Television&nbsp;</b></i>
								 </div>
				            </div>
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
	var lista_keysdos=[];
	var lista_labels_totaldos={y:'Instalaciones Tv + Internet',z:"Instalaciones Tv",a:"Instalaciones Internet",b:"Agregar Tv",c:"Agregar Internet",d:"Traslado",e:"Revision",f:"Reconexion",g:"Suspension Combo",h:"Suspension Internet",i:"Suspension Television",j:"Corte Television"};
    var lista_labels_personalizadados=[];
    $('#invoices-sales-chart').empty();
    var datosdos={
        element: 'invoices-sales-chart',
        data: [
            <?php foreach ($stat['instalaciones_tv_e_internet'] as $key => $row) {
            $datex = new DateTime($row['year']."-".$row['month']."-01");
            //$num = cal_days_in_month(CAL_GREGORIAN, $row['month'], $row['year']);
            echo "{ x: '".($datex->format("Y-m-t"))."', y: ". intval($row['numero']) .",z: " . intval($stat['instalaciones_tv'][$key]['numero']) . ",a: " . intval($stat['instalaciones_internet'][$key]['numero']) . ",b: " . intval($stat['instalaciones_Agregar_Tv'][$key]['numero']) .",c:" . intval($stat['instalaciones_AgregarInternet'][$key]['numero']) . ",d: " . intval($stat['instalaciones_Traslado'][$key]['numero']) . ",e: " . intval($stat['instalaciones_Revision'][$key]['numero']) . ",f: " . intval($stat['instalaciones_Reconexion'][$key]['numero']) . ",g: " . intval($stat['instalaciones_Suspension_Combo'][$key]['numero']) . ",h: " . intval($stat['instalaciones_Suspension_Internet'][$key]['numero']) . ",i: " . intval($stat['instalaciones_Suspension_Television'][$key]['numero']) . ",j: " . intval($stat['instalaciones_Corte_Television'][$key]['numero']) . "},";
            
        } ?>

        ],
        xkey: 'x',
        ykeys: [],
        labels: [],
        hideHover: 'auto',
        resize: true,
        barColors: ['#34cea7', '#ff6e40','#9A7D0A','#FFA633', '#FF7933','#FF3333','#33FFB8', '#33D3FF','#338AFF','#8033FF', '#C933FF','#FF33DA'],
    }
	Morris.Bar(datosdos);
	function activar_desactivar_meses(ck2,key){
		if(ck2!=null){
			
			if($("#"+ck2).prop("checked")){
				$("#"+ck2).prop("checked",false);
			}else{
				$("#"+ck2).prop("checked",true);
			}
		}
		var indice_elemento2=lista_keysdos.indexOf(key);
		if(indice_elemento2==-1){
			lista_keysdos.push(key);
		}else{
			lista_keysdos.splice(indice_elemento2,1);
		}

		//console.log(lista_labels_total.a);
		lista_labels_personalizadados=[];	
		$(lista_keysdos).each(function(index,dato){
			lista_labels_personalizadados.push(lista_labels_totaldos[dato]);
		});
		

		//console.log(lista_keys);
		datosdos.ykeys=lista_keysdos;
		datosdos.labels=lista_labels_personalizadados;
		$('#invoices-sales-chart').empty();
		Morris.Bar(datosdos);

		
	}
    var lista_keys=[];
    var lista_labels_total={y:'Instalaciones Tv + Internet',z:"Instalaciones Tv",a:"Instalaciones Internet",b:"Agregar Tv",c:"Agregar Internet",d:"Traslado",e:"Revision",f:"Reconexion",g:"Suspension Combo",h:"Suspension Internet",i:"Suspension Television",j:"Corte Television"};
    var lista_labels_personalizada=[];
    $('#invoices-products-chart').empty();
	var datos={
        element: 'invoices-products-chart',
        data: [
            <?php foreach ($tipos['instalaciones_tv_e_internet'] as $key => $row) {
            $datex = new DateTime($row['fecha1']);
            //$num = cal_days_in_month(CAL_GREGORIAN, $row['month'], $row['year']);
            echo "{ x: '".($datex->format("Y-m-d"))."', y: " . intval($row['numero']) . ",z: " . intval($tipos['instalaciones_tv'][$key]['numero']) . ",a: " . intval($tipos['instalaciones_internet'][$key]['numero']) . ",b: " . intval($tipos['instalaciones_Agregar_Tv'][$key]['numero']) . ",c: " . intval($tipos['instalaciones_AgregarInternet'][$key]['numero']) . ",d: " . intval($tipos['instalaciones_Traslado'][$key]['numero']) . ",e: " . intval($tipos['instalaciones_Revision'][$key]['numero']) . ",f: " . intval($tipos['instalaciones_Reconexion'][$key]['numero']) . ",g: " . intval($tipos['instalaciones_Suspension_Combo'][$key]['numero']) . ",h: " . intval($tipos['instalaciones_Suspension_Internet'][$key]['numero']) . ",i: " . intval($tipos['instalaciones_Suspension_Television'][$key]['numero']) . ",j: " . intval($tipos['instalaciones_Corte_Television'][$key]['numero']) . "},";//,z: " . intval($tipos['instalaciones_tv'][$key]['numero']) . "
            
        } ?>

        ],
        xkey: 'x',
        ykeys: [],
        labels: [],
        hideHover: 'auto',
        resize: true,
        lineColors: ['#34cea7', '#ff6e40','#9A7D0A','#FFA633', '#FF7933','#FF3333','#33FFB8', '#33D3FF','#338AFF','#8033FF', '#C933FF','#FF33DA'],
    }
    Morris.Line(datos);
	function activar_desactivar_lines(ck,key){
		if(ck!=null){
			
			if($("#"+ck).prop("checked")){
				$("#"+ck).prop("checked",false);
			}else{
				$("#"+ck).prop("checked",true);
			}
		}
		var indice_elemento=lista_keys.indexOf(key);
		if(indice_elemento==-1){
			lista_keys.push(key);
		}else{
			lista_keys.splice(indice_elemento,1);
		}

		//console.log(lista_labels_total.a);
		lista_labels_personalizada=[];	
		$(lista_keys).each(function(index,dato){
			lista_labels_personalizada.push(lista_labels_total[dato]);
		});
		

		//console.log(lista_keys);
		datos.ykeys=lista_keys;
		datos.labels=lista_labels_personalizada;
		$('#invoices-products-chart').empty();
		Morris.Line(datos);

		
	}
	
	

</script>