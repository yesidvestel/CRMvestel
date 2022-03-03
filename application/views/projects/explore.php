<?php $lista_productos_orden=$this->db->get_where('transferencia_products_orden',array('proy_id'=>$id_orden_n))->result_array(); ?>
<div class="app-content content container-fluid">
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="card card-block">
                <div id="notify" class="alert alert-success" style="display:none;">
                    <a href="#" class="close" data-dismiss="alert">&times;</a>

                    <div class="message"></div>
                </div>
                <div class="grid_3 grid_4">
                    <div class="header-block">
                        <h3 class="title">
                            <?php echo $project['name'] ?>
                        </h3>
                        <p><?php echo $this->lang->line('Status') ?>: <span
                                    class="project_<?php echo $project['status'] ?>"><?php echo $this->lang->line($project['status']) ?></span>
                        </p>
                        <p>
                            Asignado a</p>
                        <p><?php
                            foreach ($emp as $row) {

                                echo '<span class="avatar"><img src="' . base_url() . '/userfiles/employee/thumbnail/' . $row['picture'] . '" title="' . $row['name'] . '" alt="' . $row['name'] . '"></span> &nbsp; ';
                            }
                            ?></p></div>
                    <p>&nbsp;</p>
                    <div class="row">
                        <div class="col-xl-3 col-lg-6 col-xs-6">
                            <div class="card">
                                <div class="card-body">
                                    <div class="card-block">
                                        <div class="media">
                                            <div class="media-body text-xs-left">
                                                <h3 class="pink" id="dash_0"></h3>
                                                <span><?php echo $this->lang->line('Due') ?></span>
                                            </div>
                                            <div class="media-right media-middle">
                                                <i class="icon-clock3 pink font-large-2 float-xs-right"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-lg-6 col-xs-6">
                            <div class="card">
                                <div class="card-body">
                                    <div class="card-block">
                                        <div class="media">
                                            <div class="media-body text-xs-left">
                                                <h3 class="indigo" id="dash_1"></h3>
                                                <span><?php echo $this->lang->line('Progress') ?></span>
                                            </div>
                                            <div class="media-right media-middle">
                                                <i class="icon-spinner5 indigo font-large-2 float-xs-right"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-lg-6 col-xs-6">
                            <div class="card">
                                <div class="card-body">
                                    <div class="card-block">
                                        <div class="media">
                                            <div class="media-body text-xs-left">
                                                <h3 class="green" id="dash_2"></h3>
                                                <span><?php echo $this->lang->line('Done') ?></span>
                                            </div>
                                            <div class="media-right media-middle">
                                                <i class="icon-clipboard2 green font-large-2 float-xs-right"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-lg-6 col-xs-6">
                            <div class="card">
                                <div class="card-body">
                                    <div class="card-block">
                                        <div class="media">
                                            <div class="media-body text-xs-left">
                                                <h3 class="deep-cyan" id="dash_6"><?php echo $totalt ?></h3>
                                                <span><?php echo $this->lang->line('Total') ?></span>
                                            </div>
                                            <div class="media-right media-middle">
                                                <i class="icon-stats-bars22 deep-cyan font-large-2 float-xs-right"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                </div>

                <input type="hidden" id="dashurl" value="projects/task_stats?id=<?php echo $project['id']; ?>">
                <div class="card">
                    <div class="card-body">
                        <div class="card-block">
                            <p></p>
                            <ul class="nav nav-tabs nav-justified">
                                <li class="nav-item">
                                    <a class="nav-link active" id="active-tab" data-toggle="tab" href="#active"
                                       aria-controls="active"
                                       aria-expanded="true"><?php echo $this->lang->line('Summary') ?></a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="link-tab" data-toggle="tab" href="#link"
                                       aria-controls="link"
                                       aria-expanded="false"><?php echo $this->lang->line('Tasks') ?></a>
                                </li>

                                <li class="nav-item">
                                    <a class="nav-link" id="thread-tab" data-toggle="tab" href="#thread"
                                       aria-controls="thread"><?php echo $this->lang->line('Thread') ?></a>
                                </li>

                                <li class="nav-item">
                                    <a class="nav-link" id="milestones-tab" data-toggle="tab" href="#milestones"
                                       aria-controls="milestones"><?php echo $this->lang->line('Activities') ?></a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="thread-tab" data-toggle="tab" href="#activities"
                                       aria-controls="activities"><?php echo $this->lang->line('Bill') ?></a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="linkOpt-tab" data-toggle="tab" href="#files"
                                       aria-controls="files"><?php echo $this->lang->line('Files') ?></a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="linkOpt-tab" data-toggle="tab" href="#notes"
                                       aria-controls="notes"><?php echo $this->lang->line('Notes') ?></a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="invoices-tab" data-toggle="tab" href="#invoices"
                                       aria-controls="invoices">Materiales</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="comments-tab" data-toggle="tab" href="#comments"
                                       aria-controls="comments"><?php echo $this->lang->line('Comments') ?></a>
                                </li>
                            </ul>
                            <div class="tab-content px-1 pt-1">
                                <div role="tabpanel" class="tab-pane fade active in" id="active"
                                     aria-labelledby="active-tab" aria-expanded="true">
                                    <div class="table-responsive col-sm-12">
                                        <table class="table">

                                            <tbody>
                                            <tr>
                                                <th scope="row"><?php echo $this->lang->line('Name') ?></th>
                                                <td>
                                                    <p><?php echo $project['name'] ?></p>

                                                </td>

                                            </tr>
                                            <tr>
                                                <th scope="row"><?php echo $this->lang->line('Priority') ?></th>
                                                <td>
                                                    <p><?php echo $this->lang->line($project['priority']); ?></p>

                                                </td>

                                            </tr>
                                            <tr>
                                                <th scope="row"><?php echo $this->lang->line('Status') ?></th>
                                                <td>
                                                    <p><?php echo $this->lang->line($project['status']) ?></p>

                                                </td>

                                            </tr>
                                            <tr>
                                                <th scope="row"><?php echo $this->lang->line('Progress') ?></th>
                                                <td>
                                                    <input type="range" min="0" max="100"
                                                           value="<?php echo $project['progress'] ?>" class="slider"
                                                           id="progress">
                                                    <p><span id="prog"></span></p>

                                                </td>

                                            </tr>
                                            <tr>
                                                <th scope="row"><?php echo $this->lang->line('Customer') ?></th>
                                                <td>
                                                    <p><?php echo $project['customer'] ?></p>
                                                    <p class="text-muted"><?php echo $project['email'] ?></p>
                                                </td>

                                            </tr>
                                            <tr>
                                                <th scope="row"><?php echo $this->lang->line('Start Date') ?></th>
                                                <td>
                                                    <p><?php echo dateformat($project['sdate']) ?></p>

                                                </td>

                                            </tr>
                                            <tr>
                                                <th scope="row"><?php echo $this->lang->line('Due Date') ?></th>
                                                <td>
                                                    <p><?php echo dateformat($project['edate']) ?></p>

                                                </td>

                                            </tr>
                                            <tr>
                                                <th scope="row"><?php echo $this->lang->line('Tags') ?></th>
                                                <td>
                                                    <p><?php echo $project['tag'] ?></p>

                                                </td>

                                            </tr>
                                            <tr>
                                                <th scope="row"><?php echo $this->lang->line('Phase') ?></th>
                                                <td>
                                                    <p><?php echo $project['phase'] ?></p>

                                                </td>

                                            </tr>
                                            <tr>
                                                <th scope="row"><?php echo $this->lang->line('Budget') ?></th>
                                                <td>
                                                    <p><?php echo amountFormat($project['worth']) ?></p>

                                                </td>

                                            </tr>
                                            <tr>
                                                <th scope="row">Comuinicado a</th>
                                                <td>
                                                    <p><?php switch ($project['ptype']) {
                                                            case 0 :
                                                                echo 'None';
                                                                break;
                                                            case 1 :
                                                                echo $this->lang->line('Emails to team');
                                                                break;

                                                            case 2 :
                                                                echo $this->lang->line('Emails to team &  customer');
                                                                break;
                                                        }

                                                        ?></p>

                                                </td>

                                            </tr>

                                            </tbody>
                                        </table>
                                    </div>

                                </div>
                                <div class="tab-pane fade" id="link" role="tabpanel" aria-labelledby="link-tab"
                                     aria-expanded="false"><p><a
                                                href="<?php echo base_url('projects/addtask?id=' . $project['id']) ?>"
                                                class="btn btn-primary btn-sm rounded">
                                            <?php echo $this->lang->line('Add new') . ' ' . $this->lang->line('Task') ?>
                                        </a></p>
                                    <table id="todotable" class="display" cellspacing="0" width="100%">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th><?php echo $this->lang->line('Task') ?></th>
                                            <th><?php echo $this->lang->line('Due Date') ?></th>
                                            <th><?php echo $this->lang->line('Start') ?></th>
                                            <th><?php echo $this->lang->line('Status') ?></th>
                                            <th><?php echo $this->lang->line('Actions') ?></th>


                                        </tr>
                                        </thead>
                                        <tbody>

                                        </tbody>

                                    </table>
                                </div>
                                <!--thread-->
                                <div class="tab-pane fade" id="thread" role="tabpanel" aria-labelledby="thread-tab"
                                     aria-expanded="false">

                                    <ul class="timeline">
                                        <?php $flag = true;
                                        $total = count($thread_list);
                                        foreach ($thread_list as $row) {


                                            ?>
                                            <li class="<?php if (!$flag) {
                                                echo 'timeline-inverted';
                                            } ?>">
                                                <div class="timeline-badge info"><?php echo $total ?></div>
                                                <div class="timeline-panel">
                                                    <div class="timeline-heading">
                                                        <h4 class="timeline-title"><?php echo $row['name'] ?></h4>
                                                        <p>
                                                            <small class="text-muted"><i
                                                                        class="glyphicon glyphicon-time"></i> <?php echo $row['emp'] . ' ' . $row['start'] . ' ~ ' . $row['duedate'] ?>
                                                            </small>
                                                        </p>
                                                    </div>
                                                    <div class="timeline-body">
                                                        <p><?php echo $row['description'] ?></p>
                                                    </div>
                                                </div>
                                            </li>
                                            <?php $flag = !$flag;
                                            $total--;
                                        } ?>


                                    </ul>


                                </div>
                                <!--thread-->
                                <!--milestones-->
                                <div class="tab-pane fade" id="milestones" role="tabpanel"
                                     aria-labelledby="milestones-tab" aria-expanded="false">
                                    <p><a href="<?php echo base_url('projects/addmilestone?id=' . $project['id']) ?>"
                                          class="btn btn-primary btn-sm rounded">
                                            <?php echo $this->lang->line('Add Activity') ?>
                                        </a></p>

                                    <ul class="timeline">
                                        <?php $flag = true;
                                        $total = count($milestones);
                                        foreach ($milestones as $row) {


                                            ?>
                                            <li data-block="sec" class="<?php if (!$flag) {
                                                echo 'timeline-inverted';
                                            } ?>">
                                                <div class="timeline-badge"
                                                     style="background-color: <?php echo $row['color'] ?>;"><?php echo $total ?></div>
                                                <div class="timeline-panel">
                                                    <div class="timeline-heading">
                                                        <h4 class="timeline-title"><?php echo $row['name'] ?></h4>
                                                        <p>
                                                            <small class="text-muted"><i
                                                                        class="glyphicon glyphicon-time"></i> <?php echo $row['sdate'] . ' ~ ' . $row['edate'] . '</small><a href="#" class=" float-xs-right delete-custom" data-did="2" data-object-id="' . $row['id'] . '"><i class="danger icon-trash-o"></i></a>'; ?>
                                                        </p>
                                                    </div>
                                                    <div class="timeline-body">
                                                        <p><?php echo $row['exp'];
                                                            if ($row['task']) echo '</p><p><strong>[Task]</strong> ' . $row['task']; ?></p>

                                                    </div>
                                                </div>
                                            </li>
                                            <?php $flag = !$flag;
                                            $total--;
                                        } ?>


                                    </ul>

                                </div>
                                <!--milestones-->
                                <!--activities-->
                                <div class="tab-pane fade" id="activities" role="tabpanel"
                                     aria-labelledby="activities-tab" aria-expanded="false"><p><a
                                                href="<?php echo base_url('projects/addactivity?id=' . $project['id']) ?>"
                                                class="btn btn-primary btn-sm rounded">
                                            Añadir
                                        </a></p>
                                    <?php foreach ($activities as $row) { ?>


                                        <div class="form-group row">


                                            <div class="col-sm-10">
                                                <?php

                                                echo '- ' . $row['value'] . '<br><br>';


                                                ?>
                                            </div>
                                        </div>
                                    <?php }
                                    ?>
                                </div>
                                <!--activities-->
                                <!--files-->
                                <div class="tab-pane fade" id="files" role="tabpanel" aria-labelledby="files-tab"
                                     aria-expanded="false">
                                    <p>
                                        <?php foreach ($p_files as $row) { ?>


                                            <section class="form-group row">


                                                <div data-block="sec" class="col-sm-12">
                                                    <div class="card card-block"><?php


                                                        echo '<a href="' . base_url('userfiles/project/' . $row['value']) . '">' . $row['value'] . '</a><a href="#" class="btn btn-danger float-xs-right delete-custom" data-did="1" data-object-id="' . $row['meta_data'] . '"><i class="icon-trash-b"></i></a> ';

                                                        echo '<br><br>';
                                                        ?></div>
                                                </div>
                                            </section>
                                        <?php } ?>
                                    </p>
                                    <span class="btn btn-success fileinput-button">
        <i class="glyphicon glyphicon-plus"></i>
        <span>...</span>
                                        <!-- The file input field used as target for the file upload widget -->
        <input id="fileupload" type="file" name="files[]" multiple>
    </span>
                                    <br>
                                    <br>
                                    <!-- The global progress bar -->
                                    <div id="progress" class="progress">
                                        <div class="progress-bar progress-bar-success"></div>
                                    </div>
                                    <!-- The container for the uploaded files -->
                                    <div id="files" class="files"></div>
                                    <br>
                                </div>
                                <!--Files-->
                                <!--notes-->
                                <div class="tab-pane fade" id="notes" role="tabpanel" aria-labelledby="notes-tab"
                                     aria-expanded="false">
                                    <form method="post" id="data_form">
                                        <div class="form-group row">


                                            <div class="col-sm-12">
                        <textarea class="summernote"
                                  placeholder=" Note"
                                  autocomplete="false" rows="10"
                                  name="content"><?php echo $project['note']; ?></textarea>
                                            </div>
                                        </div>
                                        <div class="form-group row">


                                            <div class="col-sm-10">
                                                <input type="submit" class="btn btn-success sub-btn"
                                                       value="<?php echo $this->lang->line('Update') ?> "
                                                       id="submit-data" data-loading-text="Creating...">
                                            </div>
                                        </div>
                                        <input type="hidden" value="projects/set_note" id="action-url">
                                        <input type="hidden" value="<?php echo $project['id']; ?>" name="nid">
                                    </form>
                                </div>
                                <!--notes-->
                                <!--invoices-->
                                <div class="tab-pane fade" id="invoices" role="tabpanel" aria-labelledby="invoices-tab"
                                     aria-expanded="false">
                                    <p><a href="#pop_model3" data-toggle="modal" onclick="funcion_status();" data-remote="false" class="btn btn-success sub-btn" title="Change Status">ASIGNAR MATERIAL</a></p>

                                    <div class="table-responsive">
                                        <table  class="table-responsive tfr my_stripe" width="80%">
										<thead>
											<tr>
												<th colspan="3" ><h5 align="left"><strong>Material usado en la red</strong></h5></th>
											</tr>
											<tr>
												<th style="text-align: center;" width="10%">PID</th>
												<th style="text-align: center;" width="40%">Nombre</th>
												<th style="text-align: center;" width="30%">Cantidad Tot.</th>
												<th style="text-align: center;" width="20%">Valor a Transferir</th>
											</tr>
										</thead>
										<tbody>

											<?php foreach ($lista_productos_orden as $key => $prod) { $prod_padre=$this->db->get_where('products',array('pid'=>$prod['products_pid']))->row(); ?>        
												<tr>
													<td style="text-align: center;" width="10%"><?=$prod_padre->pid?></td>
													<td style="text-align: center;" width="30%"><?=$prod_padre->product_name?></td>
													<td style="text-align: center;" width="20%"><?=$prod['cantidad']?></td>
													<td style="text-align: center;" width="20%"><a onclick="eliminar_prod_lista(<?=$prod['idtransferencia_products_orden']?>)"><img src="<?=base_url()?>/assets/img/trash.png"></a></td>
												</tr>
											<?php } ?>
										</tbody>
									</table>
                                    </div>

                                </div>
                                <!--invoices-->
                                <!--comments-->
                                <div class="tab-pane fade" id="comments" role="tabpanel" aria-labelledby="comments-tab"
                                     aria-expanded="false">
                                    <p>Cronología de comentarios entre los miembros del equipo y el cliente</p>
                                    <form method="post" id="data_form2">
                                        <div class="form-group row">


                                            <div class="col-sm-12">
                        <textarea class="summernote"
                                  placeholder=" Note"
                                  autocomplete="false" rows="10" name="content"></textarea>
                                            </div>
                                        </div>
                                        <div class="form-group row">


                                            <div class="col-sm-10">
                                                <input type="submit" class="btn btn-success sub-btn"
                                                       value="<?php echo $this->lang->line('Comment') ?> "
                                                       id="submit-data2" data-loading-text="Creating...">
                                            </div>
                                        </div>
                                        <input type="hidden" value="projects/addcomment" id="action-url2">
                                        <input type="hidden" value="<?php echo $project['id']; ?>" name="nid">
                                    </form>
                                    <ul class="timeline">
                                        <?php $flag = true;
                                        $total = count($comments_list);
                                        foreach ($comments_list as $row) {


                                            ?>
                                            <li class="<?php if (!$flag) {
                                                echo 'timeline-inverted';
                                            } ?>">
                                                <div class="timeline-badge info"><?php echo $total ?></div>
                                                <div class="timeline-panel">
                                                    <div class="timeline-heading">
                                                        <h4 class="timeline-title"><?php if ($row['key3']) echo $row['customer'] . ' Reply <small>(Customer)</small>'; else echo $row['employee'] . ' Reply <small>(Employee)</small>'; ?></h4>

                                                    </div>
                                                    <div class="timeline-body">
                                                        <p><?php echo $row['value'] ?></p>
                                                    </div>
                                                </div>
                                            </li>
                                            <?php $flag = !$flag;
                                            $total--;
                                        } ?>


                                    </ul>


                                </div>
                                <!--comments-->


                            </div>
                        </div>
                    </div>
                </div>


                <div id="pop_model" class="modal fade">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;
                                </button>
                                <h4 class="modal-title"><?php echo $this->lang->line('Change Status'); ?></h4>
                            </div>

                            <div class="modal-body">
                                <form id="form_model">


                                    <div class="row">
                                        <div class="col-xs-12 mb-1"><label
                                                    for="status"><?php echo $this->lang->line('Change Status') ?></label>
                                            <select name="stat" class="form-control mb-1" id="status_task">
                                                <?php 
                                                    echo"<option value='Due'>".$this->lang->line('Due')."</option>
                                                    <option value='Done'>".$this->lang->line('Done')."</option>
                                                    <option value='Progress'>".$this->lang->line('Progress')."</option>";
                                                    ?>
                                            </select>

                                        </div>
                                    </div>

                                    <div class="modal-footer">
                                        <input type="hidden" class="form-control"
                                               name="tid" id="taskid" value="">
                                        <button type="button" class="btn btn-default"
                                                data-dismiss="modal"><?php echo $this->lang->line('Close'); ?></button>
                                        <input type="hidden" id="action-url" value="tools/set_task">
                                        <button type="button" class="btn btn-primary"
                                                id="submit_model"><?php echo $this->lang->line('Change Status'); ?></button>
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
								<h4 class="modal-title">Asignar Material</h4>
							</div>
							<div class="modal-body">
								<form id="form_model3">

							<div class="form-group row">

						<div class="col-sm-10">
							<label class="col-sm-4 col-form-label" for="name">Nombre del articulo</label> 
							<select class="form-control select-box" id="lista_productos" name="lista_productos[]" multiple="multiple" style="width: 100%;">
								<?php foreach ($lista_productos_tecnico as $key => $producto) { ?>
									<option value="<?=$producto['pid']?>"  data-qty="<?=$producto['qty']?>" data-pid="<?=$producto['pid']?>" data-product_name="<?=$producto['product_name']?>" ><?=$producto['product_name']?></option>
							   <?php } ?>
							</select>
						</div>
									 </div>   
									 <table width="80%" style="text-align: center;" class="table-responsive tfr my_stripe">
											<thead >
												<tr>
													<th style="text-align: center;" width="10%">PID</th>
													<th style="text-align: center;" width="30%">Nombre</th>
													<th style="text-align: center;" width="20%">Cantidad Tot.</th>
													<th style="text-align: center;" width="20%">Valor a Transferir</th>
												</tr>
											</thead>
											<tbody id="itemsx">
												<tr id="remover_fila">
													<td>PID</td>
													<td>Nombre</td>
													<td>##</td>
													<td><input type="number" name="" data-max="5" data-pid="0" class="form-control" onfocusout="validar_numeros(this);" disabled></td>   
												</tr>
											</tbody>
										</table>
										<br>
										<input  type="button" class="btn btn-primary" value="Agregar" onclick="guardar_productos()">
										<button type="button" class="btn btn-default" data-dismiss="modal">Volver</button>

									</div>
								</form>
							</div>
						</div>
					</div>
				</div>

                <div id="task_model" class="modal fade">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;
                                </button>
                                <h4 class="modal-title" id="task_title"><?php echo $this->lang->line('Details'); ?></h4>
                            </div>

                            <div class="modal-body">
                                <form id="form_model">


                                    <div class="row">
                                        <div class="col-xs-12 mb-1" id="description">

                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-xs-12 mb-1"><?php echo $this->lang->line('Priority') ?> <strong><span
                                                        id="priority"></span></strong>

                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-12 mb-1"><?php echo $this->lang->line('Assigned to') ?>
                                            <strong><span
                                                        id="employee"></span></strong>

                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-12 mb-1"><?php echo $this->lang->line('Assigned by') ?>
                                            <strong><span
                                                        id="assign"></span></strong>

                                        </div>
                                    </div>
                                    <div class="row" >
                                        <div class="col-xs-12 mb-1">Puntuación
                                            <strong><span
                                                        id="puntuacion"></span></strong>

                                        </div>
                                    </div>

                                    <div class="modal-footer">
                                        <input type="hidden" class="form-control"
                                               name="tid" id="taskid" value="">
                                        <button type="button" class="btn btn-default"
                                                data-dismiss="modal"><?php echo $this->lang->line('Close'); ?></button>

                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- add task -->
    <!--dynamic delete -->
    <div id="delete_model_1" class="modal fade">
        <form id="mform_1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                    aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title"><?php echo $this->lang->line('Delete') ?></h4>
                    </div>

                    <div class="modal-footer">
                        <input type="hidden" name="project_id" value="<?php echo $project['id']; ?>">
                        <input type="hidden" id="object-id_1" value="" name="object_id">
                        <input type="hidden" id="action-url_1" value="projects/delete_file">
                        <button type="button" data-dismiss="modal" class="btn btn-primary delete-confirm"
                                id="delete-confirm_1"><?php echo $this->lang->line('Delete') ?></button>
                        <button type="button" data-dismiss="modal"
                                class="btn"><?php echo $this->lang->line('Cancel') ?></button>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <!--dynamic delete 2-->
    <div id="delete_model_2" class="modal fade">
        <form id="mform_2">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                    aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title"><?php echo $this->lang->line('Delete') ?></h4>
                    </div>

                    <div class="modal-footer">

                        <input type="hidden" id="object-id_2" value="" name="object_id">
                        <input type="hidden" id="action-url_2" value="projects/delete_milestone">
                        <button type="button" data-dismiss="modal" class="btn btn-primary delete-confirm"
                                id="delete-confirm_2"><?php echo $this->lang->line('Delete') ?></button>
                        <button type="button" data-dismiss="modal"
                                class="btn"><?php echo $this->lang->line('Cancel') ?></button>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <!-- 3 -->
    <div id="delete_model_3" class="modal fade">
        <form id="mform_3">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                    aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title"><?php echo $this->lang->line('Delete') ?></h4>
                    </div>
                    <div class="modal-body">
                        <p><?php echo $this->lang->line('delete this task') ?> </p>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" id="object-id_3" value="" name="deleteid">
                        <input type="hidden" id="action-url_3" value="tools/delete_i">
                        <button type="button" data-dismiss="modal" class="btn btn-primary delete-confirm"
                                id="delete-confirm_3"><?php echo $this->lang->line('Delete') ?></button>
                        <button type="button" data-dismiss="modal"
                                class="btn"><?php echo $this->lang->line('Cancel') ?></button>
                    </div>
                </div>
            </div>
    </div>

    <script type="text/javascript">

        $(document).ready(function () {

            $('#todotable').DataTable({

                "processing": true,
                "serverSide": true,
                'createdRow': function (row, data, dataIndex) {
                    $(row).attr('data-block', '0');
                },
                "order": [],
                "ajax": {
                    "url": "<?php echo site_url('projects/todo_load_list')?>",
                    "type": "POST",
                    data: {'pid':<?php echo $project['id']; ?>}
                },
                "columnDefs": [
                    {
                        "targets": [1],
                        "orderable": true,
                    },
                ],

            });

            $(function () {
                $('.select-box').select2();

                $('.summernote').summernote({
                    height: 250,
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

            $(document).on('click', ".set-task", function (e) {
                e.preventDefault();
                $('#taskid').val($(this).attr('data-id'));
                $("#status_task").val($(this).attr('data-stat'));
                $('#pop_model').modal({backdrop: 'static', keyboard: false});

            });


            $(document).on('click', ".view_task", function (e) {
                e.preventDefault();

                var actionurl = 'tools/view_task';
                var id = $(this).attr('data-id');
                $('#task_model').modal({backdrop: 'static', keyboard: false});


                $.ajax({

                    url: baseurl + actionurl,
                    type: 'POST',
                    data: {'tid': id},
                    dataType: 'json',
                    success: function (data) {

                        $('#description').html(data.description);
                        $('#task_title').html(data.name);
                        $('#employee').html(data.employee);
                        $('#assign').html(data.assign);
                        if(data.puntuacion==null || data.puntuacion=="null"){
                            $('#puntuacion').html("Sin Puntuacion");    
                        }else{
                            $('#puntuacion').html(data.puntuacion);
                        }
                        
                        $('#priority').html(data.priority);
                    }

                });

            });
            miniDash();


        });

    </script>
    <script src="<?php echo base_url('assets/vendors/js/upload/jquery.iframe-transport.js') ?>"></script>
    <script src="<?php echo base_url('assets/vendors/js/upload/jquery.ui.widget.js') ?>"></script>
    <script src="<?php echo base_url('assets/vendors/js/upload/load-image.all.min.js') ?>"></script>
    <script src="<?php echo base_url('assets/vendors/js/upload/canvas-to-blob.min.js') ?>"></script>
    <!-- The basic File Upload plugin -->
    <script src="<?php echo base_url('assets/vendors/js/upload/jquery.fileupload.js') ?>"></script>
    <!-- The File Upload processing plugin -->
    <script src="<?php echo base_url('assets/vendors/js/upload/jquery.fileupload-process.js') ?>"></script>
    <!-- The File Upload image preview & resize plugin -->
    <script src="<?php echo base_url('assets/vendors/js/upload/jquery.fileupload-image.js') ?>"></script>
    <!-- The File Upload audio preview plugin -->
    <script src="<?php echo base_url('assets/vendors/js/upload/jquery.fileupload-audio.js') ?>"></script>
    <!-- The File Upload video preview plugin -->
    <script src="<?php echo base_url('assets/vendors/js/upload/jquery.fileupload-video.js') ?>"></script>
    <!-- The File Upload validation plugin -->
    <script src="<?php echo base_url('assets/vendors/js/upload/jquery.fileupload-validate.js') ?>"></script>

    <script>
        /*jslint unparam: true, regexp: true */
        /*global window, $ */
        $(function () {
            'use strict';
            // Change this to the location of your server-side upload handler:
            var url = baseurl + 'projects/file_handling?id=<?php echo $project['id']; ?>',
                uploadButton = $('<button/>')
                    .addClass('btn btn-primary')
                    .prop('disabled', true)
                    .text('Processing...')
                    .on('click', function () {
                        var $this = $(this),
                            data = $this.data();
                        $this
                            .off('click')
                            .text('Abort')
                            .on('click', function () {
                                $this.remove();
                                data.abort();
                            });
                        data.submit().always(function () {
                            $this.remove();
                        });
                    });
            $('#fileupload').fileupload({
                url: url,
                dataType: 'json',
                autoUpload: false,
                acceptFileTypes: /(\.|\/)(gif|jpe?g|png|docx|docs|txt|pdf|xls)$/i,
                maxFileSize: 999000,
                // Enable image resizing, except for Android and Opera,
                // which actually support image resizing, but fail to
                // send Blob objects via XHR requests:
                disableImageResize: /Android(?!.*Chrome)|Opera/
                    .test(window.navigator.userAgent),
                previewMaxWidth: 100,
                previewMaxHeight: 100,
                previewCrop: true
            }).on('fileuploadadd', function (e, data) {
                data.context = $('<div/>').appendTo('#files');
                $.each(data.files, function (index, file) {
                    var node = $('<p/>')
                        .append($('<span/>').text(file.name));
                    if (!index) {
                        node
                            .append('<br>')
                            .append(uploadButton.clone(true).data(data));
                    }
                    node.appendTo(data.context);
                });
            }).on('fileuploadprocessalways', function (e, data) {
                var index = data.index,
                    file = data.files[index],
                    node = $(data.context.children()[index]);
                if (file.preview) {
                    node
                        .prepend('<br>')
                        .prepend(file.preview);
                }
                if (file.error) {
                    node
                        .append('<br>')
                        .append($('<span class="text-danger"/>').text(file.error));
                }
                if (index + 1 === data.files.length) {
                    data.context.find('button')
                        .text('Upload')
                        .prop('disabled', !!data.files.error);
                }
            }).on('fileuploadprogressall', function (e, data) {
                var progress = parseInt(data.loaded / data.total * 100, 10);
                $('#progress .progress-bar').css(
                    'width',
                    progress + '%'
                );
            }).on('fileuploaddone', function (e, data) {
                $.each(data.result.files, function (index, file) {
                    if (file.url) {
                        var link = $('<a>')
                            .attr('target', '_blank')
                            .prop('href', file.url);
                        $(data.context.children()[index])
                            .wrap(link);
                    } else if (file.error) {
                        var error = $('<span class="text-danger"/>').text(file.error);
                        $(data.context.children()[index])
                            .append('<br>')
                            .append(error);
                    }
                });
            }).on('fileuploadfail', function (e, data) {
                $.each(data.files, function (index) {
                    var error = $('<span class="text-danger"/>').text('File upload failed.');
                    $(data.context.children()[index])
                        .append('<br>')
                        .append(error);
                });
            }).prop('disabled', !$.support.fileInput)
                .parent().addClass($.support.fileInput ? undefined : 'disabled');
        });

        var slider = $('#progress');
        var textn = $('#prog');
        textn.text(slider.val() + '%');
        $(document).on('change', slider, function (e) {
            e.preventDefault();
            textn.text($('#progress').val() + '%');
            $.ajax({

                url: baseurl + 'projects/progress',
                type: 'POST',
                data: {'pid':<?php echo $project['id']; ?>, 'val': $('#progress').val()},
                dataType: 'json',
                success: function (data) {

                    $('#description').html(data.description);
                    $('#task_title').html(data.name);
                    $('#employee').html(data.employee);
                    $('#assign').html(data.assign);
                    $('#priority').html(data.priority);
                }

            });
        });
	var id_orden_n="<?=$id_orden_n?>";

    $("#lista_productos").select2();
    let listaProductos=[];
    $("#lista_productos").on('select2:select',function(e){
                var itemSeleccionado;
                itemSeleccionado= {pid:e.params.data.element.dataset.pid,qty:e.params.data.element.dataset.qty,product_name:e.params.data.element.dataset.product_name};

                
                listaProductos.push(itemSeleccionado);
                $("#remover_fila").html('');
                var max_var=itemSeleccionado.qty;
                if(max_var<0){
                    max_var=0;
                }
                $("#itemsx").append('<tr id="fila_'+itemSeleccionado.pid+'"> <td>'+itemSeleccionado.pid+'</td><td>'+itemSeleccionado.product_name+'</td>       <td>'+itemSeleccionado.qty+'</td>           <td><input type="number" name="" data-max="'+max_var+'" data-pid="'+itemSeleccionado.pid+'" class="form-control" onfocusout="validar_numeros(this);" value="'+max_var+'"></td>     </tr>');

console.log(e);
console.log(itemSeleccionado);
                 
            });

        $("#lista_productos").on("select2:unselect",function(e){
        console.log("eliminado "+e.params.data.element.dataset.pid);
        
        $("#fila_"+e.params.data.element.dataset.pid).remove();
        var remove_index=0;
        $(listaProductos).each(function(index,value){
            if(e.params.data.element.dataset.pid==value.pid){
                remove_index=index;
            }    
            
            
        });
        listaProductos.splice(remove_index,1);
        
    });


    function guardar_productos(){
        var datos_lista=$("#lista_productos").val();
        if(datos_lista==null){
            $("#lista_productos").attr("required", true);
            $("#document_add").click();
            setTimeout(function(){
            $("#lista_productos").attr("required", false);    
            },1000);
        }else{
         $.post(baseurl+"projects/add_products_orden",{lista:listaProductos,id_orden_n:id_orden_n},function(data){
                alert("Productos Agregados");
                window.location.reload();
            });   
        }
    }

    function validar_numeros (input){
        var valorInput =parseInt($(input).val());
        var valorMaximo = parseInt($(input).data('max'));
        var valor_pid=parseInt($(input).data('pid'));
        if(isNaN(valorInput)){
            $(input).val(0);
        }else if(valorInput<0){
            $(input).val(0);    
        }else if(valorInput>valorMaximo){
            $(input).val(valorMaximo);
        }
        // cambia el valor total del la listaProductos y pasar los valores al input para que se envien al submit
        valorInput =parseInt($(input).val());
        var index_cambiar=0;
        $(listaProductos).each(function(index,value){
            if(value.pid==valor_pid){
                index_cambiar=index;
            }
        });
        listaProductos[index_cambiar].qty=valorInput;
    }

    function eliminar_prod_lista(idtransferencia_products_orden){
        var confirmacion =confirm("¿Deseas realmente eliminar este item ?");
        if(confirmacion==true){
            $.post(baseurl+"tickets/eliminar_prod_lista",{id:idtransferencia_products_orden},function(data){
                alert("Producto Eliminado");
                window.location.reload();
            });
        }
    }

    </script>