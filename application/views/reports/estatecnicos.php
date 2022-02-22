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


	.btn-flotante {
		-webkit-tap-highlight-color: rgba(0,0,0,0);
	font-size: 16px; /* Cambiar el tamaño de la tipografia */
	text-transform: uppercase; /* Texto en mayusculas */
	font-weight: bold; /* Fuente en negrita o bold */
	color: #ffffff; /* Color del texto */
	
	letter-spacing: 2px; /* Espacio entre letras */
	/*background-color: #E91E63; /* Color de fondo */
	padding: 20px 12px; /* Relleno del boton */
	position: fixed;
	bottom: 45%;
	right: 4px;
	transition: all 300ms ease 0ms;
	box-shadow: 0px 8px 15px rgba(0, 0, 0, 0.1);
	z-index: 99;

	/*transform: translateY(-550%);*/

	background: -o-linear-gradient(rgba(50, 50, 50, .5), rgba(50, 50, 50, .75), rgb(50, 50, 50));
		background: -moz-linear-gradient(rgba(50, 50, 50, .5), rgba(50, 50, 50, .75), rgb(50, 50, 50));
		background: -webkit-linear-gradient(rgba(50, 50, 50, .5), rgba(50, 50, 50, .75), rgb(50, 50, 50));
		background: linear-gradient(rgba(50, 50, 50, .5), rgba(50, 50, 50, .75), rgb(50, 50, 50));
		color: #aaa;
		border-radius: 40%;
}
.btn-flotante:hover {
	background-color: white; /* Color de fondo al pasar el cursor */
	color: white;
	box-shadow: 0px 15px 20px rgba(0, 0, 0, 0.3);
	bottom: 44%;
}
@media only screen and (max-width: 600px) {
 	.btn-flotante {
		font-size: 14px;
		padding: 12px 20px;
		bottom: 20px;
		right: 5px;
	}
} 

.btn-flotante2 {
		-webkit-tap-highlight-color: rgba(0,0,0,0);
	font-size: 16px; /* Cambiar el tamaño de la tipografia */
	text-transform: uppercase; /* Texto en mayusculas */
	font-weight: bold; /* Fuente en negrita o bold */
	color: #ffffff; /* Color del texto */
	
	letter-spacing: 2px; /* Espacio entre letras */
	/*background-color: #E91E63; /* Color de fondo */
	padding: 20px 12px; /* Relleno del boton */
	position: fixed;
	bottom: 53%;
	right: 4px;
	transition: all 300ms ease 0ms;
	box-shadow: 0px 8px 15px rgba(0, 0, 0, 0.1);
	z-index: 99;

	/*transform: translateY(-550%);*/

	background: -o-linear-gradient(rgba(50, 50, 50, .5), rgba(50, 50, 50, .75), rgb(50, 50, 50));
		background: -moz-linear-gradient(rgba(50, 50, 50, .5), rgba(50, 50, 50, .75), rgb(50, 50, 50));
		background: -webkit-linear-gradient(rgba(50, 50, 50, .5), rgba(50, 50, 50, .75), rgb(50, 50, 50));
		background: linear-gradient(rgba(50, 50, 50, .5), rgba(50, 50, 50, .75), rgb(50, 50, 50));
		color: #aaa;
		border-radius: 40%;
}
.btn-flotante2:hover {
	background-color: white; /* Color de fondo al pasar el cursor */
	color: white;
	box-shadow: 0px 15px 20px rgba(0, 0, 0, 0.3);
	bottom: 52%;
}
@media only screen and (max-width: 600px) {
 	.btn-flotante2 {
		font-size: 14px;
		padding: 12px 20px;
		bottom: 20px;
		right: 5px;
	}
} 


