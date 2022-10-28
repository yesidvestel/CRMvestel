<style type="text/css">
    
/*[data-title]:hover:after {
    opacity: 1;
    transition: all 0.1s ease 0.5s;
    visibility: visible;

}

[data-title]:after {
    content: attr(data-title);
    background-color: #333;
    color: #fff;
    font-size: 14px;
    font-family: Raleway;
    position: initial;
    padding: 3px 20px;
    bottom: -1.6em;
    left: 100%;
    white-space: nowrap;
    box-shadow: 1px 1px 3px #222222;
    opacity: 0;
    border: 1px solid #111111;
    z-index: 99999;
    visibility: hidden;
    border-radius: 6px;
    
}
[data-title] {
    position: relative;

}*/
.facturas_para_pagar:hover{
     transform: scale(3);
}
</style>
<article class="content">
    <div class="card card-block">
        <div id="notify" class="alert alert-success" style="display:none;">
            <a href="#" class="close" data-dismiss="alert">&times;</a>

            <div class="message"></div>
        </div>
        <div class="grid_3 grid_4 animated fadeInRight table-responsive">
            <h5><?php echo $this->lang->line('Invoices') ?></h5>

            <hr>
            <div class="card card-block">
                <h4><?php echo $this->lang->line('Customer') ?></h4>
                <hr>
                <div class="row m-t-lg">
                    <div class="col-md-1">
                        <strong><?php echo $this->lang->line('Name') ?></strong>
                    </div>
                    <div class="col-md-10">
                        <?php echo $details['name'] ?>
                    </div>

                </div>
                <div class="row m-t-lg">
                    <div class="col-md-1">
                        <strong>Email</strong>
                    </div>
                    <div class="col-md-10">
                        <?php echo $details['email'] ?>
                    </div>

                </div>
                <div class="row m-t-lg">
                	<div class="col-md-1">
                    <strong>TOTAL</strong>
                    </div>
                    <div class="col-md-10" id="total_text">
                    <?php echo amountFormat(($due['total']-$due['pamnt'])) ?>
                    </div>
                </div>
            </div>
            <a href="#part_payment" onclick="cargar_facturas()" data-toggle="modal" data-remote="false" data-type="reminder" class="btn btn-large btn-success" title="Partial Payment">
				<span class="icon-money"></span> <?php echo $this->lang->line('Make Payment') ?> </a><span id="span_facturas">&nbsp;Facturas a pagar</span>
            <?php if ($this->aauth->get_user()->roleid > 3) { ?>
			<a href="#" id="btn-notas-debit-credit" class="btn btn-warning"><i class="icon-minus"></i>Notas Debito, <i class="icon-plus"></i>Notas Credito</a>
			<?php }; ?>
			<a href="#" class="btn btn-primary" onclick="filtrar_facturas()">Filtrar Facturas Sin Pagar</a>              
			<a href="<?=base_url().'invoices/ver_estado_de_cuenta_user?id='.$_GET['id'] ?>" class="btn btn-primary">Estado de cuenta</a>
			
            <hr>

            <table id="invoices" class="table-striped" cellspacing="0" width="100%">
                <thead>
                <tr>
					<th><i class="icon-marquee"></i></th>
                    <th>No</th>
                    <th><?php echo $this->lang->line('Invoice') ?>#</th>
                    <th><?php echo $this->lang->line('') ?>Tipo</th>
                    <th><?php echo $this->lang->line('Date') ?></th>
                    <th><?php echo $this->lang->line('') ?>Estado</th>
                    <th><?php echo $this->lang->line('Total') ?></th>
                    <th class="no-sort"><?php echo $this->lang->line('') ?>Pago</th>
					<th class="no-sort"><?php echo $this->lang->line('Settings') ?></th>
					<?php if ($this->aauth->get_user()->roleid == 5) { ?>
                    <th class="no-sort">Admin</th>
                    <?php } ?>


                </tr>
                </thead>
                <tbody id="tbody1"> 
                </tbody>

                <tfoot>
                <tr>
					<th ><i class="icon-marquee"></i></th>
                    <th>No</th>
                    <th><?php echo $this->lang->line('Invoice') ?>#</th>
                    <th><?php echo $this->lang->line('') ?>Tipo</th>
                    <th><?php echo $this->lang->line('Date') ?></th>
                    <th><?php echo $this->lang->line('') ?>Estado</th>
                    <th><?php echo $this->lang->line('Total') ?></th>
                    <th class="no-sort"><?php echo $this->lang->line('') ?>Pago</th>
					<th class="no-sort"><?php echo $this->lang->line('Settings') ?></th>
					<?php if ($this->aauth->get_user()->roleid == 5) { ?>
                    <th class="no-sort">Admin</th>
					<?php } ?>
                </tr>
                </tfoot>
            </table>
        </div>
    </div>


