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
	
/*.first-col {
  padding-left: 35px!important;
}*/
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
<link rel="stylesheet" type="text/css" href="<?=base_url()  ?>assets/css/reporte_tecnicos_css_btns_flotantes.css">
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
<a style="color: white;" class="btn-flotante3"><i class="icon-menu5"></i></a>                        	
<a style="color: white;" class="btn-flotante">></a>
<a style="color: white;" class="btn-flotante2"><</a>
<a href="#detalles_totales" style="display:none" id="link1"></a>

                            <div class="table-responsive">
                                <table class="table mb-1" id="x2">
                                    <thead>
										<tr>
										<th rowspan="2" width="140px" class="static">Tipor de orden</th>
										<th colspan="<?=$tipos['cuantos_dias_a_imprimir'] ?>" style="text-align: center">Dia</th>
										</tr>
									
                                    <tr>
                                        
                                        <?php for ($i=1;$i<=$tipos['cuantos_dias_a_imprimir'];$i++){
													echo '<th style="text-align: center;">'.$i.'</th>';}?>
                                        <th rowspan="2" style="text-align: center;" >TOTAL</th>
                                    </tr>
										
                                    </thead>
                                    <tbody>
										
										<tr>
											<td class="static">
												<div class="cl-instalaciones_tv_e_internet" style="cursor: pointer;" onclick="desactivar_activar_tabla_instalaciones_tv_e_internet()"><i><u>Ins. Tv+Int </u></i></div>
												
													<table class="tb_tec_info_instalaciones_tv_e_internet"><tbody>
														<?php $lista_clases_css1=""; 
															foreach ($lista_de_tecnicos as $key => $value) {
																$name_class="instalaciones_tv_e_internet_".$value['username'];
																$lista_clases_css1.=",.".$name_class."";
																echo "<tr class='".$name_class."'><td>".$value['username']."</td></tr>";
														}  ?>	
														
													</tbody></table> 
											</td>
											<?php $conteo=0; foreach ($tipos['instalaciones_tv_e_internet'] as $key1=> $row) {?>												
												<td class="first-col" style="padding-right: 0px;padding-left: 0px;text-align: center;">
													<div class="cl-instalaciones_tv_e_internet" style="cursor: pointer;" onclick="desactivar_activar_tabla_instalaciones_tv_e_internet()"><?php echo $row;$conteo+=$row; ?></div>
														
														<table class="tb_tec_info_instalaciones_tv_e_internet" style='width: 100px;'><tbody>
															<?php foreach ($lista_por_tecnicos['instalaciones_tv_e_internet'][$key1] as $key => $value2) {
																echo "<tr class='instalaciones_tv_e_internet_".$key."' ><td style='width: 140px;text-align: center;'>".($value2['FTTH']['puntuacion']+$value2['EOC']['puntuacion']+$value2['puntos_adicionales']['puntuacion']+$value2['puntos_adicionales_multiples']['puntuacion'])."p</td></tr>";																
															} ?>	
														</tbody></table> 	
												</td>
											<?php } ?>

												
											
											<td align="center" >
												<div   class="cl-instalaciones_tv_e_internet" style="cursor: pointer;" onclick="desactivar_activar_tabla_instalaciones_tv_e_internet()"><?php echo $conteo; ?></div>
														<table class="tb_tec_info_instalaciones_tv_e_internet" style='width: 200px;text-align: center;'><tbody>
															<?php foreach ($lista_datos_cuentas_tipos_por_tecnico['instalaciones_tv_e_internet'] as $key => $value2) {
																echo "<tr class='instalaciones_tv_e_internet_".$key."' ><td style='width: 400px;'> <strong>".($value2['FTTH']['puntuacion']+$value2['EOC']['puntuacion']+$value2['puntos_adicionales']['puntuacion']+$value2['puntos_adicionales_multiples']['puntuacion'])."</strong> pts </td></tr>";																
															} ?>	
														</tbody></table> 	
											</td>
										</tr>
										<tr>
											<td class="static">Ins. Tv</td>
											<?php $conteo=0; foreach ($tipos['instalaciones_tv'] as $row) {?>												
											<td style="text-align: center;"><?php echo $row;$conteo+=$row; } ?></td>
											<td align="center"><?php echo $conteo; ?></td>
										</tr>
										<tr>
											<td class="static">
												<div class="cl-instalaciones_internet" style="cursor: pointer;" onclick="desactivar_activar_tabla_instalaciones_internet()"><i><u>Ins. Int</u></i></div>
												
													<table class="tb_tec_info_instalaciones_internet"><tbody>
														<?php $lista_clases_css2=""; 
															foreach ($lista_de_tecnicos as $key => $value) {
																$name_class="instalaciones_internet_".$value['username'];
																$lista_clases_css2.=",.".$name_class."";
																echo "<tr class='".$name_class."'><td>".$value['username']."</td></tr>";
														}  ?>	
														
													</tbody></table> 
											</td>
											<?php $conteo=0; foreach ($tipos['instalaciones_internet'] as $key1=> $row) {?>												
												<td class="first-col" style="padding-right: 0px;padding-left: 0px;text-align: center;">
													<div class="cl-instalaciones_internet" style="cursor: pointer;" onclick="desactivar_activar_tabla_instalaciones_internet()"><?php echo $row;$conteo+=$row; ?></div>
														
														<table class="tb_tec_info_instalaciones_internet" style='width: 100px;'><tbody>
															<?php foreach ($lista_por_tecnicos['instalaciones_internet'][$key1] as $key => $value2) {
																echo "<tr class='instalaciones_internet_".$key."' ><td style='width: 100px;text-align: center;'>".($value2['FTTH']['puntuacion']+$value2['EOC']['puntuacion']+$value2['TV']['puntuacion'])."p</td></tr>";																
															} ?>	
														</tbody></table> 	
												</td>
											<?php } ?>

												
											
											<td align="center" >
												<div   class="cl-instalaciones_internet" style="cursor: pointer;" onclick="desactivar_activar_tabla_instalaciones_internet()"><?php echo $conteo; ?></div>
														<table class="tb_tec_info_instalaciones_internet" style='width: 200px;text-align: center;'><tbody>
															<?php foreach ($lista_datos_cuentas_tipos_por_tecnico['instalaciones_internet'] as $key => $value2) {
																echo "<tr class='instalaciones_internet_".$key."' ><td style='width: 200px;'><strong>".($value2['FTTH']['puntuacion']+$value2['EOC']['puntuacion']+$value2['TV']['puntuacion'])."</strong> pts </td></tr>";																
															} ?>	
														</tbody></table> 	
											</td>
										</tr>
										
										
														<tr>
											<td class="static">
												<div class="cl-instalaciones_Agregar_Tv" style="cursor: pointer;" onclick="desactivar_activar_tabla_instalaciones_Agregar_Tv()"><i><u>Agregar Tv</u></i></div>
												
													<table class="tb_tec_info_instalaciones_Agregar_Tv"><tbody>
														<?php $lista_clases_css3=""; 
															foreach ($lista_de_tecnicos as $key => $value) {
																$name_class="instalaciones_Agregar_Tv_".$value['username'];
																$lista_clases_css3.=",.".$name_class."";
																echo "<tr class='".$name_class."'><td>".$value['username']."</td></tr>";
														}  ?>	
														
													</tbody></table> 
											</td>
											<?php $conteo=0; foreach ($tipos['instalaciones_Agregar_Tv'] as $key1=> $row) {?>												
												<td class="first-col" style="padding-right: 0px;padding-left: 0px;text-align: center;">
													<div class="cl-instalaciones_Agregar_Tv" style="cursor: pointer;" onclick="desactivar_activar_tabla_instalaciones_Agregar_Tv()"><?php echo $row;$conteo+=$row; ?></div>
														
														<table class="tb_tec_info_instalaciones_Agregar_Tv" style='width: 100px;'><tbody>
															<?php foreach ($lista_por_tecnicos['instalaciones_Agregar_Tv'][$key1] as $key => $value2) {
																echo "<tr class='instalaciones_Agregar_Tv_".$key."' ><td style='width: 100px;text-align: center;'>".($value2['Agregar_Tv']['puntuacion']+$value2['puntos_adicionales']['puntuacion']+$value2['puntos_adicionales_multiples']['puntuacion'])."p</td></tr>";																
															} ?>	
														</tbody></table> 	
												</td>
											<?php } ?>

												
											
											<td align="center" >
												<div   class="cl-instalaciones_Agregar_Tv" style="cursor: pointer;" onclick="desactivar_activar_tabla_instalaciones_Agregar_Tv()"><?php echo $conteo; ?></div>
														<table class="tb_tec_info_instalaciones_Agregar_Tv" style='width: 200px;text-align: center;'><tbody>
															<?php foreach ($lista_datos_cuentas_tipos_por_tecnico['instalaciones_Agregar_Tv'] as $key => $value2) {
																echo "<tr class='instalaciones_Agregar_Tv_".$key."' ><td style='width: 200px;'><strong>".($value2['Agregar_Tv']['puntuacion']+$value2['puntos_adicionales']['puntuacion']+$value2['puntos_adicionales_multiples']['puntuacion'])."</strong> pts </td></tr>";																
															} ?>	
														</tbody></table> 	
											</td>
										</tr>
						
										
										<tr>
											<td class="static">
												<div class="cl-instalaciones_AgregarInternet" style="cursor: pointer;" onclick="desactivar_activar_tabla_instalaciones_AgregarInternet()"><i><u>Agregar Int</u></i></div>
												
													<table class="tb_tec_info_instalaciones_AgregarInternet"><tbody>
														<?php $lista_clases_css5=""; 
															foreach ($lista_de_tecnicos as $key => $value) {
																$name_class="instalaciones_AgregarInternet_".$value['username'];
																$lista_clases_css5.=",.".$name_class."";
																echo "<tr class='".$name_class."'><td>".$value['username']."</td></tr>";
														}  ?>	
														
													</tbody></table> 
											</td>
											<?php $conteo=0; foreach ($tipos['instalaciones_AgregarInternet'] as $key1=> $row) {?>												
												<td class="first-col" style="padding-right: 0px;padding-left: 0px;text-align: center;">
													<div class="cl-instalaciones_AgregarInternet" style="cursor: pointer;" onclick="desactivar_activar_tabla_instalaciones_AgregarInternet()"><?php echo $row;$conteo+=$row; ?></div>
														
														<table class="tb_tec_info_instalaciones_AgregarInternet" style='width: 100px;'><tbody>
															<?php foreach ($lista_por_tecnicos['instalaciones_AgregarInternet'][$key1] as $key => $value2) {
																echo "<tr class='instalaciones_AgregarInternet_".$key."' ><td style='width: 100px;text-align: center;'>".($value2['FTTH']['puntuacion']+$value2['EOC']['puntuacion']+$value2['TV']['puntuacion'])."p</td></tr>";																
															} ?>	
														</tbody></table> 	
												</td>
											<?php } ?>

												
											
											<td align="center" >
												<div   class="cl-instalaciones_AgregarInternet" style="cursor: pointer;" onclick="desactivar_activar_tabla_instalaciones_AgregarInternet()"><?php echo $conteo; ?></div>
														<table class="tb_tec_info_instalaciones_AgregarInternet" style='width: 200px;text-align: center;'><tbody>
															<?php foreach ($lista_datos_cuentas_tipos_por_tecnico['instalaciones_AgregarInternet'] as $key => $value2) {
																echo "<tr class='instalaciones_AgregarInternet_".$key."' ><td style='width: 200px;'><strong>".($value2['FTTH']['puntuacion']+$value2['EOC']['puntuacion']+$value2['TV']['puntuacion'])."</strong> pts </td></tr>";																
															} ?>	
														</tbody></table> 	
											</td>
										</tr>
										<tr>
											<td class="static">
												<div class="cl-instalaciones_Traslado" style="cursor: pointer;" onclick="desactivar_activar_tabla_instalaciones_Traslado()"><i><u>Traslado</u></i></div>
												
													<table class="tb_tec_info_instalaciones_Traslado"><tbody>
														<?php $lista_clases_css4=""; 
															foreach ($lista_de_tecnicos as $key => $value) {
																$name_class="instalaciones_Traslado_".$value['username'];
																$lista_clases_css4.=",.".$name_class."";
																echo "<tr class='".$name_class."'><td>".$value['username']."</td></tr>";
														}  ?>	
														
													</tbody></table> 
											</td>
											<?php $conteo=0; foreach ($tipos['instalaciones_Traslado'] as $key1=> $row) {?>												
												<td class="first-col" style="padding-right: 0px;padding-left: 0px;text-align: center;">
													<div class="cl-instalaciones_Traslado" style="cursor: pointer;" onclick="desactivar_activar_tabla_instalaciones_Traslado()"><?php echo $row;$conteo+=$row; ?></div>
														
														<table class="tb_tec_info_instalaciones_Traslado" style='width: 100px;'><tbody>
															<?php foreach ($lista_por_tecnicos['instalaciones_Traslado'][$key1] as $key => $value2) {
																echo "<tr class='instalaciones_Traslado_".$key."' ><td style='width: 100px;text-align: center;'>".($value2['FTTH']['puntuacion']+$value2['EOC']['puntuacion']+$value2['TV']['puntuacion'])."p</td></tr>";																
															} ?>	
														</tbody></table> 	
												</td>
											<?php } ?>

												
											
											<td align="center" >
												<div   class="cl-instalaciones_Traslado" style="cursor: pointer;" onclick="desactivar_activar_tabla_instalaciones_Traslado()"><?php echo $conteo; ?></div>
														<table class="tb_tec_info_instalaciones_Traslado" style='width: 200px;text-align: center;'><tbody>
															<?php foreach ($lista_datos_cuentas_tipos_por_tecnico['instalaciones_Traslado'] as $key => $value2) {
																echo "<tr class='instalaciones_Traslado_".$key."' ><td style='width: 200px;'><strong>".($value2['FTTH']['puntuacion']+$value2['EOC']['puntuacion']+$value2['TV']['puntuacion'])."</strong> pts </td></tr>";																
															} ?>	
														</tbody></table> 	
											</td>
										</tr>
						
										<tr>
											<td class="static">
												<div class="cl-instalaciones_Revision_tv_e_internet" style="cursor: pointer;" onclick="desactivar_activar_tabla_instalaciones_Revision_tv_e_internet()"><i><u>Revision Tv+Int</u></i></div>
												
													<table class="tb_tec_info_instalaciones_Revision_tv_e_internet"><tbody>
														<?php $lista_clases_css7=""; 
															foreach ($lista_de_tecnicos as $key => $value) {
																$name_class="instalaciones_Revision_tv_e_internet_".$value['username'];
																$lista_clases_css7.=",.".$name_class."";
																echo "<tr class='".$name_class."'><td>".$value['username']."</td></tr>";
														}  ?>	
														
													</tbody></table> 
											</td>
											<?php $conteo=0; foreach ($tipos['instalaciones_Revision_tv_e_internet'] as $key1=> $row) {?>												
												<td class="first-col" style="padding-right: 0px;padding-left: 0px;text-align: center;vertical-align: middle;">
													<div class="cl-instalaciones_Revision_tv_e_internet" style="cursor: pointer;" onclick="desactivar_activar_tabla_instalaciones_Revision_tv_e_internet()"><?php echo $row;$conteo+=$row; ?></div>
														
														<table class="tb_tec_info_instalaciones_Revision_tv_e_internet" style='width: 100px;'><tbody>
															<?php foreach ($lista_por_tecnicos['instalaciones_Revision_tv_e_internet'][$key1] as $key => $value2) {
																echo "<tr class='instalaciones_Revision_tv_e_internet_".$key."' ><td style='width: 100px;text-align: center;'>".($value2['puntuacion'])."p</td></tr>";																
															} ?>	
														</tbody></table> 	
												</td>
											<?php } ?>

												
											
											<td align="center" style="vertical-align: middle;">
												<div   class="cl-instalaciones_Revision_tv_e_internet" style="cursor: pointer;" onclick="desactivar_activar_tabla_instalaciones_Revision_tv_e_internet()"><?php echo $conteo; ?></div>
														<table class="tb_tec_info_instalaciones_Revision_tv_e_internet" style='width: 200px;text-align: center;vertical-align: middle;'><tbody>
															<?php foreach ($lista_datos_cuentas_tipos_por_tecnico['instalaciones_Revision_tv_e_internet'] as $key => $value2) {
																echo "<tr class='instalaciones_Revision_tv_e_internet_".$key."' ><td style='width: 200px;'><strong>".($value2['puntuacion'])."</strong> pts </td></tr>";																
															} ?>	
														</tbody></table> 	
											</td>
										</tr>
										<tr>
											<td class="static">
												<div class="cl-instalaciones_Revision_tv" style="cursor: pointer;" onclick="desactivar_activar_tabla_instalaciones_Revision_tv()"><i><u>Revision Tv</u></i></div>
												
													<table class="tb_tec_info_instalaciones_Revision_tv"><tbody>
														<?php $lista_clases_css15=""; 
															foreach ($lista_de_tecnicos as $key => $value) {
																$name_class="instalaciones_Revision_tv_".$value['username'];
																$lista_clases_css15.=",.".$name_class."";
																echo "<tr class='".$name_class."'><td>".$value['username']."</td></tr>";
														}  ?>	
														
													</tbody></table> 
											</td>
											<?php $conteo=0; foreach ($tipos['instalaciones_Revision_tv'] as $key1=> $row) {?>												
												<td class="first-col" style="padding-right: 0px;padding-left: 0px;text-align: center;">
													<div class="cl-instalaciones_Revision_tv" style="cursor: pointer;" onclick="desactivar_activar_tabla_instalaciones_Revision_tv()"><?php echo $row;$conteo+=$row; ?></div>
														
														<table class="tb_tec_info_instalaciones_Revision_tv" style='width: 100px;'><tbody>
															<?php foreach ($lista_por_tecnicos['instalaciones_Revision_tv'][$key1] as $key => $value2) {
																echo "<tr class='instalaciones_Revision_tv_".$key."' ><td style='width: 100px;text-align: center;'>".($value2['puntuacion'])."p</td></tr>";																
															} ?>	
														</tbody></table> 	
												</td>
											<?php } ?>

												
											
											<td align="center" >
												<div   class="cl-instalaciones_Revision_tv" style="cursor: pointer;" onclick="desactivar_activar_tabla_instalaciones_Revision_tv()"><?php echo $conteo; ?></div>
														<table class="tb_tec_info_instalaciones_Revision_tv" style='width: 200px;text-align: center;'><tbody>
															<?php foreach ($lista_datos_cuentas_tipos_por_tecnico['instalaciones_Revision_tv'] as $key => $value2) {
																echo "<tr class='instalaciones_Revision_tv_".$key."' ><td style='width: 200px;'><strong>".($value2['puntuacion'])."</strong> pts </td></tr>";																
															} ?>	
														</tbody></table> 	
											</td>
										</tr>
										<tr>
											<td class="static">
												<div class="cl-instalaciones_Revision_internet" style="cursor: pointer;" onclick="desactivar_activar_tabla_instalaciones_Revision_internet()"><i><u>Revision Int</u></i></div>
												
													<table class="tb_tec_info_instalaciones_Revision_internet"><tbody>
														<?php $lista_clases_css16=""; 
															foreach ($lista_de_tecnicos as $key => $value) {
																$name_class="instalaciones_Revision_internet_".$value['username'];
																$lista_clases_css16.=",.".$name_class."";
																echo "<tr class='".$name_class."'><td>".$value['username']."</td></tr>";
														}  ?>	
														
													</tbody></table> 
											</td>
											<?php $conteo=0; foreach ($tipos['instalaciones_Revision_internet'] as $key1=> $row) {?>												
												<td class="first-col" style="padding-right: 0px;padding-left: 0px;text-align: center;">
													<div class="cl-instalaciones_Revision_internet" style="cursor: pointer;" onclick="desactivar_activar_tabla_instalaciones_Revision_internet()"><?php echo $row;$conteo+=$row; ?></div>
														
														<table class="tb_tec_info_instalaciones_Revision_internet" style='width: 100px;'><tbody>
															<?php foreach ($lista_por_tecnicos['instalaciones_Revision_internet'][$key1] as $key => $value2) {
																echo "<tr class='instalaciones_Revision_internet_".$key."' ><td style='width: 100px;text-align: center;'>".($value2['puntuacion'])."p</td></tr>";																
															} ?>	
														</tbody></table> 	
												</td>
											<?php } ?>

												
											
											<td align="center" >
												<div   class="cl-instalaciones_Revision_internet" style="cursor: pointer;" onclick="desactivar_activar_tabla_instalaciones_Revision_internet()"><?php echo $conteo; ?></div>
														<table class="tb_tec_info_instalaciones_Revision_internet" style='width: 200px;text-align: center;'><tbody>
															<?php foreach ($lista_datos_cuentas_tipos_por_tecnico['instalaciones_Revision_internet'] as $key => $value2) {
																echo "<tr class='instalaciones_Revision_internet_".$key."' ><td style='width: 200px;'><strong>".($value2['puntuacion'])."</strong> pts </td></tr>";																
															} ?>	
														</tbody></table> 	
											</td>
										</tr>
										<tr>
											<td class="static">
												<div class="cl-instalaciones_Reconexion_tv_e_internet" style="cursor: pointer;" onclick="desactivar_activar_tabla_instalaciones_Reconexion_tv_e_internet()"><i><u>Reconexion tv+int</u></i></div>
												
													<table class="tb_tec_info_instalaciones_Reconexion_tv_e_internet"><tbody>
														<?php $lista_clases_css8=""; 
															foreach ($lista_de_tecnicos as $key => $value) {
																$name_class="instalaciones_Reconexion_tv_e_internet_".$value['username'];
																$lista_clases_css8.=",.".$name_class."";
																echo "<tr class='".$name_class."'><td>".$value['username']."</td></tr>";
														}  ?>	
														
													</tbody></table> 
											</td>
											<?php $conteo=0; foreach ($tipos['instalaciones_Reconexion_tv_e_internet'] as $key1=> $row) {?>												
												<td class="first-col" style="padding-right: 0px;padding-left: 0px;text-align: center;vertical-align: middle;">
													<div class="cl-instalaciones_Reconexion_tv_e_internet" style="cursor: pointer;" onclick="desactivar_activar_tabla_instalaciones_Reconexion_tv_e_internet()"><?php echo $row;$conteo+=$row; ?></div>
														
														<table class="tb_tec_info_instalaciones_Reconexion_tv_e_internet" style='width: 100px;'><tbody>
															<?php foreach ($lista_por_tecnicos['instalaciones_Reconexion_tv_e_internet'][$key1] as $key => $value2) {
																echo "<tr class='instalaciones_Reconexion_tv_e_internet_".$key."' ><td style='width: 100px;text-align: center;'>".($value2['puntuacion'])."p</td></tr>";																
															} ?>	
														</tbody></table> 	
												</td>
											<?php } ?>

												
											
											<td align="center" style="vertical-align: middle;">
												<div   class="cl-instalaciones_Reconexion_tv_e_internet" style="cursor: pointer;" onclick="desactivar_activar_tabla_instalaciones_Reconexion_tv_e_internet()"><?php echo $conteo; ?></div>
														<table class="tb_tec_info_instalaciones_Reconexion_tv_e_internet" style='width: 200px;text-align: center;vertical-align: middle;'><tbody>
															<?php foreach ($lista_datos_cuentas_tipos_por_tecnico['instalaciones_Reconexion_tv_e_internet'] as $key => $value2) {
																echo "<tr class='instalaciones_Reconexion_tv_e_internet_".$key."' ><td style='width: 200px;'><strong>".($value2['puntuacion'])."</strong> pts </td></tr>";																
															} ?>	
														</tbody></table> 	
											</td>
										</tr>
										<tr>
											<td class="static">
												<div class="cl-instalaciones_Reconexion_tv" style="cursor: pointer;" onclick="desactivar_activar_tabla_instalaciones_Reconexion_tv()"><i><u>Reconexion tv</u></i></div>
												
													<table class="tb_tec_info_instalaciones_Reconexion_tv"><tbody>
														<?php $lista_clases_css13=""; 
															foreach ($lista_de_tecnicos as $key => $value) {
																$name_class="instalaciones_Reconexion_tv_".$value['username'];
																$lista_clases_css13.=",.".$name_class."";
																echo "<tr class='".$name_class."'><td>".$value['username']."</td></tr>";
														}  ?>	
														
													</tbody></table> 
											</td>
											<?php $conteo=0; foreach ($tipos['instalaciones_Reconexion_tv'] as $key1=> $row) {?>												
												<td class="first-col" style="padding-right: 0px;padding-left: 0px;text-align: center;vertical-align: middle;">
													<div class="cl-instalaciones_Reconexion_tv" style="cursor: pointer;" onclick="desactivar_activar_tabla_instalaciones_Reconexion_tv()"><?php echo $row;$conteo+=$row; ?></div>
														
														<table class="tb_tec_info_instalaciones_Reconexion_tv" style='width: 100px;'><tbody>
															<?php foreach ($lista_por_tecnicos['instalaciones_Reconexion_tv'][$key1] as $key => $value2) {
																echo "<tr class='instalaciones_Reconexion_tv_".$key."' ><td style='width: 100px;text-align: center;'>".($value2['puntuacion'])."p</td></tr>";																
															} ?>	
														</tbody></table> 	
												</td>
											<?php } ?>

												
											
											<td align="center" style="vertical-align: middle;">
												<div   class="cl-instalaciones_Reconexion_tv" style="cursor: pointer;" onclick="desactivar_activar_tabla_instalaciones_Reconexion_tv()"><?php echo $conteo; ?></div>
														<table class="tb_tec_info_instalaciones_Reconexion_tv" style='width: 200px;text-align: center;vertical-align: middle;'><tbody>
															<?php foreach ($lista_datos_cuentas_tipos_por_tecnico['instalaciones_Reconexion_tv'] as $key => $value2) {
																echo "<tr class='instalaciones_Reconexion_tv_".$key."' ><td style='width: 200px;'><strong>".($value2['puntuacion'])."</strong> pts </td></tr>";																
															} ?>	
														</tbody></table> 	
											</td>
										</tr>
										<tr>
											<td class="static">
												<div class="cl-instalaciones_Reconexion_internet" style="cursor: pointer;" onclick="desactivar_activar_tabla_instalaciones_Reconexion_internet()"><i><u>Reconexion int</u></i></div>
												
													<table class="tb_tec_info_instalaciones_Reconexion_internet"><tbody>
														<?php $lista_clases_css14=""; 
															foreach ($lista_de_tecnicos as $key => $value) {
																$name_class="instalaciones_Reconexion_internet_".$value['username'];
																$lista_clases_css14.=",.".$name_class."";
																echo "<tr class='".$name_class."'><td>".$value['username']."</td></tr>";
														}  ?>	
														
													</tbody></table> 
											</td>
											<?php $conteo=0; foreach ($tipos['instalaciones_Reconexion_internet'] as $key1=> $row) {?>												
												<td class="first-col" style="padding-right: 0px;padding-left: 0px;text-align: center;vertical-align: middle;">
													<div class="cl-instalaciones_Reconexion_internet" style="cursor: pointer;" onclick="desactivar_activar_tabla_instalaciones_Reconexion_internet()"><?php echo $row;$conteo+=$row; ?></div>
														
														<table class="tb_tec_info_instalaciones_Reconexion_internet" style='width: 100px;vertical-align: middle;'><tbody>
															<?php foreach ($lista_por_tecnicos['instalaciones_Reconexion_internet'][$key1] as $key => $value2) {
																echo "<tr class='instalaciones_Reconexion_internet_".$key."' ><td style='width: 100px;text-align: center;'>".($value2['puntuacion'])."p</td></tr>";																
															} ?>	
														</tbody></table> 	
												</td>
											<?php } ?>

												
											
											<td align="center" style="vertical-align: middle;" >
												<div   class="cl-instalaciones_Reconexion_internet" style="cursor: pointer;" onclick="desactivar_activar_tabla_instalaciones_Reconexion_internet()"><?php echo $conteo; ?></div>
														<table class="tb_tec_info_instalaciones_Reconexion_internet" style='width: 200px;text-align: center;vertical-align: middle;'><tbody>
															<?php foreach ($lista_datos_cuentas_tipos_por_tecnico['instalaciones_Reconexion_internet'] as $key => $value2) {
																echo "<tr class='instalaciones_Reconexion_internet_".$key."' ><td style='width: 200px;'><strong>".($value2['puntuacion'])."</strong> pts </td></tr>";																
															} ?>	
														</tbody></table> 	
											</td>
										</tr>
										<tr>
											<td class="static">Sus. Tv+Int</td>
											<?php $conteo=0; foreach ($tipos['instalaciones_Suspension_Combo'] as $row) {?>												
											<td style="text-align: center;"><?php echo $row;$conteo+=$row; } ?></td>
											<td align="center"><?php echo $conteo; ?></td>
										</tr>
										<tr>
											<td class="static">Sus. Int</td>
											<?php $conteo=0; foreach ($tipos['instalaciones_Suspension_Internet'] as $row) {?>												
											<td style="text-align: center;"><?php echo $row;$conteo+=$row; } ?></td>
											<td align="center"><?php echo $conteo; ?></td>
										</tr>
										<tr>
											<td class="static">Sus. Tv</td>
											<?php $conteo=0; foreach ($tipos['instalaciones_Suspension_Television'] as $row) {?>												
											<td style="text-align: center;"><?php echo $row;$conteo+=$row; } ?></td>
											<td align="center"><?php echo $conteo; ?></td>
										</tr>
										<tr>
											<td class="static">
												<div class="cl-instalaciones_Corte_tv_e_internet" style="cursor: pointer;" onclick="desactivar_activar_tabla_instalaciones_Corte_tv_e_internet()"><i><u>Corte Tv+Int</u></i></div>
												
													<table class="tb_tec_info_instalaciones_Corte_tv_e_internet"><tbody>
														<?php $lista_clases_css12=""; 
															foreach ($lista_de_tecnicos as $key => $value) {
																$name_class="instalaciones_Corte_tv_e_internet_".$value['username'];
																$lista_clases_css12.=",.".$name_class."";
																echo "<tr class='".$name_class."'><td>".$value['username']."</td></tr>";
														}  ?>	
														
													</tbody></table> 
											</td>
											<?php $conteo=0; foreach ($tipos['instalaciones_Corte_tv_e_internet'] as $key1=> $row) {?>												
												<td class="first-col" style="padding-right: 0px;padding-left: 0px;text-align: center;">
													<div class="cl-instalaciones_Corte_tv_e_internet" style="cursor: pointer;" onclick="desactivar_activar_tabla_instalaciones_Corte_tv_e_internet()"><?php echo $row;$conteo+=$row; ?></div>
														
														<table class="tb_tec_info_instalaciones_Corte_tv_e_internet" style='width: 100px;'><tbody>
															<?php foreach ($lista_por_tecnicos['instalaciones_Corte_tv_e_internet'][$key1] as $key => $value2) {
																echo "<tr class='instalaciones_Corte_tv_e_internet_".$key."' ><td style='width: 100px;text-align: center;'>".($value2['puntuacion'])."p</td></tr>";																
															} ?>	
														</tbody></table> 	
												</td>
											<?php } ?>

												
											
											<td align="center" >
												<div   class="cl-instalaciones_Corte_tv_e_internet" style="cursor: pointer;" onclick="desactivar_activar_tabla_instalaciones_Corte_tv_e_internet()"><?php echo $conteo; ?></div>
														<table class="tb_tec_info_instalaciones_Corte_tv_e_internet" style='width: 200px;text-align: center;'><tbody>
															<?php foreach ($lista_datos_cuentas_tipos_por_tecnico['instalaciones_Corte_tv_e_internet'] as $key => $value2) {
																echo "<tr class='instalaciones_Corte_tv_e_internet_".$key."' ><td style='width: 200px;'><strong>".($value2['puntuacion'])."</strong> pts </td></tr>";																
															} ?>	
														</tbody></table> 	
											</td>
										</tr>
										<tr>
											<td class="static">
												<div class="cl-instalaciones_Corte_Tv" style="cursor: pointer;" onclick="desactivar_activar_tabla_instalaciones_Corte_Tv()"><i><u>Corte Tv</u></i></div>
												
													<table class="tb_tec_info_instalaciones_Corte_Tv"><tbody>
														<?php $lista_clases_css9=""; 
															foreach ($lista_de_tecnicos as $key => $value) {
																$name_class="instalaciones_Corte_Tv_".$value['username'];
																$lista_clases_css9.=",.".$name_class."";
																echo "<tr class='".$name_class."'><td>".$value['username']."</td></tr>";
														}  ?>	
														
													</tbody></table> 
											</td>
											<?php $conteo=0; foreach ($tipos['instalaciones_Corte_Tv'] as $key1=> $row) {?>												
												<td class="first-col" style="padding-right: 0px;padding-left: 0px;text-align: center;">
													<div class="cl-instalaciones_Corte_Tv" style="cursor: pointer;" onclick="desactivar_activar_tabla_instalaciones_Corte_Tv()"><?php echo $row;$conteo+=$row; ?></div>
														
														<table class="tb_tec_info_instalaciones_Corte_Tv" style='width: 100px;'><tbody>
															<?php foreach ($lista_por_tecnicos['instalaciones_Corte_Tv'][$key1] as $key => $value2) {
																echo "<tr class='instalaciones_Corte_Tv_".$key."' ><td style='width: 100px;text-align: center;'>".($value2['puntuacion'])."p</td></tr>";																
															} ?>	
														</tbody></table> 	
												</td>
											<?php } ?>

												
											
											<td align="center" >
												<div   class="cl-instalaciones_Corte_Tv" style="cursor: pointer;" onclick="desactivar_activar_tabla_instalaciones_Corte_Tv()"><?php echo $conteo; ?></div>
														<table class="tb_tec_info_instalaciones_Corte_Tv" style='width: 200px;text-align: center;'><tbody>
															<?php foreach ($lista_datos_cuentas_tipos_por_tecnico['instalaciones_Corte_Tv'] as $key => $value2) {
																echo "<tr class='instalaciones_Corte_Tv_".$key."' ><td style='width: 200px;'><strong>".($value2['puntuacion'])."</strong> pts </td></tr>";																
															} ?>	
														</tbody></table> 	
											</td>
										</tr>
										<tr>
											<td class="static">
												<div class="cl-instalaciones_Corte_Internet" style="cursor: pointer;" onclick="desactivar_activar_tabla_instalaciones_Corte_Internet()"><i><u>Corte Int</u></i></div>
												
													<table class="tb_tec_info_instalaciones_Corte_Internet"><tbody>
														<?php $lista_clases_css11=""; 
															foreach ($lista_de_tecnicos as $key => $value) {
																$name_class="instalaciones_Corte_Internet_".$value['username'];
																$lista_clases_css11.=",.".$name_class."";
																echo "<tr class='".$name_class."'><td>".$value['username']."</td></tr>";
														}  ?>	
														
													</tbody></table> 
											</td>
											<?php $conteo=0; foreach ($tipos['instalaciones_Corte_Internet'] as $key1=> $row) {?>												
												<td class="first-col" style="padding-right: 0px;padding-left: 0px;text-align: center;">
													<div class="cl-instalaciones_Corte_Internet" style="cursor: pointer;" onclick="desactivar_activar_tabla_instalaciones_Corte_Internet()"><?php echo $row;$conteo+=$row; ?></div>
														
														<table class="tb_tec_info_instalaciones_Corte_Internet" style='width: 100px;'><tbody>
															<?php foreach ($lista_por_tecnicos['instalaciones_Corte_Internet'][$key1] as $key => $value2) {
																echo "<tr class='instalaciones_Corte_Internet_".$key."' ><td style='width: 100px;text-align: center;'>".($value2['puntuacion'])."p</td></tr>";																
															} ?>	
														</tbody></table> 	
												</td>
											<?php } ?>

												
											
											<td align="center" >
												<div   class="cl-instalaciones_Corte_Internet" style="cursor: pointer;" onclick="desactivar_activar_tabla_instalaciones_Corte_Internet()"><?php echo $conteo; ?></div>
														<table class="tb_tec_info_instalaciones_Corte_Internet" style='width: 200px;text-align: center;'><tbody>
															<?php foreach ($lista_datos_cuentas_tipos_por_tecnico['instalaciones_Corte_Internet'] as $key => $value2) {
																echo "<tr class='instalaciones_Corte_Internet_".$key."' ><td style='width: 200px;'><strong>".($value2['puntuacion'])."</strong> pts </td></tr>";																
															} ?>	
														</tbody></table> 	
											</td>
										</tr>
										<tr>
											<td class="static">
												<div class="cl-instalaciones_migracion" style="cursor: pointer;" onclick="desactivar_activar_tabla_instalaciones_migracion()"><i><u>Migracion</u></i></div>
												
													<table class="tb_tec_info_instalaciones_migracion"><tbody>
														<?php $lista_clases_css17=""; 
															foreach ($lista_de_tecnicos as $key => $value) {
																$name_class="instalaciones_migracion_".$value['username'];
																$lista_clases_css17.=",.".$name_class."";
																echo "<tr class='".$name_class."'><td>".$value['username']."</td></tr>";
														}  ?>	
														
													</tbody></table> 
											</td>
											<?php $conteo=0; foreach ($tipos['instalaciones_migracion'] as $key1=> $row) {?>												
												<td class="first-col" style="padding-right: 0px;padding-left: 0px;text-align: center;">
													<div class="cl-instalaciones_migracion" style="cursor: pointer;" onclick="desactivar_activar_tabla_instalaciones_migracion()"><?php echo $row;$conteo+=$row; ?></div>
														
														<table class="tb_tec_info_instalaciones_migracion" style='width: 100px;'><tbody>
															<?php foreach ($lista_por_tecnicos['instalaciones_migracion'][$key1] as $key => $value2) {
																echo "<tr class='instalaciones_migracion_".$key."' ><td style='width: 100px;text-align: center;'>".($value2['puntuacion'])."p</td></tr>";																
															} ?>	
														</tbody></table> 	
												</td>
											<?php } ?>

												
											
											<td align="center" >
												<div   class="cl-instalaciones_migracion" style="cursor: pointer;" onclick="desactivar_activar_tabla_instalaciones_migracion()"><?php echo $conteo; ?></div>
														<table class="tb_tec_info_instalaciones_migracion" style='width: 200px;text-align: center;'><tbody>
															<?php foreach ($lista_datos_cuentas_tipos_por_tecnico['instalaciones_migracion'] as $key => $value2) {
																echo "<tr class='instalaciones_migracion_".$key."' ><td style='width: 200px;'><strong>".($value2['puntuacion'])."</strong> pts </td></tr>";																
															} ?>	
														</tbody></table> 	
											</td>
										</tr>
										<tr>
											<td class="static">
												<div class="cl-instalaciones_punto_nuevo" style="cursor: pointer;" onclick="desactivar_activar_tabla_instalaciones_punto_nuevo()"><i><u>Punto Nuevo</u></i></div>
												
													<table class="tb_tec_info_instalaciones_punto_nuevo"><tbody>
														<?php $lista_clases_css27=""; 
															foreach ($lista_de_tecnicos as $key => $value) {
																$name_class="instalaciones_punto_nuevo_".$value['username'];
																$lista_clases_css27.=",.".$name_class."";
																echo "<tr class='".$name_class."'><td>".$value['username']."</td></tr>";
														}  ?>	
														
													</tbody></table> 
											</td>
											<?php $conteo=0; foreach ($tipos['instalaciones_punto_nuevo'] as $key1=> $row) {?>												
												<td class="first-col" style="padding-right: 0px;padding-left: 0px;text-align: center;">
													<div class="cl-instalaciones_punto_nuevo" style="cursor: pointer;" onclick="desactivar_activar_tabla_instalaciones_punto_nuevo()"><?php echo $row;$conteo+=$row; ?></div>
														
														<table class="tb_tec_info_instalaciones_punto_nuevo" style='width: 100px;'><tbody>
															<?php foreach ($lista_por_tecnicos['instalaciones_punto_nuevo'][$key1] as $key => $value2) {
																echo "<tr class='instalaciones_punto_nuevo_".$key."' ><td style='width: 100px;text-align: center;'>".($value2['puntos_adicionales']['puntuacion']+$value2['puntos_adicionales_multiples']['puntuacion'])."p</td></tr>";																
															} ?>	
														</tbody></table> 	
												</td>
											<?php } ?>

												
											
											<td align="center" >
												<div   class="cl-instalaciones_punto_nuevo" style="cursor: pointer;" onclick="desactivar_activar_tabla_instalaciones_punto_nuevo()"><?php echo $conteo; ?></div>
														<table class="tb_tec_info_instalaciones_punto_nuevo" style='width: 200px;text-align: center;'><tbody>
															<?php foreach ($lista_datos_cuentas_tipos_por_tecnico['instalaciones_punto_nuevo'] as $key => $value2) {
																echo "<tr class='instalaciones_punto_nuevo_".$key."' ><td style='width: 200px;'><strong>".($value2['puntos_adicionales']['puntuacion']+$value2['puntos_adicionales_multiples']['puntuacion'])."</strong> pts </td></tr>";																
															} ?>	
														</tbody></table> 	
											</td>
										</tr>
									<tr>
											<td class="static">
												<div class="cl-instalaciones_recuperacion_cable_modem" style="cursor: pointer;" onclick="desactivar_activar_tabla_instalaciones_recuperacion_cable_modem()"><i><u>Rec. modem</u></i></div>
												
													<table class="tb_tec_info_instalaciones_recuperacion_cable_modem"><tbody>
														<?php $lista_clases_css37=""; 
															foreach ($lista_de_tecnicos as $key => $value) {
																$name_class="instalaciones_recuperacion_cable_modem_".$value['username'];
																$lista_clases_css37.=",.".$name_class."";
																echo "<tr class='".$name_class."'><td>".$value['username']."</td></tr>";
														}  ?>	
														
													</tbody></table> 
											</td>
											<?php $conteo=0; foreach ($tipos['instalaciones_recuperacion_cable_modem'] as $key1=> $row) {?>												
												<td class="first-col" style="padding-right: 0px;padding-left: 0px;text-align: center;vertical-align: middle;">
													<div class="cl-instalaciones_recuperacion_cable_modem" style="cursor: pointer;" onclick="desactivar_activar_tabla_instalaciones_recuperacion_cable_modem()"><?php echo $row;$conteo+=$row; ?></div>
														
														<table class="tb_tec_info_instalaciones_recuperacion_cable_modem" style='width: 100px;vertical-align: middle;'><tbody>
															<?php foreach ($lista_por_tecnicos['instalaciones_recuperacion_cable_modem'][$key1] as $key => $value2) {
																echo "<tr class='instalaciones_recuperacion_cable_modem_".$key."' ><td style='width: 100px;text-align: center;'>".($value2['puntuacion'])."p</td></tr>";																
															} ?>	
														</tbody></table> 	
												</td>
											<?php } ?>

												
											
											<td align="center" style="vertical-align: middle;" >
												<div   class="cl-instalaciones_recuperacion_cable_modem" style="cursor: pointer;" onclick="desactivar_activar_tabla_instalaciones_recuperacion_cable_modem()"><?php echo $conteo; ?></div>
														<table class="tb_tec_info_instalaciones_recuperacion_cable_modem" style='width: 200px;text-align: center;vertical-align: middle;'><tbody>
															<?php foreach ($lista_datos_cuentas_tipos_por_tecnico['instalaciones_recuperacion_cable_modem'] as $key => $value2) {
																echo "<tr class='instalaciones_recuperacion_cable_modem_".$key."' ><td style='width: 200px;'><strong>".($value2['puntuacion'])."</strong> pts </td></tr>";																
															} ?>	
														</tbody></table> 	
											</td>
										</tr>	
									<tr>
										<tr>
											<td class="static">
												<div class="cl-instalaciones_veeduria" style="cursor: pointer;" onclick="desactivar_activar_tabla_instalaciones_veeduria()"><i><u>Veeduria</u></i></div>
												
													<table class="tb_tec_info_instalaciones_veeduria"><tbody>
														<?php $lista_clases_css47=""; 
															foreach ($lista_de_tecnicos as $key => $value) {
																$name_class="instalaciones_veeduria_".$value['username'];
																$lista_clases_css47.=",.".$name_class."";
																echo "<tr class='".$name_class."'><td>".$value['username']."</td></tr>";
														}  ?>	
														
													</tbody></table> 
											</td>
											<?php $conteo=0; foreach ($tipos['instalaciones_veeduria'] as $key1=> $row) {?>												
												<td class="first-col" style="padding-right: 0px;padding-left: 0px;text-align: center;vertical-align: middle;">
													<div class="cl-instalaciones_veeduria" style="cursor: pointer;" onclick="desactivar_activar_tabla_instalaciones_veeduria()"><?php echo $row;$conteo+=$row; ?></div>
														
														<table class="tb_tec_info_instalaciones_veeduria" style='width: 100px;vertical-align: middle;'><tbody>
															<?php foreach ($lista_por_tecnicos['instalaciones_veeduria'][$key1] as $key => $value2) {
																echo "<tr class='instalaciones_veeduria_".$key."' ><td style='width: 100px;text-align: center;'>".($value2['puntuacion'])."p</td></tr>";																
															} ?>	
														</tbody></table> 	
												</td>
											<?php } ?>

												
											
											<td align="center" style="vertical-align: middle;" >
												<div   class="cl-instalaciones_veeduria" style="cursor: pointer;" onclick="desactivar_activar_tabla_instalaciones_veeduria()"><?php echo $conteo; ?></div>
														<table class="tb_tec_info_instalaciones_veeduria" style='width: 200px;text-align: center;vertical-align: middle;'><tbody>
															<?php foreach ($lista_datos_cuentas_tipos_por_tecnico['instalaciones_veeduria'] as $key => $value2) {
																echo "<tr class='instalaciones_veeduria_".$key."' ><td style='width: 200px;'><strong>".($value2['puntuacion'])."</strong> pts </td></tr>";																
															} ?>	
														</tbody></table> 	
											</td>
										</tr>
                                            <td class="static">
                                                <div class="cl-tareas_en_proyectos" style="cursor: pointer;" onclick="desactivar_activar_tabla_tareas_en_proyectos()"><i><u>Tareas</u></i></div>
                                                
                                                    <table class="tb_tec_info_tareas_en_proyectos"><tbody>
                                                        <?php $lista_clases_css20=""; 
                                                            foreach ($lista_de_tecnicos as $key => $value) {
                                                                $name_class="tareas_en_proyectos_".$value['username'];
                                                                $lista_clases_css17.=",.".$name_class."";
                                                                echo "<tr class='".$name_class."'><td>".$value['username']."</td></tr>";
                                                        }  ?>   
                                                        
                                                    </tbody></table> 
                                            </td>
                                            <?php $conteo=0; foreach ($tipos['tareas_en_proyectos'] as $key1=> $row) {?>                                                
                                                <td class="first-col" style="padding-right: 0px;padding-left: 0px;text-align: center;">
                                                    <div class="cl-tareas_en_proyectos" style="cursor: pointer;" onclick="desactivar_activar_tabla_tareas_en_proyectos()"><?php echo $row;$conteo+=$row; ?></div>
                                                        
                                                        <table class="tb_tec_info_tareas_en_proyectos" style='width: 100px;'><tbody>
                                                            <?php foreach ($lista_por_tecnicos['tareas_en_proyectos'][$key1] as $key => $value2) {
                                                                echo "<tr class='tareas_en_proyectos_".$key."' ><td style='width: 100px;text-align: center;'>".($value2['puntuacion'])."p</td></tr>";                                                               
                                                            } ?>    
                                                        </tbody></table>    
                                                </td>
                                            <?php } ?>

                                                
                                            
                                            <td align="center" >
                                                <div   class="cl-tareas_en_proyectos" style="cursor: pointer;" onclick="desactivar_activar_tabla_tareas_en_proyectos()"><?php echo $conteo; ?></div>
                                                        <table class="tb_tec_info_tareas_en_proyectos" style='width: 200px;text-align: center;'><tbody>
                                                            <?php foreach ($lista_datos_cuentas_tipos_por_tecnico['tareas_en_proyectos'] as $key => $value2) {
                                                                echo "<tr class='tareas_en_proyectos_".$key."' ><td style='width: 200px;'><strong>".($value2['puntuacion'])."</strong> pts </td></tr>";                                                             
                                                            } ?>    
                                                        </tbody></table>    
                                            </td>
                                        </tr>
										<tr id="detalles_totales">
											<td class="static" style="background-color:#719FD0 ">
												<div class="cl-instalaciones_total" style="cursor: pointer;" onclick="desactivar_activar_tabla_instalaciones_total()"><i><u>TOTAL DIA</u></i></div>
												
													<table class="tb_tec_info_instalaciones_total" style="background-color:#fff "><tbody>
														<?php $lista_clases_css10=""; 
															foreach ($lista_de_tecnicos as $key => $value) {
																$name_class="instalaciones_total_".$value['username'];
																$lista_clases_css10.=",.".$name_class."";
																echo "<tr class='".$name_class."'><td>".$value['username']."</td></tr>";
														}  ?>	
														
													</tbody></table> 
											</td>
											<?php $conteo=0; foreach ($tipos['total_dia'] as $key1=> $row) {?>												
												<td class="first-col" style="padding-right: 0px;padding-left: 0px;text-align: center;background-color:#719FD0 ">
													<div class="cl-instalaciones_total" style="cursor: pointer;" onclick="desactivar_activar_tabla_instalaciones_total()"><?php echo $row;$conteo+=$row; ?></div>
														
														<table class="tb_tec_info_instalaciones_total" style='width: 100px;background-color: #fff;'><tbody>
															<?php foreach ($lista_por_tecnicos['total_dia'][$key1] as $key => $value2) {
																echo "<tr class='instalaciones_total_".$key."' ><td style='width: 100px;text-align: center;'>".($value2)."p</td></tr>";																
															} ?>	
														</tbody></table> 	
												</td>
											<?php } ?>

												
											
											<td align="center" style="background-color:#719FD0 " >
												<div   class="cl-instalaciones_total" style="cursor: pointer;" onclick="desactivar_activar_tabla_instalaciones_total()"><?php echo $conteo; ?></div>
														<table class="tb_tec_info_instalaciones_total" style='width: 200px;text-align: center;background-color:#fff'><tbody>
															<?php foreach ($lista_datos_cuentas_tipos_por_tecnico['instalaciones_tv_e_internet'] as $key => $value2) {
																    $puntuacion_instalaciones_FTTH=array("cantidad"=>0,"puntuacion"=>0);
																    $puntuacion_instalaciones_EOC=array("cantidad"=>0,"puntuacion"=>0);
																    $puntuacion_instalaciones_SIN_TEG=array("cantidad"=>0,"puntuacion"=>0);
																    $puntuacion_instalaciones_TV=array("cantidad"=>0,"puntuacion"=>0);
																    $puntuacion_traslado_EOC=array("cantidad"=>0,"puntuacion"=>0);
																    $puntuacion_traslado_FTTH=array("cantidad"=>0,"puntuacion"=>0);
																    $puntuacion_traslado_TV=array("cantidad"=>0,"puntuacion"=>0);
																    $puntuacion_migracion_FTTH=array("cantidad"=>0,"puntuacion"=>0);//preguntar a cuales ordenes se relaciona
																    $puntuacion_agregar_internet_FTTH=array("cantidad"=>0,"puntuacion"=>0);
																    $puntuacion_agregar_internet_EOC=array("cantidad"=>0,"puntuacion"=>0);
																    $puntuacion_agregar_internet_SIN_TEG=array("cantidad"=>0,"puntuacion"=>0);
																    $puntuacion_agregar_tv=array("cantidad"=>0,"puntuacion"=>0);
																    $puntuacion_punto_adicional=array("cantidad"=>0,"puntuacion"=>0);
																    $puntuacion_punto_adicional_multiple=array("cantidad"=>0,"puntuacion"=>0);
																    $puntuacion_revision_internet=array("cantidad"=>0,"puntuacion"=>0);
																    $puntuacion_revision_tv=array("cantidad"=>0,"puntuacion"=>0);
																    $puntuacion_reconexion=array("cantidad"=>0,"puntuacion"=>0);
																    $puntuacion_desconexion=array("cantidad"=>0,"puntuacion"=>0);
																    $puntuacion_suspencion=array("cantidad"=>0,"puntuacion"=>0);
																    $puntuacion_recuperacion=array("cantidad"=>0,"puntuacion"=>0);
																    $puntuacion_veeduria=array("cantidad"=>0,"puntuacion"=>0);
																    $puntuacion_tareas=array("cantidad"=>0,"puntuacion"=>0);

																$x=$lista_datos_cuentas_tipos_por_tecnico['instalaciones_tv_e_internet'][$key];
																$total=$x['FTTH']['puntuacion']+$x['EOC']['puntuacion']+$x['puntos_adicionales']['puntuacion']+$x['puntos_adicionales_multiples']['puntuacion'];
																	$puntuacion_instalaciones_FTTH=$x['FTTH'];
																	$puntuacion_instalaciones_EOC=$x['EOC'];
																	$puntuacion_punto_adicional=$x['puntos_adicionales'];
																	$puntuacion_punto_adicional_multiple=$x['puntos_adicionales_multiples'];

																$x=$lista_datos_cuentas_tipos_por_tecnico['instalaciones_internet'][$key];
																$total+=$x['FTTH']['puntuacion']+$x['EOC']['puntuacion']+$x['TV']['puntuacion'];

																$puntuacion_instalaciones_FTTH['cantidad']+=$x['FTTH']['cantidad'];
																$puntuacion_instalaciones_FTTH['puntuacion']+=$x['FTTH']['puntuacion'];
																$puntuacion_instalaciones_EOC['cantidad']+=$x['EOC']['cantidad'];
																$puntuacion_instalaciones_EOC['puntuacion']+=$x['EOC']['puntuacion'];
																$puntuacion_instalaciones_SIN_TEG=$x['TV'];

																$x=$lista_datos_cuentas_tipos_por_tecnico['instalaciones_tv'][$key];
																$total+=$x['TV']['puntuacion'];

																$puntuacion_instalaciones_TV=$x['TV'];

																$x=$lista_datos_cuentas_tipos_por_tecnico['instalaciones_Traslado'][$key];
																$total+=$x['FTTH']['puntuacion']+$x['EOC']['puntuacion']+$x['TV']['puntuacion'];
																$puntuacion_traslado_FTTH=$x['FTTH'];
																$puntuacion_traslado_EOC=$x['EOC'];
																$puntuacion_traslado_TV=$x['TV'];

																$x=$lista_datos_cuentas_tipos_por_tecnico['instalaciones_AgregarInternet'][$key];
																$total+=$x['FTTH']['puntuacion']+$x['EOC']['puntuacion']+$x['TV']['puntuacion'];

																	$puntuacion_agregar_internet_FTTH=$x['FTTH'];																	
																	$puntuacion_agregar_internet_EOC=$x['EOC'];
																	$puntuacion_agregar_internet_SIN_TEG=$x['TV'];


																$x=$lista_datos_cuentas_tipos_por_tecnico['instalaciones_Agregar_Tv'][$key];
																$total+=$x['Agregar_Tv']['puntuacion']+$x['puntos_adicionales']['puntuacion']+$x['puntos_adicionales_multiples']['puntuacion'];
																	$puntuacion_agregar_tv=$x['Agregar_Tv'];
																	$puntuacion_punto_adicional['cantidad']+=$x['puntos_adicionales']['cantidad'];
																	$puntuacion_punto_adicional['puntuacion']+=$x['puntos_adicionales']['puntuacion'];
																	$puntuacion_punto_adicional_multiple['cantidad']+=$x['puntos_adicionales_multiples']['cantidad'];
																	$puntuacion_punto_adicional_multiple['puntuacion']+=$x['puntos_adicionales_multiples']['puntuacion'];

																$x=$lista_datos_cuentas_tipos_por_tecnico['instalaciones_punto_nuevo'][$key];
																$total+=$x['Agregar_Tv']['puntuacion'];
																	//$puntuacion_agregar_tv=$x['Agregar_Tv'];
																	$puntuacion_punto_adicional['cantidad']+=$x['puntos_adicionales']['cantidad'];
																	$puntuacion_punto_adicional['puntuacion']+=$x['puntos_adicionales']['puntuacion'];
																	$puntuacion_punto_adicional_multiple['cantidad']+=$x['puntos_adicionales_multiples']['cantidad'];
																	$puntuacion_punto_adicional_multiple['puntuacion']+=$x['puntos_adicionales_multiples']['puntuacion'];

																//$x=$lista_datos_cuentas_tipos_por_tecnico['instalaciones_Reconexion'][$key];
																//$total+=$x['Reconexion_de_internet']['puntuacion']+$x['Reconexion_de_tv']['puntuacion'];

																$x=$lista_datos_cuentas_tipos_por_tecnico['instalaciones_Corte_tv_e_internet'][$key];
																$total+=$x['puntuacion'];
																	$puntuacion_desconexion['cantidad']=$x['cantidad'];
																	$puntuacion_desconexion['puntuacion']=$x['puntuacion'];

																$x=$lista_datos_cuentas_tipos_por_tecnico['instalaciones_Corte_Internet'][$key];
																$total+=$x['puntuacion'];
																	$puntuacion_desconexion['cantidad']+=$x['cantidad'];
																	$puntuacion_desconexion['puntuacion']+=$x['puntuacion'];

																$x=$lista_datos_cuentas_tipos_por_tecnico['instalaciones_Corte_Tv'][$key];
																$total+=$x['puntuacion'];
																	$puntuacion_desconexion['cantidad']+=$x['cantidad'];
																	$puntuacion_desconexion['puntuacion']+=$x['puntuacion'];
																/*suspencion*/
																	$x=$lista_datos_cuentas_tipos_por_tecnico['instalaciones_Suspension_Combo'][$key];
																	$total+=$x['puntuacion'];
																		$puntuacion_suspencion['cantidad']=$x['cantidad'];
																		$puntuacion_suspencion['puntuacion']=$x['puntuacion'];

																	$x=$lista_datos_cuentas_tipos_por_tecnico['instalaciones_Suspension_Internet'][$key];
																	$total+=$x['puntuacion'];
																		$puntuacion_suspencion['cantidad']+=$x['cantidad'];
																		$puntuacion_suspencion['puntuacion']+=$x['puntuacion'];

																	$x=$lista_datos_cuentas_tipos_por_tecnico['instalaciones_Suspension_Television'][$key];
																	$total+=$x['puntuacion'];
																		$puntuacion_suspencion['cantidad']+=$x['cantidad'];
																		$puntuacion_suspencion['puntuacion']+=$x['puntuacion'];
																/**/

																$x=$lista_datos_cuentas_tipos_por_tecnico['instalaciones_Reconexion_tv_e_internet'][$key];
																$total+=$x['puntuacion'];
																$puntuacion_reconexion=$x;

																$x=$lista_datos_cuentas_tipos_por_tecnico['instalaciones_Reconexion_tv'][$key];
																$total+=$x['puntuacion'];
																	$puntuacion_reconexion['cantidad']+=$x['cantidad'];
																	$puntuacion_reconexion['puntuacion']+=$x['puntuacion'];

																$x=$lista_datos_cuentas_tipos_por_tecnico['instalaciones_Reconexion_internet'][$key];
																$total+=$x['puntuacion'];
																	$puntuacion_reconexion['cantidad']+=$x['cantidad'];
																	$puntuacion_reconexion['puntuacion']+=$x['puntuacion'];

																$x=$lista_datos_cuentas_tipos_por_tecnico['instalaciones_recuperacion_cable_modem'][$key];
																$total+=$x['puntuacion'];
																	$puntuacion_recuperacion['cantidad']+=$x['cantidad'];
																	$puntuacion_recuperacion['puntuacion']+=$x['puntuacion'];

																$x=$lista_datos_cuentas_tipos_por_tecnico['instalaciones_veeduria'][$key];
																$total+=$x['puntuacion'];
																	$puntuacion_veeduria['cantidad']+=$x['cantidad'];
																	$puntuacion_veeduria['puntuacion']+=$x['puntuacion'];

																$x=$lista_datos_cuentas_tipos_por_tecnico['instalaciones_Revision_tv_e_internet'][$key];
																$total+=$x['puntuacion'];
																	$puntuacion_revision_tv=$x;
																    $puntuacion_revision_internet=$x;

																$x=$lista_datos_cuentas_tipos_por_tecnico['instalaciones_Revision_tv'][$key];
																$total+=$x['puntuacion'];
																	$puntuacion_revision_tv['cantidad']+=$x['cantidad'];
																	$puntuacion_revision_tv['puntuacion']+=$x['puntuacion'];
																    
																$x=$lista_datos_cuentas_tipos_por_tecnico['instalaciones_Revision_internet'][$key];
																$total+=$x['puntuacion'];
																	$puntuacion_revision_internet['cantidad']+=$x['cantidad'];
																	$puntuacion_revision_internet['puntuacion']+=$x['puntuacion'];
																$x=$lista_datos_cuentas_tipos_por_tecnico['instalaciones_migracion'][$key];
																$total+=$x['puntuacion'];
																$puntuacion_migracion_FTTH=$x;

																$x=$lista_datos_cuentas_tipos_por_tecnico['tareas_en_proyectos'][$key];
																$total+=$x['puntuacion'];
																$puntuacion_tareas=$x;

																$puntuaciones=" data-instalaciones-ftth='".$puntuacion_instalaciones_FTTH['cantidad'].",".$puntuacion_instalaciones_FTTH['puntuacion']."' 
																				data-instalaciones-eoc='".$puntuacion_instalaciones_EOC['cantidad'].",".$puntuacion_instalaciones_EOC['puntuacion']."' 
																				data-instalaciones-sin-teg='".$puntuacion_instalaciones_SIN_TEG['cantidad'].",".$puntuacion_instalaciones_SIN_TEG['puntuacion']."' 
																				data-instalaciones-tv='".$puntuacion_instalaciones_TV['cantidad'].",".$puntuacion_instalaciones_TV['puntuacion']."' 
																				data-instalaciones-traslado-ftth='".$puntuacion_traslado_FTTH['cantidad'].",".$puntuacion_traslado_FTTH['puntuacion']."' 
																				data-instalaciones-traslado-eoc='".$puntuacion_traslado_EOC['cantidad'].",".$puntuacion_traslado_EOC['puntuacion']."'  
																				data-instalaciones-traslado-tv='".$puntuacion_traslado_TV['cantidad'].",".$puntuacion_traslado_TV['puntuacion']."'  
																				data-instalaciones-migracion='".$puntuacion_migracion_FTTH['cantidad'].",".$puntuacion_migracion_FTTH['puntuacion']."' 
																				data-instalaciones-agregar-internet-ftth='".$puntuacion_agregar_internet_FTTH['cantidad'].",".$puntuacion_agregar_internet_FTTH['puntuacion']."' 
																				data-instalaciones-agregar-internet-eoc='".$puntuacion_agregar_internet_EOC['cantidad'].",".$puntuacion_agregar_internet_EOC['puntuacion']."' 
																				data-instalaciones-agregar-internet-sin-teg='".$puntuacion_agregar_internet_SIN_TEG['cantidad'].",".$puntuacion_agregar_internet_SIN_TEG['puntuacion']."' 
																				data-instalaciones-agregar-tv='".$puntuacion_agregar_tv['cantidad'].",".$puntuacion_agregar_tv['puntuacion']."' 
																				data-instalaciones-puntos-adicionales='".$puntuacion_punto_adicional['cantidad'].",".$puntuacion_punto_adicional['puntuacion']."' 
																				data-instalaciones-puntos-adicionales-multiples='".$puntuacion_punto_adicional_multiple['cantidad'].",".$puntuacion_punto_adicional_multiple['puntuacion']."' 
																				data-instalaciones-revision-internet='".$puntuacion_revision_internet['cantidad'].",".$puntuacion_revision_internet['puntuacion']."' 
																				data-instalaciones-revision-tv='".$puntuacion_revision_tv['cantidad'].",".$puntuacion_revision_tv['puntuacion']."' 
																				data-instalaciones-reconexion='".$puntuacion_reconexion['cantidad'].",".$puntuacion_reconexion['puntuacion']."' 
																				data-instalaciones-desconexion='".$puntuacion_desconexion['cantidad'].",".$puntuacion_desconexion['puntuacion']."' 
																				data-instalaciones-suspencion='".$puntuacion_suspencion['cantidad'].",".$puntuacion_suspencion['puntuacion']."' 
																				data-instalaciones-veeduria='".$puntuacion_recuperacion['cantidad'].",".$puntuacion_recuperacion['puntuacion']."' 
																				data-instalaciones-recuperacion='".$puntuacion_veeduria['cantidad'].",".$puntuacion_veeduria['puntuacion']."' 
																				data-tareas='".$puntuacion_tareas['cantidad'].",".$puntuacion_tareas['puntuacion']."' "; 

																echo "<tr class='instalaciones_total_".$key."' ><td style='width: 200px;cursor:pointer;' class='td_totalizador' data-username='".$key."' ".$puntuaciones." ><strong>".($total)."</strong> pts </td></tr>";																
															} ?>	
														</tbody></table> 	
											</td>
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

