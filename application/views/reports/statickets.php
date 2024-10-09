<style>
	td {
		width: 14%;
		
	}
</style>
<script type="text/javascript">
    var dataVisits = [
        <?php $tt_inc = 0;foreach ($incomechart as $row) {
        $tt_inc += $row['total'];
        echo "{ x: '" . $row['date'] . "', y: " . intval($row['total']) . "},";
    }
        ?>
    ];
    var dataVisits2 = [
        <?php $tt_exp = 0; foreach ($expensechart as $row) {
        $tt_exp += $row['total'];
        echo "{ x: '" . $row['date'] . "', y: " . intval($row['total']) . "},";
    }
        ?>]; 
	var dataVisits3 = [
        <?php $tt_inc2 = 0;foreach ($incomechart2 as $row) {
        $tt_inc2 += $row['total'];
        echo "{ x: '" . $row['date'] . "', y: " . intval($row['total']) . "},";
    }
        ?>
    ];
	
</script>
<div class="app-content content container-fluid">
    <div class="content-wrapper">
        <div class="content-header">
            <div class="card-header">
                <h4 class="card-title">Estadisticas de Tickets
					<a class="float-xs-right" href="<?php echo base_url() ?>reports/refresh_data_ticket"><i class="icon-refresh2"></i></a></h4>
				</div>
				<div class="card-header">
					<div class="col-sm-3">
						<!-- Menú para seleccionar la sede -->
						<select class="form-control" id="sede-select" onchange="updateChart()">
							<?php
                                foreach ($customergrouplist as $row) {
                                    $cid = $row['id'];
                                    $title = $row['title'];
                                    echo "<option value='$cid'>$title</option>";
                                }
                                ?>
						</select>
					</div>
					<button id="uncheck-all" onclick="uncheckAll()" class="btn btn-primary" style="margin-left: 18px">Desmarcar todos</button>
					<hr>
					<table width="100%">
					<tr>
						<td><input type="checkbox" id="show-instalaciones" checked onchange="updateChart()" > Instalaciones</td>
						<td><input type="checkbox" id="show-retiros" checked onchange="updateChart()"> Retiros</td>
						<td><input type="checkbox" id="show-agregar-internet" checked onchange="updateChart()"> Agregar Internet</td>
						<td><input type="checkbox" id="show-agregar-television" checked onchange="updateChart()"> Agregar television</td>
						<td><input type="checkbox" id="show-Activacion" checked onchange="updateChart()"> Activacion</td>
					</tr>
					<tr>
						<td><input type="checkbox" id="show-Cambio-equipo" checked onchange="updateChart()" > Cambio de equipo</td>
						<td><input type="checkbox" id="show-Cambio-clave" checked onchange="updateChart()"> Cambio de clave</td>
						<td><input type="checkbox" id="show-Corte-Combo" checked onchange="updateChart()"> Corte Combo</td>
						<td><input type="checkbox" id="show-Corte-Internet" checked onchange="updateChart()"> Corte Internet</td>
						<td><input type="checkbox" id="show-Corte-television" checked onchange="updateChart()"> Corte television</td>
					</tr>
					<tr>
						<td><input type="checkbox" id="show-Equipo-adicional" checked onchange="updateChart()" > Equipo adicional</td>
						<td><input type="checkbox" id="show-Punto-nuevo" checked onchange="updateChart()"> Punto nuevo</td>
						<td><input type="checkbox" id="show-Veeduria" checked onchange="updateChart()"> Veeduria</td>
						<td><input type="checkbox" id="show-Revision-Internet" checked onchange="updateChart()"> Revision de Internet</td>
						<td><input type="checkbox" id="show-Revision-television" checked onchange="updateChart()"> Revision de television</td>
					</tr>
					<tr>
						<<td><input type="checkbox" id="show-Revision-tv-internet" checked onchange="updateChart()" > Revision tv e internet</td>
						<td><input type="checkbox" id="show-Reconexion-Combo" checked onchange="updateChart()"> Reconexion Combo</td>
						<td><input type="checkbox" id="show-Reinstalacion" checked onchange="updateChart()"> Reinstalación</td>
						<td><input type="checkbox" id="show-Reconexion-Internet" checked onchange="updateChart()"> Reconexion Internet</td>
						<td><input type="checkbox" id="show-Reconexion-Television" checked onchange="updateChart()"> Reconexion Television</td>
					</tr>
					<tr>
						<td><input type="checkbox" id="show-Recuperacion-modem" checked onchange="updateChart()" > Recuperación modem</td>
						<td><input type="checkbox" id="show-Subir-megas" checked onchange="updateChart()"> Subir megas</td>
						<td><input type="checkbox" id="show-Bajar-megas" checked onchange="updateChart()"> Bajar megas</td>
						<td><input type="checkbox" id="show-Suspension-Combo" checked onchange="updateChart()"> Suspension Combo</td>
						<td><input type="checkbox" id="show-Suspension-Internet" checked onchange="updateChart()"> Suspension Internet</td>
					</tr>
					<tr>
						<td><input type="checkbox" id="show-Suspension-Television" checked onchange="updateChart()" > Suspension Television</td>
						<td><input type="checkbox" id="show-Traslado" checked onchange="updateChart()"> Traslado</td>
						<td><input type="checkbox" id="show-Toma-Adicional" checked onchange="updateChart()"> Toma Adicional</td>
						<td><input type="checkbox" id="show-Migracion" checked onchange="updateChart()"> Migracion</td>
						<td></td>
					</tr>
					</table>
            </div>
        </div>
        <!--div class="content-body"><!-- stats -->
			
            <!--/ stats -->
            <!--/ project charts -->
            <div class="row">
                <div class="col-xl-12 col-lg-12">
                    <div class="card">
                        <div class="card-header no-border">
                            <h6 class="card-title">Tickets resueltos en los ultimos 12 meses</h6>

                        </div>

                        <div class="card-body">


                            <div id="invoices-sales-chart"></div>

                        </div>

                    </div>
                </div>

            </div>
             
            <!--div class="row match-height">

                <div class="col-xl-12 col-lg-12 ">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title"><?php echo $this->lang->line('All Time Detailed Statistics') ?></h4>
                            <a class="heading-elements-toggle"><i class="icon-ellipsis font-medium-3"></i></a>
                            <div class="heading-elements">
                                <ul class="list-inline mb-0">
                                    <li><a data-action="reload"><i class="icon-reload"></i></a></li>
                                    <li><a data-action="expand"><i class="icon-expand2"></i></a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="card-body">

                            <div class="table-responsive">
                                <table class="table table-hover mb-1">
                                    <thead>
                                    <tr>
                                        <th><?php echo $this->lang->line('Month') ?></th>
                                        <th><?php echo $this->lang->line('Income') ?></th>
                                        <th><?php echo $this->lang->line('Expenses') ?></th>
                                        <th><?php echo $this->lang->line('Sales') ?></th>
                                        <th><?php echo $this->lang->line('Invoices') ?></th>
                                        <th><?php echo $this->lang->line('products') .' vendidos'  ?></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php

                                    foreach ($stat as $item) {
                                        // $month=date("F", $item['month']);


                                        $dateObj = DateTime::createFromFormat('!m', $item['month']);
                                        $month = $dateObj->format('F');
										setlocale(LC_TIME, "spanish");
                                        echo '<tr>
                                <td class="text-truncate">' . strftime("%B del", strtotime($month)) .' ' . $item['year'] . '</td>
                                <td class="text-truncate"> ' . amountFormat($item['income']) . '</td>
                            
                                <td class="text-truncate">' . amountFormat($item['expense']) . '</td>
                                 <td class="text-truncate">' . amountFormat($item['sales']) . '</td>
                                  <td class="text-truncate">' . $item['invoices'] . '</td>
                                   <td class="text-truncate">' . $item['items'] . '</td>
                               
                            </tr>';
                                    } ?>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div-->
            <!-- Recent invoice with Statistics -->


        </div>
    </div>
