<article class="content">
    <div class="card card-block">
        <div id="notify" class="alert alert-success" style="display:none;">
            <a href="#" class="close" data-dismiss="alert">&times;</a>
			
            <div class="message"></div>
        </div>
        <div class="grid_3 grid_4 table-responsive">
			
            <h5>Transferencias</h5>
			<a href="#" onclick="redirect_to_export()" class="btn btn-success btn-md">Exportar a Excel .XLSX</a>
            <hr>
            <table id="trans_table" class="display" cellspacing="0" width="100%">
                <thead>
                <tr>
                    <th><?php echo $this->lang->line('Date') ?></th>
                    <th><?php echo $this->lang->line('Account') ?></th>
                    <th><?php echo $this->lang->line('Debit') ?></th>
                    <th><?php echo $this->lang->line('Credit') ?></th>
					<th>Nota</th>
                    <th><?php echo $this->lang->line('Payer') ?></th>
                    <th><?php echo $this->lang->line('Method') ?></th>
					<th>Categoria</th>
					<th>Estado</th>
                    <th>Comprobante</th>


                </tr>
                </thead>
                <tbody>
                </tbody>

            </table>
        </div>
    </div>
</article>

<script type="text/javascript">

    $(document).ready(function () {
        $('#trans_table').DataTable({
            "processing": true,
            "serverSide": true,
            "stateSave": true,
            "ajax": {
                "url": "<?php echo site_url('transactions/translist?type=transferencia')?>",
                "type": "POST"
            },
            "columnDefs": [
                {
                    "targets": [0],
                    "orderable": true,
                },
            ],
        });
    });
	function redirect_to_export(){
         
        var url_redirect=baseurl+'transactions/explortar_a_excel';
            window.location.replace(url_redirect);

    }
	function abrir_modal2(link){
        $("#pop_model2").modal("show");
        $("#object-id2").val($(link).data("object-id2"));
        $("#object-cat").val($(link).data("object-cat"));
		var object =$(link).data("object-id2");	
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
                <p><?php echo $this->lang->line('delete this transaction') ?></p>
            </div>
            <div class="modal-footer">
                <input type="hidden" id="object-id" value="">
                <input type="hidden" id="action-url" value="transactions/delete_i">
                <button type="button" data-dismiss="modal" class="btn btn-primary"
                        id="delete-confirm"><?php echo $this->lang->line('Delete') ?></button>
                <button type="button" data-dismiss="modal"
                        class="btn"><?php echo $this->lang->line('Cancel') ?></button>
            </div>
        </div>
    </div>
</div>
<div id="pop_model2" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Comprobante</h4>
            </div>			
            <div class="modal-body">
                <form id="form_model2" enctype="multipart/form-data">
				 <div class="col-sm-6">
                            <input id="fileupload" type="file" name="files[]" >
                        </span>
                        <br>
                        
                    </div>
                </div>
				<div class="modal-body">
                        <button type="button" class="btn btn-default"
                                data-dismiss="modal">Volver</button>
                        <input type="text" id="object-id2" value="" name="id">
                        <input type="text" value="transfer" name="cat">
                <input type="hidden" id="action-url2" value="transactions/displaypic">
                <button type="button" data-dismiss="modal" class="btn btn-primary"
                        id="submit_model2-tr-nw">Subir</button>
                 </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
$("#submit_model2-tr-nw").on("click", function(e) {
    e.preventDefault();
    var o_data =  $("#form_model2").serializeArray();
     var form_data = new FormData();
     var file_date=$("#fileupload").prop("files")[0];
     form_data.append("files",file_date);

    $.map(o_data, function(n, i){console.log(n['name']);
        form_data.append(n['name'], n['value']);
    });

     
    var action_url= $('#action-url2').val();
    addObject_eq(form_data,action_url);
});
</script>