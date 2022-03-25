<div class="app-content content container-fluid">
    <div class="content-wrapper">
        <div class="content-header row">
            <div class=" animated fadeInRight">
                <div class="col-md-8">
                    <div class="card card-block bg-white">
                        <div id="notify" class="alert alert-success" style="display:none;">
                            <a href="#" class="close" data-dismiss="alert">&times;</a>

                            <div class="message"></div>
                        </div>
                        <form method="post" id="data_form" class="form-horizontal">
                            <div class="grid_3 grid_4">

                                <h5><?php echo $this->lang->line('Employee Details') ?> </h5>
                                <hr>
                                <div class="form-group row">

                                    <label class="col-sm-6 col-form-label"
                                           for="name"><?php echo $this->lang->line('UserName') ?>
                                        <small class="error">(Use Only a-z0-9)</small>
                                    </label>

                                    <div class="col-sm-10">
                                        <input type="text"
                                               class="form-control margin-bottom required" name="username"
                                               placeholder="username">
                                    </div>
                                </div>

                                <div class="form-group row">

                                    <label class="col-sm-6 col-form-label" for="email">Email</label>

                                    <div class="col-sm-10">
                                        <input type="email" placeholder="email"
                                               class="form-control margin-bottom required" name="email"
                                               placeholder="email">
                                    </div>
                                </div>
                                <div class="form-group row">

                                    <label class="col-sm-6 col-form-label"
                                           for="password"><?php echo $this->lang->line('Password') ?>
                                        <small>(min length 6)</small>
                                    </label>

                                    <div class="col-sm-10">
                                        <input type="text" placeholder="Password"
                                               class="form-control margin-bottom required" name="password"
                                               placeholder="password">
                                    </div>
                                </div>
                                <?php if ($this->aauth->get_user()->roleid >= 0) { ?>
                                    <div class="form-group row">

                                        <label class="col-sm-2 col-form-label"
                                               for="name"><?php echo $this->lang->line('UserRole') ?></label>

                                        <div class="col-sm-5">
                                            <select id="sl-roleid" name="roleid" class="form-control margin-bottom">
                                                <option value="5">Super usuario</option>
                                                <option value="4">Administrativo</option>
                                                <option value="3">Caja y ventas</option>
                                                <option value="2">Tecnicos</option>
                                                
                                            </select>
                                        </div>
                                    </div>
									<div class="form-group row">

                                        <label class="col-sm-2 col-form-label"
                                               for="name"><?php echo $this->lang->line('') ?>Permisos</label>

                                        <div class="col-sm-10">
                                            <table border="0">
											  <tbody>
												<tr>
													<td><input type="checkbox" name="co"></input></td>
												  	<td align="lift" colspan="2">COBRANZA</td>
													<td><input type="checkbox" name="red"></input></td>
												  	<td align="lift" colspan="2">REDES</td>
													<td><input type="checkbox" name="inv"></input></td>
												  	<td align="lift" colspan="2">INVENTARIOS</td>
												</tr>
												<tr>
												  <td align="right"></td>
												  <td><input type="checkbox" name="coape"></input></td>
												  <td align="lift">Apertura</td>
												  <td align="right"></td>
												  <td><input type="checkbox" name="reding"></input></td>
												  <td align="lift">Ingresar equipo</td>
												  <td align="right"></td>
												  <td><input type="checkbox" name="inving"></input></td>
												  <td align="lift">Ingresar material</td>
												</tr>
												<tr>
												  	<td align="right"></td>
												  	<td><input type="checkbox" name="conue"></input></td>
												  	<td align="lift">Nueva Factura</td>
												  	<td align="right"></td>
												  	<td><input type="checkbox" name="redadm"></input></td>
													<td align="lift">Administrar equipos</td>
													<td align="right"></td>
												  	<td><input type="checkbox" name="invadm"></input></td>
												  	<td align="lift">Administrar material</td>
												</tr>
												<tr>
												  	<td align="right"></td>
												  	<td><input type="checkbox" name="coadm"></input></td>
												  	<td align="lift">Administrar facturas</td>
												  	<td align="right"></td>
												  	<td><input type="checkbox" name="redbod"></input></td>
												  	<td align="lift">Bodega de equipos</td>
													<td align="right"></td>
													<td><input type="checkbox" name="invcat"></input></td>
												  	<td align="lift">Categorias material</td>
												</tr>
												<tr>
												  	<td align="right"></td>
												  	<td><input type="checkbox" name="cocie"></input></td>
												  	<td align="lift">Cierre</td>
												  	<td><input type="checkbox" name="com"></input></td>
												  	<td align="lift" colspan="2">ORDEN DE COMPRA</td>
													<td align="right"></td>
													<td><input type="checkbox" name="invalm"></input></td>
												  	<td align="lift">Almacenes</td>
												</tr>
												<tr>
												  	<td align="right"></td>
												  	<td><input type="checkbox" name="cofa"></input></td>
												  	<td align="lift">Facturacion</td>
												  	<td align="right"></td>
												  	<td><input type="checkbox" name="comnue"></input></td>
												  	<td align="lift">Nueva orden</td>
													<td align="right"></td>
													<td><input type="checkbox" name="invtrs"></input></td>
												  	<td align="lift">Traspasos</td>
												</tr>
												<tr>
												  	<td align="right"></td>
												  	<td><input type="checkbox" name="cofae"></input></td>
												  	<td align="lift">Facturacion electronica</td>
												  	<td align="right"></td>
												  	<td><input type="checkbox" name="comadm"></input></td>
												  	<td align="lift">Administrar ordenes</td>
													<td><input type="checkbox" name="emp"></input></td>
												  	<td align="lift" colspan="2">EMPLEADOS</td>
												</tr>
												<tr>
                                                    <td align="right"></td>
                                                    <td align="right"><input type="checkbox" name="conotas" ></input></td>
                                                    <td align="lift">Notas Debito/Credito</td>
                                                </tr>
												<tr>
													<td><input type="checkbox" name="us"></input></td>
												  	<td align="lift" colspan="2">USUARIOS</td>
												  	<td><input type="checkbox" name="tes"></input></td>
												  	<td align="lift" colspan="2">TESORERIA</td>
												  	<td><input type="checkbox" name="comp"></input></td>
												  	<td align="lift" colspan="2">COMPLEMENTOS</td>
												</tr>
												<tr>
												  	<td align="right"></td>
												  	<td><input type="checkbox" name="usnue"></input></td>
												  	<td align="lift">Nuevo usuario</td>
												  	<td align="right"></td>
												  	<td><input type="checkbox" name="testran"></input></td>
												  	<td align="lift">Ver transacciones</td>
													<td align="right"></td>
													<td><input type="checkbox" name="comprec"></input></td>
												  	<td align="lift">Recaptchat</td>
												</tr>
												<tr>
												  	<td align="right"></td>
												  	<td><input type="checkbox" name="usadm"></input></td>
												  	<td align="lift">Administrar usuarios</td>
												  	<td align="right"></td>
												  	<td><input type="checkbox" name="tesanu"></input></td>
												  	<td align="lift">Ver anulaciones</td>
													<td align="right"></td>
													<td><input type="checkbox" name="compurl"></input></td>
												  	<td align="lift">Url corta</td>
												</tr>
												<tr>
												  	<td align="right"></td>
												  	<td><input type="checkbox" name="usgru"></input></td>
												  	<td align="lift">Administrar grupos</td>
												  	<td align="right"></td>
												  	<td><input type="checkbox" name="tesnuetransac"></input></td>
												  	<td align="lift">Nueva trasaccion</td>
													<td align="right"></td>
													<td><input type="checkbox" name="comptwi"></input></td>
												  	<td align="lift">Twilio</td>
												</tr>
												<tr>
													<td><input type="checkbox" name="tik"></input></td>
												  	<td align="lift" colspan="2">TICKET</td>
													<td align="right"></td>
												  	<td><input type="checkbox" name="tesnuetransfer"></input></td>
												  	<td align="lift">Nueva transferencia</td>
													<td align="right"></td>
													<td><input type="checkbox" name="compcurr"></input></td>
												  	<td align="lift">Currency</td>
												</tr>
												<tr>
												  	<td align="right"></td>
												  	<td><input type="checkbox" name="tiknue"></input></td>
												  	<td align="lift">Nuevo ticket</td>
												  	<td align="right"></td>
												  	<td><input type="checkbox" name="tesing"></input></td>
												  	<td align="lift">Ingresos</td>
												  	<td><input type="checkbox" name="pla"></input></td>
												  	<td align="lift" colspan="2">PLANTILLAS</td>
												</tr>
												<tr>
												  	<td align="right"></td>
												  	<td><input type="checkbox" name="tikadm"></input></td>
												  	<td align="lift">Administrar entrada</td>
												  	<td align="right"></td>
												  	<td><input type="checkbox" name="tesgas"></input></td>
													<td align="lift">Gastos</td>
													<td align="right"></td>
												  	<td><input type="checkbox" name="placor"></input></td>
												  	<td align="lift">Correo</td>
												</tr>

												<tr>
												  	<td><input type="checkbox" name="mo"></input></td>
												  	<td align="lift" colspan="2">MOVILES</td>
												  	<td align="right"></td>
												  	<td><input type="checkbox" name="testransfer"></input></td>
												  	<td align="lift">Transferencias</td>
													<td align="right"></td>
													<td><input type="checkbox" name="plamen"></input></td>
												  	<td align="lift">Mensajes</td>
												</tr>
												<tr>
												  	<td align="right"></td>
												  	<td><input type="checkbox" name="monue"></input></td>
												  	<td align="lift">Nueva movil</td>
												  	<td><input type="checkbox" name="dat"></input></td>
												  	<td align="lift" colspan="2">DATOS E INFORMES</td>
													<td align="right"></td>
													<td><input type="checkbox" name="platem"></input></td>
												  	<td align="lift">Temas</td>
												</tr>
												<tr>
												  	<td align="right"></td>
												  	<td><input type="checkbox" name="moadm"></input></td>
												  	<td align="lift">Administrar moviles</td>
												  	<td align="right"></td>
												  	<td><input type="checkbox" name="datest"></input></td>
												  	<td align="lift">Estadisticas</td>
													<td><input type="checkbox" name="conf"></input></td>
												  	<td align="lift" colspan="2">CONFIGURACIONES</td>
												</tr>
												<tr>
												  	<td><input type="checkbox" name="pro"></input></td>
												  	<td align="lift" colspan="2">PROVEEDORES</td>
												  	<td align="right"></td>
												  	<td><input type="checkbox" name="datdec"></input></td>
												  	<td align="lift">Declaraciones</td>
													<td align="right"></td>
												  	<td><input type="checkbox" name="confemp"></input></td>
												  	<td align="lift">Empresa</td>
												</tr>
												<tr>
													<td align="right"></td>
												  	<td><input type="checkbox" name="pronue"></input></td>
												  	<td align="lift">Nuevo proveedor</td>
												  	<td align="right"></td>
												  	<td><input type="checkbox" name="datrep"></input></td>
												  	<td align="lift">Reporte tecnico</td>
												  	<td align="right"></td>
												  	<td><input type="checkbox" name="conffa"></input></td>
												  	<td align="lift">Facturacion y lenguaje</td>
												</tr>
												<tr>
												  	<td align="right"></td>
												  	<td><input type="checkbox" name="proadm"></input></td>
												  	<td align="lift">Administrar proveedor</td>
												  	<td align="right"></td>
												  	<td><input type="checkbox" name="datusu"></input></td>
												  	<td align="lift">Usu. declaraciones</td>
													<td align="right"></td>
													<td><input type="checkbox" name="confmon"></input></td>
												  	<td align="lift">Moneda</td>
												</tr>
												<tr>
												  	<td><input type="checkbox" name="enc"></input></td>
												  	<td align="lift" colspan="2">ENCUESTAS</td>
												  	<td align="right"></td>
												  	<td><input type="checkbox" name="datpro"></input></td>
												  	<td align="lift">Prov. declaraciones</td>
													<td align="right"></td>
													<td><input type="checkbox" name="conffec"></input></td>
												  	<td align="lift">Formato fecha</td>
												</tr>
												<tr>
												  	<td align="right"></td>
												  	<td><input type="checkbox" name="encllam"></input></td>
												  	<td align="lift">Lista de llamadas</td>
												  	<td align="right"></td>
												  	<td><input type="checkbox" name="dating"></input></td>
												  	<td align="lift">Calcular ingresos</td>
													<td align="right"></td>
													<td><input type="checkbox" name="confcat"></input></td>
												  	<td align="lift">Categorias transaccion</td>
												</tr>
												<tr>
													<td align="right"></td>
												  	<td><input type="checkbox" name="encnue"></input></td>
												  	<td align="lift">Nueva encuesta</td>
													<td align="right"></td>
												  	<td><input type="checkbox" name="datgas"></input></td>
												  	<td align="lift">Calcular gastos</td>
													<td align="right"></td>
													<td><input type="checkbox" name="confmet"></input></td>
												  	<td align="lift">Fijar metas</td>
												</tr>
												<tr>
												  <td align="right"></td>
												  <td><input type="checkbox" name="encenc"></input></td>
												  <td align="lift">Lista encuestas</td>
												  <td align="right"></td>
												  <td><input type="checkbox" name="dattrans"></input></td>
												  <td align="lift">Trans. clientes</td>
												  <td align="right"></td>
												  <td><input type="checkbox" name="confrest"></input></td>
												  <td align="lift">Api rest</td>
												</tr>
												<tr>
												  	<td align="right"></td>
												  	<td><input type="checkbox" name="encats"></input></td>
												  	<td align="lift">Nueva ATS</td>
												  	<td align="right"></td>
												  	<td><input type="checkbox" name="datimp"></input></td>
													<td align="lift">Impuestos</td>
													<td align="right"></td>
												  	<td><input type="checkbox" name="confcorr"></input></td>
												  	<td align="lift">Correo</td>
												</tr>
												 <tr>
                                                    <td align="right"></td>
                                                    <td><input type="checkbox" name="encatslis" ></input></td>
                                                    <td align="lift">Lista ATS</td>
                                                    <td align="right"></td>
                                                    <td align="right"><input type="checkbox" name="dathistorial" ></input></td>
                                                    <td align="lift">Historial CRM</td>
                                                </tr>
												<tr>
												  	<td align="right"></td>
												  	<td></td>
												  	<td align="lift"></td>
												  	<td><input type="checkbox" name="not"></input></td>
												  	<td align="lift" colspan="2">NOTAS</td>
													<td align="right"></td>
													<td><input type="checkbox" name="confterm"></input></td>
												  	<td align="lift">Termino facturacion</td>
												</tr>
												<tr>
												  	<td><input type="checkbox" name="proy"></input></td>
												  	<td align="lift" colspan="2">PROYECTOS</td>
												  	<td><input type="checkbox" name="cal"></input></td>
												  	<td align="lift" colspan="2">CALENDARIO</td>
													<td align="right"></td>
													<td><input type="checkbox" name="confaut"></input></td>
												  	<td align="lift">Trabajo automatico</td>
												</tr>
												<tr>
												  	<td align="right"></td>
												  	<td><input type="checkbox" name="proynue"></input></td>
												  	<td align="lift">Nuevo proyecto</td>
												  	<td><input type="checkbox" name="doct"></input></td>
												  	<td align="lift" colspan="2">DOCUMENTOS</td>
													<td align="right"></td>
													<td><input type="checkbox" name="confseg"></input></td>
												  	<td align="lift">Seguridad</td>
												</tr>
												<tr>
												  	<td align="right"></td>
												  	<td><input type="checkbox" name="proyadm"></input></td>
												  	<td align="lift">Administrar proyectos</td>
												  	<td><input type="checkbox" name="pag"></input></td>
												  	<td align="lift" colspan="2">CONFIGURAR PAGO</td>
													<td align="right"></td>
													<td><input type="checkbox" name="conftem"></input></td>
												  	<td align="lift">Tema</td>
												</tr>
												<tr>
													<td><input type="checkbox" name="cuen"></input></td>
												  	<td align="lift" colspan="2">CUENTAS</td>
												  	<td align="right"></td>
												  	<td><input type="checkbox" name="pagconf"></input></td>
												  	<td align="lift">Configuracion pago</td>
												  	<td align="right"></td>
												  	<td><input type="checkbox" name="confsop"></input></td>
												  	<td align="lift">Soporte</td>
												</tr>
												<tr>
												  	<td align="right"></td>
												  	<td><input type="checkbox" name="cuenadm"></input></td>
												  	<td align="lift">Cuenta de administracion</td>
												  	<td align="right"></td>
												  	<td><input type="checkbox" name="pagvia"></input></td>
												  	<td align="lift">Via de pago</td>
													<td align="right"></td>
													<td><input type="checkbox" name="conface"></input></td>
												  	<td align="lift">Acerca de</td>
												</tr>
												<tr>
												  	<td align="right"></td>
												  	<td><input type="checkbox" name="cuennue"></input></td>
												  	<td align="lift">Nueva cuenta</td>
												  	<td align="right"></td>
												  	<td><input type="checkbox" name="pagmon"></input></td>
												  	<td align="lift">Moneda de pago</td>
													<td align="right"></td>
													<td><input type="checkbox" name="confupt"></input></td>
												  	<td align="lift">Update</td>
												</tr>
												<tr>
												  	<td align="right"></td>
												  	<td><input type="checkbox" name="cuenbal"></input></td>
												  	<td align="lift">Hoja de balance</td>
												  	<td align="right"></td>
												  	<td><input type="checkbox" name="pagcam"></input></td>
												  	<td align="lift">Cambio de divisas</td>
													<td align="right"></td>
													<td><input type="checkbox" name="confapi"></input></td>
												  	<td align="lift">APIS</td>
												</tr>
												<tr>
												  	<td align="right"></td>
												  	<td><input type="checkbox" name="cuendec"></input></td>
												  	<td align="lift">Declaracion de cuenta</td>
												  	<td align="right"></td>
												  	<td><input type="checkbox" name="pagban"></input></td>
												  	<td align="lift">Cuentas bancarias</td>
													<td><input type="checkbox" name="tar"></input></td>
												  	<td align="lift" colspan="2">TAREAS</td>
												</tr>
											  </tbody>
											</table>
                                        </div>
                                    </div>

                                <?php } ?>

                                <hr>

                                <div class="form-group row">

                                    <label class="col-sm-2 col-form-label"
                                           for="name"><?php echo $this->lang->line('Name') ?></label>

                                    <div class="col-sm-10">
                                        <input type="text" placeholder="Nombre completo"
                                               class="form-control margin-bottom required" name="name"
                                               placeholder="Full name">
                                    </div>
                                </div>
								<div class="form-group row">

                                    <label class="col-sm-2 col-form-label"
                                           for="name"><?php echo $this->lang->line('') ?>Documento</label>

                                    <div class="col-sm-10">
                                        <input type="text" placeholder="Numero de documento"
                                               class="form-control margin-bottom required" name="documento"
                                               placeholder="Full name">
                                    </div>
                                </div>
								<div class="form-group row">

                                    <label class="col-sm-2 col-form-label"
                                           for="name"><?php echo $this->lang->line('') ?>Fecha ingreso</label>

                                    <div class="col-sm-10">
                                        <input type="text" class="form-control required"
                                                   placeholder="Billing Date" name="ingreso"
                                                   data-toggle="datepicker"
                                                   autocomplete="false">
                                    </div>
                                </div>
								<div class="form-group row">

                                    <label class="col-sm-2 col-form-label"
                                           for="address"><?php echo $this->lang->line('') ?>RH</label>

                                    <div class="col-sm-10">
                                        <input type="text" placeholder="Grupo sanguineo"
                                               class="form-control margin-bottom" name="rh">
                                    </div>
                                </div>
								<div class="form-group row">

                                    <label class="col-sm-2 col-form-label"
                                           for="address"><?php echo $this->lang->line('') ?>Eps</label>

                                    <div class="col-sm-10">
                                        <input type="text" placeholder="Eps donde se encuentra afiliado"
                                               class="form-control margin-bottom" name="eps">
                                    </div>
                                </div>
								<div class="form-group row">

                                    <label class="col-sm-2 col-form-label"
                                           for="address"><?php echo $this->lang->line('') ?>Fondo de pension</label>

                                    <div class="col-sm-10">
                                        <input type="text" placeholder="Entidad donde este afiliado a pension"
                                               class="form-control margin-bottom" name="pensiones">
                                    </div>
                                </div>
                                <div class="form-group row">

                                    <label class="col-sm-2 col-form-label"
                                           for="address"><?php echo $this->lang->line('Address') ?></label>

                                    <div class="col-sm-10">
                                        <input type="text" placeholder="Direccion completa"
                                               class="form-control margin-bottom" name="address">
                                    </div>
                                </div>
                                <div class="form-group row">

                                    <label class="col-sm-2 col-form-label"
                                           for="city"><?php echo $this->lang->line('City') ?></label>

                                    <div class="col-sm-10">
                                        <input type="text" placeholder="Ciudad"
                                               class="form-control margin-bottom" name="city">
                                    </div>
                                </div>
                                <div class="form-group row">

                                    <label class="col-sm-2 col-form-label"
                                           for="city">Departamento</label>

                                    <div class="col-sm-10">
                                        <input type="text" placeholder="Departamento"
                                               class="form-control margin-bottom" name="region">
                                    </div>
                                </div>
                                <div class="form-group row">

                                    <label class="col-sm-2 col-form-label"
                                           for="country"><?php echo $this->lang->line('Country') ?></label>

                                    <div class="col-sm-10">
                                        <input type="text"
                                               class="form-control margin-bottom" name="country">
                                    </div>
                                </div>

                                <div class="form-group row">

                                    <label class="col-sm-2 col-form-label"
                                           for="phone">Celular</label>

                                    <div class="col-sm-10">
                                        <input type="text"
                                               class="form-control margin-bottom" name="phone">
                                    </div>
                                </div>

                                <div class="form-group row">

                                    <label class="col-sm-2 col-form-label"></label>

                                    <div class="col-sm-4">
                                        <input type="submit" id="submit-data" class="btn btn-success margin-bottom"
                                               value="<?php echo $this->lang->line('Add') ?>"
                                               data-loading-text="Adding...">
                                        <input type="hidden" value="employee/submit_user" id="action-url">
                                    </div>
                                </div>

                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> </div>
