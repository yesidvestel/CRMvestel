<style>
.st-Activo, .st-Instalar , .st-Cortado, .st-Suspendido, .st-Exonerado
{
    text-transform: uppercase;
    color: #fff;
    padding: 4px;
    border-radius: 11px;
    font-size: 15px;
}
.st-Activo
{
 background-color: #4EAA28;
}
.st-Instalar
{
 background-color: #A49F20;
}
.st-Cortado
{
 background-color: #A4282A;
}
.sts-Cortado
{
 color: #A4282A;
}
.sts-Suspendido
{
 color: #2224A3;
}
.st-Suspendido
{
 background-color: #2224A3;
}
.st-Exonerado
{
 background-color: #24A9AB;
}
.st-Compromiso
{
 background-color: #EB8D25;
}
.st-Depurado
{
 background-color: darkcyan;
}
.st-Cartera
{
 background-color:darkgoldenrod;
}
</style>
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
						<input type="hidden" placeholder="Material nombre" class="form-control margin-bottom  required" name="abonado" value="<?php echo $codigo + 1 ?>">
						<div class="col-sm-3">
                        	<h6><label class="col-form-label"
                               for="name"><?php echo $this->lang->line('') ?>1er Nombre</label></h6>
							<div>
                            <input type="text"
                                   class="form-control margin-bottom  required" name="name" id="mcustomer_name">
                        	</div>
						</div>
                        <div class="col-sm-3">
                            <h6><label class="col-form-label"
                               for="apellidos"><?php echo $this->lang->line('') ?>2do Nombre</label></h6>
							<div>
                            <input type="text"
                                   class="form-control margin-bottom" name="dosnombre" id="mcustomer_dosnombre">
                        </div>
                        </div>
                        <div class="col-sm-3">
                            <h6><label class="col-form-label"
                               for="apellidos"><?php echo $this->lang->line('') ?>1er Apellido</label></h6>
							<div>
                            <input type="text"
                                   class="form-control margin-bottom  required" name="unoapellido" id="mcustomer_unoapellido">
                        	</div>
                        </div>
                        <div class="col-sm-3">
                            <h6><label class="col-form-label"
                               for="apellidos"><?php echo $this->lang->line('') ?>2do Apellido</label></h6>
							<div>
                            <input type="text"
                                   class="form-control margin-bottom" name="dosapellido" id="mcustomer_dosapellido">
                        	</div>
                        </div>

                        
                        
                        
                        
                    
						<div class="col-sm-6">
                        <h6><label class="col-form-label"
                               for="address"><?php echo $this->lang->line('Company') ?></label></h6>
							<div>
							<input type="text" placeholder="Compañia"
                                   class="form-control margin-bottom" name="company" id="mcustomer_address1">
                        
							</div>
						</div>
                        <div class="col-sm-6">
                            <h6><label class="col-form-label"
                               for="phone"><?php echo $this->lang->line('') ?>Celular</label></h6>
							<div>
                            <input type="text" placeholder="Numero"
                                   class="form-control margin-bottom required" name="celular" id="mcustomer_phone">
                        	</div>
                        </div>
                    
						<div class="col-sm-6">
                       	 <h6><label class="col-form-label" for="celular2">Celular (adi)</label></h6>
							<div>
                            <input type="text" placeholder="Numero adicional"
                                   class="form-control margin-bottom" name="celular2" id="mcustomer_city">
                        	</div>
						</div>
                        <div class="col-sm-6">
                            <h6><label class="col-form-label"
                               for="email"><?php echo $this->lang->line('') ?>Correo</label></h6>
							<div>
                        		<input type="text" placeholder="email"
                                   class="form-control margin-bottom required" name="email" id="mcustomer_email">
                        	</div>
                        </div>                    
                        
                        
                    
						<div class="col-sm-4">
                        <h6><label class="col-form-label"
                               for="nacimiento"><?php echo $this->lang->line('') ?>Feha de nacimiento</label></h6>
							<div>
							<input type="text" class="form-control required" placeholder="Billing Date" name="nacimiento" data-toggle="datepicker" autocomplete="false">
							</div>
						</div>
                        <div class="col-sm-2">
                            <h6><label class="col-form-label"
                               for="tipo_cliente"><?php echo $this->lang->line('') ?>Tipo clte</label></h6>
							<div>
                            <select class="form-control"  id="discountFormat" name="tipo_cliente">
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
                            	<input type="text" placeholder="Numero de documento" class="form-control margin-bottom required" name="documento" id="mcustomer_documento" onfocusout="validar_n_documento()">
                                <a href="#" style="margin-top:1px;" class="btn btn-info" title="Validar Numero de documento" onclick="validar_n_documento()"><i class="icon-refresh"></i></a>
                        	</div>
                        </div>
                    
						<div class="col-sm-4">
						<h6><label class="col-form-label"><?php echo $this->lang->line('') ?>Estrato</label></h6>
					
						<div>
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
					</div>
                    <hr class="col-sm-11">
                    <h5 class="col-sm-11"><?php echo $this->lang->line('') ?>Datos de residencia</h5>
                    <hr class="col-sm-11">
                    <div class="form-group row">
						<div class="col-sm-6">
							 <h6><label class="col-form-label" for="departamento">Departamento</label></h6>
							<div>
							<select name="departamento"  id="depar"  class="form-control mb-1">
												<option value="">-</option>
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
						</div> 
                        <div class="col-sm-6">
                            <h6><label class="col-form-label"
                               for="ciudad"><?php echo $this->lang->line('') ?>Ciudad</label></h6>
						    <div>
								<select  id="cmbCiudades"  class="selectpicker form-control" name="ciudad">
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
                                </select>
							</div>
                        </div>
						<div class="col-sm-6">
                            <h6><label class="col-form-label"
                               for="barrio"><?php echo $this->lang->line('') ?>Barrio</label></h6>
						    <div id="barrios">
								<select id="cmbBarrios" class="selectpicker form-control" name="barrio">
                                <option value="0">-</option>
                                </select>
							</div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <h6><label class="col-sm-12 col-form-label"
                               for="city"><?php echo $this->lang->line('') ?>Direccion</label></h6>
                    	<div class="col-lg-2 mb-1">
						<select class="form-control"  id="nomenclatura" name="nomenclatura">
									<option value="Calle">Calle</option>
									<option value="Carrera">Carrera</option>
									<option value="Diagonal">Diagonal</option>
									<option value="Transversal">Transversal</option>
									<option value="Manzana">Manzana</option>
							</select>
						</div>
                        <div class="col-sm-2 mb-1">
                            <input id="numero1" type="text" placeholder="Numero"
                                   class="form-control margin-bottom" name="numero1">
                        </div>
                        <div class="col-sm-2 mb-1">
                            <select class="form-control" name="adicionauno" id="adicionauno">
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
                        <div class="col-sm-2 mb-1">
                            <input id="numero2" type="text" placeholder="Numero"
                                   class="form-control margin-bottom" name="numero2">
                        </div>
                        <div class="col-sm-2 mb-1">
                            <select id="adicional2" class="col-sm-1 form-control" name="adicional2">
													<option value=""></option>
													<option value="Lote">Lote</option>
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
                        <div class="col-sm-2 mb-1">
                            <input type="text" placeholder="Numero"
                                   class="form-control margin-bottom" name="numero3" id="numero3">
                        </div>
                    
						<div class="col-sm-6">
                        <h6><label class="col-form-label"
                               for="postbox"><?php echo $this->lang->line('') ?>Residencia</label></h6>
							<div>
                        	<select class="form-control"  id="residencia" name="residencia">
										<option value="Casa">Casa</option>
										<option value="Apartamento">Apartamento</option>
										<option value="Edificio">Edificio</option>
										<option value="Oficina">Oficina</option>
										<option value="Vereda">Vereda</option>
								</select>
							</div>
                            <a href="#" style="margin-top:2px;" class="btn btn-info" title="Validar Direccion" id="a_validar_direccion"><i class="icon-refresh"></i></a>
						</div>
                        <div class="col-sm-6">
                            <h6><label class="col-form-label"
                               for="postbox"><?php echo $this->lang->line('') ?>Referencia</label></h6>
							<div>
                            <input id="referencia" type="text" placeholder="detalles de residencia"
                                   class="form-control margin-bottom" name="referencia">
                        	</div>
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
                        <div class="col-sm-12">
                            <h6><label class="col-form-label"
                                   for="tegnologia">Tecnología</label><h6>
                            <div>
                                       <select id="tegnologia" name="tegnologia_instalacion" class="form-control" onchange="selecciona_para_agregar()">
                                        <option value="">--</option>
                                           <option value="GPON">GPON</option>
                                           <option value="EPON">EPON</option>
                                           <option value="EOC">EOC</option>
                                       </select>                     
                                       
                            </div>
                         </div>
						<div class="col-sm-12">
                        <h6><label class="col-form-label"
                               for="name_s"><?php echo $this->lang->line('Name') ?></label><h6>
                        <div>
                            <input type="text" placeholder="Name"
                                   class="form-control margin-bottom" name="name_s" id="mcustomer_name_s" onblur="selecciona_para_agregar()" > 
                                   <span id="msg_error_username" style="color: red;visibility :hidden">Este Nombre de Usuario Ya Existe</span>
                        </div>
                    </div>                    
						<div class="col-sm-6">
                        	<h6><label class="col-form-label"
                               for="phone_s"><?php echo $this->lang->line('') ?>Contraseña</label></h6>
							<div>                       
                        	<input type="text" class="form-control margin-bottom" name="contra" id="mcustomer_documento_s" onkeyup="selecciona_para_agregar()">
						</div>
						</div>
                        <div class="col-sm-6">
                             <h6><label class="col-form-label" for="email_s">Servicio</label></h6>
							<div>
                            <select class="form-control"  id="discountFormatServicio" name="servicio">
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
									<option value="-">-</option>
							</select>                       
							</div>
						</div>
                        <div class="col-sm-6">
                            <h6><label class="col-form-label"
                               for="city_s"><?php echo $this->lang->line('') ?>Ip local</label></h6>
							 <div>
                            <select class="form-control"  id="discountFormatIpLocal" name="Iplocal">
											<option value="-">-</option>
									</select>
                        	</div>
                        </div>
                    
						<div class="col-sm-6">
                        	<h6><label class="col-form-label"
                               for="region_s"><?php echo $this->lang->line('') ?>Ip remota</label></h6>
							<div>
							<input disabled="disabled" type="text" placeholder="Ip remota"
                                   class="form-control margin-bottom" name="Ipremota" id="Ipremota" value="" onkeyup="selecciona_para_agregar()">
                                   <input style="display: none;" type="text" placeholder="Region"
                                   class="form-control margin-bottom" name="Ipremota2" id="Ipremota2" value="">
                        	</div>
						</div>
                        <div class="col-sm-6">                            
                            <h6><label class="col-form-label"
                               for="country_s"><?php echo $this->lang->line('') ?>Comentario</label></h6>
							<div>
                            <input type="text" placeholder="Barrio y codigo usuario"
                                   class="form-control margin-bottom" name="comentario" id="mcustomer_comentario_s" onkeyup="selecciona_para_agregar()">
                        	</div>
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
<div id="modal_validacion_documento" class="modal fade">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 id="titulo-validaciones" class="modal-title">Usuarios con el mismo documento</h4>
            </div>          
            <div class="modal-body">
                <div class="table-responsive">
                    <table id="clientstable" class="table-striped" cellspacing="0" width="100%">
                        <thead>
                    <tr>
                        <th>#</th>
                        <th>Abonado</th>
                        <th><?php echo $this->lang->line('Name') ?></th>
                        <th>Celular</th>
                        <th>Cedula</th>
                        <th><?php echo $this->lang->line('Address') ?></th>
                        <th >Estado</th>
                        


                    </tr>
                    </thead>
                    <tbody>
                    </tbody>

                    <tfoot>
                    <tr>
                        <th>#</th>
                        <th>Abonado</th>
                        <th><?php echo $this->lang->line('Name') ?></th>
                        <th>Celular</th>
                        <th>Cedula</th>
                        <th><?php echo $this->lang->line('Address') ?></th>
                        <th>Estado</th>
                        


                    </tr>
                    </tfoot>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary" onclick='$("#modal_validacion_documento").modal("hide");'>Aceptar</button>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    var remote_ip_yopal="<?=$ips_remotas['yopal']?>";
    var remote_ip_yopal_gpon="<?=$ips_remotas['yopal_gpon']?>";
    var remote_ip_villanueva="<?=$ips_remotas['villanueva']?>";
    var remote_ip_monterrey="<?=$ips_remotas['monterrey']?>";
    var remote_ip_villanueva_gpon="<?=$ips_remotas['villanueva_gpon']?>";
    function selecciona_para_agregar(){
        var elemento=document.getElementById("copy_address");
        //console.log($("#discountFormatServicio").val());
        if(elemento.checked==true){
            var desabilitar=false;
            //console.log($("#mcustomer_name_s").val());
            validar_user_name();
            if($("#mcustomer_name_s").val()=="" || $("#mcustomer_documento_s").val()=="" || $("#discountFormatPerfil").val()=="-" || $("#discountFormatPerfil").val()=="Seleccine..." || $("#discountFormatIpLocal").val()=="-" || $("#Ipremota").val()=="" || $("#mcustomer_comentario_s").val()=="" || $("#tegnologia").val()==""){
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
        if(username!=""){
            $.post(baseurl+"customers/validar_user_name",{username:username,sede:sede,tegnologia_instalacion:tegnologia_instalacion},function(data){
                if(data=="disponible"){
                    $("#msg_error_username").css("visibility","hidden");
                    console.log($("#tegnologia").val());
                    if($("#mcustomer_name_s").val()=="" || $("#mcustomer_documento_s").val()=="" || $("#discountFormatPerfil").val()=="-" || $("#discountFormatPerfil").val()=="Seleccine..." || $("#discountFormatIpLocal").val()=="-" || $("#Ipremota").val()=="" || $("#mcustomer_comentario_s").val()=="" || $("#tegnologia").val()==""){
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
    var tb;
     $(document).ready(function () {
 tb=$('#clientstable').DataTable({
                    
                    "language":{
                            "processing": "Procesando...",
                            "lengthMenu": "Mostrar _MENU_ registros",
                            "zeroRecords": "No se encontraron resultados",
                            "emptyTable": "Ningún dato disponible en esta tabla",
                            "infoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
                            "infoFiltered": "(filtrado de un total de _MAX_ registros)",
                            "search": "Buscar:",
                            "infoThousands": ",",
                            "loadingRecords": "Cargando...",
                            "paginate": {
                                "first": "Primero",
                                "last": "Último",
                                "next": "Siguiente",
                                "previous": "Anterior"
                            },
                             "info": "Mostrando de _START_ a _END_ de _TOTAL_ entradas"

                        }
                    
                });
});
    function validar_n_documento(){
        var doc=$("#mcustomer_documento").val();
        if(doc!=" " && doc!=""){
            $.post(baseurl+"customers/validar_n_documento",{'documento':doc},function(data){
                if(data.conteo!=0){
                    tb.ajax.url(baseurl+"customers/lista_por_documento?doc="+doc).load();
                    $("#titulo-validaciones").text("Usuarios con el mismo documento");
                    $("#modal_validacion_documento").modal("show");                    
                }

            },'json');
                
            
               

        }
    }
    $("#a_validar_direccion").click(function(ev){
        ev.preventDefault();
        validar_direccion();
    });
    function validar_direccion(){
        var id_departamento=$("#depar").val();
        var cmbCiudades=$("#cmbCiudades").val();
        var cmbLocalidades=$("#cmbLocalidades").val();
        var cmbBarrios=$("#cmbBarrios").val();
        var nomenclatura=$("#nomenclatura option:selected").val();
        var numero1=$("#numero1").val();
        var adicionauno=$("#adicionauno option:selected").val();
        var numero2=$("#numero2").val();
        var adicional2=$("#adicional2 option:selected").val();
        var numero3=$("#numero3").val();
        var residencia=$("#residencia option:selected").val();
        var referencia=$("#referencia").val();
        
            $.post(baseurl+"customers/validar_direccion",{
                'id_departamento':id_departamento,
                'cmbCiudades':cmbCiudades,
                'cmbLocalidades':cmbLocalidades,
                'cmbBarrios':cmbBarrios,
                'nomenclatura':nomenclatura,
                'numero1':numero1,
                'adicionauno':adicionauno,
                'numero2':numero2,
                'adicional2':adicional2,
                'numero3':numero3,
                'residencia':residencia,
                'referencia':referencia,
                },function(data){

                if(data=="existe"){
                    
                    tb.ajax.url(baseurl+"customers/lista_por_documento?id_departamento="+id_departamento+"&cmbCiudades="+cmbCiudades+"&cmbLocalidades="+cmbLocalidades+"&cmbBarrios="+cmbBarrios+"&nomenclatura="+nomenclatura+"&numero1="+numero1+"&adicionauno="+adicionauno+"&numero2="+numero2+"&adicional2="+adicional2+"&numero3="+numero3+"&residencia="+residencia+"&referencia="+referencia).load();
                    $("#titulo-validaciones").text("Usuarios con la misma direccion");
                    $("#modal_validacion_documento").modal("show");                    
                }

            });
                
            
               

        
    }
	var perfil_2 = new Array ("Seleccine...","3Megas","5Megas","5MegasD","10Megas","10MegasSt","10MegasD","15Megas","15MegasD","20Megas","20MegasSt","20MegasD","30Megas","30MegasSt","30MegasD","40Megas","40MegasSt","40MegasD","50Megas","50MegasSt","50MegasD","60Megas","60MegasSt","60MegasD","70Megas","70MegasSt","70MegasD","80Megas","80MegasSt","80MegasD","90Megas","90MegasSt","90MegasD","100Megas","100MegasSt","100MegasD","Cortados");
	var perfil_3 = new Array ("Seleccine...","3Megas","5Megas","5MegasD","10Megas","10MegasSt","10MegasD","15Megas","15MegasD","20Megas","20MegasSt","20MegasD","30Megas","30MegasSt","30MegasD","40Megas","40MegasSt","40MegasD","50Megas","50MegasSt","50MegasD","60Megas","60MegasSt","60MegasD","70Megas","70MegasSt","70MegasD","80Megas","80MegasSt","80MegasD","90Megas","90MegasSt","90MegasD","100Megas","100MegasSt","100MegasD","Cortados");
	var perfil_4 = new Array ("Seleccine...","3Megas","5Megas","5MegasD","10Megas","10MegasSt","10MegasD","15Megas","15MegasD","20Megas","20MegasSt","20MegasD","30Megas","30MegasSt","30MegasD","40Megas","40MegasSt","40MegasD","50Megas","50MegasSt","50MegasD","60Megas","60MegasSt","60MegasD","70Megas","70MegasSt","70MegasD","80Megas","80MegasSt","80MegasD","90Megas","90MegasSt","90MegasD","100Megas","100MegasSt","100MegasD","Cortados");
    var perfil_5 = new Array ("Seleccine...","3Megas","5Megas","5MegasD","10Megas","10MegasSt","10MegasD","15Megas","15MegasD","20Megas","20MegasSt","20MegasD","30Megas","30MegasSt","30MegasD","40Megas","40MegasSt","40MegasD","50Megas","50MegasSt","50MegasD","60Megas","60MegasSt","60MegasD","70Megas","70MegasSt","70MegasD","80Megas","80MegasSt","80MegasD","90Megas","90MegasSt","90MegasD","100Megas","100MegasSt","100MegasD","Cortados");
							//crear funcion que ejecute el cambio
							function cambia(){
								var customergroup;
								customergroup = document.formulario1.customergroup[document.formulario1.customergroup.selectedIndex].value;
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
                                var tegnologia_instalacion1=$("#tegnologia option:selected").val();
                                if(customergroup=="2"){
                                    $("#Ipremota").val(remote_ip_yopal);
                                    $("#Ipremota2").val(remote_ip_yopal);
                                    if(tegnologia_instalacion1=="GPON"){
                                        $("#Ipremota").val(remote_ip_yopal_gpon);
                                        $("#Ipremota2").val(remote_ip_yopal_gpon);
                                    }
                                }else if(customergroup=="3"){
                                    $("#Ipremota").val(remote_ip_villanueva);
                                    $("#Ipremota2").val(remote_ip_villanueva);
                                    if(tegnologia_instalacion1=="GPON"){
                                        $("#Ipremota").val(remote_ip_villanueva_gpon);
                                        $("#Ipremota2").val(remote_ip_villanueva_gpon);
                                    }
                                }else if(customergroup=="4"){
                                    $("#Ipremota").val(remote_ip_monterrey);
                                    $("#Ipremota2").val(remote_ip_monterrey);
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
	var Iplocal_2 = new Array ("10.0.0.1");
    var Iplocal_2gpon = new Array ("10.100.0.1");
	var Iplocal_3 = new Array ("80.0.0.1");
	var Iplocal_4 = new Array ("10.1.100.1");
    var Iplocal_3gpon = new Array ("10.20.0.1");
							//crear funcion que ejecute el cambio
							function cambia2(){
								var customergroup;
								customergroup = document.formulario1.customergroup[document.formulario1.customergroup.			selectedIndex].value;
								//se verifica la seleccion dada
								if(customergroup!=0){
                                    var tegnologia_instalacion1=$("#tegnologia option:selected").val();
                                    if(customergroup==3 && tegnologia_instalacion1=="GPON"){
                                        customergroup="3gpon";
                                    }
                                    if(customergroup==2 && tegnologia_instalacion1=="GPON"){
                                        customergroup="2gpon";
                                    }
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