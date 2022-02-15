<!doctype html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Estado Usuario#<?php echo $id ?></title>
    <style>	
        body {
            color: #2B2000;
			font-family: 'Helvetica';						
        }
        .invoice-box {
            width: 210mm;
            height: 297mm;
            margin: auto;
            padding: 4mm;
            border: 0;
            font-size: 12pt;
            line-height: 14pt;
            color: #000;
        }

        table {
            width: 100%;
            line-height: 16pt;
            text-align: left;
			border-collapse: collapse;
        }

        .plist tr td {
            line-height: 12pt;
        }

        .subtotal tr td {
            line-height: 10pt;
		    padding: 6pt;
        }

		.subtotal tr td {          
			border: 1px solid #ddd;
        }

        .sign {
            text-align: right;
            font-size: 10pt;
            margin-right: 110pt;
        }

        .sign1 {
            text-align: right;
            font-size: 10pt;
            margin-right: 90pt;
        }

        .sign2 {
            text-align: right;
            font-size: 10pt;
            margin-right: 115pt;
        }

        .sign3 {
            text-align: right;
            font-size: 10pt;
            margin-right: 115pt;
        }

        .terms {
            font-size: 9pt;
            line-height: 16pt;
			margin-right:20pt;
        }

        .invoice-box table td {
            padding: 10pt 4pt 8pt 4pt;
            vertical-align: top;

        }

		.invoice-box table.top_sum td {
            padding: 0;
			font-size: 12pt;
        }

        .party tr td:nth-child(3) {
            text-align: center;
        }

		.centeral {
            text-align: center;
        }

        .invoice-box table tr.top table td {
            padding-bottom: 20pt;

        }

        table tr.top table td.title {
            font-size: 45pt;
            line-height: 45pt;
            color: #555;
        }

        table tr.information table td {
            padding-bottom: 20pt;
        }

        table tr.heading td {
            background: #515151;
            color: #FFF;
            padding: 6pt;

        }

       table tr.details td {
            padding-bottom: 20pt;
        }

		   .invoice-box table tr.item td{
            border: 1px solid #ddd;
        }

        table tr.b_class td{
            border-bottom: 1px solid #ddd;
        }

       table tr.b_class.last td{
            border-bottom: none;
        }

        table tr.total td:nth-child(4) {
            border-top: 2px solid #fff;
            font-weight: bold;
        }

        .myco {
            width: 350pt;
        }

        .myco2 {
            width: 300pt;
        }

        .myw {
            width: 290pt;
            font-size: 14pt;
            line-height: 14pt;
			
        }

        .mfill {
            background-color: #eee;
        }

		 .descr {
            font-size: 10pt;
            color: #515151;
        }

        .tax {
            font-size: 10px;
            color: #515151;
        }

        .t_center {
            text-align: right;

        }
		.party {
		border: #ccc 1px solid;
		}
		
        
    </style>
</head>

<body <?php if(LTR=='rtl') echo'dir="rtl"'; ?>>

