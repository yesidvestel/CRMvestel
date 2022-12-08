<article class="content">
    <div class="card card-block">
        <div id="notify" class="alert alert-success" style="display:none;">
            <a href="#" class="close" data-dismiss="alert">&times;</a>

            <div class="message"></div>
        </div>
        <h4>Historial</h4>
		<div class="card card-block sameheight-item">

                        
                            <div class="form-group row">
								<label class="col-sm-12 col-form-label"
                                       for="pay_cat"><h5>FILTRAR</h5></label>
								
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label"
                                       for="pay_cat">Fechas</label>

                                <div class="col-sm-6">
                                    <select name="trans_type" class="form-control" id="fechas" onchange="filtrado_fechas()">
                                        <option value=''>Todas</option>
                                        <option value='fcreada'>Especificar Fecha</option>
                                        
                                    </select>
                                </div>                              
                            </div>
				 			<div class="form-group row" id="div_fechas" style="display: none">
                                <label class="col-sm-2 col-form-label"
                                       for="pay_cat" id="label_fechas">Fechas</label>

                                <div class="col-sm-2">
                                    <input type="text" class="form-control required"
                                           placeholder="Start Date" name="sdate" id="sdate"
                                            autocomplete="false">
                                </div>
								<div class="col-sm-2">
									<input type="text" class="form-control required"
                                           placeholder="End Date" name="edate" id="edate"
                                           data-toggle="datepicker" autocomplete="false">
								</div>
                            </div>
                           
							<div class="form-group row">
                                <label class="col-sm-3 col-form-label" for="pay_cat"></label>

                                <div class="col-sm-4">
                                    <input type="button" class="btn btn-primary btn-md" value="VER" onclick="filtrar()">


                                </div>
                            </div>
                        
                    </div>
		<a href="#" onclick="redirect_to_export()" class="btn btn-success fa-sharp fa-solid fa-file-excel"></a>
        <hr>
        <div class="grid_3 grid_4">
            <table id="tabla-historial" class="table-striped table-hover" cellspacing="0" width="100%">
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
<script src="https://kit.fontawesome.com/317775a1b1.js" crossorigin="anonymous"></script>
<script type="text/javascript">
    var tb;
    $(document).ready(function(){
        tb=$('#tabla-historial').DataTable({

            "processing": true, //Feature control the processing indicator.
            "serverSide": true, //Feature control DataTables' server-side processing mode.
            "order": [], //Initial no order.

            // Load data for the table's content from an Ajax source
            "ajax": {
                "url": "<?php echo site_url('products/historial_list?mod=Orden de Compra')?>",
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

    $(document).on("click",".ver-mas",function(e){
        let contenido;
            contenido=$(this).data("descripcion");

            
            if(typeof contenido ==="string"){
                    $("#parrafo").html("<p>"+contenido+"</p>");
                    $("#tabla").css("display","none");
                    $("#parrafo").css("display","");    
            }else{
                    var content="";
                    
                     for(var clave in contenido){
                        console.log(clave);
                        content+="<tr><td>"+clave+"</td><td>"+contenido[clave]+"</td></tr>";
                     }
                    
                    $("#tbody1").html(content);
                    $("#parrafo").css("display","none");
                    $("#tabla").css("display","");    
            }
            

        //console.log(contenido);
        $("#pop_model").modal("show");
    });
	function filtrar(){
        var opcion_seleccionada=$("#fechas option:selected").val();
        var edate=$("#edate").val();
        var sdate=$("#sdate").val();
        if(opcion_seleccionada==""){
            tb.ajax.url( baseurl+'products/historial_list?mod=Orden de Compra').load();     
        }else{
            //var tec=$("#tecnicos2 option:selected").data("id");
            tb.ajax.url( baseurl+"products/historial_list?edate="+edate+"&sdate="+sdate+"&filtro_fecha="+opcion_seleccionada+"&mod=Orden de Compra" ).load();     
        }
       

    }
	//export excel
	function redirect_to_export(){
       var tecnico=$("#tecnicos2 option:selected").val();
		var tipo=$("#tipo option:selected").val();
        var opcion_seleccionada=$("#fechas option:selected").val();
        var edate=$("#edate").val();
        var edatefin=$("#edatefin").val();
        var sdate=$("#sdate").val();
        var sdatefin=$("#sdatefin").val();
        var url_redirect=baseurl+"purchase/explortar_his_ord?tecnico="+tecnico+"&tipo="+tipo+"&edate="+edate+"&edatefin="+edatefin+"&sdate="+sdate+"&sdatefin="+sdatefin+"&filtro_fecha="+opcion_seleccionada;
            window.location.replace(url_redirect);

    }
	function  filtrado_fechas(){
        var opcion_seleccionada=$("#fechas option:selected").val();
        if(opcion_seleccionada=="fcreada"){
            $("#div_fechas").show();
            $("#label_fechas").text("Fechas")
        }else{
            $("#div_fechas").hide();
        }
		 if(opcion_seleccionada=="fecha_final"){
            $("#div_fecha_final").show();
            $("#label_fecha_final").text("Fechas")
        }else{
            $("#div_fecha_final").hide();
        }
    }
</script>