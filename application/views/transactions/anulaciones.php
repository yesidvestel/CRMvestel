<article class="content">
    <div class="card card-block">
        <div id="notify" class="alert alert-success" style="display:none;">
            <a href="#" class="close" data-dismiss="alert">&times;</a>

            <div class="message"></div>
        </div>
        <div class="grid_3 grid_4 table-responsive animated fadeInRight">
            <h5>Transacciones Anuladas</h5>
			<a href="#" onclick="redirect_to_export()" class="btn btn-success btn-md">Exportar a Excel .XLSX</a>
            <hr>
            <table id="trans_table" class="display" cellspacing="0" width="100%">
                <thead>
                <tr>

                    <th><?php echo $this->lang->line('Date') ?></th>
                    <th><?php echo $this->lang->line('') ?>Caja</th>
                    <th><?php echo $this->lang->line('Debit') ?></th>
                    <th><?php echo $this->lang->line('Credit') ?></th>
                    <th><?php echo $this->lang->line('') ?>Usuario</th>
					<th>Cuenta</th>
                    <th><?php echo $this->lang->line('Method') ?></th>
                    <th>Estado</th>
                    <th>Observacion</th>
                    <th>Usuario Anulo</th>
                    <th><?php echo $this->lang->line('Action') ?></th>


                </tr>
                </thead>
                <tbody>
                </tbody>

                <tfoot>
                <tr>
                    <th><?php echo $this->lang->line('Date') ?></th>
                    <th><?php echo $this->lang->line('') ?>Caja</th>
                    <th><?php echo $this->lang->line('Debit') ?></th>
                    <th><?php echo $this->lang->line('Credit') ?></th>
                    <th><?php echo $this->lang->line('') ?>Usuario</th>
					<th>Cuenta</th>
                    <th><?php echo $this->lang->line('Method') ?></th>
                    <th>Estado</th>
                    <th>Observacion</th>
                    <th>Usuario Anulo</th>
                    <th><?php echo $this->lang->line('Action') ?></th>


                </tr>
                </tfoot>
            </table>
        </div>
    </div>
</article>
<script type="text/javascript">
    $(document).ready(function () {
       $('#trans_table').DataTable({
            "processing": true,
            "serverSide": true,
            "stateSave": true,
            "ajax": {
                "url": "<?php echo site_url('transactions/anullist')?>",
                "type": "POST"
            },
            "columnDefs": [
                {
                    "targets": [0],
                    "orderable": true,
                },
            ],
		   "order": [[ 2, "desc" ]],
                "language": {
                    "info": "Pagina _PAGE_ de _PAGES_ (filtrado de un total de _MAX_ registros)",
                    "infoFiltered": "(filtrado de un total de _MAX_ registros)",
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
    });
	function redirect_to_export(){
         
        var url_redirect=baseurl+'transactions/explortar_a_excel3';
            window.location.replace(url_redirect);

    }
</script>

<div id="delete_model" class="modal fade" >
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Anulacion</h4>
            </div>
            <div class="modal-body">
                <p id="texto1">¿Seguro que quieres anular esta transacción? El saldo de la cuenta se ajustará.</p>
                <div >
                    
                    <input style="cursor: pointer" id="ck2" type="radio" name="anulacion" value="Anulado de Cierre">&nbspAnulado de Cierre<br>
                    <input style="cursor: pointer" id="ck3" type="radio" name="anulacion" value="Anulado de otros Cierres">&nbspAnulado de otros Cierres<br>
                </div>
                <br>
                <div>
                    <label>Razon</label>
                    <textarea class="form-control" id="razon_anulacion" name="razon_anulacion"></textarea>
                </div>
                <br>
                <h5 id="usuario_anula">Usuario que realizo la anulacion : </h5>

            </div>
            <div class="modal-footer">
                <input type="hidden" id="object-id" value="">
                <input type="hidden" id="action-url" value="transactions/delete_i">
                <button type="button" data-dismiss="modal" class="btn btn-primary"
                        id="delete-confirm_002">Anular</button>
                <button type="button" data-dismiss="modal"
                        class="btn"><?php echo $this->lang->line('Cancel') ?></button>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    
    $("#delete-confirm_002").on("click", function() {
     var o_data = $('#object-id').val();
     var anulacion=$("input:radio[name=anulacion]:checked").val();
    var action_url= $('#action-url').val();
    var razon_anulacion= $('#razon_anulacion').val();
    
    

    $.post(baseurl+action_url,{deleteid:o_data,anulacion:anulacion,razon_anulacion:razon_anulacion},function(data){
        alert("Transferencia anulada");
        $("#estado_"+o_data).text("Anulada");
        $("#anula"+o_data).data("detalle",anulacion);
    },'json');

});


    function abrir_modal(link){
        $("#delete_model").modal("show");
        $("#object-id").val($(link).data("object-id"));
        var estado=$("#estado_"+$(link).data("object-id")).text();
        var detalle_estado=$(link).data("detalle");
        var razon_anulacion=$(link).data("razon_anulacion");
        var usuario_anula=$(link).data("usuario_anula");
        if(estado=="Anulada"){
            $("#texto1").text("Esta Transaccion ya fue anulada por...");
            if(detalle_estado=="Cobranza Efectiva"){
                    $('#ck2').prop("checked", true);
            }else if(detalle_estado=="Anulado de Cierre"){
                    $('#ck2').prop("checked", true);
            }else{
                    $('#ck3').prop("checked", true);
            }
            $("#razon_anulacion").val(razon_anulacion);
            $("#delete-confirm_002").attr("disabled",true);
            if(usuario_anula==""){
                usuario_anula="no registrado";
            }
            $("#usuario_anula").text("Usuario que realizo la anulacion : "+usuario_anula);
            $("#usuario_anula").show();
        }else{
            $("#texto1").text("¿Seguro que quieres anular esta transacción? El saldo de la cuenta se ajustará.");
            $("#razon_anulacion").val("");
            $("#usuario_anula").hide();
            $('#ck2').prop("checked", true);
            $("#delete-confirm_002").removeAttr("disabled");
        }
        

    }
</script>