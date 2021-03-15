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
                    <div class="col-md-10">
                    <?php echo amountFormat($due['total']-$due['pamnt']) ?>
                    </div>
                </div>
            </div>
            <a href="#part_payment" onclick="cargar_facturas()" data-toggle="modal" data-remote="false" data-type="reminder" class="btn btn-large btn-success mb-1" title="Partial Payment">
				<span class="icon-money"></span> <?php echo $this->lang->line('Make Payment') ?> </a><span id="span_facturas">&nbsp;Facturas a pagar</span>
                <br><a href="#" class="btn btn-primary" onclick="filtrar_facturas()">Filtrar Facturas Sin Pagar</a>

            <hr>

            <table id="invoices" class="table-striped" cellspacing="0" width="100%">
                <thead>
                <tr>
					<th><i class="icon-marquee"></i></th>
                    <th>No</th>
                    <th><?php echo $this->lang->line('Invoice') ?>#</th>
                    <th><?php echo $this->lang->line('Customer') ?></th>
                    <th><?php echo $this->lang->line('Date') ?></th>
                    <th><?php echo $this->lang->line('') ?>Estado</th>
                    <th><?php echo $this->lang->line('Total') ?></th>
                    <th class="no-sort"><?php echo $this->lang->line('Status') ?></th>
                    <th class="no-sort"><?php echo $this->lang->line('Settings') ?></th>
                    


                </tr>
                </thead>
                <tbody id="tbody1"> 
                </tbody>

                <tfoot>
                <tr>
					<th ><i class="icon-marquee"></i></th>
                    <th>No</th>
                    <th><?php echo $this->lang->line('Invoice') ?>#</th>
                    <th><?php echo $this->lang->line('Customer') ?></th>
                    <th><?php echo $this->lang->line('Date') ?></th>
                    <th><?php echo $this->lang->line('') ?>Estado</th>
                    <th><?php echo $this->lang->line('Total') ?></th>
                    <th class="no-sort"><?php echo $this->lang->line('Status') ?></th>
                    <th class="no-sort"><?php echo $this->lang->line('Settings') ?></th>

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
    var tb;
    var fac_pagadas="<?= (isset($_GET['fac_pag'])) ? $_GET['fac_pag'] : '' ?>";
    var id_customer="<?=$_GET['id']?>";
    $(document).ready(function () {
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
            var link="<a href='"+baseurl+"invoices/printinvoice?id="+fac_pagadas+"' class='btn btn-info btn-lg' target='_blank'><span class='icon-file-text2' aria-hidden='true'></span>Ver PDF Facturas Pagadas</a>";
            $("#notify .message").html("<strong>" + "Success" + "</strong>: " + " "+link);
            $("#notify").removeClass("alert-danger").addClass("alert-success").fadeIn();
            $("html, body").scrollTop($("body").offset().top);
        }
        

    });
   $(document).on('click', "#submitpayment2", function (e) {
    e.preventDefault();
   var pyurl=baseurl + 'transactions/payinvoicemultiple';

        payInvoice(pyurl);


});

    function filtrar_facturas(){
       
        tb.ajax.url( baseurl+'customers/inv_list?cid=<?php echo $_GET['id'] ?>&filtrar=si').load();     
    }

    var total_facturas="<?=$due['total']-$due['pamnt']?>";
   
    function cargar_facturas(){
        
        $("#facturas_seleccionadas").val("");
        var total = 0;
        var x="";
        $(".facturas_para_pagar:checked").each(function(index){            
            total+=parseInt($(this).data('total'));            
        });

        $(lista_facturas).each(function(index){
            if(x==""){
                x=this;
            }else{
                x+="-"+this;
            }
        });
        $("#facturas_seleccionadas").val(x);
        
        if(x==""){
            $("#rmpay").val("0");
            $("#submitpayment2").attr("disabled",true);
        }else{
            $("#rmpay").val(total);
            $("#submitpayment2").removeAttr("disabled");
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
    
</script>
