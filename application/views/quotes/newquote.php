
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
                                        <?php echo $details['name'].' '.$details['unoapellido'] ?>
                                    </div>
                                    <div class="clientinfo">
                                        Documento: <?php echo $details['documento'] ?>
                                    </div>
                                    <div class="clientinfo">
                                        Celular: <?php echo $details['celular'] ?>
                                    </div>
									<div class="clientinfo">
                                        Direccion: <?php echo $details['nomenclatura'] ?> <?php echo $details['numero1'] ?><?php echo $details['adicionauno'] ?> N <?php echo $details['numero2'] ?> <?php echo $details['adicional2'] ?> - <?php echo $details['numero3'] ?>
                                    </div>
                                    <hr>                                    
                                </div>


                            </div>
                        </div>
                        <div class="col-sm-6 cmp-pnl">
                            <div class="inner-cmp-pnl">


                                <div class="form-group row">
									<input type="hidden" class="form-control"  name="ticketnumero"
                                                   value="<?php echo $lastquote+1 ?>"></input>
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
                                            	<select name="subject" class="form-control" onchange="cambia()" >
													<option value="no">seleccione...</option>
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
                                            <select class=" col-sm-2 form-control"  name="detalle" id="detalle">
													<option value="-">-</option>
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
                                                   data-toggle="datepicker"
                                                   autocomplete="false" readonly>
                                        </div>
                                    </div>
									<div class="col-sm-6">
										<label for="invociedate" class="caption">Factura mes</label>
										<div class="input-group">
										<select name="factura" id="tecnicos" class="form-control mb-1">
												<option value='null'>-</option>
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
                                                   autocomplete="false" >
											
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
												<option value=""></option>
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
												<input type="text" placeholder="Numero"class="form-control margin-bottom" name="numero1">
                                		</div>
									</div>
									<div class="col-sm-2" style="margin-left: -14px;">
                                        <div class="input-group">
                                             <select class="form-control mb-1" name="adicional1">
													<option value=""></option>
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
												<input type="text" placeholder="Numero"class="form-control margin-bottom" name="numero2">
                                		</div>
									</div>
									<div class="col-sm-2" style="margin-left: -14px;">
                                        <div class="input-group">
                                             <select class="form-control mb-1" name="adicional2">
													<option value=""></option>
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
												<input type="text" placeholder="Numero"class="form-control margin-bottom" name="numero3">
                                		</div>
									</div>
									<div class="col-sm-6">
									<label for="invociedate" class="caption">Localidad</label>
										<div class="input-group">
											
											<select name="localidad" class="form-control mb-1" onChange="cambia5()">
												<?php if ($details['ciudad']==='Yopal'){ ?>
												<option value='-'>-</option>
												<option value='ComunaI'>ComunaI</option>
												<option value='ComunaII'>ComunaII</option>
												<option value='ComunaIII'>ComunaIII</option>
												<option value='ComunaIV'>ComunaIV</option>
												<option value='ComunaV'>ComunaV</option>
												<option value='ComunaVI'>ComunaVI</option>
											<?php }if ($details['ciudad']==='Monterrey'){ ?>
												<option value='-'>-</option>
												<option value='Ninguno'>Ninguno</option>
											<?php }if ($details['ciudad']==='Villanueva'){ ?>
												<option value='-'>-</option>
												<option value='SinLocalidad'>Sin localidad</option>
											<?php }if ($details['ciudad']==='Mocoa'){ ?>
												<option value='-'>-</option>
												<option value='Ninguna'>Ninguna</option>
												<?php } ?>
											</select>
											
										</div>
                                   </div>
									<div class="col-sm-6">
									<label for="invociedate" class="caption">Barrio</label>
										<div class="input-group">									
											<select name="barrio" class="form-control mb-1">
												<option value="-">-</option>
											</select>
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
												<option value="no">No</option>
                                        		<option value="Television">Si</option>
											</select>
										</div>
                                   </div>
									<div class="col-sm-4">
									<label for="invociedate" class="caption">Internet</label>
										<div class="input-group">									
											<select name="inter" class="form-control mb-1">
												<?php if ($details['ciudad']==='Yopal' || $details['ciudad']==='Monterrey' ){ ?>
												<option value="no">No</option>
												<option value="1Mega">1Mega</option>
												<option value="2Megas">2Megas</option>
												<option value="3Megas">3Megas</option>
												<option value="3MegasSolo">3Megas Solo</option>
												<option value="5Megas">5Megas</option>
												<option value="5MegasD">5Megas Dedicado</option>
												<option value="5MegasSolo">5Megas Solo</option>
												<option value="10Megas">10Megas</option>
												<option value="10MegasSolo">10Megas Solo</option>
												<option value="50Megas">50Megas</option>
												<?php }if ($details['ciudad']==='Villanueva'){ ?>
												<option value="no">No</option>	
												<option value="2MegasV">2Megas</option>
												<option value="3MegasV">3Megas</option>
												<option value="5MegasV">5Megas</option>
												<option value="5MegasVD">5Megas Dedicado</option>
												<option value="5MegasVS">5Megas Solo</option>
												<option value="10MegasV">10Megas</option>
												<option value="10MegasVS">10Megas Solo</option>
												<option value="50MegasV">50Megas</option>
												<?php } ?>
											</select>
										</div>
                                   </div>
									<div class="col-sm-4">
									<label for="invociedate" class="caption">Puntos</label>
										<div class="input-group">									
											<select name="punto" class="form-control mb-1">
												<option value="0">no</option>
													<?php for ($i=1;$i<=20;$i++){
													echo '<option value="'.$i.'">'.$i.'</option>';}?>
											</select>
										</div>
                                   </div>
								</div>
                              </div>
							</div>
                        

                    </div>

                    <div class="form-group row">
                        <div class="col-sm-12">
                            <label for="toAddInfo" class="caption">Descripcion de Orden</label>
                            <textarea class="summernote" name="section" id="contents" rows="2"></textarea></div>
                    </div>
                   
					<input type="submit" class="btn btn-success sub-btn" value="Update Quote" id="submit-data" data-loading-text="Updating...">
						
                    <input type="hidden" value="quote/action" id="action-url">
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
	var perfil_servicio = new Array ("Seleccine...","Instalacion","Reinstalacion","Traslado","Subir 5 Mg","Subir 10 Mg","Bajar 5 Mg","Bajar 3 Mg","Cambio de equipo","Equipo adicional","Reconexion Combo","Reconexion Internet","Reconexion Television","Suspencion Combo","Suspencion Internet","Suspencion Television","Corte Combo","Corte Internet","Corte Television","Toma Adicional","Punto nuevo");
	var perfil_reclamo = new Array ("Seleccine...","Revision de Internet","Revision de television","Otros");	
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
									for(i=0; i<num_opts; i++){
										document.soporte.detalle.options[i].value=mis_opts[i];
										document.soporte.detalle.options[i].text=mis_opts[i];
									}
										}else{
											//resultado si no hay obciones
											document.soporte.detalle.length = 1;
											document.soporte.detalle.options[0].value="-"
											document.soporte.detalle.options[0].text="-"											
								}
								document.soporte.detalle.options[0].selected = true;
							}
	var barrio_ComunaI = new Array ("-","Bello horizonte","Brisas del Cravo","El Batallon","El Centro","El Libertador","La Corocora","La Estrella bon Habitad","la Pradera","Luis Hernandez Vargas","San Martin","La Arboleda");
	var barrio_ComunaII = new Array ("-","El Triunfo","Comfacasanare","Conjunto Residencial Comfaboy","El Bicentenario","El Remanso","Juan Pablo","La Floresta","Los Andes","Los Helechos","Los Heroes","Maria Milena","Puerta Amarilla","Valle de los guarataros","Villa Benilda","Barcelona","Ciudad Jardín","Juan Hernando Urrego","Unión San Carlos","Laureles","Villa Natalia");
	var barrio_ComunaIII = new Array ("-","20 De Julio","Aerocivil","El Gavan","El Oasis","El Recuerdo","La Amistad","Maria Paz","Mastranto II","Provivienda");
	var barrio_ComunaIV = new Array ("-","1ro de Mayo","Araguaney","Vencedores","Casiquiare","El Bosque","La Campiña","La Esperanza","Las Palmeras","Paraíso","Villa Rocío");
	var barrio_ComunaV = new Array ("-","Ciudad del Carmen","Ciudadela San Jorge","El Laguito","El Nogal","El Portal","El Progreso","La Primavera","Los Almendros","Maranatha","Montecarlo","Nuevo Hábitat","Nuevo Hábitat II","Nuevo Milenio","San Mateo","Villa Nelly","Villa Vargas","Villas de Chavinave");
	var barrio_ComunaVI = new Array ("-","Villa Lucia","Villa Salomé 1","Xiruma","Llano Vargas","Bosques de Sirivana","Bosques de Guarataros","Villa David","Getsemaní","Villa Salomé 2","Las americas","Puente Raudal","Camoruco");
	var barrio_Ninguno = new Array ("-","Palmeras","Pradera","Esperanza","Villa del prado","Primavera","Nuevo milenio","San jose","Centro","Panorama","Alfonso lopez","Rivera de san andres","Rosales","Nuevo horizonte","La roca","Paomera","Floresta","Alcaravanes","Morichito","Villa santiago","15 de octubre","Glorieta","Olimpico","Brisas del tua","Guaira","Esteros","Villa del bosque","Villa mariana","Guadalupe","Leche miel","Lanceros","Paraiso","El caney","Villa daniela","Julia luz","Los esteros");
	var barrio_SinLocalidad = new Array ("-","Banquetas","Bella Vista","Bello Horizonte","Brisas del Agua Clara","Brisas del Upia I","Brisas del Upia II","Buenos Aires","Caricare","Centro","Ciudadela la Virgen","Comuneros","El Bosque","El Morichal","El Morichalito","El Portal","Fundadores","La floresta","Las Vegas","Mirador","Palmeras","Panorama","Paraiso I","Paraiso II","Progreso","Quintas del Camino Real","Villa Alejandra","Villa Campestre","Villa Estampa","Villa Luz","Villa del Palmar","Villa Mariana","Villa de los angeles");
	var barrio_Ninguna = new Array ("-","Venecia","Villa Caimaron","Villa Colombia","Villa Daniela","Villa del Norte","Villa del rio","Villa Diana","Villa Natalia","Villa Nueva","Palermo","Paraiso","Peñan","Pinos","Piñayaco","Placer","Plaza de Mercado","Prados","Progreso","Rumipamba","San Andres","San Agustin","San Fernando","San Francisco","La Loma","La union","Las Vegas","Libertador","Loma","Los Angeles","Miraflores","Modelo","Naranjito","Nueva Floresta","Obrero 1","Obrero 2","Olimpico","Pablo VI","Pablo VI bajo");
							//crear funcion que ejecute el cambio
							function cambia5(){
								var localidad;
								localidad = document.soporte.localidad[document.soporte.localidad.			selectedIndex].value;
								//se verifica la seleccion dada
								if(localidad!=0){
									mis_opts=eval("barrio_"+localidad);
									//definimos cuantas obciones hay
									num_opts=mis_opts.length;
									//marcamos obciones en el selector
									document.soporte.barrio.length = num_opts;
									//colocamos las obciones array
									for(i=0; i<num_opts; i++){
										document.soporte.barrio.options[i].value=mis_opts[i];
										document.soporte.barrio.options[i].text=mis_opts[i];
									}
										}else{
											//resultado si no hay obciones
											document.soporte.barrio.length = 1;
											document.soporte.barrio.options[0].value="-"
											document.soporte.barrio.options[0].text="-"											
								}
								document.soporte.barrio.options[0].selected = true;
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
			$('#ocultar').children(selectValor).show();
	}

</script>
