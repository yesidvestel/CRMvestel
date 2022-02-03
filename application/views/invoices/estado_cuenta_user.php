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
                            /*$validtoken = hash_hmac('ripemd160', $invoice['tid'], $this->config->item('encryption_key'));

                            $link = base_url('billing/view?id=' . $invoice['tid'] . '&token=' . $validtoken);*/ //cuadrar esto despues es para la visualizacion de los clientes sin acceso al sistema?>
                                <div class="title-action">
								
                                

                                <!-- SMS -->
                                

                                <div class="btn-group ">
                                    <button type="button" class="btn btn-success mb-1 btn-min-width dropdown-toggle"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i
                                                class="icon-print"></i> <?php echo $this->lang->line('Print') ?>
                                    </button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item"
                                           href="<?php echo 'printinvoice_proforma?id=' . $customer->id; ?>"><?php echo $this->lang->line('Print') ?></a>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item"
                                           href="<?php echo 'printinvoice_proforma?id=' . $customer->id; ?>&d=1"><?php echo $this->lang->line('PDF Download') ?></a>

                                    </div>
                                </div>                               
                                </div>
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
                            <ul class="pb-1"> <?php echo 'Usuario #' . $customer->id . '</p>
                            <ul class="pb-1">'.Sede .': ' . $customer->ciudad . '</p>'; ?>
                            <ul class="px-0 list-unstyled">
                                <li><?php echo $this->lang->line('Gross Amount') ?></li>
                                <li class="lead text-bold-800" id="total1"><?php echo amountFormat(0) ?></li>
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
                                            href="<?php echo base_url('customers/view?id=' . $customer->id) ?>"><strong
                                                class="invoice_a"><?php echo ucwords($customer->name) .' '.ucwords($customer->unoapellido).'</strong></a></li><li>' .$customer->tipo_documento.': '. $customer->documento .  '</li><li>'.Celular .': ' . $customer->celular . '</li><li>'.$this->lang->line('Email') .': ' . $customer->email;
                                    
                                                ?>
                                </li>
                            </ul>

                        </div>
                        <div class="offset-md-3 col-md-3 col-sm-12 text-xs-center text-md-left">
                            <?php echo '<p><span class="text-muted">'.$this->lang->line('Invoice Date').'  :</span> ' . dateformat($products[0]['invoicedate']) . '</p> <p><span class="text-muted">'.$this->lang->line('Due Date').' :</span> ' . dateformat((isset($facturas_adelantadas))? $facturas_adelantadas[count($facturas_adelantadas)-1]['fecha_final'] : $products[count($products)-1]['invoiceduedate']) . '</p>';
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
                                        <th>Factura</th>
                                        
                                        <th class="text-xs-left">Items</th>
                                        <th class="text-xs-left"><?php echo $this->lang->line('Rate') ?></th>
                                        <th class="text-xs-left"><?php echo $this->lang->line('Tax') ?></th>
                                        <th class="text-xs-left"><?php echo $this->lang->line('Discount') ?></th>
                                        <th class="text-xs-left"><?php echo $this->lang->line('Amount') ?></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php $c = 1;
                                    
                                    setlocale(LC_TIME, "spanish");
                                    $sub_total=0;
                                    $tax_total=0;
                                    $mostrar=true;
                                    if(count($products)==1 && isset($facturas_adelantadas) && count($facturas_adelantadas)>0){
                                        $query1=$this->db->query("select count(*) as conteo from transactions where tid='".$products[0]['tid']."' and estado is null")->result();    
                                        if($query1[0]->conteo>=2){
                                            $mostrar=false;
                                        }
                                    }
                                    foreach ($products as $row) {

                                        $sub_t += $row['total'];
                                        $servicios_asignados="";
                                        /*if ($row['television'] == no ){
                                                    $servicios_asignados.= '';
                                                } else{
                                                        if($row['estado_tv'] == "Cortado"){
                                                                $servicios_asignados.=  "<b><i class='sts-Cortado'>".$row['television']." (cortado)</i></b>";
                                                        }else if($row['estado_tv'] == "Suspendido"){
                                                                $servicios_asignados.=  "<b><i class='sts-Suspendido'>".$row['television']." (suspendido)</i></b>";
                                                        }else{
                                                            $servicios_asignados.=  $row['television'];    
                                                        }
                                                    }*/
                                           /* if ($row['combo'] == no ){
                                                    $servicios_asignados.=  '';
                                                } else{

                                                     if($row['estado_combo'] == "Cortado"){
                                                                $servicios_asignados.=  " mas <b><i class='sts-Cortado'>".$row['combo']." (cortado)</i></b>";
                                                        }else if($row['estado_combo'] == "Suspendido"){
                                                                $servicios_asignados.=  " mas <b><i class='sts-Suspendido'>".$row['combo']." (suspendido)</i></b>";
                                                        }else{
                                                            $servicios_asignados.=  ' mas '.$row['combo'];
                                                        }
                                                    }*/
                                            /*if ($row['puntos'] == 0 ){
                                                    $servicios_asignados.=  '';
                                                } else{
                                                    $servicios_asignados.=  ' mas '.$row['puntos'].' puntos adicionales';
                                                }*/
                                               $list_items= $this->db->get_where("invoice_items",array("tid"=>$row['tid']))->result_array();
                                               foreach ($list_items as $key => $value) {
                                                   $servicios_asignados.=$value['product'];
                                                   if($key<(count($list_items)-1)){
                                                    $servicios_asignados.=",";
                                                   }
                                               }

                                                $f1 = date(" F ",strtotime($row['invoicedate']));
                                                $transacciones_factura=array();
                                                if($total_customer<0){                                                    
                                                    $transacciones_factura=$this->db->query("select sum(credit-debit) as total_pagado from transactions where tid=".$row['tid']." and estado is null and id!=".$tr_saldo_adelantado['id'])->result_array();                                                    
                                                }else{
                                                    $transacciones_factura=$this->db->query("select sum(credit-debit) as total_pagado from transactions where tid=".$row['tid']." and estado is null")->result_array();                                                                                                        
                                                }
                                                
                                                if(isset($transacciones_factura[0]['total_pagado']) && $transacciones_factura[0]['total_pagado']>0){
                                                            $porcentaje=($transacciones_factura[0]['total_pagado']*100)/$row['total'];
                                                            $row['total']-=$transacciones_factura[0]['total_pagado'];
                                                            $row['subtotal']=$row['subtotal']-(($row['subtotal']*$porcentaje)/100);
                                                            $row['tax']=$row['tax']-(($row['tax']*$porcentaje)/100);    
                                                            if($row['subtotal']==$row['total']){
                                                                $row['subtotal']-=$row['tax'];    
                                                            }
                                                            
                                                }
                                                if($total_customer==0){
                                                    
                                                }
                                                $sub_total+=$row['subtotal'];
                                                $tax_total+=$row['tax'];
                                                if($mostrar){
                                        echo '<tr>
<th scope="row">' . $c . '</th>
                            <td> <a href="'.base_url().'invoices/view?id='.$row['tid'].'">'.ucfirst(strftime("%B", strtotime($f1))).' CTA : ' . $row['tid'] . '</a></td>
                           <td><code>' . $servicios_asignados . '</code></td>
                            <td>' . amountFormat($row['subtotal']) . '</td>                             
                            <td>' . amountFormat($row['tax']) . '</td>
                            <td>' . amountFormat($row['discount']) . '</td>
                            <td>' . amountFormat($row['total']) . '</td>
                        </tr>';

                                        }
                                        $c++;
                                    } 

                                    if(isset($facturas_adelantadas)){
                                        foreach ($facturas_adelantadas as $key => $value) {
                                             echo '<tr>
<th scope="row">' . $c . '</th>
                            <td> '.ucfirst($value['mes']).'</td>
                           <td><code></code></td>
                            <td>' . amountFormat($value['valor_a_colocar']) . '</td>                             
                            <td>' . amountFormat(0) . '</td>
                            <td>' . amountFormat(0) . '</td>
                            <td>' . amountFormat($value['valor_a_colocar']) . '</td>
                        </tr>';
                        $c++;
                                        }
                                    }

                                    ?>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <p></p>
                        <div class="row">
                            <div class="col-md-7 col-sm-12 text-xs-center text-md-left">

