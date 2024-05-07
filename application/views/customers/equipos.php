<article class="content">
    <div class="card card-block">
        <div id="notify" class="alert alert-success" style="display:none;">
            <a href="#" class="close" data-dismiss="alert">&times;</a>

            <div class="message"></div>
        </div>        
        <hr>
		<div class="col-sm-2">			
		 	<a href="#pop_model2" id="btn-asignar"   class="btn btn- btn-green mb-1" title="Change Status"
                > ASIGNAR EQUIPO</a></div>
		<div class="col-sm-2">			
		 	<a href="#pop_model3" data-toggle="modal" onclick="funcion_status();" data-remote="false" class="btn btn- btn-blue mb-1" title="Change Status"
                > DEVOLVER EQUIPO</a></div>
        <div class="table-responsive">
			
            <table id="equipostable" class="display" cellspacing="0" width="100%">
                <thead>
                <tr>
                    <th>#</th>
					<th>Codigo</th>
                    <th>MAC</th>
                    <th>Serial</th>
                    <th>Estado</th>                    
					<th>Marca</th>
					<th>T/po instalacion</th>
					<th>Vlan</th>
					<th>Nat</th>
					<th>P/to Nat</th>
                    <th>GENIEACS</th>
                </tr>
                </thead>
                <tbody>
                </tbody>

                <tfoot>
                <tr>
                    <th>#</th>
					<th>Codigo</th>
                    <th>MAC</th>
                    <th>Serial</th>
                    <th>Estado</th>                    
					<th>Marca</th>
					<th>T/po instalacion</th>
					<th>Vlan</th>
					<th>Nat</th>
					<th>P/to Nat</th>
                    <th>GENIEACS</th>
                </tr>
                </tfoot>
            </table>
        </div>
    </div>
    <input type="hidden" id="dashurl" value="products/prd_stats">
</article>
<div id="pop_model2" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Asignar Equipo</h4>
            </div>
		
            <div class="modal-body form-group row">
                <div id="notify_asignar" class="alert alert-warning" >
                        <a href="#" class="close" data-dismiss="alert">&times;</a>

                        <div class="message"> <strong>Mensaje : </strong> El usuario ya cuenta con un equipo, si desea añadir uno nuevo debe de devolver el actual</div>
                </div>
                 <form id="form_model2">
                    <div class="col-sm-6">
                        <label for="cst" class="caption col-form-label">Buscar equipo</label>
                        <div>
                            <input type="hidden" name="iduser"  value="<?php echo $details['id'] ?>"></input>
                            <input type="text" class="form-control" name="cst" id="equipo-box" placeholder="Ingrese mac del equipo" autocomplete="off"/>
                            <div id="equipo-box-result"></div>
                        </div>
                    </div>
                <div class="col-sm-6">
                    <label class="caption col-form-label">Equipo mac<span style="color: red;">*</span></label>
                    <div>
                        <input type="hidden" name="idequipo" id="customer_id" value="0">
                        <input type="text" class="form-control" name="mac" id="customer_name">
                    </div>
                </div>
				<div class="col-sm-6">
                    <label class="caption col-form-label">Metros de cable instalacion<span style="color: red;">*</span></label>
                    <div>
                        <input type="text" class="form-control" name="metros">
                    </div>
                </div>
				<div class="col-sm-6">
                    <label class="caption col-form-label">Accesorios<span style="color: red;">*</span></label>
                    <div>
                        <input type="text" class="form-control" name="accesorios">
                    </div>
                </div>
                <div class="col-sm-6">
                        <label for="pmethod" class="caption col-form-label">Tipo de instalacion</label>
                        <div>
                            <select id="tinstalacion" name="tinstalacion" class="form-control mb-1" onchange="validaciones_campos();">
                                <option value="null">-</option>
                                <option value="EOC">EOC</option>
                                <option value="FTTH">FTTH</option>
                            </select>
                        </div>
                </div>
                
                	<div class="col-sm-6" id="eoc_div">
                        <label for="pmethod" class="caption col-form-label">Master</label>
                        <div class="">
                            <input type="text" name="master" class="form-control mb-1" placeholder="master">
                        </div>
                    </div>
                    <div id="ftth_div" style="display: none;">
                    
                	<div class="col-sm-6">
                        <label for="pmethod" class="caption col-form-label">Caja Nat</label>
                        <div class="form-group">
                            <select id="naps_multiple" name="nap" class="form-control select-box" multiple="multiple" style="width: 100%">
                                   <?php
									foreach ($naps as $row) {
										$cid = $row['idn'];
										$title = $row['nap'];
										echo "<option value='$cid'>$title</option>";
									}
									?>       
                            </select>
                        </div>
                    </div>
            		<div class="col-sm-6">
                        <label for="pmethod" class="caption col-form-label">Puerto Nat</label>
                        <div>
                            <select name="puerto" class="form-control mb-1" id="cmbpuertos">
                        	</select>
                        </div>
                    </div>
               </div>
				<div class="frmSearch col-sm-12">
                    <div style="text-align: right;">
                        <button type="button" class="btn btn-default"
                                data-dismiss="modal">Volver</button>
                        <input type="hidden" id="action-url" value="tickets/asig_equipo">
                        <button type="button" class="btn btn-primary"
                                id="submit_model2">Asignar</button>
            
                    </div>
				</div>
            </form>
		</div>
    	</div>
	</div>
