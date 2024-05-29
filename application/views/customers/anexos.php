<!doctype html>
<?php
	if ($servicios['television']!=="no"){
		$producto = $this->db->get_where('products',array('pid'=>27))->row();
		$totaltv = $producto->product_price+3992;
	
	}if ($servicios['combo']!=="no"){

						$x1 = $this->db->get_where('products',array('product_name'=>$servicios['combo']))->row();
						$x1=$servicios['combo'];
						//$x1=str_replace(" ","", $x1);

						$producto2 = $this->db->query("SELECT * FROM products where product_name='".$x1."'")->result_array(); 
						$precio=$producto2[0]['product_price'];
						$iva=($producto2[0]['product_price']*$producto2[0]['taxrate'])/100;
						$inter =$precio+$iva ;
	}
	$equipo = $this->db->get_where('equipos',array('asignado'=>$details['id']))->row();
	$serial = $equipo->serial;
	$fcontrato = $details['f_contrato'];
?>
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

        .party tr td:nth-child(3) {
            text-align: center;
        }

		.centeral {
            text-align: center;
        }

        .invoice-box table tr.top table td {
            padding-bottom: 20pt;

        }
		.prestacion th{
			background-color:lightgray;
			font-weight: bold;
			padding: 1;
		}
		.prestacion td{
			padding: 1px;
		}
         /* Estilos para el contenedor del checkbox */
        .cheque {
			border: 2px solid #000;
			padding: 20px;
			width: 600px;
			background-color: #fff;
		}
    </style>
</head>

<body <?php if(LTR=='rtl') echo'dir="rtl"';
	  $fecha=date('d/m/Y')
	  ?>>

