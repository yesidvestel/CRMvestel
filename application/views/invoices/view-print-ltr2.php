<!doctype html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Print Invoice #<?php echo $invoice['tid'] ?></title>
    <style>
        body {
            color: #2B2000;
			font-family: 'Helvetica';
        }
        .invoice-box {
            width: 100%;
            height: 297mm;
            margin: auto;
            padding: 4mm;
            border: 0;
            font-size: 12pt;
            line-height: 12pt;
            color: #000;
        }

        table {
            width: 100%;
            line-height: 14pt;
            text-align: left;
			border-collapse: collapse;
        }

        .plist tr td {
            line-height: 9pt;
        }

        .subtotal tr td {
            line-height: 5pt;
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
            text-align: center;
            font-size: 10pt;
            margin-right: 90pt;
			width: 100%;
        }

        .sign2 {
            text-align: center;
            font-size: 10pt;
            margin-right: 115pt;
			width: 100%;
        }

        .sign3 {
            text-align: center;
            font-size: 10pt;
            margin-right: 115pt;
			width: 100%;
        }

        .terms {
            font-size: 9pt;
            line-height: 2pt;
			margin-right:20pt;
			width: 100%;
        }

        .invoice-box table td {
            padding: 6pt 4pt 5pt 4pt;
            vertical-align: center;

        }

		.invoice-box table.top_sum td {
            padding: 0;
			font-size: 12pt;
        }

        .party tr td:nth-child(3) {
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
            width: 40mm;
        }

        .myco2 {
            width: 20mm;
        }

        .myw {
            width: 100%;
            font-size: 14pt;
            line-height: 14pt;
			text-align: center;

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
            text-align: center;

        }
		.party {
		border: #ccc 1px solid;
        margin-top: -50px;
		}


    </style>
</head>

<body>

<div class="invoice-box" >


    <br>
    <table class="party" >
        <thead>
        <tr>
         
        </tr>
        </thead>
        <tbody>
        <tr>
            <td >
				<?php echo '<strong>'.ucwords($customer->name) .' '.ucwords($customer->unoapellido) . '</strong><br>';
                if ($customer->company) echo $customer->company . '<br>';
                 echo $customer->tipo_documento .': '.$customer->documento
					 .'<br>'. $this->lang->line('Email') . ' : ' . $customer->email
					 .'<br>Abonado : ' . $customer->abonado
                ?>
				
            </td>

            <td>
                
            </td>
        </tr>
        </tbody>
    </table>
    <br/>
    <table class="plist" cellpadding="0" cellspacing="0">


        <tr class="heading">
            <td>
                <?php echo $this->lang->line('Description') ?>
                
            </td>

            
            <td class="t_center">
                <?php echo $this->lang->line('SubTotal') ?>
            </td>
        </tr>

        <?php $c = 1;
                                    
                                    setlocale(LC_TIME, "spanish");
                                    $sub_total=0;
                                    $tax_total=0;
                                    foreach ($products as $row) {

                                        $sub_t += $row['total'];
                                        $servicios_asignados="";
                                        if ($row['television'] == no ){
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
                                                }
                                                
                                                $sub_total+=$row['subtotal'];
                                                $tax_total+=$row['tax'];


                                                echo '<tr class="item' . $flag . '"> 
                                                            <td>' . ucfirst(strftime("%B", strtotime($f1))).' CTA : ' . $row['tid'] .'</td>';
                                                echo '<td class="t_center">' . amountExchange($row['total']) . '</td>
                                                            </tr>';                                        
                                       
                                    } 

                                    if(isset($facturas_adelantadas)){
                                        foreach ($facturas_adelantadas as $key => $value) {
                                             echo '<tr class="item' . $flag . '"> 
                                                            <td>' . ucfirst($value['mes']).' CTA : ' . $row['tid'] .'</td>';
                                                echo '<td class="t_center">' . amountExchange($value['valor_a_colocar']) . '</td>
                                                            </tr>'; 
                                                                                
                       
                                        }
                                    }

                                    ?>
<?php $estado_de_user="Cancelado"; 
if(($sub_total+$tax_total)>0){
    $estado_de_user="Debe";
}
if($total_customer==0){
    $estado_de_user="Cancelado";   
}else if($total_customer<0){
    $estado_de_user="Pago Adelantado";
    $sub_total=$total_customer;
    $tax_total=0;
} ?>

    </table>
    <br>
    <table class="subtotal">

       
        <tr>
            
            <td><strong><?php echo $this->lang->line('Summary') ?>:</strong></td>
            <td></td>


        </tr>
        <tr class="f_summary">


            <td>Cantidad Total:</td>
            <td><?php echo amountExchange($sub_total+$tax_total); ?></td>
        </tr>
        
        <tr>
			<td><?php echo $this->lang->line('Paid Amount')?></td>

            <td><?php echo amountExchange(0); ?></td>
		</tr><tr>
            <td><?php echo $this->lang->line('Balance Due') ?>:</td>

            <td><strong><?php $rming = $cantidad_total-$cantidad_total_a_restar;
			
    if ($rming < 0) {
        $rming = 0;

    }
	$user = $this->aauth->get_user()->username;
	$perfil = $this->aauth->get_user()->roleid;
	$rol = user_role($perfil);
    echo amountExchange($sub_total+$tax_total);
    echo '</strong></td>
		</tr>
		</table><br>
		<strong>' . $this->lang->line('Status') . ':'.$estado_de_user.'</strong>
		<div class="sign2">(' . $user . ')</div><div class="sign3">' . user_role($perfil) . '</div> <div class="terms"><hr><strong>' . $this->lang->line('Terms') . ':</strong>';

    //echo '<strong>' . $invoice['termtit'] . '</strong><br>' . $invoice['terms'];
    ?></div>
</div>
</body>
</html>