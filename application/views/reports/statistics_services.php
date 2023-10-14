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
                             <div class="row">
				            	<div class="col-xl-12 col-lg-12"><!-- ['y','z','a','b','c','d','e','f','g','h','i','j'] -->
								
				            	</div>
				            </div>
                        </div>
						
                        <div class="card-body">
                            <div id="invoices-products-chart">
                            </div>
							<div class="card-header no-border"><!-- ['y','z','a','b','c','d','e','f','g','h','i','j'] -->
								<h4 style="text-align: center;" class="card-title">Ocultar estados</h4>	
									<input type="checkbox" id="n_internet" style="cursor:pointer;" onclick="activar_desactivar_lines(null,'z');" class="case"><b style="cursor:pointer;" onclick="activar_desactivar_lines('n_internet','z');" ><i>&nbsp;Activos Internet&nbsp;</b></i>
									<input type="checkbox" id="n_tv" style="cursor:pointer;" onclick="activar_desactivar_lines(null,'a');" class="case"><b style="cursor:pointer;" onclick="activar_desactivar_lines('n_tv','a');"><i>&nbsp;Activos Television&nbsp;</b></i>
									<input type="checkbox" id="cor_int" style="cursor:pointer;" onclick="activar_desactivar_lines(null,'b');" class="case"><b style="cursor:pointer;" onclick="activar_desactivar_lines('cor_int','b');"><i>&nbsp;Cortados Internet&nbsp;</b></i>
									<input type="checkbox" id="cor_tv" style="cursor:pointer;" onclick="activar_desactivar_lines(null,'c');" class="case"><b style="cursor:pointer;" onclick="activar_desactivar_lines('cor_tv','c');"><i>&nbsp;Corte Television&nbsp;</b></i>
									<input type="checkbox" id="car_int" style="cursor:pointer;" onclick="activar_desactivar_lines(null,'d');" class="case"><b style="cursor:pointer;" onclick="activar_desactivar_lines('cor_tv','d');"><i>&nbsp;Cartera Internet&nbsp;</b></i>
									<input type="checkbox" id="car_tv" style="cursor:pointer;" onclick="activar_desactivar_lines(null,'e');" class="case"><b style="cursor:pointer;" onclick="activar_desactivar_lines('cor_tv','e');"><i>&nbsp;Cartera Television&nbsp;</b></i>
									<input type="checkbox" id="sus_int" style="cursor:pointer;" onclick="activar_desactivar_lines(null,'f');" class="case"><b style="cursor:pointer;" onclick="activar_desactivar_lines('sus_int','f');"><i>&nbsp;Suspensiones Internet&nbsp;</b></i>
									<input type="checkbox" id="sus_tv" style="cursor:pointer;" onclick="activar_desactivar_lines(null,'g');" class="case"><b style="cursor:pointer;" onclick="activar_desactivar_lines('sus_tv','g');"><i>&nbsp;Suspensiones Television&nbsp;</b></i>
									<input type="checkbox" id="ret_int" style="cursor:pointer;" onclick="activar_desactivar_lines(null,'h');" class="case"><b style="cursor:pointer;" onclick="activar_desactivar_lines('ret_int','h');"><i>&nbsp;Retirados Internet&nbsp;</b></i>
									<input type="checkbox" id="ret_tv" style="cursor:pointer;" onclick="activar_desactivar_lines(null,'i');" class="case"><b style="cursor:pointer;" onclick="activar_desactivar_lines('ret_tv','i');"><i>&nbsp;Retirados Television&nbsp;</b></i>
							</div>
                        </div>
						
                    </div>
					<div class="card">
                        <div class="card-header no-border">
                            <h4 style="text-align: center;" class="card-title">Usuarios por Estados <a class="float-xs-right" href="<?php echo base_url() ?>reports/refresh_data?tipo=estadisticas_servicios"><i
                                class="icon-refresh2"></i></a></h4>
                             <div class="row">
                             	<?php 	$x1=array_reverse($lista_estadisticas);?>
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
   	var lista_keys=[];
    var lista_labels_total={z:'Activos Internet',a:"Activos Television",b:"Cortados Internet",c:"Cortados Television",d:"Cartera Internet",e:"Cartera Television",f:"Sus. Internet",g:"Sus. Television",h:"Ret. Internet",i:"Ret. Television"};
    var lista_labels_personalizada=[];