</div>
<?php //var_dump($stat); ?>
<?php $date = new DateTime();
        $mes =$date->format("m");
        $year =$date->format("Y");
$data = [];
$data = [];
foreach ($stat as $row) {
    if (intval($row['month']) > intval($mes) && intval($row['year']) >= intval($year)) {
        // Ignorar meses futuros
    } else {
        $num = cal_days_in_month(CAL_GREGORIAN, $row['month'], $row['year']);
        $data[] = [
            'sede' => intval($row['sede']),  // Asegurarse de tener la sede en los datos
            'x' => $row['year'] . '-' . sprintf("%02d", $row['month']) . "-$num",  // Llave X (Fecha)
            'A' => intval($row['Instalacion']),  // Valor de Instalaciones
            'B' => intval($row['Retiro_voluntario']),  // Valor de Retiros
            'C' => intval($row['AgregarInternet']),  // Valor de Retiros
            'D' => intval($row['AgregarTelevision']),  // Valor de Agregar Internet
            'E' => intval($row['Cambio_equipo']),  
            'F' => intval($row['Cambio_clave']),  
            'G' => intval($row['Corte_Combo']),  
            'H' => intval($row['Corte_Internet']+$row['Corte_Combo']),  
            'I' => intval($row['Corte_Television']+$row['Corte_Combo']),  
            'J' => intval($row['Equipo_adicional']),  
            'K' => intval($row['Punto_nuevo']),  
            'L' => intval($row['Veeduria']),  
            'M' => intval($row['Revision_Internet']+$row['Revision_tv_internet']),  
            'N' => intval($row['Revision_television']+$row['Revision_tv_internet']),  
            'O' => intval($row['Revision_tv_internet']),  
            'P' => intval($row['Reconexion_Combo']),  
            'Q' => intval($row['Reinstalación']),  
            'R' => intval($row['Reconexion_Internet']+$row['Reconexion_Combo']),  
            'S' => intval($row['Reconexion_Television']+$row['Reconexion_Combo']),  
            'T' => intval($row['Recuperación_modem']),  
            'U' => intval($row['Subir_megas']),  
            'V' => intval($row['Bajar_megas']),  
            'W' => intval($row['Suspension_Combo']),  
            'Y' => intval($row['Suspension_Internet']+$row['Suspension_Combo']),  
            'Z' => intval($row['Suspension_Television']+$row['Suspension_Combo']),  
            'A1' => intval($row['Traslado']),  
            'B1' => intval($row['Toma_Adicional']),  
            'C1' => intval($row['Migracion']),  
        ];
    }
}

 ?>
