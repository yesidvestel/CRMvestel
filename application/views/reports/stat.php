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
                                        <th><?php echo $this->lang->line('sold') . $this->lang->line('products') ?></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php

                                    foreach ($stat as $item) {
                                        // $month=date("F", $item['month']);


                                        $dateObj = DateTime::createFromFormat('!m', $item['month']);
                                        $month = $dateObj->format('F');
                                        echo '<tr>
                                <td class="text-truncate">' . $month . ', ' . $item['year'] . '</td>
                                <td class="text-truncate"> ' . $item['income'] . '</td>
                            
                                <td class="text-truncate">' . $item['expense'] . '</td>
                                 <td class="text-truncate">' . $item['sales'] . '</td>
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
<script type="text/javascript">


    $('#invoices-sales-chart').empty();

    Morris.Bar({
        element: 'invoices-sales-chart',
        data: [
            <?php $i = 0;foreach (array_reverse($stat) as $row) {
            if ($i > 11) exit;
            $num = cal_days_in_month(CAL_GREGORIAN, $row['month'], $row['year']);
            echo "{ x: '" . $row['year'] . '-' . sprintf("%02d", $row['month']) . "-$num', y: " . intval($row['income']) . ", z: " . intval($row['expense']) . "},";
            $i++;
        } ?>

        ],
        xkey: 'x',
        ykeys: ['y', 'z'],
        labels: ['Income', 'expense'],
        hideHover: 'auto',
        resize: true,
        barColors: ['#34cea7', '#ff6e40'],
    });


    $('#invoices-products-chart').empty();

    Morris.Line({
        element: 'invoices-products-chart',
        data: [
            <?php $i = 0;foreach (array_reverse($stat) as $row) {
            if ($i > 11) exit;
            $num = cal_days_in_month(CAL_GREGORIAN, $row['month'], $row['year']);
            echo "{ x: '" . $row['year'] . '-' . sprintf("%02d", $row['month']) . "-$num', y: " . intval($row['items']) . ", z: " . intval($row['invoices']) . "},";
            $i++;
        } ?>

        ],
        xkey: 'x',
        ykeys: ['y', 'z'],
        labels: ['Products', 'Invoices'],
        hideHover: 'auto',
        resize: true,
        lineColors: ['#34cea7', '#ff6e40'],
    });


</script>