<style type="text/css">
    .wrapper1, .wrapper2 { width: 100%; overflow-x: scroll; overflow-y: hidden; }
.wrapper1 { height: 20px; }
.div1 { height: 20px; }
.div2 { overflow: none; }
</style>
<style>
.st-Activo, .st-Instalar , .st-Cortado, .st-Suspendido, .st-Exonerado, .st-Compromiso
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
.st-Suspendido
{
 background-color: #2224A3;
}
.sts-Suspendido
{
 color: #2224A3;
}
.st-Exonerado
{
 background-color: #24A9AB;
}
.st-Compromiso
{
 background-color: #8B6390;
}
.cl-servicios:hover {
    border: solid 1px red;
}
.cl-ck-f-electronicas:hover{
     transform: scale(4);
}
.st-Dado
{
 background-color: #A8531A;
}
.st-Por
{
 background-color: #180E97;
}

/*Cambios filtro multiple */
.selectBox {
  position: relative;
}

.selectBox select {
  width: 100%;
  font-weight: bold;
}

.overSelect {
  position: absolute;
  left: 0;
  right: 0;
  top: 0;
  bottom: 0;
}
/*primer grupo de chechbox configuracion (estado usuario)*/
#checkboxes {
  display: none;
  border: 1px #dadada solid;
}

#checkboxes label {
  display: block;
}

#checkboxes label:hover {
  background-color: #1e90ff;
}
/*segundo grupo de chechbox configuracion (estado de cuenta)*/
#checkboxes2 {
  display: none;
  border: 1px #dadada solid;
}

#checkboxes2 label {
  display: block;
}

#checkboxes2 label:hover {
  background-color: #1e90ff;
}
/*3er grupo de chechbox configuracion (localidad)*/
#checkboxes3 {
  display: none;
  border: 1px #dadada solid;
}

#checkboxes3 label {
  display: block;
}

#checkboxes3 label:hover {
  background-color: #1e90ff;
}
/*3er grupo de chechbox configuracion (barrio)*/
#checkboxes4 {
  display: none;
  border: 1px #dadada solid;
}

#checkboxes4 label {
  display: block;
}

#checkboxes4 label:hover {
  background-color: #1e90ff;
}



