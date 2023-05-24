<link rel="stylesheet" href="<?=base_url()?>assets/css/jquery.lineProgressbar.css">
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-cookie/1.4.1/jquery.cookie.min.js"></script>
<script type="text/javascript" src="<?=base_url()?>assets/js/jquery.lineProgressbar.js"></script>
<article class="content">

    <div class="card card-block">
         <div id="notify" class="alert alert-success" style="display:none;">
            <a href="#" class="close" data-dismiss="alert">&times;</a>
            
            <div class="message"></div>
        </div>
<h4>Selecciona el archivo y subelo ...</h4>
<hr>
        <form id="form_model2" enctype="multipart/form-data">
                 <div class="col-sm-4">
                            <input id="fileupload" type="file" name="files[]" required accept=".xlsx,.xls">
                        </span>
                        <br>
                        
                    </div>
                <div>
                
                  
                <input type="hidden" id="action-url2" value="transactions/cargue_xlxs">
                <button type="submit" data-dismiss="modal" class="btn btn-primary"
                        id="submit_model2-tr-nw">Subir</button>
                </div>
                </form>
<hr>
        <h4>Lista de archivos cargados</h4>


        <hr>

       
        <div class="grid_3 grid_4">
            <table id="tabla-archivos" class="table-striped table-hover" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Fecha</th>
                        <th>Usuario</th>
                        <th>Estado</th>
                        <th>Accion</th>
                    </tr>
                </thead>
                <tbody>
                    
                </tbody>
                <tfoot>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Fecha</th>
                        <th>Usuario</th>
                        <th>Estado</th>
                        <th>Accion</th>
                    </tr>
                </tfoot>
            </table>
        </div>
        
        
        
        </div>
</article>
<div id="modal_process" class="modal fade">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Progreso del Proceso</h4>
            </div>
            
            <div class="modal-body" >
                 <p>Progreso recorrido usuarios</p>
                        <div id="progress" data-init="true"></div>
                        <div style="margin-top: -25px;"><span id="span_progress1">0/0</span></div>
                        <br>
                        <div id="pro2">
                        <p class="progressfg">Progreso proceso en ejecucion</p>
                        <div id="progressfg" class="progressfg" data-init="true"></div>
                        </div>
                 <hr>
                 <div class="grid_3 grid_4">
            <table id="tabla-cs" class="table-striped table-hover" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Documento</th>
                        <th>Monto</th>
                        <th>Estado</th>
                        <th>REF. EFECTY</th>
                    </tr>
                </thead>
                <tbody>
                    
                </tbody>
                <tfoot>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Documento</th>
                        <th>Monto</th>
                        <th>Estado</th>
                        <th>REF. EFECTY</th>
                    </tr>
                </tfoot>
            </table>
        </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default"
                        data-dismiss="modal"><?php echo $this->lang->line('Close') ?></button>
                
            </div>
            
        </div>
    </div>