<script type="text/javascript">
	
	// Pasar los datos generados por PHP a JavaScript
	var allData = <?php echo json_encode($data); ?>;
	// Función para desmarcar todos los checkboxes
	function uncheckAll() {
		document.getElementById('show-instalaciones').checked = false;
		document.getElementById('show-retiros').checked = false;
		document.getElementById('show-agregar-internet').checked = false;
		document.getElementById('show-agregar-television').checked = false;		
		document.getElementById('show-Cambio-equipo').checked = false;
		document.getElementById('show-Cambio-clave').checked = false;
		document.getElementById('show-Corte-Combo').checked = false;
		document.getElementById('show-Corte-Internet').checked = false;
		document.getElementById('show-Corte-television').checked = false;
		document.getElementById('show-Equipo-adicional').checked = false;
		document.getElementById('show-Punto-nuevo').checked = false;
		document.getElementById('show-Veeduria').checked = false;
		document.getElementById('show-Revision-Internet').checked = false;
		document.getElementById('show-Revision-television').checked = false;
		document.getElementById('show-Revision-tv-internet').checked = false;
		document.getElementById('show-Reconexion-Combo').checked = false;
		document.getElementById('show-Reinstalacion').checked = false;
		document.getElementById('show-Reconexion-Internet').checked = false;
		document.getElementById('show-Reconexion-Television').checked = false;
		document.getElementById('show-Recuperacion-modem').checked = false;
		document.getElementById('show-Subir-megas').checked = false;
		document.getElementById('show-Bajar-megas').checked = false;
		document.getElementById('show-Suspension-Combo').checked = false;
		document.getElementById('show-Suspension-Internet').checked = false;
		document.getElementById('show-Suspension-Television').checked = false;
		document.getElementById('show-Traslado').checked = false;
		document.getElementById('show-Toma-Adicional').checked = false;
		document.getElementById('show-Migracion').checked = false;

		// Actualizar el gráfico después de desmarcar los checkboxes
		updateChart();
	}
	
	function updateChart() {
    var selectedSede = document.getElementById("sede-select").value;

    // Filtrar los datos por la sede seleccionada
    var filteredData = allData.filter(function(row) {
        return row.sede == selectedSede;
    });

    // Verificar qué series deben mostrarse
    var ykeys = [];
    var labels = [];
    var barColors = [];

    if (document.getElementById('show-instalaciones').checked) {
        ykeys.push('A');  // 'y' es el valor de Instalaciones
        labels.push('Instalaciones');
        barColors.push('#34cea7');  // Color para Instalaciones
    }
    if (document.getElementById('show-retiros').checked) {
        ykeys.push('B');  // 'z' es el valor de Retiros
        labels.push('Retiros');
        barColors.push('#ff6e40');  // Color para Retiros
    }
    if (document.getElementById('show-agregar-internet').checked) {
        ykeys.push('C');  // 'A' es el valor de Agregar Internet
        labels.push('AgregarInternet');
        barColors.push('#c3c52e');  // Color para Agregar Internet
    }
	if (document.getElementById('show-agregar-television').checked) {
        ykeys.push('D');  // 'A' es el valor de Agregar Internet
        labels.push('AgregarTelevision');
        barColors.push('#2ec5be');
    }
	if (document.getElementById('show-Cambio-equipo').checked) {
        ykeys.push('E');  // 'A' es el valor de Agregar Internet
        labels.push('Cambio_equipo');
        barColors.push('#2e69c5');
    }
	if (document.getElementById('show-Cambio-clave').checked) {
        ykeys.push('F');  // 'A' es el valor de Agregar Internet
        labels.push('Cambio_clave');
        barColors.push('#2e35c5');
    }
	if (document.getElementById('show-Corte-Combo').checked) {
        ykeys.push('G');  // 'A' es el valor de Agregar Internet
        labels.push('Corte_Combo');
        barColors.push('#6e2ec5');
    }
  	if (document.getElementById('show-Corte-Internet').checked) {
        ykeys.push('H');  // 'A' es el valor de Agregar Internet
        labels.push('Corte_Internet');
        barColors.push('#9c2ec5');
    }
 	if (document.getElementById('show-Corte-television').checked) {
        ykeys.push('I');  // 'A' es el valor de Agregar Internet
        labels.push('Corte_Television');
        barColors.push('#c52eb0');
    }
 	if (document.getElementById('show-Equipo-adicional').checked) {
        ykeys.push('J');  // 'A' es el valor de Agregar Internet
        labels.push('Equipo_adicional');
        barColors.push('#c52e83');
    }
 	if (document.getElementById('show-Punto-nuevo').checked) {
        ykeys.push('K');  // 'A' es el valor de Agregar Internet
        labels.push('Punto_nuevo');
        barColors.push('#c52e50');
    }
 	if (document.getElementById('show-Veeduria').checked) {
        ykeys.push('L');  // 'A' es el valor de Agregar Internet
        labels.push('Veeduria');
        barColors.push('#c52e2e');
    }
 	if (document.getElementById('show-Revision-Internet').checked) {
        ykeys.push('M');  // 'A' es el valor de Agregar Internet
        labels.push('Revision_Internet');
        barColors.push('#c5592e');
    }
 	if (document.getElementById('show-Revision-television').checked) {
        ykeys.push('N');  // 'A' es el valor de Agregar Internet
        labels.push('Revision_television');
        barColors.push('#c57e2e');
    }
 	if (document.getElementById('show-Revision-tv-internet').checked) {
        ykeys.push('O');  // 'A' es el valor de Agregar Internet
        labels.push('Revision_tv_internet');
        barColors.push('#c5972e');
    }
 	if (document.getElementById('show-Reconexion-Combo').checked) {
        ykeys.push('P');  // 'A' es el valor de Agregar Internet
        labels.push('Reconexion_Combo');
        barColors.push('#c5b02e');
    }if (document.getElementById('show-Reinstalacion').checked) {
        ykeys.push('Q');  // 'A' es el valor de Agregar Internet
        labels.push('Reinstalación');
        barColors.push('#acc52e');
    }if (document.getElementById('show-Reconexion-Internet').checked) {
        ykeys.push('R');  // 'A' es el valor de Agregar Internet
        labels.push('Reconexion_Internet');
        barColors.push('#acc52e');
    }if (document.getElementById('show-Reconexion-Television').checked) {
        ykeys.push('S');  // 'A' es el valor de Agregar Internet
        labels.push('Reconexion_Television');
        barColors.push('#90e810');
    }if (document.getElementById('show-Recuperacion-modem').checked) {
        ykeys.push('T');  // 'A' es el valor de Agregar Internet
        labels.push('Recuperación_modem');
        barColors.push('#31e810');
    }if (document.getElementById('show-Subir-megas').checked) {
        ykeys.push('U');  // 'A' es el valor de Agregar Internet
        labels.push('Subir_megas');
        barColors.push('#10e879');
    }if (document.getElementById('show-Bajar-megas').checked) {
        ykeys.push('V');  // 'A' es el valor de Agregar Internet
        labels.push('Bajar_megas');
        barColors.push('#10e8d1');
    }if (document.getElementById('show-Suspension-Combo').checked) {
        ykeys.push('W');  // 'A' es el valor de Agregar Internet
        labels.push('Suspension_Combo');
        barColors.push('#10c1e8');
    }if (document.getElementById('show-Suspension-Internet').checked) {
        ykeys.push('Y');  // 'A' es el valor de Agregar Internet
        labels.push('Suspension_Internet');
        barColors.push('#1096e8');
    }if (document.getElementById('show-Suspension-Television').checked) {
        ykeys.push('Z');  // 'A' es el valor de Agregar Internet
        labels.push('Suspension_Television');
        barColors.push('#1055e8');
    }if (document.getElementById('show-Traslado').checked) {
        ykeys.push('A1');  // 'A' es el valor de Agregar Internet
        labels.push('Traslado');
        barColors.push('#1013e8');
    }if (document.getElementById('show-Toma-Adicional').checked) {
        ykeys.push('B1');  // 'A' es el valor de Agregar Internet
        labels.push('Toma_Adicional');
        barColors.push('#7c10e8');
    }if (document.getElementById('show-Migracion').checked) {
        ykeys.push('C1');  // 'A' es el valor de Agregar Internet
        labels.push('Migracion');
        barColors.push('#db10e8');
    }

    // Evitar gráfico vacío si no hay series seleccionadas
    if (ykeys.length === 0) {
        alert("Debes seleccionar al menos una serie para mostrar.");
        return;
    }

    // Vaciar el gráfico y volver a generarlo
    $('#invoices-sales-chart').empty();
    
    // Crear el gráfico solo si hay datos válidos
    if (filteredData.length > 0) {
        Morris.Bar({
            element: 'invoices-sales-chart',
            data: filteredData,
            xkey: 'x',  // Llave X (fecha)
            ykeys: ykeys,  // Series dinámicas
            labels: labels,  // Etiquetas dinámicas
            hideHover: false,  // Mostrar los tooltips al pasar el mouse
            resize: true,  // Hacer el gráfico responsivo
            barColors: barColors  // Colores dinámicos
        });
    } else {
        alert("No hay datos para mostrar para la sede seleccionada.");
    }
}

