<article class="content">
    <div class="card card-block">
        <div id="notify" class="alert alert-success" style="display:none;">
            <a href="#" class="close" data-dismiss="alert">&times;</a>

            <div class="message"></div>
        </div>
        <form method="post" id="data_form" class="form-horizontal">
            <div class="row">

                <h5><?php echo $this->lang->line('Edit Customer Details') ?></h5>
                <hr>
                <div class="col-md-6">
                    <h5><?php echo $this->lang->line('') ?>DATOS PERSONALES</h5>
                    <input type="hidden" name="id" value="<?php echo $customer['id'] ?>" id="customer_id">
					<hr>

                    <div class="form-group row">

                        <h6><label class="col-sm-3 col-form-label"
                               for="name"><?php echo $this->lang->line('') ?>1er Nombre</label></h6> 

                        <div class="col-sm-3">
                            <h6><label class="col-form-label"
                               for="apellidos"><?php echo $this->lang->line('') ?>2do Nombre</label></h6>
                        </div>
                        <div class="col-sm-3">
                            <h6><label class="col-form-label"
                               for="apellidos"><?php echo $this->lang->line('') ?>1er Apellido</label></h6>
                        </div>
                        <div class="col-sm-3">
                            <h6><label class="col-form-label"
                               for="apellidos"><?php echo $this->lang->line('') ?>2do Apellido</label></h6>
                        </div>
                        

                        <div class="col-sm-3">
                            <input type="text"
                                   class="form-control margin-bottom  required" name="name" value="<?php echo $customer['name'] ?>" id="mcustomer_name">
                        </div>
                        <div class="col-sm-3">
                            <input type="text" class="form-control margin-bottom" name="dosnombre" value="<?php echo $customer['dosnombre'] ?>"id="mcustomer_apellidos">
                        </div>
                        <div class="col-sm-3">
                            <input type="text" class="form-control margin-bottom  required" name="unoapellido" value="<?php echo $customer['unoapellido'] ?>" id="mcustomer_unoapellido">
                        </div>
                        <div class="col-sm-3">
                            <input type="text" class="form-control margin-bottom  required" name="dosapellido" value="<?php echo $customer['dosapellido'] ?>"id="mcustomer_apellidos">
                        </div>
                    </div>
                    <div class="form-group row">

                        <h6><label class="col-sm-6 col-form-label"
                               for="Company"><?php echo $this->lang->line('Company') ?></label></h6>

                        <div class="col-sm-6">
                            <h6><label class="col-sm-2 col-form-label"
                               for="celular"><?php echo $this->lang->line('') ?>Celular</label></h6>
                        </div>
                    
                    <div class="col-sm-6">
							<input type="text" placeholder="Compañia"
                                   class="form-control margin-bottom" name="company" value="<?php echo $customer['company'] ?>" id="mcustomer_address1">
                        
							</div>
                        <div class="col-sm-6">
                            <input type="text" placeholder="Numero"
                                   class="form-control margin-bottom required" name="celular" value="<?php echo $customer['celular'] ?>" id="mcustomer_phone">
                        </div>
                    </div>
                    <div class="form-group row">

                        <h6><label class="col-sm-6 col-form-label" for="celular2">Celular (adi)</label></h6>

                        <div class="col-sm-6">
                            <h6><label class="col-sm-2 col-form-label"
                               for="email"><?php echo $this->lang->line('') ?>Correo</label></h6>
                        </div>                    
                        <div class="col-sm-6">
                            <input type="text" placeholder="Numero adicional"
                                   class="form-control margin-bottom" name="celular2" value="<?php echo $customer['celular2'] ?>" id="mcustomer_city">
                        </div>
                        <div class="col-sm-6">
                        <input type="text" placeholder="email"
                                   class="form-control margin-bottom required" name="email" value="<?php echo $customer['email'] ?>" id="mcustomer_email">
                        </div>
                    </div>
                    <div class="form-group row">

                        <h6><label class="col-sm-4 col-form-label"
                               for="nacimiento"><?php echo $this->lang->line('') ?>Feha de nacimiento</label></h6>

                        <div class="col-sm-2">
                            <h6><label class="col-form-label"
                               for="tipo_cliente"><?php echo $this->lang->line('') ?>Tipo clte</label></h6>
                        </div>
                        <div class="col-sm-2">
                            <h6><label class="col-form-label"
                               for="tipo_documento"><?php echo $this->lang->line('') ?>Tipo Dto</label></h6>
                        </div>
                        <div class="col-sm-4">
                            <h6><label class="col-form-label"
                               for="documento"><?php echo $this->lang->line('') ?>Nº Documento</label></h6>
                        </div>
                    
                    	<div class="col-sm-4">
						<input type="text" class="form-control required"
                                                   placeholder="Billing Date" name="nacimiento"
                                                   data-toggle="datepicker"
                                                   autocomplete="false" value="<?php echo $customer['nacimiento'] ?>" >
                        
						</div>
                        <div class="col-sm-2">
                            <select class="form-control"  id="discountFormat" name="tipo_cliente">
                            						<option value="<?php echo $customer['tipo_cliente'] ?>"><?php echo $customer['tipo_cliente'] ?></option>
													<option value="Natural">Natural</option>
                                                	<option value="Juridico">Juridico</option>
                                                  	<option value="Gubernamental">Gubernamental</option>
                                                	<option value="Militar">Militar</option>
                                            </select>
                        </div>
                        <div class="col-sm-2">
                            <select class="form-control"  id="mcustomer_country" name="tipo_documento">
                            						<option value="<?php echo $customer['tipo_documento'] ?>"><?php echo $customer['tipo_documento'] ?></option>
													<option value="CC">CC</option>
                                                	<option value="CE">CE</option>
                                                  	<option value="NIT">NIT</option>
                                                	<option value="PAS">PAS</option>
                                            </select>
                        </div>
                        <div class="col-sm-4">
                            <input type="text" placeholder="Numero de documento"
                                   class="form-control margin-bottom" name="documento" value="<?php echo $customer['documento'] ?>" id="mcustomer_documento">
                        </div>
                    </div>
                    <hr>
                    <h5><?php echo $this->lang->line('') ?>DATOS DE RESIDENCIA</h5>
                    <hr>
                    <div class="form-group row">
						
						
						<div class="col-sm-6">
							 <h6><label class="col-sm-6 col-form-label"
								   for="departamento"><?php echo $this->lang->line('') ?>Departamento</label></h6>
						
							<?php echo $this->lang->line('departamentos') ?> 
							<select id="departamentos"	class="selectpicker form-control" name="departamento">                            	
								 <?php
								 echo '<option value="' . $departamentos['idDepartamento'] . '">' . $departamentos['departamento'] . '</option>';
								foreach ($departamentoslist as $row) {
									echo '<option value="' . $row['idDepartamento'] . '">' . $row['departamento'] . '</option>';
								}?>

							</select>
						
						</div> 

                        <div class="col-sm-6">
                            <h6><label class="col-sm-2 col-form-label"
                               for="ciudad"><?php echo $this->lang->line('') ?>Ciudad</label></h6>
						    <div id="ciudades">
								<select id="cmbCiudades" class="selectpicker form-control" name="ciudad">
                                <option value="<?php echo $ciudad['idCiudad'] ?>"><?php echo $ciudad['ciudad'] ?></option>
                                <option value="1">Seleccionar</option>
                                </select>
							</div>
							   
                        </div>
                      
                       
                    </div>
                    <div class="form-group row"> 
					
						<div class="col-sm-6">
                            <h6><label class="col-sm-2 col-form-label"
                               for="localidad"><?php echo $this->lang->line('') ?>Localidad</label></h6>
						    <div id="localidades">
								<select id="cmbLocalidades"  class="selectpicker form-control" name="localidad">
                                <option value="<?php echo $localidad['idLocalidad'] ?>"><?php echo $localidad['localidad'] ?></option>
                                </select>
							</div>
							   
                        </div>
						
						<div class="col-sm-6">
                            <h6><label class="col-sm-2 col-form-label"
                               for="barrio"><?php echo $this->lang->line('') ?>Barrio</label></h6>
						    <div id="barrios">
								<select id="cmbBarrios" class="selectpicker form-control" name="barrio">
                                <option value="<?php echo $barrio['idBarrio'] ?>"><?php echo $barrio['barrio'] ?></option>
                                </select>
							</div>
							   
                        </div>
                    	 
                    </div>
                    <div class="form-group row">

                        <h6><label class="col-sm-12 col-form-label"
                               for="city"><?php echo $this->lang->line('') ?>Direccion</label></h6>

                        
                    
                    	<div class="col-sm-2">
						<select class="form-control"  id="discountFormat" name="nomenclatura">
                        							<option value="<?php echo $customer['nomenclatura'] ?>"><?php echo $customer['nomenclatura'] ?></option>
													<option value="Calle">Calle</option>
                                                	<option value="Carrera">Carrera</option>
                                                  	<option value="Diagonal">Diagonal</option>
                                                	<option value="Transversal">Transversal</option>
                                            </select>
                        
						</div>
                        <div class="col-sm-2">
                            <input type="text" placeholder="Numero"
                                   class="form-control margin-bottom" name="numero1" value="<?php echo $customer['numero1'] ?>">
                        </div>
                        <div class="col-sm-2">
                            <select class="form-control" name="adicionauno">
													<option value="<?php echo $customer['adicionauno'] ?>"><?php echo $customer['adicionauno'] ?></option>
                                                    <option value="bis">bis</option>
                                                	<option value="a">a</option>
                                                  	<option value="b">b</option>
                                                	<option value="c">c</option>
                                                    <option value="d">d</option>
                                                    <option value="e">e</option>
                                                    <option value="a bis">a bis</option>
                                                    <option value="b bis">b bis</option>
                                                    <option value="c bis">c bis</option>
                                                    <option value="d bis">d bis</option>
                                            </select>
                        </div>
                        <div class="col-sm-1">
                            <label class="col-form-label" for="Nº">Nº</label>
                        </div>
                        <div class="col-sm-2">
                            <input type="text" placeholder="Numero"
                                   class="form-control margin-bottom" name="numero2" value="<?php echo $customer['numero2'] ?>" >
                        </div>
                        <div class="col-sm-1">
                            <select class="col-sm-1 form-control" name="adicional2">
													<option value="<?php echo $customer['adicional2'] ?>"><?php echo $customer['adicional2'] ?></option>
                                                    <option value="bis">bis</option>
                                                	<option value="a">a</option>
                                                  	<option value="b">b</option>
                                                	<option value="c">c</option>
                                                    <option value="d">d</option>
                                                    <option value="e">e</option>
                                                    <option value="a bis">a bis</option>
                                                    <option value="b bis">b bis</option>
                                                    <option value="c bis">c bis</option>
                                                    <option value="d bis">d bis</option>
                                            </select>
                        </div>
                        <div class="col-sm-2">
                            <input type="text" placeholder="Numero"
                                   class="form-control margin-bottom" name="numero3" value="<?php echo $customer['numero3'] ?>" id="numero3">
                        </div>
                    </div>
                    <div class="form-group row">

                        <h6><label class="col-sm-6 col-form-label"
                               for="postbox"><?php echo $this->lang->line('') ?>Residencia</label></h6>

                        <div class="col-sm-6">
                            
                            <h6><label class="col-sm-2 col-form-label"
                               for="postbox"><?php echo $this->lang->line('') ?>Referencia</label></h6>
                        </div>
                    
                    	<div class="col-sm-6">
                        	<select class="form-control"  id="discountFormat" name="residencia">
                            						<option value="<?php echo $customer['residencia'] ?>"><?php echo $customer['residencia'] ?></option>
													<option value="Casa">Casa</option>
                                                	<option value="Apartamento">Apartamento</option>
                                                  	<option value="Edificio">Edificio</option>
                                                	<option value="Oficina">Oficina</option>
                                            </select>
						</div>
                        <div class="col-sm-6">
                            <input type="text" placeholder="detalles de residencia"
                                   class="form-control margin-bottom" name="referencia" value="<?php echo $customer['referencia'] ?>">
                        </div>
                    </div>
                    

                </div>
                

                <!--ship-->

                <div class="col-md-6">
                    <h5><?php echo $this->lang->line('') ?>DATOS DE INTEGRACION</h5>
                    <div class="form-group row">
					<hr>
                        <div class="input-group">
                            <label class="display-inline-block custom-control custom-radio ml-1">
                                <input type="checkbox" name="customer1" class="custom-control-input" id="copy_address">
                                <span class="custom-control-indicator"></span>
                                <span class="custom-control-description ml-0"><?php echo $this->lang->line('') ?>Integrar al sistema</span>
                            </label>

                        </div>

                        <div class="col-sm-10">
                            <?php echo $this->lang->line("") ?>Ingrese los datos para integrar USUARIO con el SISTEMA
                        </div>
                    </div>
                    <div class="form-group row">

                        <h6><label class="col-sm-10 col-form-label"
                               for="customergroup"><?php echo $this->lang->line('') ?>Mikrotik</label></h6>

                        <div class="col-sm-12">
                            <select name="customergroup" class="form-control" onchange="cambia()" >
                            	
                                <?php
								echo '<option value="' . $customergroup['id'] . '">' . $customergroup['title'] . '</option>';
                                foreach ($customergrouplist as $row) {
                                    $cid = $row['id'];
                                    $title = $row['title'];
                                    echo "<option value='$cid'>$title</option>";
                                }
                                ?>
                            </select>


                        </div>
                    </div>

                    <div class="form-group row">

                        <h6><label class="col-sm-10 col-form-label"
                               for="name_s"><?php echo $this->lang->line('Name') ?></label><h6>
						
                        <div class="col-sm-12">
                            <input type="text" placeholder="Name"
                                   class="form-control margin-bottom" name="name_s" value="<?php echo $customer['name_s'] ?>" id="mcustomer_name_s">
                        </div>
                    </div>


                    <div class="form-group row">

                        <h6><label class="col-sm-6 col-form-label"
                               for="phone_s"><?php echo $this->lang->line('') ?>Contraseña</label></h6>

                        <div class="col-sm-6">
                             <h6><label class="col-sm-2 col-form-label" for="email_s">Servicio</label></h6>
                        </div>                    
                    	<div class="col-sm-6">                       
                        <input type="text" placeholder="phone"
                                   class="form-control margin-bottom" name="contra" value="<?php echo $customer['contra'] ?>" id="mcustomer_documento_s">
						</div>
                        <div class="col-sm-6">
                            <select class=" col-sm-2 form-control"  id="discountFormat" name="servicio">
                            						<option value="<?php echo $customer['servicio'] ?>"><?php echo $customer['servicio'] ?></option>
													<option value="pppoe">pppoe</option>
                                                    <option value="pptp">pptp</option>
                                                	
                                            </select>
                        </div>
                    </div>
                    <div class="form-group row">

                        <h6><label class="col-sm-6 col-form-label"
                               for="address"><?php echo $this->lang->line('') ?>Perfil</label></h6>

                        <div class="col-sm-6">
                            
                            <h6><label class="col-sm-6 col-form-label"
                               for="city_s"><?php echo $this->lang->line('') ?>Ip local</label></h6>
                        </div>
                    
                   		 <div class="col-sm-6">
							<select class=" col-sm-2 form-control"  id="discountFormat" name="perfil" onchange="cambia2()">
													<option value="<?php echo $customer['perfil'] ?>"><?php echo $customer['perfil'] ?></option>
                                            </select>                       
						</div>
                        <div class="col-sm-6">
                            <select class=" col-sm-2 form-control"  id="discountFormat" name="Iplocal">
													<option value="<?php echo $customer['Iplocal'] ?>"><?php echo $customer['Iplocal'] ?></option>
                                            </select>
                        </div>
                    </div>
                    <div class="form-group row">

                        <h6><label class="col-sm-6 col-form-label"
                               for="region_s"><?php echo $this->lang->line('') ?>Ip remota</label></h6>

                        <div class="col-sm-6">                            
                            <h6><label class="col-sm-2 col-form-label"
                               for="country_s"><?php echo $this->lang->line('') ?>Comentario</label></h6>
                        </div>
                    
                    	<div class="col-sm-6">
							<input type="text" placeholder="Region"
                                   class="form-control margin-bottom" name="Ipremota" id="Ipremota" value="<?php echo $customer['Ipremota'] ?>">
                        </div>
                        <div class="col-sm-6">
                            <input type="text" placeholder="Barrio y codigo usuario"
                                   class="form-control margin-bottom" name="comentario" value="<?php echo $barrio['barrio'] ?>" id="mcustomer_comentario_s">
                        </div>
                    </div>


                </div>

            </div>
            <div class="form-group row">

                <label class="col-sm-2 col-form-label"></label>

                <div class="col-sm-4">
                    <input type="submit" id="submit-data" class="btn btn-success margin-bottom"
                           value="Actualizar" data-loading-text="Updating...">
                    <input type="hidden" value="customers/editcustomer" id="action-url">
                </div>
            </div>
        </form>
    </div>