</div>
<div id="pop_model3" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Devolucion de equipo</h4>
            </div>

            <div class="modal-body">
                <form id="form_model3">
				<div id="customerpanel" class="form-group row">
                    <label for="toBizName"
                           class="caption col-sm-2 col-form-label">Codigo equipo<span
                                style="color: red;">*</span></label>					
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="codigo" >
                    </div>
										
                </div>
				<div id="customerpanel" class="form-group row">
                    <label for="toBizName"
                           class="caption col-sm-2 col-form-label">Motivo<span
                                style="color: red;">*</span></label>
					<input type="hidden" name="iduser" value="<?php echo $details['id'] ?>"></input>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="nota">
                    </div>
										
                </div>
				<div id="customerpanel" class="form-group row">
                    <label for="toBizName"
                           class="caption col-sm-2 col-form-label">Estado<span
                                style="color: red;">*</span></label>					
                    <div class="col-sm-6">
                        <select name="estado" class="form-control">
							<option value="Bueno">Bueno</option>
							<option value="Malo">Malo</option>						
							<option value="Depurado">Depurado</option>						
						</select>
                    </div>
										
                </div>
                        <button type="button" class="btn btn-default"
                                data-dismiss="modal">Volver</button>
                        <input type="hidden" id="action-url" value="customers/dev_equipo">
                        <button type="button" class="btn btn-primary"
                                id="submit_model3">Devolver</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div id="genieacs-modal" class="modal fade">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                
                <h3 class="modal-title" align="center">Genieacs Integracion, MAC = <label id="mac-modal">xxx</label></h3>

            </div>
            <div class="modal-body">
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">SSID</label>
                    <div class="col-sm-7">
                        <input type="text" name="ssid" id="genieacs-ssid" class="form-control">
                    </div>
                    <div class="col-sm-1">
                        <small id="cargando-cambio-ssid"> ¡¡ CARGANDO !!...</small>
                        <a href="#" class="btn btn-small btn-green actualizar-gns-button" data-parameter="ssid" data-texto="el SSID" id="actualizar-ssid"><span class="icon-pencil"></span>Cambiar<span class="icon-pencil"></a>    
                    </div>
                    
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Contraseña</label>
                    <div class="col-sm-7">
                        <input type="text" name="password" id="genieacs-password" class="form-control">
                    </div>
                    <div class="col-sm-1">
                        <small id="cargando-cambio-password"> ¡¡ CARGANDO !!...</small>
                        <a href="#" class="btn btn-small btn-green actualizar-gns-button" data-parameter="password" data-texto="la Contraseña" id="actualizar-password"><span class="icon-pencil"></span>Cambiar<span class="icon-pencil"></a>    
                    </div>
                    
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Tv</label>
                    <div class="col-sm-7">
                        <a class="btn btn-lg btn-success" href="#"  id="genieacs-tv-on">&nbsp&nbsp&nbsp&nbsp&nbsp<span class="icon-thumbs-up"> Activo <span class="icon-check">&nbsp&nbsp&nbsp</a>
                        <a class="btn btn-lg btn-danger" href="#"  id="genieacs-tv-off">&nbsp&nbsp&nbsp&nbsp&nbsp<span class="icon-thumbs-down"> Inactivo <span class="icon-thumbs-down">&nbsp&nbsp&nbsp</a>
                    </div>
                    <div class="col-sm-1">
                        <small id="cargando-cambio-tv"> ¡¡ CARGANDO !!...</small>
                        <a href="#" class="btn btn-small btn-green actualizar-gns-button-boolean" data-valor="true" data-parameter="tv" data-texto="la TV" id="actualizar-tv"><span class="icon-pencil"></span>Cambiar<span class="icon-pencil"></a>    
                    </div>
                    
                </div>
                
            </div>
            <div class="modal-footer">
                
                <button type="button" class="btn btn-primary" data-dismiss="modal">Cerrar</button>
                
            </div>
        </div>
    </div>
