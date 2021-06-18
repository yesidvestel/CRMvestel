<article class="content">
    <div class="card card-block">
        <div id="notify" class="alert alert-success" style="display:none;">
            <a href="#" class="close" data-dismiss="alert">&times;</a>

            <div class="message"></div>
        </div>
        <div class="grid_3 grid_4 animated fadeInRight table-responsive">
            <h5>Facturas Electronicas Customer</h5>
            <a style="color: white" class="btn btn-primary" onclick="openModal()" >Generar Factura Electronica</a>

            <hr>
            <table id="invoices" class="table-striped" cellspacing="0" width="100%">
                <thead>
                <tr> <th>#</th>
                    <th>id</th>
                    <th><?php echo $this->lang->line('Date') ?></th>
                    <th>Customer</th>
                    <th>Factura</th>
                    <th>Servicios Facturados</th>
                    <th><?php echo $this->lang->line('Amount') ?></th>
                  
                </tr>
                </thead>
                <tbody>
                </tbody>

                <tfoot>
                <tr> <th>#</th>
                    <th>id</th>
                    <th><?php echo $this->lang->line('Date') ?></th>
                    <th>Customer</th>
                    <th>Factura</th>
                    <th>Servicios Facturados</th>
                    <th><?php echo $this->lang->line('Amount') ?></th>
                </tr>
                </tfoot>
            </table>
        </div>
    </div>


</article>
<div id="generar_factura" class="modal fade">
    <div class="modal-dialog">
     <form id="" method="post" action="<?=base_url()?>facturasElectronicas/guardar">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                <h4 class="modal-bodytitle">Generar Factura Electronica</h4>
            </div>

            <div class="modal-body">
                
                <div class="form-group row">

                    <label class="col-sm-3 control-label"
                           for="sdate2">Fecha</label>

                    <div class="col-sm-4">
                        <input type="text" class="form-control required"
                               placeholder="Start Date" name="sdate" id="sdate2"
                                autocomplete="false" onclick="editar_z_index();" >
                    </div>

                </div>
                <div class="form-group row">

                    <label class="col-sm-3 control-label"
                           for="sdate2">Servicios</label>
                    <div  class="col-sm-9">
                    <select id="servicios" onchange="al_cambiar_de_servicio();" name="servicios" class="form-control">
                        <?php if($servicios['television']!="no"){ ?>
                        <option value="Television">Television</option>
                        <?php } ?>
                        <?php if($servicios['combo']!="no"){ ?>
                        <option value="Internet">Internet</option>
                        <?php } ?>
                        <?php if($servicios['combo']!="no" && $servicios['television']!="no"){ ?>
                        <option value="Combo">Combo</option>
                        <?php } ?>
                    </select>
                    </div>
                </div>
                
                <?php if($servicios['television']!="no") { ?>
                    <div class="form-group row" id="div_de_puntos">

                        <label class="col-sm-3 control-label"
                               for="sdate2">Puntos</label>
                        <div  class="col-sm-9">
                        <select id="puntos" name="puntos" class="form-control">
                            <option value="no">no</option>
                            <?php for ($i=1; $i <100 ; $i++) { ?>
                                <option value="<?=$i?>" <?= ($due['puntos']==$i) ? 'selected="true"':""?> ><?=$i?></option>
                            <?php  } ?>
                        </select>
                        </div>
                    </div>
                <?php } ?>
            </div>
            <div class="modal-footer">
                <input type="hidden" id="object-id" name="id" value="<?=$_GET['id']?>">
                <input type="hidden" id="action-url" value="facturasElectronicas/generar">
                <?php if($servicios['estado']!="Suspendido" || $servicios['estado']!="suspendido") {?>
                    <button type="submit"  class="btn btn-primary" >Generar</button>
                <?php } ?>
                <button type="button" data-dismiss="modal" class="btn">Cancel</button>
            </div>

        </div>
        </form>
        
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function () {

        var table = $('#invoices').DataTable({
            "processing": true,
            "serverSide": true,
            "order": [],
            "ajax": {
                "url": "<?php echo site_url('facturasElectronicas/ajax_list?id='.$_GET['id'])?>",
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
    function openModal(){
        $("#generar_factura").modal("show");
    }
    function editar_z_index(){
        $(".datepicker-container,datepicker-dropdown").css("z-index","5000");
    }
    function al_cambiar_de_servicio(){
        var elemento= $("#servicios option:selected").val();
        if(elemento=="Internet"){
            $("#div_de_puntos").hide();
        }else{
            $("#div_de_puntos").show();
        }

    }
</script>