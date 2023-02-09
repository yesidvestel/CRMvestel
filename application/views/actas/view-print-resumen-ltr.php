<!doctype html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title><?=$title ?></title>
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
                       <td colspan="1" class="t_center"><h2 ><?php echo "Reporte Transferencia Material" ?></h2><br><br></td>
                    </tr>
			<tr>
            
			</tr>
			<tr>
            <td>Fecha Elaboracion</td><td><?php echo date("d-m-Y H:i:s"); ?></td>
			</tr>
			
			</table>
			
	
               
            </td>
        </tr>
    </table>

    <br>
    <table class="party">
        <thead>
        <tr class="heading">
            <td> Datos Tecnico :</td>

            <td>Datos Filtro :</td>
        </tr>
        </thead>
        <tbody>
        <tr>
            
            <td>
            <?php if($tecnico_var->id_tecnico!=null) { ?>
                    
                       <strong><?=$tecnico_var->id_tecnico->name ?></strong><br>
                    
                    
                        <?=$tecnico_var->id_tecnico->city ?><br>
                    
                    
                        CC: <?=$tecnico_var->id_tecnico->dto ?><br>
                    
                    
                        Telefono: <?=$tecnico_var->id_tecnico->phone ?><br>
                    
                    
                        Dir: <?=$tecnico_var->id_tecnico->address ?>
                    
                <?php }else{ ?>
                    <strong><?=$tecnico_var->title ?></strong>
                <?php } ?>
            </td>
            <td>
               Fecha Inicial : <?= $fecha_inicial  ?><br>
               Fecha Final : <?=$fecha_final ?>
            </td>
        </tr>
        </tbody>
    </table>
    <br/>
    <table class="plist" cellpadding="0" cellspacing="0">


        <tr class="heading">
            <td >
                #
            </td>
            <td >
                PID
            </td>
                
            <td >
                Nombre
            </td>
            <td >
                Cantidad Transferida
            </td>
            <td >
                Cantidad Gastada
            </td>
            <td >
                Total en Almacen
            </td>

        </tr>

        <?php
        $fill = true;
        $sub_t=0;
        $cols = 1;
        $c_m=0;
        foreach ($lista_productos as $pr) {

            
			
            if ($fill == true) {
                $flag = ' mfill';				
            } else {
                $flag = '';
            }
            
			if(empty($pr['cantidad_gastada'])){
                $pr['cantidad_gastada']=0;
            }

            echo '<tr class="item' . $flag . '">'; 
            echo '<td>' . $cols . '</td>';
                       echo '<td>' . $pr['pid'] . '</td>
                           
                            <td>' .$pr['name']. '</td>
                             <td>' . $pr['cant_transferida']. '</td>
                            <td>' . $pr['cantidad_gastada'] . '</td>
                            <td>' . ($pr['cant_transferida']-$pr['cantidad_gastada']). '</td>';
            echo '</tr>';

            $fill = !$fill;
            $cols++;        
         
        }

  

        ?>


    </table>
    <br>
    
            <br>
            <table>
                <tr>
                    <td align="left">Generado Por:<br>
                       <?php echo '<img src="' . FCPATH . 'userfiles/employee_sign/' . $employee->sign . '" alt="signature" class="height-50" width="30%"/>
                                    <h6>(' . $employee->name . ')</h6>
                                    <p class="text-muted">' . user_role($employee_aauth_users->roleid) . '</p>'; ?>
                    </td>
                    
                </tr>
            </table>

    
</div>
</body>
</html>