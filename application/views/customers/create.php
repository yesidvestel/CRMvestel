<article class="content">
    <div class="card card-block">
        <div id="notify" class="alert alert-success" style="display:none;">
            <a href="#" class="close" data-dismiss="alert">&times;</a>

            <div class="message"></div>
        </div>
        <form method="post" id="data_form" class="form-horizontal" name="formulario1">
            <div class="row">

                <h5><?php echo $this->lang->line('') ?> AÑADIR NUEVO USUARIO</h5>
                <hr>
                <div class="col-md-6">
                    <h5><?php echo $this->lang->line('') ?>Datos personales</h5>
                    <hr>
                    <div class="form-group row">
						<input type="text" placeholder="Material nombre" class="form-control margin-bottom  required" name="abonado" value="<?php echo $codigo + 1 ?>">
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
                                   class="form-control margin-bottom  required" name="name" id="mcustomer_name">
                        </div>
                        <div class="col-sm-3">
                            <input type="text"
                                   class="form-control margin-bottom" name="dosnombre" id="mcustomer_dosnombre">
                        </div>
                        <div class="col-sm-3">
                            <input type="text"
                                   class="form-control margin-bottom  required" name="unoapellido" id="mcustomer_unoapellido">
                        </div>
                        <div class="col-sm-3">
                            <input type="text"
                                   class="form-control margin-bottom" name="dosapellido" id="mcustomer_dosapellido">
                        </div>
                    </div>
                    <div class="form-group row">

                        <h6><label class="col-sm-6 col-form-label"
                               for="address"><?php echo $this->lang->line('Company') ?></label></h6>

                        <div class="col-sm-6">
                            <h6><label class="col-sm-2 col-form-label"
                               for="phone"><?php echo $this->lang->line('') ?>Celular</label></h6>
                        </div>
                    
                    <div class="col-sm-6">
							<input type="text" placeholder="Compañia"
                                   class="form-control margin-bottom" name="company" id="mcustomer_address1">
                        
							</div>
                        <div class="col-sm-6">
                            <input type="text" placeholder="Numero"
                                   class="form-control margin-bottom required" name="celular" id="mcustomer_phone">
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
                                   class="form-control margin-bottom" name="celular2" id="mcustomer_city">
                        </div>
                        <div class="col-sm-6">
                        <input type="text" placeholder="email"
                                   class="form-control margin-bottom required" name="email" id="mcustomer_email">
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
                                                   autocomplete="false">
                        
						</div>
                        <div class="col-sm-2">
                            <select class="form-control"  id="discountFormat" name="tipo_cliente">
													<option value="Natural">Natural</option>
                                                	<option value="Juridico">Juridico</option>
                                                  	<option value="Gubernamental">Gubernamental</option>
                                                	<option value="Militar">Militar</option>
                                            </select>
                        </div>
                        <div class="col-sm-2">
                            <select class="form-control"  id="mcustomer_country" name="tipo_documento">
													<option value="CC">CC</option>
                                                	<option value="CE">CE</option>
                                                  	<option value="NIT">NIT</option>
                                                	<option value="PAS">PAS</option>
                                            </select>
                        </div>
                        <div class="col-sm-4">
                            <input type="text" placeholder="Numero de documento"
                                   class="form-control margin-bottom" name="documento" id="mcustomer_documento">
                        </div>
                    </div>
					<div class="form-group row">
						<h6><label class="col-sm-12 col-form-label"><?php echo $this->lang->line('') ?>Estrato</label></h6>
					
						<div class="col-sm-4 ">
                            <select name="estrato" class="form-control" >
								<option value="Estrato 1">Estrato 1</option>
								<option value="Estrato 2">Estrato 2</option>
								<option value="Estrato 3">Estrato 3</option>
								<option value="Estrato 4">Estrato 4</option>
								<option value="Estrato 5">Estrato 5</option>
								<option value="Estrato 6">Estrato 6</option>
								<option value="Estrato 7">Estrato 7</option>
								<option value="Estrato 8">Estrato 8</option>
							</select>
                        </div>
					</div>
                    <hr class="col-sm-12">
                    <h5 class="col-sm-12"><?php echo $this->lang->line('') ?>Datos de residencia</h5>
                    <hr class="col-sm-12">
                    <div class="form-group row">
						
						
						<div class="col-sm-6">
							 <h6><label class="col-sm-6 col-form-label"
								   for="departamento"><?php echo $this->lang->line('') ?>Departamento</label></h6>
						
							<?php echo $this->lang->line('departamentos') ?> 
							<select id="departamentos"	class="selectpicker form-control" name="departamento" id="mcustomer_country" onchange="cambia3()">
								<option value="0">seleccione</option>
								<option value="Casanare">Casanare</option>
								<option value="Putumayo">Putumayo</option>
							</select>
						
						</div> 

                        <div class="col-sm-6">
                            <h6><label class="col-sm-2 col-form-label"
                               for="ciudad"><?php echo $this->lang->line('') ?>Ciudad</label></h6>
						    <div id="ciudades">
								<select id="cmbCiudades" class="selectpicker form-control" name="ciudad" onChange="cambia4()">                                
                                <option value="0">-</option>
                                </select>
							</div>
							   
                        </div>
                      
                       
                    </div>
                    <div class="form-group row"> 
					
						<div class="col-sm-6">
                            <h6><label class="col-sm-2 col-form-label"
                               for="localidad"><?php echo $this->lang->line('') ?>Localidad</label></h6>
						    <div id="localidades">
								<select id="cmbLocalidades"  class="selectpicker form-control" name="localidad" onChange="cambia5()">
                                <option value="0">-</option>
                                </select>
							</div>
							   
                        </div>
						
						<div class="col-sm-6">
                            <h6><label class="col-sm-2 col-form-label"
                               for="barrio"><?php echo $this->lang->line('') ?>Barrio</label></h6>
						    <div id="barrios">
								<select id="cmbBarrios" class="selectpicker form-control" name="barrio" >
                                <option value="0">-</option>
                                </select>
							</div>
							   
                        </div>
                    	 
                    </div>
                    <div class="form-group row">

                        <h6><label class="col-sm-12 col-form-label"
                               for="city"><?php echo $this->lang->line('') ?>Direccion</label></h6>

                        
                    
                    	<div class="col-sm-2">
						<select class="form-control"  id="discountFormat" name="nomenclatura">
													<option value="Calle">Calle</option>
                                                	<option value="Carrera">Carrera</option>
                                                  	<option value="Diagonal">Diagonal</option>
                                                	<option value="Transversal">Transversal</option>
													<option value="Manzana">Manzana</option>
                                            </select>
                        
						</div>
                        <div class="col-sm-2">
                            <input type="text" placeholder="Numero"
                                   class="form-control margin-bottom" name="numero1">
                        </div>
                        <div class="col-sm-2">
                            <select class="form-control" name="adicionauno">
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
                        <div class="col-sm-1" style="margin-left: -10px;">
                            <label class="col-form-label" for="Nº">Nº</label>
                        </div>
                        <div class="col-sm-2" style="margin-left: 14px;">
                            <input type="text" placeholder="Numero"
                                   class="form-control margin-bottom" name="numero2" style="margin-left: -20px;">
                        </div>
                        <div class="col-sm-2" style="margin-left: -30px;margin-right: -20px;">
                            <select class="col-sm-1 form-control" name="adicional2">
													<option value=""></option>
                                                    <option value="bis">bis</option>
													<option value="sur">sur</option>
                                                	<option value="a">a</option>
													<option value="a sur">a sur</option>
                                                  	<option value="b">b</option>
													<option value="b sur">b sur</option>
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
                        <div class="col-sm-2">
                            <input type="text" placeholder="Numero"
                                   class="form-control margin-bottom" name="numero3" id="numero3">
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
													<option value="Casa">Casa</option>
                                                	<option value="Apartamento">Apartamento</option>
                                                  	<option value="Edificio">Edificio</option>
                                                	<option value="Oficina">Oficina</option>
                                            </select>
						</div>
                        <div class="col-sm-6">
                            <input type="text" placeholder="detalles de residencia"
                                   class="form-control margin-bottom" name="referencia">
                        </div>
					</div>
						<div class="form-group row">

                        <h6><label class="col-sm-2 col-form-label"
                               for="customergroup"><?php echo $this->lang->line('') ?>Sede</label></h6>
						
                        <div class="col-sm-12">
                            <select id="id_sede" name="customergroup" class="form-control"  onchange="cambia()">
                                <?php

                                foreach ($customergrouplist as $row) {
                                    $cid = $row['id'];
                                    $title = $row['title'];
                                    echo "<option value='$cid'>$title</option>";
                                }
                                ?>
                            </select>
                        </div>
					</div>
                 </div> 
                <!--ship-->

                <div class="col-md-6">
                    <h5><?php echo $this->lang->line('') ?>Datos de Integracion</h5>
                    <div class="form-group row">
					<hr>
                        <div class="input-group">
                            <label class="display-inline-block custom-control custom-radio ml-1">
                                <input type="checkbox" name="customer1" class="custom-control-input" id="copy_address" >
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
                               for="name_s"><?php echo $this->lang->line('Name') ?></label><h6>
						
                        <div class="col-sm-12">
                            <input type="text" placeholder="Name"
                                   class="form-control margin-bottom" name="name_s" id="mcustomer_name_s" onblur="selecciona_para_agregar()" > 
                                   <span id="msg_error_username" style="color: red;visibility :hidden">Este Nombre de Usuario Ya Existe</span>
                        </div>
                    </div>


                    <div class="form-group row">

                        <h6><label class="col-sm-6 col-form-label"
                               for="phone_s"><?php echo $this->lang->line('') ?>Contraseña</label></h6>

                        <div class="col-sm-6">
                             <h6><label class="col-sm-2 col-form-label" for="email_s">Servicio</label></h6>
                        </div>                    
                    	<div class="col-sm-6">                       
                        <input type="text" 
                                   class="form-control margin-bottom" name="contra" id="mcustomer_documento_s" onkeyup="selecciona_para_agregar()">
						</div>
                        <div class="col-sm-6">
                            <select class=" col-sm-2 form-control"  id="discountFormatServicio" name="servicio">
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
							<select class=" col-sm-2 form-control"  id="discountFormatPerfil" name="perfil" onchange="cambia2()">
													<option value="-">-</option>
                                            </select>                       
						</div>
                        <div class="col-sm-6">
                            <select class=" col-sm-2 form-control"  id="discountFormatIpLocal" name="Iplocal">
													<option value="-">-</option>
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
							<input disabled="disabled" type="text" placeholder="Ip remota"
                                   class="form-control margin-bottom" name="Ipremota" id="Ipremota" value="" onkeyup="selecciona_para_agregar()">
                                   <input style="display: none;" type="text" placeholder="Region"
                                   class="form-control margin-bottom" name="Ipremota2" id="Ipremota2" value="">
                        </div>
                        <div class="col-sm-6">
                            <input type="text" placeholder="Barrio y codigo usuario"
                                   class="form-control margin-bottom" name="comentario" id="mcustomer_comentario_s" onkeyup="selecciona_para_agregar()">
                        </div>
                    </div>
                    

                    


                </div>
            </div>
            <div class="form-group row">

                <label class="col-sm-5 col-form-label"></label>

                <div class="col-sm-4">
                    <input type="submit" id="submit-data" class="btn btn-success margin-bottom"
                           value="<?php echo $this->lang->line('Add customer') ?>" data-loading-text="Adding...">
                    <input type="hidden" value="customers/addcustomer" id="action-url">
                    <!--<a class="btn btn-success" href="<?=base_url()?>customers/conectar_microtik"  >Conectar</a>-->
                </div>
            </div>


    </div>
    </form>
    </div>
