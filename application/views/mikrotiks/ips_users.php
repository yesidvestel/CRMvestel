<style type="text/css">
    .st-Activo, .st-Inactivo
{
    text-transform: uppercase;
    color: #fff;
    padding: 4px;
    border-radius: 11px;
    font-size: 15px;
}
.st-Activo
{
 background-color: #4EAA28;
}
.st-Inactivo
{
 background-color: #A4282A;
}

</style>
<article class="content">

    <div class="card card-block">
        <div id="notify" >
            
        </div>

        <h4>Configuracion de Ips por defecto de usuarios </h4>
<a href="#" id="open_modal" class="btn-small btn-primary">Agregar Nueva Configuracion</a>

        <hr>
        <div class="grid_3 grid_4">
            <table id="tabla-historial" class="table-striped table-hover" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Ip Local</th>
                        <th>Ip Remota</th>
                        <th>Tegnologia</th>
                        <th>Sede</th>
                        <th>Acciones</th>
                        

                    </tr>
                </thead>
                <tbody>
                    
                </tbody>
                <tfoot>
                    <tr>
                      <th>ID</th>
                        <th>Nombre</th>
                        <th>Ip Local</th>
                        <th>Ip Remota</th>
                        <th>Tegnologia</th>
                        <th>Sede</th>
                        <th>Acciones</th>
                    </tr>
                </tfoot>
            </table>
        </div>
        
        
        
        </div>
</article>
<div id="modal_agregar" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"><span class="tipo">Agregar</span> Mikrotik</h4>
            </div>
            <form action="#" method="post" id="form_guardar" >
            <div class="modal-body" id="emailbody">
                <table width="100%">
                    <tr>
                        <td>
                            <label>Ip Local</label>
                                    <input required placeholder="Ip Local" type="text" name="ip_local" minlength="7" maxlength="15" size="15" pattern="^((\d{1,2}|1\d\d|2[0-4]\d|25[0-5])\.){3}(\d{1,2}|1\d\d|2[0-4]\d|25[0-5])$" class="form-control">             
                        </td>
                        <td>
                            <label>Ip Remota</label>
                                    <input required placeholder="Ip Remota" type="text" name="ip_remota" minlength="7" maxlength="15" size="15" pattern="^((\d{1,2}|1\d\d|2[0-4]\d|25[0-5])\.){3}(\d{1,2}|1\d\d|2[0-4]\d|25[0-5])$" class="form-control">             
                        </td>
                        
                </tr>                        
                <tr>
                    <td>
                                <label>Nombre</label>
                                 <input type="text" name="nombre" class="form-control" placeholder="Nombre">             
                        </td>
                        <td>
                            <label>Tegnologia</label>
                               <select class="form-control" name="tegnologia" id="tegnologia">
                                        <option value=""> Sin Tegnologia</option>
                                       <option value="GPON">GPON</option>
                                       <option value="EPON">EPON</option>
                                       <option value="EOC">EOC</option>
                               </select>         
                        </td>
                        
                    </tr>
                    <tr>
                        <td>
                            <label>Sede</label>
                               <select class="form-control" name="sede" id="sede">
                                <?php foreach ($lista_sedes as $key => $sd): ?>
                                        <option value="<?=$sd['id'] ?>"><?=$sd['title'] ?></option>
                                <?php endforeach ?>
                                   
                               </select>
                        </td>
                        <td></td>
                    </tr>
                    
                  
                </table>
                
               
            
               
               
                   
               
            </div>
            <div class="modal-footer">
                <input type="hidden" name="id_configuracion" value="0">
                <button type="button" class="btn btn-default"
                        data-dismiss="modal"><?php echo $this->lang->line('Close') ?></button>
                <button type="submit" class="btn btn-primary tipo"
                        id="sendM" >Guardar</button>
            </div>
            </form>
        </div>
    </div>
