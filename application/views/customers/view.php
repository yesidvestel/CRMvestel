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
.st-Suspendido
{
 background-color: #2224A3;
}
.st-Exonerado
{
 background-color: #24A9AB;
}
</style>
<div class="app-content content container-fluid">
    <div class="content-wrapper">
        <div id="notify" class="alert alert-success" style="display:none;">
            <a href="#" class="close" data-dismiss="alert">&times;</a>

            <div class="message"></div>
        </div>

        <div class="content-body">
            <section>
                <div class="row wrapper white-bg page-heading">
                    <div class="col-md-4">
                        <div class="card card-block">
                            <h4 class="text-xs-center"><?php  echo  strtoupper($details['name']." ".$details['unoapellido']) ?></h4>
                            <div class="ibox-content mt-2 " align="center">
                                <img alt="image" id="dpic" class="img-responsive"
                                     src="<?php echo base_url('userfiles/customers/') . $details['picture'] ?>">
                            </div>
                            <hr>
                            <div class="user-button">
                                <div class="row mt-3">
                                    <div class="col-md-6">

                                        <a href="#sendMail" data-toggle="modal" data-remote="false"
                                           class="btn btn-primary btn-md  " data-type="reminder"><i
                                                    class="icon-envelope"></i> <?php echo $this->lang->line('Send Message') ?>
                                        </a>

                                    </div>
									
                                    <div class="col-md-6">
                                        <a href="<?php echo base_url('customers/edit?id=' . $details['id']) ?>"
                                           class="btn btn-info btn-md"><i
                                                    class="icon-pencil"></i> <?php echo $this->lang->line('Edit Profile') ?>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-md-12">
                                    <h3><?php echo $this->lang->line('Balance') ?></h3>
                                    <?= amountFormat($details['balance']) ?>
                                    <hr>
                                    <h5><?php echo $this->lang->line('Balance Summary') ?></h5>
                                    <ul class="list-group list-group-flush">
										<li class="list-group-item">
											<span class="tag tag-default tag-pill float-xs-right st-<?php echo $due['estado']?>"><?php echo $due['estado']?></span>
											Estado Servicio
                                        </li>
										<li class="list-group-item">
											<span class="tag tag-default tag-pill bg-primary float-xs-right"><?php if ($servicios['television']!==no){ echo $servicios['television'];} if ($servicios['combo']!==no){ echo ' + '.$servicios['combo'];}if ($due['puntos']!=='0'){ echo ' + '.$due['puntos'].' Puntos';}?></span>
											Servicios
                                        </li>
                                        <li class="list-group-item">
                                            <span class="tag tag-default tag-pill bg-primary float-xs-right"><?php echo amountFormat($money['credit']) ?></span>
                                            <?php echo $this->lang->line('Income') ?>
											
                                        </li>
                                        <li class="list-group-item">
                                            <span class="tag tag-default tag-pill bg-danger float-xs-right"><?php echo amountFormat($money['debit']) ?></span>
                                            <?php echo $this->lang->line('Expenses') ?>
                                        </li>

                                        <li class="list-group-item">
                                            <span class="tag tag-default tag-pill bg-danger float-xs-right"><?php echo amountFormat($due['total']-$due['pamnt']) ?></span>
                                            <?php echo $this->lang->line('Total Due') ?>
											
                                        </li>

                                    </ul>

                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-md-12">
                                    <h5><?php echo $this->lang->line('') ?>SEDE </h5>


                                </div>
                            </div>
                            <div class="row mt-1">
                                <div class="offset-md-2 col-md-4">
                                    <a href="<?php echo base_url('customers/changepassword?id=' . $details['id']) ?>" class="btn btn-danger btn-md">
									<i class="icon-pencil"></i> <?php echo $this->lang->line('Change Password') ?>
                                    </a>
                                </div>
                                
                                <div class="col-md-12"><br>
                                    <h5><?php echo $this->lang->line('Change Customer Picture') ?></h5><input id="fileupload" type="file" name="files[]">
								</div>                  
                               <div id="progress" class="progress1">
                                    <div class="progress-bar progress-bar-success"></div>
                                </div>
                                
                            </div>
                            <hr>
                             <strong>DATOS DE INTEGRACION</strong>
                            <hr>                            
                                <div class="col-md-3">
                                    <strong><?php echo $this->lang->line('') ?>Mikrotik:</strong>
                                    <strong><?php echo $this->lang->line('') ?>Usuario:</strong>
                                    <strong><?php echo $this->lang->line('') ?>Pasword:</strong>
                                    <strong><?php echo $this->lang->line('') ?>Servicio:</strong>
                                    <strong><?php echo $this->lang->line('') ?>Perfil:</strong>
                                    <strong><?php echo $this->lang->line('') ?>Local:</strong>
                                    <strong><?php echo $this->lang->line('') ?>Remota:</strong>
                                    <strong><?php echo $this->lang->line('') ?>Comt/rio:</strong>                                    
                                    
                                    <a class="btn btn-success" href="<?=base_url().'customers/edita_estado_usuario?username='.$details['name_s'].'&id_cm='.$details['id']?>&id_sede=<?=$details['gid']?>"><?= ($estado_mikrotik=='true') ? "Activar" : "Desactivar" ?></a>                                 
                                
                                </div>
                                <div class="col-md-6">
                                    <?php echo $customergroup['title'] ?>                                    
                                </div>
                                <div class="col-md-6">
                                    <?php echo $details['name_s'] ?>                                   
                                </div>
                                <div class="col-md-6">
                                    <?php echo $details['contra'] ?>                                    
                                </div>
                                <div class="col-md-6">
                                    <?php echo $details['servicio'] ?>                                    
                                </div>
                                <div class="col-md-6">
                                    <?php echo $details['perfil'] ?>                                    
                                </div>
                                <div class="col-md-6">
                                    <?php echo $details['Iplocal'] ?>                                    
                                </div>
                                <div class="col-md-6">
                                    <?php echo $details['Ipremota'] ?>                                    
                                </div>
                                <div class="col-md-6">
                                    <?php echo $barrio['comentario'] ?>                                    
                                </div>
                                
                                
                        </div>

                    </div>
                    <div class="col-md-8">
                        <div class="card card-block">
                            <h4>Detalles de Usuario</h4>
                            <hr>
                            <div class="row m-t-lg">
                                <div class="col-md-2">
                                    <strong><?php echo $this->lang->line('') ?>Usuario Nº:</strong>
                                </div>
                                <div class="col-md-10">
                                    <?php echo $details['abonado'] ?> <strong>ID:</strong> <?php echo $details['id'] ?>
                                </div>

                            </div>
                            <hr>
                            <div class="row m-t-lg">
                                <div class="col-md-2">
                                    <strong><?php echo $this->lang->line('Name') ?>s:</strong>
                                </div>
                                <div class="col-md-10">
                                    <?php echo $details['name'] ?> <?php echo $details['dosnombre'] ?>
                                </div>

                            </div>
                            <hr>
                            <div class="row m-t-lg">
                                <div class="col-md-2">
                                    <strong><?php echo $this->lang->line('') ?>Apellidos:</strong>
                                </div>
                                <div class="col-md-10">
                                    <?php echo $details['unoapellido'] ?> <?php echo $details['dosapellido'] ?>
                                </div>
                    
                            </div>
							<hr>
                            <div class="row m-t-lg">
                                <div class="col-md-2">
                                    <strong>Documento:</strong>
                                </div>
                                <div class="col-md-10">
                                    <?php echo $details['tipo_documento'] .". ". $details['documento'] ?>
                                </div>

                            </div>
							<hr>
                            <div class="row m-t-lg">
                                <div class="col-md-2">
                                    <strong><?php echo $this->lang->line('') ?>Celular:</strong>
                                </div>
                                <div class="col-md-10">
                                    <?php echo $details['celular'] ?>
                                </div>

                            </div>
                            <hr>
							<div class="row m-t-lg">
                                <div class="col-md-2">
                                    <strong><?php echo $this->lang->line('') ?>Celular ADI:</strong>
                                </div>
                                <div class="col-md-10">
                                    <?php echo $details['celular2'] ?>
                                </div>

                            </div>
                            <hr>
							<div class="row m-t-lg">
                                <div class="col-md-2">
                                    <strong><?php echo $this->lang->line('') ?>Correo:</strong>
                                </div>
                                <div class="col-md-10">
                                    <?php echo $details['email'] ?>
                                </div>

                            </div>
							<hr>
                            <div class="row m-t-lg">
                                <div class="col-md-2">
                                    <strong><?php echo $this->lang->line('') ?>Empresa:</strong>
                                </div>
                                <div class="col-md-10">
                                    <?php echo $details['company'] ?>
                                </div>

                            </div>
                            
                            <hr>
                            
                            
                            <div class="row m-t-lg">
                                <div class="col-md-2">
                                    <strong><?php echo $this->lang->line('') ?>Fecha de nacimiento:</strong>
                                </div>
                                <div class="col-md-10">
                                    <?php echo $details['nacimiento'] ?>
                                </div>

                            </div>
                            <hr>
                            <div class="row m-t-lg">
                                <div class="col-md-2">
                                    <strong><?php echo $this->lang->line('') ?>Tipo:</strong>
                                </div>
                                <div class="col-md-10">
                                    <?php echo $details['tipo_cliente'] ?>
                                </div>

                            </div>
                            
                            <hr>
                            <div class="row m-t-lg">
                                <div class="col-md-2">
                                    <strong><?php echo $this->lang->line('') ?>Departamento:</strong>
                                </div>
                                <div class="col-md-10">
                                    <?php echo  $details['departamento'] ?>
                                </div>

                            </div>
                            <hr>
                            <div class="row m-t-lg">
                                <div class="col-md-2">
                                    <strong><?php echo $this->lang->line('') ?>Ciudad:</strong>
                                </div>
                                <div class="col-md-10">
                                    <?php echo $details['ciudad'] ?>
                                </div>

                            </div>
                            <hr>
                            <div class="row m-t-lg">
                                <div class="col-md-2">
                                    <strong><?php echo $this->lang->line('') ?>Localidad:</strong>
                                </div>
                                <div class="col-md-10">
                                    <?php echo $details['localidad'] ?>
                                </div>

                            </div>
                            <hr>
                            <div class="row m-t-lg">
                                <div class="col-md-2">
                                    <strong><?php echo $this->lang->line('') ?>Barrio:</strong>
                                </div>
                                <div class="col-md-10">
                                    <?php echo $details['barrio'] ?>
                                </div>

                            </div>
                            <hr>
                            <div class="row m-t-lg">
                                <div class="col-md-2">
                                    <strong><?php echo $this->lang->line('') ?>Direccion:</strong>
                                </div>
                                <div class="col-md-10">
                                    <?php echo $details['nomenclatura']." ".$details['numero1'].$details['adicionauno']." N° ".$details['numero2'].$details['adicional2']." - ".$details['numero3'] ?>
                                </div>

                            </div>
                            <hr>
                            <div class="row m-t-lg">
                                <div class="col-md-2">
                                    <strong><?php echo $this->lang->line('') ?>Referencia:</strong>
                                </div>
                                <div class="col-md-10">
                                    <?php echo $details['residencia'].", ".$details['referencia'] ?>
                                </div>

                            </div>
                            <hr>
							<div class="row m-t-lg">
                                <div class="col-md-2">
                                    <strong>Contrato:</strong>
                                </div>
                                <div class="col-md-10">
                                   <a class="btn btn-primary btn-lg"
                                           href="<?php echo 'printpdf?id=' . $details['id']; ?>"><?php echo $this->lang->line('Print') ?></a>
                                            <a class="btn btn-success btn-lg"
                                           href="<?php echo 'firmadigital?id=' . $details['id']; ?>">Firma Digital</a>

                                            <a class="btn btn-primary btn-lg"
                                           href="<?php echo 'subir_huella?id=' . $details['id']; ?>">Subir PNG Huella</a>
                                </div>
                                

                            </div>
                            <hr>
                            <div class="row mt-3">
                                <div class="col-md-4">

                                    <a href="<?php echo base_url('customers/invoices?id=' . $details['id']) ?>"
                                       class="btn btn-primary btn-lg"><i
                                                class="icon-file-text2"></i> <?php echo $this->lang->line('View Invoices') ?></a>

                                </div>
                                <div class="col-md-4" style="margin-top: 5px;">
                                    <a href="<?php echo base_url('customers/transactions?id=' . $details['id']) ?>"
                                       class="btn btn-success btn-lg"><i
                                                class="icon-money3"></i> <?php echo $this->lang->line('View Transactions') ?>
                                    </a>
                                </div>
                                <div class="col-md-4" style="margin-top: 5px;">
                                    <a href="<?php echo base_url('quote/create?id=' . $details['id']) ?>"
                                       class="btn btn-primary btn-lg"><i
                                                class="icon-ticket"></i> Generar ticket
                                    </a>
                                </div>						
								
								<div class="col-md-4" style="margin-top: 5px;">

                                    <a href="<?php echo base_url('customers/soporte?id=' . $details['id']) ?>"
                                       class="btn btn-success btn-lg" style="border-right-width: 11px;"><i
                                                class="icon-file-text2"></i> Ver Tickets </a>

                                </div>
								<div class="col-md-4" style="margin-top: 5px;">

                                    <a href="<?php echo base_url('customers/equipos?id=' . $details['id']) ?>"
                                       class="btn btn-primary btn-lg" style="border-right-width: 22px;border-left-width: 22px;"><i
                                                class="icon-file-text2"></i> Ver Equipos</a>

                                </div>
								<div class="col-md-4" style="margin-top: 5px;">

                                    <a href="#pop_model2" data-toggle="modal" onclick="funcion_status();" data-remote="false" 
                                       class="btn btn-success btn-lg" style="border-right-width: 7px;"><i
                                                class="icon-file-text2"></i> Cambio Titular </a>

                                </div>
								<div class="col-md-4" style="margin-top: 5px;">

                                    <a href="<?php echo base_url('llamadas/index?id=' . $details['id']) ?>"
                                       class="btn btn-primary btn-lg" style="border-right-width: 15px;border-left-width: 22px;"><i
                                                class="icon-mobile-phone"></i> Llamadas</a>

                                </div>
                            </div>
                            <hr>
                            <h5 class="text-xs-center col-md-10">OBSERVACIONES</h5>
							<div class="col-md-1">

                                    <a href="#pop_model" data-toggle="modal" onclick="funcion_status();" data-remote="false" class="btn btn-success btn-lg" style="border-right-width: -2px;border-bottom-width: 0px;border-top-width: 0px;border-right-width: 0px;border-left-width: 0px;margin-top: -10;margin-bottom: 2px;padding-top: 5px;padding-bottom: 5px;">
										 + </a>

                                </div>
                            <table class="table table-striped">
                                <thead>
                                <tr>
                                    <th >Fecha</th>
                                    <th>Tipo</th>
									<th>Detalle</th>
									<th>Accion</th>


                                </tr>
                                </thead>
                                <tbody id="activity">
                                <?php foreach ($activity as $row) {
									if ($row['tipos']=='Cambio Titular'){
                                    echo '<tr>
                            		<td>' . $row['fecha'] . '</td><td>' . $row['tipos'] . '</td><td>' . $row['nombres'].', '.$row['tdocumento'] .': '.$row['documento2'] . '</td>
									<td><a class="btn btn-danger" onclick="eliminar_documento(' .$row['idn'].')" > <i class="icon-trash-o "></i></a></td>
                        			</tr>';
									}else{
										echo '<tr>
                            		<td>' . $row['fecha'] . '</td><td>' . $row['tipos'] . '</td><td>' . $row['observacion'] . '</td>
									<td><a class="btn btn-danger" onclick="eliminar_documento(' .$row['idn'].')" > <i class="icon-trash-o "></i></a></td>
                        			</tr>';
										$i++;
									}
                                } ?>

                                </tbody>
                            </table>


                        </div>
                    </div>
                </div>

            </section>
        </div>
    </div>
