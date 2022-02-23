<?php 

$array_afiliaciones=array();
	$var_cuenta_planes=array("Television"=>0); 
	$var_cuenta_planes_montos=array("TelevisionMonto"=>0);
	$television1=array('monto' => 0, 'iva'=>0);
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
		$array_bancos=array("BANCOLOMBIA TV" => array('cantidad' => 0,"monto"=>0 ),"BANCOLOMBIA TELECOMUNICACIONES"=>array('cantidad' => 0,"monto"=>0 ),"BANCOLOMBIA CUENTA CORRIENTE"=>array('cantidad' => 0,"monto"=>0 ),"Caja Virtual"=>array('cantidad' => 0,"monto"=>0 ));
		$array_resumen_tipo_servicio= array('Internet' => array('cantidad' => 0,"monto"=>0 ),"Television"=> array('cantidad' => 0,"monto"=>0 ));
		$array_efectivo=array("cantidad"=>0,"monto"=>0);
		foreach ($lista as $key => $value) { 
			$invoice = $this->db->get_where("invoices",array("tid"=>$value['tid']))->row(); 
			$invoice_items=$this->db->get_where('invoice_items',array('tid' =>$value['tid']))->result_array();
			if(intval($invoice->total)!=0){
			$sumatoria_items=0;
			$items_tocados=array();
			foreach ($invoice_items as $key => $item_invoic) {
				//recorro y pregunto si tiene iva o no el item para la primera tabla
				$valor_parcial=intval($value['credit']);
				$valor_total=intval($invoice->total);
				$valor_item=intval($item_invoic['subtotal']);
				//para la Resumen por Servicios
				if(strpos(strtolower($item_invoic['product']), "mega")!==false){



					
					$nombre_plan=strtolower($item_invoic['product']);
					$nombre_plan=str_replace("solo","",$nombre_plan);
					$nombre_plan=str_replace("v","",$nombre_plan);
					$nombre_plan=str_replace("vs","",$nombre_plan);
					$nombre_plan=str_replace("vc","",$nombre_plan);
					$nombre_plan=str_replace("vc","",$nombre_plan);
					$nombre_plan=str_replace("dedicadas","",$nombre_plan);
					$nombre_plan=str_replace("d","",$nombre_plan);
					$nombre_plan=str_replace(" ","",$nombre_plan);

					$nombre_plan_monto=$nombre_plan.'Monto';
						if($value['credit']!=0 && $valor_item!=0){
				 			$var_cuenta_planes[$nombre_plan]++;			
				 			$cuanto_porcentaje_item_en_invoice=($valor_item*100)/$valor_total;
				 			$valor_item=($valor_parcial*$cuanto_porcentaje_item_en_invoice)/100;
				 			$var_cuenta_planes_montos[$nombre_plan_monto]+=$valor_item;	
				 			$sumatoria_items+=$valor_item;
				 			$items_tocados[$nombre_plan_monto]=true;
			 			}
				}else if(strpos(strtolower($item_invoic['product']), "reconexi")!==false){
					
					if($value['credit']!=0 && $valor_item!=0){
			 		$array_reconexiones['cantidad']++;			
			 			$cuanto_porcentaje_item_en_invoice=($valor_item*100)/$valor_total;
			 			$valor_item=($valor_parcial*$cuanto_porcentaje_item_en_invoice)/100;
						$array_reconexiones['monto']+=$valor_item;
						$sumatoria_items+=$valor_item;
						$items_tocados['array_reconexiones']="monto";
			 		}
					
				}else{
					if(strpos(strtolower($item_invoic['product']), "afilia")!==false ){
						if($value['credit']!=0 && $valor_item!=0){
					 					
					 			$cuanto_porcentaje_item_en_invoice=($valor_item*100)/$valor_total;
					 			$valor_item=($valor_parcial*$cuanto_porcentaje_item_en_invoice)/100;
					 		
						$cuenta_afiliacion=1;
						$monto_afiliacion=0;
						if(isset($array_afiliaciones[$item_invoic['product']])) {
							$array_afiliaciones[$item_invoic['product']]['cuenta_afiliacion']++;
							$array_afiliaciones[$item_invoic['product']]['monto_afiliacion']+=$valor_item;
						}else{
							$array_afiliaciones[$item_invoic['product']]=array('cuenta_afiliacion' => intval($cuenta_afiliacion),"monto_afiliacion"=> $valor_item);
						}
						$sumatoria_items+=$valor_item;
						$items_tocados['array_afiliaciones']=$item_invoic['product'];
					  }

					}else if(strpos(strtolower($item_invoic['product']), "tele")!==false){
							
							if($value['credit']!=0 && $valor_item!=0){
					 		$var_cuenta_planes['Television']++;			
					 			$cuanto_porcentaje_item_en_invoice=($valor_item*100)/$valor_total;
					 			$valor_item=($valor_parcial*$cuanto_porcentaje_item_en_invoice)/100;
					 			$var_cuenta_planes_montos['TelevisionMonto']+=$valor_item;	
					 			$sumatoria_items+=$valor_item;

					 			$cuanto_porcentaje=($valor_parcial*100)/$valor_total;
								$cuanto_iva=$invoice->tax;
								$cuanto_iva=($cuanto_iva*$cuanto_porcentaje)/100;
								$cuanto_iva=$cuanto_iva;
								$television1['monto']+=$valor_item;
								$television1['iva']+=$cuanto_iva;
					 			$items_tocados['TelevisionMonto']=true;
					 		}
					}else{
						if($value['credit']!=0 && $valor_item!=0){
					 					
					 		
					 			$items_tocados['array_afiliaciones']=$item_invoic['product'];
					 		
						 			$cuanto_porcentaje_item_en_invoice=($valor_item*100)/$valor_total;
						 			$valor_item=($valor_parcial*$cuanto_porcentaje_item_en_invoice)/100;
						 		
							$cuenta_afiliacion=1;
							$monto_afiliacion=0;
							if(isset($array_afiliaciones[$item_invoic['product']])) {
								$array_afiliaciones[$item_invoic['product']]['cuenta_afiliacion']++;
								$array_afiliaciones[$item_invoic['product']]['monto_afiliacion']+=$valor_item;
							}else{
								$array_afiliaciones[$item_invoic['product']]=array('cuenta_afiliacion' => intval($cuenta_afiliacion),"monto_afiliacion"=> $valor_item);
							}
							$sumatoria_items+=$valor_item;

						}

						/*saldo anterior se muestra aqui*/
					}
					
				}


			}//final foreach items_invoice
			$conteo=count($items_tocados);
			if($sumatoria_items<$value['credit'] && $conteo!=0 ){
				$diference=$value['credit']-$sumatoria_items;
				if($diference>1){
					
					$valores_por_cada_uno=$diference/$conteo;
					foreach ($items_tocados as $key1 => $value2) {
						if($key1=="array_reconexiones"){
							$array_reconexiones['monto']+=$valores_por_cada_uno;
						}else if($key1=="array_afiliaciones"){
							$array_afiliaciones[$value2]['monto_afiliacion']+=$valores_por_cada_uno;
						}else{
							$var_cuenta_planes_montos[$key1]+=$valores_por_cada_uno;
						}
					}
					
					//var_dump("sum = ".$sumatoria_items." | credit=".$value['credit']." id=".$value['tid']);	
				}

				
				
			}else if($sumatoria_items>$value['credit'] ){
				//cuando los items suman mas que el valor de la factura
				$diference=$sumatoria_items-$value['credit'];
				if($diference>1){
					$conteo=count($items_tocados);
					$valores_por_cada_uno=$diference/$conteo;
					foreach ($items_tocados as $key1 => $value2) {
						if($key1=="array_reconexiones"){
							$array_reconexiones['monto']-=$valores_por_cada_uno;
						}else if($key1=="array_afiliaciones"){
							$array_afiliaciones[$value2]['monto_afiliacion']-=$valores_por_cada_uno;
						}else{
							$var_cuenta_planes_montos[$key1]-=$valores_por_cada_uno;
						}
					}
				
				}
				
			}
			//resumen por cobranza
			if($invoice->tax==0){

			}else{
				$cuantos_prod_con_iva_hay++;
			}
			//end resumen por cobranza
			$items_tocados=array();

			if($value['method']=="Bank"){
				
			}else if($value['method']=="Cash"){
				$array_efectivo['cantidad']++;
				$array_efectivo['monto']+=$value['credit'];
			}
		   }//end invoice->total !=0

		 } //final foreach lista

		 //reparticion de afiliacion combo 
		 if(isset($array_afiliaciones['Afiliación Combo'])){
			 
			 $rep_tv=($array_afiliaciones['Afiliación Combo']['monto_afiliacion']*40)/100;
			 $rep_internet=($array_afiliaciones['Afiliación Combo']['monto_afiliacion']*60)/100;
			 
			 $array_afiliaciones['Afiliación Television']['monto_afiliacion']+=$rep_tv;
			 $array_afiliaciones['Afiliación Television']['cuenta_afiliacion']+=$array_afiliaciones['Afiliación Combo']['cuenta_afiliacion'];
			 
			 if(isset($array_afiliaciones['Afiliación Internet '])){
			 	$array_afiliaciones['Afiliación Internet ']['monto_afiliacion']+=$rep_internet;
			 	$array_afiliaciones['Afiliación Internet ']['cuenta_afiliacion']+=$array_afiliaciones['Afiliación Combo']['cuenta_afiliacion'];	
			 }else{
			 	$array_afiliaciones['Afiliación Internet']['monto_afiliacion']+=$rep_internet;	
			 	$array_afiliaciones['Afiliación Internet']['cuenta_afiliacion']+=$array_afiliaciones['Afiliación Combo']['cuenta_afiliacion'];
			 }
			 
			 unset($array_afiliaciones['Afiliación Combo']);
			 
		}//end reparticion afilizacion combo
		
		 $monto_prod_con_iva_hay=$television1['monto']-$television1['iva'];
		 $monto_iva_prod_con_iva_hay=$television1['iva'];
