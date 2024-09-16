<article class="content">
    <div class="card card-block">
        <div id="notify" class="alert alert-success" style="display:none;">
            <a href="#" class="close" data-dismiss="alert">&times;</a>

            <div class="message"></div>
        </div>
		<form method="post" id="data_form" class="form-horizontal">
        <div class="grid_3 grid_4">

            <div class="well col-xs-12">
                <div class="row">
                    <div class="text-center">
                        <h5><?php echo $this->lang->line('Transaction Details') ?> </h5>
                    </div>
                    <hr>
                    <div class="col-xs-6 col-sm-6 col-md-6">
                        <address>
                            <?php echo '<strong>' . $this->config->item('ctitle') . '</strong><br>' .
                                $this->config->item('address') . '<br>' . $this->config->item('postbox') . '<br> '.$this->lang->line('Phone').': ' . $this->config->item('phone') . '<br>  '.$this->lang->line('Email').': ' . $this->config->item('email'); ?>
                        </address>
                    </div>
                    <div class="col-xs-6 col-sm-6 col-md-6 text-right">
                        <address>
                            <?php echo '<strong>' . $trans['payer'].' '. $cdata['unoapellido'] . '</strong><br>' .
                                $cdata['nomenclatura'] .' '.$cdata['numero1'].$cdata['adicionaluno'].' # '.$cdata['numero2'].$cdata['adicional2'].' - '.$cdata['numero3'] . '<br>' . $cdata['ciudad'] . '<br>' . $this->lang->line('Phone') . ': ' . $cdata['celular'] . '<br>  '.$this->lang->line('Email').': ' . $cdata['email']; ?>
                        </address>
                    </div>

                </div>

                <div class="row">
                    <hr>
					<div class="col-xs-6 col-sm-6 col-md-6">
						<div class="form-group row">
							<label class="col-sm-2 col-form-label">Debito: </label>
							<div class="col-sm-4">
								 <input type="text"  class="form-control margin-bottom" name="debito" value="<?php echo $trans['debit'] ?>"></input>
							</div>
						</div>
						<div class="form-group row">
							<label class="col-sm-2 col-form-label">Credito: </label>
							<div class="col-sm-4">
								 <input type="text"  class="form-control margin-bottom" name="credito" value="<?php echo $trans['credit'] ?>"></input>
							</div>
						</div>
						<div class="form-group row">
							<label class="col-sm-2 col-form-label">Tipo: </label>
							<div class="col-md-2 col-form-label">
								 <?php echo $trans['type'] ?>
							</div>
						</div> 
					</div>                    

                <div class="col-xs-6 col-sm-6 col-md-6 text-right">
						<div class="form-group row">
							<label class="col-sm-2 col-form-label">Fecha: </label>
							<input type="hidden" name="id" value="<?php echo $trans['id'] ?>"></input>
							<div class="col-sm-4">
								 <input type="text"  class="form-control margin-bottom" name="fecha" value="<?php echo $trans['date'] ?>"></input>
							</div>
						</div>
						<div class="row m-t-lg">
							<label class="col-md-2 col-form-label">Codigo: </label>
							<div class="col-md-2 col-form-label">
								 <?php echo prefix(5) . $trans['id'] ?>
							</div>
						</div>
						<div class="row m-t-lg">
							<label class="col-md-2 col-form-label">Categoria: </label>
							<div class="col-md-4 col-form-label">
								 <select name="cat" class="form-control">
									<option value="<?php echo $trans['cat'] ?>">>><?php echo $trans['cat'] ?></option>
									<?php
									foreach ($cat as $row) {
										$cid = $row['id'];
										$title = $row['name'];
										echo "<option value='$title'>$title</option>";
									}
									?>
								</select>
							</div>
						</div>
           	 	</div>
				<div class="col-xs-12 col-sm-12 col-md-12 ">
					<div class="form-group row">
							<label class="col-sm-1 col-form-label">Nota: </label>
							<div class="col-sm-6">
								 <input type="text"  class="form-control margin-bottom" name="nota" value="<?php echo $trans['note'] ?>"></input>
							</div>
						</div>
            	</div>
				<div class="form-group row">

                    <div class="col-sm-10">
						<input type="hidden"  class="form-control margin-bottom" name="tid" value="<?php echo $trans['tid'] ?>"></input>
                        <input type="submit" id="submit-data" class="btn btn-success margin-bottom"
                               value="<?php echo $this->lang->line('Update') ?>" data-loading-text="Updating...">
                        <input type="hidden" value="transactions/edittrans" id="action-url">
                    </div>
                </div>
			</div>
			
                </div>
				</form>
            </div>

</article>