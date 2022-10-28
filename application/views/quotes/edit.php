
<div class="app-content content container-fluid">
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="card card-block">
                <div id="notify" class="alert alert-success" style="display:none;">
                    <a href="#" class="close" data-dismiss="alert">&times;</a>

                    <div class="message"></div>
                </div>
                <form method="post" id="data_form" name="soporte">


                    <div class="row">


                        <div class="col-sm-6 cmp-pnl">
                            <div id="customerpanel" class="inner-cmp-pnl">                               

                                
                                <div id="customer">
                                    <div class="clientinfo">
										<h3 class="title">Detalles Usuario</h3>
                                        <hr>
										<input type="hidden" name="customer_id" value="<?php echo $details['id'] ?>"></input>
                                        <?php echo $thread_info['name'].' '.$thread_info['unoapellido'] ?>
                                    </div>
                                    <div class="clientinfo">
                                        Documento: <?php echo $thread_info['documento'] ?>
                                    </div>
                                    <div class="clientinfo">
                                        Celular: <?php echo $thread_info['celular'] ?>
                                    </div>
									<div class="clientinfo">
                                        Direccion: <?php echo $thread_info['nomenclatura'] ?> <?php echo $thread_info['numero1'] ?><?php echo $thread_info['adicionauno'] ?> N <?php echo $thread_info['numero2'] ?> <?php echo $thread_info['adicional2'] ?> - <?php echo $thread_info['numero3'] ?>
                                    </div>
                                    <hr>                                    
                                </div>


                            </div>
                        </div>
                        <div class="col-sm-6 cmp-pnl">
                            <div class="inner-cmp-pnl">


                                <div class="form-group row">
									<input type="text" class="form-control" placeholder="Invoice #" name="ticketnumero"
                                                   value="<?php echo $thread_info['codigo'] ?>"></input>
                                    <div class="col-sm-12"><h3
                                                class="title"><?php echo $this->lang->line('') ?>Propiedades de orden</h3>
                                    </div>

                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-6">
										<label for="invocieno" class="caption">Tipo de orden</label>
                                        <div class="input-group">
                                            <div class="input-group-addon">
											<span class="icon-file-text-o" aria-hidden="true"></span></div>
											<input type="hidden" value="<?php echo $thread_info['idt'] ?>" name="customer_id"></input>
                                            	<select name="subject" class="form-control" onchange="cambia()">
													<option value="<?php echo $thread_info['subject'] ?>">>><?php echo $thread_info['subject'] ?></option>
													<option value="servicio">Orden de servicio</option>								
													<option value="reclamo">Orden de reclamo</option>
												</select>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
										<label for="invocieno" class="caption">Detalle de orden</label>
                                        <div class="input-group">
                                            <div class="input-group-addon">
												<span class="icon-bookmark-o" aria-hidden="true"></span></div>
                                            <select class=" col-sm-2 form-control" name="detalle" id="detalle">
													<option value="<?php echo $thread_info['detalle'] ?>">>><?php echo $thread_info['detalle'] ?></option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">

                                    <div class="col-sm-6">
										<label for="invociedate" class="caption">Fecha de orden</label>

                                        <div class="input-group">
                                            <div class="input-group-addon"><span class="icon-calendar4"
                                                                                 aria-hidden="true"></span></div>
                                            <input type="text" class="form-control required"
                                                   placeholder="Billing Date" name="created"
                                                   autocomplete="false" value="<?php echo $thread_info['created'] ?>" readonly>
                                        </div>
                                    </div>
									<div class="col-sm-6">
										<label for="invociedate" class="caption">Factura mes</label>
										<div class="input-group">
											
											<select name="factura" class="form-control mb-1">
												<option value='<?php echo $thread_info['id_factura'] ?>'>>><?php echo $thread_info['id_factura'] ?></option>
												<?php
											
													foreach ($facturalist as $row) {
														$cid = $row['id'];
														$title = $row['tid'];
														setlocale(LC_TIME, "spanish");
														$mes = date(" F ",strtotime($row['invoicedate']));
														
														echo "<option value='$title'>$title".' '. strftime("%B del %Y", strtotime($mes))." </option>";
													}
													?>
											</select>
										</div>
                                        </div>
                                    </div>
								<div class="form-group row">									
                                    <div class="col-sm-12">										
										<h3 class="title">Agendar</h3>
                                    </div>
                                </div>
								<div class="form-group row">
									<div class="col-sm-4">
										<label for="invociedate" class="caption">Agendar</label>
										<div class="input-group">
										<select name="agendar" id="agendar" class="form-control mb-1">
												<option value='no'>No</option>
												<option value='si'>Si</option>
												<option value="actualizar">Actualizar</option>
											</select>
										</div>
                                        </div>
                                    <div class="col-sm-4">
										<label for="invociedate" class="caption">Fecha a realizar</label>

                                        <div class="input-group">
                                            <div class="input-group-addon"><span class="icon-calendar4"
                                                                                 aria-hidden="true"></span></div>
                                            <input type="text" class="form-control"
                                                   placeholder="Billing Date" name="f_agenda"
                                                   data-toggle="datepicker"
                                                   autocomplete="false">
											
                                        </div>
										
                                    
                                </div>
									<div class="col-sm-4">
										<label for="invociedate" class="caption">Hora</label>

                                        <div class="input-group">
                                            <div class="input-group-addon"><span class="icon-calendar4"
                                                                                 aria-hidden="true"></span></div>
                                            <input type="text" class="form-control"
                                           placeholder="End Date" name="hora"
                                            autocomplete="false" value="<?php echo date("g:i a") ?>">
                                        </div>
									</div>
                                    
                                </div>
							<div id="ocultar">								
							<div class="form-group row" id="Traslado">
																		
                                    <div class="col-sm-12">
										<h3 class="title">Nueva Direccion</h3>
                                    </div>
                                
									<div class="col-sm-2">
										
										<div class="input-group">
										<select name="nomenclatura" class="form-control mb-1">
												<option value="<?php echo $temporal['nomenclatura'] ?>"><?php echo $temporal['nomenclatura'] ?></option>
												<option value="Calle">Calle</option>
                                                <option value="Carrera">Carrera</option>
                                                <option value="Diagonal">Diagonal</option>
                                                <option value="Transversal">Transversal</option>
												<option value="Manzana">Manzana</option>
												<option value="Modulo">Modulo</option>
											</select>
										</div>
                                        </div>
                                    <div class="col-sm-2" style="margin-left: -10px;">
                                        <div class="input-group">
												<input type="text" placeholder="Numero"class="form-control margin-bottom" name="numero1" value="<?php echo $temporal['nuno'] ?>">
                                		</div>
									</div>
									<div class="col-sm-2" style="margin-left: -14px;">
                                        <div class="input-group">
                                             <select class="form-control mb-1" name="adicional1">
													<option value="<?php echo $temporal['auno'] ?>"><?php echo $temporal['auno'] ?></option>
                                                 	<option value="">-</option>
												 	<option value="bis">bis</option>
													<option value="sur">sur</option>
                                                	<option value="a">a</option>
													<option value="a">a sur</option>
                                                  	<option value="b">b</option>
													<option value="a">b sur</option>
                                                	<option value="c">c</option>
                                                    <option value="d">d</option>
                                                    <option value="e">e</option>
													<option value="f">f</option>
													<option value="g">g</option>
													<option value="h">h</option>
                                                    <option value="a bis">a bis</option>
                                                    <option value="b bis">b bis</option>
                                                    <option value="c bis">c bis</option>
                                                    <option value="d bis">d bis</option>
                                            </select>
                                        </div>
                                	</div>
									<div class="col-sm-1" style="margin-left: -14px;">
                                        <div class="input-group">
												<label class="col-form-label" for="Nº">Nº</label>
                                		</div>
									</div>
									<div class="col-sm-2" style="margin-left: -14px;">
                                        <div class="input-group">
												<input type="text" placeholder="Numero"class="form-control margin-bottom" name="numero2" value="<?php echo $temporal['ndos'] ?>">
                                		</div>
									</div>
									<div class="col-sm-2" style="margin-left: -14px;">
                                        <div class="input-group">
                                             <select class="form-control mb-1" name="adicional2">
													<option value="<?php echo $temporal['ados'] ?>"><?php echo $temporal['ados'] ?></option>
												 	<option value="">-</option>
                                                    <option value="bis">bis</option>
													<option value="sur">sur</option>
                                                	<option value="a">a</option>
													<option value="a">a sur</option>
                                                  	<option value="b">b</option>
													<option value="a">b sur</option>
                                                	<option value="c">c</option>
                                                    <option value="d">d</option>
                                                    <option value="e">e</option>
													<option value="f">f</option>
													<option value="g">g</option>
													<option value="h">h</option>
                                                    <option value="a bis">a bis</option>
                                                    <option value="b bis">b bis</option>
                                                    <option value="c bis">c bis</option>
                                                    <option value="d bis">d bis</option>
                                            </select>
                                        </div>
                                	</div>
									<div class="col-sm-2">
                                        <div class="input-group">
												<input type="text" placeholder="Numero"class="form-control margin-bottom" name="numero3" value="<?php echo $temporal['ntres'] ?>">
                                		</div>
									</div>
									<div class="col-sm-6">
									<label for="invociedate" class="caption">Localidad</label>
										<div class="input-group">
											
											<select name="localidad" id="cmbLocalidades" class="form-control mb-1">
												<option value='<?php echo $local['idLocalidad'] ?>'><?php echo $local['localidad'] ?></option>
												<?php
													foreach ($localidades as $row) {
														$cid = $row->idLocalidad;
														$local = $row->localidad;
														echo "<option value='$cid'>$local</option>";
													}
													?>
											</select>
											
										</div>
                                   </div>
									<div class="col-sm-6">
									<label for="invociedate"  class="caption">Barrio</label>
										<div class="input-group">									
											<select name="barrio" id="cmbBarrios" class="form-control mb-1">
												<option value="<?php echo $barrio['idBarrio'] ?>"><?php echo $barrio['barrio'] ?></option>
											</select>
										</div>
                                   </div>
								<div class="col-sm-6">
									<label for="invociedate" class="caption">Recidencia</label>
										<div class="input-group">									
											<select class="form-control" name="residencia">
													<option value="<?php echo $temporal['residencia'] ?>"><?php echo $temporal['residencia'] ?></option>
													<option value="Casa">Casa</option>
                                                	<option value="Apartamento">Apartamento</option>
                                                  	<option value="Edificio">Edificio</option>
                                                	<option value="Oficina">Oficina</option>
                                            </select>
										</div>
                                   </div>
								<div class="col-sm-6">
									<label for="invociedate" class="caption">Referencia</label>
                                        <div class="input-group">
												<input type="text" class="form-control margin-bottom" name="referencia" value="<?php echo $temporal['referencia'] ?>">
                                		</div>
									</div>
								</div>
								<div class="form-group row" id="Instalacion">	
                                    <div class="col-sm-12">
										<h3 class="title">Asignar servicio</h3>
                                    </div>
									<div class="col-sm-4">
									<label for="invociedate" class="caption">Television</label>
										<div class="input-group">									
											<select name="tele" class="form-control mb-1">
												<option value="<?php echo $temporal['tv'] ?>"><?php echo $temporal['tv'] ?></option>
												<option value="no">No</option>
                                        		<?php
													foreach ($paquete as $row) {
														$cid = $row['pid'];
														$title = $row['product_name'];
														echo "<option value='$title'>$title</option>";
													}
												?>
											</select>
										</div>
                                   </div>
									<div class="col-sm-4">
									<label for="invociedate" class="caption">Internet</label>
										<div class="input-group">									
											<select name="inter" class="form-control mb-1">
												<option value="<?php echo $temporal['internet'] ?>"><?php echo $temporal['internet'] ?></option>
												<option value="no">No</option>
												<?php
													foreach ($paqueteinter as $row) {
														$cid = $row['pid'];
														$title = $row['product_name'];
														echo "<option value='$title'>$title</option>";
													}
												?>
											</select>
										</div>
                                   </div>
									
									<div class="col-sm-4">
									<label for="invociedate" class="caption">Puntos</label>
										<div class="input-group">									
											<select name="punto" class="form-control mb-1">
												<option value="<?php echo $temporal['puntos'] ?>"><?php echo $temporal['puntos'] ?></option>
												<option value="0">no</option>
													<?php for ($i=1;$i<=20;$i++){
													echo '<option value="'.$i.'">'.$i.'</option>';}?>
											</select>
										</div>
                                   </div>
								</div>
								<div class="form-group row" id="Subir_megas">	
                                    <div class="col-sm-12">
										<h3 class="title">Subir megas</h3>
                                    </div>
									<div class="col-sm-4">
										<label for="invociedate" class="caption">Paquete</label>
											<select name="suinter" class="form-control mb-1">
												<option value="no">No</option>
												<?php
													foreach ($paqueteinter as $row) {
														$cid = $row['pid'];
														$title = $row['product_name'];
														echo "<option value='$title'>$title</option>";
													}
												?>
											</select>
									</div>
									<div class="col-sm-4">
									<label for="invociedate" class="caption">Perfil Mikrotik</label>
										<div class="input-group">									
											<select name="supaquete" class="form-control mb-1">
												<option value="0">no</option>
													<?php for ($i=1;$i<=10;$i++){
													echo '	<option value="'.$i*'10'.'Megas">'.$i*'10'.'Megas</option>
															<option value="'.$i*'10'.'MegasSt">'.$i*'10'.'MegasSt</option>
															<option value="'.$i*'10'.'MegasD">'.$i*'10'.'MegasD</option>'
														
														;}?>
											</select>
										</div>
                                   </div>
								</div>
								<div class="form-group row" id="Bajar_megas">	
                                    <div class="col-sm-12">
										<h3 class="title">Bajar megas</h3>
                                    </div>
									<div class="col-sm-4">
										<label for="invociedate" class="caption">Paquete</label>
											<select name="bainter" class="form-control mb-1">
												<option value="no">No</option>
												<?php
													foreach ($paqueteinter as $row) {
														$cid = $row['pid'];
														$title = $row['product_name'];
														echo "<option value='$title'>$title</option>";
													}
												?>
											</select>
									</div>
									<div class="col-sm-4">
									<label for="invociedate" class="caption">Perfil Mikrotik</label>
										<div class="input-group">									
											<select name="bapaquete" class="form-control mb-1">
												<option value="0">no</option>
													<?php for ($i=1;$i<=10;$i++){
													echo '	<option value="'.$i*'10'.'Megas">'.$i*'10'.'Megas</option>
															<option value="'.$i*'10'.'MegasSt">'.$i*'10'.'MegasSt</option>
															<option value="'.$i*'10'.'MegasD">'.$i*'10'.'MegasD</option>'
														
														;}?>
											</select>
										</div>
                                   </div>
								</div>
								<div class="form-group row" id="AgregarTelevision">	
                                    <div class="col-sm-12">
										<h3 class="title">Asignar servicio</h3>
                                    </div>
									<div class="col-sm-4">
									<label for="invociedate" class="caption">Television</label>
										<div class="input-group">									
											<select name="teleB" class="form-control mb-1">
												<option value="<?php echo $temporales->tv ?>"><?php echo $temporales->tv ?></option>
												<option value="no">No</option>
                                        		<?php
													foreach ($paquete as $row) {
														$cid = $row['pid'];
														$title = $row['product_name'];
														echo "<option value='$title'>$title</option>";
													}
												?>
											</select>
										</div>
                                   </div>
									<div class="col-sm-4">
									<label for="invociedate" class="caption">Puntos</label>
										<div class="input-group">									
											<select name="puntoB" class="form-control mb-1">
												<option value="<?php echo $temporales->puntos ?>"><?php echo $temporales->puntos ?></option>
												<option value="0">no</option>
													<?php for ($i=1;$i<=20;$i++){
													echo '<option value="'.$i.'">'.$i.'</option>';}?>
											</select>
										</div>
                                   </div>
								</div>
								<div class="form-group row" id="Revision_de_Internet">
                        <div class="col-sm-12">
                            <label for="toAddInfo" class="caption">Posible Problema</label>
                            	<select name="problema" class="form-control mb-1">
									<option value="<?php echo $thread_info['problema'] ?>"><?php echo $thread_info['problema'] ?></option>
									<option value="">-</option>
									<option value="Internet lento">Internet lento</option>
									<option value="No aparece la Red">No aparece la Red</option>
									<option value="No prende Cablemoden">No prende Cablemoden</option>
									<option value="Fibra Rota">Fibra Rota</option>
									<option value="Cable Caido">Cable Caido</option>
									<option value="Desconfigurado Cablemoden">Desconfigurado Cablemoden</option>
									<option value="Cambio de Tecnologia">Cambio de Tecnologia</option>
									<option value="No hay Internet">No hay Internet</option>
								</select>
						</div>
                    </div>
					<div class="form-group row" id="Revision_de_television">
                        <div class="col-sm-12">
                            <label for="toAddInfo" class="caption">Posible Problema</label>
                            	<select name="problema" class="form-control mb-1">
									<option value="<?php echo $thread_info['problema'] ?>"><?php echo $thread_info['problema'] ?></option>
									<option value="">-</option>
									<option value="Señal Lluviosa">Señal Lluviosa</option>
									<option value="Televisor desconfigurado">Televisor desconfigurado</option>
									<option value="Cambio de Tecnologia">Cambio de Tecnologia</option>
									<option value="No hay Television">No hay Television</option>
								</select>
						</div>
                    </div>
								<div class="form-group row" id="AgregarInternet">	
                                    <div class="col-sm-12">
										<h3 class="title">Asignar servicio</h3>
                                    </div>
									<div class="col-sm-4">
									<label for="invociedate" class="caption">Internet</label>
										<div class="input-group">									
											<select name="interB" class="form-control mb-1">
												<option value="<?php echo $temporales->internet ?>"><?php echo $temporales->internet ?></option>
												<option value="no">No</option>
												<?php
													foreach ($paqueteinter as $row) {
														$cid = $row['pid'];
														$title = $row['product_name'];
														echo "<option value='$title'>$title</option>";
													}
												?>
											</select>
										</div>
                                   </div>
									
								</div>
                              </div>  
							</div>
                        </div>

                    </div>

                    <div class="form-group row">
                        <div class="col-sm-12">
                            <label for="toAddInfo" class="caption">Descripcion de Orden</label>
                            <textarea class="summernote" name="section" id="contents" rows="2"><?php echo $thread_info['section'] ?></textarea></div>
                    </div>
                   
					<input type="submit" class="btn btn-success sub-btn" value="Actualizar" id="submit-data" data-loading-text="Creating...">
						
                    <input type="hidden" value="quote/editaction" id="action-url">
                    <input type="hidden" value="search" id="billtype">
                    <input type="hidden" value="0" name="counter" id="ganak">
                    <input type="hidden" value="<?php echo $this->config->item('currency'); ?>" name="currency">
                    <input type="hidden" value="%" name="taxformat" id="tax_format">
                    <input type="hidden" value="%" name="discountFormat" id="discount_format">
                    <input type="hidden" value="<?php if ($this->config->item('tax') == 1) {
                        echo 'yes';
                    } else {
                        echo 'no';
                    } ?>" name="tax_handle" id="tax_status">
                    <input type="hidden" value="yes" name="applyDiscount" id="discount_handle">


                </form>
            </div>

        </div>
    </div>