//bancos
		 foreach ($cuenta1 as $key => $value) {
		 	if($value['estado']!="Anulada"){
		 		
		 		$invoice = $this->db->get_where("invoices",array("tid"=>$value['tid']))->row(); 
		 		if($invoice->refer!=null){
		 			$invoice->refer=str_replace(" ","",$invoice->refer);		 				 			
		 		}		 				 		
		 		if(strtolower($invoice->refer)==strtolower($caja)){		 			
		 			$array_bancos['BANCOLOMBIA TV']['cantidad']++;
					$array_bancos['BANCOLOMBIA TV']['monto']+=$value['credit'];	
		 		}
		 	}
		 }
		 
		 foreach ($cuenta2 as $key => $value) {		 	
		 	if($value['estado']!="Anulada"){
			 	$invoice = $this->db->get_where("invoices",array("tid"=>$value['tid']))->row(); 
				if($invoice->refer!=null){
		 			$invoice->refer=str_replace(" ","",$invoice->refer);		 				 			
		 		}
			 	if(strtolower($invoice->refer)==strtolower($caja)){
			 		$array_bancos['BANCOLOMBIA TELECOMUNICACIONES']['cantidad']++;
					$array_bancos['BANCOLOMBIA TELECOMUNICACIONES']['monto']+=$value['credit'];
				}
			}
		 }
		 
		 foreach ($cuenta3 as $key => $value) {		 	
		 	if($value['estado']!="Anulada"){
			 	$invoice = $this->db->get_where("invoices",array("tid"=>$value['tid']))->row(); 
			 	if($invoice->refer!=null){
		 			$invoice->refer=str_replace(" ","",$invoice->refer);		 				 			
		 		}
			 	if(strtolower($invoice->refer)==strtolower($caja)){
			 		$array_bancos['BANCOLOMBIA CUENTA CORRIENTE']['cantidad']++;
					$array_bancos['BANCOLOMBIA CUENTA CORRIENTE']['monto']+=$value['credit'];
				}
			}
		 }

		 //caja virtual
		 if($caja=="Caja Virtual"){
		 foreach ($cuenta4 as $key => $value) {		 	
		 	if($value['estado']!="Anulada"){
			 		$array_bancos['Caja Virtual']['cantidad']++;
					$array_bancos['Caja Virtual']['monto']+=$value['credit'];
				
			}
		 }
		}
		 //end bancos

		 //resumen por tipo de servicio
		 foreach ($lista as $key => $val1) {
						$inv1 = $this->db->get_where("invoices",array("tid"=>$val1['tid']))->row(); 
						if(intval($inv1->total)!=0){

						$invoice_items = $this->db->get_where("invoice_items",array('tid' => $val1['tid'] ))->result_array();
						$sumatoria_items=0;
						$items_tocados=array();
						foreach ($invoice_items as $key => $item_invoic) {
						$valor_parcial=intval($val1['credit']);
						$valor_total=intval($inv1->total);
						$valor_item=intval($item_invoic['subtotal']);
							if(strpos(strtolower($item_invoic['product']), "mega")!==false){
									if($val1['credit']!=0 && $valor_item!=0){
						 			$array_resumen_tipo_servicio['Internet']['cantidad']++;
						 			$cuanto_porcentaje_item_en_invoice=($valor_item*100)/$valor_total;
									$valor_item=($valor_parcial*$cuanto_porcentaje_item_en_invoice)/100;
									$array_resumen_tipo_servicio['Internet']['monto']+=$valor_item;
									$sumatoria_items+=$valor_item;
									$items_tocados['Internet']=true;
						 		}

						}else if(strpos(strtolower($item_invoic['product']), "tele")!==false){
								
								if($val1['credit']!=0 && $valor_item!=0){
									$array_resumen_tipo_servicio['Television']['cantidad']++;
						 			$cuanto_porcentaje_item_en_invoice=($valor_item*100)/$valor_total;
									$valor_item=($valor_parcial*$cuanto_porcentaje_item_en_invoice)/100;
									$array_resumen_tipo_servicio['Television']['monto']+=$valor_item;
									$sumatoria_items+=$valor_item;
									$items_tocados['Television']=true;
						 		}
								
							}else {
								
						 		if($val1['credit']!=0 && $valor_item!=0){
						 			$array_resumen_tipo_servicio['Internet']['cantidad']++;
						 			$cuanto_porcentaje_item_en_invoice=($valor_item*100)/$valor_total;
									$valor_item=($valor_parcial*$cuanto_porcentaje_item_en_invoice)/100;
									$array_resumen_tipo_servicio['Internet']['monto']+=$valor_item;
									$sumatoria_items+=$valor_item;
									$items_tocados['Internet']=true;
						 		}
							}



						}
						//sumatorias
						$conteo=count($items_tocados);					
						if($sumatoria_items<$val1['credit'] && $conteo!=0 ){
							$diference=$val1['credit']-$sumatoria_items;
							if($diference>1){
								
								$valores_por_cada_uno=$diference/$conteo;
								foreach ($items_tocados as $key1 => $value2) {
									if($key1=="Internet"){
										$array_resumen_tipo_servicio['Internet']['monto']+=$valores_por_cada_uno;
									}else{
										$array_resumen_tipo_servicio['Television']['monto']+=$valores_por_cada_uno;
									}
								}
								
								//var_dump("sum = ".$sumatoria_items." | credit=".$value['credit']." id=".$value['tid']);	
							}

				
				
						}else if($sumatoria_items>$val1['credit'] ){
							//cuando los items suman mas que el valor de la factura
							$diference=$sumatoria_items-$val1['credit'];
							if($diference>1){
								$conteo=count($items_tocados);
								$valores_por_cada_uno=$diference/$conteo;
								foreach ($items_tocados as $key1 => $value2) {
									if($key1=="Internet"){
										$array_resumen_tipo_servicio['Internet']['monto']-=$valores_por_cada_uno;
									}else{
										$array_resumen_tipo_servicio['Television']['monto']-=$valores_por_cada_uno;
									}
								}
							
							}
							
						}
						//end sumatorias
						}//end validacion invoice->total !=0

					}
	$cuantos_prod_sin_iva_hay=$array_resumen_tipo_servicio['Internet']['cantidad'];
	$monto_prod_sin_iva_hay= ($array_resumen_tipo_servicio['Internet']['monto']+$array_resumen_tipo_servicio['Television']['monto'])-($monto_prod_con_iva_hay+$monto_iva_prod_con_iva_hay);

		 //fin resumen por tipo de servicio 
		 //tabla 1
		 $tabla_total_cobranza_monto=$monto_prod_sin_iva_hay+$monto_prod_con_iva_hay+$monto_iva_prod_con_iva_hay;
		//end tabla 1
			//tabla 3 Resumen por Servicios
				/*$var_cantidad_mensualidades=$var_cuenta_planes['1Mega']+$var_cuenta_planes['2Megas']+$var_cuenta_planes['3Megas']+$var_cuenta_planes['5Megas']+$var_cuenta_planes['10Megas']+$var_cuenta_planes['Television'];
				$var_total_mensualidades=$var_cuenta_planes_montos['1MegaMonto']+$var_cuenta_planes_montos['2MegasMonto']+$var_cuenta_planes_montos['3MegasMonto']+$var_cuenta_planes_montos['5MegasMonto']+$var_cuenta_planes_montos['10MegasMonto']+$var_cuenta_planes_montos['TelevisionMonto'];*/
				$var_cantidad_mensualidades=0;
				foreach ($var_cuenta_planes as $key => $v1) {
						$var_cantidad_mensualidades+=$v1;					
				}
				$var_total_mensualidades=0;
				foreach ($var_cuenta_planes_montos as $key => $v1) {
						$var_total_mensualidades+=$v1;					
				}

				$conteo=0;
				while ($conteo<count($var_cuenta_planes)) {
					$proximo_menor_agregar=null;
						foreach ($var_cuenta_planes as $key => $p1) {
									if(!isset($lista_planes_ordenada[$key])){
											if($proximo_menor_agregar==null){
													$proximo_menor_agregar=$key;
											}else{
													$n1 = (int) filter_var($key, FILTER_SANITIZE_NUMBER_INT);  								
													$n2 = (int) filter_var($proximo_menor_agregar, FILTER_SANITIZE_NUMBER_INT);  								
													if($n1<$n2){
															$proximo_menor_agregar=$key;
													}
											}
									}
							}
						if($proximo_menor_agregar!=null){
								$lista_planes_ordenada[$proximo_menor_agregar]=$var_cuenta_planes[$proximo_menor_agregar];
								$conteo++;

						}
				}
				$lineas_str_de_planes="";
				foreach ($lista_planes_ordenada as $key => $pl1) {
					if(strpos(strtolower($key), "mega")!==false){
								$int = (int) filter_var($key, FILTER_SANITIZE_NUMBER_INT);

							$lineas_str_de_planes.="<tr ><td style='border-bottom: 2px solid #111;color: #333;font-size: 12px;padding: 10px;'>Internet ".$int."MG</td><td style='text-align: center;border-bottom: 2px solid #111;color: #333;font-size: 12px;padding: 10px;'>".$var_cuenta_planes[$key]."</td><td style='text-align: center;border-bottom: 2px solid #111;color: #333;font-size: 12px;padding: 1px;'>"."$ ".number_format($var_cuenta_planes_montos[$key.'Monto'],0,",",".")."</td></tr>";				
					}

				}
				
			//end tabla 3 Resumen por Servicios
				
			//sobre anulaciones
				$cuenta_anulaciones=array("Cobranza Efectiva"=>array("cantidad"=>0,"monto"=>0),"Anulado de Cierre"=>array("cantidad"=>0,"monto"=>0),"Anulado de otros Cierres"=>array("cantidad"=>0,"monto"=>0));
						foreach ($lista_anulaciones as $key => $value) {
								$anul=$this->db->get_where("anulaciones",array("transactions_id"=>$value['id']))->row();
								
								if(isset($cuenta_anulaciones[$anul->detalle])) {
									
									$cuenta_anulaciones[$anul->detalle]['cantidad']++;
									
									$invoce = $this->db->get_where("invoices",array("tid"=>$value['tid']))->row();
									$cuenta_anulaciones[$anul->detalle]['monto']+=intval($value['credit']);
									
								}

						} 

			//end sobre Anulaciones
		 	
		 	//tabla resumen por servicios total final
			//calculo tablas meses
						$valores_mes_actual= array('cantidad' =>0 , 'monto'=>0,'Internet'=> array('cantidad' => 0,"monto"=>0),"Television"=> array('cantidad' =>0 ,"monto"=>0 ));
					$valores_mes_anterior= array('cantidad' =>0 , 'monto'=>0,'Internet'=> array('cantidad' => 0,"monto"=>0),"Television"=> array('cantidad' =>0 ,"monto"=>0 ));
					$valores_meses_anteriores= array('cantidad' =>0 , 'monto'=>0,'Internet'=> array('cantidad' => 0,"monto"=>0),"Television"=> array('cantidad' =>0 ,"monto"=>0 ));

					foreach ($lista_mes_actual as $key => $val1) {
						$inv1 = $this->db->get_where("invoices",array("tid"=>$val1['tid']))->row(); 
						$valores_mes_actual['monto']+=$val1['credit'];

						$invoice_items = $this->db->get_where("invoice_items",array('tid' => $val1['tid'] ))->result_array();
						$sumatoria_items=0;
						$items_tocados=array();
						foreach ($invoice_items as $key => $item_invoic) {
						$valor_parcial=intval($val1['credit']);
						$valor_total=intval($inv1->total);
						$valor_item=intval($item_invoic['subtotal']);
							if(strpos(strtolower($item_invoic['product']), "mega")!==false){

						 		if($val1['credit']!=0 && $valor_item!=0){
						 			$valores_mes_actual['Internet']['cantidad']++;
						 			$cuanto_porcentaje_item_en_invoice=($valor_item*100)/$valor_total;
									$valor_item=($valor_parcial*$cuanto_porcentaje_item_en_invoice)/100;
									$valores_mes_actual['Internet']['monto']+=$valor_item;
									$sumatoria_items+=$valor_item;
									$items_tocados['Internet']=true;
						 		}
						 		

							}else if(strpos(strtolower($item_invoic['product']), "tele")!==false){
								
								if($val1['credit']!=0 && $valor_item!=0){
									$valores_mes_actual['Television']['cantidad']++;
						 			$cuanto_porcentaje_item_en_invoice=($valor_item*100)/$valor_total;
									$valor_item=($valor_parcial*$cuanto_porcentaje_item_en_invoice)/100;
									$valores_mes_actual['Television']['monto']+=$valor_item;
									$sumatoria_items+=$valor_item;
									$items_tocados['Television']=true;
						 		}
								
							}else {
								
						 		if($val1['credit']!=0 && $valor_item!=0){
						 			$valores_mes_actual['Internet']['cantidad']++;
						 			$cuanto_porcentaje_item_en_invoice=($valor_item*100)/$valor_total;
									$valor_item=($valor_parcial*$cuanto_porcentaje_item_en_invoice)/100;
									$valores_mes_actual['Internet']['monto']+=$valor_item;
									$sumatoria_items+=$valor_item;
									$items_tocados['Internet']=true;
						 		}
							}



						}
						//sumatorias
						if($sumatoria_items<$val1['credit'] ){
							$diference=$val1['credit']-$sumatoria_items;
							if($diference>1){
								$conteo=count($items_tocados);					
								$valores_por_cada_uno=$diference/$conteo;
								foreach ($items_tocados as $key1 => $value2) {
									if($key1=="Internet"){
										$valores_mes_actual['Internet']['monto']+=$valores_por_cada_uno;
									}else{
										$valores_mes_actual['Television']['monto']+=$valores_por_cada_uno;
									}
								}
								
								//var_dump("sum = ".$sumatoria_items." | credit=".$value['credit']." id=".$value['tid']);	
							}

				
				
						}else if($sumatoria_items>$val1['credit'] ){
							//cuando los items suman mas que el valor de la factura
							$diference=$sumatoria_items-$val1['credit'];
							if($diference>1){
								$conteo=count($items_tocados);
								$valores_por_cada_uno=$diference/$conteo;
								foreach ($items_tocados as $key1 => $value2) {
									if($key1=="Internet"){
										$valores_mes_actual['Internet']['monto']-=$valores_por_cada_uno;
									}else{
										$valores_mes_actual['Television']['monto']-=$valores_por_cada_uno;
									}
								}
							
							}
							
						}
						//end sumatorias

					}

					foreach ($lista_mes_anterior as $key => $val1) {
						$inv1 = $this->db->get_where("invoices",array("tid"=>$val1['tid']))->row(); 
						$valores_mes_anterior['monto']+=$val1['credit'];

						$invoice_items = $this->db->get_where("invoice_items",array('tid' => $val1['tid'] ))->result_array();
						$sumatoria_items=0;
						$items_tocados=array();
						foreach ($invoice_items as $key => $item_invoic) {
						$valor_parcial=intval($val1['credit']);
						$valor_total=intval($inv1->total);
						$valor_item=intval($item_invoic['subtotal']);
							if(strpos(strtolower($item_invoic['product']), "mega")!==false){

						 		if($val1['credit']!=0 && $valor_item!=0){
						 			$valores_mes_anterior['Internet']['cantidad']++;
						 			$cuanto_porcentaje_item_en_invoice=($valor_item*100)/$valor_total;
									$valor_item=($valor_parcial*$cuanto_porcentaje_item_en_invoice)/100;
									$valores_mes_anterior['Internet']['monto']+=$valor_item;
									$sumatoria_items+=$valor_item;
									$items_tocados['Internet']=true;
						 		}
						 		

							}else if(strpos(strtolower($item_invoic['product']), "tele")!==false){
								
								if($val1['credit']!=0 && $valor_item!=0){
									$valores_mes_anterior['Television']['cantidad']++;
						 			$cuanto_porcentaje_item_en_invoice=($valor_item*100)/$valor_total;
									$valor_item=($valor_parcial*$cuanto_porcentaje_item_en_invoice)/100;
									$valores_mes_anterior['Television']['monto']+=$valor_item;
									$sumatoria_items+=$valor_item;
									$items_tocados['Television']=true;
						 		}
								
							}else {
								
						 		if($val1['credit']!=0 && $valor_item!=0){
						 			$valores_mes_anterior['Internet']['cantidad']++;
						 			$cuanto_porcentaje_item_en_invoice=($valor_item*100)/$valor_total;
									$valor_item=($valor_parcial*$cuanto_porcentaje_item_en_invoice)/100;
									$valores_mes_anterior['Internet']['monto']+=$valor_item;
									$sumatoria_items+=$valor_item;
									$items_tocados['Internet']=true;
						 		}
							}



						}
						//sumatorias
						if($sumatoria_items<$val1['credit'] ){
							$diference=$val1['credit']-$sumatoria_items;
							if($diference>1){
								$conteo=count($items_tocados);					
								$valores_por_cada_uno=$diference/$conteo;
								foreach ($items_tocados as $key1 => $value2) {
									if($key1=="Internet"){
										$valores_mes_anterior['Internet']['monto']+=$valores_por_cada_uno;
									}else{
										$valores_mes_anterior['Television']['monto']+=$valores_por_cada_uno;
									}
								}
								
								//var_dump("sum = ".$sumatoria_items." | credit=".$value['credit']." id=".$value['tid']);	
							}

				
				
						}else if($sumatoria_items>$val1['credit'] ){
							//cuando los items suman mas que el valor de la factura
							$diference=$sumatoria_items-$val1['credit'];
							if($diference>1){
								$conteo=count($items_tocados);
								$valores_por_cada_uno=$diference/$conteo;
								foreach ($items_tocados as $key1 => $value2) {
									if($key1=="Internet"){
										$valores_mes_anterior['Internet']['monto']-=$valores_por_cada_uno;
									}else{
										$valores_mes_anterior['Television']['monto']-=$valores_por_cada_uno;
									}
								}
							
							}
							
						}
						//end sumatorias
					}
					//meses anteriores
					foreach ($lista_meses_anteriores as $key => $val1) {
						$inv1 = $this->db->get_where("invoices",array("tid"=>$val1['tid']))->row(); 
						if(intval($inv1->total)!=0){
						$valores_meses_anteriores['monto']+=$val1['credit'];

						$invoice_items = $this->db->get_where("invoice_items",array('tid' => $val1['tid'] ))->result_array();
						$sumatoria_items=0;
						$items_tocados=array();
						foreach ($invoice_items as $key => $item_invoic) {
						$valor_parcial=intval($val1['credit']);
						$valor_total=intval($inv1->total);
						$valor_item=intval($item_invoic['subtotal']);
							if(strpos(strtolower($item_invoic['product']), "mega")!==false){

						 		if($val1['credit']!=0 && $valor_item!=0){
						 			$valores_meses_anteriores['Internet']['cantidad']++;
						 			$cuanto_porcentaje_item_en_invoice=($valor_item*100)/$valor_total;
									$valor_item=($valor_parcial*$cuanto_porcentaje_item_en_invoice)/100;
									$valores_meses_anteriores['Internet']['monto']+=$valor_item;
									$sumatoria_items+=$valor_item;
									$items_tocados['Internet']=true;
						 		}
						 		

							}else if(strpos(strtolower($item_invoic['product']), "tele")!==false){
								
								if($val1['credit']!=0 && $valor_item!=0){
									$valores_meses_anteriores['Television']['cantidad']++;
						 			$cuanto_porcentaje_item_en_invoice=($valor_item*100)/$valor_total;
									$valor_item=($valor_parcial*$cuanto_porcentaje_item_en_invoice)/100;
									$valores_meses_anteriores['Television']['monto']+=$valor_item;
									$sumatoria_items+=$valor_item;
									$items_tocados['Television']=true;
						 		}
								
							}else {
								
						 		if($val1['credit']!=0 && $valor_item!=0){
						 			$valores_meses_anteriores['Internet']['cantidad']++;
						 			$cuanto_porcentaje_item_en_invoice=($valor_item*100)/$valor_total;
									$valor_item=($valor_parcial*$cuanto_porcentaje_item_en_invoice)/100;
									$valores_meses_anteriores['Internet']['monto']+=$valor_item;
									$sumatoria_items+=$valor_item;
									$items_tocados['Internet']=true;
						 		}
							}



						}
						//sumatorias
						$conteo=count($items_tocados);
						if($sumatoria_items<$val1['credit'] && $conteo!=0){
							$diference=$val1['credit']-$sumatoria_items;
							if($diference>1){
								$conteo=count($items_tocados);					
								$valores_por_cada_uno=$diference/$conteo;
								foreach ($items_tocados as $key1 => $value2) {
									if($key1=="Internet"){
										$valores_meses_anteriores['Internet']['monto']+=$valores_por_cada_uno;
									}else{
										$valores_meses_anteriores['Television']['monto']+=$valores_por_cada_uno;
									}
								}
								
								//var_dump("sum = ".$sumatoria_items." | credit=".$value['credit']." id=".$value['tid']);	
							}

				
				
						}else if($sumatoria_items>$val1['credit'] ){
							//cuando los items suman mas que el valor de la factura
							$diference=$sumatoria_items-$val1['credit'];
							if($diference>1){
								$conteo=count($items_tocados);
								$valores_por_cada_uno=$diference/$conteo;
								foreach ($items_tocados as $key1 => $value2) {
									if($key1=="Internet"){
										$valores_meses_anteriores['Internet']['monto']-=$valores_por_cada_uno;
									}else{
										$valores_meses_anteriores['Television']['monto']-=$valores_por_cada_uno;
									}
								}
							
							}
							
						}
						//end sumatorias
					  }//end validacion invoice->total !=0
					}


			//end calculo tablas meses

					  //egresos

                    $cuenta_ordenes= array('cantidad' =>0 ,"monto"=>0);
					$cuenta_transaccions= array('cantidad' =>0 ,"monto"=>0);	
					$cuenta_tr1=array('cantidad' =>0 ,"monto"=>0);

					foreach ($ordenes_compra as $key => $value) {
						if($value['estado']!="Anulada"){
							if($value['cat']=="Compra"){
								$cuenta_transaccions['cantidad']++;
								$cuenta_transaccions['monto']+=$value['debit'];
							}else{
								$cuenta_ordenes['cantidad']++;
								$cuenta_ordenes['monto']+=$value['debit'];
							}
						}
						

					}
				foreach ($tr1 as $key => $value) {
					
					if(strpos(strtolower($value['note']), strtolower($caja))!==false && $value['estado']!="Anulada"){
						$cuenta_tr1['cantidad']++;
						$cuenta_tr1['monto']+=$value['debit'];
					}
					
				}
				
                    //end egresos
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
                        <td style="border-bottom: 2px solid #111;color: #333;font-size: 12px;padding: 1px;text-align:center;">'."$ ".number_format($afiliacion['monto_afiliacion'],0,",",".").'</td>
                        </tr>';
                    }
                    //end afiliaciones

                  
					
