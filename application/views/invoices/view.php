<style type="text/css">
    .sts-Cortado
{
 color: #A4282A;
}
.sts-Suspendido
{
 color: #2224A3;
}
</style>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-cookie/1.4.1/jquery.cookie.min.js"></script>
<div class="app-content content container-fluid">
    <div class="content-wrapper">
        <div id="notify" class="alert alert-success" style="display:none;">
            <a href="#" class="close" data-dismiss="alert">&times;</a>

            <div class="message"></div>
        </div>

        <div class="content-body">
            <section class="card">
                <div id="invoice-template" class="card-block">
                    <div class="row wrapper white-bg page-heading">

                        <div class="col-lg-12">
                            <?php
                            $validtoken = hash_hmac('ripemd160', $invoice['tid'], $this->config->item('encryption_key'));

                            $link = base_url('billing/view?id=' . $invoice['tid'] . '&token=' . $validtoken);
                            if ($invoice['status'] != 'canceled') { ?>
                                <div class="title-action">
								<?php if ($this->aauth->get_user()->roleid == 5 || $this->aauth->get_user()->coape != null) { ?>
                                <a href="<?php echo 'edit?id=' . $invoice['tid']; ?>" class="btn btn-warning mb-1"><i
                                            class="icon-pencil"></i> <?php echo $this->lang->line('Edit Invoice') ?></a>

                                <a href="#part_payment" data-toggle="modal" data-remote="false" data-type="reminder"
                                   class="btn btn-large btn-success mb-1" title="Partial Payment"
                                ><span class="icon-money"></span> <?php echo $this->lang->line('Make Payment') ?> </a>
								
                                <div class="btn-group">
                                    <button type="button" class="btn btn-primary dropdown-toggle mb-1"
                                            data-toggle="dropdown"
                                            aria-haspopup="true" aria-expanded="false">
                            <span
                                    class="icon-envelope-o"></span> Email
                                    </button>
                                    <div class="dropdown-menu"><a href="#sendEmail" data-toggle="modal"
                                                                  data-remote="false" class="dropdown-item sendbill"
                                                                  data-type="notification"><?php echo $this->lang->line('Invoice Notification') ?></a>
                                        <div class="dropdown-divider"></div>
                                        <a href="#sendEmail" data-toggle="modal" data-remote="false"
                                           class="dropdown-item sendbill"
                                           data-type="reminder"><?php echo $this->lang->line('Payment Reminder') ?></a>
                                        <a
                                                href="#sendEmail" data-toggle="modal" data-remote="false"
                                                class="dropdown-item sendbill"
                                                data-type="received"><?php echo $this->lang->line('Payment Received') ?></a>
                                        <div class="dropdown-divider"></div>
                                        <a href="#sendEmail" data-toggle="modal" data-remote="false"
                                           class="dropdown-item sendbill" href="#"
                                           data-type="overdue"><?php echo $this->lang->line('Payment Overdue') ?></a><a
                                                href="#sendEmail" data-toggle="modal" data-remote="false"
                                                class="dropdown-item sendbill"
                                                data-type="refund"><?php echo $this->lang->line('Refund Generated') ?></a>

                                    </div>

                                </div>
								
                                <!-- SMS -->

                                <a href="#" id="open_modal_sms" 
                                   class="btn btn-info mb-1" 
                                ><span class="icon-envelope-o"></span> SMS</a>

                                <div class="btn-group ">
                                    <button type="button" class="btn btn-success mb-1 btn-min-width dropdown-toggle"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i
                                                class="icon-print"></i> <?php echo $this->lang->line('Print') ?>
                                    </button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item"
                                           href="<?php echo 'printinvoice?id=' . $invoice['tid']; ?>"><?php echo $this->lang->line('Print') ?></a>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item"
                                           href="<?php echo 'printinvoice?id=' . $invoice['tid']; ?>&d=1"><?php echo $this->lang->line('PDF Download') ?></a>

                                    </div>
                                </div>
                                <a href="<?php echo $link; ?>" class="btn btn-brown mb-1"><i
                                            class="icon-earth"></i> <?php echo $this->lang->line('Preview') ?>
                                </a>
								<?php } if ($this->aauth->get_user()->co != null) { ?>
                                <a href="#pop_model" data-toggle="modal" data-remote="false"
                                   class="btn btn-large btn-cyan mb-1" title="Change Status"
                                ><span class="icon-tab"></span> <?php echo $this->lang->line('Change Status') ?></a>
									<a href="#cancel-bill" class="btn btn-danger mb-1" id="cancel-bill"><i
                                            class="icon-minus-circle"> </i> <?php echo $this->lang->line('') ?>Anular
                                </a>
								<?php } if ($this->aauth->get_user()->id == 20 || $this->aauth->get_user()->roleid == 5 || $this->aauth->get_user()->id == 96 || $this->aauth->get_user()->id == 89  || $this->aauth->get_user()->co != null) { ?>
                                <a href="#pop_model2" data-toggle="modal" data-remote="false"
                                   class="btn btn-large btn-orange mb-1" title="Change Status"
                                ><span class="icon-tab"></span> <?php echo $invoice['ron'] ?> </a>
								<?php } ?>
                                      <div class="btn-group ">
                                    <button type="button" class="btn btn-primary mb-1 btn-min-width dropdown-toggle"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i
                                                class="icon-anchor"></i> <?php echo $this->lang->line('Extra') ?>
                                    </button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item"
                                           href="<?php echo 'delivery?id=' . $invoice['tid']; ?>"><?php echo $this->lang->line('Delivery Note') ?></a>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item"
                                           href="<?php echo 'proforma?id=' . $invoice['tid']; ?>"><?php echo $this->lang->line('Proforma Invoice') ?></a>

										    <a class="dropdown-item"
                                           href="<?php echo 'duplicate?id=' . $invoice['tid']; ?>">Copy <?php echo $this->lang->line('Invoice') ?></a>

                                    </div>
                                </div>




                                </div><?php if ($invoice['multi'] > 0) {

                                    echo '<div class="tag tag-info text-xs-center mt-2">' . $this->lang->line('Payment currency is different') . '</div>';
                                }
                            } else {
                                echo '<h2 class="btn btn-oval btn-danger">' . $this->lang->line('Cancelled') . '</h2>';
                            } ?>
                        </div>
                    </div>

                    <!-- Invoice Company Details -->
                    <div id="invoice-company-details" class="row mt-2">
                        <div class="col-md-6 col-sm-12 text-xs-center text-md-left"><p></p>
                            <img src="<?php echo base_url('userfiles/company/' . $this->config->item('logo')) ?>"
                                 class="img-responsive p-1 m-b-2" style="max-height: 180px;">

                        </div>
                        <div class="col-md-6 col-sm-12 text-xs-center text-md-right">
                            <h2 ><?php echo $this->lang->line('') ?>Estado de Cuenta</h2>
                            <ul class="pb-1"> <?php echo $this->config->item('prefix') . ' #' . $invoice['tid'] . '</p>
                            <ul class="pb-1">Sede: ' . $invoice['refer'] . '</p>'; ?>
                            <ul class="px-0 list-unstyled">
                                <li><?php echo $this->lang->line('Gross Amount') ?></li>
                                <li class="lead text-bold-800"><?php echo amountFormat($invoice['total']) ?></li>
                            </ul>
                        </div>
                    </div>
                    <!--/ Invoice Company Details -->

                    <!-- Invoice Customer Details -->
                    <div id="invoice-customer-details" class="row">
                        <div class="col-sm-12 text-xs-center text-md-left">
                            <p class="text-muted"><?php echo $this->lang->line('Bill To') ?>:</p>
                        </div>
                        <div class="col-md-6 col-sm-12 text-xs-center text-md-left">
                            <ul class="px-0 list-unstyled">


                                <li class="text-bold-800"><a
                                            href="<?php echo base_url('customers/view?id=' . $invoice['cid']) ?>"><strong
                                                class="invoice_a"><?php echo ucwords($invoice['name']) .' '.ucwords($invoice['unoapellido']).'</strong></a></li><li>' .$invoice['tipo_documento'].': '. $invoice['documento'] .  '</li><li>Celular: ' . $invoice['celular'] . '</li><li>'.$this->lang->line('Email') .': ' . $invoice['email'];
                                    if ($invoice['taxid']) echo '</li><li>' . $this->lang->line('Tax') . ' ID: ' . $invoice['taxid']
                                                ?>
                                </li>
                            </ul>

                        </div>
                        <div class="offset-md-3 col-md-3 col-sm-12 text-xs-center text-md-left">
                            <?php echo '<p><span class="text-muted">'.$this->lang->line('Invoice Date').'  :</span> ' . dateformat($invoice['invoicedate']) . '</p> <p><span class="text-muted">'.$this->lang->line('Due Date').' :</span> ' . dateformat($invoice['invoiceduedate']) . '</p>  <p><span class="text-muted">'.$this->lang->line('Terms').' :</span> ' . $invoice['termtit'] . '</p>';
                            ?>
                        </div>
                    </div>
                    <!--/ Invoice Customer Details -->

                    <!-- Invoice Items Details -->
                    <div id="invoice-items-details" class="pt-2">
                        <div class="row">
                            <div class="table-responsive col-sm-12">
                                <table class="table table-striped">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th><?php echo $this->lang->line('Description') ?></th>
                                        <th class="text-xs-left"><?php echo $this->lang->line('Rate') ?></th>
                                        <th class="text-xs-left"><?php echo $this->lang->line('Qty') ?></th>
                                        <th class="text-xs-left"><?php echo $this->lang->line('Tax') ?></th>
                                        <th class="text-xs-left"><?php echo $this->lang->line('Discount') ?></th>
                                        <th class="text-xs-left"><?php echo $this->lang->line('Amount') ?></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php $c = 1;
                                    $sub_t = 0;
                                    foreach ($products as $row) {
                                        $sub_t += $row['price'] * $row['qty'];
                                        if($row['tipo_retencion']!=null){
                                            $row['product'].=" - ".$row['tipo_retencion'];             
                                        }
                                        echo '<tr>
<th scope="row">' . $c . '</th>
                            <td>' . $row['product'] . '</td>
                           
                            <td>' . amountFormat($row['price']) . '</td>
                             <td>' . $row['qty'] . '</td>
                            <td>' . amountFormat($row['totaltax']) . ' (' . amountFormat_s($row['tax']) . '%)</td>
                            <td>' . amountFormat($row['totaldiscount']) . ' </td>
                            <td>' . amountFormat($row['subtotal']) . '</td>
                        </tr>';
                        $str_1="";
                        if($row['product']=="Nota Credito" || $row['product']=="Nota Debito"){
                            $str_1='<a href="#" class="btn btn-danger btn-sm eliminar_nota" data-id="'.$row['id'].'"><span class="icon-trash"></span></a>&nbsp';
                        }   $varuser="";
                            if(isset($row['id_usuario_crea'])){
                                $us1=$this->db->get_where("employee_profile",array("id"=>$row['id_usuario_crea']))->row();
                                    $varuser="nota creada por : ".$us1->name;
                            }
                                        echo '<tr><td colspan=5>'.$str_1. $row['product_des'].$varuser . '</td></tr>';
                                        $c++;
                                    } ?>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <p></p>
                        <div class="row">
                            <div class="col-md-7 col-sm-12 text-xs-center text-md-left">


                                <div class="row">
                                    <div class="col-md-8"><p
                                                class="lead"><?php echo $this->lang->line('Payment Status') ?>:
                                            <u><strong
                                                        id="pstatus"><?php echo  $this->lang->line(ucwords($invoice['status']))  ?></strong></u>
                                        </p>
                                        <p class="lead"><?php echo $this->lang->line('Payment Method') ?>: <u><strong
                                                        id="pmethod"><?php echo $this->lang->line($invoice['pmethod']) ?></strong></u>
                                        </p>

                                        <p class="lead mt-1"><br>Servicios Asignados:</p>
                                        <code>
                                            <?php $servs_eco=""; 
												if ($invoice['television'] == 'no' ){
													$servs_eco.= '';
												} else{
                                                        if($invoice['estado_tv'] == "Cortado"){
                                                                $servs_eco.= "<b><i class='sts-Cortado'>".$invoice['television']." (cortado)</i></b>";
                                                        }else if($invoice['estado_tv'] == "Suspendido"){
                                                                $servs_eco.= "<b><i class='sts-Suspendido'>".$invoice['television']." (suspendido)</i></b>";
                                                        }else{
                                                            $servs_eco.= $invoice['television'];    
                                                        }
													}
											if ($invoice['combo'] == 'no' ){
													$servs_eco.= '';
												} else{

                                                     if($invoice['estado_combo'] == "Cortado"){
                                                                $servs_eco.= " mas <b><i class='sts-Cortado'>".$invoice['combo']." (cortado)</i></b>";
                                                        }else if($invoice['estado_combo'] == "Suspendido"){
                                                                $servs_eco.= " mas <b><i class='sts-Suspendido'>".$invoice['combo']." (suspendido)</i></b>";
                                                        }else{
                                                            $servs_eco.= ' mas '.$invoice['combo'];
                                                        }
													}
											if ($invoice['puntos'] == 0 ){
													$servs_eco.= '';
												} else{
													$servs_eco.= ' mas '.$invoice['puntos'].' puntos adicionales';}?>
                                                    <?= $servs_eco.$servicios_adicionales; ?>
                                        </code>
										<p class="lead mt-1"><br>Nota:</p>
										 <code>
                                            <?php echo $invoice['notes'] ?>
                                        </code>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-5 col-sm-12">
                                <p class="lead"><?php echo $this->lang->line('Summary') ?></p>
                                <div class="table-responsive">
                                    <table class="table">
                                        <tbody>
                                            <?php if(isset($retenciones['total']) && $retenciones['total']>0){
                                                    $sub_t+=$retenciones['total'];
                                            } ?>
                                        <tr>
                                            <td><?php echo $this->lang->line('Sub Total') ?></td>
                                            <td class="text-xs-right"> <?php echo amountFormat($sub_t) ?></td>
                                        </tr>
                                        <tr>
                                            <td><?php echo $this->lang->line('Tax') ?></td>
                                            <td class="text-xs-right"><?php echo amountFormat($invoice['tax']) ?></td>
                                        </tr>
                                        <tr>
                                            <td><?php echo $this->lang->line('') ?>Descuento</td>
                                            <td class="text-xs-right"><?php echo amountFormat($invoice['discount']) ?></td>
                                        </tr>
                                        <?php foreach ($retenciones['retenciones'] as $key => $value) { ?>
                                              
                                            <tr>
                                                <td><?php echo $this->lang->line('') ?><?=$value['tipo_retencion'] ?></td>
                                                <td class="text-xs-right"><?php echo amountFormat($value['price']) ?></td>
                                            </tr>

                                        <?php } ?>
                                        <tr>
                                            <td><?php echo $this->lang->line('Shipping') ?></td>
                                            <td class="text-xs-right"><?php echo amountFormat($invoice['shipping']) ?></td>
                                        </tr>
                                        <tr>
                                            <td class="text-bold-800"><?php echo $this->lang->line('Total') ?></td>
                                            <td class="text-bold-800 text-xs-right"> <?php echo amountFormat($invoice['total']) ?></td>
                                        </tr>
                                        <tr>
                                            <td><?php echo $this->lang->line('Payment Made') ?></td>
                                            <td class="pink text-xs-right">
                                                (-) <?php echo ' <span id="paymade">' . amountFormat($invoice['pamnt']) ?></span></td>
                                        </tr>
                                        <tr class="bg-grey bg-lighten-4">
                                            <td class="text-bold-800"><?php echo $this->lang->line('Balance Due') ?></td>
                                            <td class="text-bold-800 text-xs-right"> <?php $myp = '';
                                                $rming = $invoice['total'] - $invoice['pamnt'];
                                                if ($rming < 0) {
                                                    $rming = 0;

                                                }
                                                echo ' <span id="paydue">' . amountFormat($rming) . '</span></strong>'; ?></td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="text-xs-center">
                                    <p><?php echo $this->lang->line('Authorized person') ?></p>
                                    <?php echo '<img src="' . FCPATH . 'userfiles/employee_sign/' . $employee['sign'] . '" alt="signature" class="height-100"/>
                                    <h6>(' . $employee['name'] . ')</h6>
                                    <p class="text-muted">' . user_role($employee['roleid']) . '</p>'; ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Invoice Footer -->

                    <div id="invoice-footer"><p class="lead"><?php echo $this->lang->line('') ?>Comprobante de Egreso:</p>
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th><?php echo $this->lang->line('') ?>Codigo</th>
                                <th><?php echo $this->lang->line('Date') ?></th>
                                <th><?php echo $this->lang->line('Method') ?></th>
                                <th><?php echo $this->lang->line('Amount') ?></th>
                                <th><?php echo $this->lang->line('Note') ?></th>


                            </tr>
                            </thead>
                            <tbody id="activity">
                            <?php foreach ($activity as $row) {
                                if($row['estado']=="Anulada" ){
                                    $row['note']="<span style='color:red;'>Transaccion Anulada</span>";
                                }else if($this->aauth->get_user()->roleid>=4){
                                    $row['note'].=", <a style='color:blue;' href='".base_url()."transactions/index?id_tr=".$row['id']."'>Ir a Anular<a/>";
                                }
                                if($row['type']=="Expense"){
                                    $row['credit']="-".$row['debit'];
                                }
                                echo '<tr>
                            <td>' . $row['id'] . '</td>
                            <td>' . $row['date'] . '</td>
                            <td>' . $this->lang->line($row['method']) . '</td>
                            <td>' . amountFormat($row['credit']) . '</td>
                            <td>' . $row['note'] . '</td>
                        </tr>';
                            } ?>

                            </tbody>
                        </table>

                        <div class="row">

                            <div class="col-md-7 col-sm-12">

                                <h6><?php echo $this->lang->line('Terms & Condition') ?></h6>
                                <p> <?php

                                    echo '<strong>' . $invoice['termtit'] . '</strong><br>' . $invoice['terms'];
                                    ?></p>
                            </div>

                        </div>

                    </div>
                    <!--/ Invoice Footer -->
                    <hr>
                    <pre><?php echo $this->lang->line('Public Access URL') ?>: <?php
                        echo $link ?></pre>

                    <div class="row">
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th><?php echo $this->lang->line('Files') ?></th>


                            </tr>
                            </thead>
                            <tbody id="activity">
                            <?php foreach ($attach as $row) {

                                echo '<tr><td><a data-url="' . base_url() . 'invoices/file_handling?op=delete&name=' . $row['col1'] . '&invoice=' . $invoice['tid'] . '" class="aj_delete"><i class="btn-danger btn-lg icon-trash-a"></i></a> <a class="n_item" href="' . base_url() . 'userfiles/attach/' . $row['col1'] . '"> ' . $row['col1'] . ' </a></td></tr>';
                            } ?>

                            </tbody>
                        </table>
                        <!-- The fileinput-button span is used to style the file input field as button -->
                        <span class="btn btn-success fileinput-button">
        <i class="glyphicon glyphicon-plus"></i>
        <span>Select files...</span>
                            <!-- The file input field used as target for the file upload widget -->
        <input id="fileupload" type="file" name="files[]" multiple>
    </span>
                        <br>
                        <pre>Allowed: gif, jpeg, png, docx, docs, txt, pdf, xls </pre>
                        <br>
                        <!-- The global progress bar -->
                        <div id="progress" class="progress">
                            <div class="progress-bar progress-bar-success"></div>
                        </div>
                        <!-- The container for the uploaded files -->
                        <table id="files" class="files"></table>
                        <br>
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>