<div id="modal_informativo" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Descripcion usuario : <strong id="modal_username"></strong></h4>
            </div>
            <div class="modal-body" style="text-align:center;">
            <div class="table-responsive ">
                <table class="table mb-1 table-hover" style="display: inline;text-align: center;">
                	<thead>
                		<tr>
                			<th>Tipo de Servicio</th>
                			<th>Cantidad</th>
                			<th>Puntuacion</th>
                		</tr>
                	</thead>
                	<tbody>
                		<tr>
                			<td>Instalación Ftth</td>
                			<td id="modal-instalaciones-ftth-c">0</td>
                			<td id="modal-instalaciones-ftth-p">0</td>
                		</tr>
                		<tr>
                			<td>Instalación EOC</td>
                			<td id="modal-instalaciones-eoc-c">0</td>
                			<td id="modal-instalaciones-eoc-p">0</td>
                		</tr>
                		<tr>
                			<td>Instalación Sin Teg.</td>
                			<td id="modal-instalaciones-sin-teg-c">0</td>
                			<td id="modal-instalaciones-sin-teg-p">0</td>
                		</tr>
                		<tr>
                			<td>Instalación Tv</td>
                			<td id="modal-instalaciones-tv-c">0</td>
                			<td id="modal-instalaciones-tv-p">0</td>
                		</tr>
                		<tr>
                			<td>Traslado EOC</td>
                			<td id="modal-instalaciones-traslado-eoc-c">0</td>
                			<td id="modal-instalaciones-traslado-eoc-p">0</td>
                		</tr>
                		<tr>
                			<td>Traslado Ftth</td>
                			<td id="modal-instalaciones-traslado-ftth-c">0</td>
                			<td id="modal-instalaciones-traslado-ftth-p">0</td>
                		</tr>
                		<tr>
                			<td>Traslado TV</td>
                			<td id="modal-instalaciones-traslado-tv-c">0</td>
                			<td id="modal-instalaciones-traslado-tv-p">0</td>
                		</tr>
                		<tr>
                			<td>Migracion Ftth</td>
                			<td id="modal-instalaciones-migracion-ftth-c">0</td>
                			<td id="modal-instalaciones-migracion-ftth-p">0</td>
                		</tr>
                		<tr>
                			<td>Agregar Internet Ftth</td>
                			<td id="modal-instalaciones-agregar-internet-ftth-c">0</td>
                			<td id="modal-instalaciones-agregar-internet-ftth-p">0</td>
                		</tr>
                		<tr>
                			<td>Agregar Internet EOC</td>
                			<td id="modal-instalaciones-agregar-internet-eoc-c">0</td>
                			<td id="modal-instalaciones-agregar-internet-eoc-p">0</td>
                		</tr>
                		<tr>
                			<td>Agregar Internet Sin Teg.</td>
                			<td id="modal-instalaciones-agregar-internet-sin-teg-c">0</td>
                			<td id="modal-instalaciones-agregar-internet-sin-teg-p">0</td>
                		</tr>
                		<tr>
                			<td>Agregar tv</td>
                			<td id="modal-instalaciones-agregar-tv-c">0</td>
                			<td id="modal-instalaciones-agregar-tv-p">0</td>
                		</tr>
                		<tr>
                			<td>Punto Adicional</td>
                			<td id="modal-instalaciones-punto-adicional-c">0</td>
                			<td id="modal-instalaciones-punto-adicional-p">0</td>
                		</tr>
                		<tr>
                			<td>Punto Adicional Multiple</td>
                			<td id="modal-instalaciones-punto-adicional-m-c">0</td>
                			<td id="modal-instalaciones-punto-adicional-m-p">0</td>
                		</tr>
                		<tr>
                			<td>Revision de internet</td>
                			<td id="modal-instalaciones-revision-internet-c">0</td>
                			<td id="modal-instalaciones-revision-internet-p">0</td>
                		</tr>
                		<tr>
                			<td>Revision de Tv</td>
                			<td id="modal-instalaciones-revision-tv-c">0</td>
                			<td id="modal-instalaciones-revision-tv-p">0</td>
                		</tr>
                		<tr>
                			<td>Reconexion</td>
                			<td id="modal-instalaciones-reconexion-c">0</td>
                			<td id="modal-instalaciones-reconexion-p">0</td>
                		</tr>
                		<tr>
                			<td>Desconexion</td>
                			<td id="modal-instalaciones-desconexion-c">0</td>
                			<td id="modal-instalaciones-desconexion-p">0</td>
                		</tr>
                		<tr>
                			<td>Suspencion</td>
                			<td id="modal-instalaciones-suspencion-c">0</td>
                			<td id="modal-instalaciones-suspencion-p">0</td>
                		</tr>
                		<tr>
                			<td>Veeduria</td>
                			<td id="modal-instalaciones-veeduria-c">0</td>
                			<td id="modal-instalaciones-veeduria-p">0</td>
                		</tr>
                		<tr>
                			<td>Recuperación Cable Modem</td>
                			<td id="modal-instalaciones-recuperacion-c">0</td>
                			<td id="modal-instalaciones-recuperacion-p">0</td>
                		</tr>
                		<tr>
                			<td>Tareas</td>
                			<td id="modal-tareas-c">0</td>
                			<td id="modal-tareas-p">0</td>
                		</tr>

                	</tbody>
                	<tfoot>
                		<tr>
                			<th style="vertical-align: middle;"><strong >Total:</strong></th>
                			<th style="vertical-align: middle;text-align: center;" id="cantidad-td"></th>
                			<th style="text-align: center;"><strong id="modal-total">0</strong><br><strong id="modal-total-precio">$0</strong></th>
                		</tr>
                	</tfoot>
                </table>
            </div>

            </div>
            <div class="modal-footer">
                
                <button type="button" data-dismiss="modal"
                        class="btn"><?php echo $this->lang->line('Cancel') ?> </button>
                        <button type="button" data-dismiss="modal"
                        class="btn btn-success">Aceptar</button>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
	document.addEventListener("DOMContentLoaded", function(event) {
		$(".td_totalizador").click(function (ev){
			$("#modal_username").text($(this).data("username"));
			 var total_puntuacion=0;
			 var cantidad=0;
			var datax=$(this).data("instalaciones-ftth").split(",");
			$("#modal-instalaciones-ftth-c").text(datax[0]);
			$("#modal-instalaciones-ftth-p").text(datax[1]);
			total_puntuacion+=parseInt(datax[1]);
			cantidad+=parseInt(datax[0]);
			var datax=$(this).data("instalaciones-eoc").split(",");
			$("#modal-instalaciones-eoc-c").text(datax[0]);
			$("#modal-instalaciones-eoc-p").text(datax[1]);
			total_puntuacion+=parseInt(datax[1]);
			cantidad+=parseInt(datax[0]);

			var datax=$(this).data("instalaciones-sin-teg").split(",");
			$("#modal-instalaciones-sin-teg-c").text(datax[0]);
			$("#modal-instalaciones-sin-teg-p").text(datax[1]);
			total_puntuacion+=parseInt(datax[1]);
			cantidad+=parseInt(datax[0]);

			var datax=$(this).data("instalaciones-tv").split(",");
			$("#modal-instalaciones-tv-c").text(datax[0]);
			$("#modal-instalaciones-tv-p").text(datax[1]);
			total_puntuacion+=parseInt(datax[1]);
			cantidad+=parseInt(datax[0]);

			var datax=$(this).data("instalaciones-traslado-eoc").split(",");
			$("#modal-instalaciones-traslado-eoc-c").text(datax[0]);
			$("#modal-instalaciones-traslado-eoc-p").text(datax[1]);
			total_puntuacion+=parseInt(datax[1]);
			cantidad+=parseInt(datax[0]);
			var datax=$(this).data("instalaciones-traslado-ftth").split(",");
			$("#modal-instalaciones-traslado-ftth-c").text(datax[0]);
			$("#modal-instalaciones-traslado-ftth-p").text(datax[1]);
			total_puntuacion+=parseInt(datax[1]);
			cantidad+=parseInt(datax[0]);

			var datax=$(this).data("instalaciones-traslado-tv").split(",");
			$("#modal-instalaciones-traslado-tv-c").text(datax[0]);
			$("#modal-instalaciones-traslado-tv-p").text(datax[1]);
			total_puntuacion+=parseInt(datax[1]);
			cantidad+=parseInt(datax[0]);

			var datax=$(this).data("instalaciones-migracion").split(",");
			$("#modal-instalaciones-migracion-ftth-c").text(datax[0]);
			$("#modal-instalaciones-migracion-ftth-p").text(datax[1]);
			total_puntuacion+=parseInt(datax[1]);
			cantidad+=parseInt(datax[0]);
			var datax=$(this).data("instalaciones-agregar-internet-ftth").split(",");
			$("#modal-instalaciones-agregar-internet-ftth-c").text(datax[0]);
			$("#modal-instalaciones-agregar-internet-ftth-p").text(datax[1]);
			total_puntuacion+=parseInt(datax[1]);
			cantidad+=parseInt(datax[0]);
			var datax=$(this).data("instalaciones-agregar-internet-eoc").split(",");
			$("#modal-instalaciones-agregar-internet-eoc-c").text(datax[0]);
			$("#modal-instalaciones-agregar-internet-eoc-p").text(datax[1]);
			total_puntuacion+=parseInt(datax[1]);
			cantidad+=parseInt(datax[0]);

			var datax=$(this).data("instalaciones-agregar-internet-sin-teg").split(",");
			$("#modal-instalaciones-agregar-internet-sin-teg-c").text(datax[0]);
			$("#modal-instalaciones-agregar-internet-sin-teg-p").text(datax[1]);
			total_puntuacion+=parseInt(datax[1]);
			cantidad+=parseInt(datax[0]);

			var datax=$(this).data("instalaciones-agregar-tv").split(",");
			$("#modal-instalaciones-agregar-tv-c").text(datax[0]);
			$("#modal-instalaciones-agregar-tv-p").text(datax[1]);
			total_puntuacion+=parseInt(datax[1]);
			cantidad+=parseInt(datax[0]);
			var datax=$(this).data("instalaciones-puntos-adicionales").split(",");
			$("#modal-instalaciones-punto-adicional-c").text(datax[0]);
			$("#modal-instalaciones-punto-adicional-p").text(datax[1]);
			total_puntuacion+=parseInt(datax[1]);
			cantidad+=parseInt(datax[0]);
			var datax=$(this).data("instalaciones-puntos-adicionales-multiples").split(",");
			$("#modal-instalaciones-punto-adicional-m-c").text(datax[0]);
			$("#modal-instalaciones-punto-adicional-m-p").text(datax[1]);
			total_puntuacion+=parseInt(datax[1]);
			cantidad+=parseInt(datax[0]);
			

			var datax=$(this).data("instalaciones-revision-internet").split(",");
			$("#modal-instalaciones-revision-internet-c").text(datax[0]);
			$("#modal-instalaciones-revision-internet-p").text(datax[1]);
			total_puntuacion+=parseInt(datax[1]);
			cantidad+=parseInt(datax[0]);
			var datax=$(this).data("instalaciones-revision-tv").split(",");
			$("#modal-instalaciones-revision-tv-c").text(datax[0]);
			$("#modal-instalaciones-revision-tv-p").text(datax[1]);
			total_puntuacion+=parseInt(datax[1]);
			cantidad+=parseInt(datax[0]);
			var datax=$(this).data("instalaciones-reconexion").split(",");
			$("#modal-instalaciones-reconexion-c").text(datax[0]);
			$("#modal-instalaciones-reconexion-p").text(datax[1]);
			total_puntuacion+=parseInt(datax[1]);
			cantidad+=parseInt(datax[0]);
			var datax=$(this).data("instalaciones-desconexion").split(",");
			$("#modal-instalaciones-desconexion-c").text(datax[0]);
			$("#modal-instalaciones-desconexion-p").text(datax[1]);
			total_puntuacion+=parseInt(datax[1]);
			cantidad+=parseInt(datax[0]);

			var datax=$(this).data("instalaciones-suspencion").split(",");
			$("#modal-instalaciones-suspencion-c").text(datax[0]);
			$("#modal-instalaciones-suspencion-p").text(datax[1]);
			total_puntuacion+=parseInt(datax[1]);
			cantidad+=parseInt(datax[0]);

			var datax=$(this).data("instalaciones-veeduria").split(",");
			$("#modal-instalaciones-veeduria-c").text(datax[0]);
			$("#modal-instalaciones-veeduria-p").text(datax[1]);
			total_puntuacion+=parseInt(datax[1]);
			cantidad+=parseInt(datax[0]);

			var datax=$(this).data("instalaciones-recuperacion").split(",");
			$("#modal-instalaciones-recuperacion-c").text(datax[0]);
			$("#modal-instalaciones-recuperacion-p").text(datax[1]);
			total_puntuacion+=parseInt(datax[1]);
			cantidad+=parseInt(datax[0]);

			var datax=$(this).data("tareas").split(",");
			$("#modal-tareas-c").text(datax[0]);
			$("#modal-tareas-p").text(datax[1]);
			total_puntuacion+=parseInt(datax[1]);
			cantidad+=parseInt(datax[0]);

			var total_precio=0;
			if(total_puntuacion>=165 && total_puntuacion <=200){
				total_precio=total_puntuacion*600;
			}else if(total_puntuacion>200){ 
				total_precio=total_puntuacion*800;
			}
			total_precio= new Intl.NumberFormat('es-ES', {  }).format(total_precio);
			$("#modal-total-precio").text("$ "+total_precio);
			$("#modal-total").text(total_puntuacion);
			$("#cantidad-td").text(cantidad);
			$("#modal_informativo").modal("show");
		});

		var lista_clases_css1="<?=$lista_clases_css1 ?>";
		var lista_clases_css2="<?=$lista_clases_css2 ?>";
		var lista_clases_css3="<?=$lista_clases_css3 ?>";
		var lista_clases_css4="<?=$lista_clases_css4 ?>";
		var lista_clases_css5="<?=$lista_clases_css5 ?>";
		var lista_clases_css7="<?=$lista_clases_css7 ?>";
		var lista_clases_css8="<?=$lista_clases_css8 ?>";
		var lista_clases_css9="<?=$lista_clases_css9 ?>";
		var lista_clases_css10="<?=$lista_clases_css10 ?>";
		var lista_clases_css11="<?=$lista_clases_css11 ?>";
		var lista_clases_css12="<?=$lista_clases_css12 ?>";
		var lista_clases_css13="<?=$lista_clases_css13 ?>";
		var lista_clases_css14="<?=$lista_clases_css14 ?>";
		var lista_clases_css15="<?=$lista_clases_css15 ?>";
		var lista_clases_css16="<?=$lista_clases_css16 ?>";
		var lista_clases_css17="<?=$lista_clases_css17 ?>";
		var lista_clases_css20="<?=$lista_clases_css20 ?>";
		var lista_clases_css27="<?=$lista_clases_css27 ?>";
		var lista_clases_css37="<?=$lista_clases_css37 ?>";
		var lista_clases_css47="<?=$lista_clases_css47 ?>";
		
			$(".cl-instalaciones_tv_e_internet"+lista_clases_css1).mouseover(function(){
				var x1="."+$(this).attr("class");
				$(x1).css("background-color","#d2b48c");
				
				
				$(x1).css("box-shadow","1px 1px #53a7ea,2px 2px #53a7ea,3px 3px #53a7ea");
				/*$(x1).css("-webkit-transform","translateX(-7px)");
				$(x1).css("transform","translateX(-7px)");*/
			});
			
			$(".cl-instalaciones_tv_e_internet"+lista_clases_css1).mouseout(function (){
				var x1="."+$(this).attr("class");
				$(x1).css("background-color","");
				$(x1).css("box-shadow","");
				/*$(x1).css("-webkit-transform","");
				$(x1).css("transform","");*/
			});

			$(".cl-instalaciones_internet"+lista_clases_css2).mouseover(function(){
				var x1="."+$(this).attr("class");
				$(x1).css("background-color","#d2b48c");
				
				
				$(x1).css("box-shadow","1px 1px #53a7ea,2px 2px #53a7ea,3px 3px #53a7ea");
				/*$(x1).css("-webkit-transform","translateX(-7px)");
				$(x1).css("transform","translateX(-7px)");*/
			});
			
			$(".cl-instalaciones_internet"+lista_clases_css2).mouseout(function (){
				var x1="."+$(this).attr("class");
				$(x1).css("background-color","");
				$(x1).css("box-shadow","");
				/*$(x1).css("-webkit-transform","");
				$(x1).css("transform","");*/
			});

			$(".cl-instalaciones_Agregar_Tv"+lista_clases_css3).mouseover(function(){
				var x1="."+$(this).attr("class");
				$(x1).css("background-color","#d2b48c");
				
				
				$(x1).css("box-shadow","1px 1px #53a7ea,2px 2px #53a7ea,3px 3px #53a7ea");
				/*$(x1).css("-webkit-transform","translateX(-7px)");
				$(x1).css("transform","translateX(-7px)");*/
			});
			
			$(".cl-instalaciones_Agregar_Tv"+lista_clases_css3).mouseout(function (){
				var x1="."+$(this).attr("class");
				$(x1).css("background-color","");
				$(x1).css("box-shadow","");
				/*$(x1).css("-webkit-transform","");
				$(x1).css("transform","");*/
			});
			$(".cl-instalaciones_punto_nuevo"+lista_clases_css27).mouseover(function(){
				var x1="."+$(this).attr("class");
				$(x1).css("background-color","#d2b48c");
				
				
				$(x1).css("box-shadow","1px 1px #53a7ea,2px 2px #53a7ea,3px 3px #53a7ea");
				/*$(x1).css("-webkit-transform","translateX(-7px)");
				$(x1).css("transform","translateX(-7px)");*/
			});
			
			$(".cl-instalaciones_punto_nuevo"+lista_clases_css27).mouseout(function (){
				var x1="."+$(this).attr("class");
				$(x1).css("background-color","");
				$(x1).css("box-shadow","");
				/*$(x1).css("-webkit-transform","");
				$(x1).css("transform","");*/
			});

			$(".cl-instalaciones_Traslado"+lista_clases_css4).mouseover(function(){
				var x1="."+$(this).attr("class");
				$(x1).css("background-color","#d2b48c");
				
				
				$(x1).css("box-shadow","1px 1px #53a7ea,2px 2px #53a7ea,3px 3px #53a7ea");
				/*$(x1).css("-webkit-transform","translateX(-7px)");
				$(x1).css("transform","translateX(-7px)");*/
			});
			
			$(".cl-instalaciones_Traslado"+lista_clases_css4).mouseout(function (){
				var x1="."+$(this).attr("class");
				$(x1).css("background-color","");
				$(x1).css("box-shadow","");
				/*$(x1).css("-webkit-transform","");
				$(x1).css("transform","");*/
			});
			$(".cl-instalaciones_AgregarInternet"+lista_clases_css5).mouseover(function(){
				var x1="."+$(this).attr("class");
				$(x1).css("background-color","#d2b48c");
				
				
				$(x1).css("box-shadow","1px 1px #53a7ea,2px 2px #53a7ea,3px 3px #53a7ea");
				/*$(x1).css("-webkit-transform","translateX(-7px)");
				$(x1).css("transform","translateX(-7px)");*/
			});
			
			$(".cl-instalaciones_AgregarInternet"+lista_clases_css5).mouseout(function (){
				var x1="."+$(this).attr("class");
				$(x1).css("background-color","");
				$(x1).css("box-shadow","");
				/*$(x1).css("-webkit-transform","");
				$(x1).css("transform","");*/
			});

			$(".cl-instalaciones_Revision_tv_e_internet"+lista_clases_css7).mouseover(function(){
				var x1="."+$(this).attr("class");
				$(x1).css("background-color","#d2b48c");
				
				
				$(x1).css("box-shadow","1px 1px #53a7ea,2px 2px #53a7ea,3px 3px #53a7ea");
				/*$(x1).css("-webkit-transform","translateX(-7px)");
				$(x1).css("transform","translateX(-7px)");*/
			});
			
			$(".cl-instalaciones_Revision_tv_e_internet"+lista_clases_css7).mouseout(function (){
				var x1="."+$(this).attr("class");
				$(x1).css("background-color","");
				$(x1).css("box-shadow","");
				/*$(x1).css("-webkit-transform","");
				$(x1).css("transform","");*/
			});
			$(".cl-instalaciones_Revision_tv"+lista_clases_css15).mouseover(function(){
				var x1="."+$(this).attr("class");
				$(x1).css("background-color","#d2b48c");
				
				
				$(x1).css("box-shadow","1px 1px #53a7ea,2px 2px #53a7ea,3px 3px #53a7ea");
				/*$(x1).css("-webkit-transform","translateX(-7px)");
				$(x1).css("transform","translateX(-7px)");*/
			});
			
			$(".cl-instalaciones_Revision_tv"+lista_clases_css15).mouseout(function (){
				var x1="."+$(this).attr("class");
				$(x1).css("background-color","");
				$(x1).css("box-shadow","");
				/*$(x1).css("-webkit-transform","");
				$(x1).css("transform","");*/
			});
			$(".cl-instalaciones_Revision_internet"+lista_clases_css16).mouseover(function(){
				var x1="."+$(this).attr("class");
				$(x1).css("background-color","#d2b48c");
				
				
				$(x1).css("box-shadow","1px 1px #53a7ea,2px 2px #53a7ea,3px 3px #53a7ea");
				/*$(x1).css("-webkit-transform","translateX(-7px)");
				$(x1).css("transform","translateX(-7px)");*/
			});
			
			$(".cl-instalaciones_Revision_internet"+lista_clases_css16).mouseout(function (){
				var x1="."+$(this).attr("class");
				$(x1).css("background-color","");
				$(x1).css("box-shadow","");
				/*$(x1).css("-webkit-transform","");
				$(x1).css("transform","");*/
			});
			$(".cl-instalaciones_Reconexion_tv_e_internet"+lista_clases_css8).mouseover(function(){
				var x1="."+$(this).attr("class");
				$(x1).css("background-color","#d2b48c");
				
				
				$(x1).css("box-shadow","1px 1px #53a7ea,2px 2px #53a7ea,3px 3px #53a7ea");
				/*$(x1).css("-webkit-transform","translateX(-7px)");
				$(x1).css("transform","translateX(-7px)");*/
			});
			
			$(".cl-instalaciones_Reconexion_tv_e_internet"+lista_clases_css8).mouseout(function (){
				var x1="."+$(this).attr("class");
				$(x1).css("background-color","");
				$(x1).css("box-shadow","");
				/*$(x1).css("-webkit-transform","");
				$(x1).css("transform","");*/
			});

			$(".cl-instalaciones_Corte_Tv"+lista_clases_css9).mouseover(function(){
				var x1="."+$(this).attr("class");
				$(x1).css("background-color","#d2b48c");
				
				
				$(x1).css("box-shadow","1px 1px #53a7ea,2px 2px #53a7ea,3px 3px #53a7ea");
				/*$(x1).css("-webkit-transform","translateX(-7px)");
				$(x1).css("transform","translateX(-7px)");*/
			});
			
			$(".cl-instalaciones_Corte_Tv"+lista_clases_css9).mouseout(function (){
				var x1="."+$(this).attr("class");
				$(x1).css("background-color","");
				$(x1).css("box-shadow","");
				/*$(x1).css("-webkit-transform","");
				$(x1).css("transform","");*/
			});
			$(".cl-instalaciones_total"+lista_clases_css10).mouseover(function(){
				var x1="."+$(this).attr("class");
				$(x1).css("background-color","#d2b48c");
				
				
				$(x1).css("box-shadow","1px 1px #53a7ea,2px 2px #53a7ea,3px 3px #53a7ea");
				/*$(x1).css("-webkit-transform","translateX(-7px)");
				$(x1).css("transform","translateX(-7px)");*/
			});
			
			$(".cl-instalaciones_total"+lista_clases_css10).mouseout(function (){
				var x1="."+$(this).attr("class");
				$(x1).css("background-color","");
				$(x1).css("box-shadow","");
				/*$(x1).css("-webkit-transform","");
				$(x1).css("transform","");*/
			});
			$(".cl-instalaciones_Corte_Internet"+lista_clases_css11).mouseover(function(){
				var x1="."+$(this).attr("class");
				$(x1).css("background-color","#d2b48c");
				
				
				$(x1).css("box-shadow","1px 1px #53a7ea,2px 2px #53a7ea,3px 3px #53a7ea");
				/*$(x1).css("-webkit-transform","translateX(-7px)");
				$(x1).css("transform","translateX(-7px)");*/
			});
			
			$(".cl-instalaciones_Corte_Internet"+lista_clases_css11).mouseout(function (){
				var x1="."+$(this).attr("class");
				$(x1).css("background-color","");
				$(x1).css("box-shadow","");
				/*$(x1).css("-webkit-transform","");
				$(x1).css("transform","");*/
			});
			$(".cl-instalaciones_Corte_tv_e_internet"+lista_clases_css12).mouseover(function(){
				var x1="."+$(this).attr("class");
				$(x1).css("background-color","#d2b48c");
				
				
				$(x1).css("box-shadow","1px 1px #53a7ea,2px 2px #53a7ea,3px 3px #53a7ea");
				/*$(x1).css("-webkit-transform","translateX(-7px)");
				$(x1).css("transform","translateX(-7px)");*/
			});
			
			$(".cl-instalaciones_Corte_tv_e_internet"+lista_clases_css12).mouseout(function (){
				var x1="."+$(this).attr("class");
				$(x1).css("background-color","");
				$(x1).css("box-shadow","");
				/*$(x1).css("-webkit-transform","");
				$(x1).css("transform","");*/
			});
			$(".cl-instalaciones_Reconexion_tv"+lista_clases_css13).mouseover(function(){
				var x1="."+$(this).attr("class");
				$(x1).css("background-color","#d2b48c");
				
				
				$(x1).css("box-shadow","1px 1px #53a7ea,2px 2px #53a7ea,3px 3px #53a7ea");
				/*$(x1).css("-webkit-transform","translateX(-7px)");
				$(x1).css("transform","translateX(-7px)");*/
			});
			
			$(".cl-instalaciones_Reconexion_tv"+lista_clases_css13).mouseout(function (){
				var x1="."+$(this).attr("class");
				$(x1).css("background-color","");
				$(x1).css("box-shadow","");
				/*$(x1).css("-webkit-transform","");
				$(x1).css("transform","");*/
			});
			$(".cl-instalaciones_Reconexion_internet"+lista_clases_css14).mouseover(function(){
				var x1="."+$(this).attr("class");
				$(x1).css("background-color","#d2b48c");
				
				
				$(x1).css("box-shadow","1px 1px #53a7ea,2px 2px #53a7ea,3px 3px #53a7ea");
				/*$(x1).css("-webkit-transform","translateX(-7px)");
				$(x1).css("transform","translateX(-7px)");*/
			});
			
			$(".cl-instalaciones_Reconexion_internet"+lista_clases_css14).mouseout(function (){
				var x1="."+$(this).attr("class");
				$(x1).css("background-color","");
				$(x1).css("box-shadow","");
				/*$(x1).css("-webkit-transform","");
				$(x1).css("transform","");*/
			});
			$(".cl-instalaciones_recuperacion_cable_modem"+lista_clases_css14).mouseover(function(){
				var x1="."+$(this).attr("class");
				$(x1).css("background-color","#d2b48c");
				
				
				$(x1).css("box-shadow","1px 1px #53a7ea,2px 2px #53a7ea,3px 3px #53a7ea");
				/*$(x1).css("-webkit-transform","translateX(-7px)");
				$(x1).css("transform","translateX(-7px)");*/
			});
			
			$(".cl-instalaciones_recuperacion_cable_modem"+lista_clases_css14).mouseout(function (){
				var x1="."+$(this).attr("class");
				$(x1).css("background-color","");
				$(x1).css("box-shadow","");
				/*$(x1).css("-webkit-transform","");
				$(x1).css("transform","");*/
			});
			$(".cl-instalaciones_veeduria"+lista_clases_css14).mouseover(function(){
				var x1="."+$(this).attr("class");
				$(x1).css("background-color","#d2b48c");
				
				
				$(x1).css("box-shadow","1px 1px #53a7ea,2px 2px #53a7ea,3px 3px #53a7ea");
				/*$(x1).css("-webkit-transform","translateX(-7px)");
				$(x1).css("transform","translateX(-7px)");*/
			});
			
			$(".cl-instalaciones_veeduria"+lista_clases_css14).mouseout(function (){
				var x1="."+$(this).attr("class");
				$(x1).css("background-color","");
				$(x1).css("box-shadow","");
				/*$(x1).css("-webkit-transform","");
				$(x1).css("transform","");*/
			});
			$(".cl-instalaciones_migracion"+lista_clases_css17).mouseover(function(){
				var x1="."+$(this).attr("class");
				$(x1).css("background-color","#d2b48c");
				
				
				$(x1).css("box-shadow","1px 1px #53a7ea,2px 2px #53a7ea,3px 3px #53a7ea");
				/*$(x1).css("-webkit-transform","translateX(-7px)");
				$(x1).css("transform","translateX(-7px)");*/
			});
			
			$(".cl-instalaciones_migracion"+lista_clases_css17).mouseout(function (){
				var x1="."+$(this).attr("class");
				$(x1).css("background-color","");
				$(x1).css("box-shadow","");
				/*$(x1).css("-webkit-transform","");
				$(x1).css("transform","");*/
			});

			$(".cl-tareas_en_proyectos"+lista_clases_css20).mouseover(function(){
				var x1="."+$(this).attr("class");
				$(x1).css("background-color","#d2b48c");
				
				
				$(x1).css("box-shadow","1px 1px #53a7ea,2px 2px #53a7ea,3px 3px #53a7ea");
				/*$(x1).css("-webkit-transform","translateX(-7px)");
				$(x1).css("transform","translateX(-7px)");*/
			});
			
			$(".cl-tareas_en_proyectos"+lista_clases_css20).mouseout(function (){
				var x1="."+$(this).attr("class");
				$(x1).css("background-color","");
				$(x1).css("box-shadow","");
				/*$(x1).css("-webkit-transform","");
				$(x1).css("transform","");*/
			});

			

			

		
    		
			
	});