// Ejecutar la función para generar el gráfico inicial cuando se carga la página
document.addEventListener('DOMContentLoaded', function() {
    updateChart();
});



    /*$('#invoices-sales-chart').empty();

    Morris.Bar({
        element: 'invoices-sales-chart',
        data: [
            <?php /*$i = 0;foreach ($stat as $row) {
			// Filtrar por sede 1
            if ($row['sede'] == 3) {
				if(intval($row['month'])>intval($mes) &&  intval($row['year']) >= intval($year)){
					//break;
				   // var_dump(intval($mes)." ".intval($row['month'])." " .intval($year)." ".intval($row['year']));
				}else{
					$num = cal_days_in_month(CAL_GREGORIAN, $row['month'], $row['year']);
				echo "{ 
				x: '" . $row['year'] . '-' . sprintf("%02d", $row['month']) . "-$num', 
				y: " . intval($row['Instalacion']) . ", 
				z: " . intval($row['Retiro_voluntario']) .", 
				A: " . intval($row['Retiro_voluntario']) . "},";
				$i++;    
				}
			}
            
        }*/ ?>

        ],
        xkey: 'x',
        ykeys: ['y', 'z', 'A'],
        labels: ['Instalaciones', 'Retiros', 'Agregar internet'],
        hideHover: 'auto',
        resize: true,
        barColors: ['#34cea7', '#ff6e40', '#c3c52e'],
    }); */


    $('#invoices-products-chart').empty();

    Morris.Line({
        element: 'invoices-products-chart',
        data: [
            <?php $i = 0;foreach (array_reverse($stat) as $row) {
            if(intval($row['month'])>intval($mes) &&  intval($row['year']) >= intval($year)){
                //break;
               // var_dump(intval($mes)." ".intval($row['month'])." " .intval($year)." ".intval($row['year']));
            }else{
            $num = cal_days_in_month(CAL_GREGORIAN, $row['month'], $row['year']);
            echo "{ x: '" . $row['year'] . '-' . sprintf("%02d", $row['month']) . "-$num', y: " . intval($row['items']) . ", z: " . intval($row['invoices']) . "},";
            $i++;}
        } ?>

        ],
        xkey: 'x',
        ykeys: ['y', 'z'],
        labels: ['Productos', 'Facturas'],
        hideHover: 'auto',
        resize: true,
        lineColors: ['#34cea7', '#ff6e40'],
    });

	function drawIncomeChart(dataVisits) {

        $('#dashboard-income-chart').empty();

        Morris.Area({
            element: 'dashboard-income-chart',
            data: dataVisits,
            xkey: 'x',
            ykeys: ['y'],
            ymin: 'auto 40',
            labels: ['<?php echo  $this->lang->line('Amount') ?>'],
            xLabels: "day",
            hideHover: 'auto',
            resize: true,
            lineColors: [
                '#34cea7',
            ],
            pointFillColors: [
                '#ff6e40',
            ],
            fillOpacity: 0.4,
        });


    }
	function drawIncomeChart2(dataVisits3) {

        $('#dashboard-income-chart2').empty();

        Morris.Area({
            element: 'dashboard-income-chart2',
            data: dataVisits3,
            xkey: 'x',
            ykeys: ['y'],
            ymin: 'auto 40',
            labels: ['<?php echo  $this->lang->line('Amount') ?>'],
            xLabels: "day",
            hideHover: 'auto',
            resize: true,
            lineColors: [
                '#34cea7',
            ],
            pointFillColors: [
                '#ff6e40',
            ],
            fillOpacity: 0.4,
        });


    }
	
	
	 function drawExpenseChart(dataVisits2) {

        $('#dashboard-expense-chart').empty();

        Morris.Area({
            element: 'dashboard-expense-chart',
            data: dataVisits2,
            xkey: 'x',
            ykeys: ['y'],
            ymin: 'auto 0',
            labels: ['<?php echo  $this->lang->line('Amount') ?>'],
            xLabels: "day",
            hideHover: 'auto',
            resize: true,
            lineColors: [
                '#ff6e40',
            ],
            pointFillColors: [
                '#34cea7',
            ]
        });


    }
	drawIncomeChart(dataVisits);
	drawIncomeChart2(dataVisits3);
	

    $('a[data-toggle=tab').on('shown.bs.tab', function (e) {
        window.dispatchEvent(new Event('resize'));
      
    });
</script>