<div class="invoice-box">
    <table border="1">
        <tr>
            <td class="centeral" rowspan="6">
                <h4>SISTEMA INTEGRADO DE GESTION</h4>
				<h4>FUTURE SOLUTIONS DEVELOPMENT SAS</h4><br>
				<h5>ANEXO N. 1 AL CONTRATO UNICO DE SERVICIOS FIJOS Y ACUERDOS DE NIVEL DE
				PRESTACION DE SERVICIO PARA EL ACCESO A INTERNET</h5>
            </td>
			<tr>
				   <td style="padding: 1"> <img src="<?php echo FCPATH . 'userfiles/company/' . $this->config->item('logo') ?>" style="max-width:80px;"></td>
			</tr>
			<tr>
            	<td style="padding: 1;font-size: 11px">CÓDIGO: FSD-FRM-OPS-004</td>
			</tr>
			<tr>
            	<td style="padding: 1;font-size: 11px">VERSIÓN: 006</td>
			</tr>
			<tr>
            	<td style="padding: 1;font-size: 11px">FECHA: 04/04/2022</td>
			</tr>
			<tr>
            	<td style="padding: 1;font-size: 11px">PÁGINA: 1 DE 4</td>
			</tr>
        </tr>
		<tr style="border: 0">
			<td style="border: 0"></td>
			<td style="border: 0">Contrato N: <?php echo $details['abonado'] ?></td>
		</tr>
    </table>

    <table>
        <tbody>
		<tr>
			<td style="line-height: inherit;"> <h6>Para los efectos del presente Anexo FSD S.A.S. hace referencia única y exclusivamente a la empresa Future Solutions</h6>
			<h6>Development S.A.S.</h6></td>
					</tr>
					<tr>
						<td style="font-size: 7px;line-height: inherit;text-align: justify" >

			<h4>1. OBLIGACIONES DEL PROVEEDOR</h4>
			a.	Realizar entrega del servicio en el concentrador principal, con equipos de propiedad FSD S.A.S. los cuales son instalados en calidad de comodato durante el periodo en el cual se ofrezca la duración del servicio. Se aclara que el concentrador principal se reﬁere al switch de comunicaciones, router inalámbrico o equipo de cómputo dependiendo el caso. Los equipos entregados en comodato serán retirados en el momento en que se ﬁniquite la prestación del servicio.<br>
			b.	Garantizar por un período de un (1) año contado a partir de la instalación, el buen funcionamiento de los EQUIPOS, entregados para la prestación del SERVICIO, siempre que el problema diagnosticado se deba a vicios o defectos originados en los mismos. En estos casos, FSD S.A.S. procederá a reemplazarlos sin costo alguno para el Usuario.  Se exceptúan de esta obligación los daños derivados de variaciones de energía o descargas atmosféricas o mal uso de los EQUIPOS en cuyo caso el costo será asumido por el Usuario.<br>
			c.	En el evento que FSD S.A.S. suministre el router inalámbrico, la garantía del mismo por defectos de fabricación es de 1 año (no incluye variaciones bruscas de voltajes) y el soporte técnico sobre la conﬁguración del router es de 90 días. Posterior a este tiempo, cualquier soporte técnico que se efectúe en sitio y no corresponda a fallas en el servicio de acceso a Internet será facturado por separado.<br>
			d.	Tratándose de fallas en el SERVICIO no imputables al Usuario, FSD S.A.S. se encargará de realizar las actividades correctivas del caso. Cuando se presenten fallas en la prestación del SERVICIO por causas imputables al Usuario, FSD S.A.S. prestará el SOPORTE TELEFÓNICO y, de ser necesario, enviará personal para la revisión respectiva; si del resultado de la visita se concluye que la falla es atribuible al Usuario o a terceros, bien sea por conexiones inadecuadas, mal uso o desconﬁguración de los EQUIPOS, o cualquier otra que sea de su responsabilidad, el Usuario autoriza expresamente a través del presente documento a pagar el valor correspondiente al soporte técnico realizado en el momento de realizar la prestación del servicio.<br>
			e.	El SERVICIO será prestado por la Empresa durante las veinticuatro (24) horas del día, los siete (7) días de la semana y con la calidad establecida en las disposiciones legales vigentes. Esto no implica que no existirán interrupciones o suspensiones por razones de fuerza mayor, caso fortuito o mantenimiento correctivo o preventivo. Los reembolsos o descuentos que se presenten por falla en la prestación del SERVICIO y que sean imputables a FSD S.A.S., serán efectuados de conformidad con la ley y la regulación vigente. Disponibilidad de los servicios residenciales 95%, disponibilidad de los servicios corporativos 96%, disponibilidad de canales dedicados 99.6%<br>
			f.	FSD S.A.S. no responderá ni reconocerá descuentos por el mal funcionamiento del SERVICIO, especialmente en los siguientes eventos: (i) si el Usuario no cumple con los requisitos mínimos necesarios en su EQUIPO INFORMÁTICO para este SERVICIO; (ii) si el Usuario introduce algunos elementos de hardware o software a su EQUIPO INFORMÁTICO; (iii) si el número de EQUIPOS INFORMÁTICOS conectados al SERVICIO objeto de las presentes condiciones excede la recomendación dada por FSD S.A.S.; (v) si el Usuario, previa visita, maniﬁesta su imposibilidad de cumplir y pide el aplazamiento de la misma; (vi) en los casos en que trabajadores de FSD<br>
			b.	S.A.S. o quien ésta designe deban realizar una visita al domicilio del Usuario y éste no permita el ingreso de los trabajadores de FSD S.A.S. para la ejecución de las actividades necesarias tendiente a superar el problema; (viii) cuando el SERVICIO sea interrumpido o suspendido por razones propias del Usuario de equipamiento, trabajos de ingeniería o cualquier trabajo de reparación o actividades similares necesarias a juicio de FSD S.A.S. para su correcto o mejor funcionamiento.<br>
			a.	Medir el consumo empleando instrumentos de tecnología apropiados, de acuerdo con las disposiciones legales y regulatorias vigentes.<br>
			b.	Facturar los servicios y demás conceptos, de acuerdo con la normatividad vigente.<br>
			c.	Entregar la factura en el plazo y por los medios señalados en la normatividad vigente. Se entregará factura de manera electrónica posterior a la radicación en la DIAN.<br>
			d.	Recibir, tramitar y responder oportunamente las peticiones, quejas y recursos – PQR- que presente el USUARIO.<br>
			e.	Informar al Usuario de cualquier modiﬁcación que introduzca en la prestación de los servicios de comunicaciones por cualquier medio escrito, electrónico o mediante llamada telefónica. Así mismo, mantener disponible tal información en los mecanismos de atención al usuario.<br>
			f.	Divulgar o hacer públicas a través de la página de Internet la información relativa a los servicios que presta, en los términos en que lo dispone la regulación vigente.<br>
			g.	Suministrar al Usuario en el momento de la celebración del contrato y durante su ejecución, información sobre los elementos físicos de la red que corresponden a la acometida externa para la prestación de los servicios.<br>
			h.	Las demás contenidas en este contrato y en las normas aplicables.<br>

			<h4>2. OTRAS OBLIGACIONES DEL USUARIO</h4>
			a.	Contar con los EQUIPOS INFORMÁTICOS con las siguientes características para la correcta prestación del SERVICIO: (i) una tarjeta interfaz (PCI) para redes Ethernet en cada equipo con conector RJ45; (ii) un Switch, Router o Concentrador, en los casos en los cuales se desee tener un servicio multiusuario.<br>
			b.	Utilizar el SERVICIO en el predio especiﬁcado en la solicitud del mismo, donde se instala el EQUIPO, sin perjuicio de la solicitud de traslado del SERVICIO que el Usuario pueda tramitar ante FSD S.A.S. con quince días de anticipación a la fecha de traslado deseada. Si como consecuencia de dicho traslado se genera algún costo, este será asumido por el Usuario, valor que será cancelado el día del traslado, de acuerdo con las tarifas vigentes para este trámite al momento de la solicitud del mismo, con el ﬁn de veriﬁcar si es posible llevarlo a cabo, desde el punto de vista técnico y realizar tal actividad.<br>
			c.	Permitir el acceso del personal de FSD S.A.S. o el que ésta designe, previa solicitud y una vez concertada la visita correspondiente, al lugar en donde se prestará el Servicio con el ﬁn de proceder a la instalación, reactivación, mantenimiento, desinstalación, retiro y cualquier otra actividad que a juicio de FSD S.A.S. resulte necesaria para la prestación del SERVICIO.<br>
			d.	Suministrar a FSD S.A.S. información precisa y completa a ﬁn de mantener actualizados sus datos. Asimismo, deberá notiﬁcar a FSD S.A.S. dentro de los treinta (30) días calendarios siguientes sobre cualquier cambio de los mismos.
			e.	Cumplir con todos los compromisos contractuales, en especial, pagar los servicios, los valores asociados a los mismos y todos aquellos autorizados por EL USUARIO, dentro del plazo ﬁjado en la factura como fecha máxima de pago.<br>
			f.	Restituir a FSD S.A.S. los equipos de comunicaciones y con todos sus accesorios entregados en tenencia una vez llegada la ﬁnalización de la prestación del SERVICIO por el cumplimiento del plazo pactado, o la terminación del CONTRATO por voluntad de cualquiera de las partes, por incumplimiento de una de ellas o por cualquiera otra razón<br>
			g.	Informar por escrito a FSD S.A.S. su intención de ceder el CONTRATO, indicando el nombre completo y número de celular del cesionario, previo a esto, el Usuario se deberá encontrar al día de todas las obligaciones económicas generadas por el contrato actual de prestación de servicios.<br>
			h.	Abstenerse de: (i) utilizar el SERVICIO para ejecutar prácticas ilegales, o para generar SPAM o VIRUS INFORMÁTICOS o cualquier otra actividad que pueda causar perjuicios tanto a FSD S.A.S. como a terceros; (ii) distribuir y/o transmitir discursos indecentes o materiales obscenos; (iii) acceder ilegalmente o de manera no autorizada a otras computadoras o redes [HACKING]; (iv) publicar, difundir, promover, transmitir imágenes, señales o textos, que contradigan lo dispuesto en la Ley 679 de 2001 y su decreto reglamentario 1524 de 2002 por medio de los cuales se expidió el estatuto para prevenir y contrarrestar la explotación, la pornografía y el turismo sexual con menores en desarrollo del Artículo 44 de la Constitución Política de Colombia, igualmente cualquier norma que la modiﬁque, aclare, derogue o la adicione. En cualquiera de los eventos anteriores FSD S.A.S. podrá dar por terminado el CONTRATO unilateralmente y sin que medie declaración judicial. El Usuario es el único responsable de los perjuicios o daños que cause por el incumplimiento de sus obligaciones.<br>
			i.	Cumplir con las instrucciones que le imparta FSD S.A.S. para el uso de los servicios y de los equipos que se entreguen para la adecuada prestación de los mismos.<br>
			j.	Responder por cualquier anomalía o adulteración que se encuentre en las acometidas, así como por las conexiones no autorizadas, variaciones o modiﬁcaciones que sin autorización de FSD S.A.S. se hagan en relación con las condiciones de los servicios contratados.<br>
			k.	Informar de inmediato a FSD S.A.S. sobre cualquier irregularidad o daños que se presente en las instalaciones internas, en los servicios o cualquier otra novedad que afecten la normal prestación de los servicios.<br>
			l.	Dar aviso a FSD S.A.S. en caso de no recibir oportunamente la factura, solicitar información sobre el valor a pagar o un duplicado de la factura. El hecho de no recibir la factura por causas no imputables a FSD S.A.S., no exonera a EL Usuario de su pago.<br>
			m.	Informar a FSD S.A.S. dentro de los quince (15) días hábiles siguientes cualquier cambio de uso o destinación de los servicios. En cuanto sea procedente, FSD S.A.S. aplicará inmediatamente las tarifas correspondientes al nuevo uso.
			n.	Permitir a FSD S.A.S. la revisión de las instalaciones internas para la correcta prestación del servicio y reconocerle y pagarle a EL PROVEEDOR el valor de los materiales, trabajos y visitas adicionales que FSD S.A.S. deba realizar para normalizar la prestación de los servicios o para su correcta utilización.<br>
			o.	Garantizar con un título valor el pago de las facturas a su cargo, cuando FSD S.A.S. lo requiera.<br>
			p.	Hacer uso adecuado y proteger los equipos que FSD S.A.S. le entregue en comodato para la prestación de los servicios. En caso de hurto de los equipos deberá informar a FSD S.A.S. la ocurrencia del hecho dentro de las 48 horas siguientes, así mismo, deberá denunciarlo ante las autoridades competentes.<br>
			q.	Cumplir con los procedimientos que diseñe FSD S.A.S. en materia de recolección de los equipos terminales, dispositivos y demás equipos necesarios para la prestación de los servicios de comunicaciones.<br>
			r.	Las demás contenidas en el presente contrato y en las disposiciones legales expedidas por las autoridades competentes.<br>

							
							
			<h4>3. DERECHOS DEL PROVEEDOR</h4>
			a.	FSD S.A.S. podrá exigir la suscripción de un título valor o la constitución de una garantía permitida por la ley, a ﬁn de garantizar el pago por los conceptos derivados del SERVICIO y demás rubros de que trata el presente documento, de acuerdo con el plan escogido por el Usuario.<br>
			b.	Facturar mes presente el Servicio de Acceso a Internet prestado y demás valores relacionados con el mismo. Lo anterior es buscar que la cartera sea mínima.<br>
			c.	Facturar y enviar al Usuario dentro de los primeros 20 días calendario de cada mes la factura correspondiente al mes en curso, cuyo su vencimiento será el día 03 del siguiente mes.<br>
			d.	En caso de no pago de la FACTURA por parte del Usuario dentro de la fecha límite indicada como plazo máximo para evitar la suspensión o en la que se haya acordado con el Usuario, el SERVICIO será interrumpido en forma inmediata. Una vez el Usuario cancele lo adeudado, se reactivará el servicio lo más pronto posible ya sea a las 9:00 am, 12:00 m, 3:00 pm o a las 6:00 p.m. Si el Usuario no cancela dicha FACTURA, FSD S.A.S. terminará unilateralmente el CONTRATO y procederá al corte del SERVICIO; como consecuencia, las conexiones serán retiradas. En este evento, si el Usuario desea volver a obtener el SERVICIO deberá tramitar una nueva solicitud, caso en el cual será estudiada por FSD S.A.S.<br>
			e.	El incumplimiento en el pago oportuno de las FACTURAS por parte del Usuario dará lugar al cobro de intereses moratorios de acuerdo con la tasa máxima permitida por la ley, al igual que de los costos por el cobro prejurídico y jurídico de tales obligaciones, en los términos del artículo 1629 del código civil. 3.6. Suspender el servicio el día 04 calendario del mes siguiente al facturado en el evento en que no se realice el pago o que el mismo no sea reportado oportunamente a la empresa.<br>
			f.	FSD S.A.S. no responderá por los contenidos o la información que el Usuario curse a través del SERVICIO, de manera que, por su pérdida o daño, no se generan obligaciones para FSD S.A.S. y no se le será imputable responsabilidad alguna frente a terceros por daños directos o indirectos, imprevisibles, eventuales o consecuenciales, por fallas en la prestación del SERVICIO. La responsabilidad de FSD S.A.S. se limita al valor del SERVICIO.<br>
			g.	FSD S.A.S. se reserva el derecho de controlar o veriﬁcar el uso que el Usuario haga del SERVICIO y de denunciar las actividades ilegales que detecte ante las autoridades correspondientes.<br>
			h.	Recibir el pago oportuno de las facturas generadas por los servicios prestados.<br>
			i.	Fijar las condiciones de prestación de los servicios, ciñéndose para ello a las disposiciones legales pertinentes, cuando sea el caso.<br>
			j.	Fijar y reajustar las tarifas de cada servicio de acuerdo con las condiciones del mercado, será actualizado anualmente con el incremento del IPC correspondiente, durante la vigencia de este contrato, para lo cual FSD S.A.S deberá notiﬁcar, mediante aviso escrito, con un mes de antelación al Usuario, la actualización que tenga lugar a partir de la mensualidad siguiente.<br>
			k.	Recibir trato digno y respetuoso del Usuario, en cumplimiento de los principios de buena fe y reciprocidad.<br>
			l.	Enviar información comercial sobre sus servicios, de acuerdo con las autorizaciones concedidas por el Usuario.<br>
			m.	Obtener del Usuario autorización para ingresar al inmueble en donde se encuentren instalados los servicios, con el ﬁn de efectuar mantenimiento, revisión, control, reparación y visitas adicionales a las requeridas para reparación de los servicios.<br>
			n.	Establecer acciones de control que pueden ir desde la suspensión preventiva de los servicios hasta la terminación de los mismos, en los eventos establecidos en el presente contrato, o en otros en que se compruebe mala utilización o utilización de los servicios para actividades fraudulentas o ilícitas.<br>
			o.	Las demás contenidas en el presente contrato y en las normas expedidas por las autoridades competentes.
            </td>

           
        </tr>
        </tbody>
    </table>
	<table border="1">
        <tr>
            <td class="centeral" rowspan="6">
                <h4>SISTEMA INTEGRADO DE GESTION</h4>
				<h4>FUTURE SOLUTIONS DEVELOPMENT SAS</h4><br>
				<h5>ANEXO N. 1 AL CONTRATO UNICO DE SERVICIOS FIJOS Y ACUERDOS DE NIVEL DE
				PRESTACION DE SERVICIO PARA EL ACCESO A INTERNET</h5>
            </td>
			<tr>
				   <td style="padding: 1"> <img src="<?php echo FCPATH . 'userfiles/company/' . $this->config->item('logo') ?>" style="max-width:80px;"></td>
			</tr>
			<tr>
            	<td style="padding: 1;font-size: 11px">CÓDIGO: FSD-FRM-OPS-004</td>
			</tr>
			<tr>
            	<td style="padding: 1;font-size: 11px">VERSIÓN: 006</td>
			</tr>
			<tr>
            	<td style="padding: 1;font-size: 11px">FECHA: 04/04/2022</td>
			</tr>
			<tr>
            	<td style="padding: 1;font-size: 11px">PÁGINA: 2 DE 4</td>
			</tr>
        </tr>
		<tr style="border: 0">
			<td style="border: 0"></td>
			<td style="border: 0">Contrato N: <?php echo $details['abonado'] ?></td>
		</tr>
    </table>

    <table>
        <tbody>
		
			<tr>
				<td style="font-size: 7px;line-height: inherit;text-align: justify" >		
			<h4>4. DERECHOS DEL USUARIO</h4>
			a.	Cancelar en cualquier momento el SERVICIO, previa comunicación sobre tal decisión por escrito a FSD S.A.S. Si el contrato aún cuenta con cláusula de permanencia, el USUARIO deberá cancelar el valor de la penalidad por terminación anticipada del contrato. FSD S.A.S. interrumpirá el SERVICIO al vencimiento del período de facturación en que se conozca la solicitud de terminación del CONTRATO.<br>
			b.	Presentar peticiones, quejas y recursos, en adelante PQR, ante FSD S.A.S.<br>
			c.	Solicitar cambio de plan cuando lo desee y asumir el precio y las condiciones del nuevo plan. FSD S.A.S. realizará el cambio siempre y cuando sea factible técnicamente, en un tiempo no superior a 15 días hábiles posteriores a la solicitud del Usuario.
			d.	Contratar el servicio de FSD S.A.S. por el tiempo que el usuario así lo determine.<br>
			e.	Acceder a mecanismos que le permitan veriﬁcar el cumplimiento de las condiciones de velocidad ofrecidas al momento de la celebración del CONTRATO. El concepto de velocidad es variable y depende de múltiples aspectos, que no son siempre directamente imputables al proveedor del SERVICIO, los cuales pueden ser ocasionados por: especiﬁcaciones del computador inferiores a las requeridas para la prestación del servicio, mala conﬁguración en el computador, virus, fallas en la red interna, entre otras. En el caso de que un Usuario perciba que la velocidad no cumple sus expectativas deberá usar los medios de comunicación usados por la empresa para informar la situación que presenta.<br> 
			f.	Ser notiﬁcado anualmente el incremento en los costos de la mensualidad del servicio contratado por parte del Usuario el cual estará regido por lo permitido legalmente.<br>
			g.	Recibir los servicios contratados de manera continua, sin interrupciones que superen los límites establecidos en la normatividad vigente.<br>
			h.	Solicitar y obtener información clara, veraz, suﬁciente y precisa, relacionada con el ofrecimiento y la prestación de los servicios, siempre y cuando no se trate de información caliﬁcada como secreta o reservada por FSD S.A.S., de acuerdo con la normatividad vigente.<br>
			i.	Recibir oportunamente la factura de los servicios en forma detallada en medio electrónico. Una vez emitida la factura electrónica la misma no puede ser modiﬁcada o anulada. En caso de requerir ajustes o descuentos por cualquier causa, los mismos se reﬂejarán en la facturación del mes siguiente.<br>
			j.	Solicitar el traslado de los servicios a una nueva dirección; caso en el cual FSD S.A.S. veriﬁcará si en el nuevo sitio hay cobertura. De existir cobertura, FSD S.A.S. procederá al retiro e instalación de los servicios. Dicha solicitud tendrá un costo establecido por la empresa.<br>
			k.	Los demás derechos contenidos en el presente documento y en las normas que regulan la protección de usuarios.<br>

			<h4>5. CAUSALES Y CONDICIONES PARA LA SUSPENSIÓN DE LOS SERVICIOS Y PROCEDIMIENTO A SEGUIR.</h4>
			La suspensión de los servicios se podrá efectuar en los siguientes eventos:<br>
			a.	Suspensión temporal por mutuo acuerdo: por un término máximo de dos (2) meses consecutivos una única vez durante la vigencia del contrato. Siempre y cuando al momento en que se vaya a efectuar la suspensión, el Usuario se encuentre al día con sus obligaciones. Durante la suspensión voluntaria no habrá lugar al cobro del cargo básico correspondiente; no obstante, deberá asumir el costo a que haya lugar por la reconexión. La reconexión se efectuará al vencimiento del término señalado por EL Usuario; al vencimiento de los dos (2) meses, cuando el solicitante haya guardado silencio sobre el término, o en cualquier momento a solicitud del Usuario.<br>
			b.	Suspensión unilateral: FSD S.A.S. podrá suspender los servicios, sin que se considere falla en la prestación del mismo, en los siguientes casos:<br>

			<table style="font-size: 8px;line-height: inherit;text-align: justify;">
				<tr>
					<td style="padding-top: 0"></td>
					<td style="padding: 0">* Para hacer reparaciones técnicas, mantenimientos periódicos y racionamientos por fuerza mayor, siempre que de ello se dé aviso con por lo menos tres (3) días de
					anticipación a la suspensión, si la misma va a ser mayor a treinta (30) minutos.</td>
				</tr>
				<tr>
					<td style="padding-top: 0"></td>
					<td style="padding: 0">* Por causas que surjan de disposiciones legales o administrativas de cualquier orden, que sean de obligatorio cumplimiento para FSD S.A.S.</td>
				</tr>
				<tr>
					<td style="padding-top: 0"></td>
					<td style="padding: 0">* Por orden ejecutoriada de autoridad competente.</td>
				</tr>
				<tr>
					<td style="padding-top: 0"></td>
					<td style="padding: 0">* Para adoptar medidas de seguridad, por posible uso indebido o indicios de fraude.</td>
				</tr>
				<tr>
					<td style="padding-top: 0"></td>
					<td style="padding: 0">* Por la falta de pago de una (1) factura, salvo que exista una PQR pendiente de decisión.</td>
				</tr>
				<tr>
					<td style="padding-top: 0"></td>
					<td style="padding: 0">* Por interferir el Usuario en la utilización, operación o mantenimiento de las líneas, redes y demás equipos necesarios para suministrar los servicios, sean de propiedad
					de FSD S.A.S.</td>
				</tr>
				<tr>
					<td style="padding-top: 0"></td>
					<td style="padding: 0">* Como resultado de acciones de control adelantadas por FSD S.A.S., dirigidas a verificar si el Usuario ha dado a los servicios, por acción u omisión, un uso distinto al
					declarado o convenido con FSD S.A.S.; en especial, si el Usuario ha incurrido en conductas que impliquen violación directa o indirecta del régimen legal vigente y en
					particular del régimen aplicable a las comunicaciones en Colombia.</td>
				</tr>
				<tr>
					<td style="padding-top: 0"></td>
					<td style="padding: 0">* Cuando se establezca que el pago de alguna factura de los servicios se realizó a través de mecanismos fraudulentos y/o como resultado de conducta tipificada por la
					Ley Penal.</td>
				</tr>
				<tr>
					<td style="padding-top: 0"></td>
					<td style="padding: 0">* Por impedir a los funcionarios autorizados por FSD S.A.S., debidamente identificados, la inspección de las instalaciones internas.</td>
				</tr>
				<tr>
					<td style="padding-top: 0"></td>
					<td style="padding: 0">* Por proporcionar, en forma ocasional o permanente, los servicios a otro inmueble distinto de aquél para el cual figuran contratados los servicios.</td>
				</tr>
				<tr>
					<td style="padding-top: 0"></td>
					<td style="padding: 0">* En general, por cualquier alteración inconsulta y unilateral por parte del Usuario, de las condiciones contractuales. FSD S.A.S. podrá retirar, tan pronto los servicios
					sean suspendidos, los equipos que haya entregado al Usuario, en arrendamiento o comodato, para la prestación de los servicios.</td>
				</tr>				
			</table>
			c.	Condiciones para restablecer los servicios.
			<table style="font-size: 8px;line-height: inherit;text-align: justify;">
				<tr>
					<td style="padding-top: 0"></td>
					<td style="padding: 0">* Si las causales de suspensión se debieron al Usuario, este deberá interrumpir las actividades no autorizadas o ilegales, y pagar las sumas adeudadas, incluidos los
					intereses moratorios y el valor de la tarifa de re-conexión o re-instalación, según sea el caso. FSD S.A.S. procederá al restablecimiento del servicio dentro de los tres (3)
					días hábiles siguientes a la fecha en que la causal de suspensión haya cesado y dejará constancia de la fecha en que efectúe la reconexión.</td>
				</tr>
				<tr>
					<td style="padding-top: 0"></td>
					<td style="padding: 0">* Si la suspensión de los servicios obedece a causas imputables a FSD S.A.S., no podrá cobrarse suma alguna por concepto de reconexión. Durante la suspensión por
					falta de pago, FSD S.A.S. podrá generar cobro por la disponibilidad de la infraestructura; el monto de este cobro será definido por FSD S.A.S.</td>
				</tr>	
			</table>
			<h4>6. CAUSALES Y CONDICIONES PARA LA TERMINACIÓN Y PROCEDIMIENTO A SEGUIR.</h4>
			a.	Causales: FSD S.A.S. podrá dar por terminado el presente contrato y procederá al corte deﬁnitivo de los servicios, por las siguientes causales:
			<table style="font-size: 8px;line-height: inherit;text-align: justify;">
				<tr>
					<td style="padding-top: 0"></td>
					<td style="padding: 0">* Mutuo acuerdo entre las partes.</td>
				</tr>
				<tr>
					<td style="padding-top: 0"></td>
					<td style="padding: 0">* Cuando los servicios se encuentren suspendidos por incumplimiento y EL Usuario, no obstante haberle concedido FSD S.A.S. un plazo para que cumpliera, no lo ha
					hecho.</td>
				</tr>
				<tr>
					<td style="padding-top: 0"></td>
					<td style="padding: 0">* Cuando agotado el debido proceso resulte probada en contra del Usuario alguna de las conductas que dieron lugar a la suspensión de los servicios, según lo
					establecido en la séptima viñeta de lo mencionado en el numeral 8.2. de la Suspensión Unilateral dentro de las “Causales y condiciones para la suspensión de los
					servicios y procedimiento a seguir”.</td>
				</tr>
				<tr>
					<td style="padding-top: 0"></td>
					<td style="padding: 0">* No pago de la factura de un (1) período de facturación.</td>
				</tr>
				<tr>
					<td style="padding-top: 0"></td>
					<td style="padding: 0">* Cuando el Usuario de los servicios sea incluido en los listados de la OFAC, ONU o de cualquier otra autoridad local, extranjera o internacional como sospechoso de
					actividades de lavado de activos y financiación del terrorismo.</td>
				</tr>
				<tr>
					<td style="padding-top: 0"></td>
					<td style="padding: 0">* Cuando se establezca que el pago de alguna factura de los servicios se realizó a través de mecanismos fraudulentos y/o como resultado de conducta tipificada por la
					ley penal.</td>
				</tr>
				<tr>
					<td style="padding-top: 0"></td>
					<td style="padding: 0">* Solicitud del Usuario en cualquier tiempo, informada a FSD S.A.S. siempre y cuando el USUARIO cancele la penalidad si el contrato tiene aún vigente la cláusula de
					permanencia.</td>
				</tr>
				<tr>
					<td style="padding-top: 0"></td>
					<td style="padding: 0">* Decisión unilateral del Usuario cuando se presente falla en la prestación de los servicios en los términos establecidos en las disposiciones legales y regulatorias.</td>
				</tr>
				<tr>
					<td style="padding-top: 0"></td>
					<td style="padding: 0">* Cuando por razones técnicas se haga imposible la instalación, prestación o continuación de los servicios por parte de FSD S.A.S. quien comunicará al usuario dicha
					situación.</td>
				</tr>
				<tr>
					<td style="padding-top: 0"></td>
					<td style="padding: 0">* Por orden de autoridad administrativa y judicial competente.</td>
				</tr>
				<tr>
					<td style="padding-top: 0"></td>
					<td style="padding: 0">* Por el incumplimiento de cualquiera de las obligaciones establecidas en este contrato o en las disposiciones legales que le sean aplicables.</td>
				</tr>
				<tr>
					<td style="padding-top: 0"></td>
					<td style="padding: 0">* Por el suministro de información falsa o adulterada.</td>
				</tr>
				<tr>
					<td style="padding-top: 0"></td>
					<td style="padding: 0">* Por razones de fuerza mayor, caso fortuito, hechos de terceros ajenos a FSD S.A.S.</td>
				</tr>
				<tr>
					<td style="padding-top: 0"></td>
					<td style="padding: 0">* Por utilizar métodos y equipos de comunicación no permitidos.</td>
				</tr>
				<tr>
					<td style="padding-top: 0"></td>
					<td style="padding: 0">* Por interferir u obstaculizar la operación y mantenimiento de las redes y demás equipos necesarios para suministrar el SERVICIO que sean de propiedad de FSD
					S.A.S. o de terceros.</td>
				</tr>
				<tr>
					<td style="padding-top: 0"></td>
					<td style="padding: 0">* Por impedir u obstaculizar las labores de inspección y/o mantenimiento que realicen los funcionarios autorizados de FSD S.A.S.</td>
				</tr>
				<tr>
					<td style="padding-top: 0"></td>
					<td style="padding: 0">* Por la comercialización de este SERVICIO bajo cualquier modalidad, salvo en el caso de Usuarios que cuenten con un contrato de reventa de Servicios con FSD S.A.S.</td>
				</tr>
				<tr>
					<td style="padding-top: 0"></td>
					<td style="padding: 0">b.	Condiciones:<br>
						* La decisión de dar por terminado el contrato será notificada al Usuario indicándole la causa, los efectos que ello conlleva y los recursos que proceden contra dicha
					decisión, si a ello hubiere lugar.</td>
				</tr>
				<tr>
					<td style="padding-top: 0"></td>
					<td style="padding: 0">* A la terminación se efectuará, sin perjuicio de que FSD S.A.S. inicie las acciones necesarias para obtener por la vía judicial el cobro de las obligaciones insolutas y los
					demás cargos a que allá lugar, así mismo la devolución de equipos entregados en comodato o arrendamiento, cuando aplique.
					<h4>7. PROCEDIMIENTO PARA LA PRESTACION DEL SERVICIO DE SOPORTE TECNICO</h4>
					FSD S.A.S. presta el servicio de soporte técnico relacionado con el acceso a internet al Usuario sin ningún costo cuando el inconveniente presentado sea responsabilidad de
					FSD S.A.S. En caso de falla en el servicio de acceso a Internet favor realice los siguientes pasos antes de comunicarse con el departamento de soporte:<br>
					Verificar que el inconveniente no es debido al tipo navegador, por lo tanto, cambie de navegador, ya sea con explorer, mozilla, chrome, opera, etc.<br>
					Desconecte por 1 minuto de la corriente eléctrica los dispositivos de comunicación instalados y vuelva a conectarlos verificando disponibilidad en el servicio.<br>
					Si ha realizado los pasos anteriormente relacionados y el servicio continúa presentando inconvenientes, por favor comuníquese con el servicio técnico en los números de
					contacto 6017943254 - 6019172166 - 321 289 39 78 - 3114916907 opción 1 solicitando soporte técnico.<br>
					Es importante que su reporte de fallo, queja, petición o sugerencia referente a la prestación del servicio, se haga de manera oportuna con el fin de dar solución a los
					inconvenientes presentados y conocer cuando un usuario no posee el servicio. El soporte técnico se prestará en los siguientes horarios: Soporte Telefónico: Lunes a Sábado de
					6:00 am a 9:00 pm y los domingos y festivos 9:00 am a 5:00 pm. Soporte técnico en sitio previa apertura de incidencia por soporte telefónico de Lunes a Sábado de 8:00 am a
					5:00 pm, para Usuarios residenciales o corporativos.
					</td>
				</tr>	
			</table>
            </td>
        </tr>
        </tbody>
    </table>
	<table border="1">
        <tr>
            <td class="centeral" rowspan="6">
                <h4>SISTEMA INTEGRADO DE GESTION</h4>
				<h4>FUTURE SOLUTIONS DEVELOPMENT SAS</h4><br>
				<h5>ANEXO N. 1 AL CONTRATO UNICO DE SERVICIOS FIJOS Y ACUERDOS DE NIVEL DE
				PRESTACION DE SERVICIO PARA EL ACCESO A INTERNET</h5>
            </td>
			<tr>
				   <td style="padding: 1"> <img src="<?php echo FCPATH . 'userfiles/company/' . $this->config->item('logo') ?>" style="max-width:80px;"></td>
			</tr>
			<tr>
            	<td style="padding: 1;font-size: 11px">CÓDIGO: FSD-FRM-OPS-004</td>
			</tr>
			<tr>
            	<td style="padding: 1;font-size: 11px">VERSIÓN: 006</td>
			</tr>
			<tr>
            	<td style="padding: 1;font-size: 11px">FECHA: 04/04/2022</td>
			</tr>
			<tr>
            	<td style="padding: 1;font-size: 11px">PÁGINA: 3 DE 4</td>
			</tr>
        </tr>
		<tr style="border: 0">
			<td style="border: 0"></td>
			<td style="border: 0">Contrato N: <?php echo $details['abonado'] ?></td>
		</tr>
    </table>

    <table >
        <tbody>
		
					<tr>
						<td style="font-size: 7px;line-height: inherit;text-align: justify" >
			<h4>8. SOPORTES TÉCNICOS QUE NO CORRESPONDAN A LA PRESTACIÓN DEL SERVICIO DE ACCESO A INTERNET</h4>
			Se relacionan los conceptos correspondientes a los servicios de soporte técnico que no corresponden a fallas en la prestación del servicio de acceso a Internet y que generan un costo adicional establecido de acuerdo a los costos de la prestación del servicio que se ocasionen por concepto de desplazamiento y disponibilidad del personal designado:<br>
			a.	Falla causada por el Usuario (Intercambio de cables, POE desconectado, tarjeta inalámbrica apagada, etc.).<br>
			b.	Reconﬁguración de router o Recuperación de contraseña.<br>
			c.	Modiﬁcación de la conﬁguración de red del equipo de cómputo.  <br>
			d.	Traslado de la instalación por cambio de vivienda.<br>  
			e.	Traslado de la instalación dentro la vivienda<br>
			f.	Daños causados a los equipos de comunicaciones por manipulación del Usuario o por inconvenientes eléctricos cuando el equipo no se encuentre conectado a estabilizador o la vivienda no posea polo a tierra con valor variable según el equipo afectado.<br>
			g.	Reconexión del servicio luego de suspensión voluntaria máximo por 2 meses.<br>

			<h4>9. POLÍTICA DE USO ACEPTABLE</h4>
			FSD S.A.S. en su calidad de operador de servicios de valor agregado se permite adicionar la política de uso aceptable en adelante PUA, a las condiciones bajo las cuales FSD S.A.S. presta dichos servicios, en el sentido de incluir como prohibiciones las que se señalan a continuación. Esta PUA pretende proteger a FSD S.A.S. y a sus Usuarios de ataques a sus sistemas, equipos y redes, así como coordinar y mantener los protocolos y lineamientos aceptados internacionalmente para el uso correcto y apropiado de Internet. FSD S.A.S. se reserva el derecho de modiﬁcar la presente política en cualquier momento, la cual será efectiva una vez que dicha modiﬁcación sea comunicada en la página web oﬁcial de la empresa www.ottis.com.co y es responsabilidad del Usuario consultarla de manera periódica.<br>
			<h4>a. Propósito:</h4>
			Esta política es enunciativa ya que no abarca todos los aspectos en los cuales se pueda incurrir. En este orden de ideas, toda actividad que viole la ley, las regulaciones o las normas aceptadas de la comunidad de Internet, o que perjudique el desempeño de la red, la imagen o las relaciones con los Usuarios de FSD S.A.S., así no se mencionen o se incluyan dentro de este documento, se entenderán comprendidas en éste, dado que su ﬁn es preservar la integridad y disponibilidad de Internet y de sus usuarios. La PUA está ligada a las Condiciones de Prestación del Servicio de Internet y otras políticas de FSD S.A.S.
			<h4>b. Alcance:</h4>
			La PUA está dirigida a Usuarios de FSD S.A.S., personas naturales o jurídicas, que contratan servicios para conectarse a Internet o la red de datos que ofrece FSD S.A.S. Cualquier actividad prohibida que se lleve a cabo, en la cual participe un tercero en nombre de o en beneﬁcio de un Usuario de FSD S.A.S. o cualquier Usuario o usuario ﬁnal de un Usuario de FSD S.A.S., será considerada una actividad prohibida que se lleve a cabo por el Usuario de FSD S.A.S. Cualquier vulneración a la ley o a las condiciones previstas, se constituye en VIOLACIÓN de lo estipulado por el Usuario para la utilización de los servicios, que por su potencial repercusión requieren de la toma de medidas inmediatas, en consecuencia el Usuario acepta y reconoce que FSD S.A.S. está facultada para suspender o terminar la prestación del servicio sin necesidad de requerimiento previo; sin perjurio de lo anterior, FSD
			S.A.S. podrá en los casos en que lo considere pertinente, informar al Usuario sobre la realización de conductas prohibidas y solicitarle que se abstenga de realizarlas. En estos casos se contactará al Usuario por medio de las cuentas de correo electrónico inscritas con FSD S.A.S. y las conocidas por FSD S.A.S. o se contactará por vía telefónica, de ser ello posible. En este sentido el Usuario quedará con un veto durante seis (6) meses, el veto será permanente y se dará por terminado la prestación del servicio. Si la actividad prohibida persiste después de haber sido advertido por parte del personal de seguridad informática de FSD S.A.S., se terminará la prestación del servicio. Lo anterior sin perjuicio de las acciones judiciales y denuncias que FSD S.A.S. y terceros afectados puedan emprender contra el usuario, en Colombia o cualquier otra jurisdicción.

			<h4>c. Usos indebidos:</h4>
			De manera enunciativa se señalan algunos usos indebidos que no están autorizados ni permitidos y que su ejecución por parte del usuario origina la terminación o suspensión del servicio por parte de FSD S.A.S., con justa causa al constituirse como violación de las condiciones de uso de los servicios prestados por FSD S.A.S.:
			<table style="font-size: 8px;line-height: inherit;text-align: justify;">
				<tr>
					<td style="padding-top: 0"></td>
					<td style="padding: 0">* Influir injusta, ilegal o en forma indebida o inadecuada directa o indirectamente en los sistemas, redes, aplicativos, y demás elementos involucrados en la transmisión o
					recepción de información, incluyendo los terminales de los usuarios.</td>
				</tr>
				<tr>
					<td style="padding-top: 0"></td>
					<td style="padding: 0">* Violar o intentar violar sistemas de seguridad o red de FSD S.A.S. o de cualquier tercero.</td>
				</tr>
				<tr>
					<td style="padding-top: 0"></td>
					<td style="padding: 0">* Intentar acceder sin autorización a los sitios o servicios de FSD S.A.S. o de otro operador, mediante la utilización de herramientas intrusivas (hacking), descifre de
					contraseñas, descubrimiento vulnerabilidades o cualquier otro medio no permitido o legítimo.</td>
				</tr>
				<tr>
					<td style="padding-top: 0"></td>
					<td style="padding: 0">* Cargar archivos que contengan virus, caballos de Troya (“troyanos”), gusanos (“worms”), bombas de correo (“mail-bombing”), archivos dañados o cualquier otro programa
					o software similar que pueda perjudicar el funcionamiento de los equipos, de la red de FSD S.A.S. o de propiedad de terceros.</td>
				</tr>
				<tr>
					<td style="padding-top: 0"></td>
					<td style="padding: 0">* Obtener información de los usuarios de Internet para fines comerciales no autorizados previamente, mediante publicidad engañosa o artilugios de cualquier índole.</td>
				</tr>
				<tr>
					<td style="padding-top: 0"></td>
					<td style="padding: 0">* Daños causados a los equipos de comunicaciones por manipulación del Usuario o por inconvenientes eléctricos cuando el equipo no se encuentre conectado a
					estabilizador o la vivienda no posea polo a tierra con valor variable según el equipo afectado.</td>
				</tr>
				<tr>
					<td style="padding-top: 0"></td>
					<td style="padding: 0">* Presentar, alojar o trasmitir información, imágenes, textos que en forma indirecta o directa se encuentren con actividades sexuales con menores de edad, en los términos
					de la legislación colombiana, tales como la ley 679 de 2001 y el Decreto 1524 de 2002.</td>
				</tr>
				<tr>
					<td style="padding-top: 0"></td>
					<td style="padding: 0">* Anunciar, enviar, presentar o transmitir contenido de carácter ilegal, atentatorio a la dignidad del ser humano, que tenga la potencialidad de ser peligroso, genere pánico
					económico, social, de salubridad, etc.</td>
				</tr>
				<tr>
					<td style="padding-top: 0"></td>
					<td style="padding: 0">* Vulnerar derechos de propiedad industrial, derechos de autor, o copyright protegidos por las leyes nacionales, extranjeras y acuerdos o tratados internacionales sobre la
					materia.</td>
				</tr>
				<tr>
					<td style="padding-top: 0"></td>
					<td style="padding: 0">* Violar las comunicaciones y la intimidad de las personas.</td>
				</tr>
				<tr>
					<td style="padding-top: 0"></td>
					<td style="padding: 0">* Crear identidades falsas con el propósito de confundir a terceros.</td>
				</tr>
				<tr>
					<td style="padding-top: 0"></td>
					<td style="padding: 0">* Usar los sitios o servicios que puedan dañar, deshabilitar, sobrecargar o deteriorar algún sitio o servicio prestado por FSD S.A.S. o cualquier otro operador.</td>
				</tr>
				<tr>
					<td style="padding-top: 0"></td>
					<td style="padding: 0">* Enviar correo basura, Spam indiscriminado, o encadenado no autorizado o consentido previamente por los destinatarios.</td>
				</tr>
				<tr>
					<td style="padding-top: 0"></td>
					<td style="padding: 0">* Monitorear tráfico de cualquier red o sistema sin la debida autorización del usuario o administrador de la red,</td>
				</tr>
				<tr>
					<td style="padding-top: 0"></td>
					<td style="padding: 0">* Realizar ataques de denegación de servicio (Dos) que causen daño o inutilización de los servicios prestados por FSD S.A.S. u otros operadores.</td>
				</tr>	
			</table>
			<h4>d.	Control de contenidos:</h4>
			Al hacer uso del servicio Control de Contenidos, el Usuario declara que conoce y acepta las condiciones de uso del servicio de internet de FSD S.A.S., en especial las que le imponen la obligación de responsabilidad a su cargo sobre la utilización del servicio, recibo, envío, alojamiento, imágenes, textos que en forma indirecta o directa se encuentren relacionados con actividades delictivas, sexuales, plagio, sectas, correo spam, entre otras. La instalación y uso del servicio de Control de Contenidos es una herramienta gratuita que FSD S.A.S. coloca a disposición del Usuario que no exime a éste de las responsabilidades aludidas. El Usuario conoce y acepta que el servicio de control de contenidos no tiene una efectividad de uso del 100% y en consecuencia expresamente exonera a FSD S.A.S. por las fallas que el mismo presente y en general por las manipulaciones del programa que permitan su desactivación o efectividad total o parcial.
			<h4>e.	Correo Y Política Antispam.</h4>
			Es un deber de los usuarios de FSD S.A.S. utilizar el servicio de correo electrónico de manera adecuada y responsable. El Spamming es una actividad ilegal que no es permitida
			ni tolerada por FSD S.A.S. Para determinar si un Usuario de FSD S.A.S. está enviando correo SPAM, se apoyará en los reportes enviados por entidades internacionales o
			terceros, así como de los reportes generados por la herramienta antispam con la que cuenta FSD S.A.S. Los usuarios que tienen listas con direcciones de correo electrónico, las
			cuales han sido previamente inscritas y autorizadas por sus responsables para enviarles correos electrónicos, deberán informara los destinatarios el derecho que tienen a
			solicitar su retiro de la lista (opción “unsubscribe”) y deberán adoptar las medidas necesarias para evitar que sigan enviando este tipo de correos una vez el Usuario lo haya
			solicitado. La opción de retiro de la lista de correo, no exime al generador de su responsabilidad, ya que si el correo ha sido enviado a una dirección que no lo ha solicitado será
			catalogado como SPAMMER. Los Usuarios de FSD S.A.S. son los únicos responsables de los mensajes y del contenido que anuncian, distribuyen o de otro modo facilitan
			utilizando las conexiones y servicios que ofrece FSD S.A.S. Es responsabilidad del Usuario asegurar y configurar de forma adecuada los equipos y servicios que va a conectar a
			Internet. FSD S.A.S. no se responsabiliza por equipos del Usuario. En este orden de ideas, los Usuarios deben abstenerse de realizar, entre otras, las siguientes prácticas:
			<table style="font-size: 8px;line-height: inherit;text-align: justify;">
				<tr>
					<td style="padding-top: 0"></td>
					<td style="padding: 0">* Hacer Spamming de cualquier naturaleza que no haya sido autorizados por el(los) destinatario(s) o que pudieran originar cualquier clase de incomodidad o queja por parte del mismo.</td>
				</tr>
				<tr>
					<td style="padding-top: 0"></td>
					<td style="padding: 0">* Continuar enviando correo a destinatarios que le hayan solicitado que no desean continuar recibiendo esta clase de correos.</td>
				</tr>
				<tr>
					<td style="padding-top: 0"></td>
					<td style="padding: 0">* Utilizar cualquier servicio prestado por FSD S.A.S. para la composición, almacenamiento, distribución, colección o envío masivo de correo electrónico. Se incluye
											 cualquier forma de correo que no hayan sido solicitados, así como transmitir correos a terceras personas sin su consentimiento que fueran obscenos, molestos,
											 injuriosos, difamatorios, abusivos, amenazantes o que pongan en peligro la estabilidad de la red de FSD S.A.S. o de cualquier otra red.</td>
				</tr>
				<tr>
					<td style="padding-top: 0"></td>
					<td style="padding: 0">* Brindar la posibilidad de manera directa o indirecta la proliferación de correo spam, incluyendo las casillas de correo, software para realizar spam, hosting de sitios Web para realizar spam o que realicen spam.</td>
				</tr>
				<tr>
					<td style="padding-top: 0"></td>
					<td style="padding: 0">* Utilizar un servidor de correo para retransmitir correo sin el permiso expreso del sitio (Relaying). Entiéndase Relaying como la acción de utilizar un servidor como medio
											 de difusión de correo electrónico en el cual, el remitente o el destinatario no son usuarios de dicho servidor.
					<h4>f.	Alcances y responsabilidad legal en la prestación del servicio de internet.</h4>
				Es obligación de FSD S.A.S. como Proveedores del servicio de internet informar la existencia y los alcances de la Ley 679 de 2001 y su decreto reglamentario 1524 de 2002 por
				medio de los cuales se expidió el estatuto para prevenir y contrarrestar la explotación, la pornografía y el turismo sexual con menores en desarrollo del Artículo 44 de la
				Constitución Política de Colombia. Nos permitimos relacionar los artículos 7°, 8° y 10° de la Ley 679 de 2001 así como los Deberes y Prohibiciones del decreto 1524 de 2002.
				“ARTÍCULO 7o. PROHIBICIONES. Los proveedores o servidores, administradores y usuarios de redes globales de información no podrán:.
				En caso de que la política de facturación sea modificada la misma será publicada en la página web www.ottis.com.co.<br>
				1. Alojar en su propio sitio imágenes, textos, documentos o archivos audiovisuales que impliquen directa o indirectamente actividades sexuales con menores de edad.<br>
				2. Alojar en su propio sitio material pornográfico, en especial en modo de imágenes o videos, cuando existan indicios de que las personas fotografiadas o filmadas son menores de edad.<br>
				3. Alojar en su propio sitio vínculos o links, sobre sitios telemáticos que contengan o distribuyan material pornográfico relativo a menores de edad.
				ARTÍCULO 8o. DEBERES. Sin perjuicio de la obligación de denuncia consagrada en la ley para todos los residentes en Colombia, los proveedores, administradores y usuarios
				de redes globales de información deberán:<br>
				1. Denunciar ante las autoridades competentes cualquier acto criminal contra menores de edad de que tengan conocimiento, incluso de la difusión de material pornográfico asociado a menores.<br>
				2. Combatir con todos los medios técnicos a su alcance la difusión de material pornográfico con menores de edad.<br>
				3. Abstenerse de usar las redes globales de información para divulgación de material ilegal con menores de edad.<br>
				4. Establecer mecanismos técnicos de bloqueo por medio de los cuales los usuarios se puedan proteger a sí mismos o a sus hijos de material ilegal, ofensivo o indeseable en
				relación con menores de edad.<br>
				ARTÍCULO 10. SANCIONES ADMINISTRATIVAS. El Ministerio de Comunicaciones tomará medidas a partir de las denuncias formuladas, y sancionará a los proveedores o
				servidores, administradores y usuarios responsables que operen desde territorio colombiano, sucesivamente de la siguiente manera:<br>
				1. Multas hasta de 100 salarios mínimos legales vigentes.<br>
				2. Cancelación o suspensión de la correspondiente página electrónica.<br>
				Para la imposición de estas sanciones se aplicará el procedimiento establecido en el Código Contencioso Administrativo con observancia del debido proceso y criterios de
				adecuación, proporcionalidad y reincidencia”<br>
				IMPORTANTE:<br>
				FSD S.A.S. podrá monitorear los contenidos que circulen por la red y eliminar los que a su juicio se constituyan en usos prohibidos o ilegales, especialmente aquellos que
				tengan material pornográfico con menores de edad.
					</td>
				</tr>	
			</table>
						</td>
			
				</tr>	
			</table>
            </td>
        </tr>
        </tbody>
    </table>
	<table border="1">
        <tr>
            <td class="centeral" rowspan="6">
                <h4>SISTEMA INTEGRADO DE GESTION</h4>
				<h4>FUTURE SOLUTIONS DEVELOPMENT SAS</h4><br>
				<h5>ANEXO N. 1 AL CONTRATO UNICO DE SERVICIOS FIJOS Y ACUERDOS DE NIVEL DE
				PRESTACION DE SERVICIO PARA EL ACCESO A INTERNET</h5>
            </td>
			<tr>
				   <td style="padding: 1"> <img src="<?php echo FCPATH . 'userfiles/company/' . $this->config->item('logo') ?>" style="max-width:80px;"></td>
			</tr>
			<tr>
            	<td style="padding: 1;font-size: 11px">CÓDIGO: FSD-FRM-OPS-004</td>
			</tr>
			<tr>
            	<td style="padding: 1;font-size: 11px">VERSIÓN: 006</td>
			</tr>
			<tr>
            	<td style="padding: 1;font-size: 11px">FECHA: 04/04/2022</td>
			</tr>
			<tr>
            	<td style="padding: 1;font-size: 11px">PÁGINA: 4 DE 4</td>
			</tr>
        </tr>
		<tr style="border: 0">
			<td style="border: 0"></td>
			<td style="border: 0">Contrato N: <?php echo $details['abonado'] ?></td>
		</tr>
    </table>

    <table>
        <tbody>
		
					<tr>
					<td style="font-size: 7px;line-height: inherit;text-align: justify" >
			<h4>10. AUTORIZACIONES DEL USUARIO.</h4>
				a.	Recibir información a través de mensajes de datos o texto. Cuando se trate de correo electrónico la información deberá ser entregada a la dirección registrada en el presente documento. Además, autoriza expresamente a FSD S.A.S. con la ﬁrma del presente documento a remitirle la FACTURA utilizando cualquier otro medio alternativo dispuesto por ésta, diferentes de la remisión física, en los términos autorizados por la regulación vigente. Igualmente, autoriza a efectuar el cobro y se compromete a hacer el pago por dichos medios alternativos, de acuerdo con las condiciones que para tal efecto señale la Empresa.<br>
				b.	Autorizo que cualquier notiﬁcación dentro de los trámites de PQRs se realicen a través de mecanismos alternos ya sea, mensajería expresa, en línea: a través de internet o a través de correo electrónico. El mecanismo alterno de notiﬁcación de servicio de mensajería expresa deberá realizarse conforme lo establece el numeral 2.3 del artículo 3 de la ley 1369 de 2009 y la resolución 3095 de 2011 de la CRC, la Resolución de la CRC 3066 de 2011 y demás normas vigentes.<br>
				c.	El Usuario autoriza a FSD S.A.S. de no garantizar la prestación del SERVICIO, cuando se presenten las siguientes situaciones técnicas, las cuales son ajenas a FSD S.A.S.: (i) Cuando por inﬂuencia de potencia y/o ruido generado por fuentes externas a FSD S.A.S. se degrade o impida la prestación del SERVICIO; (ii) cuando la relación entre la señal y el ruido, externo a FSD S.A.S., interﬁeran en la transmisión de datos; (iv) por daño de la red interna del Usuario; (v) cuando ocurran daños en el medio de transmisión en donde no es posible realizar reparaciones para establecer el SERVICIO. Cuando se presenten algunas de las circunstancias antes descritas, FSD S.A.S. realizará las gestiones técnicas pertinentes para tratar de establecer el SERVICIO a las condiciones inicialmente ofrecidas. En caso de no ser posible la reparación, el Usuario autoriza a FSD S.A.S. para dar por terminado sin necesidad de declaración judicial, el presente CONTRATO, sin lugar a pago o reconocimiento de indemnización alguna.<br>
				d.	El Usuario autoriza a FSD S.A.S. a no responder por los daños o perjuicios que pueda ocasionarle al Usuario, por la falta de continuidad o interrupción del SERVICIO; si el Usuario insistiere que se le suministre el SERVICIO a pesar de los inconvenientes técnicos o de los mayores costos que por virtud de los mismos se generen, éste autorizará con la ﬁrma del presente documento a FSD S.A.S. para que cobre los mayores valores que se causen para poder prestarle el SERVICIO en tales condiciones. El Usuario conoce y acepta que por tales razones la Empresa no puede garantizar el suministro y calidad del SERVICIO.<br>
				e.	Autorización para el tratamiento de datos personales: De conformidad con lo dispuesto en la Ley Estatutaria 1581 de 2012, el Decreto 1377 de 2013 o las normas que la modifiquen, los datos personales que se obtengan por parte del Titular de la Información a través de los vínculos contractuales celebrados entre Future Solutions Development S.A.S. y el Titular de la Información, serán compilados, almacenados, consultados, usados, compartidos, intercambiados, transmitidos, transferidos y objeto de tratamiento en bases de datos, las cuales estarán destinadas a las siguientes finalidades:<br>

				<table style="font-size: 8px;line-height: inherit;text-align: justify;">
					<tr>
						<td style="padding-top: 0"></td>
						<td style="padding: 0">⚫ Mantener una eficiente comunicación de la información relacionada con nuestros sistemas de gestión implementados,
												   trámites administrativos y misionales, y actividades relacionadas con el objeto social propio de Future Solutions
												   Development S.A.S.</td>
					</tr>
					<tr>
						<td style="padding-top: 0"></td>
						<td style="padding: 0">⚫ Adelantar estudios y análisis estadísticos.</td>
					</tr>
					<tr>
						<td style="padding-top: 0"></td>
						<td style="padding: 0">⚫ Elaborar y presentar informes financieros a entidades de control.</td>
					</tr>
					<tr>
						<td style="padding-top: 0"></td>
						<td style="padding: 0">⚫ Dar cumplimiento de las obligaciones contraídas por FSD S.A.S. con los Titulares de la Información, con relación a
												 temas contractuales.</td>
					</tr>
					<tr>
						<td style="padding-top: 0"></td>
						<td style="padding: 0">⚫ Caracterizar grupos de interés y adelantar estrategias de mejoramiento en la prestación del servicio.</td>
					</tr>
					<tr>
						<td style="padding-top: 0"></td>
						<td style="padding: 0">⚫ Dar respuesta a las peticiones, quejas, reclamos, denuncias, sugerencias y/o felicitaciones presentadas a la empresa.</td>
					</tr>
					<tr>
						<td style="padding-top: 0"></td>
						<td style="padding: 0">⚫ Alimentar los sistemas de información.</td>
					</tr>
					<tr>
						<td style="padding-top: 0"></td>
						<td style="padding: 0">⚫ Conocer y consultar la información del titular del dato que repose en bases de datos de entidades públicas y privadas.</td>
					</tr>
					<tr>
						<td style="padding-top: 0"></td>
						<td style="padding: 0">⚫ Adelantar encuestas de satisfacción por grupos de interés.</td>
					</tr>
					<tr>
						<td style="padding-top: 0"></td>
						<td style="padding: 0">⚫ Enviar información de interés general.</td>
					</tr>
					<tr>
						<td style="padding-top: 0"></td>
						<td style="padding: 0">⚫ Intercambiar la información personal con autoridades gubernamentales, fiscales, judiciales o administrativas y
												 organismos de control para cumplir con requerimientos que éstas soliciten.</td>
					</tr>	
				</table>
				<strong>Datos sensibles.</strong>
				El Titular de la Información o representante legal en el caso de información de hijos (as) de  menores de edad manifiesta que conoce, acepta y autoriza de manera libre y espontánea que el tratamiento de la información relativa a pertenencia a sindicatos, organizaciones sociales, a la salud, a la vida sexual y datos biométricos, que sea necesaria para el cumplimiento de la finalidades anteriormente descritas basado en lo establecido en la presente autorización y el Manual de protección de datos personales de la Empresa.<br> 
				De conformidad con lo dispuesto en la Ley Estatutaria 1581 de 2012, el Decreto 1377 de 2013 o las normas que la modifiquen, los datos personales que obtengan FSD S.A.S. por parte del Titular de la Información o representante legal en el caso de información de hijos(as) de menores de edad, serán recogidos y almacenados y objeto de tratamiento en bases de datos hasta la terminación del vínculo contractual entre el Titular de la Información y FSD S.A.S. y durante veinte (20) años más. Esta base de datos cuenta con las medidas de seguridad necesarias para la conservación adecuada de los datos personales. 
				Con la aceptación de la presente autorización, se permite el tratamiento de sus datos personales para las finalidades mencionadas y reconoce que los datos suministrados a FSD S.A.S. son ciertos, dejando por sentado que no se ha omitido o adulterado ninguna información. <br> 
				Se deja constancia que usted tiene el derecho de acceder en cualquier momento a los datos suministrados, a solicitar su corrección, actualización o supresión en los términos establecidos en la Ley Estatutaria 1581 de 2012, el Decreto 1377 de 2013 o las normas que la modifiquen, mediante escrito dirigido a FSD S.A.S. indicando las razones por las cuales solicita alguno de los tramites anteriormente mencionados, con el fin que FSD S.A.S. pueda revisarlas y pronunciarse sobre las mismas.<br>
				<strong>f.	Autorización para la consulta, reporte y procesamiento de datos financieros a centrales de riesgo. </strong>
				de acreedor, a consultar, solicitar, suministrar, reportar, procesar y divulgar toda la información que se refiere a mi comportamiento crediticio, financiero y comercial a las Centrales de Riesgo que administra la Asociación Bancaria y de Entidades Financieras de Colombia o a quien represente sus derechos.<br> 
				Lo anterior implica que mi comportamiento presente y pasado frente a mis obligaciones permanecerá reflejado de manera completa en las mencionadas bases de datos con el objeto de suministrar información suficiente y adecuada al mercado sobre el estado de mis obligaciones financieras, comerciales y crediticias. Por lo tanto, conocerán mi información quienes se encuentren afiliados a dichas centrales y/o que tengan acceso a está, de conformidad con la legislación aplicable. 
				La permanencia de mi información en las bases de datos será determinada por el ordenamiento jurídico aplicable, en especial por las normas legales y la jurisprudencia, los cuales contienen mis derechos y obligaciones, que, por ser públicos, conozco plenamente.<br>
				En caso de que, en el futuro, el autorizado en este documento efectúe una venta de cartera o una cesión a cualquier título de las obligaciones a mi cargo a favor de un tercero, los efectos de la presente autorización se extenderán a éste, en los mismos términos y condiciones.<br> 
				El beneplácito otorgado por el usuario y/o suscriptor para el tratamiento de información crediticia y la responsabilidad a cargo de la Future Solutions Development SAS para el manejo de dichos datos, se encuentran enmarcadas dentro de los postulados de orden superior establecidos en los artículos 15 y 20 de la Constitución Política y desarrollados por la Ley Estatutaria 1581 de 2012, reglamentada parcialmente por el Decreto 1377 de 2013. 
				Igualmente autorizo para que cualquier comunicación que sea necesaria sea remitida al email y/o a la dirección de notificación que aparece al pie de mi firma.

				</tr>	
			</table>
            </td>
        </tr>
        </tbody>
    </table>
	<br>
	<td colspan="2">
	 <table width="100%" border="1">
      <tbody >
       <tr >
        <td align="center">En señal de conocimiento, aceptación y autorización, firmo<br><br><br><br><br><br><br>.<?php if(file_exists($url_firma)){ ?><img height="130px" src="<?=$url_firma?>"></img><?php } if(file_exists($url_huella)){ ?><img height="130px" src="<?=$url_huella?>"></img><?php } ?></td>
       </tr>
		<tr>
			<td style="font-size: 8px;line-height: inherit;text-align: center;border: 0">Consulte el régimen de protección de usuarios en www.crcom.gov.co</td>
		</tr>
  	  </tbody>
	 </table>
	 <h6 align="center"><?php echo $details['tipo_documento'] ?> <span style="border-bottom: 1px solid;"><?php echo $details['documento'] ?></span> FECHA <span style="border-bottom: 1px solid;"><?php echo date("d",strtotime($fcontrato)) ?>/<?php echo date("m",strtotime($fcontrato)) ?>/<?php echo date("Y",strtotime($fcontrato)) ?></span></h6>
	 
	</td><br><br><br><br>
	<table border="1">
        <tr>
            <td class="centeral" rowspan="6">
                <h4>SISTEMA INTEGRADO DE GESTION</h4>
				<h4>FUTURE SOLUTIONS DEVELOPMENT SAS</h4>
				<h5>NIT. 830502580-6</h5>
				<h5>EVIDENCIA DE PRESTACIÓN DE SERVICIO</h5>
            </td>
			<tr>
				   <td style="padding: 1"> <img src="<?php echo FCPATH . 'userfiles/company/' . $this->config->item('logo') ?>" style="max-width:80px;"></td>
			</tr>
			<tr>
            	<td style="padding: 1;font-size: 11px">CÓDIGO: MIS-RYC-FRM-003</td>
			</tr>
			<tr>
            	<td style="padding: 1;font-size: 11px">VERSIÓN: 04</td>
			</tr>
			<tr>
            	<td style="padding: 1;font-size: 11px">FECHA DE EMISIÓN: 18/03/2024</td>
			</tr>
			<tr>
            	<td style="padding: 1;font-size: 11px">PAGINA 1 DE 1</td>
			</tr>
        </tr>
		<tr style="border: 0">
			<td style="border: 0"></td>
			<td style="border: 0">Contrato N: <?php echo $details['abonado'] ?></td>
		</tr>
 	</table>
