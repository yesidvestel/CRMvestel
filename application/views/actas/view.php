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
                                           href="<?php echo 'printinvoice?id=' . $invoice['tid']; ?>"><?php echo $this->lang->line('Print') ?></a>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item"
                                           href="<?php echo 'printinvoice?id=' . $invoice['tid']; ?>&d=1"><?php echo $this->lang->line('PDF Download') ?></a>
										<div class="dropdown-divider"></div>
                                        <a class="dropdown-item"
                                           href="<?php echo 'recibido?id=' . $invoice['tid']; ?>"><?php echo $this->lang->line('') ?>Recibidos</a>
                                    </div>
                                </div>
									
                                						  
                           
							
							
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
                                    <?php echo '<img src="' . FCPATH . 'userfiles/employee_sign/' . $employee->sign . '" alt="signature" class="height-100"/>
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
             
                    <div class="row">
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th><?php echo $this->lang->line('Files') ?></th>


                            </tr>
                            </thead>
                            <tbody id="activity">
                            <?php foreach ($attach as $row) {

                                echo '<tr><td><a data-url="' . base_url() . 'purchase/file_handling?op=delete&name=' . $row['col1'] . '&invoice=' . $invoice['tid'] . '" class="aj_delete"><i class="btn-danger btn-lg icon-trash-a"></i></a> <a class="n_item" href="' . base_url() . 'userfiles/attach/' . $row['col1'] . '"> ' . $row['col1'] .'/'.$row['col2'] . ' </a></td></tr>';
                            } ?>

                            </tbody>
                        </table>
                        <!-- The fileinput-button span is used to style the file input field as button -->
                        <span class="btn btn-success fileinput-button">
							<div id="customerpanel" class="form-group row">
								<label for="toBizName"
									   class="caption col-sm-2 col-form-label">Tipo de comprobante<span
											style="color: red;">*</span></label>                    
								<div class="col-sm-12">
									<select name="comprobante" class="form-control" id="comprobante">
										<option value="Pago">Pago</option>
										<option value="Recibido">Recibido</option>                      
									</select>
								</div>

							</div>
							<i class="glyphicon glyphicon-plus"></i>
							<span>Select files...</span>
												<!-- The file input field used as target for the file upload widget -->
							<input id="fileupload" type="file" name="files[]" multiple>
						</span>
                        <br>
                        <pre>Allowed: gif, jpeg, png, docx, docs, txt, pdf, xls </pre>
                        <br>
                        <!-- The global progress bar -->
                        <div id="progress" class="progress">
                            <div class="progress-bar progress-bar-success"></div>
                        </div>
                        <!-- The container for the uploaded files -->
                        <table id="files" class="files"></table>
                        <br>
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>
<script src="<?php echo base_url('assets/myjs/jquery.ui.widget.js') ?>"></script>
<script src="<?php echo base_url('assets/myjs/jquery.fileupload.js') ?>"></script>
<script>
	//universal create

    /*jslint unparam: true */
    /*global window, $ */
    //$(function () {
        'use strict';
        // Change this to the location of your server-side upload handler:
		var comprobante=$("#comprobante option:selected").val();
        
        var url = '<?php echo base_url() ?>purchase/file_handling?comprobante='+comprobante+'&id=<?php echo $id_acta ?>';
        $('#fileupload').fileupload({
            url: url,
            dataType: 'json',
            done: function (e, data) {
                $.each(data.result.files, function (index, file) {
                    $('#files').append('<tr><td><a data-url="<?php echo base_url() ?>purchase/file_handling?op=delete&name=' + file.name + '&invoice=<?php echo $id_acta ?>" class="aj_delete"><i class="btn-danger btn-sm icon-trash-a"></i> ' + file.name + ' </a></td></tr>');

                });
            },
            progressall: function (e, data) {
                var progress = parseInt(data.loaded / data.total * 100, 10);
                $('#progress .progress-bar').css(
                    'width',
                    progress + '%'
                );
            }
        }).prop('disabled', !$.support.fileInput)
            .parent().addClass($.support.fileInput ? undefined : 'disabled')
        .bind('fileuploadadd', function (e, data) {
            var comprobante=$("#comprobante option:selected").val();
            data.url = '<?php echo base_url() ?>purchase/file_handling?comprobante='+comprobante+'&id=<?php echo $id_acta ?>';
            
    });
    //});

    $(document).on('click', ".aj_delete", function (e) {
        e.preventDefault();

        var aurl = $(this).attr('data-url');
        var obj = $(this);

        jQuery.ajax({

            url: aurl,
            type: 'GET',
            dataType: 'json',
            success: function (data) {
                obj.closest('tr').remove();
                obj.remove();
            }
        });

    });
</script>




<!-- cancel -->







</script>
