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
                    <h3 class="box-title"><?php echo $this->lang->line('Invoices') ?></h3>
            <div class="card card-block">
                
                
                
                <div class="row m-t-lg">
                    <div class="col-md-1">
                    <strong>TOTAL</strong>
                    </div>
                    <div class="col-md-10" id="total_text">
                    
                    <?php 
                            setlocale(LC_MONETARY,"es_CO");
                            echo money_format("%.0n", ($due->total-$due->pamnt));
                    ?>
                    </div>
                </div>
            </div>
                    
                    <table id="invoices" class="cell-border example1 table table-striped table1 delSelTable">
                        <thead>
                        <tr>

                            <th><?php echo $this->lang->line('No') ?></th>
                            <th>#</th>
                            <th><?php echo $this->lang->line('customer') ?></th>
                            <th><?php echo $this->lang->line('Date') ?></th>
                            <th><?php echo $this->lang->line('Amount') ?></th>
                            <th  class="no-sort"><?php echo $this->lang->line('Status') ?></th>
                            <th class="no-sort"><?php echo $this->lang->line('Settings') ?></th>

                        </tr>
                        </thead>
                        <tbody>
                        </tbody>

                        <tfoot>
                        <tr>
                            <th><?php echo $this->lang->line('No') ?></th>
                            <th>#</th>
                            <th><?php echo $this->lang->line('customer') ?></th>
                            <th><?php echo $this->lang->line('Date') ?></th>
                            <th><?php echo $this->lang->line('Amount') ?></th>
                            <th  class="no-sort"><?php echo $this->lang->line('Status') ?></th>
                            <th class="no-sort"><?php echo $this->lang->line('Settings') ?></th>
                        </tr>
                        </tfoot>
                    </table>
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
                "url": "<?php echo site_url('invoices/ajax_list')?>",
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
