<article class="content content items-list-page">
    <div class="card card-block">
        <div id="notify" class="alert alert-success" style="display:none;">
            <a href="#" class="close" data-dismiss="alert">&times;</a>

            <div class="message"></div>
        </div>
        <div class="grid_3 grid_4">
                            <div class="form-group row">
                                <label class="col-sm-12 col-form-label"
                                       for="pay_cat"><h5>FILTRAR</h5></label>
                                <label class="col-sm-2 col-form-label"
                                       for="pay_cat">Deudores Morosos</label>

                                <div class="col-sm-6">
                                    <select name="tec" class="form-control" id="deudores">
                                        <option value=''>Todos</option>
                                        <option value='Si'>Morosos</option>
                                    </select>
                                </div>
                            </div>
                                <div class="form-group row">
                                <label class="col-sm-3 col-form-label" for="pay_cat"></label>

                                <div class="col-sm-4">
                                    <input type="button" class="btn btn-primary btn-md" value="VER" onclick="filtrar()">


                                </div>
                            </div>
                                                    
            <h5><?php echo $this->lang->line('') ?>USUARIOS</h5>

            <hr>
            <div class="table-responsive">
                <table id="clientstable" class="table-striped" cellspacing="0" width="100%">
                    <thead>
                    <tr>
                        <th>#</th>
						<th>Abonado</th>
                        <th><?php echo $this->lang->line('Name') ?></th>
						<th>Celular</th>
						<th>Cedula</th>
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
                        <th><?php echo $this->lang->line('Name') ?></th>
						<th>Celular</th>
						<th>Cedula</th>
                        <th><?php echo $this->lang->line('Address') ?></th>
						<th>Estado</th>
                        <th><?php echo $this->lang->line('Settings') ?></th>


                    </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</article>
<script type="text/javascript">
    var tb;
    $(document).ready(function () {
        tb=$('#clientstable').DataTable({
            'processing': true,
            'serverSide': true,
            'stateSave': true,
            'order': [],
            'ajax': {
                'url': "<?php echo site_url('customers/load_list')?>",
                'type': 'POST'
            },
            'columnDefs': [
                {
                    'targets': [0],
                    'orderable': false,
                },
            ],
			
        });
    });
    function filtrar(){
        var morosos=$("#deudores option:selected").val();
        if(morosos=="Si"){
            tb.ajax.url( baseurl+'customers/load_morosos').load();
        }else{
            tb.ajax.url( baseurl+'customers/load_list').load();
        }
        
    }
</script>
<div id="delete_model" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Delete Customer</h4>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete this customer?</p>
            </div>
            <div class="modal-footer">
                <input type="hidden" id="object-id" value="">
                <input type="hidden" id="action-url" value="customers/delete_i">
                <button type="button" data-dismiss="modal" class="btn btn-primary" id="delete-confirm">Delete</button>
                <button type="button" data-dismiss="modal" class="btn">Cancel</button>
            </div>
        </div>
    </div>
</div>