</article>
<div id="delete_model" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><?php echo $this->lang->line('Delete Invoice') ?></h4>
            </div>
            <div class="modal-body">
                <p><?php echo $this->lang->line('You can not revert') ?></p>
            </div>
            <div class="modal-footer">
                <input type="hidden" id="object-id" value="">
                <input type="hidden" id="action-url" value="invoices/delete_i">
                <button type="button" data-dismiss="modal" class="btn btn-primary"
                        id="delete-confirm"><?php echo $this->lang->line('Delete') ?></button>
                <button type="button" data-dismiss="modal"
                        class="btn"><?php echo $this->lang->line('Cancel') ?></button>
            </div>
        </div>
    </div>
</div>
<!--pago-->
<div id="part_payment" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"><?php echo $this->lang->line('Payment Confirmation') ?></h4>
            </div>

            <div class="modal-body">
                <form class="payment">
                    <div class="row">
                        <div class="col-xs-6">
                            <div class="input-group">
                                <div class="input-group-addon"><?php echo $this->config->item('currency') ?></div>
                                <input type="text" class="form-control" placeholder="Total Amount" name="amount"
                                       id="rmpay" value="<?php echo $due['total']-$due['pamnt'] ?>">
                            </div>

                        </div>
                        <div class="col-xs-6">
                            <div class="input-group">
                                <div class="input-group-addon"><span class="icon-calendar4"
                                                                     aria-hidden="true"></span></div>
                                <input type="text" class="form-control required"
                                       placeholder="Billing Date" name="paydate"
                                       data-toggle="datepicker">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xs-12 mb-1"><label
                                    for="pmethod"><?php echo $this->lang->line('Payment Method') ?></label>
                            <select name="pmethod" class="form-control mb-1" onchange="metodo_de_pago_select()" id="select_metodo_de_pago">
                                <option value="Cash"><?php echo $this->lang->line('Cash') ?></option>
                                <option value="Card"><?php echo $this->lang->line('Card') ?></option>
                                <option value="Balance"><?php echo $this->lang->line('Client Balance') ?></option>
                                <option value="Bank"><?php echo $this->lang->line('Bank') ?></option>
                            </select>
                            <div id="seleccion_banco" style="text-align: center;">
                                <input type="radio" name="banco" value="Bancolombia" style="cursor: pointer;" checked>&nbspBancolombia
                                <input type="radio" name="banco" value="BBVA colombia" style="cursor: pointer;">&nbspBBVA colombia
                            </div>
                            <label for="account"><?php echo $this->lang->line('Account') ?></label>

                            <select name="account" class="form-control">
                                <?php foreach ($acclist as $row) {
                                    echo '<option value="' . $row['id'] . '">' . $row['holder'] . ' / ' . $row['acn'] . '</option>';
                                }
                                ?>
								
                            </select></div>
                    </div>
                    <div class="row">						
                        <div class="col-xs-12 mb-1"><label
                                    for="shortnote"><?php echo $this->lang->line('Note') ?></label>
                            <input id="in_shortnote" type="text" class="form-control"
                                   name="shortnote" placeholder="Short note"
                                   value="Pago de factura # <?=$facturas_seleccionadas?><?php echo $details['name'].' '.$details['unoapellido'].' '.$details['documento']?>">
						
                    </div>
                    </div>
                        <div id="div_reconexion_cortados"  >
                    <div class="row">
                        <div class="col-xs-12 mb-1"><label
                                    for="shortnote">Generar Reconexion</label>
                             <select name="reconexion" id="reconexion" class="form-control mb-1" onchange="visualizar_div_asociadas()">
                                <option value="no">No</option>
                                <option value="si">Si</option>
                            </select></div>
                    </div>
                    <div class="row" id="div_facturas_asociadas">
                        <div class="col-xs-12 mb-1"><label
                                    for="shortnote">Factura de Corte Asociada</label>
                             <select id="factura_asociada" name="factura_asociada" class="form-control mb-1">
                                
                            </select></div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 mb-1"><label
                                    for="shortnote">Tipo de reconexion</label>
                             <select name="tipo" class="form-control mb-1">
                                <option value="Reconexion Combo">TV + Internet</option>
                                <option value="Reconexion Internet">Internet</option>
                                <option value="Reconexion Television">Television</option> 
                            </select></div>
                    </div>
                    <!--<div class="row">
                        
                        <div class="col-xs-12 mb-1" id="div_yopal_monterrey"><label
                                    for="shortnote">Paquete</label>
                             <select name="paquete_yopal_monterrey" class="form-control mb-1">
                                <option value="no">No</option>
                                <?php
									/*foreach ($paquete as $row) {
										$cid = $row['pid'];
										$title = $row['product_name'];
										echo "<option value='$title'>$title</option>";
									}*/
								?>
                            </select></div>
                        
                        <div class="col-xs-12 mb-1" id="div_villanueva"><label
                                    for="shortnote">Paquete</label>
                             <select name="paquete_villanueva" class="form-control mb-1">
                                <option value="no">No villanueva</option>
                                <option value="1Mega">1Mega</option>                                
                                <option value="3MegasV">3Megas</option>
                                <option value="5MegasV">5Megas</option>
                                <option value="5MegasVD">5MegasD</option>
                                <option value="10MegasV">10Megas</option>
                            </select></div>
                    </div>-->
                    
                    </div>
                    
                

                    <div class="modal-footer">
                        <input type="text" name="facturas_seleccionadas" hidden id="facturas_seleccionadas">
                        <input type="hidden" class="form-control "
                               name="tid" id="invoiceid" value="<?php echo $invoice['tid'] ?>">
                        <button type="button" class="btn btn-default"
                                data-dismiss="modal"><?php echo $this->lang->line('Close') ?></button>
                        <input type="hidden" name="cid" value="<?php echo $invoice['cid'] ?>"><input type="hidden" name="cname" value="<?php echo $invoice['name'] ?>">
                        <button type="button" class="btn btn-primary"
                                id="submitpayment2"><?php echo $this->lang->line('Make Payment'); ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div id="modal_resivos_de_pago" class="modal fade">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                <h3 align="center" id="titulo_modal">Resivos de la factura para eliminar</h3>
                
            </div>
            <div class="modal-body">
                
                
                    <div class="table-responsive">
                        <table id="tb_resivos_de_pago" class="table table-hover" cellspacing="0" width="100%" >
                            <thead>
                            <tr>
                                <th>#</th>                  
                                <th>Fecha</th> 
                                <th>Vista Previa</th>     
                                <th>Nombre</th>
                                <th>Transacciones</th>
                                <th>Acciones</th>
                                
                                

                            </tr>
                            </thead>
                            <tbody>
                            
                            </tbody>
                            <tfoot>
                                <th>#</th>                  
                                <th>Fecha</th> 
                                <th>Vista Previa</th>   
                                <th>Nombre</th>
                                <th>Transacciones</th>
                                <th>Acciones</th>
                            </tfoot>

                        </table>
                    </div>
                    
                
                <br>
            </div>
            
            <div class="modal-footer">
                
                
                <button type="button" class="btn btn-primary" onclick="$('#modal_resivos_de_pago').modal('hide');">Aceptar</button>
                
            </div>
        </div>
    </div>
