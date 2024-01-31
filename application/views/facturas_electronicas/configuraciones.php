<link rel="stylesheet" href="<?=base_url()?>assets/css/jquery.lineProgressbar.css">
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-cookie/1.4.1/jquery.cookie.min.js"></script>
<script type="text/javascript" src="<?=base_url()?>assets/js/jquery.lineProgressbar.js"></script>
<article class="content">
    <div class="card card-block">
        <div id="notify" class="alert alert-success" style="display:none;">
            <a href="#" class="close" data-dismiss="alert">&times;</a>

            <div class="message"></div>
        </div>
        <div class="grid_3 grid_4">
            <h6>Generar Facturas Electronicas</h6>
            <hr>
            

            <div class="row sameheight-container">
                <div class="col-md-6">
                    <div class="card card-block sameheight-item">
                        <form id="formulario_fac_electronicas" action="<?php echo base_url() ?>facturasElectronicas/generar_facturas_action" method="post" role="form">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label"
                                       for="pay_cat"><?php echo $this->lang->line('') ?>Sede</label>

                                <div class="col-sm-9">
                                    <select name="pay_acc" class="form-control" id="cuentas_">
                                        <?php if($_SESSION[md5("variable_datos_pin")]['db_name'] == "admin_crmvestel"){ ?>
                                                            <?php foreach ($ciudades_filtro as $keyx => $ciudadx) {?>
                                                                <option value="<?=$ciudadx['id'] ?>"><?=$ciudadx['name']." ( ".$ciudadx['departamentName']." )" ?></option>
                                                            <?php } ?>
                                                <?php }else{ 
                                                        foreach ($accounts as $row) {
                                                            $cid = $row['id'];
                                                            $acn = $row['acn'];
                                                            $holder = $row['holder'];
                                                            if($cid<6 || $cid==9){
                                                                echo "<option value='$cid'>$acn - $holder</option>";
                                                            }
                                                        }

                                                } ?>
                                    </select>
                                </div>
                            </div> 
							<div class="form-group row">
                                <label class="col-sm-3 col-form-label"
                                       for="pay_cat"><?php echo $this->lang->line('') ?>Estado inicial</label>
								<div class="col-sm-9">
                                    <select name="estcuenta" class="form-control" id="estcuenta">
										<option value="6960">Efectivo</option>
										<option value="6941">Credito</option>
                                    </select>
                                </div>

                            </div>
 
                            <div class="form-group row">

                                <label class="col-sm-3 control-label"
                                       for="sdate2">Fecha</label>

                                <div class="col-sm-4">
                                    <input type="text" class="form-control required"
                                           placeholder="Start Date" name="sdate" id="sdate2"
                                            autocomplete="false" >
                                </div>
                            </div>
                          
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label" for="pay_cat"></label>

                                <div class="col-sm-4">
                                    
                                    <input type="submit" id="enviar" class="btn btn-primary btn-md" value="Generar">


                                </div>
                            </div>

                        </form>
                    </div>
                </div>

            </div>

        </div>
        <p>Progreso recorrido usuarios</p>
        <div id="progress" data-init="true"></div>
        <div style="margin-top: -25px;"><span id="span_progress1">0/0</span></div>
        <br>
        <p>Progreso proceso en ejecucion</p>
        <div id="progressfg" data-init="true"></div>
        <!--div style="margin-top: -25px;"><span id="span_progressfg">0/0</span></div-->
    </div>
</article>
<div id="verificacion_modal" class="modal fade">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                
                <h3 class="modal-title" align="center">Verificacion Facturas Electronicas</h3>

            </div>
            <div class="modal-body">
                
                <p>Progreso recorrido usuarios</p>
                <div id="progress_verificacion" data-init="true"></div>
                
                <br>
                
            </div>
            <div class="modal-footer">
                
                
                
                
            </div>
        </div>
    </div>