</div>
<script>
    var id_equipo_gns=0;
    var mac_equipo_gns=0;
    var id_gns=0;
    var campo_actualizar="";
    $("#cargando-cambio-ssid").hide();
    $("#cargando-cambio-password").hide();
    $("#cargando-cambio-tv").hide();
$(document).on('click',".equipo-gns",function(ev){
    ev.preventDefault();
    mac_equipo_gns=$(this).data("mac");
    id_equipo_gns=$(this).data("id");
    $.post(baseurl+"customers/get_genieacs_data",{'mac_equipo_gns':mac_equipo_gns,'id_equipo_gns':id_equipo_gns},function(data){
        if( data.status=="exito" ) {
            $("#genieacs-ssid").val(data.ssid);
            $("#genieacs-password").val(data.password);
            $("#mac-modal").text(mac_equipo_gns);
            interaccion_booleans("tv",data.tv);
            $("#genieacs-modal").modal("show");
        }else{
            alert("Error de Conexion con  Genieacs");
        }
    },'json');    
});



//esto es para los campos de solo texto
$(document).on("click",".actualizar-gns-button",function(data){

campo_actualizar=$(this).data("parameter");
var text_actualizar2=$("#genieacs-"+campo_actualizar).val();
var validacion=true;
if(campo_actualizar=="password" && (text_actualizar2.length<8 || text_actualizar2.length>13)){
    validacion=false;
    alert("la contraseña debe de ser de entre 8 y 13 caracteres");
}
if(validacion==true){
var texto_titulo=$(this).data("texto");
        if(confirm("¿ Seguro deseas Cambiar "+texto_titulo+"?, esta accion no es revercible")){
            $("#actualizar-"+campo_actualizar).hide();
            $("#cargando-cambio-"+campo_actualizar).show();
            var text_actualizar=$("#genieacs-"+campo_actualizar).val();
                $.post(baseurl+"customers/actualizar_genieacs",{'type':"string",'mac_equipo_gns':mac_equipo_gns,'id_equipo_gns':id_equipo_gns,'text_actualizar':text_actualizar,"campo":campo_actualizar},function(data){
                    if(data=="Actualizado"){
                        alert(texto_titulo+" se a Actualizado con exito");                     
                    }else{
                        alert("Cambio no realizado el equipo se encuentra inactivo");
                    }
                       $("#cargando-cambio-"+campo_actualizar).hide();
                        $("#actualizar-"+campo_actualizar).show();
                });
        }

}
});



//esto es para los campos de solo booleans
$(document).on("click",".actualizar-gns-button-boolean",function(data){

campo_actualizar=$(this).data("parameter");
var texto_titulo=$(this).data("texto");
        if(confirm("¿ Seguro deseas Cambiar "+texto_titulo+"?, esta accion no es revercible")){
            $("#actualizar-"+campo_actualizar).hide();
            $("#cargando-cambio-"+campo_actualizar).show();
            var text_actualizar=$(this).data("valor");
                $.post(baseurl+"customers/actualizar_genieacs",{'type':"boolean",'mac_equipo_gns':mac_equipo_gns,'id_equipo_gns':id_equipo_gns,'text_actualizar':text_actualizar,"campo":campo_actualizar},function(data){
                    if(data=="Actualizado"){
                        var dato1=false;
                        if(text_actualizar=="false"){
                            dato1=true;
                        }
                        interaccion_booleans(campo_actualizar,dato1)
                        alert(texto_titulo+" se a Actualizado con exito");                     
                    }else{
                        alert("Cambio no realizado el equipo se encuentra inactivo");
                    }
                       $("#cargando-cambio-"+campo_actualizar).hide();
                        $("#actualizar-"+campo_actualizar).show();
                });
        }


});