<script src="<?php echo base_url('assets/myjs/jquery.ui.widget.js') ?>"></script>
<script src="<?php echo base_url('assets/myjs/jquery.fileupload.js') ?>"></script>
<script>
    /*jslint unparam: true */
    /*global window, $ */
    $(function () {
        'use strict';
        // Change this to the location of your server-side upload handler:
        var url = '<?php echo base_url() ?>invoices/file_handling?id=<?php echo $invoice['tid'] ?>';
        $('#fileupload').fileupload({
            url: url,
            dataType: 'json',
            done: function (e, data) {
                $.each(data.result.files, function (index, file) {
                    $('#files').append('<tr><td><a data-url="<?php echo base_url() ?>invoices/file_handling?op=delete&name=' + file.name + '&invoice=<?php echo $invoice['tid'] ?>" class="aj_delete"><i class="btn-danger btn-sm icon-trash-a"></i> ' + file.name + ' </a></td></tr>');

                });
            },
            progressall: function (e, data) {
                var progress = parseInt(data.loaded / data.total * 100, 10);
                $('#progress .progress-bar').css(
                    'width',
                    progress + '%'
                );
            }
        }).prop('disabled', !$.support.fileInput)
            .parent().addClass($.support.fileInput ? undefined : 'disabled');
    });

    $(document).on('click', ".aj_delete", function (e) {
        e.preventDefault();

        var aurl = $(this).attr('data-url');
        var obj = $(this);

        jQuery.ajax({

            url: aurl,
            type: 'GET',
            dataType: 'json',
            success: function (data) {
                obj.closest('tr').remove();
                obj.remove();
            }
        });

    });
