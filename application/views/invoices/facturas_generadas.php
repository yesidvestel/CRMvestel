<article class="content">
    <div class="card card-block">
        <div id="notify" class="alert alert-success" style="display:none;">
            <a href="#" class="close" data-dismiss="alert">&times;</a>

            <div class="message"></div>
        </div>
        <div class="grid_3 grid_4">
            <h6><?php echo $this->lang->line('') ?>Facturas Generadas</h6>
             <hr>
            <div class="table-responsive">
                <table id="clientstable" class="table-striped" cellspacing="0" width="100%">
                    <thead>
                    <tr>
                       
                        <th><?php echo $this->lang->line('Name') ?></th>
                        <th>Celular</th>
                        <th>Cedula</th>
                        
                        <th><?php echo $this->lang->line('Settings') ?></th>


                    </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($customers_afectados as $key => $cs) { ?>
                        <tr role="row" class="even"><td><a href="<?=base_url()?>customers/view?id=<?=$cs['csd']?>"><?=$cs['nombres']?></a></td><td><?=$cs['celular']?></td><td><?=$cs['cedula']?></td><td><a href="<?=base_url()?>customers/invoices?id=<?=$cs['csd']?>" class="btn btn-info btn-sm"><span class="icon-eye"></span>  Facturas</a> <a href="<?=base_url()?>invoices/view?id=<?=$cs['tid']?>" class="btn btn-info btn-sm"><span class="icon-eye"></span>  Factura Creada</a></td></tr>
                        <?php } ?>
                    </tbody>

                    <tfoot>
                    <tr>
                       
                        
                        <th><?php echo $this->lang->line('Name') ?></th>
                        <th>Celular</th>
                        <th>Cedula</th>
                       
                        <th><?php echo $this->lang->line('Settings') ?></th>


                    </tr>
                    </tfoot>
                </table>
            </div>

        </div>
    </div>
</article>
<!--<script type="text/javascript">
    $(document).ready(function () {
        $('#clientstable').DataTable({
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
</script>-->