</div>
<?php //se hizo el cambio de fecha en el archivo views/fixed/footer ?>
<script type="text/javascript">
    var i_verificacion=1;
    var total_verificacion=1;
    function verificar_creacion_fe(){
        var pay_acc=$("#cuentas_ option:selected").val();
        var sdate=$("#sdate2").val();
        console.log(sdate);
          i_verificacion=1;
         total_verificacion=1;
        $.post(baseurl+"facturasElectronicas/obtener_lista_usuarios_fe_verificacion",{'pay_acc':pay_acc,'sdate':sdate},function(data){


            $("#verificacion_modal").modal("show");
            total_verificacion=data.total_groups;
            progress_verificacion(i_verificacion);
            recorrer_verificacion();
        },'json');
        
    }
    function recorrer_verificacion(){
        var pay_acc=$("#cuentas_ option:selected").val();
        var sdate=$("#sdate2").val();
        $.post(baseurl+"facturasElectronicas/verificar_lista",{'pay_acc':pay_acc,'sdate':sdate,'i_verificacion':i_verificacion,'total_verificacion':total_verificacion},function(data){
            i_verificacion++;
            if(i_verificacion<=95){
                progress_verificacion(i_verificacion);
            }
            
            if(i_verificacion<=total_verificacion){
                if(data=="correcto"){
                    window.location.href = baseurl+"facturasElectronicas/visualizar_resumen_ejecucion?fecha="+sdate+"&sede="+pay_acc;
                }else{
                    recorrer_verificacion();        
                }
                
            }
            
        });
    }
    $(document).ready(function(){
        //verificar_creacion_fe();
    });
    function progress_verificacion(valorx){
         $('#progress_verificacion').LineProgressbar({
                    percentage: valorx,
                    animation: true
                });
    }
    function progress_one(valorx){
         $('#progressfg').LineProgressbar({
                    percentage: valorx,
                    animation: true
                });
    }
    var timer;
    var b=0;
    var pay_acc;
    var xhr;
    var x1=baseurl.replace("CRMvestel/","");
    var data_aux="nada";
    var cuenta_bug=0;
    var datos_recorrer;
    var i=0;
    var total=0;
    var total_a_facturar=0;
    var va_en=0;
    $("#enviar").click(function(ev){
        ev.preventDefault();
        $(enviar).attr("disabled","true");
        var pay_acc=$("#cuentas_ option:selected").val();
        var sdate=$("#sdate2").val();
         progress_one(40);
        $.post(baseurl+"facturasElectronicas/obtener_lista_usuarios_a_facturar",{'pay_acc':pay_acc,'sdate':sdate},function(data){
            progress_one(90);
            datos_recorrer=data.lista_usuarios_a_facturar;
            total=datos_recorrer.length;
            total_a_facturar= parseInt( data.total_usuarios);
           va_en =parseInt(total_a_facturar-datos_recorrer.length);
            $("#span_progress1").text(va_en+"/"+total_a_facturar);

            iniciar_facturacion();
        },'json');
        //proceso_facturacion();
        
    });
    /*$("#formulario_fac_electronicas").submit(function (ev){
        ev.preventDefault();
        var url =$(this).attr("action");
        //antes de iniciar consultar para que me retorne el total de usuarios, luego en cada consulta me retorna los valores
        $.post(url,{},function(data){

        },'json');
    });*/
    var errores=0;
    var id_anterior=0;
