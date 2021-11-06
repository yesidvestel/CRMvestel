<article class="content">
    <div class="card card-block">
        <div id="notify" class="alert alert-success" style="display:none;">
            <a href="#" class="close" data-dismiss="alert">&times;</a>

            <div class="message"></div>
        </div>
        <div class="grid_3 grid_4">
            <h5 class="title">
               Administrar Moviles
            </h5>
            <table id="movtable" class="display" cellspacing="0" width="100%">
                <thead>
                <tr>
                    <th>#</th>
                    <th>id movil</th>
                    <th><?php echo $this->lang->line('Name') ?></th>
                    <th>Usuario Creador</th>
                    <th>Fecha Creacion</th>
					<th>Ultima Edicion</th>
                    <th>Estado</th>
                    <th>Acciones</th>
					

                </tr>
                </thead>
                <tbody>
                
                </tbody>
                <tfoot>
                <tr>
                    <th>#</th>
                    <th>id movil</th>
                    <th><?php echo $this->lang->line('Name') ?></th>
                    <th>Usuario Creador</th>
                    <th>Fecha Creacion</th>
                    <th>Ultima Edicion</th>
                    <th>Estado</th>
                    <th>Acciones</th>
					
                </tr>
                </tfoot>
            </table>
        </div>
    </div>
</article>
<script type="text/javascript">
    var tb;
    $(document).ready(function () {

        //datatables
        tb=$('#movtable').DataTable({

            "processing": true, //Feature control the processing indicator.
            "serverSide": true, //Feature control DataTables' server-side processing mode.
            "order": [], //Initial no order.

            // Load data for the table's content from an Ajax source
            "ajax": {
                "url": "<?php echo site_url('moviles/cargar_movtable'); ?>",
                "type": "POST"
            },

            //Set column definition initialisation properties.
            "columnDefs": [
                {
                    "targets": [0], //first column / numbering column
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

    $("#movtable").on('draw.dt',function (){
      $('.cl_desactivar').click(function (e) {
            e.preventDefault();//para prevenir el redireccionamiento y realizar la accion que es agregar a la otra tabla
            var id_movil=$(this).data("id-movil");    
            $.post(baseurl+"moviles/desactivar_activar_movil",{'id_movil':id_movil},function(){
                tb.ajax.url(baseurl+"moviles/cargar_movtable").load();
            });                           
      });
       $('.cl_editar').click(function (e) {
            e.preventDefault();//para prevenir el redireccionamiento y realizar la accion que es agregar a la otra tabla
            var id_movil=$(this).data("id-movil"); 
            window.location.href =baseurl+"moviles/create?id="+id_movil;
            
            
      });
});


    });

   
</script>