</article>
<script type="text/javascript">
    var remote_ip_yopal="<?=$ips_remotas['yopal']?>";
    var remote_ip_villanueva="<?=$ips_remotas['villanueva']?>";
    var remote_ip_monterrey="<?=$ips_remotas['monterrey']?>";
    function selecciona_para_agregar(){
        var elemento=document.getElementById("copy_address");
        //console.log($("#discountFormatServicio").val());
        if(elemento.checked==true){
            var desabilitar=false;
            //console.log($("#mcustomer_name_s").val());
            validar_user_name();
            if($("#mcustomer_name_s").val()=="" || $("#mcustomer_documento_s").val()=="" || $("#discountFormatPerfil").val()=="-" || $("#discountFormatPerfil").val()=="Seleccine..." || $("#discountFormatIpLocal").val()=="-" || $("#Ipremota").val()=="" || $("#mcustomer_comentario_s").val()==""){
                desabilitar=true;
            }
           
            
            if(desabilitar){
                $("#submit-data").attr("disabled", true);    
            }else{
                $("#submit-data").removeAttr("disabled");    
            }
            
        }else{
            $("#submit-data").removeAttr("disabled");
        }
    }

function validar_user_name(){
     var username=$("#mcustomer_name_s").val();
     var sede=$("#id_sede").val();

        if(username!=""){
            $.post(baseurl+"customers/validar_user_name",{username:username,sede:sede},function(data){
                if(data=="disponible"){
                    $("#msg_error_username").css("visibility","hidden");
                    if($("#mcustomer_name_s").val()=="" || $("#mcustomer_documento_s").val()=="" || $("#discountFormatPerfil").val()=="-" || $("#discountFormatPerfil").val()=="Seleccine..." || $("#discountFormatIpLocal").val()=="-" || $("#Ipremota").val()=="" || $("#mcustomer_comentario_s").val()==""){
                         $("#submit-data").attr("disabled", true);    

                    }else{
                        $("#submit-data").removeAttr("disabled");    
                    }
                }else{
                    $("#msg_error_username").css("visibility","visible");
                    $("#submit-data").attr("disabled", true);    
                }
            });
        }
}
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
    var perfil_5 = new Array ("Seleccine...","3Megas","5Megas","10Megas","Cortados");
							//crear funcion que ejecute el cambio
							function cambia(){
								var customergroup;
								customergroup = document.formulario1.customergroup[document.formulario1.customergroup.			selectedIndex].value;
								//se verifica la seleccion dada
								if(customergroup!=0){
									mis_opts=eval("perfil_"+customergroup);
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
                                if(customergroup=="2"){
                                    $("#Ipremota").val(remote_ip_yopal);
                                    $("#Ipremota2").val(remote_ip_yopal);
                                }else if(customergroup=="3"){
                                    $("#Ipremota").val(remote_ip_villanueva);
                                    $("#Ipremota2").val(remote_ip_villanueva);
                                }else if(customergroup=="4"){
                                    $("#Ipremota").val(remote_ip_monterrey);
                                    $("#Ipremota2").val(remote_ip_monterrey);
                                }
                                selecciona_para_agregar();
							}	
	var Iplocal_2 = new Array ("10.0.0.1");
	var Iplocal_3 = new Array ("80.0.0.1");
	var Iplocal_4 = new Array ("10.1.100.1");
							//crear funcion que ejecute el cambio
							function cambia2(){
								var customergroup;
								customergroup = document.formulario1.customergroup[document.formulario1.customergroup.			selectedIndex].value;
								//se verifica la seleccion dada
								if(customergroup!=0){
									mis_opts=eval("Iplocal_"+customergroup);
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
                                selecciona_para_agregar();

							}
	var ciudad_Casanare = new Array ("-","Yopal","Monterrey","Villanueva");
	var ciudad_Putumayo = new Array ("-","Mocoa");	
							//crear funcion que ejecute el cambio
							function cambia3(){
								var departamento;
								departamento = document.formulario1.departamento[document.formulario1.departamento.			selectedIndex].value;
								//se verifica la seleccion dada
								if(departamento!=0){
									mis_opts=eval("ciudad_"+departamento);
									//definimos cuantas obciones hay
									num_opts=mis_opts.length;
									//marcamos obciones en el selector
									document.formulario1.ciudad.length = num_opts;
									//colocamos las obciones array
									for(i=0; i<num_opts; i++){
										document.formulario1.ciudad.options[i].value=mis_opts[i];
										document.formulario1.ciudad.options[i].text=mis_opts[i];
									}
										}else{
											//resultado si no hay obciones
											document.formulario1.ciudad.length = 1;
											document.formulario1.ciudad.options[0].value="-"
											document.formulario1.ciudad.options[0].text="-"											
								}
								document.formulario1.ciudad.options[0].selected = true;
							}
	var localidad_Yopal = new Array ("-","ComunaI","ComunaII","ComunaIII","ComunaIV","ComunaV","ComunaVI");
	var localidad_Monterrey = new Array ("-","Ninguno");
	var localidad_Villanueva = new Array ("-","SinLocalidad");
	var localidad_Mocoa = new Array ("-","Ninguna");
							//crear funcion que ejecute el cambio
							function cambia4(){
								var ciudad;
								ciudad = document.formulario1.ciudad[document.formulario1.ciudad.			selectedIndex].value;
								//se verifica la seleccion dada
								if(ciudad!=0){
									mis_opts=eval("localidad_"+ciudad);
									//definimos cuantas obciones hay
									num_opts=mis_opts.length;
									//marcamos obciones en el selector
									document.formulario1.localidad.length = num_opts;
									//colocamos las obciones array
									for(i=0; i<num_opts; i++){
										document.formulario1.localidad.options[i].value=mis_opts[i];
										document.formulario1.localidad.options[i].text=mis_opts[i];
									}
										}else{
											//resultado si no hay obciones
											document.formulario1.localidad.length = 1;
											document.formulario1.localidad.options[0].value="-"
											document.formulario1.localidad.options[0].text="-"											
								}
								document.formulario1.localidad.options[0].selected = true;
							}
	var barrio_ComunaI = new Array ("-","Bello horizonte","Brisas del Cravo","El Batallon","El Centro","El Libertador","La Corocora","La Estrella bon Habitad","la Pradera","Luis Hernandez Vargas","San Martin","La Arboleda");
	var barrio_ComunaII = new Array ("-","El Triunfo","Comfacasanare","Conjunto Residencial Comfaboy","El Bicentenario","El Remanso","Juan Pablo","La Floresta","Los Andes","Los Helechos","Los Heroes","Maria Milena","Puerta Amarilla","Valle de los guarataros","Villa Benilda","Barcelona","Ciudad Jardín","Juan Hernando Urrego","Unión San Carlos","Laureles","Villa Natalia");
	var barrio_ComunaIII = new Array ("-","20 De Julio","Aerocivil","El Gavan","El Oasis","El Recuerdo","La Amistad","Maria Paz","Mastranto II","Provivienda");
	var barrio_ComunaIV = new Array ("-","1ro de Mayo","Araguaney","Vencedores","Casiquiare","El Bosque","La Campiña","La Esperanza","Las Palmeras","Paraíso","Villa Rocío");
	var barrio_ComunaV = new Array ("-","Ciudad del Carmen","Ciudadela San Jorge","El Laguito","El Nogal","El Portal","El Progreso","La Primavera","Los Almendros","Maranatha","Montecarlo","Nuevo Hábitat","Nuevo Hábitat II","Nuevo Milenio","San Mateo","Villa Nelly","Villa Vargas","Villas de Chavinave");
	var barrio_ComunaVI = new Array ("-","Villa Lucia","Villa Salomé 1","Xiruma","Llano Vargas","Bosques de Sirivana","Bosques de Guarataros","Villa David","Getsemaní","Villa Salomé 2","Las americas","Puente Raudal","Camoruco");
	var barrio_Ninguno = new Array ("-","Palmeras","Pradera","Esperanza","Villa del prado","Primavera","Nuevo milenio","San jose","Centro","Panorama","Alfonso lopez","Rivera de san andres","Rosales","Nuevo horizonte","La roca","Paomera","Floresta","Alcaravanes","Morichito","Villa santiago","15 de octubre","Glorieta","Olimpico","Brisas del tua","Guaira","Esteros","Villa del bosque","Villa mariana","Guadalupe","Leche miel","Lanceros","Paraiso","El caney","Villa daniela","Julia luz","Los esteros");
	var barrio_SinLocalidad = new Array ("-","Banquetas","Bella Vista","Bello Horizonte","Brisas del Agua Clara","Brisas del Upia I","Brisas del Upia II","Buenos Aires","Caricare","Centro","Ciudadela la Virgen","Comuneros","El Bosque","El Morichal","El Morichalito","El Portal","Fundadores","La floresta","Las Vegas","Mirador","Palmeras","Panorama","Paraiso I","Paraiso II","Progreso","Quintas del Camino Real","Villa Alejandra","Villa Campestre","Villa Estampa","Villa Luz","Villa del Palmar","Villa Mariana","Villa de los angeles","Palmares");
	var barrio_Ninguna = new Array ("-","Venecia","Villa Caimaron","Villa Colombia","Villa Daniela","Villa del Norte","Villa del rio","Villa Diana","Villa Natalia","Villa Nueva","Palermo","Paraiso","Peñan","Pinos","Piñayaco","Placer","Plaza de Mercado","Prados","Progreso","Rumipamba","San Andres","San Agustin","San Fernando","San Francisco","La Loma","La union","Las Vegas","Libertador","Loma","Los Angeles","Miraflores","Modelo","Naranjito","Nueva Floresta","Obrero 1","Obrero 2","Olimpico","Pablo VI","Pablo VI bajo");
							//crear funcion que ejecute el cambio
							function cambia5(){
								var localidad;
								localidad = document.formulario1.localidad[document.formulario1.localidad.			selectedIndex].value;
								//se verifica la seleccion dada
								if(localidad!=0){
									mis_opts=eval("barrio_"+localidad);
									//definimos cuantas obciones hay
									num_opts=mis_opts.length;
									//marcamos obciones en el selector
									document.formulario1.barrio.length = num_opts;
									//colocamos las obciones array
									for(i=0; i<num_opts; i++){
										document.formulario1.barrio.options[i].value=mis_opts[i];
										document.formulario1.barrio.options[i].text=mis_opts[i];
									}
										}else{
											//resultado si no hay obciones
											document.formulario1.barrio.length = 1;
											document.formulario1.barrio.options[0].value="-"
											document.formulario1.barrio.options[0].text="-"											
								}
								document.formulario1.barrio.options[0].selected = true;
							}
				
			
			
		
		</script>