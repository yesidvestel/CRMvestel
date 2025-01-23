<?php

$currentMonth = date('Y-m'); // Mes actual en formato YYYY-MM
$previousMonth = date('Y-m', strtotime('-1 month')); // Mes anterior en formato YYYY-MM
setlocale(LC_TIME, "spanish");
$currentMonthName = strftime('%B', strtotime(date('Y-m-01'))); // Nombre del mes actual
$previousMonthName = strftime('%B', strtotime('-1 month')); 
 

// Crear un rango de días (1 al 31, porque queremos comparar día por día)
$dataVisits = [];
for ($day = 1; $day <= 31; $day++) {
    $formattedDay = str_pad($day, 2, '0', STR_PAD_LEFT); // Asegurar formato "01", "02", etc.
    $dataVisits[$formattedDay] = [
        'x' => $formattedDay,
        'currentMonth' => 0,
        'previousMonth' => 0
    ];
}

// Procesar los datos de $incomechart
foreach ($incomechart as $row) {
    $rowDay = date('d', strtotime($row['date'])); // Obtener el día (01, 02, ...)
    $rowMonth = date('Y-m', strtotime($row['date'])); // Obtener el mes (YYYY-MM)

    if ($rowMonth === $currentMonth) {
        $dataVisits[$rowDay]['currentMonth'] += intval($row['total']); // Sumar al mes actual
    } elseif ($rowMonth === $previousMonth) {
        $dataVisits[$rowDay]['previousMonth'] += intval($row['total']); // Sumar al mes anterior
    }
}

// Convierte el array a JSON para JavaScript
$dataVisitsJson = json_encode(array_values($dataVisits));
	$currentMonthExpenses = []; // Gastos del mes actual
	$previousMonthExpenses = []; // Gastos del mes anterior

	foreach ($expensechart as $row) {
		$date = $row['date'];
		$total = intval($row['total']);

		// Verifica si pertenece al mes actual o anterior
		if (date('Y-m', strtotime($date)) === date('Y-m')) {
			$currentMonthExpenses[date('d', strtotime($date))] = $total; // Día como clave
		} elseif (date('Y-m', strtotime($date)) === date('Y-m', strtotime('-1 month'))) {
			$previousMonthExpenses[date('d', strtotime($date))] = $total; // Día como clave
		}
	}

	// Genera el array para Morris.js
	$dataVisits2 = [];
	for ($day = 1; $day <= 31; $day++) {
		$formattedDay = str_pad($day, 2, '0', STR_PAD_LEFT); // Formato de día con dos dígitos

		$dataVisits2[] = [
			'x' => $formattedDay,
			'currentMonth' => isset($currentMonthExpenses[$formattedDay]) ? $currentMonthExpenses[$formattedDay] : 0,
			'previousMonth' => isset($previousMonthExpenses[$formattedDay]) ? $previousMonthExpenses[$formattedDay] : 0,
		];
	}
	$dataVisitsJson2 = json_encode(array_values($dataVisits2));
?>


<div class="app-content content container-fluid">
    <div class="content-wrapper">
        <div class="content-header">
            <div class="card-header">
                <h4 class="card-title"><?php echo $this->lang->line('Company Statistics') ?><a class="float-xs-right"
                                                                                               href="<?php echo base_url() ?>reports/refresh_data"><i
                                class="icon-refresh2"></i></a></h4>


            </div>
        </div>
        <div class="content-body"><!-- stats -->

            <!--/ stats -->
            <!--/ project charts -->
            <div class="row">
                <div class="col-xl-12 col-lg-12">
                    <div class="card">
                        <div class="card-header no-border">
                            <h6 class="card-title"><?php echo $this->lang->line('Sales in last 12 months') ?></h6>

                        </div>

                        <div class="card-body">


                            <div id="invoices-sales-chart"></div>

                        </div>

                    </div>
                </div>

            </div>
            <div class="row">
                <div class="col-xl-12 col-lg-12">
                    <div class="card">
                        <div class="card-header no-border">
                            <h6 class="card-title"><?php echo $this->lang->line('') ?>Comparativo de ingresos y gastos mes actual</h6>

                        

                         <p><?php echo $this->lang->line('') ?></p>
                                <ul class="nav nav-tabs">
                                    <li class="nav-item">
                                        <a class="nav-link active" id="base-tab1" data-toggle="tab" aria-controls="tab1"
                                           href="#sales"
                                           aria-expanded="true"><?php echo $this->lang->line('income') ?></a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="base-tab2" data-toggle="tab" aria-controls="tab2"
                                           href="#transactions1"
                                           aria-expanded="false"><?php echo $this->lang->line('expenses') ?></a>
                                    </li>


                                </ul>
                                <div class="tab-content pt-1">
                                    <div role="tabpanel" class="tab-pane active" id="sales" aria-expanded="true"
                                         data-toggle="tab">
                                        <div id="dashboard-income-chart"></div>

                                    </div>
                                    <div class="tab-pane" id="transactions1" data-toggle="tab" aria-expanded="false">
                                        <div id="dashboard-expense-chart"></div>
                                    </div>

                                </div>
						</div>
                    </div>
                </div>
            </div>
			<div class="row">
                <div class="col-xl-12 col-lg-12">
                    <div class="card">
                        <div class="card-header no-border">
                            <h6 class="card-title"><?php echo $this->lang->line('Products in last 12 months') ?></h6>

                        </div>

                        <div class="card-body">


                            <div id="invoices-products-chart"></div>

                        </div>

                    </div>
                </div>

            </div>
            <!--/ project charts -->
            <!-- Recent invoice with Statistics -->
            <div class="row match-height">

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
            </div>
            <!-- Recent invoice with Statistics -->


        </div>
    </div>
