<article class="content">
    <div class="card card-block">
        <div id="notify" class="alert alert-success" style="display:none;">
            <a href="#" class="close" data-dismiss="alert">&times;</a>

            <div class="message"></div>
        </div>
        <form method="post" id="data_form" class="form-horizontal">
            <div class="grid_3 grid_4">

                <h5>Nueva Plantilla</h5>
                <hr>
                <input type="hidden" name="id" value="<?php echo $sms['id'] ?>">
				<div class="form-group row">

                    <label class="col-sm-2 col-form-label"
                           for="amount">Nombre</label>

                    <div class="col-sm-6">
                        <input type="text" placeholder="Nombre de plantilla"
                               class="form-control margin-bottom  required" name="nombre">
                    </div>
                </div>
				


                <div class="form-group row">

                    <label class="col-sm-2 col-form-label" for="body"><?php echo $this->lang->line('Body') ?></label>

                    <div class="col-sm-8">
                        <textarea
                               class="form-control margin-bottom summernote" name="body"
                        rows="15"></textarea>
                    </div>
                </div>

                <div class="form-group row">

                    <label class="col-sm-2 col-form-label"></label>

                    <div class="col-sm-4">
                        <input type="submit" id="submit-data" class="btn btn-success margin-bottom"
                               value="Crear" data-loading-text="Updating...">
                        <input type="hidden" value="templates/sms_input" id="action-url">
                    </div>
                </div>

            </div>
        </form>
        <div class="box"> <div class="col-sm-2">Variables are </div><div class="col-sm-8"><?php if($sms['id']=="37") { ?> {primer_nombre}, {segundo_nombre}, {primer_apellido}, {segundo_apellido}, {monto_debe}, {documento}, {mes_actual}<?php  }else{ ?> {BillNumber}, {URL},{DueDate},{Amount} <?php } ?></div></div>

    </div>

</article>
