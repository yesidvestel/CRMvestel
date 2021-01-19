<article class="content">
    <div class="card card-block">
        <div id="notify" class="alert alert-success" style="display:none;">
            <a href="#" class="close" data-dismiss="alert">&times;</a>

            <div class="message"></div>
        </div>
        <div class="grid_3 grid_4">


            <form method="post" id="data_form" class="form-horizontal">

                <h5><?php echo $this->lang->line('Add New Product Warehouse') ?></h5>
                <hr>

                <div class="form-group row">

                    <label class="col-sm-2 col-form-label"
                           for="product_catname"><?php echo $this->lang->line('Name') ?></label>

                    <div class="col-sm-6">
                        <input type="text" placeholder="Product Warehouse Name"
                               class="form-control margin-bottom  required" name="product_catname">
                    </div>
                </div>
                <div class="form-group row">

                    <label class="col-sm-2 col-form-label"
                           for="product_catname"><?php echo $this->lang->line('Description') ?></label>

                    <div class="col-sm-6">
                        <input type="text" placeholder="Product Warehouse Description"
                               class="form-control margin-bottom required" name="product_catdesc">
                    </div>
                </div>
<div class="form-group row">
                    <label class="col-sm-2 col-form-label">Lista de Tecnicos</label>
                    <div class="col-sm-8">
                        <select class="form-control" name="id_del_tecnico" id="id_del_tecnico">
                            <option value="">Ninguno</option>
                            <?php foreach ($lista_de_tecnicos as $key => $tecnico) {
                                
                                $almacen=$this->db->get_where('product_warehouse',array("id_tecnico"=>$tecnico['username']))->row();
                                if(empty($almacen)){//esta validacion es para saber si el tecnico ya esta asignado a un almacen, si esta vacia la busqueda significa que esta disponible el tecnico y lo deja visualizar
                                ?>

                                <option value="<?=$tecnico['username']?>" <?= $texto1?>  ><?=$tecnico['username']?></option>
                            <?php }} ?>
                        </select>
                </div>
                </div>

                <div class="form-group row">

                    <label class="col-sm-2 col-form-label"></label>

                    <div class="col-sm-4">
                        <input type="submit" id="submit-data" class="btn btn-success margin-bottom"
                               value="<?php echo $this->lang->line('Add') ?>" data-loading-text="Adding...">
                        <input type="hidden" value="productcategory/addwarehouse" id="action-url">
                    </div>
                </div>


            </form>
        </div>
    </div>
</article>

