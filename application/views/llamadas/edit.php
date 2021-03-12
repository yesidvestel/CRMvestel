<article class="content">
    <div class="card card-block">
        <div id="notify" class="alert alert-success" style="display:none;">
            <a href="#" class="close" data-dismiss="alert">&times;</a>

            <div class="message"></div>
        </div>
        <form method="post" id="data_form" class="form-horizontal">
            <div class="grid_3 grid_4">

                <h5><?php echo $this->lang->line('Edit supplier Details') ?></h5>
                <hr>


                <input type="hidden" name="id" value="<?php echo $customer['id'] ?>">


                <div class="form-group row">

                    <label class="col-sm-2 col-form-label"
                           for="product_name"><?php echo $this->lang->line('Name') ?></label>

                    <div class="col-sm-6">
                        <input type="text" placeholder="Name"
                               class="form-control margin-bottom  required" name="name"
                               value="<?php echo $customer['name'] ?>">
                    </div>
                </div>
                <div class="form-group row">

                    <label class="col-sm-2 col-form-label"
                           for="product_name"><?php echo $this->lang->line('') ?>NIT</label>

                    <div class="col-sm-6">
                        <input type="text" placeholder="Numero de identificacion tributario"
                               class="form-control margin-bottom  required" name="nit"
                               value="<?php echo $customer['nit'] ?>">
                    </div>
                </div>
                <div class="form-group row">

                    <label class="col-sm-2 col-form-label"
                           for="product_name"><?php echo $this->lang->line('Company') ?></label>

                    <div class="col-sm-6">
                        <input type="text" placeholder="Company"
                               class="form-control margin-bottom  required" name="company"
                               value="<?php echo $customer['company'] ?>">
                    </div>
                </div>

                <div class="form-group row">

                    <label class="col-sm-2 col-form-label" for="phone"><?php echo $this->lang->line('Phone') ?></label>

                    <div class="col-sm-6">
                        <input type="text" placeholder="phone"
                               class="form-control margin-bottom  required" name="phone"
                               value="<?php echo $customer['phone'] ?>">
                    </div>
                </div>
                <div class="form-group row">

                    <label class="col-sm-2 col-form-label" for="email"><?php echo $this->lang->line('Email') ?></label>

                    <div class="col-sm-6">
                        <input type="text" placeholder="email"
                               class="form-control margin-bottom  required" name="email"
                               value="<?php echo $customer['email'] ?>">
                    </div>
                </div>
                <div class="form-group row">

                    <label class="col-sm-2 col-form-label"
                           for="product_name"><?php echo $this->lang->line('Address') ?></label>

                    <div class="col-sm-6">
                        <input type="text" placeholder="address"
                               class="form-control margin-bottom  required" name="address"
                               value="<?php echo $customer['address'] ?>">
                    </div>
                </div>
                <div class="form-group row">

                    <label class="col-sm-2 col-form-label" for="city"><?php echo $this->lang->line('City') ?></label>

                    <div class="col-sm-6">
                        <input type="text" placeholder="city"
                               class="form-control margin-bottom  required" name="city"
                               value="<?php echo $customer['city'] ?>">
                    </div>
                </div>
                <div class="form-group row">

                    <label class="col-sm-2 col-form-label"
                           for="region"><?php echo $this->lang->line('') ?>Departamento</label>

                    <div class="col-sm-6">
                        <input type="text" placeholder="Departamento"
                               class="form-control margin-bottom  required" name="region"
                               value="<?php echo $customer['region'] ?>">
                    </div>
                </div>
                <div class="form-group row">

                    <label class="col-sm-2 col-form-label"
                           for="country"><?php echo $this->lang->line('') ?>Cuenta</label>

                    <div class="col-sm-6">
                        <input type="text" placeholder="N° cuenta"
                               class="form-control margin-bottom  required" name="cuenta"
                               value="<?php echo $customer['cuenta'] ?>">
                    </div>
                </div>
                <div class="form-group row">

                    <label class="col-sm-2 col-form-label"
                           for="postbox"><?php echo $this->lang->line('') ?>Tipo</label>

                    <div class="col-sm-6">
                        <select name="typo" class="form-control">
                        	<option value='<?php echo $customer['typo'] ?>'><?php echo $customer['typo'] ?></option>
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
                        	<option value='<?php echo $customer['banco'] ?>'><?php echo $customer['banco'] ?></option>
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
                               value="<?php echo $this->lang->line('Update') ?>" data-loading-text="Updating...">
                        <input type="hidden" value="supplier/editsupplier" id="action-url">
                    </div>
                </div>

            </div>
        </form>
    </div>
</article>