</div>


<div id="sendMail" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Email</h4>
            </div>

            <div class="modal-body">
                <form id="sendmail_form">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="input-group">
                                <div class="input-group-addon"><span class="icon-envelope-o"
                                                                     aria-hidden="true"></span></div>
                                <input type="text" class="form-control" placeholder="Email" name="mailtoc"
                                       value="<?php echo $details['email'] ?>">
                            </div>

                        </div>

                    </div>


                    <div class="row">
                        <div class="col-xs-12 mb-1"><label
                                    for="shortnote"><?php echo $this->lang->line('Customer Name') ?></label>
                            <input type="text" class="form-control"
                                   name="customername" value="<?php echo $details['name'].$details['apellidos'] ?>"></div>
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
                                    for="shortnote"><?php echo $this->lang->line('Message') ?></label>
                            <textarea name="text" class="summernote" id="contents" title="Contents"></textarea></div>
                    </div>

                    <input type="hidden" class="form-control"
                           id="cid" name="tid" value="<?php echo $details['id'] ?>">
                    <input type="hidden" id="action-url" value="communication/send_general">


                </form>
            </div>
            
            <div class="modal-footer">
                <button type="button" class="btn btn-default"
                        data-dismiss="modal"><?php echo $this->lang->line('Close') ?></button>
                <button type="button" class="btn btn-primary"
                        id="sendNow"><?php echo $this->lang->line('Send') ?></button>
            </div>
            
            
            
        </div>
    </div>
