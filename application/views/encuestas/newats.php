<style>
	.titulos{
		background-color:#4881A6;
		font-weight: bold;
		padding-top: 10px;
		padding-bottom: 10px;
		
	}
	
	input[type=checkbox] {
  		transform: scale(1.5);
		margin-left: 10px;
	}
	input[type=radio] {
  		transform: scale(1.5);
		margin-left: 10px;
	}

</style>

<article class="content">
    <div class="card card-block">
        <div id="notify" class="alert alert-success" style="display:none;">
            <a href="#" class="close" data-dismiss="alert">&times;</a>

            <div class="message"></div>
        </div>
        <form method="post" id="data_form" class="form-horizontal">
            <div class="grid_3 grid_4">

                <h5>FORMATO ANALISIS SEGURO DE TRABAJO</h5>
                <hr>
				<table width="100%" border="1">
					  <tbody>
						<tr>
						  <td colspan="4" width="50%">Ciudad: <?php echo $colaborador['city']; ?> &nbsp;</td>
						  <td colspan="4" width="50%">Nombre y Apellido: <?php echo $colaborador['name']; ?>&nbsp;</td>
						</tr>
						<tr>
						  <td colspan="4">Área/Proceso: <?php echo user_role($rol); ?></td>
						  <td colspan="4">Ubicación donde se realiza el trabajo: <input type="text" name="ubicacion" size="30%" maxlength="30%" style="border: 0"></input></td>
						</tr>
						<tr>
						  	<td colspan="4">Fecha de realización del Trabajo: 
								<input type="text" name="fecha" data-toggle="datepicker" autocomplete="false" style="border: 0" ></td>
							<td valign="top" colspan="4">Lugar de Trabajo: 
								<input type="text" name="lugar" size="70%" maxlength="30%" style="border: 0"></input></td>
						</tr>
						<tr>
						  <td colspan="4">Hora de Inicio (a.m.): 
							  <input type="text" readonly placeholder="End Date" name="horain" style="border: 0; background-color: grey" autocomplete="false" value="<?php echo date("g:i a") ?>" ></td>
						  <td colspan="4">Hora de Finalización ( p.m.): 
							  <input type="text" placeholder="End Date" name="horafin" autocomplete="false" value="<?php echo date("g:i a") ?>"></td>
						</tr>
						<tr>
						  <td valign="top" colspan="4">Descripción de la tarea a realizar:  </td>
							<td colspan="4">
								<select type="text" class="form-control" name="tarea" style="border: 0">
									<option value="TENDIDO DE FIBRA">TENDIDO DE FIBRA</option>
									<option value="INSTALACION DE CAJAS NAP Y DOMOS">INSTALACION DE CAJAS NAP Y DOMOS</option>
									<option value="CONECTORIZAR">CONECTORIZAR</option>
									<option value="MIGRACION DE USUARIOS">MIGRACION DE USUARIOS</option>
									<option value="REVISION DAÑO GENERAL">REVISION DAÑO GENERAL</option>
									<option value="REALIZACION DE CORTES">REALIZACION DE CORTES</option>
									<option value="REALIZACION DE VEEDURIA">REALIZACION DE VEEDURIA</option>
								</select>
							</td>
						</tr>
						<tr>
							<td align="center" class="titulos" colspan="8">RIESGOS Y PELIGROS EXISTENTES</td>
						</tr>
						<tr>
							<td colspan="8"><table width="100%" border="0">
								  <tbody>
									<tr>
									  <td align="left">BIOLOGICO: </td>
										<td width="2%"><input type="checkbox" name="biologico"></input></td>
										
									  	<td>
										
										  <select type="text" class="form-control" id="biologico2" name="biologico2[]" style="border: 0" multiple>
											<option value="">-</option>
											<option value="Virus">Virus</option>
											<option value="Hongos">Hongos</option>
											<option value="Bacterias">Bacterias</option>
											<option value="Parasitos">Parasitos</option>
											<option value="Picaduras">Picaduras</option>
											<option value="Mordeduras">Mordeduras</option>
										</select>
										</td>
									</tr>
									<tr>
									  <td align="left">BIOMECANICO: </td>
										<td><input type="checkbox" name="biomeca"></input></td>
									  <td align="left">
										  <select type="text" class="form-control" id="biomeca2" name="biomeca2[]" style="border: 0;" multiple>
											<option value="">-</option>
											<option value="Posturas prolonsgadas">Posturas prolonsgadas</option>
											<option value="Esfuerzo">Esfuerzo</option>
											<option value="Movimiento repetitivo">Movimiento repetitivo</option>
											<option value="Manipulacion de Cargas">Manipulacion de Cargas</option>
										</select>
										</td>
									</tr>
									<tr>
									  <td align="left">CONDICIONES DE SEGURIDAD: </td>
										<td><input type="checkbox" name="condicion"></input></td>
									  <td align="left">
										  <select type="text" class="form-control" id="condicion2" name="condicion2" style="border: 0">
											<option value="">-</option>
											<option value="Gestión organizacional">Gestión organizacional</option>
											<option value="Condiciones de la tarea">Condiciones de la tarea</option>
											<option value="Jornada de trabajo">Jornada de trabajo</option>
										</select>
										</td>
									</tr>
									<tr>
									  <td align="left">FENOMENOS NATURALES: </td>
										<td><input type="checkbox" name="fenomeno"></input></td>
									  <td align="left">
										  <select type="text" class="form-control"  id="fenomeno2" name="fenomeno2[]" multiple style="border: 0">
											<option value="">-</option>
											<option value="Sismos">Sismos</option>
											<option value="Vendaval">Vendaval</option>
											<option value="Inundación">Inundación</option>
											<option value="Presipitaciones">Presipitaciones</option>
										</select>
										</td>
									</tr>
									<tr>
									  <td align="left">FISICOS: </td>
										<td><input type="checkbox" name="fisico"></input></td>
									  <td align="left">
										  <select type="text" class="form-control" id="fisico2" name="fisico2[]" multiple style="border: 0">
											<option value="">-</option>
											<option value="Ruido">Ruido</option>
											<option value="Iluminacion">Iluminacion</option>
											<option value="Vibracion">Vibracion</option>
											<option value="Temperaturas">Temperaturas</option>
											<option value="Radiaciones No Ionizantes">Radiaciones No Ionizantes</option>
										</select>
										</td>
									</tr>
									<tr>
									  <td align="left">PSICOSOCIAL: </td>
										<td><input type="checkbox" name="psico"></input></td>
									  <td align="left">
										  <input type="text" name="psico2" size="70%" maxlength="30%" style="border: 0"></input>
										</td>
									</tr>
									<tr>
									  <td align="left">QUIMICO: </td>
										<td><input type="checkbox" name="quimico"></input></td>
									  <td align="left">
										  <input type="text" name="quimico2" size="70%" maxlength="30%" style="border: 0"></input>
										</td>
									</tr>
								  </tbody>
								</table>
							</td>
						</tr>
						<tr>
							<td align="center" class="titulos" colspan="8">PARA ESTE TRABAJO SE REQUIERE PERMISO DE:</td>
						</tr>
						<tr>
							<td colspan="8" align="center" style="padding-top: 10px">
								¿TRABAJO EN ALTURA ? <label class="display-inline-block custom-control custom-radio ml-1">
                                                <input type="radio" name="alturas" class="custom-control-input"
                                                       value="1" checked="">
                                                <span class="custom-control-indicator"></span>
                                                <span class="custom-control-description ml-0">Si</span>
                                            </label>
                                            <label class="display-inline-block custom-control custom-radio">
                                                <input type="radio" name="alturas" class="custom-control-input"
                                                       value="0">
                                                <span class="custom-control-indicator"></span>
                                                <span class="custom-control-description ml-0">No</span>
                                            </label></td>
						</tr>
						<tr>
							<td align="center" class="titulos" colspan="8">ELEMENTOS DE PROTECCION PERSONAL A USAR</td>
						</tr>
						<tr>
							<td colspan="8"><table width="100%" border="0">
								  <tbody>
									<tr>
									  <td align="right">CASCO DE SEGURIDAD: </td>
										<td><input type="checkbox" name="casco"></input></td>
									  <td align="right">GAFAS ESPECIALES:</td>
									  <td><input type="checkbox" name="gafas"></input></td>
									</tr>
									<tr>
									  <td align="right">MONOGAFAS:</td>
									  <td><input type="checkbox" name="monogafas"></input></td>
									  <td align="right">TAPAOIDOS:</td>
									  <td><input type="checkbox" name="tapaoidos"></input></td>
									</tr>
									<tr>
									  <td align="right">GUANTES:</td>
									  <td><input type="checkbox" name="guantes"></input></td>
									  <td align="right">VISERA O CARETA:</td>
									  <td><input type="checkbox" name="careta"></input></td>
									</tr>
									<tr>
									  <td align="right">ARNES:</td>
									  <td><input type="checkbox" name="arnes"></input></td>
									  <td align="right">EQUIPO DE PRIMEROS AUXILIOS:</td>
									  <td><input type="checkbox" name="1er_aux"></input></td>
									</tr>
									<tr>
									  <td align="right">ESLINGA:</td>
									  <td><input type="checkbox" name="eslinga"></input></td>
									  <td align="right">RESPIRADOR ESPECIAL:</td>
									  <td><input type="checkbox" name="respirador"></input></td>
									</tr>
									<tr>
									  <td align="right">TIE OFF + MOSQUETON:</td>
									  <td><input type="checkbox" name="mosquete"></input></td>
									  <td align="right">¿ OTRO?, Cual:</td>
									  <td><input type="text" name="otros" size="70%" maxlength="30%" style="border: 0"></input></td>
									</tr>
								  </tbody>
								</table>
							</td>
						</tr>
						<tr>
							<td align="center" class="titulos" colspan="8">EQUIPOS Y HERRAMIENTAS A USAR</td>
						</tr>
						<tr>
							<td colspan="2" style="font-weight: bold" align="center">EQUIPOS Y HERRAMIENTAS</td>
							<td colspan="7" style="font-weight: bold">Indique cada una de las herramientas a utilizar.</td>
							
						</tr>
						<tr>
							<td colspan="1"  width="20%">Manuales</td>
							<td colspan="1" width="5%"><select type="text" class="form-control" name="manual1" style="border: 0">
											<option value="No">No</option>
											<option value="Si">Si</option>
										</select></td>
							<td colspan="7">
									<select type="text" class="form-control" id="manual2" name="manual2[]" style="border: 0" multiple>
											<option value="">-</option>
											<option value="Martillo">Martillo</option>
											<option value="Pinzas">Pinzas</option>
											<option value="Llave">Llave</option>
											<option value="Cortafrios">Cortafrios</option>
										</select></td>
						</tr>
						<tr>
							<td colspan="1">Eléctricas</td>
							<td colspan="1"><select type="text" class="form-control" name="electro1" style="border: 0">
											<option value="No">No</option>
											<option value="Si">Si</option>
										</select></td>
							<td colspan="6"><select type="text" class="form-control" id="electro2" name="electro2[]" style="border: 0" multiple>
											<option value="">-</option>
											<option value="Taladro">Taladro</option>
											<option value="Atornillador electrico">Atornillador electrico</option>
										</select></td>
						</tr>
						<tr>
							<td colspan="1">Mecánicas</td>
							<td colspan="1"><select type="text" class="form-control" name="mecan1" style="border: 0">
											<option value="No">No</option>
											<option value="Si">Si</option>
										</select></td>
							<td colspan="6"><select type="text" class="form-control" id="mecan2" name="mecan2[]" style="border: 0" multiple>
											<option value="">-</option>
											<option value="Brocas">Brocas</option>
											<option value="Limas">Limas</option>
											<option value="Destornilladores">Destornilladores</option>
											<option value="Tenazas">Tenazas</option>
										</select></td>
						</tr>
						<tr>
							<td colspan="1">Otras</td>
							<td colspan="1"><input type="text" name="otras1" size="5%" maxlength="30%" style="border: 0"></input></td>
							<td colspan="6"><input type="text" name="otras2" size="70%" maxlength="30%" style="border: 0"></input></td>
						</tr>
						<tr>
							<td align="center" class="titulos" colspan="8">ANALISIS DE LA TAREA</td>
						</tr>
						<tr>
							<td colspan="4">¿Qué tan alto se encuentra el lugar de trabajo?</td>
							<td colspan="4"><select type="text" class="form-control" name="alto" style="border: 0">
											<option value="6metros">6metros</option>
											<option value="10metros">10metros</option>
											<option value="12metros">12metros</option>
											<option value="16metros">16metros</option>
										</select></td>
						</tr>
						<tr>
							<td colspan="4">¿Cuál es el sistema de acceso al lugar de trabajo?</td>
							<td colspan="4"><select type="text" class="form-control" name="acceso" style="border: 0">
											<option value="Escaleras">Escaleras</option>
											<option value="Pretales">Pretales</option>
											<option value="Elevadores de personal">Elevadores de personal</option>
										</select></td>
						</tr>
						<tr>
							<td colspan="4">¿Se han establecido los puntos de anclaje?</td>
							<td colspan="4"><select type="text" class="form-control" name="puntos" style="border: 0">
											<option value="Si">Si</option>
											<option value="No">No</option>
										</select></td>
						</tr>
						<tr>
							<td colspan="4">¿Se han realizado los cálculos de la distancia de caída?</td>
							<td colspan="4"><select type="text" class="form-control" name="distancia" style="border: 0">
											<option value="Si">Si</option>
											<option value="No">No</option>
										</select></td>
						</tr>
						<tr>
							<td colspan="4">¿Cuáles son los sistemas de prevención y protección requeridos?</td>
							<td colspan="4"><select type="text" class="form-control" name="prevencion" style="border: 0">
											<option value="Línea de vida vertical">Línea de vida vertical</option>
											<option value="Línea de vida horizontal">Línea de vida horizontal</option>
											<option value="Sistemas de anclaje">Sistemas de anclaje</option>
											<option value="Arnés de Seguridad">Arnés de Seguridad</option>
										</select></td>
						</tr>
						<tr>
							<td colspan="4">¿Cuáles son los elementos de protección requeridos?</td>
							<td colspan="4"><select type="text" class="form-control" id="proteccion" name="proteccion[]" style="border: 0" multiple>
											<option value="Eslinga de posicionamiento">Eslinga de posicionamiento</option>
											<option value="Tie Off">Tie Off</option>
											<option value="Arnes de seguridad">Arnes de seguridad</option>
											<option value="Casco con barboquejo">Casco con barboquejo</option>
											<option value="Guantes">Guantes</option>
											<option value="Gafas">Gafas</option>
										</select></td>
						</tr>
						<tr>
							<td colspan="4">¿Cuántos trabajadores se requieren?</td>
							<td colspan="4"><select type="text" class="form-control" name="trabajadores" style="border: 0">
											<?php for ($i=1;$i<=10;$i++){
										echo '<option value="'.$i.'">'.$i.'</option>';}?>
										</select></td>
						</tr>
						<tr>
							<td colspan="4">¿Qué materiales y recursos van a utilizarse?</td>
							<td colspan="4"><input type="text" name="materiales" size="80%" maxlength="30%" style="border: 0"></input></td>
						</tr>
						<tr>
							<td colspan="4">¿Hay peligro de resbalar o tropezar alrededor del área de trabajo?</td>
							<td colspan="4"><select type="text" class="form-control" name="peligros" style="border: 0">
											<option value="Si">Si</option>
											<option value="No">No</option>
										</select></td>
						</tr>
						<tr>
							<td colspan="4">¿Qué otros peligros hay en el lugar de trabajo?
							(chispas, electricidad, químicos, superficie resbaladiza,
							superficies calientes, objetos filosos, cargas pesadas,
							etc.) Especifique:</td>
							<td colspan="4"><input type="text" name="peligro_otros" size="80%" maxlength="30%" style="border: 0"></input></td>
						</tr>
						<tr>
							<td align="center" class="titulos" colspan="2" width="25%">Pasos detallados de la tarea</td>
							<td align="center" class="titulos" colspan="2" width="25%">Peligros existentes y
							potenciales</td>
							<td align="center" class="titulos" colspan="2" width="25%">Consecuencias</td>
							<td align="center" class="titulos" colspan="2" width="25%">Controles Requeridos</td>
						</tr>
						<tr>
							<td colspan="2"><select type="text" class="form-control" name="tarea1" style="border: 0">
											<option value="">-</option>
											<option value="Inspeccion y selección de herramientas y EPP">Inspeccion y selección de herramientas y EPP</option>
										</select></td>
							<td colspan="2"><select type="text" class="form-control" name="riesgo1" style="border: 0">
											<option value="">-</option>
											<option value="Contacto con microorganismos">Contacto con microorganismos</option>
											<option value="Mordeduras, rasguños y picaduras">Mordeduras, rasguños y picaduras</option>
											<option value="Sobreesfuerzo, esfuerzo excesivo">Sobreesfuerzo, esfuerzo excesivo</option>
										</select></td>
							<td colspan="2"><select type="text" class="form-control" name="consecuencia1" style="border: 0">
											<option value="">-</option>
											<option value="Reacciones alérgicas, avenamiento">Reacciones alérgicas, avenamiento</option>
											<option value="Trastornos">Trastornos</option>
											<option value="lesiones osteomusculares, heridas, traumas, contusiones">lesiones osteomusculares, heridas, traumas, contusiones</option>
										</select></td>
							<td colspan="2"><select type="text" class="form-control" name="control1" style="border: 0">
											<option value="">-</option>
											<option value="Uso de EPP">Uso de EPP</option>
											<option value="Implementar programa de orden y aseo en sitio de trabajo">Implementar programa de orden y aseo en sitio de trabajo</option>
											<option value="Aplicación de procedimientos seguros">Aplicación de procedimientos seguros</option>
										</select></td>
						</tr>
						<tr>
							<td colspan="2"><select type="text" class="form-control" name="tarea2" style="border: 0">
											<option value="">-</option>
											<option value="Traslado a sitio de trabajo">Traslado a sitio de trabajo</option>
										</select></td>
							<td colspan="2"><select type="text" class="form-control" name="riesgo2" style="border: 0">
											<option value="">-</option>
											<option value="Alteraciones visuales ">Alteraciones visuales</option>
											<option value="Accidentes de trabajo - Vial">Accidentes de trabajo - Vial</option>
											<option value="Robos, atracos, asaltos, atentados, desorden público">Robos, atracos, asaltos, atentados, desorden público</option>
											<option value="Precipitaciones">Precipitaciones</option>
										</select></td>
							<td colspan="2"><select type="text" class="form-control" name="consecuencia2" style="border: 0">
											<option value="">-</option>
											<option value="Agotamiento, calambres y desmayos">Agotamiento, calambres y desmayos</option>
											<option value="Cefaleas">Cefaleas</option>
											<option value="Heridas, alteraciones del comportamiento">Heridas, alteraciones del comportamiento</option>
										</select></td>
							<td colspan="2"><select type="text" class="form-control" name="control2" style="border: 0">
											<option value="">-</option>
											<option value="Uso de EPP">Uso de EPP</option>
											<option value="Aplicación de procedimientos seguros">Aplicación de procedimientos seguros</option>
											<option value="Capacitación sobre las instrucciones del personal de seguridad ante un evento de riesgo público">Capacitación sobre las instrucciones del personal de seguridad ante un evento de riesgo público</option>
										</select></td>
						</tr>
						<tr>
							<td colspan="2"><select type="text" class="form-control" name="tarea3" style="border: 0">
											<option value="">-</option>
											<option value="Preparacion de materiales y elementos de la tarea a realizar">Preparacion de materiales y elementos de la tarea a realizar</option>
										</select></td>
							<td colspan="2"><select type="text" class="form-control" name="riesgo3" style="border: 0">
											<option value="">-</option>
											<option value="Contacto con microorganismos">Contacto con microorganismos</option>
											<option value="Mordeduras, rasguños y picaduras">Mordeduras, rasguños y picaduras</option>
											<option value="Sobreesfuerzo, esfuerzo excesivo">Sobreesfuerzo, esfuerzo excesivo</option>
										</select></td>
							<td colspan="2"><select type="text" class="form-control" name="consecuencia3" style="border: 0">
											<option value="">-</option>
											<option value="Reacciones alérgicas, avenamiento">Reacciones alérgicas, avenamiento</option>
											<option value="Trastornos">Trastornos</option>
											<option value="lesiones osteomusculares, heridas, traumas, contusiones">lesiones osteomusculares, heridas, traumas, contusiones</option>
										</select></td>
							<td colspan="2"><select type="text" class="form-control" name="control3" style="border: 0">
											<option value="">-</option>
											<option value="Uso de EPP">Uso de EPP</option>
											<option value="Implementar programa de orden y aseo en sitio de trabajo">Implementar programa de orden y aseo en sitio de trabajo</option>
											<option value="Aplicación de procedimientos seguros">Aplicación de procedimientos seguros</option>
											<option value="Realizar las tareas evitando las posturas incómodas del cuerpo.">Realizar las tareas evitando las posturas incómodas del cuerpo.</option>
											<option value="Trabajar en equipo, utilizar ayudas mecánicas.">Trabajar en equipo, utilizar ayudas mecánicas.</option>
										</select></td>
						</tr>
						<tr>
							<td colspan="2"><select type="text" class="form-control" name="tarea4" style="border: 0">
											<option value="">-</option>
											<option value="Uso de EPP e implementacion">Uso de EPP e implementacion</option>
										</select></td>
							<td colspan="2"><select type="text" class="form-control" name="riesgo4" style="border: 0">
											<option value="">-</option>
											<option value="Contacto con microorganismos">Contacto con microorganismos</option>
											<option value="Mordeduras, rasguños y picaduras">Mordeduras, rasguños y picaduras</option>
											<option value="Sobreesfuerzo, esfuerzo excesivo">Sobreesfuerzo, esfuerzo excesivo</option>
										</select></td>
							<td colspan="2"><select type="text" class="form-control" name="consecuencia4" style="border: 0">
											<option value="">-</option>
											<option value="Reacciones alérgicas, avenamiento">Reacciones alérgicas, avenamiento</option>
											<option value="Trastornos">Trastornos</option>
											<option value="lesiones osteomusculares, heridas, traumas, contusiones">lesiones osteomusculares, heridas, traumas, contusiones</option>
										</select></td>
							<td colspan="2"><select type="text" class="form-control" name="control4" style="border: 0">
											<option value="">-</option>
											<option value="Uso de EPP">Uso de EPP</option>
											<option value="Implementar programa de orden y aseo en sitio de trabajo">Implementar programa de orden y aseo en sitio de trabajo</option>
											<option value="Aplicación de procedimientos seguros">Aplicación de procedimientos seguros</option>
											<option value="Realizar las tareas evitando las posturas incómodas del cuerpo.">Realizar las tareas evitando las posturas incómodas del cuerpo.</option>
											<option value="Trabajar en equipo, utilizar ayudas mecánicas.">Trabajar en equipo, utilizar ayudas mecánicas.</option>
										</select></td>
						</tr>
						<tr>
							<td colspan="2"><select type="text" class="form-control" name="tarea5" style="border: 0">
											<option value="">-</option>
											<option value="Analisis del sitio de trabajo">Analisis del sitio de trabajo</option>
										</select></td>
							<td colspan="2"><select type="text" class="form-control" name="riesgo5" style="border: 0">
											<option value="">-</option>
											<option value="Alteraciones visuales ">Alteraciones visuales</option>
											<option value="Accidentes de trabajo - Vial">Accidentes de trabajo - Vial</option>
											<option value="Robos, atracos, asaltos, atentados, desorden público">Robos, atracos, asaltos, atentados, desorden público</option>
											<option value="Precipitaciones">Precipitaciones</option>
										</select></td>
							<td colspan="2"><select type="text" class="form-control" name="consecuencia5" style="border: 0">
											<option value="">-</option>
											<option value="Agotamiento, calambres y desmayos">Agotamiento, calambres y desmayos</option>
											<option value="Cefaleas">Cefaleas</option>
											<option value="Heridas, alteraciones del comportamiento">Heridas, alteraciones del comportamiento</option>
										</select></td>
							<td colspan="2"><select type="text" class="form-control" name="control5" style="border: 0">
											<option value="">-</option>
											<option value="Uso de EPP">Uso de EPP</option>
											<option value="Aplicación de procedimientos seguros">Aplicación de procedimientos seguros</option>
											<option value="Capacitación sobre las instrucciones del personal de seguridad ante un evento de riesgo público">Capacitación sobre las instrucciones del personal de seguridad ante un evento de riesgo público</option>
										</select></td>
						</tr>
						<tr>
							<td colspan="2"><select type="text" class="form-control" name="tarea6" style="border: 0">
											<option value="">-</option>
											<option value="Ascenso al poste">Ascenso al poste</option>
										</select></td>
							<td colspan="2"><select type="text" class="form-control" name="riesgo6" style="border: 0">
											<option value="">-</option>
											<option value="Trabajo en alturas">Trabajo en alturas</option>
											<option value="Exceso de iluminacion">Exceso de iluminacion</option>
											<option value="Contacto con alta y baja tension de electricidad">Contacto con alta y baja tension de electricidad</option>
											<option value="Mordeduras, rasguños y picaduras.">Mordeduras, rasguños y picaduras.</option>
											<option value="precipitaciones.">precipitaciones.</option>
										</select></td>
							<td colspan="2"><select type="text" class="form-control" name="consecuencia6" style="border: 0">
											<option value="">-</option>
											<option value="Caída de personas a distinto nivel">Caída de personas a distinto nivel</option>
											<option value="Trastornos.">Trastornos.</option>
											<option value="Sobreesfuerzo, esfuerzo excesivo">Sobreesfuerzo, esfuerzo excesivo</option>
											<option value="lesiones osteomusculares, heridas, traumas, contusiones">lesiones osteomusculares, heridas, traumas, contusiones</option>
											<option value="Alteraciones visuales">Alteraciones visuales</option>
										</select></td>
							<td colspan="2"><select type="text" class="form-control" name="control6" style="border: 0">
											<option value="">-</option>
											<option value="Usos de sistemas de protección contra caídas.">Usos de sistemas de protección contra caídas.</option>
											<option value="Inspecciones periódicas a elementos de protección personal">Inspecciones periódicas a elementos de protección personal</option>
											<option value="Formación en trabajo seguro en alturas.">Formación en trabajo seguro en alturas.</option>
											<option value="Capacitación al personal en identificación y control de peligros y riesgos.">Capacitación al personal en identificación y control de peligros y riesgos.</option>
										</select></td>
						</tr>
						<tr>
							<td colspan="2"><select type="text" class="form-control" name="tarea7" style="border: 0">
											<option value="">-</option>
											<option value="Realizacion de manipulacion de cableado en fibra, cajas de empalme">Realizacion de manipulacion de cableado en fibra, cajas de empalme</option>
										</select></td>
							<td colspan="2"><select type="text" class="form-control" name="riesgo7" style="border: 0">
											<option value="">-</option>
											<option value="Contacto con microorganismos">Contacto con microorganismos</option>
											<option value="Mordeduras, rasguños y picaduras">Mordeduras, rasguños y picaduras</option>
											<option value="Sobreesfuerzo, esfuerzo excesivo">Sobreesfuerzo, esfuerzo excesivo</option>
										</select></td>
							<td colspan="2"><select type="text" class="form-control" name="consecuencia7" style="border: 0">
											<option value="">-</option>
											<option value="Reacciones alérgicas, avenamiento">Reacciones alérgicas, avenamiento</option>
											<option value="Trastornos">Trastornos</option>
											<option value="lesiones osteomusculares, heridas, traumas, contusiones">lesiones osteomusculares, heridas, traumas, contusiones</option>
										</select></td>
							<td colspan="2"><select type="text" class="form-control" name="control7" style="border: 0">
											<option value="">-</option>
											<option value="Uso de EPP">Uso de EPP</option>
											<option value="Implementar programa de orden y aseo en sitio de trabajo">Implementar programa de orden y aseo en sitio de trabajo</option>
											<option value="Aplicación de procedimientos seguros">Aplicación de procedimientos seguros</option>
											<option value="Realizar las tareas evitando las posturas incómodas del cuerpo.">Realizar las tareas evitando las posturas incómodas del cuerpo.</option>
											<option value="Trabajar en equipo, utilizar ayudas mecánicas.">Trabajar en equipo, utilizar ayudas mecánicas.</option>
										</select></td>
						</tr>
						<tr>
							<td colspan="2"><select type="text" class="form-control" name="tarea8" style="border: 0">
											<option value="">-</option>
											<option value="Descenso del poste">Descenso del poste</option>
										</select></td>
							<td colspan="2"><select type="text" class="form-control" name="riesgo8" style="border: 0">
											<option value="">-</option>
											<option value="Trabajo en alturas">Trabajo en alturas</option>
											<option value="Exceso de iluminacion">Exceso de iluminacion</option>
											<option value="Contacto con alta y baja tension de electricidad">Contacto con alta y baja tension de electricidad</option>
											<option value="Mordeduras, rasguños y picaduras.">Mordeduras, rasguños y picaduras.</option>
											<option value="precipitaciones.">precipitaciones.</option>
										</select></td>
							<td colspan="2"><select type="text" class="form-control" name="consecuencia8" style="border: 0">
											<option value="">-</option>
											<option value="Caída de personas a distinto nivel">Caída de personas a distinto nivel</option>
											<option value="Trastornos.">Trastornos.</option>
											<option value="Sobreesfuerzo, esfuerzo excesivo">Sobreesfuerzo, esfuerzo excesivo</option>
											<option value="lesiones osteomusculares, heridas, traumas, contusiones">lesiones osteomusculares, heridas, traumas, contusiones</option>
											<option value="Alteraciones visuales">Alteraciones visuales</option>
										</select></td>
							<td colspan="2"><select type="text" class="form-control" name="control8" style="border: 0">
											<option value="">-</option>
											<option value="Usos de sistemas de protección contra caídas.">Usos de sistemas de protección contra caídas.</option>
											<option value="Inspecciones periódicas a elementos de protección personal">Inspecciones periódicas a elementos de protección personal</option>
											<option value="Formación en trabajo seguro en alturas.">Formación en trabajo seguro en alturas.</option>
											<option value="Capacitación al personal en identificación y control de peligros y riesgos.">Capacitación al personal en identificación y control de peligros y riesgos.</option>
										</select></td>
						</tr>
						<tr>
							<td align="center" class="titulos" colspan="8">EVALUACION DEL RIESGO</td>
						</tr>
						<tr>
							<td colspan="8" style="font-weight: bold">¿Es posible, probable o casi-seguro que ocurra un incidente?</td>
						</tr>
						<tr>
							<td colspan="8"><input type="radio" name="incidente" value="0"></input>&nbsp;Si, deténgase y no proceda con la tarea. Analice con el supervisor encargado el paso a paso, revisen controles y
							responda la siguiente pregunta.</td>
						</tr>
						<tr>
							<td colspan="8"><input type="radio" name="incidente" value="1"></input>&nbsp;No, continúe con la tarea con precaución, implemente los controles establecidos.</td>
						</tr>
						<tr>
							<td colspan="8" style="font-weight: bold">¿Es seguro proceder ahora en la tarea con los controles adicionales?</td>
						</tr>
						<tr>
							<td colspan="8"><input type="radio" name="seguro" value="0"></input>&nbsp;Si, proceda con la tarea.</td>
						</tr>
						<tr>
							<td colspan="8"><input type="radio" name="seguro" value="1"></input>&nbsp;No, consulte al supervisor antes de tomar cualquier decisión.</td>
						</tr>
						<tr>
							<td align="center" class="titulos" colspan="5" width="70%">Nombre y Cedula de los trabajadores (Ejecutor)</td>
							<td align="center" class="titulos" colspan="3" width="30%">Firma</td>
						</tr>
						<tr>
							<td align="center" colspan="5" width="70%"><?php echo $colaborador['name'].' CC: '.$colaborador['dto']; ?></td>
							<td align="center" colspan="3" width="30%"><img alt="image" class="img-responsive"
                                                 src="<?php echo base_url('userfiles/employee_sign/' . $colaborador['sign']); ?>" style="width: 40%"></td>
						</tr>
							<td align="center" class="titulos" colspan="5" width="70%">Nombre y Cedula de la persona (Emisor)</td>
							<td align="center" class="titulos" colspan="3" width="30%">Firma</td>
						</tr>
						<tr>
							<td align="center" colspan="5" width="70%"></td>
							<td align="center" colspan="3" width="30%"></td>
						</tr>
					  </tbody>
					</table>
					

				</div>
				
                <div class="form-group row">
					
                    <label class="col-sm-12 col-form-label"></label>
					
                    <div class="col-sm-12" align="center">
                        <input type="submit" id="submit-data" class="btn btn-success margin-bottom"
                               value="<?php echo $this->lang->line('Add') ?>" data-loading-text="Adding...">
                        <input type="hidden" value="encuesta/addats" id="action-url">
                    </div>
                </div>

            </div>
        </form>
    </div>
</article>
<script>
$("#biologico2").select2();
$("#biomeca2").select2();
$("#fenomeno2").select2();
$("#fisico2").select2();	
$("#manual2").select2();	
$("#electro2").select2();	
$("#mecan2").select2();	
$("#proteccion").select2();	
	
	
</script>