//datos pdf para abajo
			$fecha2 = new DateTime($fecha);
		 	$horaC =  $this->aauth->get_user()->hcierre;
			$horaA = $this->aauth->get_user()->hinicial;
			$horas = date("g:i a",strtotime($horaA));
			$horas2 = date("g:i a",strtotime($horaC));
			$user = $this->aauth->get_user()->id;
			$cajero = $this->db->get_where('employee_profile', array('id' => $user))->row();

?>
<style type="text/css">
	.tablas_anchos{
		width: 415px;
	}
	.tablast
	{
		border-collapse: collapse;
		border: 1px solid #5F5F5F;
		border-spacing: 2px;
	}
	.titulos
	{
		font-size: 1rem;
		margin-bottom: 0.5rem;
		/*font-family: inherit;*/
		font-weight: 500;
		line-height: 1.2;
		color: inherit;
		margin-top: -10px;
	}
	.encabezados
	{
		margin-top: 0;
		margin-bottom: 1rem;
		display: block;
		margin-block-start: 1em;
		margin-block-end: 1em;
		margin-inline-start: 0px;
		margin-inline-end: 0px;	
	}
	.enca_resumen
	{
		background: #555;
		color: #fff;
		text-transform: uppercase;
		text-align: center;
		font-size: 14px;
		padding: 10px;
	}
	.et_hr
	{
		margin-top: 1rem;
		margin-bottom: 1rem;
		border: 0;
		border-top: 1px solid rgba(0, 0, 0, 0.1);	
	}
	.filas
	{
		border-bottom: 2px solid #111;
		color: #333;
		font-size: 12px;
		padding: 10px;
	}
