<?php 

$array_afiliaciones=array();
	$var_cuenta_planes=array("1Mega"=>0,"2Megas"=>0,"3Megas"=>0,"5Megas"=>0,"10Megas"=>0,"Television"=>0); 
	$var_cuenta_planes_montos=array("1MegaMonto"=>0,"2MegasMonto"=>0,"3MegasMonto"=>0,"5MegasMonto"=>0,"10MegasMonto"=>0,"TelevisionMonto"=>0); 
//tabla total cobranza
	//productos con iva
		$cuantos_prod_con_iva_hay=0;
		$monto_prod_con_iva_hay=0;
		$monto_iva_prod_con_iva_hay=0;

	//end productos con iva

	//productos sin iva
		$cuantos_prod_sin_iva_hay=0;
		$monto_prod_sin_iva_hay=0;
	//end productos sin iva
//end tabla total cobranza
		$array_reconexiones=array('cantidad' =>0 ,"monto"=>0 );
		$array_bancos=array("Bancolombia" => array('cantidad' => 0,"monto"=>0 ),"BBVA"=>array('cantidad' => 0,"monto"=>0 ));
		$array_resumen_tipo_servicio= array('Internet' => array('cantidad' => 0,"monto"=>0 ),"Television"=> array('cantidad' => 0,"monto"=>0 ));
		$array_efectivo=array("cantidad"=>0,"monto"=>0);
		foreach ($lista as $key => $value) { 
			$invoice = $this->db->get_where("invoices",array("tid"=>$value['tid']))->row(); 
			$invoice_items=$this->db->get_where('invoice_items',array('tid' =>$value['tid']))->result_array();
			foreach ($invoice_items as $key => $item_invoic) {
				//recorro y pregunto si tiene iva o no el item para la primera tabla
				if($item_invoic['totaltax']!="0"){
					$cuantos_prod_con_iva_hay++;
					$monto_iva_prod_con_iva_hay=$monto_iva_prod_con_iva_hay+intval($item_invoic['totaltax']);
					$monto_prod_con_iva_hay=$monto_prod_con_iva_hay+intval($item_invoic['price']);
				}else{
					$cuantos_prod_sin_iva_hay++;
					$monto_prod_sin_iva_hay=$monto_prod_sin_iva_hay+intval($item_invoic['price']);
				}
				//para la Resumen por Servicios
				if($item_invoic['product']=="1Mega" ||$item_invoic['product']=="1 Mega"){
			 		$var_cuenta_planes['1Mega']++;
			 		$var_cuenta_planes_montos['1MegaMonto']+=intval($item_invoic['subtotal']);
			 		//resumen tipo servicio
			 		$array_resumen_tipo_servicio['Internet']['cantidad']++;
			 		$array_resumen_tipo_servicio['Internet']['monto']+=intval($item_invoic['subtotal']);

				}else if($item_invoic['product']=="2Megas" ||$item_invoic['product']=="2 Megas"){
					$var_cuenta_planes['2Megas']++;
					$var_cuenta_planes_montos['2MegasMonto']+=intval($item_invoic['subtotal']);

					//resumen tipo servicio
			 		$array_resumen_tipo_servicio['Internet']['cantidad']++;
			 		$array_resumen_tipo_servicio['Internet']['monto']+=intval($item_invoic['subtotal']);

				}else if($item_invoic['product']=="3Megas"|| $item_invoic['product']=="3 Megas"){
					$var_cuenta_planes['3Megas']++;
					$var_cuenta_planes_montos['3MegasMonto']+=intval($item_invoic['subtotal']);

					//resumen tipo servicio
			 		$array_resumen_tipo_servicio['Internet']['cantidad']++;
			 		$array_resumen_tipo_servicio['Internet']['monto']+=intval($item_invoic['subtotal']);

				}else if($item_invoic['product']=="5Megas"||$item_invoic['product']=="5 Megas"){
					$var_cuenta_planes['5Megas']++;
					$var_cuenta_planes_montos['5MegasMonto']+=intval($item_invoic['subtotal']);

					//resumen tipo servicio
			 		$array_resumen_tipo_servicio['Internet']['cantidad']++;
			 		$array_resumen_tipo_servicio['Internet']['monto']+=intval($item_invoic['subtotal']);

				}else if($item_invoic['product']=="10Megas"||$item_invoic['product']=="10 Megas"){
					$var_cuenta_planes['10Megas']++;
					$var_cuenta_planes_montos['10MegasMonto']+=intval($item_invoic['subtotal']);

					//resumen tipo servicio
			 		$array_resumen_tipo_servicio['Internet']['cantidad']++;
			 		$array_resumen_tipo_servicio['Internet']['monto']+=intval($item_invoic['subtotal']);

				}
				//le coloque asi primero para que la afiliacion teve no se entrelase con la sola tev mensual que es diferente
				if(strpos(strtolower($item_invoic['product']), "afilia")!==false){
					$cuenta_afiliacion=1;
					$monto_afiliacion=1;
					if(isset($array_afiliaciones[$item_invoic['product']])) {
						$array_afiliaciones[$item_invoic['product']]['cuenta_afiliacion']++;
						$array_afiliaciones[$item_invoic['product']]['monto_afiliacion']+=intval($item_invoic['subtotal']);
					}else{
						$array_afiliaciones[$item_invoic['product']]=array('cuenta_afiliacion' => intval($cuenta_afiliacion),"monto_afiliacion"=> intval($item_invoic['subtotal']));
					}
				}else if(strpos(strtolower($item_invoic['product']), "tele")!==false){
					$var_cuenta_planes['Television']++;
					$var_cuenta_planes_montos['TelevisionMonto']+=intval($item_invoic['subtotal']);
				}

				//resumen por tipo servicio
				if(strpos(strtolower($item_invoic['product']), "tele")!==false){
					$array_resumen_tipo_servicio['Television']['cantidad']++;
					$array_resumen_tipo_servicio['Television']['monto']+=intval($item_invoic['subtotal']);
				}else if(strpos(strtolower($item_invoic['product']), "afilia")!==false){
					$array_resumen_tipo_servicio['Internet']['cantidad']++;
			 		$array_resumen_tipo_servicio['Internet']['monto']+=intval($item_invoic['subtotal']);
				}
				//end resumen por tipo servicio
				

			}
			
			$ticket = $this->db->select("*")->from('tickets')->where("id_invoice=".$value['tid']." or id_factura=".$value['tid'])->get();
			$varx =$ticket->result();
			
			if(strpos(strtolower($varx[0]->detalle),'reconexi')!==false){
					$array_reconexiones['cantidad']++;
					$array_reconexiones['monto']+=intval($invoice->subtotal);
			}

			if($value['method']=="Bank"){
				if($value['nombre_banco']=="Bancolombia"){
					$array_bancos['Bancolombia']['cantidad']++;
					$array_bancos['Bancolombia']['monto']+=intval($invoice->subtotal);
				}else{
					$array_bancos['BBVA']['cantidad']++;
					$array_bancos['BBVA']['monto']+=intval($invoice->subtotal);
				}
			}else if($value['method']=="Cash"){
				$array_efectivo['cantidad']++;
				$array_efectivo['monto']+=intval($invoice->subtotal);
			}


		 } 
		 //tabla 1
		 $tabla_total_cobranza_monto=$monto_prod_sin_iva_hay+$monto_prod_con_iva_hay+$monto_iva_prod_con_iva_hay;
		//end tabla 1
			//tabla 3 Resumen por Servicios
			$var_cantidad_mensualidades=$var_cuenta_planes['1Mega']+$var_cuenta_planes['2Megas']+$var_cuenta_planes['3Megas']+$var_cuenta_planes['5Megas']+$var_cuenta_planes['10Megas']+$var_cuenta_planes['Television'];
			$var_total_mensualidades=$var_cuenta_planes_montos['1MegaMonto']+$var_cuenta_planes_montos['2MegasMonto']+$var_cuenta_planes_montos['3MegasMonto']+$var_cuenta_planes_montos['5MegasMonto']+$var_cuenta_planes_montos['10MegasMonto']+$var_cuenta_planes_montos['TelevisionMonto'];
			//end tabla 3 Resumen por Servicios
			
			//sobre anulaciones
				$cuenta_anulaciones=array("Cobranza Efectiva"=>array("cantidad"=>0,"monto"=>0),"Anulado de Cierre"=>array("cantidad"=>0,"monto"=>0),"Anulado de otros Cierres"=>array("cantidad"=>0,"monto"=>0));
						foreach ($lista_anulaciones as $key => $value) {
								$anul=$this->db->get_where("anulaciones",array("transactions_id"=>$value['id']))->row();
								
								if(isset($cuenta_anulaciones[$anul->detalle])) {
									
									$cuenta_anulaciones[$anul->detalle]['cantidad']++;
									
									$invoce = $this->db->get_where("invoices",array("tid"=>$value['tid']))->row();
									$cuenta_anulaciones[$anul->detalle]['monto']+=intval($invoce->subtotal);
									
								}

						} 

			//end sobre Anulaciones
		 	
		 	//tabla resumen por servicios total final
			//calculo tablas meses
						$valores_mes_actual= array('cantidad' =>0 , 'monto'=>0,'Internet'=> array('cantidad' => 0,"monto"=>0),"Television"=> array('cantidad' =>0 ,"monto"=>0 ));
					$valores_mes_anterior= array('cantidad' =>0 , 'monto'=>0,'Internet'=> array('cantidad' => 0,"monto"=>0),"Television"=> array('cantidad' =>0 ,"monto"=>0 ));

					foreach ($lista_mes_actual as $key => $val1) {
						$inv1 = $this->db->get_where("invoices",array("tid"=>$val1['tid']))->row(); 
						$valores_mes_actual['monto']+=intval($inv1->subtotal);

						$invoice_items = $this->db->get_where("invoice_items",array('tid' => $val1['tid'] ))->result_array();
						foreach ($invoice_items as $key => $item_invoic) {
							if($item_invoic['product']=="1Mega" ||$item_invoic['product']=="1 Mega"){
						 		$valores_mes_actual['Internet']['cantidad']++;
						 		$valores_mes_actual['Internet']['monto']+=intval($item_invoic['subtotal']);

							}else if($item_invoic['product']=="2Megas" ||$item_invoic['product']=="2 Megas"){
								$valores_mes_actual['Internet']['cantidad']++;
						 		$valores_mes_actual['Internet']['monto']+=intval($item_invoic['subtotal']);

							}else if($item_invoic['product']=="3Megas"|| $item_invoic['product']=="3 Megas"){
								$valores_mes_actual['Internet']['cantidad']++;
						 		$valores_mes_actual['Internet']['monto']+=intval($item_invoic['subtotal']);

							}else if($item_invoic['product']=="5Megas"||$item_invoic['product']=="5 Megas"){
								$valores_mes_actual['Internet']['cantidad']++;
						 		$valores_mes_actual['Internet']['monto']+=intval($item_invoic['subtotal']);

							}else if($item_invoic['product']=="10Megas"||$item_invoic['product']=="10 Megas"){
								$valores_mes_actual['Internet']['cantidad']++;
						 		$valores_mes_actual['Internet']['monto']+=intval($item_invoic['subtotal']);
							}

							if(strpos(strtolower($item_invoic['product']), "tele")!==false){
								$valores_mes_actual['Television']['cantidad']++;
								$valores_mes_actual['Television']['monto']+=intval($item_invoic['subtotal']);
							}else if(strpos(strtolower($item_invoic['product']), "afilia")!==false){
								$valores_mes_actual['Internet']['cantidad']++;
						 		$valores_mes_actual['Internet']['monto']+=intval($item_invoic['subtotal']);
							}

						}
					}

					foreach ($lista_mes_anterior as $key => $val1) {
						$inv1 = $this->db->get_where("invoices",array("tid"=>$val1['tid']))->row(); 
						$valores_mes_anterior['monto']+=intval($inv1->subtotal);

						$invoice_items = $this->db->get_where("invoice_items",array('tid' => $val1['tid'] ))->result_array();

						foreach ($invoice_items as $key => $item_invoic) {
							if($item_invoic['product']=="1Mega" ||$item_invoic['product']=="1 Mega"){
						 		$valores_mes_anterior['Internet']['cantidad']++;
						 		$valores_mes_anterior['Internet']['monto']+=intval($item_invoic['subtotal']);

							}else if($item_invoic['product']=="2Megas" ||$item_invoic['product']=="2 Megas"){
								$valores_mes_anterior['Internet']['cantidad']++;
						 		$valores_mes_anterior['Internet']['monto']+=intval($item_invoic['subtotal']);

							}else if($item_invoic['product']=="3Megas"|| $item_invoic['product']=="3 Megas"){
								$valores_mes_anterior['Internet']['cantidad']++;
						 		$valores_mes_anterior['Internet']['monto']+=intval($item_invoic['subtotal']);

							}else if($item_invoic['product']=="5Megas"||$item_invoic['product']=="5 Megas"){
								$valores_mes_anterior['Internet']['cantidad']++;
						 		$valores_mes_anterior['Internet']['monto']+=intval($item_invoic['subtotal']);

							}else if($item_invoic['product']=="10Megas"||$item_invoic['product']=="10 Megas"){
								$valores_mes_anterior['Internet']['cantidad']++;
						 		$valores_mes_anterior['Internet']['monto']+=intval($item_invoic['subtotal']);
							}

							if(strpos(strtolower($item_invoic['product']), "tele")!==false){
								$valores_mes_anterior['Television']['cantidad']++;
								$valores_mes_anterior['Television']['monto']+=intval($item_invoic['subtotal']);
							}else if(strpos(strtolower($item_invoic['product']), "afilia")!==false){
								$valores_mes_anterior['Internet']['cantidad']++;
						 		$valores_mes_anterior['Internet']['monto']+=intval($item_invoic['subtotal']);
							}

						}
					}


			//end calculo tablas meses
 //afiliaciones
                    $var_cuenta_afiliaciones=0;
                    $var_monto_afiliaciones=0;
                    $var1_afiliaciones="";
                    foreach ($array_afiliaciones as $key => $afiliacion) { 
                        $var_cuenta_afiliaciones+=$afiliacion['cuenta_afiliacion'];
                        $var_monto_afiliaciones+=$afiliacion['monto_afiliacion'];
                        $var1_afiliaciones.='<tr>
                        <td style="border-bottom: 2px solid #111;color: #333;font-size: 12px;padding: 10px;">'.$key.'</td>
                        <td style="border-bottom: 2px solid #111;color: #333;font-size: 12px;padding: 10px;text-align:center;">'.$afiliacion['cuenta_afiliacion'].'</td>
                        <td style="border-bottom: 2px solid #111;color: #333;font-size: 12px;padding: 10px;text-align:center;">'."$ ".number_format($afiliacion['monto_afiliacion'],0,",",".").'</td>
                        </tr>';
                    }
                    //end afiliaciones
					
