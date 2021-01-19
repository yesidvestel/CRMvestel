<div class="app-content content container-fluid">
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="card card-block">
                <div id="notify" class="alert alert-success" style="display:none;">
                    <a href="#" class="close" data-dismiss="alert">&times;</a>

                    <div class="message"></div>
                </div>
                <form method="post" id="data_form" name="soporte">


                    <div class="row">


                        <div class="col-sm-6 cmp-pnl">
                            <div id="customerpanel" class="inner-cmp-pnl">                               

                                
                                <div id="customer">
                                    <div class="clientinfo">
										<h3 class="title">Detalles Usuario</h3>
                                        <hr>
										<input type="hidden" name="customer_id" value="<?php echo $details['id'] ?>"></input>
                                        <?php echo $thread_info['name'].' '.$thread_info['unoapellido'] ?>
                                    </div>
                                    <div class="clientinfo">
                                        Documento: <?php echo $thread_info['documento'] ?>
                                    </div>
                                    <div class="clientinfo">
                                        Celular: <?php echo $thread_info['celular'] ?>
                                    </div>
									<div class="clientinfo">
                                        Direccion: <?php echo $thread_info['nomenclatura'] ?> <?php echo $thread_info['numero1'] ?><?php echo $thread_info['adicionauno'] ?> N <?php echo $thread_info['numero2'] ?> <?php echo $thread_info['adicional2'] ?> - <?php echo $thread_info['numero3'] ?>
                                    </div>
                                    <hr>                                    
                                </div>


                            </div>
                        </div>
                        <div class="col-sm-6 cmp-pnl">
                            <div class="inner-cmp-pnl">


                                <div class="form-group row">
									<input type="text" class="form-control" placeholder="Invoice #" name="ticketnumero"
                                                   value="<?php echo $thread_info['codigo'] ?>"></input>
                                    <div class="col-sm-12"><h3
                                                class="title"><?php echo $this->lang->line('') ?>Propiedades de orden</h3>
                                    </div>

                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-6">
										<label for="invocieno" class="caption">Tipo de orden</label>
                                        <div class="input-group">
                                            <div class="input-group-addon">
											<span class="icon-file-text-o" aria-hidden="true"></span></div>
											<input type="hidden" value="<?php echo $thread_info['idt'] ?>" name="customer_id"></input>
                                            	<select name="subject" class="form-control" onchange="cambia()">
													<option value="<?php echo $thread_info['subject'] ?>">>><?php echo $thread_info['subject'] ?></option>
													<option value="servicio">Orden de servicio</option>								
													<option value="reclamo">Orden de reclamo</option>
												</select>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
										<label for="invocieno" class="caption">Detalle de orden</label>
                                        <div class="input-group">
                                            <div class="input-group-addon">
												<span class="icon-bookmark-o" aria-hidden="true"></span></div>
                                            <select class=" col-sm-2 form-control"  id="discountFormat" name="detalle" >
													<option value="<?php echo $thread_info['detalle'] ?>">>><?php echo $thread_info['detalle'] ?></option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">

                                    <div class="col-sm-6">
										<label for="invociedate" class="caption">Fecha de orden</label>

                                        <div class="input-group">
                                            <div class="input-group-addon"><span class="icon-calendar4"
                                                                                 aria-hidden="true"></span></div>
                                            <input type="text" class="form-control required"
                                                   placeholder="Billing Date" name="created"
                                                   autocomplete="false" value="<?php echo $thread_info['created'] ?>" readonly>
                                        </div>
                                    </div>
									<div class="col-sm-6">
										<label for="invociedate" class="caption">Factura mes</label>
										<div class="input-group">
											<input name="factura" value="<?php echo $thread_info['id_factura'] ?>" class="form-control mb-1"></input>
										</div>
                                        </div>
                                    </div>                                
							</div>
                        </div>

                    </div>

                    <div class="form-group row">
                        <div class="col-sm-12">
                            <label for="toAddInfo" class="caption">Descripcion de Orden</label>
                            <textarea class="summernote" name="section" id="contents" rows="2"><?php echo $thread_info['section'] ?></textarea></div>
                    </div>
                   
					<input type="submit" class="btn btn-success sub-btn" value="Actualizar" id="submit-data" data-loading-text="Creating...">
						
                    <input type="hidden" value="quote/editaction" id="action-url">
                    <input type="hidden" value="search" id="billtype">
                    <input type="hidden" value="0" name="counter" id="ganak">
                    <input type="hidden" value="<?php echo $this->config->item('currency'); ?>" name="currency">
                    <input type="hidden" value="%" name="taxformat" id="tax_format">
                    <input type="hidden" value="%" name="discountFormat" id="discount_format">
                    <input type="hidden" value="<?php if ($this->config->item('tax') == 1) {
                        echo 'yes';
                    } else {
                        echo 'no';
                    } ?>" name="tax_handle" id="tax_status">
                    <input type="hidden" value="yes" name="applyDiscount" id="discount_handle">


                </form>
            </div>

        </div>
    </div>
</div>
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
	// selecion de orden
	var perfil_servicio = new Array ("Seleccine...","Instalacion","Reinstalacion","Traslado","Subir 5 Mg","Subir 10 Mg","Bajar 5 Mg","Bajar 3 Mg","Cambio de equipo","Equipo adicional","Reconexion Combo","Reconexion Internet","Reconexion Television","Suspencion Combo","Suspencion Internet","Suspencion Television","Corte Combo","Corte Internet","Corte Television");
	var perfil_reclamo = new Array ("Seleccine...","Revision de Internet","Revision de television","Otros");	
							//crear funcion que ejecute el cambio
							function cambia(){
								var subject;
								subject = document.soporte.subject[document.soporte.subject.			selectedIndex].value;
								//se verifica la seleccion dada
								if(subject!=0){
									mis_opts=eval("perfil_"+subject);
									//definimos cuantas obciones hay
									num_opts=mis_opts.length;
									//marcamos obciones en el selector
									document.soporte.detalle.length = num_opts;
									//colocamos las obciones array
									for(i=0; i<num_opts; i++){
										document.soporte.detalle.options[i].value=mis_opts[i];
										document.soporte.detalle.options[i].text=mis_opts[i];
									}
										}else{
											//resultado si no hay obciones
											document.soporte.detalle.length = 1;
											document.soporte.detalle.options[0].value="-"
											document.soporte.detalle.options[0].text="-"											
								}
								document.soporte.detalle.options[0].selected = true;
							}

</script>