</div>
<script type="text/javascript">
    $(function () {
        $('.summernote').summernote({
            height: 100,
            toolbar: [
                // [groupName, [list of button]]
                ['style', ['bold', 'italic', 'underline', 'clear']],
                ['font', ['strikethrough', 'superscript', 'subscript']],
                ['fontsize', ['fontsize']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['height', ['height']],
                ['fullscreen', ['fullscreen']],
                ['codeview', ['codeview']]
            ]
        });
    });
	// selecion de orden
	<?php if ($this->aauth->get_user()->roleid == 5 || $this->aauth->get_user()->tiknue != null) { ?>
	var perfil_servicio = new Array ("...","Reconexion Combo","Reinstalación","Activacion","Reconexion Television","Retiro voluntario","Recuperación cable modem","Cambio de clave","Veeduria","Reconexion Internet","AgregarInternet","AgregarTelevision","Migracion","Bajar_megas","Cambio de equipo","Corte Combo","Corte Internet","Corte Television","Equipo adicional","Instalacion","Punto nuevo","Subir_megas","Suspension Combo","Suspension Internet","Suspension Television","Traslado","Toma Adicional");
	<?php } else if ($this->aauth->get_user()->roleid == 4 || $this->aauth->get_user()->usadm != null) { ?>
	var perfil_servicio = new Array ("...","AgregarInternet","Reinstalación","Activacion","AgregarTelevision","Retiro voluntario","Recuperación cable modem","Cambio de clave","Migracion","Veeduria","Bajar_megas","Cambio de equipo","Corte Combo","Corte Internet","Corte Television","Equipo adicional","Instalacion","Punto nuevo","Subir_megas","Suspension Combo","Suspension Internet","Suspension Television","Traslado","Toma Adicional");
	<?php } else { ?>
	var perfil_servicio = new Array ("...","AgregarInternet","Reinstalación","Activacion","AgregarTelevision","Recuperación cable modem","Migracion","Veeduria","Bajar_megas","Cambio de equipo","Cambio de clave","Corte Combo","Corte Internet","Corte Television","Equipo adicional","Instalacion","Punto nuevo","Subir_megas","Traslado","Toma Adicional");
	<?php }; ?>
	var perfil_reclamo = new Array ("...","Revision_de_Internet","Revision_de_television","Revision tv e internet");	
							//crear funcion que ejecute el cambio
							function cambia(){
								var subject;
								subject = document.soporte.subject[document.soporte.subject.			selectedIndex].value;
								//se verifica la seleccion dada
								if(subject!=0){
									mis_opts=eval("perfil_"+subject);
									//definimos cuantas obciones hay
									num_opts=mis_opts.length;
									//marcamos obciones en el selector
									document.soporte.detalle.length = num_opts;
									//colocamos las obciones array
									mis_opts=mis_opts.sort();
									for(i=0; i<num_opts; i++){
										var text1=mis_opts[i];
										var ciclo=true;
										while(ciclo){
											text1=text1.replace("_"," ");
											if(text1.includes("_")==false){
												ciclo=false;
											}
											
										}
										
										
										
										document.soporte.detalle.options[i].value=mis_opts[i];
										document.soporte.detalle.options[i].text=text1;
									}
										}else{
											//resultado si no hay obciones
											document.soporte.detalle.length = 1;
											document.soporte.detalle.options[0].value="-"
											document.soporte.detalle.options[0].text="-"											
								}
								document.soporte.detalle.options[0].selected = true;
							}
	
	$(document).ready(function(){
		ocultar();
		$('#detalle').on('change',function(){
			ocultar();
		});
	});
	
	function ocultar(){
			var selectValor = '#'+$("#detalle option:selected").val();
			$('#ocultar').children('div').hide();
			if($("#detalle option:selected").val()=="Activacion"){
                    $('#ocultar').children('#Instalacion').show();
					$(".select_sedex").val("0");
            }else{
			$('#ocultar').children(selectValor).show();
			$(".select_sedex").val("0");
			}
	}
	//traer barrio			
$(document).ready(function(){
	$("#cmbLocalidades").change(function(){
		$("#cmbLocalidades option:selected").each(function(){
			idLocalidad = $(this).val();
			//console.log(idDepartamento);
			$.post(baseurl+"customers/barrios_list",{'idLocalidad': idLocalidad
				},function(data){
				//console.log(data);
					$("#cmbBarrios").html(data);
			})
		})
	})
})

</script>
