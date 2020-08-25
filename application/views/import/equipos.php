<article class="content">
    <div class="card card-block">
        <div id="notify" class="alert alert-success" style="display:none;">
            <a href="#" class="close" data-dismiss="alert">&times;</a>

            <div class="message"></div>
        </div>
        <?php echo form_open_multipart('importequipos/products_upload'); ?>
            <div class="grid_3 grid_4">
                <h5><?php echo $this->lang->line('') ?>Importar Equipos</h5>
                <hr>
                <p>Your products data file should as per this template <a href="http://www.ultimatekode.com/samples/products_import.csv"><strong>Download Template</strong></a>. Please download a database backup before importing the products.</p>
<p>Column Order in CSV File Must be like this</p>
 <pre>
     1. (string)Product A, 2. (string)ProductCODE, 3.(number)Sales_Price, 4.(number)Factory_Price,

     5.(number)TAX_Rate, 6.(number)Discount_Rate, 7.(integer)Quantity,

     8.(string)Product_Description, 9.(integer)Low_Stock_Alert_Quantity
</pre>

                <hr>
                <div class="form-group row">

                    <label class="col-sm-2 col-form-label" for="name">Documento
                        </label>

                    <div class="col-sm-6">
                        <input type="file" name="userfile" size="15"/>(Solo Formato CSV)
                    </div>
                </div>                

                <div class="form-group row">

                    <label class="col-sm-2 col-form-label"
                           for="product_cat"><?php echo $this->lang->line('Warehouse') ?></label>

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
                               value="Importar Equipos" data-loading-text="Adding...">

                    </div>
                </div>
            </div>

        </form>
    </div>
</article>

