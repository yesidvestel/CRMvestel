<article class="content">
    <div class="card card-block">
        <div id="notify" class="alert alert-success" style="display:none;">
            <a href="#" class="close" data-dismiss="alert">&times;</a>

            <div class="message"></div>
        </div>
        <form method="post" id="data_form" class="form-horizontal" name="formulario1">
            <div class="row">

                <h5><?php echo $this->lang->line('Edit Customer Details') ?></h5>
                <hr>
                <div class="col-md-6">
                    <h5><?php echo $this->lang->line('') ?>DATOS PERSONALES</h5>
                    <input type="hidden" name="id" value="<?php echo $customer['id'] ?>" id="customer_id">
					<input type="text" placeholder="Material nombre" class="form-control margin-bottom  required" name="abonado" value="<?php echo $customer['abonado'] ?>">
					<hr>

                    <div class="form-group row">
						<div class="col-sm-3">
							<h6><label class="col-form-label"
								   for="name"><?php echo $this->lang->line('') ?>1er Nombre</label></h6>
								<div>
								<input type="text"
									   class="form-control margin-bottom  required" name="name" value="<?php echo $customer['name'] ?>" id="mcustomer_name">
							</div>
						</div>
                        <div class="col-sm-3">
                            <h6><label class="col-form-label"
                               for="apellidos"><?php echo $this->lang->line('') ?>2do Nombre</label></h6>
							<div>
                            <input type="text" class="form-control margin-bottom" name="dosnombre" value="<?php echo $customer['dosnombre'] ?>"id="mcustomer_dosnombre">
                        	</div>
                        </div>
                        <div class="col-sm-3">
                            <h6><label class="col-form-label"
                               for="apellidos"><?php echo $this->lang->line('') ?>1er Apellido</label></h6>
							<div>
                            <input type="text" class="form-control margin-bottom  required" name="unoapellido" value="<?php echo $customer['unoapellido'] ?>" id="mcustomer_unoapellido">
                        	</div>
                        </div>
                        <div class="col-sm-3">
                            <h6><label class="col-form-label"
                               for="apellidos"><?php echo $this->lang->line('') ?>2do Apellido</label></h6>
							<div>
                            <input type="text" class="form-control margin-bottom" name="dosapellido" value="<?php echo $customer['dosapellido'] ?>"id="mcustomer_dosapellido">
                        	</div>
                        </div>
                    </div>
                    <div class="form-group row">
						<div class="col-sm-6">
                        <h6><label class="col-form-label"
                               for="Company"><?php echo $this->lang->line('Company') ?></label></h6>
							<div>
							<input type="text" placeholder="Compañia"
                                   class="form-control margin-bottom" name="company" value="<?php echo $customer['company'] ?>" id="mcustomer_address1">
							</div>
						</div>
                        <div class="col-sm-6">
                            <h6><label class="col-form-label"
                               for="celular"><?php echo $this->lang->line('') ?>Celular</label></h6>
							<div>
                            <input type="text" placeholder="Numero"
                                   class="form-control margin-bottom required" name="celular" value="<?php echo $customer['celular'] ?>" id="mcustomer_phone">
                        	</div>
                        </div>
                    </div>
                    <div class="form-group row">
						<div class="col-sm-6">
                        <h6><label class="col-form-label" for="celular2">Celular (adi)</label></h6>
							<div>
                            <input type="text" placeholder="Numero adicional"
                                   class="form-control margin-bottom" name="celular2" value="<?php echo $customer['celular2'] ?>" id="mcustomer_city">
                        	</div>
						</div>
                        <div class="col-sm-6">
                            <h6><label class="col-form-label"
                               for="email"><?php echo $this->lang->line('') ?>Correo</label></h6>
							<div>
                        	<input type="text" placeholder="email"
                                   class="form-control margin-bottom required" name="email" value="<?php echo $customer['email'] ?>" id="mcustomer_email">
                        	</div>
                        </div> 
                    </div>
                    <div class="form-group row">
						<div class="col-sm-4">
                        	<h6><label class="col-form-label"
                               for="nacimiento"><?php echo $this->lang->line('') ?>Feha de nacimiento</label></h6>
							<div>
							<input type="text" class="form-control required" placeholder="Billing Date" name="nacimiento" autocomplete="false" value="<?php echo $customer['nacimiento'] ?>" >
							</div>
						</div>
                        <div class="col-sm-2">
                            <h6><label class="col-form-label"
                               for="tipo_cliente"><?php echo $this->lang->line('') ?>Tipo clte</label></h6>
							<div>
                            <select class="form-control"  id="discountFormat" name="tipo_cliente">
									<option value="<?php echo $customer['tipo_cliente'] ?>"><?php echo $customer['tipo_cliente'] ?></option>
									<option value="Natural">Natural</option>
									<option value="Juridico">Juridico</option>
									<option value="Gubernamental">Gubernamental</option>
									<option value="Militar">Militar</option>
							</select>
                        	</div>
                        </div>
                        <div class="col-sm-2">
                            <h6><label class="col-form-label"
                               for="tipo_documento"><?php echo $this->lang->line('') ?>Tipo Dto</label></h6>
							<div>
                            <select class="form-control"  id="mcustomer_country" name="tipo_documento">
									<option value="<?php echo $customer['tipo_documento'] ?>"><?php echo $customer['tipo_documento'] ?></option>
									<option value="CC">CC</option>
									<option value="CE">CE</option>
									<option value="NIT">NIT</option>
									<option value="PAS">PAS</option>
							</select>
                        	</div>
                        </div>
                        <div class="col-sm-4">
                            <h6><label class="col-form-label"
                               for="documento"><?php echo $this->lang->line('') ?>Nº Documento</label></h6>
							<div>
                            <input type="text" placeholder="Numero de documento"
                                   class="form-control margin-bottom" name="documento" value="<?php echo $customer['documento'] ?>" id="mcustomer_documento">
                        	</div>
                        </div>
                    </div>
					<div class="form-group row">
						<div class="col-sm-6 ">
							<h6><label class="col-form-label"><?php echo $this->lang->line('') ?>Estrato</label></h6>
							<div>
                            <select name="estrato" class="form-control" >
								<option value="<?php echo $customer['estrato'] ?>">>><?php echo $customer['estrato'] ?></option>
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
						<div class="col-sm-6">
							<h6><label class="col-form-label"><?php echo $this->lang->line('') ?>Fecha contrato</label></h6>
							<div>
                            <input type="text"class="form-control margin-bottom" name="fcontrato" value="<?php echo $customer['f_contrato'] ?>">
                        	</div>
						</div>
						<div class="col-sm-6">
							<h6><label class="col-form-label"><?php echo $this->lang->line('') ?>Suscripción</label></h6>

							<div>
								<select name="suscripcion" class="form-control" >
									<option value="<?php echo $customer['suscripcion'] ?>">>><?php echo $customer['suscripcion'] ?></option>
									<option value="Residencial">Residencial</option>
									<option value="Corporativo">Corporativo</option>
									<option value="Dedicado">Dedicado</option>
								</select>
							</div>
						</div>
					</div>
                    <hr>
                    <h5><?php echo $this->lang->line('') ?>DATOS DE RESIDENCIA</h5>
                    <hr>
                    <div class="form-group row">
						<div class="col-sm-6">
							 <h6><label class="col-form-label"
								   for="departamento"><?php echo $this->lang->line('') ?>Departamento</label></h6>
							<?php echo $this->lang->line('departamentos') ?> 
							<select id="depar"	class="selectpicker form-control" name="departamento">                            	
								<option value="<?php echo $departamento['idDepartamento'] ?>">>><?php echo $departamento['departamento'] ?></option>
								<?php
								foreach ($departamentos as $row) {
									$cid = $row['idDepartamento'];
									$title = $row['username'];
									$nombre = $row['departamento'];
									echo "<option value='$cid'>$nombre</option>";
								}
								?>
							</select>
						</div> 
                        <div class="col-sm-6">
                            <h6><label class="col-form-label"
                               for="ciudad"><?php echo $this->lang->line('') ?>Ciudad</label></h6>
						    <div id="ciudades">
								<select id="cmbCiudades" class="selectpicker form-control" name="ciudad">
                                <option value="<?php echo $ciudad['idCiudad'] ?>">>><?php echo $ciudad['ciudad'] ?></option>                                
                                </select>
							</div>  
                        </div>
                    </div>
                    <div class="form-group row"> 
						<div class="col-sm-6">
                            <h6><label class="col-form-label"
                               for="localidad"><?php echo $this->lang->line('') ?>Localidad</label></h6>
						    <div id="localidades">
								<select id="cmbLocalidades"  class="selectpicker form-control" name="localidad">
                                <option value="<?php echo $localidad['idLocalidad'] ?>">>><?php echo $localidad['localidad'] ?></option>								
                                </select>
							</div> 
                        </div>
						<div class="col-sm-6">
                            <h6><label class="col-form-label"
                               for="barrio"><?php echo $this->lang->line('') ?>Barrio</label></h6>
						    <div id="barrios">
								<select id="cmbBarrios" class="selectpicker form-control" name="barrio">
                                <option value="<?php echo $barrio['idBarrio'] ?>">>><?php echo $barrio['barrio'] ?></option>
                                </select>
							</div> 
                        </div>
                    </div>
                    <div class="form-group row">
                        <h6><label class="col-sm-12 col-form-label"
                               for="city"><?php echo $this->lang->line('') ?>Direccion</label></h6>
                    	<div class="col-lg-2 mb-1">
							<select class="form-control"  id="discountFormat" name="nomenclatura">
									<option value="<?php echo $customer['nomenclatura'] ?>"><?php echo $customer['nomenclatura'] ?></option>
									<option value="Calle">Calle</option>
									<option value="Carrera">Carrera</option>
									<option value="Diagonal">Diagonal</option>
									<option value="Transversal">Transversal</option>
									<option value="Manzana">Manzana</option>
							</select>
						</div>
                        <div class="col-sm-2 mb-1">
                            <input type="text" placeholder="Numero"
                                   class="form-control margin-bottom" name="numero1" value="<?php echo $customer['numero1'] ?>">
                        </div>
                        <div class="col-sm-2 mb-1">
                            <select class="form-control" name="adicionauno">
									<option value="<?php echo $customer['adicionauno'] ?>"><?php echo $customer['adicionauno'] ?></option>
									<option value=""></option>
									<option value="bis">bis</option>
									<option value="a">a</option>
									<option value="b">b</option>
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
                        <div class="col-sm-2 mb-1">
                            <input type="text" placeholder="Numero"
                                   class="form-control margin-bottom" name="numero2" value="<?php echo $customer['numero2'] ?>" >
                        </div>
                        <div class="col-sm-2 mb-1">
                            <select class="col-sm-1 form-control" name="adicional2">
									<option value="<?php echo $customer['adicional2'] ?>"><?php echo $customer['adicional2'] ?></option>
									<option value=""></option>
									<option value="Lote">Lote</option>
									<option value="bis">bis</option>
									<option value="a">a</option>
									<option value="b">b</option>
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
                        <div class="col-sm-2 mb-1">
                            <input type="text" placeholder="Numero"
                                   class="form-control margin-bottom" name="numero3" value="<?php echo $customer['numero3'] ?>" id="numero3">
                        </div>
                    </div>
                    <div class="form-group row">
						<div class="col-sm-6">
                        <h6><label class="col-form-label"
                               for="postbox"><?php echo $this->lang->line('') ?>Residencia</label></h6>
							<div>
                        	<select class="form-control"  id="discountFormat" name="residencia">
									<option value="<?php echo $customer['residencia'] ?>"><?php echo $customer['residencia'] ?></option>
									<option value="Casa">Casa</option>
									<option value="Apartamento">Apartamento</option>
									<option value="Edificio">Edificio</option>
									<option value="Oficina">Oficina</option>
									<option value="Vereda">Vereda</option>
							</select>
							</div>
						</div>
                        <div class="col-sm-6">
                            <h6><label class="col-form-label"
                               for="postbox"><?php echo $this->lang->line('') ?>Referencia</label></h6>
							<div>
                            <input type="text" placeholder="detalles de residencia"
                                   class="form-control margin-bottom" name="referencia" value="<?php echo $customer['referencia'] ?>">
                        	</div>
                        </div>
						<div class="col-sm-3">
                            <h6><label class="col-form-label"
                               for="postbox"><?php echo $this->lang->line('') ?>División 1</label></h6>
							<div>
                            <select class="form-control"  id="divicion1" name="divicion">
										<option value="<?php echo $customer['divicion'] ?>">>><?php echo $customer['divicion'] ?></option>
										<option value="">Seleccionar...</option>
										<option value="Torre">Torre</option>
										<option value="Interior">Interior</option>
										<option value="Manzana">Manzana</option>
										<option value="Bloque">Bloque</option>
								</select>
                        	</div>
                        </div>
						<div class="col-sm-3">
							<h6><label class="col-form-label"
                               for="postbox"><?php echo $this->lang->line('') ?>Numero</label></h6>
                            <input type="text" placeholder="Numero"
                                   class="form-control margin-bottom" name="divnum1" value="<?php echo $customer['divnum1'] ?>">
                        </div>
						<div class="col-sm-3">
                            <h6><label class="col-form-label"
                               for="postbox"><?php echo $this->lang->line('') ?>División 2</label></h6>
							<div>
                            <select class="form-control" name="divicion2">
										<option value="<?php echo $customer['divicion2'] ?>">>><?php echo $customer['divicion2'] ?></option>
										<option value="">Seleccionar...</option>
										<option value="Apartamento">Apartamento</option>
										<option value="Casa">Casa</option>
								</select>
                        	</div>
                        </div>
						<div class="col-sm-3">
							<h6><label class="col-form-label"
                               for="postbox"><?php echo $this->lang->line('') ?>Numero</label></h6>
                            <input type="text" placeholder="Numero"
                                   class="form-control margin-bottom" name="divnum2" value="<?php echo $customer['divnum2'] ?>">
                        </div>
						<div class="col-sm-6">
                            <h6><label class="col-form-label"
                               for="postbox"><?php echo $this->lang->line('') ?>Coordenada 1</label></h6>
							<div>
                            <input id="referencia" type="text" value="<?php echo $customer['coor1'] ?>"
                                   class="form-control margin-bottom" name="coor1">
                        	</div>
                        </div>
						<div class="col-sm-6">
                            <h6><label class="col-form-label"
                               for="postbox"><?php echo $this->lang->line('') ?>Coordenada 2</label></h6>
							<div>
                            <input id="referencia" type="text" value="<?php echo $customer['coor2'] ?>"
                                   class="form-control margin-bottom" name="coor2">
                        	</div>
                        </div>
						<div class="col-sm-12">
                            <h6><label class="col-form-label"
                               for="postbox"><?php echo $this->lang->line('') ?>Direccion Suscriptor</label></h6>
							<div>
                            	<input type="text" placeholder="Direccion si es comercial" class="form-control margin-bottom" name="dirsuscriptor" value="<?php echo $customer['dirsuscriptor'] ?>">
                        	</div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <h6><label class="col-sm-10 col-form-label"
                               for="customergroup"><?php echo $this->lang->line('') ?>Sede</label></h6>
                        <div class="col-sm-12">
                            <select id="customergroup" name="customergroup" class="form-control" onchange="cambia()" >
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
                </div>
                

                <!--ship-->

                <div class="col-md-6">
                    <h5><?php echo $this->lang->line('') ?>DATOS DE INTEGRACION</h5>
                     <?php $edit="";
                        if($customer['name_s']!="" && $customer['name_s']!=null){
                            $edit="_edit";
                            echo "<script>var usuario_existe=true</script>";
                        }else{echo "<script>var usuario_existe=false</script>";} ?>
                    <div class="form-group row">
					<hr>
                        <div class="input-group">
                            <label class="display-inline-block custom-control custom-radio ml-1">
                                <input type="checkbox" name="customer1" class="custom-control-input" id="copy_address<?=$edit?>">
                                <span class="custom-control-indicator"></span>
                                <span class="custom-control-description ml-0"><?php echo $this->lang->line('') ?>Integrar al sistema</span>
                            </label>

                        </div>

                        <div class="col-sm-10">
                            <?php echo $this->lang->line("") ?>Ingrese los datos para integrar USUARIO con el SISTEMA
                        </div>
                    </div>
                    <div class="form-group row">
                    	<div class="col-sm-12">
                            <h6><label class="col-form-label"
                                   for="tegnologia">Tecnología</label><h6>
                            <div>
                                       <select id="tegnologia" name="tegnologia_instalacion" class="form-control" onchange="selecciona_para_agregar()">
                                        <option value="">--</option>
                                           <option value="GPON" <?= ($customer['tegnologia_instalacion']=="GPON") ? 'selected=""' :'' ?> >GPON</option>
                                           <option value="EPON" <?= ($customer['tegnologia_instalacion']=="EPON") ? 'selected=""' :'' ?> >EPON</option>
                                           <option value="EOC" <?= ($customer['tegnologia_instalacion']=="EOC") ? 'selected=""' :'' ?> >EOC</option>
                                           <option value="FIBRA" <?= ($customer['tegnologia_instalacion']=="FIBRA") ? 'selected=""' :'' ?> >FIBRA</option>
                                           <option value="RADIO" <?= ($customer['tegnologia_instalacion']=="RADIO") ? 'selected=""' :'' ?> >RADIO</option>
                                       </select>                     
                                       
                            </div>
                         </div>
						<div class="col-sm-12">
                        <h6><label class="col-form-label"
                               for="name_s"><?php echo $this->lang->line('Name') ?></label><h6>
							<div>
								<input type="text" placeholder="Name"
									   class="form-control margin-bottom" name="name_s" value="<?php echo $customer['name_s'] ?>" id="mcustomer_name_s" onblur="selecciona_para_agregar()" >
									   <span id="msg_error_username" style="color: red;visibility :hidden">Este Nombre de Usuario Ya Existe</span>
							</div>
                    	</div>
						<div class="col-sm-6">
                        <h6><label class="col-form-label"
                               for="phone_s"><?php echo $this->lang->line('') ?>Contraseña</label></h6>
							<div>                       
                        	<input type="text" placeholder="phone"
                                   class="form-control margin-bottom" name="contra" value="<?php echo $customer['contra'] ?>" id="mcustomer_documento_s" onkeyup="selecciona_para_agregar()">
							</div>
						</div>
                        <div class="col-sm-6">
                             <h6><label class="col-form-label" for="email_s">Servicio</label></h6>
							<div>
                            <select class="form-control"  id="discountFormat" name="servicio">
									<option value="<?php echo $customer['servicio'] ?>"><?php echo $customer['servicio'] ?></option>
									<option value="pppoe">pppoe</option>
									<option value="pptp">pptp</option>
							</select>
                        	</div>
                        </div>  
                    </div>
                    <div class="form-group row">
						<div class="col-sm-6">
                        	<h6><label class="col-form-label"
                               for="address"><?php echo $this->lang->line('') ?>Perfil</label></h6>
							<div>
							<select class="form-control"  id="discountFormatPerfil" name="perfil" onchange="cambia2()">
									<option value="<?php echo $customer['perfil'] ?>"><?php echo $customer['perfil'] ?></option>
							</select>                       
						</div>
						</div>
                        <div class="col-sm-6">
                            <h6><label class="col-form-label"
                               for="city_s"><?php echo $this->lang->line('') ?>Ip local</label></h6>
							<div>
                            <select class="form-control"  id="discountFormatIplocal" name="Iplocal">
									<option value="<?php echo $customer['Iplocal'] ?>"><?php echo $customer['Iplocal'] ?></option>
							</select>
                        </div>
                        </div>
                    </div>
                    <div class="form-group row">
						<div class="col-sm-6">
                        	<h6><label class="col-form-label"
                               for="region_s"><?php echo $this->lang->line('') ?>Ip remota</label></h6>
							<div>
							<input type="text" placeholder="Region"
                                   class="form-control margin-bottom" name="Ipremota" id="Ipremota" value="<?php echo $customer['Ipremota'] ?>" onkeyup="selecciona_para_agregar()">
                        	</div>
						</div>
                        <div class="col-sm-6">                            
                            <h6><label class="col-form-label"
                               for="country_s"><?php echo $this->lang->line('') ?>Comentario</label></h6>
							<div>
                            <input type="text" placeholder="Barrio y codigo usuario"
                                   class="form-control margin-bottom" name="comentario" value="<?php echo $customer['comentario'] ?>" id="mcustomer_comentario_s">
                                   <?php if($customer['name_s']!="" && $customer['name_s']!=null){  ?><a style="margin-top: 1px;color: white;" onclick="traer_comentario_mikrotik('<?=$customer['name_s']?>')" class="btn btn-info">Traer Comentario de Mikrotik</a><?php } ?>
                        	</div>
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
	function traer_comentario_mikrotik(username){
		var customergroup= $("#customergroup option:selected").val();
		var tegnologia_instalacion= $("#tegnologia option:selected").val();
		$.post(baseurl+"customers/get_comentario_mikrotik",{'username':username,'customergroup':customergroup,'tegnologia_instalacion':tegnologia_instalacion},function(data){
			$("#mcustomer_comentario_s").val(data.comentario);
		},'json');
	}


    
    function selecciona_para_agregar(){
        var elemento=document.getElementById("copy_address<?=$edit?>");
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
     var tegnologia_instalacion= $("#tegnologia option:selected").val();
        if(username!="" && user_name_default!=username){
            $.post(baseurl+"customers/validar_user_name",{username:username,sede:sede,tegnologia_instalacion:tegnologia_instalacion},function(data){
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

        if(username==user_name_default){
                $("#submit-data").removeAttr("disabled");    
                $("#msg_error_username").css("visibility","hidden");
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
	
	var datos_perfiles_ips_r_l=<?=json_encode($ips_remotas2) ?>;
							//crear funcion que ejecute el cambio
							function cambia(){
								var customergroup;
								customergroup = document.formulario1.customergroup[document.formulario1.customergroup.selectedIndex].value;
								//se verifica la seleccion dada
								if(customergroup!=0){
									mis_opts=datos_perfiles_ips_r_l['ips_'+customergroup].perfil;
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
								var tegnologia_instalacion1=$("#tegnologia option:selected").val();
                                if(customergroup==sede_default && user_name_default!=""){
                                    
                                    $("#Ipremota").val(ip_default);
                                    //$("#Ipremota2").val(ip_default);
                                    var val_ip_remot=datos_perfiles_ips_r_l['ips_'+customergroup+"_"+tegnologia_instalacion1];
                                    if(val_ip_remot!=undefined){
										val_ip_remot=datos_perfiles_ips_r_l['ips_'+customergroup+"_"+tegnologia_instalacion1].ip_remota;
                                    	$("#Ipremota").val(val_ip_remot);
                                    }
                                    
                                    /*if(customergroup=="6"){
                                        
                                        
                                        if(tegnologia_instalacion1=="GPON"){
	                                        $("#Ipremota").val(datos_perfiles_ips_r_l['ips_2_GPON'].ip_remota;
	                                       
                                   		 }
                                    }*/
                                }else{
                                    var val_ip_remote="";
	                                if(tegnologia_instalacion1!=""){
	                                    
	                                    val_ip_remote=datos_perfiles_ips_r_l['ips_'+customergroup+"_"+tegnologia_instalacion1];
	                                    console.log(val_ip_remote+" a");    
	                                    if(val_ip_remote==undefined){
	                                        val_ip_remote=datos_perfiles_ips_r_l['ips_'+customergroup].ip_remota;    
	                                    }else{
	                                        
	                                        val_ip_remote=datos_perfiles_ips_r_l['ips_'+customergroup+"_"+tegnologia_instalacion1].ip_remota;
	                                    }
	                                    console.log(val_ip_remote+" x");    
	                                }else{
	                                    val_ip_remote=datos_perfiles_ips_r_l['ips_'+customergroup].ip_remota;
	                                    console.log(val_ip_remote+" y");    
	                                }
	                               $("#Ipremota").val(val_ip_remote);
	                                //$("#Ipremota2").val(val_ip_remote);
								}
                                selecciona_para_agregar();   
							}

							$("#tegnologia").on("change",function(ev){
                                /*var tegnologia_instalacion1=$("#tegnologia option:selected").val();
                                var id_sede=$("#id_sede option:selected").val();
                                if(id_sede=="2"){
                                    $("#Ipremota").val(remote_ip_yopal);
                                    $("#Ipremota2").val(remote_ip_yopal);
                                }else if(id_sede=="3"){
                                    $("#Ipremota").val(remote_ip_villanueva);
                                    $("#Ipremota2").val(remote_ip_villanueva);
                                    if(tegnologia_instalacion1=="GPON"){
                                        $("#Ipremota").val(remote_ip_villanueva_gpon);
                                        $("#Ipremota2").val(remote_ip_villanueva_gpon);
                                    }
                                }else if(id_sede=="4"){
                                    $("#Ipremota").val(remote_ip_monterrey);
                                    $("#Ipremota2").val(remote_ip_monterrey);
                                }*/
                                cambia();
                                cambia2();
                                
                            });		
	
							//crear funcion que ejecute el cambio
							function cambia2(){
								var customergroup;
								customergroup = document.formulario1.customergroup[document.formulario1.customergroup.			selectedIndex].value;
								//se verifica la seleccion dada
								if(customergroup!=0){
									var tegnologia_instalacion1=$("#tegnologia option:selected").val();
                                    var text_key="";
                                if(tegnologia_instalacion1!=""){
                                    
                                    text_key=datos_perfiles_ips_r_l['ips_'+customergroup+"_"+tegnologia_instalacion1];
                                    if(text_key==undefined){
                                        text_key='ips_'+customergroup;    
                                    }else{                                        
                                        text_key='ips_'+customergroup+"_"+tegnologia_instalacion1;
                                    }
                                    
                                }else{
                                    text_key='ips_'+customergroup;
                                }

                                    
                                    var arrayx=new Array(datos_perfiles_ips_r_l[text_key].ip_local);
                                    mis_opts=arrayx;
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
//traer ciudad				
$(document).ready(function(){
	$("#depar").change(function(){
		$("#depar option:selected").each(function(){
			idDepartamento = $(this).val();
			//console.log(idDepartamento);
			$.post(baseurl+"customers/ciudades_list",{'idDepartamento': idDepartamento
				},function(data){
				//console.log(data);
					$("#cmbCiudades").html(data);
			})
		})
	})
})
//traer localidad			
$(document).ready(function(){
	$("#cmbCiudades").change(function(){
		$("#cmbCiudades option:selected").each(function(){
			idCiudad = $(this).val();
			//console.log(idDepartamento);
			$.post(baseurl+"customers/localidades_list",{'idCiudad': idCiudad
				},function(data){
				//console.log(data);
					$("#cmbLocalidades").html(data);
			})
		})
	})
})
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
