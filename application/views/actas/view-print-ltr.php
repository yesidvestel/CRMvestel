<!doctype html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Acta de Transferencia de Material #<?php echo $id_acta ?></title>
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
                       <td colspan="1" class="t_center"><h2 ><?php echo "Acta de Transferencia de Material" ?></h2><br><br></td>
                    </tr>
			<tr>
            <td>Acta </td><td><?php  echo  "#".$id_acta ?></td>
			</tr>
			<tr>
            <td>Fecha Elaboracion</td><td><?php echo (new DateTime($acta->fecha))->format("d-m-Y H:i:s"); ?></td>
			</tr>
			
			</table>
			
	
               
            </td>
        </tr>
    </table>

    <br>
    <table class="party">
        <thead>
        <tr class="heading">
            <td> Almacen Origen :</td>

            <td>Almacen Destino :</td>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td>
                <strong><?=$almacen_origen->title ?></strong><br>
                <?=$almacen_origen->extra ?>
            </td>
            <td>
            <?php if($almacen_destino->id_tecnico!=null) { ?>
                    
                       <strong><?=$almacen_destino->id_tecnico->name ?></strong><br>
                    
                    
                        <?=$almacen_destino->id_tecnico->city ?><br>
                    
                    
                        CC: <?=$almacen_destino->id_tecnico->dto ?><br>
                    
                    
                        Telefono: <?=$almacen_destino->id_tecnico->phone ?><br>
                    
                    
                        Dir: <?=$almacen_destino->id_tecnico->address ?>
                    
                <?php }else{ ?>
                    <strong><?=$almacen_destino->title ?></strong>
                <?php } ?>
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
                Nombre
            </td>
                
            <td >
                PID Origen
            </td>
            <td >
                PID Destino
            </td>
            <td >
                Cantidad Transferida
            </td>
            <td >
                Cantidad Total Prod. Destino
            </td>

        </tr>

        <?php
        $fill = true;
        $sub_t=0;
        $cols = 1;
        $c_m=0;
        foreach ($lista_productos as $row) {

            
			
            if ($fill == true) {
                $flag = ' mfill';				
            } else {
                $flag = '';
            }
            
			

            echo '<tr class="item' . $flag . '">'; 
            echo '<td>' . $cols . '</td>';
                       echo '<td>' . $row->nombre_producto . '</td>
                           
                            <td>' .$row->pid_origen. '</td>
                             <td>' . $row->pid_destino . '</td>
                            <td>' . $row->cantidad_transferida . '</td>
                            <td>' . $row->cantidad_total. '</td>';
            echo '</tr>';

            $fill = !$fill;
        $cols++;        
         $c_m+=$row->cantidad_transferida;
        }

  

        ?>


    </table>
    <br>
    <table class="subtotal">

       
        <tr>
            <td class="myco2" rowspan="<?php echo "6" ?>">
                <p><?php echo '<strong>' . "Descripcion" . ': ' .'</strong>';?></p><br>
                <p><?=$acta->observaciones ?></p>
            </td>
           


        </tr>
        <tr class="f_summary">


            <td>Cantidad de Materiales Transferidos:</td>

            <td><?=$c_m ?> Und.</td>
        </tr>
      
        <tr>


            <td>Cantidad de Items :</td>
            <td><strong><?= count($lista_productos) ?> Und.</strong></td>
        </tr>
            </table>
            <br>
            <table>
                <tr>
                    <td align="left">Generado Por:<br>
                       <?php echo '<img src="' . FCPATH . 'userfiles/employee_sign/' . $employee->sign . '" alt="signature" class="height-50" width="30%"/>
                                    <h6>(' . $employee->name . ')</h6>
                                    <p class="text-muted">' . user_role($employee_aauth_users->roleid) . '</p>'; ?>
                    </td>
                    <td align="right">Entregado a:<br>
                        <?php if($almacen_destino->id_tecnico!=null) { ?>
                         
                            
                            <?php  if($acta->estado=="Recibida") {?>
                                <img width="30%" alt="signature" class="height-50" src="<?=  FCPATH . 'userfiles/employee_sign/' . $almacen_destino->id_tecnico->sign ?>"><br>
                                <small>Fecha Recibida: <?=$acta->fecha_recepcion ?></small>
                                <?php }else {echo "<br><br>___________________________________________";} ?>
                                <h6><?=$almacen_destino->id_tecnico->name ?></h6>
                                <p class="text-muted"><?=user_role($almacen_destino->aauth_users->roleid) ?></p>
                        <?php }else{ ?><br>
                            ___________________________________________
                        <?php } ?>
                    </td>
                </tr>
            </table>

    
</div>
</body>
</html>