<article class="content">
    <div class="card card-block">
        <div id="notify" class="alert alert-success" style="display:none;">
            <a href="#" class="close" data-dismiss="alert">&times;</a>

            <div class="message"></div>
        </div>
        <form method="post" id="data_form" class="form-horizontal">
            <div class="grid_3 grid_4">

                <h5><?php echo $this->lang->line('') ?>Editar Equipo</h5>
                <hr>


                <input type="hidden" name="pid" value="<?php echo $equipos['id'] ?>">


                <div class="form-group row">

                    <label class="col-sm-2 col-form-label"
                           for="product_name"><?php echo $this->lang->line('') ?>Codigo Equipo</label>

                    <div class="col-sm-6">
                        <input type="text" placeholder="Product Name"
                               class="form-control margin-bottom  required" name="codigo"
                               value="<?php echo $equipos['codigo'] ?>">
                    </div>
                </div>
                <div class="form-group row">

                    <label class="col-sm-2 col-form-label"
                           for="product_cat"><?php echo $this->lang->line('') ?>Proveedor</label>

                    <div class="col-sm-6">
                        <select name="proveedor" class="form-control">
                            <?php
                            echo '<option value="'. $cat_ware['wid'] . '">' .'>>'. $cat_ware['watt'] . '</option>';
                            foreach ($supplier as $row) {
                                $cid = $row['id'];
                                $title = $row['name'];
                                echo "<option value='$cid'>$title</option>";
                            }
                            ?>
                        </select>


                    </div>
                </div>
                <div class="form-group row">

                    <label class="col-sm-2 col-form-label"
                           for="product_cat"><?php echo $this->lang->line('Warehouse') ?></label>

                    <div class="col-sm-6">
                        <select name="almacen" class="form-control">
                            <?php
                            echo '<option value="' . $alm_ware['wid'] . '">'.'>>' . $alm_ware['watt'] . ' </option>';
                            foreach ($almacen as $row) {
                                $cid = $row['id'];
                                $title = $row['almacen'];
                                echo "<option value='$cid'>$title</option>";
                            }
                            ?>
                        </select>


                    </div>
                </div>
                <div class="form-group row">

                    <label class="col-sm-2 col-form-label"
                           for="product_code"><?php echo $this->lang->line('') ?>MAC</label>

                    <div class="col-sm-6">
                        <input type="text" placeholder="Product Code"
                               class="form-control required" name="mac"
                               value="<?php echo $equipos['mac'] ?>">
                    </div>
                </div>
                <div class="form-group row">

                    <label class="col-sm-2 col-form-label"
                           for="product_code"><?php echo $this->lang->line('') ?>Serial</label>

                    <div class="col-sm-6">
                        <input type="text" placeholder="Serial equipo"
                               class="form-control required" name="serial" value="<?php echo $equipos['serial'] ?>">
                    </div>
                </div>
                <div class="form-group row">

                    <label class="col-sm-2 control-label"
                           for="product_price"><?php echo $this->lang->line('') ?>Fecha llegada</label>

                    <div class="col-sm-6">
                        <div class="input-group">
                            <span class="input-group-addon icon-calendar4"><?php echo $this->config->item('') ?></span>
                            <input type="text" class="form-control required editdate"
                                               placeholder="Billing Date" name="llegada" autocomplete="false"
                                               value="<?php echo dateformat($equipos['llegada']) ?>">
                        </div>
                    </div>
                </div>
                <div class="form-group row">

                    <label class="col-sm-2 col-form-label"><?php echo $this->lang->line('') ?>Fecha instalacion</label>

                    <div class="col-sm-6">
                        <div class="input-group">
                            <span class="input-group-addon icon-calendar4"><?php echo $this->config->item('') ?></span>
                            <input type="text" class="form-control editdate" placeholder="Due Date" name="final" value="<?php echo dateformat($equipos['final']) ?>" autocomplete="false" >
                        </div>
                    </div>
                </div>
                <div class="form-group row">

                    <label class="col-sm-2 col-form-label"><?php echo $this->lang->line('') ?>Marca</label>

                    <div class="col-sm-4">
                        <div class="input-group">                            
							<select name="marca" class="form-control">
								<option value="<?php echo $equipos['marca'] ?>">>> <?php echo $equipos['marca'] ?></option>
								<option value="Bestcom">Bestcom</option>
								<option value="Kyngtype">Kyngtype</option>
								<option value="Wifi">Wifi</option>
								<option value="Cisco">Cisco</option>
								<option value="Mikrotik">Mikrotik</option>
							</select>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <small><?php echo $this->lang->line('') ?>Puede cambiar el impuestos durante la creación de facturas también</small>
                    </div>
                </div>
                <div class="form-group row">

                     <label class="col-sm-2 col-form-label"><?php echo $this->lang->line('') ?>Asignar a:</label>

                    <div class="col-sm-4">
                        <div class="input-group">

                            <select name="asignado" class="form-control">
                            <?php
	 						echo '<option value="' . $cus_ware['wid'] . '">'.'>>' . $cus_ware['abon'] . ' '.$cus_ware['watt'].'</option>';?>
							<option value="0">Sin asignar</option>
							<?php
                            foreach ($customer as $row) {
                                $cid = $row['id'];
                                $title = $row['abonado'];
								$name = $row['name'];
                                echo "<option value='$cid'>$title $name</option>";
                            }
                            ?>
                        </select>
                        </div>
					</div>
						<div class="col-sm-4">
                        <small><?php echo $this->lang->line('') ?>Usuario al cual se le asigna el equipo</small>
                    	</div>					
                </div>
                <div class="form-group row">

                    <label class="col-sm-2 col-form-label"><?php echo $this->lang->line('') ?>Estado</label>

                    <div class="col-sm-4">
                        <select name="estado" class="form-control">
								<option value="<?php echo $equipos['estado'] ?>">>><?php echo $equipos['estado'] ?></option>
								<option value="Bueno">Bueno</option>
								<option value="Malo">Malo</option>								
							</select>
                    </div>
                </div>
                <div class="form-group row">

                    <label class="col-sm-2 col-form-label"><?php echo $this->lang->line('') ?>Observacion</label>

                    <div class="col-sm-8">
                        <textarea class="form-control margin-bottom" name="observacion"><?php echo $equipos['observacion'] ?>
						</textarea>
                    </div>
                </div>
                <div class="form-group row">

                    <label class="col-sm-2 col-form-label"></label>

                    <div class="col-sm-4">
                        <input type="submit" id="submit-data" class="btn btn-success margin-bottom"
                               value="<?php echo $this->lang->line('Update') ?>"
                               data-loading-text="Updating...">
                        <input type="hidden" value="products/editequipos" id="action-url">
                    </div>
                </div>

            </div>
        </form>
    </div>
</article>


