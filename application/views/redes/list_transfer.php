<article class="content">

    <div class="card card-block">
        <div id="notify" class="alert alert-success" style="display:none;">
            <a href="#" class="close" data-dismiss="alert">&times;</a>

            <div class="message"></div>
        </div>

        <h4>ACTAS de Transferencias</h4>
        <hr>
        <div class="grid_3 grid_4">
            <table id="tabla-historial" class="table-striped table-hover" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Fecha</th>
                        <th>Almacen Origen</th>
                        <th>Almacen Destino</th>
                        <th>Realizado Por</th>
                        <th>Estado</th>
                        <th>Opciones</th>

                    </tr>
                </thead>
                <tbody>
                    
                </tbody>
                <tfoot>
                    <tr>
                        <th>ID</th>
                        <th>Fecha</th>
                        <th>Almacen Origen</th>
                        <th>Almacen Destino</th>
                        <th>Realizado Por</th>
                        <th>Estado</th>
                        <th>Opciones</th>
                    </tr>
                </tfoot>
            </table>
        </div>
        <hr><hr>
        
        <div id="div_filtro_x">   
        <div class="form-group row">
                                            

                                            <div class="col-sm-6">
                                                <label class=""
                                                   for="pay_cat">Tecnico</label>
                                                <select style="width:100%" name="trans_type" class="form-control" id="sel_tecnicos">
                                                    <?php foreach ($lista_tecnicos as $keyt => $t1): ?>
                                                        <option value="<?=$t1['username'] ?>"><?="( ".$t1['username']." ) ".$t1['name'] ?> </option>
                                                    <?php endforeach ?>
                                                </select>
                                            </div>                              
                                           
                                        </div>
                                        <div class="form-group row" id="div_fechas_filtro_cambio_estado">
                                        
                                        <div class="col-sm-2">
                                            <input type="text" class="form-control required"
                                                   placeholder="Start Date" name="sdate3" id="sdate"
                                                    autocomplete="false">
                                        </div>
                                        <div class="col-sm-2">
                                            <input type="text" class="form-control required"
                                                   placeholder="End Date" name="edate2" id="edate"
                                                   data-toggle="datepicker" autocomplete="false">
                                        </div>
                                    </div>
                                    <a href="#" class="btn btn-success" id="btn_filtrar">Filtrar</a>
                                    <a href="#" class="btn btn-danger" id="btn_pdf">Descargar en PDF</a>
                                    <div id="replace_div">
                                    <table id="filtro_tb" class="table-striped table-hover" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>PID</th>
                                                <th>Nombre</th>
                                                <th>Total Traspasado</th>
                                                <th>Total Gastado</th>
                                                <th>Total En Almacen</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th>#</th>
                                                <th>PID</th>
                                                <th>Nombre</th>
                                                <th>Total Traspasado</th>
                                                <th>Total Gastado</th>
                                                <th>Total En Almacen</th>
                                        </tr>
                                        </tfoot>
                                    </table>
                                    </div>
                                    </div>
                                    <a href="#" id="btn_interaccion_1" class="btn btn-success btn_interaccion"><i class="icon-level-down"></i><i class="icon-level-down"></i> <b>MOSTRAR</b> Campos Para Filtrar <i class="icon-level-down"></i><i class="icon-level-down"></i></a>
                                    <a href="#" id="btn_interaccion_2" class="btn btn-success btn_interaccion"><i class="icon-level-up"></i><i class="icon-level-up"></i> <b>OCULTAR</b> Campos Para Filtrar <i class="icon-level-up"></i><i class="icon-level-up"></i></a>
        </div>
</article>

<script type="text/javascript">
    $(document).on("click","#btn_pdf",function (ev){
        ev.preventDefault();
        var tec=$("#sel_tecnicos option:selected").val();
        var sdate=$("#sdate").val();
        var edate=$("#edate").val();
        var x1a=baseurl+"actas/actas_list_filtro_pdf?tecnico="+tec+"&sdate="+sdate+"&edate="+edate+"&d=1";
        $(location).attr('href',x1a);
    });
    $("#div_filtro_x").hide();
    $("#btn_interaccion_2").hide();
    $("#sel_tecnicos").select2();
    var tb,tb2;
    $(document).on("click","#btn_filtrar",function(eve){
            eve.preventDefault();
            var tec=$("#sel_tecnicos option:selected").val();
            var sdate=$("#sdate").val();
            var edate=$("#edate").val();
            $.post(baseurl+"actas/actas_list_filtro",{"tecnico":tec,"sdate":sdate,"edate":edate},function(data){
                    $("#filtro_tb").remove();
                    $("#replace_div").html(data);
                    tb2=$('#filtro_tb').DataTable({"language":spanish});
                    tb.ajax.url( baseurl+"actas/actas_list?tecnico="+tec+"&sdate="+sdate+"&edate="+edate).load();                       
            });
            
    });
    var oculta_x=true;
    $(document).on("click",".btn_interaccion",function(ev){
            ev.preventDefault();
            $(".btn_interaccion").hide();
        if(oculta_x){
            oculta_x=false;
            $("#div_filtro_x").toggle( "slow",function(){});
            $("#btn_interaccion_2").show();
        }else{
            oculta_x=true;
            $("#div_filtro_x").toggle( "slow",function(){});
            $("#btn_interaccion_1").show();
        }
    });
    $(document).ready(function(){
        tb2=$('#filtro_tb').DataTable({"language":spanish});
            
        tb=$('#tabla-historial').DataTable({

            "processing": true, //Feature control the processing indicator.
            "serverSide": true, //Feature control DataTables' server-side processing mode.
            "order": [], //Initial no order.

            // Load data for the table's content from an Ajax source
            "ajax": {
                "url": "<?php echo site_url('redes/actas_list')?>",
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