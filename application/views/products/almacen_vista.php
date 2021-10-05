<article class="content">
    <div class="card card-block">
        <div id="notify" class="alert alert-success" style="display:none;">
            <a href="#" class="close" data-dismiss="alert">&times;</a>

            <div class="message"></div>
        </div>
        <div class="grid_3 grid_4 table-responsive animated fadeInRight">
            <h5><?php echo $this->lang->line('Products') ?></h5>

            <hr>
            <table id="equipostable" class="display" cellspacing="0" width="100%">
                <thead>
                <tr>
                    <th>#</th>
					<th>Codigo</th>
                    <th>MAC</th>
                    <th>Serial</th>
                    <th>Estado</th>
                    <th>Asignado a:</th>
					<th>Marca</th>
					<th>T/po sistema</th>
					<th>Vlan</th>
					<th>Nat</th>
					<th>P/to Nat</th>
                    <th><?php echo $this->lang->line('Settings') ?></th>


                </tr>
                </thead>
                <tbody>
                </tbody>

                <tfoot>
                <tr>
                    <th>#</th>
					<th>Codigo</th>
                    <th>MAC</th>
                    <th>Serial</th>
                    <th>Estado</th>
                    <th>Asignado a:</th>
					<th>Marca</th>
					<th>T/po sistema</th>
					<th>Vlan</th>
					<th>Nat</th>
					<th>P/to Nat</th>
                    <th><?php echo $this->lang->line('Settings') ?></th>

                </tr>
                </tfoot>
            </table>
        </div>
    </div>
</article>
<script type="text/javascript">

    var table;

    $(document).ready(function () {

        //datatables
        table = $('#equipostable').DataTable({

            "processing": true, //Feature control the processing indicator.
            "serverSide": true, //Feature control DataTables' server-side processing mode.
            "order": [], //Initial no order.

            // Load data for the table's content from an Ajax source
            "ajax": {
                "url": "<?php echo site_url('products/equipos_list') . '?id=' . $_GET['id']; ?>",
                "type": "POST"
            },

            //Set column definition initialisation properties.
            "columnDefs": [
                {
                    "targets": [0], //first column / numbering column
                    "orderable": false, //set not orderable
                },
            ],
			"order": [[ 2, "desc" ]],
                "language": {
                    "info": "Pagina _PAGE_ de _PAGES_",
                    "zeroRecords": "No se encontraron resultados",
                    "processing": "Procesando...",
                    "lengthMenu": "Mostrar _MENU_ registros",
                    "search": "Buscar:",
                    "paginate": {
                        "first": "Primero",
                        "last": "Último",
                        "next": "Siguiente",
                        "previous": "Anterior"
                    },
                }

        });

    });
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
                <input type="hidden" id="action-url" value="products/delete_e">
                <button type="button" data-dismiss="modal" class="btn btn-primary"
                        id="delete-confirm"><?php echo $this->lang->line('Delete') ?></button>
                <button type="button" data-dismiss="modal"
                        class="btn"><?php echo $this->lang->line('Cancel') ?></button>
            </div>
            </div>
        </div>
    </div>
</div>