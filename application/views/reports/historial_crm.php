<article class="content">
    <div class="card card-block">
        <div id="notify" class="alert alert-success" style="display:none;">
            <a href="#" class="close" data-dismiss="alert">&times;</a>

            <div class="message"></div>
        </div>
        <h4>Historial</h4>
        <hr>
        <div class="grid_3 grid_4">
            <table id="tabla-historial" class="table-striped" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Fecha</th>
                        <th>Modulo</th>
                        <th>Accion</th>
                        <th>Descripcion</th>
                        <th>Usuario</th>
                        <th>Opciones</th>

                    </tr>
                </thead>
                <tbody>
                    
                </tbody>
                <tfoot>
                    <tr>
                        <th>ID</th>
                        <th>Fecha</th>
                        <th>Modulo</th>
                        <th>Accion</th>
                        <th>Descripcion</th>
                        <th>Usuario</th>
                        <th>Opciones</th>
                    </tr>
                </tfoot>
            </table>
        </div>
        </div>
</article>

<script type="text/javascript">
    var tb;
    $(document).ready(function(){
        tb=$('#tabla-historial').DataTable({

            "processing": true, //Feature control the processing indicator.
            "serverSide": true, //Feature control DataTables' server-side processing mode.
            "order": [], //Initial no order.

            // Load data for the table's content from an Ajax source
            "ajax": {
                "url": "<?php echo site_url('reports/historial_list')?>",
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
        $(".ver-mas").on("click",function(){
            console.log("asdasd");
        });
    });
</script>