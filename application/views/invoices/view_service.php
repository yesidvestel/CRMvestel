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
                            
                            if ($invoice['status'] != 'canceled') { ?>
                                <?php 
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
                            <ul class="pb-1">'.Sede .': ' . $invoice['refer'] . '</p>'; ?>
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
                                            href="#"><strong
                                                class="invoice_a"><?php echo ucwords($invoice['name']) .' '.ucwords($invoice['unoapellido']).'</strong></a></li><li>' .$invoice['tipo_documento'].': '. $invoice['documento'] .  '</li><li>'.Celular .': ' . $invoice['celular'] . '</li><li>'.$this->lang->line('Email') .': ' . $invoice['email'];
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
                                        echo '<tr>
<th scope="row">' . $c . '</th>
                            <td>' . $row['product'] . '</td>
                           
                            <td>' . amountFormat($row['price']) . '</td>
                             <td>' . $row['qty'] . '</td>
                            <td>' . amountFormat($row['totaltax']) . ' (' . amountFormat_s($row['tax']) . '%)</td>
                            <td>' . amountFormat($row['totaldiscount']) . ' (' .amountFormat_s($row['discount']).$this->lang->line($invoice['format_discount']).')</td>
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
												if ($invoice['television'] == no ){
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
											if ($invoice['combo'] == no ){
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

                    <div id="invoice-footer"><p class="lead"><?php echo $this->lang->line('Credit Transactions') ?>:</p>
                        <table class="table table-striped">
                            <thead>
                            <tr>
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
                                    $row['note'].="";
                                }
                                if($row['type']=="Expense"){
                                    $row['credit']="-".$row['debit'];
                                }
                                echo '<tr>
                            <td>' . $row['date'] . '</td>
                            <td>' . $this->lang->line($row['method']) . '</td>
                            <td>' . amountFormat($row['credit']) . '</td>
                            <td>' . $row['note'] . '</td>
                        </tr>';
                            } ?>

                            </tbody>
                        </table>

                        

                    </div>
                    <!--/ Invoice Footer -->
                    
                </div>
            </section>
        </div>
    </div>
</div>



<!-- Modal HTML -->



<!-- cancel -->

</div>

<!-- Modal HTML -->






