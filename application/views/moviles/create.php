<article class="content">
    <div class="card card-block">
        <div id="notify" class="alert alert-success" style="display:none;">
            <a href="#" class="close" data-dismiss="alert">&times;</a>

            <div class="message"></div>
        </div>
<form id="formulario_movil" method="post" action="#" >
        <div class="grid_3 grid_4" id="div_remover">
           
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label"
                                       for="pay_cat">Nombre Movil</label>

                                <div class="col-sm-6">                                    
                                        <input placeholder="Nombre de la Movil" type="text" name="nombre" id="nombre" class="form-control" value="<?=$movil_temporal_user->nombre  ?>">
                                </div>
                </div>
                
                <hr>
            
            <h5 align="center">Colaboradores para asignar a la movil</h5>
            <table id="emptable" class="display" cellspacing="0" width="100%">
                <thead>
                <tr>
                    <th>#</th>
                    <th><?php echo $this->lang->line('Name') ?></th>
                    <th>Role</th>
                    <th><?php echo $this->lang->line('Status') ?></th>
                    <th>Hora ingreso</th>
                    <th>Agregar</th>
                    

                </tr>
                </thead>
                <tbody>
               
                </tbody>
                <tfoot>
                <tr>
                    <th>#</th>
                    <th><?php echo $this->lang->line('Name') ?></th>
                    <th>Role</th>
                    <th><?php echo $this->lang->line('Status') ?></th>
                    <th>Hora ingreso</th>
                    <th>Agregar</th>
                    
                </tr>
                </tfoot>
            </table>
            <hr>
            <hr>
            <h5 align="center">Colaboradores asignados a la movil</h5>
            <table id="emptable2" class="display" cellspacing="0" width="100%">
                <thead>
                <tr>
                    <th>#</th>
                    <th><?php echo $this->lang->line('Name') ?></th>
                    <th>Role</th>
                    <th><?php echo $this->lang->line('Status') ?></th>
                    <th>Hora ingreso</th>
                    <th>Quitar</th>
                    

                </tr>
                </thead>
                <tbody>
               
                </tbody>
                <tfoot>
                <tr>
                    <th>#</th>
                    <th><?php echo $this->lang->line('Name') ?></th>
                    <th>Role</th>
                    <th><?php echo $this->lang->line('Status') ?></th>
                    <th>Hora ingreso</th>
                    <th>Quitar</th>
                    
                </tr>
                </tfoot>
            </table>
            <hr>
            <div align="right">
                <input type="submit" class="btn btn-primary" name="" value="Guardar Movil" >
            </div>
            
        </div>
   </form>    
    </div>
</article>
<script type="text/javascript">
    var tb;
    var tb2;
    var id_movil_temporal="<?=$movil_temporal_user->id_movil ?>";
    $(document).ready(function () {

        //datatables
        tb=$('#emptable').DataTable({

            "processing": true, //Feature control the processing indicator.
            "serverSide": true, //Feature control DataTables' server-side processing mode.
            "order": [], //Initial no order.

            // Load data for the table's content from an Ajax source
            "ajax": {
                "url": "<?php echo site_url('moviles/cargar_emptable')."?tb=1&id_m_temporal=".$movil_temporal_user->id_movil; ?>",
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
        
          tb2=$('#emptable2').DataTable({

            "processing": true, //Feature control the processing indicator.
            "serverSide": true, //Feature control DataTables' server-side processing mode.
            "order": [], //Initial no order.

            // Load data for the table's content from an Ajax source
            "ajax": {
                "url": "<?php echo site_url('moviles/cargar_emptable')."?tb=2&id_m_temporal=".$movil_temporal_user->id_movil; ?>",
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

            

    });//end ready
    
$("#emptable").on('draw.dt',function (){
      $('.cl_agregar').click(function (e) {
            e.preventDefault();//para prevenir el redireccionamiento y realizar la accion que es agregar a la otra tabla
            var id_empleado_asignar=$(this).data("id-empleado");    
            $.post(baseurl+"moviles/agregar_empleado_a_la_movil",{'id_empleado_asignar':id_empleado_asignar,'id_movil_temporal':id_movil_temporal},function(){
                tb.ajax.url(baseurl+"moviles/cargar_emptable?tb=1&id_m_temporal="+id_movil_temporal).load();
                tb2.ajax.url(baseurl+"moviles/cargar_emptable?tb=2&id_m_temporal="+id_movil_temporal).load();
            });                           
      });
});
$("#emptable2").on('draw.dt',function (){
      $('.cl_desvincular').click(function (e) {
            e.preventDefault();//para prevenir el redireccionamiento y realizar la accion que es agregar a la otra tabla
            var id_empleado_desvincular=$(this).data("id-empleado");    
            $.post(baseurl+"moviles/desvincular_empleado_de_la_movil",{'id_empleado_desvincular':id_empleado_desvincular,'id_movil_temporal':id_movil_temporal},function(){
                tb2.ajax.url(baseurl+"moviles/cargar_emptable?tb=2&id_m_temporal="+id_movil_temporal).load();
                tb.ajax.url(baseurl+"moviles/cargar_emptable?tb=1&id_m_temporal="+id_movil_temporal).load();
            });                           
      });
});

$("#formulario_movil").submit(function(e){
    e.preventDefault();
    var nombre =  $("#nombre").val();
    var edicion="<?= (isset($_GET['id'])) ? '&type=edicion':''  ?>"
    $.post(baseurl+"moviles/guardar_movil?id_m_temporal="+id_movil_temporal+edicion,{'nombre':nombre},function(data){
            
            var mensaje ="<?= (isset($_GET['id'])) ? 'Movil Actualizada':'Movil Creada' ?>";
            $("#notify .message").html("<strong>Succes </strong>: "+mensaje);
                    $("#notify").removeClass("alert-danger").addClass("alert-success").fadeIn();
                    $("html, body").scrollTop($("body").offset().top);
            $("#div_remover").remove();
            setTimeout(function(){window.location.href =baseurl+"moviles/";},2000);
    });
    
});
</script>


