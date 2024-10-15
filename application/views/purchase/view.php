<style type="text/css">
    #nop:hover{
        transform: scale(4);
    }
    #nop{
        transform: scale(2);
    }
	.anulado{
		color: red;
	}
</style>
<div class="app-content content container-fluid">
    <div class="content-wrapper">
        <div id="notify" class="alert alert-success" style="display:none;">
            <a href="#" class="close" data-dismiss="alert">&times;</a>

            <div class="message"></div>
        </div>
		
		<!-------- MENU PARA MOSTRAR ----->

        <div class="content-body">
            <section class="card">
                <div id="invoice-template" class="card-block">
                    <div class="row wrapper white-bg page-heading">
					
                        <div class="col-lg-12">
                            <?php
                            $validtoken = hash_hmac('ripemd160', 'p' . $invoice['tid'], $this->config->item('encryption_key'));

                            $link = base_url('billing/purchase?id=' . $invoice['tid'] . '&token=' . $validtoken);
                            if ($invoice['status'] != 'anulado') { ?>
                                <div class="title-action">
									
                                <?php
            
                               if ($this->aauth->get_user()->roleid > 3) { ?> 
                                <a href="<?php echo 'edit?id=' . $invoice['tid']; ?>" class="btn btn-warning"><i
                                            class="icon-pencil"></i> <?php echo $this->lang->line('Edit Order') ?> </a>
									<?php } ?>

                                <a href="#part_payment" data-toggle="modal" data-remote="false" data-type="reminder"
                                   class="btn btn-large btn-success" title="Partial Payment"
                                ><span class="icon-money"></span> <?php echo $this->lang->line('Make Payment') ?> </a>

                                <div class="btn-group">
                                    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown"
                                            aria-haspopup="true" aria-expanded="false">
                            <span
                                    class="icon-envelope-o"></span> <?php echo $this->lang->line('Send') ?>
                                    </button>
                                    <div class="dropdown-menu"><a href="#sendEmail" data-toggle="modal"
                                                                  data-remote="false" class="dropdown-item sendbill"
                                                                  data-type="purchase"><?php echo $this->lang->line('Purchase Request') ?></a>


                                    </div>

                                </div>

                                <div class="btn-group ">
                                    <button type="button" class="btn btn-success btn-min-width dropdown-toggle"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i
                                                class="icon-print"></i> <?php echo $this->lang->line('Print Order') ?>
                                    </button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item"
                                           href="<?php echo 'printinvoice?id=' . $invoice['tid']; ?>"><?php echo $this->lang->line('Print') ?></a>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item"
                                           href="<?php echo 'printinvoice?id=' . $invoice['tid']; ?>&d=1"><?php echo $this->lang->line('PDF Download') ?></a>
										<div class="dropdown-divider"></div>
                                        <a class="dropdown-item"
                                           href="<?php echo 'recibido?id=' . $invoice['tid']; ?>"><?php echo $this->lang->line('') ?>Recibidos</a>
                                    </div>
                                </div>
									
                                <a href="<?php echo $link; ?>" class="btn btn-primary"><i
                                            class="icon-earth"></i> <?php echo $this->lang->line('Public Preview') ?>
                                </a>
                                 <?php if ($this->aauth->get_user()->roleid > 1) { ?> 
                                <a href="#pop_model2" data-toggle="modal" data-remote="false"
                                   class="btn btn-large btn-success" title="Change Status"
                                ><span class="icon-tab"></span> <?php echo $this->lang->line('Change Status') ?></a>
								<?php } ?>
									
								<?php if ($this->aauth->get_user()->roleid > 4) { ?>										
                                <a href="#cancel-bill" class="btn btn-danger" id="cancel-bill_p"><i
                                            class="icon-minus-circle"> </i> <?php echo $this->lang->line('Cancel') ?>
                                </a>
									<?php } ?>

                                </div><?php } else {
                                echo '<h2 class="btn btn-oval btn-danger">' . $this->lang->line('Cancelled') . '</h2>';}
							     ?>							  
                           
							
							
                        </div>
                    </div>

                    <!-- Invoice Company Details -->
                    <div id="invoice-company-details" class="row mt-2">
                        <div class="col-md-6 col-sm-12 text-xs-center text-md-left"><p></p>
                            <img src="<?php echo base_url('userfiles/company/' . $this->config->item('logo')) ?>"
                                 class="img-responsive p-1 m-b-2" style="max-height: 120px;">

                        </div>
                        <div class="col-md-6 col-sm-12 text-xs-center text-md-right">
                            <h2><?php echo $this->lang->line('Purchase Order') ?></h2>
                            <p class="pb-1"> <?php echo  prefix(2). $invoice['tid'] . '</p>
                            <p class="pb-1">Sede : ' . $invoice['refer'].'</p>'; ?>
                            <ul class="px-0 list-unstyled">
                                <li><?php echo $this->lang->line('Gross Amount') ?></li>
                                <li class="lead text-bold-800"><?php echo amountFormat($invoice['total']) ?></li>
                            </ul>
                        </div>
                    </div>
                    <!--/ Invoice Company Details -->

                    <!-- Invoice Customer Details -->
                    <div id="invoice-customer-details" class="row pt-2">
                        <div class="col-sm-12 text-xs-center text-md-left">
                            <p class="text-muted"><?php echo $this->lang->line('Bill From') ?></p>
                        </div>
                        <div class="col-md-6 col-sm-12 text-xs-center text-md-left">
                            <ul class="px-0 list-unstyled">


                                <li class="text-bold-800"><a
                                            href="<?php echo base_url('supplier/view?id=' . $invoice['cid']) ?>"><strong
                                                class="invoice_a"><?php echo $invoice['name'] . '</strong></a></li><li>' . $invoice['address'] . '</li><li>' . $invoice['city'] . ',' .'</li><li>NIT : '. $invoice['nit'] . '</li><li>'.$this->lang->line('Phone').': ' . $invoice['phone'] . '</li><li>'.$this->lang->line('Email').': ' . $invoice['email']; ?>
                                </li>
                            </ul>

                        </div>
                        <div class="offset-md-3 col-md-3 col-sm-12 text-xs-center text-md-left">
                            <?php echo '<p><span class="text-muted">'.$this->lang->line('Order Date').' :</span> ' . dateformat($invoice['invoicedate']) . '</p> <p><span class="text-muted">'.$this->lang->line('Due Date').' :</span> ' . dateformat($invoice['invoiceduedate']) . '</p>  <p><span class="text-muted">Categoria :</span> ' . $invoice['idcat'] . '</p><p><span class="text-muted">'.$this->lang->line('Terms').' :</span> ' . $invoice['termtit'] . '</p>';
                            ?>
                        </div>
                    </div>
                    <!--/ Invoice Customer Details -->

                    <!-- Invoice Items Details -->
                    <div id="invoice-items-details" class="pt-2">
						<form method="post" id="data_form" class="form-horizontal">
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
                                    $sub_t=0;
                                    foreach ($products as $row) {
                                        $sub_t+=$row['price']*$row['qty'];
                                        echo '<tr>
<th scope="row">' . $c . '</th>
                            <td>' . $row['product'] . '</td>
                           
                            <td>' . amountFormat($row['price']) . '</td>
                             <td>' . $row['qty'] . '</td>
                            <td>' . amountFormat($row['totaltax']) . ' (' . amountFormat_s($row['tax']) . '%)</td>
                            <td>' . amountFormat($row['totaldiscount']) . '(' .amountFormat_s($row['discount']).$this->lang->line($invoice['format_discount']).')</td>
                            <td>' . amountFormat($row['subtotal']) . '</td>
                        </tr>';
                                        echo '<tr><td colspan=5>' . $row['product_des'] . '</td></tr>';
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
                                                        id="pstatus"> <?php echo  ucwords($invoice['status']) ?></strong></u>
                                        </p>
                                        <p class="lead"><?php echo $this->lang->line('Payment Method') ?>: <u><strong
                                                        id="pmethod"><?php echo  $this->lang->line($invoice['pmethod']) ?></strong></u>
                                        </p>

                                        <p class="lead mt-1"><br><?php echo $this->lang->line('Note') ?>:</p>
                                        <code>
                                            <?php echo $invoice['notes'] ?>
                                        </code>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-5 col-sm-12">
                                <p class="lead"><?php echo $this->lang->line('Total Due') ?></p>
                                <div class="table-responsive" >
                                    <table class="table" >
                                        <tbody>
                                        <tr>
                                            <td><?php echo $this->lang->line('Sub Total') ?></td>
                                            <td class="text-xs-right"> <?php echo amountFormat($sub_t) ?></td>
                                        </tr>
                                        <tr>
                                            <td><?php echo $this->lang->line('TAX') ?></td>
                                            <td class="text-xs-right"><?php echo amountFormat($invoice['tax']) ?></td>
                                        </tr>
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
                                <div class="text-xs-center  col-sm-4">
                                    <p><?php echo $this->lang->line('') ?>Generado por</p>
                                    <img src="<?php echo base_url('userfiles/employee_sign/' . $employee['sign']) . '" class="img-responsive p-1 m-b-2" style="max-width: 100%"/>
                                    <h6>(' . $employee['name'] . ')</h6>
                                    <p class="text-muted">' . user_role($employee['name']) . '</p>'; ?>
                                </div>
								<div class="text-xs-center  col-sm-4">
									 
									<?php if($invoice['aid']==0){
										 if ($this->aauth->get_user()->id == 8 || $this->aauth->get_user()->id == 18 || $this->aauth->get_user()->id == 151) {
										echo '<input type="hidden" name="idorden" value="'.$invoice['tid'].'"></input><input type="hidden" name="estado" value="aprobado"></input><input type="submit" id="submit-data" class="btn btn-success margin-bottom"
										value="AUTORIZAR" data-loading-text="Adding...">
                        				<input type="hidden" value="purchase/autorizar" id="action-url">';
										 }
									}else{ ?>
										<p><?php echo $this->lang->line('') ?>Administrativo autoriza</p>
										 <img src="<?php echo base_url('userfiles/employee_sign/' . $employeeaut['sign']) . '" class="img-responsive p-1 m-b-2" style="max-width: 100%"/>
										<h6>(' . $employeeaut['name'] . ')</h6>
										<p class="text-muted">' . user_role($employeeaut['name']) . '</p>'; 
									} ?>
									
                                </div>
								<div class="text-xs-center  col-sm-4">
									 
									<?php if($invoice['a2id']==0){
										 if ($this->aauth->get_user()->id == 8 || $this->aauth->get_user()->id == 130 || $this->aauth->get_user()->id == 158) {
										echo '<input type="hidden" name="idorden" value="'.$invoice['tid'].'"></input><input type="hidden" name="estado" value="aprobado"></input><input type="submit" id="submit-data" class="btn btn-success margin-bottom"
										value="AUTORIZAR" data-loading-text="Adding...">
                        				<input type="hidden" value="purchase/autorizar" id="action-url">';
										 }
									}else{ ?>
										<p><?php echo $this->lang->line('') ?>Contable Autoriza</p>
										<img src="<?php echo base_url('userfiles/employee_sign/' . $employeeaut2['sign']) . '" class="img-responsive p-1 m-b-2" style="max-width: 100%"/>
										<h6>(' . $employeeaut2['name'] . ')</h6>
										<p class="text-muted">' . user_role($employeeaut2['name']) . '</p>'; 
									} ?>
									
                                </div>
                            </div>
                        </div>
					</form>
                    </div>

                    <!-- Invoice Footer -->

                    <div id="invoice-footer"><p class="lead"><?php echo $this->lang->line('') ?>Comprobante de Egreso:</p>
                        <table class="table table-striped">
                            <thead>
                            <tr >
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
                                echo '<tr>
                            <td>' . $row['id'] . '</td>
                            <td>' . $row['date'] . '</td>
                            <td>' .  $this->lang->line($row['method']) . '</td>
                            <td>' . amountFormat($row['debit']) . '</td>
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

                                echo '<tr><td><a data-url="' . base_url() . 'purchase/file_handling?op=delete&name=' . $row['col1'] . '&invoice=' . $invoice['tid'] . '" class="aj_delete"><i class="btn-danger btn-lg icon-trash-a"></i></a> <a class="n_item" href="' . base_url() . 'userfiles/attach/' . $row['col1'] . '"> ' . $row['col1'] .'/'.$row['col2'] . ' </a></td></tr>';
                            } ?>

                            </tbody>
                        </table>
                        <!-- The fileinput-button span is used to style the file input field as button -->
                        <span class="btn btn-success fileinput-button">
							<div id="customerpanel" class="form-group row">
								<label for="toBizName"
									   class="caption col-sm-2 col-form-label">Tipo de comprobante<span
											style="color: red;">*</span></label>                    
								<div class="col-sm-12">
									<select name="comprobante" class="form-control" id="comprobante">
										<option value="Pago">Pago</option>
										<option value="Recibido">Recibido</option>                      
									</select>
								</div>

							</div>
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
	//universal create

    /*jslint unparam: true */
    /*global window, $ */
    //$(function () {
        'use strict';
        // Change this to the location of your server-side upload handler:
		var comprobante=$("#comprobante option:selected").val();
        
        var url = '<?php echo base_url() ?>purchase/file_handling?comprobante='+comprobante+'&id=<?php echo $invoice['tid'] ?>';
        $('#fileupload').fileupload({
            url: url,
            dataType: 'json',
            done: function (e, data) {
                $.each(data.result.files, function (index, file) {
                    $('#files').append('<tr><td><a data-url="<?php echo base_url() ?>purchase/file_handling?op=delete&name=' + file.name + '&invoice=<?php echo $invoice['tid'] ?>" class="aj_delete"><i class="btn-danger btn-sm icon-trash-a"></i> ' + file.name + ' </a></td></tr>');

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
            .parent().addClass($.support.fileInput ? undefined : 'disabled')
        .bind('fileuploadadd', function (e, data) {
            var comprobante=$("#comprobante option:selected").val();
            data.url = '<?php echo base_url() ?>purchase/file_handling?comprobante='+comprobante+'&id=<?php echo $invoice['tid'] ?>';
            
    });
    //});

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
                <h4 class="modal-title"><?php echo $this->lang->line('Debit Payment Confirmation') ?></h4>
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
                                <input type="text" class="form-control required" id="tsn_date"
                                       placeholder="Billing Date" name="paydate"
                                       value="<?php echo dateformat($this->config->item('date')); ?>">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xs-12 mb-1"><label
                                    for="pmethod"><?php echo $this->lang->line('Payment Method') ?></label>
                            <select name="pmethod" class="form-control mb-1">
                                <option value="Cash"><?php echo $this->lang->line('Cash') ?></option>
                                <option value="Card"><?php echo $this->lang->line('Card') ?></option>
								<option value="Bank">Bank</option>
                            </select><label for="account"><?php echo $this->lang->line('Account') ?></label>

                            <select name="account" class="form-control">
                                <?php foreach ($acclist as $row) {
                                    echo '<option value="' . $row['id'] . '">' . $row['holder'] . ' / ' . $row['acn'] . '</option>';
                                }
                                ?>
                            </select></div>
                      
                            
                    </div>
                    <div class="row">
                        <div class="col-xs-12 mb-1"><label
                                    for="shortnote">Marca la casilla, para que la transacción no aparezca en la sede</label>
                            <input id="nop" type="checkbox" class="form-control" name="nop" style="cursor:pointer;"></div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 mb-1"><label
                                    for="shortnote"><?php echo $this->lang->line('Note') ?></label>
                            <input type="text" class="form-control"
                                   name="shortnote" placeholder="Short note"
                                   value="Orden de compra # <?php echo $invoice['tid'] ?>"></div>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" class="form-control required" name="tid" id="invoiceid" value="<?php echo $invoice['tid'] ?>">
                        <button type="button" class="btn btn-default"
                                data-dismiss="modal">Volver</button>
                        <input type="hidden" name="cid" value="<?php echo $invoice['cid'] ?>">
                        <input type="hidden" name="cat" value="<?php echo $invoice['idcat'] ?>">
                                                                                                                                                                                                    
                        <button type="button" class="btn btn-primary" id="purchasepayment"><?php echo $this->lang->line('Do Payment') ?></button>
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
                <h4 class="modal-title"><?php echo $this->lang->line('Cancel Purchase Order') ?></h4>
            </div>
            <div class="modal-body">
                <form class="cancelbill">
                    <div class="row">
                        <div class="col-xs-12">
                            <?php echo $this->lang->line('this action! Are you sure') ?>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" class="form-control"
                               name="tid" value="<?php echo $invoice['tid'] ?>">
                        <button type="button" class="btn btn-default"
                                data-dismiss="modal"> <?php echo $this->lang->line('Close') ?></button>
                        <button type="button" class="btn btn-primary"
                                id="send"> <?php echo $this->lang->line('Cancel') ?></button>
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
                <h4 class="modal-title">Email</h4>
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
                                    for="shortnote"><?php echo $this->lang->line('Customer Name') ?></label>
                            <input type="text" class="form-control"
                                   name="customername" value="<?php echo $invoice['name'] ?>"></div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 mb-1"><label
                                    for="shortnote"><?php echo $this->lang->line('Subject') ?></label>
                            <input type="text" class="form-control"
                                   name="subject" id="subject">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 mb-1"><label
                                    for="shortnote"><?php echo $this->lang->line('Message') ?></label>
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
                        data-dismiss="modal"><?php echo $this->lang->line('Close') ?></button>
                <button type="button" class="btn btn-primary"
                        id="sendM"><?php echo $this->lang->line('Send') ?></button>
            </div>
        </div>
    </div>
</div>

<div id="pop_model2" class="modal fade">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"><?php echo $this->lang->line('Change Status') ?></h4>
            </div>

            <div class="modal-body">
                <div id="mensaje">
                    
                </div>
               
                <form id="form_model">


                    <div class="row">
                        <div class="col-xs-12 mb-1"><label
                                    for="pmethod"><?php echo $this->lang->line('Mark As') ?></label>
                            <select id="status" name="status" class="form-control mb-1" onchange="estado_orden_compra()">
                                <option value="pendiente" <?= ($invoice['status']=="pendiente") ? 'selected="true"':'' ?> ><?php echo $this->lang->line('') ?>Pendiente</option>
								<?php if ($this->aauth->get_user()->username == 'YadiraGerente') { ?>
                                <option value="aprobado" <?= ($invoice['status']=="aprobado") ? 'selected="true"':'' ?> ><?php echo $this->lang->line('') ?>Aprobado</option>
								<?php } ?>
								<option value="aprobado" <?= ($invoice['status']=="abonado") ? 'selected="true"':'' ?> ><?php echo $this->lang->line('') ?>Abonado</option>                                
                                <option value="cancelado" <?= ($invoice['status']=="cancelado") ? 'selected="true"':'' ?>><?php echo $this->lang->line('') ?>Cancelado</option>
                                <option value="recibido parcial" <?= ($invoice['status']=="recibido parcial") ? 'selected="true"':'' ?>><?php echo $this->lang->line('') ?>Recibido Parcial</option>
                                <option value="recibido" <?= ($invoice['status']=="recibido") ? 'selected="true"':'' ?>><?php echo $this->lang->line('') ?>Recibido</option>
                                
                                <option value="finalizado" <?= ($invoice['status']=="finalizado") ? 'selected="true"':'' ?>><?php echo $this->lang->line('') ?>Finalizado</option>
                            </select>

                        </div>
                    </div>
                    <div id="div-resibido">
                        
                    <div class="row">
                       <div class="col-xs-12 mb-1">
                                        <label><?php echo $this->lang->line('Update Stock') ?></label>
                                        <div class="input-group">
                                            <label class="display-inline-block custom-control custom-radio ml-1">
                                                <input type="radio" name="update_stock" class="custom-control-input update_stock"
                                                       value="yes" <?= ($invoice['actualizar_stock'] ==1) ? 'checked="true"':'' ?> onchange="action_actualizar_stock()">
                                                <span class="custom-control-indicator"></span>
                                                <span class="custom-control-description ml-0"><?php echo $this->lang->line('Yes') ?></span>
                                            </label>
                                            <label class="display-inline-block custom-control custom-radio update_stock">
                                                <input <?= ($invoice['actualizar_stock'] ==1) ? 'disabled="true"':'' ?> type="radio" name="update_stock" class="custom-control-input update_stock" onchange="action_actualizar_stock()"
                                                       value="no" <?= ($invoice['actualizar_stock'] ==0 || $invoice['actualizar_stock'] ==null || $invoice['actualizar_stock'] =='null') ? 'checked="true"':'' ?>>
                                                <span class="custom-control-indicator"></span>
                                                <span class="custom-control-description ml-0"><?php echo $this->lang->line('No') ?></span>
                                            </label>
                                        </div>
                                    </div>
                    </div>
                    <div id="div-si-actualizar">
                    <div class="row">
                            <div class="table-responsive col-sm-12">
                                <table class="table table-striped">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th><?php echo $this->lang->line('Description') ?></th>
                                        
                                        <th class="text-xs-left"><?php echo $this->lang->line('Qty') ?></th>
                                        <th class="text-xs-left"><?php echo $this->lang->line('Qty') ?> en Almacen</th>
                                        <th class="text-xs-left"><?php echo $this->lang->line('Qty') ?> a Pasar</th>
                                        
                                        
                                        
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php $c = 1;
                                    
                                    foreach ($products as $row) {
                                        if($row['qty_en_almacen']==null){
                                            $row['qty_en_almacen'] ="0";
                                        }
                                        $options="";
                                        $numero_de_iteraciones=$row['qty']-$row['qty_en_almacen'];
                                        for ($i=0; $i <= $numero_de_iteraciones; $i++) { 
                                            $options.="<option value='".$i."'>".$i."</option>";
                                        }
                                        $texto_select='<select data-ultimo-select="'.$numero_de_iteraciones.'" class="form-control mb-1 sl-cantidades" id="sl-pr-'.$row['id'].'" name="sl-pr-'.$row['id'].'">' .$options. '</select>';
                                        if($numero_de_iteraciones==0){
                                            $texto_select='<div id="notif1" class="alert alert-success" style="margin-bottom:-9px;margin-top:-9px;"><div class="messag1">Stock En Almacen</div></div>';
                                        }
                                        echo '<tr>
                                            <th scope="row">' . $c . '</th>
                                                                        <td>' . $row['product'] . '</td>                                                                       
                                                                         <td>' . $row['qty'] . '</td>
                                                                         <td>' . $row['qty_en_almacen'] . '</td>
                                                                         <td>'.$texto_select.'</td>
                                                                    </tr>';
                                        echo '<tr><td colspan=5>' . $row['product_des'] . '</td></tr>';
                                        $c++;
                                    } ?>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12 mb-1">
                                <label for="salmacen"><?php echo $this->lang->line('Warehouse') ?></label>
                                <select class="form-control mb-1" name="almacen" <?/*= ($invoice['almacen_seleccionado']!=0 && $invoice['almacen_seleccionado']!=null) ? 'style="pointer-events:none;"':'' */ ?>>
                                    <option value="0" ><?php echo $this->lang->line('All') ?></option><?php foreach ($warehouse as $row) {
                                            $text_select="";
                                            /*if($row['id']==$invoice['almacen_seleccionado']){
                                                $text_select='selected="true"';
                                            }*/
                                            echo '<option value="' . $row['id'] . '">' . $row['title'] . '</option>';
                                        } ?>
                                </select>
                            </div>
                    </div>
                    </div>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" class="form-control required"
                               name="tid" id="invoiceid" value="<?php echo $invoice['tid'] ?>">
                        <button type="button" class="btn btn-default"
                                data-dismiss="modal"><?php echo $this->lang->line('Close') ?></button>
                        <input type="hidden" id="action-url" value="purchase/update_status">
                        <button type="button" class="btn btn-primary"
                                id="submit_model"><?php echo $this->lang->line('Change Status') ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(function () {
        $('.summernote').summernote({
            height: 100,
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

    $(document).on('click', "#cancel-bill_p", function (e) {
        e.preventDefault();

        $('#cancel_bill').modal({backdrop: 'static', keyboard: false}).one('click', '#send', function (){
            var acturl = 'transactions/cancelpurchase';
            cancelBill(acturl);

        });
    });
    estado_orden_compra();
    function estado_orden_compra(){
       var value_selected=$("#status option:selected").val();
        
        if(value_selected=="recibido parcial"){
            $(".sl-cantidades").each(function(item,value){
                
                var id=$(value).attr("id");
                sel="#"+id+" option[value='0']";
                console.log(sel);
                $(sel).prop("selected",true);
                $("#"+id).css("pointer-events","");
            });
            $("#div-resibido").show();
        }else if(value_selected=="recibido"){
            $(".sl-cantidades").each(function(item,value){
                var sel=$(value).data("ultimo-select");
                var id=$(value).attr("id");
                sel="#"+id+" option[value='"+sel+"']";
                console.log(sel);
                $(sel).prop("selected",true);
                $("#"+id).css("pointer-events","none");
            });
            $("#div-resibido").show();
        }else{
            $("#div-resibido").hide();
        }
    }
    action_actualizar_stock();
    function action_actualizar_stock(){
        var seleccionado = $(".update_stock:checked").val();
        if(seleccionado=="no"){
            $("#div-si-actualizar").hide();            
        }else{
            $("#div-si-actualizar").show();
        }
    }
</script>