</script>

<!-- Modal HTML -->
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
                                       id="rmpay" value="<?php echo $rming ?>">
                            </div>

                        </div>
                        <div class="col-xs-6">
                            <div class="input-group">
                                <div class="input-group-addon"><span class="icon-calendar4"
                                                                                 aria-hidden="true"></span></div>
                                            <input type="text" class="form-control required"
                                                   placeholder="Billing Date" name="paydate"
                                                   data-toggle="datepicker"
                                                   autocomplete="false">
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


                            <select name="account" class="form-control" id="cuentas_">
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
                                   value="Pago de factura #<?php echo $invoice['tid'] .' '.$invoice['name'].' '.$invoice['unoapellido'].' '.$invoice['documento'] ?>
										  "></div>
                    </div>
					<?php if ($invoice['ron']=='Cortado' || $invoice['rec']=='1') { ?>
					<div class="row">
                        <div class="col-xs-12 mb-1"><label
                                    for="shortnote">Generar Reconexion</label>
                             <select name="reconexion" class="form-control mb-1">
                                <option value="no">No</option>
                                <option value="si">Si</option>
                            </select></div>
                    </div>
					<div class="row">
                        <div class="col-xs-12 mb-1"><label
                                    for="shortnote">Tipo de reconexion</label>
                             <select name="tipo" class="form-control mb-1">
                                <option value="Reconexion Combo">Combo</option>
                                <option value="Reconexion Internet">Internet</option>
								<option value="Reconexion Television">Television</option> 
                            </select></div>
                    </div>
					<!--<div class="row">
						
                        <div class="col-xs-12 mb-1"><label
                                    for="shortnote">Paquete</label>
                             <select name="paquete" class="form-control mb-1">
                                <option value="no">No</option>
                                <?php
									/*foreach ($paquete as $row) {
										$cid = $row['pid'];
										$title = $row['product_name'];
										echo "<option value='$title'>$title</option>";
									}*/
								?>
                            </select></div>
                    </div>-->
					<?php } ?>
                    <div class="modal-footer">
                        <input type="hidden" class="form-control required"
                               name="tid" id="invoiceid" value="<?php echo $invoice['tid'] ?>">
                        <button type="button" class="btn btn-default"
                                data-dismiss="modal"><?php echo $this->lang->line('Close') ?></button>
                        <input type="hidden" name="cid" value="<?php echo $invoice['cid'] ?>"><input type="hidden"name="cname" value="<?php echo $invoice['name'] ?>">
                        <button type="button" class="btn btn-primary"
                                id="submitpayment"><?php echo $this->lang->line('Make Payment'); ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<!-- cancel -->
