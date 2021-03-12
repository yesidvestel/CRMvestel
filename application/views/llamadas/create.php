<article class="content">
    <div class="card card-block">
        <div id="notify" class="alert alert-success" style="display:none;">
            <a href="#" class="close" data-dismiss="alert">&times;</a>

            <div class="message"></div>
        </div>
        <form method="post" id="data_form" class="form-horizontal">
            <div class="grid_3 grid_4">

                <h5>Encuesta de calidad de atencion</h5>
                <hr>


               <p class="card card-block"><?php echo '<strong>Fecha orden: </strong> ' . $thread_info['created'];
				echo '<br><strong>Abonado:</strong> ' . $thread_info['abonado'];
                echo '<br><strong>Usuario:</strong> ' . $thread_info['name'] .' '. $thread_info['unoapellido'];
				echo '<br><strong>Documento:</strong> ' . $thread_info['documento'];
				echo '<br><strong>Celular:</strong> ' . $thread_info['celular'];
				echo '<br><strong>Direccion:</strong> ' . $thread_info['nomenclatura'].' '. $thread_info['numero1']. $thread_info['adicionauno'].' N°'. $thread_info['numero2']. $thread_info['adicional2'].' - '. $thread_info['numero3'];
				echo '<br><strong>Barrio:</strong> ' . $thread_info['barrio'];
                echo '<br><strong>Estado:</strong> <span id="pstatus">' . $thread_info['status'];
				echo '<br><strong>Tecnico Asignado:</strong> <span id="pstatus">' . $thread_info['asignado'];
                ?></p>
				<?php echo '<code class="card card-block"><h5 style="text-decoration: underline;">' .$thread_info['detalle'].'</h5>'.strip_tags($thread_info['section'],'<p>')?></code>
					<hr>
					<input type="hidden" name="tecnico" value="<?php echo $thread_info['asignado'] ?>"></input>
					<input type="hidden" name="norden" value="<?php echo $thread_info['codigo'] ?>"></input>
					<input type="hidden" name="detalle" value="<?php echo $thread_info['detalle'] ?>"></input>
					<?php if (strpos($thread_info['subject'], "servicio")!==false) {?>
                    <label class="col-sm-6 col-form-label">¿presentación del técnico en el momento de llegar a la vivienda?</label>

                    <div class="col-sm-6 col-form-label">						
                                        <div class="input-group">
                                            <label class="display-inline-block custom-control custom-radio ml-1">
                                                <input type="radio" name="uno" class="custom-control-input"
                                                       value="1" checked="">
                                                <span class="custom-control-indicator"></span>
                                                <span class="custom-control-description ml-0">1</span>
                                            </label>
                                            <label class="display-inline-block custom-control custom-radio">
                                                <input type="radio" name="uno" class="custom-control-input"
                                                       value="2">
                                                <span class="custom-control-indicator"></span>
                                                <span class="custom-control-description ml-0">2</span>
                                            </label>
											<label class="display-inline-block custom-control custom-radio">
                                                <input type="radio" name="uno" class="custom-control-input"
                                                       value="3">
                                                <span class="custom-control-indicator"></span>
                                                <span class="custom-control-description ml-0">3</span>
                                            </label>
											<label class="display-inline-block custom-control custom-radio">
                                                <input type="radio" name="uno" class="custom-control-input"
                                                       value="4">
                                                <span class="custom-control-indicator"></span>
                                                <span class="custom-control-description ml-0">4</span>
                                            </label>
											<label class="display-inline-block custom-control custom-radio">
                                                <input type="radio" name="uno" class="custom-control-input"
                                                       value="5">
                                                <span class="custom-control-indicator"></span>
                                                <span class="custom-control-description ml-0">5</span>
                                            </label>
                    </div>
                </div>
                <label class="col-sm-6 col-form-label">¿El trato del técnico durante la instalación del servicio?</label>

                    <div class="col-sm-6 col-form-label">						
                                        <div class="input-group">
                                            <label class="display-inline-block custom-control custom-radio ml-1">
                                                <input type="radio" name="dos" class="custom-control-input"
                                                       value="1" checked="">
                                                <span class="custom-control-indicator"></span>
                                                <span class="custom-control-description ml-0">1</span>
                                            </label>
                                            <label class="display-inline-block custom-control custom-radio">
                                                <input type="radio" name="dos" class="custom-control-input"
                                                       value="2">
                                                <span class="custom-control-indicator"></span>
                                                <span class="custom-control-description ml-0">2</span>
                                            </label>
											<label class="display-inline-block custom-control custom-radio">
                                                <input type="radio" name="dos" class="custom-control-input"
                                                       value="3">
                                                <span class="custom-control-indicator"></span>
                                                <span class="custom-control-description ml-0">3</span>
                                            </label>
											<label class="display-inline-block custom-control custom-radio">
                                                <input type="radio" name="dos" class="custom-control-input"
                                                       value="4">
                                                <span class="custom-control-indicator"></span>
                                                <span class="custom-control-description ml-0">4</span>
                                            </label>
											<label class="display-inline-block custom-control custom-radio">
                                                <input type="radio" name="dos" class="custom-control-input"
                                                       value="5">
                                                <span class="custom-control-indicator"></span>
                                                <span class="custom-control-description ml-0">5</span>
                                            </label>
                    </div>
                </div>
                

                <label class="col-sm-6 col-form-label">¿Cómo quedo instalado el servicio en la vivienda?</label>

                    <div class="col-sm-6 col-form-label">						
                                        <div class="input-group">
                                            <label class="display-inline-block custom-control custom-radio ml-1">
                                                <input type="radio" name="tres" class="custom-control-input"
                                                       value="1" checked="">
                                                <span class="custom-control-indicator"></span>
                                                <span class="custom-control-description ml-0">1</span>
                                            </label>
                                            <label class="display-inline-block custom-control custom-radio">
                                                <input type="radio" name="tres" class="custom-control-input"
                                                       value="2">
                                                <span class="custom-control-indicator"></span>
                                                <span class="custom-control-description ml-0">2</span>
                                            </label>
											<label class="display-inline-block custom-control custom-radio">
                                                <input type="radio" name="tres" class="custom-control-input"
                                                       value="3">
                                                <span class="custom-control-indicator"></span>
                                                <span class="custom-control-description ml-0">3</span>
                                            </label>
											<label class="display-inline-block custom-control custom-radio">
                                                <input type="radio" name="tres" class="custom-control-input"
                                                       value="4">
                                                <span class="custom-control-indicator"></span>
                                                <span class="custom-control-description ml-0">4</span>
                                            </label>
											<label class="display-inline-block custom-control custom-radio">
                                                <input type="radio" name="tres" class="custom-control-input"
                                                       value="5">
                                                <span class="custom-control-indicator"></span>
                                                <span class="custom-control-description ml-0">5</span>
                                            </label>
                    </div>
                </div>
                 <label class="col-sm-6 col-form-label">¿Piensa usted que fue oportuno el tiempo en la instalación del servicio?</label>

                    <div class="col-sm-6 col-form-label">						
                                        <div class="input-group">
                                            <label class="display-inline-block custom-control custom-radio ml-1">
                                                <input type="radio" name="cuatro" class="custom-control-input"
                                                       value="Si" checked="">
                                                <span class="custom-control-indicator"></span>
                                                <span class="custom-control-description ml-0">Si</span>
                                            </label>
                                            <label class="display-inline-block custom-control custom-radio">
                                                <input type="radio" name="cuatro" class="custom-control-input"
                                                       value="No">
                                                <span class="custom-control-indicator"></span>
                                                <span class="custom-control-description ml-0">No</span>
                                            </label>
											
                    </div>
                </div>
					<label class="col-sm-6 col-form-label">¿Usted recomendaría nuestro servicio? </label>

                    <div class="col-sm-6 col-form-label">						
                                        <div class="input-group">
                                            <label class="display-inline-block custom-control custom-radio ml-1">
                                                <input type="radio" name="cinco" class="custom-control-input"
                                                       value="Si" checked="">
                                                <span class="custom-control-indicator"></span>
                                                <span class="custom-control-description ml-0">Si</span>
                                            </label>
                                            <label class="display-inline-block custom-control custom-radio">
                                                <input type="radio" name="cinco" class="custom-control-input"
                                                       value="No">
                                                <span class="custom-control-indicator"></span>
                                                <span class="custom-control-description ml-0">No</span>
                                            </label>
                    </div>
                
                </div>
				
				<?php } ?>
				<?php if (strpos($thread_info['subject'], "reclamo")!==false) {?>
                <label class="col-sm-6 col-form-label">¿presentación del técnico en el momento de llegar a la vivienda?</label>

                    <div class="col-sm-6 col-form-label">						
                                        <div class="input-group">
                                            <label class="display-inline-block custom-control custom-radio ml-1">
                                                <input type="radio" name="uno" class="custom-control-input"
                                                       value="1" checked="">
                                                <span class="custom-control-indicator"></span>
                                                <span class="custom-control-description ml-0">1</span>
                                            </label>
                                            <label class="display-inline-block custom-control custom-radio">
                                                <input type="radio" name="uno" class="custom-control-input"
                                                       value="2">
                                                <span class="custom-control-indicator"></span>
                                                <span class="custom-control-description ml-0">2</span>
                                            </label>
											<label class="display-inline-block custom-control custom-radio">
                                                <input type="radio" name="uno" class="custom-control-input"
                                                       value="3">
                                                <span class="custom-control-indicator"></span>
                                                <span class="custom-control-description ml-0">3</span>
                                            </label>
											<label class="display-inline-block custom-control custom-radio">
                                                <input type="radio" name="uno" class="custom-control-input"
                                                       value="4">
                                                <span class="custom-control-indicator"></span>
                                                <span class="custom-control-description ml-0">4</span>
                                            </label>
											<label class="display-inline-block custom-control custom-radio">
                                                <input type="radio" name="uno" class="custom-control-input"
                                                       value="5">
                                                <span class="custom-control-indicator"></span>
                                                <span class="custom-control-description ml-0">5</span>
                                            </label>
                    </div>
                </div>
                <label class="col-sm-6 col-form-label">¿El trato del técnico durante la revisión del servicio? </label>

                    <div class="col-sm-6 col-form-label">						
                                        <div class="input-group">
                                            <label class="display-inline-block custom-control custom-radio ml-1">
                                                <input type="radio" name="dos" class="custom-control-input"
                                                       value="1" checked="">
                                                <span class="custom-control-indicator"></span>
                                                <span class="custom-control-description ml-0">1</span>
                                            </label>
                                            <label class="display-inline-block custom-control custom-radio">
                                                <input type="radio" name="dos" class="custom-control-input"
                                                       value="2">
                                                <span class="custom-control-indicator"></span>
                                                <span class="custom-control-description ml-0">2</span>
                                            </label>
											<label class="display-inline-block custom-control custom-radio">
                                                <input type="radio" name="dos" class="custom-control-input"
                                                       value="3">
                                                <span class="custom-control-indicator"></span>
                                                <span class="custom-control-description ml-0">3</span>
                                            </label>
											<label class="display-inline-block custom-control custom-radio">
                                                <input type="radio" name="dos" class="custom-control-input"
                                                       value="4">
                                                <span class="custom-control-indicator"></span>
                                                <span class="custom-control-description ml-0">4</span>
                                            </label>
											<label class="display-inline-block custom-control custom-radio">
                                                <input type="radio" name="dos" class="custom-control-input"
                                                       value="5">
                                                <span class="custom-control-indicator"></span>
                                                <span class="custom-control-description ml-0">5</span>
                                            </label>
                    </div>
                </div>
                

                <label class="col-sm-6 col-form-label">¿Cómo quedo el servicio después de la revisión?</label>

                    <div class="col-sm-6 col-form-label">						
                                        <div class="input-group">
                                            <label class="display-inline-block custom-control custom-radio ml-1">
                                                <input type="radio" name="tres" class="custom-control-input"
                                                       value="1" checked="">
                                                <span class="custom-control-indicator"></span>
                                                <span class="custom-control-description ml-0">1</span>
                                            </label>
                                            <label class="display-inline-block custom-control custom-radio">
                                                <input type="radio" name="tres" class="custom-control-input"
                                                       value="2">
                                                <span class="custom-control-indicator"></span>
                                                <span class="custom-control-description ml-0">2</span>
                                            </label>
											<label class="display-inline-block custom-control custom-radio">
                                                <input type="radio" name="tres" class="custom-control-input"
                                                       value="3">
                                                <span class="custom-control-indicator"></span>
                                                <span class="custom-control-description ml-0">3</span>
                                            </label>
											<label class="display-inline-block custom-control custom-radio">
                                                <input type="radio" name="tres" class="custom-control-input"
                                                       value="4">
                                                <span class="custom-control-indicator"></span>
                                                <span class="custom-control-description ml-0">4</span>
                                            </label>
											<label class="display-inline-block custom-control custom-radio">
                                                <input type="radio" name="tres" class="custom-control-input"
                                                       value="5">
                                                <span class="custom-control-indicator"></span>
                                                <span class="custom-control-description ml-0">5</span>
                                            </label>
                    </div>
                </div>
                 <label class="col-sm-6 col-form-label">¿Piensa que fue oportuno el tiempo en la revisión del servicio?</label>

                    <div class="col-sm-6 col-form-label">						
                                        <div class="input-group">
                                            <label class="display-inline-block custom-control custom-radio ml-1">
                                                <input type="radio" name="cuatro" class="custom-control-input"
                                                       value="Si" checked="">
                                                <span class="custom-control-indicator"></span>
                                                <span class="custom-control-description ml-0">Si</span>
                                            </label>
                                            <label class="display-inline-block custom-control custom-radio">
                                                <input type="radio" name="cuatro" class="custom-control-input"
                                                       value="No">
                                                <span class="custom-control-indicator"></span>
                                                <span class="custom-control-description ml-0">No</span>
                                            </label>
											
                    </div>
                </div>
					<label class="col-sm-6 col-form-label">¿recomendaría nuestro servicio? </label>

                    <div class="col-sm-6 col-form-label">						
                                        <div class="input-group">
                                            <label class="display-inline-block custom-control custom-radio ml-1">
                                                <input type="radio" name="cinco" class="custom-control-input"
                                                       value="Si" checked="">
                                                <span class="custom-control-indicator"></span>
                                                <span class="custom-control-description ml-0">Si</span>
                                            </label>
                                            <label class="display-inline-block custom-control custom-radio">
                                                <input type="radio" name="cinco" class="custom-control-input"
                                                       value="No">
                                                <span class="custom-control-indicator"></span>
                                                <span class="custom-control-description ml-0">No</span>
                                            </label>
											
                    </div>
                </div>
				
				<?php } ?>
				<label class="col-sm-6 col-form-label">Observacion</label>
				<div class="col-sm-6 col-form-label">
					<div class="col-sm-12">
							<textarea class="summernote" placeholder="Algun detalle adicional" autocomplete="false" rows="2" cols="50" name="observacion"></textarea>
					</div>
				</div>
				
                <div class="form-group row">
					
                    <label class="col-sm-2 col-form-label"></label>
					
                    <div class="col-sm-4">
                        <input type="submit" id="submit-data" class="btn btn-success margin-bottom"
                               value="<?php echo $this->lang->line('Add') ?>" data-loading-text="Adding...">
                        <input type="hidden" value="encuesta/addencuesta" id="action-url">
                    </div>
                </div>

            </div>
        </form>
    </div>
</article>

