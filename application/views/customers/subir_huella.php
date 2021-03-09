<article class="content">
    <div class="card card-block">
        <div id="notify" class="alert alert-success" style="display:none;">
            <a href="#" class="close" data-dismiss="alert">&times;</a>

            <div class="message"></div>
        </div>
        <div class="grid_3 grid_4">
            <h6><?php echo $this->lang->line('') ?>Subir imagen de huella Generada en aplicacion de escritorio</h6>
            <hr>
            

            <div class="row sameheight-container">
                <div class="col-md-6">
                    <div class="card card-block sameheight-item">

                        <form action="<?php echo base_url() ?>customers/subir_huella" method="post" role="form" enctype="multipart/form-data">
                            <div class="form-group row">
                            <input type="hidden" name="id" value="<?=$id?>">        
                                <label class="col-sm-3 control-label"
                                       for="sdate2">Subir Archivo</label>

                                <div class="col-sm-12">
                                    <input type="file" class="form-control required" required name="archivo_huella" accept="image/png, image/jpeg">
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