<div id="cancel_bill" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"><?php echo $this->lang->line('Cancel Invoice'); ?></h4>
            </div>
            <div class="modal-body">
                <form class="cancelbill">
                    <div class="row">
                        <div class="col-xs-12">
                            <?php echo $this->lang->line('You can not revert'); ?>

                        </div>
                    </div>


                    <div class="modal-footer">
                        <input type="hidden" class="form-control"
                               name="tid" value="<?php echo $invoice['tid'] ?>">
                        <button type="button" class="btn btn-default"
                                data-dismiss="modal"><?php echo $this->lang->line('Close'); ?></button>
                        <button type="button" class="btn btn-primary"
                                id="send"><?php echo $this->lang->line(''); ?>Anular Factura</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</div>

<!-- Modal HTML -->
<div id="sendEmail" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"><?php echo $this->lang->line('Email'); ?></h4>
            </div>
            <div id="request">
                <div id="ballsWaveG">
                    <div id="ballsWaveG_1" class="ballsWaveG"></div>
                    <div id="ballsWaveG_2" class="ballsWaveG"></div>
                    <div id="ballsWaveG_3" class="ballsWaveG"></div>
                    <div id="ballsWaveG_4" class="ballsWaveG"></div>
                    <div id="ballsWaveG_5" class="ballsWaveG"></div>
                    <div id="ballsWaveG_6" class="ballsWaveG"></div>
                    <div id="ballsWaveG_7" class="ballsWaveG"></div>
                    <div id="ballsWaveG_8" class="ballsWaveG"></div>
                </div>
            </div>
            <div class="modal-body" id="emailbody" style="display: none;">
                <form id="sendbill">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="input-group">
                                <div class="input-group-addon"><span class="icon-envelope-o"
                                                                     aria-hidden="true"></span></div>
                                <input type="text" class="form-control" placeholder="Email" name="mailtoc"
                                       value="<?php echo $invoice['email'] ?>">
                            </div>

                        </div>

                    </div>


                    <div class="row">
                        <div class="col-xs-12 mb-1"><label
                                    for="shortnote"><?php echo $this->lang->line('Customer Name'); ?></label>
                            <input type="text" class="form-control"
                                   name="customername" value="<?php echo $invoice['name'] ?>"></div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 mb-1"><label
                                    for="shortnote"><?php echo $this->lang->line('Subject'); ?></label>
                            <input type="text" class="form-control"
                                   name="subject" id="subject">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 mb-1"><label
                                    for="shortnote"><?php echo $this->lang->line('Message'); ?></label>
                            <textarea name="text" class="summernote" id="contents" title="Contents"></textarea></div>
                    </div>

                    <input type="hidden" class="form-control"
                           id="invoiceid" name="tid" value="<?php echo $invoice['tid'] ?>">
                    <input type="hidden" class="form-control"
                           id="emailtype" value="">


                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default"
                        data-dismiss="modal"><?php echo $this->lang->line('Close'); ?></button>
                <button type="button" class="btn btn-primary"
                        id="sendM"><?php echo $this->lang->line('Send'); ?></button>
            </div>
        </div>
    </div>
