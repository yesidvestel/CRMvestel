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
                       <td colspan="1" class="t_center"><h2 >Orden de servicio</h2><br><br></td>
                    </tr>
			<tr>
            <td><?php echo $this->lang->line('Order') ?></td><td><?php  echo  $thread_info['codigo'] ?></td>
			</tr>
			<tr>
            <td><?php echo $this->lang->line('Order Date') ?></td><td><?php echo $thread_info['created'] ?></td>
			</tr>
			<tr>
            <td><?php echo $this->lang->line('Due Date') ?></td><td><?php echo $thread_info['fecha_final'] ?></td>
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
            <td> Datos de usuario:</td>

            <td></td>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td><strong><?php echo $thread_info['name'].' '.$thread_info['dosnombre'].' '.$thread_info['unoapellido'].' '.$thread_info['dosapellido'] ?></strong><br>
                <?php echo
                    '<strong>Documento:</strong> ' . $thread_info['documento'] . 
					'<br> <strong>Abonado: </strong>' . $thread_info['abonado']. 
					'<br><strong>Celular:</strong> ' . $thread_info['celular'].
					'<br><strong>Direccion:</strong> ' . $thread_info['nomenclatura'].' '. $thread_info['numero1']. $thread_info['adicionauno'].' N°'. $thread_info['numero2']. $thread_info['adicional2'].' - '. $thread_info['numero3'].
					'<br><strong>Referencia:</strong> ' . $thread_info['residencia'].'/'. $thread_info['referencia'];
                ?>
            </td>

            <td>
                <?php echo 					
					'<br><strong>Barrio:</strong> ' . $barrio2['barrio'];
					if($thread_info['coor1']!=''){
						echo '<br><strong>Coordenadas:</strong> ' . $thread_info['coor1'].' '.$thread_info['coor2'];	
					}
               		echo '<br><strong>Estado:</strong> <span id="pstatus">' . $thread_info['status'];
               		echo '<br><strong>Servicios Contratados:</strong> <span id="pstatus">' . $tv.' '.$inter;
					echo '<br><strong>Equipo Asignado:</strong> <span id="pstatus">' . $thread_info['macequipo'].'<strong>'.$equipo->t_instalacion.'</strong><strong> V:</strong>'.$equipo->vlan.'<strong> N:</strong>'.$equipo->nat.'<strong> PN:</strong>'.$equipo->puerto;
                ?>
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
        </tr>
		<tr class="item">
			<td> 
				<?php echo '<strong>'.$thread_info['detalle'].'</strong><br>'.
				strip_tags($thread_info['section']);?>
			
			</td>
		</tr>
    </table>
    <br>
            <?php ;
    if ($rming < 0) {
        $rming = 0;

    }
    
    echo '
		</tr>
		</table><br><div class="sign">Realizado por:</div><div class="sign1"><img src="' . FCPATH . 'userfiles/employee_sign/' . $employee['sign'] . '" width="160" height="50" border="0" alt=""></div><div class="sign2">' . $employee['name'] . '</div><div class="sign3">' . user_role($employee['']) . '</div> <div class="terms">' . $invoice['notes'] . '<hr>';
    ?></div>
</div>
</body>
</html>