.btn-flotante3 {
		-webkit-tap-highlight-color: rgba(0,0,0,0);
	font-size: 16px; /* Cambiar el tamaño de la tipografia */
	text-transform: uppercase; /* Texto en mayusculas */
	font-weight: bold; /* Fuente en negrita o bold */
	color: #ffffff; /* Color del texto */
	
	letter-spacing: 2px; /* Espacio entre letras */
	/*background-color: #E91E63; /* Color de fondo */
	padding: 20px 12px; /* Relleno del boton */
	position: fixed;
	bottom: 61%;
	right: -1px;
	transition: all 300ms ease 0ms;
	box-shadow: 0px 8px 15px rgba(0, 0, 0, 0.1);
	z-index: 99;

	/*transform: translateY(-550%);*/

	background: -o-linear-gradient(rgba(50, 50, 50, .5), rgba(50, 50, 50, .75), rgb(50, 50, 50));
		background: -moz-linear-gradient(rgba(50, 50, 50, .5), rgba(50, 50, 50, .75), rgb(50, 50, 50));
		background: -webkit-linear-gradient(rgba(50, 50, 50, .5), rgba(50, 50, 50, .75), rgb(50, 50, 50));
		background: linear-gradient(rgba(50, 50, 50, .5), rgba(50, 50, 50, .75), rgb(50, 50, 50));
		color: #aaa;
		border-radius: 40%;
}
.btn-flotante3:hover {
	background-color: white; /* Color de fondo al pasar el cursor */
	color: white;
	box-shadow: 0px 15px 20px rgba(0, 0, 0, 0.3);
	bottom: 60%;
}
@media only screen and (max-width: 600px) {
 	.btn-flotante3 {
		font-size: 14px;
		padding: 12px 20px;
		bottom: 20px;
		right: 5px;
	}
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
																echo "<tr class='instalaciones_internet_".$key."' ><td style='width: 100px;text-align: center;'>".($value2['FTTH']['puntuacion']+$value2['EOC']['puntuacion'])."p</td></tr>";																
															} ?>	
														</tbody></table> 	
												</td>
											<?php } ?>

												
											
											<td align="center" >
												<div   class="cl-instalaciones_internet" style="cursor: pointer;" onclick="desactivar_activar_tabla_instalaciones_internet()"><?php echo $conteo; ?></div>
														<table class="tb_tec_info_instalaciones_internet" style='width: 200px;text-align: center;'><tbody>
															<?php foreach ($lista_datos_cuentas_tipos_por_tecnico['instalaciones_internet'] as $key => $value2) {
																echo "<tr class='instalaciones_internet_".$key."' ><td style='width: 200px;'><strong>".($value2['FTTH']['puntuacion']+$value2['EOC']['puntuacion'])."</strong> pts </td></tr>";																
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
																echo "<tr class='instalaciones_AgregarInternet_".$key."' ><td style='width: 100px;text-align: center;'>".($value2['FTTH']['puntuacion']+$value2['EOC']['puntuacion'])."p</td></tr>";																
															} ?>	
														</tbody></table> 	
												</td>
											<?php } ?>

												
											
											<td align="center" >
												<div   class="cl-instalaciones_AgregarInternet" style="cursor: pointer;" onclick="desactivar_activar_tabla_instalaciones_AgregarInternet()"><?php echo $conteo; ?></div>
														<table class="tb_tec_info_instalaciones_AgregarInternet" style='width: 200px;text-align: center;'><tbody>
															<?php foreach ($lista_datos_cuentas_tipos_por_tecnico['instalaciones_AgregarInternet'] as $key => $value2) {
																echo "<tr class='instalaciones_AgregarInternet_".$key."' ><td style='width: 200px;'><strong>".($value2['FTTH']['puntuacion']+$value2['EOC']['puntuacion'])."</strong> pts </td></tr>";																
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
																echo "<tr class='instalaciones_Traslado_".$key."' ><td style='width: 100px;text-align: center;'>".($value2['FTTH']['puntuacion']+$value2['EOC']['puntuacion'])."p</td></tr>";																
															} ?>	
														</tbody></table> 	
												</td>
											<?php } ?>

												
											
											<td align="center" >
												<div   class="cl-instalaciones_Traslado" style="cursor: pointer;" onclick="desactivar_activar_tabla_instalaciones_Traslado()"><?php echo $conteo; ?></div>
														<table class="tb_tec_info_instalaciones_Traslado" style='width: 200px;text-align: center;'><tbody>
															<?php foreach ($lista_datos_cuentas_tipos_por_tecnico['instalaciones_Traslado'] as $key => $value2) {
																echo "<tr class='instalaciones_Traslado_".$key."' ><td style='width: 200px;'><strong>".($value2['FTTH']['puntuacion']+$value2['EOC']['puntuacion'])."</strong> pts </td></tr>";																
															} ?>	
														</tbody></table> 	
											</td>
										</tr>
						
										<tr>
											<td class="static">
												<div class="cl-instalaciones_Revision" style="cursor: pointer;" onclick="desactivar_activar_tabla_instalaciones_Revision()"><i><u>Revision</u></i></div>
												
													<table class="tb_tec_info_instalaciones_Revision"><tbody>
														<?php $lista_clases_css7=""; 
															foreach ($lista_de_tecnicos as $key => $value) {
																$name_class="instalaciones_Revision_".$value['username'];
																$lista_clases_css7.=",.".$name_class."";
																echo "<tr class='".$name_class."'><td>".$value['username']."</td></tr>";
														}  ?>	
														
													</tbody></table> 
											</td>
											<?php $conteo=0; foreach ($tipos['instalaciones_Revision'] as $key1=> $row) {?>												
												<td class="first-col" style="padding-right: 0px;padding-left: 0px;text-align: center;">
													<div class="cl-instalaciones_Revision" style="cursor: pointer;" onclick="desactivar_activar_tabla_instalaciones_Revision()"><?php echo $row;$conteo+=$row; ?></div>
														
														<table class="tb_tec_info_instalaciones_Revision" style='width: 100px;'><tbody>
															<?php foreach ($lista_por_tecnicos['instalaciones_Revision'][$key1] as $key => $value2) {
																echo "<tr class='instalaciones_Revision_".$key."' ><td style='width: 100px;text-align: center;'>".($value2['Revision_de_Internet']['puntuacion']+$value2['Revision_de_television']['puntuacion'])."p</td></tr>";																
															} ?>	
														</tbody></table> 	
												</td>
											<?php } ?>

												
											
											<td align="center" >
												<div   class="cl-instalaciones_Revision" style="cursor: pointer;" onclick="desactivar_activar_tabla_instalaciones_Revision()"><?php echo $conteo; ?></div>
														<table class="tb_tec_info_instalaciones_Revision" style='width: 200px;text-align: center;'><tbody>
															<?php foreach ($lista_datos_cuentas_tipos_por_tecnico['instalaciones_Revision'] as $key => $value2) {
																echo "<tr class='instalaciones_Revision_".$key."' ><td style='width: 200px;'><strong>".($value2['Revision_de_Internet']['puntuacion']+$value2['Revision_de_television']['puntuacion'])."</strong> pts </td></tr>";																
															} ?>	
														</tbody></table> 	
											</td>
										</tr>
										
										<tr>
											<td class="static">
												<div class="cl-instalaciones_Reconexion" style="cursor: pointer;" onclick="desactivar_activar_tabla_instalaciones_Reconexion()"><i><u>Reconexion</u></i></div>
												
													<table class="tb_tec_info_instalaciones_Reconexion"><tbody>
														<?php $lista_clases_css8=""; 
															foreach ($lista_de_tecnicos as $key => $value) {
																$name_class="instalaciones_Reconexion_".$value['username'];
																$lista_clases_css8.=",.".$name_class."";
																echo "<tr class='".$name_class."'><td>".$value['username']."</td></tr>";
														}  ?>	
														
													</tbody></table> 
											</td>
											<?php $conteo=0; foreach ($tipos['instalaciones_Reconexion'] as $key1=> $row) {?>												
												<td class="first-col" style="padding-right: 0px;padding-left: 0px;text-align: center;">
													<div class="cl-instalaciones_Reconexion" style="cursor: pointer;" onclick="desactivar_activar_tabla_instalaciones_Reconexion()"><?php echo $row;$conteo+=$row; ?></div>
														
														<table class="tb_tec_info_instalaciones_Reconexion" style='width: 100px;'><tbody>
															<?php foreach ($lista_por_tecnicos['instalaciones_Reconexion'][$key1] as $key => $value2) {
																echo "<tr class='instalaciones_Reconexion_".$key."' ><td style='width: 100px;text-align: center;'>".($value2['Reconexion_de_internet']['puntuacion']+$value2['Reconexion_de_tv']['puntuacion'])."p</td></tr>";																
															} ?>	
														</tbody></table> 	
												</td>
											<?php } ?>

												
											
											<td align="center" >
												<div   class="cl-instalaciones_Reconexion" style="cursor: pointer;" onclick="desactivar_activar_tabla_instalaciones_Reconexion()"><?php echo $conteo; ?></div>
														<table class="tb_tec_info_instalaciones_Reconexion" style='width: 200px;text-align: center;'><tbody>
															<?php foreach ($lista_datos_cuentas_tipos_por_tecnico['instalaciones_Reconexion'] as $key => $value2) {
																echo "<tr class='instalaciones_Reconexion_".$key."' ><td style='width: 200px;'><strong>".($value2['Reconexion_de_internet']['puntuacion']+$value2['Reconexion_de_tv']['puntuacion'])."</strong> pts </td></tr>";																
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
												<div class="cl-instalaciones_Corte" style="cursor: pointer;" onclick="desactivar_activar_tabla_instalaciones_Corte()"><i><u>Corte</u></i></div>
												
													<table class="tb_tec_info_instalaciones_Corte"><tbody>
														<?php $lista_clases_css9=""; 
															foreach ($lista_de_tecnicos as $key => $value) {
																$name_class="instalaciones_Corte_".$value['username'];
																$lista_clases_css9.=",.".$name_class."";
																echo "<tr class='".$name_class."'><td>".$value['username']."</td></tr>";
														}  ?>	
														
													</tbody></table> 
											</td>
											<?php $conteo=0; foreach ($tipos['instalaciones_Corte'] as $key1=> $row) {?>												
												<td class="first-col" style="padding-right: 0px;padding-left: 0px;text-align: center;">
													<div class="cl-instalaciones_Corte" style="cursor: pointer;" onclick="desactivar_activar_tabla_instalaciones_Corte()"><?php echo $row;$conteo+=$row; ?></div>
														
														<table class="tb_tec_info_instalaciones_Corte" style='width: 100px;'><tbody>
															<?php foreach ($lista_por_tecnicos['instalaciones_Corte'][$key1] as $key => $value2) {
																echo "<tr class='instalaciones_Corte_".$key."' ><td style='width: 100px;text-align: center;'>".($value2['Corte_de_internet']['puntuacion']+$value2['Corte_de_tv']['puntuacion'])."p</td></tr>";																
															} ?>	
														</tbody></table> 	
												</td>
											<?php } ?>

												
											
											<td align="center" >
												<div   class="cl-instalaciones_Corte" style="cursor: pointer;" onclick="desactivar_activar_tabla_instalaciones_Corte()"><?php echo $conteo; ?></div>
														<table class="tb_tec_info_instalaciones_Corte" style='width: 200px;text-align: center;'><tbody>
															<?php foreach ($lista_datos_cuentas_tipos_por_tecnico['instalaciones_Corte'] as $key => $value2) {
																echo "<tr class='instalaciones_Corte_".$key."' ><td style='width: 200px;'><strong>".($value2['Corte_de_internet']['puntuacion']+$value2['Corte_de_tv']['puntuacion'])."</strong> pts </td></tr>";																
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
															<?php foreach ($lista_datos_cuentas_tipos_por_tecnico['instalaciones_Reconexion'] as $key => $value2) {
																$x=$lista_datos_cuentas_tipos_por_tecnico['instalaciones_tv_e_internet'][$key];
																$total=$x['FTTH']['puntuacion']+$x['EOC']['puntuacion']+$x['puntos_adicionales']['puntuacion']+$x['puntos_adicionales_multiples']['puntuacion'];

																$x=$lista_datos_cuentas_tipos_por_tecnico['instalaciones_internet'][$key];
																$total+=$x['FTTH']['puntuacion']+$x['EOC']['puntuacion'];

																$x=$lista_datos_cuentas_tipos_por_tecnico['instalaciones_Traslado'][$key];
																$total+=$x['FTTH']['puntuacion']+$x['EOC']['puntuacion'];

																$x=$lista_datos_cuentas_tipos_por_tecnico['instalaciones_AgregarInternet'][$key];
																$total+=$x['FTTH']['puntuacion']+$x['EOC']['puntuacion'];

																$x=$lista_datos_cuentas_tipos_por_tecnico['instalaciones_Agregar_Tv'][$key];
																$total+=$x['Agregar_Tv']['puntuacion']+$x['puntos_adicionales']['puntuacion']+$x['puntos_adicionales_multiples']['puntuacion'];

																$x=$lista_datos_cuentas_tipos_por_tecnico['instalaciones_Revision'][$key];
																$total+=$x['Revision_de_Internet']['puntuacion']+$x['Revision_de_television']['puntuacion'];

																$x=$lista_datos_cuentas_tipos_por_tecnico['instalaciones_Reconexion'][$key];
																$total+=$x['Reconexion_de_internet']['puntuacion']+$x['Reconexion_de_tv']['puntuacion'];

																$x=$lista_datos_cuentas_tipos_por_tecnico['instalaciones_Corte'][$key];
																$total+=$x['Corte_de_internet']['puntuacion']+$x['Corte_de_tv']['puntuacion'];
																
																echo "<tr class='instalaciones_total_".$key."' ><td style='width: 200px;'><strong>".($total)."</strong> pts </td></tr>";																
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
<script type="text/javascript">
	document.addEventListener("DOMContentLoaded", function(event) {
		var lista_clases_css1="<?=$lista_clases_css1 ?>";
		var lista_clases_css2="<?=$lista_clases_css2 ?>";
		var lista_clases_css3="<?=$lista_clases_css3 ?>";
		var lista_clases_css4="<?=$lista_clases_css4 ?>";
		var lista_clases_css5="<?=$lista_clases_css5 ?>";
		var lista_clases_css7="<?=$lista_clases_css7 ?>";
		var lista_clases_css8="<?=$lista_clases_css8 ?>";
		var lista_clases_css9="<?=$lista_clases_css9 ?>";
		var lista_clases_css10="<?=$lista_clases_css10 ?>";
		
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

			$(".cl-instalaciones_Revision"+lista_clases_css7).mouseover(function(){
				var x1="."+$(this).attr("class");
				$(x1).css("background-color","#d2b48c");
				
				
				$(x1).css("box-shadow","1px 1px #53a7ea,2px 2px #53a7ea,3px 3px #53a7ea");
				/*$(x1).css("-webkit-transform","translateX(-7px)");
				$(x1).css("transform","translateX(-7px)");*/
			});
			
			$(".cl-instalaciones_Revision"+lista_clases_css7).mouseout(function (){
				var x1="."+$(this).attr("class");
				$(x1).css("background-color","");
				$(x1).css("box-shadow","");
				/*$(x1).css("-webkit-transform","");
				$(x1).css("transform","");*/
			});
			$(".cl-instalaciones_Reconexion"+lista_clases_css8).mouseover(function(){
				var x1="."+$(this).attr("class");
				$(x1).css("background-color","#d2b48c");
				
				
				$(x1).css("box-shadow","1px 1px #53a7ea,2px 2px #53a7ea,3px 3px #53a7ea");
				/*$(x1).css("-webkit-transform","translateX(-7px)");
				$(x1).css("transform","translateX(-7px)");*/
			});
			
			$(".cl-instalaciones_Reconexion"+lista_clases_css8).mouseout(function (){
				var x1="."+$(this).attr("class");
				$(x1).css("background-color","");
				$(x1).css("box-shadow","");
				/*$(x1).css("-webkit-transform","");
				$(x1).css("transform","");*/
			});

			$(".cl-instalaciones_Corte"+lista_clases_css9).mouseover(function(){
				var x1="."+$(this).attr("class");
				$(x1).css("background-color","#d2b48c");
				
				
				$(x1).css("box-shadow","1px 1px #53a7ea,2px 2px #53a7ea,3px 3px #53a7ea");
				/*$(x1).css("-webkit-transform","translateX(-7px)");
				$(x1).css("transform","translateX(-7px)");*/
			});
			
			$(".cl-instalaciones_Corte"+lista_clases_css9).mouseout(function (){
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
function desactivar_activar_tabla_instalaciones_Revision(){
	$(".tb_tec_info_instalaciones_Revision").fadeToggle("fast");
}
function desactivar_activar_tabla_instalaciones_Reconexion(){
	$(".tb_tec_info_instalaciones_Reconexion").fadeToggle("fast");	
}
function desactivar_activar_tabla_instalaciones_Corte(){
	$(".tb_tec_info_instalaciones_Corte").fadeToggle("fast");		
}
function desactivar_activar_tabla_instalaciones_total(){
		$(".tb_tec_info_instalaciones_total").fadeToggle("fast");		
}
function mostrar_ocultar(){
	desactivar_activar_tabla_instalaciones_total();
	desactivar_activar_tabla_instalaciones_Corte();
	desactivar_activar_tabla_instalaciones_Reconexion();
	desactivar_activar_tabla_instalaciones_Revision();
	desactivar_activar_tabla_instalaciones_AgregarInternet();
	desactivar_activar_tabla_instalaciones_Traslado();
	desactivar_activar_tabla_instalaciones_Agregar_Tv();
	desactivar_activar_tabla_instalaciones_internet();
	desactivar_activar_tabla_instalaciones_tv_e_internet();	
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
		(this).css("color","white");
	});

	$(".btn-flotante2").click(function(ev){
		ev.preventDefault();
		posicionScroll=0
		$("#x2").scrollLeft(posicionScroll);
		(this).css("color","white");
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