</div>


<div id="modal_notas_debito_credito" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                <h3 align="center" id="titulo_modal">Crear Nota Credito o Debito</h3>
                
            </div>
            <div class="modal-body">
                <div class="row">
                        <div class="col-xs-12"><label
                                    for="shortnote">Tipo Nota</label>
                             <select name="tipo_nota" id="tipo_nota" class="form-control" onchange="tipo_nota_change()">
                                <option value="Nota Credito">Nota Credito</option>
                                <option value="Nota Debito">Nota Debito</option>
                            </select></div>
                        
                </div>
                <p><small id="info">Nota credito se utiliza para realizar descuentos a las facturas</small></p>
                 <div class="row">
                        <div class="col-xs-12"><label
                                    for="shortnote">Razón</label>
                             <textarea name="descripcion_nota" id="descripcion_nota" class="form-control"></textarea>
                        </div>
                        
                </div><br>
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="input-group">

                                <div class="input-group-addon"><?php echo $this->config->item('currency') ?></div>
                                <input  type="text" class="form-control" placeholder="Total Amount" name="monto_notas"
                                       id="monto_notas" value="0">
                            </div>

                        </div>
                        
                    </div>
                    
                   

                
                <br>
            </div>
            
            <div class="modal-footer">
                
                <button type="button" class="btn btn-default" onclick="$('#modal_notas_debito_credito').modal('hide');">Cerrar</button>
                <button type="button" class="btn btn-primary" id="id_guardar_notas" onclick="guardar_notas()">Guardar</button>
                
            </div>
        </div>
    </div>