</style>

<div style='text-align: center;'>
<img style='display:block;margin:auto;' src='<?=base_url(); ?>userfiles/theme/logo-header.png'>
</div>


<div>
<h6 class="titulos"  >Cierre de Caja</h6>
<hr class="et_hr">
<table width="100%">
	<tr>
		<td width="50%">Caja : <?=$caja?></td>
		<td width="50%">fecha : <?=$fecha2->format('Y-m-d')?></td>
	</tr>
	<tr>
		<td width="50%">Hora Apertura : <?=$horas ?></td>
		<td width="50%">Hora Cierre : <?= $horas2 ?></td>
	</tr>
	<tr>
		<td>Cajero : <?=$cajero->name ?></td>
	</tr>
</table>
<hr class="et_hr">
	<table width="100%">
		<tr>
			<?php if($datos_informe['trans_type']!='Expense'){ ?>
			<td valign="top"><!--general-->
			<h6 class="titulos">Resumen Cobranza</h6>
			<table class="tablas_anchos tablast">
					<thead>
						<tr>
							<th class="enca_resumen">
							DESCRIPCION</th>
							<th class="enca_resumen">
							CANT</th>
							<th class="enca_resumen">
							MONTO</th>	
						</tr>
					</thead>
					<tbody>
						<tr >
							<td class="filas">Excento</td><td style='text-align: center;border-bottom: 2px solid #111;color: #333;font-size: 12px;padding: 10px;'><?=$cuantos_prod_sin_iva_hay ?></td><td style='text-align: center;border-bottom: 2px solid #111;color: #333;font-size: 12px;padding: 1px;'> <?= "$ ".number_format($monto_prod_sin_iva_hay,0,",",".") ?></td>
						</tr>
						<tr>
							<td class="filas">Base</td><td style='text-align: center;border-bottom: 2px solid #111;color: #333;font-size: 12px;padding: 10px;'> <?=$cuantos_prod_con_iva_hay  ?></td><td style='text-align: center;border-bottom: 2px solid #111;color: #333;font-size: 12px;padding: 1px;'> <?="$ ".number_format($monto_prod_con_iva_hay,0,",",".") ?></td>
						</tr>
						<tr>
							<td class="filas">iva</td><td style='text-align: center;border-bottom: 2px solid #111;color: #333;font-size: 12px;padding: 10px;'><?=$cuantos_prod_con_iva_hay  ?></td><td style='text-align: center;border-bottom: 2px solid #111;color: #333;font-size: 12px;padding: 1px;'><?="$ ".number_format($monto_iva_prod_con_iva_hay,0,",",".") ?> </td>
						</tr>
						
					</tbody>
					<tfoot>
						<tr>
							<th style='background: #E1E1E1;color: #000000;text-transform: uppercase;text-align: center;font-size: 10px;padding: 10px;' >TOTAL COBRANZA</th>
							<th style='background: #E1E1E1;color: #000000;text-transform: uppercase;text-align: center;font-size: 10px;padding: 10px;'><?=($cuantos_prod_sin_iva_hay+$cuantos_prod_con_iva_hay)  ?></th>
							<th style='background: #E1E1E1;color: #000000;text-transform: uppercase;text-align: center;font-size: 10px;padding: 1px;'><?=("$ ".number_format($tabla_total_cobranza_monto,0,",","."))  ?></th>			
						</tr>
					</tfoot>
			</table>
			<h6 style='font-size: 1rem;margin-bottom: 0.5rem;font-family: inherit;font-weight: 500;line-height: 1.2;color: inherit;margin-top: 10px;'>Resumen por Banco</h6>
			<table  style='border-collapse: collapse;border: 1px solid #5F5F5F;border-spacing: 2px;'  class="tablas_anchos">
					<thead >
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
							<td style='border-bottom: 2px solid #111;color: #333;font-size: 12px;padding: 10px;'>BANCOLOMBIA TV</td><td style='text-align: center;border-bottom: 2px solid #111;color: #333;font-size: 12px;padding: 10px;'><?=$array_bancos['BANCOLOMBIA TV']['cantidad'] ?></td><td style='text-align: center;border-bottom: 2px solid #111;color: #333;font-size: 12px;padding: 1px;'> <?=("$ ".number_format($array_bancos['BANCOLOMBIA TV']['monto'],0,",","."))  ?></td>
						</tr>
						<tr>
							<td style='border-bottom: 2px solid #111;color: #333;font-size: 12px;padding: 10px;'>BANCOLOMBIA TELECOMUNICACIONES</td><td style='text-align: center;border-bottom: 2px solid #111;color: #333;font-size: 12px;padding: 10px;'><?=$array_bancos['BANCOLOMBIA TELECOMUNICACIONES']['cantidad']  ?></td><td style='text-align: center;border-bottom: 2px solid #111;color: #333;font-size: 12px;padding: 1px;'><?=("$ ".number_format($array_bancos['BANCOLOMBIA TELECOMUNICACIONES']['monto'],0,",","."))  ?></td>
						</tr>
						<tr>
							<td style='border-bottom: 2px solid #111;color: #333;font-size: 12px;padding: 10px;'>BANCOLOMBIA CUENTA CORRIENTE</td><td style='text-align: center;border-bottom: 2px solid #111;color: #333;font-size: 12px;padding: 10px;'><?=$array_bancos['BANCOLOMBIA CUENTA CORRIENTE']['cantidad']  ?></td><td style='text-align: center;border-bottom: 2px solid #111;color: #333;font-size: 12px;padding: 1px;'><?=("$ ".number_format($array_bancos['BANCOLOMBIA CUENTA CORRIENTE']['monto'],0,",","."))  ?></td>
						</tr>
						
					</tbody>
					<tfoot>
						<tr>
							<th style='background: #E1E1E1;color: #000000;text-transform: uppercase;text-align: center;font-size: 10px;padding: 10px;' >TOTAL COBRANZA</th>
							<th style='background: #E1E1E1;color: #000000;text-transform: uppercase;text-align: center;font-size: 10px;padding: 10px;'><?=($array_bancos['BANCOLOMBIA TV']['cantidad']+$array_bancos['BANCOLOMBIA TELECOMUNICACIONES']['cantidad']+$array_bancos['BANCOLOMBIA CUENTA CORRIENTE']['cantidad'])  ?></th>
							<th style='background: #E1E1E1;color: #000000;text-transform: uppercase;text-align: center;font-size: 10px;padding: 1px;'><?=("$ ".number_format($array_bancos['BANCOLOMBIA TV']['monto']+$array_bancos['BANCOLOMBIA TELECOMUNICACIONES']['monto']+$array_bancos['BANCOLOMBIA CUENTA CORRIENTE']['monto'],0,",","."))  ?></th>			
						</tr>
					</tfoot>
			</table>
			<h6 style='font-size: 1rem;margin-bottom: 0.5rem;font-family: inherit;font-weight: 500;line-height: 1.2;color: inherit;margin-top: 10px;'>Resumen por Servicios</h6>
			<table style='border-collapse: collapse;border: 1px solid #5F5F5F;border-spacing: 2px;' class="tablas_anchos">
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
						<?=$lineas_str_de_planes  ?>
						
						<?php  if($var_cuenta_planes['Television']!=0){ ?><tr ><td style='border-bottom: 2px solid #111;color: #333;font-size: 12px;padding: 10px;'>Television</td><td style='text-align: center;border-bottom: 2px solid #111;color: #333;font-size: 12px;padding: 10px;'><?=$var_cuenta_planes['Television']  ?></td><td style='text-align: center;border-bottom: 2px solid #111;color: #333;font-size: 12px;padding: 1px;'><?="$ ".number_format($var_cuenta_planes_montos['TelevisionMonto'],0,",",".")  ?></td></tr><?php } ?>
						<tr>
							<td style='background: #E1E1E1;color: #000000;text-transform: uppercase;text-align: center;font-size: 10px;padding: 10px;' ><strong>TOTAL <br>MENSUALIDADES</strong></td>
							<td style='background: #E1E1E1;color: #000000;text-transform: uppercase;text-align: center;font-size: 10px;padding: 10px;'><strong><?=$var_cantidad_mensualidades  ?></strong></td>
							<td style='background: #E1E1E1;color: #000000;text-transform: uppercase;text-align: center;font-size: 10px;padding: 1px;'><strong><?="$ ".number_format($var_total_mensualidades,0,",",".")  ?></strong></td>			
						</tr>
						<?=$var1_afiliaciones  ?>
						<tr>
							<td style='border-bottom: 2px solid #111;text-transform: uppercase;text-align: center;font-size: 10px;padding: 10px;' ><strong>TOTAL VENTAS</strong></td>
							<td style='border-bottom: 2px solid #111;text-transform: uppercase;text-align: center;font-size: 10px;padding: 10px;'><strong><?=$var_cuenta_afiliaciones  ?></strong></td>
							<td style='border-bottom: 2px solid #111;text-transform: uppercase;text-align: center;font-size: 10px;padding: 1px;'><strong><?="$ ".number_format($var_monto_afiliaciones,0,",",".")  ?></strong></td>			
						</tr>
						<tr>
							<td style='border-bottom: 2px solid #111;text-transform: uppercase;text-align: center;font-size: 10px;padding: 10px;' ><strong>TOTAL <br>RECONEXIONES</strong></td>
							<td style='border-bottom: 2px solid #111;text-transform: uppercase;text-align: center;font-size: 10px;padding: 10px;'><strong><?=$array_reconexiones['cantidad']  ?></strong></td>
							<td style='border-bottom: 2px solid #111;text-transform: uppercase;text-align: center;font-size: 10px;padding: 1px;'><strong><?="$ ".number_format($array_reconexiones['monto'],0,",",".")  ?></strong></td>			
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
							<th style='background: #E1E1E1;color: #000000;text-transform: uppercase;text-align: center;font-size: 10px;padding: 10px;'><?=($var_cantidad_mensualidades+$var_cuenta_afiliaciones+$array_reconexiones['cantidad'])  ?></th>
							<th style='background: #E1E1E1;color: #000000;text-transform: uppercase;text-align: center;font-size: 10px;padding: 1px;'><?="$ ".number_format($var_total_mensualidades+$var_monto_afiliaciones+$array_reconexiones['monto'],0,",",".")  ?></th>			
						</tr>
					</tfoot>
			</table>
			</td><!--general--><?php } ?>
			<td></td><!--general-->
			<td valign="top"><!--general--><?php if($datos_informe['trans_type']!='Expense'){ ?>
			<h6 style='font-size: 1rem;margin-bottom: 0.5rem;font-family: inherit;font-weight: 500;line-height: 1.2;color: inherit;margin-top: 0;'>Resumen por Forma de pago</h6>
			<table style='border-collapse: collapse;border: 1px solid #5F5F5F;border-spacing: 2px;'  class="tablas_anchos">
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
						<?php $cantidad_saldo_anterior; if($saldo_anterior==0){$cantidad_saldo_anterior=0;}else{$cantidad_saldo_anterior=1;} ?>
						<tr >
							<td style='border-bottom: 2px solid #111;color: #333;font-size: 12px;padding: 10px;'>Saldo Anterior</td><td style='text-align: center;border-bottom: 2px solid #111;color: #333;font-size: 12px;padding: 10px;'><?=$cantidad_saldo_anterior  ?></td><td style='text-align: center;border-bottom: 2px solid #111;color: #333;font-size: 12px;padding: 1px;'><?="$ ".number_format($saldo_anterior,0,",",".")  ?></td>
						</tr>
						<tr >
							<td style='border-bottom: 2px solid #111;color: #333;font-size: 12px;padding: 10px;'>Efectivo</td><td style='text-align: center;border-bottom: 2px solid #111;color: #333;font-size: 12px;padding: 10px;'><?=$array_efectivo['cantidad']  ?></td><td style='text-align: center;border-bottom: 2px solid #111;color: #333;font-size: 12px;padding: 1px;'><?="$ ".number_format($array_efectivo['monto'],0,",",".")  ?></td>
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
							<td style='border-bottom: 2px solid #111;color: #333;font-size: 12px;padding: 10px;'>Transferencia</td><td style='text-align: center;border-bottom: 2px solid #111;color: #333;font-size: 12px;padding: 10px;'><?=($array_bancos['Caja Virtual']['cantidad']+$array_bancos['BANCOLOMBIA TV']['cantidad']+$array_bancos['BANCOLOMBIA TELECOMUNICACIONES']['cantidad']+$array_bancos['BANCOLOMBIA CUENTA CORRIENTE']['cantidad'])  ?></td><td style='text-align: center;border-bottom: 2px solid #111;color: #333;font-size: 12px;padding: 1px;'><?=("$ ".number_format($array_bancos['Caja Virtual']['monto']+$array_bancos['BANCOLOMBIA TV']['monto']+$array_bancos['BANCOLOMBIA TELECOMUNICACIONES']['monto']+$array_bancos['BANCOLOMBIA CUENTA CORRIENTE']['monto'],0,",",".")) ?></td>
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
							<th style='background: #E1E1E1;color: #000000;text-transform: uppercase;text-align: center;font-size: 10px;padding: 10px;'><?=($cantidad_saldo_anterior+$array_bancos['Caja Virtual']['cantidad']+$array_efectivo['cantidad']+$array_bancos['BANCOLOMBIA TV']['cantidad']+$array_bancos['BANCOLOMBIA TELECOMUNICACIONES']['cantidad']+$array_bancos['BANCOLOMBIA CUENTA CORRIENTE']['cantidad'])  ?></th>
							<th style='background: #E1E1E1;color: #000000;text-transform: uppercase;text-align: center;font-size: 10px;padding: 1px;'><?=("$ ".number_format($saldo_anterior+$array_bancos['Caja Virtual']['monto']+$array_efectivo['monto']+$array_bancos['BANCOLOMBIA TV']['monto']+$array_bancos['BANCOLOMBIA TELECOMUNICACIONES']['monto']+$array_bancos['BANCOLOMBIA CUENTA CORRIENTE']['monto'],0,",","."))  ?></th>			
						</tr>
					</tfoot>
			</table>
			<h6 style='font-size: 1rem;margin-bottom: 0.5rem;font-family: inherit;font-weight: 500;line-height: 1.2;color: inherit;margin-top: 10px;'>Resumen Anulaciones</h6>
			<table style='border-collapse: collapse;border: 1px solid #5F5F5F;border-spacing: 2px;'  class="tablas_anchos">
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
							<td style='border-bottom: 2px solid #111;color: #333;font-size: 12px;padding: 10px;'>Anulado de cierre</td><td style='text-align: center;border-bottom: 2px solid #111;color: #333;font-size: 12px;padding: 10px;'><?=($cuenta_anulaciones['Anulado de Cierre']['cantidad']+$cuenta_anulaciones['Cobranza Efectiva']['cantidad'])  ?></td><td style='text-align: center;border-bottom: 2px solid #111;color: #333;font-size: 12px;padding: 1px;'><?="$ ".number_format($cuenta_anulaciones['Anulado de Cierre']['monto']+$cuenta_anulaciones['Cobranza Efectiva']['monto'],0,",",".")  ?></td>
						</tr>
						<tr>
							<td style='border-bottom: 2px solid #111;color: #333;font-size: 12px;padding: 10px;'>Anulado de otros cierres</td><td style='text-align: center;border-bottom: 2px solid #111;color: #333;font-size: 12px;padding: 10px;'><?=$cuenta_anulaciones['Anulado de otros Cierres']['cantidad']  ?></td><td style='text-align: center;border-bottom: 2px solid #111;color: #333;font-size: 12px;padding: 1px;'><?="$ ".number_format($cuenta_anulaciones['Anulado de otros Cierres']['monto'],0,",",".")  ?></td>
						</tr>
						<tr>
							<td style='border-bottom: 2px solid #111;color: #333;font-size: 12px;padding: 10px;'>Cobranza efectiva</td><td style='text-align: center;border-bottom: 2px solid #111;color: #333;font-size: 12px;padding: 10px;'></td><td style='text-align: center;border-bottom: 2px solid #111;color: #333;font-size: 12px;padding: 1px;'><?="$ ".number_format($tabla_total_cobranza_monto+($cuenta_anulaciones['Cobranza Efectiva']['monto']+$cuenta_anulaciones['Anulado de Cierre']['monto']+$cuenta_anulaciones['Anulado de otros Cierres']['monto']),0,",",".")  ?></td>
						</tr>
						
					</tbody>
					<tfoot>
						<tr>
							<th style='background: #E1E1E1;color: #000000;text-transform: uppercase;text-align: center;font-size: 10px;padding: 10px;' >COBRADO - ANULADO<br>DE OTRAS FECHAS</th>
							<th style='background: #E1E1E1;color: #000000;text-transform: uppercase;text-align: center;font-size: 10px;padding: 10px;'></th>
							<th style='background: #E1E1E1;color: #000000;text-transform: uppercase;text-align: center;font-size: 10px;padding: 1px;'><?=("$ ".number_format($tabla_total_cobranza_monto,0,",","."))  ?></th>			
						</tr>
					</tfoot>
			</table>
			
			</td><!--general--><?php } ?>
		</tr>
		
	</table>
