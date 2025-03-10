<script async defer
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCPGQt8yWSDFWFAM7XIZPc-Q3M59nj6yeY">
</script>
<style>
.contenedor{
    position: relative;
    display: inline-block;
    text-align: center;
	width: 80%;	
    top: 10%;
    left: 10%;
}
.texto-encima{
    position: absolute;
    top: 10px;
    left: 10px;
}
.centrado{
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
	color: aliceblue;
	font-size: 30px;
	font-family: impact;
}
.centrado2{
    position: absolute;
    top: 60%;
    left: 60%;
    transform: translate(-50%, -50%);
	color: aliceblue;
	font-size: 20px;
	font-family: impact;
}

</style>
<article class="content">
    <div class="card card-block">
        <div id="notify" class="alert alert-success" style="display:none;">
            <a href="#" class="close" data-dismiss="alert">&times;</a>

            <div class="message"></div>
        </div>
        <div class="grid_3 grid_4">
            <div class="header-block">
                <!--h3 class="title"-->
				<label>
                    <?php echo  'Lista de Naps, <strong>VLAN ' .$vlan. '</strong>, almacen <strong>' .$almacen ?>
                 </label>       
                <!--/h3--></div>
			<?php foreach ($naps as $row) { 
					$cid = $row['nap']; ?>
			<a href="#" class="open_modal"  data-nap="<?=$row['idn']?>" data-id-equipo="<?=$row['idn'] ?>">
			<div class="col-xl-2 col-md-4 col-xs-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-block">
                                <div class="media">
                                    <div class="media-body text-xs-left">
										
                                        <img alt="image" id="dpic" class="img-responsive contenedor"
                                     src="<?php echo base_url('userfiles/attach/nap.png') ?>">
										<h5 style="position: absolute" class="centrado"><?php echo $cid ?></h5>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
				<?php }; ?>
           </a>
        </div>
    </div>
    
</article>
<article class="content">
    <div class="card card-block">
        <div id="map2" style="width: 100%; height: 450px;"></div>
    </div>
</article>
<div id="delete_model" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><?php echo $this->lang->line('Delete') ?></h4>
            </div>
            <div class="modal-body">
                <p><?php echo $this->lang->line('delete this document') ?></p>
            </div>
            <div class="modal-footer">
                <input type="hidden" id="object-id" value="">
                <input type="hidden" id="action-url" value="tools/delete_document">
                <button type="button" data-dismiss="modal" class="btn btn-primary"
                        id="delete-confirm"><?php echo $this->lang->line('Delete') ?></button>
                <button type="button" data-dismiss="modal"
                        class="btn"><?php echo $this->lang->line('Cancel') ?></button>
            </div>
        </div>
    </div>
</div>
<div id="pop_model" class="modal fade">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="titulo_modal1">Disponibilidad de puertos</h4>
            </div>			
            <div class="modal-body">
                <form id="form_model">
					<div class="form-group row">						
                    
                        <div>
							
							<table align="center" width="100%" border="1">
							<tr>
							<td colspan="16" align="center"><img alt="image" id="dpic" class="img-responsive"
                                     src="<?php echo base_url('userfiles/attach/napaabierta2.png') ?>"></td>	
							</tr>
							<tr id="bloque_puertos">
								<a style="text-align: center;font-size: 10px"></a>
							</tr>
                           
							</table>
							<table  align="center" width="100%" border="1">
                                 <tr>
                                <td>
                                    

                                    <div id="map" style="width: 100%; height: 450px;"></div>
                                    <a id="btn_maps" href="https://www.google.com/maps/search/?api=1&query=" target="_blank" class="btn btn-primary"><i class="icon-ios-location"></i>Abrir en Maps<i class="icon-ios-location"></i></a>
                                </td>

                            </tr>                     
                            </table>
                    	
                        </div>
                    
						
				</div>
                </div>
					
                </form>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
	
	$(document).on("click",'.open_modal',function(e){
		e.preventDefault();
		var nat =$(this).data("nap");
        var id_equipo =$(this).data("id-equipo");
		$.post(baseurl+"redes/get_puertos_html",{"nat":nat,"id_equipo":id_equipo},function(data){
			$("#bloque_puertos").html(data.datos);
            $("#titulo_modal1").text("Disponibilidad de puertos, nat N°"+nat);
            if(data.coor1!=null){
                $('#btn_maps').attr('href', 'https://www.google.com/maps/search/?api=1&query='+data.coor1+','+data.coor2);

                initMap(Number(data.coor1),Number(data.coor2));    
                $("#map").show();
                $("#btn_maps").show();
            }else{
                $("#map").hide();
                $("#btn_maps").hide();
            }
            
		},'json');
		$("#pop_model").modal("show");
	});
    $(document).ready(function () {
        initMap2();
        $('#doctable').DataTable({

            "processing": true,
            "serverSide": true,
            "ajax": {
                "url": "<?php echo site_url('tools/document_load_list')?>",
                "type": "POST"
            },
            "columnDefs": [
                {
                    "targets": [0],
                    "orderable": false,
                },
            ],

        });

    });

    function initMap2(){
          


  <?php $naps_cor=false;foreach ($naps as $key => $np) { ?>
            <?php if($naps_cor==false && $np['coor1']!=null ) { ?>

              var myLatLng1 = { lat: Number(<?=$np['coor1']?>), lng: Number(<?=$np['coor2']?>) }; // Reemplaza con tus coordenadas
              const map2 = new google.maps.Map(document.getElementById('map2'), {
                zoom: 13,
                center: myLatLng1,
              });
              var market= new google.maps.Marker({
                position: myLatLng1,
                map: map2,
              });
              var infowindow = new google.maps.InfoWindow({
                                    content: 'NAP <?=$np["idn"] ?>-<?=$np["nap"] ?>',
                                  });
            market.addListener('click', () => {
                infowindow.open(map2, market);
              });


          <?php $naps_cor=true;
                }else if($naps_cor && $np['coor1']!=null){?>
                         myLatLng1 = { lat: Number(<?=$np['coor1']?>), lng: Number(<?=$np['coor2']?>) }; // Reemplaza con tus coordenadas
                          // Agrega un marcador en la ubicación

                         var market<?=$np["idn"]?>= new google.maps.Marker({
                            position: myLatLng1,
                            map: map2,
                          });

                         var infowindow<?=$np["idn"]?> = new google.maps.InfoWindow({
                                    content: 'NAP <?=$np["idn"] ?>-<?=$np["nap"] ?>',
                                  });
                        market<?=$np["idn"]?>.addListener('click', () => {
                            infowindow<?=$np["idn"]?>.open(map2, market<?=$np["idn"]?>);
                          });


          <?php } ?>

    <?php } ?>


    }

    function initMap(lat1,lng1) {
  const myLatLng = { lat: lat1, lng: lng1 }; // Reemplaza con tus coordenadas
  const map = new google.maps.Map(document.getElementById('map'), {
    zoom: 15,
    center: myLatLng,
  });

  // Agrega un marcador en la ubicación
  new google.maps.Marker({
    position: myLatLng,
    map: map,
  });
/* // codigo para agregar mas puntos al mismo mapa esto para colocar todas las naps de cada ciudad en un solo mapa
   const myLatLng2 = { lat: 5.720472, lng: -72.924639 }; // Reemplaza con tus coordenadas
  // Agrega un marcador en la ubicación
  new google.maps.Marker({
    position: myLatLng2,
    map: map,
  });*/
}
</script>