</div>
<?php /*
    $lista_invoices=$this->db->order_by('status','DESC')->get_where('invoices')->result_array();
    foreach ($lista_invoices as $key => $value) {
        $customer = $this->db->get_where('customers',array('id'=>$value['csd']));
        $lista_invoices[$key]['nombres_cus']=$customer->name." ".$customer->unoapellido;
    } 
    */
    //quito esto porque esta generando error y no se porque esta no le veo la logica
?>
<script type="text/javascript">
    var tid_invoice_trabajado=0;
    function eliminiar_resivos_de_pago(tid_invoice){
        $("#titulo_modal").text("Recibos de la factura #"+tid_invoice+" para eliminar");
        $("#modal_resivos_de_pago").modal("show");
        tid_invoice_trabajado=tid_invoice;
        tb_resivos_de_pago.ajax.url( baseurl+'invoices/lista_resivos_tb?tid='+tid_invoice).load();     
    }
    var desabilitar=false;
    var tb,tb_resivos_de_pago;
    var fac_pagadas="<?= (isset($ultimo_resivo)) ? $ultimo_resivo : '' ?>";
    var id_customer="<?=$_GET['id']?>";
    $(document).ready(function () {
        $("#div_reconexion_cortados").hide();
        $("#div_facturas_asociadas").hide();
       tb= $('#invoices').DataTable({
            'processing': true,
            'serverSide': true,
            'stateSave': true,
            'order': [],
            'ajax': {
                'url': "<?php echo site_url('customers/inv_list')?>",				
                'type': 'POST',
                'data': {'cid':<?php echo $_GET['id'] ?> }
            },
            'columnDefs': [
                {
                    'targets': [0],
                    'orderable': false,
                },
            ],
        });

        if(fac_pagadas!=""){
            var link="<a href='"+baseurl+"invoices/printinvoice2?file_name="+fac_pagadas+"' class='btn btn-info btn-lg' target='_blank'><span class='icon-file-text2' aria-hidden='true'></span>Ver PDF Facturas Pagadas</a>";
            $("#notify .message").html("<strong>" + "Success" + "</strong>: " + " "+link);
            $("#notify").removeClass("alert-danger").addClass("alert-success").fadeIn();
            $("html, body").scrollTop($("body").offset().top);
        }
        tb_resivos_de_pago= $('#tb_resivos_de_pago').DataTable({
            'processing': true,
            'serverSide': true,
            'stateSave': true,
            'order': [],
            'ajax': {
                'url': "<?php echo site_url('invoices/lista_resivos_tb')?>",               
                'type': 'POST',
            },
            'columnDefs': [
                {
                    'targets': [0],
                    'orderable': false,
                },
            ],
        });    

    });
   $(document).on('click', "#submitpayment2", function (e) {
    e.preventDefault();
   var pyurl=baseurl + 'transactions/payinvoicemultiple';
        $("#submitpayment2").attr("disabled",true);
        
        desabilitar=true;
        payInvoice(pyurl);


});
$("#invoices").on('draw.dt',function (){
        $("#id-ultima-factura").click(function(ev){
    ev.preventDefault();
    console.log("asd");
    $("#id-ultima-factura").hide();
    $("#ck-ultima-fac").show();
});

    });
   $("#tb_resivos_de_pago").on('draw.dt',function (){
        $(".eliminar_resivo").click(function(e){
            e.preventDefault();
            var file_name=$(this).data("file-name");
            console.log(file_name);
                var x=confirm("¿estas seguro de eliminar el recibo?");
                if(x==true){
                    $.post(baseurl+"invoices/eliminar_resivos_de_pago?file_name="+file_name,{id_customer:id_customer},function(data){
                        $("#total_text").text(data.total);
                        tb_resivos_de_pago.ajax.url( baseurl+'invoices/lista_resivos_tb?tid='+tid_invoice_trabajado).load();     
                        tb.ajax.url( baseurl+'customers/inv_list?cid='+id_customer).load();     
                    },'json');    
                }
                
            });

    });

