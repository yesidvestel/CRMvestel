<!doctype html>
<?php 
if ($servicios['television']!==no){
		$producto = $this->db->get_where('products',array('pid'=>27))->row();
		$totaltv = $producto->product_price+3992;
	
}if ($servicios['combo']!==no){
	
					$producto2 = $this->db->get_where('products',array('product_name'=>$servicios['combo']))->row();
                    $x1=strtolower($servicios['combo']);
                    $x1=str_replace(" ","", $x1);

                    $producto2 = $this->db->query("SELECT * FROM products where LOWER(REPLACE(product_name,' ',''))='".$x1."'")->result_array();                    
					$inter = $producto2[0]['product_price'];
}
$equipo = $this->db->get_where('equipos',array('asignado'=>$details['abonado']))->row();
$serial = $equipo->serial;
$fcontrato = $details['f_contrato'];
?>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Contrato # <?php echo $details['documento'] ?></title>
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
            width: 50%;
        }

        .myco2 {
            width: 50%;
        }
		.end1 {
			text-align: right;
		}

        .myw {
            width: 50%;
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
		.cla {
			text-align: center;
			font-weight: bold;
		}
		
   
     
    </style>
</head>

<body>

<div class="invoice-box">
	<table width="100%">
  <tbody>
    <tr>
      <td style="width: 24%"><img src="<?php echo FCPATH . 'userfiles/company/' . $this->config->item('logo') ?>" style="max-width:20%;"></td>
      <td class="end1" style="width: 25%"><h2>CONTRATO ÚNICO DE <br>SERVICIOS FIJOS </h2>No. <span style="border-bottom: 1px solid;"><?php echo $details['documento'] ?></span></td>
		<td rowspan="8" style="width: 2%"></td>
      <td colspan="2" rowspan="3" style="width: 48%; text-align: justify;">
		  
		 <h4>TERMINACIÓN</h4>
		Usted puede terminar el contrato en cualquier momento sin penalidades. Para esto debe
		realizar una solicitud a través de cualquiera de nuestros Medios de Atención mínimo 3 días
		hábiles antes del corte de facturación (su corte de facturación es el día 21 de cada mes). Si
		presenta la solicitud con una anticipación menor, la terminación del servicio se dará en el
		siguiente periodo de facturación.
		Así mismo, usted puede cancelar cualquiera de los servicios contratados, para lo que le
		informaremos las condiciones en las que serán prestados los servicios no cancelados y
		actualizaremos el contrato. Así mismo, si el operador no inicia la prestación del servicio en el
		plazo acordado, usted puede pedir la restitución de su dinero y la terminación del contrato.
		<H4>PAGO Y FACTURACIÓN</H4>
		La factura le debe llegar como mínimo 5 días hábiles antes de la fecha de pago. Si no llega,
		puede solicitarla a través de nuestros Medios de Atención y debe pagarla oportunamente.
		Si no paga a tiempo, previo aviso, suspenderemos su servicio hasta que pague sus saldos
		pendientes. Contamos con 3 días hábiles luego de su pago para reconectarle el servicio. Si no
		paga a tiempo, también podemos reportar su deuda a las centrales de riesgo. Para esto
		tenemos que avisarle por lo menos con 20 días calendario de anticipación.
		Si paga luego de este reporte, tenemos la obligación dentro del mes de seguimiento de
		informar su pago para que ya no aparezca reportado. Si tiene un reclamo sobre su factura,
		puede presentarlo antes de la fecha de pago y en ese caso no debe pagar las sumas reclamadas
		hasta que resolvamos su solicitud. Si ya pagó, tiene 6 meses para presentar la reclamación.
		</td>
      
    </tr>
    <tr>
		
      <td style="width: 15%"><img src="<?php echo FCPATH . 'userfiles/company/qr_vestel.png'?>" style="float: left"></img></td>
      <td align="left" style="width: 30%"><br><br><br><br><h1>VESTEL S.A.S</h1></td>
      
    </tr>
    <tr>
      <td colspan="2" style="background-color: black;color: white; font-size: x-large;text-align: justify">
		  	Este contrato explica las condiciones para la prestación
			de los servicios entre usted, Vesga Telecomunicaciones y Vesga Television (VESTEL S.A.S), por el que pagará mínimo
			mensualmente <span style="border-bottom: 1px solid;border-bottom-color: white"><?php echo amountFormat($totaltv+$inter) ?></span>. Este contrato
		  tendrá vigencia de <span style="border-bottom: 1px solid;border-bottom-color: white">12</span> meses, contados a partir
			del <span style="border-bottom: 1px solid;border-bottom-color: white"><?php echo date("d/m/Y",strtotime($fcontrato)) ?></span>. El plazo máximo de instalación
			es de 15 días hábiles. Acepto que mi contrato se
			renueve sucesivamente y automáticamente por un plazo
			igual a la inicial.
		</td>
      
      
    </tr>
    <tr>
      <td colspan="2" style="text-align: justify">
		  <h4>EL SERVICIO</h4>
			Con este contrato nos comprometemos a prestarle los servicios que usted elija*:
			Internet fijo Televisión Servicios adicionales <span style="border-bottom: 1px solid;"><?php if ($servicios['television']!==no){ echo $servicios['television'];} if ($servicios['combo']!==no){ echo ' + '.$servicios['combo'];}if ($servicios['puntos']!=='0'){ echo ' + '.$servicios['puntos'].' Puntos';} ?></span>
			
			Usted se compromete a pagar oportunamente el precio acordado. El servicio se activará a
			más tardar el día <span style="border-bottom: 1px solid;"><?php echo date("d/m/Y",strtotime($fcontrato."+ 15 days")) ?></span>			
			
		</td>
      
      <td colspan="2">
		  <table width="100%" border="1">
  <tbody>
    <tr>
      <td align="center"><img height="130px" src="<?=base_url()?>assets/firmas_digitales/<?=$id?>.png"></img><img height="130px" src="<?=base_url()?>assets/huellas_digitales/Huella_CUS_<?=$id?>.png"></img><br>Con esta firma acepta recibir la factura solo por medios electrónicos</td>
    </tr>
  </tbody>
</table>

		
		</td>
      
    </tr>
    <tr>
      <td colspan="2">
		  <table width="100%" border="1">
  <tbody>
    <tr style="border-radius: 20px">
      <td style="font-size: x-large">
		<h4>INFORMACIÓN DEL SUSCRIPTOR</h4><br>
		Contrato No.: <span style="border-bottom: 1px solid;"><?php echo $details['documento'] ?></span><br><br>
		Nombre/Razón Social: <span style="border-bottom: 1px solid;"> <?php echo $details['name'].' '.$details['dosnombre'].' '.$details['unoapellido'].' '.$details['dosapellido'] ?></span><br><br>
		  Identificación: <span style="border-bottom: 1px solid;"><?php echo $details['tipo_documento'].' '.$details['documento'] ?></span><br><br>
		Correo electrónico: <span style="border-bottom: 1px solid;"><?php echo $details['email'] ?></span><br><br>
		Teléfono de contacto: <span style="border-bottom: 1px solid;"><?php echo $details['celular'] ?></span><br><br>
		Dirección de servicio: <span style="border-bottom: 1px solid;"><?php echo $details['barrio'] ?></span> Estrato: <span style="border-bottom: 1px solid;"><?php echo $details['estrato'] ?></span><br><br>
		Departamento: <span style="border-bottom: 1px solid;"><?php echo $details['departamento'] ?></span> Municipio: <span style="border-bottom: 1px solid;"><?php echo $details['ciudad'] ?></span><br><br>
		Dirección suscriptor: <span style="border-bottom: 1px solid;"><?php echo $details['nomenclatura'].' '.$details['numero1'].$details['adicionauno'].' # '.$details['numero2'].$details['adicional2'].' - '.$details['numero3'] ?></span>
		</td>
    </tr>
    <tr>
      <td style="border: 0,0,0,0"></td>
    </tr>
  </tbody>
</table>
	<h4>EQUIPO EN COMODATO:</h4> El equipo Router serial N <span style="border-bottom: 1px solid;"><?php echo $serial ?></span>, suministrado durante la instalacion del servicio es en calidad de COMODATO y debe ser devuelto a la terminacion del contrato en perfecto estado, excepto por daños técnicos propios del equipo o será cargado a su cuenta a un costo de <span style="border-bottom: 1px solid;"><?php echo amountFormat(245000)?></span>
		
		</td>
      
      <td colspan="2" style="text-align: justify">
		<h4>COMO COMUNICARSE CON NOSOTROS (MEDIOS DE ATENCIÓN)</h4>
		1. Nuestros medios de atención son: oficinas físicas, página web, redes sociales y líneas
		telefónicas gratuitas.<br>
		2. Presente cualquier queja, petición/reclamo o recurso a través de estos medios y le
		responderemos en máximo 15 días hábiles.<br>
		3. Si no respondemos es porque aceptamos su petición o reclamo. Esto se llama silencio
		administrativo positivo y aplica para internet.<br>
		<h6>Si no está de acuerdo con nuestra respuesta</h6>
		4. Cuando su queja o petición sea por los servicios de internet, y esté relacionada
		con actos de negativa del contrato, suspensión del servicio, terminación del contrato, corte y
		facturación; usted puede insistir en su solicitud ante nosotros, dentro de los 10 días hábiles
		siguientes a la respuesta, y pedir que si no llegamos a una solución satisfactoria para usted,
		enviemos su reclamo directamente a la SIC (Superintendencia de Industria y Comercio) quien
		resolverá de manera definitiva su solicitud. Esto se llama recurso de reposición y en subsidio
		apelación.
		Cuando su queja o petición sea por el servicio de televisión, puede enviar la misma a la
		Autoridad Nacional de Televisión, para que esta Entidad resuelva su solicitud.
		<h6>CAMBIO DE DOMICILIO</h6>
		Usted puede cambiar de domicilio y continuar con el servicio siempre que sea técnicamente
		posible. Si desde el punto de vista técnico no es viable el traslado del servicio, usted puede
		ceder su contrato a un tercero o terminarlo pagando el valor de la cláusula de permanencia
		mínima si está vigente.
		<h6>COBRO POR RECONEXIÓN DEL SERVICIO</h6>
		En caso de suspensión del servicio por mora en el pago, podremos cobrarle un valor por
		reconexión que corresponderá estrictamente a los costos asociados a la operación de
		reconexión. En caso de servicios empaquetados procede máximo un cobro de reconexión por
		cada tipo de conexión empleado en la prestación de los servicios. Costo reconexión por servicio es de <span style="border-bottom: 1px solid;"><?php echo amountFormat(12000)?></span>
		</td>
      
    </tr>
    <tr>
      <td colspan="2" style="text-align: justify">
		<h4>ACEPTO CLAUSULA DE PERMANENCIA MÍNIMA</h4>
		En consideración a que le estamos otorgando un descuento respecto del valor del cargo por
		conexión, o le diferimos el pago del mismo, se incluye la presente cláusula de permanencia
		mínima. En la factura encontrará el valor a pagar si decide terminar el contrato
		anticipadamente.
		</td>
      
      <td colspan="2" style="background-color: black; color: white; font-size: x-large; text-align: justify">
		El usuario es el ÚNICO responsable por el contenido y la información
		que se curse a través de la red y del uso que se haga de los equipos o de
		los servicios.
		Los equipos de comunicaciones que ya no use son desechos que no
		deben ser botados a la caneca,
		</td>
      
    </tr>
    <tr>
      <td colspan="2"><table width="100%" border="1">
  <tbody>
    <tr>
      <td colspan="6" class="cla">
		<h4>COSTO INSTALACIÓN</h4>
		</td>
    </tr>
    <tr>
      <td colspan="4">VALOR TOTAL DEL CARGO POR CONEXIÓN</td>
      <td colspan="2"><?php echo amountFormat(306000)?></td>
    </tr>
    <tr>
      <td colspan="4">Suma que le fue diferida del valor total del cargo por conexión</td>
      <td colspan="2"><?php echo amountFormat(50000)?></td>
    </tr>
    <tr>
      <td colspan="4">Fecha inicio permanencia mínima</td>
      <td colspan="2"><?php echo date("d/m/Y",strtotime($fcontrato)) ?></td>
    </tr>
    <tr>
      <td colspan="4">Fecha de finalización de la permanencia mínima</td>
      <td colspan="2"><?php echo date("d/m/Y",strtotime($fcontrato."+ 1 year")) ?></td>
    </tr>
    <tr>
      <td colspan="6" style="text-align: center;font-weight: bold">Valor a pagar si termina el contrato anticipadamente según el mes</td>
    </tr>
    <tr>
      <td class="cla">Mes 1</td>
      <td class="cla">Mes 2</td>
      <td class="cla">Mes 3</td>
      <td class="cla">Mes 4</td>
      <td class="cla">Mes 5</td>
      <td class="cla">Mes 6</td>
    </tr>
    <tr>
      <td class="cla"><?php echo amountFormat(256000)?></td>
      <td class="cla"><?php echo amountFormat(234667)?></td>
      <td class="cla"><?php echo amountFormat(213334)?></td>
      <td class="cla"><?php echo amountFormat(192001)?></td>
      <td class="cla"><?php echo amountFormat(170668)?></td>
      <td class="cla"><?php echo amountFormat(149335)?></td>
    </tr>
    <tr>
      <td class="cla">Mes 7</td>
      <td class="cla">Mes 8</td>
      <td class="cla">Mes 9</td>
      <td class="cla">Mes 10</td>
      <td class="cla">Mes 11</td>
      <td class="cla">Mes 12</td>
    </tr>
	 <tr>
      <td class="cla"><?php echo amountFormat(128002)?></td>
      <td class="cla"><?php echo amountFormat(106669)?></td>
      <td class="cla"><?php echo amountFormat(85336)?></td>
      <td class="cla"><?php echo amountFormat(64003)?></td>
      <td class="cla"><?php echo amountFormat(42670)?></td>
      <td class="cla"><?php echo amountFormat(21337)?></td>
    </tr>
  </tbody>
</table>

</td>
      
      <td colspan="2" style="text-align: justify">
		<h6>PRECIO DEL SERVICIO Y FORMA DE PAGO:</h6> El suscriptor se obliga a pagar mensualidades
		por el valor contratado. El precio a pagar no incluye en suma alguna por el pago de los
		derechos de autor por ejecución pública. Por lo tanto VESTEL S.A.S. no será responsable por el
		pago de los derechos de autor que se causen por ejecución pública de obras protegidas. VESTEL
		S.A.S. podrá incrementar el valor del servicio en cualquier momento, caso en el que
		comunicará a EL SUSCRIPTOR el valor de dicho incremento previa a su aplicación y la fecha a
		partir de la cual se le aplicará el reajuste, Las tarifas de los planes de internet se incrementarán
		en un porcentaje máximo anual que no supere el 60% del valor tarifa al momento del reajuste
		tarifario, quedando a elección de VESTEL S.A.S. el índice de reajuste que utilizará y la
		periodicidad de la misma. Todo esto conforme con el registro de tarifas ante la Entidad
		competente si por ley o reglamento es necesario.
		<h6>CONDICIONES DEL SERVICIO:</h6> La oferta del servicio para internet es no caracterizada, por lo
		tanto, VESTEL S.A.S. se obliga a garantizar hasta la velocidad seleccionada en la portada del
		presente contrato, sin estar en obligación de mantenerla en oferta continua. Acepto y declaro
		conocer las condiciones contractuales que me han sido informadas con o sin cláusula de
		permanencia, las cuales puedo consultar en www.vestel.com.co la página web del
		concesionario.
		</td>
      
    </tr>
	<tr>
      <td colspan="2">
		<h4>PRINCIPALES OBLIGACIONES DEL USUARIO</h4>
		1) Pagar oportunamente los servicios prestados, incluyendo los intereses de mora cuando haya
		incumplimiento;<br>
		2) Suministrar información verdadera;<br>
		3) Hacer uso adecuado de los equipos y los servicios;<br>
		4) No divulgar ni acceder a pornografía;
		
		
		
		</td>
      
      <td colspan="2">
		  <table width="100%" border="1">
  <tbody>
    
    <tr>
      <td valign="bottom" align="center"><img height="130px" src="<?=base_url()?>assets/firmas_digitales/<?=$id?>.png"><img height="130px" src="<?=base_url()?>assets/huellas_digitales/Huella_CUS_<?=$id?>.png"></img><br>Aceptación contrato mediante firma o cualquier otro medio válido</td>
    </tr>
  </tbody>
