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

            <div class="modal-body">
                <div id="notify_asignar" class="alert alert-warning" >
                        <a href="#" class="close" data-dismiss="alert">&times;</a>

                        <div class="message"> <strong>Mensaje : </strong> El usuario ya cuenta con un equipo, si desea añadir uno nuevo debe de devolver el actual</div>
                </div>
                 <form id="form_model2">
                    <div class="frmSearch col-sm-6">
                        <label for="cst" class="caption col-form-label">Buscar equipo</label>
                        <div class="">
                            <input type="hidden" name="iduser"  value="<?php echo $details['id'] ?>"></input>
                            <input type="text" class="form-control" name="cst" id="equipo-box" placeholder="Ingrese mac del equipo" autocomplete="off"/>
                            <div id="equipo-box-result"></div>
                        </div>
                    </div>
                <div class="frmSearch col-sm-6">
                    <label class="caption col-form-label">Equipo mac<span style="color: red;">*</span></label>
                    <div class="">
                        <input type="hidden" name="idequipo" id="customer_id" value="0">
                        <input type="text" class="form-control" name="mac" id="customer_name">
                    </div>
                </div>
                <div class="frmSearch col-sm-6">
                        <label for="pmethod" class="caption col-form-label">Tipo de instalacion</label>
                        <div>
                            <select id="tinstalacion" name="tinstalacion" class="form-control mb-1" onchange="validaciones_campos();">
                                <option value="null">-</option>
                                <option value="EOC">EOC</option>
                                <option value="FTTH">FTTH</option>
                            </select>
                        </div>
                </div>
                
                <div class="frmSearch col-sm-6" id="eoc_div"  >
                        <label for="pmethod" class="caption col-form-label">Master</label>
                        <div class="">
                            <input type="text" name="master" class="form-control mb-1" placeholder="master">
                        </div>
                    </div>
                    <div id="ftth_div" style="display: none;">
                    <div class="frmSearch col-sm-6">
                        <label for="pmethod" class="caption col-form-label">Vlan</label>
                        <div class="">
                            <select name="vlan" class="form-control mb-1" >
                                <option value="null">-</option>
                                <option value="101">101</option>
                                <?php for ($i=1;$i<=36;$i++){
                                echo '<option value="'.$i*'10'.'">'.$i*'10'.'</option>';
                                }?>
                            </select>
                        </div>
                    </div>
                <div class="frmSearch col-sm-6">
                        <label for="pmethod" class="caption col-form-label">Caja Nat</label>
                        <div class="">
                            <input type="text" class="form-control mb-1" name="nat" placeholder="Numero de caja NAT"></input>
                        </div>
                    </div>
            <div class="frmSearch col-sm-6">
                        <label for="pmethod" class="caption col-form-label">Puerto Nat</label>
                        <div>
                            <select name="puerto" class="form-control mb-1" onchange="funcion_status();">
                                <option value="null">-</option>
                                <?php for ($i=1;$i<=16;$i++){
                                echo '<option value="'.$i.'">'.$i.'</option>';}?>
                            </select>
                        </div>
                    </div>
                    </div>
                    <br>
                    <div style="text-align: right;">
                        <button type="button" class="btn btn-default"
                                data-dismiss="modal">Volver</button>
                        <input type="hidden" id="action-url" value="tickets/asig_equipo">
                        <button type="button" class="btn btn-primary"
                                id="submit_model2">Asignar</button>
            
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