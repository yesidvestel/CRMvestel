<article class="content">
    <div class="card card-block">
        <div id="notify" class="alert alert-success" style="display:none;">
            <a href="#" class="close" data-dismiss="alert">&times;</a>

            <div class="message"></div>
        </div>
        <div class="grid_3 grid_4 table-responsive animated fadeInRight">
			<?php $almacen=$this->db->get_where('product_warehouse',array('id'=>$_GET['id']))->row(); ?>
            <h5><?php echo $almacen->title;?></h5>
			<!-- paneles -->
            <div class="card">
                    <div class="card-body">
                        	<label class="col-sm-12 col-form-label"
                                       for="pay_cat"><h5>FILTRAR </h5> </label>
                            <div class="tab-content px-3 pt-1">
								
                                <div role="tabpanel" class="tab-pane fade active in" id="active" aria-labelledby="active-tab" aria-expanded="true">
                                    <div class="form-group row">
                                        
                                        <label class="col-sm-2">Categoria</label>

                                        <div class="col-sm-6">
                                            <select name="cate" class="form-control select-box" id="cate">
                                                
                                                <option value=''>Todas</option>
                                                <?php
                                                    foreach ($categoria as $row) {
                                                        $cid = $row['id'];
                                                        $title = $row['title'];
                                                        echo "<option value='$cid'>$title</option>";
                                                    }
                                                    ?>
                                            </select>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                                <label class="col-sm-3 col-form-label" for="pay_cat"></label>

                                <div class="col-sm-4">
                                    <input type="button" class="btn btn-primary btn-md" value="VER" onclick="filtrar()">


                                </div>
                            </div>
					<a href="#" onclick="redirect_to_export()" class="btn btn-success btn-md">Exportar a Excel .XLSX</a>
                </div>
                <!-- fin paneles -->

            <hr>
            <table id="productstable" class="display" cellspacing="0" width="100%">
                <thead>
                <tr>
                    <th>#</th>
                    <th><?php echo $this->lang->line('Name') ?></th>
                    <th><?php echo $this->lang->line('Stock') ?></th>
                    <th><?php echo $this->lang->line('Code') ?></th>
                    <th><?php echo $this->lang->line('Category') ?></th>
                    <th><?php echo $this->lang->line('Price') ?></th>
                    <th><?php echo $this->lang->line('Settings') ?></th>


                </tr>
                </thead>
                <tbody>
                </tbody>

                <tfoot>
                <tr>
                    <th>#</th>
                    <th><?php echo $this->lang->line('Name') ?></th>
                    <th><?php echo $this->lang->line('Stock') ?></th>
                    <th><?php echo $this->lang->line('Code') ?></th>
                    <th><?php echo $this->lang->line('Category') ?></th>
                    <th><?php echo $this->lang->line('Price') ?></th>
                    <th><?php echo $this->lang->line('Settings') ?></th>

                </tr>
                </tfoot>
            </table>
        </div>
    </div>
</article>
<script type="text/javascript">

    var table;
var id_warehouse="<?=$_GET['id'] ?>";
    $(document).ready(function () {

        //datatables
        table = $('#productstable').DataTable({

            "processing": true, //Feature control the processing indicator.
            "serverSide": true, //Feature control DataTables' server-side processing mode.
            "order": [], //Initial no order.

            // Load data for the table's content from an Ajax source
            "ajax": {
                "url": "<?php echo site_url('products/warehouseproduct_list') . '?id=' . $_GET['id']; ?>",
                "type": "POST"
            },
			

            //Set column definition initialisation properties.
            "columnDefs": [
                {
                    "targets": [0], //first column / numbering column
                    "orderable": false, //set not orderable
                },
            ],

        });

    });
	function filtrar(){
        var categoria=$("#cate").val();
		if(categoria==""){
            table.ajax.url( baseurl+'products/warehouseproduct_list?id='+id_warehouse).load();     
        }else{
            table.ajax.url( baseurl+"products/warehouseproduct_list?id="+id_warehouse+"&categoria="+categoria ).load();     
        }
       

    }
	function redirect_to_export(){
         //var tecnico=$("#tecnicos2").val();
        var url_redirect=baseurl+'productcategory/explortar_a_excel?id=<?=$_GET['id']?>';
            window.location.replace(url_redirect);

    }
</script>
<div id="delete_model" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><?php echo $this->lang->line('Delete') ?></h4>
            </div>
            <div class="modal-body">
                <p><?php echo $this->lang->line('delete this product') ?></p>
            </div>
            <div class="modal-footer">
                <input type="hidden" id="object-id" value="">
                <input type="hidden" id="action-url" value="products/delete_i">
                <button type="button" data-dismiss="modal" class="btn btn-primary"
                        id="delete-confirm"><?php echo $this->lang->line('Delete') ?></button>
                <button type="button" data-dismiss="modal"
                        class="btn"><?php echo $this->lang->line('Cancel') ?></button>
            </div>
        </div>
    </div>
</div>