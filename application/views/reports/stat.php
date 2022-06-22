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
                <div class="col-xl-6 col-md-6 col-sm-12">
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
                                        <div></div>
                                    </div>

                                </div>
						</div>
                    </div>
                </div>
				 <div class="col-xl-6 col-md-6">
                    <div class="card">
                        <div class="card-header no-border">
                            <h6 class="card-title"><?php echo $this->lang->line('') ?>Comparativo de ingresos y gastos mes anterior</h6>

                        

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
                                        <div id="dashboard-income-chart2"></div>

                                    </div>
                                    <div class="tab-pane" id="transactions1" data-toggle="tab" aria-expanded="false">
                                        <div></div>
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
            <?php $i = 0;foreach (array_reverse($stat) as $row) {
            if(intval($row['month'])>intval($mes) &&  intval($row['year']) >= intval($year)){
                break;
               // var_dump(intval($mes)." ".intval($row['month'])." " .intval($year)." ".intval($row['year']));
            }

            $num = cal_days_in_month(CAL_GREGORIAN, $row['month'], $row['year']);
            echo "{ x: '" . $row['year'] . '-' . sprintf("%02d", $row['month']) . "-$num', y: " . intval($row['income']) . ", z: " . intval($row['expense']) . "},";
            $i++;
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
                break;
               // var_dump(intval($mes)." ".intval($row['month'])." " .intval($year)." ".intval($row['year']));
            }
            $num = cal_days_in_month(CAL_GREGORIAN, $row['month'], $row['year']);
            echo "{ x: '" . $row['year'] . '-' . sprintf("%02d", $row['month']) . "-$num', y: " . intval($row['items']) . ", z: " . intval($row['invoices']) . "},";
            $i++;
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