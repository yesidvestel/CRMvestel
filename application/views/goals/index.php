<article class="content">
    <div class="card card-block">
        <div id="notify" class="alert alert-success" style="display:none;">
            <a href="#" class="close" data-dismiss="alert">&times;</a>

            <div class="message"></div>
        </div>
        <div class="grid_3 grid_4">


            <form method="post" id="data_form" class="form-horizontal">

                <h5><?php echo $this->lang->line('Set Goals') ?>
                    <small>(in <?php echo $this->config->item('currency') ?>)</small>
                </h5>
                <hr>

                <div class="form-group row">

                    <label class="col-sm-2 col-form-label"
                           for="income"><?php echo $this->lang->line('Income') ?></label>

                    <div class="col-sm-5">
                        <input type="text" placeholder="Income"
                               class="form-control margin-bottom  required" name="income"
                               value="<?php echo $goals['income'] ?>">
                    </div>
                </div>

                <div class="form-group row">

                    <label class="col-sm-2 col-form-label"
                           for="expense"><?php echo $this->lang->line('Expenses') ?></label>

                    <div class="col-sm-5">
                        <input type="text" placeholder="Expenses"
                               class="form-control margin-bottom  required" name="expense"
                               value="<?php echo $goals['expense'] ?>">
                    </div>
                </div>

                <div class="form-group row">

                    <label class="col-sm-2 col-form-label" for="sales"><?php echo $this->lang->line('Sales') ?></label>

                    <div class="col-sm-5">
                        <input type="text" placeholder="Sales"
                               class="form-control margin-bottom  required" name="sales"
                               value="<?php echo $goals['sales'] ?>">
                    </div>
                </div>

                <div class="form-group row">

                    <label class="col-sm-2 col-form-label"
                           for="netincome"><?php echo $this->lang->line('Net Income') ?></label>

                    <div class="col-sm-5">
                        <input type="text" placeholder="Net Income"
                               class="form-control margin-bottom  required" name="netincome"
                               value="<?php echo $goals['netincome'] ?>">
                    </div>
                </div>
				<div class="form-group row">

                    <label class="col-sm-2 col-form-label"
                           for="netincome"><?php echo $this->lang->line('') ?>Usuarios</label>

                    <div class="col-sm-5">
                        <input type="text" placeholder="Net Income"
                               class="form-control margin-bottom  required" name="usuarios"
                               value="<?php echo $goals['users'] ?>">
                    </div>
                </div>
				<div class="form-group row">

                    <label class="col-sm-2 col-form-label"
                           for="netincome"><?php echo $this->lang->line('') ?>Vesagro</label>

                    <div class="col-sm-5">
                        <input type="text" placeholder="Net Income"
                               class="form-control margin-bottom  required" name="vesagro"
                               value="<?php echo $goals['vesagro'] ?>">
                    </div>
                </div>
				<div class="form-group row">

                    <label class="col-sm-2 col-form-label"
                           for="netincome"><?php echo $this->lang->line('') ?>Servicios</label>

                    <div class="col-sm-5">
                        <input type="text" placeholder="Net Income"
                               class="form-control margin-bottom  required" name="servicios"
                               value="<?php echo $goals['servicios'] ?>">
                    </div>
                </div>
				<div class="form-group row">

                    <label class="col-sm-2 col-form-label"
                           for="netincome"><?php echo $this->lang->line('') ?>Compras</label>

                    <div class="col-sm-5">
                        <input type="text" placeholder="Net Income"
                               class="form-control margin-bottom  required" name="compras"
                               value="<?php echo $goals['compras'] ?>">
                    </div>
                </div>
				<div class="form-group row">

                    <label class="col-sm-2 col-form-label"
                           for="netincome"><?php echo $this->lang->line('') ?>Creditos y Acuerdos</label>

                    <div class="col-sm-5">
                        <input type="text" placeholder="Net Income"
                               class="form-control margin-bottom  required" name="creditos"
                               value="<?php echo $goals['creditos'] ?>">
                    </div>
                </div>
				<div class="form-group row">

                    <label class="col-sm-2 col-form-label"
                           for="netincome"><?php echo $this->lang->line('') ?>Nomina</label>

                    <div class="col-sm-5">
                        <input type="text" placeholder="Net Income"
                               class="form-control margin-bottom  required" name="nomina"
                               value="<?php echo $goals['nomina'] ?>">
                    </div>
                </div>
				<div class="form-group row">

                    <label class="col-sm-2 col-form-label"
                           for="netincome"><?php echo $this->lang->line('') ?>Socios</label>

                    <div class="col-sm-5">
                        <input type="text" placeholder="Net Income"
                               class="form-control margin-bottom  required" name="socios"
                               value="<?php echo $goals['socios'] ?>">
                    </div>
                </div>
				<div class="form-group row">

                    <label class="col-sm-2 col-form-label"
                           for="netincome"><?php echo $this->lang->line('') ?>Oficial</label>

                    <div class="col-sm-5">
                        <input type="text" placeholder="Net Income"
                               class="form-control margin-bottom  required" name="oficial"
                               value="<?php echo $goals['oficial'] ?>">
                    </div>
                </div>
				<div class="form-group row">

                    <label class="col-sm-2 col-form-label"
                           for="netincome"><?php echo $this->lang->line('') ?>Ordenes de compra</label>

                    <div class="col-sm-5">
                        <input type="text" placeholder="Valor meta"
                               class="form-control margin-bottom  required" name="purchase"
                               value="<?php echo $goals['purchase'] ?>">
                    </div>
                </div>
				<div class="form-group row">

                    <label class="col-sm-2 col-form-label"
                           for="netincome"><?php echo $this->lang->line('') ?>Proveedores internet</label>

                    <div class="col-sm-5">
                        <input type="text" placeholder="Valor meta"
                               class="form-control margin-bottom  required" name="internet"
                               value="<?php echo $goals['internet'] ?>">
                    </div>
                </div>
				<div class="form-group row">

                    <label class="col-sm-2 col-form-label"
                           for="netincome"><?php echo $this->lang->line('') ?>Programadoras</label>

                    <div class="col-sm-5">
                        <input type="text" placeholder="Valor meta"
                               class="form-control margin-bottom  required" name="programadora"
                               value="<?php echo $goals['programadora'] ?>">
                    </div>
                </div>
				<div class="form-group row">

                    <label class="col-sm-2 col-form-label"
                           for="netincome"><?php echo $this->lang->line('') ?>Impuestos</label>

                    <div class="col-sm-5">
                        <input type="text" placeholder="Valor meta"
                               class="form-control margin-bottom  required" name="impuestos"
                               value="<?php echo $goals['impuestos'] ?>">
                    </div>
                </div>
				<div class="form-group row">

                    <label class="col-sm-2 col-form-label"
                           for="netincome"><?php echo $this->lang->line('') ?>Servicios publicos</label>

                    <div class="col-sm-5">
                        <input type="text" placeholder="Valor meta"
                               class="form-control margin-bottom  required" name="publicos"
                               value="<?php echo $goals['publicos'] ?>">
                    </div>
                </div>
				<div class="form-group row">

                    <label class="col-sm-2 col-form-label"
                           for="netincome"><?php echo $this->lang->line('') ?>Comisiones</label>

                    <div class="col-sm-5">
                        <input type="text" placeholder="Valor meta"
                               class="form-control margin-bottom  required" name="comisiones"
                               value="<?php echo $goals['comisiones'] ?>">
                    </div>
                </div>
				<div class="form-group row">

                    <label class="col-sm-2 col-form-label"
                           for="netincome"><?php echo $this->lang->line('') ?>Celulares</label>

                    <div class="col-sm-5">
                        <input type="text" placeholder="Valor meta"
                               class="form-control margin-bottom  required" name="celulares"
                               value="<?php echo $goals['celulares'] ?>">
                    </div>
                </div>

                <div class="form-group row">

                    <label class="col-sm-2 col-form-label"></label>

                    <div class="col-sm-4">
                        <input type="submit" id="submit-data" class="btn btn-success margin-bottom"
                               value="<?php echo $this->lang->line('Update') ?>" data-loading-text="Adding...">
                        <input type="hidden" value="tools/setgoals" id="action-url">
                    </div>
                </div>


            </form>
        </div>
    </div>
</article>