</style>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-cookie/1.4.1/jquery.cookie.min.js"></script>
<link rel="stylesheet" href="<?=base_url()?>assets/css/jquery.lineProgressbar.css">
<script type="text/javascript" src="<?=base_url()?>assets/js/jquery.lineProgressbar.js"></script>
<article class="content content items-list-page">
    <div class="card card-block">
        <div id="notify" class="alert alert-success" style="display:none;">
            <a href="#" class="close" data-dismiss="alert">&times;</a>

            <div class="message"></div>
        </div>
        <div id="div_notify3">
        <div id="notify3" class="alert alert-success" style="display:none;">
            <a href="#" class="close" data-dismiss="alert">&times;</a>

            <div class="message3"><img src="<?=base_url()?>/assets/img/iconocargando.gif"></div>
        </div>
		 </div>
         <div id="div_notify_elec">
             
         </div>
            <!-- paneles -->
            <div class="card">
                    <div class="card-body">
                        <div class="card-block">
                            <label class="col-sm-12 col-form-label"
                                       for="pay_cat"><h5>FILTRAR </h5> </label> 

                            <ul class="nav nav-tabs nav-justified">
                                <li class="nav-item">
                                    <a class="nav-link active" id="active-tab" data-toggle="tab" href="#active"
                                       aria-controls="active"
                                       aria-expanded="true">Estado</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="link-tab" data-toggle="tab" href="#link"
                                       aria-controls="link"
                                       aria-expanded="false">Servicio</a>
                                </li>

                                <li class="nav-item">
                                    <a class="nav-link" id="thread-tab" data-toggle="tab" href="#thread"
                                       aria-controls="thread">Direccion</a>
                                </li>

                                <li class="nav-item">
                                    <a class="nav-link" id="milestones-tab" data-toggle="tab" href="#milestones"
                                       aria-controls="milestones"> Cuenta</a>
                                </li>
                                 <li class="nav-item">
                                    <a class="nav-link" id="ingreso-tab" data-toggle="tab" href="#ingreso"
                                       aria-controls="ingreso"> Ingreso/Contrato</a>
                                </li>
                                 <li class="nav-item">
                                    <a class="nav-link" id="tegnologia-tab" data-toggle="tab" href="#tegnologia"
                                       aria-controls="tegnologia"> Tecnología</a>
                                </li>
                                  <li class="nav-item">
                                    <a class="nav-link" id="estado_anterior-tab" data-toggle="tab" href="#estado_anterior"
                                       aria-controls="estado_anterior"> Estado Anterior</a>
                                </li>
                               <!-- <li class="nav-item">
                                    <a class="nav-link" id="thread-tab" data-toggle="tab" href="#activities"
                                       aria-controls="activities">Otro Filtro</a>
                                </li>-->
                               
                            </ul>
                            <div class="tab-content px-1 pt-1">
                                
                                <div role="tabpanel" class="tab-pane fade active in" id="active" aria-labelledby="active-tab" aria-expanded="true">
                                    <div class="form-group row">
                                            
                                        <label class="col-sm-2 col-form-label"
                                               for="pay_cat">Estado</label>

                                        <div class="col-sm-6">
                                            
                                                
                                              <div class="form-group">
                                                  <select id="estado_multiple" name="estado_multiple[]" class="form-control select-box" multiple="multiple">
														<option value='Activo'>Activos </option>
														<option value='Cortado'>Cortados</option>
														<option value='Suspendido'>Suspendidos</option>
														<option value='Instalar'>Instalar</option>
														<option value='Exonerado'>Exonerado</option>
														<option value='Cartera'>Cartera</option>
														<option value='Compromiso'>Compromiso</option>
														<option value='Retirado'>Retirado</option>
														<option value='Depurado'>Depurado</option>
														<option value='Reportado'>Reportado</option>
														<option value='Dado de Baja'>Dado de Baja</option>
														<option value='Por retirar'>Por retirar</option>
														<option value='Cuentas dificil cobro'>Cuentas dificil cobro</option>
													  	<option value="Por definir"><?php echo $this->lang->line('') ?>Por definir</option>
														<option value="No instalado"><?php echo $this->lang->line('') ?>No instalado</option>
                                                    </select>

                                              </div>
                                               
                                                    <input type="checkbox" name="sin_factura_actual" id="sin_factura_actual" style="cursor: pointer;transform: scale(2);">&nbsp;&nbsp;Sin Factura Actual<br>
                                                    <input type="checkbox" name="agregar_ultima_transaccion" id="agregar_ultima_transaccion" style="cursor: pointer;transform: scale(2);">&nbsp;&nbsp;Al exportar agregar ultima transaccion<br>
                                                    <input type="checkbox" name="filtro_equipo_asignado" id="filtro_equipo_asignado" style="cursor: pointer;transform: scale(2);">&nbsp;&nbsp;Filtrar usuarios que tienen equipo asignado

                                        </div>
                                    </div>



                                </div>
                                <div class="tab-pane fade" id="link" role="tabpanel" aria-labelledby="link-tab" aria-expanded="false">
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label"
                                                   for="pay_cat">Servicio</label>

                                            <div class="col-sm-6">
                                                <select name="trans_type" class="form-control" id="sel_servicios">
                                                    <option value=''>Todos</option>
                                                    <option value='Internet'>Internet</option>
                                                    <option value='TV'>TV</option>
                                                    <option value='Combo'>Combo</option>
                                                </select>
                                            </div>                              
                                            <input type="checkbox" class="cl-ck-f-electronicas" id="check1" name="individual_service" style="cursor:pointer;" ><b onclick="ckekar_1()" style="cursor: pointer;"><i  >&nbsp; Individualizar Servicio</i></b><br>
                                            <input type="checkbox" class="cl-ck-f-electronicas" id="check2" name="usuarios_a_facturar" style="cursor:pointer;" ><b onclick="ckekar_2()" style="cursor: pointer;"><i  >&nbsp; Filtrar Con Usuarios a Facturar Electronicamente</i></b>
                                        </div>
                                </div>
                                <!--thread-->
                                <div class="tab-pane fade" id="thread" role="tabpanel" aria-labelledby="thread-tab" aria-expanded="false">

                                        <div class="form-group row">
                                        <label class="col-sm-2 col-form-label"
                                               for="pay_cat">Direccion</label>

                                        <div class="col-sm-6">
                                            <select name="trans_type" class="form-control" id="sel_dir_personalizada" onclick="act_sel_dir_personalizada()">
                                                <option value=''>Todas</option>
                                                <option value='Personalizada'>Personalizada</option>
                                            </select>
                                        </div>                              
                                    </div>
                                    <div id="div_direccion_personalizada">
                                            <div class="form-group row">

                                            <div class="col-sm-12">
                                                <h6><label class="col-sm-2 col-form-label"
                                                   for="ciudad"><?php echo $this->lang->line('') ?>Ciudad</label></h6>
                                                <div id="ciudades">
                                                    <select id="cmbCiudades"  class="selectpicker form-control" name="ciudad" > 
                                                            <option value="">-</option>
                                                            <?php if($_SESSION[md5("variable_datos_pin")]['db_name'] !== "admin_vestel"){ ?>
                                                                <?php foreach ($ciudades_filtro as $keyx => $ciudadx) {?>
                                                                    <option value="<?=$ciudadx['id'] ?>"><?=$ciudadx['name']." ( ".$ciudadx['departamentName']." )" ?></option>
                                                                <?php } ?>
                                                            <?php }else{ ?>
                                                            <option selected value="<?php echo $sede['idCiudad'] ?>"><?php echo $sede['ciudad'] ?></option>
                                                            <?php } ?>
                                                        
                                                    </select>
                                                </div>
                                                   
                                            </div>
                                          
                                           
                                        </div>
                                            <div class="form-group row"> 
                                            
                                                <div class="col-sm-6">
                                                    <h6><label class="col-sm-2 col-form-label"
                                                       for="localidad"><?php echo $this->lang->line('') ?>Localidad</label></h6>
                                                    <div id="localidades">
                                                        
                                                        <select style="width: 100%;" id="localidad_multiple" name="localidad_multiple[]" class="form-control select-box" multiple="multiple">
                                                                    
                                                         </select>
                                                         
                                                              
                                                        
                                                    </div>
                                                    
                                                </div>
                                                
                                                <div class="col-sm-6">
                                                    <h6><label class="col-sm-2 col-form-label"
                                                       for="barrio"><?php echo $this->lang->line('') ?>Barrio</label></h6>
                                                    <div id="barrios">
                                                        
                                                        <select style="width: 100%;" id="barrios_multiple" name="barrios_multiple[]" class="form-control select-box" multiple="multiple">
                                                                    
                                                         </select>
                                                    </div>
                                                       
                                                </div>
                                                 
                                            </div>
                                            <div class="form-group row">

                                                <h6><label class="col-sm-12 col-form-label"
                                                       for="city"><?php echo $this->lang->line('') ?>Direccion</label></h6>

                                                
                                            
                                                <div class="col-sm-2">
                                                <select class="form-control"  id="nomenclatura" name="nomenclatura">
                                                                            <option value="-">-</option>
                                                                            <option value="Calle">Calle</option>
                                                                            <option value="Carrera">Carrera</option>
                                                                            <option value="Diagonal">Diagonal</option>
                                                                            <option value="Transversal">Transversal</option>
                                                                            <option value="Manzana">Manzana</option>
                                                                    </select>
                                                
                                                </div>
                                                <div class="col-sm-2">
                                                    <input type="text" placeholder="Numero" id="numero1" 
                                                           class="form-control margin-bottom" name="numero1">
                                                </div>
                                                <div class="col-sm-2">
                                                    <select class="form-control" id="adicionauno" name="adicionauno">
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
                                                <div class="col-sm-1" style="margin-left: -10px; width: 2%">
                                                    <label class="col-form-label" for="Nº">Nº</label>
                                                </div>
                                                <div class="col-sm-2" style="margin-left: 14px;">
                                                    <input type="text" placeholder="Numero"
                                                           class="form-control margin-bottom" id="numero2" name="numero2" style="margin-left: -20px;">
                                                </div>
                                                <div class="col-sm-2" style="margin-left: -30px;margin-right: -20px;">
                                                    <select class="col-sm-1 form-control" id="adicional2" name="adicional2">
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
                                    </div>

                                </div>
                                <!--thread-->
                                <!--milestones-->
                                <div class="tab-pane fade" id="milestones" role="tabpanel" aria-labelledby="milestones-tab" aria-expanded="false">
                                    <div class="form-group row">
                                
                                        <label class="col-sm-2 col-form-label"
                                               for="pay_cat">Estado de Cuenta</label>

                                        <div class="col-sm-6">
                                           
                                            <select style="width: 100%;" id="deudores_multiple" name="deudores_multiple[]" class="form-control select-box" multiple="multiple">
                                                        <option value='menosdeunmes'>Menos del Mes</option>
                                                        <option value='1mes'>Corriente</option>
                                                        <option value='masdeunmes'>Mas del Mes</option>
                                                        <option value='2meses'>Mas de 2 meses</option>
                                                        <option value='3y4meses'>Mas de 3 y 4 meses</option>
                                                        <option value='Todos'>Todos los Deudores</option>
                                                        <option value='masdediez'>Debe mas de 10 mil</option>
                                                        <option value='saldoaFavor'>Saldo a Favor</option>
                                                        <option value='al Dia'>Al Dia</option>       
                                             </select>
                                            
                                        </div>
                                    </div>

                                </div>
                                <!--milestones-->
                                
                                <div class="tab-pane fade" id="ingreso" role="tabpanel" aria-labelledby="ingreso-tab" aria-expanded="false">
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label"
                                               for="pay_cat">Fechas</label>

                                        <div class="col-sm-6">
                                            <select name="trans_type" class="form-control" id="fechas" onchange="filtrado_fechas()">
                                                <option value=''>Todas</option>
                                                <option value='fecha_ingreso'>De los ingresos</option>
                                                <option value='fecha_contrato'>Fecha de Contrato</option>
                                                <option value='1_despues_contrato'>1 año despues de fecha de Contrato</option>
                                                <option value='desde_siempre_a_fecha'>Fecha de Contrato, desde Siempre Hasta Fecha Indicada</option>
                                                
                                            </select>
                                        </div>                              
                                    </div>
                                    <div class="form-group row" id="div_fechas" style="display: none">
                                        <label class="col-sm-2 col-form-label"
                                               for="pay_cat" id="label_fechas7">De los ingresos</label>

                                        <div class="col-sm-2">
                                            <input type="text" class="form-control required"
                                                   placeholder="Start Date" name="sdate" id="sdate"
                                                    autocomplete="false">
                                        </div>
                                        <div class="col-sm-2">
                                            <input type="text" class="form-control required"
                                                   placeholder="End Date" name="edate" id="edate"
                                                   data-toggle="datepicker" autocomplete="false">
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="tegnologia" role="tabpanel" aria-labelledby="milestones-tab" aria-expanded="false">
                                    <div class="form-group row">
                                
                                        <label class="col-sm-2 col-form-label"
                                               for="pay_cat">Tipo de Tecnología</label>

                                        <div class="col-sm-6">
                                           
                                            <select style="width: 100%;" id="tegnologia_multiple" name="tegnologia_multiple[]" class="form-control select-box" multiple="multiple">
                                                         
                                                        <option value='Sin Teg'>Sin definir</option>
                                                        <option value='FTTH'>FTTH</option>
                                                        <option value='EOC'>EOC</option>                                                        
                                             </select>
                                            
                                        </div>
                                    </div>

                                </div>
                                 <div class="tab-pane fade" id="estado_anterior" role="tabpanel" aria-labelledby="milestones-tab" aria-expanded="false">
                                    <div class="form-group row">
                                
                                        <label class="col-sm-2 col-form-label"
                                               for="pay_cat">Habilitar</label>

                                        <div class="col-sm-6">
                                           
                                            <select style="width: 100%;" id="ultimo_estado_sel" name="ultimo_estado_sel" class="form-control">
                                                         
                                                        <option value='No'>No</option>
                                                        <option value='Si'>Si</option>
                                             </select>

                                            
                                        </div>
                                    </div>
                                    <div class="form-group row" id="div_filtrar_fecha_cambio" style="display:none">
                                         <label class="col-sm-2 col-form-label"
                                               for="pay_cat">Filtrar por fecha de cambio</label>

                                        <div class="col-sm-6">
                                           
                                            <select style="width: 100%;" id="sel_filtrar_fecha_cambio" name="sel_filtrar_fecha_cambio" class="form-control">
                                                         
                                                        <option value='No'>No</option>
                                                        <option value='Si'>Si</option>
                                             </select>
                                             
                                            
                                        </div>
                                    </div>
                                    <div class="form-group row" id="div_fechas_filtro_cambio_estado" style="display:none;">
                                        <label class="col-sm-2 col-form-label"
                                               for="pay_cat" id="label_fechas">Fechas</label>

                                        <div class="col-sm-2">
                                            <input type="text" class="form-control required"
                                                   placeholder="Start Date" name="sdate3" id="sdate3"
                                                    autocomplete="false">
                                        </div>
                                        <div class="col-sm-2">
                                            <input type="text" class="form-control required"
                                                   placeholder="End Date" name="edate2" id="edate2"
                                                   data-toggle="datepicker" autocomplete="false">
                                        </div>
                                    </div>

                                </div>
                                
                                
                                


                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                                <label class="col-sm-3 col-form-label" for="pay_cat"></label>

                                <div class="col-sm-4">
                                    <input type="button" class="btn btn-primary btn-md" value="VER" onclick="filtrar();reestablecer_seleciones();">


                                </div>
                            </div>
                </div>
                <!-- fin paneles -->
                        
                           
							
                        
                    
        <div class="grid_3 grid_4">
            <h5><?php echo $this->lang->line('Client Group') . '- ' . $group['title'] ?></h5> 
			<a href=""  class="btn btn-primary btn-md" onclick="abrir_modal_sms(event)"><i class="fa fa-envelope"></i>Enviar mensajes de Grupo</a>
			<a href="#" onclick="redirect_to_export()" class="btn btn-success btn-md">Exportar a Excel .XLSX</a>
			<a href=""  class="btn btn-danger btn-md" onclick="abrir_modal_corte_usuarios(event)"><i class="fa fa-envelope"></i>Cortar Usuarios</a>&nbsp;
			<a class="btn btn-danger" href="<?=base_url().'clientgroup/descargar_pdf_falctura_usuarios_media_carta?gid='.$_GET['id'] ?>">Exportar a PDF <img width="20px" src="<?=base_url()?>assets/images/icons/pdf.png"></a>
            <a href=""  class="btn btn-primary btn-md" onclick="abrir_modal_envio_email(event)"><iclass="fa fa-envelope"></i>Enviar Correo</a>
			<a href="#pop_model" data-toggle="modal" data-remote="false" class="btn btn-primary btn-md" title="Change Status">SIIGO</a>
            <hr>
<div class="wrapper1">
    <div class="div1"></div>
