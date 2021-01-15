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
                                        <?php echo $details['name'].' '.$details['unoapellido'] ?>
                                    </div>
                                    <div class="clientinfo">
                                        Documento: <?php echo $details['documento'] ?>
                                    </div>
                                    <div class="clientinfo">
                                        Celular: <?php echo $details['celular'] ?>
                                    </div>
									<div class="clientinfo">
                                        Direccion: <?php echo $details['nomenclatura'] ?> <?php echo $details['numero1'] ?><?php echo $details['adicionauno'] ?> Nยบ <?php echo $details['numero2'] ?> <?php echo $details['adicional2'] ?> - <?php echo $details['numero3'] ?>
                                    </div>
                                    <hr>                                    
                                </div>


                            </div>
                        </div>
                        <div class="col-sm-6 cmp-pnl">
                            <div class="inner-cmp-pnl">


                                <div class="form-group row">
									<?php /*?><input type="hidden" class="form-control" placeholder="Invoice #" name="ticketnumero"
                                                   value="<?php echo $lastinvoice + 1 ?>" readonly></input><?php */?>
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
                                            	<select name="subject" class="form-control" onchange="cambia()">
													<option value="0">seleccione...</option>
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
													<option value="-">-</option>
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
                                                   data-toggle="datepicker"
                                                   autocomplete="false" readonly>
                                        </div>
                                    </div>
									<div class="col-sm-6"><option value=""></option>
										<label for="invociedate" class="caption">Factura mes</label>
										<div class="input-group">
										<select name="factura" id="tecnicos" class="form-control mb-1">
												<option value=''>-</option>
												<?php
													foreach ($facturalist as $row) {
														$cid = $row['id'];
														$title = $row['tid'];
														$mes = $row['invoicedate'];
														echo "<option value='$title'>$title" . date(" F, Y",strtotime($mes))." </option>";
													}
													?>
											</select>
										</div>
                                        </div>
                                    </div>                                
							</div>
                        </div>

                    </div>

                    <div class="form-group row">
                        <div class="col-sm-12">
                            <label for="toAddInfo" class="caption">Descripcion de Orden</label>
                            <textarea class="summernote" name="section" id="contents" rows="2"></textarea></div>
                    </div>
                   
					<input type="submit" class="btn btn-success sub-btn" value="Update Quote" id="submit-data" data-loading-text="Updating...">
						
                    <input type="hidden" value="quote/action" id="action-url">
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
	var perfil_servicio = new Array ("Seleccine...","Instalacion","Reinstalacion","Traslado","Subir 5 Mg","Subir 10 Mg","Bajar 5 Mg","Bajar 3 Mg","Cambio de equipo","Equipo adicional","Reconexion Combo","Reconexion Internet","Reconexion Television","Suspencion Combo","Suspencion Internet","Suspencion Television","Corte Combo","Corte Internet","Corte Television","Toma Adicional","Punto nuevo");
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
