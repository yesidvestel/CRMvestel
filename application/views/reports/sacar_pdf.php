<?php 

include (APPPATH."libraries\dendor\autoload.php");

$mpdf = new \Mpdf\Mpdf([

]);
$mpdf->SetTitle('Lista de Usuarios');

$contenidoTabla="

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
							<td style='border-bottom: 2px solid #111;color: #333;font-size: 12px;padding: 10px;'>Excento</td><td style='text-align: center;border-bottom: 2px solid #111;color: #333;font-size: 12px;padding: 10px;'>12</td><td style='text-align: center;border-bottom: 2px solid #111;color: #333;font-size: 12px;padding: 10px;'>$ 545.000</td>
						</tr>
						<tr>
							<td style='border-bottom: 2px solid #111;color: #333;font-size: 12px;padding: 10px;'>Base</td><td style='text-align: center;border-bottom: 2px solid #111;color: #333;font-size: 12px;padding: 10px;'>0</td><td style='text-align: center;border-bottom: 2px solid #111;color: #333;font-size: 12px;padding: 10px;'>$ 0</td>
						</tr>
						<tr>
							<td style='border-bottom: 2px solid #111;color: #333;font-size: 12px;padding: 10px;'>iva</td><td style='text-align: center;border-bottom: 2px solid #111;color: #333;font-size: 12px;padding: 10px;'>0</td><td style='text-align: center;border-bottom: 2px solid #111;color: #333;font-size: 12px;padding: 10px;'>$ 0</td>
						</tr>
						
					</tbody>
					<tfoot>
						<tr>
							<th style='background: #E1E1E1;color: #000000;text-transform: uppercase;text-align: center;font-size: 10px;padding: 10px;' >TOTAL COBRANZA</th>
							<th style='background: #E1E1E1;color: #000000;text-transform: uppercase;text-align: center;font-size: 10px;padding: 10px;'>12</th>
							<th style='background: #E1E1E1;color: #000000;text-transform: uppercase;text-align: center;font-size: 10px;padding: 10px;'>$ 545.000</th>			
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
							<td style='border-bottom: 2px solid #111;color: #333;font-size: 12px;padding: 10px;'>Bancolombia</td><td style='text-align: center;border-bottom: 2px solid #111;color: #333;font-size: 12px;padding: 10px;'>12</td><td style='text-align: center;border-bottom: 2px solid #111;color: #333;font-size: 12px;padding: 10px;'>$ 545.000</td>
						</tr>
						<tr>
							<td style='border-bottom: 2px solid #111;color: #333;font-size: 12px;padding: 10px;'>BBVA colombia</td><td style='text-align: center;border-bottom: 2px solid #111;color: #333;font-size: 12px;padding: 10px;'>0</td><td style='text-align: center;border-bottom: 2px solid #111;color: #333;font-size: 12px;padding: 10px;'>$ 0</td>
						</tr>
						
						
					</tbody>
					<tfoot>
						<tr>
							<th style='background: #E1E1E1;color: #000000;text-transform: uppercase;text-align: center;font-size: 10px;padding: 10px;' >TOTAL COBRANZA</th>
							<th style='background: #E1E1E1;color: #000000;text-transform: uppercase;text-align: center;font-size: 10px;padding: 10px;'>12</th>
							<th style='background: #E1E1E1;color: #000000;text-transform: uppercase;text-align: center;font-size: 10px;padding: 10px;'>$ 545.000</th>			
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
							<td style='border-bottom: 2px solid #111;color: #333;font-size: 12px;padding: 10px;'>Efectivo</td><td style='text-align: center;border-bottom: 2px solid #111;color: #333;font-size: 12px;padding: 10px;'>12</td><td style='text-align: center;border-bottom: 2px solid #111;color: #333;font-size: 12px;padding: 10px;'>$ 545.000</td>
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
							<td style='border-bottom: 2px solid #111;color: #333;font-size: 12px;padding: 10px;'>Transferencia</td><td style='text-align: center;border-bottom: 2px solid #111;color: #333;font-size: 12px;padding: 10px;'>0</td><td style='text-align: center;border-bottom: 2px solid #111;color: #333;font-size: 12px;padding: 10px;'>$ 0</td>
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
							<th style='background: #E1E1E1;color: #000000;text-transform: uppercase;text-align: center;font-size: 10px;padding: 10px;'>12</th>
							<th style='background: #E1E1E1;color: #000000;text-transform: uppercase;text-align: center;font-size: 10px;padding: 10px;'>$ 545.000</th>			
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
							<td style='border-bottom: 2px solid #111;color: #333;font-size: 12px;padding: 10px;'>Cobranza efectiva</td><td style='text-align: center;border-bottom: 2px solid #111;color: #333;font-size: 12px;padding: 10px;'>12</td><td style='text-align: center;border-bottom: 2px solid #111;color: #333;font-size: 12px;padding: 10px;'>$ 545.000</td>
						</tr>
						<tr>
							<td style='border-bottom: 2px solid #111;color: #333;font-size: 12px;padding: 10px;'>Anulado de cierre</td><td style='text-align: center;border-bottom: 2px solid #111;color: #333;font-size: 12px;padding: 10px;'>0</td><td style='text-align: center;border-bottom: 2px solid #111;color: #333;font-size: 12px;padding: 10px;'>$ 0</td>
						</tr>
						<tr>
							<td style='border-bottom: 2px solid #111;color: #333;font-size: 12px;padding: 10px;'>Anulado de otros cierres</td><td style='text-align: center;border-bottom: 2px solid #111;color: #333;font-size: 12px;padding: 10px;'>0</td><td style='text-align: center;border-bottom: 2px solid #111;color: #333;font-size: 12px;padding: 10px;'>$ 0</td>
						</tr>
						
					</tbody>
					<tfoot>
						<tr>
							<th style='background: #E1E1E1;color: #000000;text-transform: uppercase;text-align: center;font-size: 10px;padding: 10px;' >COBRADO - ANULADO<br>DE OTRAS FECHAS</th>
							<th style='background: #E1E1E1;color: #000000;text-transform: uppercase;text-align: center;font-size: 10px;padding: 10px;'>12</th>
							<th style='background: #E1E1E1;color: #000000;text-transform: uppercase;text-align: center;font-size: 10px;padding: 10px;'>$ 545.000</th>			
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
						<tr >
							<td style='border-bottom: 2px solid #111;color: #333;font-size: 12px;padding: 10px;'>Internet 1MG</td><td style='text-align: center;border-bottom: 2px solid #111;color: #333;font-size: 12px;padding: 10px;'>12</td><td style='text-align: center;border-bottom: 2px solid #111;color: #333;font-size: 12px;padding: 10px;'>$ 545.000</td>
						</tr>
						<tr>
							<td style='border-bottom: 2px solid #111;color: #333;font-size: 12px;padding: 10px;'>Internet 2MG</td><td style='text-align: center;border-bottom: 2px solid #111;color: #333;font-size: 12px;padding: 10px;'>0</td><td style='text-align: center;border-bottom: 2px solid #111;color: #333;font-size: 12px;padding: 10px;'>$ 0</td>
						</tr>
						<tr>
							<td style='border-bottom: 2px solid #111;color: #333;font-size: 12px;padding: 10px;'>Internet 3MG</td><td style='text-align: center;border-bottom: 2px solid #111;color: #333;font-size: 12px;padding: 10px;'>0</td><td style='text-align: center;border-bottom: 2px solid #111;color: #333;font-size: 12px;padding: 10px;'>$ 0</td>
						</tr>
						<tr>
							<td style='border-bottom: 2px solid #111;color: #333;font-size: 12px;padding: 10px;'>Internet 5MG</td><td style='text-align: center;border-bottom: 2px solid #111;color: #333;font-size: 12px;padding: 10px;'>0</td><td style='text-align: center;border-bottom: 2px solid #111;color: #333;font-size: 12px;padding: 10px;'>$ 0</td>
						</tr>
						<tr>
							<td style='border-bottom: 2px solid #111;color: #333;font-size: 12px;padding: 10px;'>Internet 10MG</td><td style='text-align: center;border-bottom: 2px solid #111;color: #333;font-size: 12px;padding: 10px;'>0</td><td style='text-align: center;border-bottom: 2px solid #111;color: #333;font-size: 12px;padding: 10px;'>$ 0</td>
						</tr>
						<tr>
							<td style='border-bottom: 2px solid #111;color: #333;font-size: 12px;padding: 10px;'>Television</td><td style='text-align: center;border-bottom: 2px solid #111;color: #333;font-size: 12px;padding: 10px;'>0</td><td style='text-align: center;border-bottom: 2px solid #111;color: #333;font-size: 12px;padding: 10px;'>$ 0</td>
						</tr>
						<tr>
							<td style='background: #E1E1E1;color: #000000;text-transform: uppercase;text-align: center;font-size: 10px;padding: 10px;' ><strong>TOTAL <br>MENSUALIDADES</strong></td>
							<td style='background: #E1E1E1;color: #000000;text-transform: uppercase;text-align: center;font-size: 10px;padding: 10px;'><strong>12</strong></td>
							<td style='background: #E1E1E1;color: #000000;text-transform: uppercase;text-align: center;font-size: 10px;padding: 10px;'><strong>$ 545.000</strong></td>			
						</tr>
						<tr>
							<td style='border-bottom: 2px solid #111;color: #333;font-size: 12px;padding: 10px;'>Afiliacion Borrar</td><td style='text-align: center;border-bottom: 2px solid #111;color: #333;font-size: 12px;padding: 10px;'>0</td><td style='text-align: center;border-bottom: 2px solid #111;color: #333;font-size: 12px;padding: 10px;'>$ 0</td>
						</tr>
						<tr>
							<td style='border-bottom: 2px solid #111;text-transform: uppercase;text-align: center;font-size: 10px;padding: 10px;' ><strong>TOTAL VENTAS</strong></td>
							<td style='border-bottom: 2px solid #111;text-transform: uppercase;text-align: center;font-size: 10px;padding: 10px;'><strong>12</strong></td>
							<td style='border-bottom: 2px solid #111;text-transform: uppercase;text-align: center;font-size: 10px;padding: 10px;'><strong>$ 545.000</strong></td>			
						</tr>
						<tr>
							<td style='border-bottom: 2px solid #111;text-transform: uppercase;text-align: center;font-size: 10px;padding: 10px;' ><strong>TOTAL <br>RECONEXIONES</strong></td>
							<td style='border-bottom: 2px solid #111;text-transform: uppercase;text-align: center;font-size: 10px;padding: 10px;'><strong>12</strong></td>
							<td style='border-bottom: 2px solid #111;text-transform: uppercase;text-align: center;font-size: 10px;padding: 10px;'><strong>$ 545.000</strong></td>			
						</tr>
						<tr>
							<td style='border-bottom: 2px solid #111;text-transform: uppercase;text-align: center;font-size: 10px;padding: 10px;' ><strong>TOTAL MATERIALES</strong></td>
							<td style='border-bottom: 2px solid #111;text-transform: uppercase;text-align: center;font-size: 10px;padding: 10px;'><strong>12</strong></td>
							<td style='border-bottom: 2px solid #111;text-transform: uppercase;text-align: center;font-size: 10px;padding: 10px;'><strong>$ 545.000</strong></td>			
						</tr>
						<tr>
							<td style='border-bottom: 2px solid #111;text-transform: uppercase;text-align: center;font-size: 10px;padding: 10px;' ><strong>TOTAL OTROS</strong></td>
							<td style='border-bottom: 2px solid #111;text-transform: uppercase;text-align: center;font-size: 10px;padding: 10px;'><strong>12</strong></td>
							<td style='border-bottom: 2px solid #111;text-transform: uppercase;text-align: center;font-size: 10px;padding: 10px;'><strong>$ 545.000</strong></td>			
						</tr>
					</tbody>
					<tfoot>
						<tr>
							<th style='background: #E1E1E1;color: #000000;text-transform: uppercase;text-align: center;font-size: 10px;padding: 10px;' >TOTAL</th>
							<th style='background: #E1E1E1;color: #000000;text-transform: uppercase;text-align: center;font-size: 10px;padding: 10px;'>12</th>
							<th style='background: #E1E1E1;color: #000000;text-transform: uppercase;text-align: center;font-size: 10px;padding: 10px;'>$ 545.000</th>			
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
							<td style='border-bottom: 2px solid #111;color: #333;font-size: 12px;padding: 10px;'>Diciembre 2020</td><td style='text-align: center;border-bottom: 2px solid #111;color: #333;font-size: 12px;padding: 10px;'>12</td><td style='text-align: center;border-bottom: 2px solid #111;color: #333;font-size: 12px;padding: 10px;'>$ 545.000</td>
						</tr>
						<tr>
							<td style='border-bottom: 2px solid #111;color: #333;font-size: 12px;padding: 10px;'>Noviembre 2020</td><td style='text-align: center;border-bottom: 2px solid #111;color: #333;font-size: 12px;padding: 10px;'>0</td><td style='text-align: center;border-bottom: 2px solid #111;color: #333;font-size: 12px;padding: 10px;'>$ 0</td>
						</tr>
					
						
					</tbody>
					<tfoot>
						<tr>
							<th style='background: #E1E1E1;color: #000000;text-transform: uppercase;text-align: center;font-size: 10px;padding: 10px;' >TOTAL COBRANZA<br>POR MESES</th>
							<th style='background: #E1E1E1;color: #000000;text-transform: uppercase;text-align: center;font-size: 10px;padding: 10px;'>12</th>
							<th style='background: #E1E1E1;color: #000000;text-transform: uppercase;text-align: center;font-size: 10px;padding: 10px;'>$ 545.000</th>			
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
							<td style='border-bottom: 2px solid #111;color: #333;font-size: 12px;padding: 10px;'>Diciembre 2020</td><td style='text-align: center;border-bottom: 2px solid #111;color: #333;font-size: 12px;padding: 10px;'>12</td><td style='text-align: center;border-bottom: 2px solid #111;color: #333;font-size: 12px;padding: 10px;'>$ 545.000</td>
						</tr>
						<tr>
							<td style='border-bottom: 2px solid #111;color: #333;font-size: 12px;padding: 10px;'>Noviembre 2020</td><td style='text-align: center;border-bottom: 2px solid #111;color: #333;font-size: 12px;padding: 10px;'>0</td><td style='text-align: center;border-bottom: 2px solid #111;color: #333;font-size: 12px;padding: 10px;'>$ 0</td>
						</tr>
					
						
					</tbody>
					<tfoot>
						<tr>
							<th style='background: #E1E1E1;color: #000000;text-transform: uppercase;text-align: center;font-size: 10px;padding: 10px;' >TOTAL COBRANZA<br>POR MESES</th>
							<th style='background: #E1E1E1;color: #000000;text-transform: uppercase;text-align: center;font-size: 10px;padding: 10px;'>12</th>
							<th style='background: #E1E1E1;color: #000000;text-transform: uppercase;text-align: center;font-size: 10px;padding: 10px;'>$ 545.000</th>			
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
							<td style='border-bottom: 2px solid #111;color: #333;font-size: 12px;padding: 10px;'>Diciembre 2020</td><td style='text-align: center;border-bottom: 2px solid #111;color: #333;font-size: 12px;padding: 10px;'>12</td><td style='text-align: center;border-bottom: 2px solid #111;color: #333;font-size: 12px;padding: 10px;'>$ 545.000</td>
						</tr>
						<tr>
							<td style='border-bottom: 2px solid #111;color: #333;font-size: 12px;padding: 10px;'>Noviembre 2020</td><td style='text-align: center;border-bottom: 2px solid #111;color: #333;font-size: 12px;padding: 10px;'>0</td><td style='text-align: center;border-bottom: 2px solid #111;color: #333;font-size: 12px;padding: 10px;'>$ 0</td>
						</tr>
					
						
					</tbody>
					<tfoot>
						<tr>
							<th style='background: #E1E1E1;color: #000000;text-transform: uppercase;text-align: center;font-size: 10px;padding: 10px;' >TOTAL COBRANZA<br>POR MESES</th>
							<th style='background: #E1E1E1;color: #000000;text-transform: uppercase;text-align: center;font-size: 10px;padding: 10px;'>12</th>
							<th style='background: #E1E1E1;color: #000000;text-transform: uppercase;text-align: center;font-size: 10px;padding: 10px;'>$ 545.000</th>			
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
							<td style='border-bottom: 2px solid #111;color: #333;font-size: 12px;padding: 10px;'>Internet</td><td style='text-align: center;border-bottom: 2px solid #111;color: #333;font-size: 12px;padding: 10px;'>12</td><td style='text-align: center;border-bottom: 2px solid #111;color: #333;font-size: 12px;padding: 10px;'>$ 545.000</td>
						</tr>
						<tr>
							<td style='border-bottom: 2px solid #111;color: #333;font-size: 12px;padding: 10px;'>Television</td><td style='text-align: center;border-bottom: 2px solid #111;color: #333;font-size: 12px;padding: 10px;'>0</td><td style='text-align: center;border-bottom: 2px solid #111;color: #333;font-size: 12px;padding: 10px;'>$ 0</td>
						</tr>
					
						
					</tbody>
					<tfoot>
						<tr>
							<th style='background: #E1E1E1;color: #000000;text-transform: uppercase;text-align: center;font-size: 10px;padding: 10px;' >TOTAL COBRANZA<br>POR MESES</th>
							<th style='background: #E1E1E1;color: #000000;text-transform: uppercase;text-align: center;font-size: 10px;padding: 10px;'>12</th>
							<th style='background: #E1E1E1;color: #000000;text-transform: uppercase;text-align: center;font-size: 10px;padding: 10px;'>$ 545.000</th>			
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
</div>";

$mpdf->setFooter('Pagina N° {PAGENO} de {nb}');
$mpdf->writeHtml($contenidoTabla,\Mpdf\HTMLParserMode::HTML_BODY);
$mpdf->Output();
