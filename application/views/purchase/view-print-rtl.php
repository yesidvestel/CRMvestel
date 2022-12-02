<!doctype html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Print Purchase Order #<?php echo $invoice['tid'] ?></title>
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
            width: 400pt;
        }

        .myco2 {
            width: 300pt;
        }

        .myw {
            width: 240pt;
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

<body>

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
                       <td colspan="1" class="t_center"><h2 ><?php echo $this->lang->line('Purchase Order') ?></h2><br><br></td>
                    </tr>
			<tr>
            <td><?php echo $this->lang->line('Order') ?></td><td><?php  echo  prefix(2). $invoice['tid'] ?></td>
			</tr>
			<tr>
            <td><?php echo $this->lang->line('Order Date') ?></td><td><?php echo $invoice['invoicedate'] ?></td>
			</tr>
			<tr>
            <td><?php echo $this->lang->line('Due Date') ?></td><td><?php echo $invoice['invoiceduedate'] ?></td>
			</tr>
			<?php if($invoice['refer']) { ?>
			<tr>
            <td><?php echo $this->lang->line('') ?>Sede</td><td><?php echo $invoice['refer'] ?></td>
			</tr>
			<?php } ?>
			</table>
			
	
               
            </td>
        </tr>
    </table>

    <br>
    <table class="party">
        <thead>
        <tr class="heading">
            <td> <?php echo $this->lang->line('Our Info') ?>:</td>

            <td><?php echo $this->lang->line('Supplier') ?>:</td>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td><strong><?php echo $this->config->item('ctitle'); ?></strong><br>
                <?php echo
                    $this->config->item('address') . '<br>' . $this->config->item('city') . ', ' . $this->config->item('region') .'<br>'. $this->config->item('country') . $this->config->item('') . '<br>'.$this->lang->line('Phone').': ' . $this->config->item('phone') . '<br> '.$this->lang->line('Email').': ' . $this->config->item('email') ;
                if ($this->config->item('postbox')) echo '<br>' . $this->lang->line('') . ' NIT: ' . $this->config->item('postbox');
                ?>
            </td>

            <td>
                <?php echo '<strong>'.$invoice['name'] . '</strong><br>';
                if ($invoice['company']) echo $invoice['company'] . '<br>';
               echo $invoice['address'] . '<br>' . $invoice['city'] . ', ' . $invoice['region'] . '<br>' . 'Nº Cuenta: ' . $invoice['cuenta'] . '-' . $invoice['typo'] . '<br>'.'Banco'.': ' . $invoice['banco'] . '<br>' . $this->lang->line('Email') . ' : ' . $invoice['email']. '<br>' . $this->lang->line('') . ' Categoria: ' . $invoice['idcat'];
                if ($invoice['taxid']) echo '<br>' . $this->lang->line('Tax') . ' ID: ' . $invoice['taxid'];
                ?>
            </td>
        </tr>
        </tbody>
    </table>
    <br/>
    <table class="plist" cellpadding="0" cellspacing="0">


        <tr class="heading">
            <td width="50%">
                <?php echo $this->lang->line('Description') ?>
            </td>

            <?php /*?><td width="10%">
                <?php echo $this->lang->line('Price') ?>
            </td><?php */?>
            <td width="20%">
                <?php echo $this->lang->line('Qty') ?>
            </td>

            <?php /*?><?php if ($invoice['tax'] > 0) echo '<td width="10%">' . $this->lang->line('Tax') . '</td>';

            if ($invoice['discount'] > 0) echo '<td width="10%">' . $this->lang->line('Discount') . '</td>'; ?><?php */?>
            <td width="30%" class="t_center">
                <?php echo $this->lang->line('') ?>Observaciones
            </td>
        </tr>

        <?php
        $fill = true;
        $sub_t=0;
        foreach ($products as $row) {

            $cols = 3;
			
            if ($fill == true) {
                $flag = ' mfill';				
            } else {
                $flag = '';
            }
            $sub_t+=$row['price']*$row['qty'];
			

            echo '<tr class="item' . $flag . '"> 
                            <td>' . $row['product'] . '</td>
							
                            <td style="width:6%;" >' . $row['qty'] . '</td>   ';
            //if ($invoice['tax'] > 0)  { $cols++; echo '<td style="width:16%;">' . amountExchange($row['totaltax'], $invoice['multi']) . ' <span class="tax">(' . amountFormat_s($row['tax']) . '%)</span></td>'; }
//            //if ($invoice['discount'] > 0) {   $cols++; echo ' <td style="width:16%;">' . amountExchange($row['totaldiscount'], $invoice['multi']) . '</td>'; }
            echo '<td class="t_center">' . $row[''] . '</td>
                        </tr>';
           //if($row['product_des'])  { $cc=$cols+1; echo '<tr class="item' . $flag . ' descr"> 
//                            <td colspan="'.$cc.'">' . $row['product_des'] . '<br>&nbsp;</td>
//							
//                        </tr>'; }
            $fill = !$fill;
          
        }

  if ($invoice['shipping'] > 0) { $cols++;}

        ?>


    </table>
    <br>
    <table class="subtotal">

       
        <tr>
            <td class="myco2" rowspan="<?php echo $cols ?>">
                
            </td>
            <td colspan="2"><strong><?php echo $this->lang->line('') ?>Datos quien recibe</strong></td>
            


        </tr>
        <tr class="f_summary">
            <td width="10%"><?php echo $this->lang->line('') ?>Nombre:</td>
            <td width="30%"></td>
        </tr>
        <tr>
        	<td>Cc o Nit:</td>
            <td></td>            
        </tr>
        
        	      
      	<tr>
            <td><?php echo $this->lang->line('B') ?>FIRMA</td>
            <td>Fecha Rdo:</td>
            <td></td>
		</tr>
        </table>
            <?php ;
    if ($rming < 0) {
        $rming = 0;

    }
    
    echo '
		</tr>
		</table><br><div class="sign">'.$this->lang->line('Authorized person').'</div><div class="sign1"><img src="' . FCPATH . 'userfiles/employee_sign/' . $employee['sign'] . '" width="160" height="50" border="0" alt=""></div><div class="sign2">' . $employee['name'] . '</div><div class="sign3">' . user_role($employee['']) . '</div> <div class="terms">' . $invoice['notes'] . '<hr><strong>' . $this->lang->line('Terms') . ':</strong><br>';

    echo '<strong>' . $invoice['termtit'] . '</strong><br>' . $invoice['terms'];
    ?></div>
</div>
</body>
</html>