</div>
<!--sms-->
<!-- Modal HTML -->
<div id="sendSMS" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"><?php echo $this->lang->line('Send'); ?> SMS</h4>
            </div>
            <div id="request_sms">
                <div id="ballsWaveG1">
                    <div id="ballsWaveG_1" class="ballsWaveG"></div>
                    <div id="ballsWaveG_2" class="ballsWaveG"></div>
                    <div id="ballsWaveG_3" class="ballsWaveG"></div>
                    <div id="ballsWaveG_4" class="ballsWaveG"></div>
                    <div id="ballsWaveG_5" class="ballsWaveG"></div>
                    <div id="ballsWaveG_6" class="ballsWaveG"></div>
                    <div id="ballsWaveG_7" class="ballsWaveG"></div>
                    <div id="ballsWaveG_8" class="ballsWaveG"></div>
                </div>
            </div>
            <div class="modal-body" id="smsbody" style="display: none;">
                <form id="sendsms">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="input-group">
                                <div class="input-group-addon"><span class="icon-envelope-o"
                                                                     aria-hidden="true"></span></div>
                                <input type="text" class="form-control" placeholder="SMS" name="mobile"
                                       value="<?php echo $invoice['phone'] ?>">
                            </div>

                        </div>

                    </div>


                    <div class="row">
                        <div class="col-xs-12 mb-1"><label
                                    for="shortnote"><?php echo $this->lang->line('Customer Name'); ?></label>
                            <input type="text" class="form-control"
                                   value="<?php echo $invoice['name'] ?>"></div>
                    </div>

                    <div class="row">
                        <div class="col-xs-12 mb-1"><label
                                    for="shortnote"><?php echo $this->lang->line('Message'); ?></label>
                            <textarea class="form-control" name="text_message" id="sms_tem" title="Contents"
                                      rows="3"></textarea></div>
                    </div>


                    <input type="hidden" class="form-control"
                           id="smstype" value="">


                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default"
                        data-dismiss="modal"><?php echo $this->lang->line('Close'); ?></button>
                <button type="button" class="btn btn-primary"
                        id="submitSMS"><?php echo $this->lang->line('Send'); ?></button>
            </div>
        </div>
    </div>