</div>
<script type="text/javascript">
    var tb;
    var tb_cs;
     $(document).ready(function(){
        
            
        tb=$('#tabla-archivos').DataTable({

            "processing": true, //Feature control the processing indicator.
            "serverSide": true, //Feature control DataTables' server-side processing mode.
            "order": [], //Initial no order.

            // Load data for the table's content from an Ajax source
            "ajax": {
                "url": "<?php echo site_url('transactions/list_files_up')?>",
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

        tb_cs=$('#tabla-cs').DataTable({

            "processing": true, //Feature control the processing indicator.
            "serverSide": true, //Feature control DataTables' server-side processing mode.
            "order": [], //Initial no order.

            // Load data for the table's content from an Ajax source
            "ajax": {
                "url": "<?php echo site_url('transactions/list_customers_cargados?id=0')?>",
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
var recargar_f_excel=true;

$(document).on("submit","#form_model2",function (e){
    e.preventDefault();
    
    var o_data =  $("#form_model2").serializeArray();
     var form_data = new FormData();
     var file_date=$("#fileupload").prop("files")[0];
     form_data.append("files",file_date);

    $.map(o_data, function(n, i){console.log(n['name']);
        form_data.append(n['name'], n['value']);
    });

     
    var action_url= $('#action-url2').val();
    $("#submit_model2-tr-nw").attr('disabled','disabled');
    addObject_eq(form_data,action_url);
});
$('#progress').LineProgressbar({
        percentage: 0,
        animation: true,
        fillBackgroundColor: '#1abc9c',
        height: '25px',
        radius: '10px'
    });
    $('#progressfg').LineProgressbar({
        percentage: 0,
        animation: true
    });

    //codigo de interaccion progress
    function progress_one(valorx){
             $('#progressfg').LineProgressbar({
                        percentage: valorx,
                        animation: true
                    });
    }
    
    
    var id_file;
    var xhr;
    var datos_recorrer;
    var i=0;
    var total=0;
    var total_a_facturar=0;
    var va_en=0;
var proceso_iniciado=false;
    $(document).on("click",'.cl-play-process',function(ev){
        ev.preventDefault();
        
        $(this).attr("disabled","true");
        $("#modal_process").modal("show");
         id_file=$(this).data("id-file");
        if(!proceso_iniciado){proceso_iniciado =true;
             progress_one(40);
            $.post(baseurl+"transactions/obtener_lista_usuarios_a_facturar",{'id_file':id_file},function(data){
                progress_one(90);
                datos_recorrer=data.lista_usuarios_a_facturar;
                total=datos_recorrer.length;
                total_a_facturar= parseInt( data.total_usuarios);
               va_en =parseInt(total_a_facturar-datos_recorrer.length);
                $("#span_progress1").text(va_en+"/"+total_a_facturar);

                iniciar_facturacion();
                
            },'json');
        }

    });
    
    
    var errores=0;
function iniciar_facturacion(){
        var pay_acc="x";
        var sdate="y";
        progress_one(10);
        if(i<parseInt(total)){
            var id_customer=datos_recorrer[i].id;
             //var num1=va_en+1;
             va_en++;
                var porcentaje=parseInt((va_en*100)/parseInt(total_a_facturar));
                //console.log(va_en+"-"+va_en+"-"+total+"-"+porcentaje);
                $('#progress').LineProgressbar({
                    percentage: porcentaje,
                    animation: false,
                    fillBackgroundColor: '#1abc9c',
                    height: '25px',
                    radius: '10px'
                });  
                
                    $("#span_progress1").text(va_en+"/"+total_a_facturar);
                    progress_one(40);
            $.post(baseurl+"transactions/procesar_usuarios_a_facturar",{'id_file':id_file,'id':id_customer},function(data){


                    if(data.estado=="procesado" || data.estado=="procesado 2"){
                        console.log(data.estado);
                        i++;
                        progress_one(100);
                        iniciar_facturacion();
                        recargar_tb_results();
                    }

                    
            },'json').fail(function(xhr, status, error) {
                if(errores>5){
                    i++;
                    errores=0;
                }else{
                    va_en--;    
                }
                
                console.log("ubo un error");
                iniciar_facturacion();
            });
        }else{
recargar_tb_results();
finalizar_registro_file();
            alert("Proceso Finalizado");
            
            $('.progressfg').remove();
            $("#pro2").append(' <p class="progressfg">Progreso proceso en ejecucion</p><div id="progressfg" class="progressfg" data-init="true"></div>');
            $("#pro2").hide();
             progress_one(100);
            //window.location.href = baseurl+"facturasElectronicas/visualizar_resumen_ejecucion?fecha="+sdate+"&sede="+pay_acc;
        }
}
function finalizar_registro_file(){
    $.post(baseurl+"transactions/finalizar_file",{'id_file':id_file},function(data){

        tb.ajax.url( baseurl+"transactions/list_files_up").load();                
            });
}
function recargar_tb_results(){
    tb_cs.ajax.url( baseurl+"transactions/list_customers_cargados?id="+id_file).load();
}
</script>