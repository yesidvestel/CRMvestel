<article class="content">
    <div class="card card-block">
        <div id="notify" class="alert alert-success" style="display:none;">
            <a href="#" class="close" data-dismiss="alert">&times;</a>

            <div class="message"></div>
        </div>
        <div class="grid_3 grid_4">
            <h6>Editar Variables</h6>
            <hr>
            

            <div class="row sameheight-container">
                <div class="col-md-6">
                    <div class="card card-block sameheight-item">

                        <form action="<?php echo base_url() ?>clientgroup/guardar_datos_api" method="post" role="form">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label"
                                       for="pay_cat">Api</label>

                                <div class="col-sm-9">
                                    <select name="pay_acc" class="form-control" id="cuentas_">
                                        <?php
                                        foreach ($apis as $row) {
                                            
                                            
                                            
                                                echo "<option value='".$row['nombre_api']."'>".ucwords($row['nombre_api'])."</option>";
                                            
                                        }
                                        ?>
                                    </select>


                                </div>

                            </div>
        <?php  foreach ($apis as $row) {
            $array_datos=json_decode($row['valor']);
            ?>          <div id="div_<?=$row['nombre_api'] ?>">
                <?php foreach ($array_datos as $key => $value) {?>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label"
                                       for="pay_cat"><?= $key ?></label>

                                <div class="col-sm-9">
                                    <input type="text" name="<?=$row['nombre_api'].'_'.$key?>" class="form-control" value="<?=$value?>">


                                </div>

                            </div>
                    <?php } ?>
                    </div>
        <?php } ?>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label" for="pay_cat"></label>

                                <div class="col-sm-4">
                                    <input type="submit" class="btn btn-primary btn-md" value="Actualizar">


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

