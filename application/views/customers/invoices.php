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
            <a href="#part_payment" onclick="cargar_facturas()" data-toggle="modal" data-remote="false" data-type="reminder"
                                   class="btn btn-large btn-success mb-1" title="Partial Payment"
                                ><span class="icon-money"></span> <?php echo $this->lang->line('Make Payment') ?> </a>
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
                            <input type="text" class="form-control"
                                   name="shortnote" placeholder="Short note"
                                   value="Payment for invoice #<?php echo $invoice['tid'] ?>"></div>
                    </div>

                    <div class="modal-footer">
                        <input type="text" name="facturas_seleccionadas" hidden id="facturas_seleccionadas">
                        <input type="hidden" class="form-control "
                               name="tid" id="invoiceid" value="<?php echo $invoice['tid'] ?>">
                        <button type="button" class="btn btn-default"
                                data-dismiss="modal"><?php echo $this->lang->line('Close') ?></button>
                        <input type="hidden" name="cid" value="<?php echo $invoice['cid'] ?>"><input type="hidden"
                                                                                                     name="cname"
                                                                                                     value="<?php echo $invoice['name'] ?>">
                        <button type="button" class="btn btn-primary"
                                id="submitpayment2"><?php echo $this->lang->line('Make Payment'); ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php $lista_invoices=$this->db->order_by('status','DESC')->get_where('invoices')->result_array(); ?>
<?php foreach ($lista_invoices as $key => $value) {
    $customer = $this->db->get_where('customers',array('id'=>$value['csd']));
    $lista_invoices[$key]['nombres_cus']=$customer->name." ".$customer->unoapellido;
} ?>
<script type="text/javascript">
    $(document).ready(function () {
        $('#invoices').DataTable({
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
 
        

    });
   $(document).on('click', "#submitpayment2", function (e) {
    e.preventDefault();
   var pyurl=baseurl + 'transactions/payinvoicemultiple';

        payInvoice(pyurl);


});

    function filtrar_facturas(){
        datax=jQuery.parseJSON('<?php echo json_encode($lista_invoices);?>');
        var datos="";

        $(datax).each(function(index,value){
             console.log(value);
             var clase ="st-due";
             var texto ="Pendiente"
                if(value.status=="paid"){
                    clase="st-paid";
                    texto="resivido";
                }
                //falta terminar
                datos+=' <tr role="row" class="odd"><td>'+value.id+'</td><td>'+value.tid+'</td><td>'+value.nombres_cus+' </td><td>'+value.invoicedate+'</td><td><span class="st-Instalar">'+value.ron+'</span></td><td>$ '+value.total+'</td><td class="sorting_1"><span class="'+clase+'">'+texto+'</span></td><td><a href="'+baseurl+'invoices/view?id='+value.tid+'" class="btn btn-success btn-xs"><i class="icon-file-text"></i> Ver</a> &nbsp; <a href="'+baseurl+'invoices/printinvoice?id='+value.tid+'&amp;d=1" class="btn btn-info btn-xs" title="Download"><span class="icon-download"></span></a>&nbsp; &nbsp;<a href="#" data-object-id="'+value.id+'" class="btn btn-danger btn-xs delete-object"><span class="icon-trash"></span></a></td><td><input type="checkbox" name="x" class="form-check-input facturas_para_pagar" data-status="'+value.status+'" data-total="'+value.total+'" data-idfacturas="'+value.tid+'" style="cursor:pointer"></td></tr> '
        });
        var table = $('#tbody1').html(datos);
        
    }

    var total_facturas="<?=$due['total']-$due['pamnt']?>";
   
    function cargar_facturas(){
        console.log("asd");
        $("#facturas_seleccionadas").val("");
        var total = 0;
        var x="";
        $(".facturas_para_pagar:checked").each(function(index){
            x= $("#facturas_seleccionadas").val();
            total+=parseInt($(this).data('total'));
            if(x==""){
                    x+=$(this).data('idfacturas');
            }else{
                    x+="-"+$(this).data('idfacturas');
            }
            $("#facturas_seleccionadas").val(x);             
        });  
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
    
</script>