</div>
<?php //var_dump($stat); ?>
<?php $date = new DateTime();
        $mes =$date->format("m");
        $year =$date->format("Y");

 ?>    
<script type="text/javascript">
	

    $('#invoices-sales-chart').empty();

    Morris.Bar({
        element: 'invoices-sales-chart',
        data: [
            <?php $i = 0;foreach ($stat as $row) {
            if(intval($row['month'])>intval($mes) &&  intval($row['year']) >= intval($year)){
                //break;
               // var_dump(intval($mes)." ".intval($row['month'])." " .intval($year)." ".intval($row['year']));
            }else{
                $num = cal_days_in_month(CAL_GREGORIAN, $row['month'], $row['year']);
            echo "{ x: '" . $row['year'] . '-' . sprintf("%02d", $row['month']) . "-$num', y: " . intval($row['income']) . ", z: " . intval($row['expense']) . "},";
            $i++;    
            }

            
        } ?>

        ],
        xkey: 'x',
        ykeys: ['y', 'z'],
        labels: ['Ingresos', 'Gastos'],
        hideHover: 'auto',
        resize: true,
        barColors: ['#34cea7', '#ff6e40'],
    });


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

	var dataVisits = <?php echo $dataVisitsJson; ?>;

	function drawIncomeChart(dataVisits) {
		$('#dashboard-income-chart').empty();

		Morris.Line({
			element: 'dashboard-income-chart',
			data: dataVisits,
			xkey: 'x', // Día del mes (01, 02, ..., 31)
			ykeys: ['currentMonth', 'previousMonth'], // Claves para las dos líneas
			labels: [
				'<?php echo ucfirst($currentMonthName); ?>',  // Nombre del mes actual
            	'<?php echo ucfirst($previousMonthName); ?>'
			],
			hideHover: 'auto',
			resize: true,
			lineColors: ['#34cea7', '#ff6e40'], // Colores para cada línea
			pointFillColors: ['#34cea7', '#ff6e40'],
			fillOpacity: 0.4,
		});
	}
	
	var dataVisits2 = <?php echo $dataVisitsJson2; ?>;
	 function drawExpenseChart(dataVisits2) {
		$('#dashboard-expense-chart').empty();

		Morris.Line({
			element: 'dashboard-expense-chart',
			data: dataVisits2,
			xkey: 'x', // Día del mes (01, 02, ..., 31)
			ykeys: ['currentMonth', 'previousMonth'], // Claves para las dos líneas
			labels: [
				'<?php echo ucfirst($currentMonthName); ?>',  // Nombre del mes actual (por ejemplo, "Enero")
				'<?php echo ucfirst($previousMonthName); ?>' // Nombre del mes anterior (por ejemplo, "Diciembre")
			],
			hideHover: 'auto',
			resize: true,
			lineColors: ['#ff6e40', '#34cea7'], // Colores para cada línea
			pointFillColors: ['#ff6e40', '#34cea7'],
			fillOpacity: 0.4,
		});
	}

	drawIncomeChart(dataVisits);
	

    $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
		var target = $(e.target).attr("href"); // Obtén el ID de la pestaña activa

		if (target === "#transactions1") { // Verifica si es la pestaña de "Expenses"
			$('#dashboard-expense-chart').empty(); // Limpia el gráfico antes de redibujarlo
			drawExpenseChart(<?php echo json_encode($dataVisits2); ?>); // Dibuja el gráfico de gastos
		}
	});
</script>