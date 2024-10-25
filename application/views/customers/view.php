<style>
    .checks_conf{
        cursor: pointer;
        transform: scale(3);
    }
    #tb_checks_conf tr td{
        text-align: center;
        /*border: 1px solid black;*/
        padding-top: 10px;
    }
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
.st-Evento
{
 background-color: #46882B;
}
.st-Reportado
{
 background-color: #2C60A7;
}
.st-Dado
{
 background-color: #A8531A;
}
.st-Por
{
 background-color: #180E97;
}
.st-Depurado
{
 background-color: darkcyan;
}
.st-Cartera
{
 background-color:darkgoldenrod;
}
.btn {
    white-space: normal;
    text-align: center;
    font-size: 14px; /* Ajustar tamaño de fuente */
    padding: 10px 15px; /* Ajustar padding para que el botón no sea tan grande */
}
<?php 
 $deuda=$due['total']-$due['pamnt'];
 $equipos=$details['macequipo'];
	
?>
</style>
<div class="app-content content container-fluid">
    <div class="content-wrapper">
        <div id="notify" class="alert alert-success" style="display:none;">
            <a href="#" class="close" data-dismiss="alert">&times;</a>

            <div class="message"></div>
        </div>
        <div id="alerta_update_camps"></div>

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
									<?php if ($this->aauth->get_user()->roleid == 5 || $this->aauth->get_user()->conftem != null) { ?>
                                    <div class="col-md-6">
                                        <a href="<?php echo base_url('customers/edit?id=' . $details['id']) ?>"
                                           class="btn btn-info btn-md"><i
                                                    class="icon-pencil"></i> <?php echo $this->lang->line('Edit Profile') ?>
                                        </a>
                                    </div>
									<?php } ?>
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
											<span class="tag tag-default tag-pill float-xs-right st-<?php echo $servicios['estado']?>"><?php echo $servicios['estado']?></span>
											Estado Servicio
                                        </li>
										<li class="list-group-item">
											<span class="tag tag-default tag-pill bg-primary float-xs-right"><?php if ($servicios['television']!=="no"){ echo $servicios['television'];} if ($servicios['combo']!=="no"){ echo ' + '.$servicios['combo'];}if ($servicios['puntos']!=='0'){ echo ' + '.$servicios['puntos'].' Puntos';}?></span>
											Servicios
                                        </li>
                                        <li class="list-group-item">
                                            <span class="tag tag-default tag-pill bg-primary float-xs-right"><?php echo amountFormat($money['credit']-$money['debit']) ?></span>
                                            <?php echo $this->lang->line('Income') ?>
											
                                        </li>
                                        <li class="list-group-item">
                                            <span class="tag tag-default tag-pill bg-danger float-xs-right"><?php echo amountFormat($money['debit']) ?></span>
                                            <?php echo $this->lang->line('Expenses') ?>
                                        </li>

                                        <li class="list-group-item">
                                            <span class="tag tag-default tag-pill bg-danger float-xs-right"><?php echo amountFormat(($due['total']-$due['pamnt'])) ?></span>
                                            <?php echo $this->lang->line('') ?>TOTAL A PAGAR
											
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
                             <strong>DATOS DE INTEGRACION</strong> <i class="icon-circle" style="color: <?= $color?>;"></i><i class="icon-circle" style="color: <?= $color?>;"></i><i class="icon-circle" style="color: <?= $color?>;"></i><i class="icon-circle" style="color: <?= $color?>;"></i>
                            <hr>                                  
                                    <?php if ($this->aauth->get_user()->roleid > 4) { ?>
                                    <a class="btn btn-success" href="<?=base_url().'customers/edita_estado_usuario?username='.$details['name_s'].'&id_cm='.$details['id']?>&id_sede=<?=$details['gid']?>"><?= ($estado_mikrotik=='true') ? "Activar" : "Desactivar" ?></a>                                 
                                	<?php } ?>
                                
                                <div class="col-md-12">
									<div class="col-md-3">
									<strong><?php echo $this->lang->line('') ?>Mikrotik:</strong>
									</div>
									<div class="col-md-8">
                                    <?php echo $customergroup['title'] ?> 
									</div>
                                </div>
                                <div class="col-md-12">
									<div class="col-md-3">
									<strong><?php echo $this->lang->line('') ?>Usuario:</strong>
									</div>
									<div class="col-md-9">
                                    <?php echo $details['name_s'] ?>
									</div>
                                </div>
                                <div class="col-md-12">
									<div class="col-md-3">
									<strong><?php echo $this->lang->line('') ?>Pasword:</strong>
									</div>
									<div class="col-md-9">
                                    <?php echo $details['contra'] ?>
									</div>
                                </div>
                                <div class="col-md-12">
									<div class="col-md-3">
									<strong><?php echo $this->lang->line('') ?>Servicio:</strong>
									</div>
									<div class="col-md-9">
                                    <?php echo $details['servicio'] ?>
									</div>
                                </div>
                                <div class="col-md-12">
									<div class="col-md-3">
									<strong><?php echo $this->lang->line('') ?>Perfil:</strong>
									</div>
									<div class="col-md-9">
                                    <?php echo $details['perfil'] ?>
									</div>
                                </div>
                                 <div class="col-md-12">
									<div class="col-md-3">
									<strong><?php echo $this->lang->line('') ?>Local:</strong>
									</div>
									<div class="col-md-9">
                                    <?php echo $details['Iplocal'] ?>
									</div>
                                </div>
                                <div class="col-md-12">
									<div class="col-md-3">
									<strong><?php echo $this->lang->line('') ?>Remota:</strong>
									</div>
									<div class="col-md-9">
                                    <?php echo $details['Ipremota'] ?>
									</div>
                                </div>
                                <div class="col-md-12">
									<div class="col-md-3">
									<strong><?php echo $this->lang->line('') ?>Comt/rio:</strong>
									</div>
									<div class="col-md-9">
                                    <?php echo $details['comentario'] ?>
									</div>
                                </div>
								<div class="col-md-12">
									<div class="col-md-3">
									<strong><?php echo $this->lang->line('') ?>T/sistema:</strong>
									</div>
									<div class="col-md-2">
                                    <?php echo $equipo['t_instalacion'] ?>
									</div>
									<?php if ($equipo['t_instalacion']=='EOC'){ ?>
									<div class="col-md-7">
									<strong>MAS:</strong> <?php echo $equipo['master'] ?>
									</div>
									<?php }if ($equipo['t_instalacion']=='FTTH'){ ?>
									<div class="col-md-7">
									<strong>Vlan:</strong> <?php echo $equipo['vlan'] ?>
									<strong>Nat:</strong> <?php echo $equipo['nap'] ?>
									<strong>P/to:</strong> <?php echo $equipo['puerto'] ?>
									</div>
									<?php } ?>
                                </div>
                                <div class="row">
								<table class="table table-striped">
									<thead>
									<tr>
										<th><?php echo $this->lang->line('Files') ?></th>
									</tr>
									</thead>
									<tbody id="activity">
									<?php foreach ($attach as $row) {

										echo '<tr><td><a data-url="' . base_url() . 'customers/file_handling?op=delete&name=' . $row['col1'] . '&type='.$row['type'].'&invoice=' . $details['id'] . '" class="aj_delete"><i class="btn-danger btn-lg icon-trash-a"></i></a> <a class="n_item" href="' . base_url() . 'userfiles/attach/' . $row['col1'] . '"> ' . $row['col1'] . ' </a></td></tr>';
									} ?>

									</tbody>
								</table>
								<!-- The fileinput-button span is used to style the file input field as button -->
								<span class="btn btn-success fileinput-button">
								<i class="glyphicon glyphicon-plus"></i>
								
									<!-- The file input field used as target for the file upload widget -->
								<input id="fileupload2" type="file" name="files[]" multiple>
								</span>
								<br>
								<pre>tipos: gif, jpeg, png, docx, docs, txt, pdf, xls </pre>
								<br>
								<!-- The global progress bar -->
								<div id="progress2" class="progress">
									<div class="progress-bar progress-bar-success"></div>
								</div>
								<!-- The container for the uploaded files -->
								<table id="files2" class="files"></table>
								<br>
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
                                    <span id="text_celular"><?php echo $details['celular'] ?></span><input id="input_celular" type="text" class="col-md-6 campo_edicion">&nbsp;<a href="#" data-dato="<?= $details['celular'] ?>"  data-type="celular" style="border-radius: 20px;" id="open_update_celular" class="open_update btn btn-success btn-sm"><span class="icon-pencil"></span></a>&nbsp;<a href="#"  data-type="celular" style="border-radius: 20px;" id="cancel_celular" class="cancel_update btn btn-danger btn-sm"><span class="icon-remove"></span></a>
                                </div>

                            </div>
                            <hr>
							<div class="row m-t-lg">
                                <div class="col-md-2">
                                    <strong><?php echo $this->lang->line('') ?>Celular ADI:</strong>
                                </div>
                                <div class="col-md-10">
                                    <span id="text_celular2"><?php echo $details['celular2'] ?></span><input id="input_celular2" type="text" class="col-md-6 campo_edicion">&nbsp;<a href="#" data-dato="<?= $details['celular2'] ?>" data-type="celular2" style="border-radius: 20px;" id="open_update_celular2" class="open_update btn btn-success btn-sm"><span class="icon-pencil"></span></a>&nbsp;<a href="#"  data-type="celular2" style="border-radius: 20px;" id="cancel_celular2" class="cancel_update btn btn-danger btn-sm"><span class="icon-remove"></span></a>
                                </div>

                            </div>
                            <hr>
							<div class="row m-t-lg">
                                <div class="col-md-2">
                                    <strong><?php echo $this->lang->line('') ?>Correo:</strong>
                                </div>
                                <div class="col-md-10">
                                    <span id="text_email"><?php echo $details['email'] ?></span><input id="input_email" type="email" class="col-md-6 campo_edicion">&nbsp;<a href="#" data-dato="<?= $details['email'] ?>"  data-type="email" style="border-radius: 20px;" id="open_update_email" class="open_update btn btn-success btn-sm"><span class="icon-pencil"></span></a>&nbsp;<a href="#"  data-type="email" style="border-radius: 20px;" id="cancel_email" class=" cancel_update btn btn-danger btn-sm"><span class="icon-remove"></span></a>
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
                                    <strong><?php echo $this->lang->line('') ?>Estrato:</strong>
                                </div>
                                <div class="col-md-10">
                                    <?php echo $details['estrato'] ?>
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
                                    <?php echo  $departamento['departamento'] ?>
                                </div>

                            </div>
                            <hr>
                            <div class="row m-t-lg">
                                <div class="col-md-2">
                                    <strong><?php echo $this->lang->line('') ?>Ciudad:</strong>
                                </div>
                                <div class="col-md-10">
                                    <?php echo $ciudad['ciudad'] ?>
                                </div>

                            </div>
                            <hr>
                            <div class="row m-t-lg">
                                <div class="col-md-2">
                                    <strong><?php echo $this->lang->line('') ?>Localidad:</strong>
                                </div>
                                <div class="col-md-10">
                                    <?php echo $localidad['localidad'] ?>
                                </div>

                            </div>
                            <hr>
                            <div class="row m-t-lg">
                                <div class="col-md-2">
                                    <strong><?php echo $this->lang->line('') ?>Barrio:</strong>
                                </div>
                                <div class="col-md-10">
                                    <?php echo $barrio['barrio'] ?>
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
                                    <?php
									if($details['divnum1']==0){
										$trr='';
									}else{
										$trr=$details['divnum1'];
									}
									if($details['divnum2']==0){
										$apt='';
									}else{
										$apt=$details['divnum2'];
									}
									echo $details['residencia'].", ".$details['referencia'].' '.$details['divicion'].' '.$trr.' '.$details['divicion2'].' '.$apt ?>
                                </div>

                            </div>
                            <hr>
							<div class="row m-t-lg">
                                <div class="col-md-2">
                                    <strong><?php echo $this->lang->line('') ?>Coordenadas:</strong>
                                </div>
                                <div class="col-md-10">
                                    <?php echo $details['coor1'].", ".$details['coor2'] ?>
                                </div>

                            </div>
                            <hr>
							<div class="row m-t-lg">
                                <div class="col-md-2">
                                    <strong>Contrato:</strong>
                                </div>
								<div class="col-md-10">
                                    Realizado el <?php echo $details['f_contrato'] ?>
                                </div>
                                <div class="col-md-10">
                                   <a class="btn btn-primary btn-lg" href="<?php echo 'printpdf?id=' . $details['id']; ?>"><?php echo $this->lang->line('Print') ?></a>
                                   <a class="btn btn-primary btn-lg" href="<?php echo 'printanx?id=' . $details['id']; ?>">Anexos</a>
                                   <a class="btn btn-success btn-lg" href="<?php echo 'firmadigital?id=' . $details['id']; ?>">Firma Digital</a>
                                  	<a class="btn btn-primary btn-lg" href="<?php echo 'subir_huella?id=' . $details['id']; ?>">Subir PNG Huella</a>
                                </div>
                                

                            </div>
                            <hr>
                            <div class="row row-cols-1 row-cols-md-3 g-1 mt-1">
								<?php if ($this->aauth->get_user()->roleid > 3 || $this->aauth->get_user()->co['cocie'] != null) { ?>
                                <div class="col-md-4 mb-1">

                                    <a href="<?php echo base_url('customers/invoices?id=' . $details['id']) ?>"
                                       class="btn btn-primary btn-lg" style="width: 100%"><i
                                                class="icon-file-text2"></i> <?php echo $this->lang->line('View Invoices') ?></a>

                                </div>
								<?php } if ($this->aauth->get_user()->roleid > 2) { ?>
                                <div class="col-md-4 mb-1">
                                    <a href="<?php echo base_url('customers/transactions?id=' . $details['id']) ?>"
                                       class="btn btn-success btn-lg" style="width: 100%"><i
                                                class="icon-money"></i> <?php echo $this->lang->line('View Transactions') ?>
                                    </a>
                                </div>
                                <div class="col-md-4 mb-1">
                                    <a href="<?php echo base_url('quote/create?id=' . $details['id']) ?>"
                                       class="btn btn-primary btn-lg" style="width: 100%"><i
                                                class="icon-ticket"></i> Generar ticket
                                    </a>
                                </div>
								<div class="col-md-4 mb-1">
                                    <a href="<?php echo base_url('customers/hiscuenta?id=' . $details['id']) ?>"
                                       class="btn btn-success btn-lg" style="width: 100%"><i
                                                class="icon-ticket"></i> Historial de Cuenta
                                    </a>
                                </div>						
								
								<div class="col-md-4 mb-1">

                                    <a href="<?php echo base_url('customers/soporte?id=' . $details['id']) ?>"
                                       class="btn btn-primary btn-lg" style="width: 100%"><i
                                                class="icon-ticket"></i> Ver Tickets </a>

                                </div>
								<div class="col-md-4 mb-1">

                                    <a href="<?php echo base_url('customers/equipos?id=' . $details['id']) ?>"
                                       class="btn btn-success btn-lg" style="width: 100%"><i
                                                class="icon-tasks"></i> Ver Equipos</a>

                                </div>
								<?php } if ($this->aauth->get_user()->roleid > 2) { ?>
								<div class="col-md-4 mb-1">

                                    <a href="#pop_model2" data-toggle="modal" onclick="funcion_status();" data-remote="false" 
                                       class="btn btn-primary btn-lg" style="width: 100%"><i
                                                class="icon-user"></i> Cambio Titular </a>

                                </div>
								<div class="col-md-4 mb-1">

                                    <a href="<?php echo base_url('llamadas/index?id=' . $details['id']) ?>"
                                       class="btn btn-success btn-lg" style="width: 100%"><i
                                                class="icon-mobile-phone"></i> Ate. Usuario</a>

                                </div>
								<?php } if ($this->aauth->get_user()->roleid > 3) { ?>
                                <div class="col-md-4 mb-1">

                                    <a href="<?php echo base_url('facturasElectronicas?id=' . $details['id']) ?>"
                                       class="btn btn-primary btn-lg" style="width: 100%"><i
                                                class="icon-file-text2"></i> Facturas Electronicas</a>

                                </div>
								<div class="col-md-4 mb-1">

                                    <a  href="<?php echo base_url('customers/estados?id=' . $details['id']) ?>"
                                       class="btn btn-success btn-lg" style="width: 100%"><i
                                                class="icon-calendar"></i>Historial estados</a>

                                </div>
								<?php } if ($this->aauth->get_user()->roleid > 2) { ?>
								<div class="col-md-4 mb-1">

                                    <a id="link_paz_y_salvo" data-idc="<?=$details['id']  ?>" data-deuda="<?=$deuda ?>" data-equipo="<?=$equipos ?>" href="#" data-url1="<?php echo base_url('customers/pazysalvo?id=' . $details['id'].'&deuda='.$deuda) ?>"
                                       class="btn btn-success btn-lg" style="width: 100%"><i
                                                class="icon-calendar"></i>Paz y Salvo</a>

                                </div>
								<?php } if ($this->aauth->get_user()->roleid > 2) { ?>
								<div class="col-md-4 mb-1">

                                    <a href="#pop_model3" data-toggle="modal" onclick="funcion_status();"
                                       class="btn btn-primary btn-lg" style="width: 100%"><i
                                                class="icon-calendar"></i> Compromiso</a>

                                </div>
								
                                <div class="col-md-4 mb-1">

                                    <a title="Este boton es para que, si el usuario necesita de actualizacion en telefono o correo, aparesca un modal requiriendo esta informacion al visitar el perfil y al ver las facturas de este usuario, da click para configurar esta accion..." 
                                    href="#modal_conf_requerimientos" data-toggle="modal" 
                                       class="btn btn-primary btn-lg" style="width: 100%"><i
                                                class="icon-calendar"></i> Adm. Campos</a>

                                </div>
                                <div class="col-md-4 mb-3">

                                    <a  
                                    href="<?=base_url()."customers/graficas_c?id=".$details['id'] ?>" 
                                       class="btn btn-primary btn-lg" style="width: 100%"><i
                                                class="icon-calendar"></i> Datos Navegacion</a>

                                </div>
								<?php } ?>
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
									<th>Realizado</th>
									<th>Accion</th>


                                </tr>
                                </thead>
                                <tbody id="activity">
                                <?php foreach ($activity as $row) {
									if ($row['tipos']=='Cambio Titular'){
                                    echo '<tr>
                            		<td>' . $row['fecha'] . '</td><td>' . $row['tipos'] . '</td><td>' . $row['nombres'].', '.$row['tdocumento'] .': '.$row['documento2'] . '</td><td>'. $row['colaborador'] . '</td>
									<td><a class="btn btn-danger" onclick="eliminar_documento(' .$row['idn'].')" > <i class="icon-trash-o "></i></a></td>
                        			</tr>';
									}else{
										echo '<tr>
                            		<td>' . $row['fecha'] . '</td><td>' . $row['tipos'] . '</td><td>' . $row['observacion'] .'</td><td>'. $row['colaborador'] . '</td>
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
                    <label for="toBizName" class="caption col-sm-2 col-form-label">Correo</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="email" placeholder="Correo electronico en minusculas" />
                    </div>
                </div>
				<div id="customerpanel" class="form-group row">
                    <label for="toBizName" class="caption col-sm-2 col-form-label">Celular</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="cel" placeholder="Numero celular" />
                    </div>
                </div>
				<div id="customerpanel" class="form-group row">
                    <label for="toBizName" class="caption col-sm-2 col-form-label">Celular 2</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="cel2" placeholder="Numero adicional" />
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
<div id="pop_model3" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Compromiso de pago</h4>
            </div>			
            <div class="modal-body">
                <form id="form_model3">
					<div class="form-group row">						
                    <div class="frmSearch">
						<label for="cst" class="caption col-sm-2 col-form-label">Fecha Limite</label>
                        <div class="col-sm-6">
							<input type="hidden" name="iduser2" value="<?php echo $details['id'] ?>"></input>
							<select class="form-control" name="fechalimite">
									<option value="30 de cada mes">30 de cada mes</option>
									<!--<option value="05 del siguiente mes">05 del siguiente mes</option>-->
							</select>
                        </div>
                    </div>
					</div>
					<div class="form-group row">
					<div class="frmSearch">
						<label for="cst" class="caption col-sm-2 col-form-label">Factura mes</label>
                        <div class="col-sm-6">
							<select name="factura" class="form-control mb-1">
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
                    <label for="toBizName" class="caption col-sm-2 col-form-label">Detalles</label>
                    <div class="col-sm-10">                        
                        <textarea class="summernote" placeholder=" Message" autocomplete="false" rows="10" name="razon"></textarea>
						<input type="hidden" class="form-control" placeholder="Billing Date" name="fecha2" data-toggle="datepicker" autocomplete="false">
                    </div>					
                </div>	
                        <button type="button" class="btn btn-default"
                                data-dismiss="modal">Volver</button>
                        <input type="hidden" id="action-url" value="customers/compromiso">
                        <button type="button" class="btn btn-primary"
                                id="submit_model3">Realizar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div id="modal_informativo" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Usuario Sin Firma Electronica</h4>
            </div>          
            <div class="modal-body">
                <p>Con este mensaje se le informa que el usuario no presenta firma electrónica registrada en el sistema,<br> muchas gracias.</p>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary" onclick='$("#modal_informativo").modal("hide");'>Aceptar</button>
            </div>
        </div>
    </div>
</div>
<div id="modal_informativo_pz" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Advertencia</h4>
            </div>          
            <div class="modal-body">
                <p id="texto_pz">debe</p>
                <p id="equipo_pz">equipo</p>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary" onclick='$("#modal_informativo_pz").modal("hide");'>Aceptar</button>
            </div>
        </div>
    </div>
</div>
<div id="modal_conf_requerimientos" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Configuracion de campos, requeridos para actualizar</h4>
            </div>          
            <div class="modal-body">
                <table align="center" id="tb_checks_conf">
                    <tr>
                        <td>
                             <input type="checkbox" name="ck_celular1" class="checks_conf" <?=(isset($con_camp_f) && $con_camp_f->ck_celular1=="1")? 'checked':'' ?>>
                        </td>
                        <td>
                            <input type="checkbox" name="ck_celular2" class="checks_conf" <?=(isset($con_camp_f) && $con_camp_f->ck_celular2=="1")? 'checked':'' ?>>
                        </td>
                        <td>
                            <input type="checkbox" name="ck_correo" class="checks_conf" <?=(isset($con_camp_f) && $con_camp_f->ck_correo=="1")? 'checked':'' ?>>
                        </td>
                    </tr>
                    <tr>
                         <td>
                            &nbsp;&nbsp;Celular 1&nbsp;&nbsp;
                        </td>
                        <td>
                            &nbsp;&nbsp;Celular ADI&nbsp;&nbsp;
                        </td>
                        <td>
                            &nbsp;&nbsp;Correo&nbsp;&nbsp;
                        </td>
                    </tr>

                </table>
                <div class="form-group row">

                  

                    <div class="col-sm-12">
                        <textarea id="texto_modal_data_conf" class="summernote" placeholder=" Message" autocomplete="false" rows="10" name="texto_modal_data_conf"><?=(isset($con_camp_f)) ? $con_camp_f->description:'Por favor, actualiza los campos que se te solicitan en esta alerta' ?></textarea>

                </div>
                   
            </div>
            <div align="center"> 
                <a href="#" class="btn btn-success cl_guardar_conf" id="btnx1" data-function="<?=$con_camp_f_btn_estado ?>"><?=$con_camp_f_btn_estado ?></a>
            </div>
            <small>Activa o Desactiva la funcionalidad que permite mostrar una alerta en el perfil del usuario y al pagar para que sea necesario editar los campos que selecciones</small>
                
            </div>
            <div class="modal-footer">
                <button class="btn btn-default" onclick='$("#modal_conf_requerimientos").modal("hide");'>Cancelar</button>
                <button class="btn btn-primary cl_guardar_conf" data-function="guardar" >Guardar</button>
            </div>
        </div>
    </div>
</div>
<div id="modal_actualizar_campos" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <!--button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button-->
                <h4 class="modal-title">Actualizar Usuario</h4>
            </div>  
            <div id="alerta_divx1"> </div>    
            <form id="form_actx" method="post">    
            <div class="modal-body">

                    <?php if(isset($con_camp_f)){ ?>
                        <p><?=$con_camp_f->description ?></p>
                        <?php if($con_camp_f->ck_correo==1) {?>
                    <div  class="form-group row">
                        <label for="toBizName" class="caption col-sm-2 col-form-label">Correo</label>
                        <div class="col-sm-6">
                            <input type="email" value="<?= $details['email'] ?>" class="form-control" name="act2_email" placeholder="Correo electronico en minusculas" required />
                        </div>
                    </div>
                        <?php } ?>
                        <?php if($con_camp_f->ck_celular1==1) {?>
                    <div  class="form-group row">
                        <label for="toBizName" class="caption col-sm-2 col-form-label">Celular</label>
                        <div class="col-sm-6">
                            <input type="number" value="<?= $details['celular'] ?>" class="form-control" name="act2_celular" placeholder="Numero celular" required/>
                        </div>
                    </div>
                        <?php } ?>
                        <?php if($con_camp_f->ck_celular2==1){ ?>
                    <div class="form-group row">
                        <label for="toBizName" class="caption col-sm-2 col-form-label">Celular 2</label>
                        <div class="col-sm-6">
                            <input type="number" value="<?= $details['celular2'] ?>" class="form-control" name="act2_celular2" placeholder="Numero adicional" required/>
                        </div>
                    </div>
                <?php }} ?>

                    
            </div>
            <div class="modal-footer">
                <input type="hidden" name="id" value="<?= $details['id']?>">
                <input type="hidden" name="es_correcto" value="0">
                <!--button class="btn btn-default"  onclick="$('#modal_actualizar_campos').modal('hide')">Cancelar</button-->
                <button class="btn btn-primary" >Guardar</button>
            </div>
            </form>
        </div>
    </div>
</div>

<script src="<?php echo base_url('assets/myjs/jquery.ui.widget.js') ?>"></script>
<!-- The basic File Upload plugin -->
<script src="<?php echo base_url('assets/myjs/jquery.fileupload.js') ?>"></script>
<script>

$(document).on("click","#el_correo_es_correcto",function(ev){
    ev.preventDefault();
    $("[name='es_correcto']").val("1");
    $(this).removeClass("btn-primary");
    $(this).addClass("btn-success");
    guardar_datosx_f();
});
    $(document).on("submit","#form_actx",function(ev){
        ev.preventDefault();
        //$("#form_actx").validate();
        guardar_datosx_f();
    });
    function guardar_datosx_f(){
        var datos =$("#form_actx").serialize();
        mostrar_alerta1("alerta_divx1",2,"Cargando...");    
        $.post(baseurl+"customers/save_actx",datos,function(data){
            if(data.status=="Error"){
                mostrar_alerta1("alerta_divx1",3,data.msg);    
            }else{
                mostrar_alerta1("alerta_divx1",1,data.msg);    
                setTimeout(function(){
                    $(location).attr('href',baseurl+"customers/view?id="+id_customer_update);
                },1000);
            }
            
        },'json');
    }
     <?php if(isset($con_camp_f) && $con_camp_f->estado=="Activo"){ ?>
            $("#modal_actualizar_campos").modal({backdrop: 'static', keyboard: false});
   
    <?php } ?>
    
    $(document).on("click",".cl_guardar_conf",function(ev){
        //ev.preventDefault();
        console.log("que pasa");
        var datos_env={};
         datos_env["ck_celular1"]=$('[name=ck_celular1]').prop('checked');
         datos_env['ck_celular2']=$('[name=ck_celular2]').prop('checked');
         datos_env['ck_correo']=$('[name=ck_correo]').prop('checked');
         datos_env['ck_texto_modal_data_conf']=$('#texto_modal_data_conf').val();
         datos_env['accion']=$(this).data("function");
         datos_env['id_c']=id_customer_update;
        $.post(baseurl+"customers/config_camps_faltantes_save",datos_env,function(data){
            
                $("#modal_conf_requerimientos").modal("hide");
                mostrar_alerta1("alerta_update_camps","success","<b>Success: informacion actualizada");
                if(datos_env['accion']=="Activar"){
                    $("#btnx1").text("Desactivar");
                    $("#btnx1").data("function","Desactivar");
                }else{
                    $("#btnx1").text("Activar");
                    $("#btnx1").data("function","Activar");
                }
        });
    });
    //edicion de campos



    $(".cancel_update").hide();
    $(".campo_edicion").hide();
    $(".cancel_update").attr("title","Cancelar");
    $(".open_update").attr("title","Editar");
    var id_customer_update="<?php echo $details['id'] ?>";
    var campos={'celular':false,'celular2':false,'email':false};
    $(document).on("click",'.open_update',function(e){
        e.preventDefault();
        var elementox=this;
        var tipo=$(this).data("type");
        var dato=$(this).data("dato");
        var span =$("#open_update_"+tipo).children()[0];
        $(span).removeClass("icon-pencil");
        $(span).addClass("icon-save");
        $("#text_"+tipo).hide();
        $("#cancel_"+tipo).show();
        $("#input_"+tipo).show();


        var actualizar=false;


        if(campos[tipo]){
            actualizar=true;
        }else{
            actualizar=false;
            campos[tipo]=true;
        }
        if(actualizar){
            console.log("guardar");
            var valor_env=$("#input_"+tipo).val();
            $.post(baseurl+"customers/edit_campos",{'id':id_customer_update,'campo':tipo,'value':valor_env,'dato_anterior':dato},function(data){
                    $("#text_"+tipo).text(valor_env);
                    $(elementox).data("dato",valor_env);
                    mostrar_alerta1("alerta_update_camps","success","<b>Success: </b>Campo <b>"+tipo+"</b> actualizado");
                    cerrar_campo(tipo);
            });    
        }else{
            console.log("primer");
            $("#input_"+tipo).val(dato);    
        }
        
        
    });

    $(document).on("click",'.cancel_update',function(e){
        e.preventDefault();
        
        var tipo=$(this).data("type");
        cerrar_campo(tipo);
        
    });
    function cerrar_campo(campox){
    var span =$("#open_update_"+campox).children()[0];
        $(span).removeClass("icon-save");
        $(span).addClass("icon-pencil");
        $("#text_"+campox).show();
        $("#cancel_"+campox).hide();
        $("#input_"+campox).hide();

        campos[campox]=false;
    }
    //end edicion de campos
    $(document).on("click","#link_paz_y_salvo",function(ev){
        
        var deuda_pz=$(this).data("deuda");
        var equipo_pz=$(this).data("equipo");
        var idc=$(this).data("idc");
        var url1=$(this).data("url1");
        if (deuda_pz>0 || (equipo_pz!=="" && equipo_pz!=="sin asignar" && equipo_pz!==0)) {
            ev.preventDefault();
			
				if(deuda_pz>0){
					$("#texto_pz").text('Tiene un saldo de $'+deuda_pz); 	
                    $("#modal_informativo_pz").modal("show");
				}else{
					$("#texto_pz").text('');
				}
					if(equipo_pz!=="" && equipo_pz!=="sin asignar" && equipo_pz!==0){
						$("#equipo_pz").text('Aun tiene el equipo MAC '+equipo_pz);
                        $("#modal_informativo_pz").modal("show");
					}else{
						$("#equipo_pz").text('');

					}
            
        }else{
            window.location.replace(url1);
        }
    });

    <?= (!$validar_firma) ? '$("#modal_informativo").modal("show");':'' ?>
    

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
	/*jslint unparam: true */
    /*global window, $ */
    $(function () {
        'use strict';
        // Change this to the location of your server-side upload handler:
        var url = '<?php echo base_url() ?>customers/file_handling?id=<?php echo $details['id'] ?>';
        $('#fileupload2').fileupload({
            url: url,
            dataType: 'json',
            done: function (e, data) {
                $.each(data.result.files, function (index, file) {
                    console.log(file);
                    $('#files2').append('<tr><td><a data-url="<?php echo base_url() ?>customers/file_handling?op=delete&name=' + file.name + '&invoice=<?php echo $details['id']."&type=6" ?>" class="aj_delete"><i class="btn-danger btn-sm icon-trash-a"></i> ' + file.name + ' </a></td></tr>');

                });
            },
            progressall: function (e, data) {
                var progress = parseInt(data.loaded / data.total * 100, 10);
                $('#progress2 .progress-bar').css(
                    'width',
                    progress + '%'
                );
            }
        }).prop('disabled', !$.support.fileInput)
            .parent().addClass($.support.fileInput ? undefined : 'disabled');
    });

    $(document).on('click', ".aj_delete", function (e) {
        e.preventDefault();

        var aurl = $(this).attr('data-url');
        var obj = $(this);

        jQuery.ajax({

            url: aurl,
            type: 'GET',
            dataType: 'json',
            success: function (data) {
                obj.closest('tr').remove();
                obj.remove();
            }
        });

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