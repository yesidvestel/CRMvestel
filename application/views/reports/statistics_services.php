 <div class="app-content content container-fluid">
 <div class="content-wrapper">
 <div class="content-body">


 <div class="row">
                <div class="col-xl-12 col-lg-12">
                    <div class="card">
                        <div class="card-header no-border">
                            <h4 style="text-align: center;" class="card-title">Usuarios por Estados <a class="float-xs-right"
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
							<div class="card-header no-border"><!-- ['y','z','a','b','c','d','e','f','g','h','i','j'] -->
								<h4 style="text-align: center;" class="card-title">Ocultar estados</h4>	
									<input type="checkbox" id="n_internet" style="cursor:pointer;" onclick="activar_desactivar_lines(null,'z');" class="case"><b style="cursor:pointer;" onclick="activar_desactivar_lines('n_internet','z');" ><i>&nbsp;Activos Internet&nbsp;</b></i>
									<input type="checkbox" id="n_tv" style="cursor:pointer;" onclick="activar_desactivar_lines(null,'a');" class="case"><b style="cursor:pointer;" onclick="activar_desactivar_lines('n_tv','a');"><i>&nbsp;Activos Television&nbsp;</b></i>
									<input type="checkbox" id="cor_int" style="cursor:pointer;" onclick="activar_desactivar_lines(null,'b');" class="case"><b style="cursor:pointer;" onclick="activar_desactivar_lines('cor_int','b');"><i>&nbsp;Cortados Internet&nbsp;</b></i>
									<input type="checkbox" id="cor_tv" style="cursor:pointer;" onclick="activar_desactivar_lines(null,'c');" class="case"><b style="cursor:pointer;" onclick="activar_desactivar_lines('cor_tv','c');"><i>&nbsp;Corte Television&nbsp;</b></i>
									<input type="checkbox" id="car_int" style="cursor:pointer;" onclick="activar_desactivar_lines(null,'d');" class="case"><b style="cursor:pointer;" onclick="activar_desactivar_lines('cor_tv','d');"><i>&nbsp;Cartera Internet&nbsp;</b></i>
									<input type="checkbox" id="car_tv" style="cursor:pointer;" onclick="activar_desactivar_lines(null,'e');" class="case"><b style="cursor:pointer;" onclick="activar_desactivar_lines('cor_tv','e');"><i>&nbsp;Cartera Television&nbsp;</b></i>
									<input type="checkbox" id="sus_int" style="cursor:pointer;" onclick="activar_desactivar_lines(null,'f');" class="case"><b style="cursor:pointer;" onclick="activar_desactivar_lines('sus_int','f');"><i>&nbsp;Suspensiones Internet&nbsp;</b></i>
									<input type="checkbox" id="sus_tv" style="cursor:pointer;" onclick="activar_desactivar_lines(null,'g');" class="case"><b style="cursor:pointer;" onclick="activar_desactivar_lines('sus_tv','g');"><i>&nbsp;Suspensiones Television&nbsp;</b></i>
									<input type="checkbox" id="ret_int" style="cursor:pointer;" onclick="activar_desactivar_lines(null,'h');" class="case"><b style="cursor:pointer;" onclick="activar_desactivar_lines('ret_int','h');"><i>&nbsp;Retirados Internet&nbsp;</b></i>
									<input type="checkbox" id="ret_tv" style="cursor:pointer;" onclick="activar_desactivar_lines(null,'i');" class="case"><b style="cursor:pointer;" onclick="activar_desactivar_lines('ret_tv','i');"><i>&nbsp;Retirados Television&nbsp;</b></i>
							</div>
                        </div>
						
                    </div>
                </div>
			
            </div>

       </div>
     </div>
			
   </div>

   <script type="text/javascript">
   	var lista_keys=[];
    var lista_labels_total={z:'Activos Internet',a:"Activos Television",b:"Cortados Internet",c:"Cortados Television",d:"Cartera Internet",e:"Cartera Television",f:"Sus. Internet",g:"Sus. Television",h:"Ret. Internet",i:"Ret. Television"};
    var lista_labels_personalizada=[];
$('#invoices-products-chart').empty();

var datos={
        element: 'invoices-products-chart',
        data: [
            <?php foreach ($lista_estadisticas as $key => $row) {
            $datex = new DateTime($row['fecha']);
            //$num = cal_days_in_month(CAL_GREGORIAN, $row['month'], $row['year']);
            echo "{ x: '".($datex->format("Y-m-d"))."',z: " . intval($row['n_internet']) . ",a: " . intval($row['n_tv']) .",b: " . intval($row['cor_int']) .",c: " . intval($row['cor_tv']) .",d: " . intval($row['car_int']) .",e: " . intval($row['car_int']) .",f: " . intval($row['sus_int']) .",g: " . intval($row['sus_tv']) .",h: " . intval($row['ret_int']) .",i: " . intval($row['ret_tv']) ."},";//,z: " . intval($tipos['instalaciones_tv'][$key]['numero']) . "
            
        } ?>

        ],
        xkey: 'x',
        ykeys: ['z','a','b','c','d','e','f','g','h','i'],
        labels: ['Activos Internet','Activos Television','Cortados Internet','Cortados Television','Car. Internet','Car. Television','Sus. internet','Sus. Television','Ret. Internet','Ret. Television'],
        hideHover: 'auto',
        resize: true,
        lineColors: ['#34cea7', '#ff6e40','#9A7D0A','#FFA633', '#FF7933','#FF3333','#33FFB8', '#33D3FF','#338AFF','#8033FF', '#C933FF','#FF33DA'],
        parseTime:false
    }
    Morris.Line(datos);
	   
	   function activar_desactivar_lines(ck,key){
		if(ck!=null){
			
			if($("#"+ck).prop("checked")){
				$("#"+ck).prop("checked",false);
			}else{
				$("#"+ck).prop("checked",true);
			}
		}
		var indice_elemento=lista_keys.indexOf(key);
		if(indice_elemento==-1){
			lista_keys.push(key);
		}else{
			lista_keys.splice(indice_elemento,1);
		}

		//console.log(lista_labels_total.a);
		lista_labels_personalizada=[];	
		$(lista_keys).each(function(index,dato){
			lista_labels_personalizada.push(lista_labels_total[dato]);
		});
		

		//console.log(lista_keys);
		datos.ykeys=lista_keys;
		datos.labels=lista_labels_personalizada;
		$('#invoices-products-chart').empty();
		Morris.Line(datos);

		
	}

   </script>