</table>

		
		</td>
      
    </tr>
	<tr>
      <td colspan="2" style="text-align: justify">
		  <h4>CALIDAD Y COMPENSACIÓN</h4>
		Cuando se presente indisponibilidad del servicio o este se suspenda a pesar de su pago
		oportuno, lo compensaremos en su próxima factura. Debemos cumplir con las condiciones de
		calidad definidas por la CRC. Consúltelas en la página: www.operador.com/indicadores de
		calidad
		  <h4>CESIÓN</h4>
		Si quiere ceder este contrato a otra persona, debe presentar una solicitud por escrito a través
		de nuestros Medios de Atención, acompañada de la aceptación por escrito de la persona a la
		que se hará la cesión. Dentro de los 15 días hábiles siguientes, analizaremos su solicitud y le
		daremos una respuesta. Si se acepta la cesión queda liberado de cualquier responsabilidad con
		nosotros.
		<h4>MODIFICACIÓN</h4>
		Nosotros no podemos modificar el contrato sin su autorización. Esto incluye que no podemos
		cobrarle servicios que no haya aceptado expresamente. Si esto ocurre tiene derecho a terminar
		el contrato, incluso estando vigente la cláusula de permanencia mínima, sin la obligación de
		pagar suma alguna por este concepto. No obstante, usted puede en cualquier momento
		modificar los servicios contratados. Dicha modificación se hará efectiva en el período de
		facturación siguiente, para lo cual deberá presentar la solicitud de modificación por lo menos
		con 3 días hábiles de anterioridad al corte de facturación.
		<h4>SUSPENSIÓN</h4>
		Usted tiene derecho a solicitar la suspensión del servicio por un máximo de 2 meses al año.
		Para esto debe presentar la solicitud antes del inicio del ciclo de facturación que desea
		suspender. Si existe una cláusula de permanencia mínima, su vigencia se prorrogará por el
		tiempo que dure la suspensión.
		<h6>ANEXO AL CONTRATO DE SUSCRIPCIÓN A LOS SERVICIOS DE INTERNET DE VESTEL S.A.S.</h6>
		<h6>AUTORIZACIÓN REPORTE CENTRALES DE RIESGOS:</h6> Declaro bajo juramento que la información
		que he suministrado es verídica y con consentimiento expreso e irrevocable a VESTEL S.A.S. o
		quien sea en el futuro el acreedor del crédito solicitado, para: a) Consultar o confirmar en
		cualquier tiempo, en las centrales de riesgo, entidades financieras, autoridades competentes, y
		con particulares toda la información relevante para conocer mi desempeño como deudor,
		referencias, mi capacidad de pago o para valorar el riesgo futuro de concederme un
		crédito.______ b) Reportar a las centrales de información de riesgos datos, tratados o sin
		tratar, tanto sobre el cumplimiento oportuno como sobre el incumplimiento, si lo hubiere, de
		mis obligaciones crediticias, o de mis deberes legales de contenido patrimonial, de tal forma
		que éstas presenten una información veraz, pertinente, completa actualizada y exacta de mi
		desempeño como deudor, después de haber cruzado y procesado diversos datos útiles para
		obtener una información significativa.____ c) Enviar la información mencionada a las centrales
		de riesgo de manera directa y también, por intermedio de la Superintendencia Financiera o las
		demás entidades públicas que ejercen funciones de vigilancia y control, con el fin de que éstas
		puedan tratarla, analizarla, clasificarla y luego suministrarla a dichas centrales. ____ d)
		Conservar, tanto en VESTEL S.A.S. como en las centrales de riesgo, con las debidas
		actualizaciones y durante el período necesario señalado en sus reglamentos la información
		indicada en los literales b) y e) de esta cláusula.___ e) Suministrar a las centrales de
		información de riesgo datos relativos a mis solicitudes de crédito así como otros atinentes a mis
		relaciones comerciales, financieras y en general socioeconómicas que yo haya entregado o que
		consten en registros públicos, bases de datos públicas o documentos públicos. _____ f)
		Reportar a las autoridades tributarias, aduaneras o judiciales la información que requieran para
		cumplir sus funciones de controlar y velar el acatamiento de mis deberes constitucionales y
		legales.
		<h6>AUTORIZACIÓN SOBRE TRATAMIENTO DE DATOS PERSONALES:</h6> Autorizo a VESTEL S.A.S. para
		recolectar, almacenar, depurar, usar, analizar, circular, actualizar, transferir intencionalmente y
		cruzar con información propia o de terceros, mis datos personales con la finalidad de: realizar,
		a través de cualquier medio incluyendo mensajería instantánea, en forma directa o a través de
		terceros, actividades de mercadeo, promoción y/o publicidad propia o de terceros, venta,
		facturación, gestión de cobranza, recaudo, programación, soporte técnico, inteligencia de
		mercados, mejoramiento del servicio, verificaciones y consultas, control, comportamiento,
		hábito y habilitación de medios de pago, prevención de fraude, así como cualquier otro
		relacionado con sus productos y servicios, actuales y futuros, para el cumplimiento de las
		obligaciones contractuales y de su objeto social; generar una comunicación óptima en relación
		con sus servicios, productos, promociones, programación, estrenos, destacados, facturación y
		demás actividades; evaluar la calidad de sus productos y servicios y realizar estudios sobre
		hábitos de consumo, preferencia, interés de compra, prueba de producto, concepto,
		evaluación del servicio, satisfacción y otras relacionadas con sus servicios y productos; prestar
		asistencia, servicio y soporte técnico de sus productos y servicios; realizar las gestiones
		necesarias para dar cumplimiento a las obligaciones inherentes a los servicios y productos
		contratados con VESTEL S.A.S.; cumplir con las obligaciones contraídas con sus clientes,
		suscriptores, usuarios, proveedores, aliados, sus filiales, distribuidores, subcontratistas,
		autsourcing y demás terceros públicos y/o privados, relacionados directa o indirectamente con
		el objeto social de VESTEL S.A.S.; informar sobre cambios de productos y servicios relacionados
		con el giro ordinario de los negocios de VESTEL S.A.S., controlar y prevenir el fraude en todas
		sus modalidades; facilitar la correcta ejecución de las compras y prestaciones de los servicios y
		productos contratados. En todo caso el tratamiento de mis datos personales debe estar sujeto
		a la protección establecidas en la Ley 1581 de 2012, sus decretos reglamentarios y las normas
		que los modifiquen así como a la Política de Datos Personales establecida en el Manual interno
		de tratamiento de datos personales de VESTEL S.A.S., que se encuentra disponible en
		www.vestel.com.co enlace donde va a quedar disponible. En cualquier momento podré
		ejercer los derechos establecidos en estas normas y particularmente modificar y/o revocar la
		autorización prestada o solicitar la supresión parcial o definitiva de mis datos personales. Las
		solicitudes de supresión y/o revocación de la autorización de datos personales no proceden
		cuando EL SUSCRIPTOR tenga un deber legal o contractual de permanecer en las bases de datos
		de VESTEL S.A.S. de conformidad con lo establecido en las normas aplicables.
		<h6>ADMINISTRACIÓN DE RIESGO DE LAVADO DE ACTIVOS Y FINANCIACIÓN DEL TERRORISMO:</h6>
		EL SUSCRIPTOR declara de manera voluntaria y dando certeza de que lo aquí consignado es
		información veraz y verificable, lo siguiente: __ (i) que los recursos utilizados para la ejecución
		del siguiente contrato, al igual que sus ingresos, no provienen de ninguna actividad ilícita
		previstas en el Código Penal Colombiano, las normas que lo modifiquen o adicionen, ni serán
		utilizados para efectos de financiar actividades terroristas o cualquier otra conducta delictiva
		de acuerdo con las normas penales vigentes en Colombia. __ (ii) que el suscriptor, sus socios o
		administradores (Cuando aplique, no ha sido incluido en listas de control de riesgo de lavado
		de activos y financiación al terrorismo nacionales o internacionales vinculantes para Colombia y
		definidas por VESTEL S.A.S., de acuerdo con su sistema de Autocontrol y gestión de riesgo y
		lavado de activos y financiación del terrorismo SAGRLAFT, entre las que se encuentran la lista
		de la Oficina de Control de Activos en el exterior OFAC, emitida por el por la Oficina del Tesoro
		de los Estados Unidos de Norteamérica y la lista de sanciones del Consejo de Seguridad de la
		Organización de Naciones Unidas: __ (iii) que no incurre en sus actividades en ninguna
		actividad ilícita de las contempladas en el Código Penal Colombiano o en cualquier otra norma
		que lo modifique o adicione. EL SUSCRIPTOR se obliga con VESTEL S.A.S., a entregar
		información veraz y verificable y a actualizar su información institucional, comercial y financiera
		por lo menos una vez al año, o cada vez que así lo solicite la entidad, suministrando la totalidad
		de los soportes documentales exigidos. 
		
		</td>
      <td></td>
      <td colspan="2" style="text-align: justify">
		  El incumplimiento de esta obligación faculta a VESTEL
		S.A.S., para terminar de manera inmediata y unilateral cualquier tipo de relación que tenga con
		EL SUSCRIPTOR. EL SUSCRIPTOR autoriza a VESTEL S.A.S., a realizar consultas a través de
		cualquier medio, por sí mismo o a través de un proveedor, para efectuar las verificaciones
		necesarias para corroborar la información aquí consignada.
		  <h6>PROHIBICIONES Y DEBERES PARA PREVENIR EL ACCESO A MENORES DE EDAD A
		INFORMACIÓN PORNOGRÁFICA Y A IMPEDIR EL APROVECHAMIENTO DE REDES GLOBALES DE
		INFORMACIÓN CON FINES DE EXPLOTACIÓN SEXUAL INFANTIL U OFRECIMIENTO DE
		SERVICIOS COMERCIALES QUE IMPLIQUEN ABUSO SEXUAL CON MENORES DE EDAD:</h6>
		EL SUSCRIPTOR declara expresamente que conoce y acata las normas legales que señalan las
		prohibiciones y deberes para prevenir el acceso de menores de edad a cualquier modalidad de
		información pornográfica y a impedir el aprovechamiento de redes globales de información con
		fines de explotación sexual infantil u ofrecimiento de servicios comerciales que impliquen
		abuso sexual con menores de edad particularmente las señaladas en la Ley 679 de Agosto 3 de
		2001, Ley 1336 de 2009, Decreto 1524 de 2002, Código Penal y demás normas que los
		modifiquen, sustituyan o adicionen. La inobservancia de estas diposiciones acarreará las
		sanciones administrativas y penales contempladas en la Ley 679 de 2001 y en el Decreto 1524
		de 2002, EL SUSCRIPTOR se compromete a cumplir con las siguientes obligaciones contenidas
		en el Artículo 4 y Artículo 5 del citado Decreto: Artículo 4º. Prohibiciones. Los proveedores o
		servidores, administradores y usuarios de redes globales de información no podrán: __ 1.
		Alojar en su propio sitio imágenes, textos, documentos o archivos audiovisuales que impliquen
		directa o indirectamente actividades sexuales con menores de edad. __ 2. Alojar en su propio
		sitio material pornográfico, en especial en modo de imágenes o videos, cuando existan indicios
		de que las personas fotografiadas o filmadas son menores de edad. __ 3. Alojar en su propio
		sitio vínculos o "links", sobre sitios telemáticos que contengan o distribuyan material
		pornográfico relativo a menores de edad. Artículo 5º. Deberes. Sin perjuicio de las obligaciones
		de denuncia consagrada en la ley para todos los residentes en Colombia, los proveedores,
		administradores y usuarios de redes globales de información deberán: __ 1. Denunciar ante las
		autoridades competentes cualquier acto criminal contra menores de edad que tengan
		conocimiento, incluso de la difusión de material pornográfico asociado a menores. __
		2. Combatir con todos los medios técnicos a su alcance la difusión de material pornográfico con
		menores de edad. ___ 3. Abstenerse de usar las redes globales de información para divulgación
		de material ilegal con menores de edad. __ 4. Establecer mecanismos técnicos de bloqueo por
		medio de los cuales los usuarios se puedan proteger a sí mismos o a sus hijos de material ilegal,
		ofensivo o indeseable en relación con menores de edad. DUBER BORRAR
		</td>
      
    </tr>
  </tbody>
</table>

    
	</div>
    
</body>
</html>