//datos pdf para abajo


$contenidoTabla="<div style='text-align: center;'>
<img style='display:block;margin:auto;' src='".base_url()."userfiles/theme/logo-header.png'>
</div>


<div style='box-shadow: 0px 2px 0px rgba(0, 0, 0, 0.05);margin-bottom: 1.875rem;border-radius: 0;padding: 1.5rem'>
<h6 style='font-size: 1rem;margin-bottom: 0.5rem;font-family: inherit;font-weight: 500;line-height: 1.2;color: inherit;margin-top: 0;'>Estado de Caja : </h6>
<hr style='margin-top: 1rem;margin-bottom: 1rem;border: 0;border-top: 1px solid rgba(0, 0, 0, 0.1);'>
<p style='margin-top: 0;margin-bottom: 1rem;display: block;margin-block-start: 1em;margin-block-end: 1em;margin-inline-start: 0px;margin-inline-end: 0px;'>Caja : </p>
<hr style='margin-top: 1rem;margin-bottom: 1rem;border: 0;border-top: 1px solid rgba(0, 0, 0, 0.1);'>
<table>
	<tr>
		<td style='vertical-align: top;'>
			<h6 style='font-size: 1rem;margin-bottom: 0.5rem;font-family: inherit;font-weight: 500;line-height: 1.2;color: inherit;margin-top: 0;'>Resumen Cobranza</h6>
			<table style='border-collapse: collapse;border: 1px solid #5F5F5F;border-spacing: 2px;'>
					<thead>
						<tr >
							<th style='background: #555;color: #fff;text-transform: uppercase;text-align: center;font-size: 14px;padding: 10px;'>
							DESCRIPCION</th>
							<th style='background: #555;color: #fff;text-transform: uppercase;text-align: center;font-size: 14px;padding: 10px;'>
							CANT</th>
							<th style='background: #555;color: #fff;text-transform: uppercase;text-align: center;font-size: 14px;padding: 10px;'>
							MONTO</th>	
						</tr>
					</thead>
					<tbody>
						<tr >
							<td style='border-bottom: 2px solid #111;color: #333;font-size: 12px;padding: 10px;'>Excento</td><td style='text-align: center;border-bottom: 2px solid #111;color: #333;font-size: 12px;padding: 10px;'>".$cuantos_prod_sin_iva_hay."</td><td style='text-align: center;border-bottom: 2px solid #111;color: #333;font-size: 12px;padding: 10px;'>"."$ ".number_format($monto_prod_sin_iva_hay,0,",",".")."</td>
						</tr>
						<tr>
							<td style='border-bottom: 2px solid #111;color: #333;font-size: 12px;padding: 10px;'>Base</td><td style='text-align: center;border-bottom: 2px solid #111;color: #333;font-size: 12px;padding: 10px;'>".$cuantos_prod_con_iva_hay."</td><td style='text-align: center;border-bottom: 2px solid #111;color: #333;font-size: 12px;padding: 10px;'>"."$ ".number_format($monto_prod_con_iva_hay,0,",",".")."</td>
						</tr>
						<tr>
							<td style='border-bottom: 2px solid #111;color: #333;font-size: 12px;padding: 10px;'>iva</td><td style='text-align: center;border-bottom: 2px solid #111;color: #333;font-size: 12px;padding: 10px;'>".$cuantos_prod_con_iva_hay."</td><td style='text-align: center;border-bottom: 2px solid #111;color: #333;font-size: 12px;padding: 10px;'>"."$ ".number_format($monto_iva_prod_con_iva_hay,0,",",".")."</td>
						</tr>
						
					</tbody>
					<tfoot>
						<tr>
							<th style='background: #E1E1E1;color: #000000;text-transform: uppercase;text-align: center;font-size: 10px;padding: 10px;' >TOTAL COBRANZA</th>
							<th style='background: #E1E1E1;color: #000000;text-transform: uppercase;text-align: center;font-size: 10px;padding: 10px;'>".($cuantos_prod_sin_iva_hay+$cuantos_prod_con_iva_hay)."</th>
							<th style='background: #E1E1E1;color: #000000;text-transform: uppercase;text-align: center;font-size: 10px;padding: 10px;'>".("$ ".number_format($tabla_total_cobranza_monto,0,",","."))."</th>			
						</tr>
					</tfoot>
			</table>

			
