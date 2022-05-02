<article class="content">
    <div>
        <div id="notify" class="alert alert-success" style="display:none;">
            <a href="#" class="close" data-dismiss="alert">&times;</a>

            <div class="message"></div>
        </div>
        <div class="">
            <div class="col-md-4">
                <div class="card card-block"><h5><?php echo $this->lang->line('Update Profile Picture') ?></h5>
                    <hr>
                    <div class="ibox-content no-padding border-left-right">
                        <img alt="profile picture" id="dpic" class="img-responsive"
                             src="<?php echo base_url('userfiles/employee/') . $user['picture'] ?>">
                    </div>
                    <hr>
                    <p><label for="fileupload"><?php echo $this->lang->line('Change Your Picture') ?></label><input
                                id="fileupload" type="file"
                                name="files[]"></p></div>


                <!-- signature -->

                <div class="card card-block"><h5><?php echo $this->lang->line('Update Your Signature') ?></h5>
                    <hr>
                    <div class="ibox-content no-padding border-left-right">
                        <img alt="sign_pic" id="sign_pic" class="img-responsive"
                             src="<?php echo base_url('userfiles/employee_sign/') . $user['sign'] ?>">
                    </div>
                    <hr>
                    <p>
                        <label for="sign_fileupload"><?php echo $this->lang->line('Change Your Signature') ?></label><input
                                id="sign_fileupload" type="file"
                                name="files[]"></p></div>


            </div>
            <div class="col-md-8">
                <div class="card card-block">
                    <form method="post" id="product_action" class="form-horizontal">
                        <div class="grid_3 grid_4">

                            <h5><?php echo $this->lang->line('Update Your Details') ?> (<?php echo $user['username'] ?>
                                )</h5>
                            <hr>


                            <div class="form-group row">

                                <label class="col-sm-2 col-form-label"
                                       for="name"><?php echo $this->lang->line('Name') ?></label>

                                <div class="col-sm-10">
                                    <input type="text" placeholder="Nombre completo"
                                           class="form-control margin-bottom  required" name="name"
                                           value="<?php echo $user['name'] ?>">
                                </div>
                            </div>
							<div class="form-group row">

                                    <label class="col-sm-2 col-form-label"
                                           for="name"><?php echo $this->lang->line('') ?>Documento</label>

                                    <div class="col-sm-10">
                                        <input type="text" placeholder="Numero de documento"
                                               class="form-control margin-bottom required" name="documento"
                                               placeholder="Full name" value="<?php echo $user['dto'] ?>">
                                    </div>
                                </div>
								<div class="form-group row">

                                    <label class="col-sm-2 col-form-label"
                                           for="name"><?php echo $this->lang->line('') ?>Fecha ingreso</label>

                                    <div class="col-sm-10">
                                        <input type="text" class="form-control required"
                                                   placeholder="Billing Date" name="ingreso"
                                                   data-toggle="datepicker"
                                                   autocomplete="false" value="<?php echo $user['inicio'] ?>">
                                    </div>
                                </div>
								<div class="form-group row">

                                    <label class="col-sm-2 col-form-label"
                                           for="address"><?php echo $this->lang->line('') ?>RH</label>

                                    <div class="col-sm-10">
                                        <input type="text" placeholder="Grupo sanguineo"
                                               class="form-control margin-bottom" name="rh" value="<?php echo $user['rh'] ?>">
                                    </div>
                                </div>
								<div class="form-group row">

                                    <label class="col-sm-2 col-form-label"
                                           for="address"><?php echo $this->lang->line('') ?>Eps</label>

                                    <div class="col-sm-10">
                                        <input type="text" placeholder="Eps donde se encuentra afiliado"
                                               class="form-control margin-bottom" name="eps" value="<?php echo $user['eps'] ?>">
                                    </div>
                                </div>
								<div class="form-group row">

                                    <label class="col-sm-2 col-form-label"
                                           for="address"><?php echo $this->lang->line('') ?>Fondo de pension</label>

                                    <div class="col-sm-10">
                                        <input type="text" placeholder="Entidad donde este afiliado a pension"
                                               class="form-control margin-bottom" name="pensiones" value="<?php echo $user['pensiones'] ?>">
                                    </div>
                                </div>

                            <div class="form-group row">

                                <label class="col-sm-2 col-form-label"
                                       for="address"><?php echo $this->lang->line('Address') ?></label>

                                <div class="col-sm-10">
                                    <input type="text" placeholder="Direccion completa"
                                           class="form-control margin-bottom" name="address"
                                           value="<?php echo $user['address'] ?>">
                                </div>
                            </div>
                            <div class="form-group row">

                                <label class="col-sm-2 col-form-label"
                                       for="city"><?php echo $this->lang->line('City') ?></label>

                                <div class="col-sm-10">
                                    <input type="text" placeholder="Ciudad"
                                           class="form-control margin-bottom" name="city"
                                           value="<?php echo $user['city'] ?>">
                                </div>
                            </div>
                            <div class="form-group row">

                                <label class="col-sm-2 col-form-label"
                                       for="country"><?php echo $this->lang->line('Country') ?></label>

                                <div class="col-sm-10">
                                    <input type="text" placeholder="Pais"
                                           class="form-control margin-bottom" name="country"
                                           value="<?php echo $user['country'] ?>">
                                </div>
                            </div>

                            <div class="form-group row">

                                <label class="col-sm-2 col-form-label"
                                       for="phone"><?php echo $this->lang->line('Phone') ?></label>

                                <div class="col-sm-10">
                                    <input type="text" placeholder="Numero Principal"
                                           class="form-control margin-bottom" name="phone"
                                           value="<?php echo $user['phone'] ?>">
                                </div>
                            </div>
                            <div class="form-group row">

                                <label class="col-sm-2 col-form-label"
                                       for="phone"><?php echo $this->lang->line('Phone') ?> (Alt)</label>

                                <div class="col-sm-10">
                                    <input type="text" placeholder="Numero alternativo"
                                           class="form-control margin-bottom" name="phonealt"
                                           value="<?php echo $user['phonealt'] ?>">
                                </div>
                            </div>
                            <div class="form-group row">

                                <label class="col-sm-2 col-form-label"
                                       for="email"><?php echo $this->lang->line('Email') ?></label>

                                <div class="col-sm-10">
                                    <input type="text" placeholder="email"
                                           class="form-control margin-bottom  required" name="email"
                                           value="<?php echo $user['email'] ?>" disabled>
                                </div>
                            </div>
							 <?php if ($this->aauth->get_user()->roleid >= 0) { ?>
                                    <div class="form-group row">

                                        <label class="col-sm-2 col-form-label"
                                               for="name"><?php echo $this->lang->line('UserRole') ?></label>

                                        <div class="col-sm-5">
                                            <select id="sl-roleid" name="roleid" class="form-control margin-bottom">
                                                <option value=""><?php echo user_role($user['roleid']) ?></option>
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
													<td><input type="checkbox" name="co" <?= ($user['co']=='0')?'checked':'' ?>></input></td>
												  	<td align="lift" colspan="2">COBRANZA</td>
													<td><input type="checkbox" name="red" <?= ($user['red']=='0')?'checked':'' ?>></input></td>
												  	<td align="lift" colspan="2">REDES</td>
													<td><input type="checkbox" name="inv" <?= ($user['inv']=='0')?'checked':'' ?>></input></td>
												  	<td align="lift" colspan="2">INVENTARIOS</td>
												</tr>
												<tr>
												  <td align="right"></td>
												  <td><input type="checkbox" name="coape" <?= ($user['coape']=='0')?'checked':'' ?>></input></td>
												  <td align="lift">Apertura</td>
												  <td align="right"></td>
												  <td><input type="checkbox" name="reding" <?= ($user['reding']=='0')?'checked':'' ?>></input></td>
												  <td align="lift">Ingresar equipo</td>
												  <td align="right"></td>
												  <td><input type="checkbox" name="inving" <?= ($user['inving']=='0')?'checked':'' ?>></input></td>
												  <td align="lift">Ingresar material</td>
												</tr>
												<tr>
												  	<td align="right"></td>
												  	<td><input type="checkbox" name="conue" <?= ($user['conue']=='0')?'checked':'' ?>></input></td>
												  	<td align="lift">Nueva Factura</td>
												  	<td align="right"></td>
												  	<td><input type="checkbox" name="redadm" <?= ($user['redadm']=='0')?'checked':'' ?>></input></td>
													<td align="lift">Administrar equipos</td>
													<td align="right"></td>
												  	<td><input type="checkbox" name="invadm" <?= ($user['invadm']=='0')?'checked':'' ?>></input></td>
												  	<td align="lift">Administrar material</td>
												</tr>
												<tr>
												  	<td align="right"></td>
												  	<td><input type="checkbox" name="coadm" <?= ($user['coadm']=='0')?'checked':'' ?>></input></td>
												  	<td align="lift">Administrar facturas</td>
												  	<td align="right"></td>
												  	<td><input type="checkbox" name="redbod" <?= ($user['redbod']=='0')?'checked':'' ?>></input></td>
												  	<td align="lift">Bodega de equipos</td>
													<td align="right"></td>
													<td><input type="checkbox" name="invcat" <?= ($user['invcat']=='0')?'checked':'' ?>></input></td>
												  	<td align="lift">Categorias material</td>
												</tr>
												<tr>
												  	<td align="right"></td>
												  	<td><input type="checkbox" name="cocie" <?= ($user['cocie']=='0')?'checked':'' ?>></input></td>
												  	<td align="lift">Cierre</td>
												  	<td><input type="checkbox" name="com" <?= ($user['com']=='0')?'checked':'' ?>></input></td>
												  	<td align="lift" colspan="2">ORDEN DE COMPRA</td>
													<td align="right"></td>
													<td><input type="checkbox" name="invalm" <?= ($user['invalm']=='0')?'checked':'' ?>></input></td>
												  	<td align="lift">Almacenes</td>
												</tr>
												<tr>
												  	<td align="right"></td>
												  	<td><input type="checkbox" name="cofa" <?= ($user['cofa']=='0')?'checked':'' ?>></input></td>
												  	<td align="lift">Facturacion</td>
												  	<td align="right"></td>
												  	<td><input type="checkbox" name="comnue" <?= ($user['comnue']=='0')?'checked':'' ?>></input></td>
												  	<td align="lift">Nueva orden</td>
													<td align="right"></td>
													<td><input type="checkbox" name="invtrs" <?= ($user['invtrs']=='0')?'checked':'' ?>></input></td>
												  	<td align="lift">Traspasos</td>
												</tr>
												<tr>
												  	<td align="right"></td>
												  	<td><input type="checkbox" name="cofae" <?= ($user['cofae']=='0')?'checked':'' ?>></input></td>
												  	<td align="lift">Facturacion electronica</td>
												  	<td align="right"></td>
												  	<td><input type="checkbox" name="comadm" <?= ($user['comadm']=='0')?'checked':'' ?>></input></td>
												  	<td align="lift">Administrar ordenes</td>
													<td><input type="checkbox" name="emp" <?= ($user['emp']=='0')?'checked':'' ?>></input></td>
												  	<td align="lift" colspan="2">EMPLEADOS</td>
												</tr>
                                                <tr>
                                                    <td align="right"></td>
                                                    <td align="right"><input type="checkbox" name="conotas" <?= ($user['conotas']=='0')?'checked':'' ?>></input></td>
                                                    <td align="lift">Notas Debito/Credito</td>
                                                </tr>
												<tr>
													<td><input type="checkbox" name="us" <?= ($user['us']=='0')?'checked':'' ?>></input></td>
												  	<td align="lift" colspan="2">USUARIOS</td>
												  	<td><input type="checkbox" name="tes" <?= ($user['tes']=='0')?'checked':'' ?>></input></td>
												  	<td align="lift" colspan="2">TESORERIA</td>
												  	<td><input type="checkbox" name="comp"  <?= ($user['comp']=='0')?'checked':'' ?>></input></td>
												  	<td align="lift" colspan="2">COMPLEMENTOS</td>
												</tr>
												<tr>
												  	<td align="right"></td>
												  	<td><input type="checkbox" name="usnue" <?= ($user['usnue']=='0')?'checked':'' ?>></input></td>
												  	<td align="lift">Nuevo usuario</td>
												  	<td align="right"></td>
												  	<td><input type="checkbox" name="testran" <?= ($user['testran']=='0')?'checked':'' ?>></input></td>
												  	<td align="lift">Ver transacciones</td>
													<td align="right"></td>
													<td><input type="checkbox" name="comprec" <?= ($user['comprec']=='0')?'checked':'' ?>></input></td>
												  	<td align="lift">Recaptchat</td>
												</tr>
												<tr>
												  	<td align="right"></td>
												  	<td><input type="checkbox" name="usadm" <?= ($user['usadm']=='0')?'checked':'' ?>></input></td>
												  	<td align="lift">Administrar usuarios</td>
												  	<td align="right"></td>
												  	<td><input type="checkbox" name="tesanu" <?= ($user['tesanu']=='0')?'checked':'' ?>></input></td>
												  	<td align="lift">Ver anulaciones</td>
													<td align="right"></td>
													<td><input type="checkbox" name="compurl" <?= ($user['compurl']=='0')?'checked':'' ?>></input></td>
												  	<td align="lift">Url corta</td>
												</tr>
												<tr>
												  	<td align="right"></td>
												  	<td><input type="checkbox" name="usgru" <?= ($user['usgru']=='0')?'checked':'' ?>></input></td>
												  	<td align="lift">Administrar grupos</td>
												  	<td align="right"></td>
												  	<td><input type="checkbox" name="tesnuetransac" <?= ($user['tesnuetransac']=='0')?'checked':'' ?>></input></td>
												  	<td align="lift">Nueva trasaccion</td>
													<td align="right"></td>
													<td><input type="checkbox" name="comptwi" <?= ($user['comptwi']=='0')?'checked':'' ?>></input></td>
												  	<td align="lift">Twilio</td>
												</tr>
												<tr>
													<td><input type="checkbox" name="tik" <?= ($user['tik']=='0')?'checked':'' ?>></input></td>
												  	<td align="lift" colspan="2">TICKET</td>
													<td align="right"></td>
												  	<td><input type="checkbox" name="tesnuetransfer" <?= ($user['tesnuetransfer']=='0')?'checked':'' ?>></input></td>
												  	<td align="lift">Nueva transferencia</td>
													<td align="right"></td>
													<td><input type="checkbox" name="compcurr" <?= ($user['compcurr']=='0')?'checked':'' ?>></input></td>
												  	<td align="lift">Currency</td>
												</tr>
												<tr>
												  	<td align="right"></td>
												  	<td><input type="checkbox" name="tiknue" <?= ($user['tiknue']=='0')?'checked':'' ?>></input></td>
												  	<td align="lift">Nuevo ticket</td>
												  	<td align="right"></td>
												  	<td><input type="checkbox" name="tesing" <?= ($user['tesing']=='0')?'checked':'' ?>></input></td>
												  	<td align="lift">Ingresos</td>
												  	<td><input type="checkbox" name="pla" <?= ($user['pla']=='0')?'checked':'' ?>></input></td>
												  	<td align="lift" colspan="2">PLANTILLAS</td>
												</tr>
												<tr>
												  	<td align="right"></td>
												  	<td><input type="checkbox" name="tikadm" <?= ($user['tikadm']=='0')?'checked':'' ?>></input></td>
												  	<td align="lift">Administrar entrada</td>
												  	<td align="right"></td>
												  	<td><input type="checkbox" name="tesgas" <?= ($user['tesgas']=='0')?'checked':'' ?>></input></td>
													<td align="lift">Gastos</td>
													<td align="right"></td>
												  	<td><input type="checkbox" name="placor" <?= ($user['placor']=='0')?'checked':'' ?>></input></td>
												  	<td align="lift">Correo</td>
												</tr>
												<tr>
												  	<td><input type="checkbox" name="mo" <?= ($user['mo']=='0')?'checked':'' ?>></input></td>
												  	<td align="lift" colspan="2">MOVILES</td>
												  	<td align="right"></td>
												  	<td><input type="checkbox" name="testransfer" <?= ($user['testransfer']=='0')?'checked':'' ?>></input></td>
												  	<td align="lift">Transferencias</td>
													<td align="right"></td>
													<td><input type="checkbox" name="plamen" <?= ($user['plamen']=='0')?'checked':'' ?>></input></td>
												  	<td align="lift">Mensajes</td>
												</tr>
												<tr>
												  	<td align="right"></td>
												  	<td><input type="checkbox" name="monue" <?= ($user['monue']=='0')?'checked':'' ?>></input></td>
												  	<td align="lift">Nueva movil</td>
												  	<td><input type="checkbox" name="dat" <?= ($user['dat']=='0')?'checked':'' ?>></input></td>
												  	<td align="lift" colspan="2">DATOS E INFORMES</td>
													<td align="right"></td>
													<td><input type="checkbox" name="platem" <?= ($user['platem']=='0')?'checked':'' ?>></input></td>
												  	<td align="lift">Temas</td>
												</tr>
												<tr>
												  	<td align="right"></td>
												  	<td><input type="checkbox" name="moadm" <?= ($user['moadm']=='0')?'checked':'' ?>></input></td>
												  	<td align="lift">Administrar moviles</td>
												  	<td align="right"></td>
												  	<td><input type="checkbox" name="datest" <?= ($user['datest']=='0')?'checked':'' ?>></input></td>
												  	<td align="lift">Estadisticas</td>
													<td><input type="checkbox" name="conf" <?= ($user['conf']=='0')?'checked':'' ?>></input></td>
												  	<td align="lift" colspan="2">CONFIGURACIONES</td>
												</tr>
												<tr>
												  	<td><input type="checkbox" name="pro" <?= ($user['pro']=='0')?'checked':'' ?>></input></td>
												  	<td align="lift" colspan="2">PROVEEDORES</td>
												  	<td align="right"></td>
												  	<td><input type="checkbox" name="datdec" <?= ($user['datdec']=='0')?'checked':'' ?>></input></td>
												  	<td align="lift">Declaraciones</td>
													<td align="right"></td>
												  	<td><input type="checkbox" name="confemp" <?= ($user['confemp']=='0')?'checked':'' ?>></input></td>
												  	<td align="lift">Empresa</td>
												</tr>
												<tr>
													<td align="right"></td>
												  	<td><input type="checkbox" name="pronue" <?= ($user['pronue']=='0')?'checked':'' ?>></input></td>
												  	<td align="lift">Nuevo proveedor</td>
												  	<td align="right"></td>
												  	<td><input type="checkbox" name="datrep" <?= ($user['datrep']=='0')?'checked':'' ?>></input></td>
												  	<td align="lift">Reporte tecnico</td>
												  	<td align="right"></td>
												  	<td><input type="checkbox" name="conffa" <?= ($user['conffa']=='0')?'checked':'' ?>></input></td>
												  	<td align="lift">Facturacion y lenguaje</td>
												</tr>
												<tr>
												  	<td align="right"></td>
												  	<td><input type="checkbox" name="proadm" <?= ($user['proadm']=='0')?'checked':'' ?>></input></td>
												  	<td align="lift">Administrar proveedor</td>
												  	<td align="right"></td>
												  	<td><input type="checkbox" name="datusu" <?= ($user['datusu']=='0')?'checked':'' ?>></input></td>
												  	<td align="lift">Usu. declaraciones</td>
													<td align="right"></td>
													<td><input type="checkbox" name="confmon" <?= ($user['confmon']=='0')?'checked':'' ?>></input></td>
												  	<td align="lift">Moneda</td>
												</tr>
												<tr>
												  	<td><input type="checkbox" name="enc" <?= ($user['enc']=='0')?'checked':'' ?>></input></td>
												  	<td align="lift" colspan="2">ENCUESTAS</td>
												  	<td align="right"></td>
												  	<td><input type="checkbox" name="datpro" <?= ($user['datpro']=='0')?'checked':'' ?>></input></td>
												  	<td align="lift">Prov. declaraciones</td>
													<td align="right"></td>
													<td><input type="checkbox" name="conffec" <?= ($user['conffec']=='0')?'checked':'' ?>></input></td>
												  	<td align="lift">Formato fecha</td>
												</tr>
												<tr>
												  	<td align="right"></td>
												  	<td><input type="checkbox" name="encllam" <?= ($user['encllam']=='0')?'checked':'' ?>></input></td>
												  	<td align="lift">Lista de llamadas</td>
												  	<td align="right"></td>
												  	<td><input type="checkbox" name="dating" <?= ($user['dating']=='0')?'checked':'' ?>></input></td>
												  	<td align="lift">Calcular ingresos</td>
													<td align="right"></td>
													<td><input type="checkbox" name="confcat" <?= ($user['confcat']=='0')?'checked':'' ?>></input></td>
												  	<td align="lift">Categorias transaccion</td>
												</tr>
												<tr>
													<td align="right"></td>
												  	<td><input type="checkbox" name="encnue" <?= ($user['encnue']=='0')?'checked':'' ?>></input></td>
												  	<td align="lift">Nueva encuesta</td>
													<td align="right"></td>
												  	<td><input type="checkbox" name="datgas" <?= ($user['datgas']=='0')?'checked':'' ?>></input></td>
												  	<td align="lift">Calcular gastos</td>
													<td align="right"></td>
													<td><input type="checkbox" name="confmet" <?= ($user['confmet']=='0')?'checked':'' ?>></input></td>
												  	<td align="lift">Fijar metas</td>
												</tr>
												<tr>
												  <td align="right"></td>
												  <td><input type="checkbox" name="encenc" <?= ($user['encenc']=='0')?'checked':'' ?>></input></td>
												  <td align="lift">Lista encuestas</td>
												  <td align="right"></td>
												  <td><input type="checkbox" name="dattrans" <?= ($user['dattrans']=='0')?'checked':'' ?>></input></td>
												  <td align="lift">Trans. clientes</td>
												  <td align="right"></td>
												  <td><input type="checkbox" name="confrest" <?= ($user['confrest']=='0')?'checked':'' ?>></input></td>
												  <td align="lift">Api rest</td>
												</tr>
												<tr>
												  	<td align="right"></td>
												  	<td><input type="checkbox" name="encats" <?= ($user['encats']=='0')?'checked':'' ?>></input></td>
												  	<td align="lift">Nueva ATS</td>
												  	<td align="right"></td>
												  	<td><input type="checkbox" name="datimp" <?= ($user['datimp']=='0')?'checked':'' ?>></input></td>
													<td align="lift">Impuestos</td>
													<td align="right"></td>
												  	<td><input type="checkbox" name="confcorr" <?= ($user['confcorr']=='0')?'checked':'' ?>></input></td>
												  	<td align="lift">Correo</td>
												</tr>
                                                <tr>
                                                    <td align="right"></td>
                                                    <td><input type="checkbox" name="encatslis" <?= ($user['encatslis']=='0')?'checked':'' ?>></input></td>
                                                    <td align="lift">Lista ATS</td>
                                                    <td align="right"></td>
                                                    <td align="right"><input type="checkbox" name="dathistorial" <?= ($user['dathistorial']=='0')?'checked':'' ?>></input></td>
                                                    <td align="lift">Historial CRM</td>
                                                </tr>
												<tr>
                                                    <td align="right"></td>
                                                    <td></td>
                                                    <td align="lift"></td>
                                                    <td align="right"></td>
                                                    <td align="right"><input type="checkbox" name="datservicios" <?= ($user['datservicios']=='0')?'checked':'' ?>></input></td>
                                                    <td align="lift">Estadisticas Servicios</td>
                                                </tr>
												<tr>
												  	<td align="right"></td>
												  	<td></td>
												  	<td align="lift"></td>
												  	<td><input type="checkbox" name="not" <?= ($user['not']=='0')?'checked':'' ?>></input></td>
												  	<td align="lift" colspan="2">NOTAS</td>
													<td align="right"></td>
													<td><input type="checkbox" name="confterm" <?= ($user['confterm']=='0')?'checked':'' ?>></input></td>
												  	<td align="lift">Termino facturacion</td>
												</tr>
												<tr>
												  	<td><input type="checkbox" name="proy" <?= ($user['proy']=='0')?'checked':'' ?>></input></td>
												  	<td align="lift" colspan="2">PROYECTOS</td>
												  	<td><input type="checkbox" name="cal" <?= ($user['cal']=='0')?'checked':'' ?>></input></td>
												  	<td align="lift" colspan="2">CALENDARIO</td>
													<td align="right"></td>
													<td><input type="checkbox" name="confaut" <?= ($user['confaut']=='0')?'checked':'' ?>></input></td>
												  	<td align="lift">Trabajo automatico</td>
												</tr>
												<tr>
												  	<td align="right"></td>
												  	<td><input type="checkbox" name="proynue" <?= ($user['proynue']=='0')?'checked':'' ?>></input></td>
												  	<td align="lift">Nuevo proyecto</td>
												  	<td><input type="checkbox" name="doct" <?= ($user['doct']=='0')?'checked':'' ?>></input></td>
												  	<td align="lift" colspan="2">DOCUMENTOS</td>
													<td align="right"></td>
													<td><input type="checkbox" name="confseg" <?= ($user['confseg']=='0')?'checked':'' ?>></input></td>
												  	<td align="lift">Seguridad</td>
												</tr>
												<tr>
												  	<td align="right"></td>
												  	<td><input type="checkbox" name="proyadm" <?= ($user['proyadm']=='0')?'checked':'' ?>></input></td>
												  	<td align="lift">Administrar proyectos</td>
												  	<td><input type="checkbox" name="pag" <?= ($user['pag']=='0')?'checked':'' ?>></input></td>
												  	<td align="lift" colspan="2">CONFIGURAR PAGO</td>
													<td align="right"></td>
													<td><input type="checkbox" name="conftem" <?= ($user['conftem']=='0')?'checked':'' ?>></input></td>
												  	<td align="lift">Tema</td>
												</tr>
												<tr>
													<td><input type="checkbox" name="cuen" <?= ($user['cuen']=='0')?'checked':'' ?>></input></td>
												  	<td align="lift" colspan="2">CUENTAS</td>
												  	<td align="right"></td>
												  	<td><input type="checkbox" name="pagconf" <?= ($user['pagconf']=='0')?'checked':'' ?>></input></td>
												  	<td align="lift">Configuracion pago</td>
												  	<td align="right"></td>
												  	<td><input type="checkbox" name="confsop" <?= ($user['confsop']=='0')?'checked':'' ?>></input></td>
												  	<td align="lift">Soporte</td>
												</tr>
												<tr>
												  	<td align="right"></td>
												  	<td><input type="checkbox" name="cuenadm" <?= ($user['cuenadm']=='0')?'checked':'' ?>></input></td>
												  	<td align="lift">Cuenta de administracion</td>
												  	<td align="right"></td>
												  	<td><input type="checkbox" name="pagvia" <?= ($user['pagvia']=='0')?'checked':'' ?>></input></td>
												  	<td align="lift">Via de pago</td>
													<td align="right"></td>
													<td><input type="checkbox" name="conface" <?= ($user['conface']=='0')?'checked':'' ?>></input></td>
												  	<td align="lift">Acerca de</td>
												</tr>
												<tr>
												  	<td align="right"></td>
												  	<td><input type="checkbox" name="cuennue" <?= ($user['cuennue']=='0')?'checked':'' ?>></input></td>
												  	<td align="lift">Nueva cuenta</td>
												  	<td align="right"></td>
												  	<td><input type="checkbox" name="pagmon" <?= ($user['pagmon']=='0')?'checked':'' ?>></input></td>
												  	<td align="lift">Moneda de pago</td>
													<td align="right"></td>
													<td><input type="checkbox" name="confupt" <?= ($user['confupt']=='0')?'checked':'' ?>></input></td>
												  	<td align="lift">Update</td>
												</tr>
												<tr>
												  	<td align="right"></td>
												  	<td><input type="checkbox" name="cuenbal" <?= ($user['cuenbal']=='0')?'checked':'' ?>></input></td>
												  	<td align="lift">Hoja de balance</td>
												  	<td align="right"></td>
												  	<td><input type="checkbox" name="pagcam" <?= ($user['pagcam']=='0')?'checked':'' ?>></input></td>
												  	<td align="lift">Cambio de divisas</td>
													<td align="right"></td>
													<td><input type="checkbox" name="confapi" <?= ($user['confapi']=='0')?'checked':'' ?>></input></td>
												  	<td align="lift">APIS</td>
												</tr>
												<tr>
												  	<td align="right"></td>
												  	<td><input type="checkbox" name="cuendec" <?= ($user['cuendec']=='0')?'checked':'' ?>></input></td>
												  	<td align="lift">Declaracion de cuenta</td>
												  	<td align="right"></td>
												  	<td><input type="checkbox" name="pagban" <?= ($user['pagban']=='0')?'checked':'' ?>></input></td>
												  	<td align="lift">Cuentas bancarias</td>
													<td><input type="checkbox" name="tar" <?= ($user['tar']=='0')?'checked':'' ?>></input></td>
												  	<td align="lift" colspan="2">TAREAS</td>
												</tr>
											  </tbody>
											</table>
                                        </div>
                                    </div>

                                <?php } ?>

                            <input type="hidden"
                                   name="eid"
                                   value="<?php echo $user['id'] ?>">


                            <div class="form-group row">

                                <label class="col-sm-2 col-form-label"></label>

                                <div class="col-sm-4">
                                    <input type="submit" id="profile_update" class="btn btn-success margin-bottom"
                                           value="<?php echo $this->lang->line('Update') ?>"
                                           data-loading-text="Updating...">
                                </div>
                            </div>
							
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</article>
<script type="text/javascript">
    $("#profile_update").click(function (e) {
        e.preventDefault();
        var actionurl = baseurl + 'employee/update';
        actionProduct(actionurl);
    });
