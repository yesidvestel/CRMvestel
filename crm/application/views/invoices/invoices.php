<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<style type="text/css">
    .color_li{
        background-color:rgb(249, 249, 249);
        margin-bottom: 2px;
        text-align: justify-all;
    }
    .label_pse{
        text-align: left;
    }
    .row_pse{
        /*margin-bottom: 10px;*/
    }
    #pse_terms{
        transform: scale(1.5);
        cursor: pointer;
    }
    #pse_terms:hover{
        transform: scale(3);
    }
   
.select2-selection__rendered {
    line-height: 80px !important;
}
.select2-container .select2-selection--single {
    height: 80px !important;
}
.select2-selection__arrow {
    height: 80px !important;
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
            <form method="post" action="#" id="form_pse">
               <div align="center">
               <div style="width: 70%;">
                    <div class="row row_pse"  >
                           <div class="form group"  >
                               <label class="col-sm-3 control-label label_pse" for="pse_bank">Banco* &nbsp;</label>
                               <div class="col-sm-9">
                                    <select id="pse_bank" name="pse_bank" style="width:100%" class="select-box form-control" required>
                                        
                                        <?php foreach ($list_banks as $key => $value): ?>

                                                <option data-image="<?= ($value->pseCode==0) ? '':base_url() .'userfiles/'.$value->pseCode.'.png' ?>" value="<?= ($value->pseCode==0) ? '':$value->pseCode ?>"><?= ($value->pseCode==0) ? 'Selecciona una opcion...':$value->description ?></option>
                                        <?php endforeach ?>
                                    </select>
                               </div>
                           </div>
                    </div>
                    <div class="row row_pse">
                           <div class="form group"  >
                               <label class="col-sm-3 control-label label_pse" for="pse_person_type">Tipo de persona* &nbsp;</label>
                               <div class="col-sm-9">
                                    <select id="pse_person_type" name="pse_person_type" class="form-control">
                                            <option value="N">Natural</option>
                                            <option value="J">Jurídica</option>
                                    </select>
                               </div>
                           </div>
                    </div>
                    <div class="row row_pse">
                           <div class="form group"  >
                               <label class="col-sm-3 control-label label_pse" for="pse_documnet_type">Documento* &nbsp;</label>
                               <div class="col-sm-5">
                                    <select id="pse_documnet_type" name="pse_documnet_type" class="form-control" required>
                                            <option value="CC">CC - Cédula de ciudadanía.</option>
                                            <option value="CE">CE - Cédula de extranjería.</option>
                                            <option value="NIT">NIT - Número de Identificación Tributaria (Empresas).</option>
                                            <option value="TI">TI - Tarjeta de identidad.</option>
                                            <option value="PP">PP - Pasaporte.</option>
                                            <option value="IDC">IDC - Identificador único de cliente, para el caso de ID’s únicos de clientes/usuarios de servicios públicos.</option>
                                            <option value="CEL">CEL - En caso de identificarse a través de la línea del móvil.</option>
                                            <option value="RC">RC - Registro civil de nacimiento.</option>
                                            <option value="DE">DE - Documento de identificación extranjero.</option>
                                    </select>
                               </div>
                               <div class="col-sm-4">
                                    <input required type="tel" maxlength="30" placeholder="Numero de documento" name="pse_doc" id="pse_doc" class="form-control">
                               </div>
                           </div>
                    </div>
                    <div class="row row_pse">
                           <div class="form group"  >
                               <label class="col-sm-3 control-label label_pse" for="pse_telefono">Celular* &nbsp;</label>
                               <div class="col-sm-9">
                                    <input required type="tel" placeholder="Celular" name="pse_telefono" id="pse_telefono" class="form-control">
                               </div>
                           </div>
                    </div>
                    <div class="row row_pse">
                           <div class="form group"  >
                               <label class="col-sm-3 control-label label_pse" for="pse_correo">Correo* &nbsp;</label>
                               <div class="col-sm-9">
                                    <input required type="email" placeholder="Correo" name="pse_correo" id="pse_correo" class="form-control">
                               </div>
                           </div>
                    </div>
                    <div class="row row_pse">
                           <div class="form group"  >
                               <label class="col-sm-3 control-label label_pse" for="pse_terms"></label>
                               <div class="col-sm-9">
                                    Aceptar terminos, condiciones y tratamiento de tus datos*
                                    <input required type="checkbox" name="pse_terms" id="pse_terms" class="form-control">
                               </div> 
                           </div>
                    </div>
                    <br>
                    <div class="row row_pse">
                           <div class="form group"  >
                               <label class="col-sm-3 control-label label_pse" for="pse_bank"></label>
                               <div class="col-sm-9">
                                    <button id="btn_pse_sub" type="submit" class="btn btn-lg btn-success"><img width="10%" src="<?=base_url()  ?>userfiles/Pay-PNG-HD.png">Pagar<img width="10%" src="<?=base_url()  ?>userfiles/Pay-PNG-HD.png"></button>
                               </div>
                           </div>
                    </div>
               </div>
               </div>
               </form>
               
            </div>
            <div class="modal-footer">
                
                <button data-dismiss="modal" type="button" class="btn btn-primary"
                        id="sendNow">Salir</button>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    var intests=0;
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
        $("#pse_doc").mask('#.##0', {reverse: true});
        $("#pse_telefono").mask('(000) 000-0000');

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
                        alert("Ocurrio un error informa a VESTEL POR FAVOR , "+data.message);
                    }
                },'json');
            }

    });
    
    $(document).on("submit","#form_pse",function(e){
        e.preventDefault();
        if(intests==0){
            //console.log("hola mundo");
            var data_form=$("#form_pse").serialize();
            $.post(baseurl+"payments/pse_reseption",data_form,function(data){
                    if(data.status=="SUCCESS"){
                        $("#modal_pse").modal("hide");
                        $("#div_pag_efect").append("<h3>Si no fuiste redirigido dirigete directamente este link para finalizar el proceso de pago : <a href='"+data.url+"'>"+data.url+"</a></h3>");
                        $("#pag_refer").attr("src",data.url);
                        window.location.href =data.url;
                        //abrir_modal();
                    }else{
                        alert("Ocurrio un error informa a VESTEL POR FAVOR");
                    }
            },'json');  
            intests++;  
            $("#btn_pse_sub").attr("disabled","disabled");
        }else{

            console.log("no mas intenst")
        }
        
    });

$("#pse_bank").select2(
{
    templateResult: formState,
    templateSelection: formState,
    
}
);
function formState(opt){

    if(!opt.id){
        return opt.text.toUpperCase();
    }
    var optimage=$(opt.element).attr('data-image');
    console.log(optimage);
    if(!optimage){
        return opt.text.toUpperCase();
    }else{
        var $opt=$('<span><img src="'+optimage+'" width="57px" />&nbsp;&nbsp;'+opt.text.toUpperCase()+'</span>');
        return $opt
    }


}


</script>