<table>
	<tr>
	<?php if($datos_informe['trans_type']!='Expense'){ ?>
		<td valign="top">
			<h6 style='font-size: 1rem;margin-bottom: 0.5rem;font-family: inherit;font-weight: 500;line-height: 1.2;color: inherit;margin-top: 10px;'>Resumen de cargos cobrados por meses</h6>
			<table style='border-collapse: collapse;border: 1px solid #5F5F5F;border-spacing: 2px;' class="tablas_anchos">
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
							<td style='border-bottom: 2px solid #111;color: #333;font-size: 12px;padding: 10px;'><?=$texto_mes_actual  ?></td><td style='text-align: center;border-bottom: 2px solid #111;color: #333;font-size: 12px;padding: 10px;'><?=($valores_mes_actual['Internet']['cantidad']+$valores_mes_actual['Television']['cantidad'])  ?></td><td style='text-align: center;border-bottom: 2px solid #111;color: #333;font-size: 12px;padding: 1px;'><?="$ ".number_format($valores_mes_actual['monto'],0,",",".")  ?></td>
						</tr>
						<tr>
							<td style='border-bottom: 2px solid #111;color: #333;font-size: 12px;padding: 10px;'><?=$texto_mes_anterior  ?></td><td style='text-align: center;border-bottom: 2px solid #111;color: #333;font-size: 12px;padding: 10px;'><?=($valores_mes_anterior['Internet']['cantidad']+$valores_mes_anterior['Television']['cantidad'])  ?></td><td style='text-align: center;border-bottom: 2px solid #111;color: #333;font-size: 12px;padding: 1px;'><?="$ ".number_format($valores_mes_anterior['monto'],0,",",".")  ?></td>
						</tr>
						<tr>
							<td style='border-bottom: 2px solid #111;color: #333;font-size: 12px;padding: 10px;'>Meses Anteriores</td><td style='text-align: center;border-bottom: 2px solid #111;color: #333;font-size: 12px;padding: 10px;'><?=($valores_meses_anteriores['Internet']['cantidad']+$valores_meses_anteriores['Television']['cantidad'])  ?></td><td style='text-align: center;border-bottom: 2px solid #111;color: #333;font-size: 12px;padding: 1px;'><?="$ ".number_format($valores_meses_anteriores['monto'],0,",",".")  ?></td>
						</tr>
					
						
					</tbody>
					<tfoot>
						<tr>
							<th style='background: #E1E1E1;color: #000000;text-transform: uppercase;text-align: center;font-size: 10px;padding: 10px;' >TOTAL COBRANZA<br>POR MESES</th>
							<th style='background: #E1E1E1;color: #000000;text-transform: uppercase;text-align: center;font-size: 10px;padding: 10px;'><?=($valores_mes_actual['Internet']['cantidad']+$valores_mes_anterior['Internet']['cantidad']+$valores_meses_anteriores['Internet']['cantidad']+$valores_mes_actual['Television']['cantidad']+$valores_mes_anterior['Television']['cantidad']+$valores_meses_anteriores['Television']['cantidad']) ?></th>
							<th style='background: #E1E1E1;color: #000000;text-transform: uppercase;text-align: center;font-size: 10px;padding: 1px;'><?="$ ".number_format($valores_mes_actual['monto']+$valores_mes_anterior['monto']+$valores_meses_anteriores['monto'],0,",",".")  ?></th>			
						</tr>
					</tfoot>
			</table>
			<h6 style='font-size: 1rem;margin-bottom: 0.5rem;font-family: inherit;font-weight: 500;line-height: 1.2;color: inherit;margin-top: 10px;'>Resumen por tipo de servicio</h6>
			<table style='border-collapse: collapse;border: 1px solid #5F5F5F;border-spacing: 2px;' class="tablas_anchos">
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
							<td style='border-bottom: 2px solid #111;color: #333;font-size: 12px;padding: 10px;'>Internet</td><td style='text-align: center;border-bottom: 2px solid #111;color: #333;font-size: 12px;padding: 10px;'><?=$array_resumen_tipo_servicio['Internet']['cantidad']  ?></td><td style='text-align: center;border-bottom: 2px solid #111;color: #333;font-size: 12px;padding: 1px;'><?="$ ".number_format($array_resumen_tipo_servicio['Internet']['monto'],0,",",".")  ?></td>
						</tr>
						<tr>
							<td style='border-bottom: 2px solid #111;color: #333;font-size: 12px;padding: 10px;'>Television</td><td style='text-align: center;border-bottom: 2px solid #111;color: #333;font-size: 12px;padding: 10px;'><?=$array_resumen_tipo_servicio['Television']['cantidad']  ?></td><td style='text-align: center;border-bottom: 2px solid #111;color: #333;font-size: 12px;padding: 1px;'><?="$ ".number_format($array_resumen_tipo_servicio['Television']['monto'],0,",",".")  ?></td>
						</tr>
					
						
					</tbody>
					<tfoot>
						<tr>
							<th style='background: #E1E1E1;color: #000000;text-transform: uppercase;text-align: center;font-size: 10px;padding: 10px;' >TOTAL TIPO DE SERVICIOS</th>
							<th style='background: #E1E1E1;color: #000000;text-transform: uppercase;text-align: center;font-size: 10px;padding: 10px;'><?=($array_resumen_tipo_servicio['Internet']['cantidad']+$array_resumen_tipo_servicio['Television']['cantidad'])  ?></th>
							<th style='background: #E1E1E1;color: #000000;text-transform: uppercase;text-align: center;font-size: 10px;padding: 1px;'><?=("$ ".number_format($array_resumen_tipo_servicio['Internet']['monto']+$array_resumen_tipo_servicio['Television']['monto'],0,",","."))  ?></th>			
						</tr>
					</tfoot>
			</table>
		</td>
		<td></td>
		<?php } ?>
		<td valign="top">
			<h6 style='font-size: 1rem;margin-bottom: 0.5rem;font-family: inherit;font-weight: 500;line-height: 1.2;color: inherit;margin-top: 10px;'>Resumen de cargos cobrados por meses INTERNET</h6>
			<table style='border-collapse: collapse;border: 1px solid #5F5F5F;border-spacing: 2px;' class="tablas_anchos">
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
							<td style='border-bottom: 2px solid #111;color: #333;font-size: 12px;padding: 10px;'><?=$texto_mes_actual  ?></td><td style='text-align: center;border-bottom: 2px solid #111;color: #333;font-size: 12px;padding: 10px;'><?=$valores_mes_actual['Internet']['cantidad']  ?></td><td style='text-align: center;border-bottom: 2px solid #111;color: #333;font-size: 12px;padding: 1px;'><?="$ ".number_format($valores_mes_actual['Internet']['monto'],0,",",".")  ?></td>
						</tr>
						<tr>
							<td style='border-bottom: 2px solid #111;color: #333;font-size: 12px;padding: 10px;'><?=$texto_mes_anterior  ?></td><td style='text-align: center;border-bottom: 2px solid #111;color: #333;font-size: 12px;padding: 10px;'><?=$valores_mes_anterior['Internet']['cantidad']  ?></td><td style='text-align: center;border-bottom: 2px solid #111;color: #333;font-size: 12px;padding: 1px;'><?="$ ".number_format($valores_mes_anterior['Internet']['monto'],0,",",".")  ?></td>
						</tr>
						<tr>
							<td style='border-bottom: 2px solid #111;color: #333;font-size: 12px;padding: 10px;'>Meses Anteriores</td><td style='text-align: center;border-bottom: 2px solid #111;color: #333;font-size: 12px;padding: 10px;'><?=$valores_meses_anteriores['Internet']['cantidad']  ?></td><td style='text-align: center;border-bottom: 2px solid #111;color: #333;font-size: 12px;padding: 1px;'><?="$ ".number_format($valores_meses_anteriores['Internet']['monto'],0,",",".")  ?></td>
						</tr>
					
						
					</tbody>
					<tfoot>
						<tr>
							<th style='background: #E1E1E1;color: #000000;text-transform: uppercase;text-align: center;font-size: 10px;padding: 10px;' >TOTAL COBRANZA<br>POR MESES</th>
							<th style='background: #E1E1E1;color: #000000;text-transform: uppercase;text-align: center;font-size: 10px;padding: 10px;'><?=($valores_mes_actual['Internet']['cantidad']+$valores_mes_anterior['Internet']['cantidad']+$valores_meses_anteriores['Internet']['cantidad'])  ?></th>
							<th style='background: #E1E1E1;color: #000000;text-transform: uppercase;text-align: center;font-size: 10px;padding: 1px;'><?=("$ ".number_format($valores_mes_actual['Internet']['monto']+$valores_mes_anterior['Internet']['monto']+$valores_meses_anteriores['Internet']['monto'],0,",",".") )  ?></th>			
						</tr>
					</tfoot>
			</table>
		<?php if($datos_informe['trans_type']!='Expense'){ ?>
			<h6 style='font-size: 1rem;margin-bottom: 0.5rem;font-family: inherit;font-weight: 500;line-height: 1.2;color: inherit;'>Resumen de cargos cobrados por meses TV</h6>
			<table style='border-collapse: collapse;border: 1px solid #5F5F5F;border-spacing: 2px;' class="tablas_anchos">
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
							<td style='border-bottom: 2px solid #111;color: #333;font-size: 12px;padding: 10px;'><?=$texto_mes_actual ?></td><td style='text-align: center;border-bottom: 2px solid #111;color: #333;font-size: 12px;padding: 10px;'><?=$valores_mes_actual['Television']['cantidad']  ?></td><td style='text-align: center;border-bottom: 2px solid #111;color: #333;font-size: 12px;padding: 1px;'><?="$ ".number_format($valores_mes_actual['Television']['monto'],0,",",".")  ?></td>
						</tr>
						<tr>
							<td style='border-bottom: 2px solid #111;color: #333;font-size: 12px;padding: 10px;'><?=$texto_mes_anterior  ?></td><td style='text-align: center;border-bottom: 2px solid #111;color: #333;font-size: 12px;padding: 10px;'><?=$valores_mes_anterior['Television']['cantidad']  ?></td><td style='text-align: center;border-bottom: 2px solid #111;color: #333;font-size: 12px;padding: 1px;'><?="$ ".number_format($valores_mes_anterior['Television']['monto'],0,",",".")  ?></td>
						</tr>
						<tr>
							<td style='border-bottom: 2px solid #111;color: #333;font-size: 12px;padding: 10px;'>Meses Anteriores</td><td style='text-align: center;border-bottom: 2px solid #111;color: #333;font-size: 12px;padding: 10px;'><?=$valores_meses_anteriores['Television']['cantidad']  ?></td><td style='text-align: center;border-bottom: 2px solid #111;color: #333;font-size: 12px;padding: 1px;'><?="$ ".number_format($valores_meses_anteriores['Television']['monto'],0,",",".")  ?></td>
						</tr>
					
						
					</tbody>
					<tfoot>
						<tr>
							<th style='background: #E1E1E1;color: #000000;text-transform: uppercase;text-align: center;font-size: 10px;padding: 10px;' >TOTAL COBRANZA<br>POR MESES</th>
							<th style='background: #E1E1E1;color: #000000;text-transform: uppercase;text-align: center;font-size: 10px;padding: 10px;'><?=($valores_mes_actual['Television']['cantidad']+$valores_mes_anterior['Television']['cantidad']+$valores_meses_anteriores['Television']['cantidad'])  ?></th>
							<th style='background: #E1E1E1;color: #000000;text-transform: uppercase;text-align: center;font-size: 10px;padding: 1px;'><?=("$ ".number_format($valores_mes_actual['Television']['monto']+$valores_mes_anterior['Television']['monto']+$valores_meses_anteriores['Television']['monto'],0,",","."))  ?></th>			
						</tr>
					</tfoot>
			</table>
			<?php } ?>
			
			<?php if($datos_informe['trans_type']!='Income'){ ?>
			<h6 style='font-size: 1rem;margin-bottom: 0.5rem;font-family: inherit;font-weight: 500;line-height: 1.2;color: inherit;margin-top: 10px;'>Resumen Egresos</h6>
			<table style='border-collapse: collapse;border: 1px solid #5F5F5F;border-spacing: 2px;' class="tablas_anchos">
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
							<td style='border-bottom: 2px solid #111;color: #333;font-size: 12px;padding: 10px;'>Pago Orden de Compra</td><td style='text-align: center;border-bottom: 2px solid #111;color: #333;font-size: 12px;padding: 10px;'><?=$cuenta_ordenes['cantidad']  ?></td><td style='text-align: center;border-bottom: 2px solid #111;color: #333;font-size: 12px;padding: 1px;'><?="$ ".number_format($cuenta_ordenes['monto'],0,",",".")  ?></td>
						</tr>
						<?php if($cuenta_tr1['cantidad']!=0){ ?><tr><td style='border-bottom: 2px solid #111;color: #333;font-size: 12px;padding: 10px;'>Transferencias</td><td style='text-align: center;border-bottom: 2px solid #111;color: #333;font-size: 12px;padding: 10px;'><?=$cuenta_tr1['cantidad']  ?></td><td style='text-align: center;border-bottom: 2px solid #111;color: #333;font-size: 12px;padding: 1px;'><?="$ ".number_format($cuenta_tr1['monto'],0,",",".")  ?></td></tr><?php }  ?>
						<?php if($cuenta_transaccions['cantidad']!=0){ ?><tr><td style='border-bottom: 2px solid #111;color: #333;font-size: 12px;padding: 10px;'>Transacciones</td><td style='text-align: center;border-bottom: 2px solid #111;color: #333;font-size: 12px;padding: 10px;'><?=$cuenta_transaccions['cantidad']  ?></td><td style='text-align: center;border-bottom: 2px solid #111;color: #333;font-size: 12px;padding: 1px;'><?="$ ".number_format($cuenta_transaccions['monto'],0,",",".")  ?></td></tr><?php } ?>
						
						
					</tbody>
					<tfoot>
						<tr>
							<th style='background: #E1E1E1;color: #000000;text-transform: uppercase;text-align: center;font-size: 10px;padding: 10px;' >TOTAL Egresos</th>
							<th style='background: #E1E1E1;color: #000000;text-transform: uppercase;text-align: center;font-size: 10px;padding: 10px;'><?=($cuenta_ordenes['cantidad']+$cuenta_tr1['cantidad']+$cuenta_transaccions['cantidad'])  ?></th>
							<th style='background: #E1E1E1;color: #000000;text-transform: uppercase;text-align: center;font-size: 10px;padding: 1px;'><?=("$ ".number_format($cuenta_ordenes['monto']+$cuenta_tr1['monto']+$cuenta_transaccions['monto'],0,",","."))  ?></th>			
						</tr>
					</tfoot>
			</table>
			<?php } ?>

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
<table style='width: 100%;max-width: 100%;margin-bottom: 1rem;vertical-align: bottom;border-bottom: 2px solid #e3ebf3;border-top: 1px solid #e3ebf3;padding: 0.75rem 2rem;border-spacing: 2px;font-variant: normal;border-collapse: collapse;margin-right: 8px;'>
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
   		<?= $lista_datos ?>
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
</div> 