<div class="app-content content container-fluid">
    <div class="content-wrapper">
        <div class="content-header row">
        </div>
        <div class="content-body">
            <?php if ($this->session->flashdata("messagePr")) { ?>
                <div class="alert alert-info">
                    <?php echo $this->session->flashdata("messagePr") ?>
                </div>
            <?php } ?>
            <div class="card card-block">
                <div class="box-header with-border">
                    <h3 class="box-title"><?php echo $this->lang->line('Payments') ?></h3>
                    <p><br></p>
                    <div class="table-responsive">
                    <table cellspacing="0" width="100%" id="invoices" class="cell-border example1 table table-striped table1 delSelTable table-hover">
                        <thead>
                        <tr>
                            <th><?php echo $this->lang->line('Date') ?></th>
                            <th>Monto</th>
                            <th>Metodo Pago </th>
                             <th>Estado</th>
                             <th>Link</th>
                            <th>Data</th>
                            


                        </tr>
                        </thead>
                        <tbody>
                        </tbody>

                        <tfoot>
                        <tr>
                             <th><?php echo $this->lang->line('Date') ?></th>
                            <th>Monto</th>
                            <th>Metodo Pago </th>
                             <th>Estado</th>
                             <th>Link</th>
                            <th>Data</th>


                        </tr>
                        </tfoot>
                    </table>
                    </div>
                </div>
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
                "url": "<?php echo site_url('payments/ajax_list')?>",
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
