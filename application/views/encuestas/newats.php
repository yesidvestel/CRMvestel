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
							  <input type="text" placeholder="End Date" name="horain" autocomplete="false" value="<?php echo date("g:i a") ?>"></td>
						  <td colspan="4">Hora de Finalización ( p.m.): 
							  <input type="text" placeholder="End Date" name="horafin" autocomplete="false" value="<?php echo date("g:i a") ?>"></td>
						</tr>
						<tr>
						  <td valign="top" colspan="4">Descripción de la tarea a realizar:  </td>
							<td colspan="4"><textarea name="tarea" cols="90"></textarea></td>
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
							<td colspan="1" width="5%"><input type="text" name="manual1" size="5%" maxlength="30%" style="border: 0"></input></td>
							<td colspan="7"><input type="text" name="manual2" size="70%" maxlength="30%" style="border: 0"></input></td>
						</tr>
						<tr>
							<td colspan="1">Eléctricas</td>
							<td colspan="1"><input type="text" name="electro1" size="5%" maxlength="30%" style="border: 0"></input></td>
							<td colspan="6"><input type="text" name="electro2" size="70%" maxlength="30%" style="border: 0"></input></td>
						</tr>
						<tr>
							<td colspan="1">Mecánicas</td>
							<td colspan="1"><input type="text" name="mecan1" size="5%" maxlength="30%" style="border: 0"></input></td>
							<td colspan="6"><input type="text" name="mecan2" size="70%" maxlength="30%" style="border: 0"></input></td>
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
							<td colspan="4"><input type="text" name="alto" size="80%" maxlength="30%" style="border: 0"></input></td>
						</tr>
						<tr>
							<td colspan="4">¿Cuál es el sistema de acceso al lugar de trabajo?</td>
							<td colspan="4"><input type="text" name="acceso" size="80%" maxlength="30%" style="border: 0"></input></td>
						</tr>
						<tr>
							<td colspan="4">¿Se han establecido los puntos de anclaje?</td>
							<td colspan="4"><input type="text" name="puntos" size="80%" maxlength="30%" style="border: 0"></input></td>
						</tr>
						<tr>
							<td colspan="4">¿Se han realizado los cálculos de la distancia de caída?</td>
							<td colspan="4"><input type="text" name="distancia" size="80%" maxlength="30%" style="border: 0"></input></td>
						</tr>
						<tr>
							<td colspan="4">¿Cuáles son los sistemas de prevención y protección requeridos?</td>
							<td colspan="4"><input type="text" name="prevencion" size="80%" maxlength="30%" style="border: 0"></input></td>
						</tr>
						<tr>
							<td colspan="4">¿Cuáles son los elementos de protección requeridos?</td>
							<td colspan="4"><input type="text" name="proteccion" size="80%" maxlength="30%" style="border: 0"></input></td>
						</tr>
						<tr>
							<td colspan="4">¿Cuántos trabajadores se requieren?</td>
							<td colspan="4"><input type="text" name="trabajadores" size="80%" maxlength="30%" style="border: 0"></input></td>
						</tr>
						<tr>
							<td colspan="4">¿Qué materiales y recursos van a utilizarse?</td>
							<td colspan="4"><input type="text" name="materiales" size="80%" maxlength="30%" style="border: 0"></input></td>
						</tr>
						<tr>
							<td colspan="4">¿Hay peligro de resbalar o tropezar alrededor del área de trabajo?</td>
							<td colspan="4"><input type="text" name="peligros" size="80%" maxlength="30%" style="border: 0"></input></td>
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
							<td colspan="2"><input type="text" name="tarea1" size="40%" maxlength="30%" style="border: 0"></input></td>
							<td colspan="2"><input type="text" name="riesgo1" size="40%" maxlength="30%" style="border: 0"></input></td>
							<td colspan="2"><input type="text" name="consecuencia1" size="40%" maxlength="30%" style="border: 0"></input></td>
							<td colspan="2"><input type="text" name="control1" size="40%" maxlength="30%" style="border: 0"></input></td>
						</tr>
						<tr>
							<td colspan="2"><input type="text" name="tarea2" size="40%" maxlength="30%" style="border: 0"></input></td>
							<td colspan="2"><input type="text" name="riesgo2" size="40%" maxlength="30%" style="border: 0"></input></td>
							<td colspan="2"><input type="text" name="consecuencia2" size="40%" maxlength="30%" style="border: 0"></input></td>
							<td colspan="2"><input type="text" name="control2" size="40%" maxlength="30%" style="border: 0"></input></td>
						</tr>
						<tr>
							<td colspan="2"><input type="text" name="tarea3" size="40%" maxlength="30%" style="border: 0"></input></td>
							<td colspan="2"><input type="text" name="riesgo3" size="40%" maxlength="30%" style="border: 0"></input></td>
							<td colspan="2"><input type="text" name="consecuencia3" size="40%" maxlength="30%" style="border: 0"></input></td>
							<td colspan="2"><input type="text" name="control3" size="40%" maxlength="30%" style="border: 0"></input></td>
						</tr>
						<tr>
							<td colspan="2"><input type="text" name="tarea4" size="40%" maxlength="30%" style="border: 0"></input></td>
							<td colspan="2"><input type="text" name="riesgo4" size="40%" maxlength="30%" style="border: 0"></input></td>
							<td colspan="2"><input type="text" name="consecuencia4" size="40%" maxlength="30%" style="border: 0"></input></td>
							<td colspan="2"><input type="text" name="control4" size="40%" maxlength="30%" style="border: 0"></input></td>
						</tr>
						<tr>
							<td colspan="2"><input type="text" name="tarea5" size="40%" maxlength="30%" style="border: 0"></input></td>
							<td colspan="2"><input type="text" name="riesgo5" size="40%" maxlength="30%" style="border: 0"></input></td>
							<td colspan="2"><input type="text" name="consecuencia5" size="40%" maxlength="30%" style="border: 0"></input></td>
							<td colspan="2"><input type="text" name="control5" size="40%" maxlength="30%" style="border: 0"></input></td>
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