<?php $estado_de_user="Cancelado"; 
if(($sub_total+$tax_total)>0){
    $estado_de_user="Debe";
}
if($total_customer==0){
    $estado_de_user="Cancelado";   
}else if($total_customer<0){
    $estado_de_user="Pago Adelantado";
    $sub_total=0;
    $tax_total=0;
} ?>
                                <div class="row">
                                    <div class="col-md-8"><p
                                                class="lead"><?php echo $this->lang->line('Payment Status') ?>:
                                            <u><strong
                                                        id="pstatus"><?php echo $estado_de_user;  ?></strong></u>
                                        </p>
                                        

                                        
                                        
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
                                            <td class="text-xs-right"> <?php echo amountFormat($sub_total) ?></td>
                                        </tr>
                                        <tr>
                                            <td><?php echo $this->lang->line('Tax') ?></td>
                                            <td class="text-xs-right"><?php echo amountFormat($tax_total) ?></td>
                                        </tr>
                                        <tr>
                                            <td><?php echo $this->lang->line('') ?>Descuento</td>
                                            <td class="text-xs-right"><?php echo amountFormat(0) ?></td>
                                        </tr>
                                        <tr>
                                            <td><?php echo $this->lang->line('Shipping') ?></td>
                                            <td class="text-xs-right"><?php echo amountFormat(0) ?></td>
                                        </tr>
                                        <tr>
                                            <td class="text-bold-800"><?php echo $this->lang->line('Total') ?></td>
                                            <td class="text-bold-800 text-xs-right"> <?php echo amountFormat($sub_total+$tax_total) ?></td>
                                        </tr>
                                        
                                        
                                        </tbody>
                                    </table>
                                </div>
                                
                            </div>
                        </div>
                    </div>

                    <!-- Invoice Footer -->

                    <!-- Invoice Footer -->

                    <div id="invoice-footer"><p class="lead">Ultima Transaccion Realizada:</p>
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
                            <?php foreach ($transacciones as $row) {
                                if($row['estado']=="Anulada" ){
                                    $row['note']="<span style='color:red;'>Transaccion Anulada</span>";
                                }else if($this->aauth->get_user()->roleid>=4){
                                    $row['note'].=", <a style='color:blue;' href='".base_url()."transactions/index?id_tr=".$row['id']."'>Ir a Anular<a/>";
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
                    <!--/ Invoice Footer -->
                    <hr>
                    <pre><?php echo $this->lang->line('Public Access URL') ?>: <?php
                        echo $link ?></pre>

                   
                </div>
            </section>
        </div>
    </div>
</div>



<!-- Modal HTML -->



<!-- cancel -->

</div>

<!-- Modal HTML -->

<!--sms-->
<!-- Modal HTML -->





<script type="text/javascript">
    var total="<?= amountFormat($sub_total+$tax_total) ?>";
    $("#total1").text(total);
    <?php if($total_customer<0){echo '$("#total1").text("'.amountFormat($total_customer).'");';} ?>

</script>
