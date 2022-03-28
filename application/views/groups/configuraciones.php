<article class="content">
    <div class="card card-block">
        <div id="notify" class="alert alert-success" style="display:none;">
            <a href="#" class="close" data-dismiss="alert">&times;</a>

            <div class="message"></div>
        </div>
        <div class="grid_3 grid_4" id="div_remover">
            <h6>Editar Variables</h6>
            <hr>
            

            <div class="row sameheight-container">
                <div class="col-md-12">
                    <div class="card card-block sameheight-item">

                        <form action="<?php echo base_url() ?>clientgroup/guardar_datos_api" method="post" role="form">
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label"
                                       for="pay_cat">Api</label>

                                <div class="col-sm-9">
                                    <select name="name_api" class="form-control" id="name_apis">
                                        <?php
                                        foreach ($apis as $row) {
                                            
                                            
                                            
                                                echo "<option value='".$row['nombre_api']."'>".ucwords($row['nombre_api'])."</option>";
                                            
                                        }
                                        ?>
                                    </select>


                                </div>

                            </div>
        <?php  foreach ($apis as $row) {
            $array_datos=json_decode($row['valor']);
            ?>          <div id="div_<?=$row['nombre_api'] ?>" class="divs_apis">
                <?php foreach ($array_datos as $key => $value) {?>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label"
                                       for="pay_cat"><?= $key ?></label>

                                <div class="col-sm-9">
                                    <input type="text" name="<?=$row['nombre_api'].'_'.$key?>" class="form-control" value="<?=$value?>">
                                    <?php if($key=="ip_Yopal"){
                                                $color=$color_yopal;
                                            }else if($key=="Ip_Villanueva_GPON"){
                                                $color=$color_villanueva_gpon;
                                            }else if($key=="Ip_Villanueva_EPON"){
                                                $color=$color_villanueva_epon;
                                            }else if($key=="Ip_Villanueva_EOC"){
                                                $color=$color_villanueva_epon;
                                            }else if($key=="ip_Monterrey"){
                                                $color=$color_monterrey;
                                            }
                                            if(isset($color)){
                                    ?>
                                        <i class="icon-circle" style="color: <?= $color?>;"></i><i class="icon-circle" style="color: <?= $color?>;"></i><i class="icon-circle" style="color: <?= $color?>;"></i><i class="icon-circle" style="color: <?= $color?>;"></i>
                                    <?php $color=null;} ?>
                                </div>

                            </div>
                    <?php } ?>
                    </div>
        <?php } ?>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label" for="pay_cat"></label>

                                <div class="col-sm-4">
                                    <input type="submit" class="btn btn-primary btn-md" value="Actualizar">


                                </div>
                            </div>

                        </form>
                    </div>
                </div>

            </div>

        </div>
    </div>
</article>
<div id="generar_factura" class="modal fade">
    <div class="modal-dialog">
     
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                <h4 class="modal-bodytitle">Confirmación</h4>
            </div>

            <div class="modal-body">
                <h3>¿ Desea guardar los cambios ?</h3>
            </div>
            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-primary" onclick="enviar()" >Aceptar</button>
                <button type="button" data-dismiss="modal" class="btn">Cancel</button>
            </div>

        </div>
       
        
    </div>
</div>
<script type="text/javascript">
    function enviar(){
    var o_data=$("form").serialize();
        $.post(baseurl+"clientgroup/guardar_datos_api",o_data,function(data){


                $("#notify .message").html("<strong>" + "Succes" + "</strong>: " + "Se actualizaron los datos con exito");
                $("#notify").removeClass("alert-danger").addClass("alert-success").fadeIn();
                $("html, body").scrollTop($("body").offset().top);
                $("#div_remover").remove();

        });
}  
    
    $("form").submit(function(e){
        
        e.preventDefault();
        $("#generar_factura").modal("show");
        
    });
    $("#name_apis").change(function(){
        mostrar_u_ocultar_divs(); 
    });
  function mostrar_u_ocultar_divs(){
    var seleccion= $("#name_apis option:selected").val();
        
        $(".divs_apis").hide();
        $("#div_"+seleccion).show();
  }
  mostrar_u_ocultar_divs();
</script>

