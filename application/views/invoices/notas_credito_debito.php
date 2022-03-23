<article class="content">
    <div class="card card-block">
        <div id="notify" class="alert alert-success" style="display:none;">
            <a href="#" class="close" data-dismiss="alert">&times;</a>

            <div class="message"></div>
        </div>
        <h4>Notas Credito/Debito</h4>
        <hr>
        <div class="grid_3 grid_4">
            <table id="tabla-notas" class="table-striped table-hover" cellspacing="0" width="100%">
                <thead>
                    <tr>
                     
                        
                        <th>ID</th>
                        <th>TID</th>
                        <th>Fecha Fac</th>
                        <th>Fecha Creada</th>
                        <th>Cliente</th>
                        <th>Valor</th>
                        <th>Tipo</th>
                        <th>Usuario</th>
                        <th>Acciones</th>
                        

                    </tr>
                </thead>
                <tbody>
                    
                </tbody>
                <tfoot>
                    <tr>
                        

                        <th>ID</th>
                        <th>TID</th>
                        <th>Fecha Fac</th>
                        <th>Fecha Creada</th>
                        <th>Cliente</th>
                        <th>Valor</th>
                        <th>Tipo</th>
                        <th>Usuario</th>
                        <th>Acciones</th>
                    </tr>
                </tfoot>
            </table>
        </div>
        </div>
</article>
<div id="pop_model" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Información Adicional</h4>
            </div>

            <div class="modal-body">
                <div id="parrafo">
                    
                </div>
                <div id="tabla" class="table-responsive" align="center" >
                    <table class="table mb-1 table-hover" style="display: inline;text-align: center;">
                        <thead style="background-color:#3BAFDA">
                            <tr>
                                <th style="text-align:center;">Atributo</th>
                                <th style="text-align:center;">Contenido</th>
                            </tr>
                        </thead>
                        <tbody id="tbody1">
                            
                        </tbody>
                        <tfoot style="background-color:#3BAFDA">
                            <tr>
                                <th style="text-align:center;">Atributo</th>
                                <th style="text-align:center;">Contenido</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                 <button type="button" class="btn btn-primary"
                        data-dismiss="modal">Aceptar </button>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    var tb;
    $(document).ready(function(){
        tb=$('#tabla-notas').DataTable({

            "processing": true, //Feature control the processing indicator.
            "serverSide": true, //Feature control DataTables' server-side processing mode.
            "order": [], //Initial no order.

            // Load data for the table's content from an Ajax source
            "ajax": {
                "url": "<?php echo site_url('invoices/notas_list')?>",
                "type": "POST"
            },

            //Set column definition initialisation properties.
            "columnDefs": [
                {
                    //"targets": [0], //first column / numbering column
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

    });

    $(document).on("click",".eliminar_nota",function(e){
        e.preventDefault();
        var id_nota=$(this).data("id");
        var p=confirm("¿Desea eliminar la nota?");
        if(p){
                $.post(baseurl+"invoices/eliminar_nota",{id_nota:id_nota},function(data){
                    if(data=="Realizado"){
                        location.reload();
                    }
                });    
        }
    });
</script>