</div>

<div id="pop_model2" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Cambio de Titular</h4>
            </div>
			<div class="row m-t-lg">
				<div class="col-md-6">
				<label for="cst" class="col-sm-6 col-form-label">DATOS ACTUALES</label>
					</div>
			</div>
			<hr>
            <div class="modal-body">
                <form id="form_model2">
					<div class="form-group row">						
                    <div class="frmSearch">
						<label for="cst" class="caption col-sm-2 col-form-label">Nombres</label>
                        <div class="col-sm-6">
							<input type="hidden" name="iduser" value="<?php echo $details['id'] ?>"></input>
							<input type="text" class="form-control" name="dtosantes" value="<?php echo $details['name'] .' '. $details['dosnombre'].' '. $details['unoapellido'].' '. $details['dosapellido'] ?>" disabled/>
                            <input type="hidden" class="form-control" name="dtosantes2" value="<?php echo $details['name'] .' '. $details['dosnombre'].' '. $details['unoapellido'].' '. $details['dosapellido'] ?>" />
                        </div>
                    </div>

                </div>
				<div id="customerpanel" class="form-group row">
                    <label for="toBizName" class="caption col-sm-2 col-form-label">Documento</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="doc1" value="<?php echo $details['documento'] ?>" disabled />
                        <input type="hidden" class="form-control" name="doc12" value="<?php echo $details['documento'] ?>" />
                    </div>
					<input type="hidden" name="tcliente" value="<?php echo $details['tipo_cliente'] ?>">
					<input type="hidden" name="tdocumento" value="<?php echo $details['tipo_documento'] ?>">
					<input type="hidden" class="form-control" placeholder="Billing Date" name="fecha" data-toggle="datepicker" autocomplete="false">
                </div>
				<hr>
				<div class="row m-t-lg">
					<div class="col-md-6">
					<label for="cst" class="col-sm-8 col-form-label">DATOS NUEVOS</label>
					</div>
				</div>
				<hr>
				<div id="customerpanel" class="form-group row">
                    <label for="toBizName" class="caption col-sm-2 col-form-label">Nombres</label>
                    <div class="col-sm-3">
                        <input type="text" class="form-control" name="nom1" placeholder="1er Nombre" />
                    </div>
					<div class="col-sm-3">
                        <input type="text" class="form-control" name="nom2" placeholder="2do Nombre" />
                    </div>
                </div>
				<div id="customerpanel" class="form-group row">
                    <label for="toBizName" class="caption col-sm-2 col-form-label">Apellidos</label>
                    <div class="col-sm-3">
                        <input type="text" class="form-control" name="ape1" placeholder="1er Apellido" />
                    </div>
					<div class="col-sm-3">
                        <input type="text" class="form-control" name="ape2" placeholder="2do Apellido" />
                    </div>
                </div>
				<div id="customerpanel" class="form-group row">
                    <label for="toBizName" class="caption col-sm-2 col-form-label">Tipo</label>
                    <div class="col-sm-3">
                        <select class="form-control" name="tipo_cliente">
													<option value="Natural">Natural</option>
                                                	<option value="Juridico">Juridico</option>
                                                  	<option value="Gubernamental">Gubernamental</option>
                                                	<option value="Militar">Militar</option>
                                            </select>
                    </div>
					<div class="col-sm-3">
                        <select class="form-control" name="tipo_documento">
													<option value="CC">CC</option>
                                                	<option value="CE">CE</option>
                                                  	<option value="NIT">NIT</option>
                                                	<option value="PAS">PAS</option>
                                            </select>
                    </div>			
                </div>
				<div id="customerpanel" class="form-group row">
                    <label for="toBizName" class="caption col-sm-2 col-form-label">Documento</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="doc2" placeholder="Numero documento" />
                    </div>
                </div>
				<div id="customerpanel" class="form-group row">
                    <label for="toBizName" class="caption col-sm-2 col-form-label">Celular</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="cel" placeholder="Numero celular" />
                    </div>
                </div>
				<div id="customerpanel" class="form-group row">
                    <label for="toBizName" class="caption col-sm-2 col-form-label">Observacion</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="observ" placeholder="detalles" />
                    </div>
                </div>
                        <button type="button" class="btn btn-default"
                                data-dismiss="modal">Volver</button>
                        <input type="hidden" id="action-url" value="customers/act_titular">
                        <button type="button" class="btn btn-primary"
                                id="submit_model2">Realizar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div id="pop_model" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Observacion</h4>
            </div>			
            <div class="modal-body">
                <form id="form_model">
					<div class="form-group row">						
                    <div class="frmSearch">
						<label for="cst" class="caption col-sm-2 col-form-label">Tipo</label>
                        <div class="col-sm-6">
							<input type="hidden" name="iduser2" value="<?php echo $details['id'] ?>"></input>
							<select class="form-control" name="tipo">
													<option value="Sobre Cuenta">Sobre Cuenta</option>
                                                	<option value="Sobre Datos">Sobre Datos</option>
                                                  	<option value="Sobre Equipo">Sobre Equipo</option>
                                                	<option value="Otros">Otros</option>
                                            </select>
                        </div>
                    </div>

                </div>
				<div class="form-group row">
                    <label for="toBizName" class="caption col-sm-2 col-form-label">Detalles</label>
                    <div class="col-sm-10">                        
                        <textarea class="summernote" placeholder=" Message" autocomplete="false" rows="10" name="detalle2"></textarea>
						<input type="hidden" class="form-control" placeholder="Billing Date" name="fecha2" data-toggle="datepicker" autocomplete="false">
                    </div>					
                </div>	
                        <button type="button" class="btn btn-default"
                                data-dismiss="modal">Volver</button>
                        <input type="hidden" id="action-url" value="customers/obser">
                        <button type="button" class="btn btn-primary"
                                id="submit_model">Realizar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="<?php echo base_url('assets/myjs/jquery.ui.widget.js') ?>"></script>
<!-- The basic File Upload plugin -->
<script src="<?php echo base_url('assets/myjs/jquery.fileupload.js') ?>"></script>
<script>
    /*jslint unparam: true */
    /*global window, $ */
    $(function () {
        'use strict';
        // Change this to the location of your server-side upload handler:
        var url = '<?php echo base_url() ?>customers/displaypic?id=<?php echo $details['id'] ?>';
        $('#fileupload').fileupload({
            url: url,
            dataType: 'json',
            done: function (e, data) {

                //$('<p/>').text(file.name).appendTo('#files');
                $("#dpic").load(function () {
                    $(this).hide();
                    $(this).fadeIn('slow');
                }).attr('src', '<?php echo base_url() ?>userfiles/customers/' + data.result);


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
</script>
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
function eliminar_documento(id){
        var confirmacion = confirm("Deseas Eliminar esta Observacion?");
        if(confirmacion==true){
            $.post(baseurl+"customers/delete_obs",{deleteid:id},function (data){
                alert("Observacion Eliminada...");                
                window.location.reload();
            },'json');
      }
    }

</script>