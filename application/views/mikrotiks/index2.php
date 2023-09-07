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

        <h4>Mikrotiks </h4>
<a href="#" id="open_modal" class="btn-small btn-primary">Agregar Nueva Mikrotik</a>
<a href="#" id="validar_todas_mk" class="btn-small btn-warning">Validar Conexion de Todas las Mikrotiks</a>
        <hr>
        <div class="grid_3 grid_4">
            <table id="tabla-historial" class="table-striped table-hover" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Ip</th>
                        <th>Puerto</th>
                        <th>Tegnologia</th>
                        <th><?=$title_1  ?></th>
                        <th>Usuario</th>
                        <th>Password</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                        

                    </tr>
                </thead>
                <tbody>
                    
                </tbody>
                <tfoot>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Ip</th>
                        <th>Puerto</th>
                        <th>Tegnologia</th>
                        <th><?=$title_1  ?></th>
                        <th>Usuario</th>
                        <th>Password</th>
                        <th>Estado</th>
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
                            <label>Ip</label>
                                    <input required placeholder="IP" type="text" name="ip" minlength="7" maxlength="15" size="15" pattern="^((\d{1,2}|1\d\d|2[0-4]\d|25[0-5])\.){3}(\d{1,2}|1\d\d|2[0-4]\d|25[0-5])$" class="form-control">             
                        </td>
                        <td>
                               <label>Puerto</label>
                                    <input required type="number" placeholder="Puerto" name="puerto" class="form-control">                
                        </td>
                </tr>                        
                <tr>
                        <td>
                            <label>Nombre</label>
                                 <input type="text" name="nombre" class="form-control" placeholder="Nombre">            
                        </td>
                        <td>
                            <label><?=$title_1  ?></label>
                               <select class="form-control" name="sede" id="sede">
                                <?php foreach ($lista_sedes as $key => $sd): ?>
                                        <option value="<?=$sd['id'] ?>"><?=$sd['title'] ?></option>
                                <?php endforeach ?>
                                   
                               </select>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label>Tegnologia</label>
                               <select class="form-control" name="tegnologia" id="tegnologia">
                                        <option value=""> Sin Tegnologia</option>
                                       <option value="GPON">GPON</option>
                                       <option value="EPON">EPON</option>
                                       <option value="EOC">EOC</option>
                               </select>
                        </td>
                        <td>
                            <label>Usuario</label>
                            <input required placeholder="Usuario" name="usuario" type="text"  class="form-control">
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label>Password</label>
                   <a href="#" id="ver_password" class="btn-small btn-success"><i class="icon-eye"></i></a> <input required type="password" placeholder="password" name="password" id="password" class="form-control">
                        </td>
                        <td></td>
                    </tr>
                </table>
                
               
            
               
               
                   
               
            </div>
            <div class="modal-footer">
                <input type="hidden" name="id_mikrotik" value="0">
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
    var lista_mks=<?=$lista_mks ?>;
    var numer_iteration=0;
    $(document).on("click",".cl_calcula_estado",function(ev){
            ev.preventDefault();
            var id_mk=$(this).data("id");
        mostrar_alerta1("notify",2,"Esperando Respuesta ...");
            $.post(baseurl+"/mikrotiks/estado_mikrotik",{'id':id_mk},function(data){
                mostrar_alerta1("notify",1,"Confirmado ");
                $("#notify").css("display","none");
                 tb.ajax.url( baseurl+"mikrotiks/mk_list").load();
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
                 tb.ajax.url( baseurl+"mikrotiks/mk_list").load();
                 numer_iteration++;
                 if(numer_iteration<lista_mks.length){
                    consultar_estado(numer_iteration);
                 }
            });
    }
    $(document).on("click",".set_default",function(ev){
        var datosx=$(this).data("datos");
        
        $.post(baseurl+"mikrotiks/set_default",datosx,function(dt){
            tb.ajax.url( baseurl+"mikrotiks/mk_list").load();    
        });

    });
    $(document).on("click","#ver_password",function (ev){
        ev.preventDefault();
        if(view_p){
            $('#password').get(0).type = 'text';
            view_p=false;
        }else{
            $('#password').get(0).type = 'password';
            view_p=true;
        }
        

    });
   $(document).on("click","#open_modal",function (ev){
        ev.preventDefault();
        document.getElementById("form_guardar").reset();
        $(".tipo").text("Agregar");
        $("input[name=id_mikrotik]").val(0);
        $("#modal_agregar").modal("show");
   });
   $(document).on("submit","#form_guardar",function (e){
    e.preventDefault();
        var form=$(this).serialize();
        $.post(baseurl+"mikrotiks/save_ajax",form,function(data){
            tb.ajax.url( baseurl+"mikrotiks/mk_list").load();    
            document.getElementById("form_guardar").reset(); 
            $("#modal_agregar").modal("hide");

            if($("input [name=id_mikrotik]").val()=="0"){
                mostrar_alerta1("notify",1,"Mikrotik Agregada ...");    
            }else{
                mostrar_alerta1("notify",1,"Mikrotik Actualizada ...");
            }
            

        });

   });
   $(document).on("click",".update_mk",function(e){
        e.preventDefault();
        document.getElementById("form_guardar").reset();
        var datos=$(this).data("datos");
        var id=datos.id;
        id=id.replace('MK#', '');
        $("input[name=id_mikrotik]").val(id);
        $("input[name=nombre]").val(datos.nombre);
        $("input[name=ip]").val(datos.ip);
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
        $("input[name=usuario]").val(datos.usuario);
        $("input[name=password]").val(datos.password);
        $(".tipo").text("Actualizar");
        $("#modal_agregar").modal("show");
        
   });
    $(document).ready(function(){
        
            
        tb=$('#tabla-historial').DataTable({

            "processing": true, //Feature control the processing indicator.
            "serverSide": true, //Feature control DataTables' server-side processing mode.
            "order": [], //Initial no order.

            // Load data for the table's content from an Ajax source
            "ajax": {
                "url": "<?php echo site_url('mikrotiks/mk_list')?>",
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