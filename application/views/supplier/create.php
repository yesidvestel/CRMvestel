<article class="content">
    <div class="card card-block">
        <div id="notify" class="alert alert-success" style="display:none;">
            <a href="#" class="close" data-dismiss="alert">&times;</a>

            <div class="message"></div>
        </div>
        <form method="post" id="data_form" class="form-horizontal">
            <div class="grid_3 grid_4">

                <h5><?php echo $this->lang->line('Add New supplier Details') ?></h5>
                <hr>


                <div class="form-group row">

                    <label class="col-sm-2 col-form-label" for="name"><?php echo $this->lang->line('Name') ?></label>

                    <div class="col-sm-6">
                        <input type="text" placeholder="Nombre"
                               class="form-control margin-bottom  required" name="name">
                    </div>
                </div>
                <div class="form-group row">

                    <label class="col-sm-2 col-form-label" for="nit"><?php echo $this->lang->line('') ?>NIT</label>

                    <div class="col-sm-6">
                        <input type="text" placeholder="Numero de identificacion tributario"
                               class="form-control margin-bottom  required" name="nit" id="mcustumer_nit">
                    </div>
                </div>
                <div class="form-group row">

                    <label class="col-sm-2 col-form-label" for="company"><?php echo $this->lang->line('Company') ?></label>

                    <div class="col-sm-6">
                        <input type="text" placeholder="Empresa"
                               class="form-control margin-bottom  required" name="company">
                    </div>
                </div>

                <div class="form-group row">

                    <label class="col-sm-2 col-form-label" for="phone"><?php echo $this->lang->line('Phone') ?></label>

                    <div class="col-sm-6">
                        <input type="text" placeholder="Telefono"
                               class="form-control margin-bottom  required" name="phone">
                    </div>
                </div>
                <div class="form-group row">

                    <label class="col-sm-2 col-form-label" for="email"><?php echo $this->lang->line('Email') ?></label>

                    <div class="col-sm-6">
                        <input type="text" placeholder="email"
                               class="form-control margin-bottom required" name="email">
                    </div>
                </div>
                <div class="form-group row">

                    <label class="col-sm-2 col-form-label"
                           for="address"><?php echo $this->lang->line('Address') ?></label>

                    <div class="col-sm-6">
                        <input type="text" placeholder="Direccion"
                               class="form-control margin-bottom required" name="address">
                    </div>
                </div>
                <div class="form-group row">

                    <label class="col-sm-2 col-form-label" for="city"><?php echo $this->lang->line('City') ?></label>

                    <div class="col-sm-6">
                        <input type="text" placeholder="Ciudad"
                               class="form-control margin-bottom" name="city">
                    </div>
                </div>
                <div class="form-group row">

                    <label class="col-sm-2 col-form-label"
                           for="region"><?php echo $this->lang->line('') ?>Departamento</label>

                    <div class="col-sm-6">
                        <input type="text" placeholder="Departamento"
                               class="form-control margin-bottom" name="region">
                    </div>
                </div>
                <div class="form-group row">

                    <label class="col-sm-2 col-form-label"
                           for="cuenta"><?php echo $this->lang->line('') ?>Cuenta</label>

                    <div class="col-sm-6">
                        <input type="text" placeholder="N° cuenta"
                               class="form-control margin-bottom" name="cuenta">
                    </div>
                </div>
                <div class="form-group row">

                    <label class="col-sm-2 col-form-label"
                           for="postbox"><?php echo $this->lang->line('') ?>Tipo</label>

                    <div class="col-sm-6">
                        <select name="typo" class="form-control">
                            <option value='Ahorros'>Ahorros</option>
                            <option value='Corriente'>Corriente</option>
                         </select>
                    </div>
                </div>
                <div class="form-group row">

                    <label class="col-sm-2 col-form-label"
                           for="postbox"><?php echo $this->lang->line('') ?>Banco</label>

                    <div class="col-sm-6">
                        <select name="banco" class="form-control">
                            <option value='Bancolombia'>Bancolombia</option>
                            <option value='Banco de bogota'>Banco de bogota</option>
                            <option value='Av villas'>Av villas</option>
                            <option value='Banco caja social'>Banco caja social</option>
                            <option value='Banco Agrario'>Banco Agrario</option>
                            <option value='Banco Davivienda'>Banco Davivienda</option>
                            <option value='Banco BBVA'>Banco BBVA</option>
                        </select>
                    </div>
                </div>


                <div class="form-group row">

                    <label class="col-sm-2 col-form-label"></label>

                    <div class="col-sm-4">
                        <input type="submit" id="submit-data" class="btn btn-success margin-bottom"
                               value="<?php echo $this->lang->line('Add') ?>" data-loading-text="Adding...">
                        <input type="hidden" value="supplier/addsupplier" id="action-url">
                    </div>
                </div>

            </div>
        </form>
    </div>
</article>

