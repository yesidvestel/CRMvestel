<article class="content">
    <div class="card card-block">
        <div id="notify" class="alert alert-success" style="display:none;">
            <a href="#" class="close" data-dismiss="alert">&times;</a>

            <div class="message"></div>
        </div>
        <form method="post" id="data_form" class="form-horizontal">
            <div class="grid_3 grid_4">

                <h5>Edit Product warehouse</h5>
                <hr>


                <input type="hidden" name="catid" value="<?php echo $warehouse['id'] ?>">


                <div class="form-group row">

                    <label class="col-sm-2 col-form-label" for="product_cat_name">Warehouse Name</label>

                    <div class="col-sm-8">
                        <input type="text"
                               class="form-control margin-bottom  required" name="product_cat_name"
                               value="<?php echo $warehouse['title'] ?>">
                    </div>
                </div>


                <div class="form-group row">

                    <label class="col-sm-2 col-form-label">Description</label>

                    <div class="col-sm-8">


                        <input type="text" name="product_cat_desc" class="form-control required"
                               aria-describedby="sizing-addon1" value="<?php echo $warehouse['extra'] ?>">

                    </div>

                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Lista de Tecnicos</label>
                    <div class="col-sm-8">
                        <select class="form-control" name="id_del_tecnico" id="id_del_tecnico">
                            <option value="">Ninguno</option>
                            <?php $varx=false; foreach ($lista_de_tecnicos as $key => $tecnico) {
                                $texto1="";
                                if($warehouse['id_tecnico']===$tecnico['username']){
                                    $texto1='selected="true"';
                                    $varx=true;
                                }
                                $almacen=$this->db->get_where('product_warehouse',array("id_tecnico"=>$tecnico['id']))->row();
                                if(empty($almacen)  ){//esta validacion es para saber si el tecnico ya esta asignado a un almacen, si esta vacia la busqueda significa que esta disponible el tecnico y lo deja visualizar
                                ?>

                                <option value="<?=$tecnico['username']?>" <?= $texto1?>  ><?=$tecnico['username']?></option>
                            <?php }else if($texto1!=""){ //aqui es para visualizar cuando el tecnico esta asignado al almacen el cual se esta editando;  ?>
                                    <option value="<?=$tecnico['username']?>" <?= $texto1?>  ><?=$tecnico['username']?></option>
                        <?php }}//falta replicar esto al añadir almacen ?>
                        </select>
                </div>
                </div>


                <div class="form-group row">

                    <label class="col-sm-2 col-form-label"></label>

                    <div class="col-sm-4">
                        <input type="submit" id="submit-data" class="btn btn-success margin-bottom"
                               value="Update" data-loading-text="Updating...">
                        <input type="hidden" value="productcategory/editwarehouse" id="action-url">
                    </div>
                </div>

            </div>
        </form>
    </div>

</article>
<script type="text/javascript">
    var seleccionado=<?= $varx ?>;
    if(seleccionado==1){
        $("#id_del_tecnico").prop('disabled','true');
    }
</script>
