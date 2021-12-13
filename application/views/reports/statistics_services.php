 <div class="app-content content container-fluid">
 <div class="content-wrapper">
 <div class="content-body">


 <div class="row">
                <div class="col-xl-12 col-lg-12">
                    <div class="card">
                        <div class="card-header no-border">
                            <h4 style="text-align: center;" class="card-title">Servicios Activos <a class="float-xs-right"
                                                                                               href="<?php echo base_url() ?>reports/refresh_data?tipo=estadisticas_servicios"><i
                                class="icon-refresh2"></i></a></h4>
                             <div class="row">
				            	<div class="col-xl-12 col-lg-12"><!-- ['y','z','a','b','c','d','e','f','g','h','i','j'] -->
								
				            	</div>
				            </div>
                        </div>

                        <div class="card-body">


                            <div id="invoices-products-chart">

                            </div>

                        </div>

                    </div>
                </div>
			
            </div>

       </div>
     </div>
			
   </div>

   <script type="text/javascript">
   	
$('#invoices-products-chart').empty();

var datos={
        element: 'invoices-products-chart',
        data: [
            <?php foreach ($lista_estadisticas as $key => $row) {
            $datex = new DateTime($row['fecha']);
            //$num = cal_days_in_month(CAL_GREGORIAN, $row['month'], $row['year']);
            echo "{ x: '".($datex->format("Y-m-d"))."', y: " . intval($row['n_activo']) . ",z: " . intval($row['n_internet']) . ",a: " . intval($row['n_tv']) ."},";//,z: " . intval($tipos['instalaciones_tv'][$key]['numero']) . "
            
        } ?>

        ],
        xkey: 'x',
        ykeys: ['y','z','a'],
        labels: ['Activos','Internet','Tv'],
        hideHover: 'auto',
        resize: true,
        lineColors: ['#34cea7', '#ff6e40','#9A7D0A'],
        parseTime:false
    }
    Morris.Line(datos);

   </script>