</div>
            <div class="wrapper2">
                <div class="div2">
            <table id="fclientstable" class="table table-hover" cellspacing="0" width="100%">
                <thead>
                <tr >
                    <th><input type="checkbox" <?= ($cuenta!=0) ? 'checked':'' ?>  name="" style="cursor: pointer;" onclick="selet_all_customers(this)">&nbspSMS</th>
                    <th class="1_th">#</th>
                    <th class="id_th">ID</th>
					<th class="abonado_th">Abonado</th>
                    <th class='tdoc_th'>T.Doc</th>
					<th class="cedula_th">Cedula</th>
                    <th class="nombre_th"><?php echo $this->lang->line('Name') ?></th>
					<th class="celular_th">Celular</th>
					<th class="celular2_th">Celular Ad</th>
                    <th class="Email_th">Correo</th>
                    <th class="direccion_th"><?php echo $this->lang->line('Address') ?></th>
                    <th class="barrio_th">Barrio</th>
                    <th class="serv_suscritos_th">Serv. Suscritos</th>
                    <th class="tecnologia_th">Tecnologia</th>
					<th class="estado_th" id="despues_de_thead">Estado</th>
                    <th class='deuda_th'>Deuda</th>
                    <th class='suscripcion_th'>Suscripcion</th>
                    <th class='ingresos_th'>Ingreso</th>
                    <th class='fecha_cambio_th'>Fecha Cambio</th>
                    <th class='ultimo_estado_th'>Ult. Estado</th>
                    <th class='fecha_contrato_th'>Fecha Contrato</th>
                    <th class='fecha_ingreso_th'>Fecha Ingreso</th>
                    <th class='clausula_th'>Clausula</th>
                    <th class="settings_th"><?php echo $this->lang->line('Settings') ?></th>
					<?php if ($this->aauth->get_user()->roleid > 4) { ?>
					<th class="config_th">Config</th>
					<?php } ?>

                </tr>
                </thead>
                <tbody>
                </tbody>

                <tfoot id="tf1">
                <tr >
                    <th>SMS</th>
                    <th class="1_th">#</th>
                    <th class="id_th">ID</th>
                    <th class="abonado_th">Abonado</th>
                    <th class='tdoc_th'>T.Doc</th>
                    <th class="cedula_th">Cedula</th>
                    <th class="nombre_th"><?php echo $this->lang->line('Name') ?></th>
                    <th class="celular_th">Celular</th>
                    <th class="celular2_th">Celular Ad</th>
                    <th class="Email_th">Correo</th>
                    <th class="direccion_th"><?php echo $this->lang->line('Address') ?></th>
                    <th class="barrio_th">Barrio</th>
                    <th class="serv_suscritos_th">Serv. Suscritos</th>
                    <th class="tecnologia_th">Tecnologia</th>
                    <th class="estado_th" id="despues_de_thead">Estado</th>
                    <th class='deuda_th'>Deuda</th>
                    <th class='suscripcion_th'>Suscripcion</th>
                    <th class='ingresos_th'>Ingreso</th>
                    <th class='fecha_cambio_th'>Fecha Cambio</th>
                    <th class='ultimo_estado_th'>Ult. Estado</th>
                    <th class='fecha_contrato_th'>Fecha Contrato</th>
                    <th class='fecha_ingreso_th'>Fecha Ingreso</th>
                    <th class='clausula_th'>Clausula</th>
                    <th class="settings_th"><?php echo $this->lang->line('Settings') ?></th>
					<?php if ($this->aauth->get_user()->roleid == 5) { ?>
					<th class="config_th">Config</th>
					<?php } ?>
                </tr>
                </tfoot>
            </table>
            </div>
            </div>
            <hr>
            <div class="form-group">
            <select id="select2_columnas"  class="form-control select-box" multiple="multiple">
                <option value="1">#</option>
                <option value="2">ID</option>
                <option value="3">Abonado</option>
                <option value="4">Tipo Documento</option>
                <option value="5">Cedula</option>
                <option value="6">Nombre</option>
                <option value="7">Celular</option>
                <option value="8">Email</option>
                <option value="9">Direccion</option>
                <option value="10">Barrio</option>
                <option value="11">Serv. Suscritos</option>
                <option value="12">Tecnologia</option>
                <option value="13">Estado</option>
                <option value="14">Deuda</option>
                <option value="15">Suscripcion</option>
                <option value="16">Ingreso</option>
                <option value="17">Fecha Cambio</option>
                <option value="18">Ult. Estado</option>
                <option value="19">Fecha Contrato</option>
                <option value="20">Fecha Ingreso</option>
                <option value="21">Clausula</option>                
                <option value="22">Configuraciones</option>
                <option value="23">Config</option>
            </select>
            </div>
        </div>
        
    </div>

</article>

<script type="text/javascript">
    var columnasUlEsAgregadas=false;