function visualizar_div_asociadas(){
    if($("#reconexion option:selected").val()=="si"){
        $("#div_facturas_asociadas").show();
    }else{
        $("#div_facturas_asociadas").hide();
    }
}

    function filtrar_facturas(){
       
        tb.ajax.url( baseurl+'customers/inv_list?cid=<?php echo $_GET['id'] ?>&filtrar=si').load();     
    }

    var total_facturas="<?=$due['total']-$due['pamnt']?>";
   var id_ultima_factura=0;
    function cargar_facturas(){
        
        $("#facturas_seleccionadas").val("");
        var total = 0;
        var x="";
        var cortados=false;
        var refer="yopal";
        $("#div_facturas_asociadas").find("option").remove();
        var agregar="";

        $(".facturas_para_pagar:checked").each(function(index){            
            total+=parseInt($(this).data('total'));            
            if($(this).data("ron")=="cortado" ||$(this).data("rec")=="1"){
                cortados=true;
                refer=$(this).data("refer");
                id_ultima_factura=$(this).data("id-ultima-factura");
                var idfact=$(this).data("idfacturas");
                if(id_ultima_factura!=idfact){
                    agregar+="<option value='"+idfact+"'>"+idfact+"</option>";
                }
                
            }
        });
        agregar="<option value='"+id_ultima_factura+"'>"+id_ultima_factura+"</option>"+agregar;
        $("#factura_asociada").append(agregar);
        $(lista_facturas).each(function(index){
            if(x==""){
                x=this;
            }else{
                x+="-"+this;
            }
        });

        if(cortados==true){
            $("#div_reconexion_cortados").show();
            visualizar_div_asociadas();
            if(refer=="villanueva"){
                    $("#div_yopal_monterrey").hide();
                    $("#div_villanueva").show();
            }else{
                $("#div_yopal_monterrey").show();
                $("#div_villanueva").hide();
            }
            
        }else{
            $("#div_reconexion_cortados").hide();
            $("#reconexion").val("no");
        }
        $("#facturas_seleccionadas").val(x);
        
        if(x==""){
            $("#rmpay").val("0");
            $("#submitpayment2").attr("disabled",true);
        }else{
            $("#rmpay").val(total);
            if(desabilitar==false){
                $("#submitpayment2").removeAttr("disabled");
            }
            
        }
        

    }


$("#seleccion_banco").hide();
    function metodo_de_pago_select(){
        if($("#select_metodo_de_pago option:selected").val()=="Bank"){
            $("#seleccion_banco").show();
        }else{
            $("#seleccion_banco").hide();
        }
    }