function desactivar_activar_tabla_instalaciones_tv_e_internet(){
	$(".tb_tec_info_instalaciones_tv_e_internet").fadeToggle("fast");
}
function desactivar_activar_tabla_instalaciones_internet(){
	$(".tb_tec_info_instalaciones_internet").fadeToggle("fast");
}
function desactivar_activar_tabla_instalaciones_Agregar_Tv(){
	$(".tb_tec_info_instalaciones_Agregar_Tv").fadeToggle("fast");
}
function desactivar_activar_tabla_instalaciones_Traslado(){
	$(".tb_tec_info_instalaciones_Traslado").fadeToggle("fast");
}
function desactivar_activar_tabla_instalaciones_AgregarInternet(){
	$(".tb_tec_info_instalaciones_AgregarInternet").fadeToggle("fast");
}
function desactivar_activar_tabla_instalaciones_Revision_tv_e_internet(){
	$(".tb_tec_info_instalaciones_Revision_tv_e_internet").fadeToggle("fast");
}
function desactivar_activar_tabla_instalaciones_Revision_tv(){
	$(".tb_tec_info_instalaciones_Revision_tv").fadeToggle("fast");
}
function desactivar_activar_tabla_instalaciones_Revision_internet(){
	$(".tb_tec_info_instalaciones_Revision_internet").fadeToggle("fast");
}
function desactivar_activar_tabla_instalaciones_Reconexion_tv_e_internet(){
	$(".tb_tec_info_instalaciones_Reconexion_tv_e_internet").fadeToggle("fast");	
}
function desactivar_activar_tabla_instalaciones_Reconexion_tv(){
	$(".tb_tec_info_instalaciones_Reconexion_tv").fadeToggle("fast");		
}
function desactivar_activar_tabla_instalaciones_Reconexion_internet(){
	$(".tb_tec_info_instalaciones_Reconexion_internet").fadeToggle("fast");			
}
function desactivar_activar_tabla_instalaciones_Corte_Tv(){
	$(".tb_tec_info_instalaciones_Corte_Tv").fadeToggle("fast");		
}
function desactivar_activar_tabla_instalaciones_total(){
		$(".tb_tec_info_instalaciones_total").fadeToggle("fast");		
}
function desactivar_activar_tabla_instalaciones_Corte_Internet(){
	$(".tb_tec_info_instalaciones_Corte_Internet").fadeToggle("fast");			
}
function desactivar_activar_tabla_instalaciones_Corte_tv_e_internet(){
	$(".tb_tec_info_instalaciones_Corte_tv_e_internet").fadeToggle("fast");				
}
function desactivar_activar_tabla_instalaciones_migracion(){
	$(".tb_tec_info_instalaciones_migracion").fadeToggle("fast");					
}
function desactivar_activar_tabla_tareas_en_proyectos(){
		$(".tb_tec_info_tareas_en_proyectos").fadeToggle("fast");						
}
function desactivar_activar_tabla_instalaciones_punto_nuevo(){
		$(".tb_tec_info_instalaciones_punto_nuevo").fadeToggle("fast");						
}
function desactivar_activar_tabla_instalaciones_recuperacion_cable_modem(){
		$(".tb_tec_info_instalaciones_recuperacion_cable_modem").fadeToggle("fast");						
}
function desactivar_activar_tabla_instalaciones_veeduria(){
		$(".tb_tec_info_instalaciones_veeduria").fadeToggle("fast");						
}