</script>
<script src="<?php echo base_url('assets/myjs/jquery.ui.widget.js') ?>"></script>
<!-- The basic File Upload plugin -->
<script src="<?php echo base_url('assets/myjs/jquery.fileupload.js') ?>"></script>
<script>
    /*jslint unparam: true */
    /*global window, $ */
    $(function () {
        'use strict';
        // Change this to the location of your server-side upload handler:
        var url = '<?php echo base_url() ?>employee/displaypic?id=<?php echo $user['id'] ?>';
        $('#fileupload').fileupload({
            url: url,
            dataType: 'json',
            done: function (e, data) {

                //$('<p/>').text(file.name).appendTo('#files');
                $("#dpic").load(function () {
                    $(this).hide();
                    $(this).fadeIn('slow');
                }).attr('src', '<?php echo base_url() ?>userfiles/employee/' + data.result);


            },
            progressall: function (e, data) {
                var progress = parseInt(data.loaded / data.total * 100, 10);
                $('#progress .progress-bar').css(
                    'width',
                    progress + '%'
                );
            }
        }).prop('disabled', !$.support.fileInput)
            .parent().addClass($.support.fileInput ? undefined : 'disabled');


        // Sign
        var sign_url = '<?php echo base_url() ?>employee/user_sign?id=<?php echo $user['id'] ?>';
        $('#sign_fileupload').fileupload({
            url: sign_url,
            dataType: 'json',
            done: function (e, data) {

                //$('<p/>').text(file.name).appendTo('#files');
                $("#sign_pic").load(function () {
                    $(this).hide();
                    $(this).fadeIn('slow');
                }).attr('src', '<?php echo base_url() ?>userfiles/employee_sign/' + data.result);


            },
            progressall: function (e, data) {
                var progress = parseInt(data.loaded / data.total * 100, 10);
                $('#progress .progress-bar').css(
                    'width',
                    progress + '%'
                );
            }
        }).prop('disabled', !$.support.fileInput)
            .parent().addClass($.support.fileInput ? undefined : 'disabled');
    });
	select_checkbox_segun_rol();//para hacer la seleccion al principio
$("#sl-roleid").on("change",function(ev){
	select_checkbox_segun_rol();//al cambiar de rol
});
	function select_checkbox_segun_rol(){
	var roleid=$("#sl-roleid option:selected").val();
		//$(":checkbox").prop("checked",false);
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
</script>