<br>
			<h6 style='font-size: 1rem;margin-bottom: 0.5rem;font-family: inherit;font-weight: 500;line-height: 1.2;color: inherit;margin-top: 10px;'>Resumen por Banco</h6>
			<table style='border-collapse: collapse;border: 1px solid #5F5F5F;border-spacing: 2px;'>
					<thead>
						<tr >
							<th style='background: #555;color: #fff;text-transform: uppercase;text-align: center;font-size: 14px;padding: 10px;'>
							DESCRIPCION</th>
							<th style='background: #555;color: #fff;text-transform: uppercase;text-align: center;font-size: 14px;padding: 10px;'>
							CANT</th>
							<th style='background: #555;color: #fff;text-transform: uppercase;text-align: center;font-size: 14px;padding: 10px;'>
							MONTO</th>	
						</tr>
					</thead>
					<tbody>
						<tr >
							<td style='border-bottom: 2px solid #111;color: #333;font-size: 12px;padding: 10px;'>Bancolombia</td><td style='text-align: center;border-bottom: 2px solid #111;color: #333;font-size: 12px;padding: 10px;'>".$array_bancos['Bancolombia']['cantidad']."</td><td style='text-align: center;border-bottom: 2px solid #111;color: #333;font-size: 12px;padding: 10px;'>".("$ ".number_format($array_bancos['Bancolombia']['monto'],0,",","."))."</td>
						</tr>
						<tr>
							<td style='border-bottom: 2px solid #111;color: #333;font-size: 12px;padding: 10px;'>BBVA colombia</td><td style='text-align: center;border-bottom: 2px solid #111;color: #333;font-size: 12px;padding: 10px;'>".$array_bancos['BBVA']['cantidad']."</td><td style='text-align: center;border-bottom: 2px solid #111;color: #333;font-size: 12px;padding: 10px;'>".("$ ".number_format($array_bancos['BBVA']['monto'],0,",","."))."</td>
						</tr>
						
						
					</tbody>
					<tfoot>
						<tr>
							<th style='background: #E1E1E1;color: #000000;text-transform: uppercase;text-align: center;font-size: 10px;padding: 10px;' >TOTAL COBRANZA</th>
							<th style='background: #E1E1E1;color: #000000;text-transform: uppercase;text-align: center;font-size: 10px;padding: 10px;'>".($array_bancos['Bancolombia']['cantidad']+$array_bancos['BBVA']['cantidad'])."</th>
							<th style='background: #E1E1E1;color: #000000;text-transform: uppercase;text-align: center;font-size: 10px;padding: 10px;'>".("$ ".number_format($array_bancos['Bancolombia']['monto']+$array_bancos['BBVA']['monto'],0,",","."))."</th>			
						</tr>
					</tfoot>
			</table>
			
		</td>
		
		<td width='20%'></td>
		<td >
			<h6 style='font-size: 1rem;margin-bottom: 0.5rem;font-family: inherit;font-weight: 500;line-height: 1.2;color: inherit;margin-top: 0;'>Resumen por Forma de pago</h6>
			<table style='border-collapse: collapse;border: 1px solid #5F5F5F;border-spacing: 2px;'>
					<thead>
						<tr >
							<th style='background: #555;color: #fff;text-transform: uppercase;text-align: center;font-size: 14px;padding: 10px;'>
							DESCRIPCION</th>
							<th style='background: #555;color: #fff;text-transform: uppercase;text-align: center;font-size: 14px;padding: 10px;'>
							CANT</th>
							<th style='background: #555;color: #fff;text-transform: uppercase;text-align: center;font-size: 14px;padding: 10px;'>
							MONTO</th>	
						</tr>
					</thead>
					<tbody>
						<tr >
							<td style='border-bottom: 2px solid #111;color: #333;font-size: 12px;padding: 10px;'>Efectivo</td><td style='text-align: center;border-bottom: 2px solid #111;color: #333;font-size: 12px;padding: 10px;'>".$array_efectivo['cantidad']."</td><td style='text-align: center;border-bottom: 2px solid #111;color: #333;font-size: 12px;padding: 10px;'>"."$ ".number_format($array_efectivo['monto'],0,",",".")."</td>
						</tr>
						<tr>
							<td style='border-bottom: 2px solid #111;color: #333;font-size: 12px;padding: 10px;'>Tarjeta Debito</td><td style='text-align: center;border-bottom: 2px solid #111;color: #333;font-size: 12px;padding: 10px;'>0</td><td style='text-align: center;border-bottom: 2px solid #111;color: #333;font-size: 12px;padding: 10px;'>$ 0</td>
						</tr>
						<tr>
							<td style='border-bottom: 2px solid #111;color: #333;font-size: 12px;padding: 10px;'>Tarjeta Credito</td><td style='text-align: center;border-bottom: 2px solid #111;color: #333;font-size: 12px;padding: 10px;'>0</td><td style='text-align: center;border-bottom: 2px solid #111;color: #333;font-size: 12px;padding: 10px;'>$ 0</td>
						</tr>
						<tr>
							<td style='border-bottom: 2px solid #111;color: #333;font-size: 12px;padding: 10px;'>Deposito</td><td style='text-align: center;border-bottom: 2px solid #111;color: #333;font-size: 12px;padding: 10px;'>0</td><td style='text-align: center;border-bottom: 2px solid #111;color: #333;font-size: 12px;padding: 10px;'>$ 0</td>
						</tr>
						<tr>
							<td style='border-bottom: 2px solid #111;color: #333;font-size: 12px;padding: 10px;'>Transferencia</td><td style='text-align: center;border-bottom: 2px solid #111;color: #333;font-size: 12px;padding: 10px;'>".($array_bancos['Bancolombia']['cantidad']+$array_bancos['BBVA']['cantidad'])."</td><td style='text-align: center;border-bottom: 2px solid #111;color: #333;font-size: 12px;padding: 10px;'>".("$ ".number_format($array_bancos['Bancolombia']['monto']+$array_bancos['BBVA']['monto'],0,",","."))."</td>
						</tr>
						<tr>
							<td style='border-bottom: 2px solid #111;color: #333;font-size: 12px;padding: 10px;'>Cheque</td><td style='text-align: center;border-bottom: 2px solid #111;color: #333;font-size: 12px;padding: 10px;'>0</td><td style='text-align: center;border-bottom: 2px solid #111;color: #333;font-size: 12px;padding: 10px;'>$ 0</td>
						</tr>
						<tr>
							<td style='border-bottom: 2px solid #111;color: #333;font-size: 12px;padding: 10px;'>Retencion</td><td style='text-align: center;border-bottom: 2px solid #111;color: #333;font-size: 12px;padding: 10px;'>0</td><td style='text-align: center;border-bottom: 2px solid #111;color: #333;font-size: 12px;padding: 10px;'>$ 0</td>
						</tr>
						<tr>
							<td style='border-bottom: 2px solid #111;color: #333;font-size: 12px;padding: 10px;'>Domiciliacion Bancaria</td><td style='text-align: center;border-bottom: 2px solid #111;color: #333;font-size: 12px;padding: 10px;'>0</td><td style='text-align: center;border-bottom: 2px solid #111;color: #333;font-size: 12px;padding: 10px;'>$ 0</td>
						</tr>
						
					</tbody>
					<tfoot>
						<tr>
							<th style='background: #E1E1E1;color: #000000;text-transform: uppercase;text-align: center;font-size: 10px;padding: 10px;' >TOTAL FORMA PAGO</th>
							<th style='background: #E1E1E1;color: #000000;text-transform: uppercase;text-align: center;font-size: 10px;padding: 10px;'>".($array_efectivo['cantidad']+$array_bancos['Bancolombia']['cantidad']+$array_bancos['BBVA']['cantidad'])."</th>
							<th style='background: #E1E1E1;color: #000000;text-transform: uppercase;text-align: center;font-size: 10px;padding: 10px;'>".("$ ".number_format($array_efectivo['monto']+$array_bancos['Bancolombia']['monto']+$array_bancos['BBVA']['monto'],0,",","."))."</th>			
						</tr>
					</tfoot>
			</table>

			
		</td>
	</tr>
	<tr>
		<td>
			
		</td>
		<td></td>
		<td>
			<br>
			<h6 style='font-size: 1rem;margin-bottom: 0.5rem;font-family: inherit;font-weight: 500;line-height: 1.2;color: inherit;margin-top: 10px;'>Resumen Anulaciones</h6>
			<table style='border-collapse: collapse;border: 1px solid #5F5F5F;border-spacing: 2px;'>
					<thead>
						<tr >
							<th style='background: #555;color: #fff;text-transform: uppercase;text-align: center;font-size: 14px;padding: 10px;'>
							DESCRIPCION</th>
							<th style='background: #555;color: #fff;text-transform: uppercase;text-align: center;font-size: 14px;padding: 10px;'>
							CANT</th>
							<th style='background: #555;color: #fff;text-transform: uppercase;text-align: center;font-size: 14px;padding: 10px;'>
							MONTO</th>	
						</tr>
					</thead>
					<tbody>
						<tr >
							<td style='border-bottom: 2px solid #111;color: #333;font-size: 12px;padding: 10px;'>Cobranza efectiva</td><td style='text-align: center;border-bottom: 2px solid #111;color: #333;font-size: 12px;padding: 10px;'>".$cuenta_anulaciones['Cobranza Efectiva']['cantidad']."</td><td style='text-align: center;border-bottom: 2px solid #111;color: #333;font-size: 12px;padding: 10px;'>"."$ ".number_format($cuenta_anulaciones['Cobranza Efectiva']['monto'],0,",",".")."</td>
						</tr>
						<tr>
							<td style='border-bottom: 2px solid #111;color: #333;font-size: 12px;padding: 10px;'>Anulado de cierre</td><td style='text-align: center;border-bottom: 2px solid #111;color: #333;font-size: 12px;padding: 10px;'>".$cuenta_anulaciones['Anulado de Cierre']['cantidad']."</td><td style='text-align: center;border-bottom: 2px solid #111;color: #333;font-size: 12px;padding: 10px;'>"."$ ".number_format($cuenta_anulaciones['Anulado de Cierre']['monto'],0,",",".")."</td>
						</tr>
						<tr>
							<td style='border-bottom: 2px solid #111;color: #333;font-size: 12px;padding: 10px;'>Anulado de otros cierres</td><td style='text-align: center;border-bottom: 2px solid #111;color: #333;font-size: 12px;padding: 10px;'>".$cuenta_anulaciones['Anulado de otros Cierres']['cantidad']."</td><td style='text-align: center;border-bottom: 2px solid #111;color: #333;font-size: 12px;padding: 10px;'>"."$ ".number_format($cuenta_anulaciones['Anulado de otros Cierres']['monto'],0,",",".")."</td>
						</tr>
						
					</tbody>
					<tfoot>
						<tr>
							<th style='background: #E1E1E1;color: #000000;text-transform: uppercase;text-align: center;font-size: 10px;padding: 10px;' >COBRADO - ANULADO<br>DE OTRAS FECHAS</th>
							<th style='background: #E1E1E1;color: #000000;text-transform: uppercase;text-align: center;font-size: 10px;padding: 10px;'>".($cuenta_anulaciones['Cobranza Efectiva']['cantidad']+$cuenta_anulaciones['Anulado de Cierre']['cantidad']+$cuenta_anulaciones['Anulado de otros Cierres']['cantidad'])."</th>
							<th style='background: #E1E1E1;color: #000000;text-transform: uppercase;text-align: center;font-size: 10px;padding: 10px;'>".("$ ".number_format($cuenta_anulaciones['Cobranza Efectiva']['monto']+$cuenta_anulaciones['Anulado de Cierre']['monto']+$cuenta_anulaciones['Anulado de otros Cierres']['monto'],0,",","."))."</th>			
						</tr>
					</tfoot>
			</table>
		</td>
	</tr>
	<tr>
		<td style='vertical-align: top;'>
			<h6 style='font-size: 1rem;margin-bottom: 0.5rem;font-family: inherit;font-weight: 500;line-height: 1.2;color: inherit;margin-top: 10px;'>Resumen por Servicios</h6>
			<table style='border-collapse: collapse;border: 1px solid #5F5F5F;border-spacing: 2px;'>
					<thead>
						<tr >
							<th style='background: #555;color: #fff;text-transform: uppercase;text-align: center;font-size: 14px;padding: 10px;'>
							DESCRIPCION</th>
							<th style='background: #555;color: #fff;text-transform: uppercase;text-align: center;font-size: 14px;padding: 10px;'>
							CANT</th>
							<th style='background: #555;color: #fff;text-transform: uppercase;text-align: center;font-size: 14px;padding: 10px;'>
							MONTO</th>	
						</tr>
					</thead>
					<tbody>
						".(($var_cuenta_planes['1Mega']!=0)? "<tr ><td style='border-bottom: 2px solid #111;color: #333;font-size: 12px;padding: 10px;'>Internet 1MG</td><td style='text-align: center;border-bottom: 2px solid #111;color: #333;font-size: 12px;padding: 10px;'>".$var_cuenta_planes['1Mega']."</td><td style='text-align: center;border-bottom: 2px solid #111;color: #333;font-size: 12px;padding: 10px;'>"."$ ".number_format($var_cuenta_planes_montos['1MegaMonto'],0,",",".")."</td></tr>":"")."
						
						".(($var_cuenta_planes['2Megas']!=0)? "<tr ><td style='border-bottom: 2px solid #111;color: #333;font-size: 12px;padding: 10px;'>Internet 2MG</td><td style='text-align: center;border-bottom: 2px solid #111;color: #333;font-size: 12px;padding: 10px;'>".$var_cuenta_planes['2Megas']."</td><td style='text-align: center;border-bottom: 2px solid #111;color: #333;font-size: 12px;padding: 10px;'>"."$ ".number_format($var_cuenta_planes_montos['2MegasMonto'],0,",",".")."</td></tr>":"")."
						
						".(($var_cuenta_planes['3Megas']!=0)? "<tr ><td style='border-bottom: 2px solid #111;color: #333;font-size: 12px;padding: 10px;'>Internet 3MG</td><td style='text-align: center;border-bottom: 2px solid #111;color: #333;font-size: 12px;padding: 10px;'>".$var_cuenta_planes['3Megas']."</td><td style='text-align: center;border-bottom: 2px solid #111;color: #333;font-size: 12px;padding: 10px;'>"."$ ".number_format($var_cuenta_planes_montos['3MegasMonto'],0,",",".")."</td></tr>":"")."

						".(($var_cuenta_planes['5Megas']!=0)? "<tr ><td style='border-bottom: 2px solid #111;color: #333;font-size: 12px;padding: 10px;'>Internet 5MG</td><td style='text-align: center;border-bottom: 2px solid #111;color: #333;font-size: 12px;padding: 10px;'>".$var_cuenta_planes['5Megas']."</td><td style='text-align: center;border-bottom: 2px solid #111;color: #333;font-size: 12px;padding: 10px;'>"."$ ".number_format($var_cuenta_planes_montos['5MegasMonto'],0,",",".")."</td></tr>":"")."
						
						".(($var_cuenta_planes['10Megas']!=0)? "<tr ><td style='border-bottom: 2px solid #111;color: #333;font-size: 12px;padding: 10px;'>Internet 10MG</td><td style='text-align: center;border-bottom: 2px solid #111;color: #333;font-size: 12px;padding: 10px;'>".$var_cuenta_planes['10Megas']."</td><td style='text-align: center;border-bottom: 2px solid #111;color: #333;font-size: 12px;padding: 10px;'>"."$ ".number_format($var_cuenta_planes_montos['10MegasMonto'],0,",",".")."</td></tr>":"")."
						
						".(($var_cuenta_planes['Television']!=0)? "<tr ><td style='border-bottom: 2px solid #111;color: #333;font-size: 12px;padding: 10px;'>Television</td><td style='text-align: center;border-bottom: 2px solid #111;color: #333;font-size: 12px;padding: 10px;'>".$var_cuenta_planes['Television']."</td><td style='text-align: center;border-bottom: 2px solid #111;color: #333;font-size: 12px;padding: 10px;'>"."$ ".number_format($var_cuenta_planes_montos['TelevisionMonto'],0,",",".")."</td></tr>":"")."
						<tr>
							<td style='background: #E1E1E1;color: #000000;text-transform: uppercase;text-align: center;font-size: 10px;padding: 10px;' ><strong>TOTAL <br>MENSUALIDADES</strong></td>
							<td style='background: #E1E1E1;color: #000000;text-transform: uppercase;text-align: center;font-size: 10px;padding: 10px;'><strong>".$var_cantidad_mensualidades."</strong></td>
							<td style='background: #E1E1E1;color: #000000;text-transform: uppercase;text-align: center;font-size: 10px;padding: 10px;'><strong>"."$ ".number_format($var_total_mensualidades,0,",",".")."</strong></td>			
						</tr>
						".$var1_afiliaciones."
						<tr>
							<td style='border-bottom: 2px solid #111;text-transform: uppercase;text-align: center;font-size: 10px;padding: 10px;' ><strong>TOTAL VENTAS</strong></td>
							<td style='border-bottom: 2px solid #111;text-transform: uppercase;text-align: center;font-size: 10px;padding: 10px;'><strong>".$var_cuenta_afiliaciones."</strong></td>
							<td style='border-bottom: 2px solid #111;text-transform: uppercase;text-align: center;font-size: 10px;padding: 10px;'><strong>"."$ ".number_format($var_monto_afiliaciones,0,",",".")."</strong></td>			
						</tr>
						<tr>
							<td style='border-bottom: 2px solid #111;text-transform: uppercase;text-align: center;font-size: 10px;padding: 10px;' ><strong>TOTAL <br>RECONEXIONES</strong></td>
							<td style='border-bottom: 2px solid #111;text-transform: uppercase;text-align: center;font-size: 10px;padding: 10px;'><strong>".$array_reconexiones['cantidad']."</strong></td>
							<td style='border-bottom: 2px solid #111;text-transform: uppercase;text-align: center;font-size: 10px;padding: 10px;'><strong>"."$ ".number_format($array_reconexiones['monto'],0,",",".")."</strong></td>			
						</tr>
						<tr>
							<td style='border-bottom: 2px solid #111;text-transform: uppercase;text-align: center;font-size: 10px;padding: 10px;' ><strong>TOTAL MATERIALES</strong></td>
							<td style='border-bottom: 2px solid #111;text-transform: uppercase;text-align: center;font-size: 10px;padding: 10px;'><strong>0</strong></td>
							<td style='border-bottom: 2px solid #111;text-transform: uppercase;text-align: center;font-size: 10px;padding: 10px;'><strong>$ 0</strong></td>			
						</tr>
						<tr>
							<td style='border-bottom: 2px solid #111;text-transform: uppercase;text-align: center;font-size: 10px;padding: 10px;' ><strong>TOTAL OTROS</strong></td>
							<td style='border-bottom: 2px solid #111;text-transform: uppercase;text-align: center;font-size: 10px;padding: 10px;'><strong>0</strong></td>
							<td style='border-bottom: 2px solid #111;text-transform: uppercase;text-align: center;font-size: 10px;padding: 10px;'><strong>$ 0</strong></td>			
						</tr>
					</tbody>
					<tfoot>
						<tr>
							<th style='background: #E1E1E1;color: #000000;text-transform: uppercase;text-align: center;font-size: 10px;padding: 10px;' >TOTAL</th>
							<th style='background: #E1E1E1;color: #000000;text-transform: uppercase;text-align: center;font-size: 10px;padding: 10px;'>".($var_cantidad_mensualidades+$var_cuenta_afiliaciones+$array_reconexiones['cantidad'])."</th>
							<th style='background: #E1E1E1;color: #000000;text-transform: uppercase;text-align: center;font-size: 10px;padding: 10px;'>"."$ ".number_format($var_total_mensualidades+$var_monto_afiliaciones+$array_reconexiones['monto'],0,",",".")."</th>			
						</tr>
					</tfoot>
			</table>
			<br>
			<h6 style='font-size: 1rem;margin-bottom: 0.5rem;font-family: inherit;font-weight: 500;line-height: 1.2;color: inherit;margin-top: 10px;'>Resumen de cargos cobrados por meses</h6>
			<table style='border-collapse: collapse;border: 1px solid #5F5F5F;border-spacing: 2px;'>
					<thead>
						<tr >
							<th style='background: #555;color: #fff;text-transform: uppercase;text-align: center;font-size: 14px;padding: 10px;'>
							DESCRIPCION</th>
							<th style='background: #555;color: #fff;text-transform: uppercase;text-align: center;font-size: 14px;padding: 10px;'>
							CANT</th>
							<th style='background: #555;color: #fff;text-transform: uppercase;text-align: center;font-size: 14px;padding: 10px;'>
							MONTO</th>	
						</tr>
					</thead>
					<tbody>
						<tr >
							<td style='border-bottom: 2px solid #111;color: #333;font-size: 12px;padding: 10px;'>".$texto_mes_actual."</td><td style='text-align: center;border-bottom: 2px solid #111;color: #333;font-size: 12px;padding: 10px;'>".(count($lista_mes_actual))."</td><td style='text-align: center;border-bottom: 2px solid #111;color: #333;font-size: 12px;padding: 10px;'>"."$ ".number_format($valores_mes_actual['monto'],0,",",".")."</td>
						</tr>
						<tr>
							<td style='border-bottom: 2px solid #111;color: #333;font-size: 12px;padding: 10px;'>".$texto_mes_anterior."</td><td style='text-align: center;border-bottom: 2px solid #111;color: #333;font-size: 12px;padding: 10px;'>".(count($lista_mes_anterior))."</td><td style='text-align: center;border-bottom: 2px solid #111;color: #333;font-size: 12px;padding: 10px;'>"."$ ".number_format($valores_mes_anterior['monto'],0,",",".")."</td>
						</tr>
					
						
					</tbody>
					<tfoot>
						<tr>
							<th style='background: #E1E1E1;color: #000000;text-transform: uppercase;text-align: center;font-size: 10px;padding: 10px;' >TOTAL COBRANZA<br>POR MESES</th>
							<th style='background: #E1E1E1;color: #000000;text-transform: uppercase;text-align: center;font-size: 10px;padding: 10px;'>".(count($lista_mes_anterior)+count($lista_mes_actual))."</th>
							<th style='background: #E1E1E1;color: #000000;text-transform: uppercase;text-align: center;font-size: 10px;padding: 10px;'>"."$ ".number_format($valores_mes_actual['monto']+$valores_mes_anterior['monto'],0,",",".") ."</th>			
						</tr>
					</tfoot>
			</table>
		</td>
		<td></td>
		<td style='vertical-align: top;'>
			<h6 style='font-size: 1rem;margin-bottom: 0.5rem;font-family: inherit;font-weight: 500;line-height: 1.2;color: inherit;margin-top: 10px;'>Resumen de cargos cobrados <br>por meses INTERNET</h6>
			<table style='border-collapse: collapse;border: 1px solid #5F5F5F;border-spacing: 2px;'>
					<thead>
						<tr >
							<th style='background: #555;color: #fff;text-transform: uppercase;text-align: center;font-size: 14px;padding: 10px;'>
							DESCRIPCION</th>
							<th style='background: #555;color: #fff;text-transform: uppercase;text-align: center;font-size: 14px;padding: 10px;'>
							CANT</th>
							<th style='background: #555;color: #fff;text-transform: uppercase;text-align: center;font-size: 14px;padding: 10px;'>
							MONTO</th>	
						</tr>
					</thead>
					<tbody>
						<tr >
							<td style='border-bottom: 2px solid #111;color: #333;font-size: 12px;padding: 10px;'>".$texto_mes_actual."</td><td style='text-align: center;border-bottom: 2px solid #111;color: #333;font-size: 12px;padding: 10px;'>".$valores_mes_actual['Internet']['cantidad']."</td><td style='text-align: center;border-bottom: 2px solid #111;color: #333;font-size: 12px;padding: 10px;'>"."$ ".number_format($valores_mes_actual['Internet']['monto'],0,",",".")."</td>
						</tr>
						<tr>
							<td style='border-bottom: 2px solid #111;color: #333;font-size: 12px;padding: 10px;'>".$texto_mes_anterior."</td><td style='text-align: center;border-bottom: 2px solid #111;color: #333;font-size: 12px;padding: 10px;'>".$valores_mes_anterior['Internet']['cantidad']."</td><td style='text-align: center;border-bottom: 2px solid #111;color: #333;font-size: 12px;padding: 10px;'>"."$ ".number_format($valores_mes_anterior['Internet']['monto'],0,",",".")."</td>
						</tr>
					
						
					</tbody>
					<tfoot>
						<tr>
							<th style='background: #E1E1E1;color: #000000;text-transform: uppercase;text-align: center;font-size: 10px;padding: 10px;' >TOTAL COBRANZA<br>POR MESES</th>
							<th style='background: #E1E1E1;color: #000000;text-transform: uppercase;text-align: center;font-size: 10px;padding: 10px;'>".($valores_mes_actual['Internet']['cantidad']+$valores_mes_anterior['Internet']['cantidad'])."</th>
							<th style='background: #E1E1E1;color: #000000;text-transform: uppercase;text-align: center;font-size: 10px;padding: 10px;'>".("$ ".number_format($valores_mes_actual['Internet']['monto']+$valores_mes_anterior['Internet']['monto'],0,",",".") )."</th>			
						</tr>
					</tfoot>
			</table>
			<br>
			<h6 style='font-size: 1rem;margin-bottom: 0.5rem;font-family: inherit;font-weight: 500;line-height: 1.2;color: inherit;margin-top: 10px;'>Resumen de cargos cobrados <br>por meses TV</h6>
			<table style='border-collapse: collapse;border: 1px solid #5F5F5F;border-spacing: 2px;'>
					<thead>
						<tr >
							<th style='background: #555;color: #fff;text-transform: uppercase;text-align: center;font-size: 14px;padding: 10px;'>
							DESCRIPCION</th>
							<th style='background: #555;color: #fff;text-transform: uppercase;text-align: center;font-size: 14px;padding: 10px;'>
							CANT</th>
							<th style='background: #555;color: #fff;text-transform: uppercase;text-align: center;font-size: 14px;padding: 10px;'>
							MONTO</th>	
						</tr>
					</thead>
					<tbody>
						<tr >
							<td style='border-bottom: 2px solid #111;color: #333;font-size: 12px;padding: 10px;'>".$texto_mes_actual."</td><td style='text-align: center;border-bottom: 2px solid #111;color: #333;font-size: 12px;padding: 10px;'>".$valores_mes_actual['Television']['cantidad']."</td><td style='text-align: center;border-bottom: 2px solid #111;color: #333;font-size: 12px;padding: 10px;'>"."$ ".number_format($valores_mes_actual['Television']['monto'],0,",",".")."</td>
						</tr>
						<tr>
							<td style='border-bottom: 2px solid #111;color: #333;font-size: 12px;padding: 10px;'>".$texto_mes_anterior."</td><td style='text-align: center;border-bottom: 2px solid #111;color: #333;font-size: 12px;padding: 10px;'>".$valores_mes_anterior['Television']['cantidad']."</td><td style='text-align: center;border-bottom: 2px solid #111;color: #333;font-size: 12px;padding: 10px;'>"."$ ".number_format($valores_mes_anterior['Television']['monto'],0,",",".")."</td>
						</tr>
					
						
					</tbody>
					<tfoot>
						<tr>
							<th style='background: #E1E1E1;color: #000000;text-transform: uppercase;text-align: center;font-size: 10px;padding: 10px;' >TOTAL COBRANZA<br>POR MESES</th>
							<th style='background: #E1E1E1;color: #000000;text-transform: uppercase;text-align: center;font-size: 10px;padding: 10px;'>".($valores_mes_actual['Television']['cantidad']+$valores_mes_anterior['Television']['cantidad'])."</th>
							<th style='background: #E1E1E1;color: #000000;text-transform: uppercase;text-align: center;font-size: 10px;padding: 10px;'>".("$ ".number_format($valores_mes_actual['Television']['monto']+$valores_mes_anterior['Television']['monto'],0,",","."))."</th>			
						</tr>
					</tfoot>
			</table>
			<br>
			<h6 style='font-size: 1rem;margin-bottom: 0.5rem;font-family: inherit;font-weight: 500;line-height: 1.2;color: inherit;margin-top: 10px;'>Resumen por tipo de servicio</h6>
			<table style='border-collapse: collapse;border: 1px solid #5F5F5F;border-spacing: 2px;'>
					<thead>
						<tr >
							<th style='background: #555;color: #fff;text-transform: uppercase;text-align: center;font-size: 14px;padding: 10px;'>
							DESCRIPCION</th>
							<th style='background: #555;color: #fff;text-transform: uppercase;text-align: center;font-size: 14px;padding: 10px;'>
							CANT</th>
							<th style='background: #555;color: #fff;text-transform: uppercase;text-align: center;font-size: 14px;padding: 10px;'>
							MONTO</th>	
						</tr>
					</thead>
					<tbody>
						<tr >
							<td style='border-bottom: 2px solid #111;color: #333;font-size: 12px;padding: 10px;'>Internet</td><td style='text-align: center;border-bottom: 2px solid #111;color: #333;font-size: 12px;padding: 10px;'>".$array_resumen_tipo_servicio['Internet']['cantidad']."</td><td style='text-align: center;border-bottom: 2px solid #111;color: #333;font-size: 12px;padding: 10px;'>"."$ ".number_format($array_resumen_tipo_servicio['Internet']['monto'],0,",",".")."</td>
						</tr>
						<tr>
							<td style='border-bottom: 2px solid #111;color: #333;font-size: 12px;padding: 10px;'>Television</td><td style='text-align: center;border-bottom: 2px solid #111;color: #333;font-size: 12px;padding: 10px;'>".$array_resumen_tipo_servicio['Television']['cantidad']."</td><td style='text-align: center;border-bottom: 2px solid #111;color: #333;font-size: 12px;padding: 10px;'>"."$ ".number_format($array_resumen_tipo_servicio['Television']['monto'],0,",",".")."</td>
						</tr>
					
						
					</tbody>
					<tfoot>
						<tr>
							<th style='background: #E1E1E1;color: #000000;text-transform: uppercase;text-align: center;font-size: 10px;padding: 10px;' >TOTAL TIPO DE SERVICIOS</th>
							<th style='background: #E1E1E1;color: #000000;text-transform: uppercase;text-align: center;font-size: 10px;padding: 10px;'>".($array_resumen_tipo_servicio['Internet']['cantidad']+$array_resumen_tipo_servicio['Television']['cantidad'])."</th>
							<th style='background: #E1E1E1;color: #000000;text-transform: uppercase;text-align: center;font-size: 10px;padding: 10px;'>".("$ ".number_format($array_resumen_tipo_servicio['Internet']['monto']+$array_resumen_tipo_servicio['Television']['monto'],0,",","."))."</th>			
						</tr>
					</tfoot>
			</table>
		</td>
	</tr>
	<tr>
		<td>
			
		</td>
		<td></td>
		<td>
			
			
		</td>
	</tr>