<table width="200" class="prestacion" border="1">
	  <tbody>
		<tr>
		  <th colspan="10" align="center">CANALES DE ATENCIÓN</th>
		</tr>
		<tr>
		  <td colspan="10" align="center" >Soporte técnico: PBX 6017943254 - 601 9172166 Opc.1 WhatsApp: 3212893978 Dirección: Calle 13A No. 14-60 Sogamoso (Boyacá)<br>
			  Email: mesaservicio@ottis.com.co</td>
		</tr>
		<tr>
		  <td align="center">FECHA:</td>
		  <td colspan="2" >&nbsp;<?php echo date("d/m/Y",strtotime($fcontrato)) ?></td>
		  <td colspan="3"  align="center">NÚMERO DE SOLICITUD / TAREA :</td>
		  <td colspan="4" >&nbsp;</td>
		</tr>
		<tr>
		  <th colspan="10" align="center" >INFORMACIÓN BÁSICA DEL CLIENTE</th>
		</tr>
		<tr >
		  <td colspan="2" >NOMBRE DEL TITULAR:</td>
		  <td colspan="4" >&nbsp;<?php echo $details['name'].' '.$details['dosnombre'].' '.$details['unoapellido'].' '.$details['dosapellido'] ?></td>
		  <td colspan="2" >IDENTIFICACION:</td>
		  <td colspan="2" >&nbsp;<?php echo $details['tipo_documento'].' '.$details['documento'] ?></td>
		</tr>
		<tr>
		  <td colspan="2" >NOMBRE QUIEN RECIBE:</td>
		  <td colspan="4" >&nbsp;</td>
		  <td colspan="2" >IDENTIFICACION:</td>
		  <td colspan="2" >&nbsp;</td>
		</tr>
		<tr>
		  <td colspan="2">CORREO ELECTRÓNICO:</td>
		  <td colspan="4">&nbsp;<?php echo $details['email'] ?></td>
		  <td colspan="2">CELULAR:</td>
		  <td colspan="2">&nbsp;<?php echo $details['celular'] ?></td>
		</tr>
		<tr>
		  <td colspan="2">DIRECCION:</td>
		  <td colspan="3">&nbsp;<?php
					if($details['numero1']==='' || $details['numero1']===0 || $details['numero2']===0){
						if($details['divnum1']==0){
										$trr='';
									}else{
										$trr=$details['divnum1'];
									}
									if($details['divnum2']==0){
										$apt='';
									}else{
										$apt=$details['divnum2'];
									}
						
						echo $details['residencia'].", ".$details['referencia'].' '.$details['divicion'].' '.$trr.' '.$details['divicion2'].' '.$apt;
						
					}else{
						if($details['divnum1']==0){
										$trr='';
									}else{
										$trr=$details['divnum1'];
									}
									if($details['divnum2']==0){
										$apt='';
									}else{
										$apt=$details['divnum2'];
									}
						echo $details['nomenclatura'].' '.$details['numero1'].$details['adicionauno'].' # '.$details['numero2'].$details['adicional2'].' - '.$details['numero3'].'/'.$details['residencia'].", ".$details['referencia'].' '.$details['divicion'].' '.$trr.' '.$details['divicion2'].' '.$apt;
						
					} ?></td>
		  <td colspan="2">COORDENADAS:</td>
		  <td colspan="3">&nbsp;<?php echo $details['coor1'].' '.$details['coor2'] ?></td>
		</tr>
		<tr>
		  <th colspan="10" align="center" >INFORMACION TECNICA - EQUIPOS DE COMUNICACIONES ENTREGADOS EN CALIDAD DE COMODATO EN LAS INSTALACIONES</th>
		</tr>
		<tr>
		  <td colspan="10">1.  Los equipos de comunicaciones y elementos consumibles a continuación relacionados, se instalan en la ubicación del suscriptor y son entregados por Future Solutions Development S.A.S. en calidad de Comodato (Tenencia o Préstamo), por lo tanto, en el momento de la cancelación definitiva del servicio, los equipos y sus consumibles serán retirados en su totalidad por la empresa.<br>
			<?php 
				if($equipo->marca==''){
					$eq='_____________';
				}else{
					$eq=$equipo->marca;
				}if($equipo->metos==''){
					$met='_____________';
				}else{
					$met=$equipo->metros;
				}if($equipo->mac==''){
					$mac='_____________';
				}else{
					$mac='<span style="border-bottom: 1px solid;">'.$equipo->mac.'</span>';
				}if($equipo->accesorios==''){
					$acc='_______________________________________________________';
				}else{
					$acc='<span style="border-bottom: 1px solid;">'.$equipo->accesorios.'</span>';
				}
			  	if($servicios['combo']!='no'){
						$patron = '/\d+/';
						preg_match($patron, $servicios['combo'], $coincidencias);
						$int=$coincidencias[0];
						$int2=$servicios['combo'];
					}else{
						$int='';
					} echo '<span style="border-bottom: 1px solid;">'.$int.'</span>'
			?>
			Tecnología Instalada: Radio <input type="checkbox" class="checkbox-input"></input> Fibra Optica <input type="checkbox" style="transform: scale(1.5)"></input>&nbsp; &nbsp;  Equipo CPE Marca:<span style="border-bottom: 1px solid;"><?php echo $eq ?></span>	Cable UTP o fibra:<?php echo $met ?>metros<br>
			Referencia o Modelo:___________________________	Dirección MAC o serial: <?php echo $mac ?> Adaptador de corriente:___________<br>	
			Accesorios adicionales: <?php echo $acc ?><br>																
			Plan contratado: <?php echo $int ?>Mbps <span style="border-bottom: 1px solid;"><?php echo $tv.' '.$int2 ?></span> Valor de mensualidad: <span style="border-bottom: 1px solid;"><?php echo amountFormat($totaltv+$inter) ?></span> Cláusula de permanencia: <span style="border-bottom: 1px solid;"><?php echo $clausula['meses'] ?></span> meses
			</td>
		</tr>
		<tr>
		  <th colspan="10" align="center" >VALORES CANCELADOS POR EL CLIENTE (CUANDO APLIQUE)</th>
		</tr>
		<tr>
		  <td colspan="2" width="20%" align="center">Instalación:</td>
		  <td colspan="2" width="20%" align="center">Días de la Mensualidad:</td>
		  <td colspan="2" width="20%" align="center">Suministros:</td>
		  <td colspan="2" width="20%" align="center">Visita Técnica:</td>
		  <td colspan="2" width="20%" align="center">Valor Total Pagado</td>
		</tr>
		<tr>
		  <td colspan="2">$</td>
		  <td colspan="2">$</td>
		  <td colspan="2">$</td>
		  <td colspan="2">$</td>
		  <td colspan="2">$</td>
		</tr>
		<tr>
		  <th colspan="10" align="center" >NOTAS IMPORTANTES</th>
		</tr>
		<tr>
		  <td colspan="10">1. Medios de Pago: EFECTY Convenio 112389, Corresponsal JER Convenio 432, Pago por PSE mediante página www.ottis.com.co</td>
		</tr>
		<tr>
		  <td colspan="10">2.  La información técnica correspondiente a la ejecución de la labor realizada se enviará vía correo electrónico a la dirección indicada por el cliente y que se encuentra registrada en el presente formato.</td>
		</tr>
		<tr>
		  <td colspan="10">3.  Para el correcto funcionamiento de los equipos de comunicaciones es necesario que la vivienda cuente con polo a tierra, protección eléctrica o que los equipos se encuentren conectados a un dispositivo regulador de voltaje.  En caso de que la vivienda no cumpla con la anterior observación, el cliente asume la responsabilidad de daños eléctricos en los equipos instalados, incluyendo el costo de los mismos de ser necesarios.</td>
		</tr>
		<tr>
		  <td colspan="10">4.  Se recomienda al cliente no alterar las conexiones en los equipos instalado en su vivienda para evitar indisponibilidades en la prestación del servicio que pueden acarrear costos adicionales de desplazamiento. Se recomienda al cliente desconectar los equipos de la alimentación eléctrica en caso de presentarse tormenta.</td>
		</tr>
		<tr>
		  <td colspan="10">5.  Le invitamos a visitar nuestro sitio web www.ottis.com.co en la cual encontrará toda la información referente a normatividad, planes ofertados, características del acceso a Internet ofrecido, su velocidad, calidad del servicio, etc. </td>
		</tr>
		<tr>
		  <th colspan="10" align="center" >ENCUESTA DE SATISFACCION DE ATENCIÓN AL CLIENTE</th>
		</tr>
		 <tr>
		  <td colspan="10" >La atención recibida por el personal de la empresa fue:	<br>																
			Excelente (5) <input type="checkbox" style="transform: scale(20)"></input>			Buena (4)	<input type="checkbox"></input>				Regular (3)	<input type="checkbox"></input>			Deficiente (2)	<input type="checkbox"></input>		Muy Deficiente (1) <input type="checkbox"></input>	<br>	
			Tiene claridad sobre los siguientes temas relacionados con el servicio? (Sí o No) <br>																	
			Medios de pago		<input type="checkbox"></input>		Fecha de suspensión			<input type="checkbox"></input>			Canales de Atención 		<input type="checkbox"></input>		Envío de facturas  <input type="checkbox"></input>
	<br>		
			Observaciones:																	
			</td>
		</tr>
		<tr>
		  <th colspan="10" align="center" >AUTORIZACIÓN</th>
		</tr>
		<tr>
		  <td colspan="10">Autorizo el escaneo de la firma y huella de éste documento, con el fin de vincularlo en el contrato digital de servicios el cual posteriormente a la instalación, será enviado de forma digital al correo electrónico registrado junto con los demás documentos diligenciados por el cliente. </td>
		</tr>
		<tr>
			<td colspan="2">FIRMA Y HUELLA DE QUIEN RECIBE EL SERVICIO:</td>
			<td colspan="3"></td>
			<td colspan="2">NOMBRES TÉCNICOS QUE ENTREGAN EL SERVICIO:</td>
			<td colspan="3"></td>
		</tr>
		<tr>
			<td colspan="10">Observaciones o actualización de datos personales:</td>  
		</tr>
	  </tbody>
</table>

</div>
</body>
</html>