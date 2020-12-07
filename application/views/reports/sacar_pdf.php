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
		<td>
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

		</td>
		
		<td></td>
		<td></td>
	</tr>
	<tr>
		<td></td>
		<td></td>
		<td></td>
	</tr>
</table>
</div>";

$mpdf->setFooter('Pagina N° {PAGENO} de {nb}');
$mpdf->writeHtml($contenidoTabla,\Mpdf\HTMLParserMode::HTML_BODY);
$mpdf->Output();