</div>
<script type="text/javascript">
    var view_p=true;
 
    var numer_iteration=0;
    $(document).on("click",".cl_calcula_estado",function(ev){
            ev.preventDefault();
            var id_mk=$(this).data("id");
        mostrar_alerta1("notify",2,"Esperando Respuesta ...");
            $.post(baseurl+"/mikrotiks/estado_mikrotik",{'id':id_mk},function(data){
                mostrar_alerta1("notify",1,"Confirmado ");
                $("#notify").css("display","none");
                 tb.ajax.url( baseurl+"mikrotiks/list_json_ips_users").load();
            });
    });
    $(document).on("click","#validar_todas_mk",function(ev){
        ev.preventDefault();
        consultar_estado(numer_iteration);
    });
    function consultar_estado (id){

            mostrar_alerta1("notify",2,"Esperando Respuesta ... "+(id+1));
            $.post(baseurl+"/mikrotiks/estado_mikrotik",{'id':lista_mks[id]},function(data){
                mostrar_alerta1("notify",1,"Confirmado ");
                $("#notify").css("display","none");
                 tb.ajax.url( baseurl+"mikrotiks/list_json_ips_users").load();
                 numer_iteration++;
                 if(numer_iteration<lista_mks.length){
                    consultar_estado(numer_iteration);
                 }
            });
    }
    $(document).on("click",".set_default",function(ev){
        var datosx=$(this).data("datos");
        
        $.post(baseurl+"mikrotiks/set_default",datosx,function(dt){
            tb.ajax.url( baseurl+"mikrotiks/list_json_ips_users").load();    
        });

    });

   $(document).on("click","#open_modal",function (ev){
        ev.preventDefault();
        document.getElementById("form_guardar").reset();
        $(".tipo").text("Agregar");
        $("#modal_agregar").modal("show");
   });
   $(document).on("submit","#form_guardar",function (e){
    e.preventDefault();
        var form=$(this).serialize();
        $.post(baseurl+"mikrotiks/save_ajax_ips_users",form,function(data){
            tb.ajax.url( baseurl+"mikrotiks/list_json_ips_users").load();    
            document.getElementById("form_guardar").reset(); 
            $("#modal_agregar").modal("hide");

            if($("input [name=id_configuracion]").val()=="0"){
                mostrar_alerta1("notify",1,"Datos Agregados ...");    
            }else{
                mostrar_alerta1("notify",1,"Datos Actualizados ...");
            }
            

        });

   });
   $(document).on("click",".update_mk",function(e){
        e.preventDefault();
        document.getElementById("form_guardar").reset();
        var datos=$(this).data("datos");
        var id=datos.id;
        //id=id.replace('#', '');
        $("input[name=id_configuracion]").val(id);
        $("input[name=nombre]").val(datos.nombre);
        $("input[name=ip_local]").val(datos.ip_local);
        $("input[name=ip_remota]").val(datos.ip_remota);
        $("input[name=puerto]").val(datos.puerto);
        
        var sede="''";
        var tegnologia="''";
        if(datos.tegnologia!=""){
            tegnologia=datos.tegnologia;
        }
        if(datos.sede!=""){
            sede=datos.sede;
        }
        $("#tegnologia option[value="+tegnologia+"]").prop("selected",true);
        $("#sede option[value="+sede+"]").prop("selected",true);
        $(".tipo").text("Actualizar");
        $("#modal_agregar").modal("show");
        
   });
       $(document).on("click",".set_default",function(ev){
        var datosx=$(this).data("datos");
        
        $.post(baseurl+"mikrotiks/set_default_ips_user",datosx,function(dt){
            tb.ajax.url( baseurl+"mikrotiks/list_json_ips_users").load();    
        });

    });
    $(document).ready(function(){
        
            
        tb=$('#tabla-historial').DataTable({

            "processing": true, //Feature control the processing indicator.
            "serverSide": true, //Feature control DataTables' server-side processing mode.
            "order": [], //Initial no order.

            // Load data for the table's content from an Ajax source
            "ajax": {
                "url": "<?php echo site_url('mikrotiks/list_json_ips_users')?>",
                "type": "POST"
            },

            //Set column definition initialisation properties.
            "columnDefs": [
                {
                    //"targets": [0], //first column / numbering column
                    "orderable": false, //set not orderable
                },
                
            ],  
            "language":spanish
            

        });

    });

    var spanish={
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

                };
</script>