<div class="invoice-box">
    <table>
        <tr>
            <td class="myco">
                <img src="<?php echo FCPATH . 'userfiles/company/' . $this->config->item('logo') ?>" style="max-width:260px;">
            </td>
            <td>

            </td>
            <td class="myw">
			<table class="top_sum">
   <tr>
                       <td colspan="1" class="t_center"><h2 >Estado del Usuario</h2><br><br></td>
                    </tr>
			<tr>
            <td>Usuario&nbsp;</td><td><?php echo '#' . $id ?></td>
			</tr>
			
			<?php if($customer->ciudad) { ?>
			<tr>
            <td><?php echo $this->lang->line('Reference') ?></td><td><?php echo $customer->ciudad ?></td>
			</tr>
			<?php } ?>
			</table>
			
	
               
            </td>
        </tr>
    </table>

    <table class="party">
        <thead>
        <tr class="heading">
            <td> <?php echo $this->lang->line('Our Info') ?>:</td>

            <td><?php echo $this->lang->line('Customer') ?>:</td>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td><strong><?php echo $this->config->item('ctitle'); ?></strong><br>
                <?php echo
                    $this->config->item('address') . '<br>' . $this->config->item('city') . ',' . $this->config->item('country') . '<br>'.$this->lang->line('Phone').': ' . $this->config->item('phone') . '<br> '.$this->lang->line('Email').': ' . $this->config->item('email');
                if ($this->config->item('taxno')) echo '<br>' . $this->lang->line('Tax') . ' ID: ' . $this->config->item('taxno');
                ?>
            </td>

            <td>
                <?php echo '<strong>'.$customer->name .' '. $customer->dosnombre .'</strong><br>';
                echo $customer->unoapellido .' '. $customer->dosapellido .  '<br>';
                echo $customer->departamento .'/'.$customer->ciudad . '<br>' .$customer->tipo_documento.': ' .$customer->documento . '<br>'.$this->lang->line('Phone').': ' . $customer->celular . '<br>' . $this->lang->line('Email') . ' : ' . $customer->email;
                
                ?>
            </td>
        </tr>
        </tbody>
    </table>
    <br/>
    <table class="plist" cellpadding="0" cellspacing="0">


        <tr class="heading">
             <td>
               #
            </td>
            <td>
                Factura
            </td>
            <td>
                Items
            </td>
            <td>
                <?php echo $this->lang->line('Price') ?>
            </td>
           

            <?php  echo '<td>' . $this->lang->line('Tax') . '</td>';

             ?>
            <td class="t_center">
                <?php echo $this->lang->line('SubTotal') ?>
            </td>
        </tr>

        <?php
        $fill = true;
        $sub_t=0;
        $c=1;
      $mostrar=true;
        if(count($products)==1 && isset($facturas_adelantadas) && count($facturas_adelantadas)>0){
            $query1=$this->db->query("select count(*) as conteo from transactions where tid='".$products[0]['tid']."' and estado is null")->result();    
            if($query1[0]->conteo>=2){
                $mostrar=false;
            }
        }
        setlocale(LC_TIME, "spanish");
        foreach ($products as $row) {

            $cols = 3;
			
            if ($fill == true) {
                $flag = ' mfill';				
            } else {
                $flag = '';
            }
            $sub_t+=$row['price']*$row['qty'];
			
//codigo x

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
            }
    if ($row['combo'] == no ){
            $servicios_asignados.=  '';
        } else{

             if($row['estado_combo'] == "Cortado"){
                        $servicios_asignados.=  " mas <b><i class='sts-Cortado'>".$row['combo']." (cortado)</i></b>";
                }else if($row['estado_combo'] == "Suspendido"){
                        $servicios_asignados.=  " mas <b><i class='sts-Suspendido'>".$row['combo']." (suspendido)</i></b>";
                }else{
                    $servicios_asignados.=  ' mas '.$row['combo'];
                }
            }
    if ($row['puntos'] == 0 ){
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
        
        $sub_total+=$row['subtotal'];
        $tax_total+=$row['tax'];

// end codigo x

if($mostrar){
            echo '<tr class="item' . $flag . '"> <td>'.$c.'</td>
                            <td>' . ucfirst(strftime("%B", strtotime($f1))).' CTA : ' . $row['tid'] . '</td>
                            <td> <code>' . $servicios_asignados.'</code></td>
							<td style="width:12%;">' . amountExchange($row['subtotal']) . '</td>
                            ';
             $cols++; echo '<td style="width:16%;">' . amountExchange($row['tax']) . ' </td>';
            
            echo '<td class="t_center">' . amountExchange($row['total']) . '</td>
                        </tr>';
           
            $fill = !$fill;
            $c++;
          }
        }

  if(isset($facturas_adelantadas)){
                                        foreach ($facturas_adelantadas as $key => $value) {

                                            $cols = 3;
            
            if ($fill == true) {
                $flag = ' mfill';               
            } else {
                $flag = '';
            }
            echo '<tr class="item' . $flag . '"> <td>'.$c.'</td>
                            <td>' . ucfirst($value['mes']) . '</td>
                            <td></td>
                            <td style="width:12%;">' . amountFormat($value['valor_a_colocar'])  . '</td>
                            ';
            $cols++; echo '<td style="width:16%;">' . amountExchange(0) . ' </td>'; 
            
            echo '<td class="t_center">' . amountFormat($value['valor_a_colocar'])  . '</td>
                        </tr>';
           
            $fill = !$fill;
            $c++;



                                             
                                        }
                                    }

        ?>


    </table>

    <br>
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
    <table class="subtotal">

       
        <tr>
            <td class="myco2" rowspan="<?php echo $cols ?>"><br><br><br>
                <p><?php echo '<strong>' . $this->lang->line('Status') . ': ' . ucwords($estado_de_user).'</strong></p>'; ?>
            </td>
            <td><strong><?php echo $this->lang->line('Summary') ?>:</strong></td>
            <td></td>


        </tr>
        <tr class="f_summary">


            <td><?php echo $this->lang->line('SubTotal') ?>:</td>

            <td><?php echo amountExchange($sub_total); ?></td>
        </tr>
        <?php 
            echo '<tr>        

            <td> ' . $this->lang->line('Total Tax') . ' :</td>

            <td>' . amountExchange($tax_total) . '</td>
        </tr>';
        
        
            echo '<tr>


            <td> Total:</td>

            <td>' . amountExchange($sub_total+$tax_total) . '</td>
        </tr>';

        

        
        ?>
        <tr>


            <td><?php echo $this->lang->line('Balance Due') ?>:</td>

            <td colspan="2" align="center"><strong><?php
     $rming = $invoice['total'] - $invoice['pamnt'];
    if ($rming < 0) {
        $rming = 0;

    }
    $x=$sub_total+$tax_total;
    if($total_customer<0){
        $x=$total_customer;
    }
    echo amountExchange($x);
    echo '</strong></td>
		</tr>
		</table>
        <br>';
        if(isset($data['employee']) && isset($employee['name']) ) {
            '<div class="sign">'.$this->lang->line('Authorized person').'</div><div class="sign1"></div><div class="sign2">(' . $employee['name'] . ')</div><div class="sign3">' . user_role($employee['roleid']) . '</div> ';    
        }
        
?>
<p class="lead">Ultima Transaccion Realizada:</p>
                        <table class="plist" cellpadding="0" cellspacing="0">
                           
                            <tr class="heading">
                                <td><?php echo $this->lang->line('Date') ?></td>
                                <td><?php echo $this->lang->line('Method') ?></td>
                                <td><?php echo $this->lang->line('Amount') ?></td>
                                <td><?php echo $this->lang->line('Note') ?></td>
                            </tr>
                            
                            
                            <?php foreach ($transaccion as $row) {
                                if($row['estado']=="Anulada" ){
                                    $row['note']="<span style='color:red;'>Transaccion Anulada</span>";
                                }else if($this->aauth->get_user()->roleid>=4){
                                    
                                }
                                if($row['type']=="Expense"){
                                    $row['credit']="-".$row['debit'];
                                }
                                echo '<tr class="item mfill">
                            <td>' . $row['date'] . '</td>
                            <td>' . $this->lang->line($row['method']) . '</td>
                            <td>' . amountFormat($row['credit']) . '</td>
                            <td>' . $row['note'] . '</td>
                        </tr>';//mfill
                            } ?>
                            
                        </table>

<?php  
        
?>
    


</div>
</body>
</html>