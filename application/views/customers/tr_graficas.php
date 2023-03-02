<article class="content">

    <div class="card card-block">
        

        <h4>Graficas de Trafico</h4>
        <hr>
        <script type="text/javascript" src="<?= base_url() ?>assets/js/highchart/js/highcharts.js"></script>
    <script type="text/javascript" src="<?= base_url() ?>assets/js/highchart/js/themes/gray.js"></script>

    <div id="container" style="min-width: 400px; height: 400px; margin: 0 auto"></div>
   
    <div id="trafico"></div>
    <p>GASTO TOTAL <br>
    <?=$datos_gasto['descarga'] ?><br>
    <?=$datos_gasto['subida'] ?>
</p>
    </div>

        
        
</article>
<script> 
    var chart;
    function requestDatta() {
        $.ajax({
            url: baseurl+'customers/ajax_graficas?id=<?=$_GET['id']  ?>',
            datatype: "json",
            success: function(data) {
                var midata = JSON.parse(data);
                if( midata.length > 0 ) {
                    var TX=parseInt(midata[0].data);
                    var RX=parseInt(midata[1].data);
                    var x = (new Date()).getTime(); 
                    shift=chart.series[0].data.length > 19;
                    chart.series[0].addPoint([x, TX], true, shift);
                    chart.series[1].addPoint([x, RX], true, shift);
                    document.getElementById("trafico").innerHTML=TX + " kb / " + RX+" kb";
                }else{
                    document.getElementById("trafico").innerHTML="- / -";
                }
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) { 
                console.error("Status: " + textStatus + " request: " + XMLHttpRequest); console.error("Error: " + errorThrown); 
            }       
        });
    }   

    $(document).ready(function() {
            Highcharts.setOptions({
                global: {
                    useUTC: false
                }
            });
    

           chart = new Highcharts.Chart({
               chart: {
                renderTo: 'container',
                animation: Highcharts.svg,
                type: 'spline',
                events: {
                    load: function () {
                        setInterval(function () {
                            requestDatta();
                        }, 1000);
                    }               
            }
         },
         title: {
            text: 'Monitoring'
         },
         xAxis: {
            type: 'datetime',
                tickPixelInterval: 150,
                maxZoom: 20 * 1000
         },
         yAxis: {
            minPadding: 0.2,
                maxPadding: 0.2,
                title: {
                    text: 'Trafico',
                    margin: 80
                }
         },
            series: [{
                name: 'Descarga',
                data: []
            }, {
                name: 'Carga',
                data: []
            }]
      });
  });
</script>