function iniciar_facturacion(){
        var pay_acc=$("#cuentas_ option:selected").val();
        var sdate=$("#sdate2").val();
		var estcuenta=$("#estcuenta").val();
        var segundos_ejecutar=1000;
        progress_one(10);
        if(id_anterior==datos_recorrer[i].id){
            segundos_ejecutar=70000;
        }
    setTimeout(() => {
        if(i<parseInt(total)){
            var id_customer=datos_recorrer[i].id;
            id_anterior=datos_recorrer[i].id;
             //var num1=va_en+1;
             va_en++;
                var porcentaje=parseInt((va_en*100)/parseInt(total_a_facturar));
                //console.log(va_en+"-"+va_en+"-"+total+"-"+porcentaje);
                $('#progress').LineProgressbar({
                    percentage: porcentaje,
                    animation: false,
                    fillBackgroundColor: '#1abc9c',
                    height: '25px',
                    radius: '10px'
                });  
                
                    $("#span_progress1").text(va_en+"/"+total_a_facturar);
                    progress_one(40);
            $.post(baseurl+"facturasElectronicas/procesar_usuarios_a_facturar",{'pay_acc':pay_acc,'sdate':sdate,'id_customer':id_customer,'estcuenta':estcuenta},function(data){


                    if(data.estado=="procesado" || data.estado=="procesado 2"){
                        console.log(data.estado);
                        i++;
                        progress_one(100);
                        iniciar_facturacion();
                    }

                    
            },'json').fail(function(xhr, status, error) {
                if(errores>5){
                    i++;
                    errores=0;
                }else{
                    va_en--;    
                }
                
                console.log("ubo un error");
                iniciar_facturacion();
            });
        }else{// aqui abro modal de verificacion de fe.
        //verificar_creacion_fe();
            window.location.href = baseurl+"facturasElectronicas/visualizar_resumen_ejecucion?fecha="+sdate+"&sede="+pay_acc;
        }
    },segundos_ejecutar);
}
   /* function proceso_facturacion(){
        pay_acc=$("#cuentas_ option:selected").val();
        var sdate=$("#sdate2").val();
        b=0;
        timer=setTimeout("temporizador()",2800);
        xhr=$.ajax({
            url: baseurl+"facturasElectronicas/generar_facturas_action",
            type:"POST",
            dataType: "json",
            timeout: 1000*60*250,
            data: {
                pay_acc:pay_acc,sdate:sdate
            },
            success: function(response) { 
                
                //window.location.href = baseurl+"facturasElectronicas/visualizar_resumen_ejecucion?fecha="+response.fecha+"&sede="+response.sede;
            }
        });
    }
    
    function fc_detener(accion){
        xhr.abort();
         $.get(x1+"webservice/detener.php?pay_acc="+pay_acc+"&accion="+accion,{},function(data){

         });
    }
    
    function temporizador(){
        var porcentaje=0;
        

        $.get(x1+"webservice/ws.php?pay_acc="+pay_acc,{},function(data){
            var datos=data.split(",");
            porcentaje=parseInt((parseInt(datos[0]))*100/parseInt(datos[1]));
            porcentaje2=parseInt((parseInt(datos[2]))*100/parseInt(datos[1]));
            if(b<=1){

                porcentaje=1; 
                porcentaje2=1;                
                datos[0]=0;
                datos[1]=0;
                datos[2]=0;
            }
            b++;
            if(!isNaN(porcentaje)){
                $('#progress').LineProgressbar({
                    percentage: porcentaje,
                    animation: true,
                    fillBackgroundColor: '#1abc9c',
                    height: '25px',
                    radius: '10px'
                });  
                $("#span_progress1").text(datos[0]+"/"+datos[1]);
            }
            if(!isNaN(porcentaje2)){
                $('#progressfg').LineProgressbar({
                    percentage: porcentaje2,
                    animation: true
                });  
                $("#span_progressfg").text(datos[2]+"/"+datos[1]);
            }
            /*if(datos[0]==datos[1] && b>=4){
                clearTimeout(timer);
            }else{
                console.log(cuenta_bug);
                console.log(data_aux);
                console.log(data);
                if(data_aux==data){
                    if(cuenta_bug!=null){
                        cuenta_bug++;    
                    }
                    
                    if(cuenta_bug!=null && cuenta_bug>=3777){//estaba en 35 pero para probar un lapso de tiempo mas logebo lo edito si no funciona correctamente es volverlo a 35
                        
                        console.log("aqui");
                        cuenta_bug=null;
                        fc_detener("detener");
                        setTimeout(function(){
                            fc_detener("iniciar");
                            cuenta_bug=0;
                            setTimeout(function(){
                                   // proceso_facturacion();
                            },13000);
                        },15000);

                    }else{
                        timer = setTimeout("temporizador()", 2800);  
                    }
                }else{
                    data_aux=data;
                    $cuenta_bug=0; 
                     timer = setTimeout("temporizador()", 2800);                   
                }
                
            }
            
        });
        setTimeout("temporizador()",2800);
        
    }*/
    $('#progress').LineProgressbar({
        percentage: 0,
        animation: true,
        fillBackgroundColor: '#1abc9c',
        height: '25px',
        radius: '10px'
    });
    $('#progressfg').LineProgressbar({
        percentage: 0,
        animation: true
    });
    $('#progress_verificacion').LineProgressbar({
        percentage: 0,
        animation: true,
        fillBackgroundColor: '#1abc9c',
        height: '25px',
        radius: '10px'
    });
   
</script>
