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

                        <h6><label class="col-sm-6 col-form-label"
                               for="name"><?php echo $this->lang->line('') ?>Nombre(s)</label></h6> 

                        <div class="col-sm-6">
                            <h6><label class="col-sm-2 col-form-label"
                               for="name"><?php echo $this->lang->line('') ?>Apellido(s)</label></h6>
                        </div>
                        

                        <div class="col-sm-6">
                            <input type="text" placeholder="Nombres completos"
                                   class="form-control margin-bottom  required" name="name" id="mcustomer_name">
                        </div>
                        <div class="col-sm-6">
                            <input type="text" placeholder="Apellido completos"
                                   class="form-control margin-bottom  required" name="apellidos" id="mcustomer_apellidos">
                        </div>
                    </div>
                    <div class="form-group row">

                        <h6><label class="col-sm-6 col-form-label"
                               for="name"><?php echo $this->lang->line('Company') ?></label></h6>

                        <div class="col-sm-6">
                            <h6><label class="col-sm-2 col-form-label"
                               for="phone"><?php echo $this->lang->line('') ?>Celular</label></h6>
                        </div>
                    
                    <div class="col-sm-6">
							<input type="text" placeholder="Compañia"
                                   class="form-control margin-bottom required" name="company" id="mcustomer_phone">
                        
							</div>
                        <div class="col-sm-6">
                            <input type="text" placeholder="Numero"
                                   class="form-control margin-bottom required" name="celular" id="mcustomer_celular">
                        </div>
                    </div>
                    <div class="form-group row">

                        <h6><label class="col-sm-6 col-form-label" for="email">Celular (adi)</label></h6>

                        <div class="col-sm-6">
                            <h6><label class="col-sm-2 col-form-label"
                               for="email"><?php echo $this->lang->line('') ?>Correo</label></h6>
                        </div>                    
                        <div class="col-sm-6">
                            <input type="text" placeholder="Numero adicional"
                                   class="form-control margin-bottom required" name="celular2" id="mcustomer_celular2">
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
                            <select class="form-control"  id="discountFormat" name="tipo_documento">
													<option value="CC">CC</option>
                                                	<option value="CE">CE</option>
                                                  	<option value="NIT">NIT</option>
                                                	<option value="PAS">PAS</option>
                                            </select>
                        </div>
                        <div class="col-sm-4">
                            <input type="text" placeholder="Numero de documento"
                                   class="form-control margin-bottom" name="documento" id="">
                        </div>
                    </div>
                    <hr>
                    <h5><?php echo $this->lang->line('') ?>Datos de residencia</h5>
                    <hr>
                    <div class="form-group row">

                        <h6><label class="col-sm-6 col-form-label"
                               for="Country"><?php echo $this->lang->line('') ?>Departamento</label></h6>

                        <div class="col-sm-6">
                            <h6><label class="col-sm-2 col-form-label"
                               for="PBX"><?php echo $this->lang->line('') ?>Ciudad</label></h6>
                        </div>
                    
						<div class="col-sm-6" id="departamento">
						
                        <select class="seleccion" name="cosa" onchange="cambia()" id="cosa" >
                                   <option value="0">-
                                   <option value="1">Casanare
                                   <option value="2">Putumayo           
				
			</select>
			
			<select class="seleccion">
				<?php if ("cosa"==1){
						echo "<option value='0'>-</option>";
							"<option value='2'>yopal</option>";
					} ?>
			</select>
                       
						</div>
                        <div class="col-sm-6">
                        <select id="Cbodepartamentos" name="opt" onchange="distinto()">                               
                        </select>                       
                        
                       </div> 
                        
                       
                    </div>
                    <div class="form-group row">

                        <h6><label class="col-sm-6 col-form-label"
                               for="postbox"><?php echo $this->lang->line('') ?>Localidad</label></h6>

                        <div class="col-sm-6">
                            
                            <h6><label class="col-sm-2 col-form-label"
                               for="postbox"><?php echo $this->lang->line('') ?>Barrio</label></h6>
                        </div>
                    
                    	<div class="col-sm-6">

                        	<select class="seleccion" name="cosa2" >
				<option value="-">-
			</select>
			
			<select class="seleccion" name="">
				<option value="-">-
			</select>
                       
						</div>
                        <div class="col-sm-6">
                        <select id="Cbodepartamentos" name="opt2"> 
                                                      
                        </select>  
						</div>
                        <div class="col-sm-6">
                            <select id="Cbodepartamentos">                               
                        	</select>
                        </div>
                    </div>
                    <div class="form-group row">

                        <h6><label class="col-sm-12 col-form-label"
                               for="city"><?php echo $this->lang->line('') ?>Direccion</label></h6>

                        
                    
                    	<div class="col-sm-2">
						<select class="form-control"  id="discountFormat" name="tipo_clte">
													<option value="">Calle</option>
                                                	<option value="">Carrera</option>
                                                  	<option value="">Diagonal</option>
                                                	<option value="">Transversal</option>
                                            </select>
                        
						</div>
                        <div class="col-sm-2">
                            <input type="text" placeholder="Numero"
                                   class="form-control margin-bottom" name="Numero" id="">
                        </div>
                        <div class="col-sm-1">
                            <select class="form-control"  id="discountFormat" name="tipo_clte">
													<option value=""></option>
                                                    <option value="">bis</option>
                                                	<option value="">a</option>
                                                  	<option value="">b</option>
                                                	<option value="">c</option>
                                                    <option value="">d</option>
                                                    <option value="">e</option>
                                                    <option value="">a bis</option>
                                                    <option value="">b bis</option>
                                                    <option value="">c bis</option>
                                                    <option value="">d bis</option>
                                            </select>
                        </div>
                        <div class="col-sm-1">
                            <label class="col-form-label" for="Nº">Nº</label>
                        </div>
                        <div class="col-sm-2">
                            <input type="text" placeholder="Numero"
                                   class="form-control margin-bottom" name="Numero" id="">
                        </div>
                        <div class="col-sm-2">
                            <select class=" col-sm-2 form-control"  id="discountFormat" name="tipo_clte">
													<option value=""></option>
                                                    <option value="">bis</option>
                                                	<option value="">a</option>
                                                  	<option value="">b</option>
                                                	<option value="">c</option>
                                                    <option value="">d</option>
                                                    <option value="">e</option>
                                                    <option value="">a bis</option>
                                                    <option value="">b bis</option>
                                                    <option value="">c bis</option>
                                                    <option value="">d bis</option>
                                            </select>
                        </div>
                        <div class="col-sm-2">
                            <input type="text" placeholder="Numero"
                                   class="form-control margin-bottom" name="Numero" id="">
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
                        	<select class="form-control"  id="discountFormat" name="tipo_clte">
													<option value="">Casa</option>
                                                	<option value="">Apartamento</option>
                                                  	<option value="">Edificio</option>
                                                	<option value="">Oficina</option>
                                            </select>
						</div>
                        <div class="col-sm-6">
                            <input type="text" placeholder="seleccione.."
                                   class="form-control margin-bottom" name="taxid">
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
                            <select name="customergroup" class="form-control">
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

                    <div class="form-group row">

                        <h6><label class="col-sm-10 col-form-label"
                               for="name_s"><?php echo $this->lang->line('Name') ?></label><h6>
						
                        <div class="col-sm-12">
                            <input type="text" placeholder="Name"
                                   class="form-control margin-bottom" name="name_s" id="mcustomer_name_s">
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
                                   class="form-control margin-bottom" name="phone_s" id="mcustomer_phone_s">
						</div>
                        <div class="col-sm-6">
                            <input type="text" placeholder="email"
                                   class="form-control margin-bottom" name="email_s" id="mcustomer_email_s">
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
							<input type="text" placeholder="address_s"
                                   class="form-control margin-bottom" name="address_s"
                                   id="mcustomer_address1_s">                       
						</div>
                        <div class="col-sm-6">
                            <input type="text" placeholder="city"
                                   class="form-control margin-bottom" name="city_s" id="mcustomer_city_s">
                        </div>
                    </div>
                    <div class="form-group row">

                        <h6><label class="col-sm-6 col-form-label"
                               for="region_s"><?php echo $this->lang->line('') ?>Ip remota</label></h6>

                        <div class="col-sm-6">                            
                            <h6><label class="col-sm-2 col-form-label"
                               for="country_s"><?php echo $this->lang->line('') ?>Comenterio</label></h6>
                        </div>
                    
                    	<div class="col-sm-6">
							<input type="text" placeholder="Region"
                                   class="form-control margin-bottom" name="region_s" id="region_s">
                        </div>
                        <div class="col-sm-6">
                            <input type="text" placeholder="Country"
                                   class="form-control margin-bottom" name="country_s" id="mcustomer_country_s">
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
                </div>
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
			//1) Definir Las Variables Correspondintes
			
			var opt_1 = new Array ("-", "Yopal", "Monterrey", "DOTA2");
			Yopal[1]
			Monterrey[2]
			var opt_2 = new Array ("-", "Mocoa", "villa", "CPU", "...");
			var opt_3 = new Array ("-", "Google Chrome", "Linux", "opera", "...");
			var opt_4 = new Array ("-", "MSI", "ASUS", "GIGABYTE", "...");
			// 2) crear una funcion que permita ejecutar el cambio dinamico
			
			function cambia(){
				var cosa;
				//Se toma el vamor de la "cosa seleccionada"
				cosa = document.formulario1.cosa[document.formulario1.cosa.selectedIndex].value;
				//se chequea si la "cosa" esta definida
				if(cosa!=0){
					//selecionamos las cosas Correctas
					mis_opts=eval("opt_" + cosa);
					//se calcula el numero de cosas
					num_opts=mis_opts.length;
					//marco el numero de opt en el select
					document.formulario1.opt.length = num_opts;
					//para cada opt del array, la pongo en el select
					for(i=0; i<num_opts; i++){
						document.formulario1.opt.options[i].value=mis_opts[i];
						document.formulario1.opt.options[i].text=mis_opts[i];
					}
					}else{
						//si no habia ninguna opt seleccionada, elimino las cosas del select
						document.formulario1.opt.length = 1;
						//ponemos un guion en la unica opt que he dejado
						document.formulario1.opt.options[0].value="-";
						document.formulario1.opt.options[0].text="-";
					}
					//hacer un reset de las opts
					document.formulario1.opt.options[0].selected = true;
					
				}
			
			
		
		</script>
 <script type="text/javascript">
			//1) Definir Las Variables Correspondintes
			
			var opt2_1 = new Array ("-", "localidad1", "localidad2", "DOTA2", "...");
			var opt2_2 = new Array ("-", "no tiene", "SSD", "CPU", "...");
			var opt2_3 = new Array ("-", "Google Chrome", "Linux", "opera", "...");
			var opt2_4 = new Array ("-", "MSI", "ASUS", "GIGABYTE", "...");
			// 2) crear una funcion que permita ejecutar el cambio dinamico
			
			function distinto(){
				var opt;
				//Se toma el vamor de la "cosa seleccionada"
				opt = document.formulario1.opt[document.formulario1.opt.selectedIndex].value;
				//se chequea si la "cosa" esta definida
				if(opt!=0){
					//selecionamos las cosas Correctas
					mis_opts=eval("opt2_" + opt);
					//se calcula el numero de cosas
					num_opts=mis_opts.length;
					//marco el numero de opt en el select
					document.formulario1.opt2.length = num_opts;
					//para cada opt del array, la pongo en el select
					for(x=0; x<num_opts; x++){
						document.formulario1.opt2.options[x].value=mis_opts[x];
						document.formulario1.opt2.options[x].text=mis_opts[x];
					}
					}else{
						//si no habia ninguna opt seleccionada, elimino las cosas del select
						document.formulario1.opt2.length = 1;
						//ponemos un guion en la unica opt que he dejado
						document.formulario1.opt2.options[0].value="-";
						document.formulario1.opt2.options[0].text="-";
					}
					//hacer un reset de las opts
					document.formulario1.opt2.options[0].selected = true;
					
				}
			
			
		
		</script>