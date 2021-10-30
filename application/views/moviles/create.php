<article class="content">
    <div class="card card-block">
        <div id="notify" class="alert alert-success" style="display:none;">
            <a href="#" class="close" data-dismiss="alert">&times;</a>

            <div class="message"></div>
        </div>

        <div class="grid_3 grid_4">
           
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label"
                                       for="pay_cat">Nombre Movil</label>

                                <div class="col-sm-6">                                    
                                        <input placeholder="Nombre de la Movil" type="text" name="nombre" class="form-control" >
                                </div>
                </div>
                
                <hr>
            
            <h5 align="center">Empleados para asignar a la movil</h5>
            <table id="emptable" class="display" cellspacing="0" width="100%">
                <thead>
                <tr>
                    <th>#</th>
                    <th><?php echo $this->lang->line('Name') ?></th>
                    <th>Role</th>
                    <th><?php echo $this->lang->line('Status') ?></th>
                    <th>Hora ingreso</th>
                    <th>Agregar</th>
                    

                </tr>
                </thead>
                <tbody>
               
                </tbody>
                <tfoot>
                <tr>
                    <th>#</th>
                    <th><?php echo $this->lang->line('Name') ?></th>
                    <th>Role</th>
                    <th><?php echo $this->lang->line('Status') ?></th>
                    <th>Hora ingreso</th>
                    <th>Agregar</th>
                    
                </tr>
                </tfoot>
            </table>
            <hr>
            <hr>
            <h5 align="center">Empleados asignados a la movil</h5>
            <table id="emptable2" class="display" cellspacing="0" width="100%">
                <thead>
                <tr>
                    <th>#</th>
                    <th><?php echo $this->lang->line('Name') ?></th>
                    <th>Role</th>
                    <th><?php echo $this->lang->line('Status') ?></th>
                    <th>Hora ingreso</th>
                    <th>Quitar</th>
                    

                </tr>
                </thead>
                <tbody>
               
                </tbody>
                <tfoot>
                <tr>
                    <th>#</th>
                    <th><?php echo $this->lang->line('Name') ?></th>
                    <th>Role</th>
                    <th><?php echo $this->lang->line('Status') ?></th>
                    <th>Hora ingreso</th>
                    <th>Quitar</th>
                    
                </tr>
                </tfoot>
            </table>
            <hr>
            <div align="right">
                <input type="button" class="btn btn-primary" name="" value="Guardar Movil">
            </div>
            
        </div>
    </div>
</article>
<script type="text/javascript">
    var tb;
    $(document).ready(function () {

        //datatables
        tb=$('#emptable').DataTable({

            "processing": true, //Feature control the processing indicator.
            "serverSide": true, //Feature control DataTables' server-side processing mode.
            "order": [], //Initial no order.

            // Load data for the table's content from an Ajax source
            "ajax": {
                "url": "<?php echo site_url('moviles/cargar_emptable'); ?>",
                "type": "POST"
            },

            //Set column definition initialisation properties.
            "columnDefs": [
                {
                    "targets": [0], //first column / numbering column
                    "orderable": false, //set not orderable
                },
                
            ],  
            "language":{
                    "processing": "Procesando...",
                    "lengthMenu": "Mostrar _MENU_ registros",
                    "zeroRecords": "No se encontraron resultados",
                    "emptyTable": "Ningún dato disponible en esta tabla",
                    "infoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
                    "infoFiltered": "(filtrado de un total de _MAX_ registros)",
                    "search": "Buscar:",
                    "infoThousands": ",",
                    "loadingRecords": "Cargando...",
                    "paginate": {
                        "first": "Primero",
                        "last": "Último",
                        "next": "Siguiente",
                        "previous": "Anterior"
                    },
                     "info": "Mostrando de _START_ a _END_ de _TOTAL_ entradas"

                }
            

        });
        
         $('#emptable2').DataTable({});


    });

    $('.delemp').click(function (e) {
        e.preventDefault();
        $('#empid').val($(this).attr('data-object-id'));

    });
</script>


<div id="delete_model" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Deactive Employee</h4>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to deactive this account ? <br><strong> It will disable this account access to
                        user.</strong></p>
            </div>
            <div class="modal-footer">
                <input type="hidden" id="object-id" value="">
                <input type="hidden" id="action-url" value="employee/disable_user">
                <button type="button" data-dismiss="modal" class="btn btn-primary" id="delete-confirm">Deactive</button>
                <button type="button" data-dismiss="modal" class="btn">Cancel</button>
            </div>
        </div>
    </div>
</div>

<div id="pop_model" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"><?php echo $this->lang->line('Delete'); ?></h4>
            </div>

            <div class="modal-body">
                <form id="form_model">


                    <div class="modal-body">
                        <p>Are you sure you want to delete this employee? <br><strong> It may interrupt old invoices,
                                disable account is a better option.</strong></p>
                    </div>
                    <div class="modal-footer">


                        <input type="hidden" class="form-control required"
                               name="empid" id="empid" value="">
                        <button type="button" class="btn btn-default"
                                data-dismiss="modal"><?php echo $this->lang->line('Close'); ?></button>
                        <input type="hidden" id="action-url" value="employee/delete_user">
                        <button type="button" class="btn btn-primary"
                                id="submit_model"><?php echo $this->lang->line('Delete'); ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>