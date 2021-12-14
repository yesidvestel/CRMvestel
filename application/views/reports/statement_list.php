<style>
  /* Cambios sobre la propia tabla */
  table {
    border-collapse: collapse;
    border: 1px solid #5F5F5F;
	  width: 80%;
  }
  /* Espacio de relleno en celdas y cabeceras */
  td,
  th {
    padding: 10px;
  }
  /* Modificación de estilos en cabeceras */
  th {
    background: #555;
    color: #fff;
    text-transform: uppercase;
	  text-align: center;
	  font-size: 14px;
  }
  /* Modificación de estilos en celdas */
  td {   
    border-bottom: 2px solid #111;
    color: #333;
    font-size: 12px;
  }
	/* Modificación de estilos en celdas */
  . {
    text-align: left;
    border-bottom: 2px solid #111;
    color: #333;
    font-size: 12px;
  }
	.cen
	{
		text-align: left;
	}
	/* Modificación de estilos en pie de tabla */
  .pie {
    background:#E1E1E1;
    color: #000000;
    text-transform: uppercase;
	text-align: center;
	  font-size: 10px;
  }
.sub {
	color: #000000;
    text-transform: uppercase;
	text-align: center;
	  font-size: 10px;
	font-weight: bold;
  }
</style>
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
//resumen por cobranza
			
