<article class="content">
    <div class="card card-block">
        <div id="notify" class="alert alert-success" style="display:none;">
            <a href="#" class="close" data-dismiss="alert">&times;</a>

            <div class="message"></div>
        </div>
        <div class="grid_3 grid_4">
            <h6><?php echo $this->lang->line('') ?>Facturas Generadas <?= $fecha?></h6>
             <hr>
            

            <div class="table-responsive">
                <table id="clientstable" class="table-striped" cellspacing="0" width="100%">
                    <thead>
                    <tr>
                       <th>#</th>
                        <th><?php echo $this->lang->line('Name') ?></th>
                        <th>Celular</th>
                        <th>Cedula</th>
                        
                        <th><?php echo $this->lang->line('Settings') ?></th>


                    </tr>
                    </thead>
                    <tbody>
                      
                    </tbody>

                    <tfoot>
                    <tr>
                       
                        <th>#</th>
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
<article class="content">
    <div class="card card-block">
        <div id="notify" class="alert alert-success" style="display:none;">
            <a href="#" class="close" data-dismiss="alert">&times;</a>

            <div class="message"></div>
        </div>
        <div class="grid_3 grid_4">
            <h6><?php echo $this->lang->line('') ?>Facturas no Generadas <?= $fecha?></h6>
             <hr>
            

            <div class="table-responsive">
                <table id="clientstable2" class="table-striped" cellspacing="0" width="100%">
                    <thead>
                    <tr>
                       <th>#</th>
                        <th><?php echo $this->lang->line('Name') ?></th>
                        <th>Celular</th>
                        <th>Cedula</th>
                        
                        <th><?php echo $this->lang->line('Settings') ?></th>


                    </tr>
                    </thead>
                    <tbody>
                      
                    </tbody>

                    <tfoot>
                    <tr>
                       
                        <th>#</th>
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


<script type="text/javascript">
    $(document).ready(function () {
        $('#clientstable').DataTable({
            'processing': true,
            'serverSide': true,
            'stateSave': true,
            'order': [],
            'ajax': {
                'url': "<?php echo site_url('facturasElectronicas/lista_facturas_generadas?fecha='.$fecha.'&pay_acc='.$pay_acc)?>",
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

    $(document).ready(function () {
        $('#clientstable2').DataTable({
            'processing': true,
            'serverSide': true,
            'stateSave': true,
            'order': [],
            'ajax': {
                'url': "<?php echo site_url('facturasElectronicas/lista_facturas_no_generadas?fecha='.$fecha.'&pay_acc='.$pay_acc)?>",
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

    function eliminar_factura_electronica(id){
        console.log(id);
        $.post(baseurl+"facturasElectronicas/delete_factura_electronica_local",{'id':id},function(data){
                   var nombre= $("#id_"+id).data("nombre");
                    $("#notify .message").html("<strong>Success</strong>: Factura Electronica de <i>"+nombre+"</i> eliminada del registro local");
                    $("#notify").removeClass("alert-danger").addClass("alert-success").fadeIn();
                    $("html, body").scrollTop($("body").offset().top);
            $("#id_"+id).parent().parent().css("background","red");
        });
    }
</script>

