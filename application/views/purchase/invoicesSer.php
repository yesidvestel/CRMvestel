<style>
.st-finalizado, .st-pendiente , .st-cancelado,.st-abonado, .st-recibido, .st-anulado, .st-aprobado
{
text-transform: capitalize;
    color: #fff;
    padding: 4px;
    border-radius: 11px;
    font-size: 10px;
}
.st-finalizado
{
 background-color: #3C3;
}
.st-pendiente
{
 background-color: #FC3;
}
.st-cancelado
{
 background-color: #F33;
}
.st-abonado
{
 background-color: #ccac00;
}
.st-recibido
{
 background-color: #36F;
}
.st-aprobado
{
 background-color: #A01DB7;
}
.st-anulado
{
 background-color: #000;
}
</style>
<article class="content">
    <div class="card card-block">
        <div id="notify" class="alert alert-success" style="display:none;">
            <a href="#" class="close" data-dismiss="alert">&times;</a>

            <div class="message"></div>
        </div>
        <div class="grid_3 grid_4 animated fadeInRight table-responsive">
            <h5>Purchase Orders</h5>

            <hr>
            <table id="invoices" class="table-striped" cellspacing="0" width="100%">
                <thead>
                <tr> <th><?php echo $this->lang->line('No') ?></th>
                    <th>Order #</th>
                    <th><?php echo $this->lang->line('Supplier') ?></th>
                    <th><?php echo $this->lang->line('Date') ?></th>
					<th>Detalle</th>
                    <th><?php echo $this->lang->line('Amount') ?></th>
                    <th>Sede</th>
                    <th><?php echo $this->lang->line('Status') ?></th>
                    <th class="no-sort"><?php echo $this->lang->line('Settings') ?></th>
					<?php if ($this->aauth->get_user()->roleid > 4) { ?>
					<th>Eliminar</th>
					<?php } ?>
                </tr>
                </thead>
                <tbody>
                </tbody>

                <tfoot>
                <tr> <th><?php echo $this->lang->line('No') ?></th>
                    <th>Order #</th>
                    <th><?php echo $this->lang->line('Supplier') ?></th>
                    <th><?php echo $this->lang->line('Date') ?></th>
					<th>Detalle</th>
                    <th><?php echo $this->lang->line('Amount') ?></th>
                    <th>Sede</th>
                    <th><?php echo $this->lang->line('Status') ?></th>
                    <th class="no-sort"><?php echo $this->lang->line('Settings') ?></th>
					<?php if ($this->aauth->get_user()->roleid > 4) { ?>
					<th>Eliminar</th>
					<?php } ?>
                </tr>
                </tfoot>
            </table>
        </div>
    </div>


</article>
<div id="delete_model" class="modal fade">
    <div class="modal-dialog">
	 <?php if ($this->aauth->get_user()->roleid > 4) { ?>
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><?php echo $this->lang->line('Delete Order') ?></h4>
            </div>
            <div class="modal-body">
                <p><?php echo $this->lang->line('delete this order') ?></p>
            </div>
            <div class="modal-footer">
                <input type="hidden" id="object-id" value="">
                <input type="hidden" id="action-url" value="purchase/delete_i">
                <button type="button" data-dismiss="modal" class="btn btn-primary" id="delete-confirm">Delete</button>
                <button type="button" data-dismiss="modal" class="btn">Cancel</button>
            </div>
        </div>
		<?php } ?>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function () {

        var table = $('#invoices').DataTable({
            "processing": true,
            "serverSide": true,
            "order": [],
            "ajax": {
                "url": "<?php echo site_url('purchase/ajax_list?type=servicio')?>",
                "type": "POST"
            },
            "columnDefs": [
                {
                    "targets": [0],
                    "orderable": false,
                },
            ],

        });

    });
</script>