<style>
.st-paid, .st-partial,.st-canceled,.st-rejected,.st-pending,.st-accepted,.st-Activo,.st-Stopped,.st-end, .st-Cortado, .st-Instalar, .st-Suspendido, .st-Exonerado
{
text-transform: lowercase;
    color:#000000;
    padding: 4px;
    border-radius: 11px;
    font-size: 10px;
}

.st-paid,.st-accepted
{
 background-color: #5ed45e;
}
.st-pending,.st-Activo
{
 background-color:#D4BF30;
}
.st-canceled,.st-rejected,.st-end
{
 background-color: #F00;
}
.st-Cortado
{
 background-color: #C33;
}
.st-Instalar, .st-partial
{
 background-color:#E2ED30;
}
.st-Suspendido
{
 background-color: #C09;
}
.st-Exonerado
{
 background-color: #33F;
}
</style>

<article class="content">
    <div class="card card-block">
        <div id="notify" class="alert alert-success" style="display:none;">
            <a href="#" class="close" data-dismiss="alert">&times;</a>

            <div class="message"></div>
        </div>
        <div class="grid_3 grid_4 animated fadeInRight table-responsive">
            <h5><?php echo $this->lang->line('Invoices') ?></h5>

            <hr>
            
            <table id="invoices" class="table-striped" cellspacing="0" width="100%">
                <thead>
                <tr>
                    <th width="1%"><?php echo $this->lang->line('No') ?></th>
                    <th>F/ra #</th>
                    <th><?php echo $this->lang->line('Customer') ?></th>
					<th>Abonado</th>
                    <th>Vence</th>
                    <th><?php echo $this->lang->line('') ?>Estado</th>
                    <th><?php echo $this->lang->line('Total') ?></th>
					<th>sede</th>
                    <th class="no-sort"><?php echo $this->lang->line('') ?>Pago</th>
                    <th class="no-sort"><?php echo $this->lang->line('Settings') ?></th>
					<?php if ($this->aauth->get_user()->roleid > 4) { ?>
					<th><?php echo $this->lang->line('') ?>Eliminar</th>
					<?php } ?>

                </tr>
                </thead>
                <tbody>
                </tbody>

                <tfoot>
                <tr>
                    <th width="1%"><?php echo $this->lang->line('No') ?></th>
                    <th>F/ra #</th>
                    <th><?php echo $this->lang->line('Customer') ?></th>
					<th>Abonado</th>
                    <th>Vence</th>
                    <th><?php echo $this->lang->line('') ?>Estado</th>
                    <th><?php echo $this->lang->line('Total') ?></th>
					<th>sede</th>
                    <th class="no-sort"><?php echo $this->lang->line('') ?>Pago</th>
                    <th class="no-sort"><?php echo $this->lang->line('Settings') ?></th>
					<?php if ($this->aauth->get_user()->roleid > 3) { ?>
					<th><?php echo $this->lang->line('') ?>Eliminar</th>
					<?php } ?>
                </tr>
                
                </tfoot>
            </table>
        </div>
    </div>


</article>
<div id="delete_model" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><?php echo $this->lang->line('Delete Invoice') ?></h4>
            </div>
            <div class="modal-body">
                <p><?php echo $this->lang->line('delete this invoice') ?> ?</p>
            </div>
            <div class="modal-footer">
                <input type="hidden" id="object-id" value="">
                <input type="hidden" id="action-url" value="invoices/delete_i">
                <button type="button" data-dismiss="modal" class="btn btn-primary"
                        id="delete-confirm"><?php echo $this->lang->line('Delete') ?></button>
                <button type="button" data-dismiss="modal"
                        class="btn"><?php echo $this->lang->line('Cancel') ?></button>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function () {
       $('#invoices').DataTable({
            'processing': true,
            'serverSide': true,
            'stateSave': true,
            'order': [],
            'ajax': {
                'url': "<?php echo site_url('invoices/ajax_list')?>",
                'type': 'POST'
            },
            'columnDefs': [
                {
                    'targets': [0],
                    'orderable': false,
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
    });
</script>