$("#ultimo_estado_sel").on("change",function(e){
    if($(this).val()=="Si"){
        $("#div_filtrar_fecha_cambio").css("display","");
        columnasAgregadas=false;
    }else{
        $("#div_filtrar_fecha_cambio").css("display","none");
        $("#div_fechas_filtro_cambio_estado").css("display","none");
        location.reload();
    }
    $("#sel_filtrar_fecha_cambio").val("No");
});
$("#sel_filtrar_fecha_cambio").on("change",function(){
    if($(this).val()=="Si"){
        $("#div_fechas_filtro_cambio_estado").css("display","");
    }else{
        $("#div_fechas_filtro_cambio_estado").css("display","none");
    }
});
    function selet_all_customers(elemento){
        
           
      
            //var localidad= $("#cmbLocalidades option:selected").val();
            var ciudad_ottis= $("#cmbCiudades option:selected").val();
            var nomenclatura= $("#nomenclatura option:selected").val();
            var numero1= $("#numero1").val();
            
            var adicionauno= $("#adicionauno option:selected").val();
            var numero2= $("#numero2").val();
            var adicional2= $("#adicional2 option:selected").val();
            var numero3= $("#numero3").val();
            var direccion = $("#sel_dir_personalizada option:selected").val();
            var sel_servicios = $("#sel_servicios option:selected").val();
            

            var ingreso_select=$("#fechas option:selected").val();
            var sdate=$("#sdate").val();
            var edate=$("#edate").val();
            var checked_ind_service =$("#check1").prop('checked');
            var check_usuarios_a_facturar=$("#check2").prop('checked');
            var check_sin_factura_actual=$("#sin_factura_actual").prop('checked');

             var estados_multiple=$("#estado_multiple").val();
            var localidad_multiple=$("#localidad_multiple").val();
            var barrios_multiple=$("#barrios_multiple").val();
            var deudores_multiple=$("#deudores_multiple").val();
            var tegnologia_multiple=$("#tegnologia_multiple").val();

            var ultimo_estado_sel=$("#ultimo_estado_sel option:selected").val();
            var sel_filtrar_fecha_cambio=$("#sel_filtrar_fecha_cambio option:selected").val();
            var sdate3=$("#sdate3").val();
            var edate2=$("#edate2").val();
            //14-09-2022
            var check_equipos_asignados=$("#filtro_equipo_asignado").prop('checked');//este cheq es para filtrar los usuarios con equipos asignados

            var url =baseurl+"clientgroup/get_filtrados_para_checked?id=<?=$_GET['id']?>&nomenclatura="+nomenclatura+"&numero1="+numero1+"&adicionauno="+adicionauno+"&numero2="+numero2+"&adicional2="+adicional2+"&numero3="+numero3+"&direccion="+direccion+"&sel_servicios="+sel_servicios+"&ingreso_select="+ingreso_select+"&sdate="+sdate+"&edate="+edate+"&checked_ind_service="+checked_ind_service+"&estados_multiple="+estados_multiple+"&localidad_multiple="+localidad_multiple+"&barrios_multiple="+barrios_multiple+"&deudores_multiple="+deudores_multiple+"&tegnologia_multiple="+tegnologia_multiple+"&ultimo_estado_sel="+ultimo_estado_sel+"&sel_filtrar_fecha_cambio="+sel_filtrar_fecha_cambio+"&sdate3="+sdate3+"&edate2="+edate2+"&check_usuarios_a_facturar="+check_usuarios_a_facturar+"&check_sin_factura_actual="+check_sin_factura_actual+"&check_equipos_asignados="+check_equipos_asignados+"&ciudad_ottis="+ciudad_ottis;
             if(elemento.checked==true){
                $("#div_notify3").html('<div id="notify3" class="alert alert-success" style="display:none;"><a href="#" class="close" data-dismiss="alert">&times;</a><div class="message3">></div></div>');
                    $("#notify3 .message3").html("<strong> Cargando</strong>: <img src='<?=base_url()?>/assets/img/iconocargando.gif'>");
                    $("#notify3").removeClass("alert-danger").removeClass("alert-success").addClass("alert-warning").fadeIn();
                    //$("html, body").animate({scrollTop: $('#notify3').offset().top}, 1000);

                $.post(url,{},function(data){
                    var puntos=1;
                    /*$(data).each(function(index,value){
                        var data1srt='{"id":'+(value.id)+',"celular":"'+(value.celular)+'"}';
                        var indice_elemento=lista_customers_sms.indexOf(data1srt);
                
                        if(indice_elemento==-1){
                            
                                lista_customers_sms.push(data1srt);
                        }

                    });*/
                    $("#div_notify3").html('<div id="notify3" class="alert alert-success" style="display:none;"><a href="#" class="close" data-dismiss="alert">&times;</a><div class="message3">></div></div>');
                   $("#notify3 .message3").html("<strong> Cargando</strong>: Usuarios Seleccionados...");
                    $("#notify3").removeClass("alert-danger").removeClass("alert-warning").addClass("alert-success").fadeIn();
                    $("html, body").animate({scrollTop: $('#notify3').offset().top}, 1000);
                    $(".clientes_para_enviar_sms").prop("checked",true);        
                },'json');

                
        }else{
            $(".clientes_para_enviar_sms").prop("checked",false); 
            lista_customers_sms=[];  
            $.post(baseurl+"clientgroup/deseleccionar_customers?id=<?=$_GET['id']?>",{},function(data){},'json');
        }
    }
    var tb;
    $(document).ready(function () {

        tb=$('#fclientstable').DataTable({

            "processing": true, //Feature control the processing indicator.
            "serverSide": true, //Feature control DataTables' server-side processing mode.
            "order": [], //Initial no order.

            // Load data for the table's content from an Ajax source
            "ajax": {
                "url": "<?php echo site_url('clientgroup/grouplist') . '?id=' . $group['id']; ?>",
                "type": "POST"
            },

            //Set column definition initialisation properties.
            "columnDefs": [
                {
                    "targets": [0], //first column / numbering column
                    "orderable": false, //set not orderable
                },
				
            ],	
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
		
    $("#select2_columnas").select2();
    /* configurando columnas por defecto*/
         $('#select2_columnas').val(['1','2','3','4','5','6','7','8','9','10','11','12','19','20']).trigger('change.select2');
            tb.columns([13,14,15,16,17,18]).visible(false);
            $('#select2_columnas').on('select2:select', function (e) { 
                var x1a=$('#fclientstable').width();
                //var d1=(x1a*9.5)/100;
                
                if($('#select2_columnas').val().length=="9"){
                    if(columnasUlEsAgregadas==true){
                        x1a+=300;
                    }
                        $('.div1').width(x1a+100);
                    $('.div2').width(x1a+100);
                }
                tb.column(e.params.data.id).visible(true);
            });
            $('#select2_columnas').on('select2:unselect', function (e) { 
                var x1a=$('#fclientstable').width();

                if($('#select2_columnas').val().length=="9"){
                    if(columnasUlEsAgregadas==true){
                        x1a-=300;
                    }
                        $('.div1').width(x1a-100);
                        $('.div2').width(x1a-100);
                }
                
               tb.column(e.params.data.id).visible(false);
            });
    /*end configurando columnas por defecto*/
    });
</script>
<div id="delete_model" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><?php echo $this->lang->line('Delete') ?> </h4>
            </div>
            <div class="modal-body">
                <p><?php echo $this->lang->line('delete this customer') ?> </p>
            </div>
            <div class="modal-footer">
                <input type="hidden" id="object-id" value="">
                <input type="hidden" id="action-url" value="customers/delete_i">
                <button type="button" data-dismiss="modal" class="btn btn-primary"
                        id="delete-confirm"><?php echo $this->lang->line('Delete') ?> </button>
                <button type="button" data-dismiss="modal"
                        class="btn"><?php echo $this->lang->line('Cancel') ?> </button>
            </div>
        </div>
    </div>
</div>
<div id="pop_model" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Selector SIIGO</h4>
            </div>

            <div class="modal-body">
                <form id="form_model">


                    <div class="row">
                        <div class="col-xs-12 mb-1"><label
                                    for="pmethod">Opciones de generacion</label>
                            <select name="proceso" class="form-control mb-1">
                                <option value="0">Seleccionar</option>
                                <option value="1">Limpiar seleccion</option>
                                <option value="2">Con impuesto y con Deuda</option>
                                <option value="3">Con impuesto y sin Deuda</option>
                                <option value="4">Sin impuesto y sin Deuda</option>
                                <option value="5">Sin impuesto y con Deuda</option>
                                <option value="6">Sin impuesto y con saldo a favor</option>
                            </select>

                        </div>
                    </div>

                    <div class="modal-footer">
                        <input type="hidden" class="form-control"
                               name="tid" id="invoiceid" value="<?php echo $invoice['tid'] ?>">
                        <button type="button" class="btn btn-default"
                                data-dismiss="modal"><?php echo $this->lang->line('Close'); ?></button>
                        <input type="hidden" id="action-url" value="clientgroup/update_siigo">
                        <button type="button" class="btn btn-primary"
                                id="submit_model">Realizar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div id="sendMail" class="modal fade">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"><?php echo $this->lang->line('Sms to group') ?> </h4>
            </div>

            <div class="modal-body" id="emailbody">
                <form id="sendmail_form">


                    <div class="row">
                        <div class="col-xs-12 mb-1"><label
                                    for="shortnote"><?php echo $this->lang->line('Group Name') ?> </label>
                            <input type="text" class="form-control"
                                   value="<?php echo $group['title'] ?>"></div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 mb-1"><label
                                    for="shortnote"><?php echo $this->lang->line('Subject') ?></label>
                            <input type="text" class="form-control"
                                   name="subject" id="subject">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 mb-1"><label
                                    for="plantillas">Plantillas</label>
                        <select id="plantillas" class="form-control">
                            <option value="">-</option>
                            <?php foreach ($plantillas as $key => $value) {
                                echo "<option value='".$value['other']."'>".$value['name']."</option>";
                            } ?>
                        </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 mb-1"><label
                                    for="number">numero de telefono</label>
                            <input type="text" class="form-control"
                                   name="number" id="number">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 mb-1"><label
                                    for="shortnote"><?php echo $this->lang->line('Message') ?></label>
                            <textarea name="text" class="summernote" id="contents" title="Contents"></textarea></div>
                    </div>

                    <input type="hidden" class="form-control"
                           name="gid" value="<?php echo $group['id'] ?>">
                    <input type="hidden" id="action-url" value="clientgroup/sendGroup">


                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default"
                        data-dismiss="modal"><?php echo $this->lang->line('Close') ?> </button>
                <button type="button" class="btn btn-primary"
                        id="sendNow"><?php echo $this->lang->line('Send') ?> </button>
            </div>
        </div>
    </div>
</div>
<div id="sendSms" class="modal fade">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"><?php echo $this->lang->line('Sms to group') ?> </h4>
            </div>

            <div class="modal-body" id="emailbody">
                <form id="sendSMS_form">
<div id="div_notify2">
<div id="notify2" class="alert alert-success" style="display:none;">
            <a href="#" class="close" data-dismiss="alert">&times;</a>

            <div class="message2"></div>
        </div>
</div>
<div id="div_notify4">

</div>
                    
                    <div class="row">
                        <div class="col-xs-12 mb-1"><label
                                    for="plantillas">Plantillas</label>
                        <select id="plantillas2" name="plantillas2" class="form-control" onchange="cargar_plantilla()">
                            <option value="">-</option>
                            
                            <?php foreach ($plantillas as $key => $value) {
                                echo "<option value='".$value['id']."' data-texto='".$value['other']."'>".$value['name']."</option>";
                            } ?>
                        </select>
                        </div>
                    </div>
                    <div class="row" >
                        <div class="col-xs-12 mb-1"><label
                                    for="number">Nombre Campaña</label>
                            <input type="text" class="form-control"
                                   name="name_campaign" id="name_campaign" maxlength="10" minlength="10" >
                        </div>
                    </div>
                    <div class="row" id="div_numero_individual">
                        <div class="col-xs-12 mb-1"><label
                                    for="number">Numero de telefono individual</label>
                            <input type="text" class="form-control"
                                   name="number2" id="number2" maxlength="10" minlength="10" >
                        </div>
                    </div>
                    <div class="row" id="div_envio_masivo">
                        <div class="col-xs-12 mb-1"><label
                                    for="number">Numeros envio masivo</label>
                            <input type="text" class="form-control" readonly="true" 
                                   name="numerosMasivos" id="numerosMasivo" minlength="10" >
                                   <input type="text" class="form-control" hidden="true" 
                                   name="ultimo_lote" id="ultimo_lote"  >
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 mb-1"><label
                                    for="shortnote"><?php echo $this->lang->line('Message') ?></label>
                            <textarea name="text2" class="form-control" maxlength="250" id="contents2" title="Contents"></textarea></div>
                    </div>
                    <div align="center"><input type="button" class="btn btn-danger" value="Detener Envio de Mensajes" onclick="cancelar_envio_mensajes();"></div>
					<div class="row">
                        <div class="col-xs-12 mb-1"><label
                                    for="shortnote">Personalizar</label><br>
                            <span>1er Nombre = {primer_nombre}</span><br>
							<span>2do Nombre = {segundo_nombre}</span><br>
							<span>1er Apellido = {primer_apellido}</span><br>
							<span>2do Apellido = {segundo_apellido}</span><br>
							<span>Saldo = {monto_debe}</span><br>
                            <span>Documento = {documento}</span><br>
                            <span>Mes Actual = {mes_actual}</span><br>
						</div>
                    </div>
                    <input type="hidden" class="form-control"
                           name="gid" value="<?php echo $group['id'] ?>">
                    <input type="hidden" id="action-urlSMS" value="clientgroup/sendGroupSms">


                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default"
                        data-dismiss="modal"><?php echo $this->lang->line('Close') ?> </button>
                <button type="button" class="btn btn-primary"
                        id="sendNow2" onclick="enviar_SMS()"><?php echo $this->lang->line('Send') ?> </button>
            </div>
        </div>
    </div>
</div>

<div id="modal_corte_multiple_usuarios" class="modal fade">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"><?php echo $this->lang->line('Sms to group') ?> </h4>
            </div>

            <div class="modal-body" id="emailbody">
                <form id="corte-users_form">

<div id="div_notify5">

</div>
                    
                    <div class="row">
                        <div class="col-xs-12 mb-1"><label
                                    for="plantillas">Tipo de Corte</label>
                        <select id="tipo_corte" name="tipo_corte" class="form-control" onchange="cargar_plantilla()">
                            <option value="">-</option>
                            <option value="Corte Internet">Corte Internet</option>
                            <option value="Corte Television">Corte Television</option>
                            <option value="Corte Combo">Corte Combo</option>
                            
                        </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 mb-1">
                            
                            <div style="text-align: center;"><label
                                    for="plantillas"><i> <b> Generar Solo Ordenes de Corte en Estado Pendiente</b></i></label></div>
                                    <br><div style="text-align:center;"> <input type="checkbox" style="transform: scale(4);" name="tiket_en_pendiente" id="tiket_en_pendiente"></div>
                        
                        </div>
                    </div>
                    
                    <div class="row" id="div_envio_masivo">
                        <div class="col-xs-12 mb-1"><label
                                    for="number">Customers</label>
                            <input type="text" class="form-control" readonly="true" 
                                   name="ids_customers_corte" id="ids_customers_corte" >
                                   
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 mb-1"><label
                                    for="shortnote"><?php echo $this->lang->line('Message') ?></label>
                            <textarea name="description_corte" class="form-control"  id="description_corte" title="Descripcion Corte"></textarea></div>
                    </div>
                    
                    <input type="hidden" class="form-control"
                           name="gid" value="<?php echo $group['id'] ?>">
                    <input type="hidden" id="action-url-cortes" value="clientgroup/cortar_usuarios_multiple">


                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default"
                        data-dismiss="modal"><?php echo $this->lang->line('Close') ?> </button>
                <button type="button" class="btn btn-primary"
                        id="sendNow4" onclick="realizar_corte_usuarios()">Realizar Corte de Usuarios </button>
            </div>
        </div>
    </div>
</div>

<div id="alert_modal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Facturacion Electronica Usuario</h4>
            </div>

            <div class="modal-body" id="body_modal">
               <div class="form-group row">

                    <label class="col-sm-3 control-label"
                           for="sdate2">Servicios</label>
                    <div  class="col-sm-9">
                    <select id="servicios" onchange="al_cambiar_de_servicio();" name="servicios" class="form-control">                        
                        <option value="Television">Television</option>                        
                        <option value="Internet">Internet</option>
                        <option value="Combo">Combo</option>                        
                    </select>
                    </div>
                </div>
                
                
                    <div class="form-group row" id="div_de_puntos">

                        <label class="col-sm-3 control-label"
                               for="sdate2">Puntos</label>
                        <div  class="col-sm-9">
                        <select id="puntos" name="puntos" class="form-control">
                            <option value="no">No</option>
                            <option value="si">Si</option>
                        </select>
                        <br>
                        <div id="div_cuantos_puntos_tiene" style="text-align: center;"><h4><b><i id="i_puntos">Tiene X Puntos</i><b></h4></div>
                        </div>
                    </div>
                
            
            </div>
            <div class="modal-footer">
                <button  class="btn btn-success" onclick="guardar_sl_fac_electronica()">Guardar</button>
                <button type="button" class="btn btn-default"
                        data-dismiss="modal"><?php echo $this->lang->line('Close') ?> </button>
                
            </div>
        </div>
    </div>
</div>
<div id="modal_process_emails" class="modal fade">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Progreso del Proceso</h4>
            </div>
            
            <div class="modal-body" >
                 <p>Progreso recorrido usuarios</p>
                        <div id="progress" data-init="true"></div>
                        <div style="margin-top: -25px;"><span id="span_progress1">0/0</span></div>
                        <br>
                        <div id="pro2">
                        <p class="progressfg">Progreso proceso en ejecucion</p>
                        <div id="progressfg" class="progressfg" data-init="true"></div>
                        </div>
                 <hr>
                <label
                                    for="number">Customers</label>
                            <input type="text" class="form-control" readonly="true" 
                                   name="ids_customers_email" id="ids_customers_email" >
                <label
                                    for="number">Mensaje</label>
                            <textarea class="form-control" id="mensaje_email" name="mensaje_email"><?=$mensaje_correos ?></textarea>                   
                        
                 
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default"
                        data-dismiss="modal"><?php echo $this->lang->line('Close') ?></button>
                
            </div>
            
        </div>
    </div>
</div>
<script type="text/javascript">
    $(function () {
    $('.wrapper1').on('scroll', function (e) {
        $('.wrapper2').scrollLeft($('.wrapper1').scrollLeft());
    }); 
    $('.wrapper2').on('scroll', function (e) {
        $('.wrapper1').scrollLeft($('.wrapper2').scrollLeft());
    });
});
    var aumento=250;
$(window).on('load', function (e) {
     var x1a=$('#fclientstable').width();
    //var d1=(x1a*9.5)/100;
    $('.div1').width(x1a+aumento);
    $('.div2').width(x1a+aumento);
}); 
</script>
<script type="text/javascript">
    
    function  filtrado_fechas(){
        var opcion_seleccionada=$("#fechas option:selected").val();

        $("#sdate").parent().css("display","");
        if(opcion_seleccionada=="fecha_ingreso"){
            $("#label_fechas7").text("De los ingresos");
            $("#div_fechas").show();
            
        }else if(opcion_seleccionada=="fecha_contrato"){
            $("#label_fechas7").text("Fecha del contrato");
            $("#div_fechas").show();
            
        }else if(opcion_seleccionada=="1_despues_contrato"){
            $("#label_fechas7").text("1 Año despues del Contrato");
            $("#div_fechas").show();
        }else if(opcion_seleccionada=="desde_siempre_a_fecha"){
            $("#label_fechas7").text("Fecha Contrato Hasta");
            $("#sdate").parent().css("display","none");
            $("#div_fechas").show();
        }else{
            $("#div_fechas").hide();
        }
    }
    function cargar_plantilla(){
        var text=$("#plantillas2 option:selected").data("texto");
        
        if($("#plantillas2 option:selected").val()=="38"){
            $("#contents2").attr("maxlength",250);
        }else{
            $("#contents2").attr("maxlength",250);
        }
        
        $("#contents2").val(text);
    }
   

    var columnasAgregadas=false;
    function nuevas_columnas(){
        if(!columnasAgregadas){
              tb.destroy();
               var ultimo_estado_sel=$("#ultimo_estado_sel option:selected").val();
             if(ultimo_estado_sel=="No" || columnasUlEsAgregadas==false){
               /*$("#despues_de_thead").after("<th class='cols_adicionadas'>Ingreso</th>");
              $("#despues_de_tfoot").after("<th class='cols_adicionadas'>Ingreso</th>");
              $("#despues_de_thead").after("<th class='cols_adicionadas'>Suscripcion</th>");
              $("#despues_de_tfoot").after("<th class='cols_adicionadas'>Suscripcion</th>");
              $("#despues_de_thead").after("<th class='cols_adicionadas'>Deuda</th>");
              $("#despues_de_tfoot").after("<th class='cols_adicionadas'>Deuda</th>");*/
                $('#select2_columnas').val(['1','2','3','4','5','6','7','8','9','10','11','12','13','14','15','19','20']).trigger('change.select2');

              columnasUlEsAgregadas=true;
              var x1a=$('#fclientstable').width();
                //var d1=(x1a*9.5)/100;
                $('.div1').width(x1a-500);
                $('.div2').width(x1a-500);
            }
            if(ultimo_estado_sel=="Si"){
                    /*$("#despues_de_thead").after("<th class='cols_adicionadas'>Ult. Estado</th>");
                    $("#despues_de_tfoot").after("<th class='cols_adicionadas'>Ult. Estado</th>");
                    $("#despues_de_thead").after("<th class='cols_adicionadas'>Fecha Cambio</th>");
                    $("#despues_de_tfoot").after("<th class='cols_adicionadas'>Fecha Cambio</th>");*/
                
                   var x1a=$('#fclientstable').width();
                    //var d1=(x1a*9.5)/100;
                    $('.div1').width(x1a-500);
                    $('.div2').width(x1a-500);

              }
              var ingreso_select=$("#fechas option:selected").val();
              
  if(ingreso_select!=""){
    
                    /*$(".settings_th").before("<th class='cols_adicionadas_contrato'>Fecha Contrato</th>");*/
                    $('.div1').width(x1a-500);
                    $('.div2').width(x1a-500);
  }         
      
                //var localidad= $("#cmbLocalidades option:selected").val();
                var ciudad_ottis= $("#cmbCiudades option:selected").val();
                var nomenclatura= $("#nomenclatura option:selected").val();
                var numero1= $("#numero1").val();
                
                var adicionauno= $("#adicionauno option:selected").val();
                var numero2= $("#numero2").val();
                var adicional2= $("#adicional2 option:selected").val();
                var numero3= $("#numero3").val();
                var direccion = $("#sel_dir_personalizada option:selected").val();
                var sel_servicios = $("#sel_servicios option:selected").val();

                
                var sdate=$("#sdate").val();
                var edate=$("#edate").val();
                var checked_ind_service =$("#check1").prop('checked');
                var check_usuarios_a_facturar=$("#check2").prop('checked');
                var check_sin_factura_actual=$("#sin_factura_actual").prop('checked');

                 var estados_multiple=$("#estado_multiple").val();
            var localidad_multiple=$("#localidad_multiple").val();
            var barrios_multiple=$("#barrios_multiple").val();
            var deudores_multiple=$("#deudores_multiple").val();
            var tegnologia_multiple=$("#tegnologia_multiple").val();


            var sel_filtrar_fecha_cambio=$("#sel_filtrar_fecha_cambio option:selected").val();
            var sdate3=$("#sdate3").val();
            var edate2=$("#edate2").val();

            var check_equipos_asignados=$("#filtro_equipo_asignado").prop('checked');//este cheq es para filtrar los usuarios con equipos asignados

              tb=$('#fclientstable').DataTable({

                "processing": true, //Feature control the processing indicator.
                "serverSide": true, //Feature control DataTables' server-side processing mode.
                "order": [], //Initial no order.

                // Load data for the table's content from an Ajax source
                "ajax": {
                    "url": "<?php echo site_url('clientgroup/load_morosos') . '?id=' . $group['id']; ?>&nomenclatura="+nomenclatura+"&numero1="+numero1+"&adicionauno="+adicionauno+"&numero2="+numero2+"&adicional2="+adicional2+"&numero3="+numero3+"&direccion="+direccion+"&sel_servicios="+sel_servicios+"&ingreso_select="+ingreso_select+"&sdate="+sdate+"&edate="+edate+"&pagination_start="+pagination_start+"&pagination_end="+pagination_end+"&checked_ind_service="+checked_ind_service+"&check_usuarios_a_facturar="+check_usuarios_a_facturar+"&estados_multiple="+estados_multiple+"&localidad_multiple="+localidad_multiple+"&barrios_multiple="+barrios_multiple+"&deudores_multiple="+deudores_multiple+"&tegnologia_multiple="+tegnologia_multiple+"&ultimo_estado_sel="+ultimo_estado_sel+"&sel_filtrar_fecha_cambio="+sel_filtrar_fecha_cambio+"&sdate3="+sdate3+"&edate2="+edate2+"&check_sin_factura_actual="+check_sin_factura_actual+"&check_equipos_asignados="+check_equipos_asignados+"&ciudad_ottis="+ciudad_ottis,
                    "type": "POST",
                    error: function (xhr, error, code)
                    {
                        
                    }
                },

                //Set column definition initialisation properties.
                "columnDefs": [
                    {
                        "targets": [0], //first column / numbering column
                        "orderable": false, //set not orderable
                    },
                    
                ],  
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
              if(ultimo_estado_sel=="No" || columnasUlEsAgregadas==false){
                $('#select2_columnas').val(['1','2','3','4','5','6','7','8','9','10','11','12','13','14','15','19','20']).trigger('change.select2');
                    tb.columns([16,17,18]).visible(false);          
                    if(ingreso_select!=""){
                        $('#select2_columnas').val(['1','2','3','4','5','6','7','8','9','10','11','12','13','14','15','18','19','20']).trigger('change.select2');
                            tb.columns([18]).visible(true);               
                    }
              }

              if(ultimo_estado_sel=="Si" && ingreso_select==""){
                $('#select2_columnas').val(['1','2','3','4','5','6','7','8','9','10','11','12','13','14','15','16','17','19','20']).trigger('change.select2');
                    tb.columns([18]).visible(false);           
              }
              columnasAgregadas=true;
      }
      
    }

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

        $('form').on('submit', function (e) {
            e.preventDefault();
            alert($('.summernote').summernote('code'));
            alert($('.summernote').val());
        });

        
    });
    var pagination_start="";
    var pagination_end="";
     
	function filtrar(){
       // tb.columns([12]).sortable(false);

           
           
      
            //var localidad= $("#cmbLocalidades option:selected").val();
            var ciudad_ottis= $("#cmbCiudades option:selected").val();
            var nomenclatura= $("#nomenclatura option:selected").val();
            var numero1= $("#numero1").val();
            
            var adicionauno= $("#adicionauno option:selected").val();
            var numero2= $("#numero2").val();
            var adicional2= $("#adicional2 option:selected").val();
            var numero3= $("#numero3").val();
            var direccion = $("#sel_dir_personalizada option:selected").val();
            var sel_servicios = $("#sel_servicios option:selected").val();
            

            var ingreso_select=$("#fechas option:selected").val();
            var sdate=$("#sdate").val();
            var edate=$("#edate").val();
            var checked_ind_service =$("#check1").prop('checked');
            var check_usuarios_a_facturar=$("#check2").prop('checked');
            var check_sin_factura_actual=$("#sin_factura_actual").prop('checked');
            
            var estados_multiple=$("#estado_multiple").val();
            var localidad_multiple=$("#localidad_multiple").val();
            var barrios_multiple=$("#barrios_multiple").val();
            var deudores_multiple=$("#deudores_multiple").val();
            var tegnologia_multiple=$("#tegnologia_multiple").val();
                //color:blue;font-weight:900
            
            var ultimo_estado_sel=$("#ultimo_estado_sel option:selected").val();
            var sel_filtrar_fecha_cambio=$("#sel_filtrar_fecha_cambio option:selected").val();
            var sdate3=$("#sdate3").val();
            var edate2=$("#edate2").val();
            
            var check_equipos_asignados=$("#filtro_equipo_asignado").prop('checked');//este cheq es para filtrar los usuarios con equipos asignados   

             
            //if(morosos!=""){
                if(columnasAgregadas){ tb.order([]);
                    tb.ajax.url( baseurl+"clientgroup/load_morosos?id=<?=$_GET['id']?>&nomenclatura="+nomenclatura+"&numero1="+numero1+"&adicionauno="+adicionauno+"&numero2="+numero2+"&adicional2="+adicional2+"&numero3="+numero3+"&direccion="+direccion+"&sel_servicios="+sel_servicios+"&ingreso_select="+ingreso_select+"&sdate="+sdate+"&edate="+edate+"&checked_ind_service="+checked_ind_service+"&check_usuarios_a_facturar="+check_usuarios_a_facturar+"&estados_multiple="+estados_multiple+"&localidad_multiple="+localidad_multiple+"&barrios_multiple="+barrios_multiple+"&deudores_multiple="+deudores_multiple+"&tegnologia_multiple="+tegnologia_multiple+"&ultimo_estado_sel="+ultimo_estado_sel+"&sel_filtrar_fecha_cambio="+sel_filtrar_fecha_cambio+"&sdate3="+sdate3+"&edate2="+edate2+"&check_sin_factura_actual="+check_sin_factura_actual+"&check_equipos_asignados="+check_equipos_asignados+"&ciudad_ottis="+ciudad_ottis).load();               
                    $('#select2_columnas').val(['1','2','3','4','5','6','7','8','9','10','11','12','13','14','15','16','17','18','19','20']).trigger('change.select2');
                    if(ultimo_estado_sel=="No"){
                $('#select2_columnas').val(['1','2','3','4','5','6','7','8','9','10','11','12','13','14','15','19','20']).trigger('change.select2');
                    tb.columns([16,17,18]).visible(false);          
                    if(ingreso_select!=""){
                        $('#select2_columnas').val(['1','2','3','4','5','6','7','8','9','10','11','12','13','14','15','18','19','20']).trigger('change.select2');
                            tb.columns([17]).visible(true);               
                    }
              }else{
                    if(ingreso_select!=""){
                        $('#select2_columnas').val(['1','2','3','4','5','6','7','8','9','10','11','12','13','14','15','16','17','18','19','20']).trigger('change.select2');
                            tb.columns([18]).visible(true);               
                    }
              }

              if(ultimo_estado_sel=="Si" && ingreso_select==""){
                $('#select2_columnas').val(['1','2','3','4','5','6','7','8','9','10','11','12','13','14','15','16','17','19','20']).trigger('change.select2');
                    tb.columns([18]).visible(false);           
              }
                }else{
                    nuevas_columnas();
                    $("option[value=100]").text("Todo");
                }

           /* }else{
                tb.ajax.url( baseurl+'clientgroup/grouplist?estado='+estado+"&id=<?=$_GET['id']?>&localidad="+localidad+"&barrio="+barrio+"&nomenclatura="+nomenclatura+"&numero1="+numero1+"&adicionauno="+adicionauno+"&numero2="+numero2+"&adicional2="+adicional2+"&numero3="+numero3+"&direccion="+direccion+"&sel_servicios="+sel_servicios).load();         
            }*/
            
        
       

    }
 
 function reestablecer_seleciones(){
    lista_customers_sms=[];
    lista_customers_sms_aux=[];
 }
    function redirect_to_export(){
         
           
      
            //var localidad= $("#cmbLocalidades option:selected").val();
            var ciudad_ottis= $("#cmbCiudades option:selected").val();
            var nomenclatura= $("#nomenclatura option:selected").val();
            var numero1= $("#numero1").val();
            
            var adicionauno= $("#adicionauno option:selected").val();
            var numero2= $("#numero2").val();
            var adicional2= $("#adicional2 option:selected").val();
            var numero3= $("#numero3").val();
            var direccion = $("#sel_dir_personalizada option:selected").val();
            var sel_servicios = $("#sel_servicios option:selected").val();
            

            var ingreso_select=$("#fechas option:selected").val();
            var sdate=$("#sdate").val();
            var edate=$("#edate").val();
            var checked_ind_service =$("#check1").prop('checked');
            var check_usuarios_a_facturar=$("#check2").prop('checked');
            var check_sin_factura_actual=$("#sin_factura_actual").prop('checked');
            var check_agregar_ultima_transaccion=$("#agregar_ultima_transaccion").prop('checked');

            var estados_multiple=$("#estado_multiple").val();
            var localidad_multiple=$("#localidad_multiple").val();
            var barrios_multiple=$("#barrios_multiple").val();
            var deudores_multiple=$("#deudores_multiple").val();
            var tegnologia_multiple=$("#tegnologia_multiple").val();

            var ultimo_estado_sel=$("#ultimo_estado_sel option:selected").val();
            var sel_filtrar_fecha_cambio=$("#sel_filtrar_fecha_cambio option:selected").val();
            var sdate3=$("#sdate3").val();
            var edate2=$("#edate2").val();

            var check_equipos_asignados=$("#filtro_equipo_asignado").prop('checked');//este cheq es para filtrar los usuarios con equipos asignados

            var url_redirect=baseurl+"clientgroup/explortar_a_excel?id=<?=$_GET['id']?>&nomenclatura="+nomenclatura+"&numero1="+numero1+"&adicionauno="+adicionauno+"&numero2="+numero2+"&adicional2="+adicional2+"&numero3="+numero3+"&direccion="+direccion+"&sel_servicios="+sel_servicios+"&ingreso_select="+ingreso_select+"&sdate="+sdate+"&edate="+edate+"&checked_ind_service="+checked_ind_service+"&check_usuarios_a_facturar="+check_usuarios_a_facturar+"&estados_multiple="+estados_multiple+"&localidad_multiple="+localidad_multiple+"&barrios_multiple="+barrios_multiple+"&deudores_multiple="+deudores_multiple+"&tegnologia_multiple="+tegnologia_multiple+"&ultimo_estado_sel="+ultimo_estado_sel+"&sel_filtrar_fecha_cambio="+sel_filtrar_fecha_cambio+"&sdate3="+sdate3+"&edate2="+edate2+"&check_sin_factura_actual="+check_sin_factura_actual+"&check_agregar_ultima_transaccion="+check_agregar_ultima_transaccion+"&check_equipos_asignados="+check_equipos_asignados+"&ciudad_ottis="+ciudad_ottis;
            window.location.replace(url_redirect);

    }
    $("#div_direccion_personalizada").hide();
    function act_sel_dir_personalizada(){
        var sel_dir_personalizada= $("#sel_dir_personalizada option:selected").val();
        if(sel_dir_personalizada==""){
            $("#div_direccion_personalizada").hide();
        }else{
            $("#div_direccion_personalizada").show();
        }
    }





    /* codigo envio de email*/
    function abrir_modal_envio_email(e){
        e.preventDefault();
        var lista_cadena="";
        reestablecer_seleciones();
        $.post(baseurl+"clientgroup/get_seleccionados_sms_y_cortar?id=<?=$_GET['id']?>",{},function(data){

            $(data).each(function(index,value){
                console.log(value);
                var data1srt='{"id":'+(value.id)+',"celular":"'+(value.celular)+'"}';
                        lista_customers_sms.push(data1srt);

                if(lista_cadena!=""){
                    lista_cadena=lista_cadena+","+value.id;    
                }else{
                    lista_cadena=value.id;    
                }

             });
datos_recorrer=data;
            

    
        $("#ids_customers_email").val(lista_cadena);
        //$("#div_notify5").html("");

organiza_datos_para_iniciar();
            //$("#modal_process_emails").modal("show");

        },'json');
    }
   
    $('#progress').LineProgressbar({
        percentage: 0,
        animation: true,
        fillBackgroundColor: '#1abc9c',
        height: '25px',
        radius: '10px'
    });
    $('#progressfg').LineProgressbar({
        percentage: 0,
        animation: true
    });

    //codigo de interaccion progress
    function progress_one(valorx){
             $('#progressfg').LineProgressbar({
                        percentage: valorx,
                        animation: true
                    });
    }
    
    
    var id_file;
    var xhr;
    var datos_recorrer;
    var i=0;
    var totalem=0;
    var total_a_facturar=0;
    var va_en=0;
var proceso_iniciado=false;
function organiza_datos_para_iniciar(){
    //$(document).on("click",'.cl-play-process',function(ev){
        //ev.preventDefault();
        
        //$(this).attr("disabled","true");
        $("#modal_process_emails").modal("show");
         //id_file=$(this).data("id-file");
        if(!proceso_iniciado){proceso_iniciado =true;

             progress_one(40);
            //$.post(baseurl+"transactions/obtener_lista_usuarios_a_facturar",{'id_file':id_file},function(data){
                progress_one(90);
                //datos_recorrer=lista_customers_sms;
                totalem=datos_recorrer.length;
                total_a_facturar= parseInt( totalem);
               va_en =parseInt(total_a_facturar-datos_recorrer.length);
                $("#span_progress1").text(va_en+"/"+total_a_facturar);

                iniciar_facturacion();
                
            //},'json');
        }

    //});
    }
    
    var errores=0;
    var texto_msj_correo="<?=$mensaje_correos ?>";
function iniciar_facturacion(){
        var pay_acc="x";
        var sdate="y";
        progress_one(10);
        if(i<parseInt(totalem)){
            var id_customer=datos_recorrer[i].id;

             //var num1=va_en+1;
             va_en++;
                var porcentaje=parseInt((va_en*100)/parseInt(total_a_facturar));
                //console.log(va_en+"-"+va_en+"-"+total+"-"+porcentaje);
                $('#progress').LineProgressbar({
                    percentage: porcentaje,
                    animation: false,
                    fillBackgroundColor: '#1abc9c',
                    height: '25px',
                    radius: '10px'
                });  
                
                    $("#span_progress1").text(va_en+"/"+total_a_facturar);
                    progress_one(40);
            $.post(baseurl+"clientgroup/procesar_usuarios_a_enviar_correo",{'id':id_customer,'texto':texto_msj_correo},function(data){


                    //if(data.estado=="procesado" || data.estado=="procesado 2"){
                        console.log(data.estado);
                        i++;
                        progress_one(100);
                        iniciar_facturacion();
                        //recargar_tb_results();
                    //}

                    
            },'json').fail(function(xhr, status, error) {
                if(errores>5){
                    i++;
                    errores=0;
                }else{
                    va_en--;    
                }
                
                console.log("ubo un error");
                iniciar_facturacion();
            });
        }else{
//recargar_tb_results();
//finalizar_registro_file();
            alert("Proceso Finalizado");
            
            $('.progressfg').remove();
            $("#pro2").append(' <p class="progressfg">Progreso proceso en ejecucion</p><div id="progressfg" class="progressfg" data-init="true"></div>');
            $("#pro2").hide();
             progress_one(100);
            
        }
}
    //end para envio email





    function abrir_modal_corte_usuarios(e){
        e.preventDefault();
        var lista_cadena="";
        reestablecer_seleciones();
        $.post(baseurl+"clientgroup/get_seleccionados_sms_y_cortar?id=<?=$_GET['id']?>",{},function(data){

            $(data).each(function(index,value){
                console.log(value);
                var data1srt='{"id":'+(value.id)+',"celular":"'+(value.celular)+'"}';
                        lista_customers_sms.push(data1srt);

                if(lista_cadena!=""){
                    lista_cadena=lista_cadena+","+value.id;    
                }else{
                    lista_cadena=value.id;    
                }

             });

            

    
        $("#ids_customers_corte").val(lista_cadena);
        $("#div_notify5").html("");


            $("#modal_corte_multiple_usuarios").modal("show");

        },'json');

        
    }
    function realizar_corte_usuarios(){
        $("#div_notify5").append('<div id="notify_5" class="alert alert-warning" style="display:none;"><a href="#" class="close" data-dismiss="alert">&times;</a><div class="message_5"></div></div>');        
        $("#notify_5 .message_5").html("Relizando Cortes</strong>: <img src='"+baseurl+"/assets/img/iconocargando.gif'>");
                    $("#notify_5").fadeIn();
                    $("html, body").animate({scrollTop: $('#notify_5').offset().top}, 1000);

        var o_data =  $("#corte-users_form").serialize();
        var action_url= $('#action-url-cortes').val();


        send_corte_multiple_form(o_data,action_url);
    }

    //seleccion multiple
    /*var f =1000;
    var y=f/500;
    if(y % 1==0){

        console.log(parseInt(y)+" lotes");
    }else{
        console.log(parseInt(y)+" +1 lotes");
    }*/
 function enviar_SMS(){
        //$("#div_notify2").html('<div id="notify2" class="alert alert-success" ><a href="#" class="close" data-dismiss="alert">&times;</a><div class="message2"></div></div>');
        /*$("#div_notify3").html('<div id="notify_1" class="alert alert-warning" style="display:none;"><a href="#" class="close" data-dismiss="alert">&times;</a><div class="message_1"></div></div>');        
        $("#notify_1 .message_1").html("<strong> Enviando Lote 1 de "+n_lotes_customers+"</strong>: <img src='<?=base_url()?>/assets/img/iconocargando.gif'>");
                    $("#notify_1").fadeIn();
                    $("html, body").animate({scrollTop: $('#notify_1').offset().top}, 1000);*/

        $("#div_notify4").append('<div id="notify_'+n_lote_actual_customers+'" class="alert alert-warning" style="display:none;"><a href="#" class="close" data-dismiss="alert">&times;</a><div class="message_'+n_lote_actual_customers+'"></div></div>');        
        $("#notify_"+n_lote_actual_customers+" .message_"+n_lote_actual_customers).html("<strong> Enviando Lote "+n_lote_actual_customers+" de "+n_lotes_customers+"</strong>: <img src='"+baseurl+"/assets/img/iconocargando.gif'>");
                    $("#notify_"+n_lote_actual_customers).fadeIn();
                    $("html, body").animate({scrollTop: $('#notify_'+n_lote_actual_customers).offset().top}, 1000);
if(n_lote_actual_customers<n_lotes_customers){
    $("#ultimo_lote").val("no");
}else{
    $("#ultimo_lote").val("si");
}

         var o_data =  $("#sendSMS_form").serialize();
        var action_url= $('#action-urlSMS').val();

        $.cookie("cancelar_envio_mensajes", "false");
        sendMail_g(o_data,action_url);
}
    var n_lotes_customers=1;
    var n_lote_actual_customers=1;
    let lista_customers_sms_aux=[];
    var x=0;
    var y=0;
function abrir_modal_sms(e){
    
    e.preventDefault();
    //console.log(lista_customers_sms[0]);
    n_lotes_customers=1;
    n_lote_actual_customers=1;
    //console.log(lista_customers_sms.length);
    
    reestablecer_seleciones();
        $.post(baseurl+"clientgroup/get_seleccionados_sms_y_cortar?id=<?=$_GET['id']?>",{},function(data){
            
            $(data).each(function(index,value){
                console.log(value);
                var data1srt='{"id":'+(value.id)+',"celular":"'+(value.celular)+'"}';
                        lista_customers_sms.push(data1srt);

               

             });

            if(lista_customers_sms.length>500){
                var x= lista_customers_sms.length/500;
                if(x % 1==0){
                    n_lotes_customers=parseInt(x);
                }else{
                    n_lotes_customers=parseInt(x)+1;
                }
                lista_customers_sms_aux=lista_customers_sms;
              //saber cuantas veces voy a segmentar la lista, n_lotes_customers;
              //en que segmentacion esta, n_lote_actual_customers;
              //de que indice a que indice escojer segun la segmentacion, x, y;
              n_lote_actual_customers=1;
              x=0;
              y=499;
              lista_customers_sms=lista_customers_sms.slice(x,y);

            }
            //console.log(lista_customers_sms.length);
            $("#sendSms").modal("show");
            var lista_cadena="";
            $(lista_customers_sms).each(function(index,value){
                value=JSON.parse(value);
                if(lista_cadena!=""){
                    lista_cadena=lista_cadena+","+value.id+"-"+value.celular;    
                }else{
                    lista_cadena=value.id+"-"+value.celular;    
                }
                
            });

            if(lista_cadena==""){
                $("#div_envio_masivo").hide();
                $("#div_numero_individual").show();
            }else{
                $("#div_envio_masivo").show();
                $("#div_numero_individual").hide();
            }
            $("#numerosMasivo").val(lista_cadena);
            $("#div_notify4").html("");

    
        

        },'json');

    
}
    let lista_customers_sms=[];
 function agregar_customer_envio_sms(elemento){
        var data1srt='{"id":'+$(elemento).data("id-customer")+',"celular":"'+$(elemento).data("celular")+'"}';
        var indice_elemento=lista_customers_sms.indexOf(data1srt);
        
        if(indice_elemento==-1){
                if(elemento.checked==true){
                    lista_customers_sms.push(data1srt);                   
                }
        }else{
            if(elemento.checked==false){
                lista_customers_sms.splice(indice_elemento,1);
            }
        }

           var id=$(elemento).data("id-customer");
            $.post(baseurl+"clientgroup/activar_desactivar_usuario",{'id':id,'selected':elemento.checked},function(data){
                    console.log(data);
            },'json');
      /* var y="";
        $(lista_customers_sms).each(function(index){
            if(y==""){
                y=this;
            }else{
                y+=","+this;
            }
        });
        if(y==""){
            $("#span_facturas").hide();
        }else{
            $("#span_facturas").text(" Orden Facturas a Pagar : "+y);
            $("#span_facturas").show();
            $("#in_shortnote").val("Pago de la factura #"+y);
        }*/
        
    }
    
$("#fclientstable").on('draw.dt',function (){
        $(lista_customers_sms).each(function(index,value){
           value= JSON.parse(value);
            var checked_seleccionado=document.getElementById("input_"+value.id);            
            try{
                if(checked_seleccionado.checked==false){
                        console.log("si esta imprimiendo todo esta bien Gloria Al Dios Altisimo Jesus de Nazaret.");
                        $(checked_seleccionado).prop("checked",true);

                }
            }catch(error){

            }
            
        });

    });
    //end seleccion multiple

   
   /* var localidad_Yopal = new Array ("-","ComunaI","ComunaII","ComunaIII","ComunaIV","ComunaV","ComunaVI","ComunaVII");
    var localidad_Monterrey = new Array ("-","Ninguno");
    var localidad_Villanueva = new Array ("-","SinLocalidad");
    var localidad_Mocoa = new Array ("-","Ninguna");
     //cambia4();
                            //crear funcion que ejecute el cambio
                            function cambia4(){
                                var ciudad;
                                ciudad = $("#cmbCiudades option:selected").val();
                                //se verifica la seleccion dada
                                
                                $("#localidad_multiple").find('option').remove().end();
                                if(ciudad!=0 && ciudad!="-"){
                                    mis_opts=eval("localidad_"+ciudad);
                                    $("#cmbLocalidades").find('option').remove().end();
                                    $("#localidad_multiple").find('option').remove().end();
                                    for (var i = 0; i < mis_opts.length; i++) {
                                        $('#cmbLocalidades').append(new Option(mis_opts[i], mis_opts[i]));                                           
                                           if(mis_opts[i]!="-"){
                                                $('#localidad_multiple').append(new Option(mis_opts[i], mis_opts[i]));
                                           }
                                        
                                    }
                                    
                                }else{
                                    $("#cmbLocalidades").find('option').remove().end();
                                    $('#cmbLocalidades').append(new Option("-", "-"));                                           
                                }
                                //$("#checkboxes3").html(checks_multiple);
                                $("#localidad_multiple").select2();
                            }

    var barrio_ComunaI = new Array ("-","Bello horizonte","Brisas del Cravo","El Batallon","El Centro","El Libertador","La Corocora","La Estrella bon Habitad","la Pradera","Luis Hernandez Vargas","San Martin","La Arboleda");
	var barrio_ComunaII = new Array ("-","El Triunfo","Comfacasanare","Conjunto Residencial Comfaboy","El Bicentenario","El Remanso","Juan Pablo","La Floresta","Los Andes","Los Helechos","Los Heroes","Maria Milena","Puerta Amarilla","Valle de los guarataros","Villa Benilda","Barcelona","Ciudad Jardín","Juan Hernando Urrego","Unión San Carlos","Laureles","Villa Natalia");
	var barrio_ComunaIII = new Array ("-","20 De Julio","Conjunto Comfacasanare","Aerocivil","El Gavan","El Oasis","El Recuerdo","La Amistad","Maria Paz","Mastranto II","Provivienda");
	var barrio_ComunaIV = new Array ("-","1ro de Mayo","Araguaney","Vencedores","Casiquiare","El Bosque","La Campiña","La Esperanza","Las Palmeras","Paraíso","Villa Rocío");
	var barrio_ComunaV = new Array ("-","Ciudad del Carmen","Conjunto Casa Blanca","Conjunto Flor Amarillo","Conjunto Torres de Leticia","La Victoria","Bella Vista","La Libertad","La Resistencia","Los Angeles","Ciudadela San Jorge","Casimena I","Casimena II","Casimena III","El Laguito","El Nogal","El Portal","El Progreso","La Primavera","Los Almendros","Maranatha","Montecarlo","Nuevo Hábitat","Nuevo Hábitat II","Nuevo Milenio","San Mateo","Villa Nelly","Villa Vargas","Villas de Chavinave");
	var barrio_ComunaVI = new Array ("-","La Colina","Conjunto Senderos de manare","Conjunto el Silencio","Portal de san Geronimo","Senderos de la Colina","Metropoli","Los Ocobos","San Fernando","Villa Flor","Ciudad Paris","Arrayanes","Llano Grande","Llano Lindo","Llano Lindo II","Villa Nariño","Ciudad Berlín","Villa Docente","La Bendición");
	var barrio_ComunaVII = new Array ("-","Mi Nueva Esperanza","7 de Agosto","Ocobos","Conjunto Torres de San Marcos","Villa Lucia","Villa Salomé 1","Xiruma","Xiruma II","Llano Vargas","Bosques de Sirivana","Bosques de Guarataros","Villa David","Getsemaní","Villa Salomé 2","Las americas","Puente Raudal","Camoruco");
	var barrio_Ninguno = new Array ("-","Palmares","Pradera","Chapinero","Torres de San Sebastián","Gaviotas","La estrella","Paseo real","Esperanza","Villa del prado","Primavera","Nuevo milenio","San jose","Centro","Panorama","Alfonso lopez","Rivera de san andres","Rosales","Nuevo horizonte","La roca","Paomare","Floresta","Alcaravanes","Morichito","Villa santiago","15 de septiembre","Glorieta","Olimpico","Brisas del tua","Guaira","Esteros","Villa del bosque","Villa mariana","Guadalupe","Leche miel","Lanceros","Paraiso","El caney","Villa daniela","Julia luz","Los esteros");
	var barrio_SinLocalidad = new Array ("-","Banquetas","Bella Vista","Bello Horizonte","Brisas del Agua Clara","Brisas del Upia I","Brisas del Upia II","Buenos Aires","Caricare","Centro","Ciudadela la Virgen","Comuneros","El Bosque","El Morichal","El Morichalito","El Portal","Fundadores","La colmena","La floresta","Las Vegas","Mirador","Palmeras","Palmares","Panorama","Paraiso I","Paraiso II","Progreso","Quintas del Camino Real","Villa Alejandra","Villa Campestre","Villa Estampa","Villa Luz","Villa del Palmar","Villa Mariana","Villa de los angeles");
	var barrio_Ninguna = new Array ("-","Venecia","Villa Caimaron","Villa Colombia","Villa Daniela","Villa del Norte","Villa del rio","Villa Diana","Villa Natalia","Villa Nueva","Palermo","Paraiso","Peñan","Pinos","Piñayaco","Placer","Plaza de Mercado","Prados","Progreso","Rumipamba","San Andres","San Agustin","San Fernando","San Francisco","La Loma","La union","Las Vegas","Libertador","Loma","Los Angeles","Miraflores","Modelo","Naranjito","Nueva Floresta","Obrero 1","Obrero 2","Olimpico","Pablo VI","Pablo VI bajo");
							//crear funcion que ejecute el cambio
                            function cambia5(){
                                var localidad;
                                localidad = $("#cmbLocalidades option:selected").val();
                                //se verifica la seleccion dada
                                $("#barrios_multiple").find('option').remove().end();
                                if(localidad!=0 && localidad!="-"){
                                    mis_opts=eval("barrio_"+localidad);
                                    //definimos cuantas obciones hay
                                    
                                    
                                    for (var i = 0; i < mis_opts.length; i++) {
                                        
                                        if(mis_opts[i]!="-"){
                                            $('#barrios_multiple').append(new Option(mis_opts[i], mis_opts[i]));
                                        }
                                    }
                                    //checkboxes3
                                }else{
                                //resultado si no hay obciones
                                                                                 
                                }
                                $("#barrios_multiple").select2();
                                
                            }*/

function ckekar_1(){
    var selecccionado =$("#check1").prop('checked');
    if(selecccionado){
        $("#check1").prop('checked',false);
    }else{
        $("#check1").prop('checked',true);
    }
}
function ckekar_2(){
    var selecccionado =$("#check2").prop('checked');
    if(selecccionado){
        $("#check2").prop('checked',false);
    }else{
        $("#check2").prop('checked',true);
    }
}
function ck_facturas_electronicas(ck){
    var selected=$(ck).prop("checked");
    var id=$(ck).data('id');
    
    $.post(baseurl+"facturasElectronicas/activar_desactivar_usuario",{'id':id,'selected':selected},function(data){
        console.log(data);
    },'json');
}   
function al_cambiar_de_servicio(){
    var puntos =$("#servicios").data("puntos");
        var elemento= $("#servicios option:selected").val();
        if(elemento=="Internet" || puntos=="0" || puntos=="no" || puntos=="null" || puntos==null ){
            $("#div_de_puntos").hide();
        }else{
            $("#div_de_puntos").show();
        }

    }
    var id_usuario_seleccionado=0;
    function facturas_electronicas_ev(a){
        var id=$(a).data("id");
        $.post(baseurl+"facturasElectronicas/get_datos_customer",{'id':id},function(data){
            id_usuario_seleccionado=id;
            var op_tv="<option value='Television'>Television</option>";
            var op_int="<option value='Internet'>Internet</option>";
            var op_combo="<option value='Combo'>Combo</option>";
            var options="";
            $("#servicios").data("puntos",data.puntos);            

            if(data.servicios.television!="no" && data.servicios.combo!="no"){
                options+=op_combo;   
            }
            if(data.servicios.combo!="no"){
                options+=op_int;
            }
            if(data.servicios.television!="no"){
                options+=op_tv;    
                $("#i_puntos").html("Tiene "+data.puntos+" Puntos de Tv");
                console.log(data.puntos);
                if(data.puntos=="no" || data.puntos=="0" || data.puntos=="null" || data.puntos==null){
                        $("#puntos option[value=no]").prop("selected",true);
                        $("#div_de_puntos").hide();
                }else{
                    $("#puntos option[value=si]").prop("selected",true);
                    $("#div_de_puntos").show();
                }   
                
            }else{
                $("#div_de_puntos").hide();
            }

//falta en el caso que haya seleccionado por ejemplo combo guardo la configuracion y despues cortan algun servicio y demas casuisticas sobre si se configura y se cambian los datos de la factura
            $("#servicios").html(options);
            $("#alert_modal").modal("show");
            console.log(data.f_elec_internet);
            if(data.f_elec_tv=="1" && data.f_elec_internet=="1"){

                $("#servicios option[value=Combo]").prop("selected",true);
                $("#div_de_puntos").show();
            }else if(data.f_elec_tv=="1"){

                $("#servicios option[value=Television]").prop("selected",true);
                $("#div_de_puntos").show();
            }else if(data.f_elec_internet=="1"){

                $("#servicios option[value=Internet]").prop("selected",true);
                $("#div_de_puntos").hide();
            }
            if(data.f_elec_puntos=="1"){
                    $("#puntos option[value=si]").prop("selected",true);
            }else if(data.f_elec_puntos=="0"){
                    $("#puntos option[value=no]").prop("selected",true);
            }
        },'json');
        
    }
    function guardar_sl_fac_electronica(){
        var servicio=$("#servicios option:selected").val();
        var puntos="no";
        if(servicio!="Internet"){
            puntos=$("#puntos option:selected").val();
        }
        $.post(baseurl+'facturasElectronicas/guardar_seleccion_usuario',{'id':id_usuario_seleccionado,'servicio':servicio,'puntos':puntos},function(data){
            if(data.status=="success"){
                $("#div_notify_elec").html('<div id="notify_elec" class="alert alert-success" ><a href="#" class="close" data-dismiss="alert">&times;</a><div class="message_elec"><strong>Success</strong>: Se guardo la informacion de facturacion electronica correctamente para el usuario</div></div>');
                
                $("#notify_elec").fadeIn();
                $("html, body").scrollTop($("body").offset().top);
                $("#alert_modal").modal("hide");
            }
        },'json');
        
    }
/* para estado usuario */
    var expanded = false;
    function showCheckboxes() {
      var checkboxes = document.getElementById("checkboxes");
      if (!expanded) {
        checkboxes.style.display = "block";
        expanded = true;
      } else {
        checkboxes.style.display = "none";
        expanded = false;
      }
    }
/* para estado de cuenta */
    var expanded2 = false;
    function showCheckboxes2() {
      var checkboxes = document.getElementById("checkboxes2");
      if (!expanded2) {
        checkboxes.style.display = "block";
        expanded2 = true;
      } else {
        checkboxes.style.display = "none";
        expanded2 = false;
      }
    }
    var expanded3 = false;
    function showCheckboxes3() {
      var checkboxes = document.getElementById("checkboxes3");
      if (!expanded3) {
        checkboxes.style.display = "block";
        expanded3 = true;
      } else {
        checkboxes.style.display = "none";
        expanded3 = false;
      }
    }
    var expanded4 = false;
    function showCheckboxes4() {
      var checkboxes = document.getElementById("checkboxes4");
      if (!expanded4) {
        checkboxes.style.display = "block";
        expanded4 = true;
      } else {
        checkboxes.style.display = "none";
        expanded4 = false;
      }
    }
//mas cambios

$("#estado_multiple").select2();
$("#barrios_multiple").select2();
$("#deudores_multiple").select2();
$("#tegnologia_multiple").select2();


function cancelar_envio_mensajes(){
    $.cookie("cancelar_envio_mensajes","true");
    $.post(baseurl+"clientgroup/cancelar_envio_de_mensajes",{},function(data){

    });
}
//traer localidad			

$(document).ready(function(){
   
	$("#cmbCiudades").change(function(){
        cuando_cambia_de_ciudad();
	});
    cuando_cambia_de_ciudad();
    

    $("#localidad_multiple").on("change",function (e){
            var x12=$("#localidad_multiple").val();
            try{
                var idLocalidad = x12[0];
            }catch(e){
            var idLocalidad=0;
            }
       

            //console.log(idDepartamento);
            $.post(baseurl+"customers/barrios_list",{'idLocalidad': idLocalidad
                },function(data){
                //console.log(data);
                data=data.replace("<option value=''>Seleccionar</option>","");
                    $("#barrios_multiple").html(data);
            });
    });
})
function cuando_cambia_de_ciudad(){
    $("#cmbCiudades option:selected").each(function(){
            idCiudad = $(this).val();
            //console.log(idDepartamento);
            $.post(baseurl+"customers/localidades_list?tipo=multiple",{'idCiudad': idCiudad
                },function(data){
                //console.log(data);
                    //$("#cmbLocalidades").html(data);
                    data=data.replace("<option value=''>Seleccionar</option>","");
                    $("#localidad_multiple").html(data);
                    $("#localidad_multiple").select2();
            });
        });
}
//traer barrio			

</script>                   