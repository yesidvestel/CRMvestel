<!doctype html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Print Proforma #<?php echo $invoice['tid'] ?></title>
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
            line-height: 1.5;
		    padding: 6pt;
			text-align: justify;
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

<body <?php if(LTR=='rtl') echo'dir="rtl"';
	  $fecha=date('d/m/Y')
	  ?>>

<div class="invoice-box">
    <table>
        <tr>
            <td class="myco">
                <img src="<?php echo FCPATH . 'userfiles/company/' . $this->config->item('logo') ?>" style="max-width:180px;">
            </td>
            <td>

            </td>
            <td class="myw">
			<table class="top_sum">
   <tr>
                       <td colspan="1" class="t_center"><h2 >PAZ Y SALVO</h2><br><br></td>
                    </tr>
			<tr>
            <td><?php echo $this->lang->line('') ?>Cuenta Nº&nbsp;</td><td><?php echo $usuario['documento'] ?></td>
			</tr>
			<tr>
            <td><?php echo $this->lang->line('') ?>Fecha de generacion</td><td><?php echo $fecha ?></td>
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

    <table class="party">
        <thead>
        <tr class="heading">
            <td> <?php echo $this->lang->line('') ?>Informacion de usuario:</td>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td>
                <?php echo '<strong>'.$usuario['name'] .' '. $usuario['unoapellido'] .'</strong><br>';
                echo $usuario['tipo_documento'] .' '. $usuario['documento'] .  '<br>';
                echo $ciudad['ciudad'].', ' .$dto['departamento'] . '<br>Celular : ' . $usuario['celular'] . '<br>' . $this->lang->line('Email') . ' : ' . $usuario['email'];
                //if ($invoice['taxid']) echo '<br>' . $this->lang->line('Tax') . ' ID: ' . $invoice['taxid'];
                ?>
            </td>

           
        </tr>
        </tbody>
    </table>
    <br>
    <table class="subtotal">
        <tr>
            <td rowspan="<?php echo $cols ?>">
                Cordial saludo,
				<br>
				<br>
				<p>Atendiendo su solicitud nos permitimos informarle que se encuentra a <strong>PAZ Y SALVO </strong>de sus obligaciones con la empresa de telecomunicaciones VESTEL S.A.S. con el número de abonado <?php echo '<strong>'. $usuario['documento'].'</strong>, ubicado en el barrio ' . $barrio['barrio'] . ' en la direccion ' . $usuario['nomenclatura'].' '. $usuario['numero1'].$usuario['adicionauno'].' # '.$usuario['numero2'].$usuario['adicional2'].' - '.$usuario['numero3'].'.'; ?></p>
				<br>
				<br>
					Cualquier información adicional con gusto la atenderemos en nuestras líneas de Atención al Usuario marcando al <strong>PBX 601 9171700</strong> a través de llamadas o WhatsApp.
				<br>
				<br>
				<br>
					Cordialmente, 
				
            </td>


        </tr>
		</table><br><br><br><br><br>
	<table style="width: 300px;">
		<tr>
			<td style="border-bottom-color: aqua">
				<img src="<?php echo FCPATH . 'userfiles/employee_sign/' . $empleado['sign']  ?>" alt="signature" style="height: 60px"/>
				<hr>
				<strong><?php echo $empleado['name'] ?></strong><br>
				SUSPENSIONES<br>
				VESTEL S.A.S
			</td>
		</tr>
	</table>
</div>
</body>
</html>