<article class="content">
    <div class="card card-block">
        <div id="notify" class="alert alert-success" style="display:none;">
            <a href="#" class="close" data-dismiss="alert">&times;</a>

            <div class="message"></div>
        </div>
        <form method="post" id="data_form" class="form-horizontal">
            <div class="grid_3 grid_4">

                <h5><?php echo $this->lang->line('Edit Product') ?></h5>
                <hr>


                <input type="hidden" name="pid" value="<?php echo $product['pid'] ?>">


                <div class="form-group row">

                    <label class="col-sm-2 col-form-label"
                           for="product_name"><?php echo $this->lang->line('Product Name') ?></label>

                    <div class="col-sm-6">
                        <input type="text" placeholder="Product Name"
                               class="form-control margin-bottom  required" name="product_name"
                               value="<?php echo $product['product_name'] ?>">
                    </div>
                </div>
                <div class="form-group row">

                    <label class="col-sm-2 col-form-label"
                           for="product_cat"><?php echo $this->lang->line('Product Category') ?></label>

                    <div class="col-sm-6">
                        <select name="product_cat" class="form-control">
                            <?php
                            echo '<option value="' . $cat_ware['cid'] . '">' . $cat_ware['catt'] . ' (S)</option>';
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
                            echo '<option value="' . $cat_ware['wid'] . '">' . $cat_ware['watt'] . ' (S)</option>';
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
                           for="product_code"><?php echo $this->lang->line('Product Code') ?></label>

                    <div class="col-sm-6">
                        <input type="text" placeholder="Product Code"
                               class="form-control required" name="product_code"
                               value="<?php echo $product['product_code'] ?>">
                    </div>
                </div>
                <div class="form-group row">

                    <label class="col-sm-2 control-label"
                           for="product_price"><?php echo $this->lang->line('Product Retail Price') ?></label>

                    <div class="col-sm-6">
                        <div class="input-group">
                            <span class="input-group-addon"><?php echo $this->config->item('currency') ?></span>
                            <input type="text" name="product_price" class="form-control required"
                                   placeholder="0.00" aria-describedby="sizing-addon"
                                   onkeypress="return isNumber(event)" value="<?php echo $product['product_price'] ?>">
                        </div>
                    </div>
                </div>
                <div class="form-group row">

                    <label class="col-sm-2 col-form-label"><?php echo $this->lang->line('Product Wholesale Price') ?></label>

                    <div class="col-sm-6">
                        <div class="input-group">
                            <span class="input-group-addon"><?php echo $this->config->item('currency') ?></span>
                            <input type="text" name="fproduct_price" class="form-control required"
                                   placeholder="0.00" aria-describedby="sizing-addon1"
                                   onkeypress="return isNumber(event)" value="<?php echo $product['fproduct_price'] ?>">
                        </div>
                    </div>
                </div>
                <div class="form-group row">

                    <label class="col-sm-2 col-form-label"><?php echo $this->lang->line('Default TAX Rate') ?></label>

                    <div class="col-sm-4">
                        <div class="input-group">

                            <input type="text" name="product_tax" class="form-control required"
                                   placeholder="0.00" aria-describedby="sizing-addon1"
                                   onkeypress="return isNumber(event)" value="<?php echo $product['taxrate'] ?>"><span
                                    class="input-group-addon">%</span>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <small><?php echo $this->lang->line('Tax rate during') ?></small>
                    </div>
                </div>
                <div class="form-group row">

                    <label class="col-sm-2 col-form-label"><?php echo $this->lang->line('Default Discount Rate') ?></label>

                    <div class="col-sm-4">
                        <div class="input-group">

                            <input type="text" name="product_disc" class="form-control required"
                                   placeholder="0.00" aria-describedby="sizing-addon1"
                                   onkeypress="return isNumber(event)" value="<?php echo $product['disrate'] ?>"><span
                                    class="input-group-addon">%</span>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <small><?php echo $this->lang->line('Discount rate during') ?></small>
                    </div>
                </div>
                <div class="form-group row">

                    <label class="col-sm-2 col-form-label"><?php echo $this->lang->line('Stock Units') ?></label>

                    <div class="col-sm-4">
                        <input type="text" placeholder="Total Items in stock"
                               class="form-control margin-bottom required" name="product_qty"
                               onkeypress="return isNumber(event)" value="<?php echo $product['qty'] ?>">
                    </div>
                </div>
                <div class="form-group row">

                    <label class="col-sm-2 col-form-label"><?php echo $this->lang->line('Alert Quantity') ?></label>

                    <div class="col-sm-4">
                        <input type="number" placeholder="Low Stock Alert Quantity"
                               class="form-control margin-bottom required" name="product_qty_alert"  value="<?php echo $product['alert'] ?>"
                               onkeypress="return isNumber(event)">
                    </div>
                </div>
                <div class="form-group row">

                    <label class="col-sm-2 col-form-label"><?php echo $this->lang->line('Description') ?></label>

                    <div class="col-sm-8">
                        <textarea placeholder="Description"
                                  class="form-control margin-bottom" name="product_desc"
                        ><?php echo $product['product_des'] ?></textarea>
                    </div>
                </div>
                <div class="form-group row">

                    <label class="col-sm-2 col-form-label"></label>

                    <div class="col-sm-4">
                        <input type="submit" id="submit-data" class="btn btn-success margin-bottom"
                               value="<?php echo $this->lang->line('Update') ?>"
                               data-loading-text="Updating...">
                        <input type="hidden" value="products/editproduct" id="action-url">
                    </div>
                </div>

            </div>
        </form>
    </div>
</article>