</div>

<div id="pop_model" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"><?php echo $this->lang->line('Change Status'); ?></h4>
            </div>

            <div class="modal-body">
                <form id="form_model">


                    <div class="row">
                        <div class="col-xs-12 mb-1"><label
                                    for="pmethod"><?php echo $this->lang->line('Mark As') ?></label>
                            <select name="status" class="form-control mb-1">
                                <option value="paid"><?php echo $this->lang->line('Paid'); ?></option>
                                <option value="due"><?php echo $this->lang->line('Due'); ?></option>
                                <option value="partial"><?php echo $this->lang->line('Partial'); ?></option>
                            </select>

                        </div>
                    </div>

                    <div class="modal-footer">
                        <input type="hidden" class="form-control required"
                               name="tid" id="invoiceid" value="<?php echo $invoice['tid'] ?>">
                        <button type="button" class="btn btn-default"
                                data-dismiss="modal"><?php echo $this->lang->line('Close'); ?></button>
                        <input type="hidden" id="action-url" value="invoices/update_status">
                        <button type="button" class="btn btn-primary"
                                id="submit_model"><?php echo $this->lang->line('Change Status'); ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div id="pop_model2" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"><?php echo $this->lang->line('Recurring') ?></h4>
            </div>

            <div class="modal-body">
                <form id="form_model2">

					<input type="hidden" value="<?php echo $invoice['csd'] ?>" name="usuario"></input>
                    <div class="row">
                        <div class="col-xs-12 mb-1"><label
                                    for="pmethod"><?php echo $this->lang->line('Mark As') ?></label>
                            <select name="status" class="form-control mb-1">
								<option value="<?php echo $invoice['ron'] ?>">>><?php echo $invoice['ron'] ?></option>
								<?php if ($this->aauth->get_user()->id == 20 || $this->aauth->get_user()->roleid == 5 || $this->aauth->get_user()->co != null) { ?>
                                <option value="Activo"><?php echo $this->lang->line('') ?>Activo</option>
                                <option value="Instalar"><?php echo $this->lang->line('') ?>Instalar</option>
                                <option value="Cortado"><?php echo $this->lang->line('') ?>Cortado</option>
                                <option value="Suspendido"><?php echo $this->lang->line('') ?>Suspendido</option>
                                <option value="Exonerado"><?php echo $this->lang->line('') ?>Exonerado</option>
                                <option value="Retirado"><?php echo $this->lang->line('') ?>Retirado</option>
                                <option value="Compromiso"><?php echo $this->lang->line('') ?>Compromiso</option>
								<option value="Evento"><?php echo $this->lang->line('') ?>Evento</option>
								<?php } if ($this->aauth->get_user()->id == 89 || $this->aauth->get_user()->roleid == 5 || $this->aauth->get_user()->co != null) { ?>
                                <option value="Cartera"><?php echo $this->lang->line('') ?>Cartera</option>
								<?php } if ($this->aauth->get_user()->id == 96 || $this->aauth->get_user()->roleid == 5 || $this->aauth->get_user()->co != null) { ?>
								<option value="Reportado"><?php echo $this->lang->line('') ?>Reportado</option>
								<option value="Depurado"><?php echo $this->lang->line('') ?>Depurado</option>
								<?php } ?>
                            </select>

                        </div>
						
						<div class="col-xs-6 mb-1"><label
                                    for="pmethod">Television</label>
                            <select name="television" class="form-control mb-1">
                                <option value="<?=$invoice['television'] ?>">-><?php if($invoice['estado_tv']==='Cortado'){
										$estdo = 'Cortado';
									}else if($invoice['estado_tv']==='Suspendido') { 
										$estdo = 'Suspendido'; 
									}else{
										$estdo = '';
									} echo $invoice['television'].' '.$estdo ?></option>
                            	<option value="Suspendido">Suspender</option>
                            	<option value="Cortado">Cortar</option>
								<?php
									foreach ($paquete as $row) {
										$cid = $row['pid'];
										$title = $row['product_name'];
										echo "<option value='$title'>$title</option>";
									}
									?>
                            </select>
                        </div>
						<div class="col-xs-6 mb-1"><label
                                    for="pmethod">Internet</label>
                            <select name="internet" class="form-control mb-1">
                                <option value="<?=$invoice['combo'] ?>">-><?php if($invoice['estado_combo']==='Cortado'){
									$estint = 'Cortado';
								}else if($invoice['estado_combo']==='Suspendido'){
									$estint = 'Suspendido';
								}else{ 
									$estint = ''; 
								} echo $invoice['combo'].' '.$estint ?></option>
								<option value="Cortado">Cortar</option>
								<option value="Suspendido">Suspender</option>
								<?php
									foreach ($paqueteinter as $row) {
										$cid = $row['pid'];
										$title = $row['product_name'];
										echo "<option value='$title'>$title</option>";
									}
									?>
                            </select>
                        </div>						
						
						
                    </div>

                    <div class="modal-footer">
                        <input type="hidden" class="form-control required"
                               name="tid" id="invoiceid" value="<?php echo $invoice['tid'] ?>">
                        <button type="button" class="btn btn-default"
                                data-dismiss="modal"><?php echo $this->lang->line('Close') ?></button>
                        <input type="hidden" id="action-url" value="invoices/rec_status">
                        <button type="button" class="btn btn-primary"
                                id="submit_model2"><?php echo $this->lang->line('Change Status') ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- modal sms-->
