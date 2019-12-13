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

</script>

<div class="app-content content container-fluid">
    <div class="content-wrapper">
        <div class="content-header row">
        </div>
        <div class="content-body"><!-- stats -->
            <div class="row">
                <div class="col-xl-3 col-md-6 col-xs-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-block">
                                <div class="media">
                                    <div class="media-body text-xs-left">
                                        <h3 class="pink"> <?php echo $todayin ?></h3>
                                        <span><?php echo $this->lang->line('today') . $this->lang->line('invoices') ?></span>
                                    </div>
                                    <div class="media-right media-middle">
                                        <i class="icon-file-text2 pink font-large-2 float-xs-right"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6 col-xs-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-block">
                                <div class="media">
                                    <div class="media-body text-xs-left">
                                        <h3 class="teal"><?php echo $monthin ?></h3>
                                        <span><?php echo $this->lang->line('this') . $this->lang->line('month') . $this->lang->line('invoices') ?></span>
                                    </div>
                                    <div class="media-right media-middle">
                                        <i class="icon-paste teal font-large-2 float-xs-right"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6 col-xs-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-block">
                                <div class="media">
                                    <div class="media-body text-xs-left">
                                        <h3 class="deep-orange"><?php echo amountFormat($todaysales) ?> </h3>
                                        <span><?php echo $this->lang->line('today') . $this->lang->line('sales') ?></span>
                                    </div>
                                    <div class="media-right media-middle">
                                        <i class="icon-coin-dollar deep-orange font-large-2 float-xs-right"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6 col-xs-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-block">
                                <div class="media">
                                    <div class="media-body text-xs-left">
                                        <h3 class="cyan"><?php echo amountFormat($monthsales) ?> </h3>
                                        <span><?php echo $this->lang->line('this') . $this->lang->line('month') . $this->lang->line('sales') ?></span>
                                    </div>
                                    <div class="media-right media-middle">
                                        <i class="icon-briefcase2 cyan font-large-2 float-xs-right"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--/ stats -->
            <!--/ project charts -->
            <div class="row">
                <div class="col-xl-8 col-lg-12">
                    <div class="card">
                        <div class="card-header no-border">
                            <h6 class="card-title"><?php echo $this->lang->line('in_last _30') ?></h6>

                        </div>

                        <div class="card-body">


                            <div id="invoices-sales-chart"></div>

                        </div>
                        <div class="card-footer">
                            <div class="row">
                                <div class="col-xs-3 text-xs-center">
                                    <span class="text-muted"><?php echo $this->lang->line('today') . $this->lang->line('income') ?></span>
                                    <h4 class="block font-weight-normal"><?php echo amountFormat($todayinexp['credit']) ?></h4>
                                    <progress class="progress progress-xs mt-2 progress-success" value="100"
                                              max="100"></progress>
                                </div>
                                <div class="col-xs-3 text-xs-center">
                                    <span class="text-muted"><?php echo $this->lang->line('today') . $this->lang->line('expenses') ?></span>
                                    <h4 class="block font-weight-normal"><?php echo amountFormat($todayinexp['debit']) ?></h4>
                                    <progress class="progress progress-xs mt-2 progress-warning" value="100"
                                              max="100"></progress>
                                </div>
                                <div class="col-xs-3 text-xs-center">
                                    <span class="text-muted"><?php echo $this->lang->line('today') . $this->lang->line('sold') . $this->lang->line('products') ?></span>
                                    <h4 class="block font-weight-normal"><?php echo $todayitems ?></h4>
                                    <progress class="progress progress-xs mt-2 progress-light-blue" value="100"
                                              max="100"></progress>
                                </div>

                                <div class="col-xs-3 text-xs-center">
                                    <span class="text-muted"><?php echo $this->lang->line('revenue') ?></span>
                                    <h4 class="block font-weight-normal"><?php echo amountFormat($tt_inc - $tt_exp); ?></h4>
                                    <progress class="progress progress-xs mt-2 progress-indigo" value="100"
                                              max="100"></progress>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-6">
                    <div class="card card-inverse bg-info">

                        <div class="card-header">
                            <div class="header-block">
                                <h4 class="title">
                                    <?php echo $this->lang->line('income') . ' vs ' . $this->lang->line('expenses') ?>
                                </h4></div>
                        </div>
                        <div class="card-body">
                            <div id="salesbreakdown" class="card sameheight-item sales-breakdown"
                                 data-exclude="xs,sm,lg">
                                <div class="dashboard-sales-breakdown-chart" id="dashboard-sales-breakdown-chart"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--/ project charts -->
            <!-- Recent invoice with Statistics -->
            <div class="row match-height">
                <div class="col-xl-4 col-lg-6">

                    <div class="card">
                        <div class="card-header ">
                            <h4 class="card-title"><?php echo date('F Y');
                                echo ' ' . $this->lang->line('targets') ?></h4>

                        </div>
                        <div class="card-body">
                            <div class="media">
                                <div class="p-1 text-xs-center bg-light-blue media-left media-middle">
                                    <i class="icon-clubs font-large-2 white"></i>
                                </div>
                                <div class="p-1 media-body">
                                    <h5 class="light-blue">   <?php echo $this->lang->line('income') ?></h5>
                                    <h5 class="text-bold-400"><?php echo amountFormat($tt_inc) . '/' . amountFormat($goals['income']) ?></h5>
                                    <progress class="progress progress-striped progress-light-blue mt-1 mb-0"
                                              value="<?php $ipt = sprintf("%0.2f", ($tt_inc * 100) / $goals['income']);
                                              echo $ipt ?>" max="100"></progress>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <div class="media">
                                <div class="p-1 text-xs-center bg-orange media-left media-middle">
                                    <i class="icon-list-alt font-large-2 white"></i>
                                </div>
                                <div class="p-1 media-body">
                                    <h5 class="orange"> <?php echo $this->lang->line('expenses') ?></h5>
                                    <h5 class="text-bold-400"><?php echo amountFormat($tt_exp) . '/' . amountFormat($goals['expense']) ?></h5>
                                    <progress class="progress progress-striped progress-orange mt-1 mb-0"
                                              value="<?php $ipt = sprintf("%0.2f", ($tt_exp * 100) / $goals['expense']);
                                              echo $ipt; ?>" max="100"></progress>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <div class="media">
                                <div class="p-1 text-xs-center bg-success media-left media-middle">
                                    <i class="icon-bar-chart font-large-2 white"></i>
                                </div>
                                <div class="p-1 media-body">
                                    <h5 class="success"> <?php echo $this->lang->line('sales') ?></h5>
                                    <h5 class="text-bold-400"><?php echo amountFormat($monthsales) . '/' . amountFormat($goals['sales']) ?></h5>
                                    <progress class="progress progress-striped progress-success mt-1 mb-0"
                                              value="<?php $ipt = sprintf("%0.2f", ($monthsales * 100) / $goals['sales']);
                                              echo $ipt; ?>" max="100"></progress>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <div class="media">
                                <div class="p-1 text-xs-center bg-pink media-left media-middle">
                                    <i class="icon-money font-large-2 white"></i>
                                </div>
                                <div class="p-1 media-body">
                                    <h5 class="pink"> <?php echo $this->lang->line('net_income') ?></h5>
                                    <h5 class="text-bold-400"><?php echo amountFormat($tt_inc - $tt_exp);
                                        echo '/' . amountFormat($goals['netincome']) ?></h5>
                                    <progress class="progress progress-striped progress-pink mt-1 mb-0"
                                              value="<?php $ipt = sprintf("%0.2f", (($tt_inc - $tt_exp) * 100) / $goals['netincome']);
                                              echo $ipt; ?>" max="100"></progress>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-8 col-lg-12 ">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title"><?php echo $this->lang->line('recent_invoices') ?> <a
                                        href="<?php echo base_url() ?>invoices/create"
                                        class="btn btn-primary btn-sm rounded"><?php echo $this->lang->line('Add Sale') ?></a> <a
                                        href="<?php echo base_url() ?>invoices"
                                        class="btn btn-success btn-sm rounded"><?php echo $this->lang->line('Manage Invoices') ?></a>
                            </h4>
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
                                <table class="table table-hover">
                                    <thead>
                                    <tr>
                                        <th><?php echo $this->lang->line('Invoices') ?>#</th>
                                        <th><?php echo $this->lang->line('Customer') ?></th>
                                        <th><?php echo $this->lang->line('Status') ?></th>
                                        <th><?php echo $this->lang->line('Due') ?></th>
                                        <th><?php echo $this->lang->line('Amount') ?></th>
                                    </tr>
                                    </thead>
                                    <tbody class="table-bordered">
                                    <?php

                                    foreach ($recent as $item) {
                                        echo '<tr>
                                <td class="text-truncate"><a href="' . base_url() . 'invoices/view?id=' . $item['tid'] . '">#' . $item['tid'] . '</a></td>
                                <td class="text-truncate"> ' . $item['name'] . '</td>
                                <td class="text-truncate"><span class="tag tag-default st-' . $item['status'] . '">' . $this->lang->line(ucwords($item['status'])) . '</span></td>
                                <td class="text-truncate">' . dateformat($item['invoicedate']) . '</td>
                                <td class="text-truncate">' . amountFormat($item['total']) . '</td>
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
            <div class="row match-height">
                <div class="col-xl-8 col-md-8 col-sm-12">


                    <div class="card" style="height: 250px;" id="transactions">
                        <div class="card-header">
                            <h4 class="card-title"><?php echo $this->lang->line('cashflow') ?></h4>
                        </div>
                        <div class="card-body">
                            <div class="card-block">
                                <p><?php echo $this->lang->line('graphical_presentation') ?></p>
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

                <div class="col-xl-4 col-md-4 col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title"><?php echo $this->lang->line('task_manager') . ' ' ?> <a
                                        href="<?php echo base_url() ?>manager/todo"><i
                                            class="icon-arrow-right deep-orange"></i></a></h4>
                        </div>
                        <div class="card-body pt-1">


                            <?php foreach ($tasks as $row) {

                                if ($row['status'] == 'Done') {
                                    echo '<div class="form-group"><div class="input-group"><label class="display-inline-block custom-control custom-radio ml-1">
													<input value="' . $row['id'] . '" type="checkbox" class="checkbox custom-control-input" checked>
													<span class="custom-control-indicator"></span>
													<span class="custom-control-description ml-0">' . $row['name'] . '</span>
												</label></div><hr></div>
                        ';
                                } else {
                                    echo '<div class="form-group"><div class="input-group"><label class="display-inline-block custom-control custom-radio ml-1">
													<input value="' . $row['id'] . '" type="checkbox" class="checkbox custom-control-input">
													<span class="custom-control-indicator"></span>
													<span class="custom-control-description ml-0">' . $row['name'] . '</span>
												</label></div><hr></div>
                        ';
                                }

                            }
                            ?>


                        </div>
                    </div>
                </div>
            </div>
            <!--stock-->
            <div class="row match-height">

                <div class="col-xl-8 col-lg-12 ">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title"><?php echo $this->lang->line('recent') ?> <a
                                        href="<?php echo base_url() ?>transactions"
                                        class="btn btn-primary btn-sm rounded"><?php echo $this->lang->line('Transactions') ?></a>
                            </h4>
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
                                        <th><?php echo $this->lang->line('Date') ?>#</th>
                                        <th><?php echo $this->lang->line('Account') ?></th>
                                        <th><?php echo $this->lang->line('Debit') ?></th>
                                        <th><?php echo $this->lang->line('Credit') ?></th>

                                        <th><?php echo $this->lang->line('Method') ?></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php

                                    foreach ($recent_payments as $item) {
                                        echo '<tr>
                                <td class="text-truncate"><a href="' . base_url() . 'transactions/view?id=' . $item['id'] . '">' . dateformat($item['date']) . '</a></td>
                                <td class="text-truncate"> ' . $item['account'] . '</td>
                                <td class="text-truncate">' . $item['debit'] . '</td>
                                <td class="text-truncate">' . $item['credit'] . '</td>
                               
                                <td class="text-truncate">' . $this->lang->line($item['method']) . '</td>
                            </tr>';
                                    } ?>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-6">

                    <div class="card">
                        <div class="card-header ">
                            <h4 class="card-title"><?php echo $this->lang->line('Stock Alert') ?></h4>

                        </div>
                        <div class="card-body">
                            <ul class="list-group list-group-flush">

                                <?php

                                foreach ($stock as $item) {
                                    echo '<li class="list-group-item"><span class="tag tag-default tag-pill bg-danger float-xs-right">' . $item['qty'] . '</span> <a href="' . base_url() . 'products/edit?id=' . $item['pid'] . '">' . $item['product_name'] . '</a>
                                </li>';
                                } ?>

                            </ul>

                        </div>
                    </div>



                </div>
            </div>

        </div>
    </div>
</div>
<script type="text/javascript">


    $('#invoices-sales-chart').empty();

    Morris.Line({
        element: 'invoices-sales-chart',
        data: [
            <?php foreach ($countmonthlychart as $row) {
            echo "{ y: '" . $row['date'] . "', a: " . intval($row['total']) . ", b: " . intval($row['ttlid']) . "},";
        } ?>

        ],
        xkey: 'y',
        ykeys: ['a', 'b'],
        labels: ['<?php echo  $this->lang->line('Sales') ?>', '<?php echo  $this->lang->line('Invoices') ?>'],
        hideHover: 'auto',
        resize: true,
        lineColors: ['#34cea7', '#ff6e40', '#3e8ce7'],
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
            yLabelFormat: function (y) {
                // Only integers
                if (y === parseInt(y, 10)) {
                    return y;
                }
                else {
                    return '';
                }
            },
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
            yLabelFormat: function (y) {
                // Only integers
                if (y === parseInt(y, 10)) {
                    return y;
                }
                else {
                    return '';
                }
            },
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

    drawExpenseChart(dataVisits2);


    $('#dashboard-sales-breakdown-chart').empty();

    Morris.Donut({
        element: 'dashboard-sales-breakdown-chart',
        data: [{label: "<?php echo  $this->lang->line('Income') ?>", value: <?php echo intval($tt_inc); ?> },
            {label: "<?php echo  $this->lang->line('Expenses') ?>", value: <?php echo intval($tt_exp); ?> }
        ],
        resize: true,
        colors: ['#34cea7', '#ff6e40'],
        gridTextSize: 6,
        gridTextWeight: 400
    });

    $('a[data-toggle=tab').on('shown.bs.tab', function (e) {
        window.dispatchEvent(new Event('resize'));
      
    });


</script>