<article class="content">
    <div class="card card-block">
        <div id="notify" class="alert alert-success" style="display:none;">
            <a href="#" class="close" data-dismiss="alert">&times;</a>

            <div class="message"></div>
        </div>
        <div class="grid_3 grid_4 animated fadeInRight table-responsive">
            <h5><?php echo $this->lang->line('Stock Return') ?></h5>

            <hr>
            <table id="invoices" class="table-striped" cellspacing="0" width="100%">
                <thead>
                <tr> <th><?php echo $this->lang->line('No') ?></th>
                <th>Order #</th>
                <th><?php echo $this->lang->line('Supplier') ?></th>
                <th><?php echo $this->lang->line('Date') ?></th>
                <th><?php echo $this->lang->line('Amount') ?></th>
                <th><?php echo $this->lang->line('Status') ?></th>
                <th class="no-sort"><?php echo $this->lang->line('Settings') ?></th>
                </tr>
                </thead>
                <tbody>
                </tbody>

                <tfoot>
                <tr> <th><?php echo $this->lang->line('No') ?></th>
                    <th>Order #</th>
                    <th><?php echo $this->lang->line('Supplier') ?></th>
                    <th><?php echo $this->lang->line('Date') ?></th>
                    <th><?php echo $this->lang->line('Amount') ?></th>
                    <th><?php echo $this->lang->line('Status') ?></th>
                    <th class="no-sort"><?php echo $this->lang->line('Settings') ?></th>
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
                <h4 class="modal-title"><?php echo $this->lang->line('Delete Order') ?></h4>
            </div>
            <div class="modal-body">
                <p><?php echo $this->lang->line('delete this order') ?></p>
            </div>
            <div class="modal-footer">
                <input type="hidden" id="object-id" value="">
                <input type="hidden" id="action-url" value="stockreturn/delete_i">
                <button type="button" data-dismiss="modal" class="btn btn-primary" id="delete-confirm">Delete</button>
                <button type="button" data-dismiss="modal" class="btn">Cancel</button>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function () {

        var table = $('#invoices').DataTable({
            "processing": true,
            "serverSide": true,
            "order": [],
            "ajax": {
                "url": "<?php echo site_url('stockreturn/ajax_list')?>",
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