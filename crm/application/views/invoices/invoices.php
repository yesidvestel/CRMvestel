<style type="text/css">
    .color_li{
        background-color:rgb(249, 249, 249);
        margin-bottom: 2px;
    }
</style>
<div class="app-content content container-fluid">
    <div class="content-wrapper">
        <div class="content-header row">
        </div>
        <div class="content-body">
            <?php if ($this->session->flashdata("messagePr")) { ?>
                <div class="alert alert-info">
                    <?php echo $this->session->flashdata("messagePr") ?>
                </div>
            <?php } ?>
            <div class="card card-block">
                <div class="box-header with-border">
                    <h3 class="box-title"><?php echo $this->lang->line('Invoices') ?></h3>
            <div class="card card-block">
                
                
                
                <div class="row m-t-lg">
                    <div class="col-md-1">
                    <strong>TOTAL</strong>
                    </div>
                    <div class="col-md-10" id="total_text">
                    
                    <?php 
                            setlocale(LC_MONETARY,"es_CO");
                            echo money_format("%.0n", ($due->total-$due->pamnt));
                    ?>
                    </div>
                </div>
            </div>
            <div class="card card-block" id="div_pag_efect">
                
                
                
                <button style="margin-bottom: 2px;" data-tbtn="1"  class="btn btn-warning pg"> <img width="150px" src="<?=base_url() ?>userfiles/efecty.png" ></button>
                <!--<button data-tbtn="2" class="btn btn-info pg"> <img width="150px" src="<?=base_url()  ?>userfiles/logo_baloto.png"></button>-->
                 <button data-tbtn="3" class="btn btn-info pg" > <img width="100%" src="<?=base_url()  ?>userfiles/Pago-Online-PSE.png"></button>

            </div><div class="table-responsive">
                    
                    <table id="invoices" class="cell-border example1 table table-striped table1 delSelTable table-hover" cellspacing="0" width="100%">
                        <thead>
                        <tr>

                            <th><?php echo $this->lang->line('No') ?></th>
                            <th>#</th>
                            <th><?php echo $this->lang->line('customer') ?></th>
                            <th><?php echo $this->lang->line('Date') ?></th>
                            <th><?php echo $this->lang->line('Amount') ?></th>
                            <th  class="no-sort"><?php echo $this->lang->line('Status') ?></th>
                            <th class="no-sort"><?php echo $this->lang->line('Settings') ?></th>

                        </tr>
                        </thead>
                        <tbody>
                        </tbody>

                        <tfoot>
                        <tr>
                            <th><?php echo $this->lang->line('No') ?></th>
                            <th>#</th>
                            <th><?php echo $this->lang->line('customer') ?></th>
                            <th><?php echo $this->lang->line('Date') ?></th>
                            <th><?php echo $this->lang->line('Amount') ?></th>
                            <th  class="no-sort"><?php echo $this->lang->line('Status') ?></th>
                            <th class="no-sort"><?php echo $this->lang->line('Settings') ?></th>
                        </tr>
                        </tfoot>
                    </table>
                </div>
                </div>
            </div>
        </div>


    </div>
</div>
<div id="modal_refer" class="modal fade" >
    <div class="modal-dialog modal-lg">
        <div class="modal-content" >
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"> Referencia de pago </h4>
            </div>

            <div class="modal-body" >
               <iframe id="pag_refer" width="100%" height="100%" src="">
                   
               </iframe>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default"
                        data-dismiss="modal"><?php echo $this->lang->line('Close') ?> </button>
                <button data-dismiss="modal" type="button" class="btn btn-primary"
                        id="sendNow">Aceptar </button>
            </div>
        </div>
    </div>
</div>
<div id="modal_pse" class="modal fade" >
    <div class="modal-dialog modal-lg">
        <div class="modal-content" >
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"> PSE </h4>
            </div>

            <div class="modal-body" >
               <img src="<?=base_url() ?>userfiles/top_pse.png" width="100%">
               <table>
                   <tr>
                       <td></td>
                       <td><ol ><li class="color_li">Todas la compras y pagos por PSE son realizados en linea y la confirmacion es inmediata</li><li class="color_li">Algunos bancos tienen un procedimiento de autenticacion en su pagina (por ejemplo, una segunda clave), es posible que necesites tramitar una autorizacion ante tu banco. si tienes dudas contacta con nosotros o directamente al area de atencion al cliente de tu banco.</li></ol></td>
                       <td></td>
                   </tr>
                   
               </table>
               <div align="center">
               <div style="width: 50%;">
               <div class="row">
                           <div class="form group"  >
                               <label class="col-sm-3 control-label" for="pse_bank">Banco * &nbsp;</label>
                               <div class="col-sm-9">
                                    <select id="pse_bank" class="form-control">
                                        <option>1</option>
                                        <option>1</option>
                                    </select>
                               </div>
                           </div>
                           </div>
                           </div>
                           </div>
               <table align="center">
                   <tr>
                       
                       <td >
                        
                       </td>
                       
                   </tr>
               </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default"
                        data-dismiss="modal"><?php echo $this->lang->line('Close') ?> </button>
                <button data-dismiss="modal" type="button" class="btn btn-primary"
                        id="sendNow">Aceptar </button>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function () {

        var table = $('#invoices').DataTable({
            "processing": true,
            "serverSide": true,
            "order": [],
            "ajax": {
                "url": "<?php echo site_url('invoices/ajax_list')?>",
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
    function abrir_modal(){
            var px=window.innerHeight;
            px=px-195;
             px=px+"px";
            console.log(px);
            $("#pag_refer").attr("height",px);
            
            $("#modal_refer").modal("show");//
    }
    $(document).on("click",".pg",function(event){
            var tbtn=$(this).data("tbtn");
            if(tbtn=="3"){
                    $("#modal_pse").modal("show");
            }else{
                $(".pg").attr("disabled","disabled");
            
                $.post(baseurl+"payments/pg_ef",{"a1":tbtn},function(data){
                    if(data.status=="SUCCESS"){
                        $("#div_pag_efect").append("<h3>Si cerraste la referencia de pago abrela nuevamente <button class='btn btn-primary' onclick='abrir_modal();'>AQUI</button> o dirigete directamente a este link : <a href='"+data.url+"'>"+data.url+"</a></h3>");
                        $("#pag_refer").attr("src",data.url);
                        abrir_modal();
                    }else{
                        alert("Ocurrio un error informa a VESTEL POR FAVOR");
                    }
                },'json');
            }

    });
</script>