function mostrar_ocultar(){
	desactivar_activar_tabla_instalaciones_total();
	desactivar_activar_tabla_instalaciones_Corte_Tv();
	desactivar_activar_tabla_instalaciones_Corte_Internet();
	desactivar_activar_tabla_instalaciones_Corte_tv_e_internet();
	desactivar_activar_tabla_instalaciones_Reconexion_tv_e_internet();
	desactivar_activar_tabla_instalaciones_Reconexion_tv();
	desactivar_activar_tabla_instalaciones_Reconexion_internet();
	desactivar_activar_tabla_instalaciones_Revision_tv_e_internet();
	desactivar_activar_tabla_instalaciones_Revision_internet();
	desactivar_activar_tabla_instalaciones_Revision_tv();
	desactivar_activar_tabla_instalaciones_AgregarInternet();
	desactivar_activar_tabla_instalaciones_Traslado();
	desactivar_activar_tabla_instalaciones_Agregar_Tv();
	desactivar_activar_tabla_instalaciones_internet();
	desactivar_activar_tabla_instalaciones_tv_e_internet();
	desactivar_activar_tabla_instalaciones_migracion();	
	desactivar_activar_tabla_tareas_en_proyectos();
	desactivar_activar_tabla_instalaciones_punto_nuevo();
	desactivar_activar_tabla_instalaciones_recuperacion_cable_modem();
	desactivar_activar_tabla_instalaciones_veeduria();
}
mostrar_ocultar();

