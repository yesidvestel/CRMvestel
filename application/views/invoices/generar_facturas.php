<article class="content">
    <div class="card card-block">
        <div id="notify" class="alert alert-success" style="display:none;">
            <a href="#" class="close" data-dismiss="alert">&times;</a>

            <div class="message"></div>
        </div>
        <div class="grid_3 grid_4">
            <h6><?php echo $this->lang->line('') ?>Generar Facturas</h6>
            <hr>
            

            <div class="row sameheight-container">
                <div class="col-md-6">
                    <div class="card card-block sameheight-item">

                        <form action="<?php echo base_url() ?>invoices/generar_facturas_action" method="post" role="form">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label"
                                       for="pay_cat"><?php echo $this->lang->line('') ?>Sede</label>

                                <div class="col-sm-9">
                                    <select name="pay_acc" class="form-control" id="cuentas_">
                                        <?php
                                        foreach ($accounts as $row) {
                                            $cid = $row['id'];
                                            $acn = $row['acn'];
                                            $holder = $row['holder'];
                                            if($cid<6 || $cid==9){
                                                echo "<option value='$cid'>$acn - $holder</option>";
                                            }
                                        }
                                        ?>
                                    </select>


                                </div>

                            </div>
 
                            <div class="form-group row">

                                <label class="col-sm-3 control-label"
                                       for="sdate2">Fecha</label>

                                <div class="col-sm-4">
                                    <input type="text" class="form-control required"
                                           placeholder="Start Date" name="sdate" id="sdate2"
                                            autocomplete="false" >
                                </div>
                            </div>
                          
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label" for="pay_cat"></label>

                                <div class="col-sm-4">
                                    <input type="submit" class="btn btn-primary btn-md" value="Generar">


                                </div>
                            </div>

                        </form>
                    </div>
                </div>

            </div>

        </div>
    </div>
</article>
<?php //se hizo el cambio de fecha en el archivo views/fixed/footer ?>

