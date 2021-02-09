<article class="content content items-list-page">
    <div class="card card-block">
        <div id="notify" class="alert alert-success" style="display:none;">
            <a href="#" class="close" data-dismiss="alert">&times;</a>

            <div class="message"></div>
        </div>
        <div class="grid_3 grid_4 table-responsive animated fadeInRight">
            <h5><?php echo $this->lang->line('Supplier') ?></h5>

            <hr>
            <table id="clientstable" class="table-striped" cellspacing="0" width="100%">
                <thead>
                <tr>
                    <th>#</th>
                    <th><?php echo $this->lang->line('Name') ?></th>
                    <th><?php echo $this->lang->line('Address') ?></th>
                    <th><?php echo $this->lang->line('Email') ?></th>
                    <th><?php echo $this->lang->line('Phone') ?></th>
                    <th><?php echo $this->lang->line('Settings') ?></th>


                </tr>
                </thead>
                <tbody>
                </tbody>

                <tfoot>
                <tr>
                    <th>#</th>
                    <th><?php echo $this->lang->line('Name') ?></th>
                    <th><?php echo $this->lang->line('Address') ?></th>
                    <th><?php echo $this->lang->line('Email') ?></th>
                    <th><?php echo $this->lang->line('Phone') ?></th>
                    <th><?php echo $this->lang->line('Settings') ?></th>


                </tr>
                </tfoot>
            </table>
        </div>
    </div>
</article>

<script type="text/javascript">
    $(document).ready(function () {
        $('#clientstable').DataTable({
            'processing': true,
            'serverSide': true,
            'stateSave': true,
            'order': [],
            'ajax': {
                'url': "<?php echo site_url('supplier/load_list')?>",
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
                <p><?php echo $this->lang->line('delete this supplier') ?></p>
            </div>
            <div class="modal-footer">
                <input type="hidden" id="object-id" value="">
                <input type="hidden" id="action-url" value="supplier/delete_i">
                <button type="button" data-dismiss="modal" class="btn btn-primary"
                        id="delete-confirm"><?php echo $this->lang->line('Delete') ?></button>
                <button type="button" data-dismiss="modal"
                        class="btn"><?php echo $this->lang->line('Cancel') ?></button>
            </div>
        </div>
    </div>
</div>