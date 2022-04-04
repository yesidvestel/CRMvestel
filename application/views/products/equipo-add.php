<article class="content">
    <div class="card card-block">
        <div id="notify" class="alert alert-success" style="display:none;">
            <a href="#" class="close" data-dismiss="alert">&times;</a>

            <div class="message"></div>
        </div>
        <form method="post" id="data_form" class="form-horizontal" enctype="multipart/form-data" accept-charset="utf-8">
            <div class="grid_3 grid_4">
                <h5><?php echo $this->lang->line('') ?>Agregar nuevo Equipo</h5>
                <hr>


                <input type="hidden" name="eqp" value="add_product">


                <div class="form-group row">

                    <label class="col-sm-2 col-form-label"
                           for="product_name"><?php echo $this->lang->line('') ?>Codigo equipo</label>

                    <div class="col-sm-6">
                        <input type="text" placeholder="Material nombre" class="form-control margin-bottom  required" name="codigo" value="<?php echo $codigo + 1 ?>">
                    </div>
                </div>
                <div class="form-group row">

                    <label class="col-sm-2 col-form-label"
                           for="product_cat"><?php echo $this->lang->line('') ?>Proveedor</label>

                    <div class="col-sm-6">
                        <select name="proveedor" class="form-control">
                            <?php
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
                        <input type="text" placeholder="Direccion MAC"
                               class="form-control required" name="mac">
                    </div>
                </div>
				<div class="form-group row">

                    <label class="col-sm-2 col-form-label"
                           for="product_code"><?php echo $this->lang->line('') ?>Serial</label>

                    <div class="col-sm-6">
                        <input type="text" placeholder="Serial equipo"
                               class="form-control required" name="serial">
                    </div>
                </div>
                <div class="form-group row">

                    <label class="col-sm-2 control-label"
                           for="product_price"><?php echo $this->lang->line('') ?>Fecha llegada</label>

                    <div class="col-sm-6">
                        <div class="input-group">
                            <span class="input-group-addon icon-calendar4"><?php echo $this->config->item('') ?></span>
                            <input type="text" class="form-control required"
                                                   placeholder="Billing Date" name="llegada"
                                                   data-toggle="datepicker"
                                                   autocomplete="false">
                        </div>
                    </div>
                </div>
                <div class="form-group row">

                    <label class="col-sm-2 col-form-label"><?php echo $this->lang->line('') ?>Fecha instalacion</label>

                    <div class="col-sm-6">
                        <div class="input-group">
                            <span class="input-group-addon icon-calendar4"><?php echo $this->config->item('') ?></span>
                            <input type="text" class="form-control" name="final" data-toggle="datepicker" autocomplete="false">
                        </div>
                    </div>
                </div>
                <div class="form-group row">

                    <label class="col-sm-2 col-form-label"><?php echo $this->lang->line('') ?>Marca</label>

                    <div class="col-sm-4">
                        <div class="input-group">                            
							<select name="marca" class="form-control">
								<option value="Bestcom">Bestcom</option>
								<option value="Kyngtype">Kyngtype</option>
								<option value="Wifi">Wifi</option>
								<option value="Cisco">Cisco</option>
								<option value="Mikotik">Mikrotik</option>
							</select>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <small><?php echo $this->lang->line('') ?>Especifica la marca del fabricante</small>
                    </div>
                </div>
                <div class="form-group row">

                    <label class="col-sm-2 col-form-label"><?php echo $this->lang->line('') ?>Asignar a:</label>

                    <div class="col-sm-4">
                        <div class="input-group">

                            <select name="asignado" class="form-control">
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
								<option value="Bueno">Bueno</option>
								<option value="Malo">Malo</option>								
							</select>
                    </div>
                </div>
                <div class="form-group row">

                    <label class="col-sm-2 col-form-label"><?php echo $this->lang->line('') ?>Observacion</label>

                    <div class="col-sm-8">
                        <textarea class="form-control margin-bottom" name="observacion">
						</textarea>
                    </div>
                </div>
                <div class="form-group row">

                <label class="col-sm-2 col-form-label" for="name">Imagen</label>

                <div class="col-sm-8">
                    <input type="file" name="equipofile" id="equipofile" size="20"/><br>
                    <small>(png, jpg, gif, jpeg)</small>
                </div>
            </div>
                <div class="form-group row">

                    <label class="col-sm-2 col-form-label"></label>

                    <div class="col-sm-4">
                        <input type="submit" id="submit-data_eq" class="btn btn-success margin-bottom"
                               value="<?php echo $this->lang->line('Add material') ?>Agregar Material" data-loading-text="Adding...">
                        <input type="hidden" value="products/addequipo" id="action-url">
                    </div>
                </div>
            </div>
			<hr>
				<h5><?php echo $this->lang->line('') ?>Agregar lista de Equipos</h5>
			<hr>
				
                <div class="form-group row">

                    <label class="col-sm-2 col-form-label" for="name">Archivo
                        </label>

                    <div class="col-sm-6">
                        <input type="file" name="userfile" size="15"/>(solo formato CSV)
                    </div>
                </div>

                <div class="form-group row">

                    <label class="col-sm-2 col-form-label"
                           for="product_cat"><?php echo $this->lang->line('') ?>Almacen</label>

                    <div class="col-sm-6">
                        <select name="product_warehouse" class="form-control">
                            <?php
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

                    <label class="col-sm-2 col-form-label"></label>

                    <div class="col-sm-4">
                        <input type="submit"class="btn btn-success margin-bottom"
                               value="<?php echo $this->lang->line('Import Products') ?>" data-loading-text="Adding...">
						<input type="hidden" value="importequipo/products_upload" id="action-url">
                    </div>
                </div>
            </div>

        </form>
    </div>
</article>

