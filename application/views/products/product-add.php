<article class="content">
    <div class="card card-block">
        <div id="notify" class="alert alert-success" style="display:none;">
            <a href="#" class="close" data-dismiss="alert">&times;</a>

            <div class="message"></div>
        </div>
        <form method="post" id="data_form" class="form-horizontal">
            <div class="grid_3 grid_4">
                <h5><?php echo $this->lang->line('') ?>Agregar nuevo Material</h5>
                <hr>


                <input type="hidden" name="act" value="add_product">


                <div class="form-group row">

                    <label class="col-sm-2 col-form-label"
                           for="product_name"><?php echo $this->lang->line('') ?>Material nombre</label>

                    <div class="col-sm-6">
                        <input type="text" placeholder="Material nombre"
                               class="form-control margin-bottom  required" name="product_name">
                    </div>
                </div>
                <div class="form-group row">

                    <label class="col-sm-2 col-form-label"
                           for="product_cat"><?php echo $this->lang->line('') ?>Categoria Material</label>

                    <div class="col-sm-6">
                        <select name="product_cat" class="form-control">
                            <?php
                            foreach ($cat as $row) {
                                $cid = $row['id'];
                                $title = $row['title'];
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
                        <select name="product_warehouse" class="form-control">
                            <?php
                            foreach ($warehouse as $row) {
                                $cid = $row['id'];
                                $title = $row['title'];
                                echo "<option value='$cid'>$title</option>";
                            }
                            ?>
                        </select>


                    </div>
                </div>
                <div class="form-group row">

                    <label class="col-sm-2 col-form-label"
                           for="product_code"><?php echo $this->lang->line('') ?>Codigo Material</label>

                    <div class="col-sm-6">
                        <input type="text" placeholder="Codigo Material"
                               class="form-control required" name="product_code">
                    </div>
                </div>
                <div class="form-group row">

                    <label class="col-sm-2 control-label"
                           for="product_price"><?php echo $this->lang->line('') ?>Precio de compra</label>

                    <div class="col-sm-6">
                        <div class="input-group">
                            <span class="input-group-addon"><?php echo $this->config->item('currency') ?></span>
                            <input type="text" name="product_price" class="form-control required"
                                   placeholder="0" aria-describedby="sizing-addon"
                                   onkeypress="return isNumber(event)">
                        </div>
                    </div>
                </div>
                <div class="form-group row">

                    <label class="col-sm-2 col-form-label"><?php echo $this->lang->line('') ?>Precio al por mayor</label>

                    <div class="col-sm-6">
                        <div class="input-group">
                            <span class="input-group-addon"><?php echo $this->config->item('currency') ?></span>
                            <input type="text" name="fproduct_price" class="form-control required"
                                   placeholder="0" aria-describedby="sizing-addon1"
                                   onkeypress="return isNumber(event)">
                        </div>
                    </div>
                </div>
                <div class="form-group row">

                    <label class="col-sm-2 col-form-label"><?php echo $this->lang->line('') ?>Impuesto de valor agregado</label>

                    <div class="col-sm-4">
                        <div class="input-group">

                            <input type="text" name="product_tax" class="form-control required"
                                   placeholder="0" aria-describedby="sizing-addon1"
                                   onkeypress="return isNumber(event)"><span
                                    class="input-group-addon">%</span>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <small><?php echo $this->lang->line('') ?>Puede cambiar el impuestos durante la creación de facturas también</small>
                    </div>
                </div>
                <div class="form-group row">

                    <label class="col-sm-2 col-form-label"><?php echo $this->lang->line('') ?>Descuento predeterminado</label>

                    <div class="col-sm-4">
                        <div class="input-group">

                            <input type="text" name="product_disc" class="form-control required"
                                   placeholder="0" aria-describedby="sizing-addon1"
                                   onkeypress="return isNumber(event)"><span
                                    class="input-group-addon">%</span>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <small><?php echo $this->lang->line('') ?>Puede cambiar el descuento durante la creación de la factura también</small>
                    </div>
                </div>
                <div class="form-group row">

                    <label class="col-sm-2 col-form-label"><?php echo $this->lang->line('Stock Units') ?></label>

                    <div class="col-sm-4">
                        <input type="number" placeholder="Total unidades en stock"
                               class="form-control margin-bottom required" name="product_qty"
                               onkeypress="return isNumber(event)">
                    </div>
                </div>
                <div class="form-group row">

                    <label class="col-sm-2 col-form-label"><?php echo $this->lang->line('Alert Quantity') ?></label>

                    <div class="col-sm-4">
                        <input type="number" placeholder="Cantidad baja de alerta de stock"
                               class="form-control margin-bottom required" name="product_qty_alert"
                               onkeypress="return isNumber(event)">
                    </div>
                </div>
                <div class="form-group row">

                    <label class="col-sm-2 col-form-label"><?php echo $this->lang->line('Description') ?></label>

                    <div class="col-sm-8">
                        <textarea placeholder="Descripcion del material"
                               class="form-control margin-bottom" name="product_desc"
                        ></textarea>
                    </div>
                </div>
                <div class="form-group row">

                    <label class="col-sm-2 col-form-label"></label>

                    <div class="col-sm-4">
                        <input type="submit" id="submit-data" class="btn btn-success margin-bottom"
                               value="<?php echo $this->lang->line('Add material') ?>Agregar Material" data-loading-text="Adding...">
                        <input type="hidden" value="products/addproduct" id="action-url">
                    </div>
                </div>
            </div>

        </form>
    </div>
</article>

