<article class="content">
    <div class="card card-block">
        <div id="notify" class="alert alert-success" style="display:none;">
            <a href="#" class="close" data-dismiss="alert">&times;</a>

            <div class="message"></div>
        </div>
        <div class="grid_3 grid_4">
            <div class="header-block">
                <h3 class="title">
                    <?php echo $this->lang->line('Support Tickets') ?>
                </h3></div>


            <p>&nbsp;</p>
            <div class="row">
                <div class="col-xl-3 col-lg-6 col-xs-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-block">
                                <div class="media">
                                    <div class="media-body text-xs-left">
                                        <h3 class="pink" id="dash_0"></h3>
                                        <span><?php echo $this->lang->line('Waiting') ?></span>
                                    </div>
                                    <div class="media-right media-middle">
                                        <i class="icon-clock3 pink font-large-2 float-xs-right"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-6 col-xs-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-block">
                                <div class="media">
                                    <div class="media-body text-xs-left">
                                        <h3 class="indigo" id="dash_1"></h3>
                                        <span><?php echo $this->lang->line('Processing') ?></span>
                                    </div>
                                    <div class="media-right media-middle">
                                        <i class="icon-spinner5 indigo font-large-2 float-xs-right"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-6 col-xs-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-block">
                                <div class="media">
                                    <div class="media-body text-xs-left">
                                        <h3 class="green" id="dash_2"></h3>
                                        <span><?php echo $this->lang->line('Solved') ?></span>
                                    </div>
                                    <div class="media-right media-middle">
                                        <i class="icon-clipboard2 green font-large-2 float-xs-right"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-6 col-xs-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-block">
                                <div class="media">
                                    <div class="media-body text-xs-left">
                                        <h3 class="deep-cyan"><?php echo $totalt ?></h3>
                                        <span><?php echo $this->lang->line('Total') ?></span>
                                    </div>
                                    <div class="media-right media-middle">
                                        <i class="icon-stats-bars22 deep-cyan font-large-2 float-xs-right"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
			 
			<div class="table-responsive">
            <table class="table table-hover" cellspacing="0" width="100%">
                <thead>
                <tr>
					<th>#</th>					
					<th>N° orden</th>	
                    <th><?php echo $this->lang->line('Subject') ?></th>
					<th>Detalle</th>
                    <th>F/creada</th>                    
					<th>Abonado</th>
					<th>Usuario</th>                    
					<th>Estado</th>
                    <th>Accion</th>
					

                </tr>
                </thead>
                <tbody id="entries">
				
                </tbody>

            </table>
			</div>
			 <div class="col-md-12">
			<h6 class="colspan 1">ASIGNAR ORDEN</h6>
			</div>
			<div class="col-xs-3 mb-1">
			<select name="asignado" id="tecnicos" class="form-control mb-1">
				<?php
					foreach ($tecnicoslista as $row) {
						$cid = $row['id'];
						$title = $row['username'];
						echo "<option value='$cid'>$title</option>";
					}
					?>
			</select>
				</div>
			<div class="col-xs-2 mb-1">
				<input type="hidden" id="action-url" value="tickets/update_status">
                        <button type="button" class="btn btn-primary"
                                onclick="asignar_tecnico()">Asignar</button>
			</div>
			
			</div>
        </div>
    </div>
    <input type="hidden" id="dashurl" value="tickets/ticket_stats">
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
                <p><?php echo $this->lang->line('delete this ticket') ?></p>
            </div>
            <div class="modal-footer">
                <input type="hidden" id="object-id" value="">
                <input type="hidden" id="action-url" value="tickets/delete_ticket">
                <button type="button" data-dismiss="modal" class="btn btn-primary"
                        id="delete-confirm"><?php echo $this->lang->line('Delete') ?></button>
                <button type="button" data-dismiss="modal"
                        class="btn"><?php echo $this->lang->line('Cancel') ?></button>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function () {

        $('#entries').html('<td class="text-lg-center" colspan="5">Data loading...</td>');

        $.ajax({

            url: baseurl + 'tickets/statements',
            type: 'POST',
            data: <?php echo "{'ac': '" . $filter[0] . "','ty':'" . $filter[1] . "'}"; ?>,
            dataType: 'html',
            success: function (data) {
                $('#entries').html(data);

            },
            error: function (data) {
                $('#response').html('Error')
            }

        });
    });
    let lista_ordenes=[];
    function asignar_orden(elemento){
        var indice_elemento=lista_ordenes.indexOf($(elemento).data("id"));
        
        if(indice_elemento==-1){
                if(elemento.checked==true){
                    lista_ordenes.push($(elemento).data("id"));                   
                }
        }else{
            if(elemento.checked==false){
                lista_ordenes.splice(indice_elemento,1);
            }
        }
    }

    $("#doctable").on('draw.dt',function (){
        $(lista_ordenes).each(function(index,value){
            var checked_seleccionado=document.getElementById("input_"+value);            
            try{
                if(checked_seleccionado.checked==false){
                        console.log("si esta imprimiendo todo esta bien Gloria Al Dios Altisimo Jesus de Nazaret.");
                        $(checked_seleccionado).prop("checked",true);

                }
            }catch(error){

            }
            
        });

    });
    function asignar_tecnico (){
        var id_tecnico_seleccionado=$("#tecnicos").val();
        $.post(baseurl+"tickets/asignar_ordenes",{id_tecnico_seleccionado:id_tecnico_seleccionado,lista:lista_ordenes},function(data){

                if(data=="correcto"){
                    var url1=baseurl+"tickets/";
                    window.location.replace(url1);
                }
        });
    }
    function eliminar_ticket(id){
        var confirmacion = confirm("Deseas Eliminar esta orden ?");
        if(confirmacion==true){
            $.post(baseurl+"tickets/delete_ticket",{deleteid:id},function (data){
                alert("Orden Eliminada...");                
                window.location.reload();
            },'json');
      }
    }
</script>
