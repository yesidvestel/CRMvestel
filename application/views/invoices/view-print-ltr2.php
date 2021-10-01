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
				<?php echo '<strong>'.ucwords($invoice['name']) .' '.ucwords($invoice['unoapellido']) . '</strong><br>';
                if ($invoice['company']) echo $invoice['company'] . '<br>';
                 echo $invoice['tipo_documento'] .': '.$invoice['documento']
					 .'<br>'. $this->lang->line('Email') . ' : ' . $invoice['email']
					 .'<br>Abonado : ' . $invoice['abonado'].'<br>Factura : ' . $invoice['tid'];
                if ($invoice['taxid']) echo '<br>' . $this->lang->line('Tax') . ' ID: ' . $invoice['taxid'];
                ?>
				
            </td>

            <td>
                
            </td>
        </tr><?php if ($invoice['name_s']) { ?>

            <tr>

                
            </tr>
        <?php } ?>
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

        <?php
            $cantidad_total_a_restar=0;
            $cantidad_total=0;
            $lista_a_excluir=array();
			setlocale(LC_TIME, "spanish");
			$f1 = date(" F ",strtotime($invoice['invoicedate']));
            
                
                
                     $transacciones = $this->db->query("select * from transactions where tid=".$invoice['tid']." and id<=".$transaccion->id." and estado is null order by id desc")->result_array();
                     $transacciones2 = $this->db->query("select * from transactions where tid=".$invoice['tid']." and id>".$transaccion->id." and estado is null order by id desc")->result_array();
                     $valores_a_restar=0;

                     foreach ($transacciones2 as $key => $value) {
                         $valores_a_restar+=$value['credit'];
                         $invoice['status']="partial";
                     }//var_dump($valores_a_restar);
                     $invoice['pamnt']-=$valores_a_restar;

                        $valor=$invoice['total'];
                        if(count($transacciones)!=0){                    
                            $valor1=intval($transacciones[0]['credit']);
                            if($valor1!=$invoice['total']){
                                //$valor=$valor-$valor1;
                                $valor=$valor1;
                                $cantidad_total_a_restar+=$valor1;
                            }else{
                                $cantidad_total_a_restar+=$valor1;
                            }
                        }else{
                            $cantidad_total_a_restar+=$valor;

                        }
                        $valor_transacciones=0;
                        //$transacciones = $this->db->query("select * from transactions where tid=".$invoice['tid']." and id>".$transaccion->id." and estado is null order by id desc")->result_array();
                        foreach ($transacciones as $key => $tr) {
                            $valor_transacciones+=$tr['credit'];
                            $valor_transacciones-=$tr['debit'];
                        }
                        $valor_a_cubrir=$invoice['total']-$invoice['pamnt'];
                        if($valor_transacciones>$invoice['total']){
                                $cantidad_total+=$invoice['total']-$valor_transacciones;
                        }
                        //$cantidad_total=-35000;
                        //var_dump($cantidad_total_a_restar);
                        $cantidad_total_a_restar+=$cantidad_total;

                    $porcentaje=($cantidad_total_a_restar*100)/$invoice['total'];
                    $lista_items=$this->db->get_where("invoice_items",array('tid' => $invoice['tid']))->result();

                    foreach ($lista_items as $key => $value) {
                        if($invoice['status']=="paid"){
                            $valor_item=($porcentaje*$value->subtotal)/100;    
                        }else{
                            $valor_item=$value->subtotal;
                            if(count($transacciones)>=2 && $invoice['status']=="partial"){
                                //valor de lo que falta mas la transaccion realizada
                                $valorx=($invoice['total']-$invoice['pamnt'])+$transacciones[0]['credit'];
                                $porcentaje2=($valorx*100)/$invoice['total'];
                                $valor_item=($porcentaje2*$value->subtotal)/100;    

                            }
                        }
                        $cantidad_total+=$valor_item;
                        echo '<tr class="item' . $flag . '"> 
                                <td>'.$value->product.'</td>';
                        echo '<td class="t_center">' . amountExchange( $valor_item) . '</td>
                                </tr>';
                               // $cantidad_total+=$value->subtotal;

                    }
                    //$cantidad_total_a_restar-=$cantidad_total;

                
           
            
          
        

  if ($invoice['shipping'] > 0) { $cols++;}

        ?>


    </table>
    <br>
    <table class="subtotal">

       
        <tr>
            
            <td><strong><?php echo $this->lang->line('Summary') ?>:</strong></td>
            <td></td>


        </tr>
        <tr class="f_summary">


            <td>Cantidad Total:</td>
            <td><?php echo amountExchange($cantidad_total); ?></td>
        </tr>
        <?php 
        if ($invoice['discount'] > 0) {
            echo '<tr>


            <td>' . $this->lang->line('Total Discount') . ':</td>

            <td>' . amountExchange($invoice['discount2'], $invoice['multi2']) . '</td>
        </tr>';

        }
		    
        ?>
        <tr>
			<td><?php echo $this->lang->line('Paid Amount')?></td>

            <td><?php echo amountExchange($cantidad_total_a_restar); ?></td>
		</tr><tr>
            <td><?php echo $this->lang->line('Balance Due') ?>:</td>

            <td><strong><?php $rming = $cantidad_total-$cantidad_total_a_restar;
			
    if ($rming < 0) {
        $rming = 0;

    }
	$user = $this->aauth->get_user()->username;
	$perfil = $this->aauth->get_user()->roleid;
	$rol = user_role($perfil);
    echo amountExchange($rming, $invoice['multi2']);
    echo '</strong></td>
		</tr>
		</table><br>
		<strong>' . $this->lang->line('Status') . ': ' . $this->lang->line(ucwords($invoice['status'])).'</strong>
		<div class="sign2">(' . $user . ')</div><div class="sign3">' . user_role($perfil) . '</div> <div class="terms"><hr><strong>' . $this->lang->line('Terms') . ':</strong>';

    echo '<strong>' . $invoice['termtit'] . '</strong><br>' . $invoice['terms'];
    ?></div>
</div>
</body>
</html>