let lista_facturas=[];
 function agregar_factura(elemento){
        var indice_elemento=lista_facturas.indexOf($(elemento).data("idfacturas"));
        
        if(indice_elemento==-1){
                if(elemento.checked==true){
                    lista_facturas.push($(elemento).data("idfacturas"));                   
                }
        }else{
            if(elemento.checked==false){
                lista_facturas.splice(indice_elemento,1);
            }
        }
       var y="";
        $(lista_facturas).each(function(index){
            if(y==""){
                y=this;
            }else{
                y+=","+this;
            }
        });
        if(y==""){
            $("#span_facturas").hide();
        }else{
            $("#span_facturas").text(" Orden Facturas a Pagar : "+y);
            $("#span_facturas").show();
            $("#in_shortnote").val("Pago de la factura #"+y);
        }
        
    }
    $("#span_facturas").hide();
    //js para notacreditos
    var total2=0;
    $("#btn-notas-debit-credit").click(function(e){
        e.preventDefault();
        $("#modal_notas_debito_credito").modal("show");
        if(lista_facturas.length==0){
            $("#id_guardar_notas").attr("disabled",true);
        }else{
            $("#id_guardar_notas").attr("disabled",false);
        }
         total2=0;

        $(".facturas_para_pagar:checked").each(function(index){            
            total2+=parseInt($(this).data('total'));            
        });
        $("#monto_notas").val(total2);
        $("#descripcion_nota").val("");
        validar_monto_notas();
    });
    tipo_nota_change();
    function tipo_nota_change(){
        var seleccionada=$("#tipo_nota option:selected").val();
        if(seleccionada=="Nota Credito"){
            $("#info").html("Nota <span style='color:red'>Credito</span> se utiliza para realizar <span style='color:red'>descuentos</span> a las facturas");
        }else{
            $("#info").html("Nota <span style='color:blue'>Debito</span> se utiliza para realizar <span style='color:blue'>aumentos</span> a las facturas");
        }
validar_monto_notas();
    }
    var guardar_notas_b=true;

    $("#monto_notas").keyup(function(){
        validar_monto_notas();
    });
   function validar_monto_notas(){
        var seleccionada=$("#tipo_nota option:selected").val();
        var x=parseInt($("#monto_notas").val());
        //desabilitar si x =0;
        if(seleccionada=="Nota Credito"){
            
            if(x<0){
                x=Math.abs(x);
            }

            if(x>total2 || x==0){
                $("#id_guardar_notas").attr("disabled",true);                
            }else{
                $("#id_guardar_notas").attr("disabled",false);            
            }
            
        }else{
            if(x==0){
                $("#id_guardar_notas").attr("disabled",true);
            }else{
                $("#id_guardar_notas").attr("disabled",false);
            }
            
        }
    }
    function guardar_notas(){
        var nota_seleccionada=$("#tipo_nota option:selected").val();
        var valor_nota=parseInt($("#monto_notas").val());
        var des_nota=$("#descripcion_nota").val();
        if(valor_nota<0){
                valor_nota=Math.abs(valor_nota);
        }
        $("#id_guardar_notas").attr("disabled",true);
        $.post(baseurl+"invoices/crear_nota_debito_credito",{nota_seleccionada:nota_seleccionada,valor_nota:valor_nota,des_nota:des_nota,'lista':lista_facturas,id_customer:id_customer},function(data){
            console.log(data);
            if(data.status=="realizado"){
                 $("#notify .message").html("<strong>Success : </strong>: Cambios realizados");
                    $("#notify").removeClass("alert-danger").addClass("alert-success").fadeIn();
                    $("html, body").scrollTop($("body").offset().top);                    
                    $("#total_text").text(data.total);
                    $("#modal_notas_debito_credito").modal("hide");
                    tb.ajax.url( baseurl+'customers/inv_list?cid='+id_customer).load();
                    lista_facturas=[];     
            }
        },'json');
        //falta obtener datos, conectar al servidor, realizar los calculos, guardar y refrescar tablas 
    }

</script>