</table>
<div style='page-break-after: always'></div>
<table style='width: 100%;max-width: 100%;margin-bottom: 1rem;vertical-align: bottom;border-bottom: 2px solid #e3ebf3;border-top: 1px solid #e3ebf3;padding: 0.75rem 2rem;border-spacing: 2px;font-variant: normal;border-collapse: collapse;'>
	<thead>
                <tr>
                    <th style='vertical-align: bottom;border-bottom: 2px solid #e3ebf3;border-top: 1px solid #e3ebf3;padding: 0.75rem 2rem;background: #555;color: #fff;text-transform: uppercase;text-align: center;font-size: 14px;'>Fecha</th>
                    <th style='vertical-align: bottom;border-bottom: 2px solid #e3ebf3;border-top: 1px solid #e3ebf3;padding: 0.75rem 2rem;background: #555;color: #fff;text-transform: uppercase;text-align: center;font-size: 14px;'>Descripción</th>

                    <th style='vertical-align: bottom;border-bottom: 2px solid #e3ebf3;border-top: 1px solid #e3ebf3;padding: 0.75rem 2rem;background: #555;color: #fff;text-transform: uppercase;text-align: center;font-size: 14px;'>Débito</th>
                    <th style='vertical-align: bottom;border-bottom: 2px solid #e3ebf3;border-top: 1px solid #e3ebf3;padding: 0.75rem 2rem;background: #555;color: #fff;text-transform: uppercase;text-align: center;font-size: 14px;'>Crédito</th>

                    <th style='vertical-align: bottom;border-bottom: 2px solid #e3ebf3;border-top: 1px solid #e3ebf3;padding: 0.75rem 2rem;background: #555;color: #fff;text-transform: uppercase;text-align: center;font-size: 14px;'>Equilibrar</th>


                </tr>
   </thead>
   <tbody >
   		<tr><td style='padding: 0.75rem 2rem;border-bottom: 1px solid #e3ebf3;color: #333;font-size: 12px;background-color: rgba(0, 0, 0, 0.05);text-align: center;'>2020-10-08</td><td style='padding: 0.75rem 2rem;border-bottom: 1px solid #e3ebf3;color: #333;font-size: 12px;background-color: rgba(0, 0, 0, 0.05);text-align: center;'>Payment for invoice #1037</td><td style='padding: 0.75rem 2rem;border-bottom: 1px solid #e3ebf3;color: #333;font-size: 12px;background-color: rgba(0, 0, 0, 0.05);text-align: center;'>$ 0</td><td style='padding: 0.75rem 2rem;border-bottom: 1px solid #e3ebf3;color: #333;font-size: 12px;background-color: rgba(0, 0, 0, 0.05);text-align: center;'>$ 10.000</td><td style='padding: 0.75rem 2rem;border-bottom: 1px solid #e3ebf3;color: #333;font-size: 12px;background-color: rgba(0, 0, 0, 0.05);text-align: center;'>$ 10.000</td></tr>
   		<tr><td style='padding: 0.75rem 2rem;border-bottom: 1px solid #e3ebf3;color: #333;font-size: 12px;text-align: center;'>2020-10-08</td><td style='padding: 0.75rem 2rem;border-bottom: 1px solid #e3ebf3;color: #333;font-size: 12px;text-align: center;'>Payment for invoice #1006</td><td style='padding: 0.75rem 2rem;border-bottom: 1px solid #e3ebf3;color: #333;font-size: 12px;text-align: center;'>$ 0</td><td style='padding: 0.75rem 2rem;border-bottom: 1px solid #e3ebf3;color: #333;font-size: 12px;text-align: center;'>$ 50.000</td><td style='padding: 0.75rem 2rem;border-bottom: 1px solid #e3ebf3;color: #333;font-size: 12px;text-align: center;'>$ 60.000</td></tr>
   		<tr><td style='padding: 0.75rem 2rem;border-bottom: 1px solid #e3ebf3;color: #333;font-size: 12px;background-color: rgba(0, 0, 0, 0.05);text-align: center;'>2020-10-08</td><td style='padding: 0.75rem 2rem;border-bottom: 1px solid #e3ebf3;color: #333;font-size: 12px;background-color: rgba(0, 0, 0, 0.05);text-align: center;'>Payment for invoice #1037</td><td style='padding: 0.75rem 2rem;border-bottom: 1px solid #e3ebf3;color: #333;font-size: 12px;background-color: rgba(0, 0, 0, 0.05);text-align: center;'>$ 0</td><td style='padding: 0.75rem 2rem;border-bottom: 1px solid #e3ebf3;color: #333;font-size: 12px;background-color: rgba(0, 0, 0, 0.05);text-align: center;'>$ 10.000</td><td style='padding: 0.75rem 2rem;border-bottom: 1px solid #e3ebf3;color: #333;font-size: 12px;background-color: rgba(0, 0, 0, 0.05);text-align: center;'>$ 10.000</td></tr>
   		<tr><td style='padding: 0.75rem 2rem;border-bottom: 1px solid #e3ebf3;color: #333;font-size: 12px;text-align: center;'>2020-10-08</td><td style='padding: 0.75rem 2rem;border-bottom: 1px solid #e3ebf3;color: #333;font-size: 12px;text-align: center;'>Payment for invoice #1006</td><td style='padding: 0.75rem 2rem;border-bottom: 1px solid #e3ebf3;color: #333;font-size: 12px;text-align: center;'>$ 0</td><td style='padding: 0.75rem 2rem;border-bottom: 1px solid #e3ebf3;color: #333;font-size: 12px;text-align: center;'>$ 50.000</td><td style='padding: 0.75rem 2rem;border-bottom: 1px solid #e3ebf3;color: #333;font-size: 12px;text-align: center;'>$ 60.000</td></tr>
   		
   	</tbody>
   	<tfoot>
                <tr>
                    <th style='vertical-align: bottom;border-bottom: 2px solid #e3ebf3;border-top: 1px solid #e3ebf3;padding: 0.75rem 2rem;background: #555;color: #fff;text-transform: uppercase;text-align: center;font-size: 14px;'>Fecha</th>
                    <th style='vertical-align: bottom;border-bottom: 2px solid #e3ebf3;border-top: 1px solid #e3ebf3;padding: 0.75rem 2rem;background: #555;color: #fff;text-transform: uppercase;text-align: center;font-size: 14px;'>Descripción</th>

                    <th style='vertical-align: bottom;border-bottom: 2px solid #e3ebf3;border-top: 1px solid #e3ebf3;padding: 0.75rem 2rem;background: #555;color: #fff;text-transform: uppercase;text-align: center;font-size: 14px;'>Débito</th>
                    <th style='vertical-align: bottom;border-bottom: 2px solid #e3ebf3;border-top: 1px solid #e3ebf3;padding: 0.75rem 2rem;background: #555;color: #fff;text-transform: uppercase;text-align: center;font-size: 14px;'>Crédito</th>

                    <th style='vertical-align: bottom;border-bottom: 2px solid #e3ebf3;border-top: 1px solid #e3ebf3;padding: 0.75rem 2rem;background: #555;color: #fff;text-transform: uppercase;text-align: center;font-size: 14px;'>Equilibrar</th>


                </tr>
	</tfoot>
	
</table>
</div>";


include (APPPATH."libraries\dendor\autoload.php");

$mpdf = new \Mpdf\Mpdf([

]);
$fecha =new DateTime($fecha);



$mpdf->SetTitle('Cierre de Caja '.$this->reports->obtener_dia($fecha->format("N")).', '.$fecha->format("d-m-Y"));




$mpdf->setFooter('Pagina N° {PAGENO} de {nb}');

$mpdf->writeHtml($contenidoTabla,\Mpdf\HTMLParserMode::HTML_BODY);
$mpdf->Output('Cierre de Caja '.$this->reports->obtener_dia($fecha->format("N")).', '.$fecha->format("d-m-Y").'.pdf',"I");