//end resumen por cobranza
			if(intval($invoice->total)!=0){
			$sumatoria_items=0;
			$items_tocados=array();
			foreach ($invoice_items as $key => $item_invoic) {
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
				
				
			}
			//termina foreach items invoices
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
		
			if($invoice->tax==0){
				
			}else{
				$cuantos_prod_con_iva_hay++;
			}
			$items_tocados=array();
			if($value['method']=="Bank"){
			
			}else if($value['method']=="Cash"){
				$array_efectivo['cantidad']++;
				$array_efectivo['monto']+=$value['credit'];
			}
}//end invoice->total !=0

			//$var_prueba1+=intval($value['credit']);
			//var_dump("TID= ".$invoice->tid."  ValorTotal =".$var_prueba1." valor_invoice=".$invoice->total);
		 }//termina foreach de lista
		 
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
		 		
		 		if(strtolower($invoice->refer)==strtolower($filter[5])){		 			
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
			 	if(strtolower($invoice->refer)==strtolower($filter[5])){
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
			 	if(strtolower($invoice->refer)==strtolower($filter[5])){
			 		$array_bancos['BANCOLOMBIA CUENTA CORRIENTE']['cantidad']++;
					$array_bancos['BANCOLOMBIA CUENTA CORRIENTE']['monto']+=$value['credit'];
				}
			}
		 }
		 //caja virtual
		 if($filter[5]=="Caja Virtual"){
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
 			//var_dump($var_prueba1);
		 //tabla 1
		 $tabla_total_cobranza_monto=$monto_prod_sin_iva_hay+$monto_prod_con_iva_hay+$monto_iva_prod_con_iva_hay;
		//end tabla 1
			//tabla 3 Resumen por Servicios
			$var_cantidad_mensualidades=0;
			foreach ($var_cuenta_planes as $key => $v1) {
					$var_cantidad_mensualidades+=$v1;					
			}
			$var_total_mensualidades=0;
			foreach ($var_cuenta_planes_montos as $key => $v1) {
					$var_total_mensualidades+=$v1;					
			}
			//end tabla 3 Resumen por Servicios
			
			//sobre afiliaciones


			//end sobre afiliaciones
		 	
		 	//tabla resumen por servicios total final
			$fecha = new DateTime($datos_informe['sdate']);
		 	$horaC =  $this->aauth->get_user()->hcierre;
			$horaA = $this->aauth->get_user()->hinicial;
			$horas = date("g:i a",strtotime($horaA));
			$horas2 = date("g:i a",strtotime($horaC));
			$user = $this->aauth->get_user()->id;
			$cajero = $this->db->get_where('employee_profile', array('id' => $user))->row();
		 ?>

<article class="content">
	<form method="POST" action="<?=base_url()?>reports/sacar_pdf" target="_blank">
		<input type="hidden" name="pay_acc" value="<?=$datos_informe['pay_acc']?>" >
		<input type="hidden" name="trans_type" value="<?=$datos_informe['trans_type']?>">
		<input type="hidden" name="sdate" value="<?=$datos_informe['sdate']?>">
		<input type="hidden" name="edate" value="<?=$datos_informe['edate']?>">
		<input type="hidden" name="caja" value="<?=$filter[5]?>">

		<button class="btn btn-primary" style="margin-left: 3px;" onclick="enviar_a_apertura()">Cierre de Caja</button>
	
	</form>
    <div class="card card-block">
        <div id="notify" class="alert alert-success" style="display:none;">
            <a href="#" class="close" data-dismiss="alert">&times;</a>

            <div class="message"></div>
        </div>
		 <div class="card card-block">

        
            <h6><?php echo $this->lang->line('') ?>Cierre de Caja</h6>
			 <hr>
			 
            <p class="col-sm-6"><?php echo $this->lang->line('') ?>Caja : <?php echo $filter[5] ?></p>
			 <p class="col-sm-6">Fecha: <?php echo $fecha->format("Y-m-d") ?></p>
			 <p class="col-sm-6">Hora apertura: <?php echo $horas ?></p>
			 <p class="col-sm-6">Hora cierre: <?php echo $horas2 ?></p>
			 <p class="col-sm-6">Cajero: <?php echo $cajero->name ?></p>
			 <p class="col-sm-6" id="efectivo-caja">Efectivo Caja: $0</p>
            <hr class="col-sm-12">
            <?php if($datos_informe['trans_type']!="Expense"){ ?>
			 <div class="col-sm-6">
			<h6><?php echo $this->lang->line('') ?>Resumen Cobranza</h6>
				 
			<table class="party">
				<thead>
					<tr>
						<th>DESCRIPCION</th><th>CANT</th><th>MONTO</th>	
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>Excento</td><td style="text-align: center"><?=$cuantos_prod_sin_iva_hay?></td><td style="text-align: center"><?="$ ".number_format($monto_prod_sin_iva_hay,0,",",".")?></td>
					</tr>
					<tr>
						<td>Base</td><td style="text-align: center"><?=$cuantos_prod_con_iva_hay?></td><td style="text-align: center"><?="$ ".number_format($monto_prod_con_iva_hay,0,",",".")?></td>
					</tr>
					<tr>
						<td>iva</td><td style="text-align: center"></td><td style="text-align: center"><?="$ ".number_format($monto_iva_prod_con_iva_hay,0,",",".")?></td>
					</tr>
					
				</tbody>
				<tfoot>
					<tr>
						<th class="pie">TOTAL COBRANZA</th>
						<th class="pie"><?=$cuantos_prod_sin_iva_hay+$cuantos_prod_con_iva_hay?></th>
						<th class="pie"><?="$ ".number_format($tabla_total_cobranza_monto,0,",",".")?></th>			
					</tr>
				</tfoot>
			</table>
			<hr>
			<h6><?php echo $this->lang->line('') ?>Resumen por Banco</h6>
			<table class="party">
				<thead>
					<tr>
						<th>DESCRIPCION</th>
						<th>CANT</th>
						<th>MONTO</th>			
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>BANCOLOMBIA TV</td>
						<td style="text-align: center"><?=$array_bancos['BANCOLOMBIA TV']['cantidad']?></td>
						<td style="text-align: center"><?="$ ".number_format($array_bancos['BANCOLOMBIA TV']['monto'],0,",",".")?></td>
					</tr>
					<tr>
						<td>BANCOLOMBIA TELECOMUNICACIONES</td>
						<td style="text-align: center"><?=$array_bancos['BANCOLOMBIA TELECOMUNICACIONES']['cantidad']?></td>
						<td style="text-align: center"><?="$ ".number_format($array_bancos['BANCOLOMBIA TELECOMUNICACIONES']['monto'],0,",",".")?></td>
					</tr>
					<tr>
						<td>BANCOLOMBIA CUENTA CORRIENTE</td>
						<td style="text-align: center"><?=$array_bancos['BANCOLOMBIA CUENTA CORRIENTE']['cantidad']?></td>
						<td style="text-align: center"><?="$ ".number_format($array_bancos['BANCOLOMBIA CUENTA CORRIENTE']['monto'],0,",",".")?></td>
					</tr>				
				</tbody>
				<tfoot>
					<tr>
						<th class="pie">TOTAL COBRANZA</th>
						<th class="pie"><?= $array_bancos['BANCOLOMBIA TV']['cantidad']+$array_bancos['BANCOLOMBIA TELECOMUNICACIONES']['cantidad']+$array_bancos['BANCOLOMBIA CUENTA CORRIENTE']['cantidad'] ?></th>
						<th class="pie"><?= "$ ".number_format($array_bancos['BANCOLOMBIA TV']['monto']+$array_bancos['BANCOLOMBIA TELECOMUNICACIONES']['monto']+$array_bancos['BANCOLOMBIA CUENTA CORRIENTE']['monto'],0,",",".") ?></th>			
					</tr>
				</tfoot>
			</table>
			<hr>
			<h6><?php echo $this->lang->line('') ?>Resumen por Servicios</h6>
			<table class="party">
				<thead>
					<tr>
						<th>DESCRIPCION</th>
						<th>CANT</th>
						<th>MONTO</th>			
					</tr>
				</thead>
				<tbody>
					<?php $lista_planes_ordenada=array(); 
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
					 ?>
					<?php foreach ($lista_planes_ordenada as $key => $pl1) {
						if(strpos(strtolower($key), "mega")!==false){
									$int = (int) filter_var($key, FILTER_SANITIZE_NUMBER_INT);  
							?>
							<tr>
								<td>Internet <?= $int ?>MG</td>
								<td style="text-align: center"><?=$var_cuenta_planes[$key]?></td>
								<td style="text-align: center"><?="$ ".number_format($var_cuenta_planes_montos[$key.'Monto'],0,",",".")?></td>
							</tr>

					<?php }} ?>
					
					<?php if($var_cuenta_planes['Television']!=0){  ?>
					<tr>
						<td>Television</td>
						<td style="text-align: center"><?=$var_cuenta_planes['Television']?></td>
						<td style="text-align: center"><?="$ ".number_format($var_cuenta_planes_montos['TelevisionMonto'],0,",",".")?></td>
					</tr>
					<?php } ?>
					<tr>
						<th class="pie">TOTAL MENSUALIDADES</th>
						<th class="pie"><?=$var_cantidad_mensualidades?></th>
						<th class="pie"><?="$ ".number_format($var_total_mensualidades,0,",",".") ?></th>			
					</tr>
					<?php 
					$var_cuenta_afiliaciones=0;
					$var_monto_afiliaciones=0;
					foreach ($array_afiliaciones as $key => $afiliacion) { 
						$var_cuenta_afiliaciones+=$afiliacion['cuenta_afiliacion'];
						$var_monto_afiliaciones+=$afiliacion['monto_afiliacion'];
						?>
					<tr>
						<td><?=$key?></td>
						<td style="text-align: center"><?=$afiliacion['cuenta_afiliacion']?></td>
						<td style="text-align: center"><?="$ ".number_format($afiliacion['monto_afiliacion'],0,",",".")?></td>
					</tr>
					<?php } ?>
					<tr>
						<td class="sub">Total Ventas</td>
						<td class="sub"><?=$var_cuenta_afiliaciones?></td>
						<td class="sub"><?="$ ".number_format($var_monto_afiliaciones,0,",",".")?></td>
					</tr>
					<tr>
						<td class="sub">Total Reconexiones</td>
						<td class="sub"><?=$array_reconexiones['cantidad']?></td>
						<td class="sub"><?="$ ".number_format($array_reconexiones['monto'],0,",",".")?></td>
					</tr>
					<tr>
						<td class="sub">Total Materiales</td>
						<td class="sub">0</td>
						<td class="sub">0</td>
					</tr>
					<tr>
						<td class="sub">Total Otros</td>
						<td class="sub">0</td>
						<td class="sub">0</td>
					</tr>
				</tbody>
				<tfoot>
					<tr>
						<?php $var_total_resumen_por_servicios=$var_total_mensualidades+$var_monto_afiliaciones+$array_reconexiones['monto']; ?>
						<th class="pie">TOTAL</th>
						<th class="pie"><?=$var_cantidad_mensualidades+$var_cuenta_afiliaciones+$array_reconexiones['cantidad']?></th>
						<th class="pie"><?= "$ ".number_format($var_total_resumen_por_servicios,0,",",".") ?></th>			
					</tr>
				</tfoot>
			</table>
			<hr>
			<h6><?php echo $this->lang->line('') ?>Resumen de cargos cobrados por meses</h6>
			<table class="party">
				<thead>
					<tr>
						<th>DESCRIPCION</th>
						<th>CANT</th>
						<th>MONTO</th>			
					</tr>
				</thead>
				<tbody>
					<?php 
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
						$conteo=count($items_tocados);					
						if($sumatoria_items<$val1['credit'] && $conteo!=0){
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
						$conteo=count($items_tocados);
						if($sumatoria_items<$val1['credit'] && $conteo!=0){
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



					 ?>

					<tr>
						<td><?=$texto_mes_actual?></td>
						<td style="text-align: center"><?=$valores_mes_actual['Internet']['cantidad']+$valores_mes_actual['Television']['cantidad']?></td>
						<td style="text-align: center"><?="$ ".number_format($valores_mes_actual['monto'],0,",",".")?></td>
					</tr>
					<tr>
						<td><?=$texto_mes_anterior?></td>
						<td style="text-align: center"><?=$valores_mes_anterior['Internet']['cantidad']+$valores_mes_anterior['Television']['cantidad']?></td>
						<td style="text-align: center"><?="$ ".number_format($valores_mes_anterior['monto'],0,",",".")?></td>
					</tr>
					<tr>
						<td>Meses Anteriores</td>
						<td style="text-align: center"><?=$valores_meses_anteriores['Internet']['cantidad']+$valores_meses_anteriores['Television']['cantidad']?></td>
						<td style="text-align: center"><?="$ ".number_format($valores_meses_anteriores['monto'],0,",",".")?></td>
					</tr>					
				</tbody>
				<tfoot>
					<tr>
						<th class="pie">TOTAL COBRANZA POR MESES</th>
						<th class="pie"><?=($valores_mes_actual['Internet']['cantidad']+$valores_mes_anterior['Internet']['cantidad']+$valores_meses_anteriores['Internet']['cantidad']+$valores_mes_actual['Television']['cantidad']+$valores_mes_anterior['Television']['cantidad']+$valores_meses_anteriores['Television']['cantidad'])?></th>
						<th class="pie"><?="$ ".number_format($valores_mes_actual['monto']+$valores_mes_anterior['monto']+$valores_meses_anteriores['monto'],0,",",".") ?></th>			
					</tr>
				</tfoot>
			</table>
        </div>
    	<?php } ?>

			 <div class="col-sm-6">       
			 <?php if($datos_informe['trans_type']!="Expense"){ ?>     
			<h6><?php echo $this->lang->line('') ?>Resumen por Forma de pago</h6>
			<table class="party">
				<thead>
					<tr>
						<th>DESCRIPCION</th>
						<th>CANT</th>
						<th>MONTO</th>			
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>Saldo Anterior</td>
						<?php $cantidad_saldo_anterior; if($saldo_anterior==0){$cantidad_saldo_anterior=0;}else{$cantidad_saldo_anterior=1;} ?>
						<td style="text-align: center"><?=$cantidad_saldo_anterior?></td>
						<td style="text-align: center"><?="$ ".number_format($saldo_anterior,0,",",".")?></td>
					</tr>
					<tr>
						<td>Efectivo</td>
						<td style="text-align: center"><?=$array_efectivo['cantidad']?></td>
						<td style="text-align: center"><?="$ ".number_format($array_efectivo['monto'],0,",",".")?></td>
					</tr>
					<tr>
						<td>Tarjeta Debito</td>
						<td style="text-align: center">0</td>
						<td style="text-align: center">0</td>
					</tr>
					<tr>
						<td>Tarjeta Credito</td>
						<td style="text-align: center">0</td>
						<td style="text-align: center">0</td>
					</tr>
					<tr>
						<td>Deposito</td>
						<td style="text-align: center">0</td>
						<td style="text-align: center">0</td>
					</tr>
					<tr>
						<td>Transferencia</td>
						<td style="text-align: center"><?=$array_bancos['Caja Virtual']['cantidad']+$array_bancos['BANCOLOMBIA TV']['cantidad']+$array_bancos['BANCOLOMBIA TELECOMUNICACIONES']['cantidad']+$array_bancos['BANCOLOMBIA CUENTA CORRIENTE']['cantidad']?></td>
						<td style="text-align: center"><?="$ ".number_format($array_bancos['Caja Virtual']['monto']+$array_bancos['BANCOLOMBIA TV']['monto']+$array_bancos['BANCOLOMBIA TELECOMUNICACIONES']['monto']+$array_bancos['BANCOLOMBIA CUENTA CORRIENTE']['monto'],0,",",".")?></td>
					</tr>
					<tr>
						<td>Cheque</td>
						<td style="text-align: center">0</td>
						<td style="text-align: center">0</td>
					</tr>
					<tr>
						<td>Retencion</td>
						<td style="text-align: center">0</td>
						<td style="text-align: center">0</td>
					</tr>
					<tr>
						<td>Domiciliacion Bancaria</td>
						<td style="text-align: center">0</td>
						<td style="text-align: center">0</td>
					</tr>
					
				</tbody>
				<tfoot>
					<tr>
						<th class="pie">TOTAL FORMA PAGO</th>
						<th class="pie"><?=$cantidad_saldo_anterior+$array_efectivo['cantidad']+$array_bancos['BANCOLOMBIA TV']['cantidad']+$array_bancos['BANCOLOMBIA TELECOMUNICACIONES']['cantidad']+$array_bancos['BANCOLOMBIA CUENTA CORRIENTE']['cantidad']?></th>
						<th class="pie"><?="$ ".number_format($saldo_anterior+$array_efectivo['monto']+$array_bancos['BANCOLOMBIA TV']['monto']+$array_bancos['BANCOLOMBIA TELECOMUNICACIONES']['monto']+$array_bancos['BANCOLOMBIA CUENTA CORRIENTE']['monto'],0,",",".")?></th>			
					</tr>
				</tfoot>
			</table>
			<hr>
			<h6><?php echo $this->lang->line('') ?>Resumen Anulaciones</h6>
			<table class="party">
				<thead>
					<tr>
						<th>DESCRIPCION</th>
						<th>CANT</th>
						<th>MONTO</th>			
					</tr>
				</thead>
				<tbody>
					<?php 
						$cuenta_anulaciones=array("Cobranza Efectiva"=>array("cantidad"=>0,"monto"=>0),"Anulado de Cierre"=>array("cantidad"=>0,"monto"=>0),"Anulado de otros Cierres"=>array("cantidad"=>0,"monto"=>0));
						foreach ($lista_anulaciones as $key => $value) {
								$anul=$this->db->get_where("anulaciones",array("transactions_id"=>$value['id']))->row();
								
								if(isset($cuenta_anulaciones[$anul->detalle])) {
									
									$cuenta_anulaciones[$anul->detalle]['cantidad']++;
									
									$invoce = $this->db->get_where("invoices",array("tid"=>$value['tid']))->row();
									$cuenta_anulaciones[$anul->detalle]['monto']+=intval($value['credit']);
									
								}

						} 

					?>
					
					<tr>
						<td>Anulado de cierre</td>
						<td style="text-align: center"><?=$cuenta_anulaciones['Anulado de Cierre']['cantidad']+$cuenta_anulaciones['Cobranza Efectiva']['cantidad']?></td>
						<td style="text-align: center"><?="$ ".number_format($cuenta_anulaciones['Anulado de Cierre']['monto']+$cuenta_anulaciones['Cobranza Efectiva']['monto'],0,",",".")?></td>
					</tr>
					<tr>
						<td>Anulado de otros cierres</td>
						<td style="text-align: center"><?=$cuenta_anulaciones['Anulado de otros Cierres']['cantidad']?></td>
						<td style="text-align: center"><?="$ ".number_format($cuenta_anulaciones['Anulado de otros Cierres']['monto'],0,",",".")?></td>
					</tr>
					<tr>
						<td>Cobranza Efectiva</td>
						<td style="text-align: center"></td>
						<td style="text-align: center"><?="$ ".number_format($tabla_total_cobranza_monto+($cuenta_anulaciones['Cobranza Efectiva']['monto']+$cuenta_anulaciones['Anulado de Cierre']['monto']+$cuenta_anulaciones['Anulado de otros Cierres']['monto']),0,",",".")?></td>
					</tr>
					
					
				</tbody>
				<tfoot>
					<tr>
						<th class="pie">COBRADO - ANULADO DE OTRAS FECHAS</th>
						<th class="pie"></th>
						<th class="pie"><?="$ ".number_format($tabla_total_cobranza_monto,0,",",".")?></th>			
					</tr>
				</tfoot>
			</table>
			<hr>
			<h6><?php echo $this->lang->line('') ?>Resumen de cargos cobrados por meses INTERNET</h6>
			<table class="party">
				<thead>
					<tr>
						<th>DESCRIPCION</th>
						<th>CANT</th>
						<th>MONTO</th>			
					</tr>
				</thead>
				<tbody>
					<tr>
						<td><?=$texto_mes_actual?></td>
						<td style="text-align: center"><?=$valores_mes_actual['Internet']['cantidad']?></td>
						<td style="text-align: center"><?="$ ".number_format($valores_mes_actual['Internet']['monto'],0,",",".") ?></td>
					</tr>
					<tr>
						<td><?=$texto_mes_anterior?></td>
						<td style="text-align: center"><?=$valores_mes_anterior['Internet']['cantidad']?></td>
						<td style="text-align: center"><?="$ ".number_format($valores_mes_anterior['Internet']['monto'],0,",",".") ?></td>
					</tr>
					<tr>
						<td>Meses Anteriores</td>
						<td style="text-align: center"><?=$valores_meses_anteriores['Internet']['cantidad']?></td>
						<td style="text-align: center"><?="$ ".number_format($valores_meses_anteriores['Internet']['monto'],0,",",".") ?></td>
					</tr>						
				</tbody>
				<tfoot>
					<tr>
						<th class="pie">TOTAL COBRANZA POR MESES</th>
						<th class="pie"><?=$valores_mes_actual['Internet']['cantidad']+$valores_mes_anterior['Internet']['cantidad']+$valores_meses_anteriores['Internet']['cantidad']?></th>
						<th class="pie"><?= "$ ".number_format($valores_mes_actual['Internet']['monto']+$valores_mes_anterior['Internet']['monto']+$valores_meses_anteriores['Internet']['monto'],0,",",".") ?></th>			
					</tr>
				</tfoot>
			</table>
			<hr>
			<h6><?php echo $this->lang->line('') ?>Resumen de cargos cobrados por meses TV</h6>
			<table class="party">
				<thead>
					<tr>
						<th>DESCRIPCION</th>
						<th>CANT</th>
						<th>MONTO</th>			
					</tr>
				</thead>
				<tbody>
					<tr>
						<td><?=$texto_mes_actual?></td>
						<td style="text-align: center"><?=$valores_mes_actual['Television']['cantidad']?></td>
						<td style="text-align: center"><?="$ ".number_format($valores_mes_actual['Television']['monto'],0,",",".") ?></td>
					</tr>
					<tr>
						<td><?=$texto_mes_anterior?></td>
						<td style="text-align: center"><?=$valores_mes_anterior['Television']['cantidad']?></td>
						<td style="text-align: center"><?="$ ".number_format($valores_mes_anterior['Television']['monto'],0,",",".") ?></td>
					</tr>
					<tr>
						<td>Meses Anteriores</td>
						<td style="text-align: center"><?=$valores_meses_anteriores['Television']['cantidad']?></td>
						<td style="text-align: center"><?="$ ".number_format($valores_meses_anteriores['Television']['monto'],0,",",".") ?></td>
					</tr>						
				</tbody>
				<tfoot>
					<tr>
						<th class="pie">TOTAL COBRANZA POR MESES</th>
						<th class="pie"><?=$valores_mes_actual['Television']['cantidad']+$valores_mes_anterior['Television']['cantidad']+$valores_meses_anteriores['Television']['cantidad']?></th>
						<th class="pie"><?= "$ ".number_format($valores_mes_actual['Television']['monto']+$valores_mes_anterior['Television']['monto']+$valores_meses_anteriores['Television']['monto'],0,",",".") ?></th>			
					</tr>
				</tfoot>
			</table>
			<hr>
			<h6><?php echo $this->lang->line('') ?>Resumen por tipo de servicio</h6>
			<table class="party">
				<thead>
					<tr>
						<th>DESCRIPCION</th>
						<th>CANT</th>
						<th>MONTO</th>			
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>Internet</td>
						<td style="text-align: center"><?=$array_resumen_tipo_servicio['Internet']['cantidad']?></td>
						<td style="text-align: center"><?="$ ".number_format($array_resumen_tipo_servicio['Internet']['monto'],0,",",".")?></td>
					</tr>
					<tr>
						<td>Television</td>
						<td style="text-align: center"><?=$array_resumen_tipo_servicio['Television']['cantidad']?></td>
						<td style="text-align: center"><?="$ ".number_format($array_resumen_tipo_servicio['Television']['monto'],0,",",".")?></td>
					</tr>					
				</tbody>
				<tfoot>
					<tr>
						<th class="pie">TOTAL TIPO DE SERVICIOS</th>
						<th class="pie"><?=$array_resumen_tipo_servicio['Internet']['cantidad']+$array_resumen_tipo_servicio['Television']['cantidad']?></th>
						<th class="pie"><?="$ ".number_format($array_resumen_tipo_servicio['Internet']['monto']+$array_resumen_tipo_servicio['Television']['monto'],0,",",".") ?></th>			
					</tr>
				</tfoot>
			</table>
			<hr>
			<?php } ?>
			<?php 
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
					
					if(strpos(strtolower($value['note']), strtolower($filter[5]))!==false && $value['estado']!="Anulada"){
						$cuenta_tr1['cantidad']++;
						$cuenta_tr1['monto']+=$value['debit'];
					}
					
				}
				
				

			 ?>

			 <?php if($datos_informe['trans_type']=="All" || $datos_informe['trans_type']=="Expense"){ ?>
			<h6>Resumen Egresos</h6>
			<table class="party">
				<thead>
					<tr>
						<th>DESCRIPCION</th>
						<th>CANT</th>
						<th>MONTO</th>			
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>Pago Orden de Compra</td>
						<td style="text-align: center"><?=$cuenta_ordenes['cantidad']?></td>
						<td style="text-align: center;padding: 1px;"><?="$ ".number_format($cuenta_ordenes['monto'],0,",",".")?></td>
					</tr>
					<?php if($cuenta_tr1['cantidad']!=0){ ?>
					<tr>
						<td>Transferencias</td>
						<td style="text-align: center"><?=$cuenta_tr1['cantidad']?></td>
						<td style="text-align: center;padding: 1px;"><?="$ ".number_format($cuenta_tr1['monto'],0,",",".")?></td>
					</tr>
					<?php } ?>
					<?php if($cuenta_transaccions['cantidad']!=0){ ?>
					<tr>
						<td>Transacciones</td>
						<td style="text-align: center"><?=$cuenta_transaccions['cantidad']?></td>
						<td style="text-align: center;padding: 1px;"><?="$ ".number_format($cuenta_transaccions['monto'],0,",",".")?></td>
					</tr>
					<?php } ?>
					
				</tbody>
				<tfoot>
					<tr>
						<th class="pie">TOTAL Egresos</th>
						<th class="pie"><?=$cuenta_ordenes['cantidad']+$cuenta_tr1['cantidad']+$cuenta_transaccions['cantidad']?></th>
						<th class="pie" style="padding: 1px;"><?="$ ".number_format($cuenta_ordenes['monto']+$cuenta_tr1['monto']+$cuenta_transaccions['monto'],0,",",".") ?></th>			
					</tr>
				</tfoot>
			</table>
			<?php } ?>
        </div>
		
    </div>
		
        <div class="grid_3 grid_4">
            

            


            <table class="table table-striped" cellspacing="0" width="100%">
                <thead>
                <tr>
                    <th><?php echo $this->lang->line('Date') ?></th>
                    <th><?php echo $this->lang->line('Description') ?></th>

                    <th><?php echo $this->lang->line('Debit') ?></th>
                    <th><?php echo $this->lang->line('Credit') ?></th>

                    <th><?php echo $this->lang->line('Balance') ?></th>


                </tr>
                </thead>
                <tbody id="entries">
                </tbody>

                <tfoot>
                <tr>
                    <th><?php echo $this->lang->line('Date') ?></th>
                    <th><?php echo $this->lang->line('Description') ?></th>

                    <th><?php echo $this->lang->line('Debit') ?></th>
                    <th><?php echo $this->lang->line('Credit') ?></th>

                    <th><?php echo $this->lang->line('Balance') ?></th>


                </tr>
                </tfoot>
            </table>
        </div>
    </div>
</article>
<script type="text/javascript">


    $(document).ready(function () {

        $('#entries').html('<td class="text-lg-center" colspan="5">Data loading...</td>');

        $.ajax({

            url: baseurl + 'reports/statements',
            type: 'POST',
            data: <?php echo "{'ac': '" . $filter[0] . "','sd':'" . $filter[2] . "','ed':'" . $filter[3] . "','ty':'" . $filter[1] . "'}"; ?>,
            dataType: 'html',
            success: function (data) {
                $('#entries').html(data);
                //var x=$.cookie("cierre_variable_efectivo_format");
                //$("#efectivo-caja").text("Efectivo Caja: "+x);

            },
            error: function (data) {
                $('#response').html('Error')
            }

        });
    });
    function enviar_a_apertura(){
    	setTimeout(function(){
    		window.location.href=baseurl+'invoices/apertura';
    	},2000);
    	
    }
</script>