<script type="text/javascript">
    $("#profile_add").click(function (e) {
        e.preventDefault();
        var actionurl = baseurl + 'user/submit_user';
        actionProduct1(actionurl);
    });
</script>

<script>
	select_checkbox_segun_rol();//para hacer la seleccion al principio
$("#sl-roleid").on("change",function(ev){
	select_checkbox_segun_rol();//al cambiar de rol
});
function select_checkbox_segun_rol(){
	var roleid=$("#sl-roleid option:selected").val();
		$(":checkbox").prop("checked",false);
		if(roleid=="5"){
			//cobranza
			$("input[name=co]").prop("checked",true);
			$("input[name=coape]").prop("checked",true);
			$("input[name=conue]").prop("checked",true);
			$("input[name=coadm]").prop("checked",true);
			$("input[name=cocie]").prop("checked",true);
			$("input[name=cofa]").prop("checked",true);
			$("input[name=cofae]").prop("checked",true);
			$("input[name=conotas]").prop("checked",true);
			//usuarios
			$("input[name=us]").prop("checked",true);
			$("input[name=usnue]").prop("checked",true);
			$("input[name=usadm]").prop("checked",true);
			$("input[name=usgru]").prop("checked",true);
			//tickets
			$("input[name=tik]").prop("checked",true);
			$("input[name=tiknue]").prop("checked",true);
			$("input[name=tikadm]").prop("checked",true);
			//moviles
			$("input[name=mo]").prop("checked",true);
			$("input[name=monue]").prop("checked",true);
			$("input[name=moadm]").prop("checked",true);
			//proveedores
			$("input[name=pro]").prop("checked",true);
			$("input[name=pronue]").prop("checked",true);
			$("input[name=proadm]").prop("checked",true);
			//encuestas
			$("input[name=enc]").prop("checked",true);
			$("input[name=encllam]").prop("checked",true);
			$("input[name=encnue]").prop("checked",true);
			$("input[name=encenc]").prop("checked",true);
			$("input[name=encats]").prop("checked",true);
			$("input[name=encatslis]").prop("checked",true);
			//proyectos
			$("input[name=proy]").prop("checked",true);
			$("input[name=proynue]").prop("checked",true);
			$("input[name=proyadm]").prop("checked",true);
			//cuentas
			$("input[name=cuen]").prop("checked",true);
			$("input[name=cuenadm]").prop("checked",true);
			$("input[name=cuennue]").prop("checked",true);
			$("input[name=cuenbal]").prop("checked",true);
			$("input[name=cuendec]").prop("checked",true);
			//redes
			$("input[name=red]").prop("checked",true);
			$("input[name=reding]").prop("checked",true);
			$("input[name=redadm]").prop("checked",true);
			$("input[name=redbod]").prop("checked",true);
			//ordenes
			$("input[name=com]").prop("checked",true);
			$("input[name=comnue]").prop("checked",true);
			$("input[name=comadm]").prop("checked",true);
			//tesoreria
			$("input[name=tes]").prop("checked",true);
			$("input[name=testran]").prop("checked",true);
			$("input[name=tesanu]").prop("checked",true);
			$("input[name=tesnuetransac]").prop("checked",true);
			$("input[name=tesnuetransfer]").prop("checked",true);
			$("input[name=tesing]").prop("checked",true);
			$("input[name=tesgas]").prop("checked",true);
			$("input[name=testransfer]").prop("checked",true);
			//datos
			$("input[name=dat]").prop("checked",true);
			$("input[name=datest]").prop("checked",true);
			$("input[name=datdec]").prop("checked",true);
			$("input[name=datrep]").prop("checked",true);
			$("input[name=datusu]").prop("checked",true);
			$("input[name=datpro]").prop("checked",true);
			$("input[name=dating]").prop("checked",true);
			$("input[name=datgas]").prop("checked",true);
			$("input[name=dattrans]").prop("checked",true);
			$("input[name=datimp]").prop("checked",true);
			$("input[name=dathistorial]").prop("checked",true);
			//notas
			$("input[name=not]").prop("checked",true);
			//calendario
			$("input[name=cal]").prop("checked",true);
			//documentos
			$("input[name=doct]").prop("checked",true);
			//pagos
			$("input[name=pag]").prop("checked",true);
			$("input[name=pagconf]").prop("checked",true);
			$("input[name=pagvia]").prop("checked",true);
			$("input[name=pagmon]").prop("checked",true);
			$("input[name=pagcam]").prop("checked",true);
			$("input[name=pagban]").prop("checked",true);
			//inventarios
			$("input[name=inv]").prop("checked",true);
			$("input[name=inving]").prop("checked",true);
			$("input[name=invadm]").prop("checked",true);
			$("input[name=invcat]").prop("checked",true);
			$("input[name=invalm]").prop("checked",true);
			$("input[name=invtrs]").prop("checked",true);
			//empleados
			$("input[name=emp]").prop("checked",true);
			//complementos
			$("input[name=comp]").prop("checked",true);
			$("input[name=comprec]").prop("checked",true);
			$("input[name=compurl]").prop("checked",true);
			$("input[name=comptwi]").prop("checked",true);
			$("input[name=compcurr]").prop("checked",true);
			//plantillas
			$("input[name=pla]").prop("checked",true);
			$("input[name=placor]").prop("checked",true);
			$("input[name=plamen]").prop("checked",true);
			$("input[name=platem]").prop("checked",true);
			//configuraciones
			$("input[name=conf]").prop("checked",true);
			$("input[name=confemp]").prop("checked",true);
			$("input[name=conffa]").prop("checked",true);
			$("input[name=confmon]").prop("checked",true);
			$("input[name=conffec]").prop("checked",true);
			$("input[name=confcat]").prop("checked",true);
			$("input[name=confmet]").prop("checked",true);
			$("input[name=confrest]").prop("checked",true);
			$("input[name=confcorr]").prop("checked",true);
			$("input[name=confterm]").prop("checked",true);
			$("input[name=confaut]").prop("checked",true);
			$("input[name=confseg]").prop("checked",true);
			$("input[name=conftem]").prop("checked",true);
			$("input[name=confsop]").prop("checked",true);
			$("input[name=conface]").prop("checked",true);
			$("input[name=confupt]").prop("checked",true);
			$("input[name=confapi]").prop("checked",true);
			//tareas
			$("input[name=tar]").prop("checked",true);
		}else if(roleid=="4"){
			//cobranza
			$("input[name=co]").prop("checked",true);
			$("input[name=coape]").prop("checked",true);
			$("input[name=conue]").prop("checked",true);
			$("input[name=coadm]").prop("checked",true);
			$("input[name=cocie]").prop("checked",true);
			//usuarios
			$("input[name=us]").prop("checked",true);
			$("input[name=usnue]").prop("checked",true);
			$("input[name=usadm]").prop("checked",true);
			$("input[name=usgru]").prop("checked",true);
			//tickets
			$("input[name=tik]").prop("checked",true);
			$("input[name=tiknue]").prop("checked",true);
			$("input[name=tikadm]").prop("checked",true);
			//moviles
			$("input[name=mo]").prop("checked",true);
			$("input[name=monue]").prop("checked",true);
			$("input[name=moadm]").prop("checked",true);
			//proveedores
			$("input[name=pro]").prop("checked",true);
			$("input[name=pronue]").prop("checked",true);
			$("input[name=proadm]").prop("checked",true);
			//encuestas
			$("input[name=enc]").prop("checked",true);
			$("input[name=encllam]").prop("checked",true);
			$("input[name=encnue]").prop("checked",true);
			$("input[name=encenc]").prop("checked",true);
			$("input[name=encats]").prop("checked",true);
			$("input[name=encatslis]").prop("checked",true);
			//proyectos
			$("input[name=proy]").prop("checked",true);
			$("input[name=proynue]").prop("checked",true);
			$("input[name=proyadm]").prop("checked",true);
			//redes
			$("input[name=red]").prop("checked",true);
			$("input[name=reding]").prop("checked",true);
			$("input[name=redadm]").prop("checked",true);
			$("input[name=redbod]").prop("checked",true);
			//ordenes
			$("input[name=com]").prop("checked",true);
			$("input[name=comnue]").prop("checked",true);
			$("input[name=comadm]").prop("checked",true);
			//tesoreria
			$("input[name=tes]").prop("checked",true);
			$("input[name=tesnuetransac]").prop("checked",true);
			$("input[name=tesnuetransfer]").prop("checked",true);
			//datos
			$("input[name=dat]").prop("checked",true);
			$("input[name=datest]").prop("checked",true);
			$("input[name=datdec]").prop("checked",true);
			$("input[name=datrep]").prop("checked",true);
			//notas
			$("input[name=not]").prop("checked",true);
			//calendario
			$("input[name=cal]").prop("checked",true);
			//documentos
			$("input[name=doct]").prop("checked",true);
			//inventarios
			$("input[name=inv]").prop("checked",true);
			$("input[name=inving]").prop("checked",true);
			$("input[name=invadm]").prop("checked",true);
			$("input[name=invcat]").prop("checked",true);
			$("input[name=invalm]").prop("checked",true);
			$("input[name=invtrs]").prop("checked",true);
			//empleados
			$("input[name=emp]").prop("checked",true);
			//tareas
			$("input[name=tar]").prop("checked",true);
		}else if(roleid=="3"){
			//cobranza
			$("input[name=co]").prop("checked",true);
			$("input[name=coape]").prop("checked",true);
			$("input[name=conue]").prop("checked",true);
			$("input[name=cocie]").prop("checked",true);
			//usuarios
			$("input[name=us]").prop("checked",true);
			$("input[name=usnue]").prop("checked",true);
			$("input[name=usgru]").prop("checked",true);
			//tickets
			$("input[name=tik]").prop("checked",true);
			$("input[name=tiknue]").prop("checked",true);
			$("input[name=tikadm]").prop("checked",true);
			//notas
			$("input[name=not]").prop("checked",true);
			//calendario
			$("input[name=cal]").prop("checked",true);
			//documentos
			$("input[name=doct]").prop("checked",true);
			//ordenes
			$("input[name=com]").prop("checked",true);
			$("input[name=comadm]").prop("checked",true);
			//tesoreria
			$("input[name=tes]").prop("checked",true);
			$("input[name=tesnuetransac]").prop("checked",true);
			$("input[name=tesnuetransfer]").prop("checked",true);
			//tareas
			$("input[name=tar]").prop("checked",true);
		}else if(roleid=="2"){
			//notas
			$("input[name=not]").prop("checked",true);
			//calendario
			$("input[name=cal]").prop("checked",true);
			//documentos
			$("input[name=doct]").prop("checked",true);
			//tareas
			$("input[name=tar]").prop("checked",true);
		}
}
    function actionProduct1(actionurl) {

        $.ajax({

            url: actionurl,
            type: 'POST',
            data: $("#product_action").serialize(),
            dataType: 'json',
            success: function (data) {
                $("#notify .message").html("<strong>" + data.status + "</strong>: " + data.message);
                $("#notify").removeClass("alert-warning").addClass("alert-success").fadeIn();


                $("html, body").animate({scrollTop: $('html, body').offset().top}, 200);
                $("#product_action").remove();
            },
            error: function (data) {
                $("#notify .message").html("<strong>" + data.status + "</strong>: " + data.message);
                $("#notify").removeClass("alert-success").addClass("alert-warning").fadeIn();
                $("html, body").animate({scrollTop: $('#notify').offset().top}, 1000);

            }

        });


    }
</script>