<article class="content">
    <div class="card card-block">
        <div id="notify" class="alert alert-success" style="display:none;">
            <a href="#" class="close" data-dismiss="alert">&times;</a>

            <div class="message"></div>
        </div>
        <form method="post" action="<?=base_url()?>importequipo/equipos_upload" enctype="multipart/form-data">

            
        <?php //echo form_open_multipart('importequipo/equipos_upload'); ?>
            <div class="grid_3 grid_4">
                <h5><?php echo $this->lang->line('') ?>Importar Equipos</h5>
                <hr>
                <p>El archivo de datos de sus productos debe seguir esta plantilla <a href="http://www.ultimatekode.com/samples/products_import.csv"><strong>Descargar plantilla</strong></a>. Please download a database backup before importing the products.</p>
<p>Column Order in CSV File Must be like this</p>
 <pre>
     1. (numero)Codigo, 2. (string)Proveedor, 3.(string)Almacen, 4.(string)Mac,

     5.(string)Serial, 6.(data)Fecha Llegada, 7.(data)Fecha asignado,

     8.(string)marca, 9.(number)Abonado del asignado, 10.(string)Estado de equipo, 
	 
	 11.(string)detalles
</pre>

                <hr>
                <div class="form-group row">

                    <label class="col-sm-2 col-form-label" for="name">Documento
                        </label>

                    <div class="col-sm-6">
                        <input type="file" name="cargar_csv" accept=".csv" required="true"/>(Solo Formato CSV)
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

