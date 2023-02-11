<style type="text/css">
    #nop:hover{
        transform: scale(4);
    }
    #nop{
        transform: scale(2);
    }
	.anulado{
		color: red;
	}
</style>
<div class="app-content content container-fluid">
    <div class="content-wrapper">
        <div id="notify" class="alert alert-success" style="display:none;">
            <a href="#" class="close" data-dismiss="alert">&times;</a>

            <div class="message"></div>
        </div>
        <div id="alertax">
            
        </div>
		
		<!-------- MENU PARA MOSTRAR ----->

        <div class="content-body">
            <section class="card">
                <div id="invoice-template" class="card-block">
                    <div class="row wrapper white-bg page-heading">
					
                        <div class="col-lg-12">
                            

                                <div class="btn-group ">
                                    <button type="button" class="btn btn-success btn-min-width dropdown-toggle"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i
                                                class="icon-print"></i> <?php echo $this->lang->line('Print Order') ?>
                                    </button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item"
                                           href="<?php echo 'printacta?id=' . $id_acta; ?>"><?php echo $this->lang->line('Print') ?></a>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item"
                                           href="<?php echo 'printacta?id=' . $id_acta; ?>&d=1"><?php echo $this->lang->line('PDF Download') ?></a>
										<div class="dropdown-divider"></div>
                                       
                                    </div>
                                </div>
                                <?php if($almacen_destino->id_tecnico->id==$this->aauth->get_user()->id && $acta->estado==null){ ?>
                                        <a href="#" class="btn btn-primary" id="recibir_material"><i
                                                    class="icon-earth"></i> Recibir Material
                                        </a>
                                <?php } ?>
									
                                						  
                           
							
							
                        </div>
                    </div>

                    <!-- Invoice Company Details -->
                    <div id="invoice-company-details" class="row mt-2">
                        <div class="col-md-6 col-sm-12 text-xs-center text-md-left"><p></p>
                            <img src="<?php echo base_url('userfiles/company/' . $this->config->item('logo')) ?>"
                                 class="img-responsive p-1 m-b-2" style="max-height: 120px;">

                        </div>
                        <div class="col-md-6 col-sm-12 text-xs-center text-md-right">
                            <h2>Acta de Transferencia de Material</h2>
                            <p class="pb-1"> <?php echo  "ACTA#". $id_acta . '</p>'?>
                            <p class="pb-1">Almacen Origen: <?=$almacen_origen->title ?></p>
                            <span > <?=$almacen_origen->extra ?></span>
                            <ul class="px-0 list-unstyled">
                                <li>Total Items</li>
                                <li class="lead text-bold-800" id="texto_ini_unidades"><?=count($lista_productos) ?> Und.</li>
                            </ul>
                        </div>
                    </div>
                    <!--/ Invoice Company Details -->

                    <!-- Invoice Customer Details -->
                    <div id="invoice-customer-details" class="row pt-2">
                        <div class="col-sm-12 text-xs-center text-md-left">
                            <p class="text-muted">Almacen Destino</p>
                        </div>
                        <div class="col-md-6 col-sm-12 text-xs-center text-md-left">
                            <ul class="px-0 list-unstyled">


                                
                                        <?php if($almacen_destino->id_tecnico!=null) { ?>
                                            <li class="text-bold-800">
                                                <a href="<?=base_url()."employee/view?id=".$almacen_destino->id_tecnico->id  ?>" class="invoice_a"><?=$almacen_destino->id_tecnico->name ?></a>
                                            </li>
                                            <li>
                                                <?=$almacen_destino->id_tecnico->city ?>
                                            </li>
                                            <li>
                                                CC: <?=$almacen_destino->id_tecnico->dto ?>
                                            </li>
                                            <li>
                                                Telefono: <?=$almacen_destino->id_tecnico->phone ?>
                                            </li>
                                            <li>
                                                Dir: <?=$almacen_destino->id_tecnico->address ?>
                                            </li>
                                        <?php }else{ ?>
                                            <a href="#" class="invoice_a"><?=$almacen_destino->title ?></a>
                                        <?php } ?>
                                
                                    
                                
                            </ul>

                        </div>
                        <div class="offset-md-3 col-md-3 col-sm-12 text-xs-center text-md-left">
                            <?php echo '<p><span class="text-muted">Fecha Elaboracion </span>: ' . (new DateTime($acta->fecha))->format("d-m-Y H:i:s") . '</p> ';
                            ?>
                        </div>
                    </div>
                    <!--/ Invoice Customer Details -->

                    <!-- Invoice Items Details -->
                    <div id="invoice-items-details" class="pt-2">
						<form method="post" id="data_form" class="form-horizontal">
                        <div class="row">
                            <div class="table-responsive col-sm-12">
                                <table class="table table-striped">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Nombre</th>
                                        <th class="text-xs-left">PID Origen</th>
                                        <th class="text-xs-left">PID Destino</th>
                                        <th class="text-xs-left">Cantidad Transferida</th>
                                        <th class="text-xs-left">Cantidad Total Prod. Destino</th>
                                        
                                        
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php $c = 1;$c_m=0;
                                    
                                    foreach ($lista_productos as $row) {
                                        
                                        echo '<tr>
<th scope="row">' . $c . '</th>
                            <td>' . $row->nombre_producto . '</td>
                           
                            <td>' .$row->pid_origen. '</td>
                             <td>' . $row->pid_destino . '</td>
                            <td>' . $row->cantidad_transferida . '</td>
                            <td>' . $row->cantidad_total. '</td>
                            
                            
                        </tr>';
                                        
                                        $c++;
                                        $c_m+=$row->cantidad_transferida;
                                    } ?>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <p></p>
                        <div class="row">
                            <div class="col-md-7 col-sm-12 text-xs-center text-md-left">


                                <div class="row">
                                    <div class="col-md-8">
                                       
                                        <p class="lead ">Descripción:</p>
                                        
                                            <?php echo $acta->observaciones; ?>
                                        
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-5 col-sm-12">
                                <p class="lead">Totales</p>
                                <div class="table-responsive">
                                    <table class="table" >
                                        <tbody>
                                         <tr>
                                            <td class="text-bold-800">Cantidad de Materiales Transferidos</td>
                                            <td class="text-bold-800 text-xs-right"> <?=$c_m ?> Und.</td>
                                        </tr>
                                        <tr class="bg-grey bg-lighten-4">
                                            <td class="text-bold-800">Cantidad de Items</td>
                                            <td class="text-bold-800 text-xs-right"> <?php 
                                                
                                                echo ' <span id="paydue">'.count($lista_productos).' Und.'.'</span></strong>'; ?></td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="text-xs-center  col-sm-6">
                                    <p><?php echo $this->lang->line('') ?>Generado por</p>
                                    <?php echo '<img src="'.base_url().'userfiles/employee_sign/' . $employee->sign . '" alt="signature" class="height-100"/>
                                    <h6>(' . $employee->name . ')</h6>
                                    <p class="text-muted">' . user_role($employee_aauth_users->roleid) . '</p>'; ?>
                                </div>
								
                            </div>
                        </div>
					</form>
                    </div>

                    <!-- Invoice Footer -->

                    
                    <!--/ Invoice Footer -->
                    <hr>
             
                    
                </div>
            </section>
        </div>
    </div>
</div>
<div id="modal_recibir" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Recibir</h4>
            </div>
            
            <div class="modal-body" id="emailbody" style="display: none;">
               <p>¿Estas seguro de realizar esta accion?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default"
                        data-dismiss="modal"><?php echo $this->lang->line('Close') ?></button>
                <button type="button" class="btn btn-primary"
                        id="sendM" onclick="recibir_metod()">Aceptar</button>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    var id_acta_var="<?=$id_acta ?>";
    $(document).on("click","#recibir_material",function(evt){
        evt.preventDefault();
        $("#modal_recibir").modal("show");
    });
    function recibir_metod(){
        $.post(baseurl+"actas/recibir_material",{'id':id_acta_var},function(data){
            $("#modal_recibir").modal("hide");
            mostrar_alerta1("alertax",1,"Material Recibido...");
            setTimeout(function (e) {
                            $("#recibir_material").hide();
                    },1000);
        });
    }
</script>