function interaccion_booleans(campo,dato1){

            if(dato1==true){
                $("#genieacs-"+campo+"-on").show();
                $("#genieacs-"+campo+"-off").hide();
                $("#actualizar-"+campo).data("valor","true");
            }else{
                $("#genieacs-"+campo+"-off").show();
                $("#genieacs-"+campo+"-on").hide();
                $("#actualizar-"+campo).data("valor","false");
            }
            console.log(dato1);
}


//traer puertos			
$(document).ready(function(){
	$("#naps_multiple").change(function(){
		$("#naps_multiple option:selected").each(function(){
			idn = $(this).val();
			//console.log(idDepartamento);
			$.post(baseurl+"redes/puertos_list",{'idn': idn
				},function(data){
				//console.log(data);
					$("#cmbpuertos").html(data);
			})
		})
	})
})	
</script>
<script type="text/javascript">
	
	
    var table;
    var id_customer="<?=$_GET['id']?>";
    $(document).ready(function () {

        //datatables
        table = $('#equipostable').DataTable({

            "processing": true, //Feature control the processing indicator.
            "serverSide": true, //Feature control DataTables' server-side processing mode.
            "order": [], //Initial no order.

            // Load data for the table's content from an Ajax source
            "ajax":  {
                'url': "<?php echo site_url('customers/equipolist')?>",				
                'type': 'POST',
                'data': {'cid':<?php echo $_GET['id'] ?> }
            },

            //Set column definition initialisation properties.
            "columnDefs": [
                {
                    "targets": [0], //first column / numbering column
                    "orderable": false, //set not orderable
                },
            ],
				"order": [[ 2, "desc" ]],
                "language": {
                    "info": "Pagina _PAGE_ de _PAGES_",
                    "zeroRecords": "No se encontraron resultados",
                    "processing": "Procesando...",
                    "lengthMenu": "Mostrar _MENU_ registros",
                    "search": "Buscar:",
                    "paginate": {
                        "first": "Primero",
                        "last": "Último",
                        "next": "Siguiente",
                        "previous": "Anterior"
                    },
                }

        });
        miniDash();
    });
    function validaciones_campos(){
        var ck=$("#tinstalacion option:checked").val();
        if(ck=="EOC"){
            $("#eoc_div").show();
            $("#ftth_div").hide();
        }else{
            $("#eoc_div").hide();
            $("#ftth_div").show();
        }
        console.log(ck);

    }
    $("#btn-asignar").click(function(ev){
        ev.preventDefault();
        $.post(baseurl+"customers/validar_equipos_usuario",{id_customer:id_customer},function(data){
            if(data=="true" || data==true){
                $("#submit_model2").removeAttr("disabled");
                $("#notify_asignar").hide();
            }else{                
                $("#submit_model2").attr("disabled","true");
                $("#notify_asignar").show();
            }
            $("#pop_model2").modal("show");
        });
        

    });
$("#naps_multiple").select2();
</script>
<div id="delete_model" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><?php echo $this->lang->line('Delete') ?></h4>
            </div>
            <div class="modal-body">
                <p><?php echo $this->lang->line('delete this product') ?></p>
            </div>
            <div class="modal-footer">
                <input type="hidden" id="object-id" value="">
                <input type="hidden" id="action-url" value="products/delete_i">
                <button type="button" data-dismiss="modal" class="btn btn-primary"
                        id="delete-confirm"><?php echo $this->lang->line('Delete') ?></button>
                <button type="button" data-dismiss="modal"
                        class="btn"><?php echo $this->lang->line('Cancel') ?></button>
            </div>
        </div>
    </div>
</div>