</script>
<script type="text/javascript">
	//$("#x2").scrollLeft(200);
	/*
		position: relative;
	    top: 300;
	    z-index: 1;
	    float: right;
	*/
	var posicionScroll=0;
	$(".btn-flotante").click(function(ev){
		ev.preventDefault();
		posicionScroll+=250
		$("#x2").scrollLeft(posicionScroll);
		$(this).css("color","white");
	});

	$(".btn-flotante2").click(function(ev){
		ev.preventDefault();
		posicionScroll=0
		$("#x2").scrollLeft(posicionScroll);
		$(this).css("color","white");
	});
	$(".btn-flotante3").click(function(ev){
		ev.preventDefault();
		mostrar_ocultar();
		$("#link1").click();
	});

	var lista_keysdos=[];
	var lista_labels_totaldos={y:'Instalaciones Tv + Internet',z:"Instalaciones Tv",a:"Instalaciones Internet",b:"Agregar Tv",c:"Agregar Internet",d:"Traslado",e:"Revision",f:"Reconexion",g:"Suspension Combo",h:"Suspension Internet",i:"Suspension Television",j:"Corte Television"};
    var lista_labels_personalizadados=[];
    $('#invoices-sales-chart').empty();
    var datosdos={
        element: 'invoices-sales-chart',
        data: [
            <?php foreach ($stat['instalaciones_tv_e_internet'] as $key => $numero) {
            $datex = new DateTime($key);
            //$num = cal_days_in_month(CAL_GREGORIAN, $row['month'], $row['year']);
            echo "{ x: '".($datex->format("Y-m-t"))."', y: ". intval($stat['instalaciones_tv_e_internet'][$key]) .",z: " . intval($stat['instalaciones_tv'][$key]) . ",a: " . intval($stat['instalaciones_internet'][$key]) . ",b: " . intval($stat['instalaciones_Agregar_Tv'][$key]) .",c:" . intval($stat['instalaciones_AgregarInternet'][$key]) . ",d: " . intval($stat['instalaciones_Traslado'][$key]) . ",e: " . intval($stat['instalaciones_Revision'][$key]) . ",f: " . intval($stat['instalaciones_Reconexion'][$key]) . ",g: " . intval($stat['instalaciones_Suspension_Combo'][$key]) . ",h: " . intval($stat['instalaciones_Suspension_Internet'][$key]) . ",i: " . intval($stat['instalaciones_Suspension_Television'][$key]) . ",j: " . intval($stat['instalaciones_Corte_Television'][$key]) . "},";
            
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
            $datex = new DateTime($key);
            //$num = cal_days_in_month(CAL_GREGORIAN, $row['month'], $row['year']);
            echo "{ x: '".($datex->format("Y-m-d"))."', y: " . intval($tipos['instalaciones_tv_e_internet'][$key]) . ",z: " . intval($tipos['instalaciones_tv'][$key]) . ",a: " . intval($tipos['instalaciones_internet'][$key]) . ",b: " . intval($tipos['instalaciones_Agregar_Tv'][$key]) . ",c: " . intval($tipos['instalaciones_AgregarInternet'][$key]) . ",d: " . intval($tipos['instalaciones_Traslado'][$key]) . ",e: " . intval($tipos['instalaciones_Revision'][$key]) . ",f: " . intval($tipos['instalaciones_Reconexion'][$key]) . ",g: " . intval($tipos['instalaciones_Suspension_Combo'][$key]) . ",h: " . intval($tipos['instalaciones_Suspension_Internet'][$key]) . ",i: " . intval($tipos['instalaciones_Suspension_Television'][$key]) . ",j: " . intval($tipos['instalaciones_Corte_Television'][$key]) . "},";//,z: " . intval($tipos['instalaciones_tv'][$key]['numero']) . "
            
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