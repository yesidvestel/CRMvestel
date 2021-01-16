<article class="content content items-list-page">
    <div class="card card-block">
        <div id="notify" class="alert alert-success" style="display:none;">
            <a href="#" class="close" data-dismiss="alert">&times;</a>

            <div class="message"></div>
        </div>
		 <div class="card card-block sameheight-item">

                        
                            <div class="form-group row">
								<label class="col-sm-12 col-form-label"
                                       for="pay_cat"><h5>FILTRAR</h5></label>
                                <label class="col-sm-2 col-form-label"
                                       for="pay_cat">Tecnico</label>

                                <div class="col-sm-6">
                                    <select name="tec" class="form-control" id="estado">
                                        <option value=''>Todos</option>
                                        <option value='Activos'>Activos</option>
										<option value='Cortados'>Cortados</option>
                                    </select>
                                </div>
                            </div>
							<div class="form-group row">
                                <label class="col-sm-2 col-form-label"
                                       for="pay_cat">Estado</label>

                                <div class="col-sm-6">
                                    <select name="trans_type" class="form-control" id="depar">
                                        <option value=''>Todas</option>
                                        <option value='CASANARE'>CASANARE</option>
                                        <option value='MOCOA'>MOCOA</option>
                                    </select>
                                </div>								
                            </div>
							<div class="form-group row">
                                <label class="col-sm-3 col-form-label" for="pay_cat"></label>

                                <div class="col-sm-4">
                                    <input type="button" class="btn btn-primary btn-md" value="VER" onclick="filtrar()">


                                </div>
                            </div>
                        
                    </div>
        <div class="grid_3 grid_4">
            <h5><?php echo $this->lang->line('Client Group') . '- ' . $group['title'] ?></h5> 
			<a href="#sendMail" data-toggle="modal" data-remote="false" class="btn btn-primary btn-sm"><i
                        class="fa fa-envelope"></i> <?php echo $this->lang->line('Send Group Message') ?> </a>
            <hr>
            <table id="fclientstable" class="table-striped" cellspacing="0" width="100%">
                <thead>
                <tr>
                    <th>#</th>
					<th>Abonado</th>
					<th>Cedula</th>
                    <th><?php echo $this->lang->line('Name') ?></th>
					<th>Celular</th>
                    <th><?php echo $this->lang->line('Address') ?></th>
					<th>Estado</th>
                    <th><?php echo $this->lang->line('Settings') ?></th>


                </tr>
                </thead>
                <tbody>
                </tbody>

                <tfoot>
                <tr>
                    <th>#</th>
					<th>Abonado</th>
					<th>Cedula</th>
                    <th><?php echo $this->lang->line('Name') ?></th>
					<th>Celular</th>
                    <th><?php echo $this->lang->line('Address') ?></th>
					<th>Estado</th>
                    <th><?php echo $this->lang->line('Settings') ?></th>
                </tr>
                </tfoot>
            </table>
        </div>
    </div>
</article>
<script type="text/javascript">
    $(document).ready(function () {

        $('#fclientstable').DataTable({

            "processing": true, //Feature control the processing indicator.
            "serverSide": true, //Feature control DataTables' server-side processing mode.
            "order": [], //Initial no order.

            // Load data for the table's content from an Ajax source
            "ajax": {
                "url": "<?php echo site_url('clientgroup/grouplist') . '?id=' . $group['id']; ?>",
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
</script>
<div id="delete_model" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><?php echo $this->lang->line('Delete') ?> </h4>
            </div>
            <div class="modal-body">
                <p><?php echo $this->lang->line('delete this customer') ?> </p>
            </div>
            <div class="modal-footer">
                <input type="hidden" id="object-id" value="">
                <input type="hidden" id="action-url" value="customers/delete_i">
                <button type="button" data-dismiss="modal" class="btn btn-primary"
                        id="delete-confirm"><?php echo $this->lang->line('Delete') ?> </button>
                <button type="button" data-dismiss="modal"
                        class="btn"><?php echo $this->lang->line('Cancel') ?> </button>
            </div>
        </div>
    </div>
</div>

<div id="sendMail" class="modal fade">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"><?php echo $this->lang->line('Email to group') ?> </h4>
            </div>

            <div class="modal-body" id="emailbody">
                <form id="sendmail_form">


                    <div class="row">
                        <div class="col-xs-12 mb-1"><label
                                    for="shortnote"><?php echo $this->lang->line('Group Name') ?> </label>
                            <input type="text" class="form-control"
                                   value="<?php echo $group['title'] ?>"></div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 mb-1"><label
                                    for="shortnote"><?php echo $this->lang->line('Subject') ?></label>
                            <input type="text" class="form-control"
                                   name="subject" id="subject">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 mb-1"><label
                                    for="shortnote"><?php echo $this->lang->line('Message') ?></label>
                            <textarea name="text" class="summernote" id="contents" title="Contents"></textarea></div>
                    </div>

                    <input type="hidden" class="form-control"
                           name="gid" value="<?php echo $group['id'] ?>">
                    <input type="hidden" id="action-url" value="clientgroup/sendGroup">


                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default"
                        data-dismiss="modal"><?php echo $this->lang->line('Close') ?> </button>
                <button type="button" class="btn btn-primary"
                        id="sendNow"><?php echo $this->lang->line('Send') ?> </button>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(function () {
        $('.summernote').summernote({
            height: 100,
            toolbar: [
                // [groupName, [list of button]]
                ['style', ['bold', 'italic', 'underline', 'clear']],
                ['font', ['strikethrough', 'superscript', 'subscript']],
                ['fontsize', ['fontsize']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['height', ['height']],
                ['fullscreen', ['fullscreen']],
                ['codeview', ['codeview']]
            ]
        });

        $('form').on('submit', function (e) {
            e.preventDefault();
            alert($('.summernote').summernote('code'));
            alert($('.summernote').val());
        });
    });
	function filtrar(){
        var estado=$("#estado option:selected").val();
        var depar =$("#depar option:selected").val();
        if(estado=="" && depar==""){
            tb.ajax.url( baseurl+'clientgroup/grouplist?id=' ).load();     
        }else{
            tb.ajax.url( baseurl+'clientgroup/grouplist?estado='+estado+"&depar="+depar+"&id=" ).load();     
        }
       

    }
</script>