$('#invoices-products-chart').empty();

var datos={
        element: 'invoices-products-chart',
		 <?php $sdx=str_replace("-", "", $this->aauth->get_user()->sede_accede); $sede_a=explode(",", $sdx) ;
		 if (in_array(0, $sede_a)) { ?>
        data: [
            <?php foreach ($lista_estadisticas as $key => $row) {
			$sedesmas=0;
			$sedestv=0;
			$sedescorint=0;
			$sedescortv=0;
			$sedescarint=0;
			$sedescartv=0;
			$sedessusint=0;
			$sedessustv=0;
			$sedesretint=0;
			$sedesrettv=0;
            $datex = new DateTime($row['fecha']);
			 foreach ($grupos as $row2) {
				 $cod=$row2['id'];
				 $sedesmas+=$row['n_internet_'.$cod];
				 $sedestv+=$row['n_tv_'.$cod];
				 $sedescorint+=$row['cor_int_'.$cod];
				 $sedescortv+=$row['cor_tv_'.$cod];
				 $sedescarint+=$row['car_int_'.$cod];
				 $sedescartv+=$row['car_tv_'.$cod];
				 $sedessusint+=$row['sus_int_'.$cod];
				 $sedessustv+=$row['sus_tv_'.$cod];
				 $sedesretint+=$row['ret_int_'.$cod];
				 $sedesrettv+=$row['ret_tv_'.$cod];
			 }
			 if($this->config->item('ctitle')=='VESTEL S.A.S'){
				 $vestel=$row['n_internet']+$row['n_internet_vill']+$row['n_internet_mon'];
				 $vestel2=$row['n_tv']+$row['n_tv_vill']+$row['n_tv_mon'];
				 $vestel3=$row['cor_int']+$row['cor_int_vill']+$row['cor_int_mon'];
				 $vestel4=$row['cor_tv']+$row['cor_tv_vill']+$row['cor_tv_mon'];
				 $vestel5=$row['car_int']+$row['car_int_vill']+$row['car_int_mon'];
				 $vestel6=$row['car_tv']+$row['car_tv_vill']+$row['car_tv_mon'];
				 $vestel7=$row['sus_int']+$row['sus_int_vill']+$row['sus_int_mon'];
				 $vestel8=$row['sus_tv']+$row['sus_tv_vill']+$row['sus_tv_mon'];
				 $vestel9=$row['ret_int']+$row['ret_int_vill']+$row['ret_int_mon'];
				 $vestel10=$row['ret_tv']+$row['ret_tv_vill']+$row['ret_tv_mon'];
			 }else{
				 $vestel=0;
				 $vestel2=0;
				 $vestel3=0;
				 $vestel4=0;
				 $vestel5=0;
				 $vestel6=0;
				 $vestel7=0;
				 $vestel8=0;
				 $vestel9=0;
				 $vestel10=0;
			 }
            //$num = cal_days_in_month(CAL_GREGORIAN, $row['month'], $row['year']);
            echo "{ x: '".($datex->format("Y-m-d"))."',z: " . intval($vestel+$sedesmas) . ",a: " . intval($vestel2+$sedestv) .",b: " . intval($vestel3+$sedescorint) .",c: " . intval($vestel4+$sedescortv) .",d: " . intval($vestel5+$sedescarint) .",e: " . intval($vestel6+$sedescartv) .",f: " . intval($vestel7+$sedessusint) .",g: " . intval($vestel8+$sedessustv) .",h: " . intval($vestel9+$sedesretint) .",i: " . intval($vestel10+$sedesrettv) ."},";//,z: " . intval($tipos['instalaciones_tv'][$key]['numero']) . "
			 
        } ?>

        ],
	//YOPAL
		<?php } if (in_array(2, $sede_a)) { ?>
        data: [
            <?php foreach ($lista_estadisticas as $key => $row) {
            $datex = new DateTime($row['fecha']);
            //$num = cal_days_in_month(CAL_GREGORIAN, $row['month'], $row['year']);
            echo "{ x: '".($datex->format("Y-m-d"))."',z: " . intval($row['n_internet']) . ",a: " . intval($row['n_tv']) .",b: " . intval($row['cor_int']) .",c: " . intval($row['cor_tv']) .",d: " . intval($row['car_int']) .",e: " . intval($row['car_tv']) .",f: " . intval($row['sus_int']) .",g: " . intval($row['sus_tv']) .",h: " . intval($row['ret_int']) .",i: " . intval($row['ret_tv']) ."},";//,z: " . intval($tipos['instalaciones_tv'][$key]['numero']) . "
            
        } ?>

        ],
	//MONTERREY
		<?php } if (in_array(4, $sede_a)) { ?>
        data: [
            <?php foreach ($lista_estadisticas as $key => $row) {
            $datex = new DateTime($row['fecha']);
            //$num = cal_days_in_month(CAL_GREGORIAN, $row['month'], $row['year']);
            echo "{ x: '".($datex->format("Y-m-d"))."',z: " . intval($row['n_internet_mon']) . ",a: " . intval($row['n_tv_mon']) .",b: " . intval($row['cor_int_mon']) .",c: " . intval($row['cor_tv_mon']) .",d: " . intval($row['car_int_mon']) .",e: " . intval($row['car_tv_mon']) .",f: " . intval($row['sus_int_mon']) .",g: " . intval($row['sus_tv_mon']) .",h: " . intval($row['ret_int_mon']) .",i: " . intval($row['ret_tv_mon']) ."},";//,z: " . intval($tipos['instalaciones_tv'][$key]['numero']) . "
            
        } ?>

        ],
	//VILLANUEVA
		<?php } if (in_array(3, $sede_a)) { ?>
        data: [
            <?php foreach ($lista_estadisticas as $key => $row) {
            $datex = new DateTime($row['fecha']);
            //$num = cal_days_in_month(CAL_GREGORIAN, $row['month'], $row['year']);
            echo "{ x: '".($datex->format("Y-m-d"))."',z: " . intval($row['n_internet_vill']) . ",a: " . intval($row['n_tv_vill']) .",b: " . intval($row['cor_int_vill']) .",c: " . intval($row['cor_tv_vill']) .",d: " . intval($row['car_int_vill']) .",e: " . intval($row['car_tv_vill']) .",f: " . intval($row['sus_int_vill']) .",g: " . intval($row['sus_tv_vill']) .",h: " . intval($row['ret_int_vill']) .",i: " . intval($row['ret_tv_vill']) ."},";//,z: " . intval($tipos['instalaciones_tv'][$key]['numero']) . "
            
        } ?>

        ],
		//DINAMICO
		<?php } if ($sede['id']) { ?>
        data: [
            <?php foreach ($lista_estadisticas as $key => $row) {
            $datex = new DateTime($row['fecha']);
			$cod2=$sede['id'];
            //$num = cal_days_in_month(CAL_GREGORIAN, $row['month'], $row['year']);
            echo "{ x: '".($datex->format("Y-m-d"))."',z: " . intval($row['n_internet_'.$cod2]) . ",a: " . intval($row['n_tv_'.$cod2]) .",b: " . intval($row['cor_int_'.$cod2]) .",c: " . intval($row['cor_tv_'.$cod2]) .",d: " . intval($row['car_int_'.$cod2]) .",e: " . intval($row['car_tv_'.$cod2]) .",f: " . intval($row['sus_int_'.$cod2]) .",g: " . intval($row['sus_tv_'.$cod2]) .",h: " . intval($row['ret_int_'.$cod2]) .",i: " . intval($row['ret_tv_'.$cod2]) ."},";//,z: " . intval($tipos['instalaciones_tv'][$key]['numero']) . "
            
        } ?>

        ],
		<?php } ?>
        xkey: 'x',
        ykeys: ['z','a','b','c','d','e','f','g','h','i'],
        labels: ['Activos Internet','Activos Television','Cortados Internet','Cortados Television','Car. Internet','Car. Television','Sus. internet','Sus. Television','Ret. Internet','Ret. Television'],
        hideHover: 'auto',
        resize: true,
        lineColors: ['#34cea7', '#ff6e40','#9A7D0A','#FFA633', '#FF7933','#FF3333','#33FFB8', '#33D3FF','#338AFF','#8033FF', '#C933FF','#FF33DA'],
        parseTime:false
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