<div id="sendSms" class="modal fade">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"><?php echo $this->lang->line('Sms individual') ?> </h4>
            </div>

            <div class="modal-body" id="emailbody">
                <form id="sendSMS_form">
<div id="div_notify2">
<div id="notify2" class="alert alert-success" style="display:none;">
            <a href="#" class="close" data-dismiss="alert">&times;</a>

            <div class="message2"></div>
        </div>
</div>
<div id="div_notify4">

</div>
                    
                    <div class="row">
                        <div class="col-xs-12 mb-1"><label
                                    for="plantillas">Plantillas</label>
                        <select id="plantillas2" name="plantillas2" class="form-control" onchange="cargar_plantilla()">
                            <option value="">-</option>
                            
                            <?php foreach ($plantillas as $key => $value) {
                                    $x1=rtrim($value['other'], "\r\n");
                                echo "<option value='".$value['id']."' data-texto='".$x1."'>".$value['name']."</option>";
                            } ?>
                        </select>
                        </div>
                    </div>
                    <div class="row" >
                        <div class="col-xs-12 mb-1"><label
                                    for="number">Nombre Campaña</label>
                            <input type="text" class="form-control"
                                   name="name_campaign" id="name_campaign" maxlength="10" minlength="10" >
                        </div>
                    </div>
                    <!--div class="row" id="div_numero_individual">
                        <div class="col-xs-12 mb-1"><label
                                    for="number">Numero de telefono individual</label>
                            <input type="text" class="form-control"
                                   name="number2" id="number2" maxlength="10" minlength="10" >
                        </div>
                    </div-->
                    <div class="row" id="div_envio_masivo">
                        <div class="col-xs-12 mb-1"><label
                                    for="number">Numeros</label>
                            <input type="text" class="form-control" readonly="true" value="<?= $phons  ?>" 
                                   name="numerosMasivos" id="numerosMasivo" minlength="10" >
                                   <input type="text" class="form-control" hidden="true" 
                                   name="ultimo_lote" id="ultimo_lote" value="si">
                                   <input type="text" class="form-control" hidden="true" 
                                   name="envio_desde_factura" id="envio_desde_factura" value="si">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 mb-1"><label
                                    for="shortnote"><?php echo $this->lang->line('Message') ?></label>
                            <textarea name="text2" class="form-control" maxlength="250" id="contents2" title="Contents"></textarea></div>
                    </div>
                    <div align="center"><input type="button" class="btn btn-danger" value="Detener Envio de Mensajes" onclick="cancelar_envio_mensajes();"></div>
                    <div class="row">
                        <div class="col-xs-12 mb-1"><label
                                    for="shortnote">Personalizar</label><br>
                            <span>1er Nombre = {primer_nombre}</span><br>
                            <span>2do Nombre = {segundo_nombre}</span><br>
                            <span>1er Apellido = {primer_apellido}</span><br>
                            <span>2do Apellido = {segundo_apellido}</span><br>
                            <span>Saldo = {monto_debe}</span><br>
                            <span>Documento = {documento}</span><br>
                            <span>Mes Actual = {mes_actual}</span><br>
                        </div>
                    </div>
                    <input type="hidden" class="form-control"
                           name="gid" value="<?php echo $group['id'] ?>">
                    <input type="hidden" id="action-urlSMS" value="clientgroup/sendGroupSms">


                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default"
                        data-dismiss="modal"><?php echo $this->lang->line('Close') ?> </button>
                <button <?= ($phons=="") ? "disabled='disabled'" :"" ?> type="button" class="btn btn-primary"
                        id="sendNow2" onclick="enviar_SMS()"><?php echo $this->lang->line('Send') ?> </button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).on("click","#open_modal_sms",function (e){
        e.preventDefault();
        $("#sendSms").modal("show");
    });
        function cargar_plantilla(){
        var text=$("#plantillas2 option:selected").data("texto");
        
        if($("#plantillas2 option:selected").val()=="38"){
            $("#contents2").attr("maxlength",250);
        }else{
            $("#contents2").attr("maxlength",250);
        }
        
        $("#contents2").val(text);
    }

     function enviar_SMS(){

         var o_data =  $("#sendSMS_form").serialize();
        var action_url= $('#action-urlSMS').val();

        $.cookie("cancelar_envio_mensajes", "false");
        sendMail_g(o_data,action_url);
}
$("#seleccion_banco").hide();
    function metodo_de_pago_select(){
        if($("#select_metodo_de_pago option:selected").val()=="Bank"){
            $("#seleccion_banco").show();
        }else{
            $("#seleccion_banco").hide();
        }
    }
    $(function () {
       // $('#cuentas_ option[value="4"]').remove();
       // $('#cuentas_ option[value="5"]').remove();

        $('.summernote').summernote({
            height: 150,
            toolbar: [
                // [groupName, [list of button]]
                ['style', ['bold', 'italic', 'underline', 'clear']],
                ['font', ['strikethrough', 'superscript', 'subscript']],
                ['fontsize', ['fontsize']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['height', ['height']],
                ['fullscreen', ['fullscreen']],
                ['codeview', ['codeview']]
            ]
        });

        $('#sendM').on('click', function (e) {
            e.preventDefault();

            sendBill($('.summernote').summernote('code'));

        });


    });

$(".eliminar_nota").click(function(e){
    e.preventDefault();
    var id_nota=$(this).data("id");
    var p=confirm("¿Desea eliminar la nota?");
    if(p){
            $.post(baseurl+"invoices/eliminar_nota",{id_nota:id_nota},function(data){
                if(data=="Realizado"){
                    location.reload();
                }
            });    
    }
    

});
</script>