</article>
<script type="text/javascript">
function ShowSelected()
{
/* Para obtener el valor */
var cod = document.getElementById("producto").value;
alert(cod);
 
/* Para obtener el texto */
var combo = document.getElementById("producto");
var selected = combo.options[combo.selectedIndex].text;
alert(selected);
}
</script>
<script type="text/javascript">	
	var perfil_2 = new Array ("Seleccine...","3Megas","5Megas","10Megas","MOROSOS");
	var perfil_3 = new Array ("Seleccine...","3MEGAS","5MEGAS","10MEGAS","MOROSOS");
	var perfil_4 = new Array ("Seleccine...","3Megas","5Megas","10Megas","Cortados");
							//crear funcion que ejecute el cambio
							function cambia(){
								var mikrotik;
								mikrotik = document.formulario1.mikrotik[document.formulario1.mikrotik.			selectedIndex].value;
								//se verifica la seleccion dada
								if(mikrotik!=0){
									mis_opts=eval("perfil_"+mikrotik);
									//definimos cuantas obciones hay
									num_opts=mis_opts.length;
									//marcamos obciones en el selector
									document.formulario1.perfil.length = num_opts;
									//colocamos las obciones array
									for(i=0; i<num_opts; i++){
										document.formulario1.perfil.options[i].value=mis_opts[i];
										document.formulario1.perfil.options[i].text=mis_opts[i];
									}
										}else{
											//resultado si no hay obciones
											document.formulario1.perfil.length = 1;
											document.formulario1.perfil.options[0].value="-"
											document.formulario1.perfil.options[0].text="-"											
								}
								document.formulario1.perfil.options[0].selected = true;
							}	
	var Iplocal_2 = new Array ("10.0.0.1");
	var Iplocal_3 = new Array ("80.0.0.1");
	var Iplocal_4 = new Array ("10.1.100.1");
							//crear funcion que ejecute el cambio
							function cambia2(){
								var mikrotik;
								mikrotik = document.formulario1.mikrotik[document.formulario1.mikrotik.			selectedIndex].value;
								//se verifica la seleccion dada
								if(mikrotik!=0){
									mis_opts=eval("Iplocal_"+mikrotik);
									//definimos cuantas obciones hay
									num_opts=mis_opts.length;
									//marcamos obciones en el selector
									document.formulario1.Iplocal.length = num_opts;
									//colocamos las obciones array
									for(i=0; i<num_opts; i++){
										document.formulario1.Iplocal.options[i].value=mis_opts[i];
										document.formulario1.Iplocal.options[i].text=mis_opts[i];
									}
										}else{
											//resultado si no hay obciones
											document.formulario1.Iplocal.length = 1;
											document.formulario1.Iplocal.options[0].value="-"
											document.formulario1.Iplocal.options[0].text="-"											
								}
								document.formulario1.Iplocal.options[0].selected = true;
							}		
				
			$("#departamentos").change(function(){
 
				if($(this).val()!=""){
					 
					var dato=$(this).val(); 
					$.ajax({
						type:"POST",
						dataType:"html",
						url:"ciudades_list",
						data:"idDepartamento="+dato+" ",
						success:function(msg){ 
							$('#cmbCiudades').html('<option>Seleccionar</option>'+ msg); 
						}
					});
				}else{
					//$("#dependencia").empty().attr("disabled","disabled");
					//$("#departamento").empty().attr("disabled","disabled");
				}
			});
			
			$("#cmbCiudades").change(function(){ 
				 
				if($(this).val()!=""){
					 
					var dato=$(this).val(); 
				 
					
					$.ajax({
						type:"POST",
						dataType:"html",
						url:"localidades_list",
						data:"idCiudad="+dato+" ",
						success:function(msg){   
							$('#cmbLocalidades').html('<option>Seleccionar</option>'+msg); 
						}
					});
				}else{
					//$("#dependencia").empty().attr("disabled","disabled");
					//$("#departamento").empty().attr("disabled","disabled");
				}
			});
			
			$("#cmbLocalidades").change(function(){ 
 
				if($(this).val()!=""){
					 
					var dato=$(this).val();  
					
					$.ajax({
						type:"POST",
						dataType:"html",
						url:"barrios_list",
						data:"idLocalidad="+dato+" ",
						success:function(msg){  
							$('#cmbBarrios').html('<option>Seleccionar</option>'+msg); 
						}
					});
				}else{
					//$("#dependencia").empty().attr("disabled","disabled");
					//$("#departamento").empty().attr("disabled","disabled");
				}
			});
			
			
		
		</script>
